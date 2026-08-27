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
<html lang="en"
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

    <!-- DataTables & Alert CSS -->
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">

    <style>
        /* Comprehensive override for DataTables selected row, cells, click, hover, and striped states */
        #outsourcingCompanyTable tbody tr,
        #outsourcingCompanyTable tbody tr td {
            cursor: pointer;
            outline: none !important;
            box-shadow: none !important;
        }

        #outsourcingCompanyTable tbody tr:focus,
        #outsourcingCompanyTable tbody tr:active,
        #outsourcingCompanyTable tbody tr:focus-visible,
        #outsourcingCompanyTable tbody tr td:focus,
        #outsourcingCompanyTable tbody tr td:active {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Selected row and all child cells in ALL states (normal, hover, active, striped) */
        #outsourcingCompanyTable tbody tr.selected,
        #outsourcingCompanyTable tbody tr.selected > td,
        #outsourcingCompanyTable tbody tr.selected > th,
        #outsourcingCompanyTable tbody tr.selected:hover,
        #outsourcingCompanyTable tbody tr.selected:hover > td,
        #outsourcingCompanyTable tbody tr.selected:hover > th,
        #outsourcingCompanyTable.dataTable tbody tr.selected,
        #outsourcingCompanyTable.dataTable tbody tr.selected > *,
        #outsourcingCompanyTable.dataTable tbody tr.selected:hover,
        #outsourcingCompanyTable.dataTable tbody tr.selected:hover > *,
        #outsourcingCompanyTable.dataTable.table-hover tbody tr.selected:hover,
        #outsourcingCompanyTable.dataTable.table-hover tbody tr.selected:hover > *,
        #outsourcingCompanyTable.dataTable.table-striped tbody tr.selected,
        #outsourcingCompanyTable.dataTable.table-striped tbody tr.selected > *,
        #outsourcingCompanyTable.dataTable.table-striped tbody tr.selected:hover,
        #outsourcingCompanyTable.dataTable.table-striped tbody tr.selected:hover > *,
        #outsourcingCompanyTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected,
        #outsourcingCompanyTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected > * {
            background-color: #F87C63 !important;
            color: #ffffff !important;
            box-shadow: none !important;
            outline: none !important;
        }

        /* Unselected row hover state */
        #outsourcingCompanyTable tbody tr:not(.selected):hover,
        #outsourcingCompanyTable tbody tr:not(.selected):hover > td,
        #outsourcingCompanyTable tbody tr:not(.selected):hover > th,
        #outsourcingCompanyTable.dataTable tbody tr:not(.selected):hover > *,
        #outsourcingCompanyTable.dataTable.table-hover tbody tr:not(.selected):hover > * {
            background-color: rgba(248, 124, 99, 0.15) !important;
            color: inherit !important;
        }

        /* Responsive spacing & layout adjustments */
        @media (max-width: 991.98px) {
            .container-p-y {
                padding-top: 15px !important;
            }
            .action-buttons-wrapper {
                flex-direction: column;
                align-items: stretch !important;
            }
            .action-buttons-wrapper > button,
            .action-buttons-wrapper > div {
                width: 100%;
            }
            .action-buttons-wrapper > div > button {
                flex: 1;
            }
        }
        @media (min-width: 992px) {
            .container-p-y {
                padding-top: 55px !important;
            }
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
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="row">
                            <!-- Left Column: Form -->
                            <div class="col-12 col-lg-8 mb-4">
                                <form id="OutsourcingCompanyForm" name="OutsourcingCompanyForm">
                                    <input type="hidden" id="companyId" name="ids" value="">
                                    <input type="hidden" id="formAction" name="action" value="add">
                                    <input type="hidden" id="currentStatus" name="status" value="Active">

                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-building-4-line me-2 text-primary"></i>Outsourcing Company Registration Details
                                            </h5>
                                            <div id="statusBadgeContainer">
                                                <span class="badge bg-label-success" id="companyStatusBadge">New Entry</span>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row g-3 mb-4">
                                                <!-- Company Name -->
                                                <div class="col-12 col-md-6">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <input type="text" class="form-control" id="companyName" name="company_name" placeholder="Company Name" required>
                                                        <label for="companyName">Company Name <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <!-- CR Number -->
                                                <div class="col-12 col-md-6">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <input type="text" class="form-control" id="crNumber" name="cr_number" placeholder="CR Number" required>
                                                        <label for="crNumber">CR Number <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <!-- Contact Person Name -->
                                                <div class="col-12 col-md-6">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <input type="text" class="form-control" id="contactPersonName" name="contact_person_name" placeholder="Contact Person Name">
                                                        <label for="contactPersonName">Contact Person Name</label>
                                                    </div>
                                                </div>

                                                <!-- Contact Person Number -->
                                                <div class="col-12 col-md-6">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <input type="tel" class="form-control" id="contactPersonNumber" name="contact_person_number" placeholder="Contact Person Number">
                                                        <label for="contactPersonNumber">Contact Person Number</label>
                                                    </div>
                                                </div>

                                                <!-- Email ID -->
                                                <div class="col-12 col-md-12">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <input type="email" class="form-control" id="emailId" name="email_id" placeholder="Email ID">
                                                        <label for="emailId">Email ID</label>
                                                    </div>
                                                </div>

                                                <!-- Address -->
                                                <div class="col-12 col-md-12">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <textarea class="form-control" id="companyAddress" name="address" placeholder="Company Address" style="height: 100px;"></textarea>
                                                        <label for="companyAddress">Company Address</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 action-buttons-wrapper">
                                                <button type="button" class="btn btn-secondary" id="btn_cancel">
                                                    <i class="ri-refresh-line me-1"></i> Reset / Cancel
                                                </button>

                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-warning d-none" id="toggleStatusBtn" data-permission="outsourcing_company_manage">
                                                        <i class="ri-toggle-line me-1"></i> Deactivate
                                                    </button>
                                                    <button type="submit" class="btn btn-primary" id="saveCompanyBtn" data-permission="outsourcing_company_manage">
                                                        <i class="ri-save-line me-1"></i> Save Company
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Right Column: List Table -->
                            <div class="col-12 col-lg-4">
                                <div class="card shadow-sm">
                                    <div class="card-header p-2">
                                        <input type="text" id="companySearch" class="form-control" placeholder="Type to search companies...">
                                    </div>

                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table id="outsourcingCompanyTable" class="table table-sm table-hover align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Company Name</th>
                                                        <th>CR No.</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Loaded via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                    <!-- / Footer -->
                </div>
            </div>
        </div>
    </div>

    <div id="dropdownContent" style="text-align:center;"></div>

    <!-- Scripts -->
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>

    <script>
        let companyTableInstance = null;
        let selectedCompanyData = null;

        $(document).ready(function () {
            loadCompanyList();

            // Contact Number validation
            $('#contactPersonNumber').on('input', function () {
                this.value = this.value.replace(/[^0-9+]/g, '');
            });

            // Form Submit
            $('#OutsourcingCompanyForm').on('submit', function (e) {
                e.preventDefault();
                saveCompanyData();
            });

            // Cancel / Reset button
            $('#btn_cancel').on('click', function () {
                resetCompanyForm();
            });

            let pendingCompanyId = null;
            let pendingCompanyStatus = null;

            // Toggle Status Button (Activate / Deactivate) using SaNDSAlert modal
            $('#toggleStatusBtn').on('click', function (e) {
                e.preventDefault();
                let companyId = $('#companyId').val() || (selectedCompanyData ? selectedCompanyData.ids : null);
                let companyStatus = $('#currentStatus').val() || (selectedCompanyData ? selectedCompanyData.status : 'Active');

                if (!companyId) {
                    setupDropdown('dropdownContent', 'error', 'No company selected to change status', 'click');
                    return;
                }

                pendingCompanyId = companyId;
                pendingCompanyStatus = companyStatus;

                SaNDSAlert(
                    'Are you sure you want to change the status?',
                    'ChangeCompanyStatus',
                    'warning',
                    '#f39c12',
                    'Yes Change',
                    'Cancel',
                    'Change Status'
                );
            });

            $(document).on('click', '#msg_popup_confirmed', function () {
                let action = $('#message_matter').attr('data-switch-values');
                if (action === 'ChangeCompanyStatus') {
                    let targetSt = (pendingCompanyStatus === 'Active') ? 'Inactive' : 'Active';
                    $.ajax({
                        url: '/OutsourcingCompanyController',
                        type: 'POST',
                        data: JSON.stringify({
                            action: 'update_status',
                            ids: pendingCompanyId,
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
                                resetCompanyForm();
                                loadCompanyList();
                            } else {
                                setupDropdown(
                                    'dropdownContent',
                                    'error',
                                    res.message || 'Status update failed.',
                                    'click'
                                );
                            }
                        },
                        error: function () {
                            setupDropdown(
                                'dropdownContent',
                                'warning',
                                'Server error during status update.',
                                'click'
                            );
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
        });

        function loadCompanyList() {
            if ($.fn.DataTable.isDataTable('#outsourcingCompanyTable')) {
                $('#outsourcingCompanyTable').DataTable().destroy();
                $('#outsourcingCompanyTable tbody').empty();
            }

            companyTableInstance = $('#outsourcingCompanyTable').DataTable({
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
                    url: '/OutsourcingCompanyController',
                    type: 'POST',
                    contentType: 'application/json',
                    data: function () {
                        return JSON.stringify({ action: 'list' });
                    },
                    dataSrc: function (json) {
                        return json.data || [];
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'company_name' },
                    { data: 'cr_number' },
                    {
                        data: 'status',
                        render: function (data) {
                            if (data === 'Active') {
                                return '<span class="badge bg-label-success">Active</span>';
                            } else {
                                return '<span class="badge bg-label-danger">Inactive</span>';
                            }
                        }
                    }
                ]
            });

            // Live Search
            $('#companySearch').off('keyup').on('keyup', function () {
                companyTableInstance.search(this.value).draw();
            });

            // Table Row Click Event
            $('#outsourcingCompanyTable tbody').off('click', 'tr').on('click', 'tr', function () {
                let table = $('#outsourcingCompanyTable').DataTable();
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                let rowData = table.row(this).data();
                if (rowData) {
                    selectedCompanyData = rowData;
                    loadCompanyForEdit(rowData);
                }
            });
        }

        function loadCompanyForEdit(data) {
            $('#companyId').val(data.ids);
            $('#formAction').val('update');
            $('#companyName').val(data.company_name);
            $('#crNumber').val(data.cr_number);
            $('#contactPersonName').val(data.contact_person_name || '');
            $('#contactPersonNumber').val(data.contact_person_number || '');
            $('#emailId').val(data.email_id || '');
            $('#companyAddress').val(data.address || '');
            $('#currentStatus').val(data.status || 'Active');

            $('#saveCompanyBtn').html('<i class="ri-save-line me-1"></i> Update Company');

            // Status Badge & Toggle Button update
            if (data.status === 'Active') {
                $('#companyStatusBadge').attr('class', 'badge bg-label-success').text('Active');
                $('#toggleStatusBtn')
                    .removeClass('d-none btn-success')
                    .addClass('btn-warning')
                    .html('<i class="ri-close-circle-line me-1"></i> Deactivate');
            } else {
                $('#companyStatusBadge').attr('class', 'badge bg-label-danger').text('Inactive');
                $('#toggleStatusBtn')
                    .removeClass('d-none btn-warning')
                    .addClass('btn-success')
                    .html('<i class="ri-checkbox-circle-line me-1"></i> Activate');
            }
        }

        function resetCompanyForm() {
            $('#OutsourcingCompanyForm')[0].reset();
            $('#companyId').val('');
            $('#formAction').val('add');
            $('#currentStatus').val('Active');
            selectedCompanyData = null;

            $('#saveCompanyBtn').html('<i class="ri-save-line me-1"></i> Save Company');
            $('#companyStatusBadge').attr('class', 'badge bg-label-success').text('New Entry');
            $('#toggleStatusBtn').addClass('d-none');

            if (companyTableInstance) {
                companyTableInstance.$('tr.selected').removeClass('selected');
            }
        }

        function saveCompanyData() {
            if (!$('#companyName').val().trim()) {
                Swal.fire('Validation Error', 'Please enter company name.', 'warning');
                return;
            }
            if (!$('#crNumber').val().trim()) {
                Swal.fire('Validation Error', 'Please enter CR number.', 'warning');
                return;
            }

            const formData = {
                action: $('#formAction').val(),
                ids: $('#companyId').val(),
                company_name: $('#companyName').val().trim(),
                cr_number: $('#crNumber').val().trim(),
                contact_person_name: $('#contactPersonName').val().trim(),
                contact_person_number: $('#contactPersonNumber').val().trim(),
                email_id: $('#emailId').val().trim(),
                address: $('#companyAddress').val().trim()
            };

            $('#saveCompanyBtn').prop('disabled', true);

            $.ajax({
                url: '/OutsourcingCompanyController',
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (res) {
                    $('#saveCompanyBtn').prop('disabled', false);
                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        resetCompanyForm();
                        loadCompanyList();
                    } else {
                        Swal.fire('Error', res.message || 'Saving failed.', 'error');
                    }
                },
                error: function () {
                    $('#saveCompanyBtn').prop('disabled', false);
                    Swal.fire('Error', 'An error occurred while communicating with server.', 'error');
                }
            });
        }
    </script>
</body>
</html>
