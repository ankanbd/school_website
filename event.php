<?php
require_once 'includes/db.php';
require_once 'includes/classes.php';
$school = new SchoolInfo($conn);
$school_info = $school->get();
// Fetch all events
$events = $conn->query('SELECT * FROM events ORDER BY event_date DESC, id DESC');
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ইভেন্ট/ব্লগ | <?php echo htmlspecialchars($school_info['school_name'] ?? 'স্কুল'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include_once 'includes/header.php'; ?>
<div class="container my-5">
  <h2 class="mb-4 text-center bg-primary text-white rounded shadow py-2">ইভেন্ট/ব্লগ</h2>
  <div class="row g-4 justify-content-center">
    <?php if ($events && $events->num_rows > 0): while($event = $events->fetch_assoc()): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <?php if (!empty($event['image'])): ?>
            <img src="assets/images/<?php echo htmlspecialchars($event['image']); ?>" class="card-img-top" style="height:180px;object-fit:cover;" alt="Event">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($event['title']); ?></h5>
            <div class="mb-2 text-muted small"><i class="bi bi-calendar-event"></i> <?php echo htmlspecialchars($event['event_date']); ?></div>
            <div class="card-text mb-2"><?php echo htmlspecialchars(mb_strimwidth(strip_tags($event['description']),0,100,'...')); ?></div>
            <a href="event_detail.php?id=<?php echo $event['id']; ?>" class="btn btn-outline-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>
    <?php endwhile; else: ?>
      <div class="col-12"><div class="alert alert-info text-center">No events found.</div></div>
    <?php endif; ?>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>
</body>
</html> 