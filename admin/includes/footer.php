</main>

<footer class="mt-4 text-center text-muted">
    <hr>
    <p>&copy; <?php echo date('Y'); ?> Sansia NGO Admin Panel</p>
</footer>
</div> <!-- End of content column -->
</div> <!-- End of row -->
</div> <!-- End of container-fluid -->

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="../assets/admin/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<!-- Custom Admin AJAX Script -->
<script src="../assets/admin/js/ajax.js"></script>

<!-- Admin UI JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');

        // Check for saved sidebar state
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        if (sidebarCollapsed) {
            sidebar.classList.add('collapsed');
        }

        // Toggle sidebar on button click
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
        }

        // Mobile menu toggle
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function () {
                if (window.innerWidth < 992) {
                    sidebar.classList.toggle('mobile-open');
                }
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (event) {
            if (window.innerWidth < 992 && sidebar.classList.contains('mobile-open')) {
                if (!sidebar.contains(event.target) && event.target !== mobileMenuToggle) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });

        // Adjust sidebar on window resize
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('mobile-open');
            }
        });
    });
</script>

</body>

</html>