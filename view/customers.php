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
        /* Comprehensive override for DataTables selected row, cells, click, hover, and striped states */
        #customerTable tbody tr,
        #customerTable tbody tr td {
            cursor: pointer;
            outline: none !important;
            box-shadow: none !important;
        }

        #customerTable tbody tr:focus,
        #customerTable tbody tr:active,
        #customerTable tbody tr:focus-visible,
        #customerTable tbody tr td:focus,
        #customerTable tbody tr td:active {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Selected row and all child cells in ALL states (normal, hover, active, striped) */
        #customerTable tbody tr.selected,
        #customerTable tbody tr.selected > td,
        #customerTable tbody tr.selected > th,
        #customerTable tbody tr.selected:hover,
        #customerTable tbody tr.selected:hover > td,
        #customerTable tbody tr.selected:hover > th,
        #customerTable.dataTable tbody tr.selected,
        #customerTable.dataTable tbody tr.selected > *,
        #customerTable.dataTable tbody tr.selected:hover,
        #customerTable.dataTable tbody tr.selected:hover > *,
        #customerTable.dataTable.table-hover tbody tr.selected:hover,
        #customerTable.dataTable.table-hover tbody tr.selected:hover > *,
        #customerTable.dataTable.table-striped tbody tr.selected,
        #customerTable.dataTable.table-striped tbody tr.selected > *,
        #customerTable.dataTable.table-striped tbody tr.selected:hover,
        #customerTable.dataTable.table-striped tbody tr.selected:hover > *,
        #customerTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected,
        #customerTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected > * {
            background-color: #2b54b8 !important;
            color: #ffffff !important;
            box-shadow: none !important;
            outline: none !important;
        }

        /* Unselected row hover state */
        #customerTable tbody tr:not(.selected):hover,
        #customerTable tbody tr:not(.selected):hover > td,
        #customerTable tbody tr:not(.selected):hover > th,
        #customerTable.dataTable tbody tr:not(.selected):hover > *,
        #customerTable.dataTable.table-hover tbody tr:not(.selected):hover > * {
            background-color: rgba(43, 84, 184, 0.15) !important;
            color: inherit !important;
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
          object-fit: cover;   /* âœ… fills properly */
          border-radius: 50%;
        }
       #driverTable tbody tr {
            cursor: pointer;
            outline: none !important;
        }
        
        /* Remove all focus/active blue styles */
        #driverTable tbody tr:focus,
        #driverTable tbody tr:active,
        #driverTable tbody tr:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            background-color: inherit !important;
        }
        
        /* Force red selection */
        #driverTable tbody tr.selected,
        #driverTable tbody tr.selected td {
            background-color: red !important;
            color: white !important;
        }
        
        /* Prevent hover from interfering */
        #driverTable tbody tr:hover {
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
                        
                        <?php include ROOT_PATH . '/view/templates/customer/customer_body.php'; ?>
                        <?php include ROOT_PATH . '/view/templates/customer/customer_images_modal.php'; ?>
                        <?php include ROOT_PATH . '/view/templates/customer/confirm_action_modal.php'; ?>
                        
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
        <h5 class="modal-title">Crop Driver Image</h5>
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
        folderName: 'customerdocs',
        documentTypeControlId: '#rentCarImageName',
        callFunction : uploadVehicleFiles
    };     
   $('#addrentCarImageButton').on('click', function (e) {
                
        let clickedButton = this.id;
    
        if (clickedButton === 'addrentCarImageButton') {
    
            addBookingAndUploadImagesFunction(carRequiredControls);
        }

    
    });
    

//   function addBookingAndUploadImagesFunction(RequiredControlsNames){
                    
//      if (!validateForm(RequiredControlsNames.validationStatusId, RequiredControlsNames.validationFunctionName)) return;

//         const files = $(RequiredControlsNames.fileInputId)[0].files;
//         if (!files.length) return;

//         const form = document.getElementById(RequiredControlsNames.formId);
//         const tempFormData = new FormData(form);

//         tempFormData.append('foldername', RequiredControlsNames.folderName);
//         tempFormData.append('documentType', $(RequiredControlsNames.documentTypeControlId).val());

//         let processed = 0;

//         Array.from(files).forEach((file) => {

//             if (file.type.startsWith('image/')) {

