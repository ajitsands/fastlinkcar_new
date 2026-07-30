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

            loadRoles();
            loadCompanies();
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
                        $('#select2Basic').append('<option value="">Select Role</option>');

                        roles.forEach(function(role) {

                            $('#select2Basic').append(
                                `<option value="${role.role_id}">${role.role_name}</option>`
                            );

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

                

                $('#select2Basic').val('').trigger('change');
                  const allCompanyIds = $('#select2Multiple option').map(function () {
                    return this.value;
                }).get();
            
                $('#select2Multiple').val(allCompanyIds).trigger('change');

                $('#userName').val('').prop('disabled', false);
                $('#userPassword').val('').prop('disabled', false);

                // clear images
                uploadedImages = [];
                $('#imagePreview').html('<img id="previewImg" src="assets/img/users/default.jpg" alt="Preview" style="width:100%; height:100%; object-fit:cover;">');
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
                let roleId = $('#select2Basic').val();
                let roleName = $('#select2Basic option:selected').text();
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
                if (roleId === '' || roleId === null) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please select a user role', 'click');
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

                if (username.trim() !== '') {
                    return;
                }

                $.ajax({
                    url: '/CheckUsername',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        username: username,
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
                //pageLength: 100,
                searching: true,
                lengthChange: false,
                dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'>>" + // top row: entries left, empty right
                    "<'row'<'col-sm-12'tr>>" + // table
                    "<'row mt-2'<'col-sm-6'i><'col-sm-6 d-flex justify-content-end'p>>",

                columnDefs: [{
                    targets: [0, 1, 9],
                    className: "text-center"
                }],

                ajax: {
                    url: '/ListOfUsers',
                    type: 'POST',
                    data: function(d) {
                        return JSON.stringify({
                            action: 'LoadUserList'
                        });
                    },
                    contentType: "application/json",
                    dataSrc: 'data',
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                },

                columns: [

                    {
                        data: null,
                        title: 'S.No',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'profile_image',
                        title: 'Image',
                        render: function(data) {

                            if (!data || data === '') {
                                data = 'default.jpg';
                            }

                            return `<img src="assets/img/users/${data}" 
                            width="40" 
                            height="40" 
                            style="border-radius:50%;object-fit:cover;">`;
                        }

                    },
                    {
                        data: 'profile_name',
                        title: 'Name',
                        width: '200px'
                    },
                    {
                        data: 'user_name',
                        title: 'Username'
                    },
                    {
                        data: 'user_passkey',
                        visible: false
                    },
                    {
                        data: 'user_email',
                        title: 'Email'
                    },
                    {
                        data: 'user_mobile',
                        title: 'Phone'
                    },
                    {
                        data: 'user_role_name',
                        title: 'Role'
                    },
                    {
                        data: 'company_json',
                        title: 'Companies',
                        visible: false,
                        render: function(data) {

                            if (!data) return '';

                            let companies = [];

                            try {
                                let jsonData = JSON.parse(data);

                                jsonData.forEach(function(item) {
                                    companies.push(item.company_name);
                                });

                            } catch (e) {
                                console.log(e);
                            }

                            return companies.join(', ');
                        }
                    },
                    {
                        data: 'user_status',
                        title: 'Status',

                        render: function(data, type, row) {

                            switch (data) {

                                case 'Active':
                                    return '<span class="badge rounded-pill bg-label-success">Active</span>';

                                case 'Deactive':
                                    return '<span class="badge rounded-pill bg-label-danger">Deactive</span>';

                                default:
                                    return '<span class="badge rounded-pill bg-label-secondary">' + data + '</span>';
                            }

                        }
                    },

                    {
                        data: null,
                        title: 'Actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-more-2-line icon-22px text-body-secondary"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a class="dropdown-item edit-user"
                                    href="javascript:void(0);"
                                    data-row='${JSON.stringify(row)}'>
                                    Edit
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item change-status"
                                    href="javascript:void(0);"
                                    data-id="${row.user_id}"
                                    data-status="${row.user_status}">
                                    Change Status
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item reset-password"
                                    href="javascript:void(0);"
                                    data-id="${row.user_id}">
                                    Reset Password
                                    </a>
                                </li>

                            </ul>
                        </div>`;
                        }
                    }

                ]

            });

            $('#searchUser').on('keyup', function() {

                table.search(this.value).draw();

            });

            // Edit user form details
            $(document).on('click', '.edit-user', function() {

                $('#saveUserData').hide();
                $('#updateUserData').show();

                let rowData = $(this).data('row');

                fillUserForm(rowData);

            });

            function fillUserForm(data) {

                $('#editUserId').val(data.user_id);

                $('#userProfileName').val(data.profile_name);
                $('#userName').val(data.user_name).prop('disabled', true);
                $('#userPassword').val(data.user_passkey).prop('disabled', true);
                $('#userEmail').val(data.user_email);
                $('#userPhoneNumber').val(data.user_mobile);

                // Role select
                $('#select2Basic').val(data.user_role_id).trigger('change');

                // Companies JSON
                let companies = JSON.parse(data.company_json);

                let companyIds = companies.map(c => c.ids);
                $('#select2Multiple').val(companyIds).trigger('change');

                if (data.profile_image) {

                    $('#imagePreview').html(`
                    <img src="assets/img/users/${data.profile_image}"
                    width="50"
                    height="50"
                    style="border-radius:50%; object-fit:cover; border:2px solid #ddd;">
                `);
                    //$('#fileNameDisplay').text(data.profile_image);
                    $('#uploadedImageName').val(data.profile_image);
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
                let roleId = $('#select2Basic').val();
                let roleName = $('#select2Basic option:selected').text();
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
                if (roleId === '' || roleId === null) {
                    setupDropdown('dropdownContent', 'error', svgError + 'Please select a user role', 'click');
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
                    roleId: $('#select2Basic').val(),
                    roleName: $('#select2Basic option:selected').text(),
                    companies: companies,
                    userImage: $('#uploadedImageName').val()
                };

                updateUser(formData);

            });

            // change status click function
            let userId = null;
            let currentStatus = null;

            $(document).on('click', '.change-status', function() {

                userId = $(this).data('id');
                currentStatus = $(this).data('status');

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

            $(document).on('click', '.reset-password', function() {

                let userId = $(this).data('id');
                //alert('hi' + userId);
                resetUserPassword(userId);
            });

            function resetUserPassword(userId) {
                let randomPassword = Math.floor(10000 + Math.random() * 90000).toString();
                $.ajax({
                    url: '/ResetUserPassword',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        user_id: userId,
                        password: randomPassword,
                        action: 'ResetPassword'
                    }),

                    success: function(response) {
                        //console.log(response);
                        if (response.success) {
                            setupDropdown(
                                'dropdownContent',
                                'success',
                                svgSuccess + 'Password reset to '+randomPassword+' successfully',
                                'click'
                            );
                            $('#userTable').DataTable().ajax.reload(null, false);
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
                            svgError + 'Server error',
                            'click'
                        );
                    }

                });

            }

        });
    </script>

</body>


</html>