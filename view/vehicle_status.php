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
                        
                        <?php include ROOT_PATH . '/view/templates/VehicleStatus/VehicleStatusBody.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicleFloatingFooter.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_booking_modal.php'; ?>
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
    <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicleInfoModal.php'; ?>
   

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-selects.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
   
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
      url: '/VehicleStatusController',
      method: 'POST',
      data: {
        modelId: modelId,
        vehicleNumber:vehicleNumber,
        action: 'get_vehicle_details'
      },
      dataType: 'html',
      success: function(response) {

        $('#vehicleContainer').html(response);
         $('[data-bs-toggle="tooltip"]').tooltip();
        
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
           
            var vehicleNumber = $(this).find('.fw-bold').text().toLowerCase();

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
        vehicleNumber: $btn.closest('.vehicle-card').find('.fw-bold.text-dark').text()
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
 let passingHistory = [];
 let insuranceHistory = [];
 let maintenanceHistory = [];
 
 $(document).on('click', '.btn_vehicle_view', function() {
    let vehicleId = $(this).data('id');
    
    $('#hid_vehicle_id_info_modal').val(vehicleId);
    resetPassingForm();
    $('#passingFormCard').addClass('d-none');
    let modal = new bootstrap.Modal(document.getElementById('vehicleDetailsModal'));
    modal.show();

   
    $.ajax({
        url: '/VehicleStatusController',
        method: 'POST',
        data: {
            action: 'get_vehicle_full_details',
            vehicleId: vehicleId
        },
        success: function(response) {
            
         let res = response.data[0];
            let lastImage = response.last_image;
            let vehicleStatushtml = response.vehicleStatushtml;
            let other = JSON.parse(res.other_details_json || "{}");
            passingHistory = JSON.parse(res.passing_histroy || "[]");
            insuranceHistory = JSON.parse(res.insurance_histroy || "[]");
            maintenanceHistory = JSON.parse(res.maintenance_histroy || "[]");
            $('#vehicleModel').text(res.model_names || '-');
            $('#vehicleNumber').text(res.vehicle_number || '-');
            $('#div_common_car_number').text(res.vehicle_number || '-');
            $('#div_common_car_name').text(res.model_names || '-');
            
            $('#vehicleYear').text(res.vehicle_year || '-');
            $('#vehicleColor').text(res.vehicle_color || '-');
            
            $('#purchaseDate').text(res.vehicle_purchase_date || '-');
            $('#purchaseCost').text(other.vehiclePurchasePrice || '-');
            
            $('#costHour').text(other.vehiclePricePerHour || 0);
            $('#costDay').text(other.vehiclePricePerDay || 0);
            $('#costMonth').text(other.vehiclePricePerMonth || 0);
            
            $('#remarks').text(other.vehicleDescription || '-');
            let imageUrlModal = '/uploads/vehicleImages/' + lastImage;

            $('#vehicleImageModal').attr('src', imageUrlModal);
            $('#div_modal_status').html(vehicleStatushtml);
            let imageHtml = '';
            
            
            let imagesRaw = res.image_json;

                    let images = [];
                    
                    try {
                      let parsed = JSON.parse(imagesRaw);
                    
                      if (typeof parsed === 'string') {
                        parsed = JSON.parse(parsed);
                      }
                    
                      if (Array.isArray(parsed)) {
                        images = parsed;
                      }
                    
                    } catch (e) {
                      console.error("Image JSON parse error:", e);
                      images = [];
                    }

               
                
                images.forEach(img => {
                    
                  imageHtml += `
                    <li class="avatar avatar-lg pull-up me-1 open-file-docs"
                        data-img="/uploads/vehicleImages/${img}"
                        data-name="${img}"
                        title="${img}">
                        
                      <img class="rounded-circle" src="/uploads/vehicleImages/${img}">
                    </li>
                  `;
                });
                
                $('#vehicleImagesList').html(imageHtml);
                
          let docs = [];

            let attachments = JSON.parse(JSON.parse(res.vehicle_attachments || "{}"));
            
            attachments.vehicles?.forEach(v => {
              v.files.forEach(file => {
                docs.push({
                  name: v.documentName,
                  url: file
                });
              });
            });
            
            let docHtml = '';

                docs.forEach(doc => {
                    let exts = doc.url.split('.').pop().toLowerCase();
                    let previewSrcs = getFilePreview(exts, doc.url);
                 docHtml += `
                    <li class="avatar avatar-lg pull-up me-1 open-file-docs"
                        data-img="${doc.url}"
                        data-name="${doc.name}"
                        title="${doc.name}">
                        
                      <img class="rounded-circle" src="${previewSrcs}">
                       <div style="font-size:11px; max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                ${doc.name}
                            </div>
                    </li>
                    `;
                });
 
    
   
          $('#vehicleDocsList').html(docHtml);
                
          renderPassingTimeline(passingHistory);
          renderInsuranceTimeline(insuranceHistory); 
          renderMaintenanceTimeline(maintenanceHistory); 

        },
        error: function() {
            $('#vehicleInfoContent').html('<div class="text-danger">Failed to load data</div>');
        }
    });
});
function renderPassingTimeline(passingHistory=null) {

    let passtimelineHtml = '';

    [...passingHistory].reverse().forEach((passitem, passindex) => {

        let passoriginalIndex = passingHistory.length - 1 - passindex;
    
    
        let passattachmentsHtml = '<ul id="Passing_img_list" class="list-unstyled d-flex align-items-center avatar-group mb-0">';
    
        if (passitem.documents && passitem.documents.length > 0) {
            passitem.documents.forEach(passdoc => {
              let passtimeexts = passdoc.url.split('.').pop().toLowerCase();
              let passtimeurl ='httpdocs'+passdoc.url;
              let passtimepreviewSrcs = getFilePreview(passtimeexts, passtimeurl);
                passattachmentsHtml += `
                    <li data-img="httpdocs${passdoc.url}" data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="${passdoc.name}"
                        class="avatar avatar-lg pull-up me-1 open-file-docs">
                        
                        <img class="rounded-circle" src="${passtimepreviewSrcs}">
                    </li>
                `;
            });
        }
         passattachmentsHtml += '</ul>';
        passtimelineHtml += `
        <li class="timeline-item timeline-item-transparent border-dashed" data-index="${passoriginalIndex}">
            <span class="timeline-point timeline-point-primary"></span>
    
            <div class="timeline-event">
    
                <div class="timeline-header mb-3">
                    <h6 class="mb-0 timeline-title">${passitem.added_info}</h6>
    
                    <div class="d-flex justify-content-end mb-2">
                        <button class="btn btn-sm btn-outline-primary me-1 editPassingTimeline" data-index="${passoriginalIndex}">Edit</button>
                        <button class="btn btn-sm btn-outline-danger deletePassingTimeline" data-index="${passoriginalIndex}">Delete</button>
                    </div>
                </div>
    
                <div class="row g-2 mb-2">
    
                    <div class="col-md-6">
                        <small class="text-muted">Next Passing Date</small>
                        <div class="fw-medium">${passitem.next_date}</div>
                    </div>
    
                    <div class="col-md-6">
                        <small class="text-muted">Done Date</small>
                        <div class="fw-medium">${passitem.done_date}</div>
                    </div>
    
                    <div class="col-md-12">
                        <small class="text-muted">Remarks</small>
                        <p class="mb-1">${passitem.remarks || ''}</p>
                    </div>
    
                </div>
    
                <!-- Attachments -->
                <div class="mb-2">
                    <small class="text-muted d-block mb-1">Attachments</small>
    
                    <ul class="users-list d-flex align-items-center avatar-group m-0">
                        ${passattachmentsHtml}
                    </ul>
                </div>
    
            </div>
        </li>
        `;
    });
    $('#ul_passing_histroy_timeline').html(passtimelineHtml);
}
function renderInsuranceTimeline(insuranceHistory=null) {

    let insurancetimelineHtml = '';

    [...insuranceHistory].reverse().forEach((insuranceitem, insuranceindex) => {

        let insuranceoriginalIndex = insuranceHistory.length - 1 - insuranceindex;
    
    
        let insuranceattachmentsHtml = '<ul id="insurance_img_list" class="list-unstyled d-flex align-items-center avatar-group mb-0">';
    
        if (insuranceitem.documents && insuranceitem.documents.length > 0) {
            insuranceitem.documents.forEach(insurancedoc => {
              let insurancetimeexts = insurancedoc.url.split('.').pop().toLowerCase();
              let insurancetimeurl ='httpdocs'+insurancedoc.url;
              let insurancetimepreviewSrcs = getFilePreview(insurancetimeexts, insurancetimeurl);
                insuranceattachmentsHtml += `
                    <li data-img="httpdocs${insurancedoc.url}" data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="${insurancedoc.name}"
                        class="avatar avatar-lg pull-up me-1 open-file-docs">
                        
                        <img class="rounded-circle" src="${insurancetimepreviewSrcs}">
                    </li>
                `;
            });
        }
         insuranceattachmentsHtml += '</ul>';
        insurancetimelineHtml += `
        <li class="timeline-item timeline-item-transparent border-dashed" data-index="${insuranceoriginalIndex}">
            <span class="timeline-point timeline-point-success"></span>
    
            <div class="timeline-event">
    
                <div class="timeline-header mb-3">
                    <h6 class="mb-0 timeline-title">${insuranceitem.added_info}</h6>
    
                    <div class="d-flex justify-content-end mb-2">
                        <button class="btn btn-sm btn-outline-primary me-1 editInsuranceTimeline" data-index="${insuranceoriginalIndex}">Edit</button>
                        <button class="btn btn-sm btn-outline-danger deleteInsuranceTimeline" data-index="${insuranceoriginalIndex}">Delete</button>
                    </div>
                </div>
    
                <div class="row g-2 mb-2">
    
                    <div class="col-md-6">
                        <small class="text-muted">Next Insurance Date</small>
                        <div class="fw-medium">${insuranceitem.next_date}</div>
                    </div>
    
                    <div class="col-md-6">
                        <small class="text-muted">Done Date</small>
                        <div class="fw-medium">${insuranceitem.done_date}</div>
                    </div>
    
                    <div class="col-md-12">
                        <small class="text-muted">Remarks</small>
                        <p class="mb-1">${insuranceitem.remarks || ''}</p>
                    </div>
    
                </div>
    
                <!-- Attachments -->
                <div class="mb-2">
                    <small class="text-muted d-block mb-1">Attachments</small>
    
                    <ul class="users-list d-flex align-items-center avatar-group m-0">
                        ${insuranceattachmentsHtml}
                    </ul>
                </div>
    
            </div>
        </li>
        `;
    });
    $('#ul_insurance_histroy_timeline').html(insurancetimelineHtml);
}
function renderMaintenanceTimeline(maintenanceHistory=null) {

    let maintenancetimelineHtml = '';

    [...maintenanceHistory].reverse().forEach((maintenanceitem, maintenanceindex) => {

        let maintenanceoriginalIndex = maintenanceHistory.length - 1 - maintenanceindex;
    
    
        let maintenanceattachmentsHtml = '<ul id="maintenance_img_list" class="list-unstyled d-flex align-items-center avatar-group mb-0">';
    
        if (maintenanceitem.documents && maintenanceitem.documents.length > 0) {
            maintenanceitem.documents.forEach(maintenancedoc => {
              let maintenancetimeexts = maintenancedoc.url.split('.').pop().toLowerCase();
              let maintenancetimeurl ='httpdocs'+maintenancedoc.url;
              let maintenancetimepreviewSrcs = getFilePreview(maintenancetimeexts, maintenancetimeurl);
                maintenanceattachmentsHtml += `
                    <li data-img="httpdocs${maintenancedoc.url}" data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="${maintenancedoc.name}"
                        class="avatar avatar-lg pull-up me-1 open-file-docs">
                        
                        <img class="rounded-circle" src="${maintenancetimepreviewSrcs}">
                    </li>
                `;
            });
        }
        maintenanceattachmentsHtml += '</ul>';
        maintenancetimelineHtml += `
        <li class="timeline-item timeline-item-transparent border-dashed" data-index="${maintenanceoriginalIndex}">
            <span class="timeline-point timeline-point-info"></span>
    
            <div class="timeline-event">
    
                <div class="timeline-header mb-3">
                    <h6 class="mb-0 timeline-title">${maintenanceitem.added_info}</h6>
    
                    <div class="d-flex justify-content-end mb-2">
                        <button class="btn btn-sm btn-outline-primary me-1 editMaintenanceTimeline" data-index="${maintenanceoriginalIndex}">Edit</button>
                        <button class="btn btn-sm btn-outline-danger deleteMaintenanceTimeline" data-index="${maintenanceoriginalIndex}">Delete</button>
                    </div>
                </div>
    
                <div class="row g-2 mb-2">
    
                    <div class="col-md-6">
                        <small class="text-muted">Next Maintenance Date</small>
                        <div class="fw-medium">${maintenanceitem.next_date}</div>
                    </div>
    
                    <div class="col-md-6">
                        <small class="text-muted">Done Date</small>
                        <div class="fw-medium">${maintenanceitem.done_date}</div>
                    </div>
    
                    <div class="col-md-12">
                        <small class="text-muted">Remarks</small>
                        <p class="mb-1">${maintenanceitem.remarks || ''}</p>
                    </div>
    
                </div>
    
                <!-- Attachments -->
                <div class="mb-2">
                    <small class="text-muted d-block mb-1">Attachments</small>
    
                    <ul class="users-list d-flex align-items-center avatar-group m-0">
                        ${maintenanceattachmentsHtml}
                    </ul>
                </div>
    
            </div>
        </li>
        `;
    });
    $('#ul_maintenance_histroy_timeline').html(maintenancetimelineHtml);
}
$(document).on('click','.open-file-docs', function () {

    let fileUrl = $(this).data('img');
    let fileName = $(this).data('name');

    let ext = fileUrl.split('.').pop().toLowerCase();

    $('#filePreviewTitle').text(fileName);

    let content = '';

    // Image preview
    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
        content = `<img src="${fileUrl}" class="img-fluid rounded">`;
    }

    // PDF preview
    else if (ext === 'pdf') {
        content = `
            <iframe src="${fileUrl}" 
                    width="100%" 
                    height="600px"
                    style="border:none;">
            </iframe>`;
    }

    // Other files
    else {
        content = `
            <div class="text-center">
                <p>Preview not available</p>
                <a href="${fileUrl}" target="_blank" class="btn btn-primary">
                    Open / Download
                </a>
            </div>`;
    }

    $('#filePreviewBody').html(content);

    $('#filePreviewModal').modal('show');
});

