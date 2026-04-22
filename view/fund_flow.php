<?php
require_once dirname(__DIR__) . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__) . '/envfiles');
$dotenv->load();
define('ROOT_PATH', dirname(__DIR__));
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="vertical-menu-template">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <title>Fund Flow Report | AA CarRental</title>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/apex-charts/apex-charts.css" />
    <style>
        .report-card { transition: all 0.3s ease; border: none; }
        .report-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .overdue-highlight { background-color: #ffe5e5; border-left: 4px solid #ff4d49; }
        .month-detail-card { display: none; }
    </style>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include ROOT_PATH . '/view/templates/menu.php'; ?>
            <div class="layout-page">
                <?php include ROOT_PATH . '/view/templates/nav.php'; ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Reports /</span> Fund Flow</h4>
                            <div class="d-flex gap-2">
                                <input type="date" id="startDate" class="form-control" value="<?= date('Y-m-01', strtotime('-5 months')) ?>">
                                <input type="date" id="endDate" class="form-control" value="<?= date('Y-m-t') ?>">
                                <button class="btn btn-primary" id="btnFilter">Filter</button>
                            </div>
                        </div>

                        <!-- KPI Cards -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card report-card overdue-highlight">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-danger"><i class="ri-alert-line"></i></span>
                                            </div>
                                            <h6 class="mb-0">Backdate Dues (Overdue)</h6>
                                        </div>
                                        <h3 class="mb-1 text-danger" id="lblOverdue">0.000</h3>
                                        <p class="mb-0 small text-muted">Outstanding balances before the start date</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card report-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-primary"><i class="ri-bank-card-line"></i></span>
                                            </div>
                                            <h6 class="mb-0">Total Expected Inflow</h6>
                                        </div>
                                        <h3 class="mb-1 text-primary" id="lblTotalExpected">0.000</h3>
                                        <p class="mb-0 small text-muted">Invoices + Cheques within date range</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card report-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-warning"><i class="ri-time-line"></i></span>
                                            </div>
                                            <h6 class="mb-0">Pending Cheques</h6>
                                        </div>
                                        <h3 class="mb-1 text-warning" id="lblPendingCheques">0.000</h3>
                                        <p class="mb-0 small text-muted">Cheques deposited but not yet collected</p>
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

                    </div>
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/moment/moment.js"></script>

    <script>
    $(document).ready(function() {
        let chart = null;

        function loadReport() {
            const start = $('#startDate').val();
            const end = $('#endDate').val();

            $.get('/FundFlowController', { action: 'GetMonthlySummary', start_date: start, end_date: end }, function(res) {
                if(res.status) {
                    $('#lblOverdue').text(parseFloat(res.overdue).toFixed(3));
                    renderChart(res.data);
                    
                    let totalExp = 0;
                    let totalCheques = 0;
                    res.data.forEach(m => {
                        totalExp += parseFloat(m.total_debit) - parseFloat(m.total_credit);
                        totalCheques += parseFloat(m.pending_cheques);
                    });
                    $('#lblTotalExpected').text(totalExp.toFixed(3));
                    $('#lblPendingCheques').text(totalCheques.toFixed(3));
                }
            }, 'json');
        }

        function renderChart(data) {
            const options = {
                series: [{
                    name: 'Net Receivables',
                    data: data.map(m => (parseFloat(m.total_debit) - parseFloat(m.total_credit)).toFixed(3))
                }, {
                    name: 'Pending Cheques',
                    data: data.map(m => parseFloat(m.pending_cheques).toFixed(3))
                }],
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
                let html = '';
                const data = JSON.parse(res);
                if(data.status && data.data) {
                    data.data.forEach(row => {
                        html += `<tr>
                            <td>${row.customer_name}</td>
                            <td>${row.customer_mobile || '-'}</td>
                            <td class="text-end">${parseFloat(row.balance).toFixed(3)}</td>
                            <td class="text-end font-weight-bold ${parseFloat(row.pending_cheque_amount) > 0 ? 'text-warning' : ''}">${parseFloat(row.pending_cheque_amount).toFixed(3)}</td>
                            <td class="text-end fw-bold">${(parseFloat(row.balance) + parseFloat(row.pending_cheque_amount)).toFixed(3)}</td>
                        </tr>`;
                    });
                }
                $('#tblDetails tbody').html(html || '<tr><td colspan="5" class="text-center">No transactions found</td></tr>');
                $('html, body').animate({ scrollTop: $('#detailSection').offset().top - 50 }, 500);
            });
        }

        $('#btnFilter').on('click', loadReport);
        loadReport();
    });
    </script>
</body>
</html>
