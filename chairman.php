<?php
require_once 'includes/db.php';
require_once 'includes/classes.php';
$msg = new Message($conn);
$chairman = $msg->get('chairman');
$school = new SchoolInfo($conn);
$school_info = $school->get();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সভাপতির বাণী | <?php echo htmlspecialchars($school_info['school_name'] ?? 'স্কুল'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include_once 'includes/header.php'; ?>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-info text-white text-center fs-5">সভাপতির বাণী</div>
        <div class="card-body text-center">
          <?php if (!empty($chairman['photo'])): ?>
            <img src="assets/images/<?php echo htmlspecialchars($chairman['photo']); ?>" class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;" alt="সভাপতি">
          <?php endif; ?>
          <?php if (!empty($chairman['name'])): ?>
            <div class="fw-bold mb-2" style="font-size:1.2rem;">- <?php echo htmlspecialchars($chairman['name']); ?></div>
          <?php endif; ?>
          <?php if (!empty($chairman['title'])): ?>
            <div class="mb-3 text-muted">(<?php echo htmlspecialchars($chairman['title']); ?>)</div>
          <?php endif; ?>
          <div class="text-start mx-auto" style="max-width:600px;">
            <?php echo nl2br(htmlspecialchars($chairman['message'] ?? '')); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>
</body>
</html> 