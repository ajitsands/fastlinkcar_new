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

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>

    <style>
       .custom-modal-header {
           background: linear-gradient(135deg, #f12526, #c81e1f);
           color: #ffffff;
           border-bottom: none;
       }
       .custom-modal-header .modal-title {
           font-weight: 600;
           color:#ffffff;
       }
       .custom-modal-header .btn-close {
           filter: invert(1) grayscale(100%) brightness(200%);
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
            <?php include ROOT_PATH . '/view/templates/maintenance/maintenance_body.php'; ?>
          </div>
          <!-- / Content -->

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
  <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
  <script src="../assets/vendor/libs/select2/select2.js"></script>
  <script src="../assets/js/forms-selects.js"></script>
  <script src="../assets/sands/settings.js"></script>
  <script src="../assets/sands/sands_popup.js"></script>
  <script src="../alertmessage/js/sandsalert.js"></script>
  
  <!-- Page JS -->
  <script src="../httpdocs/user_js/maintenance.js"></script>
</body>
</html>
