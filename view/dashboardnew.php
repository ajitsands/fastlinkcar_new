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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">

    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">

    <!-- Operations Dashboard Custom Styles & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/css/operations-dashboard.css" />

    <!-- Helpers -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
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
            <?php include ROOT_PATH . '/view/templates/dashboard/dashboard_body.php'; ?>
            <!--/ Content -->

            <!-- Modals -->
            <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>
            <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicleInfoModal.php'; ?>
            <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_calender_modal.php'; ?>
            <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_return_calender.php'; ?>

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
    <div class="drag-target"></div>

    <!-- Core JS -->
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

    <!-- Vendors JS -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/js/forms-selects.js"></script>
    <script src="../assets/sands/settings.js"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>
    <script src="../httpdocs/user_js/vehicle_info.js"></script>

    <!-- Operations Dashboard Engine -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/operations-dashboard.js"></script>
  </body>
</html>
