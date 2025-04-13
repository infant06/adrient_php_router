<?php
// Start session
session_start();

// Process AJAX registration request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/db.php';
    require_once 'function.php';

    $response = handleRegistration($conn, $_POST);

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
    <title>Volunteer Registration</title>
    <link rel="stylesheet" href="../assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/admin/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-white text-center py-3">
                        <h4 class="mb-0">Volunteer Registration</h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="alert-container"></div>
                        <form id="registrationForm" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>

                            <div class="mt-3 text-center">
                                <p class="mb-0">Already have an account? <a href="login.php">Login here</a></p>
                            </div>
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