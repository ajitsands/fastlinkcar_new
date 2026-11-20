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
include('envinclude.php');
?>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>

<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-wide"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="../assets/"
    data-template="horizontal-menu-template-no-customizer">

<head>
    <?php include('templates/head.php'); ?>


    <!-- Helpers -->
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/customParseFormat.js"></script>
    <script>dayjs.extend(window.dayjs_plugin_customParseFormat);</script>
    <script>
        const SYSTEM_LOGGED_IN_USER = "<?= htmlspecialchars($_SESSION['profile_name'] ?? $_SESSION['name'] ?? $_SESSION['username'] ?? 'Administrator', ENT_QUOTES) ?>";
    </script>
    <?php
    $phpDateFormat = 'd-M-Y'; // Default to DD-MMM-YYYY pattern
    if (class_exists('CommonPDOModel')) {
        $__pdo = new CommonPDOModel();
        $__cid = $_SESSION['company_id'] ?? 1;
        // First try company specific, then fallback to any
        $__res = $__pdo->selectexecuteQuery("SELECT date_format FROM tbl_system_settings WHERE company_id = '{$__cid}' LIMIT 1");
        if (!$__res || empty($__res->fetchAll(PDO::FETCH_ASSOC))) {
            $__res = $__pdo->selectexecuteQuery("SELECT date_format FROM tbl_system_settings LIMIT 1");
        } else {
            // Re-run query because fetchAll exhausts the result set
            $__res = $__pdo->selectexecuteQuery("SELECT date_format FROM tbl_system_settings WHERE company_id = '{$__cid}' LIMIT 1");
        }
        if ($__res) {
            $__rows = $__res->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($__rows[0]['date_format'])) {
                $phpDateFormat = $__rows[0]['date_format'];
            }
        }
    } else if (defined('SYS_DATE_FORMAT')) {
        $phpDateFormat = SYS_DATE_FORMAT;
    }
    $mapping = [
        'd' => 'DD',
        'j' => 'D',
        'm' => 'MM',
        'n' => 'M',
        'Y' => 'YYYY',
        'y' => 'YY',
        'M' => 'MMM',
        'F' => 'MMMM'
    ];
    $jsDateFormat = strtr($phpDateFormat, $mapping);
    ?>
    <script>
        window.SYS_DATE_FORMAT = "<?= $jsDateFormat ?>";
    </script>
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="../assets/js/config.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">


    <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/spinkit/spinkit.css" />
    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">
    
    <!-- Quill Editor CSS for Terms Management -->
    <link rel="stylesheet" href="../assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" />
    <style>
   
    html, body {
         height: 100%;
    overflow: hidden; /* ❌ disables page scroll */
        }
        
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        .list-group-item.active-click {
          background-color: #1b3d94; /* Bootstrap primary */
          color: white;
        }
        .table-active {
            background-color: #1b3d94 !important; /* Red background */
            color: white !important;              /* White text */
        }
        
        .table-active td {
            color: white !important;              /* Make all cell text white */
        }
        .highlight {
          background-color: yellow;
          font-weight: bold;
        }
    
   
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
        #modelsTable tbody tr {
          cursor: pointer;
        }
        
        .vehicle-card {
          transition: 0.2s;
          background: #fff;
        }
        
        .vehicle-card:hover {
          background: #f8f9fa;
          transform: translateY(-2px);
          cursor: pointer;
        }
        
        .btn-sm, .btn-group-sm > .btn {
        --bs-btn-padding-y: 0.2415rem;
        --bs-btn-padding-x: 0.369rem;
}

/* Chrome, Safari, Edge */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}

.vehicle-card.selected {
    border: 2px solid #1b3d94;       /* red border for selection */
    background-color: #eef3fc;       /* light highlight */
    box-shadow: 0 0 10px rgba(27, 61, 148, 0.4); /* optional glow */
    transition: all 0.2s ease-in-out;
}

#selectedVehiclesFooter::-webkit-scrollbar {
    height: 6px;
}

#selectedVehiclesFooter::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}

.custom-modal-header {
    background: linear-gradient(135deg, #1b3d94, #153075);
    color: white !important; 
    border-bottom: none;
}

.custom-modal-header .modal-title {
    color: #fff;
}

.custom-modal-header .btn-close {
    filter: invert(1); /* makes the close (X) icon white */
    opacity: 1;
}
.modal-body {
    background-color: #f8f9fa;
}

.card {
    border-radius: 12px;
}
.scroll-container {
    height: 100vh;
    overflow-y: auto;
}
.nav-pills .nav-link {
    border-radius: 20px;
    padding: 6px 14px;
}

.nav-pills .nav-link.active {
    background-color: #1b3d94;
}

//SaNDS Alert
#popupOverlay {
    z-index: 999998 !important;
    pointer-events: auto !important;
}

#popupContainer {
    z-index: 999999 !important;
    pointer-events: auto !important;
}
.left-scroll-area {
    overflow: visible;   /* 🔥 important */
}
#dropdownContainer {
    width: 100%;
    flex: 1; /* 🔥 important for flex layouts */
}
#confirmActionModal {
    z-index: 999999 !important;
   
}
#dropdownContent {
    z-index: 999999 !important;
   
}
#confirmActionModal,
#confirmActionModal * {
    pointer-events: auto !important;
}
#notesModal {
    z-index: 999999 !important;
   
}

.quotation-preview-scroll {
    height: 60vh;
    overflow-y: auto;
    overflow-x: hidden;
    padding-bottom: 50px;
}

#quotationPreview table {
    margin-bottom: 30px;
}
.quotation-list-scroll {
    max-height:300px;
    overflow-y:auto;
}

/* Main column scrolling */
.scroll-container {
    height: calc(100vh - 120px);
    overflow-y: auto;
    overflow-x: hidden;
}

/* Quotation preview */
.quotation-preview-scroll {
    height: 40vh;
    overflow-y: auto;
    overflow-x: hidden;
}

/* Vehicle list */
.vehicle-scroll {
    height: 400px;
    overflow-y: auto;
}


/* Mobile devices */
@media (max-width: 991px) {

    .scroll-container {
        height: auto;
        overflow: visible;
    }

    .quotation-preview-scroll {
        height: auto;
        max-height: 400px;
        overflow-y: auto;
    }

    .vehicle-scroll {
        height: 400px;
    }

}


