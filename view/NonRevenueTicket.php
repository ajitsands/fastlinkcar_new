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
#dropdownContent {
    position: fixed;
    z-index: 999999;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: auto;
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
                        
                        <?php include ROOT_PATH . '/view/templates/NonRevenueTicket/NonRevenueTicketBody.php'; ?>
                         <?php include('templates/VehicleReservation/vehicle_images_slider.php'); ?>
                         <?php include ROOT_PATH . '/view/templates/NonRevenueTicket/vehicleFloatingFooter.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/NonRevenueTicket/vehicle_change_status_modal.php'; ?>
                          <?php include ROOT_PATH . '/view/templates/NonRevenueTicket/vehicle_return_modal.php'; ?>
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
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
    <script>
$(document).ready(function() {
    
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
        action: 'get_vehicle_details_insight_search'
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
    const status = $btn.data('status'); // Get data-status
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
    if (status === 'Staff Use') {
        $('#proceedSelectedVehiclesList').show();
        $('#proceedSelectedVehicles').hide();
    } else {
        $('#proceedSelectedVehiclesList').hide();
        $('#proceedSelectedVehicles').show();
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

$(document).on('click', '#proceedSelectedVehiclesList', function () {
    
    
    if (selectedVehicles.length === 0) {
         setupDropdown('dropdownContent', 'error', svgError + "Please select at least one vehicle", 'click');
                return false;
       
    }

    else
    {
        renderSelectedVehiclesInModalList(selectedVehicles);
                 $('#vehicleChangeStatusModalList').modal('show');
                 setCurrentDateTime('#to_datetime_return');
                 load_non_revenue_ticket_return();
                 
                 
       
    }
    
    
   
    
});

function load_non_revenue_ticket_return()
{
    $('#tblNonRevenueBookings').DataTable({
    destroy: true,
    processing: true,
    
    ajax: {
        url: '/NonRevenueController',
        type: 'POST',
        data: function (d) {
            d.action = 'list_non_revenue_bookings';
            d.returnvehicles = selectedVehicles.map(v => v.id); // Pass only vehicle IDs
        },
       dataSrc: 'data'
    },
    columns: [
    {
        data: null,
        render: function (data, type, row) {
            return `
                <div>
                    <strong>${row.vehicle_no}</strong><br>
                    <small class="text-info">
                        <i class="ri-price-tag-3-line"></i> Ref: ${row.booking_no}
                    </small>
                </div>
            `;
        }
    },
    { data: 'models' },
       {
        data: null,
        render: function (data, type, row) {
            return `
                <div>
                    <small class="text-primary"><strong>From:</strong></small><br>
                    ${row.book_from_date}<br>
                    <small class="text-danger"><strong>To:</strong></small><br>
                    ${row.book_to_date}
                </div>
            `;
        }
    },
    { data: 'staff_details' },
    {
    data: 'notes',
    render: function(data) {
        return '<div style="white-space: normal; word-break: break-word; max-width:250px;">' +
                (data ?? '') +
               '</div>';
    }
}
    ]
});
}

function renderSelectedVehiclesInModalList(vehicles) {

    let container = $('#modalselectedVehiclesList1');
    container.empty();

    if (vehicles.length === 0) {
        container.html('<div class="text-muted small">No vehicles selected</div>');
        $('#modalvehicleBookingCountList').text(0);
        return;
    }

    vehicles.forEach(vehicle => {

        let html = `
            <div class="badge bg-primary text-white d-flex align-items-center gap-1"
                 data-id="${vehicle.id}">

                ${vehicle.modelName} - ${vehicle.vehicleNumber}

                <i class="ri ri-close-line ms-1 cursor-pointer remove-vehicleList"
                   style="font-size:14px;"></i>
            </div>
        `;

        container.append(html);
    });

    $('#modalvehicleBookingCountList').text(vehicles.length);
}
$(document).on('click', '.remove-vehicleList', function () {

    let $badge = $(this).closest('.badge');
    let id = $badge.data('id');

    // Remove from array
    selectedVehicles = selectedVehicles.filter(v => v.id != id);

    // Remove from UI (modal)
    $badge.remove();

    // Update count
    $('#modalvehicleBookingCountList').text(selectedVehicles.length);
    load_non_revenue_ticket_return();
  
    syncVehicleSelectionUI(id);
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

$(document).on('click', '#btnCompleteReturn', function () {

    let return_date = $('#to_datetime_return').val();
    let vehicle_status = $('#select_vehicle_status').val();
    let return_notes = $('#return_notes').val();

    if (!return_date) {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please select return date & time.',
            'click'
        );
        return false;
    }

    if (!vehicle_status) {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please select vehicle status.',
            'click'
        );
        return false;
    }

    if (selectedVehicles.length === 0) {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'No vehicles selected.',
            'click'
        );
        return false;
    }


    // Get vehicle IDs
    let vehicle_ids = selectedVehicles.map(v => v.id);


    $.ajax({
        url: '/NonRevenueController',
        type: 'POST',
       // dataType: 'json',
        data: {
            action: 'non_revenue_ticket_return',
            vehicle_ids: vehicle_ids,
            return_date: return_date,
            vehicle_status: vehicle_status,
            return_notes: return_notes
        },

        success: function (response) {

            if (response.status) {

                setupDropdown(
                    'dropdownContent',
                    'success',
                    svgSuccess + response.message,
                    'click'
                );

                $('#return_notes').val('');
                $('#to_datetime_return').val('');
                $('#select_service_type').val('');

                selectedVehicles = [];

                $('#vehicleChangeStatusModalList').modal('hide');

                location.reload();

            } else {

                setupDropdown(
                    'dropdownContent',
                    'error',
                    svgError + response.message,
                    'click'
                );
            }
        },

        error: function(xhr){
            console.log(xhr.responseText);
        }
    });

});
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
function validateDateRange(from, to) {

   
    if (!from && !to) {
         return { valid: false, message: 'Please select both From and To date & time' };
    }

    if (!from || !to) {
        return { valid: false, message: 'Please select both From and To date & time' };
    }

    let fromDate = new Date(from);
    let toDate = new Date(to);

    if (isNaN(fromDate) || isNaN(toDate)) {
        return { valid: false, message: 'Invalid date format' };
    }
    if (fromDate >= toDate) {
        return { valid: false, message: 'From date must be less than To date' };
    }

    return { valid: true };
}
$(document).on('click', '#confirmnrtBtn', function () {
    
    let staff_ids = $('#staff_id').val();
    let staff_name = $('#StaffName').val();
    let staff_mobile = $('#StaffPhone').val();
    let staff_email = $('#StaffEmail').val();
    let staff_license = $('#StaffLicence').val();
    let staff_cpr = $('#StaffCPR').val();
    let staff_cprexpiry = $('#StaffCPRExpiry').val();
    let staff_licenseplace = $('#StaffLicenceIssue').val();
    let staff_licenseissue = $('#StaffLicenceIssueDate').val();
    let staff_licenseexpiry = $('#StaffLicenceExpiryDate').val();
    
    let notes = $('#booking_notes').val();
    let from = $('#from_datetime').val();
    let to = $('#to_datetime').val();

    let validation = validateDateRange(from, to);
    if (from && to) {
    
        let validation = validateDateRange(from, to);
    
        if (!validation.valid) {
            setupDropdown(
                'dropdownContent',
                'error',
                svgError + validation.message,
                'click'
            );
            return false;
        }
    
    }
    if (staff_ids=='' ) {
        $('#dropdownContent').css('z-index', '99999');

         setupDropdown('dropdownContent', 'error', svgError + "Please select a staff to assign the selected vehicle.", 'click');
                return false;
       
    }
    

     
   else if (selectedVehicles.length === 0) {
       $('#dropdownContent').css('z-index', '99999');

         setupDropdown('dropdownContent', 'error', svgError + "Please select at least one vehicle", 'click');
                return false;
    }

    else
    {
        let staffDetails = {
            staff_id: staff_ids,
            staff_name: staff_name,
            mobile: staff_mobile,
            email: staff_email,
            licence_no: staff_license,
            licence_issue_place: staff_licenseplace,
            licence_issue_date: staff_licenseissue,
            licence_expiry_date: staff_licenseexpiry,
            cpr_no: staff_cpr,
            cpr_expiry: staff_cprexpiry
        };
        
        let bookingDetails = {
            from_datetime: from,
            to_datetime: to,
            notes: notes
        };
    console.log(selectedVehicles);
    let vehicleIds = selectedVehicles.map(v => v.id);
       $.ajax({
            url: '/NonRevenueController',
            type: 'POST',
            data: {
                action:'non_revenue_ticket_book',
                 vehicles: JSON.stringify(selectedVehicles),
                staff_details: JSON.stringify(staffDetails),
                booking_details: JSON.stringify(bookingDetails)
            },
             dataType: 'json',
            success: function (response) {
                
                   if (response.status)
                    {
                     
                       setupDropdown(
                            'dropdownContent',
                            'success',
                            svgSuccess + response.message + "<br>Ref No: <b>" + response.booking_no + "</b>",
                            'click'
                        );
                    
                     $('#booking_notes').val('');  
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
 $('#vehicleChangeStatusModal').on('shown.bs.modal', function () {
 if ($('#selectStaffFromSelect2').hasClass('select2-hidden-accessible')) {
        $('#selectStaffFromSelect2').select2('destroy');
    }
setCurrentDateTime('#from_datetime');


    $('#selectStaffFromSelect2').select2({
        dropdownParent: $('#vehicleChangeStatusModal'),
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
function formatDate(dateStr) {
    var parts = dateStr.split('-');
    return parts[2] + '-' + parts[1] + '-' + parts[0];
}



$('#selectStaffFromSelect2').on('select2:select', function (e) {
    let data = e.params.data;
    $('#staff_id').val(data.id);
    $('#StaffName').val(data.staff_name);
    $('#StaffPhone').val(data.staff_contact_no);
    $('#StaffEmail').val(data.staff_email_id);
    $('#StaffCPR').val(data.staff_cpr_no);
    $('#StaffCPRExpiry').val(formatDate(data.staff_cpr_expiry_date));
    $('#StaffLicence').val(data.license_no);
    $('#StaffLicenceIssue').val(data.license_issue_place);
    $('#StaffLicenceIssueDate').val(formatDate(data.license_issue_date));
    $('#StaffLicenceExpiryDate').val(formatDate(data.license_expiry_date));
    checkLicenseExpiry(data.license_expiry_date);
    checkCprExpiry(data.staff_cpr_expiry_date);
   
});

function checkLicenseExpiry(expiryDate) {
    // expiryDate format: yyyy-mm-dd
    var today = new Date();
    today.setHours(0, 0, 0, 0);

    var expiry = new Date(expiryDate);
    expiry.setHours(0, 0, 0, 0);

    var diffDays = Math.floor((expiry - today) / (1000 * 60 * 60 * 24));

    if (diffDays < 0) {
        $("#licenseStatus")
            .html("<i class='ri-error-warning-fill'></i> License has expired.")
            .css({
                "color": "#dc3545", // Red
                "font-weight": "bold"
            });

    } else if (diffDays < 15) {
        $("#licenseStatus")
            .html("<i class='ri-alert-fill'></i> Warning: License will expire in <b>" + diffDays + "</b> day(s).")
            .css({
                "color": "#fd7e14", // Orange
                "font-weight": "bold"
            });

    } else {
        $("#licenseStatus")
            .html("<i class='ri-checkbox-circle-fill'></i> Expiry in <b>" + diffDays + "</b> day(s).")
            .css({
                "color": "#198754", // Green
                "font-weight": "normal"
            });
    }
}
function checkCprExpiry(expiryDate) {
    // expiryDate format: yyyy-mm-dd
    var today = new Date();
    today.setHours(0, 0, 0, 0);

    var expiry = new Date(expiryDate);
    expiry.setHours(0, 0, 0, 0);

    var diffDays = Math.floor((expiry - today) / (1000 * 60 * 60 * 24));

    if (diffDays < 0) {
        $("#cprStatus")
            .html("<i class='ri-error-warning-fill'></i> CPR has expired.")
            .css({
                "color": "#dc3545", // Red
                "font-weight": "bold"
            });

    } else if (diffDays < 15) {
        $("#cprStatus")
            .html("<i class='ri-alert-fill'></i> Warning: CPR will expire in <b>" + diffDays + "</b> day(s).")
            .css({
                "color": "#fd7e14", // Orange
                "font-weight": "bold"
            });

    } else {
        $("#cprStatus")
            .html("<i class='ri-checkbox-circle-fill'></i> Expiry in <b>" + diffDays + "</b> day(s).")
            .css({
                "color": "#198754", // Green
                "font-weight": "normal"
            });
    }
}

$('#selectStaffFromSelect2').on('select2:clear', function () {
    $('#staff_id').val('');
    $('#StaffName').val('');
    $('#StaffPhone').val('');
    $('#StaffEmail').val('');
    $('#StaffCPR').val('');
    $('#StaffCPRExpiry').val('');
    $('#StaffLicence').val('');
    $('#StaffLicenceIssue').val('');
    $('#StaffLicenceIssueDate').val('');
    $('#StaffLicenceExpiryDate').val('');
    $('#cprStatus').html('');
    $('#licenseStatus').html('');
}); 
function setCurrentDateTime(selectors) {
    const now = new Date();

    const currentDateTime =
        now.getFullYear() + '-' +
        String(now.getMonth() + 1).padStart(2, '0') + '-' +
        String(now.getDate()).padStart(2, '0') + 'T' +
        String(now.getHours()).padStart(2, '0') + ':' +
        String(now.getMinutes()).padStart(2, '0');

    $(selectors).val(currentDateTime);
}

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

loadAllVehiclesTable(
    'Available',
    $('#AvailvehicleContainer'),
    $('#AvailvehicleAvailabilityContent'),
    $('#AvailvehicleContainer .vehicle-card')
);
// All Vehicle List
$(document).on('click', '.li_Vehicle_list', function () {
     let status = $(this).data('status');
      let divcontainer,divcontent,vehicle_card;
     switch(status)
     {
        
         
         case 'List':
             divcontainer = $('#ParkvehicleContainer');
              divcontent = $('#ParkvehicleAvailabilityContent');
              vehicle_card=$('#ParkvehicleContainer .vehicle-card');
         break;
          case 'Available':
             divcontainer = $('#AvailvehicleContainer');
              divcontent = $('#AvailvehicleAvailabilityContent');
              vehicle_card=$('#AvailvehicleContainer .vehicle-card');
         break;
         default:
             divcontainer = $('#AvailvehicleContainer');
              divcontent = $('#AvailvehicleAvailabilityContent');
              vehicle_card=$('#AvailvehicleContainer .vehicle-card');
         break;
        
     }
  
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
        
     
      $('#selectedVehiclesFooter').addClass('d-none');
    
        $('#selectedVehiclesList').empty();    
    loadAllVehiclesTable(status,divcontainer,divcontent,vehicle_card);
});

  function loadAllVehiclesTable(status,divcontainer,divcontent,vehicle_card) {
    $('#AllvehicleContainer').html('<div class="p-3 text-center">Loading...</div>');

    $.ajax({
      url: '/NonRevenueController',
      method: 'POST',
      data: {
        action: 'get_vehicle_details_insight',
        status:status
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
        
         case 'Available':
             
              vehicle_card=$('#AvailvehicleContainer .vehicle-card');
         break;
         case 'Parking':
           
              vehicle_card=$('#ParkvehicleContainer .vehicle-card');
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
</script>

</body>

</html>