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

// Company Access Privilege Resolution
$pdoModelObj = new CommonPDOModel();
$isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);
$userId = $_SESSION['user_id'] ?? 0;

$allCompanies = [];
try {
    $stmtComp = $pdoModelObj->selectexecuteQuery("SELECT ids, company_name FROM tbl_company WHERE status = 'Active' ORDER BY ids ASC");
    if ($stmtComp && $stmtComp instanceof PDOStatement) {
        $allCompanies = $stmtComp->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (\Throwable $e) {}

$allowedCompanies = [];
if ($isSuperAdmin) {
    $allowedCompanies = $allCompanies;
} else {
    if (!empty($_SESSION['company_json'])) {
        $decoded = json_decode($_SESSION['company_json'], true);
        if (is_array($decoded) && !empty($decoded)) {
            $allowedCompanies = $decoded;
        }
    }
    if (empty($allowedCompanies) && !empty($userId)) {
        try {
            $uStmt = $pdoModelObj->selectexecuteQuery("SELECT company_json, company_id FROM tbl_users WHERE id = :uid OR user_id = :uid LIMIT 1", [':uid' => $userId]);
            if ($uStmt && $uStmt instanceof PDOStatement) {
                $uRow = $uStmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($uRow['company_json'])) {
                    $decoded = json_decode($uRow['company_json'], true);
                    if (is_array($decoded) && !empty($decoded)) {
                        $allowedCompanies = $decoded;
                    }
                }
                if (empty($allowedCompanies) && !empty($uRow['company_id'])) {
                    foreach ($allCompanies as $ac) {
                        if (strval($ac['ids']) === strval($uRow['company_id'])) {
                            $allowedCompanies[] = $ac;
                            break;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {}
    }
    if (empty($allowedCompanies) && !empty($_SESSION['company_id'])) {
        foreach ($allCompanies as $ac) {
            if (strval($ac['ids']) === strval($_SESSION['company_id'])) {
                $allowedCompanies[] = $ac;
                break;
            }
        }
    }
}

if (empty($allowedCompanies)) {
    $allowedCompanies = !empty($allCompanies) ? $allCompanies : [['ids' => '1', 'company_name' => 'AA Car Rental']];
}

$hasMultipleCompanies = count($allowedCompanies) > 1;
$defaultCompanyValue  = $hasMultipleCompanies ? 'all' : strval($allowedCompanies[0]['ids']);
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


    <!-- Helpers -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">


    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/spinkit/spinkit.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <style>
    html, body {
    overflow-x: hidden;
        }
        
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        .list-group-item.active-click {
          background-color: #1b3d94; /* Bootstrap primary */
          color: white;
        }
        .table-active {
            background-color: #1b3d94 !important; /* Red background */
            color: white !important;              /* White text */
        }
        
        .table-active td {
            color: white !important;              /* Make all cell text white */
        }
        .highlight {
          background-color: yellow;
          font-weight: bold;
        }
    
   
        .swiper {
            width: 400px;
            height: 300px;
        }

        .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            background-size: cover;
            background-position: center;
        }

        .modal {
            z-index: 10065 !important;
        }

        .modal-backdrop {
            z-index: 10060 !important;
        }

        /* Desktop / Large screens */
        @media (min-width: 992px) {
            #offcanvasCarBooking {
                --bs-offcanvas-width: 50% !important;
            }
        }

        @media (max-width: 991.98px) {
            #offcanvasCarBooking {
                --bs-offcanvas-width: 100% !important;
            }
        }

        #customerAttachmentUploadModal .modal-content,
        #addNewCustomerModal .modal-content,
        #filePreviewModal .modal-content {
            box-shadow:
                0 25px 80px rgba(0, 0, 0, 0.65),
                0 0 0 1px rgba(255, 255, 255, 0.05);
        }
        #modelsTable tbody tr {
          cursor: pointer;
        }
        #modelsTable thead {
            display: none;
        }
        .vehicle-card {
          transition: 0.2s;
          background: #fff;
        }
        
        .vehicle-card:hover {
          background: #f8f9fa;
          transform: translateY(-2px);
          cursor: pointer;
        }
        
        .btn-sm, .btn-group-sm > .btn {
        --bs-btn-padding-y: 0.2415rem;
        --bs-btn-padding-x: 0.369rem;
}

.vehicle-card.selected {
    border: 2px solid #1b3d94;       /* red border for selection */
    background-color: #eef3fc;       /* light highlight */
    box-shadow: 0 0 10px rgba(27, 61, 148, 0.4); /* optional glow */
    transition: all 0.2s ease-in-out;
}

#selectedVehiclesFooter::-webkit-scrollbar {
    height: 6px;
}

#selectedVehiclesFooter::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}