/* Small mobile */
@media (max-width: 576px) {

    .container-fluid {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }

    .card-header {
        font-size: 14px;
    }

    .form-label {
        font-size: 12px;
    }

}
</style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->
            <?php include('templates/nav.php'); ?>
            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    <?php include('templates/menu.php'); ?>
                    <!-- / Menu -->

                    <!-- Content -->
                    
                        <!-- Layout Demo -->
                        
                        <?php include('templates/DirectContract/DirectContractBody.php'); ?>
                        <?php include('templates/quotation/add_new_customer_modal.php'); ?>
                        <?php include('templates/customer/customer_images_modal.php'); ?>
                        <?php include('templates/DirectContract/direct_contract_wizard_modal.php'); ?>
                         <?php include('templates/VehicleReservation/vehicleFloatingFooter.php'); ?>
                         <?php include('templates/VehicleStatus/vehicle_filepreview_modal.php'); ?>
                         <?php include('templates/VehicleReservation/reservation_preview_modal.php'); ?>
                         <?php include('templates/VehicleReservation/vehicle_images_slider.php'); ?>
                         <?php include('templates/VehicleReservation/custom_confirm_modal.php'); ?>
                         <?php include('templates/VehicleReservation/confirm_action_modal.php'); ?>
                          <?php include('templates/VehicleReservation/view_notes_modal.php'); ?>
                          <?php include('templates/VehicleReservation/vehicle_availability_model.php'); ?>
                          <?php include('templates/VehicleReservation/booking_listupon_avail_check.php'); ?>
                          <?php // include('templates/VehicleReservation/vehicleAvailFloatingBar.php'); ?>
                         
                          
                     
                        <!--/ Layout Demo -->
                    
                    <!--/ Content -->

                    <!-- Footer -->
                    <?php include('templates/footer.php'); ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>
    <div id="dropdownContent" style="text-align:center;"></div> 
    <?php include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
   

    <?php include('templates/vehicles/vehicle_profile_modal.php'); ?>
    <?php include('templates/VehicleContractGeneration/customer_driver_documents_upload.php'); ?>
    <?php include('templates/VehicleContractGeneration/terms_condition_modal.php'); ?>
    <?php include('templates/scripts.php'); ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/js/forms-selects.js"></script>
    <script src="../assets/sands/settings.js"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>
    <script src="../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    
    <!-- Quill Editor JS for Terms Management -->
    <script src="../assets/vendor/libs/quill/katex.js"></script>
    <script src="../assets/vendor/libs/highlight/highlight.js"></script>
    <script src="../assets/vendor/libs/quill/quill.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
    
    <script src="../httpdocs/user_js/vehicle_info.js"></script>
    <script src="../httpdocs/user_js/car_survey_widget.js?v=<?= time() ?>"></script>
    <script src="../httpdocs/user_js/direct_contract_wizard.js?v=<?= time() + 1 ?>"></script>
    
    <script>
        const fullToolbar = [
            [{ font: [] }, { size: [] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ color: [] }, { background: [] }],
            [{ script: 'super' }, { script: 'sub' }],
            [{ header: '1' }, { header: '2' }, 'blockquote', 'code-block'],
            [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
            [{ direction: 'rtl' }],
            ['link', 'image', 'video', 'formula'],
            ['clean']
        ];
        
        // Expose katex and hljs to window for Quill formula/syntax modules
        if (typeof katex !== 'undefined') window.katex = katex;
        if (typeof hljs !== 'undefined') window.hljs = hljs;
        
        let fullEditor = null;
        if (document.getElementById('full-editor')) {
            fullEditor = new Quill('#full-editor', {
                bounds: '#full-editor',
                placeholder: 'Type Something...',
                modules: { syntax: true, toolbar: fullToolbar },
                theme: 'snow'
            });
        }
    </script>

    <script>
function parseDDMMYYYYtoJSDate(dateStr) {
    if (!dateStr || dateStr.length < 10) return new Date("Invalid");
    let parts = dateStr.split(' ');
    let dParts = parts[0].split('-');
    let tParts = (parts[1] || '00:00').split(':');
    if(dParts.length !== 3) return new Date("Invalid");
    return new Date(dParts[2], parseInt(dParts[1]) - 1, dParts[0], tParts[0], tParts[1]);
}

function convertDDMMYYYYtoYYYYMMDD(dateStr) {
    if (!dateStr || typeof dateStr !== 'string') return dateStr;
    let parts = dateStr.split(' ');
    let dParts = parts[0].split('-');
    if (dParts.length < 3) return dateStr;
    
    if (dParts[0].length === 4) return dateStr; // Already YYYY-MM-DD
    
    let timeStr = parts.length > 1 ? ' ' + parts.slice(1).join(' ') : '';
    return dParts[2] + '-' + dParts[1] + '-' + dParts[0] + timeStr;
}

$(document).ready(function() {
    $(document).on('input', '.from_datetime, .to_datetime', function(e) {
        let input = $(this).val().replace(/\D/g, ''); // Remove all non-digits
        let formatted = '';
        
        if (input.length > 0) formatted += input.substring(0, 2);
        if (input.length >= 3) formatted += '-' + input.substring(2, 4);
        if (input.length >= 5) formatted += '-' + input.substring(4, 8);
        if (input.length >= 9) formatted += ' ' + input.substring(8, 10);
        if (input.length >= 11) formatted += ':' + input.substring(10, 12);
        
        $(this).val(formatted);
    });
    $(document).on('blur', '.from_datetime, .to_datetime', function(e) {
        let val = $(this).val();
        if (val.length === 10) {
            $(this).val(val + ' 00:00');
            $(this).trigger('change');
        }
    });

    const wizardModern = document.querySelector('.wizard-modern-example');
    if (typeof wizardModern !== undefined && wizardModern !== null) {
      const modernStepper = new Stepper(wizardModern, { linear: false });
      window.stepper = modernStepper; // Make it globally accessible for reset logic
      
      const btnNextList = [].slice.call(wizardModern.querySelectorAll('.btn-next'));
      const btnPrevList = [].slice.call(wizardModern.querySelectorAll('.btn-prev'));
      
      if (btnNextList) {
        btnNextList.forEach(btnNext => {
          btnNext.addEventListener('click', event => {
            modernStepper.next();
          });
        });
      }
      if (btnPrevList) {
        btnPrevList.forEach(btnPrev => {
          btnPrev.addEventListener('click', event => {
            modernStepper.previous();
          });
        });
      }
    }

    
    // var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    //     popoverTriggerList.map(function (el) {
    //         return new bootstrap.Popover(el);
    //     });
     $('#ModelRef').val('').trigger('change');;
    function resetcustomer_booking()
    {
        $('#quotationRef').val('');
        $('#customerName').val('');
        $('#customer_code').val('');
        $('#customerPhone').val('');
        $('#customerEmail').val('');
        $('#customerAddress').val('');
        $('#customerAttention').val('');
        $('#customercprcr').val('');
        
    }
let selectedVehicles = [];

  $('#bookingTypeMain').on('change', function () {
    resetcustomer_booking()
    let type = $(this).val();
    

    if (type === 'quotation') {

        // Show quotation UI
        $('#quotationSection').removeClass('d-none');

        // Hide direct UI
        $('#directSection').addClass('d-none');

    } else {

        // Hide quotation UI
        $('#quotationSection').addClass('d-none');

        // Show direct UI
        $('#directSection').removeClass('d-none');

    }

});

setTimeout(function() {
    if ($('#selectCustomerFromSelect2').hasClass('select2-hidden-accessible')) {
        $('#selectCustomerFromSelect2').select2('destroy');
    }

    $('#selectCustomerFromSelect2').select2({
        placeholder: 'Search customer by name, mobile or cpr/cr',
        allowClear: true,
        minimumInputLength: 2,
        tags: true, 
        createTag: function (params) {
            let term = $.trim(params.term);

            if (term === '') {
                return null;
            }
        },
        ajax: {
            url: '/SearchCustomerDetails',
            dataType: 'json',
            delay: 300,
            data: function (params) {
                return {
                    q: params.term,
                    action: 'SearchCustomer'
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.customer_name,
                        customer_name: item.customer_name,
                        customer_mobile: item.customer_mobile,
                        phone_1: item.phone_1,
                        customer_id: item.customer_name,
                        customer_address: item.customer_addr || item.customer_address,
                        customer_email: item.customer_email,
                        customer_code: item.customer_code,
                        customer_attn: item.customer_attn,
                        customer_cr_cpr: item.customer_cr_cpr,
                        nationality: item.nationality,
                        license_no: item.license_no,
                        license_issue_place: item.license_issue_place,
                        license_expiry_date: item.license_expiry_date,
                        customer_account_id: item.customer_account_id,
                        account_name: item.account_name,
                        status: item.status,
                        is_blacklisted: item.is_blacklisted,
                        blacklist_description: item.blacklist_description
                    }))
                };
            }
        },
        templateResult: formatCustomer,
        templateSelection: formatCustomerSelection
    });
}, 100);

$(document).ready(function () {
    $.getJSON('/CustomerAccountController?action=list&active_only=1', function (res) {
        if (res && res.status === 'success' && Array.isArray(res.data)) {
            const $sel = $('#customerAccountId');
            $sel.find('option:not(:first)').remove();
            res.data.forEach(function (acc) {
                $sel.append($('<option>', { value: acc.ids, text: acc.account_name }));
            });
        }
    });
});

function formatCustomer(customer) {
    if (!customer.id) return customer.text;
    const isBl = (customer.is_blacklisted == 1 || customer.is_blacklisted === '1' || customer.status === 'Blacklisted');
    if (isBl) {
        const reason = customer.blacklist_description ? ` — ${$('<div>').text(customer.blacklist_description).html()}` : '';
        return $(`
            <div class="text-danger">
                <strong>${customer.customer_name} | ${customer.customer_mobile} | ${customer.customer_cr_cpr}</strong>
                <span class="badge bg-danger ms-1">BLACKLISTED</span>
                <div class="small">${reason ? 'Remarks: ' + $('<div>').text(customer.blacklist_description).html() : 'Blacklisted customer'}</div>
            </div>
        `);
    }

    return $(`
        <div>
            <strong>${customer.customer_name} | ${customer.customer_mobile} | ${customer.customer_cr_cpr}</strong>
        </div>
    `);
}

function formatCustomerSelection(customer) {
    return customer.customer_name
        ? `${customer.customer_name}`
        : customer.text;
}


$('#selectCustomerFromSelect2').on('select2:select', function (e) {
    let data = e.params.data;
    const isBl = (data.is_blacklisted == 1 || data.is_blacklisted === '1' || data.status === 'Blacklisted');
    $('#blacklistedCustomerAlert').remove();

    if (isBl) {
        window.__selectedCustomerBlacklisted = true;
        const remarksText = data.blacklist_description ? data.blacklist_description : 'No remarks specified.';
        const alertHtml = `
            <div id="blacklistedCustomerAlert" class="alert alert-danger mt-2 mb-2 d-flex align-items-start gap-2" role="alert">
                <i class="ri-spam-2-fill fs-5 mt-1"></i>
                <div>
                    <div class="fw-bold">Customer Blacklisted: ${$('<div>').text(data.customer_name || '').html()}</div>
                    <div class="small"><strong>Remarks:</strong> ${$('<div>').text(remarksText).html()}</div>
                    <div class="small mt-1">You cannot proceed with contract creation for a blacklisted customer.</div>
                </div>
            </div>
        `;
        $('#selectCustomerFromSelect2').closest('.col, .col-12, .mb-3, .form-floating, div').parent().append(alertHtml);

        $('#selectCustomerFromSelect2').val(null).trigger('change');
        $('#customer_code, #customerName, #customerPhone, #customerTelephone, #customerEmail, #customerAddress, #customerAttention, #customercprcr, #customerNationality, #customerLicenseNo, #customerLicenseIssuePlace, #customerLicenseExpiry, #customerAccountId').val('');
        setupDropdown('dropdownContent', 'error', svgError + 'Cannot select blacklisted customer. Remarks: ' + remarksText, 'click');
        return;
    }

    window.__selectedCustomerBlacklisted = false;
    $('#customer_code').val(data.customer_code || '');
    $('#customerName').val(data.customer_name || '');
    $('#customerPhone').val(data.customer_mobile || '');
    $('#customerTelephone').val(data.phone_1 || '');
    $('#customerEmail').val(data.customer_email || '');
    $('#customerAddress').val(data.customer_address || '');
    $('#customerAttention').val(data.customer_attn || '');
    $('#customercprcr').val(data.customer_cr_cpr || '');
    $('#customerNationality').val(data.nationality || '');
    $('#customerLicenseNo').val(data.license_no || '');
    $('#customerLicenseIssuePlace').val(data.license_issue_place || '');
    $('#customerLicenseExpiry').val(data.license_expiry_date ? String(data.license_expiry_date).substring(0, 10) : '');

    const accId = data.customer_account_id ? String(data.customer_account_id) : '';
    if (accId && $('#customerAccountId option[value="' + accId + '"]').length === 0 && data.account_name) {
        $('#customerAccountId').append($('<option>', { value: accId, text: data.account_name }));
    }
    $('#customerAccountId').val(accId);
});


