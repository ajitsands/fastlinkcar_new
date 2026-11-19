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
             
              <?php include('templates/vehicles/vehicle_list_body.php'); ?>
             
              <?php include('templates/VehicleStatus/vehicle_filepreview_modal.php'); ?>
               <?php include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
               <?php include('templates/VehicleStatus/vehicle_calender_modal.php'); ?>
                   <!-- slider modal -->
  <div
    class="modal-onboarding modal fade animate__animated"
    id="modalvehicleimages" data-bs-backdrop="static"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content text-center">
        <div class="modal-header border-0">
          
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div
          id="modalCarouselControls"
          class="carousel slide pb-6 mb-2"
          data-bs-interval="false">
          <div class="carousel-indicators">
            <button
              type="button"
              data-bs-target="#modalCarouselControls"
              data-bs-slide-to="0"
              class="active"></button>
            <button
              type="button"
              data-bs-target="#modalCarouselControls"
              data-bs-slide-to="1"></button>
            <button
              type="button"
              data-bs-target="#modalCarouselControls"
              data-bs-slide-to="2"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="onboarding-media">
                <div class="mx-2">
                  <img
                    src="../<?= $_ENV['BASE_URL'] ?>assets/img/illustrations/girl-with-laptop-light.png"
                    alt="girl-with-laptop-light"
                    width="335"
                    class="img-fluid"
                    data-app-light-img="illustrations/girl-with-laptop-light.png"
                    data-app-dark-img="illustrations/girl-with-laptop-dark.png" />
                </div>
              </div>
              <div class="onboarding-content">
                <h4 class="onboarding-title text-body">Example Request Information</h4>
               
              </div>
            </div>
            <div class="carousel-item">
              <div class="onboarding-media">
                <div class="mx-2">
                  <img
                    src="../<?= $_ENV['BASE_URL'] ?>assets/img/illustrations/boy-with-laptop-light.png"
                    alt="boy-with-laptop-light"
                    width="300"
                    class="img-fluid"
                    data-app-light-img="illustrations/boy-with-laptop-light.png"
                    data-app-dark-img="illustrations/boy-with-laptop-dark.png" />
                </div>
              </div>
              <div class="onboarding-content">
                <h4 class="onboarding-title text-body">Example Request Information</h4>
                <div class="onboarding-info">
                  In this example you can see a form where you can request some additional
                  information from the customer when they land on the app page.
                </div>
                
              </div>
            </div>
            <div class="carousel-item">
              <div class="onboarding-media">
                <div class="mx-2">
                  <img
                    src="../<?= $_ENV['BASE_URL'] ?>assets/img/illustrations/girl-verify-password-light.png"
                    alt="girl-verify-password-light"
                    width="300"
                    class="img-fluid"
                    data-app-light-img="illustrations/girl-verify-password-light.png"
                    data-app-dark-img="illustrations/girl-verify-password-dark.png" />
                </div>
              </div>
              <div class="onboarding-content">
                <h4 class="onboarding-title text-body">Example Request Information</h4>
                <div class="onboarding-info">
                  In this example you can see a form where you can request some additional
                  information from the customer when they land on the app page.
                </div>
              
              </div>
            </div>
          </div>
          <a
            class="carousel-control-prev"
            href="#modalCarouselControls"
            role="button"
            data-bs-slide="prev">
            <i
              class="icon-base ri ri-arrow-left-double-line icon-18px scaleX-n1-rtl lh-1 me-1"></i
            ><span>Previous</span>
          </a>
          <a
            class="carousel-control-next"
            href="#modalCarouselControls"
            role="button"
            data-bs-slide="next">
            <span>Next</span
            ><i
              class="icon-base ri ri-arrow-right-double-line icon-18px scaleX-n1-rtl lh-1 ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--/ slider modal -->
             
            </div>
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
      <!--<script src="../httpdocs/user_js/vehicle_dates_calender.js"></script>-->
    <!-- Main JS -->

    <!--<script src="<?= $_ENV['BASE_URL'] ?>assets/js/main.js"></script>-->

    <!-- Page JS -->
    <!--<script src="<?= $_ENV['BASE_URL'] ?>assets/js/app-ecommerce-product-list.js"></script>-->
    <!-- jQuery first -->
