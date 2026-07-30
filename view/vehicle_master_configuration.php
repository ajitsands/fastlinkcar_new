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
   
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">


    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/spinkit/spinkit.css" />
    
    
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/dropzone/dropzone.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/flatpickr/flatpickr.css" />

     <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    <style>
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
        
        
        .btn-icon.btn-fab {
            block-size: calc(1.2502625rem + calc(1px * 2));
            inline-size: calc(1.2502625rem + calc(1px * 2));
        }
        
        
        /* Make modal bigger without stretching image */
                    
            #cropModal .modal-dialog {
                max-width: 80vw; /* increase from 50vw → 80vw */
                margin: 1rem auto;
            }
            
            #cropModal .modal-body {
                max-height: 90vh; /* increase height */
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0.5rem; /* reduce padding for more space */
            }
            
            #cropImage {
                width: 100%;        /* take full width */
                max-height: 85vh;   /* increase height */
                display: block;
            }

       #imagePreview {
          display: flex;
          flex-wrap: wrap;
          gap: 8px;
        }
        
        #imagePreview li {
          width: 50px;
          height: 50px;
          position: relative;
          flex: 0 0 auto;
        }
        
        #imagePreview img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          border-radius: 8px;
        }
        
        /* Remove button */
        #imagePreview .remove-img {
          position: absolute;
          top: -6px;
          right: -6px;
          width: 18px;
          height: 18px;
          font-size: 12px;
          padding: 0;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
        }
        #imageModal {
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(0, 0, 0, 0.85);
          justify-content: center;
          align-items: center;
          padding: 15px;
          box-sizing: border-box;
          z-index: 9999;
        }
        #imageModal img {
          max-width: 90vw;
          max-height: 90vh;
        }
        #closeModal {
          position: absolute;
          top: 15px;
          right: 20px;
          color: white;
          font-size: 28px;
          cursor: pointer;
          z-index: 10000;
        }
        #rentalCarImages li {
          width: 60px;
          height: 60px;
          overflow: hidden;
          border-radius: 50%; /* keep avatar circle */
          display: flex;
          align-items: center;
          justify-content: center;
        }
        
        #rentalCarImages img {
          width: 100%;
          height: 100%;
          object-fit: cover;   /* Ã¢Å“â€¦ fills properly */
          border-radius: 50%;
        }
       .customdataTable tbody tr {
            cursor: pointer;
            outline: none !important;
        }
        
        /* Remove all focus/active blue styles */
        .customdataTable tbody tr:focus,
        .customdataTable tbody tr:active,
        .customdataTable tbody tr:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            background-color: inherit !important;
        }
        
        /* Force red selection */
        .customdataTable tbody tr.selected,
        .customdataTable tbody tr.selected td {
            background-color: red !important;
            color: white !important;
        }
        
        /* Prevent hover from interfering */
        .customdataTable tbody tr:hover {
            background-color: inherit !important;
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
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 55px !important">
                        
                        <?php include ROOT_PATH . '/view/templates/VehicleMasterConfiguration/VehicleMasterConfigurationBody.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleMasterConfiguration/crop_modal.php'; ?>
                        <?php include ROOT_PATH . '/view/templates/VehicleMasterConfiguration/image_preview_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleMasterConfiguration/pricingMasterModal.php'; ?>
                         
                        <!--/ Layout Demo -->
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
  
 <div id="dropdownContent" style="text-align:center;"></div>    
<!--Cropping image Before Upload Modal-->
<!-- Crop Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crop Vehicle Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="cropImage" src="" alt="Crop Image" style="max-width: 100%; display: block; margin: auto;">
      </div>
      <div class="modal-footer">
        <button id="cropAndUpload" class="btn btn-primary">Crop & Upload</button>
      </div>
    </div>
  </div>
</div>






    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-selects.js"></script>
    
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/quill.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/dropzone/dropzone.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/tagify/tagify.js"></script>
    
    <!--<script src="<?= $_ENV['BASE_URL'] ?>assets/js/app-ecommerce-product-add.js"></script>-->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/vehicles_add.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <!-- Page JS -->
    <script>

$(document).ready(function () {
    const baseUrl = window.location.origin;
    let cropper;
    let croppedBlob = null;
    $(document).on('click', '.preview-image', function () {

    let imageUrl = $(this).data('image');

    // Clear previous modal content
    $('#vehicleCarouselIndicators').html('');
    $('#vehicleCarouselInner').html('');

    // Indicator
    $('#vehicleCarouselIndicators').append(`
        <button type="button" data-bs-target="#modalCarouselControls" 
            data-bs-slide-to="0" class="active"></button>
    `);

    // Image
    $('#vehicleCarouselInner').append(`
        <div class="carousel-item active">
            <img src="${imageUrl}" 
                 class="d-block w-100"
                 style="max-height:400px; object-fit:contain;">
        </div>
    `);

    // Show modal
    $('#modalimages').modal('show');
});
$('#cropModal').on('shown.bs.modal', function () {

    cropper = new Cropper(document.getElementById('cropImage'));

}).on('hidden.bs.modal', function () {

    cropper.destroy();
    cropper = null;

});



function openCropperModal(file, previewTargetId) {

    let reader = new FileReader();

    reader.onload = function (event) {

        // set image in crop modal
        $('#cropImage').attr('src', event.target.result);

        // store preview target globally
        $('#cropImage').data('preview-target', previewTargetId);

        $('#cropModal').modal('show');
    };

    reader.readAsDataURL(file);
}

$('#cropBtn').click(function () {

    let canvas = cropper.getCroppedCanvas({
        aspectRatio: 1,
    viewMode: 1,
    autoCropArea: 0.8, // ðŸ‘ˆ increase this (default ~0.5)
    responsive: true
    });

    canvas.toBlob(function (blob) {

        croppedBlob = blob;

        let previewUrl = URL.createObjectURL(blob);
    let previewTarget = $('#cropImage').data('preview-target');
        $(previewTarget).html(`
            <li>
                <img src="${previewUrl}" 
                class="preview-image"
                data-image="${previewUrl}"
                     style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
            </li>
        `);

        $('#cropModal').modal('hide');
    });

});

// Category Master
$('#saveCategoryData').on('click', function (e) {
    e.preventDefault();
    if (!$('#categoryName').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide category name", 'click');
                return false;
        }
    if (!$('#categoryDescription').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide category description", 'click');
        return false;
    } 
    if (!$('#categoryStatus').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please select status", 'click');
        return false;
    } 
    let cate_id=  $('#categoryId').val();   
    let formData = new FormData();
    formData.append('id', $('#categoryId').val()); // empty = add
    formData.append('categoryName', $('#categoryName').val());
    formData.append('categoryDescription', $('#categoryDescription').val());
    formData.append('status', $('#categoryStatus').val());

     if (croppedBlob) {
        formData.append('categoryImage', croppedBlob, 'default.jpg');
    }

    formData.append('action', 'save_category');

    $.ajax({
        url: '/MasterConfigurationController',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            let data = JSON.parse(res);

            if (data.success) {
                setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess + (cate_id ? "Category updated successfully" : "Category added successfully"),
                        'click'
                    );
                load_category_list(); // reload table
                resetCategoryForm();
            }
        }
    });
});
function resetCategoryForm() {
    $('#categoryId').val('');
    $('#categoryName').val('');
    $('#categoryDescription').val('');
     $('#categoryDescription').val('');
    $('#categoryImages').val('');
    $('#categoryimagePreview').html('');
    $('#categoryStatus').val('').trigger('change');
    $('#saveCategoryData').text('Save');

    croppedBlob = null; // ðŸ”¥ reset cropped image
}

$('#categoryImages').on('change', function () {
 
    let file = this.files[0];
    if (!file) return;

    // âœ… Reset any previous preview/blob
    croppedBlob = null;

    // âœ… Only images
    if (!file.type.startsWith('image/')) {
        setupDropdown('dropdownContent', 'error', svgError + "Only images allowed", 'click');
        $(this).val('');
        return;
    }

    // âœ… Optional: limit file size (e.g. 2MB)
    let maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        setupDropdown('dropdownContent', 'error', svgError + "Image must be less than 2MB", 'click');
        $(this).val('');
        return;
    }

    // âœ… Open cropper
    openCropperModal(file, '#categoryimagePreview');

});


 load_category_list();
 function load_category_list() {
  // Destroy existing table
  if ($.fn.DataTable.isDataTable('#vehicleCategoryTable')) {
    $('#vehicleCategoryTable').DataTable().destroy();
    $('#vehicleCategoryTable tbody').empty();
  }

  // Initialize DataTable
  let categorytable = $('#vehicleCategoryTable').DataTable({
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    info: true,
    ordering: false,
    searching: true,
    dom: '<"row"<"col-12">><"row"<"col-12"tr>><"row"<"col-6"i><"col-6"p>>',

    ajax: {
        url: '/MasterConfigurationController',
        type: 'POST',
        data: {
            action: 'get_categories'
        },
       dataSrc: function (json) {
        return json.data.data; // IMPORTANT FIX
    }
    },

    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { data: 'category_name' },
        {
            data: 'category_status',
            render: function (data, type, row) {
        
                if (data === 'Active') {
                    return `<span class="badge bg-success">Active</span>`;
                } else {
                    return `<span class="badge bg-default">Inactive</span>`;
                }
            }
        }
    ]
});

  $('#vehicleCategorySearch').off('keyup').on('keyup', function() {
    categorytable.search(this.value).draw();
  });
}

