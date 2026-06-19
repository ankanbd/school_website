<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: #0d2346; box-shadow: 0 2px 8px rgba(13,35,70,0.07); border-bottom: 2px solid #0d6efd; z-index:1051;">
  <div class="container">
    <!-- School Logo and Brand -->
    <a class="navbar-brand d-flex align-items-center fw-bold text-light" href="index.php" style="font-size:1.35rem; letter-spacing:normal;">
      <?php
        require_once __DIR__ . '/../includes/db.php';
        require_once __DIR__ . '/classes.php';
        $school = new SchoolInfo($conn);
        $school_info = $school->get();
        if (!empty($school_info['logo'])): ?>
          <img src="assets/images/<?php echo htmlspecialchars($school_info['logo']); ?>" alt="Logo" style="height:38px; width:auto; margin-right:10px; border-radius:6px; background:#fff; padding:2px;">
      <?php endif; ?>
      <?php echo htmlspecialchars($school_info['school_name'] ?? 'স্কুল'); ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
        <li class="nav-item">
          <a class="nav-link px-3" href="index.php">প্রথম পাতা</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="about.php"> প্রতিষ্ঠান সম্পর্কে</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle px-3" href="#" id="importantDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="return false;">
            স্টুডেন্ট কর্নার
          </a>
          <ul class="dropdown-menu shadow-sm rounded-3" aria-labelledby="importantDropdown">
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/dashboard">শিক্ষার্থী প্রফাইল লগইন</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/admission">অনলাইন ভর্তি</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/certificates">Certificates</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/exam_results">Exam Results </a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle px-3" href="#" id="importantDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="return false;">
            গুরুত্বপূর্ণ তথ্য
          </a>
          <ul class="dropdown-menu shadow-sm rounded-3" aria-labelledby="importantDropdown">
            <li><a class="dropdown-item" href="student_info.php">শিক্ষার্থী তথ্য</a></li>
            <li><a class="dropdown-item" href="teachers.php">শিক্ষকবৃন্দ</a></li>
            <li><a class="dropdown-item" href="routine.php">ক্লাস রুটিন</a></li>
            <li><a class="dropdown-item" href="result.php">ফলাফল</a></li>
            <li><a class="dropdown-item" href="result_archives.php">ফলাফল আর্কাইভ</a></li>
            <li><a class="dropdown-item" href="management_committee.php">ব্যবস্থাপনা কমিটি</a></li>
            <li><a class="dropdown-item" href="admission.php">ভর্তি তথ্য </a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link px-3" href="notices.php">নোটিশ</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle px-3" href="#" id="othersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="return false;">
          অন্যান্য
          </a>
          <ul class="dropdown-menu shadow-sm rounded-3" aria-labelledby="othersDropdown">
            <li><a class="dropdown-item" href="forms.php">সকল ফর্ম</a></li>
            <li><a class="dropdown-item" href="student_of_the_year.php">কৃতি শিক্ষার্থী</a></li>
            <li><a class="dropdown-item" href="event.php">ইভেন্ট</a></li>
            <li><a class="dropdown-item" href="photo_gallery.php">ছবি গ্যালারি</a></li>
            <li><a class="dropdown-item" href="video_gallery.php">ভিডিও গ্যালারি</a></li>
            <li><a class="dropdown-item" href="student_info.php"> প্রফাইল লগইন</a></li>
            <li><a class="dropdown-item" href="admin/dashboard.php">Admin Dashboard</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3" href="contact.php">যোগাযোগ</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
<style>
.navbar-nav .nav-link {
  font-weight: 500;
  color: #f3f7ff !important;
  transition: color 0.18s, background 0.18s;
  border-radius: 0.35rem;
}
.navbar-nav .nav-link.active, .navbar-nav .nav-link:hover, .navbar-nav .nav-link:focus {
  color: #0d6efd !important;
  background: #f3f7ff;
}
.navbar-nav .dropdown-menu {
  min-width: 180px;
  font-size: 1rem;
}
.navbar .dropdown-menu { z-index: 2000; }
.navbar-brand {
  font-size: 1.35rem;
  letter-spacing: normal;
}
@media (max-width: 991.98px) {
  .navbar-nav .nav-link { padding-left: 1rem; padding-right: 1rem; }
}
</style>