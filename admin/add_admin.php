<?php
// Start session and check if user is logged in
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Include required files
require_once '../config/db.php';
require_once 'function.php';

// Check if it's an AJAX POST request and handle the user creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the registration using the handleRegistration function from function.php
    $response = handleRegistration($pdo, $_POST);

    // Return JSON response
    echo json_encode($response);
    exit;
}

// If not an AJAX request, show the page normally
$pageTitle = "Add New Admin User";
include_once 'includes/header.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Admin User</h1>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Create New Admin User</h6>
                </div>
                <div class="card-body">
                    <div id="alert-container"></div>

                    <form id="registrationForm" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">User Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="user">Regular User</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>

<!-- Initialize Admin Registration -->
<script id="init-admin-page" data-page="add_admin"></script>