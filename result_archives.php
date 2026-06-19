<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

$archives = $conn->query('SELECT * FROM result_archives ORDER BY exam_year DESC, id DESC');

$page_title = 'ফলাফল আর্কাইভ';
$page_desc = 'পূর্ববর্তী বছরের পাবলিক পরিক্ষার ফলাফল আর্কাইভ';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <section class="result-section bg-light rounded-4 shadow-sm p-4 mx-auto" style="max-width: 900px;">
    <div class="mb-4 bg-primary text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
      <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">বিগত বছরের পাবলিক পরিক্ষার ফলাফল</h4>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-primary">
          <tr style="font-size:1.12rem;">
            <th>পরীক্ষার নাম</th>
            <th>বছর</th>
            <th>মোট শিক্ষার্থী</th>
            <th>মোট পাস</th>
            <th>পাস রেট (%)</th>
            <th>জিপিএ ৫</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($archives && $archives->num_rows > 0): while($row = $archives->fetch_assoc()): ?>
          <tr style="font-size:1.05rem;">
            <td class="fw-semibold"><?php echo htmlspecialchars($row['exam_name']); ?></td>
            <td><?php echo htmlspecialchars($row['exam_year']); ?></td>
            <td><?php echo htmlspecialchars($row['total_students']); ?></td>
            <td><?php echo htmlspecialchars($row['total_pass']); ?></td>
            <td><?php echo number_format($row['pass_rate'], 2); ?>%</td>
            <td><?php echo isset($row['total_gpa5']) && $row['total_gpa5'] !== null ? htmlspecialchars($row['total_gpa5']) : '-'; ?></td>
          </tr>
          <?php endwhile; else: ?>
          <tr><td colspan="6" class="text-center">কোনো ফলাফল আর্কাইভ পাওয়া যায়নি।</td></tr>
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