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
    <style>
    html, body {
    overflow-x: hidden;
        }
        
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        .list-group-item.active-click {
          background-color: #f12526; /* Bootstrap primary */
          color: white;
        }
        .table-active {
            background-color: #f12526 !important; /* Red background */
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
    border: 2px solid #f12526;       /* red border for selection */
    background-color: #fff0f0;       /* light highlight */
    box-shadow: 0 0 10px rgba(241, 37, 38, 0.4); /* optional glow */
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
    background-color: #f12526;
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

@media print {
    body {
        background: #fff;
    }
    /* Hide layout elements */
    .layout-menu,
    .layout-navbar,
    .content-footer,
    .nav-tabs,
    #dropdownContent,
    .btn, 
    #btnPrint,
    #filterCompany,
    label[for="filterCompany"],
    #selectedVehiclesFooter {
        display: none !important;
    }
    
    /* Remove padding/margins */
    .layout-page, .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    /* Format header */
    h4.fw-bold {
        text-align: center;
        margin-bottom: 20px !important;
        font-size: 24px !important;
    }
    
    /* Only show active tab pane */
    .tab-content > .tab-pane {
        display: none !important;
    }
    .tab-content > .active {
        display: block !important;
        visibility: visible !important;
    }
    
    /* Search tab specific: hide categories/models */
    #divsearch .col-xl-3 {
        display: none !important;
    }
    
    /* Expand vehicle container */
    #divsearch .col-xl-6, 
    .col-xl-12 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }
    
    /* Card formatting */
    .vehicle-card {
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
        margin-bottom: 15px !important;
        box-shadow: none !important;
    }
    
    /* Force background colors to print for badges */
    .badge {
        border: 1px solid #000;
        color: #000 !important;
    }
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
                    
                        <!-- Layout Demo -->
                        
                        <?php include ROOT_PATH . '/view/templates/VehicleInsight/VehicleInsightBody.php'; ?>
                         <?php include('templates/VehicleReservation/vehicle_images_slider.php'); ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleInsight/vehicleFloatingFooter.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleInsight/vehicle_change_status_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleInsight/maintenance_request_view_modal.php'; ?>
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
     <?php include('templates/vehicles/vehicle_profile_modal.php'); ?>
   

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-selects.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
    <script>
    let highResLogoBase64 = null;
    let highResLogoRatio = 1;