// let fileStore = {
//   passing: []
// };

let fileStore = {
    passing: [],
    insurance: [],
    maintenance: []
};

function uploadModuleFiles(moduleKey, callback) {

  let files = fileStore[moduleKey] || [];

  console.log("FILES FROM STORE:", files); // ✅ MUST NOT BE EMPTY

  if (files.length === 0) {
    console.warn("No files to upload");
    callback([]);
    return;
  }

  let formData = new FormData();

  formData.append("module", moduleKey);

  files.forEach(file => {
    formData.append("files[]", file);
  });

  // 🔍 DEBUG: log FormData
  for (let pair of formData.entries()) {
    console.log(pair[0], pair[1]);
  }

  $.ajax({
    url: '/UploadVehicleDocs',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    success: function (res) {
      console.log("UPLOAD RESPONSE:", res);

      if (typeof res === "string") {
        res = JSON.parse(res);
      }

      callback(res.files || []);
    },
    error: function (err) {
      console.error("UPLOAD ERROR:", err);
    }
  });
}


// For Vehicle Passing Details
 let editPassingTarget = null;

function resetPassingForm() {
  $('#nextDate').val('');
  $('#passingDate').val('');
  $('#addedinfo').val('');
  $('#passingremarks').val('');
  $('#passingattachments').val('');
  $('#PassingfilePreview').html('');
  selecteddocFiles= [];
  editPassingTarget = null;
  index = null;
  $('#formTitle').text('Add Passing Details');
}

