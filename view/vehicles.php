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

$userId = $_SESSION['user_id'] ?? 1;
$userCompanies = [];
$outsourcingCompanies = [];

try {
    $pdoModelObj = new CommonPDOModel();
    $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);

    if ($isSuperAdmin) {
        $allCompSql = "SELECT ids, company_name FROM tbl_company ORDER BY ids ASC";
        $allCompStmt = $pdoModelObj->selectexecuteQuery($allCompSql);
        if ($allCompStmt && $allCompStmt instanceof PDOStatement) {
            $userCompanies = $allCompStmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        // User company access
        $userSql = "SELECT company_json FROM tbl_users WHERE user_id = '{$userId}' LIMIT 1";
        $userStmt = $pdoModelObj->selectexecuteQuery($userSql);
        if ($userStmt && $userStmt instanceof PDOStatement) {
            $uRows = $userStmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($uRows[0]['company_json'])) {
                $userCompanies = json_decode($uRows[0]['company_json'], true) ?: [];
            }
        }
    }

    if (empty($userCompanies)) {
        $userCompanies = [
            ['ids' => strval($_SESSION['company_id'] ?? '1'), 'company_name' => $_SESSION['company_name'] ?? 'AA Car Rental']
        ];
    }

    // Active outsourcing companies
    $outSql = "SELECT ids, company_name FROM tbl_outsourcing_companies WHERE status = 'Active' ORDER BY company_name ASC";
    $outStmt = $pdoModelObj->selectexecuteQuery($outSql);
    if ($outStmt && $outStmt instanceof PDOStatement) {
        $outsourcingCompanies = $outStmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    $userCompanies = [
        ['ids' => '1', 'company_name' => 'AA Car Rental']
    ];
    $outsourcingCompanies = [];
}
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
        
        /* Unselected row hover state for vehicleTable */
        #vehicleTable tbody tr:not(.selected):hover,
        #vehicleTable tbody tr:not(.selected):hover > td,
        #vehicleTable tbody tr:not(.selected):hover > th,
        #vehicleTable.dataTable tbody tr:not(.selected):hover > *,
        #vehicleTable.dataTable.table-hover tbody tr:not(.selected):hover > * {
            --bs-table-bg-state: rgba(43, 84, 184, 0.15) !important;
            --bs-table-hover-bg: rgba(43, 84, 184, 0.15) !important;
            --bs-table-bg-type: rgba(43, 84, 184, 0.15) !important;
            --bs-table-accent-bg: rgba(43, 84, 184, 0.15) !important;
            --bs-table-bg: rgba(43, 84, 184, 0.15) !important;
            background-color: rgba(43, 84, 184, 0.15) !important;
            color: inherit !important;
            box-shadow: inset 0 0 0 9999px rgba(43, 84, 184, 0.15) !important;
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






    <?php include ROOT_PATH . '/view/templates/vehicles/vehicle_profile_modal.php'; ?>
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
         
const userCompaniesData = <?= json_encode($userCompanies) ?>;
const outsourcingCompaniesData = <?= json_encode($outsourcingCompanies) ?>;

function populateCompanyOptions() {
    let compSelect = $('#belongsToCompanyID');
    compSelect.empty();

    if (userCompaniesData.length === 1) {
        let c = userCompaniesData[0];
        compSelect.append(`<option value="${c.ids}" selected>${c.company_name}</option>`);
    } else {
        compSelect.append('<option value="" disabled selected>Select Registration Company</option>');
        userCompaniesData.forEach(c => {
            compSelect.append(`<option value="${c.ids}">${c.company_name}</option>`);
        });
    }

    let outSelect = $('#outsourcingCompanyId');
    outSelect.empty().append('<option value="" disabled selected>Select Outsourcing Company</option>');
    outsourcingCompaniesData.forEach(o => {
        outSelect.append(`<option value="${o.ids}">${o.company_name}</option>`);
    });
}

populateCompanyOptions();

$('#isOutsourced').on('change', function() {
    if ($(this).val() === 'Yes') {
        $('#outsourcingCompanyContainer').slideDown(200);
    } else {
        $('#outsourcingCompanyContainer').slideUp(200);
        $('#outsourcingCompanyId').val('');
    }
});

