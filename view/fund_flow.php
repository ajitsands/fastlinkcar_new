<?php
require_once dirname(__DIR__) . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__) . '/envfiles');
$dotenv->load();
define('ROOT_PATH', dirname(__DIR__));
?>
<!DOCTYPE html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <title>Fund Flow Report | AA CarRental</title>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>
        .report-card { transition: all 0.3s ease; border: none; }
        .report-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .overdue-highlight { background-color: #ffe5e5; border-left: 4px solid #ff4d49; cursor: pointer; }
        .month-detail-card { display: none; }
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
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Reports /</span> Fund Flow</h4>
                            <div class="d-flex gap-2">
                                <input type="date" id="startDate" class="form-control" value="<?= date('Y-m-01', strtotime('-5 months')) ?>">
                                <input type="date" id="endDate" class="form-control" value="<?= date('Y-m-t') ?>">
                                <button class="btn btn-primary" id="btnFilter">Filter</button>
                            </div>
                        </div>

                        <!-- KPI Cards Section Row 1: Current Expectations -->
                        <div class="row g-3 mb-3">
                            <!-- Pending Invoices (Net Receivables) -->
                            <div class="col-md-4">
                                <div class="card h-100 border-start border-info border-3 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 text-muted small fw-bold">Pending Invoices</h6>
                                            <div class="avatar avatar-xs bg-label-info rounded">
                                                <i class="ri-file-list-3-line"></i>
                                            </div>
                                        </div>
                                        <h3 class="mb-1 text-info" id="lblNetReceivables">0.000</h3>
                                        <div class="text-muted" style="font-size: 10px;">Unpaid invoices (Current Range)</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Cheques Card -->
                            <div class="col-md-4">
                                <div class="card h-100 border-start border-warning border-3 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 text-muted small fw-bold">Pending Cheques</h6>
                                            <div class="avatar avatar-xs bg-label-warning rounded">
                                                <i class="ri-bank-card-line"></i>
                                            </div>
                                        </div>
                                        <h3 class="mb-1 text-warning" id="lblPendingCheques">0.000</h3>
                                        <div class="text-muted" style="font-size: 10px;">Uncollected cheques (Current Range)</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Expected Inflow -->
                            <div class="col-md-4">
                                <div class="card h-100 border-start border-primary border-3 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 text-muted small fw-bold">Total Expected Inflow</h6>
                                            <div class="avatar avatar-xs bg-label-primary rounded">
                                                <i class="ri-money-dollar-circle-line"></i>
                                            </div>
                                        </div>
                                        <h3 class="mb-1 text-primary" id="lblTotalExpected">0.000</h3>
                                        <div class="text-muted" style="font-size: 10px;">Sum of Pending Invoices + Cheques</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KPI Cards Row 2: History & Realized Funds -->
                        <div class="row g-2 mb-4">
                            <!-- Backdate Dues Card -->
                            <div class="col-md-2">
                                <div class="card h-100 border-top border-danger border-3 shadow-sm" id="cardOverdue" onclick="showOverdueDetails()" style="background-color: #fcfcfc; cursor: pointer;">
                                    <div class="card-body p-2 text-center">
                                        <h6 class="mb-1 text-muted small fw-bold" style="font-size: 10px;">Backdate Dues</h6>
                                        <h5 class="mb-0 text-danger" id="lblOverdue">0.000</h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Amount Received -->
                            <div class="col-md-3">
                                <div class="card h-100 border-top border-success border-3 shadow-sm" style="background-color: #fcfcfc;">
                                    <div class="card-body p-2 text-center">
                                        <h6 class="mb-1 text-muted small fw-bold" style="font-size: 10px;">Total Received (Realized)</h6>
                                        <h5 class="mb-0 text-success" id="lblTotalReceived">0.000</h5>
                                    </div>
                                </div>
                            </div>

                            <!-- BY Check -->
                            <div class="col-md-2">
                                <div class="card h-100 border-top border-info border-3 shadow-sm" style="background-color: #fcfcfc;">
                                    <div class="card-body p-2 text-center">
                                        <h6 class="mb-1 text-muted small fw-bold" style="font-size: 10px;">By Cheque</h6>
                                        <h5 class="mb-0 text-info" id="lblByCheque">0.000</h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Cash Received -->
                            <div class="col-md-2">
                                <div class="card h-100 border-top border-dark border-3 shadow-sm" style="background-color: #fcfcfc;">
                                    <div class="card-body p-2 text-center">
                                        <h6 class="mb-1 text-muted small fw-bold" style="font-size: 10px;">Cash Received</h6>
                                        <h5 class="mb-0 text-dark" id="lblCashReceived">0.000</h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="col-md-3">
                                <div class="card h-100 border-top border-primary border-3 shadow-sm" style="background-color: #fcfcfc;">
                                    <div class="card-body p-2 text-center">
                                        <h6 class="mb-1 text-muted small fw-bold" style="font-size: 10px;">Bank Transfer Received</h6>
                                        <h5 class="mb-0 text-primary" id="lblBankReceived">0.000</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Expected Cash Inflow Timeline</h5>
                                        <small class="text-muted">Click on a month to see customer details</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="fundFlowChart" style="min-height: 350px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Section -->
                        <div class="row month-detail-card" id="detailSection">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header">
                                        <h5 class="mb-0">Breakdown for <span id="lblSelectedMonth" class="text-primary"></span></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblDetails" class="table table-hover border-top">
                                                <thead>
                                                    <tr>
                                                        <th>Customer Name</th>
                                                        <th>Mobile</th>
                                                        <th class="text-end">Invoice Bal.</th>
                                                        <th class="text-end">Pending Cheques</th>
                                                        <th class="text-end">Total Due</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End container-fluid -->
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                </div> <!-- End content-wrapper -->
            </div> <!-- End layout-page -->
        </div> <!-- End layout-container -->
    </div> <!-- End layout-wrapper -->

    <!-- Overdue Details Modal -->
    <div class="modal fade" id="modalOverdueDetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Overdue Pending Cheques</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    <div id="overdueChequeList" class="d-flex flex-column gap-3">
                        <!-- Badges/Details will be injected here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/moment/moment.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <script>
    let chart = null;

    function loadReport() {
        const start = $('#startDate').val();
        const end = $('#endDate').val();

        $.get('/FundFlowController', { action: 'GetMonthlySummary', start_date: start, end_date: end }, function(res) {
                if(res.status) {
                    $('#lblOverdue').text(parseFloat(res.overdue).toFixed(3));
                    renderChart(res.data);
                    
                    let totalDebit = 0;
                    let totalCash = 0;
                    let totalBank = 0;
                    let totalOther = 0;
                    let totalCollectedCheques = 0;
                    let totalPendingCheques = 0;

                    res.data.forEach(m => {
                        totalDebit += parseFloat(m.total_debit);
                        totalCash += parseFloat(m.cash_credit);
                        totalBank += parseFloat(m.bank_transfer_credit);
                        totalOther += parseFloat(m.other_payment_credit);
                        totalCollectedCheques += parseFloat(m.collected_cheques);
                        totalPendingCheques += parseFloat(m.pending_cheques);
                    });

                    const totalReceived = totalCash + totalBank + totalOther + totalCollectedCheques;
                    const netReceivables = totalDebit - totalReceived; 

                    $('#lblNetReceivables').text(netReceivables.toFixed(3));
                    $('#lblPendingCheques').text(totalPendingCheques.toFixed(3));
                    $('#lblTotalExpected').text((netReceivables + totalPendingCheques).toFixed(3));
                    
                    // Row 2 Metrics
                    $('#lblOverdue').text(parseFloat(res.overdue).toFixed(3));
                    $('#lblTotalReceived').text(totalReceived.toFixed(3));
                    $('#lblByCheque').text(totalCollectedCheques.toFixed(3));
                    $('#lblCashReceived').text(totalCash.toFixed(3));
                    $('#lblBankReceived').text(totalBank.toFixed(3));

                    // Update cursor for overdue card based on value (non-zero)
                    if (parseFloat(res.overdue) !== 0) {
                        $('#cardOverdue').css('cursor', 'pointer');
                    } else {
                        $('#cardOverdue').css('cursor', 'default');
                    }
                }
            }, 'json');
    }

    function renderChart(data) {
            const options = {
                series: [
                    { 
                        name: 'Net Receivables', 
                        data: data.map(m => parseFloat(m.total_debit) - (parseFloat(m.cash_credit) + parseFloat(m.bank_transfer_credit) + parseFloat(m.other_payment_credit) + parseFloat(m.collected_cheques))) 
                    },
                    { 
                        name: 'Pending Cheques', 
                        data: data.map(m => parseFloat(m.pending_cheques)) 
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: { show: false },
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            const month = data[config.dataPointIndex];
                            loadDetails(month.month_key, month.month_name);
                        }
                    }
                },
                colors: ['#696cff', '#ffab00'],
                plotOptions: { bar: { borderRadius: 4, columnWidth: '40%' } },
                dataLabels: { enabled: false },
                xaxis: { categories: data.map(m => m.month_name) },
                yaxis: { title: { text: 'Amount' } },
                legend: { position: 'top', horizontalAlign: 'left' }
            };

            if (chart) chart.destroy();
            chart = new ApexCharts(document.querySelector("#fundFlowChart"), options);
            chart.render();
        }

        function loadDetails(monthKey, monthName) {
            $('#lblSelectedMonth').text(monthName);
            $('#detailSection').fadeIn();
            
            $.get('/FundFlowController', { action: 'GetMonthlyDetails', month: monthKey }, function(res) {
                const tbody = $('#tblDetails tbody').empty();
                if(res.status && res.data.length > 0) {
                    res.data.forEach(item => {
                        let row = `<tr>
                            <td>${item.customer_name}</td>
                            <td>${item.customer_mobile}</td>
                            <td class="text-end">${parseFloat(item.balance).toFixed(3)}</td>
                            <td class="text-end text-warning">${parseFloat(item.pending_cheque_amount).toFixed(3)}</td>
                            <td class="text-end fw-bold">${(parseFloat(item.balance) + parseFloat(item.pending_cheque_amount)).toFixed(3)}</td>
                        </tr>`;
                        tbody.append(row);
                    });
                    $('html, body').animate({ scrollTop: $('#detailSection').offset().top - 50 }, 500);
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center">No data found</td></tr>');
                }
            }, 'json');
        }

        $(document).ready(function() {
            $('#btnFilter').on('click', loadReport);
            loadReport();
        });

    // Global function to bypass potential jQuery scope/binding issues
    function showOverdueDetails() {
        const overdueValStr = $('#lblOverdue').text().replace(/,/g, '').trim();
        const overdueVal = parseFloat(overdueValStr);
        
        // Do nothing if value is exactly 0
        if (isNaN(overdueVal) || overdueVal === 0) {
            return;
        }

        const start = $('#startDate').val();
        console.log('Fetching details for overdue:', overdueVal);

        const myAlert = (msg, type = 'info') => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ title: type === 'error' ? 'Error' : 'Info', text: msg, icon: type });
            } else {
                alert(msg);
            }
        };

        $.ajax({
            url: '/FundFlowController',
            type: 'GET',
            data: { action: 'GetOverdueDetails', start_date: start },
            success: function(res) {
                try {
                    const data = (typeof res === 'string') ? JSON.parse(res) : res;
                    
                    if(data.status && data.data && data.data.length > 0) {
                        const list = $('#overdueChequeList').empty();
                        data.data.forEach(c => {
                            let statusBadge = '';
                            let actionBtns = '';
                            
                            if (c.cheque_status === 'Pending') {
                                statusBadge = `<span class="badge bg-label-warning">Pending</span>`;
                                actionBtns = `
                                    <button type="button" class="btn btn-sm btn-outline-success btn-status-modal" data-id="${c.ids}" data-status="Collected" title="Collect">
                                        <i class="ri-check-line me-1"></i> Collect
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-status-modal" data-id="${c.ids}" data-status="Bounced" title="Bounce">
                                        <i class="ri-close-line me-1"></i> Bounce
                                    </button>
                                `;
                            } else {
                                const color = c.cheque_status === 'Collected' ? 'success' : 'danger';
                                statusBadge = `<span class="badge bg-label-${color}">${c.cheque_status}</span>`;
                                actionBtns = `
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-status-modal" data-id="${c.ids}" data-status="Pending" title="Revoke">
                                        <i class="ri-refresh-line me-1"></i> Revoke
                                    </button>
                                `;
                            }

                            const item = `
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded bg-light mb-2">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="mb-0 me-2">${c.customer_name}</h6>
                                            ${statusBadge}
                                        </div>
                                        <div style="font-size:11px" class="text-muted mb-2">
                                            <i class="ri-bank-line me-1"></i>From: ${c.from_bank || 'N/A'} 
                                            <span class="mx-2">|</span>
                                            <i class="ri-bank-fill me-1"></i>To: ${c.to_bank || 'N/A'}
                                        </div>
                                        <div class="small mb-2">
                                            <span class="badge bg-label-info">Ref: ${c.ref_no || '-'}</span>
                                            <span class="badge bg-label-secondary ms-1">Due: ${moment(c.cheque_date).format('DD MMM YYYY')}</span>
                                        </div>
                                        <!-- Action Buttons -->
                                        <div class="d-flex gap-2">
                                            ${actionBtns}
                                        </div>
                                    </div>
                                    <div class="text-end ms-3">
                                        <h5 class="mb-0 text-primary">${parseFloat(c.amount).toFixed(3)}</h5>
                                        <small class="text-uppercase fw-bold text-muted" style="font-size:10px">Cheque Amount</small>
                                    </div>
                                </div>
                            `;
                            list.append(item);
                        });
                        
                        // Try all possible ways to show the modal
                        const modalEl = document.getElementById('modalOverdueDetails');
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                            modal.show();
                        } else if ($.fn.modal) {
                            $(modalEl).modal('show');
                        }
                    } else {
                        myAlert('No pending cheques found for the overdue period (Balance: ' + overdueVal.toFixed(3) + ')');
                    }
                } catch (e) {
                    console.error('Parsing error:', e, res);
                    myAlert('Error processing details.', 'error');
                }
            },
            error: function(xhr, status, error) {
                myAlert('Failed to fetch details.', 'error');
            }
        });
    }

    // Handle Status Update from Modal
    $(document).on('click', '.btn-status-modal', function() {
        const id = $(this).data('id');
        const status = $(this).data('status');
        const msg = `Mark this overdue cheque as ${status}?`;
        
        if (typeof Swal === 'undefined') {
            if(!confirm(msg)) return;
            updateStatus();
        } else {
            Swal.fire({
                title: 'Are you sure?',
                text: msg,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) updateStatus();
            });
        }

        function updateStatus() {
            $.post('/CustomerLedgerController', { action: 'UpdateChequeStatus', ids: id, status: status }, function(res) {
                if(res.status) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Success', 'Cheque status updated successfully', 'success');
                    } else {
                        alert('Status updated successfully');
                    }
                    // Refresh both main report and modal content
                    if (typeof loadReport === 'function') loadReport();
                    showOverdueDetails(); 
                } else {
                    const errorMsg = res.message || 'Failed to update status';
                    if (typeof Swal !== 'undefined') Swal.fire('Error', errorMsg, 'error');
                    else alert(errorMsg);
                }
            }, 'json');
        }
    });
    </script>
</body>
</html>
