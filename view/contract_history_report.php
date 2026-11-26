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
    
    <!-- RemixIcon WebFont CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" />
    
    <!-- DataTables & Select2 CSS -->
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    <style>
        .ri {
            display: inline-block;
            width: 1em;
            height: 1em;
            line-height: 1;
            vertical-align: -0.125em;
        }

        /* KPI Metric Cards matching ContractReturnOverdueReport */
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
            background: linear-gradient(135deg, #f4f7fe 0%, #ffffff 100%);
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

        /* Standard Report DataTable Look and Feel */
        #tbl_contract_history {
            font-size: 12.5px;
        }
        #tbl_contract_history > thead > tr > th,
        table.dataTable thead th,
        .table thead th {
            background-color: #eef3fc !important;
            color: #1b3d94 !important;
            border-bottom: 2px solid #1b3d94 !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            font-size: 0.78rem !important;
            letter-spacing: 0.5px;
            white-space: nowrap;
            vertical-align: middle;
            padding: 8px 10px;
        }
        #tbl_contract_history tbody tr:hover {
            background-color: #fff9f9 !important;
        }

        .custom-modal-header {
            background: linear-gradient(135deg, #1b3d94, #153075) !important;
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
        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            background: linear-gradient(135deg, #1b3d94, #153075) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(27, 61, 148, 0.3);
        }
        .nav-pills .nav-link {
            color: #475569;
            transition: all 0.2s ease;
        }
        .nav-pills .nav-link:hover:not(.active) {
            background-color: #f8fafc;
            color: #1b3d94;
        }
        .btn-primary {
            background-color: #1b3d94 !important;
            border-color: #1b3d94 !important;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #153075 !important;
            border-color: #153075 !important;
        }
        .btn-outline-primary {
            color: #1b3d94 !important;
            border-color: #1b3d94 !important;
        }
        .btn-outline-primary:hover {
            background-color: #1b3d94 !important;
            color: #ffffff !important;
        }
        .text-primary {
            color: #1b3d94 !important;
        }
        .bg-primary {
            background-color: #1b3d94 !important;
        }
        .vehicle-history-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .vehicle-history-card.active-vehicle { background: #f0fdf4; border-color: #86efac; }
        .sign-preview-img { max-height: 80px; max-width: 220px; border: 1px solid #cbd5e1; border-radius: 6px; padding: 3px; background: #fff; }
        .gallery-img-thumb { width: 85px; height: 85px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1; transition: transform 0.2s ease; }
        .gallery-img-thumb:hover { transform: scale(1.08); }
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
                        
                        <!-- Top Title & Action Bar matching ContractReturnOverdueReport -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2 no-print">
                            <div>
                                <h4 class="fw-bold mb-1">
                                    <i class="ri ri-history-line text-danger me-2"></i>Contract & Vehicle Replacement History Report
                                </h4>
                                <p class="text-muted mb-0">
                                    Search and audit complete contract history, vehicle replacements, images, staff signatures, and financial ledgers at a glance.
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="btn_export_excel" class="btn btn-outline-success btn-sm">
                                    <i class="ri ri-file-excel-2-line me-1"></i> Export to Excel
                                </button>
                            </div>
                        </div>

                        <!-- Summary KPI Metrics Cards matching ContractReturnOverdueReport -->
                        <div class="row g-3 mb-4 no-print" id="kpiContainer">
                            <!-- Total Contracts -->
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-blue h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Total Contracts</span>
                                        <div class="kpi-icon-box bg-primary">
                                            <i class="ri ri-file-list-3-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0" id="kpi_total_contracts">0</h3>
                                    <span class="text-muted small">All matching records</span>
                                </div>
                            </div>

                            <!-- Active Rentout -->
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-green h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Active Rentout</span>
                                        <div class="kpi-icon-box bg-success">
                                            <i class="ri ri-car-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-success" id="kpi_total_active">0</h3>
                                    <span class="text-muted small">Currently active</span>
                                </div>
                            </div>

                            <!-- Extended Contracts -->
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-purple h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Extended</span>
                                        <div class="kpi-icon-box" style="background-color: #8b5cf6;">
                                            <i class="ri ri-repeat-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0" id="kpi_total_extended">0</h3>
                                    <span class="text-muted small">Extended periods</span>
                                </div>
                            </div>

                            <!-- Vehicle Replacements -->
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-amber h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Vehicle Replacements</span>
                                        <div class="kpi-icon-box bg-warning">
                                            <i class="ri ri-arrow-left-right-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-warning" id="kpi_total_replacements">0</h3>
                                    <span class="text-muted small">Audit events recorded</span>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Options Card -->
                        <div class="card mb-4 border shadow-sm">
                            <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-dark"><i class="ri ri-filter-3-line text-danger me-1"></i> Filter Contracts</h6>
                            </div>
                            <div class="card-body mt-3">
                                <div class="row g-3">
                                    <!-- Company Filter -->
                                    <div class="col-12 col-md-3">
                                        <label class="form-label fw-semibold" for="filter_company">
                                            <i class="ri ri-building-line text-danger me-1"></i>Company
                                        </label>
                                        <select id="filter_company" class="form-select select2" style="width:100%">
                                            <?php if ($hasMultipleCompanies): ?>
                                                <option value="all" <?= ($defaultCompanyValue === 'all') ? 'selected' : '' ?>>All Companies</option>
                                            <?php endif; ?>
                                            <?php foreach ($allowedCompanies as $comp): ?>
                                                <option value="<?= htmlspecialchars($comp['ids']) ?>" <?= (strval($defaultCompanyValue) === strval($comp['ids'])) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($comp['company_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Customer Autocomplete Filter -->
                                    <div class="col-12 col-md-4">
                                        <label class="form-label fw-semibold" for="selectCustomerFromSelect2">Customer Name / Mobile / CPR</label>
                                        <select id="selectCustomerFromSelect2" class="form-select select2" style="width:100%"></select>
                                        <input type="hidden" id="filter_customer_code">
                                    </div>

                                    <!-- Vehicle Autocomplete Filter -->
                                    <div class="col-12 col-md-3">
                                        <label class="form-label fw-semibold" for="selectVehicleFromSelect2">Vehicle Number / Model</label>
                                        <select id="selectVehicleFromSelect2" class="form-select select2" style="width:100%"></select>
                                        <input type="hidden" id="filter_vehicle_id">
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="col-12 col-md-2 d-flex align-items-end gap-2">
                                        <button type="button" id="btn_search_history" class="btn btn-primary btn-sm px-3 w-100">
                                            <i class="ri ri-search-line me-1"></i> Search
                                        </button>
                                        <button type="button" id="btn_reset_history" class="btn btn-outline-secondary btn-icon" title="Reset Filters">
                                            <i class="ri ri-refresh-line fs-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contract Search Results Table Card -->
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-bordered" id="tbl_contract_history" style="width:100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="4%" class="text-center">#</th>
                                                <th width="18%">Contract Details</th>
                                                <th width="24%">Vehicle Details</th>
                                                <th width="20%">Customer Details</th>
                                                <th width="14%">Contract Period</th>
                                                <th width="14%">Replacements</th>
                                                <th width="6%" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic Rows -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- FULL CONTRACT HISTORY DETAILS & AUDIT MODAL -->
    <div class="modal fade" id="modal_contract_full_history" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-extra-large" style="max-width: 95vw; width: 95vw; margin: 1.25rem auto;">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header custom-modal-header py-3 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3 bg-white bg-opacity-25 text-white">
                            <i class="ri-file-search-line fs-3"></i>
                        </div>
                        <div>
                            <h5 class="modal-title text-white fw-bold mb-0" id="historyModalTitle">Contract Audit & Comprehensive History</h5>
                            <small class="text-white-50">Complete vehicle lifecycle, replacements, extensions, signatures, and financial ledger</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    
                    <!-- Top KPI Summary Cards Banner -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm h-100 bg-white p-3 border-start border-primary border-4 rounded-3">
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.75rem;">Agreement Ref</small>
                                <div class="fs-5 fw-bold text-dark mt-1" id="modal_agreement_no_display">AGR-XXXXXX</div>
                                <div class="mt-1" id="modal_agreement_status_display"><span class="badge bg-success">Rentout</span></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm h-100 bg-white p-3 border-start border-info border-4 rounded-3">
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.75rem;">Customer Details</small>
                                <div class="fw-bold text-dark text-truncate mt-1 fs-6" id="modal_kpi_cust_name">-</div>
                                <small class="text-muted" id="modal_kpi_cust_code">Code: -</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm h-100 bg-white p-3 border-start border-warning border-4 rounded-3">
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.75rem;">Vehicle Replacements</small>
                                <div class="fs-5 fw-bold text-dark mt-1" id="modal_kpi_replacements">0</div>
                                <small class="text-muted" id="modal_kpi_veh_no">Current Veh: -</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm h-100 bg-white p-3 border-start border-danger border-4 rounded-3">
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.75rem;">Net Outstanding Balance</small>
                                <div class="fs-5 fw-bold text-danger mt-1" id="modal_kpi_balance">0.000 BHD</div>
                                <div class="mt-1">
                                    <a href="#" target="_blank" id="btn_export_contract_pdf" class="btn btn-danger btn-xs py-1 px-2 text-white">
                                        <i class="ri-file-pdf-line me-1"></i> Export PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <ul class="nav nav-pills nav-fill mb-3 bg-white p-2 rounded-3 shadow-sm border" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold py-2" data-bs-toggle="tab" data-bs-target="#tab_overview" type="button">
                                <i class="ri-user-3-line me-1"></i> Overview & Customer
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold py-2" data-bs-toggle="tab" data-bs-target="#tab_vehicles_timeline" type="button">
                                <i class="ri-history-line me-1"></i> Vehicle History & Replacements <span class="badge bg-warning text-dark ms-1" id="tab_badge_replacements">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold py-2" data-bs-toggle="tab" data-bs-target="#tab_bookings" type="button">
                                <i class="ri-calendar-event-line me-1"></i> Bookings & Renewals <span class="badge bg-secondary ms-1" id="tab_badge_bookings">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold py-2" data-bs-toggle="tab" data-bs-target="#tab_ledger" type="button">
                                <i class="ri-money-dollar-circle-line me-1"></i> Financial Ledger
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold py-2" data-bs-toggle="tab" data-bs-target="#tab_signatures" type="button">
                                <i class="ri-quill-pen-line me-1"></i> Signatures & Audit Log
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- TAB 1: OVERVIEW & CUSTOMER -->
                        <div class="tab-pane fade show active" id="tab_overview">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm rounded-3">
                                        <div class="card-header bg-white border-bottom fw-bold text-primary py-3">
                                            <i class="ri-user-line me-2 fs-5"></i> Customer Profile Information
                                        </div>
                                        <div class="card-body pt-3">
                                            <table class="table table-sm table-hover table-borderless mb-0">
                                                <tr><th width="35%" class="text-muted">Full Name:</th><td id="m_cust_name" class="fw-bold text-dark fs-6">-</td></tr>
                                                <tr><th class="text-muted">Customer Code:</th><td id="m_cust_code" class="fw-bold text-primary">-</td></tr>
                                                <tr><th class="text-muted">Mobile / Contact:</th><td id="m_cust_contact" class="fw-bold">-</td></tr>
                                                <tr><th class="text-muted">CPR / CR / Passport:</th><td id="m_cust_cpr" class="fw-bold">-</td></tr>
                                                <tr><th class="text-muted">Email Address:</th><td id="m_cust_email">-</td></tr>
                                                <tr><th class="text-muted">Physical Address:</th><td id="m_cust_address">-</td></tr>
                                                <tr><th class="text-muted">Nationality:</th><td id="m_cust_country">-</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm rounded-3">
                                        <div class="card-header bg-white border-bottom fw-bold text-primary py-3">
                                            <i class="ri-file-list-3-line me-2 fs-5"></i> Contract Main Details
                                        </div>
                                        <div class="card-body pt-3">
                                            <table class="table table-sm table-hover table-borderless mb-0">
                                                <tr><th width="35%" class="text-muted">Agreement No:</th><td id="m_agr_no" class="fw-bold text-primary fs-6">-</td></tr>
                                                <tr><th class="text-muted">Agreement Date:</th><td id="m_agr_date" class="fw-bold">-</td></tr>
                                                <tr><th class="text-muted">Quotation / Booking Ref:</th><td id="m_quot_no">-</td></tr>
                                                <tr><th class="text-muted">Service Type:</th><td id="m_service_type">-</td></tr>
                                                <tr><th class="text-muted">Rental Rate / Charges:</th><td id="m_rental_rate" class="fw-bold text-success">-</td></tr>
                                                <tr><th class="text-muted">Agreement Status:</th><td id="m_status_badge">-</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: VEHICLE HISTORY & REPLACEMENTS -->
                        <div class="tab-pane fade" id="tab_vehicles_timeline">
                            <div id="container_vehicle_timeline">
                                <!-- Dynamic vehicle timeline blocks -->
                            </div>
                        </div>

                        <!-- TAB 3: BOOKINGS & RENEWALS -->
                        <div class="tab-pane fade" id="tab_bookings">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered align-middle mb-0" id="tbl_modal_bookings">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="5%" class="text-center">#</th>
                                                    <th width="14%" class="text-center">Type Tag</th>
                                                    <th width="16%">Ref / Record Date</th>
                                                    <th width="16%">Start Date</th>
                                                    <th width="16%">End / Return Date</th>
                                                    <th>Notes / Booking & Renewal Details</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_modal_bookings">
                                                <!-- Dynamic Bookings & Extensions Entries -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: CONTRACT FINANCIAL LEDGER -->
                        <div class="tab-pane fade" id="tab_ledger">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover table-bordered align-middle mb-0" id="tbl_modal_ledger">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="5%" class="text-center">#</th>
                                                    <th width="15%">Date</th>
                                                    <th width="15%">Type</th>
                                                    <th>Description</th>
                                                    <th width="15%" class="text-end">Debit (BHD)</th>
                                                    <th width="15%" class="text-end">Credit (BHD)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_modal_ledger">
                                                <!-- Dynamic ledger entries -->
                                            </tbody>
                                            <tfoot class="table-light fw-bold">
                                                <tr>
                                                    <td colspan="4" class="text-end">Total Debits / Credits:</td>
                                                    <td class="text-end text-danger fs-6" id="m_tot_debit">0.000 BHD</td>
                                                    <td class="text-end text-success fs-6" id="m_tot_credit">0.000 BHD</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-end fs-6">Net Outstanding Balance:</td>
                                                    <td colspan="2" class="text-end fs-5 fw-bolder" id="m_net_balance">0.000 BHD</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: SIGNATURES & STAFF LOG -->
                        <div class="tab-pane fade" id="tab_signatures">
                            <div class="row g-3" id="container_signatures_gallery">
                                <!-- Dynamic Signatures -->
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-white border-top py-3 px-4">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i> Close Audit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contract Details Modal (Identical to VehicleContractList) -->
    <?php include ROOT_PATH . '/view/templates/VehicleContractList/view_contract_details_modal.php'; ?>
    <?php include ROOT_PATH . '/view/templates/VehicleContractList/vehicle_image_preview_modal.php'; ?>
    <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>

    <div id="dropdownContent" style="text-align:center;"></div>
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/quill.js"></script>
    <script src="../httpdocs/user_js/car_survey_widget.js?v=<?= time() ?>"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>

    <script>
    let historyTable = null;
    let historyDataCache = [];
    const defaultCompanyVal = "<?= $defaultCompanyValue ?>";

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

    function formatDisplayDate(dateStr) {
        if (!dateStr || dateStr === '-' || dateStr === 'N/A' || dateStr === '0000-00-00' || dateStr === '0000-00-00 00:00:00') {
            return '-';
        }
        let str = String(dateStr).trim();
        let parts = str.split(' ');
        let datePart = parts[0];
        let timePart = parts[1] ? ' ' + parts[1] : '';

        if (datePart.includes('-')) {
            let p = datePart.split('-');
            if (p.length === 3) {
                if (p[0].length === 4) { // YYYY-MM-DD
                    return `${p[2].padStart(2, '0')}-${p[1].padStart(2, '0')}-${p[0]}${timePart}`;
                } else if (p[2].length === 4) { // DD-MM-YYYY
                    return `${p[0].padStart(2, '0')}-${p[1].padStart(2, '0')}-${p[2]}${timePart}`;
                }
            }
        } else if (datePart.includes('/')) {
            let p = datePart.split('/');
            if (p.length === 3) {
                if (p[0].length === 4) { // YYYY/MM/DD
                    return `${p[2].padStart(2, '0')}-${p[1].padStart(2, '0')}-${p[0]}${timePart}`;
                } else if (p[2].length === 4) { // DD/MM/YYYY
                    return `${p[0].padStart(2, '0')}-${p[1].padStart(2, '0')}-${p[2]}${timePart}`;
                }
            }
        }

        let d = new Date(str);
        if (!isNaN(d.getTime())) {
            let day = String(d.getDate()).padStart(2, '0');
            let month = String(d.getMonth() + 1).padStart(2, '0');
            let year = d.getFullYear();
            return `${day}-${month}-${year}${timePart}`;
        }
        return str;
    }

    $(document).ready(function() {
        // Initialize Company Dropdown Select2
        if ($('#filter_company').length) {
            $('#filter_company').select2({
                minimumResultsForSearch: 10
            });
        }

        // Initialize Customer Select2 Autocomplete
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

        // Initialize Vehicle Select2 Autocomplete
        $('#selectVehicleFromSelect2').select2({
            placeholder: 'Search Vehicle by Vehicle Number or Model',
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: '/SearchVehicleDetails',
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return { q: params.term, action: 'SearchVehicle' };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.vehicle_number + ' - ' + (item.model_names || item.model_name || ''),
                            vehicle_id: item.id,
                            vehicle_number: item.vehicle_number
                        }))
                    };
                }
            }
        });

        $('#selectVehicleFromSelect2').on('select2:select', function (e) {
            $('#filter_vehicle_id').val(e.params.data.vehicle_id);
        }).on('select2:clear', function () {
            $('#filter_vehicle_id').val('');
        });

        // Initialize Results DataTable
        historyTable = $('#tbl_contract_history').DataTable({
            data: [],
            pageLength: 25,
            searching: true,
            ordering: false,
            columns: [
                { data: null, className: 'text-center', render: (d, t, r, m) => m.row + 1 },
                { 
                    data: 'agreement_no', 
                    render: (d, t, r) => {
                        if (t === 'filter' || t === 'sort') {
                            return `${d || ''} ${r.company_name || ''} ${r.booking_no || 'Direct Contract'} ${r.agreement_status || ''}`;
                        }
                        let compBadge = (r.company_name && r.company_name !== 'N/A')
                            ? `<span class="badge bg-label-danger">${escapeHtml(r.company_name)}</span>`
                            : '';
                        let statusStr = (r.agreement_status || '').trim() || 'Rentout';
                        let statusBadge = (typeof window.getContractStatusBadgeHtml === 'function')
                            ? window.getContractStatusBadgeHtml(statusStr)
                            : `<span class="badge bg-secondary">${escapeHtml(statusStr)}</span>`;
                        let sourceText = r.booking_no ? `Booking: ${escapeHtml(r.booking_no)}` : 'Direct Contract';
                        let sourceBadge = `<span class="badge bg-label-secondary">${sourceText}</span>`;

                        return `
                            <div class="d-flex flex-column gap-1">
                                <div><a href="javascript:void(0)" class="fw-bold text-primary btn-view-full-history" data-id="${r.ids}" title="Click to view full history & audit">${escapeHtml(d)} <i class="ri ri-external-link-line ms-1 small"></i></a></div>
                                <div class="d-flex flex-wrap align-items-center gap-1">
                                    ${compBadge}
                                    <span class="status-cell">${statusBadge}</span>
                                </div>
                                <div>${sourceBadge}</div>
                            </div>
                        `;
                    } 
                },
                { 
                    data: null,
                    render: (d, t, r) => {
                        if (t === 'filter' || t === 'sort') {
                            return `${r.vehicle_no || ''} ${r.brand_name || ''} ${r.model_name || ''} ${r.category_name || ''} ${r.chassis_number || ''} ${r.vehicle_year || ''} ${r.vehicle_color || ''}`;
                        }
                        const brandModel = [r.brand_name, r.model_name].filter(Boolean).join(' - ') || '-';
                        const vStatus = r.vehicle_status
                            ? (typeof window.getVehicleStatusBadgeHtml === 'function' ? window.getVehicleStatusBadgeHtml(r.vehicle_status) : `<span class="badge bg-label-info">${escapeHtml(r.vehicle_status)}</span>`)
                            : '';
                        let badges = '';
                        if (r.category_name) badges += `<span class="badge bg-label-primary me-1 mb-1">${escapeHtml(r.category_name)}</span>`;
                        if (r.vehicle_year) badges += `<span class="badge bg-label-info me-1 mb-1"><i class="ri-calendar-line me-1"></i>${escapeHtml(r.vehicle_year)}</span>`;
                        if (r.vehicle_color) badges += `<span class="badge me-1 mb-1" style="background-color:#fef3c7;color:#92400e;"><span class="d-inline-block rounded-circle me-1 border" style="width:8px;height:8px;background-color:${escapeHtml(r.vehicle_color)};"></span>${escapeHtml(r.vehicle_color)}</span>`;
                        if (r.fuel_type) badges += `<span class="badge bg-label-success me-1 mb-1"><i class="ri-gas-station-line me-1"></i>${escapeHtml(r.fuel_type)}</span>`;
                        if (r.gear_type) badges += `<span class="badge me-1 mb-1" style="background-color:#ede9fe;color:#6d28d9;"><i class="ri-settings-4-line me-1"></i>${escapeHtml(r.gear_type)}</span>`;
                        let chassisHtml = r.chassis_number ? `<small class="text-muted"><i class="ri-barcode-line me-1"></i>Chassis: <strong>${escapeHtml(r.chassis_number)}</strong></small>` : '';

                        return `
                            <div class="d-flex flex-column gap-1">
                                <div class="d-flex flex-wrap align-items-center gap-1">
                                    <span class="fw-bold text-dark">${escapeHtml(r.vehicle_no || '-')}</span>
                                    <span class="text-muted fw-semibold">${escapeHtml(brandModel)}</span>
                                    ${vStatus}
                                </div>
                                <div class="d-flex flex-wrap align-items-center">${badges}</div>
                                ${chassisHtml}
                            </div>
                        `;
                    }
                },
                { 
                    data: 'customer_name', 
                    render: (d, t, r) => {
                        if (t === 'filter' || t === 'sort') {
                            return `${r.customer_name || ''} ${r.customer_code || ''} ${r.mobile_number || ''} ${r.cpr_no || ''} ${r.customer_email || ''}`;
                        }
                        let meta = [];
                        if (r.mobile_number && r.mobile_number !== '-') meta.push(`<i class="ri-phone-line me-1"></i>${escapeHtml(r.mobile_number)}`);
                        if (r.cpr_no) meta.push(`<i class="ri-id-card-line me-1"></i>${escapeHtml(r.cpr_no)}`);
                        if (r.customer_nationality) meta.push(`<i class="ri-global-line me-1"></i>${escapeHtml(r.customer_nationality)}`);
                        let emailLine = r.customer_email ? `<small class="text-muted d-block text-truncate" style="max-width:200px;"><i class="ri-mail-line me-1"></i>${escapeHtml(r.customer_email)}</small>` : '';
                        return `
                            <div class="d-flex flex-column gap-1">
                                <div class="d-flex flex-wrap align-items-center gap-1">
                                    <strong class="text-dark">${escapeHtml(d || 'N/A')}</strong>
                                    ${r.customer_code ? `<span class="badge bg-label-secondary">${escapeHtml(r.customer_code)}</span>` : ''}
                                </div>
                                <small class="text-muted d-flex flex-wrap gap-2">${meta.join(' ')}</small>
                                ${emailLine}
                            </div>
                        `;
                    } 
                },
                { 
                    data: null,
                    render: (d, t, r) => `
                        <div class="d-flex flex-column gap-1 small">
                            <div><span class="text-muted fw-semibold">From:</span> <strong class="text-dark">${escapeHtml(r.from_date_format || formatDisplayDate(r.agreement_date))}</strong></div>
                            <div><span class="text-muted fw-semibold">To:</span> <strong class="text-dark">${escapeHtml(r.to_date_format || '-')}</strong></div>
                        </div>
                    `
                },
                { 
                    data: 'replacement_count', 
                    render: (d, t, r) => {
                        let count = parseInt(d) || 0;
                        if (count === 0) {
                            return '<span class="badge bg-label-secondary">0 Replacements</span>';
                        }
                        let list = Array.isArray(r.replaced_summary) ? r.replaced_summary : [];
                        let itemsHtml = list.map(rep => `<div class="small text-muted text-nowrap mt-1"><i class="ri-arrow-right-line text-warning me-1"></i><strong>${escapeHtml(rep.old_veh)}</strong> → <strong>${escapeHtml(rep.new_veh)}</strong> <span class="text-muted">(${formatDisplayDate(rep.replaced_on)})</span></div>`).join('');
                        return `<div><span class="badge bg-warning text-dark"><i class="ri-repeat-line me-1"></i>${count} Replacement${count > 1 ? 's' : ''}</span>${itemsHtml}</div>`;
                    }
                },
                {
                    data: 'ids',
                    className: 'text-center',
                    render: (d, t, r) => `
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-primary btn-view-contract-modal" data-id="${r.ids}" data-vehicle="${r.vehicle_id || ''}" data-customer="${escapeHtml(r.customer_code || '')}" data-model="${r.model_id || ''}" title="View Contract Details"><i class="ri ri-eye-line fs-5"></i></button>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-info btn-view-full-history" data-id="${r.ids}" title="View Audit & Replacement History"><i class="ri ri-history-line fs-5"></i></button>
                        </div>
                    `
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Instant filter contracts...",
                emptyTable: "No contracts matching selected filter criteria."
            }
        });

        // Initial Load
        loadContractHistory();

        // Company Filter Change Event
        $('#filter_company').on('change', function() {
            loadContractHistory();
        });

        $('#btn_search_history').click(function() {
            loadContractHistory();
        });

        $('#btn_reset_history').click(function() {
            $('#filter_company').val(defaultCompanyVal).trigger('change.select2');
            $('#selectCustomerFromSelect2').val(null).trigger('change');
            $('#selectVehicleFromSelect2').val(null).trigger('change');
            $('#filter_customer_code').val('');
            $('#filter_vehicle_id').val('');
            loadContractHistory();
        });

        $('#btn_export_excel').click(function() {
            exportHistoryToCSV();
        });

        $(document).on('click', '.btn-view-contract-modal', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const vid = $(this).data('vehicle');
            const ccode = $(this).data('customer');
            const mid = $(this).data('model');
            if (id) {
                openviewcontractModal(id, vid, ccode, mid);
            }
        });

        $(document).on('click', '.btn-view-full-history', function(e) {
            e.preventDefault();
            let agreementId = $(this).attr('data-id') || $(this).closest('.btn-view-full-history').attr('data-id');
            if (agreementId) {
                openContractHistoryModal(agreementId);
            }
        });
    });

    function updateKPIs(data) {
        let totalContracts = data.length;
        let totalActive = data.filter(r => (r.agreement_status || '').trim() === 'Rentout').length;
        let totalExtended = data.filter(r => (r.agreement_status || '').trim() === 'Extended').length;
        let totalReplacements = data.reduce((acc, r) => acc + (parseInt(r.replacement_count) || 0), 0);

        $('#kpi_total_contracts').text(totalContracts);
        $('#kpi_total_active').text(totalActive);
        $('#kpi_total_extended').text(totalExtended);
        $('#kpi_total_replacements').text(totalReplacements);
    }

    function exportHistoryToCSV() {
        if (!historyDataCache || historyDataCache.length === 0) {
            alert('No contract history records to export.');
            return;
        }

        let headers = [
            "#",
            "Company",
            "Agreement No",
            "Agreement Date",
            "Agreement Status",
            "Customer Name",
            "Customer Code",
            "Mobile",
            "CPR/CR",
            "Vehicle Details",
            "Vehicle Replacements Count"
        ];

        let csvRows = [];
        csvRows.push(headers.map(h => `"${h}"`).join(','));

        historyDataCache.forEach((row, i) => {
            let rowVals = [
                i + 1,
                row.company_name || '',
                row.agreement_no || '',
                row.agreement_date || '',
                row.agreement_status || '',
                row.customer_name || '',
                row.customer_code || '',
                row.mobile_number || '',
                row.cpr_no || '',
                row.vehicle_summary || '',
                row.replacement_count || 0
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
        link.setAttribute("download", `Contract_History_Report_${new Date().toISOString().slice(0,10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function loadContractHistory() {
        let custCode = $('#filter_customer_code').val();
        let vehId = $('#filter_vehicle_id').val();
        let compId = $('#filter_company').val() || defaultCompanyVal;

        $.ajax({
            url: '/ContractHistoryController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'searchContracts',
                company_id: compId,
                customer_code: custCode,
                vehicle_id: vehId
            }),
            dataType: 'json',
            success: function(res) {
                if (res && res.status && Array.isArray(res.data)) {
                    historyDataCache = res.data;
                    historyTable.clear().rows.add(res.data).draw();
                    updateKPIs(res.data);
                } else {
                    historyDataCache = [];
                    historyTable.clear().draw();
                    updateKPIs([]);
                }
            },
            error: function() {
                historyDataCache = [];
                historyTable.clear().draw();
                updateKPIs([]);
            }
        });
    }

    function openContractHistoryModal(agreementId) {
        $.ajax({
            url: '/ContractHistoryController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'getContractFullDetails',
                agreement_id: agreementId
            }),
            dataType: 'json',
            success: function(res) {
                if (res && res.status) {
                    populateHistoryModal(res);
                    $('#modal_contract_full_history').modal('show');
                } else {
                    setupDropdown('dropdownContent', 'error', res.message || 'Failed to load details', 'click');
                }
            }
        });
    }

    function populateHistoryModal(res) {
        let contract = res.contract || {};
        let customer = res.customer || {};
        let currentVeh = res.current_vehicle || {};
        let replacedHistory = res.replaced_history || [];
        let extensions = res.extensions || [];
        let ledger = res.ledger || {};

        let custName = customer.customer_name || contract.customer_name || 'N/A';
        let custCode = contract.customer_code || customer.customer_code || 'N/A';

        // Top KPI Header Banner & Badges
        const modalStatusHtml = (typeof window.getContractStatusBadgeHtml === 'function')
            ? window.getContractStatusBadgeHtml(contract.agreement_status || 'Rentout')
            : `<span class="badge bg-success">${contract.agreement_status || 'Rentout'}</span>`;
        $('#modal_agreement_no_display').text(contract.agreement_no || 'N/A');
        $('#modal_agreement_status_display').html(modalStatusHtml);
        $('#btn_export_contract_pdf').attr('href', '/ContractHistoryExport?agreement_id=' + contract.ids);

        $('#modal_kpi_cust_name').text(custName);
        $('#modal_kpi_cust_code').text('Code: ' + custCode);
        $('#modal_kpi_replacements').text(replacedHistory.length);
        $('#tab_badge_replacements').text(replacedHistory.length);
        $('#modal_kpi_veh_no').text('Current Veh: ' + (contract.vehicle_no || 'N/A'));

        $('#tab_badge_extensions').text(extensions.length);

        // Overview Tab Data
        $('#m_cust_name').text(custName);
        $('#m_cust_code').text(custCode);
        $('#m_cust_contact').text(customer.mobile_number || 'N/A');
        $('#m_cust_cpr').text(customer.cpr_no || 'N/A');
        $('#m_cust_email').text(customer.customer_email || 'N/A');
        $('#m_cust_address').text(customer.customer_address || 'N/A');
        $('#m_cust_country').text(customer.country_name || 'N/A');

        $('#m_agr_no').text(contract.agreement_no || 'N/A');
        $('#m_agr_date').text(formatDisplayDate(contract.agreement_date));
        $('#m_quot_no').text(contract.quotation_number || 'N/A');
        $('#m_service_type').text(contract.service_type || 'N/A');
        $('#m_rental_rate').text(contract.rent_amount ? contract.rent_amount + ' BHD' : (contract.rental_rate ? contract.rental_rate + ' BHD' : 'N/A'));
        $('#m_status_badge').html(modalStatusHtml);

        // Vehicles & Replacement Timeline Tab
        let $timeline = $('#container_vehicle_timeline').empty();

        // 1. Current Vehicle Card
        let currentVehCard = `
            <div class="vehicle-history-card active-vehicle p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <h6 class="fw-bold text-success mb-0"><i class="ri-car-fill me-1"></i> Current Active Contract Vehicle</h6>
                    <span class="badge bg-success">Active Rentout</span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6 border-end">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><th width="35%">Vehicle Number:</th><td><strong class="fs-6 text-primary">${contract.vehicle_no || 'N/A'}</strong></td></tr>
                            <tr><th>Category:</th><td>${contract.category_name || '-'}</td></tr>
                            <tr><th>Model:</th><td>${contract.model_name || '-'}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><th width="35%">KM Out:</th><td>${contract.km_out || '0'} KM</td></tr>
                            <tr><th>Date Out:</th><td>${formatDisplayDate(contract.date_out || contract.starting_date)}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        `;
        $timeline.append(currentVehCard);

        // 2. Replaced Vehicles Timeline Cards
        if (replacedHistory.length > 0) {
            $timeline.append('<h6 class="fw-bold text-dark mt-4 mb-3"><i class="ri-history-line me-1"></i> Previous Replaced Vehicles History (' + replacedHistory.length + ')</h6>');
            replacedHistory.forEach((node, idx) => {
                let oldV = node.old_vehicle || {};
                let newV = node.new_vehicle || {};
                
                let retImgsHtml = '';
                if (Array.isArray(oldV.old_return_images) && oldV.old_return_images.length > 0) {
                    oldV.old_return_images.forEach(img => {
                        retImgsHtml += `<a href="../uploads/rentvehicleImages/${img}" target="_blank"><img src="../uploads/rentvehicleImages/${img}" class="gallery-img-thumb"></a>`;
                    });
                } else {
                    retImgsHtml = '<span class="text-muted fst-italic">No return images</span>';
                }

                let rentImgsHtml = '';
                if (Array.isArray(newV.new_rentout_images) && newV.new_rentout_images.length > 0) {
                    newV.new_rentout_images.forEach(img => {
                        rentImgsHtml += `<a href="../uploads/rentvehicleImages/${img}" target="_blank"><img src="../uploads/rentvehicleImages/${img}" class="gallery-img-thumb"></a>`;
                    });
                } else {
                    rentImgsHtml = '<span class="text-muted fst-italic">No rentout images</span>';
                }

                let staffSignHtml = node.staff_signature ? `<img src="${node.staff_signature}" class="sign-preview-img">` : '<span class="text-muted fst-italic">No signature</span>';

                let cardHtml = `
                    <div class="vehicle-history-card p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <h6 class="fw-bold text-dark mb-0">Replacement #${idx + 1} (Ref: ${node.replacement_id || ''})</h6>
                            <span class="badge bg-secondary">Replaced On: ${formatDisplayDate(node.replaced_on)}</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6 border-end">
                                <h6 class="fw-bold text-danger"><i class="ri-logout-box-r-line me-1"></i> Replaced Return Vehicle (Old)</h6>
                                <table class="table table-sm table-bordered bg-white">
                                    <tr><th width="35%">Vehicle Number:</th><td><strong>${oldV.vehicle_number || '-'}</strong> (${oldV.category_name || ''} ${oldV.model_name || ''})</td></tr>
                                    <tr><th>KM Out / IN / Used:</th><td>Out: ${oldV.km_out || 0} | In: ${oldV.km_in || 0} | Used: <strong>${oldV.km_used || 0} KM</strong></td></tr>
                                    <tr><th>Fuel Out / IN:</th><td>Out: ${oldV.fuel_level_out || 'N/A'} | In: <strong>${oldV.fuel_level_in || 'N/A'}</strong></td></tr>
                                    <tr><th>Date Out / IN:</th><td>${formatDisplayDate(oldV.dt_out)} to ${formatDisplayDate(oldV.dt_in)}</td></tr>
                                </table>
                                <div><strong>Return Images:</strong><div class="d-flex flex-wrap gap-1 mt-1">${retImgsHtml}</div></div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-success"><i class="ri-login-box-r-line me-1"></i> Replacement Vehicle Assigned (New)</h6>
                                <table class="table table-sm table-bordered bg-white">
                                    <tr><th width="35%">Vehicle Number:</th><td><strong>${newV.vehicle_number || '-'}</strong> (${newV.category_name || ''} ${newV.model_name || ''})</td></tr>
                                    <tr><th>KM Out (New):</th><td><strong>${newV.km_out || 0} KM</strong></td></tr>
                                    <tr><th>Fuel Level Out:</th><td><strong>${newV.fuel_level_out || 'N/A'}</strong></td></tr>
                                    <tr><th>Date Out (New):</th><td>${formatDisplayDate(newV.dt_out)}</td></tr>
                                </table>
                                <div><strong>Rentout Images:</strong><div class="d-flex flex-wrap gap-1 mt-1">${rentImgsHtml}</div></div>
                            </div>
                        </div>

                        <div class="mt-3 p-2 bg-white border rounded d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div><strong>Responsible Staff Name:</strong> ${node.staff_name || 'N/A'}</div>
                            <div><strong>Staff Signature:</strong> ${staffSignHtml}</div>
                        </div>
                    </div>
                `;
                $timeline.append(cardHtml);
            });
        }

        // Bookings & Renewals Tab Data
        let bookingsList = [];

        // 1. Initial Booking Record (from tbl_vehicle_rentout_contracts)
        let bookingStart = contract.date_out || contract.starting_date || contract.dt_out || contract.agreement_date || '-';
        let bookingEnd = contract.expected_return_date || contract.return_date || contract.dt_in || '-';
        let bookingNotes = [];
        if (contract.service_type) bookingNotes.push('Service: ' + contract.service_type);
        if (contract.quotation_number) bookingNotes.push('Quotation Ref: ' + contract.quotation_number);
        if (contract.remarks) bookingNotes.push(contract.remarks);
        let bookingDetails = bookingNotes.length > 0 ? bookingNotes.join(' | ') : 'Initial Rentout Booking';

        bookingsList.push({
            type_tag: '<span class="badge bg-primary px-2 py-1"><i class="ri-file-list-3-line me-1"></i>Booking</span>',
            record_date: formatDisplayDate(contract.agreement_date),
            start_date: formatDisplayDate(bookingStart),
            end_date: formatDisplayDate(bookingEnd),
            details: bookingDetails
        });

        // 2. Extension & Renewal Records (from tbl_vehicle_contract_extensions)
        extensions.forEach(ex => {
            bookingsList.push({
                type_tag: '<span class="badge bg-warning text-dark px-2 py-1"><i class="ri-history-line me-1"></i>Extension</span>',
                record_date: formatDisplayDate(ex.extension_date),
                start_date: formatDisplayDate(ex.extend_start_date),
                end_date: formatDisplayDate(ex.extend_end_date),
                details: ex.extend_details || ex.remarks || 'Contract Extension / Renewal'
            });
        });

        $('#tab_badge_bookings').text(bookingsList.length);

        let $tbodyBookings = $('#tbody_modal_bookings').empty();
        if (bookingsList.length === 0) {
            $tbodyBookings.append('<tr><td colspan="6" class="text-center text-muted fst-italic py-3">No bookings or extensions recorded</td></tr>');
        } else {
            bookingsList.forEach((b, i) => {
                $tbodyBookings.append(`
                    <tr>
                        <td class="text-center fw-bold">${i + 1}</td>
                        <td class="text-center">${b.type_tag}</td>
                        <td>${b.record_date}</td>
                        <td>${b.start_date}</td>
                        <td><strong class="text-primary">${b.end_date}</strong></td>
                        <td>${b.details}</td>
                    </tr>
                `);
            });
        }

        // Financial Ledger Tab Data
        let entries = ledger.entries || [];
        let $tbodyLedger = $('#tbody_modal_ledger').empty();
        if (entries.length === 0) {
            $tbodyLedger.append('<tr><td colspan="6" class="text-center text-muted fst-italic py-3">No financial ledger entries found for this contract</td></tr>');
        } else {
            entries.forEach((le, i) => {
                $tbodyLedger.append(`
                    <tr>
                        <td class="text-center">${i + 1}</td>
                        <td>${formatDisplayDate(le.trans_date)}</td>
                        <td><span class="badge bg-label-info">${le.trans_type || 'Entry'}</span></td>
                        <td>${le.description || ''}</td>
                        <td class="text-end text-danger fw-bold">${parseFloat(le.debit || 0).toFixed(3)}</td>
                        <td class="text-end text-success fw-bold">${parseFloat(le.credit || 0).toFixed(3)}</td>
                    </tr>
                `);
            });
        }
        $('#m_tot_debit').text(parseFloat(ledger.total_debit || 0).toFixed(3) + ' BHD');
        $('#m_tot_credit').text(parseFloat(ledger.total_credit || 0).toFixed(3) + ' BHD');
        let bal = parseFloat(ledger.balance || 0);
        let balStr = bal.toFixed(3) + ' BHD';
        $('#m_net_balance').text(balStr).removeClass('text-danger text-success').addClass(bal > 0 ? 'text-danger' : 'text-success');
        $('#modal_kpi_balance').text(balStr).removeClass('text-danger text-success').addClass(bal > 0 ? 'text-danger' : 'text-success');

        // Signatures & Audit Tab Data
        let $sigGallery = $('#container_signatures_gallery').empty();
        let hirerSig = contract.hirer_signature ? `<img src="${contract.hirer_signature}" class="sign-preview-img">` : '<span class="text-muted fst-italic">No signature available</span>';
        let delSig = contract.delivered_signature ? `<img src="${contract.delivered_signature}" class="sign-preview-img">` : '<span class="text-muted fst-italic">No signature available</span>';

        $sigGallery.append(`
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 rounded-3">
                    <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="ri-quill-pen-line me-1"></i> Hirer (Customer) Signature</h6>
                    <div class="mb-2">Hirer Name: <strong class="text-dark">${contract.hirer_name || custName}</strong></div>
                    <div class="mt-2 text-center p-2 bg-light rounded">${hirerSig}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-3 rounded-3">
                    <h6 class="fw-bold text-success border-bottom pb-2 mb-3"><i class="ri-user-received-line me-1"></i> Delivery Staff Signature</h6>
                    <div class="mb-2">Staff Name: <strong class="text-dark">${contract.delivered_signatory || contract.delivered_by || 'N/A'}</strong></div>
                    <div class="mt-2 text-center p-2 bg-light rounded">${delSig}</div>
                </div>
            </div>
        `);
    }

    let chrQuillEditor = null;
    function getChrQuill() {
        if (!chrQuillEditor && typeof Quill !== 'undefined' && document.getElementById('full-editor-onbody')) {
            chrQuillEditor = new Quill('#full-editor-onbody', { theme: 'snow', readOnly: true, modules: { toolbar: false } });
        }
        return chrQuillEditor;
    }

    function openviewcontractModal(id, vehicleid, customer_code, model_ids) {
        $.ajax({
            url: '/ContractListController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'GetContractDetails',
                agreementid: id,
                vehicleid: vehicleid || '',
                customer_code: customer_code || '',
                model_ids: model_ids || ''
            }),
            success: function (res) {
                populateviewContractModal(res);
                const modalEl = document.getElementById('viewcontractModal');
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.show();
            },
            error: function() {
                alert('Failed to load contract details.');
            }
        });
    }

    function populateviewContractModal(d) {
        let data = (typeof d === 'string') ? JSON.parse(d) : d;
        data = data || {};
        let customer = data.customer || {};
        let vehicle = data.vehicle || {};
        let contract = data.contract || {};

        $('#viewcontract_agreement_ref').text(contract.agreement_no || '');
        $('#txt_viewcontract_modal_agreement_id').val(contract.ids || '');
        $('#txt_viewcontract_modal_agreement_no').val(contract.agreement_no || '');
        $('#txt_viewcontract_modal_booking_ids').val(contract.booking_ids || '');

        $('#viewcontract_c_name').text(customer.customer_name || '');
        $('#viewcontract_c_code').text(customer.customer_id || '');
        $('#viewcontract_c_mobile').text(customer.customer_mobile || '');
        $('#viewcontract_c_email').text(customer.customer_email || '');
        $('#viewcontract_c_attn').text(customer.customer_attn || '');
        $('#viewcontract_c_attr').text(customer.customer_addr || '');

        $('#viewcontract_v_no').text(vehicle.vehicle_number || '');
        $('#viewcontract_v_model').text(vehicle.model_names || '');
        $('#viewcontract_v_brand').text(vehicle.brand_name || '');
        $('#viewcontract_v_category').text(vehicle.category_name || '');
        $('#viewcontract_v_color').text(vehicle.vehicle_color || '');
        $('#viewcontract_v_year').text(vehicle.vehicle_year || '');
        $('#viewcontract_v_passing').text(vehicle.formatted_next_passing_date || '');
        $('#viewcontract_hid_nxt_passing').val(vehicle.next_passing_date || '');
        $('#viewcontract_v_maintenance').text(vehicle.formatted_next_maintenance_date || '');
        $('#viewcontract_hid_nxt_maintenance').val(vehicle.next_maintenance_date || '');
        $('#viewcontract_v_insurance').text(vehicle.formatted_next_insurance_date || '');
        $('#viewcontract_hid_nxt_insurance').val(vehicle.next_insurance_date || '');

        $('#viewcontract_hid_vehicle_id').val(vehicle.ids || '');
        $('#viewcontract_hid_category_id').val(vehicle.category_id || '');
        $('#viewcontract_hid_model_id').val(vehicle.model_id || '');
        $('#viewcontract_hid_vehicle_no').val(vehicle.vehicle_number || '');

        if (Array.isArray(data.price_list)) {
            data.price_list.forEach(function(item) {
                const amt = parseFloat(item.amount || 0).toFixed(3);
                switch (item.item) {
                    case 'Price per hour rental without driver': $('#viewcontract_wod_hourly').text(amt); break;
                    case 'Price per hour rental with driver': $('#viewcontract_wd_hourly').text(amt); break;
                    case 'Price per day rental without driver': $('#viewcontract_wod_daily').text(amt); break;
                    case 'Price per day rental with driver': $('#viewcontract_wd_daily').text(amt); break;
                    case 'Price per week rental without driver': $('#viewcontract_wod_weekly').text(amt); break;
                    case 'Price per week rental with driver': $('#viewcontract_wd_weekly').text(amt); break;
                    case 'Price per month rental without driver': $('#viewcontract_wod_monthly').text(amt); break;
                    case 'Price per month rental with driver': $('#viewcontract_wd_monthly').text(amt); break;
                }
            });
        }

        let driverDetails = {};
        let acc = {};
        try { driverDetails = JSON.parse(contract.driver_details || '{}') || {}; } catch(e) {}
        try { acc = JSON.parse(contract.vehicle_accessories_details || '{}') || {}; } catch(e) {}

        $('#viewcontractchk_tools').prop('checked', acc.chk_tools === 'Yes');
        $('#viewcontractchk_spare').prop('checked', acc.chk_spare === 'Yes');
        $('#viewcontractchk_radio').prop('checked', acc.chk_radio === 'Yes');
        $('#viewcontractkm_out').val(acc.vehicle_km_out || contract.km_out || 0);
        $('#viewcontractkm_in').val(contract.km_in || 0);
        $('#viewcontractfuel_level').val(acc.fuel_level || '');
        $('#viewcontractdt_out').val(acc.date_out || '');
        $('#viewcontractdt_in').val(contract.return_date || '');
        $('#viewcontractdt_contract_date').val(contract.agreement_date || '');

        $('#viewcontractcust_driver').val(contract.customer_driver_name || '');
        $('#viewcontract_agreement_status').html(typeof window.getContractStatusBadgeHtml === 'function' ? window.getContractStatusBadgeHtml(contract.agreement_status) : (contract.agreement_status || ''));
        $('#viewcontractcust_driver_contact_no').val(contract.customer_driver_contact_number || '');
        $('.driverclass').show();

        $('#viewcontractd_name').text(driverDetails.driver_name === 'Select Driver' ? '' : (driverDetails.driver_name || ''));
        $('#viewcontractd_mobile').text(driverDetails.driver_mobile || '');
        $('#viewcontractd_license_no').text(driverDetails.driver_license_no || '');
        $('#viewcontractd_license_issue_place').text(driverDetails.driver_license_issplace || '');
        $('#viewcontractd_licenseissueDate').text(driverDetails.driver_license_expdate || '');
        $('#viewcontractd_licenseexpiryDate').text(driverDetails.driver_license_expdate || '');

        const q = getChrQuill();
        if (q && q.root) {
            q.root.innerHTML = contract.terms_condition || '';
        } else {
            $('#full-editor-onbody').html(contract.terms_condition || '');
        }

        const bindSig = (sig, imgSel, noSel, nameSel, nameVal, dateSel, dateVal, emptyTxt) => {
            if (sig && sig.trim() !== '') {
                $(imgSel).attr('src', sig).show();
                $(noSel).hide();
            } else {
                $(imgSel).hide();
                $(noSel).show().text(emptyTxt);
            }
            $(nameSel).text(nameVal || '-');
            $(dateSel).text(dateVal || '-');
        };
        bindSig(contract.hirer_signature, '#latest_hirer_signature', '#no_hirer_signature', '#latest_hirer_name', contract.hirer_name, '#latest_hirer_date', contract.hirer_signature_date, 'No Hirer Signature Applied');
        bindSig(contract.delivered_signature, '#latest_delivery_signature', '#no_delivery_signature', '#latest_delivery_name', contract.delivered_signatory || contract.delivered_by, '#latest_delivery_date', contract.delivered_signature_date, 'No Delivered Signature Applied');
        bindSig(contract.receiver_signature, '#latest_receiver_signature', '#no_receiver_signature', '#latest_receiver_name', contract.receiver_name, '#latest_receiver_date', contract.receiver_signature_datetime, 'No Receiver Signature Applied');

        $('#viewcontractpreview').empty();
        let rentImgs = [];
        try { rentImgs = JSON.parse(contract.vehicle_rentout_images || '[]') || []; } catch(e) {}
        if (Array.isArray(rentImgs)) {
            rentImgs.forEach(img => {
                $('#viewcontractpreview').append(`<div class="position-relative me-2 mb-2"><a href="../uploads/rentvehicleImages/${escapeHtml(img)}" target="_blank"><img src="../uploads/rentvehicleImages/${escapeHtml(img)}" class="rounded border" style="width:80px;height:80px;object-fit:cover;"></a></div>`);
            });
        }

        $('#viewcontractreturnpreview').empty();
        let retImgs = [];
        try { retImgs = JSON.parse(contract.vehicle_return_images || '[]') || []; } catch(e) {}
        if (Array.isArray(retImgs)) {
            retImgs.forEach(img => {
                $('#viewcontractreturnpreview').append(`<div class="position-relative me-2 mb-2"><a href="../uploads/returnvehicleImages/${escapeHtml(img)}" target="_blank"><img src="../uploads/returnvehicleImages/${escapeHtml(img)}" class="rounded border" style="width:80px;height:80px;object-fit:cover;"></a></div>`);
            });
        }

        if (typeof listExtendedListviewcontract === 'function' && contract.ids) {
            listExtendedListviewcontract(contract.ids);
        }
    }
    </script>
</body>
</html>