function resetVehicleForm() {

    $('#VehicleDetailsForm')[0].reset();

    uploadedImages = [];
    $('#imagePreview').html('');
    $('#rentalCarImages').html('');
    
    bookingMaster = { vehicles: [] }; // ✅ safe reset

    selectedVehicleData = null;

    $('#saveVehicleData').html('<i class="ri-save-line me-1"></i> Save Vehicle');

    $('#vehicleStatusBadge').attr('class', 'badge bg-label-success').text('New Entry');
    $('#toggleStatusBtn, #btnViewVehicleProfile, #btnOpenInsPassModal').addClass('d-none');
    $('#chassisNumber').val('');

    populateCompanyOptions();
    $('#isOutsourced').val('No');
    $('#outsourcingCompanyContainer').hide();
    $('#outsourcingCompanyId').val('');
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
       $(document).on('input change', '#VehicleDetailsForm input, #VehicleDetailsForm select, #VehicleDetailsForm textarea', function () {
            $(this).removeClass('is-invalid');
       });

       $('#saveVehicleData').on('click', function (e) {
            e.preventDefault();

            function failVehValidation(selector, msg) {
                const $el = $(selector);
                $el.addClass('is-invalid').focus();
                setupDropdown('dropdownContent', 'error', svgError + msg, 'click');
                return false;
            }

            let belongsToCompanyID = $('#belongsToCompanyID').val();
            if (!belongsToCompanyID) {
                return failVehValidation('#belongsToCompanyID', 'Please select Registration Company');
            }

            let isOutsourced = $('#isOutsourced').val();
            let outsourcingCompanyId = (isOutsourced === 'Yes') ? $('#outsourcingCompanyId').val() : 0;

            if (isOutsourced === 'Yes' && (!outsourcingCompanyId || outsourcingCompanyId === '0' || outsourcingCompanyId === null)) {
                return failVehValidation('#outsourcingCompanyId', 'Please select Outsourcing Company');
            }

            let modelVal = $('#vehicleModel').val();
            let modelName = $.trim($('#vehicleModel option:selected').text());

            if (!modelVal || modelVal === "0" || modelVal === "null") {
                return failVehValidation('#vehicleModel', 'Please select Vehicle Model');
            }

            if (!$.trim($('#vehicleNumber').val())) {
                return failVehValidation('#vehicleNumber', 'Please enter Vehicle Number');
            }

            let vehYear = parseInt($.trim($('#vehicleYear').val()), 10);
            if (!$.trim($('#vehicleYear').val()) || isNaN(vehYear) || vehYear < 1950 || vehYear > 2100) {
                return failVehValidation('#vehicleYear', 'Please enter a valid Year');
            }

            if (!$.trim($('#vehicleColor').val())) {
                return failVehValidation('#vehicleColor', 'Please select Car Color');
            }

            if (!$.trim($('#vehicleEngineType').val())) {
                return failVehValidation('#vehicleEngineType', 'Please select Engine Type');
            }

            if (!$.trim($('#vehicleTransmission').val())) {
                return failVehValidation('#vehicleTransmission', 'Please select Transmission');
            }
            let selectedOption = $('#vehicleModel').find('option:selected');

            let category_id = selectedOption.data('id');
            let brand_id = selectedOption.data('brand');
            let vehicleDetails = {
                vehicleFuelType: $('#vehicleEngineType').val(),
                vehicleGearType: $('#vehicleTransmission').val(),
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
                belongsToCompanyID: belongsToCompanyID,
                is_outsourced: isOutsourced,
                outsourcing_company_id: outsourcingCompanyId,
                vehicleModel: modelVal,
                modelName: modelName,
                category_id:category_id,
                brand_id:brand_id,
                vehicleNumber: $('#vehicleNumber').val(),
                chassisNumber: $('#chassisNumber').val(),
                vehicleYear: $('#vehicleYear').val(),
                vehicleColor: $('#vehicleColor').val(),
                vehicleStatus: $('#vehicleStatus').val() || 'Available',
                is_active: $('#vehicleIsActive').is(':checked') ? 1 : 0,
                mileage_km: $('#vehicleMileageKm').val(),
                body_type: $('#vehicleBodyType').val(),
                engine_type: $('#vehicleEngineType').val(),
                capacity_cc: $('#vehicleCapacityCc').val(),
                transmission: $('#vehicleTransmission').val(),
                vehiclePurchaseDate : $('#vehiclePurchaseDate').val(),
                vehiclePassingDate : $('#vehiclePassingDate').val(),
                vehicleInsuranceExpDate : $('#vehicleInsuranceExpDate').val(),
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
                    let resObj = response;
                    try {
                        if (typeof response === 'string') {
                            resObj = JSON.parse(response);
                        }
                    } catch(e) {}

                    if (resObj && resObj.status === false) {
                        setupDropdown('dropdownContent', 'error', resObj.message || "Error saving vehicle", 'click');
                        return;
                    }

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
                    $('#saveVehicleData').html('<i class="ri-save-line me-1"></i> Save Vehicle');
                },
        
                error: function (xhr) {
                    console.error(xhr.responseText);
                    setupDropdown('dropdownContent', 'error', svgError + "Error saving vehicle", 'click');
                   
                },
        
                complete: function () {
                    btn.prop('disabled', false);
                    if (selectedVehicleData !== null) {
                        btn.html('<i class="ri-save-line me-1"></i> Update Vehicle');
                    } else {
                        btn.html('<i class="ri-save-line me-1"></i> Save Vehicle');
                    }
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
            action: 'ListVehicleMaster',
            company_id: $('#companyFilter').val()
        });
    },
    dataSrc: function (json) {
            return json.data; 
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
                 data: 'model_names',
                 render: function (data, type, row) {
                     let html = `<span class="small fw-bold">${data || ''}</span>`;
                     html += `<small class="d-block text-success mt-1 lh-1"><i class="ri ri-building-4-line align-middle"></i> Reg Co: ${row.ownership_company || 'N/A'}</small>`;
                     return html;
                 }
             },
             {
                 data: null,
                 render: function (data, type, row) {
                     let html = '<div class="fw-bold">' + row.vehicle_number + '</div><small class="text-muted">' + (row.chassis_number || 'N/A') + '</small>';
                     if (row.is_outsourced === 'Yes') {
                         html += `<small class="d-block text-warning mt-1 lh-1"><i class="ri ri-share-forward-line align-middle"></i> Outsource: ${row.outsourcing_company_name || row.outsourcing_company || 'N/A'}</small>`;
                     }
                     const badgeFor = (dtStr, lbl) => {
                         if (!dtStr || dtStr === '0000-00-00') return '';
                         const diff = Math.ceil((new Date(dtStr + 'T00:00:00') - new Date(new Date().toDateString())) / 86400000);
                         if (diff < 0) return `<span class="badge bg-danger me-1 mt-1" style="font-size:10px;">${lbl} Expired</span>`;
                         if (diff <= 30) return `<span class="badge bg-warning text-dark me-1 mt-1" style="font-size:10px;">${lbl} ${diff}d</span>`;
                         return '';
                     };
                     const badges = badgeFor(row.next_insurance_date, 'Ins') + badgeFor(row.next_passing_date, 'Pass');
                     if (badges) html += `<div>${badges}</div>`;
                     return html;
                 }
             },
            { data: 'vehicle_year' },
            { 
                data: 'vehicle_status',
                render: function (data, type, row) {
                    if (typeof window.getVehicleStatusBadgeHtml === 'function') {
                        return window.getVehicleStatusBadgeHtml(data);
                    }
                    return data;
                }
            },
            {
                data: 'ids',
                orderable: false,
                className: 'text-center',
                render: function (id, type, row) {
                    const hasTx = parseInt(row.has_transactions || 0, 10) === 1;
                    const escAttr = (s) => String(s || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
                    if (hasTx) {
                        const src = escAttr(row.transaction_sources || 'other tables');
                        return `<span class="d-inline-block btn-delete-vehicle-wrap" data-sources="${src}" title="Cannot delete: transactions exist in ${src}" style="cursor: not-allowed;"><button type="button" class="btn btn-sm btn-outline-secondary" disabled style="pointer-events:none;"><i class="ri-delete-bin-line"></i></button></span>`;
                    }
                    return `<button type="button" class="btn btn-sm btn-outline-danger btn-delete-vehicle" data-id="${id}" data-veh="${escAttr(row.vehicle_number || '')}" title="Delete Vehicle"><i class="ri-delete-bin-line"></i></button>`;
                }
            }
        ]
  });

  $('#vehicleSearch').on('keyup', function () {
    vehicletable.search(this.value).draw();
  });

  $('#companyFilter').on('change', function () {
    vehicletable.ajax.reload();
  });
}

