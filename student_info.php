<?php
require_once 'includes/db.php';
require_once __DIR__ . '/includes/classes.php';

$infos = $conn->query('SELECT * FROM student_info ORDER BY id ASC');

$page_title = 'শিক্ষার্থী তথ্য';
$page_desc = 'শ্রেণি ও লিঙ্গভিত্তিক শিক্ষার্থী তথ্য';

include_once 'includes/header.php';
?>
<div class="container my-5">
  <section class="student-info-section bg-light rounded-4 shadow-sm p-4 mx-auto" style="max-width: 800px;">
    <div class="mb-4 bg-primary text-white rounded shadow text-center w-100" style="padding: 1.2rem 0;">
      <h4 class="mb-0" style="font-size:2rem; letter-spacing:normal;">শিক্ষার্থী তথ্য</h4>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-primary">
          <tr style="font-size:1.15rem;">
            <th>শ্রেণি</th>
            <th>মোট শিক্ষার্থী</th>
            <th>ছাত্ৰ</th>
            <th>ছাত্ৰী</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($infos && $infos->num_rows > 0): while($row = $infos->fetch_assoc()): ?>
          <tr style="font-size:1.08rem;">
            <td class="fw-semibold"><?php echo htmlspecialchars($row['class_name']); ?></td>
            <td><?php echo $row['total_students']; ?></td>
            <td><?php echo $row['male_students']; ?></td>
            <td><?php echo $row['female_students']; ?></td>
          </tr>
          <?php endwhile; else: ?>
          <tr><td colspan="4" class="text-center">কোনো তথ্য পাওয়া যায়নি।</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
<style>
.student-info-section {
  background: #f8fafc;
  border-radius: 2rem;
  box-shadow: 0 4px 24px rgba(0,0,0,0.07);
}
.student-info-section table {
  border-radius: 1rem;
  overflow: hidden;
}
.student-info-section th, .student-info-section td {
  text-align: center;
}
</style>
<?php include_once 'includes/footer.php'; ?> 