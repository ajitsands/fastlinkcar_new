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

// Enforce access permission
require_once dirname(__DIR__) . '/model/common/PermissionHelper.php';
if (!isset($_SESSION['user_permissions']) && !empty($_SESSION['user_id'])) {
    PermissionHelper::loadUserPermissionsIntoSession($_SESSION['user_id'], $_SESSION['user_role_id'] ?? 0, $_SESSION['user_role_name'] ?? '');
}
if (!PermissionHelper::hasPermission('vehicle_insurance_access')) {
    echo "<h2>Access Denied</h2><p>You do not have permission to access this page.</p>";
    exit();
}
?>
<?php
include ROOT_PATH . '/view/envinclude.php';
?>
<!doctype html>

<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/"
  data-template="horizontal-menu-template-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    
    <?php include ROOT_PATH . '/view/templates/title.php'; ?>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/css/vehicle_insurance.css" />

    <!-- Helpers -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
    
    <style>
    .custom-modal-header {
        background: linear-gradient(135deg, #1b3d94, #153075);
        color: white !important; 
        border-bottom: none;
    }
    .custom-modal-header .modal-title {
        color: #fff;
    }
    .custom-modal-header .btn-close {
        filter: invert(1);
        opacity: 1;
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
             
              <?php include('templates/vehicle_insurance/list_body.php'); ?>
             
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
    <?php include ROOT_PATH . '/view/templates/vehicles/vehicle_profile_modal.php'; ?>
    <!-- / Layout wrapper -->

    <!-- Scripts -->
        <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <!-- / Scripts -->

    <!-- Vendors JS -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Add DayJS for date formatting -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>

    <!-- Page JS -->
    <script src="<?= $_ENV['BASE_URL'] ?>user_js/vehicle_insurance.js"></script>
  </body>
</html>
