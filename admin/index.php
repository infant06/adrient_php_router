<?php
require_once '../config/db.php';
require_once 'function.php';

// Check if user is logged in and has admin privileges
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Set page title
$page_title = 'Dashboard';

// Get counts for dashboard widgets
$query_blogs = "SELECT COUNT(*) as count FROM blogs";
$stmt_blogs = $conn->query($query_blogs);
$blog_count = $stmt_blogs->fetch(PDO::FETCH_ASSOC)['count'];

$query_events = "SELECT COUNT(*) as count FROM events";
$stmt_events = $conn->query($query_events);
$event_count = $stmt_events->fetch(PDO::FETCH_ASSOC)['count'];

$query_services = "SELECT COUNT(*) as count FROM services";
$stmt_services = $conn->query($query_services);
$service_count = $stmt_services->fetch(PDO::FETCH_ASSOC)['count'];

$query_contacts = "SELECT COUNT(*) as count FROM contact_submissions";
$stmt_contacts = $conn->query($query_contacts);
$contact_count = $stmt_contacts->fetch(PDO::FETCH_ASSOC)['count'];

// Get recent contact submissions
$query_recent_contacts = "SELECT * FROM contact_submissions ORDER BY submission_date DESC LIMIT 5";
$stmt_recent_contacts = $conn->query($query_recent_contacts);
$recent_contacts = $stmt_recent_contacts->fetchAll(PDO::FETCH_ASSOC);

// Include header
include 'includes/header.php';
?>

<h1>Dashboard</h1>

<div id="alert-container"></div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Blog Posts</h5>
                <h2><?php echo $blog_count; ?></h2>
                <a href="blogs.php" class="text-white">Manage Blogs <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Events</h5>
                <h2><?php echo $event_count; ?></h2>
                <a href="events.php" class="text-white">Manage Events <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5 class="card-title">Services</h5>
                <h2><?php echo $service_count; ?></h2>
                <a href="services.php" class="text-dark">Manage Services <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Contact Messages</h5>
                <h2><?php echo $contact_count; ?></h2>
                <a href="contact.php" class="text-white">View Messages <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Recent Contact Messages</h5>
            </div>
            <div class="card-body">
                <?php if (count($recent_contacts) > 0): ?>
                    <div class="list-group">
                        <?php foreach ($recent_contacts as $contact): ?>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($contact['name']); ?></h6>
                                    <small><?php echo date('M d, Y', strtotime($contact['submission_date'])); ?></small>
                                </div>
                                <p class="mb-1 text-truncate"><?php echo htmlspecialchars($contact['message']); ?></p>
                                <small class="text-muted"><?php echo htmlspecialchars($contact['email']); ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3">
                        <a href="contact.php" class="btn btn-sm btn-outline-primary">View All Messages</a>
                    </div>
                <?php else: ?>
                    <p class="mb-0">No recent contact messages.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Links</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="blogs.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-edit me-2"></i> Add New Blog Post
                    </a>
                    <a href="events.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-plus me-2"></i> Add New Event
                    </a>
                    <a href="services.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-cogs me-2"></i> Manage Services
                    </a>
                    <a href="categories.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags me-2"></i> Manage Categories
                    </a>
                    <a href="settings.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-wrench me-2"></i> Website Settings
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Site Overview</h5>
            </div>
            <div class="card-body">
                <p>Welcome to the Sansia NGO admin panel. Here you can manage all aspects of your website.</p>
                <p>Need help? Check out the documentation or contact support.</p>
                <a href="../" target="_blank" class="btn btn-outline-secondary">Visit Website</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>