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

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">

    <style>
        /* Comprehensive override for DataTables selected row, cells, click, hover, and striped states */
        #garageTable tbody tr, #garageTable tbody tr td,
        #serviceTable tbody tr, #serviceTable tbody tr td {
            cursor: pointer;
            outline: none !important;
            box-shadow: none !important;
        }

        #garageTable tbody tr:focus, #garageTable tbody tr:active, #garageTable tbody tr:focus-visible,
        #garageTable tbody tr td:focus, #garageTable tbody tr td:active,
        #serviceTable tbody tr:focus, #serviceTable tbody tr:active, #serviceTable tbody tr:focus-visible,
        #serviceTable tbody tr td:focus, #serviceTable tbody tr td:active {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Selected row and all child cells in ALL states (normal, hover, active, striped) */
        #garageTable tbody tr.selected, #garageTable tbody tr.selected > td, #garageTable tbody tr.selected > th,
        #garageTable tbody tr.selected:hover, #garageTable tbody tr.selected:hover > td, #garageTable tbody tr.selected:hover > th,
        #garageTable.dataTable tbody tr.selected, #garageTable.dataTable tbody tr.selected > *,
        #garageTable.dataTable tbody tr.selected:hover, #garageTable.dataTable tbody tr.selected:hover > *,
        #garageTable.dataTable.table-hover tbody tr.selected:hover, #garageTable.dataTable.table-hover tbody tr.selected:hover > *,
        #garageTable.dataTable.table-striped tbody tr.selected, #garageTable.dataTable.table-striped tbody tr.selected > *,
        #garageTable.dataTable.table-striped tbody tr.selected:hover, #garageTable.dataTable.table-striped tbody tr.selected:hover > *,
        #garageTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected, #garageTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected > *,
        #serviceTable tbody tr.selected, #serviceTable tbody tr.selected > td, #serviceTable tbody tr.selected > th,
        #serviceTable tbody tr.selected:hover, #serviceTable tbody tr.selected:hover > td, #serviceTable tbody tr.selected:hover > th,
        #serviceTable.dataTable tbody tr.selected, #serviceTable.dataTable tbody tr.selected > *,
        #serviceTable.dataTable tbody tr.selected:hover, #serviceTable.dataTable tbody tr.selected:hover > *,
        #serviceTable.dataTable.table-hover tbody tr.selected:hover, #serviceTable.dataTable.table-hover tbody tr.selected:hover > *,
        #serviceTable.dataTable.table-striped tbody tr.selected, #serviceTable.dataTable.table-striped tbody tr.selected > *,
        #serviceTable.dataTable.table-striped tbody tr.selected:hover, #serviceTable.dataTable.table-striped tbody tr.selected:hover > *,
        #serviceTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected, #serviceTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected > * {
            background-color: #2b54b8 !important;
            color: #ffffff !important;
            box-shadow: none !important;
            outline: none !important;
        }

        /* Unselected row hover state */
        #garageTable tbody tr:not(.selected):hover, #garageTable tbody tr:not(.selected):hover > td, #garageTable tbody tr:not(.selected):hover > th,
        #garageTable.dataTable tbody tr:not(.selected):hover > *, #garageTable.dataTable.table-hover tbody tr:not(.selected):hover > *,
        #serviceTable tbody tr:not(.selected):hover, #serviceTable tbody tr:not(.selected):hover > td, #serviceTable tbody tr:not(.selected):hover > th,
        #serviceTable.dataTable tbody tr:not(.selected):hover > *, #serviceTable.dataTable.table-hover tbody tr:not(.selected):hover > * {
            background-color: rgba(43, 84, 184, 0.15) !important;
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
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 55px !important">
                        
                        <?php include ROOT_PATH . '/view/templates/garages/garage_body.php'; ?>
                        <?php include ROOT_PATH . '/view/templates/customer/confirm_action_modal.php'; ?>

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

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <div id="dropdownContent" style="text-align:center;"></div>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>

    <!-- Page specific JS -->
    <script>
        let isEditGarage = false;
        let selectedGarageData = null;
        let pendingGarageId = null;
        let pendingGarageStatus = null;

        let isEditService = false;
        let selectedServiceData = null;
        let pendingServiceId = null;
        let pendingServiceStatus = null;

        $(document).ready(function () {
            load_garage_list();
            load_garage_service_list();

            $('#garageSearch').on('keyup', function () {
                $('#garageTable').DataTable().search(this.value).draw();
            });

            $('#serviceSearch').on('keyup', function () {
                $('#serviceTable').DataTable().search(this.value).draw();
            });

            // ------------- GARAGE JS -------------
            function load_garage_list() {
                if ($.fn.DataTable.isDataTable('#garageTable')) {
                    $('#garageTable').DataTable().destroy();
                    $('#garageTable tbody').empty();
                }

                let table = $('#garageTable').DataTable({
                    ajax: {
                        url: '/GarageController',
                        type: 'POST',
                        data: function(d) {
                            return JSON.stringify({ action: 'LoadGarages' });
                        },
                        contentType: 'application/json',
                        dataSrc: function (json) {
                            return json.data || [];
                        }
                    },
                    columns: [
                        { data: 'garage_code' },
                        { data: 'garage_name' },
                        {
                            data: 'status',
                            render: function (data, type, row) {
                                if (data === 'Available' || data === 'Active') {
                                    return '<span class="badge bg-label-success">Available</span>';
                                } else {
                                    return '<span class="badge bg-label-danger">Deactivated</span>';
                                }
                            }
                        }
                    ]
                });
            }

            // Row Selection for Garage
            $('#garageTable tbody').on('click', 'tr', function () {
                let table = $('#garageTable').DataTable();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    resetGarageForm();
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    let data = table.row(this).data();
                    if (data) {
                        loadGarageForEdit(data);
                    }
                }
            });

            function loadGarageForEdit(data) {
                isEditGarage = true;
                selectedGarageData = data;
                
                $('#garageId').val(data.ids);
                $('#garageCode').val(data.garage_code);
                $('#garageName').val(data.garage_name);
                $('#garageAddress').val(data.address);
                $('#contactPerson').val(data.contact_person);
                $('#contactNumber').val(data.contact_number);
                $('#emailId').val(data.email_id);

                $('#saveGarageBtn').html('<i class="ri-save-line me-1"></i> Update Garage');
                
                // Status Toggle Button
                $('#toggleGarageStatusBtn').removeClass('d-none');
                if (data.status === 'Available' || data.status === 'Active') {
                    $('#garageStatusBadge').attr('class', 'badge bg-label-success').text('Available');
                    $('#toggleGarageStatusBtn')
                        .removeClass('btn-success')
                        .addClass('btn-warning')
                        .html('<i class="ri-close-circle-line me-1"></i> Deactivate');
                } else {
                    $('#garageStatusBadge').attr('class', 'badge bg-label-danger').text('Deactivated');
                    $('#toggleGarageStatusBtn')
                        .removeClass('btn-warning')
                        .addClass('btn-success')
                        .html('<i class="ri-checkbox-circle-line me-1"></i> Activate');
                }
            }

            function resetGarageForm() {
                isEditGarage = false;
                selectedGarageData = null;
                $('#garageForm')[0].reset();
                $('#garageId').val('');
                $('#saveGarageBtn').html('<i class="ri-save-line me-1"></i> Save Garage');
                $('#garageStatusBadge').attr('class', 'badge bg-label-success').text('New Entry');
                $('#toggleGarageStatusBtn').addClass('d-none');
                $('#garageTable').DataTable().$('tr.selected').removeClass('selected');
            }

            $('#resetGarageBtn').on('click', function() {
                resetGarageForm();
            });

            $('#saveGarageBtn').on('click', function(e) {
                e.preventDefault();
                let garageName = $('#garageName').val();
                if(!garageName) {
                    setupDropdown('dropdownContent', 'warning', 'Garage Name is required', 'click');
                    return;
                }

                let postData = {
                    action: isEditGarage ? 'UpdateGarage' : 'AddGarage',
                    garage_id: $('#garageId').val(),
                    garage_code: $('#garageCode').val(),
                    garage_name: garageName,
                    address: $('#garageAddress').val(),
                    contact_person: $('#contactPerson').val(),
                    contact_number: $('#contactNumber').val(),
                    email_id: $('#emailId').val()
                };

                let btn = $(this);
                let originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="ri-loader-4-line spin"></i> Saving...');

                $.ajax({
                    url: '/GarageController',
                    type: 'POST',
                    data: JSON.stringify(postData),
                    contentType: 'application/json',
                    success: function(res) {
                        let resObj = typeof res === 'string' ? JSON.parse(res) : res;
                        if(resObj && resObj.status === false) {
                            setupDropdown('dropdownContent', 'error', resObj.message, 'click');
                            btn.prop('disabled', false).html(originalHtml);
                            return;
                        }
                        
                        setupDropdown('dropdownContent', 'success', resObj.message, 'click');
                        load_garage_list();
                        resetGarageForm();
                    },
                    error: function() {
                        setupDropdown('dropdownContent', 'error', 'Error saving garage', 'click');
                        btn.prop('disabled', false).html(originalHtml);
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        if(selectedGarageData !== null) {
                            btn.html('<i class="ri-save-line me-1"></i> Update Garage');
                        } else {
                            btn.html('<i class="ri-save-line me-1"></i> Save Garage');
                        }
                    }
                });
            });

            $('#toggleGarageStatusBtn').on('click', function () {
                if (!selectedGarageData) return;
                pendingGarageId = selectedGarageData.ids;
                pendingGarageStatus = selectedGarageData.status;

                let actionText = (pendingGarageStatus === 'Available' || pendingGarageStatus === 'Active') ? 'deactivate' : 'activate';
                SaNDSAlert(
                    `Are you sure you want to ${actionText} this Garage?`, 
                    'ChangeGarageStatus', 
                    'warning', 
                    '#ff9900', 
                    'Yes, Change', 
                    'Cancel', 
                    'Confirm Status Change'
                );
            });


            // ------------- SERVICE JS -------------
            function load_garage_service_list() {
                if ($.fn.DataTable.isDataTable('#serviceTable')) {
                    $('#serviceTable').DataTable().destroy();
                    $('#serviceTable tbody').empty();
                }

                let table = $('#serviceTable').DataTable({
                    ajax: {
                        url: '/GarageController',
                        type: 'POST',
                        data: function(d) {
                            return JSON.stringify({ action: 'LoadGarageServices' });
                        },
                        contentType: 'application/json',
                        dataSrc: function (json) {
                            return json.data || [];
                        }
                    },
                    columns: [
                        { data: 'service_name' },
                        {
                            data: 'status',
                            render: function (data, type, row) {
                                if (data === 'Available' || data === 'Active') {
                                    return '<span class="badge bg-label-success">Available</span>';
                                } else {
                                    return '<span class="badge bg-label-danger">Deactivated</span>';
                                }
                            }
                        }
                    ]
                });
            }

            // Row Selection for Service
            $('#serviceTable tbody').on('click', 'tr', function () {
                let table = $('#serviceTable').DataTable();
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    resetServiceForm();
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    let data = table.row(this).data();
                    if (data) {
                        loadServiceForEdit(data);
                    }
                }
            });

            function loadServiceForEdit(data) {
                isEditService = true;
                selectedServiceData = data;
                
                $('#serviceId').val(data.ids);
                $('#serviceName').val(data.service_name);
                $('#serviceUnit').val(data.unit);
                $('#serviceCharge').val(data.charge_per_unit);

                $('#saveServiceBtn').html('<i class="ri-save-line me-1"></i> Update Service');
                
                // Status Toggle Button
                $('#toggleServiceStatusBtn').removeClass('d-none');
                if (data.status === 'Available' || data.status === 'Active') {
                    $('#serviceStatusBadge').attr('class', 'badge bg-label-success').text('Available');
                    $('#toggleServiceStatusBtn')
                        .removeClass('btn-success')
                        .addClass('btn-warning')
                        .html('<i class="ri-close-circle-line me-1"></i> Deactivate');
                } else {
                    $('#serviceStatusBadge').attr('class', 'badge bg-label-danger').text('Deactivated');
                    $('#toggleServiceStatusBtn')
                        .removeClass('btn-warning')
                        .addClass('btn-success')
                        .html('<i class="ri-checkbox-circle-line me-1"></i> Activate');
                }
            }

            function resetServiceForm() {
                isEditService = false;
                selectedServiceData = null;
                $('#serviceForm')[0].reset();
                $('#serviceId').val('');
                $('#saveServiceBtn').html('<i class="ri-save-line me-1"></i> Save Service');
                $('#serviceStatusBadge').attr('class', 'badge bg-label-success').text('New Entry');
                $('#toggleServiceStatusBtn').addClass('d-none');
                $('#serviceTable').DataTable().$('tr.selected').removeClass('selected');
            }

            $('#resetServiceBtn').on('click', function() {
                resetServiceForm();
            });

            $('#saveServiceBtn').on('click', function(e) {
                e.preventDefault();
                let serviceName = $('#serviceName').val();
                if(!serviceName) {
                    setupDropdown('dropdownContent', 'warning', 'Service Name is required', 'click');
                    return;
                }

                let postData = {
                    action: isEditService ? 'UpdateGarageService' : 'AddGarageService',
                    service_id: $('#serviceId').val(),
                    service_name: serviceName,
                    unit: $('#serviceUnit').val(),
                    charge_per_unit: $('#serviceCharge').val()
                };

                let btn = $(this);
                let originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="ri-loader-4-line spin"></i> Saving...');

                $.ajax({
                    url: '/GarageController',
                    type: 'POST',
                    data: JSON.stringify(postData),
                    contentType: 'application/json',
                    success: function(res) {
                        let resObj = typeof res === 'string' ? JSON.parse(res) : res;
                        if(resObj && resObj.status === false) {
                            setupDropdown('dropdownContent', 'error', resObj.message, 'click');
                            btn.prop('disabled', false).html(originalHtml);
                            return;
                        }
                        
                        setupDropdown('dropdownContent', 'success', resObj.message, 'click');
                        load_garage_service_list();
                        resetServiceForm();
                    },
                    error: function() {
                        setupDropdown('dropdownContent', 'error', 'Error saving service', 'click');
                        btn.prop('disabled', false).html(originalHtml);
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        if(selectedServiceData !== null) {
                            btn.html('<i class="ri-save-line me-1"></i> Update Service');
                        } else {
                            btn.html('<i class="ri-save-line me-1"></i> Save Service');
                        }
                    }
                });
            });

            $('#toggleServiceStatusBtn').on('click', function () {
                if (!selectedServiceData) return;
                pendingServiceId = selectedServiceData.ids;
                pendingServiceStatus = selectedServiceData.status;

                let actionText = (pendingServiceStatus === 'Available' || pendingServiceStatus === 'Active') ? 'deactivate' : 'activate';
                SaNDSAlert(
                    `Are you sure you want to ${actionText} this Service?`, 
                    'ChangeGarageServiceStatus', 
                    'warning', 
                    '#ff9900', 
                    'Yes, Change', 
                    'Cancel', 
                    'Confirm Status Change'
                );
            });


            // ------------- SaNDS Alert Handler -------------
            $(document).on('click', '#msg_popup_confirmed', function () {
                let action = $('#message_matter').attr('data-switch-values');
                
                if (action === 'ChangeGarageStatus') {
                    let targetSt = (pendingGarageStatus === 'Available' || pendingGarageStatus === 'Active') ? 'Deactivated' : 'Available';
                    $.ajax({
                        url: '/GarageController',
                        type: 'POST',
                        data: JSON.stringify({
                            action: 'ChangeGarageStatus',
                            garage_id: pendingGarageId,
                            status: targetSt
                        }),
                        contentType: 'application/json',
                        dataType: 'json',
                        success: function (res) {
                            if (res.status || res === true) {
                                setupDropdown('dropdownContent', 'success', 'Garage Status Changed Successfully', 'click');
                                load_garage_list();
                                if (selectedGarageData && selectedGarageData.ids === pendingGarageId) {
                                    selectedGarageData.status = targetSt;
                                    loadGarageForEdit(selectedGarageData);
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
                else if (action === 'ChangeGarageServiceStatus') {
                    let targetSt = (pendingServiceStatus === 'Available' || pendingServiceStatus === 'Active') ? 'Deactivated' : 'Available';
                    $.ajax({
                        url: '/GarageController',
                        type: 'POST',
                        data: JSON.stringify({
                            action: 'ChangeGarageServiceStatus',
                            service_id: pendingServiceId,
                            status: targetSt
                        }),
                        contentType: 'application/json',
                        dataType: 'json',
                        success: function (res) {
                            if (res.status || res === true) {
                                setupDropdown('dropdownContent', 'success', 'Service Status Changed Successfully', 'click');
                                load_garage_service_list();
                                if (selectedServiceData && selectedServiceData.ids === pendingServiceId) {
                                    selectedServiceData.status = targetSt;
                                    loadServiceForEdit(selectedServiceData);
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

        }); // Document Ready
    </script>
</body>
</html>
