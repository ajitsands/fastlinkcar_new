<?php
include ROOT_PATH . '/view/envinclude.php';
?>
<!doctype html>

<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/"
  data-template="horizontal-menu-template-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    
    <?php include ROOT_PATH . '/view/templates/title.php'; ?>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
    <style>
        
        .spin {
    animation: spin 1s linear infinite;
}
@keyframes spin {
    100% { transform: rotate(360deg); }
}
.custom-modal-header {
    background: linear-gradient(135deg, #f12526, #c81e1f);
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
            <div class="container-fluid flex-grow-1 container-p-y">
             
              <div class="row g-3">

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Total Vehicles</h6>
                        <h4>120</h4>
                    </div>
                    <i class="ri ri-car-line text-primary kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Available</h6>
                        <h4 class="text-success">80</h4>
                    </div>
                    <i class="ri ri-check-line text-success kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Rented</h6>
                        <h4 class="text-danger">30</h4>
                    </div>
                    <i class="ri ri-user-3-line text-danger kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Maintenance</h6>
                        <h4 class="text-warning">10</h4>
                    </div>
                    <i class="ri ri-tools-line text-warning kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Today Revenue</h6>
                        <h4>₹5,200</h4>
                    </div>
                    <i class="ri ri-money-dollar-circle-line text-success kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100 h-100" id="openCalendarBtn">
                <i class="ri ri-calendar-line me-1"></i>
                Open Calendar
            </button>
        </div>

    </div>


    <!-- ================= SECOND ROW ================= -->
    <div class="row mt-4 g-3">

        <!-- ALERTS -->
        <div class="col-md-4">
           
             <div class="card p-3 card-box">

    <h6 class="mb-3">
        🚨 Alerts & Notifications
        <span class="badge bg-danger">5</span>
    </h6>

    <!-- 🔴 OVERDUE RENTAL -->
    <div class="alert alert-danger py-2 px-2 mb-2 small" style="border-left:5px solid #dc3545;">
        <div class="d-flex justify-content-between">
            <div>
                <i class="ri ri-error-warning-line me-1"></i>
                <b>Overdue Return</b><br>
                <span class="small fw-bold">12345 - NISSAN MICRA</span><br>
                <small>Overdue by 2 days</small>
            </div>
            
        </div>
    </div>


    <!-- 🟡 INSURANCE EXPIRING -->
    <div class="alert alert-warning py-2 px-2 mb-2 small" style="border-left:5px solid #ffc107;">
        <div class="d-flex justify-content-between">
            <div>
                <i class="ri ri-shield-check-line me-1"></i>
                <b>Insurance Expiring</b><br>
                <span class="small fw-bold">67890 - TOYOTA COROLLA</span><br>
                <small>Due in 5 days (14-06-2026)</small>
            </div>
           
        </div>
    </div>


    <!-- 🔵 MAINTENANCE -->
    <div class="alert alert-info py-2 px-2 mb-2 small" style="border-left:5px solid #0dcaf0;">
        <div class="d-flex justify-content-between">
            <div>
                <i class="ri ri-tools-line me-1"></i>
                <b>Maintenance Due</b><br>
                <span class="small fw-bold">11111 - HONDA CITY</span><br>
                <small>Due in 3 days</small>
            </div>
            
        </div>
    </div>


    <!-- 🟢 PASSING DUE -->
    <div class="alert alert-success py-2 px-2 mb-2 small" style="border-left:5px solid #198754;">
        <div class="d-flex justify-content-between">
            <div>
                <i class="ri ri-car-line me-1"></i>
                <b>Passing Renewal</b><br>
                <span class="small fw-bold">22222 - KIA OPTIMA</span><br>
                <small>Due on 10-06-2026</small>
            </div>
           
        </div>
    </div>


    <!-- 💰 PAYMENT PENDING -->
    <div class="alert alert-primary py-2 px-2 mb-0 small" style="border-left:5px solid #0d6efd;">
        <div class="d-flex justify-content-between">
            <div>
                <i class="ri ri-money-dollar-circle-line me-1"></i>
                <b>Payment Pending</b><br>
                <span class="small fw-bold">33333 - NISSAN SUNNY</span><br>
                <small>Invoice ₹12,500 not paid</small>
            </div>
            
        </div>
    </div>

</div>
        </div>


        <div class="col-md-8">
    <div class="card card-box p-3">

        <h6 class="mb-1">
            📅 Expected Return Due
        </h6>

        <hr class="my-1">

        <table class="table table-sm align-middle">
            <thead >
                <tr>
                    <th>Vehicle</th>
                    <th>Customer</th>
                    <th>Start Date</th>
                    <th>Expected Return</th>
                    <th>Days Left</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <!-- 🔴 OVERDUE -->
                <tr >
                    <td><span class="small fw-bold">12345 - NISSAN MICRA</span></td>
                    <td>John</td>
                    <td>01-06-2026</td>
                    <td>10-06-2026</td>
                    <td><b>-2 Days</b></td>
                    <td><span class="badge bg-danger">Overdue</span></td>
                </tr>


                <!-- 🟡 DUE SOON -->
                <tr >
                    <td><span class="small fw-bold">67890 - TOYOTA COROLLA</span></td>
                    <td>Ali</td>
                    <td>03-06-2026</td>
                    <td>14-06-2026</td>
                    <td><b>3 Days</b></td>
                    <td><span class="badge bg-warning ">Due Soon</span></td>
                </tr>


                <!-- 🟢 SAFE -->
                <tr>
                    <td><span class="small fw-bold">22222 - HONDA CITY</span></td>
                    <td>Mohamed</td>
                    <td>05-06-2026</td>
                    <td>25-06-2026</td>
                    <td><b>14 Days</b></td>
                    <td><span class="badge bg-success">Active</span></td>
                </tr>


                <!-- 🟡 DUE SOON -->
                <tr >
                    <td><span class="small fw-bold">54321 - KIA SPORTAGE</span></td>
                    <td>Ahmed</td>
                    <td>06-06-2026</td>
                    <td>13-06-2026</td>
                    <td><b>2 Days</b></td>
                    <td><span class="badge bg-warning ">Due Soon</span></td>
                </tr>


                <!-- 🔴 OVERDUE -->
                <tr >
                    <td><span class="small fw-bold">77777 - NISSAN SUNNY</span></td>
                    <td>John</td>
                    <td>28-05-2026</td>
                    <td>05-06-2026</td>
                    <td><b>-4 Days</b></td>
                    <td><span class="badge bg-danger">Overdue</span></td>
                </tr>

            </tbody>

        </table>

    </div>
</div>

    </div>
            </div>
            <!--/ Content -->
           <?php include('templates/VehicleStatus/vehicle_filepreview_modal.php'); ?>
               <?php include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
               <?php include('templates/VehicleStatus/vehicle_calender_modal.php'); ?>
 
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

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

    <!-- endbuild -->

    <!-- Vendors JS -->
    
 <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/js/forms-selects.js"></script>
    <script src="../assets/sands/settings.js"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
     
   
<script>
$(document).ready(function() {

 

 let vehicleCalendar;
let calendarInitialized = false;

// ===============================
// OPEN CALENDAR BUTTON
// ===============================
$('#openCalendarBtn').on('click', function () {

    // Bootstrap 5 modal
    let modal = new bootstrap.Modal(document.getElementById('calendarModal'));
    modal.show();

    // Load calendar after modal opens
    setTimeout(function () {
        loadVehicleCalendar();
    }, 300);
});


// ===============================
// LOAD CALENDAR FUNCTION
// ===============================
function loadVehicleCalendar() {

    let calendarEl = document.getElementById('vehicleCalendar');

    // Prevent re-initialization
    if (calendarInitialized) {
        vehicleCalendar.render();
        return;
    }

    vehicleCalendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        height: "auto",
        expandRows: true,

        // ===============================
        // EVENTS LOAD (AJAX)
        // ===============================
        events: function (fetchInfo, successCallback) {

            $.ajax({
                url: '/LoadVehicleByUserSellection',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'vehicle_calendar'
                }),

                success: function (response) {

                    let events = [];

                    response.data.forEach(v => {

                        let baseTitle = v.vehicle_number + ' - ' + v.model_names;
                        let status = v.vehicle_status || '';

                        // =========================
                        // 🔴 PASSING
                        // =========================
                        if (v.next_passing_date) {
                            events.push({
                                title: baseTitle,
                                start: v.next_passing_date,
                                color: '#dc3545',
                                extendedProps: {
                                    status: status,
                                    type: 'Passing'
                                }
                            });
                        }

                        // =========================
                        // 🔵 INSURANCE
                        // =========================
                        if (v.next_insurance_date) {
                            events.push({
                                title: baseTitle ,
                                start: v.next_insurance_date,
                                color: '#0d6efd',
                                 extendedProps: {
                                    status: status,
                                    type: 'Insurance'
                                }
                            });
                        }

                        // =========================
                        // 🟢 MAINTENANCE
                        // =========================
                        if (v.next_maintenance_date) {
                            events.push({
                                title: baseTitle ,
                                start: v.next_maintenance_date,
                                color: '#198754',
                                extendedProps: {
                                    status: status,
                                    type: 'Maintenance'
                                }
                            });
                        }

                    });

                    successCallback(events);
                }
            });
        },

      eventContent: function (info) {

    let props = info.event.extendedProps || {};

    let status = props.status || '-';
    let type = props.type || '-';

    return {
        html: `
            <div style="font-size:11px; line-height:1.2;">
           
                <div style="font-weight:400;">
                    ${info.event.title}
                </div>

                <div style="
                    display:flex;
                    justify-content:space-between;
                    font-size:10px;
                    margin-top:2px;
                ">
                    <span>[${type}]</span>
                    <span>[${status}]</span>
                </div>

            </div>
        `
    };
}

    });

    vehicleCalendar.render();
    calendarInitialized = true;
}

});

</script>

   
  </body>
  
</html>
