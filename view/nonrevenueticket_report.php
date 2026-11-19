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
                        
                        <?php include ROOT_PATH . '/view/templates/NonRevenueReport/vehicle_nonrevenue_report_body.php'; ?>
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
   
   //staff filter

    $('#selectStaffFromSelect2').select2({
      
        placeholder: 'Search staff by name or mobile',
        allowClear: true,
        minimumInputLength: 2,
        ajax: {
            url: '/SearchStaffDetails',
            dataType: 'json',
            delay: 300,
            data: function (params) {
                return {
                    q: params.term,
                    action: 'SearchStaff'
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.staff_name,
                        staff_name: item.staff_name,
                        staff_contact_no: item.staff_contact_no,
                        staff_email_id: item.staff_email_id,
                        staff_cpr_no: item.staff_cpr_no,
                        license_no: item.license_no,
                        license_issue_place: item.license_issue_place,
                        license_issue_date: item.license_issue_date,
                        license_expiry_date: item.license_expiry_date,
                        staff_cpr_expiry_date: item.staff_cpr_expiry_date
                    }))
                };
            }
        },
        templateResult: formatStaff,
        templateSelection: formatStaffSelection
    });


function formatStaff(staff) {
    if (!staff.id) return staff.text;

    return $(`
        <div>
            <strong>${staff.staff_name} | ${staff.staff_contact_no}</strong>
        </div>
    `);
}

function formatStaffSelection(staff) {
    return staff.staff_name
        ? `${staff.staff_name}`
        : staff.text;
}
$('#selectStaffFromSelect2').on('select2:select', function (e) {

    const data = e.params.data;

    $('#staff_id_filter').val(data.id);

});

$('#selectStaffFromSelect2').on('select2:clear', function () {

    $('#staff_id_filter').val('');

});   


   //vehicle filter

    $('#selectVehicleFromSelect2').select2({
      
        placeholder: 'Search vehicle by vehicle number',
        allowClear: true,
        minimumInputLength: 2,
        ajax: {
            url: '/SearchVehicleDetails',
            dataType: 'json',
            delay: 300,
            data: function (params) {
                return {
                    q: params.term,
                    action: 'SearchVehicle'
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.model_names,
                        vehicle_number: item.vehicle_number,
                        vehicle_year: item.vehicle_year,
                        vehicle_color: item.vehicle_color
                    }))
                };
            }
        },
        templateResult: formatVehicle,
        templateSelection: formatVehicleSelection
    });


function formatVehicle(vehi) {
    if (!vehi.id) return vehi.text;

    return $(`
        <div>
            <strong>${vehi.text} | ${vehi.vehicle_number}</strong>
        </div>
    `);
}

function formatVehicleSelection(vehi) {
    return vehi.vehicle_number
        ? `${vehi.vehicle_number}`
        : vehi.text;
}
$('#selectVehicleFromSelect2').on('select2:select', function (e) {

    const data = e.params.data;

    $('#vehicle_id_filter').val(data.id);

});

$('#selectVehicleFromSelect2').on('select2:clear', function () {

    $('#vehicle_id_filter').val('');

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
    
});
    }
// ✅ Set default date = today
   var today = new Date();

    // First day of current month
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

    // Format as YYYY-MM-DD
    var date = firstDay.getFullYear() + '-' +
        ('0' + (firstDay.getMonth() + 1)).slice(-2) + '-' +
        ('0' + firstDay.getDate()).slice(-2);

    $('#filter_from_date').val(date);
let toDate = new Date();


$('#filter_to_date').val(toDate.toISOString().split('T')[0]);
 loadreportList($('#filter_from_date').val(),$('#filter_to_date').val(),$('#customer_code_filter').val(),$('#vehicleModelAvail').val());
function loadreportList(startDate = '', endDate = '', staff_id='', vehicle_id='') {
    $.post('/DailyReportController', 
    { 
        startDate: startDate,
        endDate: endDate,
        staff_id: staff_id,
        vehicle_id: vehicle_id,
        action: 'GetNonRevenueReport'
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
                
 
   var startDate= $('#filter_from_date').val();
   var endDate= $('#filter_to_date').val();
   var staff_id= $('#staff_id_filter').val();
   var vehicle_id= $('#vehicle_id_filter').val();
   
    loadreportList(startDate,endDate,staff_id,vehicle_id);

});
  

  $('#btnExport').click(function () {
                
 
   var startDate= $('#filter_from_date').val();
   var endDate= $('#filter_to_date').val();
   var staff_id= $('#staff_id_filter').val();
   var vehicle_id= $('#vehicle_id_filter').val();
   
   const params = new URLSearchParams({
    from: startDate,
    to: endDate,
    staff_id: staff_id,
    vehicle_id: vehicle_id
});

    fetch('/controller/ajax_encrypt_nrt.php?' + params.toString())
        .then(response => response.text())
        .then(token => {
            token = token.trim();

            if (!token) {
                Swal.fire('Error', 'Encryption failed.', 'error');
                return;
            }

            window.open('/NonRevenueTicketExport?token=' + encodeURIComponent(token), '_blank');
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