$('#selectCustomerFromSelect2').on('select2:clear', function () {
    window.__selectedCustomerBlacklisted = false;
    $('#blacklistedCustomerAlert').remove();
    $('#customer_code, #customerName, #customerPhone, #customerTelephone, #customerEmail, #customerAddress, #customerAttention, #customercprcr, #customerNationality, #customerLicenseNo, #customerLicenseIssuePlace, #customerLicenseExpiry, #customerAccountId').val('');
}); 

$('#addCustomerBtn').click(function () {
       
        $('#QtnAddNewCustomerModal').modal('show');
  });
 function saveCustomer(action)
{
    let customerData = {
        action: action,
        customer_type: $("#customer_type_onmodal").val(),
        customer_name: $("#bookingCustomerName_onmodal").val(),
        telephone: $("#customerMobile_onmodal").val(),
        email: $("#customerEmail_onmodal").val(),
        attention: $("#bookingCustomerAttn_onmodal").val(),
        cprcr: $("#customerCprCr_onmodal").val(),
        cprexpiryDate: $("#cprexpiryDate_onmodal").val(),
        address: $("#bookingCustomerAddress_onmodal").val(),
        clientsDoc: typeof bookingMaster !== 'undefined' ? bookingMaster : [] 
    };

    $.ajax({
        url: "/SaveCustomerDetails",
        type: "POST",
       data: JSON.stringify(customerData), 
        contentType: "application/json",   
        success: function(res) {
    
            //let res = JSON.parse(response); 
    
            if (res.status) {
                setupDropdown(
                    'dropdownContent',
                    'success',
                    svgSuccess + ' Customer saved successfully',
                    'click'
                );
    
                $("#QtnAddNewCustomerModal").modal("hide");
                
                // Auto-select the new customer in the dropdown
                let newOption = new Option(customerData.customer_name, res.customerId, true, true);
                $('#selectCustomerFromSelect2').append(newOption).trigger('change');
                
                // Fill the direct contract customer fields
                $('#customer_code').val(res.customerId || '');
                $('#customerName').val(customerData.customer_name || '');
                $('#customerPhone').val(customerData.telephone || '');
                $('#customerTelephone').val($('#phone_1_onmodal').val() || '');
                $('#customerEmail').val(customerData.email || '');
                $('#customerAddress').val(customerData.address || '');
                $('#customerAttention').val(customerData.attention || '');
                $('#customercprcr').val(customerData.cprcr || '');
                $('#customerNationality').val($('#nationality_onmodal').val() || '');
                $('#customerLicenseNo').val($('#license_no_onmodal').val() || '');
                $('#customerLicenseIssuePlace').val($('#license_issue_place_onmodal').val() || '');
                $('#customerLicenseExpiry').val($('#license_expiry_date_onmodal').val() || '');
                $('#customerAccountId').val($('#customer_account_id_onmodal').val() || '');
    
            } else {
                setupDropdown(
                    'dropdownContent',
                    'danger',
                    svgDanger + res.message,
                    'click'
                );
            }
    
        },
        error: function() {
            setupDropdown(
                'dropdownContent',
                'danger',
                svgDanger + ' Error saving customer',
                'click'
            );
        }
    });
    }
  $(document).on("click", "#btn_add_new_customer", function () {

    saveCustomer('AddNewCustomer');

});


  $('#searchQuotation').on('keyup', function () {

    let term = $(this).val();

    if (term.length < 2) {
        $('#quotationList').html('<div class="text-muted small">Type to search...</div>');
        return;
    }

    $.ajax({
        url: '/AutoLoadQuotationNo',
        type: 'GET',
        dataType: 'json',
        data: { term: term },
        success: function (data) {

            let html = '';

            if (data.length === 0) {
                html = '<div class="text-muted small">No quotations found</div>';
            } else {

                data.forEach(item => {

                    html += `
                        <div class="quotation-item p-2 border-bottom d-flex justify-content-between align-items-center"
                             data-id="${item.id}"
                             data-no="${item.quotation_no}"
                             data-client="${item.customer_name}"
                             style="cursor:pointer;">
                    
                            <div>
                                <div class="fw-semibold">${item.quotation_no}</div>
                                <div class="text-muted small">${item.customer_name}</div>
                            </div>
                    
                    
                        </div>
                    `;
                });

            }

            $('#quotationList').html(html);
        }
    });

});

$(document).on('click', '.quotation-item', function () {

    let id = $(this).data('id');

    // Highlight selected
    $('.quotation-item').removeClass('bg-light');
    $(this).addClass('bg-light');

    // Fetch full quotation details
    $.ajax({
        url: '/GetQuotationDetails',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function (res) {

            fillQuotationData(res);

        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });

});

$('#quotationRef').val('');
$('#customer_code').val('');
function fillQuotationData(response) {

    
    let datares = response[0];
    
    let itemsres = datares.items;

    $('#customerName').val(datares.customer_name);
    $('#customerPhone').val(datares.customer_phone);
    $('#customerEmail').val(datares.customer_email);
    $('#customerAddress').val(datares.customer_address);
    $('#customerAttention').val(datares.attention);
     $('#customercprcr').val(datares.customer_cr_cpr);
    $('#quotationRef').val(datares.quotation_no);
    $('#customer_code').val(datares.customer_code);

    
    let html = '';

   html += `
            <div class="mb-2">
               
                <div class="d-flex gap-4">
                    <p class="mb-1"><strong>Quotation No:</strong> ${datares.quotation_no}</p>
                    <p class="mb-1"><strong>Date:</strong> ${datares.qtnformatted_date}</p>
                </div>
            
                <div>
                    <p class="mb-1"><strong>Client:</strong> ${datares.customer_name}</p>
                </div>
            
            </div>
            `;

    // ITEMS TABLE
    let items_data = JSON.parse(itemsres);

  html += `
<table class="table table-bordered mb-4">
    <thead>
        <tr>
            <th style="padding: 4px 8px; line-height: 1.2;">Quotation Items</th>
        </tr>
    </thead>
    <tbody>
`;

items_data.forEach(item => {

    
    let from = item.period_from;
    let to = item.period_to;

   html += `
        <tr class="quotation-row" 
            data-from="${item.period_from}" 
            data-to="${item.period_to}" 
            data-rate="${item.rate_type_id}" 
            data-service="${item.service_id}"
            data-model="${item.item_model_id}"
            data-price="${item.price}"
            data-duration="${item.duration}"
            data-vat="${item.vat}">
        
            <td>
                <div class="p-2">
        
                    <div class="fw-semibold">
                        ${item.item_name} (${item.qty} Nos)
                    </div>
        
                    <div class="text-muted">
                        ${item.service_name}
                    </div>
        
                    <div class="small mt-1 d-flex gap-3">
                        <div><strong>From:</strong> ${from}</div>
                        <div><strong>To:</strong> ${to}</div>
                    </div>
        
                    <div class="small text-muted mt-1">
                        Duration: ${item.duration} | ${item.rate_type_name}
                    </div>
        
                </div>
            </td>
        </tr>
        `;
});

html += `
    </tbody>
</table>
`;

    $('#quotationPreview').html(html);
}


$(document).on('click', '.quotation-row', function () {

    let from = $(this).data('from');
    let to = $(this).data('to');
    let rate = $(this).data('rate');
    let service = $(this).data('service');
    let modelId = $(this).data('model');
    let price = $(this).data('price');
    let duration = $(this).data('duration');
    let vat = $(this).data('vat');

    
    $('.from_datetime').val(from);
    $('.to_datetime').val(to);

    
    $('.rate_type').val(rate);
    $('.service').val(service);
    
    $('.price').val(price);
    $('.duration').val(duration);
    $('.vat').val(vat);
  
    
    $('.quotation-row').removeClass('table-active');
    $(this).addClass('table-active');
     $('#ModelRef').val(modelId).trigger('change');;
     loadVehiclesTableAvailability(modelId, from, to);
    //loadVehiclesTable(modelId, '0')
    
});


   $('#vehicleModel').select2({
    dropdownParent: $('#dropdownContainer'),
    width: '100%',
     allowClear: true
}); 

$('#vehicleModelAvail').select2({
    dropdownParent: $('#checkavailabilityModal'),
    width: '100%',
     allowClear: true
}); 
    modelloadDropdown(null);

    function modelloadDropdown(currentModel = null) {
       if (currentModel === null) {
           currentModel = $('#vehicleModel').val();
       }
       $('#dropdownContainer').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading models...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadVehicleModelReservation',
            type: 'GET',
            data: { company_id: $('#reservationCompanySelect').val() },
            success: function (response) {
                $('#dropdownContainer').html(response);

                $('#vehicleModel').select2({
                    placeholder: "Select Model",
                    allowClear: true,
                    width: '100%'
                });
                
                let fromDate = $('.from_datetime').val();
                let toDate   = $('.to_datetime').val();
                let vehicleNos = $('#vehicleSearch').val();
                if(!vehicleNos) vehicleNos = '0';
                
                if (currentModel && currentModel !== '') {
                    if ($('#vehicleModel option[value="' + currentModel + '"]').length > 0) {
                        // Re-select the model
                        $('#vehicleModel').val(currentModel).trigger('change.select2');
                        $('#ModelRef').val(currentModel).trigger('change');
                    }
                }
            },
        error: function (xhr, status, error) {
            $('#dropdownContainer').html(`
            <div class="text-center p-3">
                <div class="mt-2">Error loading data</div>
            </div>`);
            
            console.error(error);
        }
        });
    }
    function modelloadDropdownAvail(currentModelAvail = null) {
       if (currentModelAvail === null) {
           currentModelAvail = $('#vehicleModelAvail').val();
       }
       $('#dropdownContaineravail').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading models...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadVehicleModelReservationAvail',
            type: 'GET',
            data: { company_id: $('#reservationCompanySelect').val() },
            success: function (response) {
                $('#dropdownContaineravail').html(response);

                $('#vehicleModelAvail').select2({
                    placeholder: "Select Model",
                    dropdownParent: $('#checkavailabilityModal'),
                    allowClear: true,
                    width: '100%'
                });
                
                if (currentModelAvail && currentModelAvail !== '') {
                    if ($('#vehicleModelAvail option[value="' + currentModelAvail + '"]').length > 0) {
                        $('#vehicleModelAvail').val(currentModelAvail).trigger('change.select2');
                    }
                }
            },
        error: function (xhr, status, error) {
            $('#dropdownContaineravail').html(`
            <div class="text-center p-3">
                <div class="mt-2">Error loading data</div>
            </div>`);
            
            console.error(error);
        }
        });
    }
    