$('#addTimelineBtn').click(function () {

  editPassingTarget = null;
  
 resetPassingForm();
  $('#passingFormCard').removeClass('d-none');
  
});


function renderFilePreview(moduleKey, containerId, historyData, index) {

    let container = $('#' + containerId);
    container.html('');

    let files = fileStore[moduleKey] || [];

    // ✅ 1. Show existing files (if editing)
    if (index !== null && historyData[index] !== undefined) {

        let item = historyData[index];

        item.documents.forEach((doc, docIndex) => {

            let ext = doc.url.split('.').pop().toLowerCase();
            let isImage = ['jpg','jpeg','png','gif','webp'].includes(ext);

            let previewSrc = getFilePreview(ext, doc.url);

            let finalSrc = isImage
                ? (doc.isNew ? previewSrc : 'httpdocs/' + doc.url)
                : previewSrc;

            container.append(buildPreviewItem({
                previewIcon: finalSrc,
                fileUrl: 'httpdocs/' + doc.url,
                fileName: doc.name,
                type: 'existing',
                index: docIndex,
                module: moduleKey
            }));
        });
    }

    // ✅ 2. Show newly added files (ALWAYS)
    files.forEach((file, fileIndex) => {

        let blobUrl = URL.createObjectURL(file);
        let ext = file.name.split('.').pop().toLowerCase();

        let previewSrc = getFilePreview(ext, blobUrl);

        container.append(buildPreviewItem({
            previewIcon: previewSrc,
            fileUrl: blobUrl,
            fileName: file.name,
            type: 'new',
            index: fileIndex,
            module: moduleKey
        }));
    });
}
function buildPreviewItem({ previewIcon, fileUrl, fileName, type, index, module }) {

    return `
    <li class="avatar avatar-lg pull-up me-1 open-preview"
        data-img="${fileUrl}"
        data-name="${fileName}"
        data-type="${type}"
        data-index="${index}"
        data-module="${module}"
        data-bs-toggle="tooltip"
        title="${fileName}">

        <img class="rounded-circle" src="${previewIcon}" />

        <span class="remove-file"
              data-type="${type}"
              data-index="${index}"
              data-module="${module}">&times;</span>

    </li>`;
}


