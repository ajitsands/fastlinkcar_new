<?php
include('envinclude.php');
?>
<!doctype html>

<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-wide"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="../assets/"
    data-template="horizontal-menu-template-no-customizer">

<head>
    <?php include('templates/head.php'); ?>


    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="../assets/js/config.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">


    <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/spinkit/spinkit.css" />
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
    </style>

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
                        <!-- Layout Demo -->
                        <?php //echo "DB NAME : ".$_ENV['DB_NAME'];
                        ?>
                        <?php include('templates/home/home_body.php'); ?>
                        <!--/ Layout Demo -->
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
    <?php include('templates/home/image_slider_modal.php'); ?>
    <?php include('templates/home/customer_attachments_upload_modal.php'); ?>
    <?php include('templates/home/list_of_booking_off_canvas.php'); ?>
    <?php include('templates/home/book_car_off_canvas.php'); ?>
    <?php include('templates/home/add_driver_modal.php'); ?>
    <?php include('templates/home/add_rental_car_image_modal.php'); ?>
    <?php include('templates/home/preview_attachments_modal.php'); ?>
    <?php include('templates/home/add_customer_modal.php'); ?>



    <?php include('templates/scripts.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/js/forms-selects.js"></script>

    <!-- Page JS -->
    <script>
        $(document).ready(function() {

            var table = $('#bookingTable').DataTable({
                responsive: true,
                paging: false, // hide pagination
                searching: false, // hide search box
                info: false, // hide "Showing X of Y"
                lengthChange: false // hide "Show entries"
            });

            // Sample data (this can come from AJAX)
            var data = [{
                    name: "Mr. Kumar - 35078 079",
                    status: "<span class='badge rounded-pill text-bg-success'>Confirmed</span>",
                    fromdate: "18 Jan 2026",
                    todate: "20 Jan 2026",
                    bookedBy: "User 1",
                    action: '<button type="button" class="btn btn-xs btn-info waves-effect waves-light" > VIEW</button>'
                },
                {
                    name: "Ms Ancy Varghese - 35 654 253",
                    status: "<span class='badge rounded-pill text-bg-warning'>Pending</span>",
                    fromdate: "21 Jan 2026",
                    todate: "25 Jan 2026",
                    bookedBy: "User 2",
                    action: '<button type="button" class="btn btn-xs btn-primary waves-effect waves-light"> CANCEL</button>'
                }
            ];

            // Add rows dynamically
            data.forEach(function(row) {
                table.row.add([
                    row.name,
                    row.status,
                    row.fromdate,
                    row.todate,
                    row.bookedBy,
                    row.action
                ]).draw(false);
            });

            //------------------------------------------
            const validationsForDriver = [{
                    id: '#driverName',
                    msg: 'Please enter driver name'
                },
                {
                    id: '#driver_document',
                    msg: 'Please select a file',
                    type: 'file'
                },
                {
                    id: '#driver_document_type',
                    msg: 'Please select a document type'
                },
                {
                    id: '#driver_document_issue_date',
                    msg: 'Please select an issue date'
                },
                {
                    id: '#driver_document_expiry_date',
                    msg: 'Please select an expiry date'
                }

            ];

            const validationsOwnerDoc = [{
                    id: '#client_document',
                    msg: 'Please select a file',
                    type: 'file'
                },
                {
                    id: '#client_document_type',
                    msg: 'Please select a document type'
                },
                {
                    id: '#client_document_issue_date',
                    msg: 'Please select an issue date'
                },
                {
                    id: '#client_document_expiry_date',
                    msg: 'Please select an expiry date'
                }
            ];

            const validationsRentCarImage = [{
                    id: '#rentCarImageName',
                    msg: 'Please enter driver name'
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
            $('input, select').on('change keyup', function() {
                $('#driver_upload_status').html('');
            });

            // $(document).on('click', '#documentImages li, #driverImages li, #rentalCarImages li', function () {
            //     var imgSrc = $(this).data('img');

            //     $('#previewImage').attr('src', imgSrc);
            //     $('#imagePreviewModal').modal('show');
            // });
            let currentPreviewLi = null;
            $(document).on('click', '#rentalCarImages li, #driverImages li, #documentImages li, #customerDocumentImages li', function() {

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
                        src="https://docs.google.com/gview?url=<?php echo $_ENV['BASE_URL'] ?? getenv('BASE_URL'); ?>${encodeURIComponent(fileUrl)}&embedded=true"
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
            
            //------------------------------------------
            
            //const formDataWithAllParameter = new FormData();
            // Master Booking Object (Memory Storage)
                let bookingMaster = {
                    bookingInfo: {},
                    drivers: [],
                    vehicles: [],
                    clients: [],
                    payments: {}
                };
            $('#selectCustomerFromSelect2').on('select2:select', function(e) {

                collectBookingInfo();
                
            })
            function collectBookingInfo(){

                let dataObj = {};
            
                // Existing car-data collection
                $('.car-data').each(function () {
                    Object.assign(dataObj, this.dataset);
                });
            
                // ⭐ Select2 Customer Value + Text
                let customerId = $('#selectCustomerFromSelect2').val();
                let customerName = $('#selectCustomerFromSelect2 option:selected').text();
            
                dataObj.customerId = customerId;
                dataObj.customerName = customerName;
            
                bookingMaster.bookingInfo = dataObj;
            
                console.log("Booking Info:", bookingMaster.bookingInfo);
            }

                // Driver Controls 
                let driverRequiredControls = {
                    validationStatusId: 'driver_upload_status',
                    validationFunctionName: validationsForDriver,
                    fileInputId: '#driver_document',
                    formId: 'addDriverDetails',
                    folderName: 'driver',
                    documentTypeControlId: '#driver_document_type',
                    callFunction : uploadDriverFiles
                };
                // Client Controls 
                let clientRequiredControls = {
                    validationStatusId: 'upload_status',
                    validationFunctionName: validationsOwnerDoc,
                    fileInputId: '#client_document',
                    formId: 'upload_client_document',
                    folderName: 'client',
                    documentTypeControlId: '#client_document_type',
                    callFunction : uploadClientsFiles
                };
                // Car Controls 
                let carRequiredControls = {
                    validationStatusId: 'rentCarImage_upload_status',
                    validationFunctionName: validationsRentCarImage,
                    fileInputId: '#rentCarImage_document',
                    formId: 'addRentalCarDetails',
                    folderName: 'rentedcars',
                    documentTypeControlId: '#rentCarImageName',
                    callFunction : uploadVehicleFiles
                };
    
                $('#addDriverDetailsButton, #upload_client_document_button, #addrentCarImageButton').on('click', function (e) {
                
                    let clickedButton = this.id;
                
                    if (clickedButton === 'addDriverDetailsButton') {
                
                        addBookingAndUploadImagesFunction(driverRequiredControls);
                
                    } else if (clickedButton === 'upload_client_document_button') {
                
                        addBookingAndUploadImagesFunction(clientRequiredControls);
                
                    } else if (clickedButton === 'addrentCarImageButton') {
                
                        addBookingAndUploadImagesFunction(carRequiredControls);
                
                    }
                
                });
                
                

                function addBookingAndUploadImagesFunction(RequiredControlsNames)
                {
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
                
                function uploadDriverFiles(tempFormData) {

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
                                    $('#uploadDriverDocumentProgress')
                                        .css('width', percent + '%')
                                        .text(percent + '%');
                                }
                            }, false);
    
                            return xhr;
                        },
                        beforeSend: function () {
                            
                            $('#uploadDriverDocumentProgress')
                            .css('width', '0%')
                            .text('0%');

                            $('#driver_upload_status').html('Uploading...');

                            $('#driver_loader_spinner').show();
                        },

                        success: function (res) {
                            $('#uploadDriverDocumentProgress')
                            .css('width', '100%')
                            .text('100%');
                            $('#uploadDriverDocumentStatus').html('Process Completed Successfully');
                            $('#driver_upload_status').html(res.messsage);
                            if (res.status !== 'success') return;

                            // ⭐ Create Driver Object
                            let driverObj = {
                                driverName: $('#driverName').val(),
                                documentType: $('#driver_document_type').val(),
                                issueLocation: $('#driver_document_issue_location').val(),
                                issueDate: $('#driver_document_issue_date').val(),
                                expiryDate: $('#driver_document_expiry_date').val(),
                                files: []
                            };

                            // ⭐ Store Uploaded Paths
                            res.data.forEach(item => {

                                let fileUrl = (item.type === 'image') ? item.webp : item.file;

                                driverObj.files.push(fileUrl);

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

                                $('#driverImages').append(liHtml);

                            });
                            
                            let tooltipTriggerList = [].slice.call(
                                document.querySelectorAll('[data-bs-toggle="tooltip"]')
                            );
                            tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                            // ⭐ Save Driver To Master Object
                            bookingMaster.drivers.push(driverObj);

                            console.log("Master Object:", bookingMaster);

                            // Reset Form
                            let driverNameValue = $('#driverName').val();
                            $('#addDriverDetails')[0].reset();
                            $('#driverName').val(driverNameValue);

                            $('#driver_loader_spinner').hide();
                        },
                        error: function() {
                            $('#driver_upload_status').html('<span class="text-danger">Upload failed. Please try again.</span>');
                            $('#driver_loader_spinner').hide();
                        }

                    });

                }

                function uploadClientsFiles(tempFormData) {

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
                                    $('#uploadCustomerDocumentProgress')
                                        .css('width', percent + '%')
                                        .text(percent + '%');
                                }
                            }, false);
    
                            return xhr;
                        },
                        beforeSend: function () {
                            
                            $('#uploadCustomerDocumentProgress')
                            .css('width', '0%')
                            .text('0%');

                            $('#upload_status').html('Uploading...');

                            $('#loader_spinner').show();
                        },

                        success: function (res) {
                            $('#uploadCustomerDocumentProgress')
                            .css('width', '100%')
                            .text('100%');
                            $('#uploadCustomerDocumentStatus').html('Process Completed Successfully');
                            $('#upload_status').html(res.messsage);
                            if (res.status !== 'success') return;

                            // ⭐ Create Driver Object
                            let clientObj = {
                                documentType: $('#client_document_type').val(),
                                issueLocation: $('#client_document_issue_location').val(),
                                issueDate: $('#client_document_issue_date').val(),
                                expiryDate: $('#client_document_issue_date').val(),
                                files: []
                            };

                            // ⭐ Store Uploaded Paths
                            res.data.forEach(item => {

                                let fileUrl = (item.type === 'image') ? item.webp : item.file;

                                clientObj.files.push(fileUrl);

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

                                $('#documentImages').append(liHtml);
                                $('#customerDocumentImages').append(liHtml);

                            });
                            
                            let tooltipTriggerList = [].slice.call(
                                document.querySelectorAll('[data-bs-toggle="tooltip"]')
                            );
                            tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });

                            // ⭐ Save Driver To Master Object
                            bookingMaster.clients.push(clientObj);

                            console.log("Master Object:", bookingMaster);

                            // Reset Form
                           
                            $('#upload_client_document')[0].reset();

                            $('#loader_spinner').hide();
                        },
                        error: function() {
                            $('#upload_status').html('<span class="text-danger">Upload failed. Please try again.</span>');
                            $('#loader_spinner').hide();
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

                            // ⭐ Create Driver Object
                            let vehiclesObj = {
                                documentName: $('#rentCarImageName').val(),
                                files: []
                            };

                            // ⭐ Store Uploaded Paths
                            res.data.forEach(item => {

                                let fileUrl = (item.type === 'image') ? item.webp : item.file;

                                vehiclesObj.files.push(fileUrl);

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

                            // ⭐ Save Driver To Master Object
                            bookingMaster.vehicles.push(vehiclesObj);

                            console.log("Master Object:", bookingMaster);

                            // Reset Form
                           
                            $('#upload_client_document')[0].reset();

                            $('#rentCarImage_loader_spinner').hide();
                        },
                        error: function() {
                            $('#rentCarImage_upload_status').html('<span class="text-danger">Upload failed. Please try again.</span>');
                            $('#rentCarImage_loader_spinner').hide();
                        }

                    });

                }



                $('#buttonConfirmBooking').on('click', function () {

                        
                        const formFinal = document.getElementById('formBookingInfoAndPayments');
                        let finalFormData = new FormData(formFinal);
                        bookingMaster.payments = Object.fromEntries(new FormData(formFinal).entries());
                        //  bookingMaster.payments = {
                        //     ...bookingMaster.payments,
                        //     ...Object.fromEntries(new FormData(formFinal).entries())
                        // };
                        
                        console.log("Master Object:", bookingMaster);
                        
                        sendFinalBooking(bookingMaster);
                    
                });
                
                
                function sendFinalBooking(finalFormData) {
                    
                    //bookingMaster.bookingInfo.append('vehicle_image', '');
                    $.ajax({
                        url: '/SaveFinalBooking',
                        method: 'POST',
                        contentType: "application/json",
                        data: JSON.stringify(bookingMaster),
                        dataType: "json",
                        processData: false,
                        contentType: false,
                
                        success: function (res) {
                            console.log("Final Saved:", res);
                        },
                
                        error: function (e) {
                            alert("Final Submit Failed"+e.error());
                        }
                
                    });
                
                }

            //------------------------------------------

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

            function resetCustomerUploadUI() {
                // Reset progress bar
                $('#uploadCustomerDocumentProgress')
                    .css('width', '0%')
                    .attr('aria-valuenow', 0)
                    .text('0%');

                // Reset status message
                $('#uploadCustomerDocumentStatus')
                    .removeClass('text-success text-danger text-warning')
                    .html('')
                    .hide();
            }

            $('#buttonCloseCustomerModal').click(function() {
                resetCustomerUploadUI();
            })

            // Below Function is Depricated 
            $('#driver_document1111').on('change', function() {
                const files = this.files;
                if (!files.length) return;

                const formData = new FormData();
                formData.append('foldername', 'driver');
                let processed = 0;

                $('#uploadDriverDocumentStatus').html('Optimizing images...');

                Array.from(files).forEach((file, index) => {
                    resizeImage(file, function(blob) {
                        formData.append('images[]', blob, 'product_' + index + '.jpg');
                        processed++;

                        if (processed === files.length) {
                            uploadImages(formData);
                        }
                    });
                });
            });


            // Remove Uploaded Images 
        
            // Uploaded Item Icon CLick written on the Line 270
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
                    // const fileName = filePath.split('/').pop(); // e.g., file_697d1837ce49d1.93872214.webp
                    // const baseName = fileName.split('.').slice(0,-1).join('.'); // file_697d1837ce49d1.93872214
                
                    // // Drivers
                    // if(Array.isArray(bookingMaster.drivers)){
                    //     bookingMaster.drivers.forEach(driver => {
                    //         if(Array.isArray(driver.files)){
                    //             driver.files = driver.files.filter(f => !f.includes(baseName));
                    //         }
                    //     });
                    // }
                
                    const fileName = filePath.split('/').pop(); 
                    const baseName = fileName.split('.').slice(0, -1).join('.');
                    
                    if (Array.isArray(bookingMaster.drivers)) {
                        bookingMaster.drivers = bookingMaster.drivers
                            .map(driver => {
                                if (Array.isArray(driver.files)) {
                                    // Remove the selected file
                                    driver.files = driver.files.filter(f => !f.includes(baseName));
                                }
                                return driver;
                            })
                            // Remove driver node if no files left
                            .filter(driver => Array.isArray(driver.files) && driver.files.length > 0);
                    }

                    if (Array.isArray(bookingMaster.clients)) {
                        bookingMaster.clients = bookingMaster.clients
                            .map(client => {
                                if (Array.isArray(client.files)) {
                                    // Remove the selected file
                                    client.files = client.files.filter(f => !f.includes(baseName));
                                }
                                return client;
                            })
                            // Remove driver node if no files left
                            .filter(client => Array.isArray(client.files) && client.files.length > 0);
                    }
                
                
                    // // Clients
                    // if(Array.isArray(bookingMaster.clients)){
                    //     bookingMaster.clients.forEach(client => {
                    //         if(Array.isArray(client.files)){
                    //             client.files = client.files.filter(f => !f.includes(baseName));
                    //         }
                    //     });
                    // }
                
                    // Cars
                    // if(Array.isArray(bookingMaster.vehicles)){
                    //     bookingMaster.vehicles.forEach(car => {
                    //         if(Array.isArray(car.files)){
                    //             car.files = car.files.filter(f => !f.includes(baseName));
                    //         }
                    //     });
                    // }
                    if (Array.isArray(bookingMaster.vehicles)) {
                        bookingMaster.vehicles = bookingMaster.vehicles
                            .map(vehicle => {
                                if (Array.isArray(vehicle.files)) {
                                    // Remove the selected file
                                    vehicle.files = vehicle.files.filter(f => !f.includes(baseName));
                                }
                                return vehicle;
                            })
                            // Remove driver node if no files left
                            .filter(vehicle => Array.isArray(vehicle.files) && vehicle.files.length > 0);
                    }
                
                    console.log('Updated bookingMaster:', bookingMaster);
            }





}); // Jquery Close


        $(document).on('click', '.openAddRentalCarImageModal', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#rentCarImage_upload_status').html('');
            const modalEl = document.getElementById('addRentalCarImageModal');

            setTimeout(() => {
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }, 300);
        });

        $(document).on('click', '.openAttachmentModal', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#upload_status').html('');
            // alert('OK');
            // const offcanvasEl = document.getElementById('offcanvasCarBooking');
            const modalEl = document.getElementById('customerAttachmentUploadModal');

            // const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
            // if (offcanvasInstance) {
            //     offcanvasInstance.hide();
            // }

            setTimeout(() => {
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }, 300);
        });

        $(document).on('click', '.openAddDriverModal', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const modalEl = document.getElementById('addDriverModal');
            setTimeout(() => {
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }, 300);
        });

        $(document).on('click', '#addNewCustomerButtom', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const modalEl = document.getElementById('addNewCustomerModal');
            setTimeout(() => {
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }, 300);
        });

        // Copy Selected Car Details to the Car Booking Div
        $(document).on('click', '.book-new-cars', function() {

            var carId = $(this).data('car-id');
        
            var source = $('.rent-cars-details[data-car-id="' + carId + '"]').first();
        
            var target = $('#booking-card-details');
        
            // ⭐ Copy Inner HTML
            target.html(source.html());
        
            // ⭐ Add class
            target.addClass('car-data');
        
            // ⭐ Copy All data-* Attributes
            $.each(source[0].dataset, function(key, value) {
                target.attr(
                    'data-' + key.replace(/[A-Z]/g, m => '-' + m.toLowerCase()),
                    value
                );
            });
        
        });


        $(document).on('change', '#rent_start_date, #rent_end_date', function() {

            var startDate = $('#rent_start_date').val();
            var endDate = $('#rent_end_date').val();

            // Clear if one date is missing
            if (!startDate || !endDate) {
                $('#total_days_taken').val('');
                return;
            }

            // Convert to Date objects
            var start = new Date(startDate);
            var end = new Date(endDate);

            // If end date is before start date
            if (end < start) {
                $('#total_days_taken').val('');
                alert('End date cannot be before start date');
                return;
            }

            // Calculate difference in days (include both dates)
            var diffTime = end.getTime() - start.getTime();
            var diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

            $('#total_days_taken').val(diffDays);
        });

        $(document).on('input change', '#rent_per_day, #total_days_taken', function() {

            var rentPerDay = parseFloat($('#rent_per_day').val());
            var totalDays = parseInt($('#total_days_taken').val());

            // Validate inputs
            if (isNaN(rentPerDay) || isNaN(totalDays) || rentPerDay <= 0 || totalDays <= 0) {
                $('#rent_total_cost').val('');
                return;
            }

            var totalCost = rentPerDay * totalDays;

            // Optional: format to 2 decimals
            $('#rent_total_cost').val(totalCost.toFixed(3));
        });

        $(document).on('input change','#rent_total_cost, #rent_discount_if_any, #rent_tax_any', function() {

                var totalCost = parseFloat($('#rent_total_cost').val()) || 0;
                var discount = parseFloat($('#rent_discount_if_any').val()) || 0;
                var tax = parseFloat($('#rent_tax_any').val()) || 0;

                // Safety: discount cannot exceed total
                if (discount > totalCost) {
                    discount = totalCost;
                    $('#rent_discount_if_any').val(discount.toFixed(3));
                }

                // After discount
                var afterDiscount = totalCost - discount;
                $('#rent_after_discount').val(afterDiscount.toFixed(3));

                // Safety: tax cannot be negative
                if (tax < 0) tax = 0;

                var netTaxTotal = (afterDiscount * tax) / 100;
                // Grand total
                var grandTotal = afterDiscount + netTaxTotal;
                $('#rent_grand_total').val(grandTotal.toFixed(3));

                updateGrandTotalInWords();
            });

        function numberToBHDWords(amount) {

            if (!amount || isNaN(amount)) return '';

            var dinars = Math.floor(amount);
            var fils = Math.round((amount - dinars) * 1000);

            function toWords(num) {
                var a = [
                    '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six',
                    'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve',
                    'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
                    'Seventeen', 'Eighteen', 'Nineteen'
                ];
                var b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty',
                    'Sixty', 'Seventy', 'Eighty', 'Ninety'
                ];

                if (num < 20) return a[num];
                if (num < 100) return b[Math.floor(num / 10)] + (num % 10 ? ' ' + a[num % 10] : '');
                if (num < 1000)
                    return a[Math.floor(num / 100)] + ' Hundred' + (num % 100 ? ' ' + toWords(num % 100) : '');
                if (num < 1000000)
                    return toWords(Math.floor(num / 1000)) + ' Thousand' + (num % 1000 ? ' ' + toWords(num % 1000) : '');
                if (num < 1000000000)
                    return toWords(Math.floor(num / 1000000)) + ' Million' + (num % 1000000 ? ' ' + toWords(num % 1000000) : '');

                return '';
            }

            var words = toWords(dinars) + ' Bahraini Dinar';
            if (dinars !== 1) words += 's';

            if (fils > 0) {
                words += ' and ' + toWords(fils) + ' Fils';
            }

            return words;
        }

        function updateGrandTotalInWords() {

            var grandTotal = parseFloat($('#rent_grand_total').val()) || 0;

            if (grandTotal <= 0) {
                $('#inWords').text('');
                return;
            }

            $('#inWords').text(numberToBHDWords(grandTotal));
        }


        $(document).on('input change', '#rent_grand_total', function() {

            var grandTotal = parseFloat($(this).val()) || 0;

            if (grandTotal <= 0) {
                $('#inWords').text('');
                return;
            }

            var words = numberToBHDWords(grandTotal);
            $('#inWords').text(words);
        });


        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById("rent_start_date").value = today;
        });
        
        
        
    </script>

</body>

</html>