$(document).ready(function() {
    // Preload high-res logo for PDF
    let img = new Image();
    img.onload = function() {
        let canvas = document.createElement('canvas');
        canvas.width = img.width;
        canvas.height = img.height;
        let ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);
        highResLogoBase64 = canvas.toDataURL('image/png');
        highResLogoRatio = img.width / img.height;
    };
    img.src = '/assets/img/logo/logo.png';

   $('#hid_model_id').val(0);
   let selectedVehicles = [];
    $('[data-bs-toggle="tooltip"]').tooltip();
   $('#statusTabs .nav-link').on('click', function(e){
    e.preventDefault(); // prevent default anchor jump

    // Add active class
    $('#statusTabs .nav-link').removeClass('active');
    $(this).addClass('active');

    const targetId = $(this).attr('href'); 
    const $target = $(targetId);

    if($target.length){
        $('html, body').animate({
            scrollTop: $target.offset().top - 100 // adjust for fixed header
        }, 500);
    }
});
  function loadCategories() {
    $('#treeContainer').html('<div class="p-3 text-center">Loading...</div>');

    $.ajax({
      url: '/LoadCategoryController',
      method: 'POST',
      success: function(response) {
        $('#treeContainer').html(response);
      },
      error: function() {
        $('#treeContainer').html('<div class="text-danger">Failed to load</div>');
      }
    });
  }
  
  loadCategories();
  

  $('#treeContainer').on('click', '[data-brand]', function(e) {
    e.stopPropagation();

    
    $('#treeContainer .list-group-item').removeClass('active-click');
    $(this).addClass('active-click');

    let brandId = $(this).data('brand');
    let categoryId = $(this).closest('li[data-category]').data('category');

   $('#hid_model_id').val(0);
    loadModelsTable(categoryId,brandId);

  var tableOffset = $('#modelsTable').closest('.card').offset().top;

if ($(window).width() < 992) {
    // Mobile/tablet → scroll so table is at top of viewport
    $('html, body').animate({
        scrollTop: tableOffset - 70
    }, 400);
} else {
    // Desktop → scroll a bit above table, so header is visible
    $('html, body').animate({
        scrollTop: tableOffset - 150
    }, 400);
}
  });

function loadModelsTable(categoryId, brandId) {
  // Destroy existing table
  if ($.fn.DataTable.isDataTable('#modelsTable')) {
    $('#modelsTable').DataTable().destroy();
    $('#modelsTable tbody').empty();
  }

  // Initialize DataTable
  let modeltable = $('#modelsTable').DataTable({
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    paging: false,
    lengthChange: false,
    info: false,
    ordering: false,
    searching: true, 
     dom: '<"row"<"col-12">><"row"<"col-12"tr>>', // remove default filter input
    ajax: {
      url: '/VehicleStatusController',
      type: 'POST',
      data: {
        categoryId: categoryId,
        brandId: brandId,
        action: 'get_model_details'
      }
    },
    columns: [
      {
        data: null,
        render: function(data, type, row) {
          let img = row.vehicle_modal_pic 
            ? 'httpdocs/images/vehicle_model_images/' + row.vehicle_modal_pic 
            : 'httpdocs/images/vehicle_model_images/default.jpg';

          return `
            <div class="d-flex align-items-center" data-id="${row.model_ids}">
              <div class="avatar avatar-md me-2">
                <img src="${img}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
              </div>
              <div>
                <div class="fw-bold">${row.model_name}</div>
                <small class="text-muted">${row.category_name} - ${row.brand_name}</small>
              </div>
            </div>
          `;
        }
      }
    ]
  });

  // Bind your **custom full-width search**
  $('#modelsSearch').off('keyup').on('keyup', function() {
    modeltable.search(this.value).draw();
  });
}



$('#modelsTable tbody').on('click', 'tr', function () {
  
    $('#modelsTable tbody tr').removeClass('table-active');

   
    $(this).addClass('table-active');

   let data = $('#modelsTable').DataTable().row(this).data();
    
   $('#hid_model_id').val(data.model_ids);
   
    loadVehiclesTable(data.model_ids,'0');
});

  function loadVehiclesTable(modelId, vehicleNumber) {
    $('#vehicleContainer').html('<div class="p-3 text-center">Loading...</div>');

    $.ajax({
      url: '/VehicleInsightController',
      method: 'POST',
      data: {
        modelId: modelId,
        vehicleNumber:vehicleNumber,
        action: 'get_vehicle_details_insight_search',
        filter_company_id: $('#filterCompany').val()
      },
      dataType: 'json',
      success: function(response) {

        $('#vehicleContainer').html(response.html);
         $('[data-bs-toggle="tooltip"]').tooltip();
         $('#SearchvehicleAvailabilityBar').show();
          
          $('#SearchvehicleAvailabilityContent').html('');
   
        let content = '';
        let total = 0;

        // ✅ Use response.summary instead of response.rows
        if (response.summary) {
    
            let parsedSummary = JSON.parse(response.summary);
     
            $.each(parsedSummary, function(model, count) {
    
                total += count;
    
                let badgeClass = count > 0 ? 'bg-primary' : 'bg-danger';
    
                content += `
                    <span class="badge ${badgeClass} me-2">
                        ${model}: ${count}
                    </span>
                `;
            });

        content = `<strong class="me-3">Total: ${total}</strong>` + content ;
                     $('#SearchvehicleAvailabilityBar').show();
                    $('#SearchvehicleAvailabilityContent').html(content);
                   
                    
                }
            else {
                 $('#SearchvehicleAvailabilityBar').hide();
                $('#SearchvehicleAvailabilityContent').html('');
            }
            $('#vehicleContainer .vehicle-card').each(function() {
                var $btn = $(this).find('.btn_vehicle_select');
                var vehicleId = $btn.data('id');

               
                if (selectedVehicles.some(item => item.id === vehicleId)) {
                    $(this).addClass('selected'); // highlight card
                    $btn.removeClass('btn-primary').addClass('btn-outline-danger');
                    $btn.attr('title', 'Deselect');
                    $btn.html('<i class="ri ri-close-line icon-18px"></i>');
                } else {
                    $(this).removeClass('selected'); // normal
                    $btn.removeClass('btn-outline-danger').addClass('btn-primary');
                    $btn.attr('title', 'Select');
                    $btn.html('<i class="ri ri-check-line icon-18px"></i>');
                }
            });
      },
      error: function() {
         
        $('#vehicleContainer').html('<div class="text-danger">Failed to load</div>');
      }
    });
  }

$('#vehicleSearch').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();

        $('#vehicleContainer .vehicle-card').each(function() {
           
            var vehicleNumber = $(this).find('.veh_no').text().toLowerCase();

            if (vehicleNumber.indexOf(searchValue) > -1) {
                $(this).closest('.col-12').show(); 
            } else {
                $(this).closest('.col-12').hide(); 
            }
        });
    });

      


  $('#vehicleSearchBtn').on('click', function() {
        let vehicleNos = $('#vehicleSearch').val().trim();

        if(vehicleNos === '') {
             setupDropdown('dropdownContent', 'error', svgError + "Please enter a vehicle number", 'click');
                return false;
           
        }
        loadVehiclesTable('0', vehicleNos)
       
       
    });

 function updateSelectedFooter() {
    const footer = $('#selectedVehiclesFooter');
    const list = $('#selectedVehiclesList');
    list.empty();
    $('#selectedCount').text(selectedVehicles.length);
    if (selectedVehicles.length === 0) {
        footer.addClass('d-none'); // hide footer if none selected
        return;
    }

    footer.removeClass('d-none');

    selectedVehicles.forEach(vehicle => {
        const item = $(`
            <div class="badge bg-primary text-white d-flex align-items-center gap-1">
                ${vehicle.modelName} - ${vehicle.vehicleNumber}
                <i class="ri ri-close-line ms-1 cursor-pointer" style="font-size:14px;"></i>
            </div>
        `);

       
        item.find('i').on('click', function() {
            selectedVehicles = selectedVehicles.filter(v => v.id !== vehicle.id);
            updateSelectedFooter();

            // Also toggle select button on the card
            $(`.btn_vehicle_select[data-id="${vehicle.id}"]`)
                .removeClass('btn-outline-danger')
                .addClass('btn-primary')
                .attr('title', 'Select')
                .find('i')
                .removeClass('ri-close-line')
                .addClass('ri-check-line')
                .closest('.vehicle-card').removeClass('selected');
        });

        list.append(item);
    });
}

