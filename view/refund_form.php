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

$userCompanyJson = isset($_SESSION['company_json']) ? json_decode($_SESSION['company_json'], true) : [];
$userCompanyIds = [];
if (is_array($userCompanyJson)) {
    foreach ($userCompanyJson as $c) {
        if (isset($c['ids'])) {
            $userCompanyIds[] = $c['ids'];
        }
    }
}

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;
if (!empty($userCompanyIds)) {
    $placeholders = implode(',', array_fill(0, count($userCompanyIds), '?'));
    $stmt = $pdo->prepare("SELECT * FROM tbl_company WHERE ids IN ($placeholders) AND status = 'Active'");
    $stmt->execute($userCompanyIds);
} else {
    $stmt = $pdo->query("SELECT * FROM tbl_company WHERE status = 'Active'");
}
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="../assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include('templates/head.php'); ?>
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    <style>
        .card-headernew {
            min-height: auto !important;
            padding-top: 6px !important;
            padding-bottom: 6px !important;
        }
        #refundTable > thead > tr > th {
            background: #ffeff0 !important;
            color: #d12222 !important;
            border-bottom: 2px solid #d12222 !important;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->
            <?php include('templates/nav.php'); ?>
            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    <?php include('templates/menu.php'); ?>
                    <!-- / Menu -->

                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 55px !important">
                        <?php include('templates/accounting/refund_form_body.php'); ?>
                    </div>
                    <!--/ Content -->

                    <!-- Footer -->
                    <?php include('templates/footer.php'); ?>
                    <!-- / Footer -->
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="dropdownContent" style="text-align:center;"></div>    
    <?php include('templates/scripts.php'); ?>

    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/sands/settings.js"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>

    <script>
    $(document).ready(function() {
        $('#selectCustomerFromSelect2').select2({
            placeholder: 'Search customer by name, mobile or cpr/cr',
            allowClear: true,
            minimumInputLength: 2,
            tags: true, 
            createTag: function (params) {
                let term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
            },
            ajax: {
                url: '/SearchCustomerDetails',
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return { 
                        q: params.term, 
                        action: 'SearchCustomer'
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.customer_name,
                            customer_name: item.customer_name,
                            customer_mobile: item.customer_mobile,
                            customer_id: item.customer_name,
                            customer_address: item.customer_addr,
                            customer_email: item.customer_email,
                            customer_code: item.customer_code,
                            customer_attn: item.customer_attn,
                            customer_cr_cpr: item.customer_cr_cpr
                        }))
                    };
                },
                cache: true
            },
            templateResult: formatCustomer,
            templateSelection: formatCustomerSelection
        });

        function formatCustomer(customer) {
            if (!customer.id) return customer.text;
            return $(`
                <div>
                    <strong>${customer.customer_name} | ${customer.customer_mobile} | ${customer.customer_cr_cpr}</strong>
                </div>
            `);
        }

        function formatCustomerSelection(customer) {
            return customer.customer_name ? `${customer.customer_name}` : customer.text;
        }

        $('#selectCustomerFromSelect2').on('select2:select', function (e) {
            let data = e.params.data;
            $('#customer_code').val(data.customer_code).trigger('change');
            $('#agreement_no').val(null).trigger('change');
        });

        $('#selectCustomerFromSelect2').on('select2:clear', function () {
            $('#customer_code').val('').trigger('change');
            $('#agreement_no').val(null).trigger('change');
        });

        $('#company_id').on('change', function() {
            $('#selectCustomerFromSelect2').val(null).trigger('change');
            $('#customer_code').val('').trigger('change');
            $('#agreement_no').val(null).trigger('change');
        });

        $('#agreement_no').select2({
            ajax: {
                url: '/getAgreementOptions',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { 
                        q: params.term, 
                        customer_code: $('#customer_code').val(),
                        company_id: $('#company_id option:selected').attr('data-id')
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.value,
                                id: item.value
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#agreement_no').on('change', function() {
            let agreement_no = $(this).val();
            if (!agreement_no) {
                $('#agreementSummarySection').hide();
                $('#agreementSummaryContent').html('');
                return;
            }

            $.post('/RefundFormController', { action: 'get_agreement_summary', agreement_no: agreement_no }, function(res) {
                let r = JSON.parse(res);
                if (r.status && r.data) {
                    let contract = r.data.contract || {};
                    let ledger = r.data.ledger || {};
                    let make = contract.vechile_details ? (contract.vechile_details.make || contract.vechile_details.brand || '') : '';
                    let model = contract.vechile_details ? (contract.vechile_details.model_name || contract.vechile_details.model || '') : '';
                    let vehicleName = (make + ' ' + model).trim() || 'N/A';
                    let chassisNo = contract.vechile_details ? (contract.vechile_details.chassis_number || contract.vechile_details.chassis_no || 'N/A') : 'N/A';
                    
                    const formatCustomDate = (dateString) => {
                        if (!dateString || dateString === 'N/A') return 'N/A';
                        const date = new Date(dateString);
                        if (isNaN(date.getTime())) return dateString;
                        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        const day = date.getDate().toString().padStart(2, '0');
                        const month = months[date.getMonth()];
                        const year = date.getFullYear();
                        return `${day} ${month} ${year}`;
                    };

                    let totalPaid = parseFloat(ledger.total_credit || 0);
                    let totalCharged = parseFloat(ledger.total_debit || 0);
                    let balance = totalPaid - totalCharged;

                    let html = `
                        <div class="col-md-6 mb-2">
                            <strong class="text-dark">Vehicle:</strong> ${vehicleName} (${contract.vehicle_no || 'N/A'})<br>
                            <strong class="text-dark">Chassis No:</strong> ${chassisNo}<br>
                            <strong class="text-dark">Rentout Date:</strong> ${formatCustomDate(contract.service_start_date_time)}<br>
                            <strong class="text-dark">Return Date:</strong> ${formatCustomDate(contract.return_date)}<br>
                            <strong class="text-dark">KM Used:</strong> ${contract.km_used || 0}
                        </div>
                        <div class="col-md-6 mb-2 text-end">
                            <strong class="text-dark">Total Payable:</strong> ${totalCharged.toFixed(3)}<br>
                            <strong class="text-dark">Total Paid:</strong> ${totalPaid.toFixed(3)}<br>
                            <strong class="text-dark">Balance:</strong> <span class="${balance >= 0 ? 'text-success' : 'text-danger'} fw-bold">${balance.toFixed(3)}</span>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h6 class="border-bottom pb-1 mb-2 fw-bold text-secondary" style="font-size: 0.9rem;">Agreement Ledger History</h6>
                            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                <table class="table table-bordered table-sm table-striped mb-0" style="font-size: 0.85rem;">
                                    <thead class="table-light" style="position: sticky; top: 0;">
                                        <tr>
                                            <th class="text-nowrap text-center">Date</th>
                                            <th class="text-nowrap text-center">Type</th>
                                            <th>Description / Ref No</th>
                                            <th class="text-end text-nowrap">Debit</th>
                                            <th class="text-end text-nowrap">Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${r.data.ledger_rows && r.data.ledger_rows.length > 0 ? r.data.ledger_rows.map(row => `
                                            <tr>
                                                <td class="text-nowrap text-center align-middle">${formatCustomDate(row.trans_date)}</td>
                                                <td class="text-nowrap text-center align-middle">${row.trans_type}</td>
                                                <td class="align-middle">${row.description || ''} ${row.ref_no ? `(${row.ref_no})` : ''}</td>
                                                <td class="text-end text-danger text-nowrap align-middle fw-bold">${parseFloat(row.debit) > 0 ? parseFloat(row.debit).toFixed(3) : '-'}</td>
                                                <td class="text-end text-success text-nowrap align-middle fw-bold">${parseFloat(row.credit) > 0 ? parseFloat(row.credit).toFixed(3) : '-'}</td>
                                            </tr>
                                        `).join('') : '<tr><td colspan="5" class="text-center text-muted">No ledger records found</td></tr>'}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    $('#agreementSummaryContent').html(html);
                    $('#agreementSummarySection').fadeIn();
                } else {
                    $('#agreementSummarySection').hide();
                }
            });
        });

        loadRefunds();

        $('#btnShowChargesSection').click(function() {
            $('#btnShowChargesContainer').hide();
            $('#additionalChargesSection').fadeIn();
            if ($('#chargesTableBody tr:not(.empty-row)').length === 0) {
                $('#btnAddChargeRow').click();
            }
        });

        $('#btnHideChargesSection').click(function() {
            $('#additionalChargesSection').hide();
            $('#btnShowChargesContainer').fadeIn();
            // Clear all rows and reset total if they hide it? 
            // Better to let them keep the rows in case they accidentally hide it, but if they hide it they might assume charges won't apply.
            // Let's clear the charges if they hide it to avoid hidden charges applying.
            $('#chargesTableBody').empty().append('<tr class="empty-row"><td colspan="4" class="text-center text-muted">No additional charges added</td></tr>');
            calculateTotalCharges();
        });

        $('#btnAddChargeRow').click(function() {
            $('.empty-row').remove();
            let row = `
                <tr>
                    <td>
                        <select class="form-select form-select-sm charge-type"></select>
                    </td>
                    <td><input type="text" class="form-control form-control-sm charge-desc" placeholder="Description"></td>
                    <td><input type="number" step="0.001" class="form-control form-control-sm charge-amt" value="0.000"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-remove-charge"><i class="ri ri-delete-bin-line text-white"></i></button>
                    </td>
                </tr>
            `;
            let $row = $(row);
            $('#chargesTableBody').append($row);
            
            $row.find('.charge-type').select2({
                placeholder: 'Select Charge Type',
                allowClear: true,
                ajax: {
                    url: '/RefundFormController',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            action: 'search_ledger_heads',
                            q: params.term || ''
                        };
                    },
                    processResults: function (data) {
                        return { results: data };
                    },
                    cache: true
                }
            });
        });

        $('#btnSubmitCharges').click(function() {
            let agreement_no = $('#agreement_no').val();
            if (!agreement_no) {
                Swal.fire('Error', 'Please select an agreement first.', 'error');
                return;
            }

            let charges = [];
            $('#chargesTableBody tr:not(.empty-row)').each(function() {
                let type = $(this).find('.charge-type').text().trim(); 
                // Since it's select2, we can get the selected text
                if (!type && $(this).find('.charge-type').select2('data').length > 0) {
                    type = $(this).find('.charge-type').select2('data')[0].text;
                }
                let desc = $(this).find('.charge-desc').val();
                let amt = $(this).find('.charge-amt').val();
                
                if (type || amt > 0) {
                    charges.push({
                        type: type,
                        desc: desc,
                        amount: amt
                    });
                }
            });

            if (charges.length === 0) {
                Swal.fire('Warning', 'No charges to submit.', 'warning');
                return;
            }

            // Disable button to prevent double submission
            let $btn = $(this);
            $btn.prop('disabled', true).text('Submitting...');

            $.post('/RefundFormController', { action: 'save_additional_charges', agreement_no: agreement_no, charges: charges }, function(res) {
                $btn.prop('disabled', false).text('Submit Charges');
                try {
                    let response = JSON.parse(res);
                    if (response.status) {
                        Swal.fire('Success', response.message, 'success');
                        // Hide section or clear it
                        $('#btnHideChargesSection').click();
                        // Refresh the agreement summary to show updated ledger balances
                        $('#agreement_no').trigger('change');
                    } else {
                        Swal.fire('Error', response.message || 'Error saving charges', 'error');
                    }
                } catch(e) {
                    Swal.fire('Error', 'Invalid server response', 'error');
                }
            });
        });

        $(document).on('click', '.btn-remove-charge', function() {
            $(this).closest('tr').remove();
            if ($('#chargesTableBody tr').length === 0) {
                $('#chargesTableBody').append('<tr class="empty-row"><td colspan="4" class="text-center text-muted">No additional charges added</td></tr>');
            }
            calculateTotalCharges();
        });

        $(document).on('input', '.charge-amt', function() {
            calculateTotalCharges();
        });

        function calculateTotalCharges() {
            let total = 0;
            $('.charge-amt').each(function() {
                let val = parseFloat($(this).val()) || 0;
                total += val;
            });
            $('#totalCharges').val(total.toFixed(3));
        }

        $('#saveRefundBtn').click(function() {
            let charges = [];
            $('#chargesTableBody tr:not(.empty-row)').each(function() {
                let type = $(this).find('.charge-type').val();
                let desc = $(this).find('.charge-desc').val();
                let amt = parseFloat($(this).find('.charge-amt').val()) || 0;
                if (amt > 0) {
                    charges.push({ type: type, desc: desc, amt: amt });
                }
            });

            let data = {
                action: 'save_refund',
                company_code: $('#company_id').val(),
                refund_date: $('#refund_date').val(),
                customer_code: $('#customer_code').val(),
                agreement_no: $('#agreement_no').val(),
                amount: $('#amount').val(),
                refund_mode: $('input[name="refund_mode"]:checked').val(),
                reason: $('#reason').val(),
                charges: JSON.stringify(charges)
            };

            if (!data.company_code) {
                setupDropdown('dropdownContent', 'error', 'Please select a company', 'click');
                return;
            }
            if (!data.customer_code || !data.amount || !data.agreement_no) {
                setupDropdown('dropdownContent', 'error', 'Please fill all required fields', 'click');
                return;
            }

            $.post('/RefundFormController', data, function(res) {
                let r = JSON.parse(res);
                if(r.status) {
                    setupDropdown('dropdownContent', 'success', r.message, 'click');
                    loadRefunds();
                    $('#refundForm')[0].reset();
                    $('#customer_code').val(null).trigger('change');
                    $('#agreement_no').val(null).trigger('change');
                } else {
                    setupDropdown('dropdownContent', 'error', r.message, 'click');
                }
            });
        });
        $('#filter_company_id').on('change', function() {
            loadRefunds();
        });
    });

    let refundTable;
    function loadRefunds() {
        let company_code = $('#filter_company_id').val();
        $.post('/RefundFormController', { action: 'get_refunds', filter_company_code: company_code }, function(res) {
            let r = JSON.parse(res);
            let html = '';
            r.data.forEach(function(item) {
                // format date to dd-mm-yyyy
                let parts = item.date.split('-');
                let formattedDate = parts.length === 3 ? `${parts[2]}-${parts[1]}-${parts[0]}` : item.date;

                let companyBadge = item.company_name ? `<br><span class="badge bg-label-primary mt-1">${item.company_name}</span>` : '';
                let customerDetails = [];
                if (item.customer_code) customerDetails.push(`<strong>${item.customer_code}</strong>`);
                if (item.customer_name) customerDetails.push(item.customer_name);
                if (item.customer_mobile) customerDetails.push(`<span class="text-muted">${item.customer_mobile}</span>`);
                if (item.customer_cr_cpr) customerDetails.push(`<span class="text-muted">${item.customer_cr_cpr}</span>`);
                let customerStr = customerDetails.join(' | ');

                html += `<tr>
                    <td class="align-middle">${item.refund_no}${companyBadge}</td>
                    <td class="align-middle">${formattedDate}</td>
                    <td class="align-middle">${customerStr}</td>
                    <td class="align-middle">${item.agreement_no}</td>
                    <td class="align-middle text-end fw-bold">${parseFloat(item.amount).toFixed(3)}</td>
                    <td class="align-middle text-center"><span class="badge ${item.status === 'Approved' ? 'bg-success' : 'bg-warning'}">${item.status}</span></td>
                    <td class="align-middle text-center" style="white-space: nowrap;">`;
                
                html += `<button class="btn btn-sm btn-info me-1" onclick="viewRefund(${item.id}); $('.tooltip').remove();" data-bs-toggle="tooltip" title="View"><i class="ri ri-eye-line"></i></button>`;
                html += `<button class="btn btn-sm btn-warning me-1" onclick="printRefund(${item.id}); $('.tooltip').remove();" data-bs-toggle="tooltip" title="Print"><i class="ri ri-printer-line"></i></button>`;
                
                let deleteDisabled = item.status === 'Approved' ? 'disabled' : '';
                html += `<button class="btn btn-sm btn-danger me-1" onclick="deleteRefund(${item.id})" ${deleteDisabled} data-bs-toggle="tooltip" title="Delete"><i class="ri ri-delete-bin-line"></i></button>`;

                if(item.status == 'Pending') {
                    html += `<button class="btn btn-sm btn-success" onclick="approveRefund(${item.id})">Approve</button>`;
                }
                html += `</td></tr>`;
            });

            if ($.fn.DataTable.isDataTable('#refundTable')) {
                $('#refundTable').DataTable().destroy();
            }
            $('#refundTableBody').html(html);
            refundTable = $('#refundTable').DataTable({
                "order": [],
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search..."
                },
                "drawCallback": function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
            // Match styling of ContractList
            $('.dataTables_filter input').addClass('form-control');
            $('.dataTables_length select').addClass('form-select');
        });
    }

    function approveRefund(id) {
        Swal.fire({
            title: 'Approve Refund?',
            text: 'Are you sure you want to approve this refund? This will affect the customer ledger.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/RefundFormController', { action: 'approve_refund', id: id }, function(res) {
                    let r = JSON.parse(res);
                    if(r.status) {
                        setupDropdown('dropdownContent', 'success', r.message, 'click');
                        loadRefunds();
                    } else {
                        setupDropdown('dropdownContent', 'error', r.message, 'click');
                    }
                });
            }
        });
    }

    function viewRefund(id) {
        $.post('/RefundFormController', { action: 'get_refund_details', id: id }, function(res) {
            try {
                let r = JSON.parse(res);
                if (r.status && r.data) {
                    let refund = r.data.refund;
                    let charges = r.data.charges;
                    let contract = r.data.contract;
                    let ledger_sum = r.data.ledger_sum;
                    
                    let make = contract && contract.vechile_details ? (contract.vechile_details.make || contract.vechile_details.brand || '') : '';
                    let model = contract && contract.vechile_details ? (contract.vechile_details.model_name || contract.vechile_details.model || '') : '';
                    let vehicleName = (make + ' ' + model).trim() || 'N/A';
                    let chassisNo = contract && contract.vechile_details ? (contract.vechile_details.chassis_number || contract.vechile_details.chassis_no || 'N/A') : 'N/A';
                    
                    const formatCustomDate = (dateString) => {
                        if (!dateString || dateString === 'N/A') return 'N/A';
                        const date = new Date(dateString);
                        if (isNaN(date.getTime())) return dateString;
                        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        const day = date.getDate().toString().padStart(2, '0');
                        const month = months[date.getMonth()];
                        const year = date.getFullYear();
                        return `${day} ${month} ${year}`;
                    };

                    let totalPaid = ledger_sum ? parseFloat(ledger_sum.total_credit || 0) : 0;
                    let totalCharged = ledger_sum ? parseFloat(ledger_sum.total_debit || 0) : 0;
                    let balance = totalPaid - totalCharged;

                    let html = `
                        <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #d12222;">
                            <h5 class="mb-0 fw-bold text-white fs-4">Refund Details</h5>
                            <i class="ri ri-close-line text-white fs-3" style="cursor:pointer;" onclick="Swal.close()"></i>
                        </div>
                        <div class="text-start p-4" style="font-size: 1.05rem;">
                            <h5 class="border-bottom pb-2 mb-3 fw-bold text-primary" style="text-transform: uppercase;">Refund Information</h5>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Refund No:</div><div class="col-7 fw-bold fs-6">${refund.refund_no}</div>
                                <div class="col-5 text-muted">Date:</div><div class="col-7 fw-bold fs-6">${refund.date}</div>
                                <div class="col-5 text-muted">Status:</div><div class="col-7 fw-bold fs-6">${refund.status}</div>
                                <div class="col-5 text-muted">Refund Mode:</div><div class="col-7 fw-bold fs-6">${refund.refund_mode || 'Cash'}</div>
                                <div class="col-5 text-muted">Amount:</div><div class="col-7 fw-bold text-success fs-5">${parseFloat(refund.amount).toFixed(3)}</div>
                            </div>
                            
                            <h5 class="border-bottom pb-2 mb-3 mt-4 fw-bold text-primary" style="text-transform: uppercase;">Customer Details</h5>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Customer Name:</div><div class="col-7 fs-6">${refund.customer_name || 'N/A'}</div>
                                <div class="col-5 text-muted">Customer Code:</div><div class="col-7 fs-6">${refund.customer_code || 'N/A'}</div>
                                <div class="col-5 text-muted">Agreement No:</div><div class="col-7 fs-6">${refund.agreement_no || 'N/A'}</div>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4 fw-bold text-primary" style="text-transform: uppercase;">Agreement Summary</h5>
                            <div class="row mb-2">
                                <div class="col-6 mb-2 fs-6">
                                    <strong class="text-dark">Vehicle:</strong> ${vehicleName} (${contract ? (contract.vehicle_no || 'N/A') : 'N/A'})<br>
                                    <strong class="text-dark">Chassis No:</strong> ${chassisNo}<br>
                                    <strong class="text-dark">Rentout Date:</strong> ${contract ? formatCustomDate(contract.service_start_date_time) : 'N/A'}<br>
                                    <strong class="text-dark">Return Date:</strong> ${contract ? formatCustomDate(contract.return_date) : 'N/A'}<br>
                                    <strong class="text-dark">KM Used:</strong> ${contract ? (contract.km_used || 0) : 0}
                                </div>
                                <div class="col-6 mb-2 fs-6">
                                    <strong class="text-dark">Total Payable:</strong> ${totalCharged.toFixed(3)}<br>
                                    <strong class="text-dark">Total Paid:</strong> ${totalPaid.toFixed(3)}<br>
                                    <strong class="text-dark">Balance:</strong> <span class="${balance >= 0 ? 'text-success' : 'text-danger'} fw-bold fs-5">${balance.toFixed(3)}</span>
                                </div>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4 fw-bold text-primary" style="text-transform: uppercase;">Reason / Remarks</h5>
                            <p class="text-muted fs-6">${refund.reason || 'No reason provided.'}</p>
                    `;

                    let ledger_rows = r.data.ledger_rows || [];
                    if (ledger_rows.length > 0) {
                        html += `
                            <h5 class="border-bottom pb-2 mb-3 mt-4 fw-bold text-primary" style="text-transform: uppercase;">Agreement Ledger History</h5>
                            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                <table class="table table-bordered table-sm table-striped mb-0" style="font-size: 0.95rem;">
                                    <thead class="table-light" style="position: sticky; top: 0;">
                                        <tr>
                                            <th class="text-nowrap text-center">Date</th>
                                            <th class="text-nowrap text-center">Type</th>
                                            <th>Description / Ref No</th>
                                            <th class="text-end text-nowrap">Debit</th>
                                            <th class="text-end text-nowrap">Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${ledger_rows.map(row => `
                                            <tr>
                                                <td class="text-nowrap text-center align-middle">${formatCustomDate(row.trans_date)}</td>
                                                <td class="text-nowrap text-center align-middle">${row.trans_type}</td>
                                                <td class="align-middle">${row.description || ''} ${row.ref_no ? `(${row.ref_no})` : ''}</td>
                                                <td class="text-end text-danger text-nowrap align-middle fw-bold">${parseFloat(row.debit) > 0 ? parseFloat(row.debit).toFixed(3) : '-'}</td>
                                                <td class="text-end text-success text-nowrap align-middle fw-bold">${parseFloat(row.credit) > 0 ? parseFloat(row.credit).toFixed(3) : '-'}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        `;
                    }


                    if (charges && charges.length > 0) {
                        html += `<h6 class="border-bottom pb-2 mb-3 mt-4 fw-bold text-primary" style="text-transform: uppercase;">Additional Charges</h6>
                                <table class="table table-sm table-bordered text-start mb-0">
                                    <thead class="table-light"><tr><th>Type</th><th>Description</th><th>Amount</th></tr></thead>
                                    <tbody>`;
                        let totalCharges = 0;
                        charges.forEach(c => {
                            let amt = parseFloat(c.amount) || 0;
                            totalCharges += amt;
                            html += `<tr><td>${c.trans_type}</td><td>${c.desc || ''}</td><td>${amt.toFixed(3)}</td></tr>`;
                        });
                        html += `</tbody>
                                <tfoot><tr><th colspan="2" class="text-end">Total</th><th>${totalCharges.toFixed(3)}</th></tr></tfoot>
                                </table>`;
                    }

                    html += `</div>`;

                    Swal.fire({
                        html: html,
                        width: '800px',
                        showCloseButton: false,
                        showConfirmButton: false,
                        padding: '0',
                        customClass: {
                            popup: 'p-0 overflow-hidden',
                            htmlContainer: 'm-0 p-0'
                        }
                    });
                } else {
                    Swal.fire('Error', r.message || 'Could not load refund details', 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Invalid server response', 'error');
            }
        });
    }

    function printRefund(id) {
        window.open('../pdf/refund_receipt.php?id=' + id, '_blank');
    }

    function deleteRefund(id) {
        Swal.fire({
            title: 'Delete Refund?',
            text: 'Are you sure you want to delete this refund? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/RefundFormController', { action: 'delete_refund', id: id }, function(res) {
                    let r = JSON.parse(res);
                    if(r.status) {
                        setupDropdown('dropdownContent', 'success', r.message, 'click');
                        loadRefunds();
                    } else {
                        setupDropdown('dropdownContent', 'error', r.message, 'click');
                    }
                });
            }
        });
    }
    </script>
</body>
</html>