$('#vehicleCategoryTable tbody').on('click', 'tr', function () {

    let categorytable = $('#vehicleCategoryTable').DataTable();

    categorytable.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');

    this.blur();
    resetCategoryForm();
    let data = categorytable.row(this).data();
    
    loadCategoryForEdit(data); 
});


function loadCategoryForEdit(data) {

   $('#saveCategoryData').text('Update Category');
    $('#categoryStatus').val(data.category_status).trigger('change');
    $('#categoryId').val(data.ids);
    $('#categoryName').val(data.category_name);
    $('#categoryDescription').val(data.category_description);
     let imageUrl = 'httpdocs/images/vehicle_category_images/' + data.category_image;
        $('#categoryimagePreview').html(`
            <li>
                <img src="${imageUrl}" 
                class="preview-image"
                data-image="${imageUrl}"
                     style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
            </li>
        `);
    
   
}

$('#btn_category_cancel').click(function () {
    resetCategoryForm();
});


// Brand Master
$('#saveBrandData').on('click', function (e) {
    e.preventDefault();
    if (!$('#brandName').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide brand name", 'click');
                return false;
        }
   
    if (!$('#brandStatus').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please select status", 'click');
        return false;
    } 
    let brand_id=  $('#brandId').val();   
    let formData = new FormData();
    formData.append('brand_id', $('#brandId').val()); // empty = add
    formData.append('brandName', $('#brandName').val());
    formData.append('brandDescription', $('#brandDescription').val());
    formData.append('brand_status', $('#brandStatus').val());

     if (croppedBlob) {
        formData.append('brandImage', croppedBlob, 'default.jpg');
    }

    formData.append('action', 'save_brand');

    $.ajax({
        url: '/MasterConfigurationController',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            let data = JSON.parse(res);

            if (data.success) {
                setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess + (brand_id ? "Brand updated successfully" : "Brand added successfully"),
                        'click'
                    );
                load_brand_list(); // reload table
                resetBrandForm();
            }
        }
    });
});
function resetBrandForm() {
    $('#brandId').val('');
    $('#brandName').val('');
    $('#brandDescription').val('');
    $('#brandImages').val('');
    $('#brandimagePreview').html('');
    $('#brandStatus').val('').trigger('change');
    $('#saveBrandData').text('Save');

    croppedBlob = null; // ðŸ”¥ reset cropped image
}