.custom-modal-header {
    background: linear-gradient(135deg, #1b3d94, #153075);
    color: white !important; 
    border-bottom: none;
}

.custom-modal-header .modal-title {
    color: #fff;
}

.custom-modal-header .btn-close {
    filter: invert(1); /* makes the close (X) icon white */
    opacity: 1;
}
.modal-body {
    background-color: #f8f9fa;
}

.card {
    border-radius: 12px;
}

.nav-pills .nav-link {
    border-radius: 20px;
    padding: 6px 14px;
}

.nav-pills .nav-link.active {
    background-color: #1b3d94;
}

//SaNDS Alert
#popupOverlay {
    z-index: 999998 !important;
    pointer-events: auto !important;
}

#popupContainer {
    z-index: 999999 !important;
    pointer-events: auto !important;
}

.bg-purple {
    background: #7950f2 !important;

</style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->
            <?php include ROOT_PATH . '/view/templates/nav.php'; ?>
            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    <?php include ROOT_PATH . '/view/templates/menu.php'; ?>
                    <!-- / Menu -->

                    <!-- Content -->
                    
                        <!-- Layout Demo -->
                        
                        <?php include ROOT_PATH . '/view/templates/VehicleCashReport/vehicle_cash_report_body.php'; ?>
                         <?php include('templates/VehicleReservation/vehicle_images_slider.php'); ?>
                         <?php include('templates/VehicleStatus/vehicle_return_calender.php'); ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleInsight/vehicle_change_status_modal.php'; ?>
                        <!--/ Layout Demo -->
                    
                    <!--/ Content -->

                    <!-- Footer -->
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>
    <div id="dropdownContent" style="text-align:center;"></div> 
     <?php include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
   

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-selects.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
    <script>
$(document).ready(function() {
$('#vehicleModelAvail').select2({
    dropdownParent: $('#dropdownContaineravail'),
    width: '100%',
     allowClear: true
}); 


    modelloadDropdown();

    function modelloadDropdown() {
       $('#dropdownContaineravail').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading models...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadVehicleModelReservationAvail',
            type: 'GET',
            success: function (response) {
                $('#dropdownContaineravail').html(response);

                $('#vehicleModelAvail').select2({
                    placeholder: "Select Model",
                    allowClear: true,
                    width: '100%'
                });
            },
        error: function (xhr, status, error) {
            $('#dropdownContaineravail').html(`
            <div class="text-center p-3">
                <div class="mt-2">Error loading data</div>
            </div>`);
            
            console.error(error);
        }
        });
    }
   
   //customer filter

$('#selectCustomerFromSelect2_filter').select2({
  
    placeholder: 'Search customer by name, mobile or CPR/CR',
    allowClear: true,
    minimumInputLength: 2,
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
                    id: item.customer_code,
                    text: item.customer_name,
                    customer_name: item.customer_name,
                    customer_mobile: item.customer_mobile,
                    customer_address: item.customer_addr,
                    customer_email: item.customer_email,
                    customer_code: item.customer_code,
                    customer_attn: item.customer_attn,
                    customer_cr_cpr: item.customer_cr_cpr
                }))
            };
        }
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
    return customer.customer_name
        ? `${customer.customer_name}`
        : customer.text;
}
$('#selectCustomerFromSelect2_filter').on('select2:select', function (e) {

    const data = e.params.data;

    $('#customer_code_filter').val(data.customer_code);

});

