<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="horizontal-menu-template">

<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <title>System Settings - AA Car Rental</title>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/jquery/jquery.js"></script>
</head>

<body>
    <div id="dropdownContent"></div>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->
            <?php include ROOT_PATH . '/view/templates/nav.php'; ?>
            <!-- / Navbar -->

            <!-- Layout page -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    <?php include ROOT_PATH . '/view/templates/menu.php'; ?>
                    <!-- / Menu -->

                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 55px !important">
                        
                        <div class="row g-4">
                            <!-- Left Column: Form Settings -->
                            <div class="col-12 col-lg-7">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header d-flex align-items-center justify-content-between pb-3 border-bottom">
                                        <div>
                                            <h5 class="card-title mb-0">
                                                <i class="ri-settings-3-line me-2 text-primary"></i>Application Settings
                                            </h5>
                                            <small class="text-muted">Configure VAT %, Default Currency, Timezone & Date Formatting</small>
                                        </div>
                                        <div>
                                            <span class="badge bg-label-success" id="settingsStatusBadge">Configured</span>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <form id="systemSettingsForm">
                                            <div class="row g-3 mb-3">
                                                <!-- Country & Currency Setting -->
                                                <div class="col-12 col-md-6">
                                                    <div class="form-floating form-floating-outline">
                                                        <select id="currencySetting" class="form-select" name="currency_setting">
                                                            <option value="BHD|BD" selected>🇧🇭 Bahrain — BHD (BD)</option>
                                                            <option value="SAR|SR">🇸🇦 Saudi Arabia — SAR (SR)</option>
                                                            <option value="AED|AED">🇦🇪 United Arab Emirates — AED</option>
                                                            <option value="KWD|KD">🇰🇼 Kuwait — KWD (KD)</option>
                                                            <option value="OMR|OMR">🇴🇲 Oman — OMR</option>
                                                            <option value="QAR|QR">🇶🇦 Qatar — QAR (QR)</option>
                                                            <option value="INR|₹">🇮🇳 India — INR (₹)</option>
                                                        </select>
                                                        <label for="currencySetting">Default Currency & Country</label>
                                                    </div>
                                                </div>

                                                <!-- VAT Percentage -->
                                                <div class="col-12 col-md-6">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="number" step="0.01" min="0" max="100" class="form-control" id="vatPercentage" placeholder="10.00" name="vat_percentage" value="10.00">
                                                        <label for="vatPercentage">VAT / Tax Rate (%)</label>
                                                    </div>
                                                </div>

                                                <!-- Timezone -->
                                                <div class="col-12 col-md-6">
                                                    <div class="form-floating form-floating-outline">
                                                        <select id="timezoneSetting" class="form-select" name="timezone">
                                                            <option value="Asia/Bahrain" selected>Bahrain (GMT+3)</option>
                                                            <option value="Asia/Riyadh">Saudi Arabia — Riyadh (GMT+3)</option>
                                                            <option value="Asia/Dubai">UAE — Dubai (GMT+4)</option>
                                                            <option value="Asia/Kuwait">Kuwait (GMT+3)</option>
                                                            <option value="Asia/Muscat">Oman — Muscat (GMT+4)</option>
                                                            <option value="Asia/Qatar">Qatar — Doha (GMT+3)</option>
                                                            <option value="Asia/Kolkata">India — Kolkata (GMT+5:30)</option>
                                                        </select>
                                                        <label for="timezoneSetting">System Timezone</label>
                                                    </div>
                                                </div>

                                                <!-- Date Formatting -->
                                                <div class="col-12 col-md-6">
                                                    <div class="form-floating form-floating-outline">
                                                        <select id="dateFormatSetting" class="form-select" name="date_format">
                                                            <option value="Y-m-d" selected>YYYY-MM-DD (e.g. <?= date('Y-m-d') ?>)</option>
                                                            <option value="d/m/Y">DD/MM/YYYY (e.g. <?= date('d/m/Y') ?>)</option>
                                                            <option value="d-M-Y">DD-MMM-YYYY (e.g. <?= date('d-M-Y') ?>)</option>
                                                            <option value="m/d/Y">MM/DD/YYYY (e.g. <?= date('m/d/Y') ?>)</option>
                                                        </select>
                                                        <label for="dateFormatSetting">Date Format</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-3 border-top">
                                                <button type="button" class="btn btn-secondary" id="btnResetSettings">
                                                    <i class="ri-refresh-line me-1"></i> Reset / Reload
                                                </button>
                                                <button type="button" class="btn btn-primary" id="btnSaveSettings">
                                                    <i class="ri-save-line me-1"></i> Save Settings
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Live Configuration Preview -->
                            <div class="col-12 col-lg-5">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header pb-3 border-bottom">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-eye-line me-2 text-primary"></i>Live Setting Preview
                                        </h5>
                                        <small class="text-muted">Real-time preview of system formatting</small>
                                    </div>
                                    <div class="card-body pt-4">
                                        <div class="p-3 bg-body rounded-3 mb-3 border">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small">Selected Currency:</span>
                                                <span class="fw-semibold text-primary" id="previewCurrency">BHD (BD)</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small">VAT Rate:</span>
                                                <span class="fw-semibold text-success" id="previewVat">10.00%</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small">Selected Timezone:</span>
                                                <span class="badge bg-label-info" id="previewTimezone">Asia/Bahrain</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Sample Date Format:</span>
                                                <span class="fw-semibold text-dark" id="previewDateFormat"><?= date('Y-m-d') ?></span>
                                            </div>
                                        </div>

                                        <!-- Sample Financial Calculation Card -->
                                        <div class="p-3 rounded-3 border" style="background-color: #f8f9fa;" id="sampleInvoiceCard">
                                            <h6 class="mb-2 fw-semibold text-secondary">
                                                <i class="ri-calculator-line me-1"></i>Sample Invoice Calculation
                                            </h6>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="small text-muted">Rental Subtotal:</span>
                                                <span class="fw-semibold" id="sampleSubtotal">100.000 BD</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="small text-muted">VAT Amount:</span>
                                                <span class="fw-semibold text-danger" id="sampleVatAmount">10.000 BD</span>
                                            </div>
                                            <hr class="my-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Grand Total:</span>
                                                <span class="fw-bold text-success fs-6" id="sampleGrandTotal">110.000 BD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                    <!-- / Footer -->
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>

    <script>
    $(document).ready(function() {
        const svgSuccess = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> ';
        const svgError = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16.01"></line></svg> ';

        loadSystemSettings();

        function loadSystemSettings(showToast = false) {
            $.ajax({
                url: '/SystemSettingsController',
                type: 'POST',
                data: { action: 'get_settings' },
                dataType: 'json',
                success: function(res) {
                    if (res.success && res.data) {
                        let d = res.data;
                        let currVal = (d.currency_code || 'BHD') + '|' + (d.currency_symbol || 'BD');
                        $('#currencySetting').val(currVal).trigger('change');
                        $('#vatPercentage').val(parseFloat(d.vat_percentage || 10.00).toFixed(2));
                        $('#timezoneSetting').val(d.timezone || 'Asia/Bahrain').trigger('change');
                        $('#dateFormatSetting').val(d.date_format || 'Y-m-d').trigger('change');
                        updatePreview();

                        if (showToast) {
                            setupDropdown('dropdownContent', 'success', svgSuccess + 'Settings Reset to Saved Configuration', 'click');
                        }
                    }
                }
            });
        }

        function formatSampleDate(formatStr) {
            let now = new Date();
            let year = now.getFullYear();
            let month = String(now.getMonth() + 1).padStart(2, '0');
            let day = String(now.getDate()).padStart(2, '0');
            let monthsArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            let monthName = monthsArr[now.getMonth()];

            if (formatStr === 'd/m/Y') {
                return `${day}/${month}/${year}`;
            } else if (formatStr === 'd-M-Y') {
                return `${day}-${monthName}-${year}`;
            } else if (formatStr === 'm/d/Y') {
                return `${month}/${day}/${year}`;
            } else {
                return `${year}-${month}-${day}`;
            }
        }

        function updatePreview() {
            let currVal = $('#currencySetting').val() || 'BHD|BD';
            let curr = currVal.split('|');
            let code = curr[0] || 'BHD';
            let sym = curr[1] || 'BD';
            let vat = parseFloat($('#vatPercentage').val() || 10).toFixed(2);
            let tz = $('#timezoneSetting').val();
            let df = $('#dateFormatSetting').val();

            $('#previewCurrency').text(code + ' (' + sym + ')');
            $('#previewVat').text(vat + '%');
            $('#previewTimezone').text(tz);
            $('#previewDateFormat').text(formatSampleDate(df));

            let sampleSub = 100.00;
            let sampleVat = sampleSub * (parseFloat(vat) / 100);
            let sampleTotal = sampleSub + sampleVat;

            $('#sampleSubtotal').text(sampleSub.toFixed(3) + ' ' + sym);
            $('#sampleVatAmount').text(sampleVat.toFixed(3) + ' ' + sym);
            $('#sampleGrandTotal').text(sampleTotal.toFixed(3) + ' ' + sym);
        }

        $('#currencySetting, #vatPercentage, #timezoneSetting, #dateFormatSetting').on('change input', function() {
            updatePreview();
        });

        $('#btnResetSettings').click(function(e) {
            e.preventDefault();
            loadSystemSettings(true);
        });

        $('#btnSaveSettings').click(function(e) {
            e.preventDefault();
            if (typeof SaNDSAlert === 'function') {
                SaNDSAlert(
                    'Are you sure you want to save system configuration settings?',
                    'SaveSystemSettings',
                    'warning',
                    '#f39c12',
                    'Yes Save',
                    'Cancel',
                    'Save Settings'
                );
            } else {
                executeSaveSettings();
            }
        });

        $(document).on('click', '#msg_popup_confirmed', function() {
            let action = $('#message_matter').attr('data-switch-values');
            if (action === 'SaveSystemSettings') {
                executeSaveSettings();
            }
            closePopup();
        });

        $(document).on('click', '#msg_popup_canceled', function() {
            closePopup();
        });

        function closePopup() {
            if ($('#popupOverlay').length) $('#popupOverlay').hide();
            if ($('#popupContainer').length) $('#popupContainer').hide();
        }

        function executeSaveSettings() {
            let currVal = $('#currencySetting').val() || 'BHD|BD';
            let curr = currVal.split('|');
            let formData = {
                action: 'save_settings',
                currency_code: curr[0] || 'BHD',
                currency_symbol: curr[1] || 'BD',
                vat_percentage: $('#vatPercentage').val() || 10.00,
                timezone: $('#timezoneSetting').val() || 'Asia/Bahrain',
                date_format: $('#dateFormatSetting').val() || 'Y-m-d'
            };

            $.ajax({
                url: '/SystemSettingsController',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    if (res && (res.status === true || res.success === true)) {
                        setupDropdown('dropdownContent', 'success', svgSuccess + (res.message || 'Settings saved successfully'), 'click');
                        loadSystemSettings();
                    } else {
                        let errMsg = (res && res.message) ? res.message : 'Error saving settings';
                        setupDropdown('dropdownContent', 'error', svgError + errMsg, 'click');
                    }
                },
                error: function() {
                    setupDropdown('dropdownContent', 'error', svgError + 'Failed to save settings', 'click');
                }
            });
        }
    });
    </script>
</body>
</html>
