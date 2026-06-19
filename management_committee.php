<?php
require_once 'includes/db.php';
require_once 'includes/classes.php';
$committee = new ManagementCommittee($conn);
$members = $committee->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ব্যবস্থাপনা কমিটি (Management Committee)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include_once 'includes/header.php';?>
<div class="container my-5">
    <h2 class="mb-4 text-center">ব্যবস্থাপনা কমিটি</h2>
    <div class="row g-4">
        <?php if ($members && $members->num_rows > 0): while($row = $members->fetch_assoc()): ?>
        <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm">
                <?php if ($row['image']): ?>
                <img src="assets/images/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top img-fluid rounded mx-auto d-block" alt="member" style="width:140px; height:140px; object-fit:cover;">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['full_name']); ?></h5>
                    <div class="mb-1 text-muted"><?php echo htmlspecialchars($row['title']); ?></div>
                    <?php if ($row['contact_number']): ?>
                    <p class="mb-1"><strong>Contact:</strong> <?php echo htmlspecialchars($row['contact_number']); ?></p>
                    <?php endif; ?>
                    <p class="mb-0"><strong>Joining Date:</strong> <?php echo htmlspecialchars($row['joining_date']); ?></p>
                </div>
            </div>
        </div>
        <?php endwhile; else: ?>
        <div class="col-12 text-center"><div class="alert alert-info">No committee members found.</div></div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html> 