$(document).on('select2:select select2:clear', '#vehicleModel', function (e) {
    
    // Empty selected vehicles when model changes
    selectedVehicles = [];
    updateSelectedFooter();

    let modelId = $('#vehicleModel').val() || 'All';
    $('#ModelRef').val(modelId).trigger('change');
    let fromdate= $('.from_datetime').val();
    let todate =  $('.to_datetime').val();
    fromdate = fromdate ? fromdate : 'NA';
    todate   = todate ? todate : 'NA';
    if(fromdate=='NA' || todate=='NA')
    {
        loadVehiclesTable(modelId, '0');
    }
    else
    {
        loadVehiclesTableAvailability(modelId, fromdate, todate);
    }
});

function loadVehiclesTable(modelId, vehicleNumber) {
    $('#vehicleContainer').html('<div class="p-3 text-center">Loading...</div>');

    $.ajax({
      url: '/VehicleStatusController',
      method: 'POST',
      data: {
        modelId: modelId,
        vehicleNumber:vehicleNumber,
        action: 'get_vehicle_details_reservation',
        layout: 'fullwidth', company_id: $('#reservationCompanySelect').val()
      },
       dataType: 'json',
      success: function(response) {

        $('#vehicleContainer').html(response.html);
          $('#vehicleAvailabilityContent').html('');
   
        let content = '';
        let total = 0;

        // ✅ Use response.summary instead of response.rows
        if (response.summary) {
    
            let parsedSummary = JSON.parse(response.summary);
    
            $.each(parsedSummary, function(model, count) {
    
                total += count;
    
                let badgeClass = count > 0 ? 'bg-success' : 'bg-danger';
    
                content += `
                    <span class="badge ${badgeClass} me-2">
                        ${model}: ${count}
                    </span>
                `;
            });

        content = `<strong class="me-3">Total: ${total}</strong>` + content;

                    $('#vehicleAvailabilityContent').html(content);
                    $('#vehicleAvailabilityBar').show();
                    
                }
            else {
                $('#vehicleAvailabilityContent').html('');
                    $('#vehicleAvailabilityBar').hide();
            }
        
        
            $('#vehicleContainer .vehicle-card').each(function() {
                var $btn = $(this).find('.btn_vehicle_select');
                var vehicleId = $btn.data('id');

               
                if (selectedVehicles.some(item => item.id === vehicleId)) {
                    $(this).addClass('selected'); // highlight card
                    $btn.removeClass('btn-primary').addClass('btn-outline-danger');
                    $btn.attr('title', 'Deselect').attr('data-bs-original-title', 'Deselect');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-close-line me-1"></i> Deselect');
                } else {
                    $(this).removeClass('selected'); // normal
                    $btn.removeClass('btn-outline-danger').addClass('btn-primary');
                    $btn.attr('title', 'Select').attr('data-bs-original-title', 'Select');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-check-line me-1"></i> Select');
                }
            });
            
            if (typeof applyUiPermissions === 'function') {
                applyUiPermissions();
            }
      },
      error: function() {
         
        $('#vehicleContainer').html('<div class="text-danger">Failed to load</div>');
      }
    });
  }
  
 
$('#vehicleSearch').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();

        $('#vehicleContainer .vehicle-card').each(function() {
           
            var vehicleNumber = $(this).find('h5.text-danger').text().toLowerCase();

            if (vehicleNumber.indexOf(searchValue) > -1) {
                $(this).closest('.col-12').show(); 
            } else {
                $(this).closest('.col-12').hide(); 
            }
        });
    });


function toggleFooter(isOpen) {

    let content = $('#second_section');
    let footer = $('#selectedVehiclesFooter');

    if (isOpen) {

        footer.removeClass('d-none');

        
        content.css({
            'height': `calc(100vh - 290px)`,
            'overflow-y': 'scroll'
        });

    } else {

        footer.addClass('d-none');

        content.css({
            'height': '100vh',
            'overflow-y': 'auto'
        });
    }
}

 function updateSelectedFooter() {
    const footer = $('#selectedVehiclesFooter');
    const list = $('#selectedVehiclesList');
    list.empty();
    $('#selectedCount').text(selectedVehicles.length);
    if (selectedVehicles.length === 0) {
        footer.addClass('d-none'); // hide footer if none selected
        toggleFooter(false);
        return;
    }

    footer.removeClass('d-none');
    toggleFooter(true);

    selectedVehicles.forEach(vehicle => {
        const item = $(`
            <div class="badge bg-primary text-white d-flex align-items-center gap-1">
                ${vehicle.modelName} - ${vehicle.vehicleNumber}
                <i class="ri ri-close-line ms-1 cursor-pointer" style="font-size:14px;"></i>
            </div>
        `);

       
        item.find('i').on('click', function() {
            selectedVehicles = selectedVehicles.filter(v => v.id !== vehicle.id);
            updateSelectedFooter();

            // Also toggle select button on the card
            $(`.btn_vehicle_select[data-id="${vehicle.id}"]`)
                .removeClass('btn-outline-danger')
                .addClass('btn-primary')
                .attr('title', 'Select')
                .find('i')
                .removeClass('ri-close-line')
                .addClass('ri-check-line')
                .closest('.vehicle-card').removeClass('selected');
        });

        list.append(item);
    });
}

// Clear all
$('#clearSelectedVehicles').on('click', function() {
    selectedVehicles = [];
    updateSelectedFooter();

// Reset all select buttons
$('.btn_vehicle_select')
    .removeClass('btn-outline-danger')
    .addClass('btn-primary')
    .attr('title', 'Select')
    .find('i')
    .removeClass('ri-close-line')
    .addClass('ri-check-line')
    .closest('.vehicle-card').removeClass('selected');
});