$('#brandImages').on('change', function () {
 
    let file = this.files[0];
    if (!file) return;

    // âœ… Reset any previous preview/blob
    croppedBlob = null;

    // âœ… Only images
    if (!file.type.startsWith('image/')) {
        setupDropdown('dropdownContent', 'error', svgError + "Only images allowed", 'click');
        $(this).val('');
        return;
    }

    // âœ… Optional: limit file size (e.g. 2MB)
    let maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        setupDropdown('dropdownContent', 'error', svgError + "Image must be less than 2MB", 'click');
        $(this).val('');
        return;
    }

    // âœ… Open cropper
    openCropperModal(file, '#brandimagePreview');

});


 load_brand_list();
 function load_brand_list() {
  // Destroy existing table
  if ($.fn.DataTable.isDataTable('#vehicleBrandTable')) {
    $('#vehicleBrandTable').DataTable().destroy();
    $('#vehicleBrandTable tbody').empty();
  }

  // Initialize DataTable
  let brandtable = $('#vehicleBrandTable').DataTable({
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    info: true,
    ordering: false,
    searching: true,
    dom: '<"row"<"col-12">><"row"<"col-12"tr>><"row"<"col-6"i><"col-6"p>>',

    ajax: {
        url: '/MasterConfigurationController',
        type: 'POST',
        data: {
            action: 'get_brand'
        },
       dataSrc: function (json) {
        return json.data.data; // IMPORTANT FIX
    }
    },

    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { data: 'brand_name' },
        {
            data: 'brand_status',
            render: function (data, type, row) {
        
                if (data === 'Active') {
                    return `<span class="badge bg-success">Active</span>`;
                } else {
                    return `<span class="badge bg-default">Inactive</span>`;
                }
            }
        }
    ]
});

  $('#vehicleBrandSearch').off('keyup').on('keyup', function() {
    brandtable.search(this.value).draw();
  });
}

