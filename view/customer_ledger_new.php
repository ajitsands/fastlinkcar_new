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
?>
<?php
include ROOT_PATH . '/view/envinclude.php';
require_once ROOT_PATH . '/pdf/print_settings_helper.php';
$clCompanyId = !empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1;
$clPrintSettings = getPrintSettings(null, $clCompanyId);
?>
<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/notyf/notyf.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>
        .ledger-card { height: 100%; }
        .summary-card { border-left: 4px solid; }
        .card-total-debit { border-left-color: #ff4d49; }
        .card-total-credit { border-left-color: #72e128; }
        .card-balance { border-left-color: #26c6f9; }
        .row-collected { background-color: #e8fadf !important; }
        .row-bounced { background-color: #ffe5e5 !important; }
        .fc-event { cursor: pointer; }
    </style>
</head>
<body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <?php include ROOT_PATH . '/view/templates/nav.php'; ?>
            <div class="layout-page">
                <div class="content-wrapper">
                    <?php include ROOT_PATH . '/view/templates/menu.php'; ?>
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 100px !important;">
                        <div class="row mb-4 g-3">
                            <!-- Summary Cards -->
                            <div class="col-md-4">
                                <div class="card summary-card card-total-debit shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Total Debit (Owed)</h6>
                                        <h4 class="card-title mb-0" id="lblTotalDebit">0.000</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card summary-card card-total-credit shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Total Credit (Paid)</h6>
                                        <h4 class="card-title mb-0" id="lblTotalCredit">0.000</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card summary-card card-balance shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Current Balance</h6>
                                        <h4 class="card-title mb-0" id="lblBalance">0.000</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Search & Form Card -->
                            <div class="col-lg-4">
                                <div class="card ledger-card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Customer Selection</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label class="form-label">Search Customer (Name/Mobile)</label>
                                            <select id="selCustomer" class="form-select select2"></select>
                                        </div>
                                         <input type="hidden" name="customer_code" id="txtCustomerCode">
                                        <div class="mb-3">
                                            <label class="form-label">Select Agreement</label>
                                            <select id="selQuotation" class="form-select select2" disabled><option value="">Select Agreement</option></select>
                                        </div>

                                        <hr class="my-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Customer Agreements</h6>
                                            <span class="badge bg-label-primary" id="lblContractCount">0</span>
                                        </div>
                                        <div id="customerContractsList" class="d-flex flex-column gap-2" style="max-height: 460px; overflow-y: auto;">
                                            <div class="text-muted small text-center py-3">Select a customer to view agreements.</div>
                                        </div>
                                  
                                    </div>
                                </div>
                            </div>

                            <!-- Ledger Table Card -->
                            <div class="col-lg-8">
                                <div class="card ledger-card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Ledger Statement</h5>
                                        <button type="button" class="btn btn-primary" id="btnPrintSOA" disabled>
                                            <i class="ri-printer-line me-1"></i> Print SOA
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblLedger" class="table table-hover border-top align-middle" style="font-size: 13px; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type / Method</th>
                                                        <th>Reference &amp; Details</th>
                                                        <th class="text-center">Flag</th>
                                                        <th class="text-end">Debit</th>
                                                        <th class="text-end">Credit</th>
                                                        <th class="text-end">Balance</th>
                                                        <th>Agreement / Receipt</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div class="modal fade" id="modalChequeCalendar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cheque Collection Calendar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Filter by Customer</label>
                            <select id="selCalendarCustomer" class="form-select select2-modal"></select>
                        </div>
                        <div class="col-md-6 d-none" id="divPendingSummary">
                            <label class="form-label">Pending Cheques Summary</label>
                            <div id="pendingBadges" class="d-flex flex-wrap gap-1"></div>
                        </div>
                    </div>
                    <div id="chequeCalendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cheque Details Modal -->
    <div class="modal fade" id="modalChequeDetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cheques for <span id="lblSelectedDate"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tblChequeDetails" class="table table-sm border-top">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Reference</th>
                                    <th class="text-end">Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Add Bank -->
    <div class="modal fade" id="modalAddBank" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmAddBank">
                        <div class="mb-3">
                            <label class="form-label">Bank Name</label>
                            <input type="text" class="form-control" id="txtNewBankName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Number (Optional)</label>
                            <input type="text" class="form-control" id="txtNewAccountNo">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Bank</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Add Head -->
    <div class="modal fade" id="modalAddHead" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Head</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmAddHead">
                        <div class="mb-3">
                            <label class="form-label">Head Name</label>
                            <input type="text" class="form-control" id="txtNewHeadName" required placeholder="e.g. Refund">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="selNewHeadType" required>
                                <option value="Credit">Credit (Money Received)</option>
                                <option value="Debit">Debit (Charge/Invoice)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Head</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/moment/moment.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/notyf/notyf.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script>
        window.LEDGER_PRINT_SETTINGS = <?= json_encode($clPrintSettings, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    </script>

    <script>
    $(document).ready(function() {
        const userRole = '<?= $_SESSION['user_role_name'] ?? '' ?>';
        const currentUserId = '<?= $_SESSION['user_id'] ?? 0 ?>';
        const todayStr = '<?= date('Y-m-d') ?>';
        let ledgerTable = null;

        // Initialize Notyf
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' },
            types: [
                { type: 'success', background: '#72e128', icon: { className: 'ri-checkbox-circle-fill', tagName: 'i', color: 'white' } },
                { type: 'error', background: '#ff4d49', icon: { className: 'ri-close-circle-fill', tagName: 'i', color: 'white' } }
            ]
        });

        function showToast(msg, type = 'success') {
            notyf.open({ type: type, message: msg });
        }

        // Handle Payment Method change for Bank visibility
        $('#selPaymentMethod').on('change', function() {
            const method = $(this).val();
            if(method === 'Cheque') {
                $('#divBank').removeClass('d-none');
                $('#divCompanyBank').removeClass('d-none');
                $('#divChequeDate').removeClass('d-none');
                $('#divReference').removeClass('col-12').addClass('col-6');
                $('#txtChequeDate').attr('required', true);
                loadBanks();
                loadCompanyBanks();
            } else if(method === 'BankTransfer') {
                $('#divBank').addClass('d-none');
                $('#divCompanyBank').removeClass('d-none');
                $('#divChequeDate').addClass('d-none');
                $('#divReference').removeClass('col-6').addClass('col-12');
                $('#txtChequeDate').attr('required', false);
                loadCompanyBanks();
            } else {
                $('#divBank').addClass('d-none');
                $('#divCompanyBank').addClass('d-none');
                $('#divChequeDate').addClass('d-none');
                $('#divReference').removeClass('col-6').addClass('col-12');
                $('#txtChequeDate').attr('required', false);
                $('#selBank').val(null).trigger('change');
                $('#selCompanyBank').val(null).trigger('change');
            }
        });

        function loadCompanyBanks(selectedId = null) {
            $.get('/CustomerLedgerController', { action: 'GetBanks' }, function(data) {
                $('#selCompanyBank').empty().append('<option value="">Select Company Bank</option>');
                if(data.status && data.data) {
                    data.data.forEach(bank => {
                        const option = new Option(`${bank.text} (${bank.account_no})`, bank.id, false, bank.id == selectedId);
                        $('#selCompanyBank').append(option);
                    });
                    $('#selCompanyBank').trigger('change');
                }
            }, 'json');
        }

        function loadBanks(selectedId = null) {
            $.get('/CustomerLedgerController', { action: 'GetBanks' }, function(data) {
                $('#selBank').empty().append('<option value="">Select Bank</option>');
                // res is already parsed if dataType is 'json'
                if(data.status && data.data) {
                    data.data.forEach(bank => {
                        const option = new Option(bank.text, bank.id, false, bank.id == selectedId);
                        $('#selBank').append(option);
                    });
                    $('#selBank').trigger('change');
                }
            }, 'json');
        }

        function loadHeads(selectedName = null) {
            $.get('/CustomerLedgerController', { action: 'GetLedgerHeads' }, function(data) {
                $('#selTransType').empty().append('<option value="">Select Type</option>');
                if(data.status && data.data) {
                    data.data.forEach(head => {
                        const option = new Option(head.text, head.text, false, head.text == selectedName);
                        $(option).attr('data-head-type', head.head_type);
                        $('#selTransType').append(option);
                    });
                    $('#selTransType').trigger('change');
                }
            }, 'json');
        }
        
        loadHeads(); // Initial load

        // Add Head Modal logic
        $('#btnAddHead').on('click', () => $('#modalAddHead').modal('show'));
        $('#frmAddHead').on('submit', function(e) {
            e.preventDefault();
            const name = $('#txtNewHeadName').val();
            const type = $('#selNewHeadType').val();
            $.post('/CustomerLedgerController', { action: 'SaveLedgerHead', head_name: name, head_type: type }, function(res) {
                if(res.status) {
                    showToast('Head added successfully', 'success');
                    $('#modalAddHead').modal('hide');
                    $('#frmAddHead')[0].reset();
                    loadHeads(name);
                }
            }, 'json');
        });

        // Add Bank Modal logic
        $('#btnAddBank').on('click', () => $('#modalAddBank').modal('show'));
        $('#frmAddBank').on('submit', function(e) {
            e.preventDefault();
            const name = $('#txtNewBankName').val();
            const acc = $('#txtNewAccountNo').val();
            $.post('/CustomerLedgerController', { action: 'SaveBank', bank_name: name, account_no: acc }, function(res) {
                if(res.status) {
                    showToast('Bank added successfully', 'success');
                    $('#modalAddBank').modal('hide');
                    $('#frmAddBank')[0].reset();
                    loadBanks(res.last_id); 
                }
            }, 'json');
        });

        // Toggle Payment Method select based on type
        $('#selTransType').on('change', function() {
            const headType = $(this).find(':selected').data('head-type');
            if(headType === 'Debit') {
                $('#divPaymentMethod').addClass('d-none');
                $('#selPaymentMethod').val('N/A').trigger('change');
            } else {
                $('#divPaymentMethod').removeClass('d-none');
            }
        });

        let selectedCustomer = null;
        let currentLedgerRows = [];

        function escHtml(s) {
            return $('<div>').text(s == null ? '' : String(s)).html();
        }

        function getLedgerFlag(r) {
            const deb = parseFloat(r.debit || 0);
            const cred = parseFloat(r.credit || 0);
            if (r.payment_method === 'Cheque') {
                const st = r.cheque_status || 'Pending';
                if (st === 'Collected') return { label: 'Collected', cls: 'bg-success' };
                if (st === 'Bounced') return { label: 'Bounced', cls: 'bg-danger' };
                return { label: 'Pending Cheque', cls: 'bg-warning' };
            }
            if (cred > 0) return { label: 'Paid', cls: 'bg-label-success' };
            if (deb > 0) return { label: 'Charge', cls: 'bg-label-danger' };
            return { label: 'Info', cls: 'bg-label-secondary' };
        }

        function openEncryptedPrint(urlPath, docNo) {
            const cleanNo = $.trim(docNo || '');
            if (!cleanNo) return;
            fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(cleanNo))
                .then(res => res.text())
                .then(token => {
                    if (!token || !token.trim()) {
                        Swal.fire('Error', 'Encryption failed.', 'error');
                        return;
                    }
                    window.open(urlPath + '?token=' + encodeURIComponent(token.trim()), '_blank');
                });
        }

        // Initialize Select2 for Customer
        $('#selCustomer').select2({
            placeholder: 'Search Customer by name or mobile...',
            ajax: {
                url: '/CustomerLedgerController',
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term, action: 'SearchCustomer' }),
                processResults: data => ({ results: data.map(i => ({ id: i.customer_code, text: `${i.customer_name} (${i.customer_mobile || ''})`, raw: i })) })
            }
        }).on('select2:select', function(e) {
            const data = e.params.data.raw;
            selectedCustomer = data;
            $('#txtCustomerCode').val(data.customer_code);
            $('#btnPrintSOA').prop('disabled', false);
            loadCustomerDependents(data.customer_code);
            refreshLedger(data.customer_code, 'All');
        });

        // Deep-linking: Auto-load customer if passed in URL
        const urlParams = new URLSearchParams(window.location.search);
        const urlCustCode = urlParams.get('customer_code');
        const urlCustName = urlParams.get('customer_name');
        
        if (urlCustCode && urlCustName) {
            setTimeout(() => {
                var option = new Option(urlCustName, urlCustCode, true, true);
                $('#selCustomer').append(option).trigger('change');
                
                $('#selCustomer').trigger({
                    type: 'select2:select',
                    params: {
                        data: { raw: { customer_code: urlCustCode, customer_name: urlCustName, customer_mobile: '' } }
                    }
                });
            }, 300);
        }

        function loadCustomerDependents(code) {
            $.get('/CustomerLedgerController', { action: 'GetContracts', customer_code: code }, function(data) {
                $('#selQuotation').empty().append('<option value="All">All Agreements</option>').attr('disabled', false);
                (data || []).forEach(q => $('#selQuotation').append(new Option(q.text, q.id)));
            }, 'json');

            $('#customerContractsList').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></div>');
            $.get('/CustomerLedgerController', { action: 'GetCustomerContractsSummary', customer_code: code }, function(res) {
                const contracts = (res && res.data) ? res.data : [];
                $('#lblContractCount').text(contracts.length);
                if (!contracts.length) {
                    $('#customerContractsList').html('<div class="text-muted small text-center py-3">No agreements found for this customer.</div>');
                    return;
                }
                const html = contracts.map(c => {
                    const statusBadge = c.is_returned
                        ? '<span class="badge bg-label-secondary">Returned</span>'
                        : '<span class="badge bg-label-success">Active</span>';
                    const deb = parseFloat(c.total_debit || 0).toFixed(3);
                    const cred = parseFloat(c.total_credit || 0).toFixed(3);
                    const bal = parseFloat(c.balance || 0).toFixed(3);
                    const balCls = parseFloat(c.balance || 0) > 0 ? 'text-danger' : 'text-success';
                    const receipts = Array.isArray(c.receipts) ? c.receipts : [];

                    let receiptBtnHtml = '';
                    if (receipts.length === 1) {
                        receiptBtnHtml = `<button type="button" class="btn btn-xs btn-outline-success btn-print-receipt" data-receipt="${escHtml(receipts[0].cashmemo_no)}" title="Print Receipt ${escHtml(receipts[0].cashmemo_no)}"><i class="ri-receipt-line me-1"></i>Receipt</button>`;
                    } else if (receipts.length > 1) {
                        const items = receipts.map(rc => `<li><a class="dropdown-item btn-print-receipt" href="javascript:void(0)" data-receipt="${escHtml(rc.cashmemo_no)}">${escHtml(rc.cashmemo_no)} (${parseFloat(rc.net_total || 0).toFixed(3)})</a></li>`).join('');
                        receiptBtnHtml = `<div class="btn-group">
                            <button type="button" class="btn btn-xs btn-outline-success dropdown-toggle" data-bs-toggle="dropdown"><i class="ri-receipt-line me-1"></i>Receipts (${receipts.length})</button>
                            <ul class="dropdown-menu dropdown-menu-end">${items}</ul>
                        </div>`;
                    }

                    return `<div class="border rounded p-2 bg-light-subtle contract-summary-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <a href="javascript:void(0)" class="fw-bold text-primary view_contract" data-contract="${escHtml(c.agreement_no)}">${escHtml(c.agreement_no)}</a>
                                <div class="small text-muted">${escHtml(c.vehicle_no || '-')} ${c.model_name ? '· ' + escHtml(c.model_name) : ''}</div>
                            </div>
                            ${statusBadge}
                        </div>
                        <div class="d-flex justify-content-between small mt-2 pt-1 border-top">
                            <span>Debit: <strong>${deb}</strong></span>
                            <span>Paid: <strong class="text-success">${cred}</strong></span>
                            <span>Bal: <strong class="${balCls}">${bal}</strong></span>
                        </div>
                        <div class="d-flex flex-wrap gap-1 mt-2">
                            <button type="button" class="btn btn-xs btn-outline-primary btn-filter-contract" data-id="${c.contract_id}"><i class="ri-list-check me-1"></i>Ledger</button>
                            <button type="button" class="btn btn-xs btn-outline-secondary view_contract" data-contract="${escHtml(c.agreement_no)}"><i class="ri-file-text-line me-1"></i>Agreement</button>
                            ${receiptBtnHtml}
                        </div>
                    </div>`;
                }).join('');
                $('#customerContractsList').html(html);
            }, 'json');
        }

        $(document).on('click', '.btn-filter-contract', function() {
            const cid = $(this).data('id');
            $('#selQuotation').val(String(cid)).trigger('change');
        });

        $(document).on('click', '.btn-print-receipt', function() {
            openEncryptedPrint('/CashMemoPrint', $(this).data('receipt'));
        });

        $(document).on('change', '#selQuotation', function () {
            var contract_id = $(this).val();
            var code = $('#txtCustomerCode').val();
            if (code) refreshLedger(code, contract_id);
        });

        function refreshLedger(code, contract_id = null) {
            if ($.fn.DataTable.isDataTable('#tblLedger')) {
                $('#tblLedger').DataTable().destroy();
            }

            ledgerTable = $('#tblLedger').DataTable({
                ajax: {
                    url: '/CustomerLedgerController',
                    data: { action: 'GetCustomerContractLedgerData', customer_code: code, contract_id: contract_id },
                    dataSrc: function(json) {
                        const rows = (json && Array.isArray(json.data)) ? json.data : [];
                        currentLedgerRows = rows;
                        let totDebit = 0, totCredit = 0;
                        rows.forEach(r => {
                            totDebit += parseFloat(r.debit || 0);
                            totCredit += parseFloat(r.credit || 0);
                        });
                        $('#lblTotalDebit').text(totDebit.toFixed(3));
                        $('#lblTotalCredit').text(totCredit.toFixed(3));
                        $('#lblBalance').text((totDebit - totCredit).toFixed(3));
                        return rows;
                    }
                },
                columns: [
                    { 
                        data: 'trans_date',
                        className: 'text-nowrap',
                        render: v => v ? moment(v).format('DD MMM YYYY') : '-'
                    },
                    { 
                        data: null, 
                        render: r => {
                            const method = (r.payment_method && r.payment_method !== 'N/A') ? `<span class="badge bg-label-info mt-1">${escHtml(r.payment_method)}</span>` : '<small class="text-muted">N/A</small>';
                            return `<div class="fw-semibold">${escHtml(r.trans_type || '-')}</div>${method}`;
                        }
                    },
                    { 
                        data: null, 
                        render: r => {
                            let out = `<div class="fw-semibold">${escHtml(r.ref_no || '-')} ${r.cheque_date ? `<span class="text-info fw-normal ms-1" style="font-size:11px">(${moment(r.cheque_date).format('DD MMM YYYY')})</span>` : ''}</div>`;
                            if (r.description) {
                                out += `<div class="small text-muted">${escHtml(r.description)}</div>`;
                            }
                            if (r.bank_name) {
                                out += `<div style="font-size:11px" class="text-primary"><i class="ri-bank-line me-1"></i>From: ${escHtml(r.bank_name)} ${r.account_no ? '(' + escHtml(r.account_no) + ')' : ''}</div>`;
                            }
                            if (r.company_bank_name) {
                                out += `<div style="font-size:11px" class="text-success"><i class="ri-bank-fill me-1"></i>To: ${escHtml(r.company_bank_name)} ${r.company_account_no ? '(' + escHtml(r.company_account_no) + ')' : ''}</div>`;
                            }
                            if (r.cheque_status === 'Collected' && r.collected_at) {
                                out += `<div style="font-size:11px" class="text-success fw-medium"><i class="ri-checkbox-circle-line me-1"></i>Collected: ${moment(r.collected_at).format('DD MMM YYYY')}</div>`;
                            }
                            if (r.quotation_no || r.booking_no) {
                                out += `<div style="font-size:11px" class="text-muted"><i class="ri-links-line me-1"></i>${escHtml(r.quotation_no || r.booking_no || '')}</div>`;
                            }
                            return out;
                        }
                    },
                    {
                        data: null,
                        className: 'text-center text-nowrap',
                        render: r => {
                            const f = getLedgerFlag(r);
                            return `<span class="badge ${f.cls}">${escHtml(f.label)}</span>`;
                        }
                    },
                    { data: 'debit', className: 'text-end text-danger text-nowrap', render: v => parseFloat(v || 0) > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { data: 'credit', className: 'text-end text-success text-nowrap', render: v => parseFloat(v || 0) > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { 
                        data: 'running_balance', 
                        className: 'text-end fw-bold text-nowrap', 
                        render: v => {
                            const val = parseFloat(v || 0);
                            return `<span class="${val >= 0 ? 'text-primary' : 'text-danger'}">${val.toFixed(3)}</span>`;
                        }
                    },
                    {
                        data: null,
                        className: 'text-nowrap',
                        render: r => {
                            const agreeNo = $.trim(r.agreement_no || '');
                            let html = agreeNo
                                ? `<div><a href="javascript:void(0)" class="view_contract fw-bold small text-primary text-decoration-underline" data-contract="${escHtml(agreeNo)}">${escHtml(agreeNo)}</a></div>`
                                : '<span class="text-muted small">-</span>';
                            const candReceipt = $.trim(r.matched_cashmemo_no || (parseFloat(r.credit || 0) > 0 && /\/CM\/|CM\//i.test(String(r.ref_no || '')) ? r.ref_no : ''));
                            if (candReceipt) {
                                html += `<button type="button" class="btn btn-xs btn-outline-primary mt-1 btn-print-receipt" data-receipt="${escHtml(candReceipt)}" title="Print Receipt ${escHtml(candReceipt)}"><i class="ri-printer-line me-1"></i>Receipt</button>`;
                            }
                            return html;
                        }
                    }
                ],
                createdRow: function(row, data) {
                    if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                    else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
                },
                order: [],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                pageLength: 25
            });
        }

        $(document).on('click', '.view_contract', function () {
            openEncryptedPrint('/PrintAgreement', $(this).data('contract'));
        });

        function hexToRgbArray(hex, fallback) {
            const clean = String(hex || '').replace('#', '').trim();
            if (/^[0-9a-fA-F]{6}$/.test(clean)) {
                return [parseInt(clean.substring(0, 2), 16), parseInt(clean.substring(2, 4), 16), parseInt(clean.substring(4, 6), 16)];
            }
            return fallback;
        }

        $('#btnPrintSOA').on('click', function () {
            if (!selectedCustomer || !$('#txtCustomerCode').val()) {
                showToast('Please select a customer first', 'error');
                return;
            }
            if (typeof window.jspdf === 'undefined') {
                showToast('PDF library not loaded yet', 'error');
                return;
            }
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'pt', 'a4');
            const ps = window.LEDGER_PRINT_SETTINGS || {};
            const accentRgb = hexToRgbArray(ps.accent_color, [27, 61, 148]);
            const pageWidth = doc.internal.pageSize.getWidth();
            const pageHeight = doc.internal.pageSize.getHeight();
            const marginX = 32;

            let imgData = ps.logo_base64 || '';
            let showLogo = Number(ps.show_logo !== undefined ? ps.show_logo : 1) === 1;
            let logoW = Math.min(130, Math.max(70, Number(ps.logo_width || 120) * 0.8));
            let logoH = logoW / 2.8;

            const agreeText = $('#selQuotation option:selected').text() || 'All Agreements';
            const totDebit = $('#lblTotalDebit').text() || '0.000';
            const totCredit = $('#lblTotalCredit').text() || '0.000';
            const totBalance = $('#lblBalance').text() || '0.000';

            const bodyRows = currentLedgerRows.length
                ? currentLedgerRows.map(r => {
                    const f = getLedgerFlag(r);
                    const dt = r.trans_date ? moment(r.trans_date).format('DD MMM YYYY') : '-';
                    const descParts = [r.ref_no || '-'];
                    if (r.description) descParts.push(r.description);
                    if (r.bank_name) descParts.push('Bank: ' + r.bank_name);
                    return [
                        dt,
                        r.agreement_no || '-',
                        `${r.trans_type || '-'}${r.payment_method && r.payment_method !== 'N/A' ? ' (' + r.payment_method + ')' : ''}`,
                        descParts.join(' | '),
                        f.label,
                        parseFloat(r.debit || 0) > 0 ? parseFloat(r.debit).toFixed(3) : '-',
                        parseFloat(r.credit || 0) > 0 ? parseFloat(r.credit).toFixed(3) : '-',
                        parseFloat(r.running_balance || 0).toFixed(3)
                    ];
                })
                : [[{ content: 'No ledger transactions found.', colSpan: 8, styles: { halign: 'center' } }]];

            doc.autoTable({
                head: [['Date', 'Agreement', 'Type / Method', 'Reference & Details', 'Flag', 'Debit', 'Credit', 'Balance']],
                body: bodyRows,
                startY: 132,
                theme: 'grid',
                styles: { fontSize: 8.5, font: 'helvetica', cellPadding: 5, valign: 'middle', lineColor: [215, 222, 235], lineWidth: 0.4 },
                headStyles: { fillColor: accentRgb, textColor: 255, fontStyle: 'bold' },
                columnStyles: {
                    0: { cellWidth: 70 },
                    1: { cellWidth: 95 },
                    4: { cellWidth: 72, halign: 'center' },
                    5: { cellWidth: 62, halign: 'right' },
                    6: { cellWidth: 62, halign: 'right' },
                    7: { cellWidth: 66, halign: 'right', fontStyle: 'bold' }
                },
                alternateRowStyles: { fillColor: [248, 250, 253] },
                margin: { top: 96, left: marginX, right: marginX, bottom: 50 },
                didDrawPage: function (data) {
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

                    doc.setFontSize(8);
                    let rightX = pageWidth - marginX;
                    let rightY = 26;
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
                        doc.text('STATEMENT OF ACCOUNT (SOA)', marginX, 86);

                        doc.setFont('helvetica', 'normal');
                        doc.setFontSize(8.5);
                        doc.setTextColor(71, 85, 105);
                        doc.text(`Customer: ${selectedCustomer.customer_name || ''} (${selectedCustomer.customer_code || ''})  |  Mobile: ${selectedCustomer.customer_mobile || '-'}`, marginX, 102);
                        doc.text(`Agreement Filter: ${agreeText}`, marginX, 116);

                        doc.text(`Statement Date: ${moment().format('DD MMM YYYY')}`, rightX, 86, { align: 'right' });
                        doc.setFont('helvetica', 'bold');
                        doc.text(`Total Debit: ${totDebit}   |   Total Credit: ${totCredit}   |   Balance: ${totBalance} BHD`, rightX, 116, { align: 'right' });
                    } else {
                        doc.setFont('helvetica', 'bold');
                        doc.setFontSize(10);
                        doc.setTextColor(71, 85, 105);
                        doc.text(`Statement of Account - ${selectedCustomer.customer_name || ''} (Cont.)`, marginX, 84);
                    }

                    let footerY = pageHeight - 28;
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
        });
        // Form Submission
        $('#frmTransaction').on('submit', function(e) {
            e.preventDefault();
            if(!$('#txtCustomerCode').val()) {
                showToast('Please select a customer first', 'error');
                return;
            }
            
            const formData = $(this).serialize() + '&quotation_no=' + $('#selQuotation').val() + '&booking_no=' + $('#selBooking').val();
            
            $.post('/CustomerLedgerController', formData, function(res) {
                if(res.status) {
                    $('#frmTransaction')[0].reset();
                    $('#txtTransId').val('');
                    $('#btnCancelEdit').addClass('d-none');
                    $('#btnSave').text('Save Transaction');
                    refreshLedger($('#txtCustomerCode').val());
                    showToast(res.message, 'success');
                } else {
                    showToast(res.message, 'error');
                }
            }, 'json');
        });

        // Edit Button Click
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            $.get('/CustomerLedgerController', { action: 'GetTransaction', ids: id }, function(res) {
                if(res.status && res.data.length > 0) {
                    const row = res.data[0];
                    $('#txtTransId').val(row.ids);
                    $('#txtDate').val(row.trans_date);
                    $('#selTransType').val(row.trans_type).trigger('change');
                    $('#selPaymentMethod').val(row.payment_method).trigger('change');
                    $('#txtAmount').val(row.debit > 0 ? row.debit : row.credit);
                    $('#txtReference').val(row.ref_no);
                    $('#txtDescription').val(row.description);
                    if(row.bank_id) {
                        setTimeout(() => loadBanks(row.bank_id), 100);
                    }
                    if(row.company_bank_id) {
                        setTimeout(() => loadCompanyBanks(row.company_bank_id), 100);
                    }
                    $('#txtChequeDate').val(row.cheque_date);
                    $('#selQuotation').val(row.quotation_no);
                    $('#selBooking').val(row.booking_no);
                    
                    $('#btnSave').text('Update Transaction');
                    $('#btnCancelEdit').removeClass('d-none');
                    $('html, body').animate({ scrollTop: $('#frmTransaction').offset().top - 100 }, 500);
                }
            }, 'json');
        });

        $('#btnCancelEdit').on('click', function() {
            $('#frmTransaction')[0].reset();
            $('#txtTransId').val('');
            $('#selPaymentMethod').trigger('change');
            $('#btnCancelEdit').addClass('d-none');
            $('#btnSave').text('Save Transaction');
        });

        // Delete Button Click
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this transaction? This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/CustomerLedgerController', { action: 'DeleteTransaction', ids: id }, function(res) {
                        if(res.status) {
                            ledgerTable.ajax.reload(null, false);
                            showToast('Transaction deleted successfully', 'success');
                        } else {
                            showToast(res.message, 'error');
                        }
                    }, 'json');
                }
            });
        });

        // Cheque Status Update from Main Table
        $(document).on('click', '.btn-status-main', function() {
            const id = $(this).data('id');
            const status = $(this).data('status');
            const msg = status === 'Pending' ? 'Revoke cheque status back to Pending?' : `Mark cheque as ${status}?`;
            
            Swal.fire({
                title: 'Are you sure?',
                text: msg,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/CustomerLedgerController', { action: 'UpdateChequeStatus', ids: id, status: status }, function(res) {
                        if(res.status) {
                            ledgerTable.ajax.reload(null, false);
                            if(calendar) calendar.refetchEvents();
                            showToast('Status updated successfully', 'success');
                        } else {
                            showToast(res.message, 'error');
                        }
                    }, 'json');
                }
            });
        });

        // --- Cheque Calendar Logic ---
        let calendar = null;
        let detailsTable = null;

        $('#btnOpenCalendar').on('click', function() {
            $('#modalChequeCalendar').modal('show');
            setTimeout(() => {
                if (!calendar) initCalendar();
                else calendar.render();
            }, 300);
        });

        function initCalendar() {
            const calendarEl = document.getElementById('chequeCalendar');
            calendar = new Calendar(calendarEl, {
                plugins: [ dayGridPlugin ],
                initialView: 'dayGridMonth',
                contentHeight: 450,
                aspectRatio: 1.8,
                events: function(info, successCallback, failureCallback) {
                    $.get('/CustomerLedgerController', { 
                        action: 'GetChequeCalendarEvents',
                        customer_code: $('#selCalendarCustomer').val()
                    }, data => successCallback(data), 'json');
                },
                eventClick: function(info) {
                    showChequeDetails(info.event.extendedProps.date);
                }
            });
            calendar.render();
        }

        $('#selCalendarCustomer').select2({
            dropdownParent: $('#modalChequeCalendar'),
            placeholder: 'Filter by Customer...',
            allowClear: true,
            ajax: {
                url: '/CustomerLedgerController',
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term, action: 'SearchCustomer' }),
                processResults: data => ({ results: data.map(i => ({ id: i.customer_code, text: i.customer_name })) })
            }
        }).on('change', function() {
            const code = $(this).val();
            if(code) {
                loadPendingSummary(code);
            } else {
                $('#divPendingSummary').addClass('d-none');
            }
            if(calendar) calendar.refetchEvents();
        });

        function loadPendingSummary(code) {
            $.get('/CustomerLedgerController', { action: 'GetPendingCheques', customer_code: code }, function(res) {
                if(res.status && res.data.length > 0) {
                    $('#divPendingSummary').removeClass('d-none');
                    $('#pendingBadges').empty();
                    res.data.forEach(c => {
                        const dateStr = moment(c.cheque_date).format('DD MMM');
                        const amountStr = parseFloat(c.amount).toFixed(3);
                        const badge = `<span class="badge bg-label-warning border border-warning" title="Ref: ${c.ref_no}">
                            <small class="d-block text-dark" style="font-size:9px">${dateStr}</small>
                            ${amountStr}
                        </span>`;
                        $('#pendingBadges').append(badge);
                    });
                } else {
                    $('#divPendingSummary').addClass('d-none');
                }
            }, 'json');
        }

        function showChequeDetails(date) {
            $('#lblSelectedDate').text(moment(date).format('DD MMM YYYY'));
            if (detailsTable) detailsTable.destroy();

            detailsTable = $('#tblChequeDetails').DataTable({
                ajax: {
                    url: '/CustomerLedgerController',
                    data: { action: 'GetChequesByDate', date: date, customer_code: $('#selCalendarCustomer').val() },
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'customer_name' },
                    { data: 'ref_no' },
                    { 
                        data: 'credit', 
                        className: 'text-end fw-bold',
                        render: v => parseFloat(v).toFixed(3)
                    },
                    { 
                        data: 'cheque_status',
                        render: v => `<span class="badge ${v === 'Collected' ? 'bg-success' : (v === 'Bounced' ? 'bg-danger' : 'bg-warning')}">${v}</span>`
                    },
                    {
                        data: 'ids',
                        render: (id, type, row) => {
                            if (row.cheque_status === 'Pending') {
                                return `
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-success btn-status px-2" data-id="${id}" data-status="Collected">Collect</button>
                                        <button class="btn btn-sm btn-danger btn-status px-2" data-id="${id}" data-status="Bounced">Bounce</button>
                                    </div>
                                `;
                            } else {
                                return `<button class="btn btn-sm btn-outline-secondary btn-status" data-id="${id}" data-status="Pending"><span class="ri-refresh-line me-1"></span>Revert</button>`;
                            }
                        }
                    }
                ],
                paging: false,
                info: false,
                searching: false,
                createdRow: function(row, data) {
                    if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                    else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
                }
            });
            $('#modalChequeDetails').modal('show');
        }

        $(document).on('click', '.btn-status', function() {
            const id = $(this).data('id');
            const status = $(this).data('status');
            $.post('/CustomerLedgerController', { action: 'UpdateChequeStatus', ids: id, status: status }, function(res) {
                if(res.status) {
                    detailsTable.ajax.reload();
                    calendar.refetchEvents();
                    if(ledgerTable) ledgerTable.ajax.reload();
                    showToast('Status updated successfully', 'success');
                } else {
                    showToast(res.message, 'error');
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>