$(document).on('click', '.btn-delete-vehicle-wrap', function (e) {
    e.stopPropagation();
    const sources = $(this).data('sources') || 'other tables';
    const msg = 'This vehicle cannot be deleted because transactions exist in: ' + sources;
    if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'info', title: 'Cannot Delete Vehicle', text: msg, confirmButtonColor: '#1b3d94' });
    } else {
        setupDropdown('dropdownContent', 'warning', svgError + msg, 'click');
    }
});

$(document).on('click', '.btn-delete-vehicle', function (e) {
    e.stopPropagation();
    const id = $(this).data('id');
    const vehNo = $(this).data('veh') || '';
    if (!id) return;

    const doDelete = () => {
        fetch('/AddVehicles', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'delete_vehicle', vehicle_id: id })
        })
        .then(r => r.json())
        .then(res => {
            if (res && res.status) {
                if (selectedVehicleData && String(selectedVehicleData.ids) === String(id)) {
                    resetVehicleForm();
                }
                load_master_vehicle_list();
                setupDropdown('dropdownContent', 'success', svgSuccess + (res.message || 'Vehicle deleted successfully.'), 'click');
            } else {
                const errMsg = (res && res.message) || 'Cannot delete this vehicle.';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'warning', title: 'Cannot Delete Vehicle', text: errMsg, confirmButtonColor: '#1b3d94' });
                } else {
                    setupDropdown('dropdownContent', 'danger', svgError + errMsg, 'click');
                }
            }
        })
        .catch(() => {
            setupDropdown('dropdownContent', 'danger', svgError + 'Error deleting vehicle.', 'click');
        });
    };

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Vehicle ' + vehNo + '?',
            text: 'This vehicle has no transactions and will be permanently removed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) doDelete();
        });
    } else if (confirm('Delete vehicle ' + vehNo + '?')) {
        doDelete();
    }
});

$('#vehicleTable tbody').on('click', 'tr', function (e) {
    if ($(e.target).closest('.btn-delete-vehicle, .btn-delete-vehicle-wrap').length) {
        return;
    }

    let table = $('#vehicleTable').DataTable();

    table.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');
    $(this).siblings().css({'background-color': '', 'color': '', '--bs-table-bg': '', '--bs-table-color': '', '--bs-table-accent-bg': '', 'box-shadow': ''});
    $(this).siblings().find('*').css({'background-color': '', 'color': '', '--bs-table-bg': '', '--bs-table-color': '', '--bs-table-accent-bg': '', 'box-shadow': ''});
    $(this).css({'background-color': '#2b54b8', 'color': '#ffffff', '--bs-table-bg': '#2b54b8', '--bs-table-color': '#ffffff', '--bs-table-accent-bg': '#2b54b8', 'box-shadow': 'inset 0 0 0 9999px #2b54b8'});
    $(this).find('*').css({'background-color': '#2b54b8', 'color': '#ffffff', '--bs-table-bg': '#2b54b8', '--bs-table-color': '#ffffff', '--bs-table-accent-bg': '#2b54b8', 'box-shadow': 'inset 0 0 0 9999px #2b54b8'});


    this.blur();
    resetVehicleForm();
    let data = table.row(this).data();
    selectedVehicleData = data; // ✅ store globally
    
    loadVehicleForEdit(data); // ✅ load into UI
});


