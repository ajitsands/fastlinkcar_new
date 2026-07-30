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
            max-width: 50vw; /* almost full screen width */
            margin: 1.5rem auto; /* spacing from top/bottom */
        }
        
        #cropModal .modal-body {
            max-height: 80vh; /* maximum 80% of viewport height */
            overflow: hidden;   /* scroll if content is taller */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        
        /* Image inside modal */
        #cropImage {
            max-width: 99%;   /* fit inside modal width */
            max-height: 75vh; /* fit inside modal height */
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
          object-fit: cover;   /* ✅ fills properly */
          border-radius: 50%;
        }
       #vehicleTable tbody tr {
            cursor: pointer;
            outline: none !important;
        }
        
        /* Remove all focus/active blue styles */
        #vehicleTable tbody tr:focus,
        #vehicleTable tbody tr:active,
        #vehicleTable tbody tr:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            background-color: inherit !important;
        }
        
        /* Force red selection */
        #vehicleTable tbody tr.selected,
        #vehicleTable tbody tr.selected td {
            background-color: red !important;
            color: white !important;
        }
        
        /* Prevent hover from interfering */
        #vehicleTable tbody tr:hover {
            background-color: inherit !important;
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
                        
                        <?php include ROOT_PATH . '/view/templates/vehicles/vehicles_body.php'; ?>
                        <?php include ROOT_PATH . '/view/templates/vehicles/vehicle_images_modal.php'; ?>
                         
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
   let selectedVehicleData = null; // null = ADD mode, object = EDIT mode
    
    let bookingMaster = {
        vehicles: []
    };
