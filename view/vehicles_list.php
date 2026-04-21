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
             
              <!-- Product List Table -->
              <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Filter</h5>
                 <div class="row align-items-end g-2">

    <!-- Date -->
    <div class="col-md-2">
        <div class="form-floating form-floating-outline">
            <input class="form-control form-control-sm"
                   id="filter_date"
                   name="filter_date"
                   type="date"
                   placeholder="dd-mm-yyyy">
            <label for="filter_date">Filter By</label>
        </div>
    </div>

    <!-- Dropdown -->
    <div class="col-md-4">
        <div class="form-floating form-floating-outline">
        <div id="dropdownContaineravail" class=" w-100">
         <label for="vehicleModelLbl">Select Vehicle Model</label>
        </div>
        </div>
    </div>

    <!-- Search Button -->
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnSearch">
    <i class="ri ri-search-line me-1"></i> Search
</button>
    </div>

</div>
                </div>
                <div class="card-datatable table-responsive">
                  <table class="datatables-products table" id="vehicleTable">
                    <thead>
                      <tr>
                          
                    <th>Sn</th>
                       <th>Model</th>
                    <th>Number</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Next Passing </th>
                    <th>Next Insurance </th>
                    <th>Next Maintenance </th>
                    <th>Purchase On</th>
                    <th>Actions</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
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
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>

    <!-- Main JS -->

    <!--<script src="<?= $_ENV['BASE_URL'] ?>assets/js/main.js"></script>-->

    <!-- Page JS -->
    <!--<script src="<?= $_ENV['BASE_URL'] ?>assets/js/app-ecommerce-product-list.js"></script>-->
    <!-- jQuery first -->
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
                    vehicle_model: $('#vehicleModelAvail').val()
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

            { data: 'model_names' },
            { data: 'vehicle_number' },

            // ✅ Details Column (Icons)
            {
                data: null,
                title: 'Details',
                render: function (data, type, row) {

                    let details = {};
                    try {
                        details = JSON.parse(row.other_details_json || '{}');
                    } catch (e) {}

                    return `
                        <div class="d-flex flex-column gap-1">

                            <div>
                                <i class="ri-calendar-line text-primary me-1"></i>
                                <small>${row.vehicle_year ?? '-'}</small>
                            </div>

                            <div>
                                <i class="ri-palette-line text-warning me-1"></i>
                                <small>${row.vehicle_color ?? '-'}</small>
                            </div>

                            <div>
                                <i class="ri-gas-station-line text-success me-1"></i>
                                <small>${details.vehicleFuelType ?? '-'}</small>
                            </div>

                            <div>
                                <i class="ri-settings-3-line text-info me-1"></i>
                                <small>${details.vehicleGearType ?? '-'}</small>
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
                        case 'Rent Out':
                            return '<span class="badge rounded-pill bg-label-primary">On Rent</span>';
                        case 'On Maintenance':
                            return '<span class="badge rounded-pill bg-label-warning">On Maintenance</span>';
                        case 'On Parking':
                            return '<span class="badge rounded-pill bg-label-warning">On Parking</span>';
                        case 'Blocked':
                            return '<span class="badge rounded-pill bg-label-danger">Blocked</span>';
                        default:
                            return `<span class="badge rounded-pill bg-label-secondary">${data}</span>`;
                    }
                }
            },

            // ✅ Passing Date
            {
                data: 'next_passing_date',
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
                data: 'next_insurance_date',
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

            { data: 'next_maintenance_date' },
            { data: 'vehicle_purchase_date' },

            // ✅ Actions
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <div class="dropdown">
                            <button class="btn p-0" data-bs-toggle="dropdown">
                                <i class="ri-more-2-line"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="reportBug(${row.ids})">View Details</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="shareTeams(${row.ids})">Change Status</a></li>
                            </ul>
                        </div>
                    `;
                }
            }

        ]
    });

    // ✅ Search Button Click
    $('#btnSearch').on('click', function () {

        let btn = $(this);
        btn.prop('disabled', true).html('<i class="ri-loader-4-line spin"></i>');

        table.ajax.reload(function () {
            btn.prop('disabled', false).html('<i class="ri-search-line"></i> Search');
        });
    });
        
        

    
});

</script>

   
  </body>
  
</html>