$('#vehicleBrandTable tbody').on('click', 'tr', function () {

    let brandtable = $('#vehicleBrandTable').DataTable();

    brandtable.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');

    this.blur();
    resetBrandForm();
    let data = brandtable.row(this).data();
    
    loadBrandForEdit(data); 
});


function loadBrandForEdit(data) {

   $('#saveBrandData').text('Update Brand');
    $('#brandStatus').val(data.brand_status).trigger('change');
    $('#brandId').val(data.ids);
    $('#brandName').val(data.brand_name);
    $('#brandDescription').val(data.brand_description);
     let imageUrl = 'httpdocs/images/vehicle_brand_images/' + data.brand_image;
        $('#brandimagePreview').html(`
            <li>
                <img src="${imageUrl}" 
                class="preview-image"
                data-image="${imageUrl}"
                     style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
            </li>
        `);
    
   
}

$('#btn_brand_cancel').click(function () {
    resetBrandForm();
});

// Vehicle Model
    $('#vehicleCategory').select2({
        placeholder: "Select Model",
        allowClear: true,
        width: '100%'
    });
    
    categoryloadDropdown();

    function categoryloadDropdown() {
       $('#dropdownContainerCategory').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading category...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadCategorySelect',
            type: 'GET',
            success: function (response) {
                $('#dropdownContainerCategory').html(response);

                $('#vehicleCategory').select2({
                    placeholder: "Select Category",
                    allowClear: true,
                    width: '100%'
                });
            },
        error: function (xhr, status, error) {
            $('#dropdownContainerCategory').html(`
            <div class="text-center p-3">
                <div class="mt-2">Error loading data</div>
            </div>`);
            
            console.error(error);
        }
        });
    }
    
    $('#vehicleBrand').select2({
        placeholder: "Select Brand",
        allowClear: true,
        width: '100%'
    });
    
    brandloadDropdown();

    function brandloadDropdown() {
       $('#dropdownContainerBrand').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading brand...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadBrandSelect',
            type: 'GET',
            success: function (response) {
                $('#dropdownContainerBrand').html(response);

                $('#vehicleBrand').select2({
                    placeholder: "Select Brand",
                    allowClear: true,
                    width: '100%'
                });
            },
        error: function (xhr, status, error) {
            $('#dropdownContainerBrand').html(`
            <div class="text-center p-3">
                <div class="mt-2">Error loading data</div>
            </div>`);
            
            console.error(error);
        }
        });
    }
