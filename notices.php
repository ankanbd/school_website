<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

// Pagination setup
$per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

// Fetch total count
$total_result = $conn->query('SELECT COUNT(*) as total FROM notices WHERE status=1');
$total_row = $total_result ? $total_result->fetch_assoc() : ['total' => 0];
$total_notices = $total_row['total'];

// Fetch notices for this page
$sql = 'SELECT * FROM notices WHERE status=1 ORDER BY notice_date DESC, id DESC LIMIT ? OFFSET ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$page_title = 'নোটিশ';
$page_desc = 'সকল নোটিশ দেখুন';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <h2 class="mb-4 text-center">নোটিশ</h2>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($notice = $result->fetch_assoc()): ?>
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h5 class="card-title mb-2">
                <a href="notice.php?id=<?php echo $notice['id']; ?>" class="text-decoration-none text-dark">
                  <?php echo htmlspecialchars($notice['title']); ?>
                </a>
              </h5>
              <div class="mb-2 text-muted small">প্রকাশের তারিখ: <?php echo htmlspecialchars($notice['notice_date']); ?></div>
              <p class="card-text"><?php echo mb_substr(strip_tags($notice['description']), 0, 120); ?><?php if (mb_strlen(strip_tags($notice['description'])) > 120) echo '...'; ?></p>
              <a href="notice.php?id=<?php echo $notice['id']; ?>" class="btn btn-sm btn-outline-primary">আরও পড়ুন</a>
              <?php if (!empty($notice['attachment'])): ?>
                <a href="assets/notices/<?php echo htmlspecialchars($notice['attachment']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">Attachment</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
        <?php if ($total_notices > (int)$page * (int)$per_page): ?>
          <div class="text-center">
            <a href="notices.php?page=<?php echo $page + 1; ?>" class="btn btn-primary">আরও দেখুন</a>
          </div>
        <?php endif; ?>
      <?php else: ?>
        <div class="alert alert-info">কোনো নোটিশ পাওয়া যায়নি।</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>