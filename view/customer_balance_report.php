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
                        <div class="d-flex justify-content-end mb-3 gap-2 no-print">
                            <button type="button" id="btn_export_excel" class="btn btn-outline-success btn-sm">
                                <i class="ri ri-file-excel-2-line me-1"></i> Export to Excel
                            </button>
                        </div>
                        
                        <!-- Summary KPI Metrics Cards matching Contract Status & Return Overdue Report -->
                        <div class="row g-3 mb-4 no-print" id="kpiContainer">
                            <!-- Total Customers with Balance -->
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-blue h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Total Customers</span>
                                        <div class="kpi-icon-box bg-primary">
                                            <i class="ri ri-group-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0" id="kpi_total_customers">0</h3>
                                    <span class="text-muted small">With active ledger records</span>
                                </div>
                            </div>

                            <!-- Total Outstanding (Company Receives) -->
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-red pulse-danger h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-danger small fw-bold">Total Outstanding</span>
                                        <div class="kpi-icon-box bg-danger">
                                            <i class="ri ri-arrow-down-circle-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-danger" id="lblTotalReceivable">0.000</h3>
                                    <span class="text-danger small fw-semibold">Company should receive (BHD)</span>
                                </div>
                            </div>

                            <!-- Total Overpaid (Company Pays) -->
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-green h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Total Overpaid</span>
                                        <div class="kpi-icon-box bg-success">
                                            <i class="ri ri-arrow-up-circle-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-success" id="lblTotalPayable">0.000</h3>
                                    <span class="text-muted small">Company should refund (BHD)</span>
                                </div>
                            </div>

                            <!-- Net Balance -->
                            <div class="col-6 col-md-3">
                                <div class="card kpi-card kpi-amber h-100 p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted small fw-semibold">Net Balance</span>
                                        <div class="kpi-icon-box bg-warning">
                                            <i class="ri ri-money-dollar-circle-line"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0 text-dark" id="lblNetBalance">0.000</h3>
                                    <span class="text-muted small">Net outstanding amount (BHD)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Main Report Data Table Card -->
                        <div class="card border shadow-sm">
                            <div class="card-datatable table-responsive">
                                <table id="tblBalances" class="table table-bordered table-sm table-hover align-middle text-start" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="4%" class="text-center">#</th>
                                            <th width="28%">Customer Details</th>
                                            <th width="13%" class="text-end">Total Debit (Owed)</th>
                                            <th width="13%" class="text-end">Total Credit (Paid)</th>
                                            <th width="12%" class="text-end">Overdue Return</th>
                                            <th width="11%" class="text-center">Status</th>
                                            <th width="13%" class="text-end">Balance Amount</th>
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
                                            <td class="text-center"></td>
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

                    <!-- Ledger Table -->
                    <div class="table-responsive border rounded">
                        <table class="table table-sm table-bordered table-hover align-middle mb-0" style="font-size:12.5px;">
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
                    
                    // Update KPI Cards
                    $('#kpi_total_customers').text(balancesCache.length);
                    $('#lblTotalReceivable').text(totalReceivable.toFixed(3));
                    $('#lblTotalPayable').text(totalPayable.toFixed(3));
                    $('#lblNetBalance').text(netBal.toFixed(3));
                    
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
            // Customer Details Column (Identical to Contract List)
            { 
                data: null,
                render: function(data, type, row) {
                    if (type === 'filter' || type === 'sort') {
                        return `${row.customer_name || ''} ${row.customer_id || ''} ${row.customer_mobile || ''} ${row.customer_cr_cpr || ''} ${row.customer_email || ''}`;
                    }
                    let meta = [];
                    if (row.customer_mobile && row.customer_mobile !== '-') meta.push(`<i class="ri-phone-line me-1"></i>${escapeHtml(row.customer_mobile)}`);
                    if (row.customer_cr_cpr && row.customer_cr_cpr !== 'N/A' && row.customer_cr_cpr !== '-') meta.push(`<i class="ri-id-card-line me-1"></i>${escapeHtml(row.customer_cr_cpr)}`);
                    if (row.customer_nationality) meta.push(`<i class="ri-global-line me-1"></i>${escapeHtml(row.customer_nationality)}`);
                    let emailLine = row.customer_email ? `<small class="text-muted d-block text-truncate" style="max-width:220px;"><i class="ri-mail-line me-1"></i>${escapeHtml(row.customer_email)}</small>` : '';

                    return `
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex flex-wrap align-items-center gap-1">
                                <a href="javascript:void(0)" class="clickable-name fw-bold text-dark btn-open-cb-ledger" data-customer="${escapeHtml(row.customer_id || '')}" title="Open Customer Ledger Modal">${escapeHtml(row.customer_name || '-')}</a>
                                ${row.customer_id ? `<span class="badge bg-label-secondary">${escapeHtml(row.customer_id)}</span>` : ''}
                            </div>
                            <small class="text-muted d-flex flex-wrap gap-2">${meta.join(' ')}</small>
                            ${emailLine}
                        </div>
                    `;
                }
            },
            // Total Debit
            { 
                data: 'total_debit', 
                className: 'text-end text-danger fw-semibold', 
                render: v => parseFloat(v).toFixed(3) + ' BHD'
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
            // Status
            { 
                data: 'balance',
                className: 'text-center',
                render: function(v) {
                    let bal = parseFloat(v);
                    if (bal > 0) return '<span class="badge bg-danger"><i class="ri ri-alarm-warning-line me-1"></i>Pending Payment</span>';
                    if (bal < 0) return '<span class="badge bg-success"><i class="ri ri-checkbox-circle-line me-1"></i>Credit Balance</span>';
                    return '<span class="badge bg-secondary">Settled</span>';
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

        $('#cb_led_tot_debit, #cb_led_tot_credit, #cb_led_net_bal').text('0.000 BHD');
        $('#cb_led_tbody').html('<tr><td colspan="8" class="text-center text-muted py-3">Loading ledger...</td></tr>');
        new bootstrap.Modal(document.getElementById('cbCustomerLedgerModal')).show();

        $.getJSON('/CustomerLedgerController', { action: 'GetLedgerData', customer_code: row.customer_id }, function(res) {
            const rows = (res && Array.isArray(res.data)) ? res.data : (Array.isArray(res) ? res : []);
            if (!rows.length) {
                $('#cb_led_tbody').html('<tr><td colspan="8" class="text-center text-muted py-3">No ledger entries found.</td></tr>');
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
            $('#cb_led_tot_debit').text(totD.toFixed(3) + ' BHD');
            $('#cb_led_tot_credit').text(totC.toFixed(3) + ' BHD');
            $('#cb_led_net_bal').text(run.toFixed(3) + ' BHD');
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

    // Export to Excel / CSV
    $('#btn_export_excel').on('click', function() {
        exportBalancesToCSV();
    });

    function exportBalancesToCSV() {
        if (!balancesCache || balancesCache.length === 0) {
            alert('No data to export.');
            return;
        }

        let headers = [
            "#",
            "Customer Code",
            "Customer Name",
            "Mobile",
            "CPR / CR",
            "Total Debit (BHD)",
            "Total Credit (BHD)",
            "Overdue Return (BHD)",
            "Status",
            "Balance Amount (BHD)"
        ];

        let csvRows = [];
        csvRows.push(headers.map(h => `"${h}"`).join(','));

        balancesCache.forEach((row, i) => {
            let bal = parseFloat(row.balance) || 0;
            let status = bal > 0 ? "Pending Payment" : (bal < 0 ? "Credit Balance" : "Settled");

            let rowVals = [
                i + 1,
                row.customer_id || '',
                row.customer_name || '',
                row.customer_mobile || '',
                row.customer_cr_cpr || '',
                parseFloat(row.total_debit || 0).toFixed(3),
                parseFloat(row.total_credit || 0).toFixed(3),
                parseFloat(row.overdue_amount || 0).toFixed(3),
                status,
                bal.toFixed(3)
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
        link.setAttribute("download", `Customer_Balances_Summary_${new Date().toISOString().slice(0,10)}.csv`);
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
});
</script>

</body>
</html>