function getBookingDetails() {
    return {
        fromDate: convertDDMMYYYYtoYYYYMMDD($('.from_datetime').val()),
        toDate: convertDDMMYYYYtoYYYYMMDD($('.to_datetime').val()),
        rateType: $('.rate_type').val(),
        service: $('.service').val(),
        rateTypeText:  $.trim($('.rate_type option:selected').text()),
        serviceText: $.trim($('.service option:selected').text()),
        duration: $('.duration').val(),
        price: $('.price').val(),
        vat: $('.vat').val(),
        total: $.trim($('#lineTotal').text()),
        notes: $('#booking_notes').val(),
        customerName: $('#customerName').val(),
        customerCode: $('#customer_code').val(),
        customerPhone: $('#customerPhone').val(),
        customerEmail: $('#customerEmail').val(),
        customerAddress: $('#customerAddress').val(),
        customerAttention: $('#customerAttention').val(),
        customer_cr_cpr: $('#customercprcr').val(),
        quotation_ref: $('#quotationRef').val(),
        book_through: $('#bookingTypeMain').val()
    };
}


$(document).on('click', '.btn_vehicle_select', function () {

    const $btn = $(this);
    try {
        const tip = bootstrap.Tooltip.getInstance($btn[0]);
        if (tip) tip.hide();
    } catch (e) {}
    $('.tooltip').remove();
    $btn.blur();
    const $card = $btn.closest('.vehicle-card');
    const bookingDetails = getBookingDetails();

    // ✅ VALIDATION
    if (window.__selectedCustomerBlacklisted) {
        setupDropdown('dropdownContent', 'error', svgError + "Cannot create contract for a blacklisted customer", 'click');
        return;
    }

    if (!bookingDetails.customerCode?.trim()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please select customer to proceed", 'click');
        return;
    }

    if (!bookingDetails.customerName?.trim()) {
        setupDropdown('dropdownContent', 'error', svgError + "Customer name is missing", 'click');
        return;
    }

    if (!bookingDetails.fromDate) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide from date", 'click');
        return;
    }

    if (!bookingDetails.toDate) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide to date", 'click');
        return;
    }
    
    if (new Date(bookingDetails.toDate) < new Date(bookingDetails.fromDate)) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide valid date range", 'click');
        return;
    }
    if (!bookingDetails.rateType || bookingDetails.rateType === '0') {
        setupDropdown('dropdownContent', 'error', svgError + "Please select type", 'click');
        return;
    }

    if (!bookingDetails.service || bookingDetails.service === '0') {
        setupDropdown('dropdownContent', 'error', svgError + "Please select service", 'click');
        return;
    }

    if (!bookingDetails.duration || parseFloat(bookingDetails.duration) <= 0) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide a valid duration", 'click');
        return;
    }

    if (!bookingDetails.price || parseFloat(bookingDetails.price) <= 0) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide a valid unit price", 'click');
        return;
    }

    let minpricecondition = 0;

    switch (bookingDetails.rateType) {
        case 'hour':
            minpricecondition = bookingDetails.service === '1'
                ? $btn.attr('data-priceHWOD')
                : $btn.attr('data-priceHWD');
            break;

        case 'day':
            minpricecondition = bookingDetails.service === '1'
                ? $btn.attr('data-priceDWOD')
                : $btn.attr('data-priceDWD');
            break;

        case 'week':
            minpricecondition = bookingDetails.service === '1'
                ? $btn.attr('data-priceWWOD')
                : $btn.attr('data-priceWWD');
            break;

        case 'month':
            minpricecondition = bookingDetails.service === '1'
                ? $btn.attr('data-priceMWOD')
                : $btn.attr('data-priceMWD');
            break;
    }

    // ✅ Convert to number
    minpricecondition = parseFloat(minpricecondition) || 0;
    let enteredPrice = parseFloat(bookingDetails.price) || 0;

    // ✅ Correct placement
    if (minpricecondition > enteredPrice) {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + "Price is below minimum. Please increase the unit price.",
            'click'
        );
        return;
    }
    let from = new Date(bookingDetails.fromDate);
    let to = new Date(bookingDetails.toDate);

    let passingDate = $btn.data('passing');
    let insuranceDate = $btn.data('insurance');
    let maintenanceDate = $btn.data('maintenance');
   

    let message = '';
    let showConfirm = false;

    // ✅ LOCAL DATE CHECKS
    if (passingDate && new Date(passingDate) >= from && new Date(passingDate) <= to) {
        showConfirm = true;
        message += '⚠️ Passing date falls within selected range<br>';
    }

    if (insuranceDate && new Date(insuranceDate) >= from && new Date(insuranceDate) <= to) {
        showConfirm = true;
        message += '⚠️ Insurance date falls within selected range<br>';
    }

    // if (maintenanceDate && new Date(maintenanceDate) >= from && new Date(maintenanceDate) <= to) {
    //     showConfirm = true;
    //     message += '⚠️ Maintenance date falls within selected range<br>';
    // }

    let vehicleId = $btn.data('id');

    // ✅ CHECK DB AVAILABILITY (ASYNC - CORRECT WAY)
    $.ajax({
        url: '/VehicleStatusController',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'check_vehicle_availability',
            vehicle_id: vehicleId,
            fromDate: bookingDetails.fromDate,
            toDate: bookingDetails.toDate
        },
        success: function (res) {

            const esc = (v) => $('<div>').text(v || '').html();
            const fmtBookings = (list) => list.map(b => {
                const no = b.booking_no ? `<strong>${esc(b.booking_no)}</strong>` : 'Booking';
                const cust = b.customer_name ? ` — ${esc(b.customer_name)}` : '';
                const st = b.book_status ? ` <span class="badge bg-label-warning">${esc(b.book_status)}</span>` : '';
                return `<div class="small ms-2 mb-1">• ${no}${cust}${st}<br><span class="text-muted ms-2">${esc(b.book_from_date)} to ${esc(b.book_to_date)}</span></div>`;
            }).join('');

            const overlapping = (res && Array.isArray(res.overlapping_bookings)) ? res.overlapping_bookings : [];
            const future = (res && Array.isArray(res.future_bookings)) ? res.future_bookings : [];

            // ✅ DB OVERLAP CHECK
            if (overlapping.length > 0) {
                showConfirm = true;
                message += '<div class="text-danger fw-semibold mb-1">⚠️ Vehicle already booked during the selected contract period:</div>' + fmtBookings(overlapping);
            } else if (res && res.status && res.exists) {
                showConfirm = true;
                message += '⚠️ Vehicle already booked in selected date range<br>';
            }

            // ✅ FUTURE BOOKINGS CHECK
            if (future.length > 0) {
                showConfirm = true;
                message += '<div class="text-warning fw-semibold mt-2 mb-1">📅 Vehicle has upcoming future booking(s):</div>' + fmtBookings(future);
            }

            // ✅ FINAL DECISION
            if (showConfirm) {

                message += '<br><b>Do you want to continue?</b>';

                $('#confirmMessage').html(message);

                window.pendingVehicleSelection = {
                    $btn: $btn,
                    $card: $card,
                    bookingDetails: bookingDetails
                };

                new bootstrap.Modal(document.getElementById('customConfirmModal')).show();

            } else {
                // ✅ SAFE → DIRECT SELECT
                processVehicleSelection($btn, $card, bookingDetails);
            }
        },
        error: function () {
            setupDropdown('dropdownContent', 'error', svgError + "Error checking vehicle availability", 'click');
        }
    });

});
function processVehicleSelection($btn, $card, bookingDetails) {

    const vehicle = {
        id: $btn.data('id'),
        modelId: $btn.data('model'),
        modelName: $btn.data('modelname'),
        vehicleNumber: $btn.data('veh_no'),
        chassisNumber: $btn.data('chassis'),
        categoryName: $btn.data('category'),
        vehicleColor: $btn.data('color'),
        vehicleYear: $btn.data('year'),
        currentStatusName: $btn.data('status'),
        insuranceExpiry: $btn.data('insurance'),
        passingExpiry: $btn.data('passing'),
        vehicleImage: $btn.data('image'),
        vehicleImages: $btn.data('images'),
        booking: bookingDetails
    };

    const index = selectedVehicles.findIndex(v => v.id === vehicle.id);

    if (index === -1) {

        selectedVehicles.push(vehicle);

        $card.addClass('selected');
        $btn.removeClass('btn-primary').addClass('btn-outline-danger');
        $btn.attr('title', 'Deselect').attr('data-bs-original-title', 'Deselect');
        $btn.html('<i class="ri ri-close-line me-1"></i> Deselect');

    } else {

        selectedVehicles.splice(index, 1);

        $card.removeClass('selected');
        $btn.removeClass('btn-outline-danger').addClass('btn-primary');
        $btn.attr('title', 'Select').attr('data-bs-original-title', 'Select');
        $btn.html('<i class="ri ri-check-line me-1"></i> Select');
    }

    try {
        const tip = bootstrap.Tooltip.getInstance($btn[0]);
        if (tip) {
            tip.hide();
            if (typeof tip.setContent === 'function') {
                tip.setContent({ '.tooltip-inner': index === -1 ? 'Deselect' : 'Select' });
            }
        }
    } catch (e) {}
    $('.tooltip').remove();
    $btn.blur();

    updateSelectedFooter();
}

$('#confirmYesBtn').on('click', function () {

    const modal = bootstrap.Modal.getInstance(document.getElementById('customConfirmModal'));
    modal.hide();

    const data = window.pendingVehicleSelection;
    if (!data) return;

    processVehicleSelection(data.$btn, data.$card, data.bookingDetails);

    window.pendingVehicleSelection = null;
});
$(document).on('click', '.vehicle-image', function () {
    let images = $(this).data('images');
    openVehicleModal(images);
});

