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
        /* Unselected row hover state for userTable */
        #userTable tbody tr:not(.selected):hover,
        #userTable tbody tr:not(.selected):hover > td,
        #userTable tbody tr:not(.selected):hover > th,
        #userTable.dataTable tbody tr:not(.selected):hover > *,
        #userTable.dataTable.table-hover tbody tr:not(.selected):hover > * {
            --bs-table-bg-state: rgba(248, 124, 99, 0.15) !important;
            --bs-table-hover-bg: rgba(248, 124, 99, 0.15) !important;
            --bs-table-bg-type: rgba(248, 124, 99, 0.15) !important;
            --bs-table-accent-bg: rgba(248, 124, 99, 0.15) !important;
            --bs-table-bg: rgba(248, 124, 99, 0.15) !important;
            background-color: rgba(248, 124, 99, 0.15) !important;
            color: inherit !important;
            box-shadow: inset 0 0 0 9999px rgba(248, 124, 99, 0.15) !important;
        }
    </style>

</head>

<body>
    <div id="dropdownContent" style="text-align:center; position: relative; z-index: 99999;"></div>
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
                        <?php include ROOT_PATH . '/view/templates/users/users_body.php'; ?>
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

    <div id="dropdownContent" style="text-align:center; position: relative; z-index: 99999;"></div>
    <!--Cropping image Before Upload Modal-->
    <!-- Crop Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
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

    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white p-3">
                    <h5 class="modal-title text-white mb-0">
                        <i class="ri-key-2-line me-2"></i>Reset User Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="resetModalUserId">
                    <div class="alert alert-primary py-2 px-3 mb-3 d-flex align-items-center">
                        <i class="ri-user-follow-line me-2 fs-5"></i>
                        <span>Resetting password for: <strong id="resetModalUserName">User</strong></span>
                    </div>

                    <div class="mb-3">
                        <label for="resetModalNewPassword" class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="resetModalNewPassword" placeholder="Enter new password">
                            <button class="btn btn-outline-secondary" type="button" id="btnGenerateRandomModalPass" title="Generate Random Password">
                                <i class="ri-refresh-line me-1"></i> Generate
                            </button>
                        </div>
                        <small class="text-muted mt-1 d-block">Specify a custom password or click <strong>Generate</strong> for a random 6-digit password.</small>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmResetPasswordBtn">
                        <i class="ri-check-line me-1"></i> Update Password
                    </button>
                </div>
            </div>
        </div>
    </div>






    <!-- Manage Roles & Role Permissions Modal -->
    <div class="modal fade" id="rolePermissionsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow-lg">
                <div class="modal-header text-white p-3" style="background: linear-gradient(135deg, #f12526, #c81e1f); border-bottom: none;">
                    <h5 class="modal-title text-white mb-0">
                        <i class="ri-shield-user-line me-2"></i>Manage Roles & Role Permissions Matrix
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-4 align-items-center">
                        <!-- Create New Role -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Create New Role</label>
                            <div class="input-group">
                                <input type="text" id="newRoleNameInput" class="form-control" placeholder="e.g. Accountant, Rental Agent">
                                <button type="button" class="btn btn-success" id="btnSaveNewRole">
                                    <i class="ri-add-line me-1"></i> Add Role
                                </button>
                            </div>
                        </div>

                        <!-- Select Role to Edit Permissions -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Configure Role Permissions</label>
                            <select id="roleMatrixSelect" class="form-select">
                                <option value="">Select a Role...</option>
                            </select>
                        </div>
                    </div>

                    <!-- Role Permission Matrix Table -->
                    <div class="card border shadow-none">
                        <div class="card-header bg-light py-2 px-3 d-flex align-items-center justify-content-between">
                            <span class="fw-semibold text-dark" id="roleMatrixTitle">Permissions for Selected Role</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-success" id="btnModalGrantAll">Grant All</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="btnModalRevokeAll">Revoke All</button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-hover align-middle mb-0" id="roleMatrixTable">
                                <thead class="table-light sticky-top" style="z-index: 1;">
                                    <tr>
                                        <th style="width: 40px;" class="text-center">#</th>
                                        <th>Permission / Control Name</th>
                                        <th style="width: 120px;" class="text-center">Group</th>
                                        <th style="width: 100px;" class="text-center">Status</th>
                                        <th style="width: 80px;" class="text-center">Grant</th>
                                    </tr>
                                </thead>
                                <tbody id="roleMatrixTbody">
                                    <tr><td colspan="5" class="text-center text-muted py-3">Select a role above to configure its default permissions.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSaveRolePermissions">
                        <i class="ri-save-line me-1"></i> Save Role Permissions
                    </button>
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
        const loggedInIsSuperAdmin = <?= (!empty($_SESSION['is_super_admin']) || ($_SESSION['user_role_name'] ?? '') === 'Super Admin' || ($_SESSION['user_role_id'] ?? 0) == 3) ? 'true' : 'false' ?>;

        $(document).ready(function() {

            loadRoles();
            loadCompanies();
            loadPermissions();
              setTimeout(function () {
                        $('#userName').val('').trigger('change');
                         $('#userPassword').val('').trigger('change');
                    }, 500);

            //let userTable = $('#userTable').DataTable({});

            // let svgSuccess = '';
            // let svgError = '';

            // function setupDropdown(containerId, type, message, trigger) {

            //     let color = '';

            //     if (type === 'success') color = 'green';
            //     if (type === 'warning') color = 'orange';
            //     if (type === 'error') color = 'red';

            //     $('#' + containerId).html(
            //         `<div style="padding:10px;border-radius:5px;background:${color};color:white;">
            //             ${message}
            //         </div>`
            //     );

            //     if (trigger === 'click') {
            //         $('#' + containerId).fadeIn().delay(3000).fadeOut();
            //     }
            // }

            // Load Roles from DB
            function loadRoles() {

                $.ajax({
                    url: '/LoadRoles', // your controller route
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        action: 'LoadRoles'
                    }),

                    success: function(response) {

                        let roles = response.data;

                        $('#select2Basic').empty();

                        roles.forEach(function(role) {
                            if (!loggedInIsSuperAdmin && (role.role_name === 'Super Admin' || role.role_id == 3)) {
                                return;
                            }

                            $('#select2Basic').append(
                                `<option value="${role.role_id}">${role.role_name}</option>`
                            );

                        });

                        $('#select2Basic').off('change.superadmin').on('change.superadmin', function() {
                            let selectedRoles = $(this).val() || [];
                            if (selectedRoles.includes('3')) {
                                let allCompanyVals = [];
                                $('#select2Multiple option').each(function() {
                                    if ($(this).val()) allCompanyVals.push($(this).val());
                                });
                                $('#select2Multiple').val(allCompanyVals).trigger('change').prop('disabled', true);
                            } else {
                                $('#select2Multiple').prop('disabled', false);
                            }
                        });

                    },

                    error: function() {
                        setupDropdown(
                            'dropdownContent',
                            'error',
                            svgError + 'Error loading roles',
                            'click'
                        );
                    }

                });

            }
            // Load Companies from DB
            function loadCompanies() {

               $.ajax({
    url: '/LoadCompanies',
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
        action: 'LoadCompanies'
    }),

    success: function(response) {

        let companies = response.data;

        $('#select2Multiple').empty();

        let selectedValues = [];

        companies.forEach(function(company) {

            $('#select2Multiple').append(
                `<option value="${company.ids}">
                    ${company.company_name}
                </option>`
            );

            selectedValues.push(company.ids); // Collect all IDs
        });

        // Select all options by default
        $('#select2Multiple').val(selectedValues).trigger('change');
    },

    error: function() {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Error loading companies',
            'click'
        );
    }
});
function selectAllCompanies() {
    const allCompanyIds = $('#select2Multiple option').map(function () {
        return this.value;
    }).get();

    $('#select2Multiple').val(allCompanyIds).trigger('change');
}
            }
            // ResetForm
            function resetUserForm() {

                // reset form fields
                $('#UserDetailsForm')[0].reset();

                $('#editUserId').val('');
                $('#select2Basic').val([]).trigger('change');
                const allCompanyIds = $('#select2Multiple option').map(function () {
                    return this.value;
                }).get();
            
                $('#select2Multiple').val(allCompanyIds).trigger('change').prop('disabled', false);

                $('#userName').val('').prop('disabled', false);
                $('#userPassword').val('').prop('disabled', false);

                // clear images
                uploadedImages = [];
                $('#imagePreview').html('<img id="previewImg" src="assets/img/users/default.jpg" alt="Preview" style="width:100%; height:100%; object-fit:cover;">');

                $('#saveUserData').show();
                $('#updateUserData').hide();
                $('#userStatusBadge').attr('class', 'badge bg-label-success').text('New Entry');
                $('#toggleUserStatusBtn').addClass('d-none');
                $('#resetUserPasswordBtn').addClass('d-none');

                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().$('tr.selected').removeClass('selected');
                }

                loadPermissions();
            }

            function insertUser(profileName, roleId, roleName, username, password, email, phoneNumber, companies, userImage) {
                let postData = {
                    name: profileName,
                    role_id: roleId,
                    role_name: roleName,
                    username: username,
                    password: password,
                    email: email,
                    phoneNumber: phoneNumber,
                    companies: companies,
                    image: userImage,
                    permissions: getSelectedPermissions(),
                    action: 'InsertUserInformation'
                };

                // Insert user
                $.ajax({
                    url: '/InsertUser',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(postData),

                    success: function(response) {
                        setupDropdown('dropdownContent', 'success', svgSuccess + 'User saved successfully', 'click');
                        resetUserForm();
                        $('#imagePreview').html('<img id="previewImg" src="assets/img/users/default.jpg" alt="Preview" style="width:100%; height:100%; object-fit:cover;">');
                        $('#userTable').DataTable().ajax.reload(null, false);
                    },

                    error: function() {
                        setupDropdown('dropdownContent', 'error', svgError + 'Error saving user', 'click');
                    }
                });

            }

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

            $('#saveUserData').on('click', function(e) {
                e.preventDefault();

                let profileName = $('#userProfileName').val().trim();
                let roleIds = $('#select2Basic').val() || [];
                let roleNames = [];
                $('#select2Basic option:selected').each(function() {
                    roleNames.push($(this).text().trim());
                });

                let roleId = roleIds.join(',');
                let roleName = roleNames.join(', ');

                let phoneNumber = $('#userPhoneNumber').val().trim();
                let username = $('#userName').val().trim();
                let password = $('#userPassword').val().trim();

                let userImage = $('#uploadedImageName').val() || 'default.jpg';

                let companies = [];

                $('#select2Multiple option:selected').each(function() {

                    companies.push({
                        ids: $(this).val(),
                        company_name: $(this).text().trim()
                    });

                });

                // Profile Name validation
                if (profileName === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Name is Required', 'click');
                    $('#userProfileName').focus();
                    return;
                }

                // Role validation
                if (roleIds.length === 0) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please select at least one user role', 'click');
                    $('#select2Basic').focus();
                    return;
                }
                // Email Validation
                let email = $('#userEmail').val().trim();
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailPattern.test(email)) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please enter a valid email address', 'click');
                    $('#userEmail').focus();
                    return;
                }

                // Phone Number validation
                if (phoneNumber === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Phone number is required', 'click');
                    $('#userPhoneNumber').focus();
                    return;
                }

                if (username === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Username is required', 'click');
                    $('#userName').focus();
                    return;
                }

                // Password validation
                if (password === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Password is required', 'click');
                    $('#userPassword').focus();
                    return;
                }

                // Company validation
                if (companies.length === 0) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please select at least one company', 'click');
                    $('#select2Multiple').focus();
                    return;
                }

                insertUser(profileName, roleId, roleName, username, password, email, phoneNumber, companies, userImage);
                // JSON Data

            });

            // Phone number check
            $('#userPhoneNumber').on('keyup', function() {

                let phoneNumber = $(this).val().trim();
                let phonePattern = /^[0-9+\-() ]+$/;

                if (!phonePattern.test(phoneNumber)) {

                    setupDropdown('dropdownContent', 'warning', svgError + 'Phone number is invalid', 'click');
                    $(this).focus();
                    $(this).val('');

                }

            });
           
                  
            
            // Username duplication check
            $('#userName').on('blur', function() {

                let username = $(this).val().trim();

                if (username === '') {
                    return;
                }

                let currentUserId = $('#editUserId').val() || null;

                $.ajax({
                    url: '/CheckUsername',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        username: username,
                        user_id: currentUserId,
                        action: 'CheckUsername'
                    }),

                    success: function(response) {

                        if (response.exists === true) {

                            setupDropdown('dropdownContent', 'warning', svgError + 'Username already exists', 'click');
                            $('#userName').val('').focus();

                        }

                    },

                    error: function() {
                        setupDropdown('dropdownContent', 'error', svgError + 'Error checking username', 'click');
                    }

                });

            });
            // Jquery Close

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


            // clear function
            $('#clearUserData').on('click', function() {
                resetUserForm();
            });


            // user table list

            let table = $('#userTable').DataTable({
                searching: true,
                lengthChange: false,
                responsive: true,
                autoWidth: false,
                paging: true,
                pageLength: 15,
                ordering: false,
                dom: '<"row"<"col-12 font-weight-bold">><"row"<"col-12"tr>><"row"<"col-6"i><"col-6"p>>',
                ajax: {
                    url: '/ListOfUsers',
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    data: function() {
                        return JSON.stringify({
                            action: 'LoadUserList'
                        });
                    },
                    dataSrc: function(json) {
                        return (json && json.data && Array.isArray(json.data)) ? json.data : [];
                    },
                    error: function(xhr) {
                        console.log('Error loading users:', xhr.responseText);
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'profile_image',
                        render: function(data) {
                            if (!data || data === '') {
                                data = 'default.jpg';
                            }
                            return `<img src="assets/img/users/${data}" width="36" height="36" style="border-radius:50%;object-fit:cover;">`;
                        }
                    },
                    {
                        data: 'profile_name',
                        render: function(data, type, row) {
                            let compNames = '';
                            if (row.company_json) {
                                try {
                                    let cList = JSON.parse(row.company_json);
                                    if (Array.isArray(cList) && cList.length > 0) {
                                        compNames = cList.map(c => c.company_name).join(', ');
                                    }
                                } catch(e) {}
                            }
                            let compBadge = compNames ? `<br><small class="text-primary" style="font-size:11px; font-weight:500;"><i class="ri-building-line me-1"></i>${compNames}</small>` : '';
                            return `<span class="fw-semibold">${data}</span> <small class="text-muted">(@${row.user_name || ''})</small>${compBadge}`;
                        }
                    },
                    {
                        data: 'user_role_name',
                        render: function(data) {
                            if (data === 'Super Admin') {
                                return '<span class="badge bg-label-danger"><i class="ri-shield-user-line me-1"></i>Super Admin</span>';
                            }
                            return data || '-';
                        }
                    },
                    {
                        data: 'user_status',
                        render: function(data) {
                            if (data === 'Active') {
                                return '<span class="badge bg-label-success">Active</span>';
                            } else {
                                return '<span class="badge bg-label-danger">Deactive</span>';
                            }
                        }
                    }
                ]
            });

            $('#searchUser').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Table Row Click Event matching Outsourcing Company layout
            $('#userTable tbody').off('click', 'tr').on('click', 'tr', function () {
                let tableInstance = $('#userTable').DataTable();
                tableInstance.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                let rowData = tableInstance.row(this).data();
                if (rowData) {
                    fillUserForm(rowData);
                }
            });

            // Edit user form details
            $(document).on('click', '.edit-user', function() {

                $('#saveUserData').hide();
                $('#updateUserData').show();

                let rowData = $(this).data('row');

                fillUserForm(rowData);

            });

            function fillUserForm(data) {

                $('#saveUserData').hide();
                $('#updateUserData').show();

                $('#editUserId').val(data.user_id);

                $('#userProfileName').val(data.profile_name);
                $('#userName').val(data.user_name).prop('disabled', true);
                $('#userPassword').val(data.user_passkey).prop('disabled', true);
                $('#userEmail').val(data.user_email);
                $('#userPhoneNumber').val(data.user_mobile);

                // Role select
                let roleIds = data.user_role_id ? data.user_role_id.split(',') : [];
                $('#select2Basic').val(roleIds).trigger('change');

                // Companies JSON
                if (data.company_json) {
                    try {
                        let companies = JSON.parse(data.company_json);
                        let companyIds = companies.map(c => c.ids);
                        $('#select2Multiple').val(companyIds).trigger('change');
                    } catch(e) {}
                }

                if (data.profile_image) {
                    $('#imagePreview').html(`
                    <img src="assets/img/users/${data.profile_image}"
                    width="100"
                    height="100"
                    style="border-radius:50%; object-fit:cover; border:2px solid #ddd;">
                `);
                    $('#uploadedImageName').val(data.profile_image);
                }

                // Status Badge & Toggle Button Setup
                let isTargetSuperAdmin = (data.user_role_name === 'Super Admin' || data.user_role_id == 3);

                if (data.user_status === 'Active') {
                    $('#userStatusBadge').attr('class', 'badge bg-label-success').text('Active');
                    $('#toggleUserStatusBtn')
                        .removeClass('d-none btn-success')
                        .addClass('btn-warning')
                        .html('<i class="ri-close-circle-line me-1"></i> Deactivate')
                        .attr('data-id', data.user_id)
                        .attr('data-status', 'Active')
                        .data('id', data.user_id)
                        .data('status', 'Active');
                } else {
                    $('#userStatusBadge').attr('class', 'badge bg-label-danger').text('Deactive');
                    $('#toggleUserStatusBtn')
                        .removeClass('d-none btn-warning')
                        .addClass('btn-success')
                        .html('<i class="ri-checkbox-circle-line me-1"></i> Activate')
                        .attr('data-id', data.user_id)
                        .attr('data-status', 'Deactive')
                        .data('id', data.user_id)
                        .data('status', 'Deactive');
                }

                // If target user is Super Admin and logged-in user is NOT Super Admin, hide status toggle
                if (isTargetSuperAdmin && !loggedInIsSuperAdmin) {
                    $('#toggleUserStatusBtn').addClass('d-none');
                }

                // Show Reset Password button: Super Admin can reset all users; Admin can reset regular users (not Admins/Super Admins)
                let canResetPassword = false;
                let isTargetAdminOrSuper = (data.user_role_name === 'Administrator' || data.user_role_name === 'Super Admin' || data.user_role_id == 1 || data.user_role_id == 3);

                if (loggedInIsSuperAdmin) {
                    canResetPassword = true;
                } else if (data.user_id && !isTargetAdminOrSuper) {
                    canResetPassword = true;
                }

                if (canResetPassword && data.user_id) {
                    $('#resetUserPasswordBtn')
                        .removeClass('d-none')
                        .attr('data-id', data.user_id)
                        .attr('data-name', data.profile_name);
                } else {
                    $('#resetUserPasswordBtn').addClass('d-none');
                }

                if (data.user_id) {
                    loadPermissions(data.user_id);
                } else {
                    loadPermissions();
                }
            }


            function updateUser(data) {

                let postData = {
                    user_id: data.userId,
                    name: data.profileName,
                    username: data.username,
                    password: data.password,
                    email: data.email,
                    phoneNumber: data.phoneNumber,
                    role_id: data.roleId,
                    role_name: data.roleName,
                    companies: data.companies,
                    image: data.userImage,
                    permissions: getSelectedPermissions(),
                    action: 'UpdateUserInformation'
                };

                $.ajax({
                    url: '/UpdateUserInformation',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(postData),

                    success: function(response) {
                        //let res = JSON.parse(response);
                        console.log(response);
                        if (response.status === true) {

                            setupDropdown('dropdownContent', 'success', svgSuccess + 'User updated successfully', 'click');
                            resetUserForm();
                            $('#userTable').DataTable().ajax.reload(null, false);

                            $('#saveUserData').show();
                            $('#updateUserData').hide();

                        } else {
                            setupDropdown('dropdownContent', 'error', svgError + 'Update Failed', 'click');
                        }

                    }
                });
            }

            $('#updateUserData').click(function(e) {
                e.preventDefault();

                let userId = $('#editUserId').val();
                let profileName = $('#userProfileName').val().trim();
                let username = $('#userName').val().trim();
                let password = $('#userPassword').val().trim();
                let email = $('#userEmail').val().trim();
                let phoneNumber = $('#userPhoneNumber').val().trim();

                let roleIds = $('#select2Basic').val() || [];
                let roleNames = [];
                $('#select2Basic option:selected').each(function() {
                    roleNames.push($(this).text().trim());
                });

                let roleId = roleIds.join(',');
                let roleName = roleNames.join(', ');

                let companies = [];

                $('#select2Multiple option:selected').each(function() {

                    companies.push({
                        ids: $(this).val(),
                        company_name: $(this).text().trim()
                    });
                });

                // Profile Name validation
                if (profileName === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Name is Required', 'click');
                    $('#userProfileName').focus();
                    return;
                }

                // Role validation
                if (roleIds.length === 0) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please select at least one user role', 'click');
                    $('#select2Basic').focus();
                    return;
                }

                // Email validation
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailPattern.test(email)) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please enter a valid email address', 'click');
                    $('#userEmail').focus();
                    return;
                }

                // Phone validation
                if (phoneNumber === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Phone number is required', 'click');
                    $('#userPhoneNumber').focus();
                    return;
                }

                // Password validation
                if (password === '') {
                    setupDropdown('dropdownContent', 'error', svgError + 'Password is required', 'click');
                    $('#userPassword').focus();
                    return;
                }

                // Company validation
                if (companies.length === 0) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please select at least one company', 'click');
                    $('#select2Multiple').focus();
                    return;
                }

                let formData = {
                    userId: userId,
                    profileName: $('#userProfileName').val(),
                    username: $('#userName').val(),
                    password: $('#userPassword').val(),
                    email: $('#userEmail').val(),
                    phoneNumber: $('#userPhoneNumber').val(),
                    roleId: roleId,
                    roleName: roleName,
                    companies: companies,
                    userImage: $('#uploadedImageName').val()
                };

                updateUser(formData);

            });

            // change status click function
            let userId = null;
            let currentStatus = null;

            $(document).on('click', '.change-status, #toggleUserStatusBtn', function(e) {
                e.preventDefault();

                userId = $(this).attr('data-id') || $(this).data('id') || $('#editUserId').val();
                currentStatus = $(this).attr('data-status') || $(this).data('status') || 'Active';

                if (!userId) {
                    setupDropdown('dropdownContent', 'error', svgError + 'No user selected to change status', 'click');
                    return;
                }

                SaNDSAlert(
                    'Are you sure you want to change the status?',
                    'ChangeStatus',
                    'warning',
                    '#f39c12',
                    'Yes Change',
                    'Cancel',
                    'Change Status'
                );

            });

            $(document).on('click', '#msg_popup_confirmed', function() {

                let action = $('#message_matter').attr('data-switch-values');

                if (action === 'ChangeStatus') {

                    changeStatus(userId, currentStatus);

                }

                closePopup();

            });

            $(document).on('click', '#msg_popup_canceled', function() {

                closePopup();

            });

            function closePopup() {

                $('#popupOverlay').hide();
                $('#popupContainer').hide();

            }

            function changeStatus(userId, currentStatus) {
                // Toggle status
                let newStatus = currentStatus === 'Active' ? 'Deactive' : 'Active';
                //alert(userId + '' + currentStatus);
                $.ajax({
                    url: '/UpdateUserStatus',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        user_id: userId,
                        status: newStatus,
                        action: 'ChangeUserStatus'
                    }),
                    success: function(response) {
                        if (response.success) {
                             setupDropdown(
                                 'dropdownContent',
                                 'success',
                                 svgSuccess + 'Status Changed Successfully',
                                 'click'
                             );

                             resetUserForm();
                             // Update the row in DataTable dynamically
                             $('#userTable').DataTable().ajax.reload(null, false);
                        } else {
                            setupDropdown(
                                'dropdownContent',
                                'error',
                                svgError + 'Failed to update status',
                                'click'
                            );
                        }
                    },
                    error: function() {
                        setupDropdown(
                            'dropdownContent',
                            'warning',
                            svgError + 'Error updating status',
                            'click'
                        );
                    }
                });
            }

            // Reset Password Modal Trigger
            $(document).on('click', '.reset-password, #resetUserPasswordBtn', function(e) {
                e.preventDefault();
                let userId = $(this).attr('data-id') || $(this).data('id') || $('#editUserId').val();
                let userName = $(this).attr('data-name') || $('#userProfileName').val() || 'User';
                
                if (!userId) {
                    setupDropdown('dropdownContent', 'error', svgError + 'No user selected for password reset', 'click');
                    return;
                }

                $('#resetModalUserId').val(userId);
                $('#resetModalUserName').text(userName);
                // Default random password
                let randomPass = Math.floor(100000 + Math.random() * 900000).toString();
                $('#resetModalNewPassword').val(randomPass);

                const resetModalEl = document.getElementById('resetPasswordModal');
                const modal = new bootstrap.Modal(resetModalEl);
                modal.show();
            });

            // Generate Random Password button inside modal
            $(document).on('click', '#btnGenerateRandomModalPass', function() {
                let randomPass = Math.floor(100000 + Math.random() * 900000).toString();
                $('#resetModalNewPassword').val(randomPass);
            });

            // Confirm Password Reset inside modal
            $(document).on('click', '#confirmResetPasswordBtn', function() {
                let userId = $('#resetModalUserId').val();
                let userName = $('#resetModalUserName').text();
                let newPassword = $('#resetModalNewPassword').val().trim();

                if (!newPassword) {
                    setupDropdown('dropdownContent', 'warning', svgError + 'Please enter or generate a new password', 'click');
                    $('#resetModalNewPassword').focus();
                    return;
                }

                let btn = $(this);
                btn.prop('disabled', true).html('<i class="ri-loader-4-line spin me-1"></i> Updating...');

                $.ajax({
                    url: '/ResetUserPassword',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        user_id: userId,
                        password: newPassword,
                        action: 'ResetPassword'
                    }),

                    success: function(response) {
                        let res = (typeof response === 'string') ? JSON.parse(response) : response;
                        if (res.success) {
                            const resetModalEl = document.getElementById('resetPasswordModal');
                            const modal = bootstrap.Modal.getInstance(resetModalEl);
                            if (modal) modal.hide();

                            setupDropdown(
                                'dropdownContent',
                                'success',
                                svgSuccess + 'Password for <strong>' + userName + '</strong> reset to: <strong>' + newPassword + '</strong>',
                                'click'
                            );
                            $('#userPassword').val(newPassword);
                            if ($.fn.DataTable.isDataTable('#userTable')) {
                                $('#userTable').DataTable().ajax.reload(null, false);
                            }
                        } else {
                            setupDropdown(
                                'dropdownContent',
                                'error',
                                svgError + 'Password reset failed',
                                'click'
                            );
                        }
                    },

                    error: function() {
                        setupDropdown(
                            'dropdownContent',
                            'error',
                            svgError + 'Server error during password reset',
                            'click'
                        );
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="ri-check-line me-1"></i> Update Password');
                    }
                });
            });

            function loadPermissions(userId = null, roleId = null) {
                let requestUrl = userId ? '/LoadUserPermissions' : (roleId ? '/LoadRolePermissions' : '/LoadMasterPermissions');
                let requestData = { action: userId ? 'LoadUserPermissions' : (roleId ? 'LoadRolePermissions' : 'LoadMasterPermissions') };
                if (userId) requestData.user_id = userId;
                if (roleId) requestData.role_id = roleId;

                $.ajax({
                    url: requestUrl,
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    data: JSON.stringify(requestData),
                    success: function(response) {
                        let responseData = (typeof response === 'string') ? JSON.parse(response) : response;
                        let perms = responseData.data || [];
                        let tbody = $('#permissionsTbody');
                        tbody.empty();

                        if (perms.length === 0) {
                            tbody.html('<tr><td colspan="4" class="text-center text-muted py-3">No permissions found.</td></tr>');
                            return;
                        }

                        perms.forEach(function(perm, index) {
                            let isGranted = (perm.status === 'Granted');
                            let badgeClass = isGranted ? 'bg-label-success' : 'bg-label-danger';
                            let badgeText = isGranted ? 'Granted' : 'Revoked';

                            let rowHtml = `
                                <tr data-perm-name="${(perm.permission_name || '').toLowerCase()}" data-perm-group="${(perm.module_group || '').toLowerCase()}">
                                    <td class="text-center fw-semibold text-muted">${index + 1}</td>
                                    <td><span class="fw-semibold text-dark">${perm.permission_name}</span></td>
                                    <td class="text-center"><span class="badge bg-label-info">${perm.module_group || 'General'}</span></td>
                                    <td class="text-center"><span class="badge ${badgeClass}" id="perm_badge_${perm.permission_id}">${badgeText}</span></td>
                                </tr>
                            `;
                            tbody.append(rowHtml);
                        });
                    },
                    error: function() {
                        $('#permissionsTbody').html('<tr><td colspan="4" class="text-center text-danger py-3">Error loading permissions.</td></tr>');
                    }
                });
            }

            // Auto-load role permissions into permissions card when role changes
            $(document).on('change', '#select2Basic', function() {
                let selectedRoleIds = $(this).val() || [];
                let editingUserId = $('#editUserId').val();
                if (!editingUserId && selectedRoleIds.length > 0) {
                    loadPermissions(null, selectedRoleIds.join(','));
                } else if (!editingUserId) {
                    $('#permissionsTbody').empty().html('<tr><td colspan="4" class="text-center text-muted py-3">Select one or more roles to see permissions.</td></tr>');
                }
            });

            function getSelectedPermissions() {
                return [];
            }

            // Live permission search filter
            $('#searchPermissions').on('keyup', function() {
                let query = $(this).val().toLowerCase().trim();
                $('#permissionsTbody tr').each(function() {
                    let name = $(this).data('perm-name') || '';
                    let group = $(this).data('perm-group') || '';
                    if (name.includes(query) || group.includes(query)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Open Manage Roles & Permissions Modal
            $('#btnOpenRoleModal').on('click', function(e) {
                e.preventDefault();
                populateRoleMatrixDropdown();
                const modal = new bootstrap.Modal(document.getElementById('rolePermissionsModal'));
                modal.show();
            });

            function populateRoleMatrixDropdown() {
                $.ajax({
                    url: '/LoadRoles',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    processData: false,
                    data: JSON.stringify({ action: 'LoadRoles' }),
                    success: function(res) {
                        let responseData = (typeof res === 'string') ? JSON.parse(res) : res;
                        let roles = responseData.data || [];
                        let select = $('#roleMatrixSelect');
                        select.empty();
                        select.append('<option value="">Select a Role...</option>');
                        roles.forEach(function(r) {
                            select.append(`<option value="${r.role_id}">${r.role_name}</option>`);
                        });
                    }
                });
            }

            // Create New Role
            $('#btnSaveNewRole').on('click', function(e) {
                e.preventDefault();
                let roleName = $('#newRoleNameInput').val().trim();
                if (!roleName) {
                    setupDropdown('dropdownContent', 'error', 'Please enter a role name', 'click');
                    return;
                }

                $.ajax({
                    url: '/CreateRole',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    processData: false,
                    data: JSON.stringify({ action: 'CreateRole', role_name: roleName }),
                    success: function(res) {
                        let responseData = (typeof res === 'string') ? JSON.parse(res) : res;
                        if (responseData.status) {
                            setupDropdown('dropdownContent', 'success', 'Role created successfully!', 'click');
                            $('#newRoleNameInput').val('');
                            loadRoles();
                            populateRoleMatrixDropdown();
                            setTimeout(function() {
                                $('#roleMatrixSelect').val(responseData.role_id).trigger('change');
                            }, 300);
                        } else {
                            setupDropdown('dropdownContent', 'error', responseData.message || 'Error creating role', 'click');
                        }
                    }
                });
            });

            // Select Role in Modal -> Load Role Permissions
            
            function initRoleMatrixDataTable() {
                if ($.fn.DataTable.isDataTable('#roleMatrixTable')) {
                    $('#roleMatrixTable').DataTable().destroy();
                }
                $('#roleMatrixTable').DataTable({
                    paging: false,
                    info: true,
                    searching: true,
                    scrollY: '450px',
                    scrollCollapse: true,
                    order: [] // prevent auto sorting of the first column
                });
            }

            $('#roleMatrixSelect').on('change', function() {
                let roleId = $(this).val();
                let roleName = $('#roleMatrixSelect option:selected').text();
                let tbody = $('#roleMatrixTbody');

                if (!roleId) {
                    $('#roleMatrixTitle').text('Permissions for Selected Role');
                    tbody.html('<tr><td colspan="5" class="text-center text-muted py-3">Select a role above to configure its default permissions.</td></tr>');
                    return;
                }

                $('#roleMatrixTitle').html(`Default Permissions for <strong>${roleName}</strong> Role`);

                $.ajax({
                    url: '/LoadRolePermissions',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    processData: false,
                    data: JSON.stringify({ action: 'LoadRolePermissions', role_id: roleId }),
                    success: function(res) {
                        let responseData = (typeof res === 'string') ? JSON.parse(res) : res;
                        let perms = responseData.data || [];
                        tbody.empty();
                        if (perms.length === 0) {
                            tbody.html('<tr><td colspan="5" class="text-center text-muted py-3">No permissions found.</td></tr>');
                            return;
                        }

                        perms.forEach(function(perm, index) {
                            let isGranted = (perm.status === 'Granted');
                            let badgeClass = isGranted ? 'bg-label-success' : 'bg-label-danger';
                            let badgeText = isGranted ? 'Granted' : 'Revoked';

                            let rowHtml = `
                                <tr>
                                    <td class="text-center fw-semibold text-muted">${index + 1}</td>
                                    <td><span class="fw-semibold text-dark">${perm.permission_name}</span></td>
                                    <td class="text-center"><span class="badge bg-label-info">${perm.module_group || 'General'}</span></td>
                                    <td class="text-center"><span class="badge ${badgeClass}" id="role_perm_badge_${perm.permission_id}">${badgeText}</span></td>
                                    <td class="text-center">
                                        <label class="switch switch-success switch-sm d-inline-block mb-0">
                                            <input type="checkbox" class="switch-input role-permission-switch" id="role_perm_switch_${perm.permission_id}" data-perm-id="${perm.permission_id}" ${isGranted ? 'checked' : ''} />
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </td>
                                </tr>
                            `;
                            tbody.append(rowHtml);
                        });
                        initRoleMatrixDataTable();
                    },
                    error: function(xhr, status, error) {
                        if (xhr && xhr.responseText) {
                            try {
                                let raw = xhr.responseText;
                                let start = raw.indexOf('{');
                                let end = raw.lastIndexOf('}');
                                if (start !== -1 && end !== -1) {
                                    let parsed = JSON.parse(raw.substring(start, end + 1));
                                    if (parsed && parsed.data) {
                                        let perms = parsed.data;
                                        tbody.empty();
                                        perms.forEach(function(perm, index) {
                                            let isGranted = (perm.status === 'Granted');
                                            let badgeClass = isGranted ? 'bg-label-success' : 'bg-label-danger';
                                            let badgeText = isGranted ? 'Granted' : 'Revoked';

                                            let rowHtml = `
                                                <tr>
                                                    <td class="text-center fw-semibold text-muted">${index + 1}</td>
                                                    <td><span class="fw-semibold text-dark">${perm.permission_name}</span></td>
                                                    <td class="text-center"><span class="badge bg-label-info">${perm.module_group || 'General'}</span></td>
                                                    <td class="text-center"><span class="badge ${badgeClass}" id="role_perm_badge_${perm.permission_id}">${badgeText}</span></td>
                                                    <td class="text-center">
                                                        <label class="switch switch-success switch-sm d-inline-block mb-0">
                                                            <input type="checkbox" class="switch-input role-permission-switch" id="role_perm_switch_${perm.permission_id}" data-perm-id="${perm.permission_id}" ${isGranted ? 'checked' : ''} />
                                                            <span class="switch-toggle-slider">
                                                                <span class="switch-on"></span>
                                                                <span class="switch-off"></span>
                                                            </span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            `;
                                            tbody.append(rowHtml);
                                        });
                                        return;
                                    }
                                }
                            } catch (e) {
                                console.error("Fallback error parse failed:", e);
                            }
                        }
                        tbody.html('<tr><td colspan="5" class="text-center text-danger py-3">Error loading role permissions.</td></tr>');
                    }
                });
            });

            // Live status badge update on role switch toggle
            $(document).on('change', '.role-permission-switch', function() {
                let permId = $(this).data('perm-id');
                let isChecked = $(this).is(':checked');
                let badge = $('#role_perm_badge_' + permId);
                if (isChecked) {
                    badge.removeClass('bg-label-danger').addClass('bg-label-success').text('Granted');
                } else {
                    badge.removeClass('bg-label-success').addClass('bg-label-danger').text('Revoked');
                }
            });

            // Grant All inside Modal
            $('#btnModalGrantAll').on('click', function() {
                $('.role-permission-switch').prop('checked', true).trigger('change');
            });

            // Revoke All inside Modal
            $('#btnModalRevokeAll').on('click', function() {
                $('.role-permission-switch').prop('checked', false).trigger('change');
            });

            // Save Role Permissions
            $('#btnSaveRolePermissions').on('click', function(e) {
                e.preventDefault();
                let roleId = $('#roleMatrixSelect').val();
                if (!roleId) {
                    setupDropdown('dropdownContent', 'error', 'Please select a role first', 'click');
                    return;
                }

                let permissions = [];
                $('.role-permission-switch').each(function() {
                    let permId = $(this).data('perm-id');
                    let status = $(this).is(':checked') ? 'Granted' : 'Revoked';
                    if (permId) {
                        permissions.push({ permission_id: permId, status: status });
                    }
                });

                $.ajax({
                    url: '/SaveRolePermissions',
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    processData: false,
                    data: JSON.stringify({ action: 'SaveRolePermissions', role_id: roleId, permissions: permissions }),
                    success: function(res) {
                        let responseData = (typeof res === 'string') ? JSON.parse(res) : res;
                        if (responseData.status) {
                            setupDropdown('dropdownContent', 'success', 'Role permissions saved successfully!', 'click');
                            if ($('#select2Basic').val() == roleId && !$('#editUserId').val()) {
                                loadPermissions();
                            }
                        } else {
                            setupDropdown('dropdownContent', 'error', responseData.message || 'Error saving role permissions', 'click');
                        }
                    }
                });
            });

        });
    </script>

</body>


</html>