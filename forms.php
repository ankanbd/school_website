<?php
require_once 'includes/db.php';

// Fetch all active forms
$sql = 'SELECT * FROM forms WHERE status=1 ORDER BY id DESC';
$result = $conn->query($sql);

$page_title = 'গুরুত্বপূর্ণ ডকুমেন্টস সমুহ';
$page_desc = 'স্কুলের সকল ডকুমেন্ট বা ফর্ম ডাউনলোড করুন।';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <h2 class="mb-4 text-center"> গুরুত্বপূর্ণ ডকুমেন্টস সেন্টার</h2>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <?php if ($result && $result->num_rows > 0): ?>
        <div class="list-group">
          <?php while($form = $result->fetch_assoc()): ?>
            <a href="assets/forms/<?php echo htmlspecialchars($form['file']); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" target="_blank">
              <span><?php echo htmlspecialchars($form['title']); ?></span>
              <span class="badge bg-primary rounded-pill">Download</span>
            </a>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info">কোনো ডকুমেন্টস পাওয়া যায়নি।</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>