function openVehicleModal(images) {

    // safe parse
    if (typeof images === "string") {
        try {
            images = JSON.parse(images);
        } catch (e) {
            images = [];
        }
    }

    // force array
    if (!Array.isArray(images)) {
        images = [];
    }

    // remove invalid values
    images = images.filter(img => img && img !== "default.jpg");

    if (images.length === 0) {
        images = ["default.jpg"];
    }

    images = [...images].reverse();

    let inner = document.getElementById("vehicleCarouselInner");
    let indicators = document.getElementById("vehicleCarouselIndicators");

    inner.innerHTML = "";
    indicators.innerHTML = "";

    images.forEach((img, index) => {

        let activeClass = index === 0 ? "active" : "";

        inner.innerHTML += `
            <div class="carousel-item ${activeClass}">
                <img src="uploads/vehicleImages/${img}" 
                     class="d-block w-100"
                     style="max-height:500px;object-fit:contain;">
            </div>
        `;

        indicators.innerHTML += `
            <button type="button"
                data-bs-target="#modalCarouselControls"
                data-bs-slide-to="${index}"
                class="${activeClass}">
            </button>
        `;
    });

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalvehicleimages')
    ).show();
}
 let DecimalPositions = 3;  
function line_item_calculation()
{
   
   let from = parseDDMMYYYYtoJSDate($('.from_datetime').val());
   let to = parseDDMMYYYYtoJSDate($('.to_datetime').val());
   let rateType = $('.rate_type').val();;

    if(from && to && to >= from){

        let diffMs = to - from;
        let duration_count = 0;

        if(rateType == 'hour'){
            duration_count = Math.ceil(diffMs / (1000*60*60)); // hours
        } else if(rateType == 'day'){
            duration_count = Math.ceil(diffMs / (1000*60*60*24)); // days
        }
        else if (rateType == 'week') {
        duration_count = Math.ceil(diffMs / (1000 * 60 * 60 * 24 * 7)); // weeks

        }
        else if(rateType == 'month'){
            duration_count = Math.ceil(diffMs / (1000*60*60*24*30)); // months
        }

       $('.duration').val(duration_count);

        
        let price = parseFloat($('.price').val()) || 0;
        let qty = 1;
        let vat = parseFloat($('.vat').val()) || 0;

        let total = (price * qty * duration_count) * (1 + vat/100);
        
        $('#lineTotal').text(total.toFixed(DecimalPositions));

    }
}


$(document).on('blur','.to_datetime',function(){

  
    let from = $('.from_datetime').val();
    let to = $(this).val();
    if($('.rate_type').val() === 'hour') {
        let fromDate = parseDDMMYYYYtoJSDate(from);
        let toDate   = parseDDMMYYYYtoJSDate(to);
    } else {
        let fromDate = parseDDMMYYYYtoJSDate(from);
        let toDate   = parseDDMMYYYYtoJSDate(to);

        if(toDate < fromDate){
             setupDropdown('dropdownContent','error',svgSuccess+'To date must be after From date','click');
            
            $(this).val('');
        }

    }

});

$('.service').on('change', function () {

    let vatValue = $(this).find('option:selected').data('id');

    if (vatValue !== undefined) {
        $('.vat').val(vatValue);
    }

    // optional: trigger recalculation
    $('.vat').trigger('input');
});
$('.service, .rate_type, .from_datetime, .to_datetime, .price, .vat, .duration')
.on('input change', function () {
    let modelId = $('#ModelRef').val() || 'All';
    let fromDate = $('.from_datetime').val();
    let toDate   = $('.to_datetime').val();
    
    if (fromDate !== '' && toDate !== '') {
        loadVehiclesTableAvailability(modelId, fromDate, toDate);
    }
    line_item_calculation();
});

$(document).on('input change', '.watch-field', function () {
   
    recalculate();
    line_item_calculation();
     
});

$(document).on('click', '#recalcBtn', function () {
    let fromDate = $('.from_datetime').val();
        let toDate = $('.to_datetime').val();
        let from = parseDDMMYYYYtoJSDate(fromDate);
        let to = parseDDMMYYYYtoJSDate(toDate);
        let service = $('.service').val();
        let rateType = $('.rate_type').val();
        let modelId = $('#ModelRef').val();
        
            if (fromDate === '' || toDate === '') {
                 setupDropdown('dropdownContent', 'error', svgError + "Please provide booking dates", 'click');
                        return false;
               
            }
            else if (to < from) {
                 setupDropdown('dropdownContent', 'error', svgError + "Please provide valid date range", 'click');
                        return false;
               
            }
             else if (!service && service ==='0') {
                 setupDropdown('dropdownContent', 'error', svgError + "Please select service to proceed", 'click');
                        return false;
               
            }
             else if (!rateType && rateType ==='0') {
                 setupDropdown('dropdownContent', 'error', svgError + "Please select type to proceed", 'click');
                        return false;
               
            }
            else if (!modelId || modelId === 'All') {
                 setupDropdown('dropdownContent', 'error', svgError + "Please specify the model", 'click');
                        return false;
               
            }
            else
            {
                recalculate();
                line_item_calculation();
            }
});
$('.minprice').val('0');
function getPriceList(response) {
    try {
        // Step 1: Check if data exists
        if (!response?.data || !response.data[0]?.price_json) {
            return [];
        }

        // Step 2: Parse JSON string
        let priceArray = JSON.parse(response.data[0].price_json);

        // Step 3: Normalize values
        return priceArray.map(item => ({
            id: item.ids || '',
            item: item.item || '',
            amount: item.amount && item.amount !== '' 
                ? parseFloat(item.amount).toFixed(3) 
                : '0.000'
        }));

    } catch (error) {
        console.error("Error parsing price_json:", error);
        return [];
    }
}
function getAmount(data, keyword) {

    let list = getPriceList(data);

    let found = list.find(x =>
        x.item.toLowerCase().includes(keyword.toLowerCase())
    );

    return found ? parseFloat(found.amount) : 0;
}
function recalculate()
{
    let fromDate = $('.from_datetime').val();
    let toDate = $('.to_datetime').val();
    let from = parseDDMMYYYYtoJSDate(fromDate);
    let to = parseDDMMYYYYtoJSDate(toDate);
       
    let service = $('.service').val();
    let service_text = $('.service option:selected').text();
    let rateType = $('.rate_type').val();
    let modelId = $('#ModelRef').val();
    
    if( modelId && modelId !== 'All' && service && service!='0' && rateType && rateType!='0')
    {
         $.ajax({
        url: '/VehicleStatusController',
        type: 'POST',
        data: {
            modelId: modelId,
            action: 'get_model_price_details'
        },
        success: function (response) {
            let search_keyword=rateType+" " +service_text;
            let unit_amt = getAmount(response, search_keyword);
            $('.min-price-text').text('Min price : '+unit_amt);
            $('.minprice').val(unit_amt);
            
            // Populate unit price and run calculation
            $('.price').val(unit_amt);
            line_item_calculation();
        },
        error: function () {
            alert('Server error occurred');
        }
    });
        
    }
   
    
}
function renderVehicleTable(selectedVehicles) {

    let tbody = '';

    selectedVehicles.forEach((v, index) => {

        const b = v.booking || {};

        let price = parseFloat(b.price || 0);
        let vat = parseFloat(b.vat || 0);
        let duration = parseFloat(b.duration || 0);
       

        tbody += `
        <tr>
            <td>${index + 1}</td>
            <!-- Vehicle (Model + Number) -->
            <td>
                <div class="d-flex flex-column">
                    <span class="fw-semibold">${v.modelName || '-'}</span>
                    <small class="text-muted">${v.vehicleNumber || '-'}</small>
                </div>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <span class="fw-semibold">${b.customerName || '-'}</span>
                    <small class="text-muted">${b.customerCode || '-'}</small>
                </div>
            </td>

            
            <!-- Booking -->
            <td style="min-width:220px;">
                From: ${b.fromDate || '-'} <br>
                To: ${b.toDate || '-'} <br>
                Rate: ${b.rateTypeText || '-'} <br>
                Service: ${b.serviceText || '-'}
            </td>

            <!-- Pricing -->
            <td>
                Duration: ${b.duration || 0} <br>
                Price: ${b.price || 0} <br>
                VAT: ${b.vat || 0}% <br>
                <strong>Total: ${b.total}</strong>
            </td>

            <!-- Notes -->
             <td>${b.notes || '-'}</td>

           

            <!-- Action -->
            <td>
                <button class="btn btn-sm btn-danger deleteVehicle"
                        data-index="${index}">
                    <i class="ri ri-delete-bin-line"></i>
                </button>
            </td>
        </tr>
        `;
    });

    $('#vehicleTableBody').html(tbody);

    new bootstrap.Modal(document.getElementById('bookingSummaryModal')).show();
}


