    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/jquery/jquery.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/hammer/hammer.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/i18n/i18n.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/main.js"></script>

    <?php
    require_once ROOT_PATH . '/model/common/PermissionHelper.php';
    if (!isset($_SESSION['user_permissions']) && !empty($_SESSION['user_id'])) {
        PermissionHelper::loadUserPermissionsIntoSession($_SESSION['user_id'], $_SESSION['user_role_id'] ?? 0, $_SESSION['user_role_name'] ?? '');
    }
    $userPermissionsJson = json_encode($_SESSION['user_permissions'] ?? []);
    
    // Map PHP date format to JS (Day.js) format
    $phpDateFormat = defined('SYS_DATE_FORMAT') ? SYS_DATE_FORMAT : 'Y-m-d';
    $jsDateFormat = str_replace(['d', 'm', 'Y'], ['DD', 'MM', 'YYYY'], $phpDateFormat);
    ?>
    <script>
        window.USER_PERMISSIONS = <?= $userPermissionsJson ?>;
        window.SYS_DATE_FORMAT = "<?= $jsDateFormat ?>";

        window.getVehicleStatusBadgeHtml = function(status) {
            if (!status) return '<span class="badge bg-label-secondary">Unknown</span>';
            
            let statusClass = 'bg-label-secondary';
            let s = status.toLowerCase().replace(/\s+/g, ''); // Normalize spacing and case
            
            if (s === 'available' || s === 'active') statusClass = 'bg-label-success'; // Green
            else if (s === 'parking' || s === 'parked') statusClass = 'bg-label-info'; // Blue
            else if (s === 'rentout' || s === 'rented' || s === 'onrent' || s === 'staffuse') statusClass = 'bg-label-danger'; // Red
            else if (s === 'maintence' || s === 'maintenance' || s === 'workshop') statusClass = 'bg-label-warning'; // Orange
            else if (s === 'blocked') statusClass = 'bg-label-dark'; // Dark
            else if (s === 'saleout') statusClass = 'bg-label-primary'; // Purple/Red Theme Default
            else if (s === 'deactivated' || s === 'inactive') statusClass = 'bg-label-secondary'; // Grey
            
            return '<span class="badge ' + statusClass + '">' + status + '</span>';
        };
    </script>
    <script src="<?= $_ENV['BASE_URL'] ?>user_js/rbac_ui_enforcer.js"></script>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const savedLogo = localStorage.getItem('selectedCompanyLogo');
			const logo = document.getElementById('companyLogo');

			if (savedLogo && logo) {
				logo.src = savedLogo;
			}
		});
	</script>