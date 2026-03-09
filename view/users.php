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


    <link rel="stylesheet" href="../assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/dropzone/dropzone.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />


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
            max-width: 50vw;
            /* almost full screen width */
            margin: 1.5rem auto;
            /* spacing from top/bottom */
        }

        #cropModal .modal-body {
            max-height: 80vh;
            /* maximum 80% of viewport height */
            overflow: hidden;
            /* scroll if content is taller */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        /* Image inside modal */
        #cropImage {
            max-width: 99%;
            /* fit inside modal width */
            max-height: 75vh;
            /* fit inside modal height */
            display: block;
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
                        <?php include('templates/users/users_body.php'); ?>
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






    <?php include('templates/scripts.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/js/forms-selects.js"></script>


    <script src="../assets/vendor/libs/quill/katex.js"></script>
    <script src="../assets/vendor/libs/quill/quill.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/vendor/libs/dropzone/dropzone.js"></script>
    <script src="../assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="../assets/vendor/libs/tagify/tagify.js"></script>

    <!--<script src="../assets/js/app-ecommerce-product-add.js"></script>-->
    <script src="../assets/js/vehicles_add.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <!-- Page JS -->
    <script>
        $(document).ready(function() {
            /*       let uploadedImages = [];

        $('#vehicleImages').on('change', function () {
        
            let files = this.files;
        
            let formData = new FormData();
        
            // append all files
            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }
        
            $.ajax({
                url: '/UploadVehicleImages',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
        
                    let response = JSON.parse(res);
        
                    if (response.status === 'success') {
        
                        // store filenames
                        response.files.forEach(function (fileName) {
        
                            uploadedImages.push(fileName);
        
                            // preview
                            $('#imagePreview').append(`
                            
                                <li
                                    data-file="${fileName}"
                                    data-img="${fileName}"
                                    data-bs-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-bs-placement="top"
                                    title=""
                                    class="avatar avatar-lg pull-up img-box">
                                    <img class="rounded-circle"
                                         src="uploads/vehicleImages/${fileName}"
                                         alt="" />
                                    <a class="btn rounded-pill btn-icon btn-primary btn-fab demo waves-effect waves-light remove-img" style="color:white;"><span class="icon-base ri ri-close-line icon-15px"></span></a>
                                </li>
                            
                            `);
                        });
                    }
                }
            });
        });
*/
            let uploadedImages = [];

            let cropper;
            let selectedFile;

            $('#vehicleImages').on('change', function() {
                const file = this.files[0];
                if (!file) return;
                selectedFile = file;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('cropImage');
                    img.src = e.target.result;

                    // Destroy previous cropper if exists
                    if (cropper) cropper.destroy();

                    const cropModalEl = document.getElementById('cropModal');
                    const modal = new bootstrap.Modal(cropModalEl);
                    modal.show();

                    // Initialize cropper **after modal is fully shown**
                    cropModalEl.addEventListener('shown.bs.modal', function() {
                        cropper = new Cropper(img, {
                            aspectRatio: 16 / 9,
                            viewMode: 1,
                            dragMode: 'move', // only move image
                            cropBoxResizable: false, // crop box fixed
                            cropBoxMovable: true, // user can move crop box
                            zoomable: true,
                            scalable: false,
                            autoCropArea: 0.8,
                            background: false
                        });
                    }, {
                        once: true
                    });
                };

                reader.readAsDataURL(file);
            });


            $('#cropAndUpload').on('click', function() {

                let canvas = cropper.getCroppedCanvas({
                    width: 1280,
                    height: 720
                });

                canvas.toBlob(function(blob) {

                    let formData = new FormData();
                    formData.append('images[]', blob, 'cropped.jpg');

                    $.ajax({
                        url: '/UploadVehicleImages',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(res) {

                            let response = JSON.parse(res);

                            if (response.status === 'success') {

                                response.files.forEach(function(fileName) {

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





            $(document).on('click', '.remove-img', function() {

                let box = $(this).closest('.img-box');
                let fileName = box.data('file');

                $.ajax({
                    url: '/DeleteUploadVehicleImages',
                    type: 'POST',
                    data: {
                        file: fileName
                    },
                    success: function() {

                        uploadedImages = uploadedImages.filter(f => f !== fileName);
                        box.remove();
                    }
                });
            });

            function resetVehicleForm() {

                // reset form fields
                $('#VehicleDetailsForm')[0].reset();

                // clear quill
                $('.ql-editor').html('');

                // clear images
                uploadedImages = [];
                $('#imagePreview').html('');
            }


            $('#saveVehicleData').on('click', function(e) {
                e.preventDefault();

                // Description from Quill editor
                let description = $('#VehicleDiscription .ql-editor').html();

                // Image array
                // let images = [];
                // $('.dz-preview img').each(function () {
                //     images.push($(this).attr('src'));
                // });

                // Build JSON details
                let vehicleDetails = {
                    vehicleCostPerDay: $('#vehicleCostPerDay').val(),
                    vehicleMaxDiscountPrice: $('#vehicleMaxDiscountPrice').val(),
                    description: description,
                    vehicleFuelType: $('#vehicleFuelType').val(),
                    chargeTax: $('#price-charge-tax').is(':checked') ? 1 : 0,
                    images: uploadedImages
                };

                // Full JSON object
                let postData = {
                    vehicleName: $('#vehicleName').val(),
                    vehicleRegNumber: $('#vehicleRegNumber').val(),
                    vehicleModal: $('#vehicleModal').val(),
                    vehiclePurchaseDate: $('#vehiclePurchaseDate').val(),
                    vehiclePassingDate: $('#vehiclePassingDate').val(),
                    vehicleInsuranceExpDate: $('#vehicleInsuranceExpDate').val(),
                    vehicleStatus: $('input[type="checkbox"][class="form-check-input"]:last').is(':checked') ? 'Available' : 'Unavailable',
                    category: $('#category-org').val(),
                    vehicleDetails: vehicleDetails,
                    belongsToCompanyID: $('#belongsToCompany').val(),
                    belongsToCompanyName: $('#belongsToCompany option:selected').text(),
                    action: 'AddVehicleInformation'
                };

                $.ajax({
                    url: '/AddVehicles',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(postData),
                    success: function(response) {
                        alert('Vehicle saved successfully');
                        console.log(response);
                        resetVehicleForm();
                    },
                    error: function() {
                        alert('Error saving vehicle');
                    }
                });

            });
            resetVehicleForm();

        }); // Jquery Close
    </script>

</body>

</html>