// Clear all
$('#clearSelectedVehicles').on('click', function() {
    selectedVehicles = [];
    updateSelectedFooter();

    // Reset all select buttons
    $('.btn_vehicle_select')
        .removeClass('btn-outline-danger')
        .addClass('btn-primary')
        .attr('title', 'Select')
        .find('i')
        .removeClass('ri-close-line')
        .addClass('ri-check-line')
        .closest('.vehicle-card').removeClass('selected');
});

$(document).on('click', '.btn_vehicle_select', function() {
    const $btn = $(this);
    var $card = $btn.closest('.vehicle-card');
    const vehicle = {
        id: $btn.data('id'),
        modelId: $btn.data('model'),
        modelName: $btn.data('modelname'),
        vehicleNumber: $btn.closest('.vehicle-card').find('.veh_no').text()
    };

    const index = selectedVehicles.findIndex(v => v.id === vehicle.id);

    if(index === -1){
        // Add to selection
         selectedVehicles.push(vehicle);
       
           $card.addClass('selected');
            $btn.removeClass('btn-primary').addClass('btn-outline-danger');
            $btn.attr('title', 'Deselect');
            $btn.html('<i class="ri ri-close-line icon-18px"></i>');
            
            
        
    } else {
        // Remove from selection
        selectedVehicles.splice(index,1);
            $card.removeClass('selected');
            $btn.removeClass('btn-outline-danger').addClass('btn-primary');
            $btn.attr('title', 'Select');
            $btn.html('<i class="ri ri-check-line icon-18px"></i>');
            
        
    }

    updateSelectedFooter();
});  

   // Search filter with highlight
  let debounceTimer;
  $('#searchTree').on('keyup', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      let value = $(this).val().toLowerCase();
      let container = $('#treeContainer');
      let firstVisible = null;

      container.find('li[data-category]').each(function() {
        let categoryNameEl = $(this).find('.fw-bold').first();
        let categoryText = categoryNameEl.text().toLowerCase();
        let categoryMatch = categoryText.includes(value);

        let hasVisibleBrand = false;

        // Loop brands
        $(this).find('[data-brand]').each(function() {
          let brandText = $(this).text().toLowerCase();
          if (brandText.includes(value)) {
            $(this).show();
            highlightText(this, value);
            hasVisibleBrand = true;
            if (!firstVisible) firstVisible = $(this);
          } else {
            $(this).hide();
            removeHighlight(this);
          }
        });

        // Show category if matched or has visible brand
        if (categoryMatch || hasVisibleBrand) {
          $(this).show();
          highlightText(categoryNameEl, value);
          if (!firstVisible) firstVisible = categoryNameEl.closest('li');
        } else {
          $(this).hide();
          removeHighlight(categoryNameEl);
        }
      });

      // Scroll to first match
      if (firstVisible) scrollToBrand(firstVisible);

    }, 300);
  });

  // Scroll helper function
  function scrollToBrand($element) {
    var container = $('#treeContainer');

    if ($(window).width() < 992) {
      $('html, body').animate({
        scrollTop: $('#modelsTable').closest('.card').offset().top - 70
      }, 400);
    } else {
      var scrollTo = $element.position().top + container.scrollTop() - 20;
      container.animate({ scrollTop: scrollTo }, 400);
    }
  }

  // Highlight matched text
  function highlightText(element, search) {
    let text = $(element).text();
    if (!search) { removeHighlight(element); return; }
    let regex = new RegExp(`(${search})`, 'gi');
    let newText = text.replace(regex, '<span class="highlight">$1</span>');
    $(element).html(newText);
  }

  // Remove highlight
  function removeHighlight(element) {
    $(element).html($(element).text());
  }
 
 $('#hid_vehicle_id_info_modal').val('');
 
 //Vehicle Info Modal
 function getFilePreview(ext, url) {
    const map = {
        pdf: '/assets/icons/pdf.png',
        doc: '/assets/icons/word.png',
        docx: '/assets/icons/word.png',
        xls: '/assets/icons/excel.png',
        xlsx: '/assets/icons/excel.png',
        zip: '/assets/icons/zip.png',
        rar: '/assets/icons/zip.png',
        txt: '/assets/icons/txt.png'
    };

    const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (imageExts.includes(ext)) {
        return url || '';
    }

    return map[ext] || '/assets/icons/file.png';
}

