<?php
// Include the app configuration
require_once __DIR__ . '/app.php';

// Include the router
require_once __DIR__ . '/router.php';

// Include database connection
require_once 'config/db.php';

// Ensure compatibility with existing code


// Log traffic
// $page_name = basename($_SERVER['PHP_SELF']);
// $ip_address = $_SERVER['REMOTE_ADDR'];
// $query = "INSERT INTO traffic_logs (page_name, ip_address) VALUES (?, ?)";
// $stmt = $conn->prepare($query);
// $stmt->execute([$page_name, $ip_address]);

// Initialize the router
$router = new Router();

// Define routes
require_once __DIR__ . '/routes.php';

// Dispatch the router
$router->dispatch();
?>