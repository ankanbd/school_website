<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

// Fetch only active teachers ordered by sort_order (0 means no serial, so they appear last)
$sql = 'SELECT * FROM teachers WHERE status=1 ORDER BY (sort_order=0), sort_order ASC, id DESC';
$result = $conn->query($sql);

$page_title = 'শিক্ষকবৃন্দ';
$page_desc = 'স্কুলের শিক্ষকবৃন্দের তালিকা';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <h2 class="mb-4 text-center">শিক্ষকবৃন্দ</h2>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <?php if ($result && $result->num_rows > 0): ?>
        <div class="row g-4">
          <?php while($teacher = $result->fetch_assoc()): ?>
            <div class="col-md-4">
              <div class="card h-100 text-center teacher-card">
                <a href="teacher_detail.php?id=<?php echo $teacher['id']; ?>">
                  <?php if (!empty($teacher['photo'])): ?>
                    <img src="assets/images/<?php echo htmlspecialchars($teacher['photo']); ?>" 
                         class="card-img-top mx-auto mt-3 rounded-circle" 
                         style="width:120px;height:120px;object-fit:cover;" 
                         alt="<?php echo htmlspecialchars($teacher['name']); ?>">
                  <?php else: ?>
                    <img src="assets/images/default_teacher.png" 
                         class="card-img-top mx-auto mt-3 rounded-circle" 
                         style="width:120px;height:120px;object-fit:cover;" 
                         alt="No Photo">
                  <?php endif; ?>
                </a>
                <div class="card-body">
                  <h5 class="card-title mb-1">
                    <a href="teacher_detail.php?id=<?php echo $teacher['id']; ?>" 
                       class="text-decoration-none text-dark">
                       <?php echo htmlspecialchars($teacher['name']); ?>
                    </a>
                  </h5>
                  <div class="mb-2 text-muted small"><?php echo htmlspecialchars($teacher['designation']); ?></div>
                  <?php if (!empty($teacher['phone'])): ?>
                    <div class="small"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($teacher['phone']); ?></div>
                  <?php endif; ?>
                  <?php if (!empty($teacher['email'])): ?>
                    <div class="small"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($teacher['email']); ?></div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info">কোনো শিক্ষক পাওয়া যায়নি।</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>
<style>
.teacher-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
}

.teacher-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-color: #0d6efd;
    background-color: #f8f9ff;
}

.teacher-card:hover .card-title a {
    color: #0d6efd !important;
}

.teacher-card:hover .card-img-top {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

.teacher-card .card-img-top {
    transition: transform 0.3s ease;
}
</style> 
