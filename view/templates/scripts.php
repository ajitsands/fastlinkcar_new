    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/jquery/jquery.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/hammer/hammer.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/i18n/i18n.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/main.js"></script>


	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const savedLogo = localStorage.getItem('selectedCompanyLogo');
			const logo = document.getElementById('companyLogo');

			if (savedLogo && logo) {
				logo.src = savedLogo;
			}
		});
	</script>