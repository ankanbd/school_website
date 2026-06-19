<?php
include 'includes/db.php';
include 'includes/header.php';

// Fetch current admission info
$details = '';
$updated_at = '';
$result = $conn->query("SELECT * FROM admission_info LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $details = $row['details'];
    $updated_at = $row['updated_at'];
}
?>
<div class="container" style="margin-top:40px; margin-bottom:40px;">
    <h2>Admission Information</h2>
    <hr>
    <section>
        <h3>Admission Details</h3>
        <div><?php echo nl2br(htmlspecialchars($details)); ?></div>
    </section>
    <?php if ($updated_at) { ?>
    <div style="margin-top:20px; color: #888; font-size: 0.95em;">
        Last updated: <?php echo date('F j, Y, g:i a', strtotime($updated_at)); ?>
    </div>
    <?php } ?>
</div>
<?php
include 'includes/footer.php';
?> 