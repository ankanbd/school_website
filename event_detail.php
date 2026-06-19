<?php
require_once 'includes/db.php';
require_once 'includes/classes.php';
$school = new SchoolInfo($conn);
$school_info = $school->get();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$event = null;
if ($id > 0) {
    $result = $conn->prepare('SELECT * FROM events WHERE id=?');
    $result->bind_param('i', $id);
    $result->execute();
    $res = $result->get_result();
    $event = $res->fetch_assoc();
    $result->close();
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $event ? htmlspecialchars($event['title']) . ' | ' : ''; ?><?php echo htmlspecialchars($school_info['school_name'] ?? 'স্কুল'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include_once 'includes/header.php'; ?>
<div class="container my-5">
  <?php if ($event): ?>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <?php if (!empty($event['image'])): ?>
            <img src="assets/images/<?php echo htmlspecialchars($event['image']); ?>" class="card-img-top" style="max-height:320px;object-fit:cover;" alt="Event">
          <?php endif; ?>
          <div class="card-body">
            <h2 class="card-title mb-2"><?php echo htmlspecialchars($event['title']); ?></h2>
            <div class="mb-3 text-muted"><i class="bi bi-calendar-event"></i> <?php echo htmlspecialchars($event['event_date']); ?></div>
            <div class="card-text" style="white-space:pre-line;"><?php echo htmlspecialchars($event['description']); ?></div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-danger text-center">Event not found.</div>
  <?php endif; ?>
</div>
<?php include_once 'includes/footer.php'; ?>
</body>
</html> 