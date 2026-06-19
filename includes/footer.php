<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/classes.php';
$school = new SchoolInfo($conn);
$footer = new FooterInfo($conn);
$school_info = $school->get();
$footer_info = $footer->get();
?>
    <!-- Footer -->
    <footer class="bg-dark text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">প্রতিষ্ঠান সম্পর্কে</h6>
                    <?php if (!empty($footer_info['footer_logo'])): ?>
                        <img src="assets/images/<?php echo htmlspecialchars($footer_info['footer_logo']); ?>" alt="Footer Logo" class="mb-2" style="max-width:80px; max-height:60px; display:block;" loading="lazy" decoding="async">
                    <?php endif; ?>
                    <p class="small"><?php echo nl2br(htmlspecialchars($footer_info['footer_short'] ?? '')); ?></p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">সকল তথ্য</h6>
                    <ul class="list-unstyled small">
                        <li><a href="notices.php" class="text-light text-decoration-none">নোটিশ</a></li>
                        <li><a href="teachers.php" class="text-light text-decoration-none">শিক্ষকবৃন্দ</a></li>
                        <li><a href="result.php" class="text-light text-decoration-none">ফলাফল</a></li>
                        <li><a href="routine.php" class="text-light text-decoration-none">রুটিন</a></li>
                        <li><a href="photo_gallery.php" class="text-light text-decoration-none">ছবি</a></li>
                        <li><a href="video_gallery.php" class="text-light text-decoration-none">ভিডিও</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">যোগাযোগ</h6>
                    <ul class="list-unstyled small">
                        <li>ঠিকানা: <?php echo htmlspecialchars($footer_info['address'] ?? ''); ?></li>
                        <li>ফোন: <?php echo htmlspecialchars($footer_info['phone'] ?? ''); ?></li>
                        <li>ইমেইল: <?php echo htmlspecialchars($footer_info['email'] ?? ''); ?></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="fw-bold">দ্রুত লিংক</h6>
                    <ul class="list-unstyled small">
                        <li><a href="index.php" class="text-light text-decoration-none">প্রথম পাতা</a></li>
                        <li><a href="about.php" class="text-light text-decoration-none">প্রতিষ্ঠান সম্পর্কে</a></li>
                        <li><a href="notices.php" class="text-light text-decoration-none">নোটিশ</a></li>
                        <li><a href="notices.php" class="text-light text-decoration-none">নোটিশ</a></li>
                        <li><a href="admission.php" class="text-light text-decoration-none">ভর্তি তথ্য</a></li>
                        <li><a href="<?php echo APP_URL; ?>/admin/login.php" class="text-light text-decoration-none">লগইন করুন</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($school_info['school_name'] ?? ''); ?>. সর্বস্বত্ব সংরক্ষিত। কারিগরি সহায়তায় <a href="https://facebook.com/ankandas.fb" target="_blank" style="color: #fff; text-decoration: underline; font-size: 0.9rem;line-height: 1.4;">ANKAN</a></div>
         
         <!--   <div class="text-center small mt-2">
                <?php if (!empty($footer_info['facebook'])): ?><a href="<?php echo htmlspecialchars($footer_info['facebook']); ?>" class="text-light me-2" target="_blank"><i class="bi bi-facebook"></i></a><?php endif; ?>
            </div>
         -->   
        </div>
    </footer>
    <!-- End Footer -->
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js" defer></script>

</body>
</html> 