function resetRentCarUploadProgress() {
    $('#uploadrentCarImageDocumentProgress')
        .css('width', '0%')
        .text('0%');

    $('#uploadrentCarImageDocumentStatus').html('');
    $('#rentCarImage_upload_status').html('');
}
 $(document).on('click', '.openAddRentalCarImageModal', function(e) {
    
            e.preventDefault();
            e.stopPropagation();
            resetRentCarUploadProgress();
            //$('#rentCarImage_upload_status').html('');
            const modalEl = document.getElementById('addRentalCarImageModal');

            setTimeout(() => {
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }, 300);
        });

            const validationsRentCarImage = [{
                    id: '#rentCarImageName',
                    msg: 'Please enter document name'
                },
                {
                    id: '#rentCarImage_document',
                    msg: 'Please select a file',
                    type: 'file'
                }
            ];
              function validateForm(displayErrorDiv, validateFor) {
                for (let v of validateFor) {
                    if (v.type === 'file') {
                        if (!$(v.id)[0].files.length) return showError(v.id, v.msg, displayErrorDiv);
                    } else {
                        if (!$(v.id).val()) return showError(v.id, v.msg, displayErrorDiv);
                    }
                }
                return true;
            }

            function showError(selector, message, displayErrorDiv) {
                $('#' + displayErrorDiv)
                    .html(`<span class="text-danger">${message}</span>`);
                $(selector).focus();
                return false;
            }
             function resizeImage(file, callback) {
                const reader = new FileReader();
                const img = new Image();

                reader.onload = e => img.src = e.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');

                    const MAX = 2000;
                    let w = img.width;
                    let h = img.height;

                    if (w > MAX || h > MAX) {
                        const ratio = Math.min(MAX / w, MAX / h);
                        w *= ratio;
                        h *= ratio;
                    }

                    canvas.width = w;
                    canvas.height = h;
                    canvas.getContext('2d').drawImage(img, 0, 0, w, h);

                    canvas.toBlob(blob => callback(blob), 'image/jpeg', 0.85);
                };

                reader.readAsDataURL(file);
            }
             function getDocumentPreview(fileUrl) {

                let extension = fileUrl.split('.').pop().toLowerCase();

                switch (extension) {
                    case 'pdf':
                        return '/assets/icons/pdf.png';

                    case 'doc':
                    case 'docx':
                        return '/assets/icons/word.png';

                    case 'xls':
                    case 'xlsx':
                        return '/assets/icons/excel.png';

                    case 'ppt':
                    case 'pptx':
                        return '/assets/icons/ppt.png';

                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                    case 'webp':
                        return fileUrl; // actual image

                    default:
                        return '/assets/icons/file.png';
                }
            }

    let carRequiredControls = {
        validationStatusId: 'rentCarImage_upload_status',
        validationFunctionName: validationsRentCarImage,
        fileInputId: '#rentCarImage_document',
        formId: 'addRentalCarDetails',
        folderName: 'rentedcars',
        documentTypeControlId: '#rentCarImageName',
        callFunction : uploadVehicleFiles
    };     
   $('#addrentCarImageButton').on('click', function (e) {
                
        let clickedButton = this.id;
    
        if (clickedButton === 'addrentCarImageButton') {
    
            addBookingAndUploadImagesFunction(carRequiredControls);
        }

    
    });
    

  function addBookingAndUploadImagesFunction(RequiredControlsNames){
                    
     if (!validateForm(RequiredControlsNames.validationStatusId, RequiredControlsNames.validationFunctionName)) return;

        const files = $(RequiredControlsNames.fileInputId)[0].files;
        if (!files.length) return;

        const form = document.getElementById(RequiredControlsNames.formId);
        const tempFormData = new FormData(form);

        tempFormData.append('foldername', RequiredControlsNames.folderName);
        tempFormData.append('documentType', $(RequiredControlsNames.documentTypeControlId).val());

        let processed = 0;

        Array.from(files).forEach((file) => {

            if (file.type.startsWith('image/')) {

                resizeImage(file, function (blob) {
                    tempFormData.append('files[]', blob, file.name);
                    processed++;
                    //if (processed === files.length) uploadDriverFiles(tempFormData);
                    if (processed === files.length) RequiredControlsNames.callFunction(tempFormData);
                    
                });

            } else {

                tempFormData.append('files[]', file);
                processed++;
                //if (processed === files.length) uploadDriverFiles(tempFormData);
                if (processed === files.length) RequiredControlsNames.callFunction(tempFormData);

            }

        });

    }
     function uploadVehicleFiles(tempFormData) {

                    $.ajax({
                        url: '/UploadDocumentsCompressed',
                        type: 'POST',
                        data: tempFormData,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            let xhr = new XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(e) {
                                if (e.lengthComputable) {
                                    let percent = Math.round((e.loaded / e.total) * 100);
                                    $('#uploadrentCarImageDocumentProgress')
                                        .css('width', percent + '%')
                                        .text(percent + '%');
                                }
                            }, false);
    
                            return xhr;
                        },
                        beforeSend: function () {
                            
                            $('#uploadrentCarImageDocumentProgress')
                            .css('width', '0%')
                            .text('0%');

                            $('#rentCarImage_upload_status').html('Uploading...');

                            $('#rentCarImage_loader_spinner').show();
                        },

                        success: function (res) {
                            $('#uploadrentCarImageDocumentProgress')
                            .css('width', '100%')
                            .text('100%');
                            $('#uploadrentCarImageDocumentStatus').html('Process Completed Successfully');
                            $('#rentCarImage_upload_status').html(res.messsage);
                            if (res.status !== 'success') return;

                           
                           let vehiclesObj = {
                                documentName: $('#rentCarImageName').val(),
                                files: []
                            };
                      
                            
                            res.data.forEach(item => {

                                let fileUrl = (item.type === 'image') ? item.webp : item.file;

                                vehiclesObj.files.push(fileUrl);
                                let fileName = fileUrl.split('/').pop();

                               
                                    
                                // Preview UI
                                let previewSrc = getDocumentPreview(fileUrl);

                              let liHtml = `
                                        <li
                                            data-img="${fileUrl}"
                                            data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom"
                                            data-bs-placement="top"
                                            title="${res.uploaded_by}"
                                            class="avatar avatar-lg pull-up">
                                            <img class="rounded-circle"
                                                 src="${previewSrc}"
                                                 alt="${res.uploaded_by}" />
                                        </li>
                                    `;

                                $('#rentalCarImages').append(liHtml);

                            });
                            
                            let tooltipTriggerList = [].slice.call(
                                document.querySelectorAll('[data-bs-toggle="tooltip"]')
                            );
                            tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                            
                            if (!bookingMaster.vehicles) {
                                bookingMaster.vehicles = [];
                            }
                            
                            bookingMaster.vehicles.push(vehiclesObj);

                            console.log("Master Object:", bookingMaster);

                            // Reset Form
                           
                            $('#addRentalCarDetails')[0].reset();

                            $('#rentCarImage_loader_spinner').hide();
                        },
                        error: function() {
                            $('#rentCarImage_upload_status').html('<span class="text-danger">Upload failed. Please try again.</span>');
                            $('#rentCarImage_loader_spinner').hide();
                        }

                    });

                }
                
                 let currentPreviewLi = null;
            $(document).on('click', '#rentalCarImages li', function() {

                // For Delete The Uploaded Images Identify Which li User Clicks
                currentPreviewLi = $(this); // store clicked li
                let imgSrc = $(this).data('img'); // get image path
                $('#filePreviewBody img').attr('src', imgSrc);
                // Close the Delete Process and Below of the Page Return Oter Process on the Line Number 1162
            


                var fileUrl = $(this).data('img');
                var ext = fileUrl.split('.').pop().toLowerCase();

                var html = '';

                // IMAGE FILES
                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    html = `<img src="${fileUrl}" class="img-fluid rounded" style="max-height:70vh;">`;
                }

                // PDF FILE
                else if (ext === 'pdf') {
                    html = `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
                }

                // WORD / EXCEL / PPT (Preview using Google Docs Viewer)
                else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
                    html = `
                    <iframe 
                        src="https://docs.google.com/gview?url="+baseUrl+"/${encodeURIComponent(fileUrl)}&embedded=true"
                        width="100%" height="600px" style="border:none;">
                    </iframe>`;
                }

                // UNSUPPORTED FILES
                else {
                                    html = `
                        <div class="alert alert-warning">
                            Preview not available.
                            <br>
                            <a href="${fileUrl}" target="_blank" class="btn btn-primary mt-2">
                            Download File
                            </a>
                        </div>`;
                }

                $('#filePreviewBody').html(html);
                $('#filePreviewModal').modal('show');
            });
                
    $('#deletePreviewImageBtn').on('click', function(){
                if(!currentPreviewLi) return;
            
                let imgSrc = currentPreviewLi.data('img');
            
                $.ajax({
                    url: '/DeleteUploadDocuments',
                    type: 'POST',
                    data: { file: imgSrc },
                    dataType: 'json',
                    success: function(res){
                        if(res.status === 'success'){
                            // Remove preview li
                            currentPreviewLi.remove();
                            $('#filePreviewModal').modal('hide');
                            currentPreviewLi = null;
                            removeFileFromBookingMaster(imgSrc);
                            //console.log('Deleted files:', res.deleted);
                        } else {
                            alert('Delete failed: ' + res.message);
                        }
                    },
                    error: function(xhr){
                        console.error(xhr.responseText);
                        alert('Server error while deleting files.');
                    }
                });
            });
            
            function removeFileFromBookingMaster(filePath){

                if (!bookingMaster || !Array.isArray(bookingMaster.vehicles)) return;
            
                bookingMaster.vehicles = bookingMaster.vehicles
                    .map(vehicle => {
                        if (Array.isArray(vehicle.files)) {
                            vehicle.files = vehicle.files.filter(f => f !== filePath);
                        }
                        return vehicle;
                    })
                    .filter(vehicle => Array.isArray(vehicle.files) && vehicle.files.length > 0);
            
                console.log('Updated bookingMaster:', bookingMaster);
            }

          


let uploadedImages = [];
let cropper;
let selectedFile;

$('#vehicleImages').on('change', function () {

    const file = this.files[0];
    if (!file) return;

    selectedFile = file;

    const reader = new FileReader();

    reader.onload = function (e) {
        const img = document.getElementById('cropImage');
        img.src = e.target.result;

        // Destroy previous cropper if exists
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }

        const cropModalEl = document.getElementById('cropModal');
        const modal = new bootstrap.Modal(cropModalEl);
        modal.show();

        // Initialize cropper once modal is shown
        cropModalEl.addEventListener('shown.bs.modal', function () {
            cropper = new Cropper(img, {
                aspectRatio: 16 / 9,
                viewMode: 1,
                dragMode: 'move',
                cropBoxResizable: false,
                cropBoxMovable: true,
                zoomable: true,
                scalable: false,
                autoCropArea: 0.8,
                background: false
            });
        }, { once: true });
    };

    reader.readAsDataURL(file);

 
    $(this).val('');
});

$('#cropAndUpload').on('click', function () {

    let canvas = cropper.getCroppedCanvas({
        width: 1280,
        height: 720
    });

    canvas.toBlob(function (blob) {

        let formData = new FormData();
        formData.append('images[]', blob, 'cropped.jpg');

        $.ajax({
            url: '/UploadVehicleImages',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {

                let response = JSON.parse(res);

                if (response.status === 'success') {

                    response.files.forEach(function (fileName) {

                        uploadedImages.push(fileName);

                        $('#imagePreview').append(`
                            <li data-file="${fileName}" data-img="${fileName}" 
                                data-bs-toggle="tooltip" 
                                data-popup="tooltip-custom" 
                                data-bs-placement="top" title="" 
                                class="avatar avatar-lg pull-up img-box"> 
                                <img class="rounded-circle" src="uploads/vehicleImages/${fileName}" alt="" /> 
                                <a class="btn rounded-pill btn-icon btn-primary btn-fab demo waves-effect waves-light remove-img" style="color:white;">
                                <span class="icon-base ri ri-close-line icon-15px"></span></a> 
                            </li>
                        `);
                    });
                }

                // close modal
                bootstrap.Modal.getInstance(
                    document.getElementById('cropModal')
                ).hide();
            }
        });

    }, 'image/jpeg', 0.9);
});

$('#imagePreview').on('click', 'img', function () {
    let src = $(this).attr('src');
    $('#modalImage').attr('src', src);
    $('#imageModal').css('display', 'flex');
});

// Close modal when clicking outside image
$('#imageModal').on('click', function (e) {
    if (e.target.id === 'imageModal') {
        $(this).hide();
    }
});
$('#closeModal').on('click', function () {
    $('#imageModal').hide();
});

        
        $(document).on('click', '.remove-img', function () {

            let box = $(this).closest('.img-box');
            let fileName = box.data('file');
        
            $.ajax({
                url: '/DeleteUploadVehicleImages',
                type: 'POST',
                data: { file: fileName },
                success: function () {
        
                    uploadedImages = uploadedImages.filter(f => f !== fileName);
                    box.remove();
                }
            });
        });
        
         $(document).on('click', '#btn_cancel', function () {
             location.reload();
         });
         
         function resetVehicleForm() {

            $('#VehicleDetailsForm')[0].reset();
        
            uploadedImages = [];
            $('#imagePreview').html('');
            $('#rentalCarImages').html('');
            
            bookingMaster = { vehicles: [] }; // ✅ safe reset
        
            selectedVehicleData = null;
        
            $('#saveVehicleData').text('Save');
        }

       


    $('#vehicleModel').select2({
        placeholder: "Select Model",
        allowClear: true,
        width: '100%'
    });
    
    modelloadDropdown();

    function modelloadDropdown() {
       $('#dropdownContainer').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading models...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadModelSelect',
            type: 'GET',
            success: function (response) {
                $('#dropdownContainer').html(response);

                $('#vehicleModel').select2({
                    placeholder: "Select Model",
                    allowClear: true,
                    width: '100%'
                });
            },
        error: function (xhr, status, error) {
            $('#dropdownContainer').html(`
            <div class="text-center p-3">
                <div class="mt-2">Error loading data</div>
            </div>`);
            
            console.error(error);
        }
        });
    }
       $('#saveVehicleData').on('click', function (e) {
            e.preventDefault();
            let modelVal = $('#vehicleModel').val();
            let modelName = $.trim($('#vehicleModel option:selected').text());

            if (!modelVal || modelVal === "0" || modelVal === "null") {
                setupDropdown('dropdownContent', 'error', svgError + "Please select a model", 'click');
                return false;
            }
        
            if (!$('#vehicleNumber').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide vehicle number", 'click');
                return false;
            }
            if (!$('#vehicleYear').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide year", 'click');
                return false;
            }
            if (!$('#vehicleColor').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide color", 'click');
                return false;
            }
            
            if (!$('#vehicleFuelType').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please select fuel type", 'click');
                return false;
            }
            
            if (!$('#vehicleGearType').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide gear type", 'click');
                return false;
            }
            let selectedOption = $('#vehicleModel').find('option:selected');

            let category_id = selectedOption.data('id');
            let brand_id = selectedOption.data('brand');
            let vehicleDetails = {
                vehicleFuelType: $('#vehicleFuelType').val(),
                vehicleGearType: $('#vehicleGearType').val(),
                vehicleDescription: $('#vehicleDescription').val(),
                vehiclePricePerHour: parseFloat($('#pricePerHour').val()) || 0,
                vehiclePricePerDay: parseFloat($('#pricePerDay').val()) || 0,
                vehiclePricePerMonth: parseFloat($('#pricePerMonth').val()) || 0,
                vehiclePurchasePrice: parseFloat($('#purchasePrice').val()) || 0
                
            };
           
           // ---------------- MODE CHECK ----------------
            let isEdit = selectedVehicleData !== null;
   
            let postData = {
                ids: isEdit ? selectedVehicleData.ids : null, 
                vehicleModel: modelVal,
                modelName: modelName,
                category_id:category_id,
                brand_id:brand_id,
                vehicleNumber: $('#vehicleNumber').val(),
                vehicleYear: $('#vehicleYear').val(),
                vehicleColor: $('#vehicleColor').val(),
                vehiclePurchaseDate : $('#vehiclePurchaseDate').val(),
                vehicleDetails: vehicleDetails,
                vehiclesDocObj:JSON.stringify(bookingMaster),
                vehicleimages: JSON.stringify(uploadedImages),
                 action: isEdit ? 'UpdateVehicleInformation' : 'AddVehicleInformationnew'   
               
            };
        
            let btn = $('#saveVehicleData');
            btn.prop('disabled', true).text('Saving...');
        
            $.ajax({
                url: '/AddVehicles',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(postData),
        
                success: function (response) {
                  setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess + (isEdit ? "Vehicle updated successfully" : "Vehicle added successfully"),
                        'click'
                    );
                    modelloadDropdown();
                    load_master_vehicle_list();
        
                    // 🔥 RESET MODE
                    resetVehicleForm();
                    selectedVehicleData = null;
                    $('#saveVehicleData').text('Save');
                },
        
                error: function (xhr) {
                    console.error(xhr.responseText);
                    setupDropdown('dropdownContent', 'error', svgError + "Error saving vehicle", 'click');
                   
                },
        
                complete: function () {
                    btn.prop('disabled', false).text('Save');
                }
            });
        });
        resetVehicleForm();
        
       
 load_master_vehicle_list();
 function load_master_vehicle_list() {
  // Destroy existing table
  if ($.fn.DataTable.isDataTable('#vehicleTable')) {
    $('#vehicleTable').DataTable().destroy();
    $('#vehicleTable tbody').empty();
  }

  // Initialize DataTable
  let vehicletable = $('#vehicleTable').DataTable({
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    paging: true,
    pageLength: 15,
    lengthChange: false,
    info: true,
    ordering: false,
    searching: true, 
    dom: '<"row"<"col-12">><"row"<"col-12"tr>><"row"<"col-6"i><"col-6"p>>',
    ajax: {
      url: '/AddVehicles',
     type: 'POST',
    contentType: 'application/json',
     data: function () {
        return JSON.stringify({
            action: 'ListVehicleMaster'
        });
    },
    dataSrc: function (json) {
            return json.data.data; // ✅ FIXED
        }
    },
    columns: [
           {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'model_names' },
            { data: 'vehicle_number' },
            { data: 'vehicle_year' }
        ]
  });

  $('#vehicleSearch').off('keyup').on('keyup', function() {
    vehicletable.search(this.value).draw();
  });
}

$('#vehicleTable tbody').on('click', 'tr', function () {

    let table = $('#vehicleTable').DataTable();

    table.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');

    this.blur();
    resetVehicleForm();
    let data = table.row(this).data();
    selectedVehicleData = data; // ✅ store globally
    
    loadVehicleForEdit(data); // ✅ load into UI
});


function loadVehicleForEdit(data) {

   
    

   $('#saveVehicleData').text('Update Vehicle');
    $('#vehicleModel').val(data.model_id).trigger('change');
    $('#vehicleNumber').val(data.vehicle_number);
    $('#vehicleYear').val(data.vehicle_year);
    $('#vehicleColor').val(data.vehicle_color);
    $('#vehiclePurchaseDate').val(data.vehicle_purchase_date);

   
    let details = JSON.parse(data.other_details_json);

    $('#vehicleFuelType').val(details.vehicleFuelType);
    $('#vehicleGearType').val(details.vehicleGearType);
    $('#vehicleDescription').val(details.vehicleDescription);
    $('#pricePerHour').val(details.vehiclePricePerHour);
    $('#pricePerDay').val(details.vehiclePricePerDay);
    $('#pricePerMonth').val(details.vehiclePricePerMonth);
    $('#purchasePrice').val(details.vehiclePurchasePrice);

   
   let images = [];

try {
    let parsed = JSON.parse(data.image_json);

    // If still a string → parse again
    if (typeof parsed === 'string') {
        parsed = JSON.parse(parsed);
    }

    images = Array.isArray(parsed) ? parsed : [];

} catch (e) {
    images = [];
}
    uploadedImages = [...images];

    images.forEach(fileName => {

        $('#imagePreview').append(`
            <li data-file="${fileName}" 
                class="avatar avatar-lg pull-up img-box"
                style="position:relative;">
                
                <img class="rounded-circle"
                     src="uploads/vehicleImages/${fileName}" />

                <a class="remove-img"
                   data-file="${fileName}"
                   style="position:absolute;top:0;right:0;transform:translate(30%,-30%);
                          background:red;color:#fff;border-radius:50%;padding:2px 6px;">
                    ✕
                </a>
            </li>
        `);
    });

bookingMaster = { vehicles: [] };

try {
    let raw = data.vehicle_attachments;

    let parsed = JSON.parse(raw);

    // If still string → parse again
    if (typeof parsed === 'string') {
        parsed = JSON.parse(parsed);
    }

    if (parsed && Array.isArray(parsed.vehicles)) {
        bookingMaster = parsed;
    }

} catch (e) {
    console.error("Parsing error:", e);
    bookingMaster = { vehicles: [] };
}

console.log("Loaded bookingMaster:", bookingMaster);

   

    $('#rentalCarImages').empty();

   if (bookingMaster.vehicles) {

    bookingMaster.vehicles.forEach(doc => {

        doc.files.forEach(fileUrl => {

            let previewSrc = getDocumentPreview(fileUrl);

            $('#rentalCarImages').append(`
                 <li 
                    data-img="${fileUrl}" 
                    data-bs-toggle="tooltip"
                    data-popup="tooltip-custom"
                    data-bs-placement="top"
                    title="${doc.documentName}" 
                    class="avatar avatar-lg pull-up "
                    >
                    
                    <img class="rounded-circle" src="${previewSrc}" />
                </li>
            `);
                let tooltipTriggerList = [].slice.call(
                                document.querySelectorAll('[data-bs-toggle="tooltip"]')
                            );
                            tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
        });

    });
}

    console.log("Loaded bookingMaster:", bookingMaster);
}

});// Jquery Close

        
        
    </script>

</body>

</html>