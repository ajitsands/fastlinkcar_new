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
    $contractStatusColorsJson = json_encode(VehicleStatusHelper::getContractStatusColorMap());
    
    // Map PHP date format to JS (Day.js) format
    $phpDateFormat = defined('SYS_DATE_FORMAT') ? SYS_DATE_FORMAT : 'Y-m-d';
    $jsDateFormat = str_replace(['d', 'm', 'Y'], ['DD', 'MM', 'YYYY'], $phpDateFormat);
    ?>
    <script>
        window.USER_PERMISSIONS = <?= $userPermissionsJson ?>;
        window.VEHICLE_STATUS_COLORS = <?= $vehicleStatusColorsJson ?>;
        window.CONTRACT_STATUS_COLORS = <?= $contractStatusColorsJson ?>;
        window.SYS_DATE_FORMAT = "<?= $jsDateFormat ?>";

        window.getVehicleStatusColorInfo = function(status) {
            if (!status) {
                return { label: 'Unknown', bg: '', fg: '', fallbackClass: 'bg-label-secondary' };
            }

            let s = status.toLowerCase().replace(/\s+/g, '');
            if (s === 'active') s = 'available';
            else if (s === 'parked') s = 'parking';
            else if (s === 'rented' || s === 'onrent') s = 'rentout';
            else if (s === 'maintence' || s === 'workshop') s = 'maintenance';
            else if (s === 'inactive') s = 'deactivated';

            const customMap = window.VEHICLE_STATUS_COLORS || {};
            if (customMap[s] && customMap[s].badge_color) {
                return {
                    label: status,
                    bg: customMap[s].badge_color,
                    fg: customMap[s].text_color || '#ffffff',
                    fallbackClass: ''
                };
            }

            let fallbackClass = 'bg-label-secondary';
            if (s === 'available') fallbackClass = 'bg-label-success';
            else if (s === 'parking') fallbackClass = 'bg-label-info';
            else if (s === 'rentout' || s === 'staffuse') fallbackClass = 'bg-label-danger';
            else if (s === 'maintenance') fallbackClass = 'bg-label-warning';
            else if (s === 'blocked') fallbackClass = 'bg-label-dark';
            else if (s === 'saleout') fallbackClass = 'bg-label-primary';

            return { label: status, bg: '', fg: '', fallbackClass: fallbackClass };
        };

        window.getVehicleStatusBadgeHtml = function(status) {
            const info = window.getVehicleStatusColorInfo(status);
            if (info.bg) {
                return `<span class="badge" style="background-color: ${info.bg}; color: ${info.fg};">${info.label}</span>`;
            }
            return `<span class="badge ${info.fallbackClass}">${info.label}</span>`;
        };

        window.applyVehicleStatusBadge = function(selectorOrEl, status, extraClass = '') {
            const $el = $(selectorOrEl);
            if (!$el.length) return;
            const info = window.getVehicleStatusColorInfo(status);
            const cls = extraClass ? ('badge ' + extraClass) : 'badge';
            $el.text(info.label).css({ 'background-color': '', 'color': '' });
            if (info.bg) {
                $el.attr('class', cls).css({ 'background-color': info.bg, 'color': info.fg });
            } else {
                $el.attr('class', cls + ' ' + info.fallbackClass);
            }
        };

        window.getContractStatusBadgeHtml = function(status, extraClass = '') {
            const label = (status || '').trim() || 'N/A';
            const s = label.toLowerCase().replace(/\s+/g, '');
            const customMap = window.CONTRACT_STATUS_COLORS || {};
            if (customMap[s] && customMap[s].badge_color) {
                const bg = customMap[s].badge_color;
                const fg = customMap[s].text_color || '#ffffff';
                return `<span class="badge ${extraClass}" style="background-color: ${bg}; color: ${fg};">${label}</span>`;
            }
            let badgeClass = 'bg-secondary';
            if (s === 'generated') badgeClass = 'bg-warning';
            else if (s === 'rentout' || s === 'extended' || s === 'closed') badgeClass = 'bg-success';
            else if (s === 'returned') badgeClass = 'bg-primary';
            else if (s === 'onhold' || s === 'cancelled') badgeClass = 'bg-danger';
            return `<span class="badge ${badgeClass} ${extraClass}">${label}</span>`;
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