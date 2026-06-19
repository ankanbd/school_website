<?php
include 'includes/db.php';

// Form submission handling
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        $success = "Message sent successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<?php include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="mb-3 text-center">
                        <h5 class="fw-bold"><?php echo htmlspecialchars($school_info['school_name'] ?? ''); ?></h5>
                        <ul class="list-unstyled mb-0">
                            <?php if (!empty($school_info['eiin'])): ?>
                                <li><strong>EIIN:</strong> <?php echo htmlspecialchars($school_info['eiin']); ?></li>
                            <?php endif; ?>
                                  <li><strong>ঠিকানা:</strong> <?php echo htmlspecialchars($school_info['address']); ?></li>
                            <?php if (!empty($school_info['phone'])): ?>
                                <li><strong>ফোন:</strong> <?php echo htmlspecialchars($school_info['phone']); ?></li>
                            <?php endif; ?>
                            <?php if (!empty($school_info['email'])): ?>
                                <li><strong>ইমেইল:</strong> <?php echo htmlspecialchars($school_info['email']); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
 <!--
        <div class="col-md-6">
           <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Contact Us</h4>
                </div>
                <div class="card-body">

                    <?php if($success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>

                </div>
            </div>
        </div>
        -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">Our Location</h4>
                </div>
                <div class="card-body" style="height:650px;">
                    <?php if (!empty($school_info['google_map'])): ?>
                        <div class="ratio ratio-4x3">
                            <?php 
                                // Intentionally echo raw embed code saved by admin
                                echo $school_info['google_map']; 
                            ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">Google Map is not configured yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>