$(document).on('click', '#proceedSelectedVehicles', function () {
        
        let hasManage = window.USER_PERMISSIONS && (window.USER_PERMISSIONS.includes('*') || window.USER_PERMISSIONS.includes('generate_contract_manage'));
        if (!hasManage) {
            setupDropdown('dropdownContent', 'error', svgError + "You do not have permission to generate contracts.", 'click');
            return false;
        }
    
        let fromDate = $('.from_datetime').val();
        let toDate = $('.to_datetime').val();
        let from = parseDDMMYYYYtoJSDate(fromDate);
        let to = parseDDMMYYYYtoJSDate(toDate);
        
       
   // let serviceType = $('#select_service_type').val();
   let serviceType = 'Reserve Vehicles';
   
    if ($('#customerName').val()=='' ) {
         setupDropdown('dropdownContent', 'error', svgError + "Please provide customer name", 'click');
                return false;
       
    }

    else if (fromDate === '' || toDate === '') {
         setupDropdown('dropdownContent', 'error', svgError + "Please provide booking dates", 'click');
                return false;
       
    }
    else if (to < from) {
         setupDropdown('dropdownContent', 'error', svgError + "Please provide valid date range", 'click');
                return false;
       
    }
    else if ($('#bookingTypeMain').val()=='quotation' && $('#quotationRef').val()=='') {
         setupDropdown('dropdownContent', 'error', svgError + "Please select a quotation", 'click');
                return false;
       
    }
   else if (!serviceType) {
         setupDropdown('dropdownContent', 'error', svgError + "Please select service to proceed", 'click');
                return false;
       
    }

    else if (selectedVehicles.length === 0) {
         setupDropdown('dropdownContent', 'error', svgError + "Please select at least one vehicle", 'click');
                return false;
       
    }

    else
    {
        
        
        switch(serviceType)
        {
            case 'Reserve Vehicles':
                let b_unit_price = parseFloat($('.price').val()) || 0;
                let b_duration = parseFloat($('.duration').val()) || 0;
                let b_vat_perc = parseFloat($('.vat').val()) || 0;
                let b_total = b_unit_price * b_duration;
                let b_vat_amt = b_total * (b_vat_perc / 100);
                let b_final_total = b_total + b_vat_amt;

                let bookingDetails = {
                    customerName: $('#customerName').val(),
                    customerCode: $('#customer_code').val(),
                    fromDate: $('.from_datetime').val(),
                    toDate: $('.to_datetime').val(),
                    rateType: $('.rate_type option:selected').text(),
                    service: $('.service option:selected').text(),
                    duration: $('.duration').val(),
                    unitPrice: b_unit_price.toFixed(3),
                    minPrice: $('.minprice').val(),
                    vatPerc: b_vat_perc.toFixed(2),
                    vatAmt: b_vat_amt.toFixed(3),
                    total: b_final_total.toFixed(3),
                    notes: $('#booking_notes').val()
                };
                buildDirectContractWizard(bookingDetails, selectedVehicles);
                $('#directContractWizardModal').modal('show');
            break;
            case 'Create Contract':
            break;
        }
    }
    
    
   
    
});
 $('#btnSearchVehicle').on('click', function() {
        let vehicleNos = $('#vehicleSearch').val().trim();

        if(vehicleNos === '') {
             setupDropdown('dropdownContent', 'error', svgError + "Please enter a vehicle number", 'click');
                return false;
           
        }
       
        let fromDate = $('.from_datetime').val();
        let toDate   = $('.to_datetime').val();
        
        if (fromDate !== '' && toDate !== '') {
            loadVehiclesTableAvailability('All', fromDate, toDate, vehicleNos);
        }
        else
        {
             loadVehiclesTable('0', vehicleNos);
        }
       
       
       
    });
$(document).on('click', '.deleteVehicle', function () {

    let index = $(this).data('index');

    selectedVehicles.splice(index, 1);
   updateSelectedFooter();
    renderVehicleTable(selectedVehicles);
});

$('#confirmReservation').on('click', function () {

    $.ajax({
        url: '/VehicleStatusController',
        type: 'POST',
        dataType: 'json', // 🔥 important
        data: {
            vehicles: JSON.stringify(selectedVehicles),
            action: 'reserve_vehicles', company_id: $('#reservationCompanySelect').val()
        },
        success: function (response) {
            
            if (response.status) {
                $('#bookingSummaryModal').modal('hide');
                setupDropdown(
                    'dropdownContent',
                    'success',
                    svgSuccess + 'Booking Created: ' + response.booking_no,
                    'click'
                );
            
                // ⏳ Wait then reload
                setTimeout(function () {
                    location.reload();
                }, 2000); // 2 seconds

            } else {
                alert(response.message || 'Error generating booking');
            }
        },
        error: function () {
            alert('Server error occurred');
        }
    });

});

 modelloadDropdownAvail();
 $('#fromDateTimeavail').val('');
 $('#toDateTimeavail').val('');
$(document).on('click', '#btnCheckAvailability', function () {
    let modalEl = document.getElementById('checkavailabilityModal');

    let modal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',  // prevent outside click close
        keyboard: false      // prevent ESC close
    });

    modal.show(); // ✅ REQUIRED
});
function validateDateRange(from, to) {

   
    if (!from && !to) {
         return { valid: false, message: 'Please select both From and To date & time' };
    }

    if (!from || !to) {
        return { valid: false, message: 'Please select both From and To date & time' };
    }

    let fromDate = new Date(from);
    let toDate = new Date(to);

    if (isNaN(fromDate) || isNaN(toDate)) {
        return { valid: false, message: 'Invalid date format' };
    }
    if (fromDate >= toDate) {
        return { valid: false, message: 'From date must be less than To date' };
    }

    return { valid: true };
}
function loadVehiclesTableAvailability(modelId, fromDate, toDate,VehicleNo = null) {
    $('#vehicleContainer').html('<div class="p-3 text-center">Loading...</div>');

    $.ajax({
      url: '/VehicleStatusController',
      method: 'POST',
      data: {
        modelId: modelId,
        fromDate:fromDate,
        toDate:toDate,
        vehicleNumber: VehicleNo || 'NA',
        action: 'get_vehicle_details_reservation_avail',
        layout: 'fullwidth', company_id: $('#reservationCompanySelect').val()
      },
      dataType: 'json',
      success: function(response) {

        $('#vehicleContainer').html(response.html);
          $('#vehicleAvailabilityContent').html('');
   
        let content = '';
        let total = 0;

        // ✅ Use response.summary instead of response.rows
        if (response.summary) {
    
            let parsedSummary = JSON.parse(response.summary);
    
            $.each(parsedSummary, function(model, count) {
    
                total += count;
    
                let badgeClass = count > 0 ? 'bg-success' : 'bg-danger';
    
                content += `
                    <span class="badge ${badgeClass} me-2">
                        ${model}: ${count}
                    </span>
                `;
            });

        content = `<strong class="me-3">Total: ${total}</strong>` + content;

                    $('#vehicleAvailabilityContent').html(content);
                    $('#vehicleAvailabilityBar').show();
                    
                }
            else {
                $('#vehicleAvailabilityContent').html('');
                    $('#vehicleAvailabilityBar').hide();
            }
        
            $('#vehicleContainer .vehicle-card').each(function() {
                var $btn = $(this).find('.btn_vehicle_select');
                var vehicleId = $btn.data('id');

               
                if (selectedVehicles.some(item => item.id === vehicleId)) {
                    $(this).addClass('selected'); // highlight card
                    $btn.removeClass('btn-primary').addClass('btn-outline-danger');
                    $btn.attr('title', 'Deselect').attr('data-bs-original-title', 'Deselect');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-close-line me-1"></i> Deselect');
                } else {
                    $(this).removeClass('selected'); // normal
                    $btn.removeClass('btn-outline-danger').addClass('btn-primary');
                    $btn.attr('title', 'Select').attr('data-bs-original-title', 'Select');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-check-line me-1"></i> Select');
                }
            });
            
            if (typeof applyUiPermissions === 'function') {
                applyUiPermissions();
            }
      },
      error: function() {
         
        $('#vehicleContainer').html('<div class="text-danger">Failed to load</div>');
      }
    });
  }

  $(document).on('click', '#closeAvailabilityBar', function () {
     $('#vehicleAvailabilityContent').html('');
    $('#vehicleAvailabilityBar').hide();
});
 