function loadVehicleForEdit(data) {

   $('#saveVehicleData').html('<i class="ri-save-line me-1"></i> Update Vehicle');
   
   let vStatus = data.vehicle_status || 'Available';
   if (vStatus === 'Available' || vStatus === 'Active') {
       $('#vehicleStatusBadge').attr('class', 'badge bg-label-success').text('Available');
       $('#toggleStatusBtn')
           .removeClass('d-none btn-success')
           .addClass('btn-warning')
           .html('<i class="ri-close-circle-line me-1"></i> Deactivate');
   } else {
       $('#vehicleStatusBadge').attr('class', 'badge bg-label-danger').text(vStatus);
       $('#toggleStatusBtn')
           .removeClass('d-none btn-warning')
           .addClass('btn-success')
           .html('<i class="ri-checkbox-circle-line me-1"></i> Activate');
   }
    if (data.company_id) {
        $('#belongsToCompanyID').val(data.company_id);
    }
    let isOut = data.is_outsourced || 'No';
    $('#isOutsourced').val(isOut);
    if (isOut === 'Yes') {
        $('#outsourcingCompanyContainer').show();
        $('#outsourcingCompanyId').val(data.outsourcing_company_id || '');
    } else {
        $('#outsourcingCompanyContainer').hide();
        $('#outsourcingCompanyId').val('');
    }

    $('#vehicleModel').val(data.model_id).trigger('change');
    $('#vehicleNumber').val(data.vehicle_number);
    $('#chassisNumber').val(data.chassis_number);
    $('#vehicleYear').val(data.vehicle_year);
    $('#vehicleColor').val(data.vehicle_color || '').trigger('change');
    $('#vehicleStatus').val(data.vehicle_status || 'Available');
    $('#vehicleIsActive').prop('checked', data.is_active === undefined || data.is_active == 1 || data.is_active === '1');
    $('#vehicleMileageKm').val(data.mileage_km ?? '');
    $('#vehicleBodyType').val(data.body_type || '').trigger('change');
    $('#vehicleEngineType').val(data.engine_type || '').trigger('change');
    $('#vehicleCapacityCc').val(data.capacity_cc || '').trigger('change');
    $('#vehicleTransmission').val(data.transmission || '').trigger('change');
    $('#vehiclePurchaseDate').val(data.vehicle_purchase_date);
    $('#vehiclePassingDate').val(data.next_passing_date || '');
    $('#vehicleInsuranceExpDate').val(data.next_insurance_date || '');
    $('#btnViewVehicleProfile, #btnOpenInsPassModal').removeClass('d-none');

   
    let details = {};
    try { details = JSON.parse(data.other_details_json || '{}') || {}; } catch (e) { details = {}; }

    $('#vehicleEngineType').val(data.engine_type || details.vehicleFuelType || '').trigger('change');
    $('#vehicleTransmission').val(data.transmission || details.vehicleGearType || '').trigger('change');
    $('#vehicleDescription').val(details.vehicleDescription || '');
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
                   data-permission="vehicle_registration_manage"
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
    
    if (typeof applyUiPermissions === 'function') {
        applyUiPermissions();
    }
}

            let pendingVehicleId = null;
            let pendingVehicleStatus = null;

            // Toggle Status Button (Activate / Deactivate) using SaNDSAlert modal
            $('#toggleStatusBtn').on('click', function (e) {
                e.preventDefault();
                let vehicleId = selectedVehicleData ? selectedVehicleData.ids : null;
                let vehicleStatus = selectedVehicleData ? selectedVehicleData.vehicle_status : 'Available';

                if (!vehicleId) {
                    setupDropdown('dropdownContent', 'error', 'No vehicle selected to change status', 'click');
                    return;
                }

                pendingVehicleId = vehicleId;
                pendingVehicleStatus = vehicleStatus;

                SaNDSAlert(
                    'Are you sure you want to change the status?',
                    'ChangeVehicleStatus',
                    'warning',
                    '#f39c12',
                    'Yes Change',
                    'Cancel',
                    'Change Status'
                );
            });

            $(document).on('click', '#msg_popup_confirmed', function () {
                let action = $('#message_matter').attr('data-switch-values');
                if (action === 'ChangeVehicleStatus') {
                    let targetSt = (pendingVehicleStatus === 'Available' || pendingVehicleStatus === 'Active') ? 'Deactivated' : 'Available';
                    $.ajax({
                        url: '/AddVehicles',
                        type: 'POST',
                        data: JSON.stringify({
                            action: 'update_status',
                            ids: pendingVehicleId,
                            status: targetSt
                        }),
                        contentType: 'application/json',
                        dataType: 'json',
                        success: function (res) {
                            if (res.status) {
                                setupDropdown(
                                    'dropdownContent',
                                    'success',
                                    'Status Changed Successfully',
                                    'click'
                                );
                                // Update UI locally
                                if (targetSt === 'Available') {
                                    $('#vehicleStatusBadge').attr('class', 'badge bg-label-success').text('Available');
                                    $('#toggleStatusBtn')
                                        .removeClass('d-none btn-success')
                                        .addClass('btn-warning')
                                        .html('<i class="ri-close-circle-line me-1"></i> Deactivate');
                                } else {
                                    $('#vehicleStatusBadge').attr('class', 'badge bg-label-danger').text('Deactivated');
                                    $('#toggleStatusBtn')
                                        .removeClass('d-none btn-warning')
                                        .addClass('btn-success')
                                        .html('<i class="ri-checkbox-circle-line me-1"></i> Activate');
                                }
                                pendingVehicleStatus = targetSt;
                                if (selectedVehicleData) selectedVehicleData.vehicle_status = targetSt;
                                
                                if($.fn.DataTable.isDataTable('#vehicleTable')){
                                     $('#vehicleTable').DataTable().ajax.reload(null, false);
                                }
                            } else {
                                setupDropdown('dropdownContent', 'error', res.message || 'Error changing status', 'click');
                            }
                        },
                        error: function () {
                            setupDropdown('dropdownContent', 'error', 'Error connecting to server', 'click');
                        }
                    });
                }
                $('#popupOverlay').hide();
                $('#popupContainer').hide();
            });

            $(document).on('click', '#msg_popup_canceled', function () {
                $('#popupOverlay').hide();
                $('#popupContainer').hide();
            });

    const lookupSelectMap = {
        color: '#vehicleColor',
        body_type: '#vehicleBodyType',
        engine_type: '#vehicleEngineType',
        capacity_cc: '#vehicleCapacityCc',
        transmission: '#vehicleTransmission'
    };

    function initLookupSelect2($sel, type) {
        if (!$.fn.select2) return;
        const placeholderMap = {
            color: 'Select a Color',
            body_type: 'Select Body Type',
            engine_type: 'Select Engine Type',
            capacity_cc: 'Select Capacity (cc)',
            transmission: 'Select Transmission'
        };
        if ($sel.hasClass('select2-hidden-accessible')) {
            $sel.select2('destroy');
        }
        $sel.select2({
            placeholder: placeholderMap[type] || 'Select...',
            allowClear: true,
            width: '100%'
        });
        $sel.next('.select2-container').css({ 'flex': '1 1 auto', 'min-width': '0' });
    }

    function loadVehicleLookupDropdowns(selectedOverrides = {}) {
        fetch('/VehicleLookupController?action=list')
            .then(r => r.json())
            .then(res => {
                if (res.status !== 'success' || !res.data) return;
                Object.keys(lookupSelectMap).forEach(type => {
                    const $sel = $(lookupSelectMap[type]);
                    if (!$sel.length) return;
                    const prevVal = selectedOverrides[type] !== undefined ? selectedOverrides[type] : $sel.val();
                    const firstOpt = type === 'color' ? '<option value="">Select a Color</option>' : '<option value="">Select...</option>';
                    $sel.html(firstOpt);
                    (res.data[type] || []).forEach(val => {
                        $sel.append($('<option>', { value: val, text: val }));
                    });
                    if (prevVal && prevVal !== 'NA') {
                        if ($sel.find('option[value="' + String(prevVal).replace(/"/g, '\\"') + '"]').length === 0) {
                            $sel.append($('<option>', { value: prevVal, text: prevVal }));
                        }
                        $sel.val(prevVal);
                    } else {
                        $sel.val('');
                    }
                    initLookupSelect2($sel, type);
                    $sel.trigger('change');
                });
            });
    }

    loadVehicleLookupDropdowns();

    function loadSelectedModelPricingPreview(modelId) {
        const $wrap = $('#modelPricingPreviewWrapper');
        const $box  = $('#modelPricingPreview');
        if (!modelId) {
            $wrap.hide();
            $box.empty();
            return;
        }
        $.post('/LoadPriceModelTable', { modelId: modelId }, function(res) {
            let rows = [];
            try { rows = JSON.parse(res); } catch (e) { rows = []; }
            const getRate = (kw) => {
                const m = rows.find(r => (r.item || '').toLowerCase().includes(kw) && !(r.item || '').toLowerCase().includes('with driver'))
                       || rows.find(r => (r.item || '').toLowerCase().includes(kw));
                return m ? (parseFloat(m.amount) || 0) : 0;
            };
            const hourly  = getRate('hour');
            const daily   = getRate('day');
            const weekly  = getRate('week');
            const monthly = getRate('month');

            if (hourly <= 0 && daily <= 0 && weekly <= 0 && monthly <= 0) {
                $box.html(`
                    <div class="alert alert-warning mb-0 d-flex align-items-center gap-2 py-2">
                        <i class="ri-alert-line fs-5"></i>
                        <div>
                            <strong>Pricing is not configured</strong> for the selected model. Please configure Hourly, Daily, Weekly &amp; Monthly rates in <strong>Vehicle Master Configuration &rarr; Pricing</strong>.
                        </div>
                    </div>
                `);
            } else {
                $box.html(`
                    <div class="small fw-semibold mb-2" style="color: #1b3d94;"><i class="ri-price-tag-3-line me-1"></i> Model Pricing (from Vehicle Master Configuration)</div>
                    <div class="row g-2 text-center">
                        <div class="col-6 col-md-3">
                            <div class="p-2 rounded bg-white border"><div class="text-muted small">Hourly</div><div class="fw-bold">${hourly.toFixed(3)} BHD</div></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-2 rounded bg-white border"><div class="text-muted small">Daily</div><div class="fw-bold">${daily.toFixed(3)} BHD</div></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-2 rounded bg-white border"><div class="text-muted small">Weekly</div><div class="fw-bold">${weekly.toFixed(3)} BHD</div></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-2 rounded bg-white border"><div class="text-muted small">Monthly</div><div class="fw-bold">${monthly.toFixed(3)} BHD</div></div>
                        </div>
                    </div>
                `);
            }
            $wrap.show();
        });
    }

    $(document).on('change', '#vehicleModel', function() {
        loadSelectedModelPricingPreview($(this).val());
    });

    $(document).on('click', '#btnViewVehicleProfile', function() {
        if (!selectedVehicleData) return;
        const v = selectedVehicleData;
        let det = {};
        try { det = JSON.parse(v.other_details_json || '{}') || {}; } catch (e) {}

        $('#vpVehicleNumber, #vpVehicleNumBody').text(v.vehicle_number || '-');
        $('#vpCategory').text(v.category_name || '-');
        $('#vpBrand').text(v.brand_name || '-');
        $('#vpModel').text(v.model_names || '-');
        $('#vpChassis').text(v.chassis_number || '-');
        $('#vpYear').text(v.vehicle_year || '-');
        $('#vpColor').text(v.vehicle_color || '-');
        $('#vpFuelType').text(v.engine_type || det.vehicleFuelType || '-');
        $('#vpGearType').text(v.transmission || det.vehicleGearType || '-');
        $('#vpMileageKm').text(v.mileage_km ? (v.mileage_km + ' km') : '-');
        $('#vpBodyType').text(v.body_type || '-');
        $('#vpCapacityCc').text(v.capacity_cc || '-');
        if (typeof window.applyVehicleStatusBadge === 'function') {
            window.applyVehicleStatusBadge('#vpStatusBadge', v.vehicle_status || 'Available');
        } else {
            $('#vpStatusBadge').text(v.vehicle_status || 'Available');
        }
        $('#vpRegCompany').text(v.reg_company_name || '-');
        $('#vpOutsourceCompany').text(v.is_outsourced === 'Yes' ? (v.outsourcing_company_name || 'Yes') : 'Own Fleet');
        function fmtVpDate(dStr) {
            if (!dStr || dStr === '0000-00-00') return 'Not Set';
            const p = String(dStr).substring(0, 10).split('-');
            if (p.length === 3 && p[0].length === 4) {
                const ms = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                const mi = parseInt(p[1], 10) - 1;
                if (mi >= 0 && mi < 12) return `${p[2]}-${ms[mi]}-${p[0]}`;
            }
            return dStr;
        }
        $('#vpPurchaseDate').text(fmtVpDate(v.vehicle_purchase_date));
        $('#vpNextInsurance').text(fmtVpDate(v.next_insurance_date));
        $('#vpNextPassing').text(fmtVpDate(v.next_passing_date));

        // Images
        let imgs = [];
        try {
            let p = JSON.parse(v.image_json || '[]');
            if (typeof p === 'string') p = JSON.parse(p);
            imgs = Array.isArray(p) ? p : [];
        } catch (e) {}
        if (imgs.length > 0) {
            let carHtml = '';
            imgs.forEach((f, idx) => {
                carHtml += `<div class="carousel-item ${idx === 0 ? 'active' : ''}"><img src="uploads/vehicleImages/${f}" class="d-block w-100" style="max-height:280px;object-fit:contain;"></div>`;
            });
            $('#vpCarouselInner').html(carHtml);
            $('#vpImageCarousel').show();
            $('#vpNoImagesMessage').hide();
        } else {
            $('#vpImageCarousel').hide();
            $('#vpNoImagesMessage').show();
        }

        // Pricing
        let priceHtml = '';
        try {
            const pArr = JSON.parse(v.model_price_json || '[]');
            if (Array.isArray(pArr) && pArr.length) {
                const seen = {};
                pArr.forEach(p => {
                    const low = (p.item || '').toLowerCase();
                    let lbl = '';
                    if (low.includes('hour')) lbl = 'Hourly';
                    else if (low.includes('day')) lbl = 'Daily';
                    else if (low.includes('week')) lbl = 'Weekly';
                    else if (low.includes('month')) lbl = 'Monthly';
                    if (lbl && !seen[lbl]) {
                        seen[lbl] = true;
                        priceHtml += `<span class="badge bg-label-primary me-2 mb-1 p-2">${lbl}: <strong>${parseFloat(p.amount || 0).toFixed(3)} BHD</strong></span>`;
                    }
                });
            }
        } catch (e) {}
        $('#vpPricingList').html(priceHtml || '<span class="text-muted fst-italic">No pricing setup</span>');

        $('#vehicleProfileModal').appendTo('body');
        new bootstrap.Modal(document.getElementById('vehicleProfileModal')).show();
    });

    function getExpiryAlerts(rows) {
        const today = new Date(new Date().toDateString());
        const alerts = [];
        (rows || []).forEach(v => {
            [['next_insurance_date', 'Insurance'], ['next_passing_date', 'Passing']].forEach(([col, label]) => {
                const d = v[col];
                if (!d || d === '0000-00-00') return;
                const diff = Math.ceil((new Date(d + 'T00:00:00') - today) / 86400000);
                if (diff <= 30) {
                    alerts.push({
                        vehicle_number: v.vehicle_number,
                        type: label,
                        date: d,
                        days: diff,
                        expired: diff < 0
                    });
                }
            });
        });
        const $banner = $('#vehicleExpiryAlertBanner');
        if (!alerts.length) {
            $banner.hide().empty();
            return;
        }
        const expiredCnt = alerts.filter(a => a.expired).length;
        const soonCnt = alerts.length - expiredCnt;
        const tags = alerts.slice(0, 8).map(a =>
            `<span class="badge ${a.expired ? 'bg-danger' : 'bg-warning text-dark'} me-1 mb-1">${a.vehicle_number} (${a.type}: ${a.expired ? 'Expired ' + Math.abs(a.days) + 'd ago' : 'Due in ' + a.days + 'd'})</span>`
        ).join('');
        $banner.html(`
            <div class="alert ${expiredCnt > 0 ? 'alert-danger' : 'alert-warning'} d-flex align-items-start gap-2 mb-0">
                <i class="ri-alarm-warning-line fs-4 mt-1"></i>
                <div>
                    <div class="fw-bold">Vehicle Insurance &amp; Passing Expiry Alerts (${expiredCnt} Expired, ${soonCnt} Expiring within 30 Days)</div>
                    <div class="mt-1">${tags}${alerts.length > 8 ? ` <span class="small text-muted">+${alerts.length - 8} more</span>` : ''}</div>
                </div>
            </div>
        `).show();
    }

    $(document).on('xhr.dt', '#vehicleTable', function(e, settings, json) {
        if (json && Array.isArray(json.data)) {
            getExpiryAlerts(json.data);
        }
    });

    function formatVipDate(dtStr) {
        if (!dtStr || dtStr === '0000-00-00') return '-';
        const d = new Date(dtStr + 'T00:00:00');
        if (isNaN(d.getTime())) return dtStr;
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return String(d.getDate()).padStart(2, '0') + '-' + months[d.getMonth()] + '-' + d.getFullYear();
    }

    function getVipHistoryArray(type) {
        if (!selectedVehicleData) return [];
        const raw = type === 'passing' ? selectedVehicleData.passing_histroy : selectedVehicleData.insurance_histroy;
        let list = [];
        try { list = JSON.parse(raw || '[]'); } catch (e) { list = []; }
        return Array.isArray(list) ? list : [];
    }

    function resetVipEditMode() {
        $('#vip_entry_id').val('');
        $('#vip_save_btn').text('Save Record');
        $('#vip_cancel_edit_btn').addClass('d-none');
    }

    function prefillVipFromEntry(type, entry) {
        $('#vip_date').val((entry && entry.date) ? entry.date : '');
        $('#vip_amount').val(entry && entry.amount ? entry.amount : '');
        $('#vip_remarks').val(entry && entry.remarks ? entry.remarks : '');
        $('#vip_attachment').val('');
        if (type === 'insurance') {
            $('#vip_provider').val(entry && entry.provider ? entry.provider : '');
            $('#vip_policy_no').val(entry && entry.policy_no ? entry.policy_no : '');
            $('#vip_ins_type').val(entry && entry.insurance_type ? entry.insurance_type : 'Comprehensive');
            $('#vip_start_date').val(entry && entry.start_date ? entry.start_date : '');
        } else {
            $('#vip_passed_date').val(entry && entry.passed_date ? entry.passed_date : '');
        }
    }

    function prefillVipFromLatest(type) {
        if (!selectedVehicleData) return;
        resetVipEditMode();
        $('#vip_entry_detail_box').hide().empty();
        const list = getVipHistoryArray(type);
        const latest = list.length ? list[0] : null;
        prefillVipFromEntry(type, latest || {
            date: type === 'passing' ? (selectedVehicleData.next_passing_date || '') : (selectedVehicleData.next_insurance_date || '')
        });
    }

    function toggleVipFields(type) {
        if (type === 'passing') {
            $('.vip-ins-only').hide();
            $('.vip-pass-only').show();
            $('#vip_date_label').text('Next Passing Expiry Date *');
        } else {
            $('.vip-ins-only').show();
            $('.vip-pass-only').hide();
            $('#vip_date_label').text('Next Insurance Expiry Date *');
        }
        prefillVipFromLatest(type);
        renderVipHistory(type);
    }

    function renderVipHistory(type) {
        if (!selectedVehicleData) return;
        const list = getVipHistoryArray(type);
        if (!list.length) {
            $('#vip_history_list').html('<span class="text-muted fst-italic">No previous records found.</span>');
            return;
        }
        let html = `<table class="table table-sm table-bordered mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Next Expiry</th>
                    <th>${type === 'insurance' ? 'Provider / Policy / Type / Start' : 'Passed Date'}</th>
                    <th>Remarks</th>
                    <th class="text-end">Amount</th>
                    <th class="text-center">Doc</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead><tbody>`;
        list.forEach((item, idx) => {
            const details = type === 'insurance'
                ? [
                    item.provider || '',
                    item.policy_no ? `Policy: ${item.policy_no}` : '',
                    item.insurance_type || '',
                    item.start_date ? `Start: ${formatVipDate(item.start_date)}` : ''
                  ].filter(Boolean).join(' | ') || '-'
                : (item.passed_date ? formatVipDate(item.passed_date) : '-');
            const docCell = item.attachment
                ? `<a href="${item.attachment}" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-2" title="View Document"><i class="ri-file-text-line"></i> View</a>`
                : '<span class="text-muted">-</span>';
            let actionBtns = `<button type="button" class="btn btn-xs btn-outline-info py-0 px-2 btn-vip-view me-1" data-idx="${idx}" title="View Details"><i class="ri-eye-line"></i></button>`;
            if (idx === 0) {
                actionBtns += `<button type="button" class="btn btn-xs btn-outline-warning py-0 px-2 btn-vip-edit me-1" data-idx="${idx}" title="Edit Last Entry"><i class="ri-edit-line"></i></button>`;
                actionBtns += `<button type="button" class="btn btn-xs btn-outline-danger py-0 px-2 btn-vip-delete" data-idx="${idx}" title="Delete Last Entry"><i class="ri-delete-bin-line"></i></button>`;
            }
            html += `<tr>
                <td class="fw-semibold text-nowrap">${formatVipDate(item.date)}</td>
                <td>${details}</td>
                <td>${item.remarks || '-'}</td>
                <td class="text-end text-nowrap fw-semibold">${parseFloat(item.amount || 0).toFixed(3)} BHD</td>
                <td class="text-center">${docCell}</td>
                <td class="text-center text-nowrap">${actionBtns}</td>
            </tr>`;
        });
        html += '</tbody></table>';
        $('#vip_history_list').html(html);
    }

    $(document).on('click', '.btn-vip-view', function() {
        const type = $('#vip_type').val();
        const idx = parseInt($(this).data('idx'), 10);
        const item = getVipHistoryArray(type)[idx];
        if (!item) return;
        const extra = type === 'insurance'
            ? `<div><strong>Provider:</strong> ${item.provider || '-'} &nbsp;|&nbsp; <strong>Policy No:</strong> ${item.policy_no || '-'} &nbsp;|&nbsp; <strong>Type:</strong> ${item.insurance_type || '-'} &nbsp;|&nbsp; <strong>Start Date:</strong> ${formatVipDate(item.start_date)}</div>`
            : `<div><strong>Passed Date:</strong> ${formatVipDate(item.passed_date)}</div>`;
        $('#vip_entry_detail_box').html(`
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong style="color:#1b3d94;">Entry Details (${type.toUpperCase()})</strong>
                <button type="button" class="btn-close btn-sm" onclick="event.preventDefault(); event.stopPropagation(); $('#vip_entry_detail_box').hide(); return false;" title="Close Details"></button>
            </div>
            <div><strong>Next Expiry:</strong> ${formatVipDate(item.date)} &nbsp;|&nbsp; <strong>Amount:</strong> ${parseFloat(item.amount || 0).toFixed(3)} BHD</div>
            ${extra}
            <div><strong>Remarks:</strong> ${item.remarks || '-'}</div>
            ${item.attachment ? `<div><strong>Document:</strong> <a href="${item.attachment}" target="_blank">Open Attachment</a></div>` : ''}
        `).show();
    });

    $(document).on('click', '.btn-vip-edit', function() {
        const type = $('#vip_type').val();
        const idx = parseInt($(this).data('idx'), 10);
        const item = getVipHistoryArray(type)[idx];
        if (!item) return;
        $('#vip_entry_id').val(item.id || '');
        prefillVipFromEntry(type, item);
        $('#vip_save_btn').text('Update Record');
        $('#vip_cancel_edit_btn').removeClass('d-none');
    });

    $('#vip_cancel_edit_btn').on('click', function() {
        prefillVipFromLatest($('#vip_type').val());
    });

    $(document).on('click', '.btn-vip-delete', function() {
        if (!selectedVehicleData) return;
        const type = $('#vip_type').val();
        const idx = parseInt($(this).data('idx'), 10);
        const item = getVipHistoryArray(type)[idx];
        if (!item || !item.id) return;

        const runDelete = () => {
            const fd = new FormData();
            fd.append('vehicle_id', selectedVehicleData.ids);
            fd.append('entry_id', item.id);
            fd.append('type', type);

            fetch('/VehicleInsuranceController?action=deleteEntry', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(res => {
                    if (res.status) {
                        if (type === 'passing') {
                            selectedVehicleData.passing_histroy = JSON.stringify(res.history || []);
                            selectedVehicleData.next_passing_date = res.next_date || '';
                            $('#vehiclePassingDate').val(res.next_date || '');
                        } else {
                            selectedVehicleData.insurance_histroy = JSON.stringify(res.history || []);
                            selectedVehicleData.next_insurance_date = res.next_date || '';
                            $('#vehicleInsuranceExpDate').val(res.next_date || '');
                        }
                        prefillVipFromLatest(type);
                        renderVipHistory(type);
                        load_master_vehicle_list();
                        setupDropdown('dropdownContent', 'success', svgSuccess + (res.message || 'Deleted successfully'), 'click');
                    } else {
                        setupDropdown('dropdownContent', 'danger', svgError + (res.message || 'Failed to delete'), 'click');
                    }
                });
        };

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete Renewal Entry?',
                text: 'Are you sure you want to delete this last renewal entry?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) runDelete();
            });
        } else if (confirm('Delete this last renewal entry?')) {
            runDelete();
        }
    });

    $(document).on('click', '#btnOpenInsPassModal', function() {
        if (!selectedVehicleData) return;
        $('#vip_vehicle_no').text(selectedVehicleData.vehicle_number || '');
        $('#vip_type').val('insurance');
        toggleVipFields('insurance');
        $('#vehicleInsPassModal').appendTo('body');
        new bootstrap.Modal(document.getElementById('vehicleInsPassModal')).show();
    });

    $('#vip_type').on('change', function() {
        toggleVipFields($(this).val());
    });

    $('#vip_save_btn').on('click', function() {
        if (!selectedVehicleData) return;
        const type = $('#vip_type').val();
        const dateVal = $('#vip_date').val();
        if (!dateVal) {
            setupDropdown('dropdownContent', 'warning', svgError + 'Please select a date.', 'click');
            return;
        }
        const entryId = $('#vip_entry_id').val();
        const actionName = entryId ? 'updateEntry' : (type === 'passing' ? 'addPassing' : 'addInsurance');
        const fd = new FormData();
        fd.append('vehicle_id', selectedVehicleData.ids);
        if (entryId) {
            fd.append('entry_id', entryId);
            fd.append('type', type);
        }
        fd.append('date', dateVal);
        fd.append('amount', $('#vip_amount').val() || '0');
        fd.append('remarks', $('#vip_remarks').val() || '');
        fd.append('provider', $('#vip_provider').val() || '');
        fd.append('policy_no', $('#vip_policy_no').val() || '');
        fd.append('insurance_type', $('#vip_ins_type').val() || '');
        fd.append('start_date', $('#vip_start_date').val() || '');
        fd.append('passed_date', $('#vip_passed_date').val() || '');
        const fileEl = $('#vip_attachment')[0];
        if (fileEl && fileEl.files && fileEl.files[0]) {
            fd.append('attachment', fileEl.files[0]);
        }

        fetch('/VehicleInsuranceController?action=' + actionName, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    if (type === 'passing') {
                        selectedVehicleData.next_passing_date = dateVal;
                        if (res.history) selectedVehicleData.passing_histroy = JSON.stringify(res.history);
                        $('#vehiclePassingDate').val(dateVal);
                    } else {
                        selectedVehicleData.next_insurance_date = dateVal;
                        if (res.history) selectedVehicleData.insurance_histroy = JSON.stringify(res.history);
                        $('#vehicleInsuranceExpDate').val(dateVal);
                    }
                    prefillVipFromLatest(type);
                    $('#vip_attachment').val('');
                    renderVipHistory(type);
                    load_master_vehicle_list();
                    setupDropdown('dropdownContent', 'success', svgSuccess + (res.message || 'Saved successfully'), 'click');
                } else {
                    setupDropdown('dropdownContent', 'danger', svgError + (res.message || 'Failed to save'), 'click');
                }
            });
    });

    $(document).on('click', '.btn-add-lookup', function() {
        const type = $(this).data('lookup-type');
        const label = $(this).data('lookup-label') || 'Value';
        $('#vl_lookup_type').val(type);
        $('#vl_lookup_value').val('');
        $('#vlModalTitle').text('Add ' + label);
        $('#vl_lookup_label').text(label + ' *');
        new bootstrap.Modal(document.getElementById('vehicleLookupMasterModal')).show();
        setTimeout(() => $('#vl_lookup_value').focus(), 200);
    });

    $('#vl_save_btn').on('click', function() {
        const type = $('#vl_lookup_type').val();
        const val = $.trim($('#vl_lookup_value').val());
        if (!val) {
            setupDropdown('dropdownContent', 'warning', svgError + 'Please enter a value.', 'click');
            return;
        }
        fetch('/VehicleLookupController', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'save', lookup_type: type, lookup_value: val })
        })
        .then(r => r.json())
        .then(res => {
            if (res.status) {
                bootstrap.Modal.getInstance(document.getElementById('vehicleLookupMasterModal')).hide();
                const overrides = {};
                overrides[type] = val;
                loadVehicleLookupDropdowns(overrides);
                setupDropdown('dropdownContent', 'success', svgSuccess + res.message, 'click');
            } else {
                setupDropdown('dropdownContent', 'danger', svgError + (res.message || 'Failed to add value'), 'click');
            }
        });
    });
});

        
        
    </script>

</body>

</html>