let moduleConfig = {
    passing: {
        history: passingHistory,
        getEditIndex: () => editPassingTarget,
        previewId: 'PassingfilePreview'
    },
    insurance: {
        history: insuranceHistory,
        getEditIndex: () => editInsuranceTarget,
        previewId: 'InsurancefilePreview'
    },
    maintenance: {
        history: maintenanceHistory,
        getEditIndex: () => editMaintenanceTarget,
        previewId: 'MaintenancefilePreview'
    }
};
$(document).on('click', '.remove-file', function (e) {

    e.stopPropagation();

    let type = $(this).data('type');    
    let module = $(this).data('module');

    let config = moduleConfig[module];

    if (!config) {
        console.warn('Invalid module:', module);
        return;
    }

    let history = config.history;
    let historyIndex = config.getEditIndex();
    let previewId = config.previewId;

    // ✅ Remove existing file
    if (type === 'existing') {

        if (historyIndex !== null &&
            history[historyIndex] &&
            history[historyIndex].documents) {

            history[historyIndex].documents.splice(index, 1);
        }

    } 
    // ✅ Remove new file
    else {

        if (fileStore[module]) {
            fileStore[module].splice(index, 1);
        }
    }

    // ✅ Re-render preview
    renderFilePreview(module, previewId, history, historyIndex);
});

$(document).on('click', '.open-preview', function () {

    let fileUrl = $(this).data('img');
    let fileName = $(this).data('name');

    let ext = fileUrl.split('.').pop().toLowerCase();

    $('#filePreviewTitle').text(fileName);

    let content = '';

    if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
        content = `<img src="${fileUrl}" class="img-fluid">`;
    }
    else if (ext === 'pdf') {
        content = `<iframe src="${fileUrl}" width="100%" height="600px"></iframe>`;
    }
    else {
        content = `<a href="${fileUrl}" target="_blank" class="btn btn-primary">Open File</a>`;
    }

    $('#filePreviewBody').html(content);
    $('#filePreviewModal').modal('show');
});

function toggleSaveLoaderByModule(module, show = true) {

    let btn = $(`#save_${module}`);

    if (!btn.length) return;

    if (show) {
        btn.prop('disabled', true);
        btn.find('.btn-text').addClass('d-none');
        btn.find('.btn-loader').removeClass('d-none');
    } else {
        btn.prop('disabled', false);
        btn.find('.btn-text').removeClass('d-none');
        btn.find('.btn-loader').addClass('d-none');
    }
}

$(document).on('click', '.editPassingTimeline', function () {

    let index = $(this).data('index');
    let item = passingHistory[index];

    $('#addedinfo').val(item.added_info);
    $('#nextDate').val(item.next_date);
    $('#passingDate').val(item.done_date);
    $('#passingremarks').val(item.remarks);

    // Reset new files
    fileStore['passing'] = [];

    editPassingTarget = index;
    $('#savePassing').data('index', index);

    renderFilePreview('passing', 'PassingfilePreview', passingHistory, index);

    $('#formTitle').text('Save Passing Details');
    $('#passingFormCard').removeClass('d-none');
   let modalBody = $('#vehicleDetailsModal .modal-body');

    setTimeout(() => {
        modalBody.animate({
            scrollTop: $('#passingFormCard').position().top
        }, 400);
    }, 100);
});
$('#passingattachments').on('change', function (e) {

    let newFiles = Array.from(e.target.files);

    if (!fileStore['passing']) {
        fileStore['passing'] = [];
    }

    // Append new files instead of replacing
    newFiles.forEach(file => {
        fileStore['passing'].push(file);
    });

    // Clear input so same file can be reselected if needed
    $(this).val('');

    // Re-render preview with ALL stored files
    renderFilePreview('passing', 'PassingfilePreview', passingHistory, editPassingTarget);
});




