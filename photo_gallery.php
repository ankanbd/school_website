<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

// Fetch all active photos
$photos = $conn->query('SELECT * FROM gallery_photos WHERE status=1 ORDER BY id DESC');

$page_title = 'ফটো গ্যালারী';
$page_desc = 'স্কুলের ফটো গ্যালারী';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <h2 class="mb-4 text-center bg-primary text-white rounded shadow py-2">ফটো গ্যালারী</h2>
  <div class="row g-4 justify-content-center">
    <?php if ($photos && $photos->num_rows > 0): while($photo = $photos->fetch_assoc()): ?>
      <div class="col-md-4 col-sm-6">
        <div class="card h-100">
          <img src="assets/images/<?php echo htmlspecialchars($photo['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($photo['caption']); ?>">
          <?php if (!empty($photo['caption'])): ?>
          <div class="card-body text-center">
            <div class="card-text small text-muted"><?php echo htmlspecialchars($photo['caption']); ?></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; else: ?>
      <div class="col-12"><div class="alert alert-info text-center">কোনো ছবি পাওয়া যায়নি।</div></div>
    <?php endif; ?>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?> 