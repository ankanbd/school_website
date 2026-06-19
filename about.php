<?php
require_once 'includes/db.php';
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
$seo_data = $seo->get('about');
?>
<?php include_once 'includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">প্রতিষ্ঠান সম্পর্কে</h4>
                </div>
                <div class="card-body text-center">
                    <?php if (!empty($school_info['banner'])): ?>
                        <img src="assets/images/<?php echo htmlspecialchars($school_info['banner']); ?>" class="img-fluid mb-3" alt="স্কুল ব্যানার">
                    <?php endif; ?>
                   <br>
                    <?php if (!empty($school_info['logo'])): ?>
                        <img src="assets/images/<?php echo htmlspecialchars($school_info['logo']); ?>" class="mb-3" style="max-width:100px;" alt="স্কুল লোগো">
                    <?php endif; ?>
                    <div class="mb-3 text-center">
                        <h5 class="fw-bold"><?php echo htmlspecialchars($school_info['school_name'] ?? ''); ?></h5>
                        <ul class="list-unstyled mb-0">
                            <?php if (!empty($school_info['eiin'])): ?>
                                <li><strong>EIIN:</strong> <?php echo htmlspecialchars($school_info['eiin']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($school_info['mpo_code'])): ?>
                                <li><strong>MPO Code:</strong> <?php echo htmlspecialchars($school_info['mpo_code']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($school_info['school_code'])): ?>
                                <li><strong>Institute Code:</strong> <?php echo htmlspecialchars($school_info['school_code']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($school_info['established'])): ?>
                                <li><strong>প্রতিষ্ঠাকাল:</strong> <?php echo htmlspecialchars($school_info['established']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($school_info['address'])): ?>
                                <li><strong>ঠিকানা:</strong> <?php echo htmlspecialchars($school_info['address']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($school_info['phone'])): ?>
                                <li><strong>ফোন:</strong> <?php echo htmlspecialchars($school_info['phone']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($school_info['email'])): ?>
                                <li><strong>ইমেইল:</strong> <?php echo htmlspecialchars($school_info['email']); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <p class="mt-3 text-start"><?php echo nl2br(htmlspecialchars($school_info['about'] ?? '')); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>
