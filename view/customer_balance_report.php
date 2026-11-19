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
          
                        <!-- Top Title & Action Bar matching Contract Status & Return Overdue Report -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2 no-print">
                            <div>
                                <h4 class="fw-bold mb-1">
                                    <i class="ri ri-wallet-3-line text-danger me-2"></i>Customer Balances Summary Report
                                </h4>
                                <p class="text-muted mb-0">
                                    Monitor customer balances, total debits, total credits, outstanding receivables, and refund liabilities in real time.
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="btn_export_excel" class="btn btn-outline-success btn-sm">
                                    <i class="ri ri-file-excel-2-line me-1"></i> Export to Excel
                                </button>
                            </div>
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
                                            <th width="32%">Customer Details</th>
                                            <th width="16%" class="text-end">Total Debit (Owed)</th>
                                            <th width="16%" class="text-end">Total Credit (Paid)</th>
                                            <th width="12%" class="text-center">Status</th>
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
                    
                    balancesCache.forEach(row => {
                        let debit = parseFloat(row.total_debit) || 0;
                        let credit = parseFloat(row.total_credit) || 0;
                        let bal = parseFloat(row.balance) || 0;
                        
                        totalDebit += debit;
                        totalCredit += credit;
                        
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
            // Customer Details Column (Name, Code, Mobile, CPR)
            { 
                data: null,
                render: function(data, type, row) {
                    let url = `/CustomerLedger?val=${ENCRYPTED_LEDGER_VAL}&customer_code=${encodeURIComponent(row.customer_id)}&customer_name=${encodeURIComponent(row.customer_name)}`;
                    
                    let codeBadge = row.customer_id 
                        ? `<span class="badge bg-light text-secondary border" style="font-size:0.75rem;"><i class="ri ri-hashtag me-1"></i>${escapeHtml(row.customer_id)}</span>` 
                        : '';
                        
                    let mobileLine = (row.customer_mobile && row.customer_mobile !== '-') 
                        ? `<span class="text-muted small"><i class="ri ri-phone-line text-primary me-1"></i>${escapeHtml(row.customer_mobile)}</span>` 
                        : '';
                        
                    let cprLine = (row.customer_cr_cpr && row.customer_cr_cpr !== 'N/A' && row.customer_cr_cpr !== '-') 
                        ? `<div class="small text-muted mt-1"><i class="ri ri-id-card-line text-danger me-1"></i>CPR: <strong>${escapeHtml(row.customer_cr_cpr)}</strong></div>` 
                        : '';

                    return `
                        <div>
                            <a href="${url}" class="clickable-name fw-bold fs-6" title="Click to view Customer Ledger">
                                <i class="ri ri-user-line me-1"></i>${escapeHtml(row.customer_name)}
                            </a>
                        </div>
                        <div class="mt-1 d-flex flex-wrap align-items-center gap-2">
                            ${codeBadge}
                            ${mobileLine}
                        </div>
                        ${cprLine}
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
            // Action Column (View Ledger)
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center no-print',
                render: function(data, type, row) {
                    let url = `/CustomerLedger?val=${ENCRYPTED_LEDGER_VAL}&customer_code=${encodeURIComponent(row.customer_id)}&customer_name=${encodeURIComponent(row.customer_name)}`;
                    return `
                        <a href="${url}" class="btn btn-outline-danger btn-xs" title="Open Customer Ledger">
                            <i class="ri ri-file-list-3-line me-1"></i>Ledger
                        </a>
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
