<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

$routines = $conn->query('SELECT * FROM routines ORDER BY id DESC');

$page_title = 'ক্লাস রুটিন';
$page_desc = 'শ্রেণি ভিত্তিক ক্লাস রুটিন (PDF/ছবি)';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <section class="routine-section bg-light rounded-4 shadow-sm p-4 mx-auto" style="max-width: 900px;">
    <div class="mb-4 bg-primary text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
      <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">ক্লাস রুটিন</h4>
    </div>
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
          <?php if ($routines && $routines->num_rows > 0): while($row = $routines->fetch_assoc()): ?>
          <tr style="font-size:1.05rem;">
            <td class="fw-semibold"><?php echo htmlspecialchars($row['class_name']); ?></td>
            <td><?php echo $row['file_type'] === 'pdf' ? 'PDF' : 'ছবি'; ?></td>
            <td>
              <?php if ($row['file_type'] === 'pdf'): ?>
                <a href="assets/routines/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">PDF দেখুন</a>
              <?php else: ?>
                <a href="assets/routines/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank">
                  <img src="assets/routines/<?php echo htmlspecialchars($row['file_name']); ?>" alt="Routine" style="height:60px;width:auto;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,0.07);">
                </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; else: ?>
          <tr><td colspan="3" class="text-center">কোনো রুটিন পাওয়া যায়নি।</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
<style>
.routine-section {
  background: #f8fafc;
  border-radius: 2rem;
  box-shadow: 0 4px 24px rgba(0,0,0,0.07);
}
.routine-section th, .routine-section td {
  text-align: center;
}
</style>
<?php include_once 'includes/footer.php'; ?> 