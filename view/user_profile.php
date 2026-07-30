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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

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
    <div id="dropdownContent" style="text-align:center;"></div>
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
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Layout Demo -->
                        <?php //echo "DB NAME : ".$_ENV['DB_NAME'];
                        ?>
                        <?php include ROOT_PATH . '/view/templates/user_profile/user_profile_body.php'; ?>
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
                    <h5 class="modal-title">Crop User Image</h5>
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


    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/quill.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/dropzone/dropzone.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/tagify/tagify.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    <!--<script src="../assets/js/app-ecommerce-product-add.js"></script>-->
    <script src="../assets/js/vehicles_add.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <!-- Page JS -->
    <script>
        $(document).ready(function() {
            
           
    loadUserProfile();

$('#btn_change_password').on('click', function () {

    let currentPassword = $('#currentPassword').val();
    let newPassword = $('#newPassword').val();
    let confirmPassword = $('#confirmPassword').val();
    let oldPassword = $('#hid_password').val();
    let user_id = $('#hid_user_id').val().trim();
    if (user_id === '') {
        setupDropdown('dropdownContent', 'error', svgError + 'User id is missing, please referesh the page.', 'click');
       location.reload();
        return;
    }
    if (currentPassword === '') {
        setupDropdown('dropdownContent', 'error', svgError + 'Please enter current password', 'click');
        $('#currentPassword').focus();
        return false;
    }


    if (newPassword === '') {
        setupDropdown('dropdownContent', 'error', svgError + 'Please enter new password', 'click');
        return false;
    }


    if (newPassword !== confirmPassword) {
         setupDropdown('dropdownContent', 'error', svgError + 'New password and confirm password do not match', 'click');
        return false;
    }


     $.ajax({
        url: '/LoadProfile',
        type: 'POST',
        contentType: 'application/json',

        data: JSON.stringify({
            action: 'ChangePassword',
            current_password: currentPassword,
            new_password: newPassword,
            user_id:user_id
        }),

        success: function(response) {

            if (typeof response === 'string') {
                response = JSON.parse(response);
            }


            if (response.status) {

                setupDropdown(
                    'dropdownContent',
                    'success',
                    svgSuccess + response.message,
                    'click'
                );

                $('#currentPassword').val('');
                $('#newPassword').val('');
                $('#confirmPassword').val('');

            } else {

                setupDropdown(
                    'dropdownContent',
                    'error',
                    svgError + response.message,
                    'click'
                );
            }

        },

        error: function(xhr) {
            console.log(xhr.responseText);
        }

    });

});


function loadUserProfile() {

   $.ajax({
    url: '/LoadProfile',
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
        action: 'LoadProfile'
    }),
    success: function (response) {

        if (response.status) {

            let user = response.data;

            $('#hid_user_id').val(user.user_id);
            $('#profileName').val(user.profile_name);
            $('#profileUsername').val(user.user_name);
            $('#profileEmail').val(user.user_email);
            $('#profilePhone').val(user.user_mobile);
            $('#profileRole').val(user.user_role_name);
             $('#hid_password').val(user.user_passkey);
            
            $('#uploadedImageName').val(user.profile_image_val);

             if (user.profile_image) {
                $('#previewImg').attr('src', user.profile_image);
            } else {
                $('#previewImg').attr('src', 'assets/img/users/default.jpg');
            }
        }
    }
});

            $('#cropAndUpload').on('click', function() {

                let canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                });

                canvas.toBlob(function(blob) {

                    let formData = new FormData();
                    formData.append('image', blob, 'default.jpg');

                    $.ajax({
                        url: '/UploadUserImages',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,

                        success: function(res) {

                            let response = JSON.parse(res);

                            if (response.status === 'success') {

                                uploadedImage = response.file;

                                $('#imagePreview').html(`
                        <li>
                            <img src="assets/img/users/${uploadedImage}" 
                            style="width:45px;height:45px;border-radius:70%;object-fit:cover;border:1px solid #ddd;">
                        </li>
                    `);

                                $('#uploadedImageName').val(uploadedImage);
                            }

                            bootstrap.Modal.getInstance(
                                document.getElementById('cropModal')
                            ).hide();

                        }

                    });

                }, 'image/jpeg', 0.9);

            });
            
                let uploadedImage = '';
            let cropper;
            let selectedFile;

            $('#userImages').on('change', function() {

                const file = this.files[0];
                if (!file) return;

                selectedFile = file;

                const reader = new FileReader();

                reader.onload = function(e) {

                    const img = document.getElementById('cropImage');
                    img.src = e.target.result;

                    if (cropper) cropper.destroy();

                    const cropModalEl = document.getElementById('cropModal');
                    const modal = new bootstrap.Modal(cropModalEl);

                    modal.show();

                    cropModalEl.addEventListener('shown.bs.modal', function() {

                        cropper = new Cropper(img, {
                            aspectRatio: 1, // square for profile
                            viewMode: 1,
                            dragMode: 'move',
                            cropBoxResizable: false,
                            cropBoxMovable: true,
                            zoomable: true,
                            autoCropArea: 0.8,
                            background: false
                        });

                    }, {
                        once: true
                    });

                };

                reader.readAsDataURL(file);

            });

            $('#btn_update_profile').on('click', function(e) {
                e.preventDefault();

                let profileName = $('#profileName').val().trim();
                let phoneNumber = $('#profilePhone').val().trim();
                 let user_id = $('#hid_user_id').val().trim();

                let userImage = $('#uploadedImageName').val() || 'default.jpg';
 
               
                // Profile Name validation
                if (profileName === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Name is Required', 'click');
                    $('#profileName').focus();
                    return;
                }

              
                // Email Validation
                let email = $('#profileEmail').val().trim();
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (user_id === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'User id is missing, pls referesh the page.', 'click');
                   location.reload();
                    return;
                }
                if (!emailPattern.test(email)) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please enter a valid email address', 'click');
                    $('#profileEmail').focus();
                    return;
                }

                // Phone Number validation
                if (phoneNumber === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Phone number is required', 'click');
                    $('#profilePhone').focus();
                    return;
                }

               

                updateUser(profileName,email,phoneNumber,userImage,user_id);
                // JSON Data

            });
function updateUser(profileName,email,phoneNumber,userImage,user_id) {
                let postData = {
                    name: profileName,
                    email: email,
                    phoneNumber: phoneNumber,
                    image: userImage,
                    user_id: user_id,
                    action: 'InsertUserInformation'
                };

                // Insert user
                $.ajax({
                    url: '/LoadProfile',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(postData),

                    success: function(response) {
                        setupDropdown('dropdownContent', 'success', svgSuccess + 'Profile updated successfully', 'click');
                        
                    },

                    error: function() {
                        setupDropdown('dropdownContent', 'error', svgError + 'Error updating profile', 'click');
                    }
                });

            }
            // Phone number check
            $('#profilePhone').on('keyup', function() {

                let phoneNumber = $(this).val().trim();
                let phonePattern = /^[0-9+\-() ]+$/;

                if (!phonePattern.test(phoneNumber)) {

                    setupDropdown('dropdownContent', 'warning', svgError + 'Phone number is invalid', 'click');
                    $(this).focus();
                    $(this).val('');

                }

            });
           
}

       
        });
    </script>

</body>


</html>