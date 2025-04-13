<?php
// Start session
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Process AJAX login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/db.php';
    require_once 'function.php';

    $response = handleLogin($conn, $_POST);

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/admin/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5 pt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-white text-center py-3">
                        <h4 class="mb-0">Admin Login</h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="alert-container"></div>
                        <form id="loginForm" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/admin/js/sweetalert2.all.min.js"></script>
    <script src="../assets/admin/js/ajax.js"></script>
</body>

</html>