$(document).on('click', '#btnSubmitAvailability', function () {
    let from = $('#fromDateTimeavail').val();
    let to = $('#toDateTimeavail').val();

    let validation = validateDateRange(from, to);

    if (!validation.valid) {
         setupDropdown('dropdownContent', 'error', svgError + validation.message, 'click');
                return false;
       
        return;
    }
    let modelId = $('#vehicleModelAvail').val();
    $('.from_datetime').val(from);
    $('.to_datetime').val(to);
     $('#ModelRef').val(modelId).trigger('change');
     
    loadVehiclesTableAvailability(modelId,from,to);
   let modalEl = document.getElementById('checkavailabilityModal');
    let modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
        
});
$(document).on('click', '.AvailcancelBtn', function () {
    let modalEl = document.getElementById('checkavailabilityModal');
    let modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
});
$(document).on('click', '.booking-banner', function (e) {
    e.preventDefault();
    e.stopPropagation();

    let bookings = $(this).data('bookings');

    // Ensure it's parsed
    if (typeof bookings === 'string') {
        bookings = JSON.parse(bookings);
    }

    let rows = '';

    if (bookings && bookings.length > 0) {

        bookings.forEach((b, index) => {

            let badgeClass = 'secondary';
            if (b.status === 'Pending' || b.status === 'Booked') badgeClass = 'warning';
            if (b.status === 'Confirmed') badgeClass = 'primary';
            if (b.status === 'Cancelled') badgeClass = 'danger';

            const refInfo = (b.booking_no || b.customer_name)
                ? `<div class="fw-semibold">${$('<div>').text(b.booking_no || '-').html()}</div><div class="small text-muted">${$('<div>').text(b.customer_name || '-').html()}</div>`
                : '<span class="text-muted">-</span>';

            rows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${refInfo}</td>
                    <td>${b.from}</td>
                    <td>${b.to}</td>
                    <td>
                        <span class="badge bg-${badgeClass}">
                            ${b.status}
                        </span>
                    </td>
                </tr>
            `;
        });

    } else {
        rows = `<tr><td colspan="5" class="text-center">No bookings</td></tr>`;
    }

   $('#bookingListTableBody').html(rows);
    $('#bookingListModal').modal('show');
});

$(document).ready(function() {
    $('#reservationCompanySelect').on('change', function() {
        // Clear all selected vehicles
        selectedVehicles = [];
        updateSelectedFooter();
        
        // Clear vehicle container
        $('#vehicleContainer').html('<div class="p-3 text-center text-muted">Please select a model to view vehicles.</div>');
        
        // Reset Booking Details (Step 2)
        $('.from_datetime').val('');
        $('.to_datetime').val('');
        $('.rate_type').val('0');
        $('.service').val('0');
        $('.duration').val('0');
        $('.price').val('0');
        $('.minprice').val('');
        $('.vat').val('10');
        $('#booking_notes').val('');
        $('#lineTotal').text('0.000');
        $('.min-price-text').text('Min: 0.000');
        $('#vehicleSearch').val('');
        
        // Reload models based on the new company (do not preserve old selection)
        modelloadDropdown(false);
        modelloadDropdownAvail(false);
        $('#ModelRef').val('').trigger('change');
        
        // Redirect to Step 1
        if (typeof window.stepper !== 'undefined') {
            window.stepper.to(1);
        }
    });
});

function formatDate(dateStr) {
    let d = new Date(dateStr);
    return d.toLocaleDateString();
}


});

// OVERRIDE btn_vehicle_view to open profile modal instead of old details modal
$(document).ready(function() {
    $(document).off('click', '.btn_vehicle_view').on('click', '.btn_vehicle_view', function(e) {
    e.preventDefault();
    let vehicleId = $(this).data('id');
    openVehicleProfile(vehicleId);
    });
});

function openVehicleProfile(vehicleId) {
    $.ajax({
        url: "/AddVehicles",
        type: "POST",
        dataType: "json",
        data: JSON.stringify({ action: "get_vehicle_profile", vehicle_id: vehicleId }),
        contentType: "application/json",
        success: function(response) {
            if (response.status && response.data) {
                let v = response.data;
                
                // Populate base data
                $("#vpVehicleNumber").text(v.vehicle_number || "N/A");
                $("#vpVehicleNumBody").text(v.vehicle_number || "N/A");
                $("#vpCategory").text(v.category_name || "N/A");
                $("#vpBrand").text(v.brand_name || "N/A");
                $("#vpModel").text(v.model_names || "N/A");
                $("#vpChassis").text(v.chassis_number || "N/A");
                $("#vpYear").text(v.vehicle_year || "N/A");
                $("#vpColor").text(v.vehicle_color || "N/A");
                $("#vpPurchaseDate").text(v.formatted_purchase_date || "Not Set");
                $("#vpNextInsurance").text(v.formatted_insurance_date || "Not Set");
                $("#vpNextPassing").text(v.formatted_passing_date || "Not Set");
                
                // Current User
                $("#vpRentoutDiv").hide();
                $("#vpStaffDiv").hide();
                if (v.vehicle_status === 'Rentout' && v.current_user_name) {
                    $("#vpRentoutDiv").show();
                    $("#vpCurrentUserName").text(v.current_user_name);
                    $("#vpCurrentUserContact").text(v.current_user_contact || "No Contact");
                    $("#vpContractRef").text(v.contract_ref || "N/A");
                    let expRet = v.expected_return_date ? dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : "N/A";
                    $("#vpReturnDate").text(expRet);
                } else if (v.vehicle_status === 'Staff Use' && v.current_user_name) {
                    $("#vpStaffDiv").show();
                    $("#vpStaffName").text(v.current_user_name);
                    $("#vpStaffContact").text(v.current_user_contact || "No Contact");
                    $("#vpStaffRef").text(v.contract_ref || "N/A");
                    let expRet = v.expected_return_date ? dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : "N/A";
                    $("#vpStaffReturnDate").text(expRet);
                }
                
                // Status badge
                let statusClass = "bg-label-primary";
                if(v.vehicle_status === "Available") statusClass = "bg-label-success";
                else if(v.vehicle_status === "Rentout") statusClass = "bg-label-danger";
                else if(v.vehicle_status === "Maintenance") statusClass = "bg-label-warning";
                $("#vpStatusBadge").attr("class", "badge " + statusClass).text(v.vehicle_status || "Unknown");
                
                // Ownership
                $("#vpRegCompany").text(v.ownership_company || "N/A");
                if (v.is_outsourced === "Yes") {
                    $("#vpOutsourceDiv").show();
                    $("#vpOutsourceCompany").text(v.outsourcing_company_name || "N/A");
                } else {
                    $("#vpOutsourceDiv").hide();
                }
                
                // Other details (JSON)
                let od = v.other_details || {};
                $("#vpFuelType").text(od.vehicleFuelType || "N/A");
                $("#vpGearType").text(od.vehicleGearType || "N/A");
                
                // Dynamic Pricing
                $("#vpPricingList").empty();
                if (v.model_price_json && v.model_price_json !== "") {
                    try {
                        let prices = JSON.parse(v.model_price_json);
                        if (prices && prices.length > 0) {
                            let groups = { Hour: [], Day: [], Week: [], Month: [], Year: [], Other: [] };
                            prices.forEach(p => {
                                if (p.amount && p.amount !== "") {
                                    let itemLower = p.item.toLowerCase();
                                    let groupName = 'Other';
                                    if (itemLower.includes('hour')) groupName = 'Hour';
                                    else if (itemLower.includes('day')) groupName = 'Day';
                                    else if (itemLower.includes('week')) groupName = 'Week';
                                    else if (itemLower.includes('month')) groupName = 'Month';
                                    else if (itemLower.includes('year')) groupName = 'Year';
                                    
                                    let displayName = p.item;
                                    if (itemLower.includes('without driver')) displayName = 'W/O Driver';
                                    else if (itemLower.includes('with driver')) displayName = 'With Driver';
                                    groups[groupName].push({ name: displayName, amount: p.amount });
                                }
                            });
                            let html = '<div class="row g-2 w-100">';
                            for (const [gName, items] of Object.entries(groups)) {
                                if (items.length > 0) {
                                    html += `<div class="col-6"><div class="border rounded px-2 py-1 bg-lighter"><div class="text-center text-muted fw-bold border-bottom mb-1" style="font-size: 11px;">${gName}</div>`;
                                    items.forEach(i => {
                                        html += `<div class="d-flex justify-content-between align-items-center mb-1"><span class="text-muted" style="font-size: 11px;">${i.name}</span><strong class="text-success" style="font-size: 11px;">${i.amount} <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong></div>`;
                                    });
                                    html += `</div></div>`;
                                }
                            }
                            html += '</div>';
                            $("#vpPricingList").html(html);
                        }
                    } catch(e) {}
                }
                if ($("#vpPricingList").is(':empty')) {
                    $("#vpPricingList").html('<span class="text-muted fst-italic">No pricing setup</span>');
                }
                
                // Status badge styling / Images
                let images = v.images || [];
                let carouselInner = $("#vpCarouselInner");
                carouselInner.empty();
                if (images.length > 0) {
                    $("#vpNoImagesMessage").hide();
                    $("#vpImageCarousel").show();
                    images.forEach((img, idx) => {
                        let activeClass = idx === 0 ? "active" : "";
                        let imgPath = img.includes("http") ? img : ("/uploads/vehicleImages/" + img); 
                        carouselInner.append(`<div class="carousel-item ${activeClass} h-100"><img src="${imgPath}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Vehicle Image"></div>`);
                    });
                } else {
                    $("#vpImageCarousel").hide();
                    $("#vpNoImagesMessage").show();
                }
                
                if ($("#vehicleProfileModal").length) {
                    $("#vehicleProfileModal").appendTo("body");
                }
                $("#vehicleProfileModal").modal("show");
            }
        }
    });
}
</script>
</body>

</html>










