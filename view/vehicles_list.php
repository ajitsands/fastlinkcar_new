<?php
include('envinclude.php');
?>
<!doctype html>

<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="../assets/"
  data-template="horizontal-menu-template-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    
    <?php include('templates/title.php'); ?>
    <meta name="description" content="" />

    <?php include('templates/head.php'); ?>

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
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
            <div class="container-fluid flex-grow-1 container-p-y">
              <!-- Product List Widget -->
              <div class="card mb-6">
                <div class="card-widget-separator-wrapper">
                  <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                         <div class="col-sm-6 col-lg-2">
                        <div
                          class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                          <div>
                            <p class="mb-1">Total Categories</p>
                            <h4 class="mb-1">10</h4>
                            <p class="mb-0">
                              
                              <span class="badge rounded-pill bg-label-info">View</span>
                            </p>
                          </div>
                          <div class="avatar me-sm-6">
                            <span class="avatar-initial rounded-3 text-heading">
                              <i class="icon-base ri ri-home-6-line icon-28px text-info"></i>
                            </span>
                          </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-6" />
                      </div>
                      <div class="col-sm-6 col-lg-2">
                        <div
                          class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                          <div>
                            <p class="mb-1">Total Vehicles</p>
                            <h4 class="mb-1">500</h4>
                            <p class="mb-0">
                              
                              <span class="badge rounded-pill bg-label-info">View</span>
                            </p>
                          </div>
                          <div class="avatar me-sm-6">
                            <span class="avatar-initial rounded-3 text-heading">
                              <i class="icon-base ri ri-car-line icon-28px text-info"></i>
                            </span>
                          </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-6" />
                      </div>
                      <div class="col-sm-6 col-lg-2">
                        <div
                          class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                          <div>
                            <p class="mb-1">Available</p>
                            <h4 class="mb-1">250</h4>
                            <p class="mb-0">
                             
                              <span class="badge rounded-pill bg-label-success">View</span>
                            </p>
                          </div>
                          <div class="avatar me-lg-6">
                            <span class="avatar-initial rounded-3 text-heading">
                              <i class="icon-base ri ri-car-washing-line icon-28px text-success"></i>
                            </span>
                          </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none" />
                      </div>
                      <div class="col-sm-6 col-lg-2">
                        <div
                          class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                          <div>
                            <p class="mb-1">On Rent</p>
                            <h4 class="mb-1">100</h4>
                            <p class="mb-0">
                             
                              <span class="badge rounded-pill bg-label-primary">View</span>
                            </p>
                          </div>
                          <div class="avatar me-sm-6">
                            <span class="avatar-initial rounded-3 text-heading">
                              <i class="icon-base ri ri-settings-2-line icon-28px text-primary"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-2">
                        <div
                          class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                          <div>
                            <p class="mb-1">In Maintenance</p>
                            <h4 class="mb-1">100</h4>
                            <p class="mb-0">
                             
                              <span class="badge rounded-pill bg-label-warning">View</span>
                            </p>
                          </div>
                          <div class="avatar me-sm-6">
                            <span class="avatar-initial rounded-3 text-heading">
                              <i class="icon-base ri ri-home-gear-line icon-28px text-warning"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-2">
                        <div
                          class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                          <div>
                            <p class="mb-1">Blocked</p>
                            <h4 class="mb-1">50</h4>
                            <p class="mb-0">
                             
                              <span class="badge rounded-pill bg-label-danger">View</span>
                            </p>
                          </div>
                          <div class="avatar me-sm-6">
                            <span class="avatar-initial rounded-3 text-heading">
                              <i class="icon-base ri ri-prohibited-line icon-28px text-danger"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      
                      
                    </div>
                  </div>
                </div>
              </div>

              <!-- Product List Table -->
              <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Filter</h5>
                  <div class="d-flex justify-content-between align-items-center row gap-5 gx-6 gap-md-0">
                    <div class="col-md-4 product_status"></div>
                    <div class="col-md-4 product_category"></div>
                    <div class="col-md-4 product_stock"></div>
                  </div>
                </div>
                <div class="card-datatable table-responsive">
                  <table class="datatables-products table" id="vehicleTable">
                    <thead>
                      <tr>
                          
                    <th>Image</th>
                       <th>Vehicle</th>
                    <th>Number</th>
                    <th>Model</th>
                    <th>Category</th>
                    <th>Fuel</th>
                    <th>Cost/Day</th>
                    <th>Status</th>
                    <th>Next Passing </th>
                    <th>Next Insurance </th>
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
                    src="../../assets/img/illustrations/girl-with-laptop-light.png"
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
                    src="../../assets/img/illustrations/boy-with-laptop-light.png"
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
                    src="../../assets/img/illustrations/girl-verify-password-light.png"
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
                <?php include('templates/footer.php'); ?>
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
    <?php include('templates/scripts.php'); ?>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>

    <!-- Main JS -->

    <!--<script src="../assets/js/main.js"></script>-->

    <!-- Page JS -->
    <!--<script src="../assets/js/app-ecommerce-product-list.js"></script>-->
    <!-- jQuery first -->
