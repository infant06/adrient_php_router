<?php
session_start();
require_once 'function.php';
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user = getUserById($conn, $user_id);

// Get settings for the header
$settings = getSettings($conn);
$general_settings = $settings['general'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Settings - <?php echo $general_settings['site_name'] ?? 'Sansia NGO Admin'; ?></title>
    <link rel="stylesheet" href="../assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/admin/css/custom.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profile Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" id="success-alert" style="display: none;"></div>
                        <div class="alert alert-danger" id="error-alert" style="display: none;"></div>

                        <form id="profile-form">
                            <input type="hidden" name="event" value="update_profile">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username"
                                    value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                                <small class="text-muted">Username cannot be changed</small>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email"
                                    value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                <small class="text-muted">Email cannot be changed</small>
                            </div>

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password">
                                <small class="text-muted">Required to update profile</small>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                                <small class="text-muted">Leave blank if you don't want to change password</small>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password">
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="../assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/admin/js/sweetalert2.all.min.js"></script>
    <script>
        document.getElementById('profile-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Validation
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword !== confirmPassword) {
                document.getElementById('error-alert').textContent = "New password and confirmation do not match!";
                document.getElementById('error-alert').style.display = 'block';
                document.getElementById('success-alert').style.display = 'none';
                return;
            }

            // Current password is required
            const currentPassword = document.getElementById('current_password').value;
            if (!currentPassword) {
                document.getElementById('error-alert').textContent = "Current password is required to update profile!";
                document.getElementById('error-alert').style.display = 'block';
                document.getElementById('success-alert').style.display = 'none';
                return;
            }

            // Submit form
            fetch('function.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('success-alert').textContent = data.message;
                        document.getElementById('success-alert').style.display = 'block';
                        document.getElementById('error-alert').style.display = 'none';

                        // Clear password fields
                        document.getElementById('current_password').value = '';
                        document.getElementById('new_password').value = '';
                        document.getElementById('confirm_password').value = '';
                    } else {
                        document.getElementById('error-alert').textContent = data.message;
                        document.getElementById('error-alert').style.display = 'block';
                        document.getElementById('success-alert').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('error-alert').textContent = "An error occurred while processing your request.";
                    document.getElementById('error-alert').style.display = 'block';
                    document.getElementById('success-alert').style.display = 'none';
                });
        });
    </script>
</body>

</html>