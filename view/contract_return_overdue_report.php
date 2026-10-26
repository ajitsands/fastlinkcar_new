<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header("Location: /Logout");
        exit();
    }
}
checkLogin();
include ROOT_PATH . '/view/envinclude.php';

// Company Access Privilege Resolution
$pdoModelObj = new CommonPDOModel();
$isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);
$userId = $_SESSION['user_id'] ?? 0;

$allCompanies = [];
try {
    $stmtComp = $pdoModelObj->selectexecuteQuery("SELECT ids, company_name FROM tbl_company WHERE status = 'Active' ORDER BY ids ASC");
    if ($stmtComp && $stmtComp instanceof PDOStatement) {
        $allCompanies = $stmtComp->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (\Throwable $e) {}

$allowedCompanies = [];
if ($isSuperAdmin) {
    $allowedCompanies = $allCompanies;
} else {
    if (!empty($_SESSION['company_json'])) {
        $decoded = json_decode($_SESSION['company_json'], true);
        if (is_array($decoded) && !empty($decoded)) {
            $allowedCompanies = $decoded;
        }
    }
    if (empty($allowedCompanies) && !empty($userId)) {
        try {
            $uStmt = $pdoModelObj->selectexecuteQuery("SELECT company_json, company_id FROM tbl_users WHERE id = :uid OR user_id = :uid LIMIT 1", [':uid' => $userId]);
            if ($uStmt && $uStmt instanceof PDOStatement) {
                $uRow = $uStmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($uRow['company_json'])) {
                    $decoded = json_decode($uRow['company_json'], true);
                    if (is_array($decoded) && !empty($decoded)) {
                        $allowedCompanies = $decoded;
                    }
                }
                if (empty($allowedCompanies) && !empty($uRow['company_id'])) {
                    foreach ($allCompanies as $ac) {
                        if (strval($ac['ids']) === strval($uRow['company_id'])) {
                            $allowedCompanies[] = $ac;
                            break;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {}
    }
    if (empty($allowedCompanies) && !empty($_SESSION['company_id'])) {
        foreach ($allCompanies as $ac) {
            if (strval($ac['ids']) === strval($_SESSION['company_id'])) {
                $allowedCompanies[] = $ac;
                break;
            }
        }
    }
}

if (empty($allowedCompanies)) {
    $allowedCompanies = !empty($allCompanies) ? $allCompanies : [['ids' => '1', 'company_name' => 'AA Car Rental']];
}

$hasMultipleCompanies = count($allowedCompanies) > 1;
$defaultCompanyValue  = $hasMultipleCompanies ? 'all' : strval($allowedCompanies[0]['ids']);
?>
<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <!-- RemixIcon WebFont CDN ensuring 100% universal icon rendering -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" />
    
    <!-- DataTables & Select2 CSS -->
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    
    <!-- Quill Editor CSS for Details Modal -->
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/editor.css" />

    <style>
        /* Base Icon Styling */
        .ri {
            display: inline-block;
            width: 1em;
            height: 1em;
            line-height: 1;
            vertical-align: -0.125em;
        }

        /* Unified form element heights and vertical alignment */
        #form_filter_report .form-select-sm,
        #form_filter_report .form-control-sm {
            height: 38px !important;
            min-height: 38px !important;
            font-size: 0.8125rem !important;
        }

        #form_filter_report .select2-container {
            width: 100% !important;
        }

        #form_filter_report .select2-container--default .select2-selection--single {
            height: 38px !important;
            min-height: 38px !important;
            border: 1px solid #d9dee3 !important;
            border-radius: 0.375rem !important;
            display: flex !important;
            align-items: center !important;
            background-color: #fff !important;
        }

        #form_filter_report .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
            font-size: 0.8125rem !important;
            color: #566a7f !important;
            padding-left: 0.75rem !important;
            padding-right: 2rem !important;
            display: flex !important;
            align-items: center !important;
        }

        #form_filter_report .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
            top: 1px !important;
            right: 8px !important;
        }

        #form_filter_report .select2-container--default .select2-selection--single .select2-selection__clear {
            height: 36px !important;
            line-height: 36px !important;
            margin-right: 1.25rem !important;
        }

        #form_filter_report .btn-filter-action {
            height: 38px !important;
            min-height: 38px !important;
            font-size: 0.8125rem !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* KPI Metric Cards */
        .kpi-card {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            transition: all 0.2s ease-in-out;
            position: relative;
            overflow: hidden;
            background: #ffffff;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .kpi-icon-box {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .kpi-icon-box i,
        .kpi-icon-box .ri {
            font-size: 22px !important;
            width: 22px !important;
            height: 22px !important;
            line-height: 22px !important;
            color: #ffffff !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .kpi-red {
            border-left: 4px solid #ef4444;
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
        }
        .kpi-green {
            border-left: 4px solid #10b981;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
        }
        .kpi-blue {
            border-left: 4px solid #3b82f6;
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
        }
        .kpi-purple {
            border-left: 4px solid #8b5cf6;
            background: linear-gradient(135deg, #f5f3ff 0%, #ffffff 100%);
        }
        .kpi-amber {
            border-left: 4px solid #f59e0b;
            background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%);
        }
        .pulse-danger {
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Standard Report DataTable Look and Feel */
        #tbl_contract_overdue_report {
            font-size: 12.5px;
        }
        #tbl_contract_overdue_report > thead > tr > th,
        table.dataTable thead th,
        .table thead th {
            background-color: #ffeff0 !important;
            color: #d12222 !important;
            border-bottom: 2px solid #d12222 !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            font-size: 0.78rem !important;
            letter-spacing: 0.5px;
            white-space: nowrap;
            vertical-align: middle;
            padding: 8px 10px;
        }
        #tbl_contract_overdue_report tbody tr:hover {
            background-color: #fff9f9 !important;
        }
        #tbl_contract_overdue_report tfoot {
            background-color: #ffeff0 !important;
            border-top: 2px solid #d12222 !important;
        }
        #tbl_contract_overdue_report tfoot td {
            font-weight: 700;
            font-size: 0.85rem;
            color: #d12222;
            padding: 8px 10px;
        }

        /* Agreement link styling */
        .agr-link {
            font-weight: 600;
            color: #f12526 !important;
            cursor: pointer;
            text-decoration: none;
            transition: color 0.15s ease-in-out;
        }
        .agr-link:hover {
            color: #c81e1f !important;
            text-decoration: underline !important;
        }

        /* Custom Modal Header matching ContractList */
        .custom-modal-header {
            background: linear-gradient(135deg, #f12526, #c81e1f) !important;
            color: #ffffff !important;
            border-bottom: none;
        }
        .custom-modal-header .modal-title {
            color: #ffffff !important;
        }
        .custom-modal-header .btn-close {
            filter: invert(1);
            opacity: 1;
        }

        /* Document and Image preview circles */
        #viewcontractcontractcustdriverdocpreview li {
            width: 60px;
            height: 60px;
            overflow: hidden;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #viewcontractcontractcustdriverdocpreview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        @media print {
            .no-print, .layout-navbar, .layout-menu, .footer, .btn, .card-header, #filterSection {
                display: none !important;
            }
            .layout-page, .content-wrapper, .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
            }
            body {
                background: #fff !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
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

                    <div class="container-fluid flex-grow-1 container-p-y">

                        <!-- Top Title & Action Bar -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2 no-print">
                            <div>
                                <h4 class="fw-bold mb-1">
                                    <i class="ri ri-time-line text-danger me-2"></i>Contract Status & Return Overdue Report
                                </h4>
                                <p class="text-muted mb-0">
                                    Monitor contract periods, extension history, expected return dates, overdue vehicles, and auto-calculated overdue amounts by company in real time.
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="btn_export_excel" class="btn btn-outline-success btn-sm">
                                    <i class="ri ri-file-excel-2-line me-1"></i> Export to Excel
                                </button>
                            </div>
                        </div>

                        <!-- Summary KPI Metrics Cards -->
                        <div class="row g-3 mb-4 no-print" id="kpiContainer">
                            <!-- Total Contracts -->
                            <div class="col-6 col-md-4 col-xl-2">
                                <div class="card kpi-card kpi-blue h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Total Active Fleet</span>
                                        <div class="kpi-icon-box bg-primary">
                                            <i class="ri ri-file-list-3-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0" id="kpi_total_contracts">0</h3>
                                    <span class="text-muted small">Rentout & Extended</span>
                                </div>
                            </div>

                            <!-- Currently Active / Rentout -->
                            <div class="col-6 col-md-4 col-xl-2">
                                <div class="card kpi-card kpi-green h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Initial Rentout</span>
                                        <div class="kpi-icon-box bg-success">
                                            <i class="ri ri-car-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-success" id="kpi_total_active">0</h3>
                                    <span class="text-muted small">Without extension</span>
                                </div>
                            </div>

                            <!-- Overdue Contracts -->
                            <div class="col-6 col-md-4 col-xl-2">
                                <div class="card kpi-card kpi-red pulse-danger h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-danger small fw-bold">Overdue Contracts</span>
                                        <div class="kpi-icon-box bg-danger">
                                            <i class="ri ri-alarm-warning-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-danger" id="kpi_total_overdue">0</h3>
                                    <span class="text-danger small fw-semibold">Past expected return</span>
                                </div>
                            </div>

                            <!-- Extended Contracts -->
                            <div class="col-6 col-md-4 col-xl-2">
                                <div class="card kpi-card kpi-purple h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Extended Contracts</span>
                                        <div class="kpi-icon-box" style="background-color: #8b5cf6;">
                                            <i class="ri ri-repeat-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0" id="kpi_total_extended">0</h3>
                                    <span class="text-muted small">With contract extensions</span>
                                </div>
                            </div>

                            <!-- Total Agreed Amount -->
                            <div class="col-6 col-md-4 col-xl-2">
                                <div class="card kpi-card kpi-amber h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Total Agreed</span>
                                        <div class="kpi-icon-box bg-warning">
                                            <i class="ri ri-money-dollar-circle-line"></i>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold mb-0 text-dark" id="kpi_total_agreed_amount">0.000</h4>
                                    <span class="text-muted small">Contract + Extensions BHD</span>
                                </div>
                            </div>

                            <!-- Overdue Extra Charges -->
                            <div class="col-6 col-md-4 col-xl-2">
                                <div class="card kpi-card kpi-red h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-danger small fw-bold">Overdue Extra Amt</span>
                                        <div class="kpi-icon-box bg-danger">
                                            <i class="ri ri-coins-line"></i>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold mb-0 text-danger" id="kpi_total_overdue_extra">0.000</h4>
                                    <span class="text-danger small">Overdue Days &times; Rate</span>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Filter Controls Card -->
                        <div class="card mb-4 border shadow-sm no-print" id="filterSection">
                            <div class="card-header bg-light border-bottom py-2 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark"><i class="ri ri-filter-3-line text-danger me-1"></i> Filter Options</span>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-danger btn-xs py-1 px-2" id="btn_quick_overdue">
                                        <i class="ri ri-alarm-warning-line me-1"></i> Quick: Overdue Only
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-xs py-1 px-2" id="btn_quick_active">
                                        <i class="ri ri-car-line me-1"></i> Quick: Rentout Only
                                    </button>
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <form id="form_filter_report" class="row g-3">

                                    <!-- Company Filter -->
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <label class="form-label small fw-semibold" for="filter_company">
                                            <i class="ri ri-building-line text-danger me-1"></i>Company
                                        </label>
                                        <select id="filter_company" class="form-select form-select-sm">
                                            <?php if ($hasMultipleCompanies): ?>
                                                <option value="all" <?= $defaultCompanyValue === 'all' ? 'selected' : '' ?>>All Companies (<?= count($allowedCompanies) ?>)</option>
                                                <?php foreach ($allowedCompanies as $comp): ?>
                                                    <option value="<?= htmlspecialchars($comp['ids']) ?>"><?= htmlspecialchars($comp['company_name']) ?></option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <?php foreach ($allowedCompanies as $comp): ?>
                                                    <option value="<?= htmlspecialchars($comp['ids']) ?>" selected><?= htmlspecialchars($comp['company_name']) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <!-- Date Range Filter By -->
                                    <div class="col-12 col-sm-6 col-md-2">
                                        <label class="form-label small fw-semibold" for="filter_date_by">Date Filter Field</label>
                                        <select id="filter_date_by" class="form-select form-select-sm">
                                            <option value="expected_return" selected>Expected Return Date</option>
                                            <option value="contract_date">Contract Date</option>
                                        </select>
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-12 col-sm-6 col-md-2">
                                        <label class="form-label small fw-semibold" for="filter_from_date">From Date</label>
                                        <input type="date" id="filter_from_date" class="form-control form-control-sm" value="<?= date('Y-m-01', strtotime('-1 month')) ?>">
                                    </div>

                                    <!-- To Date -->
                                    <div class="col-12 col-sm-6 col-md-2">
                                        <label class="form-label small fw-semibold" for="filter_to_date">To Date</label>
                                        <input type="date" id="filter_to_date" class="form-control form-control-sm" value="<?= date('Y-m-d', strtotime('+1 month')) ?>">
                                    </div>

                                    <!-- Contract Status -->
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <label class="form-label small fw-semibold" for="filter_status">Contract Status</label>
                                        <select id="filter_status" class="form-select form-select-sm">
                                            <option value="all" selected>All (Rentout & Extended)</option>
                                            <option value="Rentout">Rentout Only</option>
                                            <option value="Extended">Extended Only</option>
                                        </select>
                                    </div>

                                    <!-- Extended Yes / No -->
                                    <div class="col-12 col-sm-6 col-md-2">
                                        <label class="form-label small fw-semibold" for="filter_extended">Extended?</label>
                                        <select id="filter_extended" class="form-select form-select-sm">
                                            <option value="all" selected>All (Yes & No)</option>
                                            <option value="yes">Extended Only (Yes)</option>
                                            <option value="no">Not Extended (No)</option>
                                        </select>
                                    </div>

                                    <!-- Overdue Filter -->
                                    <div class="col-12 col-sm-6 col-md-2">
                                        <label class="form-label small fw-semibold" for="filter_overdue">Overdue Status</label>
                                        <select id="filter_overdue" class="form-select form-select-sm">
                                            <option value="all" selected>All (Overdue & On Schedule)</option>
                                            <option value="overdue_only">Overdue Only</option>
                                            <option value="on_time_only">On Schedule Only</option>
                                        </select>
                                    </div>

                                    <!-- Customer Autocomplete Filter -->
                                    <div class="col-12 col-md-5 col-xl-5">
                                        <label class="form-label small fw-semibold" for="selectCustomerFromSelect2">Customer Name / Mobile / CPR</label>
                                        <select id="selectCustomerFromSelect2" class="form-select select2" style="width:100%"></select>
                                        <input type="hidden" id="filter_customer_code">
                                    </div>

                                    <!-- Filter Buttons -->
                                    <div class="col-12 col-md-3 col-xl-3">
                                        <label class="form-label small fw-semibold d-none d-md-block" style="visibility: hidden;">&nbsp;</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="submit" id="btn_apply_filter" class="btn btn-primary btn-sm btn-filter-action px-3 text-nowrap">
                                                <i class="ri ri-search-line me-1"></i> Apply Filters
                                            </button>
                                            <button type="button" id="btn_reset_filter" class="btn btn-outline-secondary btn-sm btn-filter-action px-3 text-nowrap" title="Reset all filters">
                                                <i class="ri ri-refresh-line me-1"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Main Report Data Table Card -->
                        <div class="card border shadow-sm">
                            <div class="card-datatable table-responsive">
                                <table class="table table-bordered table-sm table-hover align-middle text-start" id="tbl_contract_overdue_report" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">#</th>
                                            <th width="10%">Agreement / Company</th>
                                            <th width="6%" class="text-center">Status</th>
                                            <th width="14%">Customer Details</th>
                                            <th width="12%">Vehicle Details</th>
                                            <th width="10%">Contract Period</th>
                                            <th width="5%" class="text-center">Extended</th>
                                            <th width="10%">Extension Period</th>
                                            <th width="9%">Expected Return</th>
                                            <th width="9%">Date of Return</th>
                                            <th width="8%" class="text-center">Return Overdue</th>
                                            <th width="5%" class="text-end">Daily Rate</th>
                                            <th width="7%" class="text-end">Total Agreed</th>
                                            <th width="7%" class="text-end text-danger">Overdue Extra</th>
                                            <th width="4%" class="text-center no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamically populated via AJAX -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="12" class="text-end">Filtered Totals:</td>
                                            <td class="text-end text-dark" id="foot_total_agreed">0.000 BHD</td>
                                            <td class="text-end text-danger" id="foot_total_overdue_extra">0.000 BHD</td>
                                            <td class="no-print"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Contract Details Modal (Identical to VehicleContractList) -->
    <?php include ROOT_PATH . '/view/templates/VehicleContractList/view_contract_details_modal.php'; ?>
    
    <!-- Image and Document Preview Modals -->
    <?php include ROOT_PATH . '/view/templates/VehicleContractList/vehicle_image_preview_modal.php'; ?>
    <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/quill.js"></script>

    <script>
    let reportDataCache = [];
    let reportDataTable = null;
    let viewcontractextensiontable = null;
    let fullEditorOnBody = null;
    let currentVehiclePreviewId = null;
    const defaultCompanyVal = "<?= $defaultCompanyValue ?>";

    $(document).ready(function() {
        // Initialize Quill editor for Contract Terms inside modal
        if ($('#full-editor-onbody').length && typeof Quill !== 'undefined') {
            try {
                fullEditorOnBody = new Quill('#full-editor-onbody', {
                    bounds: '#full-editor-onbody',
                    placeholder: 'Terms & Conditions',
                    modules: {
                        syntax: true,
                        toolbar: false
                    },
                    readOnly: true,
                    theme: 'snow'
                });
            } catch(e) {
                console.warn('Quill init warning:', e);
            }
        }

        initDataTable();
        loadReportData();

        // Company Dropdown Change - auto reload data
        $('#filter_company').on('change', function() {
            loadReportData();
        });

        // Filter Form Submit
        $('#form_filter_report').on('submit', function(e) {
            e.preventDefault();
            loadReportData();
        });

        // Reset Filters Button
        $('#btn_reset_filter').on('click', function() {
            $('#filter_company').val(defaultCompanyVal);
            $('#filter_date_by').val('expected_return');
            $('#filter_from_date').val('<?= date('Y-m-01', strtotime('-1 month')) ?>');
            $('#filter_to_date').val('<?= date('Y-m-d', strtotime('+1 month')) ?>');
            $('#filter_status').val('all');
            $('#filter_extended').val('all');
            $('#filter_overdue').val('all');
            $('#selectCustomerFromSelect2').val(null).trigger('change');
            $('#filter_customer_code').val('');
            loadReportData();
        });

        // Initialize Customer Select2 Autocomplete (Matching ContractHistoryReport)
        $('#selectCustomerFromSelect2').select2({
            placeholder: 'Search Customer by Name, Mobile, or CPR',
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: '/SearchCustomerDetails',
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return { q: params.term, action: 'SearchCustomer' };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.customer_code || item.id,
                            text: item.customer_name + ' | ' + (item.customer_mobile || '') + ' | ' + (item.customer_cr_cpr || ''),
                            customer_name: item.customer_name,
                            customer_mobile: item.customer_mobile,
                            customer_cr_cpr: item.customer_cr_cpr,
                            customer_code: item.customer_code || item.id
                        }))
                    };
                }
            },
            templateResult: formatCustomer,
            templateSelection: formatCustomerSelection
        });

        function formatCustomer(customer) {
            if (!customer.id) return customer.text;
            let mobile = customer.customer_mobile ? ` | Mobile: ${customer.customer_mobile}` : '';
            let cpr = customer.customer_cr_cpr ? ` | CPR/CR: ${customer.customer_cr_cpr}` : '';
            return $(`<div><strong>${customer.customer_name}</strong>${mobile}${cpr}</div>`);
        }

        function formatCustomerSelection(customer) {
            if (!customer.id) return customer.text;
            let mobile = customer.customer_mobile ? ` (${customer.customer_mobile})` : '';
            return customer.customer_name ? `${customer.customer_name}${mobile}` : customer.text;
        }

        $('#selectCustomerFromSelect2').on('select2:select', function (e) {
            $('#filter_customer_code').val(e.params.data.customer_code);
        }).on('select2:clear', function () {
            $('#filter_customer_code').val('');
        });

        // Quick Filters
        $('#btn_quick_overdue').on('click', function() {
            $('#filter_overdue').val('overdue_only');
            $('#filter_status').val('all');
            loadReportData();
        });

        $('#btn_quick_active').on('click', function() {
            $('#filter_status').val('Rentout');
            $('#filter_overdue').val('all');
            loadReportData();
        });

        // Export to CSV
        $('#btn_export_excel').on('click', function() {
            exportToCSV();
        });

        // Agreement number click or Action button click to open Contract Details Modal
        $(document).on('click', '.view_contract_details', function(e) {
            e.preventDefault();
            let id = $(this).data('id'); 
            let vehicleid = $(this).data('vehicle');
            let customer_code = $(this).data('customer');
            let agreement_no = $(this).data('contract');
            let model_ids = $(this).data('model');
            let booking_ids = $(this).data('booking_id');

            $('#viewcontract_agreement_ref').text(agreement_no);
            $('#txt_viewcontract_modal_agreement_id').val(id);
            $('#txt_viewcontract_modal_agreement_no').val(agreement_no);
            $('#txt_viewcontract_modal_booking_ids').val(booking_ids);

            openviewcontractModal(id, vehicleid, customer_code, model_ids);
        });

        // Preview vehicle image click
        $(document).on('click', '.vehicle-preview-img', function() {
            let id  = $(this).data('id');
            let src = $(this).attr('src');
            currentVehiclePreviewId = id;

            $('#VehiclefilePreviewBody').empty().html(`
                <img src="${src}" class="img-fluid rounded shadow" style="max-height:70vh;">
            `);

            let modalEl = document.getElementById('imagePreviewModal');
            let modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.show();
        });

        // Preview customer/driver documents click
        $(document).on('click', '#viewcontractcontractcustdriverdocpreview li', function() {
            let fileUrl = $(this).data('img');
            if (!fileUrl) return;

            let ext = fileUrl.split('.').pop().toLowerCase();
            let html = '';

            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                html = `<img src="${fileUrl}" class="img-fluid rounded" style="max-height:70vh;">`;
            } else if (ext === 'pdf') {
                html = `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
            } else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
                html = `<iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true" width="100%" height="600px" style="border:none;"></iframe>`;
            } else {
                html = `<div class="alert alert-warning">Preview not available.<br><a href="${fileUrl}" target="_blank" class="btn btn-primary mt-2">Download File</a></div>`;
            }

            $('#filePreviewBody').html(html);
            $('#filePreviewModal').modal('show');
        });
    });

    function initDataTable() {
        reportDataTable = $('#tbl_contract_overdue_report').DataTable({
            responsive: true,
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[8, 'desc']], // Order by Expected Return by default
            columnDefs: [
                { orderable: false, targets: [0, 14] }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Instant table filter...",
                emptyTable: "No contracts matching selected filter criteria."
            }
        });
    }

    function loadReportData() {
        let payload = {
            action: 'getReportData',
            company_id: $('#filter_company').val() || defaultCompanyVal,
            from_date: $('#filter_from_date').val(),
            to_date: $('#filter_to_date').val(),
            date_filter_by: $('#filter_date_by').val(),
            contract_status: $('#filter_status').val(),
            extended_filter: $('#filter_extended').val(),
            overdue_filter: $('#filter_overdue').val(),
            customer_code: $('#filter_customer_code').val()
        };

        // UI Loading Indicator
        reportDataTable.clear().draw();
        $('#tbl_contract_overdue_report tbody').html('<tr><td colspan="15" class="text-center py-4"><div class="spinner-border text-danger spinner-border-sm me-2" role="status"></div> Loading report data...</td></tr>');

        $.ajax({
            url: '/ContractReturnOverdueController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            dataType: 'json',
            success: function(resp) {
                if (resp.status) {
                    reportDataCache = resp.data || [];
                    updateKPIs(resp.kpis);
                    renderTableRows(reportDataCache);
                } else {
                    alert('Error: ' + (resp.message || 'Failed to retrieve report data'));
                }
            },
            error: function(xhr, status, err) {
                console.error('AJAX Error:', xhr.responseText);
                alert('Server error occurred while loading the report.');
            }
        });
    }

    function updateKPIs(kpis) {
        if (!kpis) return;
        $('#kpi_total_contracts').text(kpis.total_contracts);
        $('#kpi_total_active').text(kpis.total_active);
        $('#kpi_total_overdue').text(kpis.total_overdue);
        $('#kpi_total_extended').text(kpis.total_extended);
        $('#kpi_total_agreed_amount').text(kpis.total_agreed_amount);
        $('#kpi_total_overdue_extra').text(kpis.total_overdue_extra_amount);

        // Footer Totals
        $('#foot_total_agreed').text(kpis.total_agreed_amount + ' BHD');
        $('#foot_total_overdue_extra').text(kpis.total_overdue_extra_amount + ' BHD');
    }

    function renderTableRows(rows) {
        reportDataTable.clear();

        if (rows.length === 0) {
            reportDataTable.draw();
            return;
        }

        let tableData = [];
        rows.forEach((row, index) => {
            // Status Badge matching ContractList page exactly
            let badgeClass = 'bg-secondary';
            let s = (row.agreement_status || '').trim();
            if (s === 'Generated') {
                badgeClass = 'bg-warning';
            } else if (s === 'Rentout') {
                badgeClass = 'bg-success';
            } else if (s === 'Extended') {
                badgeClass = 'bg-success';
            } else if (s === 'Returned') {
                badgeClass = 'bg-primary';
            } else if (s === 'Closed') {
                badgeClass = 'bg-success';
            } else if (s === 'Onhold') {
                badgeClass = 'bg-danger';
            } else if (s === 'Cancelled') {
                badgeClass = 'bg-danger';
            } else {
                badgeClass = 'bg-danger';
            }
            let statusBadge = `<span class="badge ${badgeClass}">${escapeHtml(s || 'N/A')}</span>`;

            // Company & Agreement Block with Clickable Agreement Number
            let compBadge = row.company_name && row.company_name !== 'N/A' 
                ? `<div class="mt-1"><span class="badge bg-label-danger" style="font-size:0.72rem;">${escapeHtml(row.company_name)}</span></div>` 
                : '';

            let agreementHtml = `
                <div>
                    <a href="javascript:void(0)" 
                       class="agr-link view_contract_details" 
                       data-id="${row.contract_id}" 
                       data-vehicle="${row.vehicle_id}" 
                       data-model="${row.model_id}" 
                       data-customer="${row.customer_code || row.customer_id}" 
                       data-contract="${escapeHtml(row.agreement_no)}" 
                       data-booking_id="${row.booking_ids || ''}"
                       title="Click to view complete contract details">
                        ${escapeHtml(row.agreement_no)}
                        <i class="ri ri-external-link-line ms-1 small"></i>
                    </a>
                </div>
                ${compBadge}
                <div class="small text-muted">${row.agreement_date}</div>
            `;

            // Customer block
            let custHtml = `<div><strong>${escapeHtml(row.customer_name)}</strong></div>
                            <small class="text-muted"><i class="ri ri-phone-line me-1"></i>${escapeHtml(row.customer_mobile)}</small>
                            ${row.customer_cpr !== 'N/A' ? `<div class="small text-muted"><i class="ri ri-id-card-line me-1"></i>CPR: ${escapeHtml(row.customer_cpr)}</div>` : ''}`;

            // Vehicle block
            let vehHtml = `<div><strong class="text-dark">${escapeHtml(row.vehicle_no)}</strong></div>
                           <small class="text-dark">${escapeHtml(row.vehicle_model)}</small>
                           <div class="small text-muted">${escapeHtml(row.vehicle_category)}</div>`;

            // Contract Period block
            let contractPeriodHtml = `<div class="small"><strong>From:</strong> ${row.contract_period_from}</div>
                                      <div class="small"><strong>To:</strong> ${row.contract_period_to}</div>
                                      <small class="badge bg-light text-dark border">${row.contract_duration_days} Days</small>`;

            // Extended Badge
            let extendedBadge = '';
            if (row.is_extended === 'Yes') {
                extendedBadge = `<span class="badge bg-success" title="${row.extension_count} Extensions Recorded"><i class="ri ri-check-line"></i> Yes (${row.extension_count})</span>`;
            } else {
                extendedBadge = `<span class="badge bg-light text-muted border">No</span>`;
            }

            // Extension Period block
            let extPeriodHtml = row.extension_period !== '-' 
                ? `<div class="small fw-semibold text-primary">${row.extension_period}</div><small class="text-muted">Amt: ${row.extension_amount} BHD</small>`
                : '<span class="text-muted">-</span>';

            // Expected Return Date
            let expReturnHtml = `<div class="fw-bold ${row.is_overdue ? 'text-danger' : 'text-dark'}">${row.expected_return_date}</div>`;

            // Date of Return (All vehicles are currently on rent)
            let actualReturnHtml = `<span class="badge bg-light text-muted border"><i class="ri ri-roadster-line me-1"></i>On Rent</span>`;

            // Return Overdue Badge
            let overdueBadge = '';
            if (row.is_overdue) {
                overdueBadge = `<span class="badge bg-danger"><i class="ri ri-alarm-warning-line me-1"></i>${row.overdue_status_label}</span>`;
            } else {
                overdueBadge = `<span class="badge bg-success"><i class="ri ri-checkbox-circle-line me-1"></i>${row.overdue_status_label}</span>`;
            }

            // Amounts
            let agreedAmountHtml = `<div><strong>${row.total_agreed_amount}</strong></div>
                                    <small class="text-muted">Init: ${row.contract_amount}</small>`;

            let extraOverdueHtml = parseFloat(row.extra_overdue_amount) > 0 
                ? `<strong class="text-danger fs-6">+${row.extra_overdue_amount} BHD</strong><div class="small text-muted">${row.overdue_days}d &times; ${row.daily_rate}</div>` 
                : '<span class="text-muted">0.000 BHD</span>';

            let actionBtn = `
                <button type="button" 
                        class="btn btn-outline-danger btn-xs view_contract_details" 
                        data-id="${row.contract_id}" 
                        data-vehicle="${row.vehicle_id}" 
                        data-model="${row.model_id}" 
                        data-customer="${row.customer_code || row.customer_id}" 
                        data-contract="${escapeHtml(row.agreement_no)}" 
                        data-booking_id="${row.booking_ids || ''}"
                        title="View Complete Contract Details">
                    <i class="ri ri-eye-line"></i>
                </button>
            `;

            tableData.push([
                index + 1,
                agreementHtml,
                statusBadge,
                custHtml,
                vehHtml,
                contractPeriodHtml,
                extendedBadge,
                extPeriodHtml,
                expReturnHtml,
                actualReturnHtml,
                overdueBadge,
                `${row.daily_rate}`,
                agreedAmountHtml,
                extraOverdueHtml,
                actionBtn
            ]);
        });

        reportDataTable.rows.add(tableData).draw();
    }

    // Open Contract Details Modal (Identical to VehicleContractList)
    function openviewcontractModal(id, vehicleid, customer_code, model_ids) {
        $.ajax({
            url: '/ContractListController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'GetContractDetails',
                agreementid: id,
                vehicleid: vehicleid,
                customer_code: customer_code,
                model_ids: model_ids
            }),
            success: function (res) {
                populateviewContractModal(res);
                let modalEl = document.getElementById('viewcontractModal');
                let modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching contract details:', error);
                alert('Failed to load contract details.');
            }
        });
    }

    // Populate Contract Details Modal (Identical to VehicleContractList)
    function populateviewContractModal(d) {
        let data = (typeof d === "string") ? JSON.parse(d) : d;

        // Customer details
        $('#viewcontract_c_name').text(data.customer.customer_name || '');
        $('#viewcontract_c_code').text(data.customer.customer_id || '');
        $('#viewcontract_c_mobile').text(data.customer.customer_mobile || '');
        $('#viewcontract_c_email').text(data.customer.customer_email || '');
        $('#viewcontract_c_attn').text(data.customer.customer_attn || '');
        $('#viewcontract_c_attr').text(data.customer.customer_addr || '');

        // Vehicle details
        $('#viewcontract_v_no').text(data.vehicle.vehicle_number || '');
        $('#viewcontract_v_model').text(data.vehicle.model_names || '');
        $('#viewcontract_v_brand').text(data.vehicle.brand_name || '');
        $('#viewcontract_v_category').text(data.vehicle.category_name || '');
        $('#viewcontract_v_color').text(data.vehicle.vehicle_color || '');
        $('#viewcontract_v_year').text(data.vehicle.vehicle_year || '');
        $('#viewcontract_v_passing').text(data.vehicle.formatted_next_passing_date || '');
        $('#viewcontract_hid_nxt_passing').val(data.vehicle.next_passing_date || '');  
        $('#viewcontract_v_maintenance').text(data.vehicle.formatted_next_maintenance_date || '');
        $('#viewcontract_hid_nxt_maintenance').val(data.vehicle.next_maintenance_date || '');  
        $('#viewcontract_v_insurance').text(data.vehicle.formatted_next_insurance_date || ''); 
        $('#viewcontract_hid_nxt_insurance').val(data.vehicle.next_insurance_date || '');  

        $('#viewcontract_hid_vehicle_id').val(data.vehicle.ids || '');
        $('#viewcontract_hid_category_id').val(data.vehicle.category_id || '');
        $('#viewcontract_hid_model_id').val(data.vehicle.model_id || '');
        $('#viewcontract_hid_vehicle_no').val(data.vehicle.vehicle_number || '');

        // Pricing Rates
        if (data.price_list && Array.isArray(data.price_list)) {
            data.price_list.forEach(function(item) {
                switch(item.item) {
                    case "Price per hour rental without driver":
                        $('#viewcontract_wod_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                        break;
                    case "Price per hour rental with driver":
                        $('#viewcontract_wd_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                        break;
                    case "Price per day rental without driver":
                        $('#viewcontract_wod_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                        break;
                    case "Price per day rental with driver":
                        $('#viewcontract_wd_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                        break;
                    case "Price per week rental without driver":
                        $('#viewcontract_wod_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                        break;
                    case "Price per week rental with driver":
                        $('#viewcontract_wd_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                        break;
                    case "Price per month rental without driver":
                        $('#viewcontract_wod_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                        break;
                    case "Price per month rental with driver":
                        $('#viewcontract_wd_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                        break;
                }
            });
        }

        let contract = data.contract || {};
        let driverDetails = {};
        let vehicle_accessories_details = {};
        try { driverDetails = JSON.parse(contract.driver_details || '{}'); } catch(e) {}
        try { vehicle_accessories_details = JSON.parse(contract.vehicle_accessories_details || '{}'); } catch(e) {}

        // Accessories & Checkboxes
        $('#viewcontractchk_tools').prop('checked', vehicle_accessories_details.chk_tools && vehicle_accessories_details.chk_tools === 'Yes');
        $('#viewcontractchk_spare').prop('checked', vehicle_accessories_details.chk_spare && vehicle_accessories_details.chk_spare === 'Yes');
        $('#viewcontractchk_radio').prop('checked', vehicle_accessories_details.chk_radio && vehicle_accessories_details.chk_radio === 'Yes');
        $('#viewcontractkm_out').val(vehicle_accessories_details.vehicle_km_out || 0);
        $('#viewcontractkm_in').val(contract.km_in || 0);
        $('#viewcontractfuel_level').val(vehicle_accessories_details.fuel_level || '');

        $('#viewcontractdt_out').val(vehicle_accessories_details.date_out || '');
        $('#viewcontractdt_in').val(contract.return_date || '');
        $('#viewcontractdt_contract_date').val(contract.agreement_date || '');

        $('#viewcontractcust_driver').val(contract.customer_driver_name || '');
        $('#viewcontract_agreement_status').text(contract.agreement_status || '');
        $('#viewcontractcust_driver_contact_no').val(contract.customer_driver_contact_number || '');
        $('.driverclass').show(); 

        $('#viewcontractd_name').text(driverDetails.driver_name === 'Select Driver' ? '' : (driverDetails.driver_name || ''));
        $('#viewcontractd_mobile').text(driverDetails.driver_mobile || '');
        $('#viewcontractd_license_no').text(driverDetails.driver_license_no || '');
        $('#viewcontractd_license_issue_place').text(driverDetails.driver_license_issplace || '');
        $('#viewcontractd_licenseissueDate').text(driverDetails.driver_license_expdate || '');
        $('#viewcontractd_licenseexpiryDate').text(driverDetails.driver_license_expdate || '');

        // Terms & Conditions
        let termsCondition = contract.terms_condition || '';
        if (fullEditorOnBody && fullEditorOnBody.root) {
            fullEditorOnBody.root.innerHTML = termsCondition;
        } else {
            $('#full-editor-onbody').html(termsCondition);
        }

        // Signatures
        if (contract.hirer_signature && contract.hirer_signature.trim() !== '') {
            $('#latest_hirer_signature').attr('src', contract.hirer_signature).show();
            $('#no_hirer_signature').hide();
        } else {
            $('#latest_hirer_signature').hide();
            $('#no_hirer_signature').show().text('No Hirer Signature Applied');
        }
        $('#latest_hirer_name').text(contract.hirer_name || '-');
        $('#latest_hirer_date').text(contract.hirer_signature_date || '-');

        if (contract.delivered_signature && contract.delivered_signature.trim() !== '') {
            $('#latest_delivery_signature').attr('src', contract.delivered_signature).show();
            $('#no_delivery_signature').hide();
        } else {
            $('#latest_delivery_signature').hide();
            $('#no_delivery_signature').show().text('No Delivered Signature Applied');
        }
        $('#latest_delivery_name').text(contract.delivered_signatory || '-');
        $('#latest_delivery_date').text(contract.delivered_signature_date || '-');

        if (contract.receiver_signature && contract.receiver_signature.trim() !== '') {
            $('#latest_receiver_signature').attr('src', contract.receiver_signature).show();
            $('#no_receiver_signature').hide();
        } else {
            $('#latest_receiver_signature').hide();
            $('#no_receiver_signature').show().text('No Receiver Signature Applied');
        }
        $('#latest_receiver_name').text(contract.receiver_name || '-');
        $('#latest_receiver_date').text(contract.receiver_signature_datetime || '-');

        // Customer Driver Attachments
        $('#viewcontractcontractcustdriverdocpreview').empty();
        let existingAttachments = { vehicles: [] };
        try {
            existingAttachments = JSON.parse(contract.customer_driver_attachments || '{"vehicles":[]}');
        } catch(e) {}

        if (existingAttachments.vehicles && Array.isArray(existingAttachments.vehicles)) {
            existingAttachments.vehicles.forEach(vehicle => {
                if (Array.isArray(vehicle.files)) {
                    vehicle.files.forEach(fileUrl => {
                        let previewSrc = getDocumentPreview(fileUrl);
                        let id = 'db_' + Math.random().toString(36).substr(2, 9);
                        let liHtml = `
                            <li id="doc-${id}" data-img="${fileUrl}" data-file="${fileUrl}" title="${vehicle.documentName || ''}" class="avatar avatar-lg pull-up position-relative me-2">
                                <img class="rounded-circle vehicle-doc-preview" src="${previewSrc}" style="width:60px;height:60px;object-fit:cover;cursor:pointer;" />
                            </li>
                        `;
                        $('#viewcontractcontractcustdriverdocpreview').append(liHtml);
                    });
                }
            });
        }

        // Vehicle Rentout Images
        $('#viewcontractpreview').empty();  
        let existingVehicleImages = [];
        try { existingVehicleImages = JSON.parse(contract.vehicle_rentout_images || '[]'); } catch(e) {}
        if (Array.isArray(existingVehicleImages)) {
            existingVehicleImages.forEach(img => {
                let id = 'db_' + Math.random().toString(36).substr(2, 9);
                $('#viewcontractpreview').append(`
                    <div class="position-relative me-2 mb-2" id="img-${id}" data-file="${img}">
                        <img src="../uploads/rentvehicleImages/${img}" 
                             class="rounded border vehicle-preview-img" 
                             data-id="${id}" 
                             data-file="${img}" 
                             style="width:80px;height:80px;object-fit:cover;cursor:pointer;">
                    </div>
                `);
            });
        }

        // Vehicle Return Images
        $('#viewcontractreturnpreview').empty();  
        let existingVehicleImagesReturn = [];
        try { existingVehicleImagesReturn = JSON.parse(contract.vehicle_return_images || '[]'); } catch(e) {}
        if (Array.isArray(existingVehicleImagesReturn)) {
            existingVehicleImagesReturn.forEach(img => {
                let id = 'db_' + Math.random().toString(36).substr(2, 9);
                $('#viewcontractreturnpreview').append(`
                    <div class="position-relative me-2 mb-2" id="img-${id}" data-file="${img}">
                        <img src="../uploads/returntvehicleImages/${img}" 
                             class="rounded border vehicle-preview-img" 
                             data-id="${id}" 
                             data-file="${img}" 
                             style="width:80px;height:80px;object-fit:cover;cursor:pointer;">
                    </div>
                `);
            });
        }

        // Load Extension History Table
        listExtendedListviewcontract(data.contract.ids);
    }

    // Extension Table inside modal
    function listExtendedListviewcontract(agreement_ids) {
        if ($.fn.DataTable.isDataTable('#contractviewcontractTable')) {
            $('#contractviewcontractTable').DataTable().destroy();
            $('#contractviewcontractTable tbody').empty();
        }

        viewcontractextensiontable = $('#contractviewcontractTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: '/ContractListController',
                type: 'POST',
                contentType: 'application/json',
                data: function () {
                    return JSON.stringify({
                        action: 'ListContractExtensionsReturn',
                        agreementid: agreement_ids,
                        vehicleid: $('#viewcontract_hid_vehicle_id').val()
                    });
                },
                dataSrc: function (json) {
                    return json.data || [];
                }
            },
            dom: 't',
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'extension_date_format' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<div><strong><small>${row.from_date_format || ''} - ${row.to_date_format || ''}</small></strong></div>`;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<div><strong>${row.service_name || ''}</strong><br><small>${row.rate_type || ''}</small><small>, Duration: ${row.duration || ''}</small><br><small>Min Price: ${row.min_price || ''}</small>, Qtn Ref: ${row.qtn_ref_no || ''}</div>`;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<div><strong>Total: ${row.total_amt || ''}</strong><br><small>Unit Price: ${row.unit_price || ''}</small><small>, Duration: ${row.duration || ''}</small><br><small>${row.otp_details || ''}</small></div>`;
                    }
                },
                { data: 'booking_notes' }
            ]
        });
    }

    // Helper for Document Preview icons
    function getDocumentPreview(fileUrl) {
        if (!fileUrl) return '/assets/icons/file.png';
        let extension = fileUrl.split('.').pop().toLowerCase();
        switch (extension) {
            case 'pdf':
                return '/assets/icons/pdf.png';
            case 'doc':
            case 'docx':
                return '/assets/icons/word.png';
            case 'xls':
            case 'xlsx':
                return '/assets/icons/excel.png';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'webp':
                return fileUrl;
            default:
                return '/assets/icons/file.png';
        }
    }

    // CSV Export
    function exportToCSV() {
        if (!reportDataCache || reportDataCache.length === 0) {
            alert('No data to export.');
            return;
        }

        let headers = [
            "#",
            "Company",
            "Agreement No",
            "Agreement Date",
            "Status",
            "Customer Name",
            "Customer Code",
            "Mobile",
            "CPR/CR",
            "Vehicle No",
            "Vehicle Model",
            "Category",
            "Contract From",
            "Contract To",
            "Initial Days",
            "Extended",
            "Extension Count",
            "Extension Period",
            "Extension Days",
            "Expected Return Date",
            "Date of Return",
            "Overdue Status",
            "Overdue Days",
            "Daily Unit Rate (BHD)",
            "Contract Amount (BHD)",
            "Extension Amount (BHD)",
            "Total Agreed Amount (BHD)",
            "Overdue Extra Amount (BHD)",
            "Grand Total Amount (BHD)"
        ];

        let csvRows = [];
        csvRows.push(headers.map(h => `"${h}"`).join(','));

        reportDataCache.forEach((row, i) => {
            let rowVals = [
                i + 1,
                row.company_name,
                row.agreement_no,
                row.agreement_date,
                row.agreement_status,
                row.customer_name,
                row.customer_code,
                row.customer_mobile,
                row.customer_cpr,
                row.vehicle_no,
                row.vehicle_model,
                row.vehicle_category,
                row.contract_period_from,
                row.contract_period_to,
                row.contract_duration_days,
                row.is_extended,
                row.extension_count,
                row.extension_period,
                row.extension_total_days,
                row.expected_return_date,
                row.actual_return_date,
                row.overdue_status_label,
                row.overdue_days,
                row.daily_rate,
                row.contract_amount,
                row.extension_amount,
                row.total_agreed_amount,
                row.extra_overdue_amount,
                row.grand_total_amount
            ];

            let cleanRow = rowVals.map(v => {
                let s = (v !== null && v !== undefined) ? String(v).replace(/"/g, '""') : '';
                return `"${s}"`;
            });
            csvRows.push(cleanRow.join(','));
        });

        let csvString = csvRows.join('\r\n');
        let blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
        let url = URL.createObjectURL(blob);
        let link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", `Contract_Overdue_Report_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    </script>
</body>
</html>
