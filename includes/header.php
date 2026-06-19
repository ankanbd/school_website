<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/classes.php';
// Ensure UTF-8 content type for correct Bengali rendering
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}
$school = new SchoolInfo($conn);
$footer = new FooterInfo($conn);
$school_info = $school->get();
$footer_info = $footer->get();
// Fetch meta code from database
$meta_code = '';
$meta_code_row = $conn->query('SELECT code FROM meta_code LIMIT 1');
if ($meta_code_row && $meta_code_row->num_rows > 0) {
    $meta_code = $meta_code_row->fetch_assoc()['code'];
}
// Fetch SEO settings for current page
$page = basename($_SERVER['SCRIPT_NAME'], '.php');
$seo_data = null;
if (class_exists('SEOSettings')) {
    $seo = new SEOSettings($conn);
    $seo_data = $seo->get($page);
}

$default_desc = 'বাংলাদেশের অন্যতম শ্রেষ্ঠ স্কুল ম্যানেজমেন্ট সিস্টেম -Ankan Das from Khulna Devs দিচ্ছে সহজ ও দ্রুত ওয়েবসাইট আপনার শিক্ষাপ্রতিষ্ঠানের জন্য।';

if ($seo_data && !empty($seo_data['meta_description'])) {
    $description = $seo_data['meta_description'];
} elseif (!empty($school_info['about'])) {
    $description = mb_substr(strip_tags($school_info['about']), 0, 160);
} else {
    $description = $default_desc;
}
$default_keywords = 'KhulnaDevs, স্কুল ওয়েবসাইট,Ankan Das,স্কুল ম্যানেজমেন্ট, শিক্ষাপ্রতিষ্ঠান,school website, education website, school software, শিক্ষার প্রযুক্তি, স্কুল সফটওয়্যার, বাংলাদেশ';

$keywords = ($seo_data && !empty($seo_data['meta_keywords'])) ? $seo_data['meta_keywords'] : $default_keywords;
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($keywords); ?>">
    <title><?php echo htmlspecialchars(($seo_data && !empty($seo_data['meta_title'])) ? $seo_data['meta_title'] : ($school_info['school_name'] ?? ' বিদ্যালয় ওয়েবসাইট তৈরি')); ?></title>
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars(($seo_data && !empty($seo_data['meta_title'])) ? $seo_data['meta_title'] : ($school_info['school_name'] ?? ' বিদ্যালয় ওয়েবসাইট by Ankan Das')); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="og:image" content="<?php echo (!empty($seo_data['meta_image'])) ? htmlspecialchars($seo_data['meta_image']) : 'assets/images/feature.jpg'; ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars(((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">
    <meta property="og:type" content="website">
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars(($seo_data && !empty($seo_data['meta_title'])) ? $seo_data['meta_title'] : ($school_info['school_name'] ?? ' বিদ্যালয় ওয়েবসাইট by Ankan Das')); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta name="twitter:image" content="<?php echo (!empty($seo_data['meta_image'])) ? htmlspecialchars($seo_data['meta_image']) : 'assets/images/feature.jpg'; ?>">
    <!-- Resource Hints -->
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//www.youtube.com">
    <link rel="dns-prefetch" href="//i.ytimg.com">
    <link rel="preconnect" href="https://www.youtube.com">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Noto Sans Bengali + Hind Siliguri (fallback) -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;700&family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico">
    <!-- Custom CSS (must be after Bootstrap) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<?php if (!empty($meta_code)) echo $meta_code; ?>
<body style="font-family: 'Hind Siliguri','Noto Sans Bengali', sans-serif;">
    <!-- Notice Ticker (top of website) -->
    <?php
    // Show notice ticker on all pages
    $noticeTicker = new Notice($conn);
    $latest_notices = $noticeTicker->getActive(5, true);
    ?>
    <?php if ($latest_notices && $latest_notices->num_rows > 0): ?>
<div class="bg-warning text-dark py-2 px-3" style="overflow:hidden; position:relative; margin-top:0.5rem !important;">
  <div class="container">
    <div class="notice-ticker d-flex align-items-center" style="overflow:hidden;">
      <div class="ticker-label fw-bold me-3 flex-shrink-0"><i class="bi bi-megaphone"></i> নোটিশ:</div>
      <div class="ticker-wrap flex-grow-1">
        <div class="ticker-move">
          <?php $first = true; while($row = $latest_notices->fetch_assoc()): ?>
            <?php if (!$first): ?>
              <span class="mx-2">-</span>
            <?php endif; $first = false; ?>
            <span class="me-4"><a href="notice.php?id=<?php echo $row['id']; ?>" class="text-dark text-decoration-none"><?php echo htmlspecialchars($row['title']); ?></a></span>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.notice-ticker {
  margin: top 0;;
  font-size: 1rem;
  border-bottom: 1px solid #e0c200;
  z-index: 1050;
  display: flex;
  align-items: center;
}
.ticker-label {
  flex-shrink: 0;
  margin-right: 1rem;
}
.ticker-wrap {
  position: relative;
  flex-grow: 1;
  overflow: hidden;
  vertical-align: middle;
  display: inline-block;
  white-space: nowrap;
}
.ticker-move {
  display: inline-block;
  white-space: nowrap;
  animation: ticker-left 18s linear infinite;
}
.notice-ticker:hover .ticker-move {
  animation-play-state: paused;
}
.notice-ticker a:hover {
  color: #0d6efd !important;
}
@keyframes ticker-left {
  0% { transform: translateX(100%); }
  100% { transform: translateX(-100%); }
}
@media (max-width: 767.98px) {
  .notice-ticker { font-size: 0.95rem; }
  .ticker-label { display: block; margin-bottom: 2px; }
  .ticker-wrap { width: 100%; }
}
.ticker-wrap {
  overflow: hidden;
  position: relative;
  width: 100%;
}
.ticker-move {
  display: inline-block;
  white-space: nowrap;
  animation: ticker-scroll 40s linear infinite;
}
.ticker-move.paused {
  animation-play-state: paused;
}
.justified-text {
        text-align: justify;
    }

@keyframes ticker-scroll {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-100%);
  }
}
</style>
    <?php endif; ?>
    <div class="sticky-top" style="z-index: 1080;">
      <?php include_once __DIR__ . '/navbar.php'; ?>
    </div>
    <!-- Main Content Starts -->