$('#saveModelData').on('click', function (e) {
    e.preventDefault();
    if (!$('#vehicleCategory').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please select category", 'click');
                return false;
        }
   
   if (!$('#vehicleBrand').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please select brand", 'click');
                return false;
        }
   
    if (!$('#modelName').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide model name", 'click');
                return false;
        }
   
    if (!$('#modelStatus').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please select status", 'click');
        return false;
    } 
    let model_id=  $('#modelId').val();   
    let formData = new FormData();
    formData.append('model_id', $('#modelId').val()); // empty = add
    formData.append('modelName', $('#modelName').val());
    formData.append('modelDescription', $('#modelDescription').val());
    formData.append('model_status', $('#modelStatus').val());
    formData.append('category_id', $('#vehicleCategory').val());
    formData.append('brand_id', $('#vehicleBrand').val());

     if (croppedBlob) {
        formData.append('modelImage', croppedBlob, 'default.jpg');
    }

    formData.append('action', 'save_model');

    $.ajax({
        url: '/MasterConfigurationController',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            let data = JSON.parse(res);

            if (data.success) {
                setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess + (model_id ? "Model updated successfully" : "Model added successfully"),
                        'click'
                    );
                load_model_list(); // reload table
                resetModelForm();
            }
        }
    });
});
function resetModelForm() {
    $('#modelId').val('');
    $('#modelName').val('');
    $('#modelDescription').val('');
    $('#modelImages').val('');
    $('#modelimagePreview').html('');
    $('#vehicleCategory').val('0').trigger('change');
    $('#vehicleBrand').val('0').trigger('change');
    $('#modelStatus').val('').trigger('change');
    $('#saveModelData').text('Save');

    croppedBlob = null; // ðŸ”¥ reset cropped image
}

$('#modelImages').on('change', function () {
 
    let file = this.files[0];
    if (!file) return;

    // âœ… Reset any previous preview/blob
    croppedBlob = null;

    // âœ… Only images
    if (!file.type.startsWith('image/')) {
        setupDropdown('dropdownContent', 'error', svgError + "Only images allowed", 'click');
        $(this).val('');
        return;
    }

    // âœ… Optional: limit file size (e.g. 2MB)
    let maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        setupDropdown('dropdownContent', 'error', svgError + "Image must be less than 2MB", 'click');
        $(this).val('');
        return;
    }

    // âœ… Open cropper
    openCropperModal(file, '#modelimagePreview');

});


 load_model_list();
 function load_model_list() {
  // Destroy existing table
  if ($.fn.DataTable.isDataTable('#vehicleModelTable')) {
    $('#vehicleModelTable').DataTable().destroy();
    $('#vehicleModelTable tbody').empty();
  }

  // Initialize DataTable
  let modeltable = $('#vehicleModelTable').DataTable({
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    info: true,
    ordering: false,
    searching: true,
    dom: '<"row"<"col-12">><"row"<"col-12"tr>><"row"<"col-6"i><"col-6"p>>',

    ajax: {
        url: '/MasterConfigurationController',
        type: 'POST',
        data: {
            action: 'get_model'
        },
       dataSrc: function (json) {
        return json.data.data; // IMPORTANT FIX
    }
    },

    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { data: 'modal_name' },
        {
            data: 'model_status',
            render: function (data, type, row) {
        
                if (data === 'Active') {
                    return `<span class="badge bg-success">Active</span>`;
                } else {
                    return `<span class="badge bg-default">Inactive</span>`;
                }
            }
        }
    ]
});

  $('#vehicleModelSearch').off('keyup').on('keyup', function() {
    modeltable.search(this.value).draw();
  });
}

$('#vehicleModelTable tbody').on('click', 'tr', function () {

    let modeltable = $('#vehicleModelTable').DataTable();

   modeltable.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');

    this.blur();
    resetModelForm();
    let data = modeltable.row(this).data();
    
    loadModelForEdit(data); 
});


function loadModelForEdit(data) {

   $('#saveModelData').text('Update Model');
    $('#modelStatus').val(data.model_status).trigger('change');
    $('#vehicleCategory').val(data.category_id).trigger('change');
    $('#vehicleBrand').val(data.brand_id).trigger('change');
    $('#modelId').val(data.ids);
    $('#modelName').val(data.modal_name);
    $('#modelDescription').val(data.model_description);
     let imageUrl = 'httpdocs/images/vehicle_model_images/' + data.vehicle_modal_pic;
        $('#modelimagePreview').html(`
            <li>
                <img src="${imageUrl}" 
                class="preview-image"
                data-image="${imageUrl}"
                     style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
            </li>
        `);
    
   
}