// SandsAlert Common Function
  document.querySelectorAll('.popup-buttons button').forEach(function(button) {
            button.addEventListener('click', function() {
              
              var popupOverlay = document.getElementById('popupOverlay');
              var popupContainer = document.getElementById('popupContainer');
              popupOverlay.style.display = 'none';
              popupContainer.style.display = 'none';
              // Check which button was clicked
              if (button.classList.contains('ok')) {
                // OK button clicked, perform action
                 var messageMatter = $('#message_matter');
            var switchData = messageMatter.attr('data-switch-values');
           // var param = messageMatter.attr('data-param'); 
                switch (switchData) {
                    case 'deletePasingTimeline':
                       deletePasingTimeline();
                        
                    break;
                    case 'deleteInsuranceTimeline':
                       deleteInsuranceTimeline();
                        
                    break;
                    case 'deleteMaintenanceTimeline':
                       deleteMaintenanceTimeline();
                        
                    break;
				
                    default:
                        setupDropdown('dropdownContent','error',svgSuccess+'No action defined for this message.','click');
                }
              } else if (button.classList.contains('cancel')) {
                // Cancel button clicked, do nothing
               
                setupDropdown('dropdownContent','error',svgSuccess+'Action canceled!','click');
              }
            });
        });




$(document).on('click', '#proceedSelectedVehicles', function () {
    
    
    if (selectedVehicles.length === 0) {
         setupDropdown('dropdownContent', 'error', svgError + "Please select at least one vehicle", 'click');
                return false;
       
    }

    else
    {
        renderSelectedVehiclesInModal(selectedVehicles);
                 $('#vehicleChangeStatusModal').modal('show');
       
    }
    
    
   
    
});
function renderSelectedVehiclesInModal(vehicles) {

    let container = $('#modalselectedVehiclesList');
    container.empty();

    if (vehicles.length === 0) {
        container.html('<div class="text-muted small">No vehicles selected</div>');
        $('#modalvehicleBookingCount').text(0);
        return;
    }

    vehicles.forEach(vehicle => {

        let html = `
            <div class="badge bg-primary text-white d-flex align-items-center gap-1"
                 data-id="${vehicle.id}">

                ${vehicle.modelName} - ${vehicle.vehicleNumber}

                <i class="ri ri-close-line ms-1 cursor-pointer remove-vehicle"
                   style="font-size:14px;"></i>
            </div>
        `;

        container.append(html);
    });

    $('#modalvehicleBookingCount').text(vehicles.length);
}
function syncVehicleSelectionUI(id) {

    let $btn = $(`.btn_vehicle_select[data-id="${id}"]`);
    let $card = $btn.closest('.vehicle-card');

    $btn.removeClass('btn-outline-danger')
        .addClass('btn-primary')
        .attr('title', 'Select')
        .find('i')
        .removeClass('ri-close-line')
        .addClass('ri-check-line');

    $card.removeClass('selected');

    updateSelectedFooter();
}
$(document).on('click', '.remove-vehicle', function () {

    let $badge = $(this).closest('.badge');
    let id = $badge.data('id');

    // Remove from array
    selectedVehicles = selectedVehicles.filter(v => v.id != id);

    // Remove from UI (modal)
    $badge.remove();

    // Update count
    $('#modalvehicleBookingCount').text(selectedVehicles.length);

  
    syncVehicleSelectionUI(id);
});
$(document).on('click', '#confirmStatusBtn', function () {
    
    let serviceType = $('#select_service_type').val();
    let notes = $('#txt_notes').val();
  
    if (serviceType=='0' || !serviceType ) {
        $('#dropdownContent').css('z-index', '99999');

         setupDropdown('dropdownContent', 'error', svgError + "Please select a status to update the selected vehicle.", 'click');
                return false;
       
    }
   else if (selectedVehicles.length === 0) {
       $('#dropdownContent').css('z-index', '99999');

         setupDropdown('dropdownContent', 'error', svgError + "Please select at least one vehicle", 'click');
                return false;
    }

    else
    {
    console.log(selectedVehicles);
    let vehicleIds = selectedVehicles.map(v => v.id);
       $.ajax({
            url: '/VehicleInsightController',
            type: 'POST',
            data: {
                action:'update_vehicle_status',
                selectedVehicles: vehicleIds,
                status: serviceType,
                notes: notes
            },
             dataType: 'json',
            success: function (response) {
                
                   if (response.status)
                    {
                     
                        setupDropdown(
                            'dropdownContent',
                            'success',
                            svgSuccess + response.message,
                            'click'
                        );
                    
                     $('#txt_notes').val('');  
                     $('#vehicleChangeStatusModal').modal('hide');
                     location.reload();
                        return;
                    }
                    else
                    {
                        setupDropdown(
                            'dropdownContent',
                            'error',
                            svgError + response.message,
                            'click'
                        );

                        return;
                    }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
       
    }
    
    
   
    
});

$(document).on('click', '.vehicle-image', function () {
    let images = $(this).data('images');
    openVehicleModal(images);
});

function openVehicleModal(images) {

    // safe parse
    if (typeof images === "string") {
        try {
            images = JSON.parse(images);
        } catch (e) {
            images = [];
        }
    }

    // force array
    if (!Array.isArray(images)) {
        images = [];
    }

    // remove invalid values
    images = images.filter(img => img && img !== "default.jpg");

    if (images.length === 0) {
        images = ["default.jpg"];
    }

    images = [...images].reverse();

    let inner = document.getElementById("vehicleCarouselInner");
    let indicators = document.getElementById("vehicleCarouselIndicators");

    inner.innerHTML = "";
    indicators.innerHTML = "";

    images.forEach((img, index) => {

        let activeClass = index === 0 ? "active" : "";

        inner.innerHTML += `
            <div class="carousel-item ${activeClass}">
                <img src="uploads/vehicleImages/${img}" 
                     class="d-block w-100"
                     style="max-height:500px;object-fit:contain;">
            </div>
        `;

        indicators.innerHTML += `
            <button type="button"
                data-bs-target="#modalCarouselControls"
                data-bs-slide-to="${index}"
                class="${activeClass}">
            </button>
        `;
    });

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalvehicleimages')
    ).show();
}

// All Vehicle List
$(document).on('click', '.li_Vehicle_list', function () {
     let status = $(this).data('status');
      let divcontainer,divcontent,vehicle_card;
     switch(status)
     {
         case 'All':
              divcontainer = $('#AllvehicleContainer');
              divcontent = $('#AllvehicleAvailabilityContent');
              vehicle_card=$('#AllvehicleContainer .vehicle-card');
         break;
         case 'Available':
             divcontainer = $('#AvailvehicleContainer');
              divcontent = $('#AvailvehicleAvailabilityContent');
              vehicle_card=$('#AvailvehicleContainer .vehicle-card');
         break;
         case 'Staffuse':
             divcontainer = $('#StaffusevehicleContainer');
              divcontent = $('#StaffusevehicleAvailabilityContent');
              vehicle_card=$('#StaffusevehicleContainer .vehicle-card');
         break;
         case 'Rentout':
             divcontainer = $('#RentvehicleContainer');
              divcontent = $('#RentvehicleAvailabilityContent');
              vehicle_card=$('#RentvehicleContainer .vehicle-card');
         break;
         case 'Parking':
             divcontainer = $('#ParkvehicleContainer');
              divcontent = $('#ParkvehicleAvailabilityContent');
              vehicle_card=$('#ParkvehicleContainer .vehicle-card');
         break;
        
         case 'Maintenance':
             divcontainer = $('#MainvehicleContainer');
              divcontent = $('#MainvehicleAvailabilityContent');
              vehicle_card=$('#MainvehicleContainer .vehicle-card');
         break;
         case 'Blocked':
            divcontainer = $('#BlockedvehicleContainer');
              divcontent = $('#BlockedvehicleAvailabilityContent');
              vehicle_card=$('#BlockedvehicleContainer .vehicle-card');
         break;
     }
  
  
    loadAllVehiclesTable(status,divcontainer,divcontent,vehicle_card);
});

  function loadAllVehiclesTable(status,divcontainer,divcontent,vehicle_card) {
    $('#AllvehicleContainer').html('<div class="p-3 text-center">Loading...</div>');

    $.ajax({
      url: '/VehicleInsightController',
      method: 'POST',
      data: {
        action: 'get_vehicle_details_insight',
        status: status,
        filter_company_id: $('#filterCompany').val()
      },
     dataType: 'json',
      success: function(response) {

          divcontainer.html(response.html);
          divcontent.html('');
   
        let content = '';
        let total = 0;

        // ✅ Use response.summary instead of response.rows
        if (response.summary) {
    
            let parsedSummary = JSON.parse(response.summary);
     
            $.each(parsedSummary, function(model, count) {
    
                total += count;
    
                let badgeClass = count > 0 ? 'bg-primary' : 'bg-danger';
    
                content += `
                    <span class="badge ${badgeClass} me-2">
                        ${model}: ${count}
                    </span>
                `;
            });

        content = `<strong class="me-3">Total: ${total}</strong>` + content ;

                    divcontent.html(content);
                   
                    
                }
            else {
               divcontent.html('');
                   
            }
        
  
            vehicle_card.each(function() {
                var $btn = $(this).find('.btn_vehicle_select');
                var vehicleId = $btn.data('id');

               
                if (selectedVehicles.some(item => item.id === vehicleId)) {
                    $(this).addClass('selected'); // highlight card
                    $btn.removeClass('btn-primary').addClass('btn-outline-danger');
                    $btn.attr('title', 'Deselect').attr('data-bs-original-title', 'Deselect');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-close-line icon-18px"></i>');
                } else {
                    $(this).removeClass('selected'); // normal
                    $btn.removeClass('btn-outline-danger').addClass('btn-primary');
                    $btn.attr('title', 'Select').attr('data-bs-original-title', 'Select');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-check-line icon-18px"></i>');
                }
            });
      },
      error: function() {
         
        divcontainer.html('<div class="text-danger">Failed to load</div>');
      }
    });
  }

  $('.vehicle_search_txt').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();
        let status = $(this).data('status');
        let vehicle_card;
         switch(status)
     {
         case 'All':
           
              vehicle_card=$('#AllvehicleContainer .vehicle-card');
         break;
         case 'Available':
             
              vehicle_card=$('#AvailvehicleContainer .vehicle-card');
         break;
          case 'Staffuse':
             
              vehicle_card=$('#StaffusevehicleContainer .vehicle-card');
         break;
         case 'Rentout':
           
              vehicle_card=$('#RentvehicleContainer .vehicle-card');
         break;
         case 'Parking':
          
              vehicle_card=$('#ParkvehicleContainer .vehicle-card');
         break;
        
         case 'Maintenance':
           
              vehicle_card=$('#MainvehicleContainer .vehicle-card');
         break;
         case 'Blocked':
            
              vehicle_card=$('#BlockedvehicleContainer .vehicle-card');
         break;
     }
       vehicle_card.each(function() {
           
            var vehicleNumber = $(this).find('.veh_no').text().toLowerCase();

            if (vehicleNumber.indexOf(searchValue) > -1) {
                $(this).closest('.col-12').show(); 
            } else {
                $(this).closest('.col-12').hide(); 
            }
        });
    });  
    
  
});

