<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

// SEO class
class SEOSettings {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }
    public function get($page) {
        $stmt = $this->conn->prepare('SELECT * FROM seo_settings WHERE page=?');
        $stmt->bind_param('s', $page);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

$seo = new SEOSettings($conn);
$slider = new Slider($conn);
$msg = new Message($conn);
$notice = new Notice($conn);
$school = new SchoolInfo($conn);
$footer = new FooterInfo($conn);
$sidebarWidget = new SidebarWidget($conn);
$sidebar_widgets = $sidebarWidget->getActive();

$seo_data = $seo->get('index');
$sliders = $slider->getActive();
$head = $msg->get('head_teacher');
$chairman = $msg->get('chairman');
$about_school = $msg->get('about_school');
$notices = $notice->getActive(5);
$school_info = $school->get();
$footer_info = $footer->get();

// Fetch latest 5 notices for ticker
$noticeTicker = new Notice($conn);
$latest_notices = $noticeTicker->getActive(5, true);

// Fetch teachers for homepage slider
$teachers_result = $conn->query('SELECT name, photo, designation,phone,email,status FROM teachers WHERE status=1 ORDER BY (sort_order=0), sort_order ASC, id DESC LIMIT 9');
// Fetch students of the year for homepage (max 6)
$students_of_year_result = $conn->query('SELECT name,class,photo,status,year FROM student_of_the_year WHERE status=1 ORDER BY year DESC, id DESC LIMIT 6');

// Fetch latest 3 forms for sidebar
$latest_forms_result = $conn->query('SELECT title, id,file FROM forms WHERE status=1 ORDER BY id DESC LIMIT 3');
?>
<!-- Notice Ticker (after navbar) -->
<?php include_once 'includes/header.php'; ?>
<meta charset="UTF-8">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali&display=swap" rel="stylesheet">
<div class="container my-5">
  <div class="row g-4">
    <!-- Main Content (Left) -->
    <div class="col-lg-9">
      <!-- Hero Image Slider -->
      <div class="container d-flex justify-content-center my-4">
        <div id="heroCarousel" class="carousel slide w-100" style="max-width:900px;" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php $i=0; if ($sliders && $sliders->num_rows > 0): while($row = $sliders->fetch_assoc()): ?>
            <div class="carousel-item<?php if ($i++ == 0) echo ' active'; ?>">
             <img src="assets/images/<?php echo htmlspecialchars($row['image']); ?>" class="d-block w-100 slider-img" alt="Slider" <?php echo ($i==1 ? 'fetchpriority="high" decoding="async"' : 'loading="lazy" decoding="async"'); ?>>

              <div class="carousel-caption d-none d-md-block">
                <h5><?php echo htmlspecialchars($row['caption_title']); ?></h5>
                <p><?php echo htmlspecialchars($row['caption_text']); ?></p>
              </div>
            </div>
            <?php endwhile; endif; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <!-- End Hero Image Slider -->
      <!-- Main Cards Row -->
      <div class="row">
        <!-- News Column (About School) -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-header bg-primary text-white">প্রতিষ্ঠান সম্পর্কে</div>
            <div class="card-body text-center" style="height:400px; overflow-y:auto;">
              <?php if (!empty($about_school['photo'])): ?>
                <img src="assets/images/<?php echo htmlspecialchars($about_school['photo']); ?>" class="img-fluid rounded mb-3" style="max-height:120px; object-fit:cover;" alt="School Banner" loading="lazy" decoding="async">
              <?php endif; ?>
              <p class="justified-text">
                <?php 
                  $about_text = $about_school['message'] ?? '';
                  echo nl2br(htmlspecialchars(mb_strlen($about_text) > 300 ? mb_substr($about_text, 0, 300) . '...' : $about_text));
                ?>
              </p>
              <a href="about.php" class="btn btn-sm btn-outline-primary mt-3">আরও পড়ুন</a>
            </div>
          </div>
        </div>
        <!-- Headmaster's Speech Column -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-header bg-success text-white">প্রতিষ্ঠান প্রধানের বাণী</div>
            <div class="card-body text-center">
              <?php if (!empty($head['photo'])): ?>
                <img src="assets/images/<?php echo htmlspecialchars($head['photo']); ?>" class="rounded-circle mb-2 d-block mx-auto" style="width:100px;height:100px;object-fit:cover;" alt="প্রধান শিক্ষক" loading="lazy" decoding="async">
              <?php endif; ?>
              <?php if (!empty($head['name'])): ?>
                <div class="fw-bold mb-2" style="font-size:1.1rem;">- <?php echo htmlspecialchars($head['name']); ?></div>
              <?php endif; ?>
              <p class="justified-text">
                <?php 
                  $message = $head['message'] ?? '';
                  echo nl2br(htmlspecialchars(mb_strlen($message) > 300 ? mb_substr($message, 0, 300) . '...' : $message));
                ?>
              </p>
              <a href="head_teacher.php" class="btn btn-sm btn-outline-success mt-3">আরও পড়ুন</a>
            </div>
          </div>
        </div>
        <!-- Chairman's Message Column -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-header bg-info text-white">সভাপতির বাণী</div>
            <div class="card-body text-center">
              <?php if (!empty($chairman['photo'])): ?>
              <img src="assets/images/<?php echo htmlspecialchars($chairman['photo']); ?>" class="rounded-circle mb-2 d-block mx-auto" style="width:100px;height:100px;object-fit:cover;" alt="সভাপতি" loading="lazy" decoding="async">
                <?php endif; ?>
              <?php if (!empty($chairman['name'])): ?>
                <div class="fw-bold mb-2" style="font-size:1.1rem;">- <?php echo htmlspecialchars($chairman['name']); ?></div>
              <?php endif; ?>
              <p class="justified-text">
                <?php 
                  $message = $chairman['message'] ?? '';
                  echo nl2br(htmlspecialchars(mb_strlen($message) > 300 ? mb_substr($message, 0, 300) . '...' : $message));
                ?>
              </p>
              <a href="chairman.php" class="btn btn-sm btn-outline-info mt-3">আরও পড়ুন</a>
            </div>
          </div>
        </div>
      </div>
      <!-- End Main Cards Row -->

      <!-- Teachers Slider -->
      <section class="my-5 py-5 bg-light rounded-4 shadow-sm position-relative teachers-section">
        <div class="container">
          <div class="mb-4 bg-primary text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
            <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">শিক্ষকবৃন্দ</h4>
          </div>
          <?php if ($teachers_result && $teachers_result->num_rows > 0): ?>
          <div id="teachersCarousel" class="carousel slide position-relative" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php
              $teachers = [];
              while($t = $teachers_result->fetch_assoc()) $teachers[] = $t;
              $chunkSize = 3; // 3 per slide on desktop
              $chunks = array_chunk($teachers, $chunkSize);
              foreach ($chunks as $i => $teacherChunk): ?>
                <div class="carousel-item<?php if ($i==0) echo ' active'; ?>">
                  <div class="row justify-content-center">
                    <?php foreach ($teacherChunk as $teacher): ?>
                    <div class="col-md-4 mb-3">
                      <div class="card h-100 text-center">
                        <?php if (!empty($teacher['photo'])): ?>
                          <img src="assets/images/<?php echo htmlspecialchars($teacher['photo']); ?>" class="card-img-top mx-auto mt-3 rounded-circle" style="width:100px;height:100px;object-fit:cover;" alt="<?php echo htmlspecialchars($teacher['name']); ?>" loading="lazy" decoding="async">
                        <?php endif; ?>
                        <div class="card-body">
                          <h6 class="card-title mb-1"><?php echo htmlspecialchars($teacher['name']); ?></h6>
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
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev teachers-carousel-btn" type="button" data-bs-target="#teachersCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next teachers-carousel-btn" type="button" data-bs-target="#teachersCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <div class="text-center ">
            <a href="teachers.php" class="btn btn-outline-primary btn-lg px-5">সকল শিক্ষকের তথ্য দেখুন</a>
          </div>
          <?php else: ?>
            <div class="alert alert-info text-center">কোনো শিক্ষক পাওয়া যায়নি।</div>
          <?php endif; ?>
        </div>
      </section>
      <!-- End Teachers Slider -->

      <!-- Student of the Year Section -->
      <?php if ($students_of_year_result && $students_of_year_result->num_rows > 0): ?>
      <section class="my-5 py-5 bg-light rounded-4 shadow-sm position-relative teachers-section">
        <div class="container">
          <div class="mb-4 bg-success text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
            <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">কৃতি শিক্ষার্থী</h4>
          </div>
          <?php
            $students = [];
            while($student = $students_of_year_result->fetch_assoc()) $students[] = $student;
            $chunkSize = 3; // 3 per slide
            $chunks = array_chunk($students, $chunkSize);
          ?>
          <div id="studentsOfYearCarousel" class="carousel slide position-relative" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php foreach ($chunks as $i => $studentChunk): ?>
                <div class="carousel-item<?php if ($i==0) echo ' active'; ?>">
                  <div class="row justify-content-center">
                    <?php foreach ($studentChunk as $student): ?>
                    <div class="col-md-4 mb-3">
                      <div class="card h-100 text-center">
                        <?php if (!empty($student['photo'])): ?>
                        <img src="assets/images/<?php echo htmlspecialchars($student['photo']); ?>" class="card-img-top mx-auto mt-3 rounded-circle" style="width:100px;height:100px;object-fit:cover;" alt="<?php echo htmlspecialchars($student['name']); ?>" loading="lazy" decoding="async">
                        <?php endif; ?>
                        <div class="card-body">
                          <h6 class="card-title mb-1"><?php echo htmlspecialchars($student['name']); ?></h6>
                          <div class="mb-2 text-muted small">শ্রেণি: <?php echo htmlspecialchars($student['class']); ?></div>
                          <div class="small">বছর: <?php echo htmlspecialchars($student['year']); ?></div>
                        </div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev teachers-carousel-btn" type="button" data-bs-target="#studentsOfYearCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next teachers-carousel-btn" type="button" data-bs-target="#studentsOfYearCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <div class="text-center mt-4">
            <a href="student_of_the_year.php" class="btn btn-success btn-lg px-4">আরও দেখুন</a>
          </div>
        </div>
      </section>
      <?php endif; ?>
      <!-- End Student of the Year Section -->

      <!-- Photo Gallery Preview -->
      <section class="my-5 py-5 bg-light rounded-4 shadow-sm position-relative gallery-section">
        <div class="container">
          <div class="mb-4 bg-primary text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
            <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">ফটো গ্যালারী</h4>
          </div>
          <div class="row g-4 justify-content-center">
            <?php
            $photos_preview = $conn->query('SELECT * FROM gallery_photos WHERE status=1 ORDER BY id DESC LIMIT 6');
            if ($photos_preview && $photos_preview->num_rows > 0):
              while($photo = $photos_preview->fetch_assoc()): ?>
              <div class="col-md-4 col-sm-6">
                <div class="card h-100">
                  <img src="assets/images/<?php echo htmlspecialchars($photo['image']); ?>" class="card-img-top gallery-img-fixed" alt="<?php echo htmlspecialchars($photo['caption']); ?>" loading="lazy" decoding="async">
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
          <div class="text-center mt-4">
            <a href="photo_gallery.php" class="btn btn-primary btn-lg px-4">সব ছবি দেখুন</a>
          </div>
        </div>
      </section>

      <!-- Video Gallery Preview -->
      <section class="my-5 py-5 bg-light rounded-4 shadow-sm position-relative gallery-section">
        <div class="container">
          <div class="mb-4 bg-primary text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
            <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">ভিডিও গ্যালারী</h4>
          </div>
          <div class="row g-4 justify-content-center">
            <?php
            $videos_preview = $conn->query('SELECT * FROM gallery_videos WHERE status=1 ORDER BY id DESC LIMIT 3');
            if ($videos_preview && $videos_preview->num_rows > 0):
              while($video = $videos_preview->fetch_assoc()): ?>
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
                      <iframe data-youtube-src="<?php echo htmlspecialchars($embed_url); ?>" allowfullscreen title="Gallery video player" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <?php else: ?>
                      <video src="assets/videos/<?php echo htmlspecialchars($video['video_url']); ?>" controls loading="lazy"></video>
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
          <div class="text-center mt-4">
            <a href="video_gallery.php" class="btn btn-primary btn-lg px-4">সব ভিডিও দেখুন</a>
          </div>
        </div>
      </section>
      <!-- End Gallery Sections -->

      <!-- Events/Blog Preview -->
      <section class="my-5 py-5 bg-light rounded-4 shadow-sm position-relative event-section">
        <div class="container">
          <div class="mb-4 bg-primary text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
            <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">ইভেন্ট/ব্লগ</h4>
          </div>
          <div class="row g-4 justify-content-center">
            <?php
            $events_preview = $conn->query('SELECT * FROM events ORDER BY event_date DESC, id DESC LIMIT 3');
            if ($events_preview && $events_preview->num_rows > 0):
              while($event = $events_preview->fetch_assoc()): ?>
              <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                  <?php if (!empty($event['image'])): ?>
                    <img src="assets/images/<?php echo htmlspecialchars($event['image']); ?>" class="card-img-top" style="height:180px;object-fit:cover;" alt="Event">
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($event['title']); ?></h5>
                    <div class="mb-2 text-muted small"><i class="bi bi-calendar-event"></i> <?php echo htmlspecialchars($event['event_date']); ?></div>
                    <div class="card-text mb-2"><?php echo htmlspecialchars(mb_strimwidth(strip_tags($event['description']),0,100,'...')); ?></div>
                    <a href="event_detail.php?id=<?php echo $event['id']; ?>" class="btn btn-outline-primary btn-sm">Read More</a>
                  </div>
                </div>
              </div>
            <?php endwhile; else: ?>
              <div class="col-12"><div class="alert alert-info text-center">No events found.</div></div>
            <?php endif; ?>
          </div>
          <div class="text-center mt-4">
            <a href="event.php" class="btn btn-primary btn-lg px-4">See All Events</a>
          </div>
        </div>
      </section>
    </div>
    <!-- Sidebar (Right) -->
    <div class="col-lg-3 sidebar-col">
      <!-- Institute Info Widget -->
      <div class="card mb-4">
        <div class="card-header bg-dark text-white">প্রতিষ্ঠানের তথ্য</div>
        <div class="card-body">
          <div class="mb-1"><strong>নাম:</strong> <?php echo htmlspecialchars($school_info['school_name'] ?? ''); ?></div>
          <div class="mb-1"><strong>EIIN:</strong> <?php echo htmlspecialchars($school_info['eiin'] ?? ''); ?></div>
          <div class="mb-1"><strong>প্রতিষ্ঠাকাল:</strong> <?php echo htmlspecialchars($school_info['established'] ?? ''); ?></div>
          <div class="mb-1"><strong>ফোন:</strong> <?php echo htmlspecialchars($school_info['phone'] ?? ''); ?></div>
          <div class="mb-1"><strong>ইমেইল:</strong> <?php echo htmlspecialchars($school_info['email'] ?? ''); ?></div>
        </div>
      </div>
      <!-- Notices Sidebar Card -->
      <div class="card mb-4">
        <div class="card-header bg-warning text-dark">নোটিশ</div>
        <div class="card-body">
          <ul class="list-unstyled mb-0">
            <?php
            $noticesSidebar = new Notice($conn);
            $sidebar_notices = $noticesSidebar->getActive(5);
            if ($sidebar_notices && $sidebar_notices->num_rows > 0):
              while($row = $sidebar_notices->fetch_assoc()): ?>
                <li><span class="text-secondary me-1">&rarr;</span><a href="notice.php?id=<?php echo $row['id']; ?>" class="text-decoration-none"><?php echo htmlspecialchars($row['title']); ?></a></li>
            <?php endwhile; else: ?>
              <li>কোনো নোটিশ নেই।</li>
            <?php endif; ?>
          </ul>
          <a href="notices.php" class="btn btn-sm btn-outline-primary mt-3">সব নোটিশ দেখুন</a>
        </div>
      </div>
      <?php
        // একাডেমিক তথ্য (Academic Info)
        $academicInfoLinks = new AcademicInfoLinks($conn);
        $academicLinks = $academicInfoLinks->getActive();
        if ($academicLinks && $academicLinks->num_rows > 0):
      ?>
      <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">একাডেমিক তথ্য</div>
        <div class="card-body">
          <?php while($row = $academicLinks->fetch_assoc()): ?>
            <a href="<?php echo htmlspecialchars($row['url']); ?>" class="btn btn-outline-primary btn-sm w-100 mb-2"><?php echo htmlspecialchars($row['title']); ?></a>
          <?php endwhile; ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- স্টুডেন্ট কর্ণার (Student Corner) -->
      <div class="card mb-4 border-info" style="background-color: rgb(0 103 18);">
        <div class="card-header text-white" style="background-color: rgb(0 103 18); border-color: rgb(0 103 18);">স্টুডেন্ট কর্ণার</div>
        <div class="card-body">
          <a href="<?php echo APP_URL; ?>/authentication" class="btn btn-light btn-sm w-100 mb-2">শিক্ষার্থী প্রফাইল লগইন</a>
          <a href="<?php echo APP_URL; ?>/admission" class="btn btn-light btn-sm w-100 mb-2">অনলাইন ভর্তি</a>
          <a href="<?php echo APP_URL; ?>/certificates" class="btn btn-light btn-sm w-100 mb-2">Certificates</a>
          <a href="<?php echo APP_URL; ?>/exam_results" class="btn btn-light btn-sm w-100 mb-2">Exam Results</a>
        </div>
      </div>

      <!-- Latest Forms Sidebar Card -->
      <div class="card mb-4">
        <div class="card-header bg-info text-white">সাম্প্রতিক ডকুমেন্ট</div>
        <div class="card-body">
          <ul class="list-unstyled mb-0">
            <?php if ($latest_forms_result && $latest_forms_result->num_rows > 0):
              while($form = $latest_forms_result->fetch_assoc()): ?>
                <li><span class="text-secondary me-1">&rarr;</span><a href="assets/forms/<?php echo htmlspecialchars($form['file']); ?>" class="text-decoration-none" target="_blank"><?php echo htmlspecialchars($form['title']); ?></a></li>
            <?php endwhile; else: ?>
              <li>কোনো ডকুমেন্ট নেই।</li>
            <?php endif; ?>
          </ul>
          <a href="forms.php" class="btn btn-sm btn-outline-info mt-3">সব ডকুমেন্ট দেখুন</a>
        </div>
      </div>
      <?php
        // গুরুত্বপূর্ণ লিংক (Important Links)
        require_once 'includes/classes.php';
        $importantLinks = new ImportantLinks($conn);
        $links = $importantLinks->getActive();
        if ($links && $links->num_rows > 0):
      ?>
      <div class="card mb-4 border-danger">
        <div class="card-header bg-danger text-white">গুরুত্বপূর্ণ লিংক</div>
        <div class="card-body">
          <?php while($row = $links->fetch_assoc()): ?>
            <a href="<?php echo htmlspecialchars($row['url']); ?>" target="_blank" class="btn btn-outline-danger btn-sm w-100 mb-2"><?php echo htmlspecialchars($row['title']); ?></a>
          <?php endwhile; ?>
        </div>
      </div>
      <?php endif; ?>
      <?php if ($sidebar_widgets && $sidebar_widgets->num_rows > 0): while($widget = $sidebar_widgets->fetch_assoc()): ?>
        <?php if ($widget['type'] === 'image'): ?>
          <div class="card mb-4">
            <?php if (!empty($widget['title'])): ?><div class="card-header bg-primary text-white"><?php echo htmlspecialchars($widget['title']); ?></div><?php endif; ?>
            <div class="card-body text-center">
              <img src="assets/images/<?php echo htmlspecialchars($widget['content']); ?>" class="img-fluid" alt="Sidebar Image" loading="lazy">
            </div>
          </div>
        <?php elseif ($widget['type'] === 'html'): ?>
          <div class="card mb-4">
            <?php if (!empty($widget['title'])): ?><div class="card-header bg-primary text-white"><?php echo htmlspecialchars($widget['title']); ?></div><?php endif; ?>
            <div class="card-body widget-content">
              <?php echo $widget['content']; ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endwhile; endif; ?>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>
<style>
@media (min-width: 992px) {
  .sidebar-col {
    flex: 0 0 25%;
    max-width: 25%;
  }
}
  .slider-img {
    height: 400px;
    object-fit: cover;
    width: 100%;
    display: block;
  }
  @media (max-width: 767.98px) {
    .slider-img {
      height: 200px;
    }
  }
@media (max-width: 767.98px) {
  #teachersCarousel .col-md-4 { flex: 0 0 100%; max-width: 100%; }
}
.teachers-section {
  background: #f8fafc;
  border-radius: 2rem;
  box-shadow: 0 4px 24px rgba(0,0,0,0.07);
  padding-left: 0;
  padding-right: 0;
}
.teachers-section .container {
  max-width: 1100px;
}
.teachers-section h4 {
  font-size: 2rem;
  letter-spacing: normal;
  margin-bottom: 2rem;
}
#teachersCarousel .carousel-inner {
  padding-bottom: 2.5rem;
}
.teachers-carousel-btn {
  width: 3.5rem;
  height: 3.5rem;
  background: #0d6efd;
  border-radius: 50%;
  top: 50%;
  transform: translateY(-50%);
  box-shadow: 0 2px 8px rgba(0,0,0,0.10);
  opacity: 0.85;
  border: none;
}
.carousel-control-prev.teachers-carousel-btn {
  left: -2.2rem;
}
.carousel-control-next.teachers-carousel-btn {
  right: -2.2rem;
}
.teachers-carousel-btn span {
  filter: invert(1) grayscale(1) brightness(2);
}
@media (max-width: 991.98px) {
  .teachers-section .container { max-width: 100%; }
  .carousel-control-prev.teachers-carousel-btn { left: 0; }
  .carousel-control-next.teachers-carousel-btn { right: 0; }
}
.gallery-section {
  background: #f8fafc;
  border-radius: 2rem;
  box-shadow: 0 4px 24px rgba(0,0,0,0.07);
  margin-bottom: 2rem;
}
.gallery-img-fixed {
  width: 100%;
  height: 200px;
  object-fit: cover;
  background: #e9ecef;
  border-radius: 0.5rem 0.5rem 0 0;
  display: block;
  max-width: 320px;
  margin-left: auto;
  margin-right: auto;
}

.widget-content{
    padding: 0;
}
</style>