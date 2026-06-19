<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/classes.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(404);
    echo "<h1>Invalid Teacher ID</h1>";
    exit;
}

$teacher_id = intval($_GET['id']);

// ডাটাবেজ থেকে ডেটা আনা
$stmt = $conn->prepare("SELECT name, designation, photo, phone, email,bio FROM teachers WHERE id = ?");

$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo "<h1>Teacher Not Found</h1>";
    exit;
}

$teacher = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($teacher['name']); ?> - Teacher Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <?php include_once 'includes/header.php'; ?> 


</head>

<body>

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <div class="row">
            <div class="col-md-4 text-center">
                <?php if (!empty($teacher['photo'])): ?>
                    <img src="assets/images/<?php echo htmlspecialchars($teacher['photo']); ?>" 
                         alt="<?php echo htmlspecialchars($teacher['name']); ?>" 
                         class="img-fluid rounded-circle shadow-sm mb-3" width="200">
                <?php else: ?>
                    <img src="assets/images/default_teacher.png" 
                         alt="No Photo" 
                         class="img-fluid rounded-circle shadow-sm mb-3" width="200">
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($teacher['name']); ?></h2>
                <p class="text-muted mb-2"><strong>পদবী:</strong> <?php echo htmlspecialchars($teacher['designation']); ?></p>
                <p><strong>মোবাইল:</strong> <?php echo htmlspecialchars($teacher['phone']); ?></p>
                <p><strong>ইমেইল:</strong> <?php echo htmlspecialchars($teacher['email']); ?></p>
                <p><strong>বিস্তারিত:</strong> <?php echo htmlspecialchars($teacher['bio']); ?></p>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <a href="teachers.php" class="btn btn-secondary">← Back to Teachers</a>
    </div>
</div>
</body>
<?php include_once 'includes/footer.php'; ?> 
<?php $conn->close(); ?>

</html>