$('#selectCustomerFromSelect2_filter').on('select2:clear', function () {

    $('#customer_code_filter').val('');

});   

  if (!$.fn.DataTable.isDataTable('#tbl_report')) {
        
        reportTable = $('#tbl_report').DataTable({
             data: [],
            pageLength: 50,
            lengthChange: false,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: false,
           
    footerCallback: function (row, data, start, end, display) {

    var api = this.api();

    // Overall Income Total
    var incomeTotal = api
        .column(8, { page: 'current' })
        .data()
        .reduce(function (sum, value) {
            value = $('<div>').html(value).text().replace(/,/g, '');
            return sum + (parseFloat(value) || 0);
        }, 0);

    $(api.column(8).footer()).html(
        incomeTotal.toLocaleString('en-US', {
            minimumFractionDigits: 3,
            maximumFractionDigits: 3
        })
    );

    // Overall Expense Total
    var expenseTotal = api
        .column(9, { page: 'current' })
        .data()
        .reduce(function (sum, value) {
            value = $('<div>').html(value).text().replace(/,/g, '');
            return sum + (parseFloat(value) || 0);
        }, 0);

    $(api.column(9).footer()).html(
        expenseTotal.toLocaleString('en-US', {
            minimumFractionDigits: 3,
            maximumFractionDigits: 3
        })
    );

    // ==========================================
    // Payment Mode Summary
    // ==========================================

    var summary = {};

    api.rows({ page: 'current' }).every(function () {

        var d = this.data();

        var paymentMode = $('<div>').html(d[3]).text().trim();

        var income = parseFloat(
            $('<div>').html(d[8]).text().replace(/,/g, '')
        ) || 0;

        var expense = parseFloat(
            $('<div>').html(d[9]).text().replace(/,/g, '')
        ) || 0;

        if (!summary[paymentMode]) {
            summary[paymentMode] = {
                income: 0,
                expense: 0
            };
        }

        summary[paymentMode].income += income;
        summary[paymentMode].expense += expense;
    });

    var html = '<table class="table table-sm table-bordered mb-0">';
    html += '<thead>';
    html += '<tr class="table-light">';
    html += '<th>Payment Mode</th>';
    html += '<th class="text-end">Income</th>';
    html += '<th class="text-end">Expense</th>';
    html += '</tr>';
    html += '</thead><tbody>';

    $.each(summary, function (mode, val) {

        html += '<tr>';
        html += '<td>' + mode + '</td>';
        html += '<td class="text-end">' + val.income.toFixed(3) + '</td>';
        html += '<td class="text-end">' + val.expense.toFixed(3) + '</td>';
        html += '</tr>';

    });

    html += '</tbody></table>';

    $('#paymentSummary').html(html);
    var depositTotal = 0;
var refundTotal = 0;

api.rows({ search: 'applied' }).every(function () {

    var d = this.data();

    var itemName = $('<div>').html(d[6]).text().trim().toLowerCase();

    var income = parseFloat(
        $('<div>').html(d[8]).text().replace(/,/g, '')
    ) || 0;

    var expense = parseFloat(
        $('<div>').html(d[9]).text().replace(/,/g, '')
    ) || 0;

    // Deposit (case-insensitive)
    if (itemName.indexOf('deposit') !== -1) {
        depositTotal += income;
    }

    // Refund (case-insensitive)
    if (itemName.indexOf('refund') !== -1) {
        refundTotal += expense;
    }
});

$('#depositTotal').html(depositTotal.toFixed(3));
$('#refundTotal').html(refundTotal.toFixed(3));
}
});
    }
// ✅ Set default date = today
   let fromDate = new Date();
let toDate = new Date();

//toDate.setDate(toDate.getDate() + 10);

$('#filter_from_date').val(fromDate.toISOString().split('T')[0]);
$('#filter_to_date').val(toDate.toISOString().split('T')[0]);

let defaultCompanyVal = '<?= $defaultCompanyValue ?>';

loadreportList($('#filter_from_date').val(), $('#filter_to_date').val(), $('#customer_code_filter').val(), $('#vehicleModelAvail').val(), $('#filter_company').val() || defaultCompanyVal);

function loadreportList(startDate = '', endDate = '', customer_code = '', vehicle_model = '', company_id = '') {
    $.post('/DailyReportController', 
    { 
        startDate: startDate,
        endDate: endDate,
        customer_code: customer_code,
        vehicle_model: vehicle_model,
        company_id: company_id,
        action: 'GetDailyCashReport'
    }, 
    function(response) {

        let res = typeof response === "string" ? JSON.parse(response) : response;

        // Clear old data and add new rows
        reportTable.clear();
        reportTable.rows.add(res.data);
        reportTable.draw();
    });
}
   
$('#btnSearch').click(function () {
   var startDate = $('#filter_from_date').val();
   var endDate = $('#filter_to_date').val();
   var customer_code = $('#customer_code_filter').val();
   var vehicle_model = $('#vehicleModelAvail').val();
   var company_id = $('#filter_company').val() || defaultCompanyVal;
   
   loadreportList(startDate, endDate, customer_code, vehicle_model, company_id);
});

$(document).on('change', '#filter_company', function() {
    $('#btnSearch').trigger('click');
});
    $(document).on('click', '#tbl_report a.view_contract_table', function (e) {

     let btn = this;

     
     let agreement_no = $(this).data('contract');
     
  fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(agreement_no)))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/PrintAgreement?token=' + encodeURIComponent(token), '_blank');
        });
    

});

$('#btnExport').click(function () {
                
 
   var startDate= $('#filter_from_date').val();
   var endDate= $('#filter_to_date').val();
   var customer_code = $.trim($('#customer_code_filter').val()) || 'All';
   var vehicle_model= $('#vehicleModelAvail').val();
   var company_id = $('#filter_company').val() || defaultCompanyVal;
   
   const params = new URLSearchParams({
    from: startDate,
    to: endDate,
    customer_code: customer_code,
    vehicle_model: vehicle_model,
    company_id: company_id
});

    fetch('/controller/ajax_encrypt_common.php?' + params.toString())
        .then(response => response.text())
        .then(token => {
            token = token.trim();

            if (!token) {
                Swal.fire('Error', 'Encryption failed.', 'error');
                return;
            }

            window.open('/DailyCashReportExport?token=' + encodeURIComponent(token), '_blank');
        })
        .catch(error => {
            console.error(error);
            Swal.fire('Error', 'Unable to generate the report.', 'error');
        });
 

});
   
});
</script>

</body>

</html>