// OVERRIDE btn_vehicle_view to open profile modal instead of old details modal
$(document).ready(function() {
    $(document).off('click', '.btn_vehicle_view').on('click', '.btn_vehicle_view', function(e) {
        e.preventDefault();
        let vehicleId = $(this).data('id');
        openVehicleProfile(vehicleId);
    });
});

function openVehicleProfile(vehicleId) {
    $.ajax({
        url: "/AddVehicles",
        type: "POST",
        dataType: "json",
        data: JSON.stringify({ action: "get_vehicle_profile", vehicle_id: vehicleId }),
        contentType: "application/json",
        success: function(response) {
            if (response.status && response.data) {
                let v = response.data;
                
                // Populate base data
                $("#vpVehicleNumber").text(v.vehicle_number || "N/A");
                $("#vpVehicleNumBody").text(v.vehicle_number || "N/A");
                $("#vpCategory").text(v.category_name || "N/A");
                $("#vpBrand").text(v.brand_name || "N/A");
                $("#vpModel").text(v.model_names || "N/A");
                $("#vpChassis").text(v.chassis_number || "N/A");
                $("#vpYear").text(v.vehicle_year || "N/A");
                $("#vpColor").text(v.vehicle_color || "N/A");
                $("#vpPurchaseDate").text(v.formatted_purchase_date || "Not Set");
                $("#vpNextInsurance").text(v.formatted_insurance_date || "Not Set");
                $("#vpNextPassing").text(v.formatted_passing_date || "Not Set");
                
                // Current User
                $("#vpRentoutDiv").hide();
                $("#vpStaffDiv").hide();
                if (v.vehicle_status === 'Rentout' && v.current_user_name) {
                    $("#vpRentoutDiv").show();
                    $("#vpCurrentUserName").text(v.current_user_name);
                    $("#vpCurrentUserContact").text(v.current_user_contact || "No Contact");
                    $("#vpContractRef").text(v.contract_ref || "N/A");
                    let expRet = v.expected_return_date ? (new Date(v.expected_return_date).toLocaleString('en-GB', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}).replace(',', '')) : "N/A";
                    if (typeof dayjs !== 'undefined') {
                        expRet = v.expected_return_date ? dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : "N/A";
                    }
                    $("#vpReturnDate").text(expRet);
                } else if (v.vehicle_status === 'Staff Use' && v.current_user_name) {
                    $("#vpStaffDiv").show();
                    $("#vpStaffName").text(v.current_user_name);
                    $("#vpStaffContact").text(v.current_user_contact || "No Contact");
                    $("#vpStaffRef").text(v.contract_ref || "N/A");
                    let expRet = v.expected_return_date ? (new Date(v.expected_return_date).toLocaleString('en-GB', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}).replace(',', '')) : "N/A";
                    if (typeof dayjs !== 'undefined') {
                        expRet = v.expected_return_date ? dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : "N/A";
                    }
                    $("#vpStaffReturnDate").text(expRet);
                }
                
                // Status Remarks
                $("#vpRemarksDiv").hide();
                if (v.vehicle_status_notes && v.vehicle_status_notes.trim() !== "") {
                    // Only show if it's a manual status change like Parking, Blocked, etc.
                    if (v.vehicle_status === 'Parking' || v.vehicle_status === 'Blocked' || v.vehicle_status === 'Maintenance') {
                        $("#vpRemarksDiv").show();
                        $("#vpStatusRemarks").text(v.vehicle_status_notes);
                    }
                }
                
                // Status badge
                let statusClass = "bg-label-primary";
                if(v.vehicle_status === "Available") statusClass = "bg-label-success";
                else if(v.vehicle_status === "Rentout") statusClass = "bg-label-danger";
                else if(v.vehicle_status === "Maintenance") statusClass = "bg-label-warning";
                $("#vpStatusBadge").attr("class", "badge " + statusClass).text(v.vehicle_status || "Unknown");
                
                // Ownership
                $("#vpRegCompany").text(v.ownership_company || "N/A");
                if (v.is_outsourced === "Yes") {
                    $("#vpOutsourceDiv").show();
                    $("#vpOutsourceCompany").text(v.outsourcing_company_name || "N/A");
                } else {
                    $("#vpOutsourceDiv").hide();
                }
                
                // Other details (JSON)
                let od = v.other_details || {};
                $("#vpFuelType").text(od.vehicleFuelType || "N/A");
                $("#vpGearType").text(od.vehicleGearType || "N/A");
                
                // Dynamic Pricing
                $("#vpPricingList").empty();
                if (v.model_price_json && v.model_price_json !== "") {
                    try {
                        let prices = JSON.parse(v.model_price_json);
                        if (prices && prices.length > 0) {
                            let groups = { Hour: [], Day: [], Week: [], Month: [], Year: [], Other: [] };
                            prices.forEach(p => {
                                if (p.amount && p.amount !== "") {
                                    let itemLower = p.item.toLowerCase();
                                    let groupName = 'Other';
                                    if (itemLower.includes('hour')) groupName = 'Hour';
                                    else if (itemLower.includes('day')) groupName = 'Day';
                                    else if (itemLower.includes('week')) groupName = 'Week';
                                    else if (itemLower.includes('month')) groupName = 'Month';
                                    else if (itemLower.includes('year')) groupName = 'Year';
                                    
                                    let displayName = p.item;
                                    if (itemLower.includes('without driver')) displayName = 'W/O Driver';
                                    else if (itemLower.includes('with driver')) displayName = 'With Driver';
                                    groups[groupName].push({ name: displayName, amount: p.amount });
                                }
                            });
                            let html = '<div class="row g-2 w-100">';
                            for (const [gName, items] of Object.entries(groups)) {
                                if (items.length > 0) {
                                    html += `<div class="col-6"><div class="border rounded px-2 py-1 bg-lighter"><div class="text-center text-muted fw-bold border-bottom mb-1" style="font-size: 11px;">${gName}</div>`;
                                    items.forEach(i => {
                                        html += `<div class="d-flex justify-content-between align-items-center mb-1"><span class="text-muted" style="font-size: 11px;">${i.name}</span><strong class="text-success" style="font-size: 11px;">${i.amount} <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong></div>`;
                                    });
                                    html += `</div></div>`;
                                }
                            }
                            html += '</div>';
                            $("#vpPricingList").html(html);
                        }
                    } catch(e) {}
                }
                if ($("#vpPricingList").is(':empty')) {
                    $("#vpPricingList").html('<span class="text-muted fst-italic">No pricing setup</span>');
                }
                
                // Status badge styling / Images
                let images = v.images || [];
                let carouselInner = $("#vpCarouselInner");
                carouselInner.empty();
                if (images.length > 0) {
                    $("#vpNoImagesMessage").hide();
                    $("#vpImageCarousel").show();
                    images.forEach((img, idx) => {
                        let activeClass = idx === 0 ? "active" : "";
                        let imgPath = img.includes("http") ? img : ("/uploads/vehicleImages/" + img); 
                        carouselInner.append(`<div class="carousel-item ${activeClass} h-100"><img src="${imgPath}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Vehicle Image"></div>`);
                    });
                } else {
                    $("#vpImageCarousel").hide();
                    $("#vpNoImagesMessage").show();
                }
                
                if ($("#vehicleProfileModal").length) {
                    $("#vehicleProfileModal").appendTo("body");
                }
                $("#vehicleProfileModal").modal("show");
            }
        }
    });
}

