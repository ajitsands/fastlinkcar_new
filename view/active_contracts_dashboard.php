<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /Logout");
    exit();
}

include ROOT_PATH . '/view/envinclude.php';
$isContractListMode = !empty($isContractListMode);
$contractListVal = $this->encryption->encrypt('3,3-4');
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
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <style>
        .kpi-card {
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
            border: 1px solid #e2e8f0;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27, 61, 148, 0.12);
            border-color: #1b3d94;
        }
        .kpi-card.active-filter {
            border: 2px solid #1b3d94 !important;
            background-color: #f4f7fe;
        }
        .kpi-icon-box {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .kpi-icon-box i {
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        @media (max-width: 991.98px) {
            .container-p-y { padding-top: 15px !important; }
        }
        @media (min-width: 992px) {
            .container-p-y { padding-top: 55px !important; }
        }
        .custom-modal-header {
            background: linear-gradient(135deg, #1b3d94, #153075);
            color: #fff !important;
            border-bottom: none;
        }
        .custom-modal-header .modal-title,
        .custom-modal-header h5 {
            color: #fff !important;
        }
        .custom-modal-header .btn-close {
            filter: invert(1);
            opacity: 1;
        }
        .summary-card { border-left: 4px solid; }
        .card-total-debit { border-left-color: #ff4d49; }
        .card-total-credit { border-left-color: #72e128; }
        .card-balance { border-left-color: #26c6f9; }
        .row-collected { background-color: #e8fadf !important; }
        .row-bounced { background-color: #ffe5e5 !important; }
        .swal2-container {
            z-index: 2000 !important;
        }
        .select2-container--open {
            z-index: 1200 !important;
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
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                            <div>
                                <h4 class="fw-bold mb-1" style="color: #1b3d94;">
                                    <i class="ri-<?= $isContractListMode ? 'file-list-3-line' : 'dashboard-3-line' ?> me-1"></i>
                                    <?= $isContractListMode ? 'Contracts List' : 'Active Contracts Dashboard' ?>
                                </h4>
                                <p class="text-muted mb-0">
                                    <?= $isContractListMode
                                        ? 'View and manage all rental contracts across every status — active, returned, closed, or generated.'
                                        : 'Monitor all currently rented &amp; extended contracts and extend, return, or view them directly.' ?>
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="btnRefreshActive" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-refresh-line me-1"></i> Refresh
                                </button>
                                <?php if ($isContractListMode): ?>
                                <a href="/ActiveContractsDashboard" class="btn btn-primary btn-sm">
                                    <i class="ri-dashboard-3-line me-1"></i> Active Contracts Dashboard
                                </a>
                                <?php else: ?>
                                <a href="/ContractList?val=<?= urlencode($contractListVal) ?>" class="btn btn-primary btn-sm">
                                    <i class="ri-file-list-3-line me-1"></i> All Contracts
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- KPI Summary Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6 col-md-4">
                                <div class="card kpi-card active-filter" data-filter="all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Total Active Contracts</span>
                                            <h3 class="fw-bold mb-0 mt-1" style="color: #1b3d94;" id="kpiTotalActive">0</h3>
                                        </div>
                                        <div class="kpi-icon-box rounded" style="background-color: #eef3fc; color: #1b3d94;">
                                            <i class="ri-car-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="card kpi-card" data-filter="due_today">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Due Return Today</span>
                                            <h3 class="fw-bold mb-0 mt-1 text-warning" id="kpiDueToday">0</h3>
                                        </div>
                                        <div class="kpi-icon-box rounded bg-label-warning">
                                            <i class="ri-time-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="card kpi-card" data-filter="overdue">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Overdue Returns</span>
                                            <h3 class="fw-bold mb-0 mt-1 text-danger" id="kpiOverdue">0</h3>
                                        </div>
                                        <div class="kpi-icon-box rounded bg-label-danger">
                                            <i class="ri-alarm-warning-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Summary Cards (Active Contracts Till Date) -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6 col-md-4">
                                <div class="card border" style="border-color: #dbeafe !important;">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">To Be Collected (Excl. Overdue)</span>
                                            <h3 class="fw-bold mb-0 mt-1" style="color: #1b3d94;" id="kpiToCollectExcl">0.000 BHD</h3>
                                            <small class="text-muted">Till <?= date('d-M-Y') ?> &bull; Contract total minus received</small>
                                        </div>
                                        <div class="kpi-icon-box rounded" style="background-color: #eef3fc; color: #1b3d94;">
                                            <i class="ri-wallet-3-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="card border" style="border-color: #fecaca !important;">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Overdue Total (Till <?= date('d-M-Y') ?>)</span>
                                            <h3 class="fw-bold mb-0 mt-1 text-danger" id="kpiOverdueTotal">0.000 BHD</h3>
                                            <small class="text-muted">Accrued overdue charges on active contracts</small>
                                        </div>
                                        <div class="kpi-icon-box rounded bg-label-danger">
                                            <i class="ri-timer-flash-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="card border" style="border-color: #bbf7d0 !important;">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Total To Collect (Incl. Overdue)</span>
                                            <h3 class="fw-bold mb-0 mt-1 text-success" id="kpiTotalInclOverdue">0.000 BHD</h3>
                                            <small class="text-muted">Till <?= date('d-M-Y') ?> &bull; Active contracts + overdue minus received</small>
                                        </div>
                                        <div class="kpi-icon-box rounded bg-label-success">
                                            <i class="ri-funds-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Contracts Table -->
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
                                <h5 class="mb-0 fw-semibold" id="activeTableTitle" style="color: #1b3d94;"><?= $isContractListMode ? 'All Contracts List' : 'Active Contracts List' ?></h5>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <select id="contractScopeFilter" class="form-select form-select-sm" style="width: 190px;">
                                        <option value="all" <?= $isContractListMode ? 'selected' : '' ?>>All Contracts</option>
                                        <option value="active" <?= !$isContractListMode ? 'selected' : '' ?>>Active Contracts</option>
                                        <option value="closed">Closed / Previous</option>
                                        <option value="generated">Generated</option>
                                    </select>
                                    <input type="text" id="activeSearchInput" class="form-control form-control-sm" style="width: 240px;" placeholder="Search agreement, customer, plate...">
                                    <button type="button" id="btnExportActiveExcel" class="btn btn-sm btn-outline-success" title="Export to Excel">
                                        <i class="ri-file-excel-2-line me-1"></i> Excel
                                    </button>
                                    <button type="button" id="btnExportActivePdf" class="btn btn-sm btn-outline-danger" title="Export to PDF">
                                        <i class="ri-file-pdf-2-line me-1"></i> PDF
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="activeContractsTable" class="table table-hover align-middle w-100">
                                        <thead>
                                            <tr>
                                                <th>Agreement No</th>
                                                <th>Customer</th>
                                                <th>Vehicle</th>
                                                <th>Agreed Period</th>
                                                <th class="text-end">Received</th>
                                                <th class="text-end">Contract Total</th>
                                                <th class="text-end">Overdue Amt</th>
                                                <th class="text-end">Total Value</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <!-- Quick View Contract Modal -->
    <div class="modal fade" id="quickViewContractModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #1b3d94, #2563eb);">
                    <h5 class="modal-title text-white mb-0">
                        <i class="ri-file-text-line me-1"></i> Contract Details - <span id="qvAgreementNo"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Top Contract Meta Strip -->
                    <div class="row g-2 mb-3 p-2 rounded border bg-white align-items-center">
                        <div class="col-sm-6 col-md-3">
                            <div class="text-muted small">Agreement Date</div>
                            <div class="fw-semibold" id="qvAgreementDate">-</div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-muted small">Booking / Qtn No</div>
                            <div class="fw-semibold" id="qvBookingNo">-</div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-muted small">Company</div>
                            <div class="fw-semibold" id="qvCompanyName">-</div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-muted small">Status</div>
                            <div id="qvStatus">-</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <div class="p-3 rounded border h-100" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                                <div class="fw-semibold mb-2 pb-1 border-bottom border-primary-subtle" style="color: #1b3d94;">
                                    <i class="ri-user-line me-1"></i> Customer Information
                                </div>
                                <div class="row g-2 small">
                                    <div class="col-4 text-muted">Customer Name</div>
                                    <div class="col-8 fw-semibold" id="qvCustomerName">-</div>
                                    <div class="col-4 text-muted">Customer Code</div>
                                    <div class="col-8 fw-semibold" id="qvCustomerCode">-</div>
                                    <div class="col-4 text-muted">CPR / CR No</div>
                                    <div class="col-8 fw-semibold" id="qvCustomerCpr">-</div>
                                    <div class="col-4 text-muted">Phone</div>
                                    <div class="col-8 fw-semibold" id="qvCustomerPhone">-</div>
                                    <div class="col-4 text-muted">Email</div>
                                    <div class="col-8 fw-semibold text-break" id="qvCustomerEmail">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle & Rental Period -->
                        <div class="col-md-6">
                            <div class="p-3 rounded border h-100" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                                <div class="fw-semibold mb-2 pb-1 border-bottom border-primary-subtle" style="color: #1b3d94;">
                                    <i class="ri-car-line me-1"></i> Vehicle &amp; Contract Period
                                </div>
                                <div class="row g-2 small">
                                    <div class="col-4 text-muted">Vehicle No</div>
                                    <div class="col-8 fw-semibold" id="qvVehicleNo">-</div>
                                    <div class="col-4 text-muted">Category / Model</div>
                                    <div class="col-8 fw-semibold"><span id="qvVehicleCategory">-</span> / <span id="qvVehicleModel">-</span></div>
                                    <div class="col-4 text-muted">Year / Color</div>
                                    <div class="col-8 fw-semibold"><span id="qvVehicleYear">-</span> / <span id="qvVehicleColor">-</span></div>
                                    <div class="col-4 text-muted">Chassis No</div>
                                    <div class="col-8 fw-semibold" id="qvChassisNo">-</div>
                                    <div class="col-4 text-muted">Rate Type</div>
                                    <div class="col-8 fw-semibold" id="qvRateType">-</div>
                                    <div class="col-4 text-muted">Start Date</div>
                                    <div class="col-8 fw-semibold" id="qvStartDate">-</div>
                                    <div class="col-4 text-muted">Expected Return</div>
                                    <div class="col-8 fw-semibold" id="qvEndDate">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Breakdown -->
                    <div class="p-3 rounded border" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                        <div class="fw-semibold mb-2 pb-1 border-bottom border-primary-subtle" style="color: #1b3d94;">
                            <i class="ri-money-dollar-circle-line me-1"></i> Financial Summary
                        </div>
                        <div class="row g-2 text-center">
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-white border h-100">
                                    <div class="text-muted small">Contract Total</div>
                                    <div class="fw-bold mt-1" id="qvContractTotal">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-white border h-100">
                                    <div class="text-muted small">Received</div>
                                    <div class="fw-bold text-success mt-1" id="qvReceivedAmt">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-white border h-100">
                                    <div class="text-muted small">To Collect (Excl.)</div>
                                    <div class="fw-bold mt-1" style="color: #1b3d94;" id="qvToCollectExcl">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-white border h-100">
                                    <div class="text-muted small">Overdue <span id="qvOverdueDays"></span></div>
                                    <div class="fw-bold text-danger mt-1" id="qvOverdueAmt">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-white border h-100">
                                    <div class="text-muted small">To Collect (Incl.)</div>
                                    <div class="fw-bold text-success mt-1" id="qvToCollectIncl">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-white border h-100">
                                    <div class="text-muted small">Total Value</div>
                                    <div class="fw-bold mt-1" style="color: #1b3d94;" id="qvTotalAmount">0.000 BHD</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 small text-muted" id="qvNotes"></div>
                    </div>

                    <!-- Extended Full Contract Details (loaded via GetContractDetails) -->
                    <div id="qvFullDetailsContainer" class="mt-3">
                        <div class="row g-3 mb-3">
                            <!-- Rentout Checklist & Handover -->
                            <div class="col-md-6">
                                <div class="p-3 rounded border h-100" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                                    <div class="fw-semibold mb-2 pb-1 border-bottom border-primary-subtle" style="color: #1b3d94;">
                                        <i class="ri-checkbox-multiple-line me-1"></i> Rentout Handover &amp; Checklist (OUT)
                                    </div>
                                    <div class="row g-1 small mb-2">
                                        <div class="col-4 text-muted">KM Out</div>
                                        <div class="col-8 fw-semibold" id="qvKmOut">-</div>
                                        <div class="col-4 text-muted">Fuel Out</div>
                                        <div class="col-8 fw-semibold" id="qvFuelOut">-</div>
                                        <div class="col-4 text-muted">Rentout Time</div>
                                        <div class="col-8 fw-semibold" id="qvDtOut">-</div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-1" id="qvChecklistBadges"></div>
                                </div>
                            </div>

                            <!-- Driver Details -->
                            <div class="col-md-6">
                                <div class="p-3 rounded border h-100" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                                    <div class="fw-semibold mb-2 pb-1 border-bottom border-primary-subtle" style="color: #1b3d94;">
                                        <i class="ri-steering-2-line me-1"></i> Driver Details
                                    </div>
                                    <div class="row g-1 small">
                                        <div class="col-5 text-muted">Customer Driver</div>
                                        <div class="col-7 fw-semibold" id="qvCustDriverName">-</div>
                                        <div class="col-5 text-muted">Driver CPR / ID</div>
                                        <div class="col-7 fw-semibold" id="qvCustDriverCpr">-</div>
                                        <div class="col-5 text-muted">Driver Mobile / Phone</div>
                                        <div class="col-7 fw-semibold" id="qvCustDriverContact">-</div>
                                        <div class="col-5 text-muted">Company Driver</div>
                                        <div class="col-7 fw-semibold" id="qvCompanyDriver">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Extensions (if any) -->
                        <div class="p-3 rounded border mb-3 d-none" id="qvExtensionsSection" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                            <div class="fw-semibold mb-2 pb-1 border-bottom border-primary-subtle" style="color: #1b3d94;">
                                <i class="ri-calendar-event-line me-1"></i> Contract Extensions
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0 small">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Period</th>
                                            <th>Duration</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="qvExtensionsBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Contract Ledger Details -->
                        <div class="p-3 rounded border mb-3" id="qvLedgerSection" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-primary-subtle flex-wrap gap-2">
                                <span class="fw-semibold" style="color: #1b3d94;"><i class="ri-book-open-line me-1"></i> Contract Ledger</span>
                                <div class="small">
                                    Debit: <strong id="qvLedDebit">0.000</strong> |
                                    Credit: <strong class="text-success" id="qvLedCredit">0.000</strong> |
                                    Balance: <strong class="text-danger" id="qvLedBalance">0.000</strong>
                                </div>
                            </div>
                            <div class="table-responsive bg-white rounded border" style="max-height: 220px; overflow-y: auto;">
                                <table class="table table-sm table-bordered table-hover align-middle mb-0" style="font-size: 12px;">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th class="text-end">Debit</th>
                                            <th class="text-end">Credit</th>
                                            <th class="text-end">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="qvLedgerBody">
                                        <tr><td colspan="7" class="text-center text-muted py-2">Loading ledger...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Car Survey OUT & Signatures -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded border h-100 text-center" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                                    <div class="fw-semibold mb-2 pb-1 border-bottom border-primary-subtle text-start" style="color: #1b3d94;">
                                        <i class="ri-car-washing-line me-1"></i> Car Survey (OUT)
                                    </div>
                                    <canvas id="qvSurveyOutCanvas" width="360" height="220" class="border rounded bg-white" style="max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded border h-100" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                                    <div class="fw-semibold mb-2 pb-1 border-bottom border-primary-subtle" style="color: #1b3d94;">
                                        <i class="ri-quill-pen-line me-1"></i> Signatures &amp; Images
                                    </div>
                                    <div class="row g-2 text-center small mb-2">
                                        <div class="col-6">
                                            <div class="text-muted mb-1">Hirer Signature</div>
                                            <div id="qvHirerSignBox" class="border rounded p-1 bg-white" style="min-height: 55px;">-</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted mb-1">Delivered By</div>
                                            <div id="qvDeliveredSignBox" class="border rounded p-1 bg-white" style="min-height: 55px;">-</div>
                                        </div>
                                    </div>
                                    <div id="qvRentoutImages" class="d-flex flex-wrap gap-2 mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="d-flex gap-2">
                        <button type="button" id="qvReturnBtn" class="btn btn-outline-success btn-sm btn-return-modal" data-id="">
                            <i class="ri-roadster-line me-1"></i> Return Vehicle
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" id="qvPrintBtn" class="btn btn-primary btn-sm">
                            <i class="ri-printer-line me-1"></i> Print Contract
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exact Contract List Return Modal Overlay -->
    <iframe id="returnModalIframe"
            src="about:blank"
            allowtransparency="true"
            style="display:none; position:fixed; inset:0; width:100vw; height:100vh; border:0; z-index:99999 !important; background:transparent;">
    </iframe>

    <?php include ROOT_PATH . '/view/templates/VehicleContractList/contract_ledger_return_style_modal.php'; ?>
    <?php include ROOT_PATH . '/view/templates/VehicleContractList/return_receipt_modal.php'; ?>

    <!-- Client Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #1b3d94, #153075);">
                    <h5 class="modal-title text-white">
                        <i class="ri-chat-3-line me-2"></i>Client Feedback &mdash; <span id="fbModalAgreementNo"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border py-2 px-3 mb-3 d-flex justify-content-between align-items-center">
                        <span><strong>Customer:</strong> <span id="fbModalCustomerName">-</span></span>
                        <span class="text-muted small" id="fbModalVehicle">-</span>
                    </div>
                    <div class="row g-4">
                        <!-- Left Column: Add Feedback Form -->
                        <div class="col-md-5 border-end">
                            <h6 class="fw-bold mb-3" style="color: #1b3d94;"><i class="ri-add-circle-line me-1"></i>Add Feedback</h6>
                            <form id="feedbackForm" class="row g-3">
                                <input type="hidden" id="fbContractId">
                                <input type="hidden" id="fbAgreementNoInput">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Date of Feedback <span class="text-danger">*</span></label>
                                    <input type="date" id="fbDate" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Feedback Taken By <span class="text-danger">*</span></label>
                                    <input type="text" id="fbTakenBy" class="form-control form-control-sm" value="<?= htmlspecialchars($_SESSION['profile_name'] ?? ($_SESSION['user_name'] ?? '')) ?>" placeholder="Staff name" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Feedback Notes <span class="text-danger">*</span></label>
                                    <textarea id="fbNotes" class="form-control form-control-sm" rows="5" placeholder="Enter client feedback remarks..." required></textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary btn-sm" id="btnSaveFeedback">
                                        <i class="ri-save-line me-1"></i> Save Feedback
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Right Column: Scrollable Feedback Timeline -->
                        <div class="col-md-7">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0" style="color: #1b3d94;"><i class="ri-history-line me-1"></i>Feedback Timeline</h6>
                                <span class="badge bg-label-primary" id="fbTotalCountBadge">0 Entries</span>
                            </div>
                            <div id="fbHistoryList" class="border rounded p-3 bg-light" style="height: 330px; overflow-y: auto;">
                                <div class="text-center text-muted small py-4">No feedback recorded yet.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>httpdocs/user_js/car_survey_widget.js?v=<?= time() ?>"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>httpdocs/user_js/return_receipt_modal.js?v=<?= time() ?>"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>httpdocs/user_js/contract_ledger_return_style.js?v=<?= time() ?>"></script>

    <script>
    (function() {
        const contractListBaseUrl = '/ContractList?val=<?= urlencode($contractListVal) ?>';
        let allContracts = [];
        let dt = null;
        let currentAgreementNo = '';
        let currentKpiFilter = 'all';

        function formatDateTime(val) {
            if (!val) return '-';
            const d = new Date(val.replace(' ', 'T'));
            if (isNaN(d.getTime())) return val;
            return d.toLocaleString('en-GB', {
                day: '2-digit', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }

        function escapeHtml(str) {
            return String(str || '').replace(/[&<>"']/g, s => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[s]));
        }

        function getFilteredContracts() {
            const filter = currentKpiFilter || 'all';
            const search = ($('#activeSearchInput').val() || '').trim().toLowerCase();

            return allContracts.filter(c => {
                const st = (c.status || '').toLowerCase();
                if (filter === 'overdue' && !c.is_overdue) return false;
                if (filter === 'due_today' && !c.is_due_today) return false;
                if (filter === 'extended' && st !== 'extended') return false;
                if (filter === 'rentout' && st !== 'rentout') return false;
                if (filter === 'closed' && st !== 'closed' && st !== 'returned') return false;

                if (search) {
                    const hay = [
                        c.agreement_no, c.customer_name, c.customer_phone,
                        c.vehicle_no, c.vehicle_model, c.booking_no
                    ].join(' ').toLowerCase();
                    if (!hay.includes(search)) return false;
                }
                return true;
            });
        }

        function renderFilteredTable() {
            const filtered = getFilteredContracts();

            if (!dt) {
                dt = $('#activeContractsTable').DataTable({
                    data: filtered,
                    pageLength: 15,
                    order: [],
                    dom: 't<"d-flex justify-content-between align-items-center mt-3"ip>',
                    columns: [
                        {
                            data: 'agreement_no',
                            render: (v, t, row) => {
                                const statusBadge = (typeof window.getContractStatusBadgeHtml === 'function')
                                    ? window.getContractStatusBadgeHtml(row.status, 'mt-1')
                                    : `<span class="badge ${String(row.status).toLowerCase() === 'extended' ? 'bg-label-info' : 'bg-label-success'} mt-1">${escapeHtml(row.status)}</span>`;
                                return `
                                    <a href="javascript:void(0);" class="fw-semibold qv-trigger d-block" data-id="${row.id}" style="color: #1b3d94;">
                                        ${escapeHtml(v)}
                                    </a>
                                    ${row.booking_no ? `<div class="small text-muted">${escapeHtml(row.booking_no)}</div>` : ''}
                                    ${statusBadge}
                                `;
                            }
                        },
                        {
                            data: 'customer_name',
                            render: (v, t, row) => `
                                <div class="fw-semibold">${escapeHtml(v)}</div>
                                <div class="small text-muted">
                                    <span class="me-2"><strong>Code:</strong> ${escapeHtml(row.customer_code || '-')}</span>
                                    <span><strong>CPR:</strong> ${escapeHtml(row.customer_cpr || '-')}</span>
                                </div>
                                <div class="small text-muted">
                                    <i class="ri-phone-line me-1"></i>${escapeHtml(row.customer_phone || '-')}
                                </div>
                            `
                        },
                        {
                            data: 'vehicle_no',
                            render: (v, t, row) => `
                                <div class="d-flex align-items-center gap-1 flex-wrap">
                                    <span class="badge bg-label-primary">${escapeHtml(v)}</span>
                                    <span class="fw-medium small">${escapeHtml(row.vehicle_model)}</span>
                                </div>
                                <div class="small text-muted mt-1">
                                    <span><strong>Cat:</strong> ${escapeHtml(row.vehicle_category)}</span> |
                                    <span><strong>Yr:</strong> ${escapeHtml(row.vehicle_year)}</span> |
                                    <span><strong>Clr:</strong> ${escapeHtml(row.vehicle_color)}</span>
                                </div>
                                <div class="small text-muted">
                                    <strong>Chassis:</strong> ${escapeHtml(row.chassis_number)}
                                </div>
                            `
                        },
                        {
                            data: 'start_date',
                            render: (v, t, row) => {
                                let tag = '<span class="badge bg-label-primary mt-1">On Schedule</span>';
                                if (row.is_overdue) {
                                    tag = `<span class="badge bg-label-danger mt-1">Overdue (${row.overdue_days}d)</span>`;
                                } else if (row.is_due_today) {
                                    tag = '<span class="badge bg-label-warning mt-1">Due Today</span>';
                                }
                                return `
                                    <div class="small"><strong>From:</strong> ${escapeHtml(formatDateTime(v))}</div>
                                    <div class="small"><strong>To:</strong> ${escapeHtml(formatDateTime(row.end_date))}</div>
                                    ${tag}
                                `;
                            }
                        },
                        {
                            data: 'received_amount',
                            className: 'text-end fw-semibold text-success text-nowrap',
                            render: v => Number(v || 0).toFixed(3)
                        },
                        {
                            data: 'contract_total_amount',
                            className: 'text-end fw-semibold text-nowrap',
                            render: v => Number(v || 0).toFixed(3)
                        },
                        {
                            data: 'overdue_amount',
                            className: 'text-end fw-semibold text-nowrap',
                            render: (v, t, row) => {
                                const amt = Number(v || 0).toFixed(3);
                                return row.is_overdue && Number(v) > 0
                                    ? `<span class="text-danger">${amt}</span>`
                                    : `<span class="text-muted">${amt}</span>`;
                            }
                        },
                        {
                            data: 'total_contract_value',
                            className: 'text-end fw-bold text-nowrap',
                            render: v => `<span style="color: #1b3d94;">${Number(v || 0).toFixed(3)}</span>`
                        },
                        {
                            data: 'id',
                            className: 'text-center text-nowrap',
                            orderable: false,
                            render: (id, t, row) => {
                                const stLow = (row.status || '').toLowerCase();
                                const isActiveRow = (stLow === 'rentout' || stLow === 'extended');
                                const fbCount = parseInt(row.feedback_count || 0, 10);
                                const fbBadge = fbCount > 0 ? `<span class="badge rounded-pill bg-primary ms-1" style="font-size:0.65rem; color:#ffffff !important;">${fbCount}</span>` : '';
                                const returnBtn = isActiveRow
                                    ? `<button type="button" class="btn btn-outline-success btn-return-modal" data-id="${id}" title="Return Vehicle"><i class="ri-roadster-line me-1"></i> Return</button>`
                                    : '';
                                return `
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary qv-trigger" data-id="${id}" title="View Full Contract Details">
                                                <i class="ri-eye-line me-1"></i> View
                                            </button>
                                            <button type="button" class="btn btn-outline-warning btn-contract-ledger" data-id="${id}" title="Contract Ledger &amp; Receipts">
                                                <i class="ri-book-2-line me-1"></i> Ledger
                                            </button>
                                            <button type="button" class="btn btn-outline-info btn-feedback-modal" data-id="${id}" title="Collect / View Client Feedback">
                                                <i class="ri-chat-3-line"></i>${fbBadge}
                                            </button>
                                        </div>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-secondary btn-receipt-modal" data-id="${id}" title="Create / Print Receipt">
                                                <i class="ri-receipt-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-dark ac-print-btn" data-agreement="${escapeHtml(row.agreement_no || '')}" title="Print Agreement">
                                                <i class="ri-printer-line"></i>
                                            </button>
                                            ${returnBtn}
                                        </div>
                                    </div>
                                `;
                            }
                        }
                    ]
                });
            } else {
                dt.clear().rows.add(filtered).draw();
            }

            let sumExclOverdue = 0;
            let sumOverdueAmt = 0;
            let sumInclOverdue = 0;
            filtered.forEach(c => {
                const excl = parseFloat(c.to_collect_excl_overdue !== undefined ? c.to_collect_excl_overdue : Math.max(0, (parseFloat(c.contract_total_amount) || 0) - (parseFloat(c.received_amount) || 0))) || 0;
                const ov   = parseFloat(c.overdue_amount) || 0;
                const incl = parseFloat(c.to_collect_incl_overdue !== undefined ? c.to_collect_incl_overdue : Math.max(0, (parseFloat(c.total_contract_value) || 0) - (parseFloat(c.received_amount) || 0))) || 0;
                sumExclOverdue += excl;
                sumOverdueAmt  += ov;
                sumInclOverdue += incl;
            });
            $('#kpiToCollectExcl').text(sumExclOverdue.toFixed(3) + ' BHD');
            $('#kpiOverdueTotal').text(sumOverdueAmt.toFixed(3) + ' BHD');
            $('#kpiTotalInclOverdue').text(sumInclOverdue.toFixed(3) + ' BHD');
        }

        function loadActiveContracts() {
            const scope = $('#contractScopeFilter').val() || 'active';
            const titleMap = {
                active: 'Active Contracts List',
                closed: 'Closed & Previous Contracts',
                generated: 'Generated Contracts List',
                all: 'All Contracts List'
            };
            $('#activeTableTitle').text(titleMap[scope] || 'Active Contracts List');

            fetch('/ActiveContractsDashboardController?scope=' + encodeURIComponent(scope))
                .then(r => r.json())
                .then(res => {
                    if (res.status !== 'success') {
                        $('#activeContractsTable tbody').html(`<tr><td colspan="9" class="text-center text-danger py-3">${escapeHtml(res.message || 'Failed to load active contracts.')}</td></tr>`);
                        return;
                    }
                    allContracts = res.data || [];
                    const s = res.summary || {};
                    $('#kpiTotalActive').text(s.total_active || 0);
                    $('#kpiDueToday').text(s.due_today || 0);
                    $('#kpiOverdue').text(s.overdue || 0);
                    renderFilteredTable();
                })
                .catch(err => {
                    console.error('Failed to load active contracts:', err);
                    $('#activeContractsTable tbody').html(`<tr><td colspan="9" class="text-center text-danger py-3">Error loading active contracts. Check console / network response.</td></tr>`);
                });
        }

        $(document).on('click', '.kpi-card', function() {
            const filter = $(this).data('filter') || 'all';
            currentKpiFilter = filter;
            $('.kpi-card').removeClass('active-filter');
            $(this).addClass('active-filter');
            renderFilteredTable();
        });

        $('#activeSearchInput').on('input', renderFilteredTable);
        $('#btnRefreshActive').on('click', loadActiveContracts);
        $('#contractScopeFilter').on('change', function() {
            currentKpiFilter = 'all';
            $('.kpi-card').removeClass('active-filter');
        loadActiveContracts();
        });

        $('#btnExportActiveExcel').on('click', function() {
            const rows = getFilteredContracts();
            if (!rows.length) {
                alert('No contracts to export.');
                return;
            }
            const headers = [
                'Agreement No', 'Status', 'Customer Name', 'Phone',
                'Vehicle No', 'Vehicle Model', 'From Date', 'To Date',
                'Overdue Days', 'Received (BHD)', 'Contract Total (BHD)',
                'Overdue Amt (BHD)', 'Total Value (BHD)'
            ];
            const csvEscape = (val) => '"' + String(val ?? '').replace(/"/g, '""') + '"';
            const lines = [headers.map(csvEscape).join(',')];
            rows.forEach(r => {
                lines.push([
                    r.agreement_no || '',
                    r.status || '',
                    r.customer_name || '',
                    r.customer_phone || '',
                    r.vehicle_no || '',
                    r.vehicle_model || '',
                    formatDateTime(r.start_date),
                    formatDateTime(r.end_date),
                    r.is_overdue ? (r.overdue_days || 0) : 0,
                    Number(r.received_amount || 0).toFixed(3),
                    Number(r.contract_total_amount || 0).toFixed(3),
                    Number(r.overdue_amount || 0).toFixed(3),
                    Number(r.total_contract_value || 0).toFixed(3)
                ].map(csvEscape).join(','));
            });
            const blob = new Blob(['\uFEFF' + lines.join('\r\n')], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'contracts_' + ($('#contractScopeFilter').val() || 'active') + '_' + new Date().toISOString().slice(0, 10) + '.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });

        $('#btnExportActivePdf').on('click', function() {
            const rows = getFilteredContracts();
            if (!rows.length) {
                alert('No contracts to export.');
                return;
            }
            const title = $('#activeTableTitle').text() || 'Contracts List';
            let totRec = 0, totBase = 0, totOv = 0, totVal = 0;
            const trs = rows.map((r, idx) => {
                const rec = Number(r.received_amount || 0);
                const base = Number(r.contract_total_amount || 0);
                const ov = Number(r.overdue_amount || 0);
                const val = Number(r.total_contract_value || 0);
                totRec += rec; totBase += base; totOv += ov; totVal += val;
                return `<tr>
                    <td>${idx + 1}</td>
                    <td><b>${escapeHtml(r.agreement_no || '')}</b><br><small>${escapeHtml(r.status || '')}</small></td>
                    <td>${escapeHtml(r.customer_name || '')}<br><small>${escapeHtml(r.customer_phone || '')}</small></td>
                    <td><b>${escapeHtml(r.vehicle_no || '')}</b><br><small>${escapeHtml(r.vehicle_model || '')}</small></td>
                    <td>${escapeHtml(formatDateTime(r.start_date))}<br>to ${escapeHtml(formatDateTime(r.end_date))}${r.is_overdue ? '<br><b style="color:#dc2626">Overdue ' + (r.overdue_days || 0) + 'd</b>' : ''}</td>
                    <td style="text-align:right">${rec.toFixed(3)}</td>
                    <td style="text-align:right">${base.toFixed(3)}</td>
                    <td style="text-align:right;color:${ov > 0 ? '#dc2626' : '#64748b'}">${ov.toFixed(3)}</td>
                    <td style="text-align:right;font-weight:bold">${val.toFixed(3)}</td>
                </tr>`;
            }).join('');

            const w = window.open('', '_blank');
            if (!w) return;
            w.document.write(`<!doctype html><html><head><title>${escapeHtml(title)}</title>
                <style>
                    @page { size: A4 landscape; margin: 10mm; }
                    body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; }
                    h2 { color: #1b3d94; margin: 0 0 4px 0; }
                    .meta { color: #64748b; margin-bottom: 10px; font-size: 10px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #cbd5e1; padding: 5px 6px; vertical-align: top; }
                    th { background: #1b3d94; color: #fff; text-align: left; }
                    tfoot td { background: #f1f5f9; font-weight: bold; }
                </style></head><body>
                <h2>${escapeHtml(title)}</h2>
                <div class="meta">Generated on: ${new Date().toLocaleString()} | Total Records: ${rows.length}</div>
                <table>
                    <thead><tr>
                        <th>#</th><th>Agreement</th><th>Customer</th><th>Vehicle</th><th>Period</th>
                        <th style="text-align:right">Received</th><th style="text-align:right">Contract Total</th>
                        <th style="text-align:right">Overdue Amt</th><th style="text-align:right">Total Value</th>
                    </tr></thead>
                    <tbody>${trs}</tbody>
                    <tfoot><tr>
                        <td colspan="5" style="text-align:right">Totals (BHD):</td>
                        <td style="text-align:right">${totRec.toFixed(3)}</td>
                        <td style="text-align:right">${totBase.toFixed(3)}</td>
                        <td style="text-align:right">${totOv.toFixed(3)}</td>
                        <td style="text-align:right">${totVal.toFixed(3)}</td>
                    </tr></tfoot>
                </table>
                <script>window.onload = function(){ window.print(); };<\/script>
                </body></html>`);
            w.document.close();
        });

        $(document).on('click', '.btn-receipt-modal', function() {
            const id = parseInt($(this).data('id'), 10);
            const row = allContracts.find(c => c.id === id);
            if (!row) return;
            if (window.ReturnReceiptModal) {
                window.ReturnReceiptModal.open({
                    contract_id: row.id,
                    customer_code: row.customer_code || '',
                    agreement_no: row.agreement_no || ''
                });
            }
        });

        function fmtReadableDate(dateStr) {
            if (!dateStr) return '-';
            const clean = String(dateStr).trim().substring(0, 10);
            const parts = clean.split('-');
            if (parts.length === 3 && parts[0].length === 4) {
                const ms = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const mi = parseInt(parts[1], 10) - 1;
                if (mi >= 0 && mi < 12) return `${parts[2]}-${ms[mi]}-${parts[0]}`;
            }
            return dateStr;
        }

        function renderFeedbackHistory(items) {
            const list = Array.isArray(items) ? items : [];
            $('#fbTotalCountBadge').text(list.length + (list.length === 1 ? ' Entry' : ' Entries'));
            if (list.length === 0) {
                $('#fbHistoryList').html('<div class="text-center text-muted small py-4">No feedback recorded yet.</div>');
                return;
            }
            const html = '<div class="ps-3 border-start border-2 border-primary">' + list.map(fb => `
                <div class="position-relative mb-3 bg-white border rounded p-2 shadow-xs">
                    <span class="position-absolute rounded-circle bg-primary" style="width: 10px; height: 10px; left: -22px; top: 12px; border: 2px solid #fff;"></span>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="badge bg-label-primary">${escapeHtml(fmtReadableDate(fb.feedback_date))}</span>
                        <small class="text-muted"><i class="ri-user-line me-1"></i>By: <strong>${escapeHtml(fb.taken_by || '-')}</strong></small>
                    </div>
                    <div class="small text-dark" style="white-space: pre-wrap;">${escapeHtml(fb.feedback_notes || '')}</div>
                </div>
            `).join('') + '</div>';
            $('#fbHistoryList').html(html);
        }

        $(document).on('click', '.btn-feedback-modal', function() {
            const id = parseInt($(this).data('id'), 10);
            const row = allContracts.find(c => c.id === id);
            if (!row) return;

            $('#fbContractId').val(row.id);
            $('#fbAgreementNoInput').val(row.agreement_no || '');
            $('#fbModalAgreementNo').text(row.agreement_no || '');
            $('#fbModalCustomerName').text(row.customer_name || '-');
            $('#fbModalVehicle').text((row.vehicle_no || '') + ' ' + (row.vehicle_model || ''));
            $('#fbDate').val(new Date().toISOString().split('T')[0]);
            $('#fbNotes').val('');
            $('#fbHistoryList').html('<div class="text-center text-muted small py-2">Loading feedback...</div>');

            new bootstrap.Modal(document.getElementById('feedbackModal')).show();

            fetch('/ActiveContractsDashboardController', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'get_feedback', contract_id: row.id })
            })
            .then(r => r.json())
            .then(res => {
                if (res && res.status === 'success') {
                    if (res.default_taken_by && !$('#fbTakenBy').val()) {
                        $('#fbTakenBy').val(res.default_taken_by);
                    }
                    renderFeedbackHistory(res.data || []);
                } else {
                    renderFeedbackHistory([]);
                }
            })
            .catch(() => renderFeedbackHistory([]));
        });

        $('#feedbackForm').on('submit', function(e) {
            e.preventDefault();
            const cid = parseInt($('#fbContractId').val(), 10);
            const btn = $('#btnSaveFeedback');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Saving...');

            fetch('/ActiveContractsDashboardController', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'save_feedback',
                    contract_id: cid,
                    agreement_no: $('#fbAgreementNoInput').val(),
                    feedback_date: $('#fbDate').val(),
                    taken_by: $('#fbTakenBy').val(),
                    feedback_notes: $('#fbNotes').val()
                })
            })
            .then(r => r.json())
            .then(res => {
                btn.prop('disabled', false).html('<i class="ri-save-line me-1"></i> Save Feedback');
                if (res && res.status === 'success') {
                    $('#fbNotes').val('');
                    renderFeedbackHistory(res.data || []);
                    const cRow = allContracts.find(c => c.id === cid);
                    if (cRow) {
                        cRow.feedback_count = (res.data || []).length;
                        renderFilteredTable();
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'success', title: 'Saved', text: 'Client feedback saved.', timer: 1500, showConfirmButton: false });
                    }
                } else {
                    alert((res && res.message) || 'Failed to save feedback.');
                }
            })
            .catch(() => {
                btn.prop('disabled', false).html('<i class="ri-save-line me-1"></i> Save Feedback');
                alert('Error saving feedback.');
            });
        });

        $(document).on('click', '.qv-trigger', function() {
            const id = parseInt($(this).data('id'), 10);
            const row = allContracts.find(c => c.id === id);
            if (!row) return;

            currentAgreementNo = row.agreement_no;
            $('#qvAgreementNo').text(row.agreement_no || '-');
            $('#qvAgreementDate').text(row.agreement_date ? formatDateTime(row.agreement_date) : '-');
            $('#qvBookingNo').text(row.booking_no || '-');
            $('#qvCompanyName').text(row.company_name || 'Fast Link');
            $('#qvStatus').html(row.is_overdue ? `<span class="badge bg-label-danger">Overdue (${row.overdue_days}d)</span>` : (row.is_due_today ? `<span class="badge bg-label-warning">Due Today</span>` : `<span class="badge bg-label-primary">${row.status || 'Active'}</span>`));

            $('#qvCustomerName').text(row.customer_name || 'N/A');
            $('#qvCustomerCode').text(row.customer_code || '-');
            $('#qvCustomerCpr').text(row.customer_cpr || '-');
            $('#qvCustomerPhone').text(row.customer_phone || '-');
            $('#qvCustomerEmail').text(row.customer_email || '-');

            $('#qvVehicleNo').text(row.vehicle_no || 'N/A');
            $('#qvVehicleCategory').text(row.vehicle_category || '-');
            $('#qvVehicleModel').text(row.vehicle_model || '-');
            $('#qvVehicleYear').text(row.vehicle_year || '-');
            $('#qvVehicleColor').text(row.vehicle_color || '-');
            $('#qvChassisNo').text(row.chassis_number || '-');
            $('#qvRateType').text(row.rate_type || '-');
            $('#qvStartDate').text(formatDateTime(row.start_date));
            $('#qvEndDate').text(formatDateTime(row.end_date));

            const cTotal = Number(row.contract_total_amount || 0);
            const recAmt = Number(row.received_amount || 0);
            const ovAmt  = Number(row.overdue_amount || 0);
            const tVal   = Number(row.total_contract_value || 0);
            const exCol  = row.to_collect_excl_overdue !== undefined ? Number(row.to_collect_excl_overdue) : Math.max(0, cTotal - recAmt);
            const inCol  = row.to_collect_incl_overdue !== undefined ? Number(row.to_collect_incl_overdue) : Math.max(0, tVal - recAmt);

            $('#qvContractTotal').text(cTotal.toFixed(3) + ' BHD');
            $('#qvReceivedAmt').text(recAmt.toFixed(3) + ' BHD');
            $('#qvToCollectExcl').text(exCol.toFixed(3) + ' BHD');
            $('#qvOverdueDays').text(row.overdue_days > 0 ? `(${row.overdue_days}d)` : '');
            $('#qvOverdueAmt').text(ovAmt.toFixed(3) + ' BHD');
            $('#qvToCollectIncl').text(inCol.toFixed(3) + ' BHD');
            $('#qvTotalAmount').text(tVal.toFixed(3) + ' BHD');
            $('#qvNotes').text(row.notes ? 'Notes: ' + row.notes : '');

            $('#qvReturnBtn').data('id', row.id).attr('data-id', row.id);

            // Reset extended fields while loading full contract details
            $('#qvKmOut, #qvFuelOut, #qvDtOut, #qvCustDriverName, #qvCustDriverCpr, #qvCustDriverContact, #qvCompanyDriver').text('Loading...');
            $('#qvChecklistBadges, #qvExtensionsBody, #qvRentoutImages').empty();
            $('#qvExtensionsSection').addClass('d-none');
            $('#qvHirerSignBox, #qvDeliveredSignBox').html('-');
            if (window.CarSurveyWidget) {
                CarSurveyWidget.init('qvSurveyOutCanvas', [], { readOnly: true });
            }

            new bootstrap.Modal(document.getElementById('quickViewContractModal')).show();

            $.ajax({
                url: '/ContractListController',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'GetContractDetails',
                    agreementid: row.id,
                    vehicleid: row.vehicle_id || '',
                    customer_code: row.customer_code || '',
                    model_ids: row.model_id || ''
                }),
                success: function(res) {
                    const d = (typeof res === 'string') ? JSON.parse(res) : res;
                    if (!d || !d.contract) return;
                    const c = d.contract;
                    let acc = {};
                    let drv = {};
                    try { acc = JSON.parse(c.vehicle_accessories_details || '{}') || {}; } catch (e) {}
                    try { drv = JSON.parse(c.driver_details || '{}') || {}; } catch (e) {}

                    $('#qvKmOut').text(acc.vehicle_km_out || c.km_out || '-');
                    $('#qvFuelOut').text(acc.fuel_level || '-');
                    $('#qvDtOut').text(acc.date_out ? formatDateTime(acc.date_out.replace('T', ' ')) : (c.service_start_date_time ? formatDateTime(c.service_start_date_time) : '-'));

                    const chkList = [
                        ['Tools Kit', acc.chk_tools],
                        ['S. Wheel', acc.chk_spare],
                        ['W. Cup', acc.chk_wcup],
                        ['Radio', acc.chk_radio],
                        ['Scratches Mark X', acc.chk_scratches],
                        ['Seats Cleanness', acc.chk_seats]
                    ];
                    $('#qvChecklistBadges').html(chkList.map(([lbl, val]) => {
                        const yes = String(val || '').toLowerCase() === 'yes';
                        return `<span class="badge ${yes ? 'bg-label-success' : 'bg-label-secondary'}">${yes ? '✓' : '✗'} ${lbl}</span>`;
                    }).join(''));

                    $('#qvCustDriverName').text(c.customer_driver_name || acc.cust_driver_name || '-');
                    $('#qvCustDriverCpr').text(acc.cust_driver_cpr || '-');
                    const drvPhones = [c.customer_driver_contact_number || acc.cust_driver_contact_no, acc.cust_driver_phone].filter(Boolean).join(' / ');
                    $('#qvCustDriverContact').text(drvPhones || '-');
                    $('#qvCompanyDriver').text(drv.driver_name && drv.driver_name !== 'Select Driver' ? `${drv.driver_name}${drv.driver_mobile ? ' (' + drv.driver_mobile + ')' : ''}` : '-');

                    if (Array.isArray(d.extensions) && d.extensions.length > 0) {
                        $('#qvExtensionsBody').html(d.extensions.map((ext, i) => {
                            let ed = {};
                            try { ed = JSON.parse(ext.extend_details || '{}') || {}; } catch (e) {}
                            return `<tr><td>${i + 1}</td><td>${escapeHtml(ext.extend_start_date || '')} → ${escapeHtml(ext.extend_end_date || '')}</td><td>${escapeHtml((ed.duration || '') + ' ' + (ed.rate_type || ''))}</td><td class="text-end">${Number(ed.total_amt || 0).toFixed(3)}</td></tr>`;
                        }).join(''));
                        $('#qvExtensionsSection').removeClass('d-none');
                    }

                    if (window.CarSurveyWidget) {
                        CarSurveyWidget.init('qvSurveyOutCanvas', Array.isArray(acc.car_survey_out) ? acc.car_survey_out : [], { readOnly: true });
                    }

                    if (c.hirer_signature) {
                        const hp = c.hirer_signature.startsWith('/') ? c.hirer_signature : '/' + c.hirer_signature;
                        $('#qvHirerSignBox').html(`<img src="${hp}" style="max-height:50px; max-width:100%;" onerror="this.parentNode.innerText='-'">`);
                    }
                    if (c.delivered_signature) {
                        const dp = c.delivered_signature.startsWith('/') ? c.delivered_signature : '/' + c.delivered_signature;
                        $('#qvDeliveredSignBox').html(`<img src="${dp}" style="max-height:50px; max-width:100%;" onerror="this.parentNode.innerText='-'">`);
                    }

                    let imgs = [];
                    try { imgs = JSON.parse(c.vehicle_rentout_images || '[]') || []; } catch (e) {}
                    if (Array.isArray(imgs) && imgs.length > 0) {
                        $('#qvRentoutImages').html(imgs.map(im => {
                            const file = (typeof im === 'string') ? im : (im.image || im.file || '');
                            if (!file) return '';
                            const src = file.includes('/') ? (file.startsWith('/') ? file : '/' + file) : '/uploads/rentvehicleImages/' + file;
                            return `<a href="${src}" target="_blank"><img src="${src}" class="rounded border" style="width:64px; height:48px; object-fit:cover;"></a>`;
                        }).join(''));
                    }
                }
            });

            // Load Contract Ledger
            $('#qvLedgerBody').html('<tr><td colspan="7" class="text-center text-muted py-2">Loading ledger...</td></tr>');
            $('#qvLedDebit, #qvLedCredit, #qvLedBalance').text('0.000');
            $.getJSON('/CustomerLedgerController', {
                action: 'GetContractLedgerData',
                contract_id: row.id
            }, function(lRes) {
                const ld = (typeof lRes === 'string') ? JSON.parse(lRes) : lRes;
                const rows = (ld && Array.isArray(ld.data)) ? ld.data : (Array.isArray(ld) ? ld : []);
                if (!rows.length) {
                    $('#qvLedgerBody').html('<tr><td colspan="7" class="text-center text-muted py-2">No ledger entries found</td></tr>');
                    return;
                }
                let totD = 0, totC = 0, run = 0;
                const html = rows.map((r, i) => {
                    const deb = parseFloat(r.debit || 0);
                    const cred = ((r.cheque_status || '') === 'Bounced') ? 0 : parseFloat(r.credit || 0);
                    totD += deb;
                    totC += cred;
                    run += (deb - cred);
                    const dtRaw = r.trans_date || r.created_at || '-';
                    let dtDisp = String(dtRaw).substring(0, 10);
                    const dp = dtDisp.split('-');
                    if (dp.length === 3 && dp[0].length === 4) {
                        const ms = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                        const mi = parseInt(dp[1], 10) - 1;
                        if (mi >= 0 && mi < 12) dtDisp = `${dp[2]}-${ms[mi]}-${dp[0]}`;
                    }
                    const desc = r.description || r.remarks || r.notes || '-';
                    const mBadge = (r.payment_method && r.payment_method !== 'N/A') ? ` <span class="badge bg-label-info">${escapeHtml(r.payment_method)}</span>` : '';
                    return `
                        <tr>
                            <td>${i + 1}</td>
                            <td class="text-nowrap">${escapeHtml(dtDisp)}</td>
                            <td><span class="badge bg-label-primary">${escapeHtml(r.trans_type || '-')}</span>${mBadge}</td>
                            <td>${escapeHtml(desc)}</td>
                            <td class="text-end">${deb > 0 ? deb.toFixed(3) : '-'}</td>
                            <td class="text-end text-success">${cred > 0 ? cred.toFixed(3) : '-'}</td>
                            <td class="text-end fw-semibold">${run.toFixed(3)}</td>
                        </tr>
                    `;
                }).join('');
                $('#qvLedgerBody').html(html);
                $('#qvLedDebit').text(totD.toFixed(3));
                $('#qvLedCredit').text(totC.toFixed(3));
                $('#qvLedBalance').text(Math.max(0, totD - totC).toFixed(3));
            });
        });

        $(document).on('click', '.ac-print-btn', function() {
            const agr = $(this).data('agreement');
            if (!agr) return;
            fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(agr))
                .then(r => r.text())
                .then(token => {
                    if (token) window.open('/PrintAgreement?token=' + encodeURIComponent(token.trim()), '_blank');
                });
        });

        let returnIframeReady = false;
        function preloadReturnIframe() {
            const iframe = document.getElementById('returnModalIframe');
            if (!iframe) return;
            if (!iframe.src || iframe.src === 'about:blank') {
                iframe.src = `${contractListBaseUrl}&embed_return=1&preload=1`;
            }
        }

        $(document).on('click', '.btn-return-modal', function() {
            const id = parseInt($(this).attr('data-id') || $(this).data('id'), 10);
            const row = allContracts.find(c => c.id === id);
            if (!row) return;

            const qvModal = bootstrap.Modal.getInstance(document.getElementById('quickViewContractModal'));
            if (qvModal) qvModal.hide();

            const payload = {
                contract_id: row.id,
                agreement_no: row.agreement_no || '',
                vehicle_id: row.vehicle_id || '',
                customer_code: row.customer_code || '',
                model_id: row.model_id || '',
                booking_ids: row.booking_ids || '',
                booking_no: row.booking_no || row.agreement_no || ''
            };

            const iframe = document.getElementById('returnModalIframe');
            if (returnIframeReady && iframe && iframe.contentWindow) {
                iframe.style.display = 'block';
                document.body.style.overflow = 'hidden';
                iframe.contentWindow.postMessage({ type: 'openReturnModal', contract: payload }, '*');
                return;
            }

            const params = new URLSearchParams(Object.assign({ embed_return: '1' }, payload));
            iframe.src = `${contractListBaseUrl}&${params.toString()}`;
            iframe.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });

        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'returnIframeReady') {
                returnIframeReady = true;
            }
            if (event.data && event.data.type === 'returnModalClosed') {
                const iframe = document.getElementById('returnModalIframe');
                iframe.style.display = 'none';
                document.body.style.overflow = '';
                if (event.data.returned) {
        loadActiveContracts();
                }
                if (event.data.promptReceipt && event.data.contract_id) {
                    const recInfo = {
                        contract_id: event.data.contract_id,
                        customer_code: event.data.customer_code || '',
                        agreement_no: event.data.agreementNo || ''
                    };
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Vehicle Returned Successfully',
                            text: 'Do you want to generate a Receipt for agreement ' + recInfo.agreement_no + '?',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Generate Receipt',
                            cancelButtonText: 'No',
                            confirmButtonColor: '#1b3d94'
                        }).then(function(result) {
                            if (result.isConfirmed && window.ReturnReceiptModal) {
                                window.ReturnReceiptModal.open(recInfo);
                            }
                        });
                    } else if (confirm('Vehicle returned successfully. Do you want to generate a Receipt for ' + recInfo.agreement_no + '?')) {
                        if (window.ReturnReceiptModal) window.ReturnReceiptModal.open(recInfo);
                    }
                }
            }
        });

        $('#qvPrintBtn').on('click', function() {
            if (!currentAgreementNo) return;
            fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(currentAgreementNo))
                .then(r => r.text())
                .then(token => {
                    if (token) {
                        window.open('/PrintAgreement?token=' + encodeURIComponent(token.trim()), '_blank');
                    }
                });
        });

        loadActiveContracts();
        setTimeout(preloadReturnIframe, 400);
    })();
    </script>
</body>
</html>
