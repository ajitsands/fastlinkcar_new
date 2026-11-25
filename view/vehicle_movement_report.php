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
require_once ROOT_PATH . '/pdf/print_settings_helper.php';
$vmCompanyId = !empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1;
$vmPrintSettings = getPrintSettings(null, $vmCompanyId);
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css" />

    <style>
        .layout-menu-horizontal .menu-sub {
            width: max-content !important;
        }
        .layout-menu-horizontal .menu-sub .menu-link {
            white-space: nowrap !important;
        }
        
        .dt-buttons .btn {
            margin-right: 5px;
        }
        #movementReportTable thead th {
            background-color: #1b3d94 !important;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-color: #16337d !important;
            padding: 0.65rem 0.75rem;
            white-space: nowrap;
        }
        #movementReportTable tbody td {
            padding: 0.6rem 0.75rem;
            vertical-align: middle;
            border-color: #e6ebf5;
        }
        #movementReportTable tbody tr:hover {
            background-color: #f6f8fd !important;
        }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border-radius: 0.375rem;
            border: 1px solid #d5dce8;
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
                    
                    <?php include ROOT_PATH . '/view/templates/VehicleMovementReport/VehicleMovementReportBody.php'; ?>
                         
                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>
    
    <div id="dropdownContent" style="text-align:center;"></div> 
   

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    
    <!-- Print and Export dependencies -->
    <!-- (jsPDF is loaded below) -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-selects.js"></script>
    
    <!-- jsPDF AutoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    <script>
        window.MOVEMENT_PRINT_SETTINGS = <?= json_encode($vmPrintSettings, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    </script>
    <script src="../httpdocs/user_js/vehicle_movement_report.js?v=<?= time() ?>"></script>
    
</body>
</html>