$(document).on('click', '.view-maintenance-request', function(e) {
    e.preventDefault();
    let reqId = $(this).data('id');
    
    $('#viewReqServicesList').html('<tr><td colspan="3" class="text-center text-muted"><i class="ri-loader-4-line spin"></i> Loading services...</td></tr>');
    
    if ($("#maintenanceRequestViewModal").length) {
        $("#maintenanceRequestViewModal").appendTo("body");
    }
    $('#maintenanceRequestViewModal').modal('show');
    
    $.ajax({
        url: '/MaintenanceController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ action: 'get_request_details', request_id: reqId }),
        success: function(res) {
            if(res.status === 'success') {
                let req = res.data.request;
                let srvs = res.data.services;
                
                $('#viewReqNo').text(req.request_no || '--');
                let reqDate = req.created_on ? new Date(req.created_on).toLocaleString('en-GB', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}).replace(',', '') : '--';
                if (typeof dayjs !== 'undefined' && req.created_on) {
                    reqDate = dayjs(req.created_on).format('DD-MMM-YYYY h:mm A');
                }
                $('#viewReqDate').text(reqDate);
                $('#viewReqStatus').text(req.status || '--');
                
                let garageName = req.garage_name || req.garage_id || '--';
                $('#viewReqGarage').text(garageName);
                
                $('#viewReqVehicle').text(req.vehicle_number || '--');
                $('#viewReqOdoOut').text(req.odometer_out || '--');
                
                if (srvs && srvs.length > 0) {
                    let sHtml = '';
                    srvs.forEach(s => {
                        sHtml += `<tr>
                            <td>${s.service_name || s.service_id}</td>
                            <td>${s.qty || '--'}</td>
                            <td>${s.unit || '--'}</td>
                        </tr>`;
                    });
                    $('#viewReqServicesList').html(sHtml);
                } else {
                    $('#viewReqServicesList').html('<tr><td colspan="3" class="text-center text-muted">No services found</td></tr>');
                }
            } else {
                $('#viewReqServicesList').html('<tr><td colspan="3" class="text-center text-danger">Failed to load request details</td></tr>');
            }
        },
        error: function() {
            $('#viewReqServicesList').html('<tr><td colspan="3" class="text-center text-danger">Error loading request details</td></tr>');
        }
    });
});

