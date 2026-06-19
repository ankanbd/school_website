<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

// Fetch all active videos
$videos = $conn->query('SELECT * FROM gallery_videos WHERE status=1 ORDER BY id DESC');

$page_title = 'ভিডিও গ্যালারী';
$page_desc = 'স্কুলের ভিডিও গ্যালারী';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <h2 class="mb-4 text-center bg-primary text-white rounded shadow py-2">ভিডিও গ্যালারী</h2>
  <div class="row g-4 justify-content-center">
    <?php if ($videos && $videos->num_rows > 0): while($video = $videos->fetch_assoc()): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="ratio ratio-16x9">
            <?php if (strpos($video['video_url'], 'youtube.com') !== false || strpos($video['video_url'], 'youtu.be') !== false): ?>
              <?php
                // Convert YouTube URL to embed format
                $youtube_url = $video['video_url'];
                $embed_url = '';
                if (preg_match('/youtu\.be\\/([\w-]+)/', $youtube_url, $matches)) {
                  $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
                } elseif (preg_match('/youtube\.com\/watch\?v=([\w-]+)/', $youtube_url, $matches)) {
                  $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
                } else {
                  $embed_url = $youtube_url; // fallback
                }
              ?>
              <iframe src="<?php echo htmlspecialchars($embed_url); ?>" allowfullscreen></iframe>
            <?php else: ?>
              <video src="assets/videos/<?php echo htmlspecialchars($video['video_url']); ?>" controls></video>
            <?php endif; ?>
          </div>
          <?php if (!empty($video['caption'])): ?>
          <div class="card-body text-center">
            <div class="card-text small text-muted"><?php echo htmlspecialchars($video['caption']); ?></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; else: ?>
      <div class="col-12"><div class="alert alert-info text-center">কোনো ভিডিও পাওয়া যায়নি।</div></div>
    <?php endif; ?>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?> 