//                 resizeImage(file, function (blob) {
//                     tempFormData.append('files[]', blob, file.name);
//                     processed++;
//                     //if (processed === files.length) uploadDriverFiles(tempFormData);
//                     if (processed === files.length) RequiredControlsNames.callFunction(tempFormData);
                    
//                 });

//             } else {

//                 tempFormData.append('files[]', file);
//                 processed++;
//                 //if (processed === files.length) uploadDriverFiles(tempFormData);
//                 if (processed === files.length) RequiredControlsNames.callFunction(tempFormData);

//             }

//         });

//     }
    function addBookingAndUploadImagesFunction(RequiredControlsNames) {

    if (!validateForm(
        RequiredControlsNames.validationStatusId,
        RequiredControlsNames.validationFunctionName
    )) {
        return;
    }

    const files = $(RequiredControlsNames.fileInputId)[0].files;

    if (!files || files.length === 0) {
        alert('Please select at least one file.');
        return;
    }

    const form = document.getElementById(RequiredControlsNames.formId);
    const tempFormData = new FormData(form);

    tempFormData.append('foldername', RequiredControlsNames.folderName);
    tempFormData.append(
        'documentType',
        $(RequiredControlsNames.documentTypeControlId).val()
    );

    let processed = 0;

    Array.from(files).forEach(file => {

        console.log('Uploading:', file.name, file.type);

        // Compress only images
        if (file.type && file.type.startsWith('image/')) {

            resizeImage(file, function(blob) {

                tempFormData.append(
                    'files[]',
                    blob,
                    file.name
                );

                processed++;

                if (processed === files.length) {
                    RequiredControlsNames.callFunction(tempFormData);
                }
            });

        } else {

            // PDF, DOC, DOCX, XLSX, TXT, ZIP, etc.
            tempFormData.append(
                'files[]',
                file,
                file.name
            );

            processed++;

            if (processed === files.length) {
                RequiredControlsNames.callFunction(tempFormData);
            }
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
                          
                        } else {
                            alert('Delete failed: ' + res.message);
                        }
                    },
                    error: function(xhr){
                      
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
            

            }

          


        
         $(document).on('click', '#btn_cancel', function () {
             location.reload();
         });
         
       var allowcprExpiredProceed = false;
       var allowlicenseExpiredProceed = false;
         function resetCustomerForm() {

            $('#CustomerDetailsForm')[0].reset();
        
            uploadedImages = [];
            $('#rentalCarImages').html('');
            
            bookingMaster = { vehicles: [] }; // âœ… safe reset
        
            selectedVehicleData = null;
            allowcprExpiredProceed = false;
            allowlicenseExpiredProceed = false;
        
            $('#saveCustomerData').text('Save');
            $('#customerStatusBadge').removeClass('bg-label-danger').addClass('bg-label-success').text('New Entry');
            $('#toggleCustomerStatusBtn').addClass('d-none');
        }

       
        $(document).on('click', '#confirmActionBtn', function () {
        
            // ✅ allow next run to pass validation
            //allowExpiredProceed = true;
        
            let extra_type = confirmData.extra.type;
            
             if(extra_type==='cpr')
            {
                allowcprExpiredProceed = true;
            }
 
            // close modal
            let modal = bootstrap.Modal.getInstance(document.getElementById('confirmActionModal'));
            modal.hide();
        
            // 🔥 trigger same button again
            $('#saveCustomerData').trigger('click');
        });

   let confirmData = {};
function showConfirmModal({ title, message, confirmText = 'Confirm', type = 'danger', action, data, extra }) {

    $('#confirmModalTitle').text(title);
    $('#confirmModalMessage').html(message);
  
    let btn = $('#confirmActionBtn');
    btn.text(confirmText);

    btn.removeClass('btn-danger btn-primary btn-success btn-warning')
       .addClass('btn-' + type);

    // ✅ store everything
    confirmData = { action, data, extra };

    new bootstrap.Modal(document.getElementById('confirmActionModal')).show();
}
$('#cprexpiryDate').on('input', function () {
    allowcprExpiredProceed= false;
});
// $('#licenseexpiryDate').on('input', function () {
//     allowlicenseExpiredProceed= false;
// });
       $('#saveCustomerData').on('click', function (e) {
            e.preventDefault();
           
        
            if (!$('#customerName').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide customer name", 'click');
                return false;
            }
            if (!$('#ContactNumber').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide contact number", 'click');
                return false;
            }
            if (!$('#emailId').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide email id", 'click');
                return false;
            }
            
            // Email Validation
                let email = $('#emailId').val().trim();
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailPattern.test(email)) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please enter a valid email address', 'click');
                    $('#emailId').focus();
                    return;
                }
            if (!$('#cprno').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide cpr number", 'click');
                return false;
            }
            
            if (!$('#cprexpiryDate').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please provide cpr expiry date", 'click');
                return false;
            }
            
            
           
            if (!$('#customer_type_onmodal').val()) {
                setupDropdown('dropdownContent', 'error', svgError + "Please select the customer type", 'click');
                return false;
            }
            let today = new Date();
            //let licenseexpiryDate = new Date($('#licenseexpiryDate').val());
            let cprexpiryDate = new Date($('#cprexpiryDate').val());

            today.setHours(0,0,0,0);
          //  licenseexpiryDate.setHours(0,0,0,0);
            cprexpiryDate.setHours(0,0,0,0);

            //     if (licenseexpiryDate < today && !allowlicenseExpiredProceed) {
            
            //     showConfirmModal({
            //         title: "Expired License",
            //         message: "⚠️ The license has expired. Do you want to proceed anyway?",
            //         confirmText: "Proceed",
            //         type: "warning",
            //         action: null,
            //         data: {},
            //         extra: {
            //             type: 'license'
            //         }
            //     });
            
            //     return false;
            // }
            
            // CPR expiry check
            if (cprexpiryDate < today && !allowcprExpiredProceed) {
            
                showConfirmModal({
                    title: "Expired CPR",
                    message: "⚠️ The CPR has expired. Do you want to proceed anyway?",
                    confirmText: "Proceed",
                    type: "warning",
                    action: null,
                    data: {},
                    extra: {
                        type: 'cpr'
                    }
                });
            
                return false;
            }
           
            let isEdit = selectedVehicleData !== null;
   
            let postData = {
                ids: isEdit ? selectedVehicleData.ids : null, 
                customerName: $('#customerName').val(),
                ContactNumber: $('#ContactNumber').val(),
                emailId: $('#emailId').val(),
                cprno : $('#cprno').val(),
                cprexpiryDate : $('#cprexpiryDate').val(),
                custAttn : $('#custattn').val(),
                custType : $('#customer_type_onmodal').val(),
                customer_account_id : $('#customer_account_id').val(),
                customerAddress : $('#customerAddress').val(),
                nationality: $('#nationality').val(),
                license_no: $('#license_no').val(),
                license_issue_place: $('#license_issue_place').val(),
                license_expiry_date: $('#license_expiry_date').val(),
                phone_1: $('#phone_1').val(),
                phone_2: $('#phone_2').val(),
                fax_no: $('#fax_no').val(),
                website: $('#website').val(),
                vat_reg_no: $('#vat_reg_no').val(),
                is_blacklisted: $('#is_blacklisted').is(':checked') ? 1 : 0,
                blacklist_description: $('#blacklist_description').val(),
                customerDocObj:JSON.stringify(bookingMaster),
                 action: isEdit ? 'UpdateCustomerInformation' : 'AddCustomerInformationnew'   
               
            };
        
            let btn = $('#saveCustomerData');
            btn.prop('disabled', true).text('Saving...');
        
            $.ajax({
                url: '/CustomerMasterController',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(postData),
        
                success: function (response) {
                  setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess + (isEdit ? "Customer updated successfully" : "Customer added successfully"),
                        'click'
                    );
                    load_master_customer_accounts();
 function load_master_customer_accounts() {
   fetch('/CustomerAccountController?action=list&active_only=1')
     .then(r => r.json())
     .then(res => {
       const sel = $('#customer_account_id');
       const cur = sel.val();
       sel.find('option:not(:first)').remove();
       (res.data || []).forEach(a => {
         sel.append(`<option value="${a.ids}">${a.account_name}</option>`);
       });
       if (cur) sel.val(cur);
     });
 }

 load_master_customer_list();
        
                    
                    resetCustomerForm();
                    selectedVehicleData = null;
                    $('#saveCustomerData').text('Save');
                },
        
                error: function (xhr) {

                    setupDropdown('dropdownContent', 'error', svgSuccess + "Error saving customer", 'click');
                   
                },
        
                complete: function () {
                    btn.prop('disabled', false).text('Save');
                }
            });
        });
        resetCustomerForm();
      $('#ContactNumber').on('keyup', function() {

                let phoneNumber = $(this).val().trim();
                let phonePattern = /^[0-9+\-() ]+$/;

                if (!phonePattern.test(phoneNumber)) {

                    setupDropdown('dropdownContent', 'warning', svgError + 'Phone number is invalid', 'click');
                    $(this).focus();
                    $(this).val('');

                }

            });   
       
 load_master_customer_accounts();
 function load_master_customer_accounts() {
   fetch('/CustomerAccountController?action=list&active_only=1')
     .then(r => r.json())
     .then(res => {
       const sel = $('#customer_account_id');
       const cur = sel.val();
       sel.find('option:not(:first)').remove();
       (res.data || []).forEach(a => {
         sel.append(`<option value="${a.ids}">${a.account_name}</option>`);
       });
       if (cur) sel.val(cur);
     });
 }

 load_master_customer_list();
 function load_master_customer_list() {
  // Destroy existing table
  if ($.fn.DataTable.isDataTable('#customerTable')) {
    $('#customerTable').DataTable().destroy();
    $('#customerTable tbody').empty();
  }

  // Initialize DataTable
  let customerTable = $('#customerTable').DataTable({
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
      url: '/CustomerMasterController',
     type: 'POST',
    contentType: 'application/json',
     data: function () {
        return JSON.stringify({
            action: 'ListCustomerMaster'
        });
    },
    dataSrc: function (json) {
            if (json && json.data && Array.isArray(json.data.data)) {
                return json.data.data;
            }
            if (json && Array.isArray(json.data)) {
                return json.data;
            }
            return [];
        }
    },
    columns: [
           {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return row.customer_id + ' - ' + row.customer_name;
                }
            },
            { data: 'customer_mobile' },
            { data: 'customer_cr_cpr' },
            { data: 'status', render: function(data, type, row){
                if (data === 'Blacklisted' || row.is_blacklisted == 1 || row.is_blacklisted === '1' || row.is_blacklisted === true) {
                    return '<span class="badge bg-danger">Blacklisted</span>';
                }
                return (data === 'Active' || data === '1' || data === 1 || data === true) ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-danger">Inactive</span>';
            } }
          
        ]
  });

  $('#customerSearch').off('keyup').on('keyup', function() {
   customerTable.search(this.value).draw();
  });
}