$('#btn_model_cancel').click(function () {
    resetModelForm();
});


//Pricing

$('#addpriceMasterBtn').click(function () {
   
    $('#pricemasterModal').modal('show');
});

$('#addToTablePrice').on('click', function (e) {
    e.preventDefault();
    
   
    if (!$('#newPriceMasterItem').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide price item", 'click');
                return false;
        }
   
     
    let formData = new FormData();
    formData.append('priceItem', $('#newPriceMasterItem').val()); 

   
    formData.append('action', 'add_price_master');

    $.ajax({
        url: '/MasterConfigurationController',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            let data = JSON.parse(res);

            if (data.success) {
                $('#newPriceMasterItem').val('');
                 $('#pricemasterModal').modal('hide');
                setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess +  "Item added successfully" ,
                        'click'
                    );
                
            }
        }
    });
});
 load_model_price_list();
 function load_model_price_list() {
  // Destroy existing table
  if ($.fn.DataTable.isDataTable('#vehicleModelPricingTable')) {
    $('#vehicleModelPricingTable').DataTable().destroy();
    $('#vehicleModelPricingTable tbody').empty();
  }

  // Initialize DataTable
  let modelpricetable = $('#vehicleModelPricingTable').DataTable({
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    info: true,
    ordering: false,
    searching: true,
    dom: '<"row"<"col-12">><"row"<"col-12"tr>><"row"<"col-6"i><"col-6"p>>',

    ajax: {
        url: '/MasterConfigurationController',
        type: 'POST',
        data: {
            action: 'get_model_price'
        },
       dataSrc: function (json) {
        return json.data.data; // IMPORTANT FIX
    }
    },

    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { data: 'modal_name' },
        {
            data: 'model_status',
            render: function (data, type, row) {
        
                if (data === 'Active') {
                    return `<span class="badge bg-success">Active</span>`;
                } else {
                    return `<span class="badge bg-default">Inactive</span>`;
                }
            }
        }
    ]
});

  $('#vehiclePricingSearch').off('keyup').on('keyup', function() {
    modelpricetable.search(this.value).draw();
  });
}
$('#pricingmodelId').val('');
$('#vehicleModelPricingTable tbody').on('click', 'tr', function () {

    let modelpricetable = $('#vehicleModelPricingTable').DataTable();

   modelpricetable.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');

    this.blur();
   
    let data = modelpricetable.row(this).data();
    $('#pricingmodelId').val(data.ids);
    loadPricing(data.ids); 
});
function loadPricing(modelId) {

    $.post('/LoadPriceModelTable', { modelId: modelId }, function (res) {

        let data = JSON.parse(res);
        let html = '';
        let i = 1;

        data.forEach(row => {

            html += `
                <tr>
                    <td style="width:80%;">
                        ${row.item}
                        <input type="hidden" class="item_id" value="${row.id}">
                    </td>

                    <td style="width:20%;">
                        <input type="number" class="priceamount" style="width:100%; height:40px; border-radius: 6px; border: 1px solid #ccc;" value="${row.amount}">
                    </td>
                </tr>
            `;
        });

        $('#pricingTable tbody').html(html);
    });
}

$('#saveBtnPricing').click(function () {

    let data = [];

    $('#pricingTable tbody tr').each(function () {

        let id = $(this).find('.item_id').val();
        let item = $(this).find('td:eq(0)').text().trim();
        let amount = $(this).find('.priceamount').val();

        data.push({
            id: id,
            item: item,
            amount: amount 
        });
    });

    $.post('/MasterConfigurationController', {
        action:'UpdateModelPricing',
        model_id: $('#pricingmodelId').val(),
        items: JSON.stringify(data)
    }, function () {
        setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess +  "Price details updated successfully" ,
                        'click'
                    );
    });
});
});// Jquery Close

        
        
    </script>

</body>

</html>