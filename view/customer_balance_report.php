<?php
session_start();

function checkLogin()
{
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header("Location: /Logout");
        exit();
    }
}

checkLogin();
include ROOT_PATH . '/view/envinclude.php';

// Safe encryption resolution for CustomerLedger deep links
$encryptedVal = '';
if (isset($this) && isset($this->encryption)) {
    $encryptedVal = $this->encryption->encrypt("5,5-1");
} elseif (class_exists('EncryptionClass')) {
    $enc = new EncryptionClass();
    $encryptedVal = $enc->encrypt("5,5-1");
}

require_once ROOT_PATH . '/pdf/print_settings_helper.php';
$cbCompanyId = !empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1;
$cbPrintSettings = getPrintSettings(null, $cbCompanyId);
$cbHeaderHtml = renderPrintHeaderHtml($cbPrintSettings, 'Customer Balance Report', 'As of: ' . date('d M Y, H:i'), 'Generated: ' . date('d/m/Y H:i'));
$cbFooterHtml = renderPrintFooterHtml($cbPrintSettings);
?>
<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
    
    <!-- RemixIcon WebFont CDN ensuring universal icon rendering -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" />
    
    <!-- DataTables & Alert styles -->
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/notyf/notyf.css" />

    <style>
        /* Base Icon Styling */
        .ri {
            display: inline-block;
            width: 1em;
            height: 1em;
            line-height: 1;
            vertical-align: -0.125em;
        }

        /* KPI Metric Cards matching Contract Status & Return Overdue Report */
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
        #tblBalances {
            font-size: 12.5px;
        }
        #tblBalances > thead > tr > th,
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
        #tblBalances tbody tr:hover {
            background-color: #fff9f9 !important;
        }
        #tblBalances tfoot {
            background-color: #eef3fc !important;
            border-top: 2px solid #1b3d94 !important;
        }
        #tblBalances tfoot td {
            font-weight: 700;
            font-size: 0.85rem;
            color: #1b3d94;
            padding: 8px 10px;
        }

        .clickable-name {
            cursor: pointer;
            color: #1b3d94 !important;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s ease-in-out;
        }
        .clickable-name:hover {
            text-decoration: underline !important;
            color: #153075 !important;
        }

        @media print {
            .no-print, .layout-navbar, .layout-menu, .footer, .btn, .card-header {
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
          
                        <!-- Action Bar (Global header rendered by menu.php) -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 no-print">
                            <span class="badge bg-label-primary px-3 py-2 fs-6">
                                <i class="ri ri-calendar-check-line me-1"></i> Report As of Today: <strong id="lbl_as_of_date"><?= date('d M Y, H:i') ?></strong>
                            </span>
                            <div class="d-flex gap-2">
                                <button type="button" id="btn_export_excel" class="btn btn-outline-success btn-sm">
                                    <i class="ri ri-file-excel-2-line me-1"></i> Export to Excel
                                </button>
                                <button type="button" id="btn_export_pdf" class="btn btn-primary btn-sm">
                                    <i class="ri ri-file-pdf-2-line me-1"></i> Export to PDF
                                </button>
                            </div>
                        </div>
                        
                        <!-- Summary KPI Metrics Dashboard (Row 1: Customers & Collections) -->
                        <div class="row g-3 mb-3 no-print" id="kpiContainer">
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-blue h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Total Customers</span>
                                        <div class="kpi-icon-box bg-primary"><i class="ri ri-group-line"></i></div>
                                    </div>
                                    <h3 class="fw-bold mb-0" id="kpi_total_customers">0</h3>
                                    <span class="text-muted small">All registered customers</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-green h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Active Customers</span>
                                        <div class="kpi-icon-box bg-success"><i class="ri ri-user-follow-line"></i></div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-success" id="kpi_active_customers">0</h3>
                                    <span class="text-muted small">Non-blacklisted active</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-red h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Blacklisted Customers</span>
                                        <div class="kpi-icon-box bg-dark"><i class="ri ri-user-forbid-line"></i></div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-dark" id="kpi_blacklisted_customers">0</h3>
                                    <span class="text-muted small">Restricted / Blacklisted</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-green h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Total Collected</span>
                                        <div class="kpi-icon-box bg-success"><i class="ri ri-hand-coin-line"></i></div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-success" id="lblTotalCollected">0.000</h3>
                                    <span class="text-muted small">Valid collections (BHD)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Outstanding & Overpaid Breakdown -->
                        <div class="row g-3 mb-3 no-print">
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-amber h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Ledger Outstanding</span>
                                        <div class="kpi-icon-box bg-warning"><i class="ri ri-book-open-line"></i></div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-dark" id="lblLedgerOutstanding">0.000</h3>
                                    <span class="text-muted small">As per ledger &amp; contracts (BHD)</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-red h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-danger small fw-semibold">Overdue (Not Returned)</span>
                                        <div class="kpi-icon-box bg-danger"><i class="ri ri-time-line"></i></div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-danger" id="lblOverdueOutstanding">0.000</h3>
                                    <span class="text-muted small">Unreturned vehicle overdue (BHD)</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-red pulse-danger h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-danger small fw-bold">Total Outstanding</span>
                                        <div class="kpi-icon-box bg-danger"><i class="ri ri-arrow-down-circle-line"></i></div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-danger" id="lblTotalReceivable">0.000</h3>
                                    <span class="text-danger small fw-semibold">Ledger + Overdue (BHD)</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-green h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Overpaid Amount</span>
                                        <div class="kpi-icon-box bg-success"><i class="ri ri-arrow-up-circle-line"></i></div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-success" id="lblTotalPayable">0.000</h3>
                                    <span class="text-muted small">Company should refund (BHD)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Total Collected by Payment Method -->
                        <div class="card border shadow-sm mb-4 no-print">
                            <div class="card-body py-2 px-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <span class="fw-bold small text-dark"><i class="ri ri-bank-card-line text-primary me-1"></i> Total Collected by Payment Method:</span>
                                <div id="lblPaymentMethodsStrip" class="d-flex flex-wrap gap-2">
                                    <span class="text-muted small">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Filter Pills -->
                        <div class="d-flex flex-wrap gap-2 mb-3 no-print" id="cbStatusFilterPills">
                            <button type="button" class="btn btn-sm btn-primary cb-filter-pill active" data-filter="all">All</button>
                            <button type="button" class="btn btn-sm btn-outline-danger cb-filter-pill" data-filter="pending">Pending Payment</button>
                            <button type="button" class="btn btn-sm btn-outline-warning cb-filter-pill" data-filter="overdue">Overdue Return</button>
                            <button type="button" class="btn btn-sm btn-outline-info cb-filter-pill" data-filter="paid_overdue">Ledger Paid + Overdue</button>
                            <button type="button" class="btn btn-sm btn-outline-success cb-filter-pill" data-filter="overpaid">Overpaid (Credit)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary cb-filter-pill" data-filter="settled">Settled</button>
                            <button type="button" class="btn btn-sm btn-outline-dark cb-filter-pill" data-filter="blacklisted">Blacklisted</button>
                        </div>

                        <!-- Main Report Data Table Card -->
                        <div class="card border shadow-sm">
                            <div class="card-datatable table-responsive">
                                <table id="tblBalances" class="table table-bordered table-sm table-hover align-middle text-start" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="4%" class="text-center">#</th>
                                            <th width="34%">Customer Details &amp; Status</th>
                                            <th width="14%" class="text-end">Total Debit (Owed)</th>
                                            <th width="14%" class="text-end">Total Credit (Paid)</th>
                                            <th width="14%" class="text-end">Overdue Return</th>
                                            <th width="14%" class="text-end">Balance Amount</th>
                                            <th width="6%" class="text-center no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-end">Filtered Totals:</td>
                                            <td class="text-end text-danger" id="foot_total_debit">0.000 BHD</td>
                                            <td class="text-end text-success" id="foot_total_credit">0.000 BHD</td>
                                            <td class="text-end text-danger" id="foot_total_overdue">0.000 BHD</td>
                                            <td class="text-end" id="foot_net_balance">0.000 BHD</td>
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

    <!-- Customer Ledger Modal (Matching Contract List Ledger Modal Style) -->
    <div class="modal fade" id="cbCustomerLedgerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
            <div class="modal-content">
                <div class="modal-header text-white py-2" style="background: linear-gradient(135deg, #1b3d94, #2563eb);">
                    <div>
                        <h5 class="mb-0 text-white"><i class="ri-book-open-line me-1"></i> Customer Ledger — <span id="cb_led_cust_name">-</span></h5>
                        <small class="text-white-50">Code: <span id="cb_led_cust_code" class="fw-bold text-white">-</span></small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <!-- Customer Info Card -->
                    <div class="p-3 rounded border mb-3" style="background-color:#f4f7ff; border-color:#cfe0ff !important;">
                        <div class="row g-2 small align-items-center">
                            <div class="col-6 col-md-3"><span class="text-muted">Customer:</span> <strong id="cb_led_info_name">-</strong></div>
                            <div class="col-6 col-md-2"><span class="text-muted">Mobile:</span> <strong id="cb_led_info_mobile">-</strong></div>
                            <div class="col-6 col-md-2"><span class="text-muted">CPR / CR:</span> <strong id="cb_led_info_cpr">-</strong></div>
                            <div class="col-6 col-md-3"><span class="text-muted">Email:</span> <strong id="cb_led_info_email">-</strong></div>
                            <div class="col-12 col-md-2 text-md-end">
                                <a href="#" id="cb_led_full_page_link" class="btn btn-xs btn-outline-primary">
                                    <i class="ri-external-link-line me-1"></i> Full Ledger
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- KPI Strip -->
                    <div class="row g-2 mb-3 text-center">
                        <div class="col-4">
                            <div class="p-2 rounded border bg-light">
                                <div class="small text-muted">Total Debit</div>
                                <div class="fw-bold text-danger fs-6" id="cb_led_tot_debit">0.000 BHD</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded border bg-light">
                                <div class="small text-muted">Total Credit</div>
                                <div class="fw-bold text-success fs-6" id="cb_led_tot_credit">0.000 BHD</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded border bg-light">
                                <div class="small text-muted">Net Balance</div>
                                <div class="fw-bold text-primary fs-6" id="cb_led_net_bal">0.000 BHD</div>
                            </div>
                        </div>
                    </div>

                    <!-- Unposted Contracts & Active Overdue Breakdown (if any) -->
                    <div id="cb_led_unposted_wrap" class="mb-3 d-none">
                        <div class="alert alert-warning py-2 px-3 mb-2 small fw-semibold">
                            <i class="ri-error-warning-line me-1"></i> Unposted Contract Charges / Active Overdue Return Amounts (Not Yet Posted in Ledger):
                        </div>
                        <div class="table-responsive border rounded">
                            <table class="table table-sm table-bordered mb-0" style="font-size:12px;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Agreement No.</th>
                                        <th>Vehicle</th>
                                        <th>Status</th>
                                        <th class="text-end">Unposted Contract Debit</th>
                                        <th class="text-end">Overdue Days</th>
                                        <th class="text-end">Overdue Return Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="cb_led_unposted_tbody"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Ledger DataTable -->
                    <div class="table-responsive border rounded p-2">
                        <table id="cb_led_table" class="table table-sm table-bordered table-hover align-middle mb-0 w-100" style="font-size:12.5px;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Date</th>
                                    <th>Agreement No.</th>
                                    <th>Type / Receipt</th>
                                    <th>Description</th>
                                    <th class="text-end">Debit</th>
                                    <th class="text-end">Credit</th>
                                    <th class="text-end">Balance</th>
                                </tr>
                            </thead>
                            <tbody id="cb_led_tbody">
                                <tr><td colspan="8" class="text-center text-muted py-3">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer py-2 bg-light justify-content-between">
                    <button type="button" id="cb_led_btn_print_soa" class="btn btn-sm btn-primary">
                        <i class="ri-printer-line me-1"></i> Print SOA
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/notyf/notyf.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
let balancesCache = [];

$(document).ready(function() {
    
    const ENCRYPTED_LEDGER_VAL = '<?= $encryptedVal ?>';

    let tblBalances = $('#tblBalances').DataTable({
        responsive: true,
        ajax: {
            url: '/CustomerBalances',
            type: 'POST',
            data: { action: 'get_balances' },
            dataSrc: function(json) {
                if(json.status === 'success') {
                    balancesCache = json.data || [];
                    
                    let totalReceivable = 0;
                    let totalPayable = 0;
                    let totalDebit = 0;
                    let totalCredit = 0;
                    let totalOverdue = 0;
                    
                    balancesCache.forEach(row => {
                        let debit = parseFloat(row.total_debit) || 0;
                        let credit = parseFloat(row.total_credit) || 0;
                        let overdue = parseFloat(row.overdue_amount) || 0;
                        let bal = parseFloat(row.balance) || 0;
                        
                        totalDebit += debit;
                        totalCredit += credit;
                        totalOverdue += overdue;
                        
                        if (bal > 0) totalReceivable += bal;
                        if (bal < 0) totalPayable += Math.abs(bal);
                    });
                    
                    let netBal = totalReceivable - totalPayable;
                    
                    // Update KPI Cards from backend kpis
                    const kpis = json.kpis || {};
                    cbLastKpis = kpis;
                    if (kpis.as_of_date) $('#lbl_as_of_date').text(kpis.as_of_date);
                    $('#kpi_total_customers').text(kpis.total_customers ?? balancesCache.length);
                    $('#kpi_active_customers').text(kpis.active_customers ?? 0);
                    $('#kpi_blacklisted_customers').text(kpis.blacklisted_customers ?? 0);
                    $('#lblTotalCollected').text(parseFloat(kpis.total_collected ?? totalCredit).toFixed(3));
                    $('#lblLedgerOutstanding').text(parseFloat(kpis.ledger_outstanding ?? 0).toFixed(3));
                    $('#lblOverdueOutstanding').text(parseFloat(kpis.overdue_outstanding ?? totalOverdue).toFixed(3));
                    $('#lblTotalReceivable').text(parseFloat(kpis.total_outstanding ?? totalReceivable).toFixed(3));
                    $('#lblTotalPayable').text(parseFloat(kpis.total_overpaid ?? totalPayable).toFixed(3));

                    const pmList = Array.isArray(kpis.payment_methods) ? kpis.payment_methods : [];
                    if (pmList.length) {
                        $('#lblPaymentMethodsStrip').html(pmList.map(pm => `
                            <span class="badge bg-label-success border px-2 py-1" style="font-size:0.8rem;">
                                ${escapeHtml(pm.method)}: <strong>${parseFloat(pm.amount || 0).toFixed(3)} BHD</strong>
                            </span>
                        `).join(''));
                    } else {
                        $('#lblPaymentMethodsStrip').html('<span class="text-muted small">No collections recorded</span>');
                    }
                    
                    // Update Footer Totals
                    $('#foot_total_debit').text(totalDebit.toFixed(3) + ' BHD');
                    $('#foot_total_credit').text(totalCredit.toFixed(3) + ' BHD');
                    $('#foot_total_overdue').text(totalOverdue.toFixed(3) + ' BHD');
                    $('#foot_net_balance').html(netBal >= 0 
                        ? `<span class="text-danger">${netBal.toFixed(3)} BHD</span>` 
                        : `<span class="text-success">${Math.abs(netBal).toFixed(3)} (Cr) BHD</span>`);
                    
                    return balancesCache;
                }
                return [];
            }
        },
        columns: [
            // Row Index
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            // Customer Details & Status Column (Identical to Contract List + Status Badges)
            { 
                data: null,
                render: function(data, type, row) {
                    const ledBal = parseFloat(row.ledger_balance || 0);
                    const ovAmt = parseFloat(row.overdue_amount || 0);
                    const bal = parseFloat(row.balance || 0);

                    if (type === 'filter' || type === 'sort') {
                        return `${row.customer_name || ''} ${row.customer_id || ''} ${row.customer_mobile || ''} ${row.customer_cr_cpr || ''} ${row.customer_email || ''} ${row.is_blacklisted ? 'Blacklisted' : ''} ${ovAmt > 0 ? 'Overdue' : ''}`;
                    }
                    let meta = [];
                    if (row.customer_mobile && row.customer_mobile !== '-') meta.push(`<i class="ri-phone-line me-1"></i>${escapeHtml(row.customer_mobile)}`);
                    if (row.customer_cr_cpr && row.customer_cr_cpr !== 'N/A' && row.customer_cr_cpr !== '-') meta.push(`<i class="ri-id-card-line me-1"></i>${escapeHtml(row.customer_cr_cpr)}`);
                    if (row.customer_nationality) meta.push(`<i class="ri-global-line me-1"></i>${escapeHtml(row.customer_nationality)}`);
                    let emailLine = row.customer_email ? `<small class="text-muted d-block text-truncate" style="max-width:240px;"><i class="ri-mail-line me-1"></i>${escapeHtml(row.customer_email)}</small>` : '';

                    let badges = [];
                    if (row.is_blacklisted) {
                        badges.push('<span class="badge bg-dark"><i class="ri-user-forbid-line me-1"></i>Blacklisted</span>');
                    }
                    if (ledBal <= 0 && ovAmt > 0) {
                        badges.push('<span class="badge bg-label-success">Ledger Paid</span>');
                        badges.push('<span class="badge bg-danger"><i class="ri-time-line me-1"></i>Overdue Return Pending (Unposted)</span>');
                    } else if (bal > 0) {
                        badges.push('<span class="badge bg-danger"><i class="ri-alarm-warning-line me-1"></i>Pending Payment</span>');
                        if (ovAmt > 0) {
                            badges.push('<span class="badge bg-label-danger"><i class="ri-time-line me-1"></i>Overdue Return</span>');
                        }
                    } else if (bal < 0) {
                        badges.push('<span class="badge bg-success"><i class="ri-checkbox-circle-line me-1"></i>Overpaid (Credit)</span>');
                    } else {
                        badges.push('<span class="badge bg-secondary">Settled</span>');
                    }

                    if ((row.active_contracts_count || 0) > 0) {
                        badges.push(`<span class="badge bg-label-primary">${row.active_contracts_count} Active</span>`);
                    }
                    if ((row.bounced_cheques_count || 0) > 0) {
                        badges.push(`<span class="badge bg-label-warning text-dark">${row.bounced_cheques_count} Bounced Cheque</span>`);
                    }

                    return `
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex flex-wrap align-items-center gap-1">
                                <a href="javascript:void(0)" class="clickable-name fw-bold text-dark btn-open-cb-ledger" data-customer="${escapeHtml(row.customer_id || '')}" title="Open Customer Ledger Modal">${escapeHtml(row.customer_name || '-')}</a>
                                ${row.customer_id ? `<span class="badge bg-label-secondary">${escapeHtml(row.customer_id)}</span>` : ''}
                            </div>
                            <small class="text-muted d-flex flex-wrap gap-2">${meta.join(' ')}</small>
                            ${emailLine}
                            <div class="d-flex flex-wrap gap-1 mt-1">${badges.join('')}</div>
                        </div>
                    `;
                }
            },
            // Total Debit
            { 
                data: 'total_debit', 
                className: 'text-end text-danger fw-semibold', 
                render: (v, t, row) => {
                    const unp = parseFloat(row.unposted_debit || 0);
                    return parseFloat(v).toFixed(3) + ' BHD' + (unp > 0 ? `<div class="small text-muted fw-normal">Unposted: ${unp.toFixed(3)}</div>` : '');
                }
            },
            // Total Credit
            { 
                data: 'total_credit', 
                className: 'text-end text-success fw-semibold', 
                render: v => parseFloat(v).toFixed(3) + ' BHD'
            },
            // Overdue Return Amount
            {
                data: 'overdue_amount',
                className: 'text-end fw-semibold',
                render: v => {
                    let ov = parseFloat(v) || 0;
                    return ov > 0
                        ? `<span class="text-danger">${ov.toFixed(3)} BHD</span>`
                        : '<span class="text-muted">0.000 BHD</span>';
                }
            },
            // Balance Amount
            { 
                data: 'balance', 
                className: 'text-end fw-bold',
                render: function(v) {
                    let bal = parseFloat(v);
                    if (bal > 0) return `<span class="text-danger fs-6">${bal.toFixed(3)} BHD</span>`;
                    if (bal < 0) return `<span class="text-success fs-6">${Math.abs(bal).toFixed(3)} (Cr) BHD</span>`;
                    return `<span class="text-secondary">0.000 BHD</span>`;
                }
            },
            // Action Column (Open Ledger Modal)
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center no-print',
                render: function(data, type, row) {
                    return `
                        <button type="button" class="btn btn-outline-danger btn-xs btn-open-cb-ledger" data-customer="${escapeHtml(row.customer_id || '')}" title="Open Customer Ledger">
                            <i class="ri ri-file-list-3-line me-1"></i>Ledger
                        </button>
                    `;
                }
            }
        ],
        order: [[1, 'asc']],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search customer name, code, CPR...",
            emptyTable: "No customer balances found."
        }
    });

    let activeStatusFilter = 'all';
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        if (settings.nTable.id !== 'tblBalances' || activeStatusFilter === 'all') return true;
        const row = tblBalances.row(dataIndex).data();
        if (!row) return true;
        const ledBal = parseFloat(row.ledger_balance || 0);
        const ovAmt = parseFloat(row.overdue_amount || 0);
        const bal = parseFloat(row.balance || 0);
        if (activeStatusFilter === 'pending') return bal > 0;
        if (activeStatusFilter === 'overdue') return ovAmt > 0;
        if (activeStatusFilter === 'paid_overdue') return ledBal <= 0 && ovAmt > 0;
        if (activeStatusFilter === 'overpaid') return bal < 0;
        if (activeStatusFilter === 'settled') return Math.abs(bal) <= 0.0001;
        if (activeStatusFilter === 'blacklisted') return !!row.is_blacklisted;
        return true;
    });

    $(document).on('click', '.cb-filter-pill', function() {
        $('.cb-filter-pill').removeClass('active btn-primary').addClass('btn-outline-secondary');
        $(this).addClass('active');
        activeStatusFilter = $(this).data('filter') || 'all';
        tblBalances.draw();
    });

    let cbLedDataTable = null;
    let cbCurrentLedger = { customer: null, entries: [], debit: 0, credit: 0, balance: 0 };

    function fmtCbDate(val) {
        if (!val || val === '0000-00-00') return '-';
        const s = String(val).slice(0, 10);
        const p = s.split('-');
        if (p.length === 3 && p[0].length === 4) {
            const ms = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            const mi = parseInt(p[1], 10) - 1;
            if (mi >= 0 && mi < 12) return `${p[2]}-${ms[mi]}-${p[0]}`;
        }
        return s;
    }

    $(document).on('click', '.btn-open-cb-ledger', function() {
        const custCode = String($(this).data('customer') || '');
        const row = balancesCache.find(r => String(r.customer_id) === custCode);
        if (!row) return;

        cbCurrentLedger = { customer: row, entries: [], debit: 0, credit: 0, balance: 0 };
        $('#cb_led_cust_name, #cb_led_info_name').text(row.customer_name || '-');
        $('#cb_led_cust_code').text(row.customer_id || '-');
        $('#cb_led_info_mobile').text(row.customer_mobile || '-');
        $('#cb_led_info_cpr').text(row.customer_cr_cpr || '-');
        $('#cb_led_info_email').text(row.customer_email || '-');
        $('#cb_led_full_page_link').attr('href', `/CustomerLedger?val=${ENCRYPTED_LEDGER_VAL}&customer_code=${encodeURIComponent(row.customer_id)}&customer_name=${encodeURIComponent(row.customer_name)}`);

        // Populate Unposted / Active Overdue section if present
        const unpList = Array.isArray(row.unposted_or_overdue) ? row.unposted_or_overdue : [];
        if (unpList.length > 0) {
            $('#cb_led_unposted_tbody').html(unpList.map(u => `<tr>
                <td class="fw-semibold">${escapeHtml(u.agreement_no || '-')}</td>
                <td>${escapeHtml(u.vehicle_no || '-')}</td>
                <td><span class="badge bg-label-primary">${escapeHtml(u.status || '-')}</span></td>
                <td class="text-end">${parseFloat(u.unposted_debit || 0).toFixed(3)} BHD</td>
                <td class="text-end">${u.overdue_days > 0 ? u.overdue_days + 'd' : '-'}</td>
                <td class="text-end text-danger fw-bold">${parseFloat(u.overdue_amount || 0).toFixed(3)} BHD</td>
            </tr>`).join(''));
            $('#cb_led_unposted_wrap').removeClass('d-none');
        } else {
            $('#cb_led_unposted_wrap').addClass('d-none');
        }

        if ($.fn.DataTable.isDataTable('#cb_led_table')) {
            $('#cb_led_table').DataTable().destroy();
            cbLedDataTable = null;
        }
        $('#cb_led_tot_debit, #cb_led_tot_credit, #cb_led_net_bal').text('0.000 BHD');
        $('#cb_led_tbody').html('<tr><td colspan="8" class="text-center text-muted py-3">Loading ledger...</td></tr>');
        new bootstrap.Modal(document.getElementById('cbCustomerLedgerModal')).show();

        $.getJSON('/CustomerLedgerController', { action: 'GetLedgerData', customer_code: row.customer_id }, function(res) {
            const rows = (res && Array.isArray(res.data)) ? res.data : (Array.isArray(res) ? res : []);
            if (!rows.length) {
                $('#cb_led_tbody').html('<tr><td colspan="8" class="text-center text-muted py-3">No posted ledger entries found.</td></tr>');
                $('#cb_led_tot_debit').text(parseFloat(row.total_debit || 0).toFixed(3) + ' BHD');
                $('#cb_led_tot_credit').text(parseFloat(row.total_credit || 0).toFixed(3) + ' BHD');
                $('#cb_led_net_bal').text(parseFloat(row.balance || 0).toFixed(3) + ' BHD');
                return;
            }
            let totD = 0, totC = 0, run = 0;
            const html = rows.map((r, i) => {
                const deb = parseFloat(r.debit || 0);
                const cred = ((r.cheque_status || '') === 'Bounced') ? 0 : parseFloat(r.credit || 0);
                totD += deb;
                totC += cred;
                run += (deb - cred);
                const desc = r.description || r.remarks || r.notes || '-';
                const mBadge = (r.payment_method && r.payment_method !== 'N/A') ? ` <span class="badge bg-label-info">${escapeHtml(r.payment_method)}</span>` : '';
                let recNo = '';
                const cmMatch = String(r.trans_type || '').match(/[A-Z0-9]+\/\d{4}\/CM\/\d+/i)
                    || String(r.ref_no || '').match(/[A-Z0-9]+\/\d{4}\/CM\/\d+/i)
                    || String(desc || '').match(/[A-Z0-9]+\/\d{4}\/CM\/\d+/i);
                if (cmMatch) recNo = cmMatch[0];
                else if (cred > 0 && r.ref_no && String(r.ref_no).trim() !== '' && String(r.ref_no).trim() !== '-') recNo = String(r.ref_no).trim();
                const printIcon = recNo ? ` <button type="button" class="btn btn-xs btn-outline-success py-0 px-1 cb-print-receipt" data-receipt="${escapeHtml(recNo)}" title="Print Receipt ${escapeHtml(recNo)}"><i class="ri-printer-line"></i></button>` : '';
                return `<tr>
                    <td class="text-center">${i + 1}</td>
                    <td class="text-nowrap">${escapeHtml(fmtCbDate(r.trans_date || r.created_at))}</td>
                    <td class="text-nowrap fw-semibold">${escapeHtml(r.agreement_no || '-')}</td>
                    <td class="text-nowrap"><span class="badge bg-label-primary">${escapeHtml(r.trans_type || '-')}</span>${mBadge}${printIcon}</td>
                    <td>${escapeHtml(desc)}</td>
                    <td class="text-end text-danger">${deb > 0 ? deb.toFixed(3) : '-'}</td>
                    <td class="text-end text-success">${cred > 0 ? cred.toFixed(3) : '-'}</td>
                    <td class="text-end fw-bold">${run.toFixed(3)}</td>
                </tr>`;
            }).join('');
            cbCurrentLedger = { customer: row, entries: rows, debit: totD, credit: totC, balance: run };
            $('#cb_led_tbody').html(html);
            cbLedDataTable = $('#cb_led_table').DataTable({
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                ordering: false,
                language: { search: "_INPUT_", searchPlaceholder: "Search ledger..." }
            });
            $('#cb_led_tot_debit').text(parseFloat(row.total_debit || totD).toFixed(3) + ' BHD');
            $('#cb_led_tot_credit').text(parseFloat(row.total_credit || totC).toFixed(3) + ' BHD');
            $('#cb_led_net_bal').text(parseFloat(row.balance || run).toFixed(3) + ' BHD');
        });
    });

    $(document).on('click', '.cb-print-receipt', function() {
        const recNo = $.trim($(this).data('receipt') || '');
        if (!recNo) return;
        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(recNo))
            .then(r => r.text())
            .then(token => {
                if (token && token.trim()) window.open('/CashMemoPrint?token=' + encodeURIComponent(token.trim()), '_blank');
            });
    });

    $('#cb_led_btn_print_soa').on('click', function() {
        if (!cbCurrentLedger.customer) return;
        const c = cbCurrentLedger.customer;
        let run = 0;
        const rowsHtml = cbCurrentLedger.entries.map(r => {
            const deb = parseFloat(r.debit || 0);
            const cred = ((r.cheque_status || '') === 'Bounced') ? 0 : parseFloat(r.credit || 0);
            run += (deb - cred);
            return `<tr>
                <td>${escapeHtml(fmtCbDate(r.trans_date || r.created_at))}</td>
                <td>${escapeHtml(r.agreement_no || '-')}</td>
                <td>${escapeHtml(r.trans_type || '-')}</td>
                <td>${escapeHtml(r.description || '-')}</td>
                <td style="text-align:right;">${deb > 0 ? deb.toFixed(3) : '-'}</td>
                <td style="text-align:right;">${cred > 0 ? cred.toFixed(3) : '-'}</td>
                <td style="text-align:right;font-weight:bold;">${run.toFixed(3)}</td>
            </tr>`;
        }).join('');
        const w = window.open('', '_blank');
        w.document.write(`<!doctype html><html><head><title>SOA - ${escapeHtml(c.customer_name)}</title>
            <style>body{font-family:Arial,sans-serif;padding:20px;font-size:12px;} table{width:100%;border-collapse:collapse;margin-top:12px;} th,td{border:1px solid #cbd5e1;padding:6px;} th{background:#f1f5f9;text-align:left;} .hdr{display:flex;justify-content:space-between;border-bottom:2px solid #1b3d94;padding-bottom:8px;}</style>
            </head><body>
            <div class="hdr"><div><h3 style="margin:0;color:#1b3d94;">STATEMENT OF ACCOUNT (SOA)</h3><div>Customer: <strong>${escapeHtml(c.customer_name)}</strong> (${escapeHtml(c.customer_id)})</div></div>
            <div style="text-align:right;"><div>Mobile: ${escapeHtml(c.customer_mobile || '-')}</div><div>CPR: ${escapeHtml(c.customer_cr_cpr || '-')}</div></div></div>
            <table><thead><tr><th>Date</th><th>Agreement</th><th>Type</th><th>Description</th><th style="text-align:right;">Debit</th><th style="text-align:right;">Credit</th><th style="text-align:right;">Balance</th></tr></thead>
            <tbody>${rowsHtml || '<tr><td colspan="7" style="text-align:center;">No entries</td></tr>'}</tbody>
            <tfoot><tr><th colspan="4" style="text-align:right;">Totals (BHD)</th><th style="text-align:right;">${cbCurrentLedger.debit.toFixed(3)}</th><th style="text-align:right;">${cbCurrentLedger.credit.toFixed(3)}</th><th style="text-align:right;">${cbCurrentLedger.balance.toFixed(3)}</th></tr></tfoot></table>
            <script>window.onload=function(){window.print();};<\/script></body></html>`);
        w.document.close();
    });

    const CB_PRINT_HEADER_HTML = <?= json_encode($cbHeaderHtml, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const CB_PRINT_FOOTER_HTML = <?= json_encode($cbFooterHtml, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const CB_PRINT_SETTINGS = <?= json_encode($cbPrintSettings, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    let cbLastKpis = {};

    // Export to Excel & PDF
    $('#btn_export_excel').on('click', function() {
        exportBalancesToExcel();
    });
    $('#btn_export_pdf').on('click', function() {
        exportBalancesToPDF();
    });

    function getFilteredBalancesForExport() {
        if (!tblBalances) return balancesCache || [];
        const filtered = tblBalances.rows({ search: 'applied' }).data().toArray();
        return filtered.length ? filtered : (balancesCache || []);
    }

    function buildExportStatusText(row) {
        const ledBal = parseFloat(row.ledger_balance || 0);
        const ovAmt = parseFloat(row.overdue_amount || 0);
        const bal = parseFloat(row.balance || 0);
        const parts = [];
        if (row.is_blacklisted) parts.push('Blacklisted');
        if (ledBal <= 0 && ovAmt > 0) parts.push('Ledger Paid + Overdue Return Pending');
        else if (bal > 0) parts.push(ovAmt > 0 ? 'Pending Payment + Overdue Return' : 'Pending Payment');
        else if (bal < 0) parts.push('Overpaid (Credit)');
        else parts.push('Settled');
        return parts.join(' | ');
    }

    function exportBalancesToExcel() {
        const list = getFilteredBalancesForExport();
        if (!list.length) { alert('No data to export.'); return; }
        const ps = CB_PRINT_SETTINGS || {};
        const k = cbLastKpis || {};
        let totD = 0, totC = 0, totO = 0, totB = 0;
        const rowsHtml = list.map((row, i) => {
            const d = parseFloat(row.total_debit || 0);
            const c = parseFloat(row.total_credit || 0);
            const o = parseFloat(row.overdue_amount || 0);
            const b = parseFloat(row.balance || 0);
            totD += d; totC += c; totO += o; totB += b;
            return `<tr>
                <td style="text-align:center;">${i + 1}</td>
                <td>${escapeHtml(row.customer_id || '')}</td>
                <td>${escapeHtml(row.customer_name || '')}</td>
                <td>${escapeHtml(row.customer_mobile || '')}</td>
                <td>${escapeHtml(row.customer_cr_cpr || '')}</td>
                <td>${escapeHtml(buildExportStatusText(row))}</td>
                <td style="text-align:right;">${d.toFixed(3)}</td>
                <td style="text-align:right;">${c.toFixed(3)}</td>
                <td style="text-align:right;">${o.toFixed(3)}</td>
                <td style="text-align:right;font-weight:bold;">${b.toFixed(3)}</td>
            </tr>`;
        }).join('');

        const xlsHtml = `
            <html xmlns:x="urn:schemas-microsoft-com:office:excel">
            <head><meta charset="UTF-8"><style>table{border-collapse:collapse;font-family:Arial,sans-serif;font-size:11pt;} th,td{border:1px solid #cbd5e1;padding:5px 8px;} th{background:#eef3fc;color:#1b3d94;}</style></head>
            <body>
              <table>
                <tr><td colspan="10" style="font-size:14pt;font-weight:bold;color:#1b3d94;border:none;">${escapeHtml(ps.company_name || 'FAST LINK CAR RENTAL')}</td></tr>
                ${ps.header_subtitle ? `<tr><td colspan="10" style="font-size:10pt;color:#475569;border:none;">${escapeHtml(ps.header_subtitle)}</td></tr>` : ''}
                ${ps.header_address ? `<tr><td colspan="10" style="font-size:9.5pt;color:#475569;border:none;">${escapeHtml(ps.header_address)} ${ps.header_phone ? ' | Tel: ' + escapeHtml(ps.header_phone) : ''} ${ps.header_email ? ' | ' + escapeHtml(ps.header_email) : ''}</td></tr>` : ''}
                <tr><td colspan="10" style="font-size:12pt;font-weight:bold;color:#1e293b;border:none;">Customer Balance Report — As of Today: ${escapeHtml(k.as_of_date || $('#lbl_as_of_date').text())}</td></tr>
                <tr><td colspan="10" style="font-size:9.5pt;color:#475569;border:none;">Customers: ${k.total_customers || 0} (Active: ${k.active_customers || 0}, Blacklisted: ${k.blacklisted_customers || 0}) | Total Collected: ${parseFloat(k.total_collected || 0).toFixed(3)} BHD | Ledger Outstanding: ${parseFloat(k.ledger_outstanding || 0).toFixed(3)} BHD | Overdue: ${parseFloat(k.overdue_outstanding || 0).toFixed(3)} BHD | Total Outstanding: ${parseFloat(k.total_outstanding || 0).toFixed(3)} BHD</td></tr>
                <tr><td colspan="10" style="border:none;"></td></tr>
                <tr>
                  <th>#</th><th>Code</th><th>Customer Name</th><th>Mobile</th><th>CPR / CR</th><th>Status</th>
                  <th>Total Debit (BHD)</th><th>Total Credit (BHD)</th><th>Overdue Return (BHD)</th><th>Balance (BHD)</th>
                </tr>
                ${rowsHtml}
                <tr style="font-weight:bold;background:#eef3fc;">
                  <td colspan="6" style="text-align:right;">Totals (BHD)</td>
                  <td style="text-align:right;">${totD.toFixed(3)}</td>
                  <td style="text-align:right;">${totC.toFixed(3)}</td>
                  <td style="text-align:right;">${totO.toFixed(3)}</td>
                  <td style="text-align:right;">${totB.toFixed(3)}</td>
                </tr>
                <tr><td colspan="10" style="border:none;"></td></tr>
                <tr><td colspan="10" style="font-size:9pt;color:#64748b;border:none;">${escapeHtml(ps.footer_text || 'Thank you for choosing Fastlink Car Rental.')} ${ps.footer_note ? ' — ' + escapeHtml(ps.footer_note) : ''}</td></tr>
              </table>
            </body></html>`;

        const blob = new Blob(['\ufeff', xlsHtml], { type: 'application/vnd.ms-excel;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `Customer_Balance_Report_${new Date().toISOString().slice(0,10)}.xls`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function hexToRgbArray(hex, fallback) {
        if (!hex || typeof hex !== 'string') return fallback;
        const clean = hex.replace('#', '').trim();
        if (!/^[0-9a-fA-F]{6}$/.test(clean)) return fallback;
        return [parseInt(clean.slice(0, 2), 16), parseInt(clean.slice(2, 4), 16), parseInt(clean.slice(4, 6), 16)];
    }

    function exportBalancesToPDF() {
        const list = getFilteredBalancesForExport();
        if (!list.length) { alert('No data to export.'); return; }
        if (!window.jspdf || !window.jspdf.jsPDF) {
            alert('PDF library is loading. Please try again in a moment.');
            return;
        }
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'pt', 'a4');
        const ps = CB_PRINT_SETTINGS || {};
        const k = cbLastKpis || {};
        const accentRgb = hexToRgbArray(ps.accent_color, [27, 61, 148]);
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const marginX = 32;

        const imgData = ps.logo_base64 || '';
        const showLogo = Number(ps.show_logo !== undefined ? ps.show_logo : 1) === 1;
        const logoW = Math.min(130, Math.max(70, Number(ps.logo_width || 120) * 0.8));
        const logoH = logoW / 2.8;

        let totD = 0, totC = 0, totO = 0, totB = 0;
        const bodyRows = list.map((row, i) => {
            const d = parseFloat(row.total_debit || 0);
            const c = parseFloat(row.total_credit || 0);
            const o = parseFloat(row.overdue_amount || 0);
            const b = parseFloat(row.balance || 0);
            totD += d; totC += c; totO += o; totB += b;
            const contact = [row.customer_mobile, row.customer_cr_cpr ? 'CPR: ' + row.customer_cr_cpr : ''].filter(Boolean).join(' | ');
            return [
                String(i + 1),
                `${row.customer_name || ''} (${row.customer_id || ''})${contact ? '\n' + contact : ''}`,
                buildExportStatusText(row),
                d.toFixed(3),
                c.toFixed(3),
                o.toFixed(3),
                b.toFixed(3)
            ];
        });
        bodyRows.push([
            { content: 'Totals (BHD)', colSpan: 3, styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } },
            { content: totD.toFixed(3), styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } },
            { content: totC.toFixed(3), styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } },
            { content: totO.toFixed(3), styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } },
            { content: totB.toFixed(3), styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } }
        ]);

        const pmLine = Array.isArray(k.payment_methods) && k.payment_methods.length
            ? k.payment_methods.map(p => `${p.method}: ${parseFloat(p.amount || 0).toFixed(3)} BHD`).join('  |  ')
            : '-';

        doc.autoTable({
            head: [['#', 'Customer Details', 'Payment & Return Status', 'Debit (BHD)', 'Credit (BHD)', 'Overdue (BHD)', 'Balance (BHD)']],
            body: bodyRows,
            startY: 136,
            theme: 'grid',
            styles: { fontSize: 8.5, font: 'helvetica', cellPadding: 5, valign: 'middle', lineColor: [215, 222, 235], lineWidth: 0.4 },
            headStyles: { fillColor: accentRgb, textColor: 255, fontStyle: 'bold' },
            columnStyles: {
                0: { cellWidth: 28, halign: 'center' },
                1: { cellWidth: 220 },
                2: { cellWidth: 165 },
                3: { cellWidth: 80, halign: 'right' },
                4: { cellWidth: 80, halign: 'right' },
                5: { cellWidth: 85, halign: 'right' },
                6: { cellWidth: 88, halign: 'right', fontStyle: 'bold' }
            },
            alternateRowStyles: { fillColor: [248, 250, 253] },
            margin: { top: 96, left: marginX, right: marginX, bottom: 48 },
            didDrawPage: function(data) {
                if (showLogo && imgData) {
                    try { doc.addImage(imgData, 'PNG', marginX, 18, logoW, logoH); } catch (e) {}
                }
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(15);
                doc.setTextColor(accentRgb[0], accentRgb[1], accentRgb[2]);
                doc.text(String(ps.company_name || 'FAST LINK CAR RENTAL'), pageWidth / 2, 30, { align: 'center' });

                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9);
                doc.setTextColor(80, 90, 105);
                if (ps.header_subtitle) doc.text(String(ps.header_subtitle), pageWidth / 2, 43, { align: 'center' });
                if (ps.header_address) doc.text(String(ps.header_address), pageWidth / 2, 55, { align: 'center' });

                const rightX = pageWidth - marginX;
                let rightY = 26;
                doc.setFontSize(8);
                if (ps.header_phone) { doc.text('Tel: ' + String(ps.header_phone), rightX, rightY, { align: 'right' }); rightY += 11; }
                if (ps.header_email) { doc.text(String(ps.header_email), rightX, rightY, { align: 'right' }); rightY += 11; }
                if (ps.header_website) { doc.text(String(ps.header_website), rightX, rightY, { align: 'right' }); }

                doc.setDrawColor(accentRgb[0], accentRgb[1], accentRgb[2]);
                doc.setLineWidth(1.2);
                doc.line(marginX, 68, pageWidth - marginX, 68);

                if (data.pageNumber === 1) {
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(12);
                    doc.setTextColor(30, 41, 59);
                    doc.text('CUSTOMER BALANCE REPORT', marginX, 86);

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(8.5);
                    doc.setTextColor(71, 85, 105);
                    doc.text(`Customers: ${k.total_customers || 0} (Active: ${k.active_customers || 0}, Blacklisted: ${k.blacklisted_customers || 0})  |  Collected: ${parseFloat(k.total_collected || 0).toFixed(3)} BHD  |  Ledger Outst.: ${parseFloat(k.ledger_outstanding || 0).toFixed(3)} BHD  |  Overdue: ${parseFloat(k.overdue_outstanding || 0).toFixed(3)} BHD`, marginX, 102);
                    doc.text(`Collections by Method: ${pmLine}`, marginX, 116);

                    doc.text(`As of Today: ${k.as_of_date || $('#lbl_as_of_date').text()}`, rightX, 86, { align: 'right' });
                    doc.setFont('helvetica', 'bold');
                    doc.text(`Total Outstanding: ${parseFloat(k.total_outstanding || 0).toFixed(3)} BHD  |  Overpaid: ${parseFloat(k.total_overpaid || 0).toFixed(3)} BHD`, rightX, 102, { align: 'right' });
                } else {
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(10);
                    doc.setTextColor(71, 85, 105);
                    doc.text('Customer Balance Report (Cont.)', marginX, 84);
                }

                const footerY = pageHeight - 28;
                doc.setDrawColor(203, 213, 225);
                doc.setLineWidth(0.6);
                doc.line(marginX, footerY - 10, pageWidth - marginX, footerY - 10);
                if (Number(ps.show_footer !== undefined ? ps.show_footer : 1) === 1) {
                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(8);
                    doc.setTextColor(71, 85, 105);
                    if (ps.footer_text) doc.text(String(ps.footer_text), marginX, footerY);
                    if (ps.footer_note) {
                        doc.setFontSize(7.5);
                        doc.setTextColor(120, 130, 145);
                        doc.text(String(ps.footer_note), marginX, footerY + 11);
                    }
                }
                let pageStr = 'Page ' + doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') pageStr += ' of totalPages';
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(8);
                doc.setTextColor(71, 85, 105);
                doc.text(pageStr, rightX, footerY, { align: 'right' });
            }
        });

        if (typeof doc.putTotalPages === 'function') {
            doc.putTotalPages('totalPages');
        }
        window.open(doc.output('bloburl'), '_blank');
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
});
</script>

</body>
</html>