$('#customerTable tbody').on('click', 'tr', function () {

    let table = $('#customerTable').DataTable();

    table.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');

    this.blur();
    resetCustomerForm();
    let data = table.row(this).data();
    selectedVehicleData = data; 

    loadCustomerForEdit(data);
    // Show activate/deactivate button based on current status
    let isActive = (data.status === 'Active' || data.status === '1' || data.status === 1 || data.status === true);
    if (isActive) {
        $('#toggleCustomerStatusBtn').removeClass('d-none').text('Deactivate');
    } else {
        $('#toggleCustomerStatusBtn').removeClass('d-none').text('Activate');
    }
});

let pendingCustomerId = null;
let pendingCustomerStatus = null;

// Toggle status handler using SaNDSAlert modal
$('#toggleCustomerStatusBtn').on('click', function(e){
    e.preventDefault();
    if(!selectedVehicleData) return;
    
    pendingCustomerId = selectedVehicleData.ids;
    pendingCustomerStatus = selectedVehicleData.status;

    SaNDSAlert(
        'Are you sure you want to change the status?',
        'ChangeCustomerStatus',
        'warning',
        '#f39c12',
        'Yes Change',
        'Cancel',
        'Change Status'
    );
});

$(document).on('click', '#msg_popup_confirmed', function () {
    let action = $('#message_matter').attr('data-switch-values');
    if (action === 'ChangeCustomerStatus') {
        let isActive = (pendingCustomerStatus === 'Active' || pendingCustomerStatus === '1' || pendingCustomerStatus === 1 || pendingCustomerStatus === true);
        let newStatus = isActive ? 'Inactive' : 'Active';
        
        let postData = {
            ids: pendingCustomerId,
            status: newStatus,
            action: 'update_status'
        };
        $.ajax({
            url: '/SaveCustomerDetails',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(postData),
            success: function(resp){
                if(resp.status){
                    if (typeof setupDropdown === 'function') {
                        setupDropdown('dropdownContent', 'success', 'Status Changed Successfully', 'click');
                    } else {
                        alert("Success: " + resp.message);
                    }
                    load_master_customer_accounts();
 function load_master_customer_accounts() {
   fetch('/CustomerAccountController?action=list&active_only=1')
     .then(r => r.json())
     .then(res => {
       const sel = $('#customer_account_id');
       const cur = sel.val();
       sel.find('option:not(:first)').remove();
       (res.data || []).forEach(a => {
         sel.append(`<option value="${a.ids}">${a.account_name}</option>`);
       });
       if (cur) sel.val(cur);
     });
 }

 load_master_customer_list();
                    $('#toggleCustomerStatusBtn').addClass('d-none');
                } else {
                    if (typeof setupDropdown === 'function') {
                        setupDropdown('dropdownContent', 'error', resp.message || "Failed to update status", 'click');
                    } else {
                        alert("Error: " + (resp.message || "Failed to update status"));
                    }
                }
            },
            error: function(err){
                if (typeof setupDropdown === 'function') {
                    setupDropdown('dropdownContent', 'warning', "Server error updating status", 'click');
                } else {
                    alert("Error: Server error updating status");
                }
            }
        });
    }
    closePopup();
});

