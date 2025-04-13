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
$page_title = 'Contact Messages';

// Include header
include 'includes/header.php';
?>

<h1>Contact Submissions</h1>

<div id="alert-container"></div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Contact Messages</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="contactTableBody">
                    <!-- Contact submissions will be loaded here via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Message Detail Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Message Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Name:</strong>
                    <div id="detail-name"></div>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong>
                    <div id="detail-email"></div>
                </div>
                <div class="mb-3">
                    <strong>Subject:</strong>
                    <div id="detail-subject"></div>
                </div>
                <div class="mb-3">
                    <strong>Message:</strong>
                    <div id="detail-message"></div>
                </div>
                <div class="mb-3">
                    <strong>Date:</strong>
                    <div id="detail-date"></div>
                </div>
                <div class="mb-3">
                    <strong>Category:</strong>
                    <div id="detail-category"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-reply-email">Reply via Email</button>
            </div>
        </div>
    </div>
</div>

<!-- Initialize contact page functionality -->
<script id="init-admin-page" data-page="contact"></script>

<?php include 'includes/footer.php'; ?>