<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /Logout");
    exit();
}

include ROOT_PATH . '/view/envinclude.php';
require_once ROOT_PATH . '/__db.php';
require_once ROOT_PATH . '/pdf/print_settings_helper.php';

$companyId = !empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1;
$printSettings = getPrintSettings(null, $companyId);
?>
<!doctype html>
<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-wide"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/"
    data-template="horizontal-menu-template-no-customizer">

<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <style>
        .preview-paper {
            background: #ffffff;
            border: 1px solid #dbe3f3;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 6px 24px rgba(27, 61, 148, 0.08);
            min-height: 520px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .preview-body-placeholder {
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            background: #f8fafc;
            padding: 36px 20px;
            text-align: center;
            color: #64748b;
            margin: 22px 0;
        }
        .section-card-header {
            background: #eef3fc;
            color: #1b3d94;
            border-bottom: 1px solid #d0dcf5;
            font-weight: 600;
        }
        @media (max-width: 991.98px) {
            .container-p-y { padding-top: 15px !important; }
        }
        @media (min-width: 992px) {
            .container-p-y { padding-top: 55px !important; }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <?php include ROOT_PATH . '/view/templates/nav.php'; ?>

            <div class="layout-page">
                <div class="content-wrapper">
                    <?php include ROOT_PATH . '/view/templates/menu.php'; ?>

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                            <div>
                                <h4 class="fw-bold mb-1" style="color: #1b3d94;">
                                    <i class="ri-printer-line me-1"></i> Print Header & Footer Master
                                </h4>
                                <p class="text-muted mb-0">Customize the logo, header, and footer displayed across all Fast Link print formats and PDFs.</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="btnResetBlueLogo" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-refresh-line me-1"></i> Use Fast Link Blue Logo
                                </button>
                                <button type="button" id="btnSavePrintSettings" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i> Save Settings
                                </button>
                            </div>
                        </div>

                        <div id="printSettingsAlert" class="alert d-none" role="alert"></div>

                        <form id="printFormatForm" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="save_settings">
                            <input type="hidden" name="header_logo_choice" id="header_logo_choice" value="<?= htmlspecialchars($printSettings['header_logo']) ?>">

                            <div class="row g-4">
                                <!-- Left Column: Customization Form -->
                                <div class="col-lg-7">
                                    <!-- Logo & Brand -->
                                    <div class="card mb-4">
                                        <div class="card-header section-card-header py-3">
                                            <i class="ri-image-line me-1"></i> Logo & Brand Accent
                                        </div>
                                        <div class="card-body pt-4">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-md-5 text-center">
                                                    <div class="p-3 border rounded bg-light">
                                                        <img id="currentLogoPreview"
                                                             src="<?= $_ENV['BASE_URL'] . htmlspecialchars($printSettings['logo_rel_path']) ?>"
                                                             alt="Print Logo"
                                                             style="max-height: 75px; max-width: 100%; object-fit: contain;">
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <label class="form-label fw-medium">Upload Custom Logo (Optional)</label>
                                                    <input type="file" class="form-control mb-2" id="logo_file" name="logo_file" accept="image/png,image/jpeg,image/webp">
                                                    <div class="d-flex align-items-center gap-3 mt-2">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="show_logo" name="show_logo" value="1" <?= !empty($printSettings['show_logo']) ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="show_logo">Show Logo</label>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0 small text-nowrap" for="logo_width">Width (px):</label>
                                                            <input type="number" class="form-control form-control-sm" style="width: 85px;" id="logo_width" name="logo_width" min="60" max="260" value="<?= (int)$printSettings['logo_width'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Header Details -->
                                    <div class="card mb-4">
                                        <div class="card-header section-card-header py-3">
                                            <i class="ri-layout-top-line me-1"></i> Print Header Details
                                        </div>
                                        <div class="card-body pt-4">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="company_name">Company Name (English)</label>
                                                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?= htmlspecialchars($printSettings['company_name']) ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="company_name_ar">Company Name (Arabic)</label>
                                                    <input type="text" class="form-control" id="company_name_ar" name="company_name_ar" dir="rtl" value="<?= htmlspecialchars($printSettings['company_name_ar']) ?>">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label" for="header_subtitle">Header Subtitle / Tagline / CR & VAT No</label>
                                                    <input type="text" class="form-control" id="header_subtitle" name="header_subtitle" value="<?= htmlspecialchars($printSettings['header_subtitle']) ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="accent_color">Accent Color</label>
                                                    <div class="input-group">
                                                        <input type="color" class="form-control form-control-color" id="accent_color" name="accent_color" value="<?= htmlspecialchars($printSettings['accent_color']) ?>">
                                                        <input type="text" class="form-control" id="accent_color_hex" value="<?= htmlspecialchars($printSettings['accent_color']) ?>" maxlength="7">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label" for="header_address">Address</label>
                                                    <input type="text" class="form-control" id="header_address" name="header_address" value="<?= htmlspecialchars($printSettings['header_address']) ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="header_phone">Phone / Tel</label>
                                                    <input type="text" class="form-control" id="header_phone" name="header_phone" value="<?= htmlspecialchars($printSettings['header_phone']) ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="header_email">Email</label>
                                                    <input type="email" class="form-control" id="header_email" name="header_email" value="<?= htmlspecialchars($printSettings['header_email']) ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="header_website">Website</label>
                                                    <input type="text" class="form-control" id="header_website" name="header_website" value="<?= htmlspecialchars($printSettings['header_website']) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer Details -->
                                    <div class="card">
                                        <div class="card-header section-card-header py-3 d-flex justify-content-between align-items-center">
                                            <span><i class="ri-layout-bottom-line me-1"></i> Print Footer Details</span>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" id="show_footer" name="show_footer" value="1" <?= !empty($printSettings['show_footer']) ? 'checked' : '' ?>>
                                                <label class="form-check-label small" for="show_footer">Show Footer</label>
                                            </div>
                                        </div>
                                        <div class="card-body pt-4">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="footer_text">Footer Text (English)</label>
                                                    <textarea class="form-control" id="footer_text" name="footer_text" rows="2"><?= htmlspecialchars($printSettings['footer_text']) ?></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="footer_text_ar">Footer Text (Arabic)</label>
                                                    <textarea class="form-control" id="footer_text_ar" name="footer_text_ar" rows="2" dir="rtl"><?= htmlspecialchars($printSettings['footer_text_ar']) ?></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label" for="footer_note">Footer Note / Disclaimer</label>
                                                    <textarea class="form-control" id="footer_note" name="footer_note" rows="2"><?= htmlspecialchars($printSettings['footer_note']) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: Live Preview -->
                                <div class="col-lg-5">
                                    <div class="card sticky-top" style="top: 85px;">
                                        <div class="card-header section-card-header py-3">
                                            <i class="ri-eye-line me-1"></i> Live Print Format Preview
                                        </div>
                                        <div class="card-body pt-4">
                                            <div class="preview-paper">
                                                <!-- Preview Header -->
                                                <div id="pvHeaderWrap" class="d-flex justify-content-between align-items-center pb-3" style="border-bottom: 2px solid <?= htmlspecialchars($printSettings['accent_color']) ?>;">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img id="pvLogo"
                                                             src="<?= $_ENV['BASE_URL'] . htmlspecialchars($printSettings['logo_rel_path']) ?>"
                                                             alt="Logo"
                                                             style="max-height: 60px; max-width: <?= (int)$printSettings['logo_width'] ?>px; object-fit: contain; <?= empty($printSettings['show_logo']) ? 'display:none;' : '' ?>">
                                                        <div>
                                                            <h5 id="pvCompanyName" class="fw-bold mb-0" style="color: <?= htmlspecialchars($printSettings['accent_color']) ?>;">
                                                                <?= htmlspecialchars($printSettings['company_name']) ?>
                                                            </h5>
                                                            <div id="pvCompanyNameAr" class="small fw-semibold" style="color: <?= htmlspecialchars($printSettings['accent_color']) ?>;">
                                                                <?= htmlspecialchars($printSettings['company_name_ar']) ?>
                                                            </div>
                                                            <div id="pvSubtitle" class="text-muted small"><?= htmlspecialchars($printSettings['header_subtitle']) ?></div>
                                                            <div id="pvContact" class="text-muted" style="font-size: 11px;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <div id="pvDocTitle" class="fw-bold small text-uppercase" style="color: <?= htmlspecialchars($printSettings['accent_color']) ?>;">TAX INVOICE</div>
                                                        <span id="pvBadge" class="badge my-1" style="background-color: <?= htmlspecialchars($printSettings['accent_color']) ?>;">INV-2026-0001</span>
                                                        <div class="text-muted" style="font-size: 11px;"><?= date('d/m/Y') ?></div>
                                                    </div>
                                                </div>

                                                <!-- Sample Body -->
                                                <div class="preview-body-placeholder">
                                                    <i class="ri-file-list-3-line fs-2 d-block mb-1" style="color: #94a3b8;"></i>
                                                    <div class="fw-medium">Document Body Area</div>
                                                    <small>Contracts, Invoices, Cash Memos, Quotations &amp; Reports</small>
                                                </div>

                                                <!-- Preview Footer -->
                                                <div id="pvFooterWrap" class="pt-2 text-center" style="border-top: 1px solid #d0d7e5; font-size: 11px; <?= empty($printSettings['show_footer']) ? 'display:none;' : '' ?>">
                                                    <div id="pvFooterText" class="fw-semibold" style="color: <?= htmlspecialchars($printSettings['accent_color']) ?>;">
                                                        <?= htmlspecialchars($printSettings['footer_text']) ?>
                                                    </div>
                                                    <div id="pvFooterTextAr" style="color: <?= htmlspecialchars($printSettings['accent_color']) ?>;">
                                                        <?= htmlspecialchars($printSettings['footer_text_ar']) ?>
                                                    </div>
                                                    <div id="pvFooterNote" class="text-muted mt-1">
                                                        <?= htmlspecialchars($printSettings['footer_note']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

    <script>
    (function() {
        const baseUrl = "<?= $_ENV['BASE_URL'] ?>";
        const blueLogoRel = "assets/img/logo_new/fastlinklogoblue.png";

        function showAlert(type, msg) {
            const el = document.getElementById('printSettingsAlert');
            el.className = 'alert alert-' + type;
            el.textContent = msg;
            el.classList.remove('d-none');
            setTimeout(() => el.classList.add('d-none'), 4000);
        }

        function updatePreview() {
            const accent = document.getElementById('accent_color').value || '#1b3d94';
            document.getElementById('accent_color_hex').value = accent;

            document.getElementById('pvHeaderWrap').style.borderBottomColor = accent;
            document.getElementById('pvCompanyName').style.color = accent;
            document.getElementById('pvCompanyNameAr').style.color = accent;
            document.getElementById('pvDocTitle').style.color = accent;
            document.getElementById('pvBadge').style.backgroundColor = accent;
            document.getElementById('pvFooterText').style.color = accent;
            document.getElementById('pvFooterTextAr').style.color = accent;

            document.getElementById('pvCompanyName').textContent = document.getElementById('company_name').value || 'FAST LINK';
            document.getElementById('pvCompanyNameAr').textContent = document.getElementById('company_name_ar').value || '';
            document.getElementById('pvSubtitle').textContent = document.getElementById('header_subtitle').value || '';

            const parts = [];
            const addr = document.getElementById('header_address').value.trim();
            const phone = document.getElementById('header_phone').value.trim();
            const email = document.getElementById('header_email').value.trim();
            const web = document.getElementById('header_website').value.trim();
            if (addr) parts.push(addr);
            if (phone) parts.push('Tel: ' + phone);
            if (email) parts.push(email);
            if (web) parts.push(web);
            document.getElementById('pvContact').textContent = parts.join(' | ');

            const showLogo = document.getElementById('show_logo').checked;
            const logoWidth = parseInt(document.getElementById('logo_width').value || '150', 10);
            const pvLogo = document.getElementById('pvLogo');
            pvLogo.style.display = showLogo ? '' : 'none';
            pvLogo.style.maxWidth = Math.max(60, Math.min(260, logoWidth)) + 'px';

            const showFooter = document.getElementById('show_footer').checked;
            document.getElementById('pvFooterWrap').style.display = showFooter ? '' : 'none';
            document.getElementById('pvFooterText').textContent = document.getElementById('footer_text').value || '';
            document.getElementById('pvFooterTextAr').textContent = document.getElementById('footer_text_ar').value || '';
            document.getElementById('pvFooterNote').textContent = document.getElementById('footer_note').value || '';
        }

        ['company_name', 'company_name_ar', 'header_subtitle', 'header_address', 'header_phone',
         'header_email', 'header_website', 'logo_width', 'footer_text', 'footer_text_ar', 'footer_note', 'accent_color'
        ].forEach(id => {
            document.getElementById(id).addEventListener('input', updatePreview);
        });
        document.getElementById('show_logo').addEventListener('change', updatePreview);
        document.getElementById('show_footer').addEventListener('change', updatePreview);

        document.getElementById('accent_color_hex').addEventListener('input', function() {
            if (/^#[0-9a-fA-F]{6}$/.test(this.value)) {
                document.getElementById('accent_color').value = this.value;
                updatePreview();
            }
        });

        document.getElementById('logo_file').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('currentLogoPreview').src = e.target.result;
                    document.getElementById('pvLogo').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        document.getElementById('btnSavePrintSettings').addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            const formData = new FormData(document.getElementById('printFormatForm'));

            fetch('/PrintFormatMasterController', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                btn.disabled = false;
                if (res.status === 'success') {
                    if (res.data && res.data.logo_rel_path) {
                        document.getElementById('header_logo_choice').value = res.data.logo_rel_path;
                        document.getElementById('currentLogoPreview').src = baseUrl + res.data.logo_rel_path;
                        document.getElementById('pvLogo').src = baseUrl + res.data.logo_rel_path;
                    }
                    showAlert('success', res.message || 'Settings saved successfully.');
                } else {
                    showAlert('danger', res.message || 'Failed to save settings.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                showAlert('danger', 'Error saving settings: ' + err.message);
            });
        });

        document.getElementById('btnResetBlueLogo').addEventListener('click', function() {
            document.getElementById('logo_file').value = '';
            document.getElementById('header_logo_choice').value = blueLogoRel;
            document.getElementById('currentLogoPreview').src = baseUrl + blueLogoRel;
            document.getElementById('pvLogo').src = baseUrl + blueLogoRel;

            const fd = new FormData();
            fd.append('action', 'reset_logo');
            fetch('/PrintFormatMasterController', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(res => {
                    if (res.status === 'success') {
                        showAlert('success', res.message);
                    }
                });
        });

        updatePreview();
    })();
    </script>
</body>
</html>
