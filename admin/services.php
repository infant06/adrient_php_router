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
$page_title = 'Services';

// Include header
include 'includes/header.php';
?>

<h1>Services</h1>

<div id="alert-container"></div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Services</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal">Add New Service</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="serviceTableBody">
                    <!-- Services will be loaded here via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Service Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Add/Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="serviceForm" enctype="multipart/form-data" onsubmit="return false;">
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label for="title" class="form-label">Service Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <!-- Categories will be loaded via AJAX -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Service Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script id="init-admin-page" data-page="services"></script>

<?php include 'includes/footer.php'; ?>