$('#savePassing').on('click', function () {

   
    toggleSaveLoaderByModule('passing', true);

    uploadModuleFiles('passing', function (uploadedFiles) {

        let existingDocs = [];

        if (editPassingTarget !== null &&
            passingHistory[editPassingTarget].documents) {

            existingDocs = passingHistory[editPassingTarget].documents
                .filter(doc => !doc.isDeleted);
        }

        let newDocs = uploadedFiles.map(file => ({
            name: file.name,
            url: file.path || file.url,
            isNew: false
        }));

        let finalDocs = [...existingDocs, ...newDocs];

        let node = {
            added_info: $('#addedinfo').val(),
            next_date: $('#nextDate').val(),
            done_date: $('#passingDate').val(),
            remarks: $('#passingremarks').val(),
            documents: finalDocs
        };

        if (editPassingTarget !== null) {
            passingHistory[editPassingTarget] = {
                ...passingHistory[editPassingTarget],
                ...node
            };
        } else {
            passingHistory.push(node);
        }

        renderPassingTimeline(passingHistory);

        savePassingToDB(function () {
            fileStore['passing'] = [];
            editPassingTarget = null;

             toggleSaveLoaderByModule('passing', false);
        });

    });
});
function savePassingToDB(callback = null,actionOverride = null) {

    let formData = new FormData();

   let action_cate = actionOverride 
        ? actionOverride 
        : (editPassingTarget !== null ? 'edit' : 'add');
    

    let nextDates = passingHistory
        .map(item => item.next_date)
        .filter(date => date); 

    let next_passing_date = null;

    let today = new Date();
        today.setHours(0,0,0,0); // normalize
        
        let futureDates = nextDates.filter(date => {
            let d = new Date(date);
            d.setHours(0,0,0,0);
            return d >= today; // only today or future
        });
        
        if (futureDates.length > 0) {
            next_passing_date = futureDates.reduce((nearest, current) => {
                return new Date(current) < new Date(nearest) ? current : nearest;
            });
        }
   
    let payload = {
        action: 'passing',
        action_cate: action_cate,
        editIndex: editPassingTarget !== null ? editPassingTarget : null,
        next_passing_date: next_passing_date,
        passingHistory: passingHistory,
        vehicleId:$('#hid_vehicle_id_info_modal').val()
    };

    formData.append('payload', JSON.stringify(payload));

    $.ajax({
        url: '/VehicleStatusJsonController', // your endpoint
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {

    // If response is string → convert to JSON
    if (typeof res === "string") {
        res = JSON.parse(res);
    }

    console.log("SERVER RESPONSE:", res);

    
    if (res.status === true) {

        let rows = res.data?.rows_affected || 0;
        
         let successMessage = '';
        
            if (action_cate === 'delete') {
                successMessage = "Passing details deleted successfully";
            } else if (editPassingTarget !== null) {
                successMessage = "Passing details updated successfully";
            } else {
                successMessage = "Passing details added successfully";
            }
            
          setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + successMessage,
                'click'
            );
        
       setTimeout(function () {

            $('#dropdownContent')
                .appendTo('body')   
                .css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    zIndex: 9999999
                });
        
        }, 0);
         
      if (callback) callback();
        resetPassingForm();
       $('#passingFormCard').addClass('d-none');


    } else {
     toggleSaveLoaderByModule('passing', false);
        alert(res.message || "Something went wrong");
    }
},
        error: function (err) {
            console.error("SAVE ERROR:", err);
            toggleSaveLoaderByModule('passing', false);
            alert('Error saving data');
        }
    });
}


let deletePassingIndex = null;
$(document).on('click', '.deletePassingTimeline', function () {

    let index = $(this).data('index');

    if (index === undefined) {
        console.warn("Invalid index for delete");
        return;
    }

    deletePassingIndex = index; // ✅ store globally

    SaNDSAlert(
        'Are you sure you want to delete this entry?',
        'deletePasingTimeline',
        'danger',
        '#C70039',
        'Yes, I am sure'
    );
   
     // ✅ Fix layering AFTER render
    setTimeout(function () {
        $('#popupOverlay').css({
            zIndex: 999998,
            position: 'fixed'
        });

        $('#popupContainer').css({
            zIndex: 999999,
            position: 'fixed'
        });

    }, 0);
    
});

function deletePasingTimeline() {

    if (deletePassingIndex === null || deletePassingIndex === undefined) {
        console.warn("No index set for deletion");
        return;
    }

    passingHistory.splice(deletePassingIndex, 1);

    // Reset index
    deletePassingIndex = null;

    renderPassingTimeline(passingHistory);

    savePassingToDB(null, 'delete');
}


$('#closeFormPassing').click(function () {
    resetPassingForm();
    $('#passingFormCard').addClass('d-none');
  
});
 
 
 
 
 
 // Insurance Module
 
 
 let editInsuranceTarget = null;

function resetInsuranceForm() {
  $('#insurancenextDate').val('');
  $('#insuranceDate').val('');
  $('#insuranceaddedinfo').val('');
  $('#insuranceremarks').val('');
  $('#insuranceattachments').val('');
  $('#InsurancefilePreview').html('');
  insuranceselecteddocFiles= [];
  editInsuranceTarget = null;
  insuranceindex = null;
  $('#insuranceformTitle').text('Add Insurance Details');
}

$('#insuranceaddTimelineBtn').click(function () {

  editInsuranceTarget = null;
  
 resetInsuranceForm();
  $('#insuranceFormCard').removeClass('d-none');
  
});



$(document).on('click', '.editInsuranceTimeline', function () {

    let index = $(this).data('index');
    let item = insuranceHistory[index];

    $('#insuranceaddedinfo').val(item.added_info);
    $('#insurancenextDate').val(item.next_date);
    $('#insuranceDate').val(item.done_date);
    $('#insuranceremarks').val(item.remarks);

    // Reset new files
    fileStore['insurance'] = [];

    editInsuranceTarget = index;
    $('#saveInsurance').data('index', index);

    renderFilePreview('insurance', 'InsurancefilePreview', insuranceHistory, index);

    $('#insuranceformTitle').text('Save Insurance Details');
    $('#insuranceFormCard').removeClass('d-none');
   let modalBody = $('#vehicleDetailsModal .modal-body');

    setTimeout(() => {
        modalBody.animate({
            scrollTop: $('#insuranceFormCard').position().top
        }, 400);
    }, 100);
});
$('#insuranceattachments').on('change', function (e) {

    let newFiles = Array.from(e.target.files);

    if (!fileStore['insurance']) {
        fileStore['insurance'] = [];
    }

    // Append new files instead of replacing
    newFiles.forEach(file => {
        fileStore['insurance'].push(file);
    });

    // Clear input so same file can be reselected if needed
    $(this).val('');

    // Re-render preview with ALL stored files
    renderFilePreview('insurance', 'InsurancefilePreview', insuranceHistory, editInsuranceTarget);
});
 
