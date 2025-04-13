<?php
// Initialize session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
require_once '../config/db.php';

// Get current page for highlighting in menu
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sansia NGO Admin</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/admin/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="../assets/admin/css/custom.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-container">
                <h4>Sansia Admin</h4>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
            </div>
            <ul class="nav-menu">
                <li class="nav-menu-item">
                    <a href="index.php"
                        class="nav-menu-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                        <i class="bi bi-speedometer2 nav-menu-icon"></i>
                        <span class="nav-menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="blogs.php"
                        class="nav-menu-link <?php echo $current_page == 'blogs.php' ? 'active' : ''; ?>">
                        <i class="bi bi-file-richtext nav-menu-icon"></i>
                        <span class="nav-menu-text">Blog Posts</span>
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="services.php"
                        class="nav-menu-link <?php echo $current_page == 'services.php' ? 'active' : ''; ?>">
                        <i class="bi bi-gear nav-menu-icon"></i>
                        <span class="nav-menu-text">Services</span>
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="events.php"
                        class="nav-menu-link <?php echo $current_page == 'events.php' ? 'active' : ''; ?>">
                        <i class="bi bi-calendar-event nav-menu-icon"></i>
                        <span class="nav-menu-text">Events</span>
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="categories.php"
                        class="nav-menu-link <?php echo $current_page == 'categories.php' ? 'active' : ''; ?>">
                        <i class="bi bi-folder nav-menu-icon"></i>
                        <span class="nav-menu-text">Categories</span>
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="contact.php"
                        class="nav-menu-link <?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">
                        <i class="bi bi-envelope nav-menu-icon"></i>
                        <span class="nav-menu-text">Contact Messages</span>
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="settings.php"
                        class="nav-menu-link <?php echo $current_page == 'settings.php' ? 'active' : ''; ?>">
                        <i class="bi bi-sliders nav-menu-icon"></i>
                        <span class="nav-menu-text">Settings</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <button class="menu-toggle-mobile d-lg-none btn btn-link text-primary" id="mobileMenuToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>

                <nav aria-label="breadcrumb" class="d-none d-md-block ms-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">
                            <?php echo ucfirst(str_replace('.php', '', $current_page)); ?>
                        </li>
                    </ol>
                </nav>

                <div class="user-dropdown dropdown ms-auto">
                    <button class="dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="profile-img">
                            <?php echo substr($_SESSION['username'] ?? 'A', 0, 1); ?>
                        </div>
                        <span
                            class="d-none d-md-inline"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Profile</a>
                        </li>
                        <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="?logout=1"><i
                                    class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid p-0">
                <!-- Alert container -->
                <div id="alert-container" class="mb-4"></div>

                <main>