$('#filterCompany').on('change', function() {
    if ($('#navs-justified-home').hasClass('active')) {
        let vehicleNos = $('#vehicleSearch').val().trim();
        if(vehicleNos !== '') {
            loadVehiclesTable('0', vehicleNos);
        } else {
            let modelId = $('#hid_model_id').val();
            if (modelId && modelId !== '0') {
                loadVehiclesTable(modelId, '0');
            }
        }
    } else {
        // Trigger active tab to reload
        let activeTab = $('.li_Vehicle_list .nav-link.active').parent();
        if (activeTab.length) {
            activeTab.click();
        } else {
            // Default load All Vehicles
            $('.li_Vehicle_list[data-status="All"]').click();
        }
    }
});

function downloadPDF() {
    let activeTabContent = $('.tab-content > .active');
    let tableContainer = activeTabContent.find('.d-print-block');
    
    if (tableContainer.length === 0) {
        setupDropdown('dropdownContent', 'error', svgError + "No data available to print", 'click');
        return;
    }
    
    let table = activeTabContent.find('.d-print-block table')[0];
    
    if (!table) {
        setupDropdown('dropdownContent', 'error', svgError + "No data available to print", 'click');
        return;
    }
    
    if (typeof window.jspdf === 'undefined') {
        alert("PDF generator library failed to load. Please check your internet connection.");
        return;
    }
    
    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'pt', 'letter'); // Landscape, points, letter format
        
        let activeTabName = $('.nav.nav-tabs .nav-link.active').text().trim() || "All Vehicles";
        let pageWidth = doc.internal.pageSize.getWidth();

        // Use preloaded high-res logo
        let imgData = highResLogoBase64;
        let logoH = 40;
        let logoW = logoH * highResLogoRatio;
        
        if (!imgData) {
            let logo = document.getElementById('companyLogo');
            if (logo) {
                let canvas = document.createElement('canvas');
                canvas.width = logo.naturalWidth || logo.width || 150;
                canvas.height = logo.naturalHeight || logo.height || 50;
                let ctx = canvas.getContext('2d');
                ctx.drawImage(logo, 0, 0, canvas.width, canvas.height);
                imgData = canvas.toDataURL('image/png');
                let ratio = canvas.width / canvas.height;
                logoH = 40;
                logoW = logoH * ratio;
            }
        }

        // Generate AutoTable
        doc.autoTable({
            html: table,
            startY: 145, // Start below titles on page 1
            theme: 'grid',
            styles: { 
                fontSize: 9, 
                font: 'helvetica',
                cellPadding: 4,
                lineColor: [200, 200, 200],
                lineWidth: 0.1
            },
            headStyles: { 
                fillColor: [138, 28, 20], 
                textColor: 255,
                fontStyle: 'bold'
            },
            alternateRowStyles: { 
                fillColor: [248, 249, 250] 
            },
            margin: { top: 90, bottom: 40, left: 42.5, right: 42.5 },
            didDrawPage: function (data) {
                // HEADER
                if (imgData) {
                    doc.addImage(imgData, 'PNG', 42.5, 20, 136, 136 / highResLogoRatio);
                }
                
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(18);
                doc.setTextColor(0, 0, 0);
                doc.text("AA CAR RENTAL CO. W.L.L.", pageWidth / 2, 40, { align: 'center' });
                
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9);
                doc.text("Salmabad, Kingdom of Bahrain", pageWidth / 2, 55, { align: 'center' });
                
                doc.setFontSize(8);
                let rightX = pageWidth - 42.5; 
                doc.text("Tel : +973 17300322", rightX, 32, { align: 'right' });
                doc.text("Fax : +973 17300311", rightX, 44, { align: 'right' });
                doc.text("info@aarentalbh.com", rightX, 56, { align: 'right' });
                
                doc.setDrawColor(180, 180, 180);
                doc.setLineWidth(1.1); 
                doc.line(42.5, 80, pageWidth - 42.5, 80);
                
                // Titles
                if (data.pageNumber === 1) {
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.setTextColor(44, 62, 80);
                    doc.text("Vehicle Insights Report - " + activeTabName, pageWidth / 2, 100, { align: 'center' });
                    
                    let d = new Date();
                    let day = ("0" + d.getDate()).slice(-2);
                    let month = ("0" + (d.getMonth() + 1)).slice(-2);
                    let year = d.getFullYear();
                    let dateStr = "Generated on: " + day + "/" + month + "/" + year;
                    
                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(9);
                    doc.setTextColor(100, 100, 100);
                    doc.text(dateStr, 42.5, 120);
                }
                
                // FOOTER
                let str = "Page " + doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') {
                    str = str + " of " + 'totalPages';
                }
                doc.setFontSize(8);
                let pageHeight = doc.internal.pageSize.getHeight();
                doc.text(str, pageWidth / 2, pageHeight - 15, { align: 'center' });
            }
        });
        doc.putTotalPages('totalPages');
        
        // Open PDF in new tab
        window.open(doc.output('bloburl'), '_blank');
    } catch (err) {
        console.error("PDF Error: ", err);
        alert("An error occurred while generating the PDF. Check console for details.");
    }
}

</script>

</body>

</html>