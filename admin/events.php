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
$page_title = 'Events';

// Include header
include 'includes/header.php';
?>

<h1>Events</h1>

<div id="alert-container"></div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Events</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">Add New Event</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Event Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="eventTableBody">
                    <!-- Events will be loaded here via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Add/Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm" enctype="multipart/form-data" onsubmit="return false;">
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label for="title" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="event_date" class="form-label">Event Date</label>
                        <input type="date" class="form-control" id="event_date" name="event_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            <!-- Categories will be loaded via AJAX -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Event Image</label>
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

<script id="init-admin-page" data-page="events"></script>

<?php include 'includes/footer.php'; ?>