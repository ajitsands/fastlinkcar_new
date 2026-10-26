<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: /Logout');
    exit();
}
?>
<script>
(function() {
    let savedTheme = localStorage.getItem('app_theme_mode') || 'light';
    let activeTheme = savedTheme;
    if (savedTheme === 'system') {
        activeTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    document.documentElement.setAttribute('data-bs-theme', activeTheme);
    if (activeTheme === 'dark') {
        document.documentElement.classList.add('dark-style');
        document.documentElement.classList.remove('light-style');
    } else {
        document.documentElement.classList.add('light-style');
        document.documentElement.classList.remove('dark-style');
    }
})();
</script>
<meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>AA Car Rental Portal</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $_ENV['BASE_URL'] ?>assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/node-waves/node-waves.css" />

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
	
	<style>
        /* Global Table Header Styling (Matches ContractList) */
        table.dataTable thead th, .table thead th {
            background-color: #ffeff0 !important;
            color: #d12222 !important;
            border-bottom: 2px solid #d12222 !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
        }
        
		/* Top Header Navbar with Vibrant Gradient & Glassmorphism */
		#layout-navbar,
		.layout-navbar {
			background: linear-gradient(135deg, rgba(241, 37, 38, 0.94), rgba(241, 103, 35, 0.90)) !important;
			backdrop-filter: blur(12px) saturate(180%) !important;
			-webkit-backdrop-filter: blur(12px) saturate(180%) !important;
			border-bottom: 1px solid rgba(255, 255, 255, 0.25) !important;
			box-shadow: 0 4px 20px rgba(241, 37, 38, 0.2) !important;
		}
		#layout-navbar .navbar-brand,
		#layout-navbar .nav-link,
		#layout-navbar .menu-text {
			color: #ffffff !important;
			text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
		}

		/* Brand Logo & Title Height Matching & Vertical Alignment */
		.app-brand-link {
			display: inline-flex !important;
			align-items: center !important;
			gap: 10px !important;
		}

		.app-brand-logo,
		#companyLogo,
		.app-logo {
			height: 32px !important;
			max-height: 32px !important;
			width: auto !important;
			object-fit: contain !important;
			vertical-align: middle !important;
		}

		.app-brand-text,
		.menu-text {
			font-size: 1.15rem !important;
			font-weight: 600 !important;
			line-height: 1.2 !important;
			color: #ffffff !important;
			margin-bottom: 0 !important;
			letter-spacing: 0.3px !important;
		}

		/* Horizontal Menu Bar with Glassmorphic Effect & Gentle Shadow */
		#layout-menu,
		.layout-menu-horizontal,
		.menu-horizontal {
			background: linear-gradient(135deg, rgba(255, 255, 255, 0.90), rgba(245, 246, 250, 0.82)) !important;
			backdrop-filter: blur(14px) saturate(160%) !important;
			-webkit-backdrop-filter: blur(14px) saturate(160%) !important;
			border-bottom: 1px solid rgba(255, 255, 255, 0.6) !important;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04), 0 1px 4px rgba(0, 0, 0, 0.03) !important;
		}

		/* Horizontal Menu Bar Container Width */
		#layout-menu .container-fluid,
		.layout-menu-horizontal .container-fluid {
			width: 100% !important;
			max-width: 100% !important;
			padding-left: 1.25rem !important;
			padding-right: 1.25rem !important;
		}

		/* Gentle Menu Link Items, Reduced Font Size & Spacing */
		.layout-menu-horizontal .menu-inner > .menu-item > .menu-link {
			color: #43495b !important;
			font-size: 13px !important;
			font-weight: 500 !important;
			border-radius: 8px !important;
			transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
			padding: 0.45rem 0.85rem !important;
			margin: 0 3px !important;
			white-space: nowrap !important;
		}

		/* Fix Dropdown Down Arrow Indicator Overlap & Rotation */
		.layout-menu-horizontal .menu-inner > .menu-item > .menu-link.menu-toggle {
			padding-right: 2.2rem !important;
			position: relative !important;
		}

		.layout-menu-horizontal .menu-inner > .menu-item > .menu-link.menu-toggle::after {
			right: 0.75rem !important;
			position: absolute !important;
			top: 50% !important;
			transform: translateY(-50%) rotate(90deg) !important;
			margin-left: 0 !important;
			transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), filter 0.2s ease, color 0.2s ease !important;
		}

		/* On Mouse Hover, Active, or Open State: Arrow turns pure white and points straight DOWN */
		.layout-menu-horizontal .menu-inner > .menu-item:hover > .menu-link.menu-toggle::after,
		.layout-menu-horizontal .menu-inner > .menu-item.active > .menu-link.menu-toggle::after,
		.layout-menu-horizontal .menu-inner > .menu-item.open > .menu-link.menu-toggle::after {
			color: #ffffff !important;
			border-color: #ffffff !important;
			filter: brightness(0) invert(1) !important;
			transform: translateY(-50%) rotate(90deg) !important;
		}

		.layout-menu-horizontal .menu-inner > .menu-item > .menu-link i.menu-icon {
			font-size: 1.05rem !important;
			margin-right: 0.4rem !important;
		}

		.layout-menu-horizontal .menu-inner > .menu-item:hover > .menu-link,
		.layout-menu-horizontal .menu-inner > .menu-item.active > .menu-link {
			background: linear-gradient(135deg, #F87C63, #f15031) !important;
			color: #ffffff !important;
			box-shadow: 0 4px 14px rgba(248, 124, 99, 0.38) !important;
			transform: translateY(-1px);
		}

		.layout-menu-horizontal .menu-inner > .menu-item:hover > .menu-link i,
		.layout-menu-horizontal .menu-inner > .menu-item.active > .menu-link i {
			color: #ffffff !important;
		}

		/* Glassmorphic Dropdown Submenus */
		.menu-horizontal .menu-sub {
			background: rgba(255, 255, 255, 0.92) !important;
			backdrop-filter: blur(16px) saturate(180%) !important;
			-webkit-backdrop-filter: blur(16px) saturate(180%) !important;
			border: 1px solid rgba(255, 255, 255, 0.6) !important;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04) !important;
			border-radius: 12px !important;
			padding: 6px !important;
			min-width: 180px !important;
		}

		.menu-horizontal .menu-sub .menu-link {
			font-size: 13px !important;
			border-radius: 6px !important;
			padding: 0.45rem 0.85rem !important;
			transition: all 0.2s ease !important;
		}

		.menu-horizontal .menu-sub .menu-item.active > .menu-link,
		.menu-horizontal .menu-sub .menu-item:hover > .menu-link {
			background: rgba(248, 124, 99, 0.12) !important;
			color: #F87C63 !important;
		}
		.menu-horizontal .menu-sub .menu-item:hover > .menu-link {
			background: rgba(248, 124, 99, 0.12) !important;
			color: #F87C63 !important;
		}

		/* Glassmorphic Footer with Gentle Shadow */
		.content-footer {
			background: linear-gradient(135deg, rgba(255, 255, 255, 0.85), rgba(240, 227, 229, 0.75)) !important;
			backdrop-filter: blur(10px) !important;
			-webkit-backdrop-filter: blur(10px) !important;
			border-top: 1px solid rgba(255, 255, 255, 0.5) !important;
			box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.03) !important;
		}

		/* Global Compact Body & Component Typography */
		body,
		html {
			font-size: 13px !important;
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
			color: #383e4b;
			-webkit-font-smoothing: antialiased;
		}

		/* Compact Form Controls & Floating Labels */
		.form-control,
		.form-select,
		.input-group-text,
		.form-floating > label,
		.form-label,
		.select2-container--default .select2-selection--single,
		.select2-container--default .select2-selection--multiple {
			font-size: 13px !important;
		}

		/* Global DataTables & Tables Typography Override (Matches Body 13px) */
		table.dataTable,
		table.dataTable th,
		table.dataTable td,
		.dataTables_wrapper,
		.table,
		.table th,
		.table td,
		.table tbody td,
		.table thead th,
		table.dataTable tbody td,
		table.dataTable thead th,
		table.dataTable tbody tr td,
		table.dataTable thead tr th {
			font-size: 13px !important;
			padding-top: 6px !important;
			padding-bottom: 6px !important;
		}

		table.dataTable thead th,
		.table thead th {
			font-size: 12.5px !important;
			font-weight: 600 !important;
			text-transform: uppercase !important;
			letter-spacing: 0.3px !important;
		}

		/* DataTables Controls: Search, Length, Info & Pagination */
		.dataTables_wrapper .dataTables_info,
		.dataTables_wrapper .dataTables_length,
		.dataTables_wrapper .dataTables_filter,
		.dataTables_wrapper .dataTables_paginate {
			font-size: 12px !important;
		}

		.dataTables_wrapper .dataTables_filter input,
		.dataTables_wrapper .dataTables_length select {
			font-size: 12px !important;
			padding: 0.3rem 0.6rem !important;
		}

		.dataTables_wrapper .pagination .page-link {
			font-size: 12px !important;
			padding: 0.35rem 0.65rem !important;
		}

		/* Compact Badges, Buttons, & Card Titles */
		.badge {
			font-size: 11.5px !important;
			font-weight: 500 !important;
		}

		.btn {
			font-size: 13px !important;
		}

		.btn-sm {
			font-size: 12px !important;
		}

		.card-title {
			font-size: 15px !important;
			font-weight: 600 !important;
		}

		/* ========================================================= */
		/* DARK MODE STYLES & OVERRIDES                              */
		/* ========================================================= */
		[data-bs-theme="dark"],
		.dark-style {
			color-scheme: dark;
		}

		[data-bs-theme="dark"] body,
		.dark-style body {
			background-color: #171821 !important;
			color: #d0d2e0 !important;
		}

		[data-bs-theme="dark"] .card,
		.dark-style .card {
			background-color: #212330 !important;
			border-color: rgba(255, 255, 255, 0.07) !important;
			box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25) !important;
			color: #d0d2e0 !important;
		}

		[data-bs-theme="dark"] .card-header,
		.dark-style .card-header {
			background-color: transparent !important;
			border-bottom-color: rgba(255, 255, 255, 0.08) !important;
			color: #ffffff !important;
		}

		[data-bs-theme="dark"] .card-title,
		.dark-style .card-title {
			color: #ffffff !important;
		}

		[data-bs-theme="dark"] .form-control,
		[data-bs-theme="dark"] .form-select,
		[data-bs-theme="dark"] .input-group-text,
		.dark-style .form-control,
		.dark-style .form-select,
		.dark-style .input-group-text {
			background-color: #191b26 !important;
			border-color: rgba(255, 255, 255, 0.12) !important;
			color: #e2e4f0 !important;
		}

		[data-bs-theme="dark"] .form-control:focus,
		[data-bs-theme="dark"] .form-select:focus,
		.dark-style .form-control:focus,
		.dark-style .form-select:focus {
			border-color: #F87C63 !important;
			box-shadow: 0 0 0 0.25rem rgba(248, 124, 99, 0.25) !important;
		}

		[data-bs-theme="dark"] .form-floating > label,
		[data-bs-theme="dark"] .form-label,
		.dark-style .form-floating > label,
		.dark-style .form-label {
			color: #a3a6c0 !important;
		}

		/* Tables & DataTables in Dark Mode */
		[data-bs-theme="dark"] table.dataTable,
		[data-bs-theme="dark"] .table,
		.dark-style table.dataTable,
		.dark-style .table {
			color: #d0d2e0 !important;
			border-color: rgba(255, 255, 255, 0.08) !important;
		}

		[data-bs-theme="dark"] table.dataTable thead th,
		[data-bs-theme="dark"] .table thead th,
		.dark-style table.dataTable thead th,
		.dark-style .table thead th {
			background-color: #191b26 !important;
			color: #e2e4f0 !important;
			border-bottom-color: rgba(255, 255, 255, 0.12) !important;
		}

		[data-bs-theme="dark"] table.dataTable tbody td,
		[data-bs-theme="dark"] .table tbody td,
		.dark-style table.dataTable tbody td,
		.dark-style .table tbody td {
			background-color: #212330 !important;
			color: #d0d2e0 !important;
			border-color: rgba(255, 255, 255, 0.06) !important;
		}

		/* Horizontal Menu in Dark Mode */
		[data-bs-theme="dark"] #layout-menu,
		[data-bs-theme="dark"] .layout-menu-horizontal,
		.dark-style #layout-menu,
		.dark-style .layout-menu-horizontal {
			background: linear-gradient(135deg, rgba(33, 35, 48, 0.94), rgba(25, 27, 38, 0.90)) !important;
			border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
		}

		[data-bs-theme="dark"] .layout-menu-horizontal .menu-inner > .menu-item > .menu-link,
		.dark-style .layout-menu-horizontal .menu-inner > .menu-item > .menu-link {
			color: #c0c3d6 !important;
		}

		[data-bs-theme="dark"] .menu-horizontal .menu-sub,
		.dark-style .menu-horizontal .menu-sub {
			background: rgba(33, 35, 48, 0.95) !important;
			border-color: rgba(255, 255, 255, 0.1) !important;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4) !important;
		}

		[data-bs-theme="dark"] .menu-horizontal .menu-sub .menu-link,
		.dark-style .menu-horizontal .menu-sub .menu-link {
			color: #c0c3d6 !important;
		}

		/* Dropdown Menus & Modals in Dark Mode */
		[data-bs-theme="dark"] .dropdown-menu,
		[data-bs-theme="dark"] .modal-content,
		.dark-style .dropdown-menu,
		.dark-style .modal-content {
			background-color: #252736 !important;
			border-color: rgba(255, 255, 255, 0.1) !important;
			color: #d0d2e0 !important;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
		}

		[data-bs-theme="dark"] .dropdown-item,
		.dark-style .dropdown-item {
			color: #c0c3d6 !important;
		}

		[data-bs-theme="dark"] .dropdown-item:hover,
		.dark-style .dropdown-item:hover {
			background-color: rgba(248, 124, 99, 0.15) !important;
			color: #F87C63 !important;
		}

		/* ========================================================= */
		/* AA CAR RENTAL - GLOBAL BRAND THEME STYLES                 */
		/* ========================================================= */
		:root,
		[data-bs-theme="light"],
		[data-bs-theme="dark"],
		.light-style,
		.dark-style {
			--bs-primary: #f12526 !important;
			--bs-primary-rgb: 241, 37, 38 !important;
			--bs-primary-hover: #c81e1f !important;
			--bs-primary-active: #b51a1b !important;
			--bs-primary-text-emphasis: #7a0c0d !important;
			--bs-primary-bg-subtle: #fee2e2 !important;
			--bs-primary-border-subtle: #fca5a5 !important;
			--bs-primary-contrast: #ffffff !important;
			--bs-link-color: #f12526 !important;
			--bs-link-hover-color: #c81e1f !important;
			--bs-pagination-active-bg: #f12526 !important;
			--bs-pagination-active-border-color: #f12526 !important;
			--bs-pagination-active-color: #ffffff !important;
			--bs-form-check-input-checked-bg-color: #f12526 !important;
			--bs-form-check-input-checked-border-color: #f12526 !important;
		}

		/* Primary Buttons */
		.btn-primary {
			background-color: #f12526 !important;
			border-color: #f12526 !important;
			color: #ffffff !important;
			box-shadow: 0 2px 6px 0 rgba(241, 37, 38, 0.4) !important;
		}

		.btn-primary:hover,
		.btn-primary:focus,
		.btn-primary:focus-visible {
			background-color: #c81e1f !important;
			border-color: #c81e1f !important;
			color: #ffffff !important;
			box-shadow: 0 4px 12px 0 rgba(241, 37, 38, 0.5) !important;
		}

		.btn-primary:active,
		.btn-primary.active,
		.btn-primary:focus:active,
		.show > .btn-primary.dropdown-toggle {
			background-color: #b51a1b !important;
			border-color: #b51a1b !important;
			color: #ffffff !important;
			box-shadow: 0 2px 4px 0 rgba(241, 37, 38, 0.4) !important;
		}

		.btn-primary:disabled,
		.btn-primary.disabled {
			background-color: #f12526 !important;
			border-color: #f12526 !important;
			color: #ffffff !important;
			opacity: 0.65 !important;
		}

		/* Outline Primary Buttons */
		.btn-outline-primary {
			color: #f12526 !important;
			border-color: #f12526 !important;
			background-color: transparent !important;
		}

		.btn-outline-primary:hover,
		.btn-outline-primary:focus {
			background-color: #f12526 !important;
			border-color: #f12526 !important;
			color: #ffffff !important;
			box-shadow: 0 4px 12px 0 rgba(241, 37, 38, 0.4) !important;
		}

		.btn-outline-primary:active,
		.btn-outline-primary.active,
		.show > .btn-outline-primary.dropdown-toggle {
			background-color: #c81e1f !important;
			border-color: #c81e1f !important;
			color: #ffffff !important;
		}

		/* Label Primary Buttons */
		.btn-label-primary {
			background-color: rgba(241, 37, 38, 0.12) !important;
			color: #f12526 !important;
			border-color: transparent !important;
		}

		.btn-label-primary:hover,
		.btn-label-primary:focus {
			background-color: #f12526 !important;
			color: #ffffff !important;
		}

		/* DataTables Pagination & Page Numbering */
		.dataTables_wrapper .pagination .page-item.active .page-link,
		.dataTables_paginate .pagination .page-item.active .page-link,
		div.dt-container div.dt-paging ul.pagination .page-item.active .page-link,
		.pagination .page-item.active .page-link,
		.page-item.active .page-link,
		.paginate_button.current,
		.dataTables_paginate .paginate_button.current {
			background-color: #f12526 !important;
			border-color: #f12526 !important;
			color: #ffffff !important;
			box-shadow: 0 2px 6px 0 rgba(241, 37, 38, 0.4) !important;
		}

		.dataTables_wrapper .pagination .page-item .page-link:hover,
		.dataTables_paginate .pagination .page-item .page-link:hover,
		div.dt-container div.dt-paging ul.pagination .page-item:not(.active) .page-link:hover,
		.pagination .page-item:not(.active) .page-link:hover {
			color: #f12526 !important;
			background-color: rgba(241, 37, 38, 0.08) !important;
			border-color: rgba(241, 37, 38, 0.2) !important;
		}

		div.dt-container table.dataTable.table tbody > tr.selected,
		table.dataTable tbody tr.selected {
			background-color: rgba(241, 37, 38, 0.08) !important;
		}

		/* Step Wizard / bs-stepper */
		.bs-stepper .step.active .bs-stepper-circle,
		.bs-stepper .step-trigger.active .bs-stepper-circle,
		.bs-stepper .step-trigger:focus .bs-stepper-circle,
		.bs-stepper-header .step.active .bs-stepper-circle,
		.active .bs-stepper-circle {
			border: 3px solid #f12526 !important;
			background-color: #f12526 !important;
			color: #ffffff !important;
			box-shadow: 0 3px 9px 0 rgba(241, 37, 38, 0.4) !important;
		}

		.bs-stepper .step.crossed .bs-stepper-circle,
		.bs-stepper .step.crossed .step-trigger .bs-stepper-circle,
		.bs-stepper-header .step.crossed .bs-stepper-circle {
			border-color: #f12526 !important;
			background-color: #f12526 !important;
			color: #ffffff !important;
		}

		.bs-stepper .step.active .bs-stepper-icon svg,
		.bs-stepper .step.crossed .step-trigger .bs-stepper-icon svg {
			fill: #f12526 !important;
		}

		.bs-stepper .step.active .bs-stepper-icon .icon-base,
		.bs-stepper .step.crossed .step-trigger .bs-stepper-icon .icon-base {
			color: #f12526 !important;
		}

		.bs-stepper .step.active .bs-stepper-label .bs-stepper-title,
		.bs-stepper .step.active .bs-stepper-label .bs-stepper-number,
		.bs-stepper .bs-stepper-header .step.active .bs-stepper-label .bs-stepper-title,
		.bs-stepper .bs-stepper-header .step.active .bs-stepper-label .bs-stepper-number {
			color: #f12526 !important;
		}

		.bs-stepper .step.crossed + .line,
		.bs-stepper-header .step.crossed + .line,
		.bs-stepper-header .line.active,
		.bs-stepper .line.active {
			border-color: #f12526 !important;
			background-color: #f12526 !important;
		}

		.bs-stepper .step-trigger:focus {
			color: #f12526 !important;
		}

		/* Form Elements, Checks, Radios, Switches */
		.form-check-input:checked {
			background-color: #f12526 !important;
			border-color: #f12526 !important;
			box-shadow: 0 2px 4px 0 rgba(241, 37, 38, 0.4) !important;
		}

		.form-check-input:focus {
			border-color: #f12526 !important;
			box-shadow: 0 0 0 0.25rem rgba(241, 37, 38, 0.25) !important;
		}

		.switch-input:checked ~ .switch-toggle-slider {
			background-color: #f12526 !important;
		}

		.form-control:focus,
		.form-select:focus {
			border-color: #f12526 !important;
			box-shadow: 0 0 0 0.25rem rgba(241, 37, 38, 0.2) !important;
		}

		.form-floating > .form-control:focus ~ label,
		.form-floating > .form-select:focus ~ label {
			color: #f12526 !important;
		}

		/* Nav-pills & Tabs */
		.nav-pills .nav-link.active,
		.nav-pills .show > .nav-link {
			background: linear-gradient(135deg, #f12526, #c81e1f) !important;
			color: #ffffff !important;
			box-shadow: 0 4px 12px rgba(241, 37, 38, 0.3) !important;
		}

		/* General Badges & Text Utilities */
		.badge.bg-primary {
			background-color: #f12526 !important;
			color: #ffffff !important;
		}

		.badge.bg-label-primary {
			background-color: rgba(241, 37, 38, 0.12) !important;
			color: #f12526 !important;
		}

		.text-primary {
			color: #f12526 !important;
		}

		.bg-primary {
			background-color: #f12526 !important;
		}

		.border-primary {
			border-color: #f12526 !important;
		}

		.dropdown-item.active,
		.dropdown-item:active {
			background-color: #f12526 !important;
			color: #ffffff !important;
		}

		.select2-container--default .select2-results__option--highlighted[aria-selected] {
			background-color: #f12526 !important;
			color: #ffffff !important;
		}

		.flatpickr-day.selected,
		.flatpickr-day.startRange,
		.flatpickr-day.endRange {
			background: #f12526 !important;
			border-color: #f12526 !important;
		}

		.flatpickr-day.today {
			border-color: #f12526 !important;
		}
	</style>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		function updateThemeUI(theme) {
			let activeTheme = theme;
			if (theme === 'system') {
				activeTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
			}
			document.documentElement.setAttribute('data-bs-theme', activeTheme);
			if (activeTheme === 'dark') {
				document.documentElement.classList.add('dark-style');
				document.documentElement.classList.remove('light-style');
				let icon = document.getElementById('themeToggleIcon');
				if (icon) icon.className = 'icon-base ri ri-moon-clear-line icon-22px';
			} else {
				document.documentElement.classList.add('light-style');
				document.documentElement.classList.remove('dark-style');
				let icon = document.getElementById('themeToggleIcon');
				if (icon) icon.className = 'icon-base ri ri-sun-line icon-22px';
			}
			localStorage.setItem('app_theme_mode', theme);
		}

		let currentTheme = localStorage.getItem('app_theme_mode') || 'light';
		updateThemeUI(currentTheme);

		document.addEventListener('click', function(e) {
			let themeBtn = e.target.closest('.dropdown-styles [data-theme]');
			if (themeBtn) {
				e.preventDefault();
				let selectedTheme = themeBtn.getAttribute('data-theme');
				updateThemeUI(selectedTheme);
			}
		});
	});
	</script>