$(document).on('click', '#msg_popup_canceled', function () {
    closePopup();
});

function closePopup() {
    $('#popupOverlay').hide();
    $('#popupContainer').hide();
}
$('#emailId').on('input', function () {
    this.value = this.value.replace(/[^a-zA-Z0-9@._%+-]/g, '');
});

document.getElementById('ContactNumber').addEventListener('input', function () {
    let value = this.value;

    // Keep only digits and +
    value = value.replace(/[^0-9+]/g, '');

    // Allow + only at the beginning
    if (value.includes('+')) {
        value = '+' + value.replace(/\+/g, '').replace(/^\+/, '');
    }

    this.value = value;
});

function loadCustomerForEdit(data) {

    $('#saveCustomerData').text('Update Customer');

    let isBlacklisted = (data.status === 'Blacklisted' || data.is_blacklisted == 1 || data.is_blacklisted === '1' || data.is_blacklisted === true);
    let isActive = (data.status === 'Active' || data.status === '1' || data.status === 1 || data.status === true);
    if (isBlacklisted) {
        $('#customerStatusBadge').removeClass('bg-label-success bg-label-danger').addClass('bg-danger').text('Blacklisted');
    } else if (isActive) {
        $('#customerStatusBadge').removeClass('bg-label-danger bg-danger').addClass('bg-label-success').text('Active');
    } else {
        $('#customerStatusBadge').removeClass('bg-label-success bg-danger').addClass('bg-label-danger').text('Inactive');
    }

    // ✅ Correct field mapping
    $('#customer_account_id').val(data.customer_account_id || '');
    $('#customerName').val(data.customer_name);
    $('#ContactNumber').val(data.customer_mobile);
    $('#emailId').val(data.customer_email);
    $('#cprno').val(data.customer_cr_cpr);
    $('#cprexpiryDate').val(data.cpr_expiry_date);
    $('#customerAddress').val(data.customer_addr);
    $('#custattn').val(data.customer_attn);
    $('#nationality').val(data.nationality || '');
    $('#license_no').val(data.license_no || '');
    $('#license_issue_place').val(data.license_issue_place || '');
    $('#license_expiry_date').val(data.license_expiry_date || '');
    $('#phone_1').val(data.phone_1 || '');
    $('#phone_2').val(data.phone_2 || '');
    $('#fax_no').val(data.fax_no || '');
    $('#website').val(data.website || '');
    $('#vat_reg_no').val(data.vat_reg_no || '');
    $('#is_blacklisted').prop('checked', data.is_blacklisted == 1 || data.is_blacklisted === '1' || data.is_blacklisted === true);
    $('#blacklist_description').val(data.blacklist_description || '');
  
    $('#customer_type_onmodal')
    .val(data.customer_type)
    .trigger('change');

bookingMaster = { vehicles: [] };

try {
    let raw = data.client_docs;

    let parsed = JSON.parse(raw);

  
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


}



});// Jquery Close

        
        
    </script>

</body>

</html>