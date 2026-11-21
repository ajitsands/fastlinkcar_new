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
            let s = label.toLowerCase().replace(/[\s_-]+/g, '');
            if (s === 'canceled') s = 'cancelled';
            else if (s === 'return') s = 'returned';
            else if (s === 'extend') s = 'extended';
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

		<?php if (!empty($_SESSION['user_id'])): ?>
		(function() {
			let sessionRedirecting = false;
			function redirectToLoginOnExpiry() {
				if (sessionRedirecting) return;
				sessionRedirecting = true;
				window.location.href = '/Logout';
			}

			// Intercept jQuery AJAX 401 / session_expired responses
			if (window.jQuery) {
				$(document).ajaxError(function(event, jqxhr) {
					if (jqxhr && (jqxhr.status === 401 || (jqxhr.responseJSON && jqxhr.responseJSON.session_expired))) {
						redirectToLoginOnExpiry();
					}
				});
			}

			// Intercept fetch() 401 responses
			if (window.fetch) {
				const origFetch = window.fetch;
				window.fetch = function() {
					return origFetch.apply(this, arguments).then(function(res) {
						if (res && res.status === 401) {
							redirectToLoginOnExpiry();
						}
						return res;
					});
				};
			}

			// Periodic & tab-focus session check
			function checkSessionAlive() {
				if (sessionRedirecting) return;
				window.fetch('/SessionCheck', { credentials: 'same-origin', cache: 'no-store' })
					.then(function(r) { return r.json(); })
					.then(function(data) {
						if (data && data.authenticated === false) {
							redirectToLoginOnExpiry();
						}
					})
					.catch(function() {});
			}
			setInterval(checkSessionAlive, 60000);
			document.addEventListener('visibilitychange', function() {
				if (document.visibilityState === 'visible') {
					checkSessionAlive();
				}
			});

			// Load Insurance & Passing expiry notifications into top navbar
			document.addEventListener('DOMContentLoaded', function() {
				const listEl = document.getElementById('navNotifList');
				const badgeEl = document.getElementById('navNotifBadgeCount');
				const hdrBadgeEl = document.getElementById('navNotifHeaderCount');
				if (!listEl) return;

				const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
				function fmtShortDate(iso) {
					const d = new Date(iso + 'T00:00:00');
					if (isNaN(d.getTime())) return iso;
					return String(d.getDate()).padStart(2, '0') + '-' + months[d.getMonth()] + '-' + d.getFullYear();
				}
				function escHtml(s) {
					return String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
				}

				window.fetch('/VehicleInsuranceController?action=listVehicles', { credentials: 'same-origin' })
					.then(function(r) { return r.json(); })
					.then(function(res) {
						if (!res || !res.status || !Array.isArray(res.data)) {
							listEl.innerHTML = '<li class="list-group-item text-center text-muted py-4 small">No alerts available.</li>';
							return;
						}
						const today = new Date(new Date().toDateString());
						const alerts = [];
						res.data.forEach(function(v) {
							[['next_insurance_date', 'Insurance', 'ri-shield-check-line'], ['next_passing_date', 'Passing', 'ri-car-washing-line']].forEach(function(cfg) {
								const raw = v[cfg[0]];
								if (!raw || raw === '0000-00-00') return;
								const dt = new Date(raw + 'T00:00:00');
								if (isNaN(dt.getTime())) return;
								const diff = Math.ceil((dt - today) / 86400000);
								if (diff <= 30) {
									alerts.push({
										veh: v.vehicle_number || '-',
										model: [v.brand_name, v.model_names].filter(Boolean).join(' '),
										type: cfg[1],
										icon: cfg[2],
										date: fmtShortDate(raw),
										days: diff
									});
								}
							});
						});
						alerts.sort(function(a, b) { return a.days - b.days; });

						if (hdrBadgeEl) {
							hdrBadgeEl.textContent = alerts.length + ' Due';
							hdrBadgeEl.className = 'badge rounded-pill fs-xsmall ' + (alerts.length > 0 ? 'bg-label-danger' : 'bg-label-success');
						}
						if (badgeEl) {
							if (alerts.length > 0) {
								badgeEl.textContent = alerts.length > 99 ? '99+' : String(alerts.length);
								badgeEl.classList.remove('d-none');
							} else {
								badgeEl.classList.add('d-none');
							}
						}

						if (alerts.length === 0) {
							listEl.innerHTML = '<li class="list-group-item text-center text-muted py-4 small"><i class="ri ri-checkbox-circle-line text-success me-1"></i>No expired or upcoming (30 days) dues.</li>';
							return;
						}

						listEl.innerHTML = alerts.map(function(a) {
							const isExp = a.days < 0;
							const statusText = isExp
								? ('Expired ' + Math.abs(a.days) + 'd ago')
								: (a.days === 0 ? 'Due Today' : ('Expires in ' + a.days + 'd'));
							const tone = isExp ? 'danger' : 'warning';
							return '<li class="list-group-item list-group-item-action dropdown-notifications-item" style="cursor:pointer;" onclick="window.location.href=\'/VehicleInsurance\'">' +
								'<div class="d-flex align-items-start">' +
									'<div class="flex-shrink-0 me-3">' +
										'<div class="avatar"><span class="avatar-initial rounded-circle bg-label-' + tone + '"><i class="icon-base ri ' + a.icon + ' icon-18px"></i></span></div>' +
									'</div>' +
									'<div class="flex-grow-1">' +
										'<div class="d-flex justify-content-between align-items-center mb-1">' +
											'<h6 class="small mb-0 fw-bold">' + escHtml(a.veh) + ' <span class="fw-normal text-muted">(' + escHtml(a.type) + ')</span></h6>' +
											'<span class="badge bg-label-' + tone + '" style="font-size:0.65rem;">' + escHtml(statusText) + '</span>' +
										'</div>' +
										'<small class="d-block text-muted text-truncate" style="max-width:230px;">' + escHtml(a.model) + '</small>' +
										'<small class="text-body-secondary">Due: ' + escHtml(a.date) + '</small>' +
									'</div>' +
								'</div>' +
							'</li>';
						}).join('');
					})
					.catch(function() {
						listEl.innerHTML = '<li class="list-group-item text-center text-muted py-4 small">Unable to load alerts.</li>';
					});
			});
		})();
		<?php endif; ?>
	</script>