<script>
function openVehicleModal(images) {
            const carouselInner = document.querySelector('#modalCarouselControls .carousel-inner');
            const carouselIndicators = document.querySelector('#modalCarouselControls .carousel-indicators');
        
            carouselInner.innerHTML = ''; // Clear previous slides
            carouselIndicators.innerHTML = ''; // Clear previous indicators
        
            images.forEach((img, index) => {
                // Slide
                const activeClass = index === 0 ? 'active' : '';
                const slide = `
                    <div class="carousel-item ${activeClass}">
                        <div class="onboarding-media">
                            <div class="mx-2">
                                <img src="uploads/vehicleImages/${img}" class="img-fluid" style="max-height:500px; object-fit:contain;" />
                            </div>
                        </div>
                        <div class="onboarding-content">
                            
                        </div>
                    </div>
                `;
                carouselInner.insertAdjacentHTML('beforeend', slide);
        
                // Indicator
                const indicatorActive = index === 0 ? 'active' : '';
                const indicator = `
                    <button type="button" data-bs-target="#modalCarouselControls" data-bs-slide-to="${index}" class="${indicatorActive}"></button>
                `;
                carouselIndicators.insertAdjacentHTML('beforeend', indicator);
            });
        
            // Reset carousel to first slide
            const carousel = new bootstrap.Carousel(document.getElementById('modalCarouselControls'));
            carousel.to(0);
        
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('modalvehicleimages'));
            modal.show();
        }
    $(document).ready(function () {
       
        $('#vehicleTable').DataTable({
            pageLength: 100,
            ajax: {
                url: '/LoadVehicleByUserSellection',
                type: 'POST',
                data: function(d) {
                    return JSON.stringify({
                        action: 'LoadVehicleToMasterList'
                    });
                },
                dataSrc: 'data',
                error: function (xhr, error, code) {
                    console.log(xhr.responseText);
                }
            },
             columns: [
                {
                    data: 'all_vehicle_images',
                    title: 'Images',
                    render: function(data, type, row) {
                        if (!data) return '';
                
                        // Parse the JSON array of images
                        let images = [];
                        try {
                            images = JSON.parse(data); // data is like '["img1.jpg","img2.jpg"]'
                        } catch(e) {
                            console.error('Invalid JSON', e, data);
                            return '';
                        }
                
                        if (images.length === 0) return '';
                
                        // Show first image as clickable thumbnail
                        return `<div class="avatar me-2"><img src="uploads/vehicleImages/${images[0]}" class="rounded-circle" style="cursor:pointer;" onclick='openVehicleModal(${JSON.stringify(images)})'></div>`;
                    }
                },
               
                { data: 'vehicles_name', title: 'Vehicle' },
                { data: 'vehicles_number', title: 'Number' },
                { data: 'vehicles_modal', title: 'Model' },
                { data: 'category', title: 'Category' },
                { data: 'fuel_type', title: 'Fuel' },
                { data: 'cost_per_day', title: 'Cost/Day' },
                { data: 'vehicles_status', title: 'Status',
                
                    render: function(data, type, row) {

                        switch (data) {
                            case 'Available':
                                return '<span class="badge rounded-pill bg-label-success">Available</span>';
                
                            case 'On Rent':
                                return '<span class="badge rounded-pill bg-label-primary">On Rent</span>';
                
                            case 'On Maintenance':
                                return '<span class="badge rounded-pill bg-label-warning">On Maintenance</span>';
                
                            case 'Blocked':
                                return '<span class="badge rounded-pill bg-label-danger">Blocked</span>';
                
                            default:
                                return '<span class="badge rounded-pill bg-label-secondary">' + data + '</span>';
                        }
                    }
                },
                { data: 'passing_date', title: 'Passing Date' ,
                    render: function(data, type, row) {

                        if (!data) return '';
                
                        const diffDays = parseInt(row.passing_age_days);
                
                         // Determine label and color
                        let label = '';
                        let colorClass = ''; 
                        let maincolorClass = ''; 
                
                         if (diffDays < 0) {
                            // overdue → entire text red
                            label = `${Math.abs(diffDays)} day${Math.abs(diffDays) !== 1 ? 's' : ''} overdue`;
                            colorClass = 'text-danger';
                            maincolorClass = 'text-danger';
                        } else if (diffDays <= 30) {
                            // due soon → danger
                            label = `Due in ${diffDays} day${diffDays !== 1 ? 's' : ''}`;
                            colorClass = 'text-danger';
                            maincolorClass = '';
                        } else if (diffDays <= 90) {
                            // warning
                            label = `Due in ${diffDays} day${diffDays !== 1 ? 's' : ''}`;
                            colorClass = 'text-warning';
                             maincolorClass = '';
                        } else {
                            // safe
                            label = `Due in ${diffDays} day${diffDays !== 1 ? 's' : ''}`;
                            colorClass = '';
                             maincolorClass = '';
                        }
                         return `
                            <span class="${maincolorClass}">
                                <div style="line-height:1; margin-bottom:0;">${data}</div>
                                <small style="font-size:0.7em; line-height:1;" class="fst-italic ${colorClass}">${label}</small>
                            </span>
                        `;
                        
                    }
                },
                { data: 'insurance_date', title: 'Insurance Date',
                
                    render: function(data, type, row) {

                        if (!data) return '';
                
                        const insdiffDays = parseInt(row.insurance_age_days);
                
                         // Determine label and color
                        let label1 = '';
                        let colorClass1 = ''; 
                        let maincolorClass1 = ''; 
                 if (insdiffDays < 0) {
                            // overdue → entire text red
                            label1 = `${Math.abs(insdiffDays)} day${Math.abs(insdiffDays) !== 1 ? 's' : ''} overdue`;
                            colorClass1 = 'text-danger';
                            maincolorClass1 = 'text-danger';
                        } else if (insdiffDays <= 30) {
                            // due soon → danger
                            label1 = `Due in ${insdiffDays} day${insdiffDays !== 1 ? 's' : ''}`;
                            colorClass1 = 'text-danger';
                            maincolorClass1 = '';
                        } else if (insdiffDays <= 90) {
                            // warning
                            label1 = `Due in ${insdiffDays} day${insdiffDays !== 1 ? 's' : ''}`;
                            colorClass1 = 'text-warning';
                             maincolorClass1 = '';
                        } else {
                            // safe
                            label1 = `Due in ${insdiffDays} day${insdiffDays !== 1 ? 's' : ''}`;
                            colorClass1 = '';
                             maincolorClass1 = '';
                        }
                         return `
                            <span class="${maincolorClass1}">
                                <div style="line-height:1; margin-bottom:0;">${data}</div>
                                <small style="font-size:0.7em; line-height:1;" class="fst-italic ${colorClass1}">${label1}</small>
                            </span>
                        `;
                        
                        
                    }
                    
                },
                { data: 'purchase_date', title: 'Purchase Date' },
                {
                data: null, // since this is action, not bound to a field
                title: 'Actions',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-base ri ri-more-2-line icon-22px text-body-secondary"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="shareTeams(${row.ids})">Change Status</a></li>
                            <li><a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="suggestEdits(${row.ids})">Suggest Edits</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item waves-effect" href="javascript:void(0);" onclick="reportBug(${row.ids})">View Details</a></li>
                        </ul>
                    </div>`;
                }
            }
               
                
            ]
        });
        
        

    });

</script>

   
  </body>
  
</html>