$('#saveInsurance').on('click', function () {

   
    toggleSaveLoaderByModule('insurance', true);

    uploadModuleFiles('insurance', function (uploadedFiles) {

        let existingDocs = [];

        if (editInsuranceTarget !== null &&
            insuranceHistory[editInsuranceTarget].documents) {

            existingDocs = insuranceHistory[editInsuranceTarget].documents
                .filter(doc => !doc.isDeleted);
        }

        let newDocs = uploadedFiles.map(file => ({
            name: file.name,
            url: file.path || file.url,
            isNew: false
        }));

        let finalDocs = [...existingDocs, ...newDocs];

        let node = {
            added_info: $('#insuranceaddedinfo').val(),
            next_date: $('#insurancenextDate').val(),
            done_date: $('#insuranceDate').val(),
            remarks: $('#insuranceremarks').val(),
            documents: finalDocs
        };

        if (editInsuranceTarget !== null) {
            insuranceHistory[editInsuranceTarget] = {
                ...insuranceHistory[editInsuranceTarget],
                ...node
            };
        } else {
            insuranceHistory.push(node);
        }

        renderInsuranceTimeline(insuranceHistory);

        saveInsuranceToDB(function () {
            fileStore['insurance'] = [];
            editInsuranceTarget = null;

             toggleSaveLoaderByModule('insurance', false);
        });

    });
});
function saveInsuranceToDB(callback = null,actionOverride = null) {

    let formData = new FormData();

   let action_cate = actionOverride 
        ? actionOverride 
        : (editInsuranceTarget !== null ? 'edit' : 'add');
    

    let nextDates = insuranceHistory
        .map(item => item.next_date)
        .filter(date => date); 

    let next_insurance_date = null;

     let today = new Date();
        today.setHours(0,0,0,0); // normalize
        
        let futureDates = nextDates.filter(date => {
            let d = new Date(date);
            d.setHours(0,0,0,0);
            return d >= today; // only today or future
        });
        
        if (futureDates.length > 0) {
            next_insurance_date = futureDates.reduce((nearest, current) => {
                return new Date(current) < new Date(nearest) ? current : nearest;
            });
        }
   
   
    let payload = {
        action: 'insurance',
        action_cate: action_cate,
        editIndex: editInsuranceTarget !== null ? editInsuranceTarget : null,
        next_insurance_date: next_insurance_date,
        insuranceHistory: insuranceHistory,
        vehicleId:$('#hid_vehicle_id_info_modal').val()
    };

    formData.append('payload', JSON.stringify(payload));

    $.ajax({
        url: '/VehicleStatusJsonController', // your endpoint
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {

    // If response is string → convert to JSON
    if (typeof res === "string") {
        res = JSON.parse(res);
    }

    
    if (res.status === true) {

        let rows = res.data?.rows_affected || 0;
        
         let successMessage = '';
        
            if (action_cate === 'delete') {
                successMessage = "Insurance details deleted successfully";
            } else if (editPassingTarget !== null) {
                successMessage = "Insurance details updated successfully";
            } else {
                successMessage = "Insurance details added successfully";
            }
            
          setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + successMessage,
                'click'
            );
        
       setTimeout(function () {

            $('#dropdownContent')
                .appendTo('body')   
                .css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    zIndex: 9999999
                });
        
        }, 0);
         
      if (callback) callback();
        resetInsuranceForm();
       $('#insuranceFormCard').addClass('d-none');


    } else {
     toggleSaveLoaderByModule('insurance', false);
        alert(res.message || "Something went wrong");
    }
},
        error: function (err) {
            console.error("SAVE ERROR:", err);
            toggleSaveLoaderByModule('insurance', false);
            alert('Error saving data');
        }
    });
}


let deleteInsuranceIndex = null;
$(document).on('click', '.deleteInsuranceTimeline', function () {

    let index = $(this).data('index');

    if (index === undefined) {
        console.warn("Invalid index for delete");
        return;
    }

    deleteInsuranceIndex = index; // ✅ store globally

    SaNDSAlert(
        'Are you sure you want to delete this entry?',
        'deleteInsuranceTimeline',
        'danger',
        '#C70039',
        'Yes, I am sure'
    );
   
     // ✅ Fix layering AFTER render
    setTimeout(function () {
        $('#popupOverlay').css({
            zIndex: 999998,
            position: 'fixed'
        });

        $('#popupContainer').css({
            zIndex: 999999,
            position: 'fixed'
        });

    }, 0);
    
});

function deleteInsuranceTimeline() {

    if (deleteInsuranceIndex === null || deleteInsuranceIndex === undefined) {
        console.warn("No index set for deletion");
        return;
    }

    insuranceHistory.splice(deleteInsuranceIndex, 1);

    // Reset index
    deleteInsuranceIndex = null;

    renderInsuranceTimeline(insuranceHistory);

    saveInsuranceToDB(null, 'delete');
}


$('#closeFormInsurance').click(function () {
    resetInsuranceForm();
    $('#insuranceFormCard').addClass('d-none');
  
});


// Maintenance Module
 
 
 let editMaintenanceTarget = null;

function resetMaintenanceForm() {
  $('#maintenancenextDate').val('');
  $('#maintenanceDate').val('');
  $('#maintenanceaddedinfo').val('');
  $('#maintenanceremarks').val('');
  $('#maintenanceattachments').val('');
  $('#MaintenancefilePreview').html('');
  maintenanceselecteddocFiles= [];
  editMaintenanceTarget = null;
  maintenanceindex = null;
  $('#maintenanceformTitle').text('Add Maintenance Details');
}

$('#maintenanceaddTimelineBtn').click(function () {

  editMaintenanceTarget = null;
  
 resetMaintenanceForm();
  $('#maintenanceFormCard').removeClass('d-none');
  
});



