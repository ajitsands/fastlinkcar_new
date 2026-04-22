<?php
include ROOT_PATH . '/view/envinclude.php';
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
                    <div class="container-fluid flex-grow-1 container-p-y">
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
                                        <div class="mb-3">
                                            <label class="form-label">Quotation Reference</label>
                                            <select id="selQuotation" class="form-select select2" disabled><option value="">Select Quotation</option></select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Booking Reference</label>
                                            <select id="selBooking" class="form-select select2" disabled><option value="">Select Booking</option></select>
                                        </div>

                                        <hr class="my-4">
                                        
                                        <h5 class="mb-3">New Transaction</h5>
                                        <form id="frmTransaction">
                                            <input type="hidden" name="action" value="SaveTransaction">
                                            <input type="hidden" name="ids" id="txtTransId">
                                            <input type="hidden" name="customer_code" id="txtCustomerCode">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Transaction Date</label>
                                                <input type="date" name="trans_date" id="txtDate" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Type</label>
                                                <div class="input-group">
                                                    <select name="trans_type" id="selTransType" class="form-select" required></select>
                                                    <button class="btn btn-outline-primary" type="button" id="btnAddHead"><i class="ri ri-add-line ri-xl"></i></button>
                                                </div>
                                            </div>
                                            <div class="mb-3" id="divPaymentMethod">
                                                <label class="form-label">Payment Method</label>
                                                <select name="payment_method" id="selPaymentMethod" class="form-select">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Cheque">Cheque</option>
                                                    <option value="BankTransfer">Bank Transfer</option>
                                                    <option value="CreditCard">Credit Card</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 d-none" id="divBank">
                                                <label class="form-label">Deposited Bank</label>
                                                <div class="input-group">
                                                    <select class="form-select" id="selBank" name="bank_id"></select>
                                                    <button class="btn btn-outline-primary" type="button" id="btnAddBank"><i class="ri ri-add-line ri-xl"></i></button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Amount</label>
                                                <input type="number" step="0.001" name="amount" id="txtAmount" class="form-control" required placeholder="0.000">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Ref / Cheque No.</label>
                                                <input type="text" name="ref_no" id="txtReference" class="form-control" placeholder="Optional">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" id="txtDescription" class="form-control" rows="2"></textarea>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary" id="btnSave">Save Transaction</button>
                                                <button type="button" class="btn btn-outline-secondary d-none" id="btnCancelEdit">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Ledger Table Card -->
                            <div class="col-lg-8">
                                <div class="card ledger-card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Ledger Statement</h5>
                                        <button type="button" class="btn btn-outline-primary" id="btnOpenCalendar">
                                            <span class="ri-calendar-line me-1"></span> Cheque Calendar
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblLedger" class="table table-hover border-top">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type / Method</th>
                                                        <th>Ref</th>
                                                        <th class="text-end">Debit</th>
                                                        <th class="text-end">Credit</th>
                                                        <th class="text-end">Balance</th>
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
                    </div>
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div class="modal fade" id="modalChequeCalendar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
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
            if(method === 'Cheque' || method === 'BankTransfer') {
                $('#divBank').removeClass('d-none');
                loadBanks();
            } else {
                $('#divBank').addClass('d-none');
                $('#selBank').val(null).trigger('change');
            }
        });

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

        // Initialize Select2 for Customer
        $('#selCustomer').select2({
            placeholder: 'Search Customer by name or mobile...',
            ajax: {
                url: '/CustomerLedgerController',
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term, action: 'SearchCustomer' }),
                processResults: data => ({ results: data.map(i => ({ id: i.customer_code, text: `${i.customer_name} (${i.customer_mobile})`, raw: i })) })
            }
        }).on('select2:select', function(e) {
            const data = e.params.data.raw;
            $('#txtCustomerCode').val(data.customer_code);
            loadCustomerDependents(data.customer_code);
            refreshLedger(data.customer_code);
        });


        function loadCustomerDependents(code) {
            // Load Quotations
            $.get('/CustomerLedgerController', { action: 'GetQuotations', customer_code: code }, function(data) {
                $('#selQuotation').empty().append('<option value="">Select Quotation</option>').attr('disabled', false);
                data.forEach(q => $('#selQuotation').append(new Option(q.text, q.id)));
            }, 'json');

            // Load Bookings
            $.get('/CustomerLedgerController', { action: 'GetBookings', customer_code: code }, function(data) {
                $('#selBooking').empty().append('<option value="">Select Booking</option>').attr('disabled', false);
                data.forEach(b => $('#selBooking').append(new Option(b.text, b.id)));
            }, 'json');
        }

        function refreshLedger(code) {
            if ($.fn.DataTable.isDataTable('#tblLedger')) {
                $('#tblLedger').DataTable().destroy();
            }

            ledgerTable = $('#tblLedger').DataTable({
                ajax: {
                    url: '/CustomerLedgerController',
                    data: { action: 'GetLedgerData', customer_code: code },
                    dataSrc: function(json) {
                        let totDebit = 0, totCredit = 0;
                        json.data.forEach(r => {
                            totDebit += parseFloat(r.debit);
                            totCredit += parseFloat(r.credit);
                        });
                        $('#lblTotalDebit').text(totDebit.toFixed(3));
                        $('#lblTotalCredit').text(totCredit.toFixed(3));
                        $('#lblBalance').text((totDebit - totCredit).toFixed(3));
                        return json.data;
                    }
                },
                columns: [
                    { 
                        data: 'trans_date',
                        render: v => moment(v).format('DD-MM-YYYY')
                    },
                    { 
                        data: null, 
                        render: r => `<div class="fw-bold">${r.trans_type}</div><small class="text-muted">${r.payment_method}</small>`
                    },
                    { 
                        data: null, 
                        render: r => {
                            let out = `<div class="small">${r.ref_no || '-'}</div>`;
                            if(r.bank_name) {
                                out += `<div style="font-size:10px" class="text-primary"><i class="ri-bank-line me-1"></i>${r.bank_name} ${r.account_no ? '('+r.account_no+')' : ''}</div>`;
                            }
                            out += `<div style="font-size:10px" class="text-muted">${r.quotation_no || r.booking_no || ''}</div>`;
                            return out;
                        }
                    },
                    { data: 'debit', className: 'text-end text-danger', render: v => v > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { data: 'credit', className: 'text-end text-success', render: v => v > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { 
                        data: 'running_balance', 
                        className: 'text-end fw-bold', 
                        render: v => `<span class="${v >= 0 ? 'text-primary' : 'text-danger'}">${v.toFixed(3)}</span>`
                    },
                    {
                        data: 'ids',
                        render: (id, type, row) => {
                            const isAdmin = userRole.toLowerCase().includes('admin');
                            const isToday = moment(row.created_at).format('YYYY-MM-DD') === todayStr;
                            const canModify = isAdmin || (row.user_id == currentUserId && isToday);
                            
                            if(!canModify) return '';

                            let btns = `<div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-icon text-primary btn-edit" data-id="${id}" title="Edit"><span class="ri ri-edit-line ri-xl"></span></button>
                                <button type="button" class="btn btn-sm btn-icon text-danger btn-delete" data-id="${id}" title="Delete"><span class="ri ri-delete-bin-line ri-xl"></span></button>`;
                            
                            if (row.payment_method === 'Cheque') {
                                if (row.cheque_status === 'Pending') {
                                    btns += `
                                        <button class="btn btn-sm btn-icon text-success btn-status-main" data-id="${id}" data-status="Collected" title="Collect Cheque"><span class="ri ri-check-line ri-xl"></span></button>
                                        <button class="btn btn-sm btn-icon text-warning btn-status-main" data-id="${id}" data-status="Bounced" title="Bounce Cheque"><span class="ri ri-close-line ri-xl"></span></button>
                                    `;
                                } else {
                                    btns += `<button class="btn btn-sm btn-icon text-secondary btn-status-main" data-id="${id}" data-status="Pending" title="Revoke Status"><span class="ri ri-refresh-line ri-xl"></span></button>`;
                                }
                            }
                            
                            btns += `</div>`;
                            return btns;
                        }
                    }
                ],
                createdRow: function(row, data) {
                    if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                    else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
                },
                order: [[0, 'asc'], [5, 'asc']], // Sort by date then by id
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                pageLength: 25
            });
        }

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
            $('#divBank').addClass('d-none');
            $(this).addClass('d-none');
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
        }).on('change', () => calendar.refetchEvents());

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
