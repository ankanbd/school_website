<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

// Helper function to make URLs clickable
function make_links_clickable($text) {
    $pattern = '/(https?:\/\/[\w\-\.\/?&=;%#@!\+~:,]+)/i';
    return preg_replace($pattern, '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', htmlspecialchars($text));
}

// Get notice id from query string
$notice_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$notice = null;
if ($notice_id > 0) {
    $stmt = $conn->prepare('SELECT * FROM notices WHERE id=?');
    $stmt->bind_param('i', $notice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $notice = $result->fetch_assoc();
}

// SEO meta
$page_title = $notice ? htmlspecialchars($notice['title']) . ' | নোটিশ' : 'নোটিশ';
$page_desc = $notice ? mb_substr(strip_tags($notice['description']), 0, 150) : 'নোটিশ';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <?php if ($notice): ?>
        <div class="card shadow">
          <div class="card-header bg-warning text-dark fs-5">নোটিশ</div>
          <div class="card-body">
            <h3 class="mb-3"><?php echo htmlspecialchars($notice['title']); ?></h3>
            <div class="mb-2 text-muted small">প্রকাশের তারিখ: <?php echo htmlspecialchars($notice['notice_date']); ?></div>
            <div><?php echo nl2br(make_links_clickable($notice['description'])); ?></div>
            <?php if (!empty($notice['attachment'])): ?>
              <div class="mt-3">
                <?php 
                  $ext = strtolower(pathinfo($notice['attachment'], PATHINFO_EXTENSION));
                  $fileUrl = 'assets/notices/' . $notice['attachment'];
                ?>
                <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                  <img src="<?php echo $fileUrl; ?>" alt="Attachment" style="max-width:100%;height:auto;display:block;margin:0 auto;">
                <?php elseif ($ext === 'pdf'): ?>
                  <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn btn-outline-primary">View PDF Attachment</a>
                <?php else: ?>
                  <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn btn-outline-secondary">Download Attachment</a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php else: ?>
        <div class="alert alert-danger">নোটিশ পাওয়া যায়নি।</div>
      <?php endif; ?>
      <div class="text-center mt-4">
        <a href="notices.php" class="btn btn-outline-secondary">সব নোটিশ</a>
      </div>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?> 