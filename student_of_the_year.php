<?php
require_once 'includes/db.php';

// Fetch students of the year (active only, latest year first)
$sql = 'SELECT * FROM student_of_the_year WHERE status=1 ORDER BY year DESC, id DESC';
$result = $conn->query($sql);

$page_title = 'Student of the Year';
$page_desc = 'List of students awarded Student of the Year.';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <h2 class="mb-4 text-center">কৃতি শিক্ষার্থী</h2>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <?php if ($result && $result->num_rows > 0): ?>
        <div class="row g-4">
          <?php while($student = $result->fetch_assoc()): ?>
            <div class="col-md-4">
              <div class="card h-100 text-center">
                <?php if (!empty($student['photo'])): ?>
                  <img src="assets/images/<?php echo htmlspecialchars($student['photo']); ?>" class="card-img-top mx-auto mt-3 rounded-circle" style="width:120px;height:120px;object-fit:cover;" alt="<?php echo htmlspecialchars($student['name']); ?>">
                <?php endif; ?>
                <div class="card-body">
                  <h5 class="card-title mb-1"><?php echo htmlspecialchars($student['name']); ?></h5>
                  <div class="mb-2 text-muted small">Class: <?php echo htmlspecialchars($student['class']); ?></div>
                  <div class="small">Year: <?php echo htmlspecialchars($student['year']); ?></div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info">No Student of the Year found.</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?> 