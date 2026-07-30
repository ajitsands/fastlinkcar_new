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
// view/customer_balance_report.php
include ROOT_PATH . '/view/envinclude.php';
?>
<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/notyf/notyf.css" />
    <style>
        .clickable-name { cursor: pointer; color: #696cff; font-weight: 500; text-decoration: none; }
        .clickable-name:hover { text-decoration: underline; color: #5f61e6; }
        .balance-card { border-left: 4px solid; }
        .card-company-receives { border-left-color: #ff4d49; }
        .card-company-pays { border-left-color: #72e128; }
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
          
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> Customer Balances Summary</h4>
          
          <!-- Summary Cards -->
          <div class="row g-4 mb-4">
              <div class="col-md-6">
                  <div class="card balance-card card-company-receives shadow-sm">
                      <div class="card-body">
                          <h6 class="card-subtitle text-muted mb-1">Total Outstanding (Company Should Receive)</h6>
                          <h4 class="card-title mb-0 text-danger" id="lblTotalReceivable">0.000</h4>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="card balance-card card-company-pays shadow-sm">
                      <div class="card-body">
                          <h6 class="card-subtitle text-muted mb-1">Total Overpaid (Company Should Pay Back)</h6>
                          <h4 class="card-title mb-0 text-success" id="lblTotalPayable">0.000</h4>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Data Table -->
          <div class="card">
            <div class="card-datatable table-responsive">
              <table id="tblBalances" class="table table-hover border-top">
                <thead>
                  <tr>
                    <th>Customer Name</th>
                    <th>Mobile</th>
                    <th class="text-end">Total Debit (Owed)</th>
                    <th class="text-end">Total Credit (Paid)</th>
                    <th>Status</th>
                    <th class="text-end">Balance Amount</th>
                  </tr>
                </thead>
                <tbody></tbody>
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
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sands_alert.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/notyf/notyf.js"></script>

<script>
$(document).ready(function() {
    
    // Encrypted route value for CustomerLedger link
    // We assume the route allows 'CustomerLedger?customer_code=XYZ' natively, or we handle it in JS.
    const ENCRYPTED_LEDGER_VAL = '<?php echo $this->encryption->encrypt("5,5-1"); ?>';

    let tblBalances = $('#tblBalances').DataTable({
        ajax: {
            url: '/CustomerBalances',
            type: 'POST',
            data: { action: 'get_balances' },
            dataSrc: function(json) {
                if(json.status === 'success') {
                    
                    let totalReceivable = 0;
                    let totalPayable = 0;
                    
                    json.data.forEach(row => {
                        let bal = parseFloat(row.balance);
                        if (bal > 0) totalReceivable += bal;
                        if (bal < 0) totalPayable += Math.abs(bal);
                    });
                    
                    $('#lblTotalReceivable').text(totalReceivable.toFixed(3));
                    $('#lblTotalPayable').text(totalPayable.toFixed(3));
                    
                    return json.data;
                }
                return [];
            }
        },
        columns: [
            { 
                data: 'customer_name',
                render: function(data, type, row) {
                    // Deep link to the customer ledger
                    let url = `/CustomerLedger?val=${ENCRYPTED_LEDGER_VAL}&customer_code=${encodeURIComponent(row.customer_id)}&customer_name=${encodeURIComponent(row.customer_name)}`;
                    return `<a href="${url}" class="clickable-name"><i class="ri-user-line me-1"></i>${data}</a>`;
                }
            },
            { data: 'customer_mobile', render: v => v || '-' },
            { data: 'total_debit', className: 'text-end text-danger', render: v => parseFloat(v).toFixed(3) },
            { data: 'total_credit', className: 'text-end text-success', render: v => parseFloat(v).toFixed(3) },
            { 
                data: 'balance',
                render: function(v) {
                    let bal = parseFloat(v);
                    if (bal > 0) return '<span class="badge bg-label-danger">Pending Payment</span>';
                    if (bal < 0) return '<span class="badge bg-label-success">Credit Balance</span>';
                    return '<span class="badge bg-label-secondary">Settled</span>';
                }
            },
            { 
                data: 'balance', 
                className: 'text-end fw-bold',
                render: function(v) {
                    let bal = parseFloat(v);
                    if (bal > 0) return `<span class="text-danger">${bal.toFixed(3)}</span>`;
                    if (bal < 0) return `<span class="text-success">${Math.abs(bal).toFixed(3)} (Cr)</span>`;
                    return `<span class="text-secondary">0.000</span>`;
                }
            }
        ],
        order: [[0, 'asc']],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        pageLength: 25
    });
});
</script>

</body>
</html>
