<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

$results = $conn->query('SELECT * FROM results ORDER BY id DESC');

$page_title = 'ফলাফল';
$page_desc = 'শ্রেণি ভিত্তিক ফলাফল (PDF/ছবি)';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <section class="result-section bg-light rounded-4 shadow-sm p-4 mx-auto" style="max-width: 900px;">
    <div class="mb-4 bg-primary text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
      <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">ফলাফল</h4>
    </div>
    <a href="result_archives.php" class="btn btn-primary mb-3">বিগত বছরের পাবলিক পরিক্ষার ফলাফল দেখুন </a>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-primary">
          <tr style="font-size:1.12rem;">
            <th>শ্রেণি</th>
            <th>ধরণ</th>
            <th>ফাইল</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($results && $results->num_rows > 0): while($row = $results->fetch_assoc()): ?>
          <tr style="font-size:1.05rem;">
            <td class="fw-semibold"><?php echo htmlspecialchars($row['class_name']); ?></td>
            <td><?php echo $row['file_type'] === 'pdf' ? 'PDF' : 'ছবি'; ?></td>
            <td>
              <?php if ($row['file_type'] === 'pdf'): ?>
                <a href="assets/results/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">PDF দেখুন</a>
              <?php else: ?>
                <a href="assets/results/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank">
                  <img src="assets/results/<?php echo htmlspecialchars($row['file_name']); ?>" alt="Result" style="height:60px;width:auto;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,0.07);">
                </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; else: ?>
          <tr><td colspan="3" class="text-center">কোনো ফলাফল পাওয়া যায়নি।</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
<style>
.result-section {
  background: #f8fafc;
  border-radius: 2rem;
  box-shadow: 0 4px 24px rgba(0,0,0,0.07);
}
.result-section th, .result-section td {
  text-align: center;
}
</style>
<?php include_once 'includes/footer.php'; ?> 