<script>
$(document).ready(function() {
$('[data-bs-toggle="tooltip"]').tooltip();
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
    
// ✅ Set default date = today
    let today = new Date().toISOString().split('T')[0];
    $('#filter_date').val(today);

    // ✅ Initialize DataTable
    var table = $('#vehicleTable').DataTable({
        pageLength: 100,
        processing: true,
        ajax: {
            url: '/LoadVehicleByUserSellection',
            type: 'POST',
            contentType: 'application/json',
            data: function (d) {
                return JSON.stringify({
                    action: 'ListVehicleMaster_Due_days',
                    filter_date: $('#filter_date').val(),
                    vehicle_model: $('#vehicleModelAvail').val() || 'All',
                    company_id: $('#companyFilter').val()
                });
            },
            dataSrc: 'data',
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        },

        columns: [

            // ✅ Serial Number
            {
                data: null,
                title: '#',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },

            { data: 'model_names' ,
                 render: function (data, type, row, meta) {
                     let html = `<span class="small fw-bold">${data || ''}</span>`;
                     html += `<small class="d-block text-success mt-1 lh-1"><i class="ri ri-building-4-line align-middle"></i> Reg Co: ${row.ownership_company || 'N/A'}</small>`;
                     return html;
                }
            },
            { data: 'vehicle_number' ,
                 render: function (data, type, row, meta) {
                     let html = `<span class="small fw-bold">${data}</span>`;
                     if (row.is_outsourced === 'Yes') {
                         html += `<small class="d-block text-warning mt-1 lh-1"><i class="ri ri-share-forward-line align-middle"></i> Outsource: ${row.outsourcing_company_name || row.outsourcing_company || 'N/A'}</small>`;
                     }
                     return html;
                }
            },

            // ✅ Details Column (Icons)
           {
    data: null,
    title: 'Details',
    render: function (data, type, row) {

        let details = {};

        if (typeof row.other_details_json === 'string') {
            try {
                details = JSON.parse(row.other_details_json || '{}');
            } catch (e) {
                details = {};
            }
        }

        return `
            <div style="font-size:12px; line-height:1.4;">

                <!-- ROW 1 -->
                <div style="display:flex; justify-content:space-between; gap:10px; margin-bottom:4px;">

                    <div style="display:flex; align-items:center; gap:6px;">
                        <i class="ri ri-calendar-line text-primary"></i>
                        <span>${row.vehicle_year ?? '-'}</span>
                    </div>

                    <div style="display:flex; align-items:center; gap:6px;">
                        <i class="ri ri-palette-line text-warning"></i>
                        <span>${row.vehicle_color ?? '-'}</span>
                    </div>

                </div>

                <!-- ROW 2 -->
                <div style="display:flex; justify-content:space-between; gap:10px;">

                    <div style="display:flex; align-items:center; gap:6px;">
                        <i class="ri ri-gas-station-line text-success"></i>
                        <span>${details?.vehicleFuelType ?? '-'}</span>
                    </div>

                    <div style="display:flex; align-items:center; gap:6px;">
                        <i class="ri ri-settings-3-line text-info"></i>
                        <span>${details?.vehicleGearType ?? '-'}</span>
                    </div>

                </div>

            </div>
        `;
    }
},

            // ✅ Status Badge
            {
                
                data: 'vehicle_status',
                render: function (data) {
                    switch (data) {
                        case 'Available':
                            return '<span class="badge rounded-pill bg-label-success">Available</span>';
                        break;
                        case 'Rentout':
                            return '<span class="badge rounded-pill bg-label-warning">Rentout</span>';
                         break;
                        case 'Maintenance':
                            return '<span class="badge rounded-pill bg-label-danger">Maintenance</span>';
                         break;
                        case 'Parking':
                            return '<span class="badge rounded-pill bg-label-success">Parking</span>';
                         break;
                        case 'Blocked':
                            return '<span class="badge rounded-pill bg-label-secondary">Blocked</span>';
                         break;
                         case 'Staff Use':
                            return '<span class="badge rounded-pill bg-label-warning">Staff Use</span>';
                         break;
                        default:
                            return `<span class="badge rounded-pill bg-label-secondary">${data}</span>`;
                         break;
                    }
                }
            },

            // ✅ Passing Date
            {
                data: 'next_passing_date_format',
                render: function (data, type, row) {

                    if (!data) return '';

                    const diffDays = parseInt(row.passing_age_days);
                    let label = '', colorClass = '', maincolorClass = '';

                    if (diffDays < 0) {
                        label = `${Math.abs(diffDays)} day(s) overdue`;
                        colorClass = 'text-danger';
                        maincolorClass = 'text-danger';
                    } else if (diffDays <= 30) {
                        label = `Due in ${diffDays} day(s)`;
                        colorClass = 'text-danger';
                    } else if (diffDays <= 90) {
                        label = `Due in ${diffDays} day(s)`;
                        colorClass = 'text-warning';
                    } else {
                        label = `Due in ${diffDays} day(s)`;
                    }

                    return `
                        <span class="${maincolorClass}">
                            <div>${data}</div>
                            <small class="fst-italic ${colorClass}">${label}</small>
                        </span>
                    `;
                }
            },

            // ✅ Insurance Date
            {
                data: 'next_insurance_date_format',
                render: function (data, type, row) {

                    if (!data) return '';

                    const diffDays = parseInt(row.insurance_age_days);
                    let label = '', colorClass = '', maincolorClass = '';

                    if (diffDays < 0) {
                        label = `${Math.abs(diffDays)} day(s) overdue`;
                        colorClass = 'text-danger';
                        maincolorClass = 'text-danger';
                    } else if (diffDays <= 30) {
                        label = `Due in ${diffDays} day(s)`;
                        colorClass = 'text-danger';
                    } else if (diffDays <= 90) {
                        label = `Due in ${diffDays} day(s)`;
                        colorClass = 'text-warning';
                    } else {
                        label = `Due in ${diffDays} day(s)`;
                    }

                    return `
                        <span class="${maincolorClass}">
                            <div>${data}</div>
                            <small class="fst-italic ${colorClass}">${label}</small>
                        </span>
                    `;
                }
            },
           
            { data: 'next_maintenance_date_format' },
            { data: 'vehicle_purchase_date_format' },

            // ✅ Actions
            {
                data: 'ids',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                  return `
                    <div class="vehicle-card"><button 
                        class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 action-btn  btn_vehicle_view btn_vehicle_select"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="View Details"
                        data-id="${data}"
                        data-pricehwd="${row.price_hour_with_driver ?? 0}"
                        data-pricehwod="${row.price_hour_without_driver ?? 0}"
                        data-pricedwd="${row.price_day_with_driver ?? 0}"
                        data-pricedwod="${row.price_day_without_driver ?? 0}"
                        data-pricewwd="${row.price_week_with_driver ?? 0}"
                        data-pricewwod="${row.price_week_without_driver ?? 0}"
                        data-pricemwd="${row.price_month_with_driver ?? 0}"
                        data-pricemwod="${row.price_month_without_driver ?? 0}">
                        
                        <i class="ri ri-information-2-line icon-18px"></i>
                
                    </button></div>
                `;
                }
            }

        ]
    });

    // ✅ Search Button Click
    $('#filter_date, #vehicleModelAvail').on('change', function () {
        table.ajax.reload();
    });

    $('#companyFilter').on('change', function () {
        table.ajax.reload();
    });

    $('#btnSearch').on('click', function () {
        let btn = $(this);
        btn.prop('disabled', true).html('<i class="ri ri-loader-4-line spin"></i>');

        table.ajax.reload(function () {
            btn.prop('disabled', false).html('<i class="ri-search-line"></i> Search');
        });
    });
        
        

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