$(document).on('click', '.editMaintenanceTimeline', function () {

    let index = $(this).data('index');
    let item = maintenanceHistory[index];

    $('#maintenanceaddedinfo').val(item.added_info);
    $('#maintenancenextDate').val(item.next_date);
    $('#maintenanceDate').val(item.done_date);
    $('#maintenanceremarks').val(item.remarks);

    // Reset new files
    fileStore['maintenance'] = [];

    editMaintenanceTarget = index;
    $('#saveMaintenance').data('index', index);

    renderFilePreview('maintenance', 'MaintenancefilePreview', maintenanceHistory, index);

    $('#maintenanceformTitle').text('Save Maintenance Details');
    $('#maintenanceFormCard').removeClass('d-none');
   let modalBody = $('#vehicleDetailsModal .modal-body');

    setTimeout(() => {
        modalBody.animate({
            scrollTop: $('#maintenanceFormCard').position().top
        }, 400);
    }, 100);
});
$('#maintenanceattachments').on('change', function (e) {

    let newFiles = Array.from(e.target.files);

    if (!fileStore['maintenance']) {
        fileStore['maintenance'] = [];
    }

    // Append new files instead of replacing
    newFiles.forEach(file => {
        fileStore['maintenance'].push(file);
    });

    // Clear input so same file can be reselected if needed
    $(this).val('');

    // Re-render preview with ALL stored files
    renderFilePreview('maintenance', 'MaintenancefilePreview', maintenanceHistory, editMaintenanceTarget);
});
 
$('#saveMaintenance').on('click', function () {

   
    toggleSaveLoaderByModule('maintenance', true);

    uploadModuleFiles('maintenance', function (uploadedFiles) {

        let existingDocs = [];

        if (editMaintenanceTarget !== null &&
            maintenanceHistory[editMaintenanceTarget].documents) {

            existingDocs = maintenanceHistory[editMaintenanceTarget].documents
                .filter(doc => !doc.isDeleted);
        }

        let newDocs = uploadedFiles.map(file => ({
            name: file.name,
            url: file.path || file.url,
            isNew: false
        }));

        let finalDocs = [...existingDocs, ...newDocs];

        let node = {
            added_info: $('#maintenanceaddedinfo').val(),
            next_date: $('#maintenancenextDate').val(),
            done_date: $('#maintenanceDate').val(),
            remarks: $('#maintenanceremarks').val(),
            documents: finalDocs
        };

        if (editMaintenanceTarget !== null) {
            maintenanceHistory[editMaintenanceTarget] = {
                ...maintenanceHistory[editMaintenanceTarget],
                ...node
            };
        } else {
            maintenanceHistory.push(node);
        }

        renderMaintenanceTimeline(maintenanceHistory);

        saveMaintenanceToDB(function () {
            fileStore['maintenance'] = [];
            editMaintenanceTarget = null;

             toggleSaveLoaderByModule('maintenance', false);
        });

    });
});
function saveMaintenanceToDB(callback = null,actionOverride = null) {

    let formData = new FormData();

   let action_cate = actionOverride 
        ? actionOverride 
        : (editMaintenanceTarget !== null ? 'edit' : 'add');
    

    let nextDates = maintenanceHistory
        .map(item => item.next_date)
        .filter(date => date); 

    let next_maintenance_date = null;

     let today = new Date();
        today.setHours(0,0,0,0); // normalize
        
        let futureDates = nextDates.filter(date => {
            let d = new Date(date);
            d.setHours(0,0,0,0);
            return d >= today; // only today or future
        });
        
        if (futureDates.length > 0) {
            next_maintenance_date = futureDates.reduce((nearest, current) => {
                return new Date(current) < new Date(nearest) ? current : nearest;
            });
        }
   
   
    let payload = {
        action: 'maintenance',
        action_cate: action_cate,
        editIndex: editMaintenanceTarget !== null ? editMaintenanceTarget : null,
        next_maintenance_date: next_maintenance_date,
        maintenanceHistory: maintenanceHistory,
        vehicleId:$('#hid_vehicle_id_info_modal').val()
    };

    formData.append('payload', JSON.stringify(payload));

    $.ajax({
        url: '/VehicleStatusJsonController', // your endpoint
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {

    // If response is string → convert to JSON
    if (typeof res === "string") {
        res = JSON.parse(res);
    }

    
    if (res.status === true) {

        let rows = res.data?.rows_affected || 0;
        
         let successMessage = '';
        
            if (action_cate === 'delete') {
                successMessage = "Maintenance details deleted successfully";
            } else if (editMaintenanceTarget !== null) {
                successMessage = "Maintenance details updated successfully";
            } else {
                successMessage = "Maintenance details added successfully";
            }
            
          setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + successMessage,
                'click'
            );
        
       setTimeout(function () {

            $('#dropdownContent')
                .appendTo('body')   
                .css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    zIndex: 9999999
                });
        
        }, 0);
         
      if (callback) callback();
        resetMaintenanceForm();
       $('#maintenanceFormCard').addClass('d-none');


    } else {
     toggleSaveLoaderByModule('maintenance', false);
        alert(res.message || "Something went wrong");
    }
},
        error: function (err) {
            console.error("SAVE ERROR:", err);
            toggleSaveLoaderByModule('maintenance', false);
            alert('Error saving data');
        }
    });
}


let deleteMaintenanceIndex = null;
$(document).on('click', '.deleteMaintenanceTimeline', function () {

    let index = $(this).data('index');

    if (index === undefined) {
        console.warn("Invalid index for delete");
        return;
    }

    deleteMaintenanceIndex = index; // ✅ store globally

    SaNDSAlert(
        'Are you sure you want to delete this entry?',
        'deleteMaintenanceTimeline',
        'danger',
        '#C70039',
        'Yes, I am sure'
    );
   
     // ✅ Fix layering AFTER render
    setTimeout(function () {
        $('#popupOverlay').css({
            zIndex: 999998,
            position: 'fixed'
        });

        $('#popupContainer').css({
            zIndex: 999999,
            position: 'fixed'
        });

    }, 0);
    
});

