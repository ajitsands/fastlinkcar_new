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
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/modal-dialog-enforcer.js"></script>

    <?php
    require_once ROOT_PATH . '/model/common/PermissionHelper.php';
    require_once ROOT_PATH . '/model/common/VehicleStatusHelper.php';
    if (!isset($_SESSION['user_permissions']) && !empty($_SESSION['user_id'])) {
        PermissionHelper::loadUserPermissionsIntoSession($_SESSION['user_id'], $_SESSION['user_role_id'] ?? 0, $_SESSION['user_role_name'] ?? '');
    }
    $userPermissionsJson = json_encode($_SESSION['user_permissions'] ?? []);
    $vehicleStatusColorsJson = json_encode(VehicleStatusHelper::getStatusColorMap());
    
    // Map PHP date format to JS (Day.js) format
    $phpDateFormat = defined('SYS_DATE_FORMAT') ? SYS_DATE_FORMAT : 'Y-m-d';
    $jsDateFormat = str_replace(['d', 'm', 'Y'], ['DD', 'MM', 'YYYY'], $phpDateFormat);
    ?>
    <script>
        window.USER_PERMISSIONS = <?= $userPermissionsJson ?>;
        window.VEHICLE_STATUS_COLORS = <?= $vehicleStatusColorsJson ?>;
        window.SYS_DATE_FORMAT = "<?= $jsDateFormat ?>";

        window.getVehicleStatusBadgeHtml = function(status) {
            if (!status) return '<span class="badge bg-label-secondary">Unknown</span>';
            
            let s = status.toLowerCase().replace(/\s+/g, ''); // Normalize spacing and case
            if (s === 'active') s = 'available';
            else if (s === 'parked') s = 'parking';
            else if (s === 'rented' || s === 'onrent') s = 'rentout';
            else if (s === 'maintence' || s === 'workshop') s = 'maintenance';
            else if (s === 'inactive') s = 'deactivated';

            const customMap = window.VEHICLE_STATUS_COLORS || {};
            if (customMap[s] && customMap[s].badge_color) {
                const bg = customMap[s].badge_color;
                const fg = customMap[s].text_color || '#ffffff';
                return `<span class="badge" style="background-color: ${bg}; color: ${fg};">${status}</span>`;
            }

            let statusClass = 'bg-label-secondary';
            if (s === 'available') statusClass = 'bg-label-success';
            else if (s === 'parking') statusClass = 'bg-label-info';
            else if (s === 'rentout' || s === 'staffuse') statusClass = 'bg-label-danger';
            else if (s === 'maintenance') statusClass = 'bg-label-warning';
            else if (s === 'blocked') statusClass = 'bg-label-dark';
            else if (s === 'saleout') statusClass = 'bg-label-primary';
            
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