function deleteMaintenanceTimeline() {

    if (deleteMaintenanceIndex === null || deleteMaintenanceIndex === undefined) {
        console.warn("No index set for deletion");
        return;
    }

    maintenanceHistory.splice(deleteMaintenanceIndex, 1);

    // Reset index
    deleteMaintenanceIndex = null;

    renderMaintenanceTimeline(maintenanceHistory);

    saveMaintenanceToDB(null, 'delete');
}


$('#closeFormMaintenance').click(function () {
    resetMaintenanceForm();
    $('#maintenanceFormCard').addClass('d-none');
  
});

$(document).on('click', '#proceedSelectedVehicles', function () {
    
    
    let serviceType = $('#select_service_type').val();

    if (!serviceType) {
         setupDropdown('dropdownContent', 'error', svgError + "Please select service type", 'click');
                return false;
       
    }

    else if (selectedVehicles.length === 0) {
         setupDropdown('dropdownContent', 'error', svgError + "Please select at least one vehicle", 'click');
                return false;
       
    }

    else
    {
        switch(serviceType)
        {
            case 'Book Vehicles':
                 renderSelectedVehiclesInModal(selectedVehicles);
                 $('#vehicleBookingModal').modal('show');
            break;
            case 'Create Contract':
            break;
        }
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


$('#searchQuotation').on('keyup', function () {

    let term = $(this).val();

    if (term.length < 2) {
        $('#quotationList').html('<div class="text-muted small">Type to search...</div>');
        return;
    }

    $.ajax({
        url: '/AutoLoadQuotationNo',
        type: 'GET',
        dataType: 'json',
        data: { term: term },
        success: function (data) {

            let html = '';

            if (data.length === 0) {
                html = '<div class="text-muted small">No quotations found</div>';
            } else {

                data.forEach(item => {

                    html += `
                        <div class="quotation-item p-2 border-bottom d-flex justify-content-between align-items-center"
                             data-id="${item.id}"
                             data-no="${item.quotation_no}"
                             data-client="${item.customer_name}"
                             style="cursor:pointer;">
                    
                            <div>
                                <div class="fw-semibold">${item.quotation_no}</div>
                                <div class="text-muted small">${item.customer_name}</div>
                            </div>
                    
                    
                        </div>
                    `;
                });

            }

            $('#quotationList').html(html);
        }
    });

});

$(document).on('click', '.quotation-item', function () {

    let id = $(this).data('id');

    // Highlight selected
    $('.quotation-item').removeClass('bg-light');
    $(this).addClass('bg-light');

    // Fetch full quotation details
    $.ajax({
        url: '/GetQuotationDetails',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function (res) {

            fillQuotationData(res);

        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });

});
// $(document).on('click', '.quotation-item', function () {

//     let data = {
//         id: $(this).data('id'),
//         quotation_no: $(this).data('no'),
//         customer_name: $(this).data('client')
//     };

//     // Highlight selected
//     $('.quotation-item').removeClass('bg-light');
//     $(this).addClass('bg-light');

//     // Fill preview
//     fillQuotationData(data);

// });


function fillQuotationData(response) {

    
    let datares = response[0];
    
   // let itemsres = JSON.parse(datares.items);
    let itemsres = datares.items;

    $('#customerName').val(datares.customer_name);
    $('#customerPhone').val(datares.customer_phone);
    $('#customerEmail').val(datares.customer_email);
    $('#customerAddress').val(datares.customer_address);
    $('#customerAttention').val(datares.attention);
    

    // QUOTATION REF
    $('#quotationRef').val(datares.quotation_no);

    // PREVIEW PANEL
    let html = '';

   html += `
            <div class="mb-2">
                <h5 class="mb-2">Quotation Details</h5>
            
                <div class="d-flex gap-4">
                    <p class="mb-1"><strong>Quotation No:</strong> ${datares.quotation_no}</p>
                    <p class="mb-1"><strong>Date:</strong> ${datares.qtnformatted_date}</p>
                </div>
            
                <div>
                    <p class="mb-1"><strong>Client:</strong> ${datares.customer_name}</p>
                </div>
            
            </div>
            `;

    // ITEMS TABLE
    let items_data = JSON.parse(itemsres);

  html += `
<table class="table table-bordered" style="table-layout: fixed; width: 100%;">
    <thead>
        <tr>
            <th style="padding: 4px 8px; line-height: 1.2;">Quotation Items</th>
        </tr>
    </thead>
    <tbody>
`;

items_data.forEach(item => {

    
    let from = item.period_from;
    let to = item.period_to;

   html += `
        <tr class="quotation-row" 
            data-from="${item.period_from}" 
            data-to="${item.period_to}" 
            data-rate="${item.rate_type_id}" 
            data-service="${item.service_id}">
        
            <td>
                <div class="p-2">
        
                    <div class="fw-semibold">
                        ${item.item_name} (${item.qty} Nos)
                    </div>
        
                    <div class="text-muted">
                        ${item.service_name}
                    </div>
        
                    <div class="small mt-1 d-flex gap-3">
                        <div><strong>From:</strong> ${from}</div>
                        <div><strong>To:</strong> ${to}</div>
                    </div>
        
                    <div class="small text-muted mt-1">
                        Duration: ${item.duration} | ${item.rate_type_name}
                    </div>
        
                </div>
            </td>
        </tr>
        `;
});

html += `
    </tbody>
</table>
`;

    $('#quotationPreview').html(html);
}


$(document).on('click', '.quotation-row', function () {

    let from = $(this).data('from');
    let to = $(this).data('to');
    let rate = $(this).data('rate');
    let service = $(this).data('service');

    
    $('.from_datetime').val(from);
    $('.to_datetime').val(to);

    
    $('.rate_type').val(rate);
    $('.service').val(service);

    
    $('.quotation-row').removeClass('table-active');
    $(this).addClass('table-active');
});
});
</script>

</body>

</html>