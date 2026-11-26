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

if (empty($_GET['embed_return']) || $_GET['embed_return'] !== '1') {
    $isContractListMode = true;
    include __DIR__ . '/active_contracts_dashboard.php';
    exit();
}
?>
<?php
include('envinclude.php');
?>
<!doctype html>

<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="../assets/"
  data-template="horizontal-menu-template-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    
    <?php include('templates/title.php'); ?>
    <meta name="description" content="" />

    <?php include('templates/head.php'); ?>

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">
    <link rel="stylesheet" href="../assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/editor.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/notyf/notyf.css" />
     <style>
        .ledger-card { height: 100%; }
        .summary-card { border-left: 4px solid; }
        .card-total-debit { border-left-color: #ff4d49; }
        .card-total-credit { border-left-color: #72e128; }
        .card-balance { border-left-color: #26c6f9; }
        .row-collected { background-color: #e8fadf !important; }
        .row-bounced { background-color: #ffe5e5 !important; }
        .fc-event { cursor: pointer; }
    </style>
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="../assets/js/config.js"></script>
    <style>
        
        .spin {
    animation: spin 1s linear infinite;
}
@keyframes spin {
    100% { transform: rotate(360deg); }
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
.child-wrapper {
    background: #f8f9fa;
    border: 2px solid #ced4da; 
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    border-left: 5px solid #1b3d94; /* blue highlight */
}
.modern-check {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #1b3d94;
}

tr.shown {
    background-color: #fff3cd !important; /* highlight parent row */
}
#dropdownContent {
     position: fixed !important;
    z-index: 999999 !important;
   
}
<?php if (!empty($_GET['embed_return']) && $_GET['embed_return'] === '1'): ?>
html, body {
    background: transparent !important;
    width: 100% !important;
    height: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden !important;
}
.layout-wrapper {
    display: none !important;
}
#ReturncontractModal, .modal {
    position: fixed !important;
    inset: 0 !important;
    z-index: 100000 !important;
}
#imagePreviewModal, #imagePreviewModalreturn, #modalAddViolationHead {
    z-index: 100080 !important;
}
#ReturncontractModal .modal-dialog {
    margin: 1.5rem auto !important;
}
.modal-backdrop {
    z-index: 99999 !important;
}
<?php endif; ?>
#contractcustdriverdocpreview li {
          width: 60px;
          height: 60px;
          overflow: hidden;
          border-radius: 50%; /* keep avatar circle */
          display: flex;
          align-items: center;
          justify-content: center;
        }
        
#contractcustdriverdocpreview img {
  width: 100%;
  height: 100%;
  object-fit: cover;   /* ✅ fills properly */
  border-radius: 50%;
}
#confirmActionModal,
#confirmActionModal * {
    pointer-events: auto !important;
}
#confirmActionModal {
    z-index: 999999 !important;
   
}
#customConfirmModalAfterOTPValidation {
    z-index: 999999 !important;
   
}
#customConfirmModal {
    z-index: 999999 !important;
   
}
#returncustomConfirmModal {
    z-index: 999999 !important;
   
}
#signatureModal {
    z-index: 999999 !important;
   
}
#signatureModalView {
    z-index: 999999 !important;
   
}

.card-headernew {
    min-height: auto !important;
    padding-top: 6px !important;
    padding-bottom: 6px !important;
}
.select2-container {
    width: 100% !important;
}

.select2-container .select2-selection--single {
    height: 38px !important;
    display: flex !important;
    align-items: center !important;
    border: 1px solid #ced4da;
}

.select2-container .select2-selection__rendered {
    line-height: 38px !important;
    padding-left: 12px !important;
}

.select2-container .select2-selection__arrow {
    height: 38px !important;
}

.select2-dropdown {
    z-index: 99999 !important;
}

#contractTable > thead > tr > th {
    background: #eef3fc !important;
    color: #1b3d94 !important;
    border-bottom: 2px solid #1b3d94 !important;
    font-weight: 600;
    text-transform: uppercase;
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
            <div class="container-fluid flex-grow-1 container-p-y">
             
              <!-- Product List Table -->
               <?php include('templates/VehicleContractList/vehicle_contract_body.php'); ?>
              <?php include('templates/VehicleReservation/add_new_customer_modal.php'); ?>
              <?php include('templates/VehicleReservation/custom_confirm_modal.php'); ?>
              <?php include('templates/VehicleReservation/confirm_action_modal.php'); ?>
              
              <?php include('templates/VehicleContractList/confirmafteroptvalidation_modal.php'); ?>
               <?php include('templates/VehicleContractList/extend_contract_modal.php'); ?>
               <?php include('templates/VehicleContractList/return_contract_modal.php'); ?>
               <?php include('templates/VehicleContractList/return_receipt_modal.php'); ?>
               <?php include('templates/VehicleContractList/replace_contract_modal.php'); ?>
               
              <?php include('templates/VehicleContractList/extension_list_modal.php'); ?>
              <?php include('templates/VehicleContractList/customer_driver_documents_upload.php'); ?>
              <?php include('templates/VehicleContractList/vehicle_image_preview_modal.php'); ?>
               <?php include('templates/VehicleContractList/return_vehicle_image_preview_modal.php'); ?>
               <?php include('templates/VehicleContractList/return_image_preview_modal.php'); ?>
               
              
              <?php include('templates/VehicleContractList/otp_verify_modal.php'); ?>
              <?php include('templates/VehicleContractList/otp_submit_modal.php'); ?>
               <?php include('templates/VehicleContractList/view_contract_details_modal.php'); ?>
                <?php include('templates/VehicleContractList/contract_ledger_modal.php'); ?>
                <?php include('templates/VehicleContractList/contract_ledger_supporting_modals.php'); ?>
                <?php include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
                <?php include('templates/vehicles/vehicle_profile_modal.php'); ?>
                       
              <?php include('templates/VehicleContractList/close_otp_verify_modal.php'); ?>
              <?php include('templates/VehicleContractList/close_otp_submit_modal.php'); ?>
             <?php include('templates/VehicleContractList/close_confirmafteroptvalidation_modal.php'); ?>
            
            </div>
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
 <?php //include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->
    <?php include('templates/scripts.php'); ?>
    <script src="../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
     <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/sands/settings.js"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>
    <script src="../assets/vendor/libs/quill/katex.js"></script>
    <script src="../assets/vendor/libs/highlight/highlight.js"></script>
    <script src="../assets/vendor/libs/quill/quill.js"></script>
    <script src="../assets/vendor/libs/moment/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
     <script src="../assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
     <script src="../assets/vendor/libs/notyf/notyf.js"></script>
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
     <script src="../httpdocs/user_js/car_survey_widget.js?v=<?= time() ?>"></script>
     <script src="../httpdocs/user_js/return_receipt_modal.js?v=<?= time() ?>"></script>
    <script>
         const fullToolbar = [
                [
                  {
                    font: []
                  },
                  {
                    size: []
                  }
                ],
                ['bold', 'italic', 'underline', 'strike'],
                [
                  {
                    color: []
                  },
                  {
                    background: []
                  }
                ],
                [
                  {
                    script: 'super'
                  },
                  {
                    script: 'sub'
                  }
                ],
                [
                  {
                    header: '1'
                  },
                  {
                    header: '2'
                  },
                  'blockquote',
                  'code-block'
                ],
                [
                  {
                    list: 'ordered'
                  },
                  {
                    indent: '-1'
                  },
                  {
                    indent: '+1'
                  }
                ],
                [{ direction: 'rtl' }, { align: [] }],
                ['link', 'image', 'video', 'formula'],
                ['clean']
              ];
             const fullEditorOnBody = new Quill('#full-editor-onbody', {
                bounds: '#full-editor-onbody',
                placeholder: 'Terms & Condition',
                modules: {
                  syntax: true,
                  toolbar: fullToolbar
                },
                theme: 'snow'
              });
             
    </script>
<script>
$(document).ready(function() {
    $('.modal').on('hidden.bs.modal', function () {

    if ($('.modal.show').length) {

        $('body').addClass('modal-open');
    }
});
let otpVerified = false;
let existingAttachments = {
    vehicles: []
};
 let bookingMaster = {
        vehicles: []
    };
 let vehiclesObj = {
    documentName: '',
    files: []
};
let carImageQueue = [];
let existingVehicleImages = [];

let uploadedFileNames = [];
let existingFileNames = [];

let carImageQueueReturn = [];
let existingVehicleImagesReturn = [];

let uploadedFileNamesReturn = [];
let existingFileNamesReturn = [];
//Return Signature
let returnSignaturePad;

$('#ReturncontractModal').on('shown.bs.modal', function () {

    const canvas = document.getElementById('Returnsignature-pad');

    // Prevent multiple initialization
    if (returnSignaturePad) {
        return;
    }

    function resizeCanvas() {

        const ratio = Math.max(window.devicePixelRatio || 1, 1);

        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = 200 * ratio;

        const ctx = canvas.getContext("2d");

        ctx.scale(ratio, ratio);
    }

    resizeCanvas();

    returnSignaturePad = new SignaturePad(canvas, {
        backgroundColor: '#fff'
    });

    window.addEventListener('resize', resizeCanvas);
});

$(document).on('shown.bs.modal hidden.bs.modal', '#ReturncontractModal', function (e) {
    if (typeof laddaReturnContract !== 'undefined' && laddaReturnContract) {
        laddaReturnContract.stop();
    }
    $('#btn_return_contract').prop('disabled', false);
    if (e.type === 'hidden') {
        const qp = new URLSearchParams(window.location.search);
        if (qp.get('embed_return') === '1' && window.parent && window.parent !== window) {
            const promptInfo = window.__pendingReceiptPrompt || null;
            window.__pendingReceiptPrompt = null;
            window.parent.postMessage({
                type: 'returnModalClosed',
                returned: window.__returnSuccess === true,
                promptReceipt: !!(promptInfo && promptInfo.contract_id),
                contract_id: promptInfo ? promptInfo.contract_id : '',
                customer_code: promptInfo ? promptInfo.customer_code : '',
                agreementNo: promptInfo ? promptInfo.agreement_no : ''
            }, '*');
        }
    }
});


// Clear Signature
$(document).on('click', '#clear_returnsignature', function () {

    if (returnSignaturePad) {

        returnSignaturePad.clear();
    }
});

// --- REPLACEMENT STAFF SIGNATURE PAD ---
let replaceStaffSignaturePad;

let replaceStepper;

$('#ReplacecontractModal').on('shown.bs.modal', function () {
    const stepperEl = document.getElementById('replaceVehicleStepper');
    if (stepperEl) {
        if (!replaceStepper) {
            replaceStepper = new Stepper(stepperEl, { linear: false, animation: true });
        }
        replaceStepper.to(1);
    }

    const canvas = document.getElementById('ReplaceStaffSignature-pad');
    if (!canvas) return;

    function resizeReplaceCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = 150 * ratio;
        const ctx = canvas.getContext("2d");
        ctx.scale(ratio, ratio);
        if (replaceStaffSignaturePad) {
            replaceStaffSignaturePad.clear();
        }
    }

    if (!replaceStaffSignaturePad) {
        resizeReplaceCanvas();
        replaceStaffSignaturePad = new SignaturePad(canvas, {
            backgroundColor: '#fff'
        });
        window.addEventListener('resize', resizeReplaceCanvas);
    } else {
        replaceStaffSignaturePad.clear();
    }
});

$(document).on('click', '#clear_replacestaffsignature', function () {
    if (replaceStaffSignaturePad) {
        replaceStaffSignaturePad.clear();
    }
});

//Return Vehicel Upload
let ReturncarImageQueue = [];
let ReturnexistingVehicleImages = [];

let ReturnuploadedFileNames = [];
let ReturnexistingFileNames = [];


$('#returncarImages').on('change', function(e) {

    // reset progress bar
    $('#returnglobalProgressBar')
        .css('width', '0%')
        .removeClass('bg-success bg-danger');

    $('#returnuploadLoader').addClass('d-none');

    let files = e.target.files;

    Array.from(files).forEach(file => {

        let id = Date.now() + Math.random();

        ReturncarImageQueue.push({
            id: id,
            file: file
        });

        let reader = new FileReader();

        reader.onload = function(e) {

            $('#returnpreview').append(`
                <div class="position-relative"
                     id="img-${id}"
                     data-file="${file.name}">

                    <img src="${e.target.result}" 
                         class="rounded border returnvehicle-preview-img"
                         data-id="${id}"
                         data-file="${file.name}"
                         style="width:80px;height:80px;object-fit:cover;">

                    <span class="returndelete-img-vehicle"
                          data-id="${id}"
                          style="
                            position:absolute;
                            top:-5px;
                            right:-5px;
                            background:red;
                            color:white;
                            border-radius:50%;
                            padding:2px 6px;
                            cursor:pointer;
                            font-size:12px;">
                        ✕
                    </span>
                </div>
            `);

        };

        reader.readAsDataURL(file);

    });

    $(this).val('');
});
$('#returnuploadBtn').on('click', function () {

    if (ReturncarImageQueue.length === 0) {
        alert('Please select images');
        return;
    }

    // reset progress
    $('#returnglobalProgressBar')
        .css('width', '0%')
        .removeClass('bg-success bg-danger');

    // show loader
    $('#returnuploadLoader').removeClass('d-none');

    let formData = new FormData();

    ReturncarImageQueue.forEach((item) => {
        formData.append('car_images[]', item.file);
    });

    $.ajax({

        url: '/ReturnCompressUploadImage',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,

        xhr: function () {

            let xhr = new window.XMLHttpRequest();

            xhr.upload.onprogress = function (e) {

                if (e.lengthComputable) {

                    let percent = Math.round(
                        (e.loaded / e.total) * 100
                    );

                    $('#returnglobalProgressBar')
                        .css('width', percent + '%');
                }
            };

            return xhr;
        },

        success: function (res) {

            $('#returnglobalProgressBar')
                .css('width', '100%')
                .addClass('bg-success');

            ReturnuploadedFileNames.push(
                ...(res.files || [])
            );

            // hide loader
            $('#returnuploadLoader').addClass('d-none');

            // clear queue after upload
            ReturncarImageQueue = [];

        },

        error: function () {

            $('#returnglobalProgressBar')
                .addClass('bg-danger');

            $('#returnuploadLoader').addClass('d-none');
        }
    });

});
let RetruncurrentVehiclePreviewId = null;


$(document).on('click', '.returnvehicle-preview-img', function () {

    let id  = $(this).data('id');
    let src = $(this).attr('src'); // safer than data-src

    RetruncurrentVehiclePreviewId = id;

    // clear previous content (important)
    $('#VehiclefilePreviewBodyreturn').empty().html(`
        <img src="${src}" 
             class="img-fluid rounded shadow" 
             style="max-height:70vh;">
    `);

    let modalEl = document.getElementById('imagePreviewModalreturn');
    if (modalEl && modalEl.parentElement !== document.body) {
        document.body.appendChild(modalEl);
    }
    if (modalEl) {
        modalEl.style.setProperty('z-index', '100080', 'important');
    }

    let modal = bootstrap.Modal.getInstance(modalEl);
    if (!modal) {
        modal = new bootstrap.Modal(modalEl);
    }

    modal.show();
});

$('#deleteVehiclePreviewImageBtnreturn').on('click', function () {

    if (!RetruncurrentVehiclePreviewId) return;

    let el = document.getElementById('img-' + RetruncurrentVehiclePreviewId);

    if (el) {

        // get file name
        let fileName = $(el).attr('data-file');

        // 🔥 delete physical file from server
        if (fileName) {

            $.post('/ReturnDeleteUploadImage', {
                file: fileName
            });
        }

        // 🔥 DB image
        if (String(RetruncurrentVehiclePreviewId).startsWith('db_')) {
       
       
        let pureFileName = fileName.split('/').pop();

        // find index
        let index = ReturnexistingFileNames.indexOf(pureFileName);

        // remove from array
        if (index !== -1) {
    
            ReturnexistingFileNames.splice(index, 1);
        }
   

        } else {

            // 🔥 newly uploaded image
            carImageQueueReturn = carImageQueueReturn.filter(
                item => item.id != RetruncurrentVehiclePreviewId
            );

            ReturnuploadedFileNames = ReturnuploadedFileNames.filter(
                item => item !== fileName
            );
        }

        // remove preview
        el.remove();
    }

    // close modal
    let modalEl = document.getElementById('imagePreviewModalreturn');
    if (modalEl && modalEl.parentElement !== document.body) {
        document.body.appendChild(modalEl);
    }
    if (modalEl) {
        modalEl.style.setProperty('z-index', '100080', 'important');
    }

    let modal = bootstrap.Modal.getInstance(modalEl);

    if (modal) {
        modal.hide();
    }

    // clear modal body
    $('#VehiclefilePreviewBodyreturn').empty();

    currentVehiclePreviewId = null;

});


$(document).on('click', '.returndelete-img-vehicle', function (e) {

    e.preventDefault();
    e.stopPropagation();

    let id = $(this).data('id');

    let el = document.getElementById('img-' + id);

    if (!el) return;

    // get file name
    let fileName = $(el).attr('data-file');

    // 🔥 delete physical file from server
    if (fileName) {

        $.post('/ReturnDeleteUploadImage', {
            file: fileName
        });
    }

    // 🔥 existing DB image
    if (String(id).startsWith('db_')) {

        let pureFileName = fileName.split('/').pop();

        // find index
        let index = ReturnexistingFileNames.indexOf(pureFileName);

        // remove from array
        if (index !== -1) {
    
            ReturnexistingFileNames.splice(index, 1);
        }

    } else {

        // 🔥 remove from upload queue
        carImageQueueReturn = carImageQueueReturn.filter(
            item => item.id != id
        );

        // 🔥 remove uploaded filename array
        ReturnuploadedFileNames = ReturnuploadedFileNames.filter(
            item => item !== fileName
        );
    }

    // remove preview from DOM
    el.remove();

});




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
                    customer_id: item.customer_name,
                    customer_address: item.customer_addr,
                    customer_email: item.customer_email,
                    customer_code: item.customer_code,
                    customer_attn: item.customer_attn,
                     customer_cr_cpr:item.customer_cr_cpr
                }))
            };
        }
    },

    templateResult: formatCustomer,
    templateSelection: formatCustomerSelection
});

function formatCustomer(customer) {
    if (!customer.id) return customer.text;

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
    $('#customer_code').val(data.customer_code);
    $('#customerName').val(data.customer_name);
    
});


$('#selectCustomerFromSelect2').on('select2:clear', function () {
    $('#customerName').val('');
    $('#customer_code').val('');
}); 


function loadCompanies() {
    $.ajax({
        url: '/LoadCompanies',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ action: 'LoadCompanies' }),
        success: function(response) {
            let companies = response.data;
            $('#companySelect').empty();
            if (companies.length > 1) {
                $('#companySelect').append(new Option('All Companies', 'all', true, true));
            } else {
                $('#companySelect').prop('disabled', true);
            }
            companies.forEach(function(company) {
                let option = new Option(company.company_name, company.ids, false, false);
                $('#companySelect').append(option);
            });
            $('#companySelect').trigger('change');
        }
    });
}

$('#companySelect').on('change', function() {
    searchContractList();
});

 $(document).on("click", "#btnMainSearch", function () {
    
   
   searchContractList();

});
function searchContractList()
{
    let customer_code = $.trim($('#customer_code').val()) || 'All';
    let filter_from=$('#filter_from_date').val();
    let filter_to=$('#filter_to_date').val();
    let booking_status=$('#select_booking_status').val();
    let company_id = $('#companySelect').val() || 'all';
     
  
        if (
            (filter_from !== '' || filter_to !== '') &&
            new Date(filter_from) > new Date(filter_to)
        ) {
            setupDropdown(
                'dropdownContent',
                'error',
                svgError + "Please provide a valid date range",
                'click'
            );
            return;
        }
  
   load_contract_list(customer_code, filter_from, filter_to, booking_status, company_id);
}

  var table;
 loadCompanies();
 // load_contract_list() will be called by the change event of companySelect when it finishes loading.

function load_contract_list(
    customer_code = 'All',
    filter_from = '',
    filter_to = '',
    booking_status = 'All',
    company_id = 'all'
) {

    // Destroy existing table
    if ($.fn.DataTable.isDataTable('#contractTable')) {
       $('#contractTable').DataTable().destroy();
        $('#contractTable tbody').empty();
    }
    
    
   table = $('#contractTable').DataTable({
    processing: true,
    serverSide: false,
    pageLength: 15,
    lengthMenu: [10, 15, 25, 50, 100],
    ajax: {
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: function () {

            return JSON.stringify({
                action: 'ListContracts',
                  customer_code: customer_code,
                    filter_from: filter_from,
                    filter_to: filter_to,
                    booking_status: booking_status,
                    company_id: company_id
            });
        },
        dataSrc: 'data'
    },

    columns: [

       {
            data: null,
            orderable: false,
            searchable: false,
            render: function (data, type, row, meta) {
        
                return `
                    <div class="d-flex align-items-center gap-2">
        
                        <span>
                            ${meta.row + 1}
                        </span>
        
                        
                    </div>
                `;
            }
        },

        // Agreement / Company / Ref / Status
        {
            data: 'agreement_no',
            render: function (data, type, row) {
                if (type === 'filter' || type === 'sort') {
                    return `${data || ''} ${row.company_name || ''} ${row.booking_no || 'Direct Contract'} ${row.agreement_status || ''}`;
                }
                const esc = (s) => $('<div>').text(s || '').html();
                let compBadge = `<span class="badge bg-label-danger">${esc(row.company_name || '')}</span>`;
                let sourceText = row.booking_no ? `Booking: ${esc(row.booking_no)}` : 'Direct Contract';
                let sourceBadge = `<span class="badge bg-label-secondary">${sourceText}</span>`;
                let statusBadge = (typeof window.getContractStatusBadgeHtml === 'function')
                    ? window.getContractStatusBadgeHtml(row.agreement_status)
                    : `<span class="badge bg-secondary">${esc(row.agreement_status || '')}</span>`;

                return `
                    <div class="d-flex flex-column gap-1">
                        <div class="fw-bold text-primary">${esc(data || '')}</div>
                        <div class="d-flex flex-wrap align-items-center gap-1">
                            ${compBadge}
                            <span class="status-cell">${statusBadge}</span>
                        </div>
                        <div>${sourceBadge}</div>
                    </div>
                `;
            }
        },

        // Vehicle Details
        {
            data: null,
            render: function (data, type, row) {
                if (type === 'filter' || type === 'sort') {
                    return `${row.vehicle_no || ''} ${row.brand_name || ''} ${row.model_name || ''} ${row.category_name || ''} ${row.chassis_number || ''} ${row.vehicle_year || ''} ${row.vehicle_color || ''}`;
                }
                const esc = (s) => $('<div>').text(s || '').html();
                const brandModel = [row.brand_name, row.model_name].filter(Boolean).join(' - ') || '-';
                const vStatus = row.vehicle_status
                    ? (typeof window.getVehicleStatusBadgeHtml === 'function' ? window.getVehicleStatusBadgeHtml(row.vehicle_status) : `<span class="badge bg-label-info">${esc(row.vehicle_status)}</span>`)
                    : '';

                let badges = '';
                if (row.category_name) badges += `<span class="badge bg-label-primary me-1 mb-1">${esc(row.category_name)}</span>`;
                if (row.vehicle_year) badges += `<span class="badge bg-label-info me-1 mb-1"><i class="ri-calendar-line me-1"></i>${esc(row.vehicle_year)}</span>`;
                if (row.vehicle_color) badges += `<span class="badge me-1 mb-1" style="background-color:#fef3c7;color:#92400e;"><span class="d-inline-block rounded-circle me-1 border" style="width:8px;height:8px;background-color:${esc(row.vehicle_color)};"></span>${esc(row.vehicle_color)}</span>`;
                if (row.fuel_type) badges += `<span class="badge bg-label-success me-1 mb-1"><i class="ri-gas-station-line me-1"></i>${esc(row.fuel_type)}</span>`;
                if (row.gear_type) badges += `<span class="badge me-1 mb-1" style="background-color:#ede9fe;color:#6d28d9;"><i class="ri-settings-4-line me-1"></i>${esc(row.gear_type)}</span>`;

                let chassisHtml = row.chassis_number ? `<small class="text-muted"><i class="ri-barcode-line me-1"></i>Chassis: <strong>${esc(row.chassis_number)}</strong></small>` : '';

                return `
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex flex-wrap align-items-center gap-1">
                            <span class="fw-bold text-dark">${esc(row.vehicle_no || '-')}</span>
                            <span class="text-muted fw-semibold">${esc(brandModel)}</span>
                            ${vStatus}
                        </div>
                        <div class="d-flex flex-wrap align-items-center">${badges}</div>
                        ${chassisHtml}
                    </div>
                `;
            }
        },

        // Customer Details
        {
            data: null,
            render: function (data, type, row) {
                if (type === 'filter' || type === 'sort') {
                    return `${row.customer_name || ''} ${row.customer_code || ''} ${row.mobile || ''} ${row.customer_cpr || ''} ${row.customer_email || ''}`;
                }
                const esc = (s) => $('<div>').text(s || '').html();
                let meta = [];
                if (row.mobile && row.mobile !== '-') meta.push(`<i class="ri-phone-line me-1"></i>${esc(row.mobile)}`);
                if (row.customer_cpr) meta.push(`<i class="ri-id-card-line me-1"></i>${esc(row.customer_cpr)}`);
                if (row.customer_nationality) meta.push(`<i class="ri-global-line me-1"></i>${esc(row.customer_nationality)}`);

                let emailLine = row.customer_email ? `<small class="text-muted d-block text-truncate" style="max-width:200px;"><i class="ri-mail-line me-1"></i>${esc(row.customer_email)}</small>` : '';

                return `
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex flex-wrap align-items-center gap-1">
                            <strong class="text-dark">${esc(row.customer_name || '-')}</strong>
                            <span class="badge bg-label-secondary">${esc(row.customer_code || '')}</span>
                        </div>
                        <small class="text-muted d-flex flex-wrap gap-2">${meta.join(' ')}</small>
                        ${emailLine}
                    </div>
                `;
            }
        },

        // Contract Period (Date & Time)
        {
            data: null,
            render: function (data, type, row) {
                if (type === 'filter' || type === 'sort') {
                    return `${row.from_date || ''} ${row.to_date || ''}`;
                }
                const esc = (s) => $('<div>').text(s || '').html();
                return `
                    <div class="d-flex flex-column gap-1 small">
                        <div><span class="text-muted fw-semibold">From:</span> <strong class="text-dark">${esc(row.from_date_format || '-')}</strong></div>
                        <div><span class="text-muted fw-semibold">To:</span> <strong class="text-dark">${esc(row.to_date_format || '-')}</strong></div>
                    </div>
                `;
            }
        },

        // Agreement Date
        {
            data: 'agreement_date_format',
            render: function (data, type, row) {
                if (type === 'sort') return row.agreement_date || '';
                return `<span class="fw-semibold text-nowrap">${data || '-'}</span>`;
            }
        },

        // Actions
        {
            data: null,
            orderable: false,
            render: function (data, type, row) {

                return `
            
                    <div class="d-flex align-items-center gap-2">
            
                        <div class="dropdown">
            
                            <button
                                class="btn btn-sm btn-gradient btn-warning dropdown-toggle shadow-sm px-3"
                                data-bs-toggle="dropdown">
            
                                <i class="ri ri-settings-3-line me-1"></i>
                                Actions
                            </button>
            
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2 action-menu">
                            
                                <li>
                                    <a class="dropdown-item rounded fw-semibold extend_contract_btn"
                                       href="javascript:void(0)"
                                       data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                       data-booking_no="${row.booking_no}">
            
                                        <i class="ri ri-file-edit-line me-2"></i>
                                        Extend Contract
                                    </a>
                                </li>
            
                                <li>
                                    <a class="dropdown-item rounded fw-semibold extend_list_btn"
                                       href="javascript:void(0)"
                                        data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                       data-booking_no="${row.booking_no}">
            
                                        <i class="ri ri-calendar-event-line me-2"></i>
                                        Contract Extensions
                                    </a>
                                </li>
                                
                                 <li>
                                    <a class="dropdown-item rounded fw-semibold return_contract_btn"
                                       href="javascript:void(0)"
                                         data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                       data-booking_no="${row.booking_no}">
            
                                        <i class="ri ri-roadster-line me-2"></i>
                                        Return Vehicle
                                    </a>
                                </li>
                                 <li>
                                    <a class="dropdown-item rounded fw-semibold replace_contract_btn"
                                       href="javascript:void(0)"
                                         data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                       data-booking_no="${row.booking_no}">
            
                                        <i class="ri ri-roadster-line me-2"></i>
                                        Replace Vehicle
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded fw-semibold close_contract_button"
                                       href="javascript:void(0)"
                                        data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                       data-booking_no="${row.booking_no}">
            
                                        <i class="ri ri-lock-line me-2"></i>
                                        Close Contract
                                    </a>
                                </li>
                                
                                <li><hr class="dropdown-divider my-2"></li>

                                ${row.agreement_status === 'Generated' ? `
                                <li>
                                    <a class="dropdown-item fw-semibold rentoutContractStatus"
                                       data-id="${row.booking_ids}"
                                       data-status="Rentout"
                                       data-vehicleid="${row.vehicle_id}"
                                       style="cursor:pointer;">
                                        🚗 Rent Out
                                    </a>
                                </li>
                                ` : ''}

                                <li>
                                    <a class="dropdown-item rounded fw-semibold print_agreement_btn" href="javascript:void(0)"
                                       data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                      >
            
                                        <i class="ri ri-printer-fill me-2"></i>
                                        Print Agreement
                                    </a>
                                </li>
            
                                <li>
                                    <a class="dropdown-item rounded fw-semibold send_agreement_btn"
                                       href="javascript:void(0)"
                                       data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                       data-booking_no="${row.booking_no}">
                                        <i class="ri ri-send-plane-fill me-2"></i>
                                        Send Agreement
                                    </a>
                                </li>
                                
                               <li>
                                    <a class="dropdown-item rounded fw-semibold view_contract_details"
                                       href="javascript:void(0)"
                                       data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                       data-booking_no="${row.booking_no}">
            
                                        <i class="ri ri-file-list-line me-2"></i>
                                        View Contract
                                    </a>
                                </li>
            
                            </ul>
            
                        </div>
            
                        <button class="btn btn-sm btn-primary shadow-sm rounded-pill contract_ledger"
                                data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"
                                data-bs-toggle="tooltip"
                                title="Contract Ledger">
            
                            <i class="ri ri-wallet-3-line me-1"></i>
                            Contract Ledger
            
                        </button>
            
                    </div>
            
                `;
            }
        }
    ]
});
    
    
}



    if (!window.__embedReturnHandled) {
        const qp = new URLSearchParams(window.location.search);
        if (qp.get('embed_return') === '1') {
            window.__embedReturnHandled = true;
            ['ReturncontractModal', 'imagePreviewModal', 'imagePreviewModalreturn', 'modalAddViolationHead', 'otpVerifyModal', 'otpSubmitModal', 'customConfirmModal', 'dropdownContent'].forEach(mid => {
                const el = document.getElementById(mid);
                if (el && el.parentElement !== document.body) {
                    document.body.appendChild(el);
                }
            });

            window.__openEmbeddedReturn = function(c) {
                if (!c || !c.contract_id) return;
                window.__returnSuccess = false;
                const cId = c.contract_id;
                const agrNo = c.agreement_no || '';
                const vehId = c.vehicle_id || '';
                const custCode = c.customer_code || '';
                const modId = c.model_id || '';
                const bkgId = c.booking_ids || '';
                const bkgNo = c.booking_no || agrNo;
                $('#return_agreement_ref').text(agrNo);
                $('#txt_return_modal_agreement_id').val(cId);
                $('#txt_return_modal_agreement_no').val(agrNo);
                $('#txt_return_modal_booking_ids').val(bkgId);
                $('#txt_return_modal_booking_ref_no').val(bkgNo);
                openReturnModal(cId, vehId, custCode, modId);
            };

            window.addEventListener('message', function(ev) {
                if (ev.data && ev.data.type === 'openReturnModal' && ev.data.contract) {
                    window.__openEmbeddedReturn(ev.data.contract);
                }
            });

            if (qp.get('contract_id')) {
                window.__openEmbeddedReturn({
                    contract_id: qp.get('contract_id'),
                    agreement_no: qp.get('agreement_no') || '',
                    vehicle_id: qp.get('vehicle_id') || '',
                    customer_code: qp.get('customer_code') || '',
                    model_id: qp.get('model_id') || '',
                    booking_ids: qp.get('booking_ids') || '',
                    booking_no: qp.get('booking_no') || ''
                });
            }

            if (window.parent && window.parent !== window) {
                window.parent.postMessage({ type: 'returnIframeReady' }, '*');
            }
        }
    }

   $('#contractTable').on('draw.dt', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });

    if (!window.__autoContractActionHandled) {
        const urlParams = new URLSearchParams(window.location.search);
        const autoAction = urlParams.get('auto_action');
        const targetId = urlParams.get('contract_id');
        if (autoAction && targetId) {
            const selectorMap = {
                extend: `.extend_contract_btn[data-id="${targetId}"]`,
                return: `.return_contract_btn[data-id="${targetId}"]`,
                view: `.view_contract_details[data-id="${targetId}"]`
            };
            const targetBtn = document.querySelector(selectorMap[autoAction] || '');
            if (targetBtn) {
                window.__autoContractActionHandled = true;
                urlParams.delete('auto_action');
                urlParams.delete('contract_id');
                const cleanUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                window.history.replaceState({}, '', cleanUrl);
                setTimeout(() => targetBtn.click(), 150);
            }
        }
    }
}); 

$(document).on('click', '.rentoutContractStatus', function () {

    let id = $(this).data('id');
    let vehicleid = $(this).data('vehicleid');
    let status = $(this).data('status');

    Swal.fire({
        title: 'Rent Out Vehicle?',
        text: 'Are you sure you want to rent out this vehicle?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Rent Out',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/VehicleStatusController',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'change_booking_status',
                    bookingid: id,
                    vehicleId: vehicleid,
                    bookingstatus: status
                },
                success: function (res) {
                if (!res.status) return;
                 setupDropdown('dropdownContent', 'success', svgSuccess + 'Vehicle rented out successfully', 'click');
                   location.reload();
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            });

        }

    });

});

let confirmData = {};
function showConfirmModal({ title, message, confirmText = 'Confirm', type = 'danger', action, data, extra }) {

    $('#confirmModalTitle').text(title);
    $('#confirmModalMessage').html(message);

    let btn = $('#confirmActionBtn');
    btn.text(confirmText);

    btn.removeClass('btn-danger btn-primary btn-success btn-warning')
       .addClass('btn-' + type);

    // ✅ store everything
    confirmData = { action, data, extra };

     let modalEl = document.getElementById('confirmActionModal');

    // ✅ IMPORTANT CHECK
    if (!modalEl) {

        console.error(
            'Modal #confirmActionModal not found in DOM'
        );

        return;
    }

    // ✅ safest bootstrap method
    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);

    modal.show();
}
$(document).on('click', '#confirmActionBtn', function () {

    if (!confirmData.action) return;
    $.ajax({
    url: '/ContractListController',
    type: 'POST',
    contentType: 'application/json',
    dataType: 'json',
    data: JSON.stringify(confirmData.data),

    success: function (res) {
                let { btn, id, agreement_ids, vehicleid } = confirmData.extra || {};

            if (res.status === true) {

                setupDropdown(
                    'dropdownContent',
                    'success',
                    svgSuccess + 'The contract extension has been deleted.',
                    'click'
                );
                if (typeof extensiontable !== 'undefined') {
                    extensiontable.ajax.reload(null, false);
                }

            } else {

                setupDropdown(
                    'dropdownContent',
                    'danger',
                    svgSuccess + (res.message || 'Something went wrong'),
                    'click'
                );
            }

            let modalEl = document.getElementById('confirmActionModal');
            let modal = bootstrap.Modal.getInstance(modalEl);

            document.activeElement.blur();

            modal.hide();
            searchContractList();
    }
});
 
});

 function getDocumentPreview(fileUrl) {

                let extension = fileUrl.split('.').pop().toLowerCase();

                switch (extension) {
                    case 'pdf':
                        return '/assets/icons/pdf.png';

                    case 'doc':
                    case 'docx':
                        return '/assets/icons/word.png';

                    case 'xls':
                    case 'xlsx':
                        return '/assets/icons/excel.png';

                    case 'ppt':
                    case 'pptx':
                        return '/assets/icons/ppt.png';

                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                    case 'webp':
                        return fileUrl; // actual image

                    default:
                        return '/assets/icons/file.png';
                }
            }
let modalEl = document.getElementById('extendcontractModal');

if (!modalEl) {
    console.error('Modal not found!');
    return;
}
  $(document).on('click', '#contractcustdriverdocpreview li', function() {

    currentPreviewLi = $(this);

    let fileUrl = $(this).data('img');

    if (!fileUrl) return;

    let ext = fileUrl.split('.').pop().toLowerCase();

    let html = '';

    // IMAGE FILES
    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {

        html = `<img src="${fileUrl}" class="img-fluid rounded" style="max-height:70vh;">`;
    }

    // PDF FILE
    else if (ext === 'pdf') {

        html = `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
    }

    // DOC / EXCEL / PPT
    else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {

        html = `
        <iframe
            src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true"
            width="100%"
            height="600px"
            style="border:none;">
        </iframe>`;
    }

    // FALLBACK
    else {

        html = `
        <div class="alert alert-warning">
            Preview not available.
            <br>
            <a href="${fileUrl}" target="_blank" class="btn btn-primary mt-2">
                Download File
            </a>
        </div>`;
    }

    $('#filePreviewBody').html(html);

    $('#filePreviewModal').modal('show');
});
// Return
$(document).on('click', '#contractTable li a.return_contract_btn', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     
    let status = $(this).closest('tr').find('.status-cell span').text().trim();


    if (status === 'Extended' || status === 'Rentout' || status === 'Cancelled') {
        
        
         $('#return_agreement_ref').text(agreement_no);
         $('#txt_return_modal_agreement_id').val(id);
         $('#txt_return_modal_agreement_no').val(agreement_no);
         $('#txt_return_modal_booking_ids').val(booking_ids);
         let booking_no = $(this).data('booking_no') || agreement_no;
         $('#txt_return_modal_booking_ref_no').val(booking_no);
         
        openReturnModal(id,vehicleid,customer_code,model_ids);
        
    } 
    else if (status === 'Returned')
    {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'The contract status has already been marked as Returned.',
                'click'
            );
            return;
    }
    
    else   {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'The contract cannot be returned',
                'click'
            );
            return;
        
    } 
   
});

function openReturnModal(id,vehicleid,customer_code,model_ids) {

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            agreementid:id,vehicleid:vehicleid,customer_code:customer_code,model_ids:model_ids
        }),
        success: function (res) {
          populatereturnContractModal(res);
          let modalEl = document.getElementById('ReturncontractModal');
          if (modalEl) {
              let modalInstance = bootstrap.Modal.getInstance(modalEl);
              if (!modalInstance) {
                  modalInstance = new bootstrap.Modal(modalEl);
              }
              modalInstance.show();
          }
        },
        error: function(xhr, status, error) {
            console.error("Error opening return modal:", error);
        }
    });
}
function populatereturnContractModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;
    data = data || {};
    let customer = data.customer || {};
    let vehicle = data.vehicle || {};
    let price_list = Array.isArray(data.price_list) ? data.price_list : [];
    
    currentReturnContractDetails = data;
    currentReturnPriceList = price_list;
    $('#ret_ext_duration').removeData('user-override');
    $('#ret_ext_unit_price').removeData('user-override');
    $('#ret_ext_vat').removeData('user-override');
    $('#ret_ext_service').removeData('user-selected');
    $('#ret_ext_rate_type').removeData('user-selected');

    window.earlyReturnReductionPosted = false;
    if (laddaReturnContract) {
        laddaReturnContract.stop();
    }
    $('#btn_return_contract').prop('disabled', false);
    $('#btn_confirm_early_reduction').prop('disabled', false).html('<span class="ladda-label"><i class="ri-refund-2-line me-1"></i> Post Credit to Ledger</span>');
    $('#ret_early_posted_status').hide();
    $('#ret_early_deduct_no').prop('checked', true);
    $('#chk_early_zero_amount').prop('checked', true);
    $('#ret_early_edit_fields').hide();
    $('#ret_early_duration').removeData('user-override');
    $('#ret_early_unit_price').removeData('user-override');
    $('#ret_early_vat').removeData('user-override');
    $('#ret_early_service').removeData('user-selected');
    $('#ret_early_rate_type').removeData('user-selected');
    $('#chk_ext_zero_amount').prop('checked', false).removeData('prev-price').removeData('prev-vat');
    $('#ret_overdue_waive_no').prop('checked', true);
    $('#ret_overdue_edit_no').prop('checked', true);
    $('#ret_waive_remarks_area').hide();
    $('#ret_waive_remarks').val('');
    $('#ret_overdue_edit_fields').hide();
    $('#ret_change_overdue_wrap').show();
    $('#chk_early_zero_amount').prop('checked', false).removeData('prev-price').removeData('prev-vat');
    
    let sessionStaffName = '<?php echo htmlspecialchars($_SESSION['profile_name'] ?? $_SESSION['user_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>';
    $('#received_by_name').val(sessionStaffName);
   
        $('#return_c_name').text(customer.customer_name || '');
        $('#return_c_code').text(customer.customer_id || '');
        $('#return_c_mobile').text(customer.customer_mobile || '');
        $('#return_c_email').text(customer.customer_email || '');
        $('#return_c_attn').text(customer.customer_attn || '');
        $('#return_c_attr').text(customer.customer_addr || '');
        
        $('#return_v_no').text(vehicle.vehicle_number || '');
        $('#return_v_model').text(vehicle.model_names || '');
        $('#return_v_brand').text(vehicle.brand_name || '');
        $('#return_v_category').text(vehicle.category_name || '');
        $('#return_v_color').text(vehicle.vehicle_color || '');
        $('#return_v_year').text(vehicle.vehicle_year || '');
        $('#return_v_passing').text(vehicle.formatted_next_passing_date || '');
        $('#return_hid_nxt_passing').val(vehicle.next_passing_date || '');  
        $('#return_v_maintenance').text(vehicle.formatted_next_maintenance_date || '');
        $('#return_hid_nxt_maintenance').val(vehicle.next_maintenance_date || '');  
        $('#return_v_insurance').text(vehicle.formatted_next_insurance_date || ''); 
        $('#return_hid_nxt_insurance').val(vehicle.next_insurance_date || '');  
        $('#return_v_chassis').text(vehicle.chassis_number || '-');
        
        $('#return_hid_vehicle_id').val(vehicle.ids || '');
        $('#return_hid_category_id').val(vehicle.category_id || '');
        $('#return_hid_model_id').val(vehicle.model_id || '');
        $('#return_hid_vehicle_no').val(vehicle.vehicle_number || '');
        
        let images = vehicle.vehicle_images;
        if (typeof images === "string") {
            try { images = JSON.parse(images); } catch (e) { images = []; }
        }
        if (!Array.isArray(images)) images = [];
        images = images.filter(img => img && img !== "default.jpg");
        if (images.length === 0) images = ["default.jpg"];

        let sliderImg  = document.getElementById("returnVSliderImg");
        let sliderDots = document.getElementById("returnVSliderDots");
        let sliderPrev = document.getElementById("returnVSliderPrev");
        let sliderNext = document.getElementById("returnVSliderNext");
        let sliderIdx  = 0;

        function returnSliderShow(idx) {
            sliderIdx = (idx + images.length) % images.length;
            let src = images[sliderIdx] === "default.jpg"
                ? "uploads/vehicleImages/default.jpg"
                : "uploads/vehicleImages/" + images[sliderIdx];
            if(sliderImg) sliderImg.src = src;
            if (sliderDots) {
                sliderDots.querySelectorAll(".slider-dot").forEach((d, i) => {
                    d.classList.toggle("active", i === sliderIdx);
                });
            }
        }

        if (sliderDots) {
            sliderDots.innerHTML = "";
            if (images.length > 1) {
                images.forEach((_, i) => {
                    let dot = document.createElement("span");
                    dot.className = "slider-dot" + (i === 0 ? " active" : "");
                    dot.addEventListener("click", () => returnSliderShow(i));
                    sliderDots.appendChild(dot);
                });
            }
        }
        if (sliderPrev) {
            sliderPrev.style.display = images.length > 1 ? "" : "none";
            sliderPrev.onclick = () => returnSliderShow(sliderIdx - 1);
        }
        if (sliderNext) {
            sliderNext.style.display = images.length > 1 ? "" : "none";
            sliderNext.onclick = () => returnSliderShow(sliderIdx + 1);
        }
        returnSliderShow(0);
        price_list.forEach(function(item) {
        
            switch(item.item) {
                case "Price per hour rental without driver":
                    $('#return_wod_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per hour rental with driver":
                    $('#return_wd_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental without driver":
                    $('#return_wod_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental with driver":
                    $('#return_wd_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental without driver":
                    $('#return_wod_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental with driver":
                    $('#return_wd_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental without driver":
                    $('#return_wod_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental with driver":
                   $('#return_wd_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
            }
        });
       
        let contract = data.contract || {};
        let bookDetails = JSON.parse(contract.book_details_json || '{}');
         let driverDetails = JSON.parse(contract.driver_details || '{}');
         let vehicle_accessiories_details = JSON.parse(contract.vehicle_accessories_details || '{}');
         let customer_driver_attachments = JSON.parse(contract.customer_driver_attachments || '[]');
         let vehicerentoutImages = JSON.parse(contract.vehicle_rentout_images || '[]');
        $('#chk_tools').prop(
            'checked',
            vehicle_accessiories_details.chk_tools && vehicle_accessiories_details.chk_tools === 'Yes'
        );
         $('#chk_spare').prop(
            'checked',
            vehicle_accessiories_details.chk_spare && vehicle_accessiories_details.chk_spare === 'Yes'
        );
         $('#chk_radio').prop(
            'checked',
            vehicle_accessiories_details.chk_radio && vehicle_accessiories_details.chk_radio === 'Yes'
        );
         $('#chk_wcup').prop(
            'checked',
            vehicle_accessiories_details.chk_wcup && vehicle_accessiories_details.chk_wcup === 'Yes'
        );
         $('#chk_scratches').prop(
            'checked',
            vehicle_accessiories_details.chk_scratches && vehicle_accessiories_details.chk_scratches === 'Yes'
        );
         $('#chk_seats').prop(
            'checked',
            vehicle_accessiories_details.chk_seats && vehicle_accessiories_details.chk_seats === 'Yes'
        );
        $('#km_out').val(vehicle_accessiories_details.vehicle_km_out || 0);
         $('#km_in').val(vehicle_accessiories_details.vehicle_km_in || 0);
         if (typeof calcOdoDiff === "function") {
             calcOdoDiff();
         }
        $('#fuel_level').val(vehicle_accessiories_details.fuel_level || '');
        $('#disp_fuel_level').text(vehicle_accessiories_details.fuel_level || '-');
        $('#return_fuel_level').val(vehicle_accessiories_details.return_fuel_level || '');
        $('#return_note').val(vehicle_accessiories_details.return_note || '');
        $('#ret_chk_tools').prop('checked', vehicle_accessiories_details.ret_chk_tools === 'Yes');
        $('#ret_chk_spare').prop('checked', vehicle_accessiories_details.ret_chk_spare === 'Yes');
        $('#ret_chk_wcup').prop('checked', vehicle_accessiories_details.ret_chk_wcup === 'Yes');
        $('#ret_chk_radio').prop('checked', vehicle_accessiories_details.ret_chk_radio === 'Yes');
        $('#ret_chk_scratches').prop('checked', vehicle_accessiories_details.ret_chk_scratches === 'Yes');
        $('#ret_chk_seats').prop('checked', vehicle_accessiories_details.ret_chk_seats === 'Yes');
        $('#ret_survey_confirmed').prop('checked', vehicle_accessiories_details.ret_survey_confirmed !== 'No');
        if (window.CarSurveyWidget) {
            CarSurveyWidget.init('ret_survey_out_preview', vehicle_accessiories_details.car_survey_out || [], { readOnly: true });
            CarSurveyWidget.init('ret_survey_in', vehicle_accessiories_details.car_survey_in || []);
        }
        
        let getCurrentDateTimeLocal = function() {
            let now = new Date();
            let year = now.getFullYear();
            let month = String(now.getMonth() + 1).padStart(2, '0');
            let day = String(now.getDate()).padStart(2, '0');
            let hours = String(now.getHours()).padStart(2, '0');
            let minutes = String(now.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        };

        let dateOutVal = vehicle_accessiories_details.date_out || bookDetails.period_from || contract.service_start_date_time || '';
        let dateInVal = vehicle_accessiories_details.date_in || contract.return_date || getCurrentDateTimeLocal();

        let formatDtLocal = function(str) {
            if (!str) return '';
            let fmt = str.replace(' ', 'T');
            return fmt.length > 16 ? fmt.substring(0, 16) : fmt;
        };

        $('#dt_out').val(formatDtLocal(dateOutVal));
        $('#dt_in').val(formatDtLocal(dateInVal));
        $('#return_vehicle_date_in').val(formatDtLocal(dateInVal));
        if (contract.agreement_group_ref_no || contract.booking_no) {
            $('#txt_return_modal_booking_ref_no').val(contract.agreement_group_ref_no || contract.booking_no);
        }
        
        if (contract.agreement_date) {
            const agrDateVal = contract.agreement_date.split(' ')[0];
            $('#dt_contract_date').val(agrDateVal);
            $('#disp_dt_contract_date').text(agrDateVal);
        } else {
            $('#disp_dt_contract_date').text('-');
        }
        
       $('#cust_driver').val(contract.customer_driver_name || '');
       $('#cust_driver_contact_no').val(contract.customer_driver_contact_number || '');
       $('#disp_cust_driver').text(contract.customer_driver_name || vehicle_accessiories_details.cust_driver_name || '-');
       $('#disp_cust_driver_contact_no').text(contract.customer_driver_contact_number || vehicle_accessiories_details.cust_driver_contact_no || '-');
       $('#disp_cust_driver_cpr').text(vehicle_accessiories_details.cust_driver_cpr || '-');
       $('#disp_cust_driver_phone').text(vehicle_accessiories_details.cust_driver_phone || '-');
       $('#disp_km_out').text($('#km_out').val() || '-');
       $('#disp_dt_out').text(formatReadableDateTime($('#dt_out').val()));
        $('.driverclass').show(); 
     
        let dName = driverDetails.driver_name;
        if (!dName || dName === 'Select Driver' || dName.trim() === '') {
            $('#company_driver_section').hide();
            $('#d_name').text('');
        } else {
            $('#company_driver_section').show();
            $('#d_name').text(dName);
        }
        $('#d_mobile').text(driverDetails.driver_mobile);
        $('#d_license_no').text(driverDetails.driver_license_no);
        $('#d_license_issue_place').text(driverDetails.driver_license_issplace);
        $('#d_licenseissueDate').text(driverDetails.driver_license_expdate);
        $('#d_licenseexpiryDate').text(driverDetails.driver_license_expdate);
       
$('#contractcustdriverdocpreview').empty();
 existingAttachments = {
    vehicles: []
};
 existingAttachments = JSON.parse(
    contract.customer_driver_attachments || '{"vehicles":[]}'
);

 bookingMaster = {
    vehicles: []
};
 carImageQueue = [];
if (
    existingAttachments.vehicles &&
    Array.isArray(existingAttachments.vehicles)
) {

    existingAttachments.vehicles.forEach(vehicle => {

         vehiclesObj = {
            documentName: vehicle.documentName || '',
            files: []
        };

        if (Array.isArray(vehicle.files)) {

            vehicle.files.forEach(fileUrl => {

                vehiclesObj.files.push(fileUrl);

                let previewSrc = getDocumentPreview(fileUrl);

                let id = 'db_' + Math.random().toString(36).substr(2, 9);

                let liHtml = `
                    <li
                        id="doc-${id}"
                        data-img="${fileUrl}"
                        data-file="${fileUrl}"
                        data-type="db"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="${vehicle.documentName}"
                        class="avatar avatar-lg pull-up position-relative">

                        <img class="rounded-circle vehicle-doc-preview"
                             src="${previewSrc}"
                             style="
                                width:70px;
                                height:70px;
                                object-fit:cover;
                                cursor:pointer;
                             " />
                    </li>
                `;

                $('#contractcustdriverdocpreview').append(liHtml);

            });
        }

        bookingMaster.vehicles.push(vehiclesObj);
    });
}
             $('#preview').empty();  
          existingVehicleImages = [];
          existingFileNames = [];
          uploadedFileNames = [];
         existingVehicleImages = JSON.parse(contract.vehicle_rentout_images || '[]');
        
        
         existingVehicleImages.forEach(img => {
             
        existingFileNames.push(img);
        let id = 'db_' + Math.random().toString(36).substr(2, 9);

        $('#preview').append(`
            <div class="position-relative" id="img-${id}" data-file="${img}">
                
                <img src="../uploads/rentvehicleImages/${img}" 
                     class="rounded border vehicle-preview-img"
                     data-id="${id}"
                      data-file="${img}"
                     style="width:80px;height:80px;object-fit:cover;cursor:pointer;">

                
            </div>
        `);
        
         });
        $('#returnpreview').empty();  
          existingVehicleImagesReturn = [];
          existingFileNamesReturn = [];
          uploadedFileNamesReturn = [];
        
        
    //      existingVehicleImagesReturn.forEach(img => {
             
    //     existingFileNamesReturn.push(img);
    //     let id = 'db_' + Math.random().toString(36).substr(2, 9);

    //     $('#returnpreview').append(`
    //         <div class="position-relative" id="img-${id}" data-file="${img}">
                
    //             <img src="../uploads/returntvehicleImages/${img}" 
    //                  class="rounded border vehicle-preview-img"
    //                  data-id="${id}"
    //                   data-file="${img}"
    //                  style="width:80px;height:80px;object-fit:cover;cursor:pointer;">

                
    //         </div>
    //     `);

      $('#chk_violations_checked').prop('checked', false);
      $('#violations_tbody').empty();
      let existingViolations = [];
      if (contract && contract.violations_json) {
          if (typeof contract.violations_json === 'string') {
              try {
                  existingViolations = JSON.parse(contract.violations_json);
              } catch(e) {
                  existingViolations = [];
              }
          } else if (Array.isArray(contract.violations_json)) {
              existingViolations = contract.violations_json;
          }
      }
let violationHeadsMap = {};

      loadViolationHeadsList();

      if (Array.isArray(existingViolations) && existingViolations.length > 0) {
          existingViolations.forEach(function(v) {
              if (v) {
                  addViolationRow(v.violation_date || v.date || '', v.title || '', v.fee || '', v.remarks || '', v.ledger_id || '');
              }
          });
      }

      if (contract && contract.ids) {
          listExtendedListReturn(contract.ids);
      }

      let returnStepperEl = document.querySelector('#returnStepper');
      if (returnStepperEl) {
          if (!window.returnStepperInstance) {
              window.returnStepperInstance = new Stepper(returnStepperEl, {
                  linear: false,
                  animation: true
              });
              
              $(returnStepperEl).find('.btn-next').on('click', function() {
                  window.returnStepperInstance.next();
              });
              $(returnStepperEl).find('.btn-prev').on('click', function() {
                  window.returnStepperInstance.previous();
              });
              
              returnStepperEl.addEventListener('shown.bs-stepper', function (event) {
                  if (typeof returnextensiontable !== 'undefined') {
                      returnextensiontable.columns.adjust().draw();
                  }
                  if (event.detail.indexStep === 3) {
                      // Signature step is shown, resize canvas if needed
                      if (typeof returnSignaturePad !== 'undefined' && returnSignaturePad) {
                          const canvas = document.getElementById('Returnsignature-pad');
                          const ratio = Math.max(window.devicePixelRatio || 1, 1);
                          canvas.width = canvas.offsetWidth * ratio;
                          canvas.height = 200 * ratio;
                          const ctx = canvas.getContext("2d");
                          ctx.scale(ratio, ratio);
                          returnSignaturePad.clear();
                      }
                  }
              });
          }
          window.returnStepperInstance.to(1); // Reset to first step
      }
} 

function loadViolationHeadsList() {
    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ action: 'getViolationHeads' }),
        dataType: 'json',
        success: function(res) {
            if (res && res.status && Array.isArray(res.data)) {
                let optionsHtml = '';
                violationHeadsMap = {};
                res.data.forEach(function(item) {
                    if (item && item.head_name) {
                        violationHeadsMap[item.head_name] = item.ids;
                        optionsHtml += `<option value="${item.head_name}"></option>`;
                    }
                });
                $('#violation_heads_list').html(optionsHtml);
            }
        }
    });
}

function addViolationRow(vdate, title, fee, remarks, ledger_id) {
    vdate = vdate || new Date().toISOString().split('T')[0];
    title = title || '';
    fee = fee || '';
    remarks = remarks || '';
    ledger_id = ledger_id || '';
    let rowCount = $('#violations_tbody tr').length + 1;
    let $row = $(`
        <tr>
            <td class="text-center align-middle row-num">${rowCount}</td>
            <td>
                <input type="date" class="form-control form-control-sm violation-date" value="${vdate}">
            </td>
            <td>
                <input type="text" list="violation_heads_list" class="form-control form-control-sm violation-title" placeholder="Search / select violation title" value="${title}" data-ledger-id="${ledger_id}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm violation-fee" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0.000" value="${fee}">
            </td>
            <td>
                <textarea class="form-control form-control-sm violation-remarks" rows="1" placeholder="Enter remarks">${remarks}</textarea>
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-violation px-2 py-1" title="Remove Violation">
                    <i class="ri ri-delete-bin-line fs-5"></i>
                </button>
            </td>
        </tr>
    `);
    $('#violations_tbody').append($row);
    renumberViolationRows();
    $row.find('.violation-title').focus();
}

function renumberViolationRows() {
    $('#violations_tbody tr').each(function(idx) {
        $(this).find('.row-num').text(idx + 1);
    });
}

$(document).on('click', '#btn_add_violation_row', function() {
    addViolationRow();
});

$(document).on('click', '.btn-remove-violation', function() {
    $(this).closest('tr').remove();
    renumberViolationRows();
});

$(document).on('show.bs.modal', '#modalAddViolationHead', function() {
    let highestZ = 1050;
    $('.modal.show').each(function() {
        if (this.id !== 'modalAddViolationHead') {
            let z = parseInt($(this).css('z-index')) || 1050;
            if (z > highestZ) highestZ = z;
        }
    });
    $(this).css('z-index', highestZ + 20);
    setTimeout(function() {
        $('.modal-backdrop').last().css('z-index', highestZ + 10);
    }, 10);
});

$(document).on('hidden.bs.modal', '#modalAddViolationHead', function() {
    if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open');
    }
});

$(document).on('show.bs.modal', '#vehicleDetailsModal', function() {
    let highestZ = 1050;
    $('.modal.show').each(function() {
        if (this.id !== 'vehicleDetailsModal') {
            let z = parseInt($(this).css('z-index')) || 1050;
            if (z > highestZ) highestZ = z;
        }
    });
    $(this).css('z-index', highestZ + 20);
    setTimeout(function() {
        $('.modal-backdrop').last().css('z-index', highestZ + 10);
    }, 10);
});

$(document).on('hidden.bs.modal', '#vehicleDetailsModal', function() {
    if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open');
    }
});

$(document).on('click', '#btn_add_violation_head_master', function() {
    $('#new_violation_head_name').val('');
    const modalEl = document.getElementById('modalAddViolationHead');
    if (modalEl) {
        if (modalEl.parentElement !== document.body) {
            document.body.appendChild(modalEl);
        }
        modalEl.style.setProperty('z-index', '100080', 'important');
    }
    $('#modalAddViolationHead').modal('show');
    setTimeout(function() {
        $('#new_violation_head_name').focus();
    }, 400);
});

$(document).on('click', '#btn_save_violation_head', function() {
    let headName = $.trim($('#new_violation_head_name').val());
    if (!headName) {
        setupDropdown('dropdownContent', 'error', svgError + 'Please enter violation head name', 'click');
        return;
    }

    let $btn = $(this);
    $btn.prop('disabled', true);

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'addViolationHead',
            head_name: headName
        }),
        dataType: 'json',
        success: function(res) {
            $btn.prop('disabled', false);
            if (res && res.status) {
                $('#modalAddViolationHead').modal('hide');
                setupDropdown('dropdownContent', 'success', svgSuccess + (res.message || 'Violation head added'), 'click');
                loadViolationHeadsList();
            } else {
                setupDropdown('dropdownContent', 'error', svgError + (res.message || 'Error adding violation head'), 'click');
            }
        },
        error: function() {
            $btn.prop('disabled', false);
            setupDropdown('dropdownContent', 'error', svgError + 'Failed to add violation head', 'click');
        }
    });
});

var returnextensiontable;
function listExtendedListReturn(agreement_ids) {
    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            action: 'ListContractExtensionsReturn',
            agreementid: agreement_ids,
            vehicleid: $('#return_hid_vehicle_id').val()
        }),
        success: function(json) {
            if (typeof handleReturnCoverageResponse === 'function') {
                handleReturnCoverageResponse(json);
            }
            const rows = (json && Array.isArray(json.data)) ? json.data : [];
            if (rows.length > 0) {
                const orig = rows[0];
                const last = rows[rows.length - 1];
                $('#orig_full_period').html(formatPeriodHtml(orig.from_date_format, last.to_date_format));
                $('#orig_service_type').text(orig.service_name || '-');
                $('#orig_rate_info').text((orig.rate_type || '-') + ' @ ' + (parseFloat(orig.unit_price || 0).toFixed(3)) + ' BHD');
                $('#orig_vat_pct').text(orig.vat !== undefined ? orig.vat : '0');
                $('#orig_contract_value').text(parseFloat(orig.total_amt || 0).toFixed(3));
                $('#ret_sum_full_period').html(formatPeriodHtml(orig.from_date_format, last.to_date_format));
            }
            if (typeof updateReturnFinancialSummary === 'function') {
                updateReturnFinancialSummary();
            }
        }
    });
}

$(document).on('change', 'input[name="ret_overdue_waive_mode"]', function() {
    const waive = $(this).val() === 'yes';
    $('#chk_ext_zero_amount').prop('checked', waive).trigger('change');
    if (waive) {
        $('#ret_waive_remarks_area').slideDown();
        $('#ret_change_overdue_wrap').hide();
        $('#ret_overdue_edit_fields').slideUp();
        $('#ret_overdue_edit_no').prop('checked', true);
    } else {
        $('#ret_waive_remarks_area').slideUp();
        $('#ret_waive_remarks').val('');
        $('#ret_change_overdue_wrap').show();
    }
});

$(document).on('change', 'input[name="ret_overdue_edit_mode"]', function() {
    const editable = $(this).val() === 'yes' && !$('#chk_ext_zero_amount').is(':checked');
    if (editable) {
        $('#ret_overdue_edit_fields').slideDown();
    } else {
        $('#ret_overdue_edit_fields').slideUp();
        if (!$('#chk_ext_zero_amount').is(':checked')) {
            $('#ret_ext_duration').removeData('user-override');
            $('#ret_ext_unit_price').removeData('user-override');
            $('#ret_ext_vat').removeData('user-override');
            calculateReturnBalanceExtension();
        }
    }
});

let currentReturnCoverageData = null;
let currentReturnContractDetails = null;
let currentReturnPriceList = [];

function handleReturnCoverageResponse(json) {
    currentReturnCoverageData = json;
    evaluateReturnCoverage();
}

function parseAnyDateTime(val) {
    if (!val) return null;
    if (val instanceof Date) {
        return isNaN(val.getTime()) ? null : val;
    }
    let s = String(val).trim();
    if (!s) return null;
    
    // Check DD-MM-YYYY or DD/MM/YYYY e.g. 31-01-2026 12:20 or 31-01-2026 12:20:00 or 31-01-2026
    let dmy = s.match(/^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})(?:[ T](\d{1,2}):(\d{1,2})(?::(\d{1,2}))?)?$/);
    if (dmy) {
        let day = parseInt(dmy[1], 10);
        let month = parseInt(dmy[2], 10) - 1;
        let year = parseInt(dmy[3], 10);
        let hour = parseInt(dmy[4] || 0, 10);
        let min = parseInt(dmy[5] || 0, 10);
        let sec = parseInt(dmy[6] || 0, 10);
        let d = new Date(year, month, day, hour, min, sec);
        return isNaN(d.getTime()) ? null : d;
    }
    
    // Check YYYY-MM-DD e.g. 2026-01-31 12:20:00 or 2026-01-31T12:20 or 2026-01-31
    let ymd = s.match(/^(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})(?:[ T](\d{1,2}):(\d{1,2})(?::(\d{1,2}))?)?$/);
    if (ymd) {
        let year = parseInt(ymd[1], 10);
        let month = parseInt(ymd[2], 10) - 1;
        let day = parseInt(ymd[3], 10);
        let hour = parseInt(ymd[4] || 0, 10);
        let min = parseInt(ymd[5] || 0, 10);
        let sec = parseInt(ymd[6] || 0, 10);
        let d = new Date(year, month, day, hour, min, sec);
        return isNaN(d.getTime()) ? null : d;
    }
    
    let fallback = new Date(s.replace(' ', 'T'));
    return isNaN(fallback.getTime()) ? null : fallback;
}

function formatDisplayDateTime(dateObjOrStr) {
    let d = parseAnyDateTime(dateObjOrStr);
    if (!d) return '';
    let day = String(d.getDate()).padStart(2, '0');
    let month = String(d.getMonth() + 1).padStart(2, '0');
    let year = d.getFullYear();
    let hours = String(d.getHours()).padStart(2, '0');
    let mins = String(d.getMinutes()).padStart(2, '0');
    return `${day}-${month}-${year} ${hours}:${mins}`;
}

function formatToDateTimeLocal(dateObjOrStr) {
    let d = parseAnyDateTime(dateObjOrStr);
    if (!d) return '';
    let year = d.getFullYear();
    let month = String(d.getMonth() + 1).padStart(2, '0');
    let day = String(d.getDate()).padStart(2, '0');
    let hours = String(d.getHours()).padStart(2, '0');
    let mins = String(d.getMinutes()).padStart(2, '0');
    return `${year}-${month}-${day}T${hours}:${mins}`;
}

function formatToDbDateTime(dateObjOrStr) {
    let d = parseAnyDateTime(dateObjOrStr);
    if (!d) return '';
    let year = d.getFullYear();
    let month = String(d.getMonth() + 1).padStart(2, '0');
    let day = String(d.getDate()).padStart(2, '0');
    let hours = String(d.getHours()).padStart(2, '0');
    let mins = String(d.getMinutes()).padStart(2, '0');
    let secs = String(d.getSeconds()).padStart(2, '0');
    return `${year}-${month}-${day} ${hours}:${mins}:${secs}`;
}

function evaluateReturnCoverage() {
    if (!currentReturnCoverageData) return;
    
    let returnVal = $('#return_vehicle_date_in').val() || $('#dt_in').val();
    if (!returnVal) {
        $('#return_coverage_status_badge').html('');
        $('#return_balance_extension_area').hide();
        return;
    }
    
    let returnDate = parseAnyDateTime(returnVal);
    if (!returnDate) return;
    
    let maxCoveredStr = currentReturnCoverageData.max_covered_date;
    if (!maxCoveredStr && currentReturnContractDetails && currentReturnContractDetails.contract) {
        maxCoveredStr = currentReturnContractDetails.contract.service_end_date_time;
    }
    
    let maxCoveredDate = parseAnyDateTime(maxCoveredStr);
    let otherMaxDate = parseAnyDateTime(currentReturnCoverageData.other_max_date);
    
    let isCoveredByThisContract = maxCoveredDate && (returnDate <= maxCoveredDate);
    let isCoveredByOtherContract = otherMaxDate && (returnDate <= otherMaxDate);
    
    // Check if vehicle return date is before covered period (Early Return)
    let diffMsCovered = maxCoveredDate ? (maxCoveredDate.getTime() - returnDate.getTime()) : 0;
    let diffHoursEarly = diffMsCovered / (1000 * 60 * 60);

    if (isCoveredByThisContract && diffHoursEarly >= 1) {
        let formattedCovered = formatDisplayDateTime(maxCoveredDate);
        let formattedReturn = formatDisplayDateTime(returnDate);
        $('#return_coverage_status_badge').html(`
            <div class="alert alert-info py-2 px-3 mb-0 d-flex align-items-center">
                <i class="ri-time-line fs-5 text-primary me-2"></i>
                <div class="small">
                    <strong>Early Return Detected:</strong> Vehicle return date (<strong>${formattedReturn}</strong>) is before covered period (Ends: <strong>${formattedCovered}</strong>). Days left reduction can be calculated and posted below.
                </div>
            </div>
        `);
        $('#return_balance_extension_area').slideUp();

        // Defaults for Early Return from latest extension or contract
        let latestSource = null;
        if (currentReturnCoverageData && Array.isArray(currentReturnCoverageData.data) && currentReturnCoverageData.data.length > 0) {
            let extRows = currentReturnCoverageData.data.filter(r => r.record_type === 'extension');
            latestSource = extRows.length > 0 ? extRows[extRows.length - 1] : currentReturnCoverageData.data[0];
        }

        $('#ret_early_from').val(formatToDateTimeLocal(returnDate));
        $('#ret_early_to').val(formatToDateTimeLocal(maxCoveredDate));

        if (!$('#ret_early_service').data('user-selected')) {
            let defService = '1';
            if (latestSource && latestSource.service_id) {
                defService = String(latestSource.service_id);
            } else if (latestSource && latestSource.service_name && latestSource.service_name.toLowerCase().includes('with driver') && !latestSource.service_name.toLowerCase().includes('without')) {
                defService = '2';
            } else if (currentReturnContractDetails && currentReturnContractDetails.contract) {
                let bookDetails = {};
                try {
                    bookDetails = JSON.parse(currentReturnContractDetails.contract.book_details_json || '{}');
                } catch(e) {}
                if (bookDetails.service_id) {
                    defService = String(bookDetails.service_id);
                }
            }
            $('#ret_early_service').val(defService);
        }

        if (!$('#ret_early_rate_type').data('user-selected')) {
            let defRateType = 'day';
            if (latestSource && latestSource.rate_type_id) {
                defRateType = String(latestSource.rate_type_id);
            } else if (latestSource && latestSource.rate_type) {
                let rt = latestSource.rate_type.toLowerCase();
                if (rt.includes('hour')) defRateType = 'hour';
                else if (rt.includes('week')) defRateType = 'week';
                else if (rt.includes('month')) defRateType = 'month';
                else defRateType = 'day';
            } else if (currentReturnContractDetails && currentReturnContractDetails.contract) {
                let bookDetails = {};
                try {
                    bookDetails = JSON.parse(currentReturnContractDetails.contract.book_details_json || '{}');
                } catch(e) {}
                if (bookDetails.rate_type_id) {
                    defRateType = String(bookDetails.rate_type_id);
                }
            }
            $('#ret_early_rate_type').val(defRateType);
        }

        calculateEarlyReturnReduction();
        $('#return_early_reduction_area').slideDown(function() {
            if (typeof updateReturnFinancialSummary === 'function') updateReturnFinancialSummary();
        });
    } else if (isCoveredByThisContract) {
        let formattedCovered = formatDisplayDateTime(maxCoveredDate);
        $('#return_coverage_status_badge').html(`
            <div class="alert alert-success py-2 px-3 mb-0 d-flex align-items-center">
                <i class="ri-checkbox-circle-fill fs-5 text-success me-2"></i>
                <div class="small">
                    <strong>Period Covered:</strong> Return date matches covered contract / extension period (Valid until: <strong>${formattedCovered}</strong>). No extension or credit required.
                </div>
            </div>
        `);
        $('#return_balance_extension_area').slideUp();
        $('#return_early_reduction_area').slideUp();
    } else if (isCoveredByOtherContract) {
        let formattedOther = formatDisplayDateTime(otherMaxDate);
        $('#return_coverage_status_badge').html(`
            <div class="alert alert-info py-2 px-3 mb-0 d-flex align-items-center">
                <i class="ri-information-fill fs-5 text-info me-2"></i>
                <div class="small">
                    <strong>Vehicle Covered:</strong> Another contract or extension for this vehicle covers up to <strong>${formattedOther}</strong>.
                </div>
            </div>
        `);
        $('#return_balance_extension_area').slideUp();
        $('#return_early_reduction_area').slideUp();
    } else {
        $('#return_early_reduction_area').slideUp();
        let coveredDateForFrom = maxCoveredDate || (otherMaxDate ? otherMaxDate : new Date());
        let formattedCovered = formatDisplayDateTime(coveredDateForFrom);
        let formattedReturn = formatDisplayDateTime(returnDate);
        
        $('#return_coverage_status_badge').html(`
            <div class="alert alert-warning py-2 px-3 mb-0 d-flex align-items-center">
                <i class="ri-error-warning-fill fs-5 text-warning me-2"></i>
                <div class="small">
                    <strong>Uncovered Period:</strong> Vehicle return date (<strong>${formattedReturn}</strong>) exceeds covered period (Ended: <strong>${formattedCovered}</strong>).
                </div>
            </div>
        `);
        
        // Find latest source from extensions or base contract for defaults
        let latestSource = null;
        if (currentReturnCoverageData && Array.isArray(currentReturnCoverageData.data) && currentReturnCoverageData.data.length > 0) {
            let extRows = currentReturnCoverageData.data.filter(r => r.record_type === 'extension');
            latestSource = extRows.length > 0 ? extRows[extRows.length - 1] : currentReturnCoverageData.data[0];
        }
        
        // Populate default balance from and to in datetime-local inputs
        $('#ret_ext_from').val(formatToDateTimeLocal(coveredDateForFrom));
        $('#ret_ext_to').val(formatToDateTimeLocal(returnDate));
        
        // Service default: from latest extension, or contract, or '1'
        if (!$('#ret_ext_service').data('user-selected')) {
            let defService = '1';
            if (latestSource && latestSource.service_id) {
                defService = String(latestSource.service_id);
            } else if (latestSource && latestSource.service_name && latestSource.service_name.toLowerCase().includes('with driver') && !latestSource.service_name.toLowerCase().includes('without')) {
                defService = '2';
            } else if (currentReturnContractDetails && currentReturnContractDetails.contract) {
                let bookDetails = {};
                try {
                    bookDetails = JSON.parse(currentReturnContractDetails.contract.book_details_json || '{}');
                } catch(e) {}
                if (bookDetails.service_id) {
                    defService = String(bookDetails.service_id);
                }
            }
            $('#ret_ext_service').val(defService);
        }
        
        // Rate type default: from latest extension, or contract, or 'day'
        if (!$('#ret_ext_rate_type').data('user-selected')) {
            let defRateType = 'day';
            if (latestSource && latestSource.rate_type_id) {
                defRateType = String(latestSource.rate_type_id);
            } else if (latestSource && latestSource.rate_type) {
                let rt = latestSource.rate_type.toLowerCase();
                if (rt.includes('hour')) defRateType = 'hour';
                else if (rt.includes('week')) defRateType = 'week';
                else if (rt.includes('month')) defRateType = 'month';
                else defRateType = 'day';
            } else if (currentReturnContractDetails && currentReturnContractDetails.contract) {
                let bookDetails = {};
                try {
                    bookDetails = JSON.parse(currentReturnContractDetails.contract.book_details_json || '{}');
                } catch(e) {}
                if (bookDetails.rate_type_id) {
                    defRateType = String(bookDetails.rate_type_id);
                }
            }
            $('#ret_ext_rate_type').val(defRateType);
        }
        
        // Calculate duration, rate, VAT, and total
        calculateReturnBalanceExtension();
        $('#return_balance_extension_area').slideDown(function() {
            if (typeof updateReturnFinancialSummary === 'function') updateReturnFinancialSummary();
        });
    }
}

function calculateReturnBalanceExtension() {
    let fromVal = $('#ret_ext_from').val();
    let toVal = $('#ret_ext_to').val();
    if (!fromVal || !toVal) return;
    
    let fromDate = parseAnyDateTime(fromVal);
    let toDate = parseAnyDateTime(toVal);
    if (!fromDate || !toDate) return;
    
    let rateType = $('#ret_ext_rate_type').val() || 'day';
    let service = $('#ret_ext_service').val() || '1';
    
    let diffMs = toDate.getTime() - fromDate.getTime();
    let duration = 1;
    if (diffMs > 0) {
        if (rateType === 'hour') {
            duration = Math.ceil(diffMs / (1000 * 60 * 60));
        } else if (rateType === 'day') {
            duration = Math.ceil(diffMs / (1000 * 60 * 60 * 24));
        } else if (rateType === 'week') {
            duration = Math.ceil(diffMs / (1000 * 60 * 60 * 24 * 7));
        } else if (rateType === 'month') {
            duration = Math.ceil(diffMs / (1000 * 60 * 60 * 24 * 30));
        }
    }
    duration = Math.max(1, duration);
    
    if (!$('#ret_ext_duration').data('user-override')) {
        $('#ret_ext_duration').val(duration);
    } else {
        duration = parseFloat($('#ret_ext_duration').val()) || 1;
    }
    
    let unitLabel = rateType === 'day' ? 'Day(s)' : (rateType === 'hour' ? 'Hour(s)' : (rateType === 'week' ? 'Week(s)' : 'Month(s)'));
    $('#return_balance_days_badge').text(`${duration} ${unitLabel} Balance`);
    
    let unitPrice = 0;
    if ($('#ret_ext_unit_price').data('user-override')) {
        unitPrice = parseFloat($('#ret_ext_unit_price').val()) || 0;
    } else {
        // Find latest source
        let latestSource = null;
        if (currentReturnCoverageData && Array.isArray(currentReturnCoverageData.data) && currentReturnCoverageData.data.length > 0) {
            let extRows = currentReturnCoverageData.data.filter(r => r.record_type === 'extension');
            latestSource = extRows.length > 0 ? extRows[extRows.length - 1] : currentReturnCoverageData.data[0];
        }
        
        // 1. From latest extension/contract
        if (latestSource && latestSource.unit_price && parseFloat(latestSource.unit_price) > 0) {
            unitPrice = parseFloat(latestSource.unit_price);
        }
        
        // 2. From contract details json
        if (unitPrice === 0 && currentReturnContractDetails && currentReturnContractDetails.contract) {
            try {
                let bJson = JSON.parse(currentReturnContractDetails.contract.book_details_json || '{}');
                unitPrice = parseFloat(bJson.unit_price) || 0;
            } catch(e) {}
        }
        
        // 3. From vehicle pricing cards on page
        if (unitPrice === 0) {
            let priceKey = '';
            if (service === '1') {
                if (rateType === 'hour') priceKey = '#return_wod_hourly';
                else if (rateType === 'day') priceKey = '#return_wod_daily';
                else if (rateType === 'week') priceKey = '#return_wod_weekly';
                else if (rateType === 'month') priceKey = '#return_wod_monthly';
            } else {
                if (rateType === 'hour') priceKey = '#return_wd_hourly';
                else if (rateType === 'day') priceKey = '#return_wd_daily';
                else if (rateType === 'week') priceKey = '#return_wd_weekly';
                else if (rateType === 'month') priceKey = '#return_wd_monthly';
            }
            if (priceKey && $(priceKey).length) {
                unitPrice = parseFloat($(priceKey).text()) || 0;
            }
        }
        
        // 4. From price_list array
        if (unitPrice === 0 && Array.isArray(currentReturnPriceList)) {
            let targetText = '';
            if (service === '1') {
                if (rateType === 'hour') targetText = 'Price per hour rental without driver';
                else if (rateType === 'day') targetText = 'Price per day rental without driver';
                else if (rateType === 'week') targetText = 'Price per week rental without driver';
                else if (rateType === 'month') targetText = 'Price per month rental without driver';
            } else {
                if (rateType === 'hour') targetText = 'Price per hour rental with driver';
                else if (rateType === 'day') targetText = 'Price per day rental with driver';
                else if (rateType === 'week') targetText = 'Price per week rental with driver';
                else if (rateType === 'month') targetText = 'Price per month rental with driver';
            }
            let found = currentReturnPriceList.find(p => p.item === targetText);
            if (found) {
                unitPrice = parseFloat(found.amount) || 0;
            }
        }
        
        $('#ret_ext_unit_price').val(unitPrice.toFixed(3));
    }
    
    // VAT %
    let vatPercent = 10;
    if ($('#ret_ext_vat').data('user-override')) {
        vatPercent = parseFloat($('#ret_ext_vat').val()) || 0;
    } else {
        let latestSource = null;
        if (currentReturnCoverageData && Array.isArray(currentReturnCoverageData.data) && currentReturnCoverageData.data.length > 0) {
            let extRows = currentReturnCoverageData.data.filter(r => r.record_type === 'extension');
            latestSource = extRows.length > 0 ? extRows[extRows.length - 1] : currentReturnCoverageData.data[0];
        }
        if (latestSource && latestSource.vat !== undefined && latestSource.vat !== '') {
            vatPercent = parseFloat(latestSource.vat);
        } else {
            vatPercent = (service === '1') ? 10 : 0;
        }
        $('#ret_ext_vat').val(vatPercent);
    }
    
    if ($('#chk_ext_zero_amount').is(':checked')) {
        unitPrice = 0;
        vatPercent = 0;
        $('#ret_ext_unit_price').val('0.000');
        $('#ret_ext_vat').val('0');
    }

    let subTotal = duration * unitPrice;
    let vatAmt = subTotal * (vatPercent / 100);
    let total = subTotal + vatAmt;
    $('#ret_ext_vat_amount').val(vatAmt.toFixed(3));
    $('#ret_ext_total').val(total.toFixed(3));

    // Update Overdue Summary Row
    const rateLabel = $('#ret_ext_rate_type option:selected').text().trim() || rateType;
    $('#ov_sum_period').html(formatPeriodHtml(fromVal, toVal, true));
    $('#ov_sum_duration').text(`${duration} ${unitLabel}`);
    $('#ov_sum_rate').text(`${rateLabel} @ ${unitPrice.toFixed(3)} BHD`);
    $('#ov_sum_vat_pct').text(vatPercent);
    $('#ov_sum_vat_amt').text(vatAmt.toFixed(3));
    $('#ov_sum_total').text(total.toFixed(3));

    if (typeof updateReturnFinancialSummary === 'function') {
        updateReturnFinancialSummary();
    }
}

function formatReadableDateTime(val) {
    if (!val) return '-';
    const d = parseAnyDateTime(val);
    if (!d) return String(val);
    return d.toLocaleString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    }).replace(',', '');
}

function formatPeriodHtml(fromVal, toVal, isOverdue = false) {
    const fromTxt = formatReadableDateTime(fromVal);
    const toTxt = formatReadableDateTime(toVal);
    const toColor = isOverdue ? '#dc2626' : '#0f766e';
    return `
        <div class="d-flex flex-column gap-1" style="line-height: 1.25;">
            <div><span class="badge bg-label-primary me-1" style="font-size: 10px; min-width: 38px;">From</span> <span>${fromTxt}</span></div>
            <div><span class="badge ${isOverdue ? 'bg-label-danger' : 'bg-label-success'} me-1" style="font-size: 10px; min-width: 38px; color: ${toColor};">To</span> <span>${toTxt}</span></div>
        </div>
    `;
}

$(document).on('change', 'input[name="ret_early_deduct_mode"]', function() {
    const includeDeduct = $(this).val() === 'yes';
    $('#chk_early_zero_amount').prop('checked', !includeDeduct).trigger('change');
    if (includeDeduct) {
        $('#ret_early_edit_fields').slideDown();
        $('#ret_early_unit_price').removeData('user-override');
        $('#ret_early_vat').removeData('user-override');
        calculateEarlyReturnReduction();
    } else {
        $('#ret_early_edit_fields').slideUp();
        if (typeof updateReturnFinancialSummary === 'function') updateReturnFinancialSummary();
    }
});

function updateReturnFinancialSummary() {
    let contractVal = 0;
    let priorExtVal = 0;
    let startVal = '';
    let endVal = '';
    if (currentReturnCoverageData && Array.isArray(currentReturnCoverageData.data) && currentReturnCoverageData.data.length > 0) {
        const rows = currentReturnCoverageData.data;
        startVal = rows[0].from_date_format || rows[0].from_date || '';
        endVal = rows[rows.length - 1].to_date_format || rows[rows.length - 1].to_date || '';
        rows.forEach((r, idx) => {
            const amt = parseFloat(r.total_amt || 0) || 0;
            if (idx === 0 && r.record_type !== 'extension') {
                contractVal += amt;
            } else {
                priorExtVal += amt;
            }
        });
    }
    let overdueVal = 0;
    let deductVal = 0;
    let hasOverdueEnd = false;
    const isEarly = $('#return_early_reduction_area').css('display') !== 'none';
    const isOverdue = $('#return_balance_extension_area').css('display') !== 'none';

    if (isOverdue) {
        $('#ret_sum_third_label').text('Total Overdue');
        const ovToVal = $('#ret_ext_to').val();
        if (ovToVal) {
            endVal = ovToVal;
            hasOverdueEnd = true;
        }
        if (!$('#chk_ext_zero_amount').is(':checked')) {
            overdueVal = parseFloat($('#ret_ext_total').val() || 0) || 0;
        }
        $('#ret_sum_overdue_total').text(overdueVal.toFixed(3));
    } else if (isEarly) {
        $('#ret_sum_third_label').text('Early Return Deduction');
        if ($('#ret_early_deduct_yes').is(':checked') && !$('#chk_early_zero_amount').is(':checked')) {
            deductVal = parseFloat($('#ret_early_total').val() || 0) || 0;
            const earlyFromVal = $('#ret_early_from').val();
            if (earlyFromVal) endVal = earlyFromVal;
        }
        $('#ret_sum_overdue_total').text(deductVal > 0 ? ('- ' + deductVal.toFixed(3)) : '0.000');
    } else {
        $('#ret_sum_third_label').text('Total Overdue');
        $('#ret_sum_overdue_total').text('0.000');
    }

    let totalContractAndExt = contractVal + priorExtVal;
    let grand = Math.max(0, totalContractAndExt + overdueVal - deductVal);
    $('#ret_sum_full_period').html(formatPeriodHtml(startVal, endVal, hasOverdueEnd));
    $('#ret_sum_agreed_total').text(totalContractAndExt.toFixed(3));
    $('#ret_sum_grand_total').text(grand.toFixed(3));
}

function calculateEarlyReturnReduction() {
    let fromVal = $('#ret_early_from').val();
    let toVal = $('#ret_early_to').val();
    if (!fromVal || !toVal) return;
    
    let fromDate = parseAnyDateTime(fromVal);
    let toDate = parseAnyDateTime(toVal);
    if (!fromDate || !toDate) return;
    
    let rateType = $('#ret_early_rate_type').val() || 'day';
    let service = $('#ret_early_service').val() || '1';
    
    let diffMs = toDate.getTime() - fromDate.getTime();
    let duration = 0;
    if (diffMs > 0) {
        if (rateType === 'hour') {
            duration = Math.ceil(diffMs / (1000 * 60 * 60));
        } else if (rateType === 'day') {
            duration = Math.round(diffMs / (1000 * 60 * 60 * 24));
            if (duration === 0 && diffMs >= 1000 * 60 * 60 * 12) {
                duration = 1;
            }
        } else if (rateType === 'week') {
            duration = Math.round(diffMs / (1000 * 60 * 60 * 24 * 7));
            if (duration === 0 && diffMs >= 1000 * 60 * 60 * 24 * 4) {
                duration = 1;
            }
        } else if (rateType === 'month') {
            duration = Math.round(diffMs / (1000 * 60 * 60 * 24 * 30));
            if (duration === 0 && diffMs >= 1000 * 60 * 60 * 24 * 15) {
                duration = 1;
            }
        }
    }
    
    if (!$('#ret_early_duration').data('user-override')) {
        $('#ret_early_duration').val(duration);
    } else {
        duration = parseFloat($('#ret_early_duration').val()) || 0;
    }
    
    let unitLabel = rateType === 'day' ? 'Day(s)' : (rateType === 'hour' ? 'Hour(s)' : (rateType === 'week' ? 'Week(s)' : 'Month(s)'));
    $('#return_early_days_badge').text(`${duration} ${unitLabel} Left`);
    
    let unitPrice = 0;
    if ($('#ret_early_unit_price').data('user-override')) {
        unitPrice = parseFloat($('#ret_early_unit_price').val()) || 0;
    } else {
        // Find latest source
        let latestSource = null;
        if (currentReturnCoverageData && Array.isArray(currentReturnCoverageData.data) && currentReturnCoverageData.data.length > 0) {
            let extRows = currentReturnCoverageData.data.filter(r => r.record_type === 'extension');
            latestSource = extRows.length > 0 ? extRows[extRows.length - 1] : currentReturnCoverageData.data[0];
        }
        
        // 1. From latest extension/contract
        if (latestSource && latestSource.unit_price && parseFloat(latestSource.unit_price) > 0) {
            unitPrice = parseFloat(latestSource.unit_price);
        }
        
        // 2. From contract details json
        if (unitPrice === 0 && currentReturnContractDetails && currentReturnContractDetails.contract) {
            try {
                let bJson = JSON.parse(currentReturnContractDetails.contract.book_details_json || '{}');
                unitPrice = parseFloat(bJson.unit_price) || 0;
            } catch(e) {}
        }
        
        // 3. From vehicle pricing cards on page
        if (unitPrice === 0) {
            let priceKey = '';
            if (service === '1') {
                if (rateType === 'hour') priceKey = '#return_wod_hourly';
                else if (rateType === 'day') priceKey = '#return_wod_daily';
                else if (rateType === 'week') priceKey = '#return_wod_weekly';
                else if (rateType === 'month') priceKey = '#return_wod_monthly';
            } else {
                if (rateType === 'hour') priceKey = '#return_wd_hourly';
                else if (rateType === 'day') priceKey = '#return_wd_daily';
                else if (rateType === 'week') priceKey = '#return_wd_weekly';
                else if (rateType === 'month') priceKey = '#return_wd_monthly';
            }
            if (priceKey && $(priceKey).length) {
                unitPrice = parseFloat($(priceKey).text()) || 0;
            }
        }
        
        // 4. From price_list array
        if (unitPrice === 0 && Array.isArray(currentReturnPriceList)) {
            let targetText = '';
            if (service === '1') {
                if (rateType === 'hour') targetText = 'Price per hour rental without driver';
                else if (rateType === 'day') targetText = 'Price per day rental without driver';
                else if (rateType === 'week') targetText = 'Price per week rental without driver';
                else if (rateType === 'month') targetText = 'Price per month rental without driver';
            } else {
                if (rateType === 'hour') targetText = 'Price per hour rental with driver';
                else if (rateType === 'day') targetText = 'Price per day rental with driver';
                else if (rateType === 'week') targetText = 'Price per week rental with driver';
                else if (rateType === 'month') targetText = 'Price per month rental with driver';
            }
            let found = currentReturnPriceList.find(p => p.item === targetText);
            if (found) {
                unitPrice = parseFloat(found.amount) || 0;
            }
        }
        
        $('#ret_early_unit_price').val(unitPrice.toFixed(3));
    }
    
    // VAT %
    let vatPercent = 10;
    if ($('#ret_early_vat').data('user-override')) {
        vatPercent = parseFloat($('#ret_early_vat').val()) || 0;
    } else {
        let latestSource = null;
        if (currentReturnCoverageData && Array.isArray(currentReturnCoverageData.data) && currentReturnCoverageData.data.length > 0) {
            let extRows = currentReturnCoverageData.data.filter(r => r.record_type === 'extension');
            latestSource = extRows.length > 0 ? extRows[extRows.length - 1] : currentReturnCoverageData.data[0];
        }
        if (latestSource && latestSource.vat !== undefined && latestSource.vat !== '') {
            vatPercent = parseFloat(latestSource.vat);
        } else {
            vatPercent = (service === '1') ? 10 : 0;
        }
        $('#ret_early_vat').val(vatPercent);
    }
    
    if ($('#chk_early_zero_amount').is(':checked')) {
        unitPrice = 0;
        vatPercent = 0;
        $('#ret_early_unit_price').val('0.000');
        $('#ret_early_vat').val('0');
    }

    let total = (duration * unitPrice) * (1 + vatPercent / 100);
    $('#ret_early_total').val(total.toFixed(3));
    if (typeof updateReturnFinancialSummary === 'function') {
        updateReturnFinancialSummary();
    }
    if (!window.earlyReturnReductionPosted) {
        if (total <= 0) {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-checkbox-circle-line me-1"></i> Record No-Cost Return</span>');
        } else {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-refund-2-line me-1"></i> Post Credit to Ledger</span>');
        }
    }
}

function isReturnPeriodUncovered() {
    return $('#return_balance_extension_area').css('display') !== 'none';
}

function executeReturnBalanceExtension() {
    let btnEl = document.querySelector('#btn_confirm_return_extension');
    let laddaReturnExt = btnEl ? Ladda.create(btnEl) : null;
    if (laddaReturnExt) laddaReturnExt.start();

    let agreement_id = $('#txt_return_modal_agreement_id').val();
    let agreement_no = $('#txt_return_modal_agreement_no').val();
    let booking_ids  = $('#txt_return_modal_booking_ids').val();
    let booking_nos  = $('#txt_return_modal_booking_ref_no').val() || agreement_no;

    let customer_data = {
        customer_name: $('#return_c_name').text().trim(),
        customer_code: $('#return_c_code').text().trim(),
        customer_mobile: $('#return_c_mobile').text().trim(),
        customer_email: $('#return_c_email').text().trim(),
        customer_attention: $('#return_c_attn').text().trim(),
        customer_address: $('#return_c_attr').text().trim()
    };

    let vehicle_data = {
        vehicle_id: $('#return_hid_vehicle_id').val(),
        category_id: $('#return_hid_category_id').val(),
        model_id: $('#return_hid_model_id').val(),
        veh_no: $('#return_hid_vehicle_no').val() || $('#return_v_no').text().trim(),
        category_name: $('#return_v_category').text().trim(),
        model_name: $('#return_v_model').text().trim(),
        vehicle_color: $('#return_v_color').text().trim(),
        vehicle_year: $('#return_v_year').text().trim()
    };

    let serviceText = $('#ret_ext_service option:selected').text().trim();
    let rateTypeText = $('#ret_ext_rate_type option:selected').text().trim();
    let durationVal = $('#ret_ext_duration').val();
    let unitPriceVal = $('#ret_ext_unit_price').val();
    let vatVal = $('#ret_ext_vat').val();
    let totalVal = $('#ret_ext_total').val();

    let periodFromDb = formatToDbDateTime($('#ret_ext_from').val());
    let periodToDb   = formatToDbDateTime($('#ret_ext_to').val());

    let contract_details = {
        period_from: periodFromDb,
        period_to: periodToDb,
        rate_type_id: $('#ret_ext_rate_type').val(),
        rate_type: rateTypeText,
        service_id: $('#ret_ext_service').val(),
        service_name: serviceText,
        duration: durationVal,
        unit_price: unitPriceVal,
        min_price: unitPriceVal,
        vat: vatVal,
        total_amt: totalVal,
        qtn_ref_no: (currentReturnContractDetails && currentReturnContractDetails.contract) ? (currentReturnContractDetails.contract.quotation_number || agreement_no) : agreement_no,
        booking_notes: 'Auto extension for return balance period (' + periodFromDb + ' to ' + periodToDb + ')',
        otp_details: ''
    };

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        data: JSON.stringify({
            action: 'extendContractGeneration',
            agreementid: agreement_id,
            agreement_no: agreement_no,
            booking_ids: booking_ids,
            booking_ref_no: booking_nos,
            customer_data: customer_data,
            vehicle_data: vehicle_data,
            contract_details: contract_details,
            service_name: serviceText
        }),
        success: function(res) {
            if (laddaReturnExt) laddaReturnExt.stop();
            if (res && res.status) {
                setupDropdown('dropdownContent', 'success', svgSuccess + 'Contract extended successfully and ledger posted.', 'click');
                $('#ret_ext_duration').removeData('user-override');
                $('#ret_ext_unit_price').removeData('user-override');
                $('#ret_ext_vat').removeData('user-override');
                if (returnextensiontable) {
                    returnextensiontable.ajax.reload();
                }
                if (typeof searchContractList === 'function') {
                    searchContractList();
                }
            } else {
                setupDropdown('dropdownContent', 'error', svgError + (res.message || 'Error extending contract'), 'click');
            }
        },
        error: function(xhr) {
            if (laddaReturnExt) laddaReturnExt.stop();
            setupDropdown('dropdownContent', 'error', svgError + 'Failed to extend contract', 'click');
        }
    });
}

function executeEarlyReturnReduction() {
    let btnEl = document.querySelector('#btn_confirm_early_reduction');
    let laddaEarly = btnEl ? Ladda.create(btnEl) : null;
    if (laddaEarly) laddaEarly.start();

    let agreement_id = $('#txt_return_modal_agreement_id').val();
    let agreement_no = $('#txt_return_modal_agreement_no').val();
    let customer_code = $('#return_c_code').text().trim();
    let serviceText = $('#ret_early_service option:selected').text().trim();
    let rateTypeText = $('#ret_early_rate_type option:selected').text().trim();
    let durationVal = $('#ret_early_duration').val();
    let unitPriceVal = $('#ret_early_unit_price').val();
    let vatVal = $('#ret_early_vat').val();
    let totalVal = $('#ret_early_total').val();

    let periodFromDb = formatToDbDateTime($('#ret_early_from').val());
    let periodToDb   = formatToDbDateTime($('#ret_early_to').val());
    let returnDateVal = $('#return_vehicle_date_in').val() || $('#dt_in').val();

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        data: JSON.stringify({
            action: 'postEarlyReturnReduction',
            agreementid: agreement_id,
            agreement_no: agreement_no,
            customer_code: customer_code,
            service_id: $('#ret_early_service').val(),
            service_name: serviceText,
            rate_type_id: $('#ret_early_rate_type').val(),
            rate_type: rateTypeText,
            duration: durationVal,
            unit_price: unitPriceVal,
            vat: vatVal,
            total_amt: totalVal,
            period_from: periodFromDb,
            period_to: periodToDb,
            trans_date: formatToDbDateTime(returnDateVal) || new Date().toISOString(),
            is_zero_cost: $('#chk_early_zero_amount').is(':checked') ? 1 : 0
        }),
        success: function(res) {
            if (laddaEarly) laddaEarly.stop();
            if (res && res.status) {
                window.earlyReturnReductionPosted = true;
                $('#ret_early_posted_status').show();
                $('#ret_early_posted_status_text').text(res.message || 'Early return reduction has been posted to customer ledger.');
                $('#btn_confirm_early_reduction').prop('disabled', true).html('<i class="ri-checkbox-circle-line me-1"></i> Credit Posted to Ledger');
                setupDropdown('dropdownContent', 'success', svgSuccess + 'Early return reduction posted to customer ledger.', 'click');
            } else {
                setupDropdown('dropdownContent', 'error', svgError + (res.message || 'Error posting early return reduction'), 'click');
            }
        },
        error: function(xhr) {
            if (laddaEarly) laddaEarly.stop();
            setupDropdown('dropdownContent', 'error', svgError + 'Failed to post early return reduction', 'click');
        }
    });
}

// Event Bindings for Return Balance Extension
$(document).on('input change', '#return_vehicle_date_in', function() {
    let val = $(this).val();
    $('#dt_in').val(val);
    $('#ret_ext_duration').removeData('user-override');
    $('#ret_early_duration').removeData('user-override');
    evaluateReturnCoverage();
});

$(document).on('input change', '#dt_in', function() {
    let val = $(this).val();
    $('#return_vehicle_date_in').val(val);
    $('#ret_ext_duration').removeData('user-override');
    $('#ret_early_duration').removeData('user-override');
    evaluateReturnCoverage();
});

// Balance From and Balance To change events
$(document).on('input change', '#ret_ext_from, #ret_ext_to', function() {
    $('#ret_ext_duration').removeData('user-override');
    calculateReturnBalanceExtension();
});

$(document).on('change', '#ret_ext_service', function() {
    $(this).data('user-selected', true);
    $('#ret_ext_unit_price').removeData('user-override');
    $('#ret_ext_vat').removeData('user-override');
    calculateReturnBalanceExtension();
});

$(document).on('change', '#ret_ext_rate_type', function() {
    $(this).data('user-selected', true);
    $('#ret_ext_duration').removeData('user-override');
    $('#ret_ext_unit_price').removeData('user-override');
    calculateReturnBalanceExtension();
});

function syncOverdueLiveTotals() {
    let dur = parseFloat($('#ret_ext_duration').val()) || 0;
    let prc = parseFloat($('#ret_ext_unit_price').val()) || 0;
    let vat = parseFloat($('#ret_ext_vat').val()) || 0;
    let rateType = $('#ret_ext_rate_type').val() || 'day';
    let unitLabel = rateType === 'day' ? 'Day(s)' : (rateType === 'hour' ? 'Hour(s)' : (rateType === 'week' ? 'Week(s)' : 'Month(s)'));
    let rateLabel = $('#ret_ext_rate_type option:selected').text().trim() || rateType;
    let subTotal = dur * prc;
    let vatAmt = subTotal * (vat / 100);
    let total = subTotal + vatAmt;

    $('#return_balance_days_badge').text(`${dur} ${unitLabel} Overdue`);
    $('#ret_ext_vat_amount').val(vatAmt.toFixed(3));
    $('#ret_ext_total').val(total.toFixed(3));
    $('#ov_sum_duration').text(`${dur} ${unitLabel}`);
    $('#ov_sum_rate').text(`${rateLabel} @ ${prc.toFixed(3)} BHD`);
    $('#ov_sum_vat_pct').text(vat);
    $('#ov_sum_vat_amt').text(vatAmt.toFixed(3));
    $('#ov_sum_total').text(total.toFixed(3));

    if (typeof updateReturnFinancialSummary === 'function') {
        updateReturnFinancialSummary();
    }
}

$(document).on('input', '#ret_ext_duration', function() {
    $(this).data('user-override', true);
    syncOverdueLiveTotals();
});

$(document).on('input', '#ret_ext_unit_price', function() {
    $(this).data('user-override', true);
    let prc = parseFloat($(this).val()) || 0;
    if (prc === 0 && $(this).val().trim() !== '') {
        $('#chk_ext_zero_amount').prop('checked', true);
    } else {
        $('#chk_ext_zero_amount').prop('checked', false);
    }
    syncOverdueLiveTotals();
});

$(document).on('input', '#ret_ext_vat', function() {
    $(this).data('user-override', true);
    syncOverdueLiveTotals();
});

$(document).on('change', '#chk_ext_zero_amount', function() {
    if ($(this).is(':checked')) {
        $(this).data('prev-price', $('#ret_ext_unit_price').val() || '');
        $(this).data('prev-vat', $('#ret_ext_vat').val() || '10');
        $('#ret_ext_unit_price').val('0.000').data('user-override', true);
        $('#ret_ext_vat').val('0').data('user-override', true);
        syncOverdueLiveTotals();
    } else {
        let prevPrice = $(this).data('prev-price');
        let prevVat = $(this).data('prev-vat');
        if (prevPrice !== undefined && parseFloat(prevPrice) > 0) {
            $('#ret_ext_unit_price').val(prevPrice).data('user-override', true);
            $('#ret_ext_vat').val(prevVat || '10').data('user-override', true);
        } else {
            $('#ret_ext_unit_price').removeData('user-override');
            $('#ret_ext_vat').removeData('user-override');
        }
        calculateReturnBalanceExtension();
    }
});

$(document).on('click', '#btn_confirm_return_extension', function(e) {
    e.preventDefault();
    let duration = $('#ret_ext_duration').val();
    let totalVal = parseFloat($('#ret_ext_total').val()) || 0;
    let unitPrc = parseFloat($('#ret_ext_unit_price').val()) || 0;
    let from = formatDisplayDateTime($('#ret_ext_from').val());
    let to = formatDisplayDateTime($('#ret_ext_to').val());
    let serviceName = $('#ret_ext_service option:selected').text();
    let rateTypeName = $('#ret_ext_rate_type option:selected').text();
    
    let isZero = (totalVal <= 0 || unitPrc <= 0);
    let totalDisplay = isZero 
        ? '<b class="text-primary">Zero Additional Amount (0.000 BHD)</b>' 
        : `<b>BHD ${$('#ret_ext_total').val()}</b>`;
    let noteText = isZero 
        ? '<span class="text-info"><i class="ri-information-line me-1"></i>A zero-cost extension entry will be recorded in customer ledger for future tracking.</span>' 
        : '<span class="text-success"><i class="ri-checkbox-circle-line me-1"></i>Ledger posting will be automatically created.</span>';
    
    let msg = `Extend contract for <b>${duration} ${rateTypeName}</b> (${serviceName}) from <b>${from}</b> to <b>${to}</b> for ${totalDisplay}?<br><br>${noteText}`;
    
    $('#confirmReturnExtensionMessage').html(msg);
    let modalEl = document.getElementById('confirmReturnExtensionModal');
    let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modalInstance.show();
});

$(document).on('click', '#btnConfirmReturnExtensionYes', function() {
    let modalEl = document.getElementById('confirmReturnExtensionModal');
    let modalInstance = bootstrap.Modal.getInstance(modalEl);
    if (modalInstance) modalInstance.hide();
    
    executeReturnBalanceExtension();
});

$(document).on('show.bs.modal', '#confirmReturnExtensionModal', function() {
    let highestZ = 1050;
    $('.modal.show').each(function() {
        if (this.id !== 'confirmReturnExtensionModal') {
            let z = parseInt($(this).css('z-index')) || 1050;
            if (z > highestZ) highestZ = z;
        }
    });
    $(this).css('z-index', highestZ + 20);
    setTimeout(function() {
        $('.modal-backdrop').last().css('z-index', highestZ + 10);
    }, 10);
});

$(document).on('hidden.bs.modal', '#confirmReturnExtensionModal', function() {
    if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open');
    }
});

// Event Bindings for Early Return Reduction
$(document).on('input change', '#ret_early_from, #ret_early_to', function() {
    $('#ret_early_duration').removeData('user-override');
    calculateEarlyReturnReduction();
});

$(document).on('change', '#ret_early_service', function() {
    $(this).data('user-selected', true);
    $('#ret_early_unit_price').removeData('user-override');
    $('#ret_early_vat').removeData('user-override');
    calculateEarlyReturnReduction();
});

$(document).on('change', '#ret_early_rate_type', function() {
    $(this).data('user-selected', true);
    $('#ret_early_duration').removeData('user-override');
    $('#ret_early_unit_price').removeData('user-override');
    calculateEarlyReturnReduction();
});

$(document).on('input', '#ret_early_duration', function() {
    $(this).data('user-override', true);
    let dur = parseFloat($(this).val()) || 0;
    let rateType = $('#ret_early_rate_type').val() || 'day';
    let unitLabel = rateType === 'day' ? 'Day(s)' : (rateType === 'hour' ? 'Hour(s)' : (rateType === 'week' ? 'Week(s)' : 'Month(s)'));
    $('#return_early_days_badge').text(`${dur} ${unitLabel} Left`);
    let prc = parseFloat($('#ret_early_unit_price').val()) || 0;
    let vat = parseFloat($('#ret_early_vat').val()) || 0;
    let tot = (dur * prc) * (1 + vat / 100);
    $('#ret_early_total').val(tot.toFixed(3));
    if (typeof updateReturnFinancialSummary === 'function') updateReturnFinancialSummary();
    if (!window.earlyReturnReductionPosted) {
        if (tot <= 0) {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-checkbox-circle-line me-1"></i> Record No-Cost Return</span>');
        } else {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-refund-2-line me-1"></i> Post Credit to Ledger</span>');
        }
    }
});

$(document).on('input', '#ret_early_unit_price', function() {
    $(this).data('user-override', true);
    let dur = parseFloat($('#ret_early_duration').val()) || 0;
    let prc = parseFloat($(this).val()) || 0;
    if (prc === 0 && $(this).val().trim() !== '') {
        $('#chk_early_zero_amount').prop('checked', true);
    } else {
        $('#chk_early_zero_amount').prop('checked', false);
    }
    let vat = parseFloat($('#ret_early_vat').val()) || 0;
    let tot = (dur * prc) * (1 + vat / 100);
    $('#ret_early_total').val(tot.toFixed(3));
    if (typeof updateReturnFinancialSummary === 'function') updateReturnFinancialSummary();
    if (!window.earlyReturnReductionPosted) {
        if (tot <= 0) {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-checkbox-circle-line me-1"></i> Record No-Cost Return</span>');
        } else {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-refund-2-line me-1"></i> Post Credit to Ledger</span>');
        }
    }
});

$(document).on('input', '#ret_early_vat', function() {
    $(this).data('user-override', true);
    let dur = parseFloat($('#ret_early_duration').val()) || 0;
    let prc = parseFloat($('#ret_early_unit_price').val()) || 0;
    let vat = parseFloat($(this).val()) || 0;
    let tot = (dur * prc) * (1 + vat / 100);
    $('#ret_early_total').val(tot.toFixed(3));
    if (typeof updateReturnFinancialSummary === 'function') updateReturnFinancialSummary();
    if (!window.earlyReturnReductionPosted) {
        if (tot <= 0) {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-checkbox-circle-line me-1"></i> Record No-Cost Return</span>');
        } else {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-refund-2-line me-1"></i> Post Credit to Ledger</span>');
        }
    }
});

$(document).on('change', '#chk_early_zero_amount', function() {
    if ($(this).is(':checked')) {
        $(this).data('prev-price', $('#ret_early_unit_price').val() || '');
        $(this).data('prev-vat', $('#ret_early_vat').val() || '10');
        $('#ret_early_unit_price').val('0.000').data('user-override', true);
        $('#ret_early_vat').val('0').data('user-override', true);
        $('#ret_early_total').val('0.000');
        if (!window.earlyReturnReductionPosted) {
            $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-checkbox-circle-line me-1"></i> Record No-Cost Return</span>');
        }
    } else {
        let prevPrice = $(this).data('prev-price');
        let prevVat = $(this).data('prev-vat');
        if (prevPrice !== undefined && parseFloat(prevPrice) > 0) {
            $('#ret_early_unit_price').val(prevPrice).data('user-override', true);
            $('#ret_early_vat').val(prevVat || '10').data('user-override', true);
        } else {
            $('#ret_early_unit_price').removeData('user-override');
            $('#ret_early_vat').removeData('user-override');
        }
        calculateEarlyReturnReduction();
        if (!window.earlyReturnReductionPosted) {
            let tot = parseFloat($('#ret_early_total').val()) || 0;
            if (tot > 0) {
                $('#btn_confirm_early_reduction').html('<span class="ladda-label"><i class="ri-refund-2-line me-1"></i> Post Credit to Ledger</span>');
            }
        }
    }
});

$(document).on('click', '#btn_confirm_early_reduction', function(e) {
    e.preventDefault();
    let duration = $('#ret_early_duration').val();
    let totalVal = parseFloat($('#ret_early_total').val()) || 0;
    let unitPrc = parseFloat($('#ret_early_unit_price').val()) || 0;
    let from = formatDisplayDateTime($('#ret_early_from').val());
    let to = formatDisplayDateTime($('#ret_early_to').val());
    let serviceName = $('#ret_early_service option:selected').text();
    let rateTypeName = $('#ret_early_rate_type option:selected').text();
    
    let isZero = (totalVal <= 0 || unitPrc <= 0);
    let totalDisplay = isZero 
        ? '<b class="text-primary">Zero Deductions / No Refund (0.000 BHD)</b>' 
        : `<b>BHD ${$('#ret_early_total').val()}</b>`;
    let noteText = isZero 
        ? '<span class="text-info"><i class="ri-information-line me-1"></i>A zero-cost early return entry will be recorded in customer ledger for future tracking.</span>' 
        : '<span class="text-success"><i class="ri-checkbox-circle-line me-1"></i>Customer ledger balance will be reduced accordingly.</span>';
    let actionLabel = isZero ? 'Record early return without deduction' : 'Post credit reduction';
    
    let msg = `${actionLabel} for <b>${duration} ${rateTypeName}</b> (${serviceName}) from <b>${from}</b> to <b>${to}</b> for ${totalDisplay} to customer ledger?<br><br>${noteText}`;
    
    $('#confirmEarlyReductionMessage').html(msg);
    let modalEl = document.getElementById('confirmEarlyReductionModal');
    let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modalInstance.show();
});

$(document).on('click', '#btnConfirmEarlyReductionYes', function() {
    let modalEl = document.getElementById('confirmEarlyReductionModal');
    let modalInstance = bootstrap.Modal.getInstance(modalEl);
    if (modalInstance) modalInstance.hide();
    
    executeEarlyReturnReduction();
});

$(document).on('show.bs.modal', '#confirmEarlyReductionModal', function() {
    let highestZ = 1050;
    $('.modal.show').each(function() {
        if (this.id !== 'confirmEarlyReductionModal') {
            let z = parseInt($(this).css('z-index')) || 1050;
            if (z > highestZ) highestZ = z;
        }
    });
    $(this).css('z-index', highestZ + 20);
    setTimeout(function() {
        $('.modal-backdrop').last().css('z-index', highestZ + 10);
    }, 10);
});

$(document).on('hidden.bs.modal', '#confirmEarlyReductionModal', function() {
    if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open');
    }
});
let currentVehiclePreviewId = null;



$(document).on('click', '.vehicle-preview-img', function () {

    let id  = $(this).data('id');
    let src = $(this).attr('src'); // safer than data-src

    currentVehiclePreviewId = id;

    // clear previous content (important)
    $('#VehiclefilePreviewBody').empty().html(`
        <img src="${src}" 
             class="img-fluid rounded shadow" 
             style="max-height:70vh;">
    `);

    let modalEl = document.getElementById('imagePreviewModal');
    if (modalEl && modalEl.parentElement !== document.body) {
        document.body.appendChild(modalEl);
    }
    if (modalEl) {
        modalEl.style.setProperty('z-index', '100080', 'important');
    }

    let modal = bootstrap.Modal.getInstance(modalEl);
    if (!modal) {
        modal = new bootstrap.Modal(modalEl);
    }

    modal.show();
});

//Extend
$(document).on('click', '#contractTable li a.extend_list_btn', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     
    let status = $(this).closest('tr').find('.status-cell span').text().trim();


    if (status === 'Extended') {
        
        
         $('#elist_agreement_ref').text(agreement_no);
         $('#txt_elist_modal_agreement_id').val(id);
         $('#txt_elist_modal_agreement_no').val(agreement_no);
          $('#txt_elist_modal_booking_ids').val(booking_ids);
         
        openExtendList(id,vehicleid,customer_code,model_ids);
        
    } else   {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'The contract has not been extended yet.',
                'click'
            );
            return;
        
    } 
   
});
function openExtendList(id,vehicleid,customer_code,model_ids) {

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            agreementid:id,vehicleid:vehicleid,customer_code:customer_code,model_ids:model_ids
        }),
        success: function (res) {
          populateelistContractModal(res);
            new bootstrap.Modal(document.getElementById('elistcontractModal')).show();
        }
    });
}
function populateelistContractModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;

    // ── Customer ──────────────────────────────────────────────────────
    $('#elist_c_name').text(data.customer.customer_name || '');
    $('#elist_c_code').text(data.customer.customer_id || '');
    $('#elist_c_mobile').text(data.customer.customer_mobile || '');
    $('#elist_c_email').text(data.customer.customer_email || '');
    let eAttn = data.customer.customer_attn || '';
    let eAddr = data.customer.customer_addr || '';
    $('#elist_c_attn').text(eAttn);
    $('#elist_c_attr').text(eAttn && eAddr ? ' - ' + eAddr : eAddr);

    // ── Vehicle ───────────────────────────────────────────────────────
    $('#elist_v_no').text(data.vehicle.vehicle_number || '');
    $('#elist_v_model').text(data.vehicle.model_names || '');
    $('#elist_v_brand').text(data.vehicle.brand_name || '');
    $('#elist_v_category').text(data.vehicle.category_name || '');
    $('#elist_v_color').text(data.vehicle.vehicle_color || '');
    $('#elist_v_year').text(data.vehicle.vehicle_year || '');
    $('#elist_v_chassis').text(data.vehicle.chassis_number || '-');
    $('#elist_v_passing').text(data.vehicle.formatted_next_passing_date || '');
    $('#elist_hid_nxt_passing').val(data.vehicle.next_passing_date || '');
    $('#elist_v_maintenance').text(data.vehicle.formatted_next_maintenance_date || '');
    $('#elist_hid_nxt_maintenance').val(data.vehicle.next_maintenance_date || '');
    $('#elist_v_insurance').text(data.vehicle.formatted_next_insurance_date || '');
    $('#elist_hid_nxt_insurance').val(data.vehicle.next_insurance_date || '');
    $('#elist_hid_vehicle_id').val(data.vehicle.ids || '');
    $('#elist_hid_category_id').val(data.vehicle.category_id || '');
    $('#elist_hid_model_id').val(data.vehicle.model_id || '');
    $('#elist_hid_vehicle_no').val(data.vehicle.vehicle_number || '');

    // ── Vehicle image mini-slider ──────────────────────────────────────
    let eImages = data.vehicle.vehicle_images;
    if (typeof eImages === "string") { try { eImages = JSON.parse(eImages); } catch(e) { eImages = []; } }
    if (!Array.isArray(eImages)) eImages = [];
    eImages = eImages.filter(img => img && img !== "default.jpg");
    if (eImages.length === 0) eImages = ["default.jpg"];

    let eSliderImg  = document.getElementById("elistVSliderImg");
    let eSliderDots = document.getElementById("elistVSliderDots");
    let eSliderPrev = document.getElementById("elistVSliderPrev");
    let eSliderNext = document.getElementById("elistVSliderNext");
    let eSliderIdx  = 0;

    function elistSliderShow(idx) {
        eSliderIdx = (idx + eImages.length) % eImages.length;
        eSliderImg.src = eImages[eSliderIdx] === "default.jpg"
            ? "uploads/vehicleImages/default.jpg"
            : "uploads/vehicleImages/" + eImages[eSliderIdx];
        if (eSliderDots) {
            eSliderDots.querySelectorAll(".slider-dot").forEach((d, i) =>
                d.classList.toggle("active", i === eSliderIdx));
        }
    }

    if (eSliderDots) {
        eSliderDots.innerHTML = "";
        if (eImages.length > 1) {
            eImages.forEach((_, i) => {
                let dot = document.createElement("span");
                dot.className = "slider-dot" + (i === 0 ? " active" : "");
                dot.addEventListener("click", () => elistSliderShow(i));
                eSliderDots.appendChild(dot);
            });
        }
    }
    if (eSliderPrev) { eSliderPrev.style.display = eImages.length > 1 ? "" : "none"; eSliderPrev.onclick = () => elistSliderShow(eSliderIdx - 1); }
    if (eSliderNext) { eSliderNext.style.display = eImages.length > 1 ? "" : "none"; eSliderNext.onclick = () => elistSliderShow(eSliderIdx + 1); }
    elistSliderShow(0);

    // ── Pricing ───────────────────────────────────────────────────────
    data.price_list.forEach(function(item) {
        switch(item.item) {
            case "Price per hour rental without driver":  $('#elist_wod_hourly').text(parseFloat(item.amount).toFixed(3)); break;
            case "Price per hour rental with driver":     $('#elist_wd_hourly').text(parseFloat(item.amount).toFixed(3)); break;
            case "Price per day rental without driver":   $('#elist_wod_daily').text(parseFloat(item.amount).toFixed(3)); break;
            case "Price per day rental with driver":      $('#elist_wd_daily').text(parseFloat(item.amount).toFixed(3)); break;
            case "Price per week rental without driver":  $('#elist_wod_weekly').text(parseFloat(item.amount).toFixed(3)); break;
            case "Price per week rental with driver":     $('#elist_wd_weekly').text(parseFloat(item.amount).toFixed(3)); break;
            case "Price per month rental without driver": $('#elist_wod_monthly').text(parseFloat(item.amount).toFixed(3)); break;
            case "Price per month rental with driver":    $('#elist_wd_monthly').text(parseFloat(item.amount).toFixed(3)); break;
        }
    });

    // ── Stepper: reset to step 1 ──────────────────────────────────────
    if (window.elistStepper) {
        try { window.elistStepper.destroy(); } catch(e) {}
    }
    let elistStepperEl = document.querySelector('#elistStepper');
    if (elistStepperEl) {
        window.elistStepper = new Stepper(elistStepperEl, {
            linear: false,
            animation: true
        });
        elistStepperEl.addEventListener('shown.bs-stepper', function (event) {
            if (typeof extensiontable !== 'undefined') {
                extensiontable.columns.adjust().draw();
            }
        });
    }
    extensiontable = $('#contractExtensionTable').DataTable({
    processing: true,
    destroy: true,
    serverSide: false,
    pageLength: 10,
    scrollX: true,
    ajax: {
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: function () {
            return JSON.stringify({
                action: 'ListContractExtensions',
                agreementid: $('#txt_elist_modal_agreement_id').val()
            });
        },
        dataSrc: 'data'
    },

    columnDefs: [
        { targets: 0,  width: '40px',  className: 'text-center align-middle' },
        { targets: 1,  width: '120px', className: 'align-middle' },
        { targets: 2,  width: '100px', className: 'text-center align-middle text-nowrap' },
        { targets: 3,  width: '160px', className: 'align-middle text-nowrap' },
        { targets: 4,  width: '180px', className: 'align-middle' },
        { targets: 5,  width: '150px', className: 'align-middle' },
        { targets: 6,  width: '130px', className: 'align-middle' },
        { targets: 7,  width: '110px', className: 'text-center align-middle' },
    ],

    columns: [
        // #
        {
            data: null,
            orderable: false,
            searchable: false,
            render: function (data, type, row, meta) {
                return `<span class="text-muted fw-semibold">${meta.row + 1}</span>`;
            }
        },
        // Agreement No
        {
            data: 'agreement_no',
            render: function (data) {
                return `<span class="badge bg-label-primary fw-semibold">${data || '-'}</span>`;
            }
        },
        // Date
        { data: 'extension_date_format' },
        // Extension Period
        {
            data: null,
            render: function (data, type, row) {
                return `<div class="lh-sm">
                    <div class="fw-semibold small">${row.from_date_format || '-'}</div>
                    <div class="text-muted" style="font-size:0.75rem;">to</div>
                    <div class="fw-semibold small">${row.to_date_format || '-'}</div>
                </div>`;
            }
        },
        // Details
        {
            data: null,
            render: function (data, type, row) {
                return `<div class="lh-sm small">
                    <div class="fw-semibold">${row.service_name || '-'}</div>
                    <div class="text-muted">${row.rate_type || ''} &bull; Duration: <strong>${row.duration || 0}</strong></div>
                    <div class="text-muted">Min: ${row.min_price || '0.000'} &bull; Qtn: ${row.qtn_ref_no || '-'}</div>
                </div>`;
            }
        },
        // Pricing
        {
            data: null,
            render: function (data, type, row) {
                return `<div class="lh-sm small">
                    <div class="fw-bold text-danger">Total: ${row.total_amt || '0.000'}</div>
                    <div class="text-muted">Unit: ${row.unit_price || '0.000'} &bull; VAT: ${row.vat || '0'}%</div>
                    <div class="text-muted" style="font-size:0.72rem;">${row.otp_details || ''}</div>
                </div>`;
            }
        },
        // Notes
        {
            data: 'booking_notes',
            render: function(data) {
                return `<span class="small text-muted">${data || '-'}</span>`;
            }
        },
        // Actions
        {
            data: null,
            orderable: false,
            render: function (data, type, row) {
                return `
                        <button type="button" class="btn btn-sm btn-icon btn-danger deleteExtension text-white" style="background-color: #ff3e1d; color: white;"
                                data-id="${row.id}"
                                data-vehicle="${row.vehicle_id}"
                                data-customer="${row.customer_code}"
                                data-contract="${row.agreement_no}"
                                data-agreement_ids="${row.agreement_ids}"
                                data-booking_id="${row.booking_ids}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="Delete Extension"
                              >
                           <i class="ri ri-delete-bin-line text-white"></i>
                        </button>
                `;
            }
        }
    ]
});
    
    
}



   $('#contractExtensionTable').on('draw.dt', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
}); 
$(document).on('click', '#contractExtensionTable button.deleteExtension', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let agreement_ids = $(this).data('agreement_ids');
     let booking_ids = $(this).data('booking_id');
   showConfirmModal({
        title: 'Delete Extension',
        message: 'Are you sure you want to delete this extension?',
        confirmText: 'Yes, Delete',
        type: 'danger',
        action: 'delete_extension',
        data: {
            action: 'delete_extension',
            extend_ids: id,
            agreementid:agreement_ids,
            booking_ids:booking_ids,
            vehicleid:vehicleid
        },
         extra: {
            btn: btn,
            id: id,
            agreement_ids: agreement_ids,
            vehicleid: vehicleid
        }
        
    });
});
 
$(document).on('click', '#contractTable li a.print_agreement_btn', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     
  fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(agreement_no)))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/PrintAgreement?token=' + encodeURIComponent(token), '_blank');
        });
    

});
$(document).on('click', '#contractTable li a.send_agreement_btn', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     $('#send_contract_no').val($.trim(agreement_no)|| '');
     
   new bootstrap.Modal(document.getElementById('sendContractModal')).show();
    

});

$(document).on('click', '#contractTable li a.extend_contract_btn', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     let booking_no = $(this).data('booking_no');
     
    let status = $(this).closest('tr').find('.status-cell span').text().trim();


    if (status === 'Rentout' || status === 'Extended' || status === 'Onhold' ) {
        
        
         $('#agreement_ref').text(agreement_no);
         $('#txt_extend_modal_agreement_id').val(id);
         $('#txt_extend_modal_agreement_no').val(agreement_no);
          $('#txt_extend_modal_booking_ids').val(booking_ids);
           $('#txt_extend_modal_booking_nos').val(booking_no);
         
        openExtendContractModal(id,vehicleid,customer_code,model_ids);
        
    }else if (status === 'Generated') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'The contract has only been generated. Please complete the rent-out process first, and then extend the contract if required.',
                'click'
            );
            return;
        
    } 
    else if (status === 'Cancelled') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'This contract has been cancelled. You cannot extend the contract.',
                'click'
            );
            return;
        
    }else if (status === 'Closed') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'This contract has been closed. You cannot extend the contract.',
                'click'
            );
            return;
        
    }
    else if (status === 'Returned') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'This vehicle has been returned. You cannot extend the contract.',
                'click'
            );
            return;
        
    }
    else {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'Invalid Status',
                'click'
            );
            return;
    }
    

});

var extendStepper;
$(document).ready(function() {
    const extWizard = document.getElementById('extendContractWizard');
    if (extWizard) {
        extendStepper = new Stepper(extWizard, { linear: false });
        
        $(extWizard).find('.btn-next').on('click', function() {
            extendStepper.next();
        });
        $(extWizard).find('.btn-prev').on('click', function() {
            extendStepper.previous();
        });
    }
});

// ── Extend Contract Date Helpers ──────────────────────────────────────────────

// Convert DB datetime (yyyy-mm-dd hh:mm:ss  OR  yyyy-mm-dd hh:mm) → dd-mm-yyyy hh:mm
function extendDbToDisplay(dbDate) {
    if (!dbDate) return '';
    // Handle ISO strings with T separator as well
    let str = String(dbDate).replace('T', ' ').trim();
    let parts = str.split(' ');
    if (parts.length < 2) return '';
    let dateParts = parts[0].split('-');   // [yyyy, mm, dd]
    let timeParts = parts[1].split(':');   // [hh, mm, (ss)]
    if (dateParts.length < 3 || timeParts.length < 2) return '';
    return `${dateParts[2]}-${dateParts[1]}-${dateParts[0]} ${timeParts[0]}:${timeParts[1]}`;
}

// Parse display value (dd-mm-yyyy hh:mm  OR  dd-mm-yyyy) → JS Date object
// If no time given, defaults to 00:00
function extendDisplayToDate(displayVal) {
    if (!displayVal) return null;
    // Full format: dd-mm-yyyy hh:mm
    let m = displayVal.match(/^(\d{2})-(\d{2})-(\d{4}) (\d{2}):(\d{2})$/);
    if (m) return new Date(+m[3], +m[2]-1, +m[1], +m[4], +m[5]);
    // Date only: dd-mm-yyyy  → default time 00:00
    let d = displayVal.match(/^(\d{2})-(\d{2})-(\d{4})$/);
    if (d) return new Date(+d[3], +d[2]-1, +d[1], 0, 0);
    return null;
}

// Convert display value (dd-mm-yyyy hh:mm  OR  dd-mm-yyyy) → DB string (yyyy-mm-dd hh:mm:00)
// If no time given, defaults to 00:00:00
function extendDisplayToDbStr(displayVal) {
    if (!displayVal) return '';
    // Full format
    let m = displayVal.match(/^(\d{2})-(\d{2})-(\d{4}) (\d{2}):(\d{2})$/);
    if (m) return `${m[3]}-${m[2]}-${m[1]} ${m[4]}:${m[5]}:00`;
    // Date only → default 00:00:00
    let d = displayVal.match(/^(\d{2})-(\d{2})-(\d{4})$/);
    if (d) return `${d[3]}-${d[2]}-${d[1]} 00:00:00`;
    return displayVal;
}

// Auto-format as user types in To field: dd-mm-yyyy hh:mm
// Uses strict > so separators only appear once the preceding group has digits after it
// This ensures backspace works correctly without fighting the formatter
function extendFormatDateInput(el) {
    let raw = el.value.replace(/\D/g, '').substring(0, 12); // strip non-digits, cap at 12 digits
    let out = raw.substring(0, 2);                              // dd
    if (raw.length > 2)  out += '-' + raw.substring(2, 4);     // -mm
    if (raw.length > 4)  out += '-' + raw.substring(4, 8);     // -yyyy
    if (raw.length > 8)  out += ' ' + raw.substring(8, 10);    // ' 'hh
    if (raw.length > 10) out += ':' + raw.substring(10, 12);   // :mm
    el.value = out;
}

// ─────────────────────────────────────────────────────────────────────────────

function openExtendContractModal(id,vehicleid,customer_code,model_ids) {

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            agreementid:id,vehicleid:vehicleid,customer_code:customer_code,model_ids:model_ids
        }),
        success: function (res) {
          populateExtendContractModal(res);
            new bootstrap.Modal(document.getElementById('extendcontractModal')).show();
            if (typeof extendStepper !== 'undefined') {
                extendStepper.to(1);
            }
        }
    });
}

function populateExtendContractModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;
   
        $('#extend_c_name').text(data.customer.customer_name || '');
        $('#extend_c_code').text(data.customer.customer_id || '');
        $('#extend_c_mobile').text(data.customer.customer_mobile || '');
        $('#extend_c_email').text(data.customer.customer_email || '');
        let attn = data.customer.customer_attn || '';
        let addr = data.customer.customer_addr || '';
        $('#extend_c_attn').text(attn);
        $('#extend_c_attr').text(attn && addr ? ' - ' + addr : addr);
        
        $('#extend_v_no').text(data.vehicle.vehicle_number || '');
        $('#extend_v_model').text(data.vehicle.model_names || '');
        $('#extend_v_brand').text(data.vehicle.brand_name || '');
        $('#extend_v_category').text(data.vehicle.category_name || '');
        $('#extend_v_color').text(data.vehicle.vehicle_color || '');
        $('#extend_v_year').text(data.vehicle.vehicle_year || '');
        $('#extend_v_chassis').text(data.vehicle.chassis_number || '-');
        $('#extend_v_passing').text(data.vehicle.formatted_next_passing_date || '');
        $('#extend_hid_nxt_passing').val(data.vehicle.next_passing_date || '');  
        $('#extend_v_maintenance').text(data.vehicle.formatted_next_maintenance_date || '');
        $('#extend_hid_nxt_maintenance').val(data.vehicle.next_maintenance_date || '');  
        $('#extend_v_insurance').text(data.vehicle.formatted_next_insurance_date || ''); 
        $('#extend_hid_nxt_insurance').val(data.vehicle.next_insurance_date || '');  
        
        
        $('#extend_hid_vehicle_id').val(data.vehicle.ids || '');
        $('#extend_hid_category_id').val(data.vehicle.category_id || '');
        $('#extend_hid_model_id').val(data.vehicle.model_id || '');
        $('#extend_hid_vehicle_no').val(data.vehicle.vehicle_number || '');
        
        let images = data.vehicle.vehicle_images;
        if (typeof images === "string") {
            try { images = JSON.parse(images); } catch (e) { images = []; }
        }
        if (!Array.isArray(images)) images = [];
        images = images.filter(img => img && img !== "default.jpg");
        if (images.length === 0) images = ["default.jpg"];

        // Build mini slider
        let sliderImg  = document.getElementById("extendVSliderImg");
        let sliderDots = document.getElementById("extendVSliderDots");
        let sliderPrev = document.getElementById("extendVSliderPrev");
        let sliderNext = document.getElementById("extendVSliderNext");
        let sliderIdx  = 0;

        function extendSliderShow(idx) {
            sliderIdx = (idx + images.length) % images.length;
            let src = images[sliderIdx] === "default.jpg"
                ? "uploads/vehicleImages/default.jpg"
                : "uploads/vehicleImages/" + images[sliderIdx];
            sliderImg.src = src;
            // update dots
            if (sliderDots) {
                sliderDots.querySelectorAll(".slider-dot").forEach((d, i) => {
                    d.classList.toggle("active", i === sliderIdx);
                });
            }
        }

        if (sliderDots) {
            sliderDots.innerHTML = "";
            if (images.length > 1) {
                images.forEach((_, i) => {
                    let dot = document.createElement("span");
                    dot.className = "slider-dot" + (i === 0 ? " active" : "");
                    dot.addEventListener("click", () => extendSliderShow(i));
                    sliderDots.appendChild(dot);
                });
            }
        }
        if (sliderPrev) {
            sliderPrev.style.display = images.length > 1 ? "" : "none";
            sliderPrev.onclick = () => extendSliderShow(sliderIdx - 1);
        }
        if (sliderNext) {
            sliderNext.style.display = images.length > 1 ? "" : "none";
            sliderNext.onclick = () => extendSliderShow(sliderIdx + 1);
        }
        extendSliderShow(0);

        data.price_list.forEach(function(item) {
        
            switch(item.item) {
                case "Price per hour rental without driver":
                    $('#extend_wod_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per hour rental with driver":
                    $('#extend_wd_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental without driver":
                    $('#extend_wod_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental with driver":
                    $('#extend_wd_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental without driver":
                    $('#extend_wod_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental with driver":
                    $('#extend_wd_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental without driver":
                    $('#extend_wod_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental with driver":
                   $('#extend_wd_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
            }
        });
       
        let contract = data.contract || {};
        let bookDetails = JSON.parse(contract.book_details_json || '{}');
        let driverDetails = JSON.parse(contract.driver_details || '{}');
        let vehicle_accessiories_details = JSON.parse(contract.vehicle_accessories_details || '{}');
        let customer_driver_attachments = JSON.parse(contract.customer_driver_attachments || '[]');
        let vehicerentoutImages = JSON.parse(contract.vehicle_rentout_images || '[]');
        // Only difference handled here
        $('#txt_contract_modal_contract_id').val(data.contract.ids || '');
        $('#txt_contract_modal_data_source').val(data.source || '');
        let rate_type = bookDetails.rate_type_id;
        let service = bookDetails.service_id;
        let duration = bookDetails.duration;
        let unit_price = bookDetails.unit_price;
        let total_amt = bookDetails.total_amt;
        let booking_notes = bookDetails.booking_notes;
        let extend_end_date = data.extend_end_date;
        let contract_status = contract.agreement_status || '';

        // Determine from date based on contract status:
        // If Extended → use latest extension end date; otherwise use contract service_end_date_time
        let rawFromDate = '';
        if (contract_status === 'Extended' && extend_end_date) {
            rawFromDate = extend_end_date;
        } else {
            rawFromDate = contract.service_end_date_time || '';
        }
        $('#extend_b_from').val(extendDbToDisplay(rawFromDate));
        $('#extend_b_to').val('');
        $('#extend_b_qtn_ref_no').val(contract.quotation_number || '');
        
        $('#extend_rate_type').val(rate_type).trigger('change');
        $('#extend_service').val(service).trigger('change');
        
        $('#extend_b_duration').val(0);
        $('#extend_price').val(0);
        $('#extend_b_vat').val(0);
        $('#extend_b_total').val(0);
        $('#extend_txt_booking_notes').val(booking_notes || '');
       
        
       updateMinPrice();
}     
function updateMinPrice() {
   
    let rateType = $('#extend_rate_type').val();
    let service = $('#extend_service').val();

    let prefix = (service === '1') ? 'extend_wod_' : 'extend_wd_';

    let selectorMap = {
        hour: prefix + 'hourly',
        day: prefix + 'daily',
        week: prefix + 'weekly',
        month: prefix + 'monthly'
    };

    let selectedId = selectorMap[rateType];
   
    if (selectedId && $('#' + selectedId).length) {
        let value = $.trim($('#' + selectedId).text());
      
        $('.extend_min-price-text').text('Min: ' + (value || '0.000'));
        $('.extend_minprice').val(value);
    } else {
        $('.extend_min-price-text').text('Min: 0.000');
        $('.extend_minprice').val(0);
    }
}

$('#extend_rate_type, #extend_service').on('change', function () {
    updateMinPrice();
});


 let DecimalPositions = 3;  
function extend_line_item_calculation()
{
   
   let from = extendDisplayToDate($('#extend_b_from').val());
   let to = extendDisplayToDate($('#extend_b_to').val());
   let rateType = $('.extend_rate_type').val();;

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

       $('#extend_b_duration').val(duration_count);

        
        let price = parseFloat($('.extend_price').val()) || 0;
        let qty = 1;
        let vat = parseFloat($('#extend_b_vat').val()) || 0;

        let total = (price * qty * duration_count) * (1 + vat/100);
      
        $('#extend_b_total').val(total.toFixed(DecimalPositions));

    }
}


$(document).on('blur','#extend_b_to',function(){
    let from = $('#extend_b_from').val();
    let to = $(this).val();

    let fromDate = extendDisplayToDate(from);
    let toDate   = extendDisplayToDate(to);

    // Only validate if BOTH dates parsed successfully
    if (fromDate && toDate && toDate < fromDate) {
        setupDropdown('dropdownContent','error', svgError + 'To date must be after from date','click');
        $(this).val('');
    }
});

// Ensure the date formatter is bound via jQuery as well (fallback for inline oninput)
$(document).on('input', '#extend_b_to, #extend_b_from', function() {
    extendFormatDateInput(this);
});


$('.extend_service').on('change', function () {

    let vatValue = $(this).find('option:selected').data('id');

    if (vatValue !== undefined) {
        $('#extend_b_vat').val(vatValue);
    }

    // optional: trigger recalculation
    $('#extend_b_vat').trigger('input');
    
    
    
  
});


$('.extend_service, .extend_rate_type, #extend_b_from, #extend_b_to, .extend_price, #extend_b_vat #extend_b_duration')
.on('input change', function () {
    otpVerified = false;
 $('#extend_otpdiv').hide();
 $('#extend_p_otp_minprice_info').text('');
    extend_line_item_calculation();
});


$(document).on('input change', '.extend_watch-field', function () {
   
   
    extend_line_item_calculation();
     
});
   

        
let laddaExtendContract = Ladda.create(
    document.querySelector('#btn_extend_contract')
);

$('#btn_extend_contract').on('click', function (e) {

saveExtendContractValidation(e);

});
function saveExtendContractValidation(e)
{
    if (e) {
        e.preventDefault();
    }

       if (!$('#extend_b_from').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide from date", 'click');
        return;
    }

    if (!$('#extend_b_to').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide to date", 'click');
        return;
    }
    
    if (new Date(extendDisplayToDate($('#extend_b_to').val())) < new Date(extendDisplayToDate($('#extend_b_from').val()))) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide valid date range", 'click');
        return;
    }

    let unitPrice = parseFloat($('#extend_price').val()) || 0;
    let minPrice = parseFloat($('.extend_minprice').val()) || 0;

    // ✅ OTP REQUIRED
    if (unitPrice < minPrice && !otpVerified) {

        let data = {
            customer: $('#extend_c_name').text().trim(),
            veh_model: $('#extend_v_model').text().trim(),
            veh_no: $('#extend_v_no').text().trim(),
            unit_price: unitPrice,
            min_price: minPrice,
            booking_ref_no: $('#agreement_ref').text().trim(),
            book_period_from: extendDisplayToDbStr($('#extend_b_from').val()),
            book_period_to: extendDisplayToDbStr($('#extend_b_to').val())
        };

        $('#otp_require_basic_details').val(JSON.stringify(data));

        $('#enableOTP').modal('show');

        return;
    }
    else
    {
         // ✅ Continue remaining validations
    proceedExtendContractValidations();
    }

   
}

function proceedExtendContractValidations()
{
     let from = extendDisplayToDate($('#extend_b_from').val());
     let to = extendDisplayToDate($('#extend_b_to').val());

    let passingDate = $('#extend_hid_nxt_passing').val();
    let insuranceDate = $('#extend_hid_nxt_insurance').val();
    let maintenanceDate =$('#extend_hid_nxt_maintenance').val();
  
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

    if (maintenanceDate && new Date(maintenanceDate) >= from && new Date(maintenanceDate) <= to) {
        showConfirm = true;
        message += '⚠️ Maintenance date falls within selected range<br>';
    }

    if (showConfirm) {

        message += '<br><b>Do you want to continue?</b>';

        $('#confirmMessage').html(message);

        new bootstrap.Modal(
            document.getElementById('customConfirmModal')
        ).show();

    } else {

        extendContract();
    }
}
$('#confirmYesBtn').on('click', function () {

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('customConfirmModal')
    );

    modal.hide();

    extendContract();

});
$('#confirmOTPYesBtn').on('click', function () {

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('customConfirmModalAfterOTPValidation')
    );

    modal.hide();

    // ✅ Continue validations after OTP success
    proceedExtendContractValidations();

});
function extendContract()
{
   laddaExtendContract.start();
    let agreement_id = $('#txt_extend_modal_agreement_id').val();
    let agreement_no = $('#txt_extend_modal_agreement_no').val();
    let booking_ids=$('#txt_extend_modal_booking_ids').val();
    let booking_nos=$('#txt_extend_modal_booking_nos').val();
    
     let customer_data = {
                customer_name: $('#extend_c_name').text().trim(),
                customer_code: $('#extend_c_code').text().trim(),
                customer_mobile: $('#extend_c_mobile').text().trim(),
                customer_email: $('#extend_c_email').text().trim(),
                customer_attention: $('#extend_c_attn').text().trim(),
                customer_address: $('#extend_c_attr').text().trim()
                };
    let vehicle_data = {
                vehicle_id: $('#extend_hid_vehicle_id').val(),
                category_id: $('#extend_hid_category_id').val(),
                model_id: $('#extend_hid_model_id').val(),
                veh_no: $('#extend_hid_vehicle_no').val(),
                category_name: $('#extend_v_category').text().trim(),
                model_name: $('#extend_v_model').text().trim(),
                vehicle_color: $('#extend_v_color').text().trim(),
                vehicle_year: $('#extend_v_year').text().trim()
                };
    let contract_details = {
                period_from: extendDisplayToDbStr($('#extend_b_from').val()),
                period_to: extendDisplayToDbStr($('#extend_b_to').val()),
                rate_type_id: $('#extend_rate_type').val(),
                rate_type: $('#extend_rate_type option:selected').text(),
                service_id: $('#extend_service').val(),
                service_name: $('#extend_service option:selected').text(),
                duration: $('#extend_b_duration').val(),
                unit_price: $('#extend_price').val(),
                min_price: $('.extend_minprice').val(),
                vat: $('#extend_b_vat').val(),
                total_amt: $('#extend_b_total').val(),
                qtn_ref_no: $('#extend_b_qtn_ref_no').val(),
                booking_notes: $('#extend_txt_booking_notes').val(),
                otp_details: $('#extend_p_otp_minprice_info').text().trim()
                
                };     
 
                $.ajax({
                    url: '/ContractListController',
                    type: 'POST',
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                
                    data: JSON.stringify({
                        action: 'extendContractGeneration',
                        agreementid: agreement_id,
                        agreement_no: agreement_no,
                        booking_ids:booking_ids,
                        booking_ref_no:booking_nos,
                        customer_data: customer_data,
                        vehicle_data: vehicle_data,
                        contract_details: contract_details,
                        service_name:$.trim($('#extend_service option:selected').text())
                       
                    }),
                
                    success: function (res) {
                        console.log(res);
                        laddaExtendContract.stop();
                       if (res.status)
                        {
                            window.__returnSuccess = true;
                            setupDropdown(
                                'dropdownContent',
                                'success',
                                svgSuccess + res.message,
                                'click'
                            );
                        
                            let modal = bootstrap.Modal.getInstance(
                                document.getElementById('extendcontractModal')
                            );
                        
                            if (modal) {
                                modal.hide();
                            }
                        searchContractList();
                            return;
                        }
                        else
                        {
                            setupDropdown(
                                'dropdownContent',
                                'error',
                                svgError + res.message,
                                'click'
                            );

                            return;
                        }
                    },
                
                    error: function (xhr) {
                        laddaExtendContract.stop();
                        console.log(xhr.responseText);
                    }
                });
        
      
}

$(document).on('input', '#modalEnableOTPPhone', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

$('#btn_otp_mobile_submit').on('click', function (e) {

    let otp_mobile = $.trim($('#modalEnableOTPPhone').val());
    let other_details = $('#otp_require_basic_details').val();

    // ❌ validation
    if (!otp_mobile) {

        setupDropdown(
            'dropdownContent',
            'error',
            svgError + ' Please enter the phone number.',
            'click'
        );

        return;
    }

    // ❌ length validation
    if (otp_mobile.length < 8) {

        setupDropdown(
            'dropdownContent',
            'error',
            svgError + ' Please enter a valid phone number.',
            'click'
        );

        return;
    }

    let enableOtpModal = document.getElementById('enableOTP');

    // ✅ wait for modal to fully close
    enableOtpModal.addEventListener('hidden.bs.modal', function handler() {

        generateAndSendOtp(otp_mobile, other_details);

        // ✅ remove listener
        enableOtpModal.removeEventListener('hidden.bs.modal', handler);

    });

    // ✅ hide modal
    let modalInstance = bootstrap.Modal.getInstance(enableOtpModal);

    if (modalInstance) {
        modalInstance.hide();
    } else {
        $('#enableOTP').modal('hide');
    }

});
function generateAndSendOtp(mobileNumber,other_details, callback) {

    $.ajax({
        url: '/GenerateOtp',
        type: 'POST',
        dataType: 'json',
        data: {
            mobile: mobileNumber
        },
        success: function (res) {

            if (res.status) {

               $('#otp_input').val(res.otpval);
               $('#txt_mobile_number_otp_send').val(mobileNumber);
                $('#applic_unit_price').val(other_details);
               $('#span_mobile_otp').text(mobileNumber);
               $('#otpModal').modal('show');
                
                
                // return OTP reference if needed
                if (callback) callback(true, res);

            } else {

                setupDropdown(
                    'dropdownContent',
                    'error',
                    svgError + ' Failed to send OTP',
                    'click'
                );

                if (callback) callback(false, res);
            }
        },
        error: function () {

            setupDropdown(
                'dropdownContent',
                'error',
                svgError + ' Server error while sending OTP',
                'click'
            );

            if (callback) callback(false, null);
        }
    });
}
$('#otpcancel').on('click', function (e) {
    $('#modalEnableOTPPhone').val('');
    $('#txt_mobile_number_otp_send').val('');
     $('#otp_input').val('');
      $('#span_mobile_otp').text('');
      $('#applic_unit_price').val('');
});
 $('#extend_otpdiv').hide();
 $('#extend_p_otp_minprice_info').text('');

$('#btn_verify_otp').on('click', function () {

    let otp_mobile_number = $('#txt_mobile_number_otp_send').val();
    let otp_code = $('#otp_input').val();

    if (!otp_code) {

        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please enter OTP',
            'click'
        );

        return;
    }

    $.ajax({

        url: '/VerifyOtp',
        type: 'POST',
        dataType: 'json',

        data: {
            mobile: otp_mobile_number,
            otp: otp_code
        },

        success: function (res) {

            
            if (res.status) {

                otpVerified = true;
            
                $('#extend_otpdiv').show();
                $('#extend_p_otp_minprice_info').text(res.info_message);
            
                $('#confirmMessageOTP').html(
                    'OTP validation completed successfully.<br><br>' +
                    '<b>Shall we proceed with contract generation?</b>'
                );
            
                // ✅ Get OTP modal instance
                let otpModalEl = document.getElementById('otpModal');
            
                // ✅ Wait until modal fully hidden
                otpModalEl.addEventListener('hidden.bs.modal', function handler() {
            
                    // ✅ Open confirmation modal
                    let confirmModalvar = new bootstrap.Modal(
                        document.getElementById('customConfirmModalAfterOTPValidation')
                    );
            
                    confirmModalvar.show();
            
                    // ✅ Remove listener after first execution
                    otpModalEl.removeEventListener('hidden.bs.modal', handler);
            
                });
            
                // ✅ Hide OTP modal
                let otpModal = bootstrap.Modal.getInstance(otpModalEl);
            
                if (otpModal) {
                    otpModal.hide();
                } else {
                    $('#otpModal').modal('hide');
                }
            }
            else {

                setupDropdown(
                    'dropdownContent',
                    'error',
                    svgError + res.message,
                    'click'
                );
            }
        }
    });
});
     
 document.querySelectorAll('.popup-buttons button').forEach(function(button) {
                    button.addEventListener('click', function() {
                      var popupOverlay = document.getElementById('popupOverlay');
                      var popupContainer = document.getElementById('popupContainer');
                      popupOverlay.style.display = 'none';
                      popupContainer.style.display = 'none';
                      // Check which button was clicked
                      if (button.classList.contains('ok')) {
                        // OK button clicked, perform action
                        var switchData = $('#message_matter').attr('data-switch-values');
                        switch (switchData) {
                           
                            case 'DeleteTerms':
                                deleteTermsAndCondition();
                            break;
                            
                            default:
                                setupDropdown('dropdownContent','error',svgSuccess+'No action defined for this message.','click');
                        }
                      } else if (button.classList.contains('cancel')) {
                        // Cancel button clicked, do nothing
                       
                        setupDropdown('dropdownContent','error',svgSuccess+'Action canceled!','click');
                      }
                    });
        });

$(document).on('click', '.btnviewSignature', function () {
    let btn = this;

    // 🔥 2. Hide tooltip (IMPORTANT)
    let tooltip = bootstrap.Tooltip.getInstance(btn);
    if (tooltip) {
        tooltip.hide();
    }
   
    let status = $(this).closest('tr').find('.status-cell span').text().trim();
    if (status === 'Cancelled') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'This booking has been cancelled. You cannot view signature for cancelled bookings.',
                'click'
            );
            return;
        
    }
    $('#signaturebook_idsModal').val($(this).data('id'));
    
    $.ajax({
        url: '/VehicleContractGeneration',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetSignDetails',
            bookingid:$(this).data('id')
        }),
        success: function (response) {

    if (response.data.length > 0) {

        let row = response.data[0];

        // =====================================
        // HIRER SIGNATURE
        // =====================================

        if (
            row.hirer_signature &&
            row.hirer_signature.trim() !== ''
        ) {

            $('#latest_hirer_signature')
                .attr('src', row.hirer_signature)
                .show();

            $('#no_hirer_signature')
                .hide();

        } else {

            $('#latest_hirer_signature')
                .hide();

            $('#no_hirer_signature')
                .show()
                .text('No Hirer Signature Applied');

        }

        $('#latest_hirer_name')
            .text(row.hirer_name || '-');

        $('#latest_hirer_date')
            .text(row.hirer_signature_date || '-');



        // =====================================
        // DELIVERY SIGNATURE
        // =====================================

        if (
            row.delivered_signature &&
            row.delivered_signature.trim() !== ''
        ) {

            $('#latest_delivery_signature')
                .attr('src', row.delivered_signature)
                .show();

            $('#no_delivery_signature')
                .hide();

        } else {

            $('#latest_delivery_signature')
                .hide();

            $('#no_delivery_signature')
                .show()
                .text('No Delivered Signature Applied');

        }

        $('#latest_delivery_name')
            .text(row.delivered_signatory || '-');

        $('#latest_delivery_date')
            .text(row.delivered_signature_date || '-');

    } else {

        // =====================================
        // NO DATA RETURNED
        // =====================================

        $('#latest_hirer_signature').hide();
        $('#no_hirer_signature')
            .show()
            .text('No Hirer Signature Applied');

        $('#latest_hirer_name').text('-');
        $('#latest_hirer_date').text('-');

        $('#latest_delivery_signature').hide();
        $('#no_delivery_signature')
            .show()
            .text('No Delivered Signature Applied');

        $('#latest_delivery_name').text('-');
        $('#latest_delivery_date').text('-');

    }
    $('#signatureModalView').modal('show');

}
       
    });
      
});

let hirerPad;
let deliveryPad;
let selectedBookingIds = [];

$(document).on('click', '.btnOpenSignatureGroup', function () {

    selectedBookingIds = [];
    $('#contractTable tbody .booking_checkbox:checked').each(function () {

        selectedBookingIds.push($(this).data('id'));

    });

    console.log(selectedBookingIds);
   

    if (selectedBookingIds.length == 0) {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please select at least one contract',
            'click'
        );

        return;


    }

   openSignatureModal();

});

$(document).on('click', '.btnOpenSignatureModal', function () {
    let books_ids= $('#signaturebook_idsModal').val();
    $.ajax({
            url: "/VehicleContractGeneration",
            type: "POST",
            contentType: "application/json",
            dataType: "json",
    
            data: JSON.stringify({
                bookingid: books_ids,
                action: "checkcontarctgenerate"
            }),
    
            success: function (response) {
    
               if (!response.status) {

                    setupDropdown(
                        'dropdownContent',
                        'error',
                        svgError + 'Please generate the contract before applying signature',
                        'click'
                    );
            
                    return;
                }
    
                    selectedBookingIds = [];
                    selectedBookingIds.push(books_ids);
                     $('#signatureModalView').modal('hide');
                     openSignatureModal();
            }
        });
    
   
});
$(document).on('click', '.btnOpenSignature', function () {
     let btn = $(this);
    let book_id = btn.data('id');
    // 🔥 2. Hide tooltip (IMPORTANT)
    let tooltip = bootstrap.Tooltip.getInstance(btn);
    if (tooltip) {
        tooltip.hide();
    }
   
    let status = $(this).closest('tr').find('.status-cell span').text().trim();
    if (status === 'Cancelled') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'This booking has been cancelled. You cannot apply signature for cancelled bookings.',
                'click'
            );
            return;
        
    }
     $.ajax({
            url: "/VehicleContractGeneration",
            type: "POST",
            contentType: "application/json",
            dataType: "json",
    
            data: JSON.stringify({
                bookingid: book_id,
                action: "checkcontarctgenerate"
            }),
    
            success: function (response) {
    
               if (!response.status) {

                    setupDropdown(
                        'dropdownContent',
                        'error',
                        svgError + 'Please generate the contract before applying signature',
                        'click'
                    );
            
                    return;
                }
    
                selectedBookingIds = [];
                selectedBookingIds.push(book_id);
    
                console.log(selectedBookingIds);
    
                openSignatureModal();
            }
        });
   
        
});
function openSignatureModal()
{
    
    
    $('#signatureModal').modal('show');
     $('#hirer_name').val('');
     $('#delivery_name').val('');
     
    setTimeout(function () {

        const hirerCanvas = document.getElementById('hirerCanvas');
        const deliveryCanvas = document.getElementById('deliveryCanvas');

        hirerCanvas.width = hirerCanvas.offsetWidth;
        hirerCanvas.height = 250;

        deliveryCanvas.width = deliveryCanvas.offsetWidth;
        deliveryCanvas.height = 250;

        hirerPad = new SignaturePad(hirerCanvas);

        deliveryPad = new SignaturePad(deliveryCanvas);
        hirerPad.clear();
        deliveryPad.clear();

    }, 300);

}

$('#btnClearHirer').click(function () {

    if (typeof hirerPad !== 'undefined' && hirerPad) {

        hirerPad.clear();

    }

});

$('#btnClearDelivery').click(function () {

    if (typeof deliveryPad !== 'undefined' && deliveryPad) {

        deliveryPad.clear();

    }

});

$('#btnSaveSignatures').click(function () {

    let hirer_name    = $.trim($('#hirer_name').val());
    let delivery_name = $.trim($('#delivery_name').val());

    let hasHirerSign    = !hirerPad.isEmpty();
    let hasDeliverySign = !deliveryPad.isEmpty();

    // At least one signature required
    if (!hasHirerSign && !hasDeliverySign) {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please provide at least one signature',
            'click'
        );

        return;
       

    }

    // Hirer signature validation
    if (hasHirerSign && hirer_name == '') {
         setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please enter hirer name',
            'click'
        );

        return;
        

    }

    // Delivery signature validation
    if (hasDeliverySign && delivery_name == '') {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please enter delivered by name',
            'click'
        );

        return;
      
    }
    let hirer_signature = '';
    
    if (
        hirerPad &&
        !hirerPad.isEmpty()
    ) {
    
        hirer_signature =
            hirerPad.toDataURL();
    
    }
    
    let delivery_signature = '';
    
    if (
        deliveryPad &&
        !deliveryPad.isEmpty()
    ) {
    
        delivery_signature =
            deliveryPad.toDataURL();
    
    }

 
    $.ajax({

        url: '/VehicleContractGeneration',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: "SaveSignature",
            selectedBookingIds: selectedBookingIds,
            hirer_name: hirer_name,
            delivery_name: delivery_name,
            hirer_signature: hirer_signature,
            delivery_signature: delivery_signature
        }),

        success: function (response) {

            if (response.status == true) {

                setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + ' Signatures saved successfully',
                'click'
            );
              
                $('#signatureModal').modal('hide');

            } else {
                    setupDropdown(
                        'dropdownContent',
                        'error',
                        svgError + response.message,
                        'click'
                    );
             

            }

        }

    });

});

$(document).on('change','.booking_checkbox',function () {

        let checkbox = $(this);

        let status = checkbox
            .closest('tr')
            .find('.status-cell span')
            .text()
            .trim();

        // =====================================
        // CANCELLED VALIDATION
        // =====================================

        if (
            status.toLowerCase() === 'cancelled'
        ) {

            checkbox.prop('checked', false);

            setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess +
                'This booking has been cancelled. You cannot select cancelled bookings.',
                'click'
            );

            return;
        }
        
         let bookingId =
            checkbox.data('id');
         $.ajax({
                url: "/VehicleContractGeneration",
                type: "POST",
                contentType: "application/json",
                dataType: "json",
            
                data: JSON.stringify({
                    bookingid: bookingId,
                    action: "checkcontarctgenerate"
                }),
            
                success: function (response) {
            
                    if (!response.status) {
            
                        // Prevent checkbox selection
                        checkbox.prop('checked', false);
            
                        // Remove from selected array if already exists
                        selectedBookingIds = selectedBookingIds.filter(
                            id => id != bookingId
                        );
            
                        setupDropdown(
                            'dropdownContent',
                            'error',
                            svgError + 'Please generate the contract for the booking and proceed with selection.',
                            'click'
                        );
            
                        return;
                    }
            
                    if (checkbox.is(':checked')) {
            
                        if (!selectedBookingIds.includes(bookingId)) {
            
                            selectedBookingIds.push(bookingId);
            
                        }
            
                    } else {
            
                        selectedBookingIds = selectedBookingIds.filter(
                            id => id != bookingId
                        );
            
                    }
            
                    console.log(selectedBookingIds);
                }
            });
        


    }
);

//Return Contract
        
let laddaReturnContract = Ladda.create(
    document.querySelector('#btn_return_contract')
);
$('#btn_return_contract').on('click', function (e) {
 let customer_code = $(this).data('customer');
saveReturnContractValidation(e,customer_code);

});
function saveReturnContractValidation(e,customer_code)
{
    if (e) {
        e.preventDefault();
    }
    if (laddaReturnContract) {
        laddaReturnContract.stop();
    }

    if (!$('#km_in').val()) {
        if (window.returnStepperInstance) window.returnStepperInstance.to(2);
        setupDropdown('dropdownContent', 'error', svgError + "Please provide km in", 'click');
        return;
    }

    if (!$('#dt_in').val()) {
        if (window.returnStepperInstance) window.returnStepperInstance.to(2);
        setupDropdown('dropdownContent', 'error', svgError + "Please provide date in", 'click');
        return;
    }

    if (!$('#chk_violations_checked').is(':checked')) {
        if (window.returnStepperInstance) window.returnStepperInstance.to(3);
        setupDropdown('dropdownContent', 'error', svgError + "Please confirm vehicle violations are checked", 'click');
        return;
    }

    if (!$.trim($('#received_by_name').val())) {
        if (window.returnStepperInstance) window.returnStepperInstance.to(4);
        setupDropdown('dropdownContent', 'error', svgError + "Please provide receiver name", 'click');
        return;
    }

    let hasReceiverSign = returnSignaturePad && !returnSignaturePad.isEmpty();
    if (!hasReceiverSign) {
        if (window.returnStepperInstance) window.returnStepperInstance.to(4);
        setupDropdown('dropdownContent', 'error', svgError + "Please provide receiver signature", 'click');
        return;
    }
    
    proceedReturnContractValidations(customer_code);
}

function proceedReturnContractValidations(customer_code)
{
    let message = '';
    let showConfirm = false;
    if (showConfirm) {

        message += '<br><b>Do you want to continue?</b>';

        $('#returnconfirmMessage').html(message);
 $('#returnconfirmYesBtn').data('customer_code', customer_code);
        new bootstrap.Modal(
            document.getElementById('returncustomConfirmModal')
        ).show();

    } else {

        returnContract(customer_code);
    }
}
$('#returnconfirmYesBtn').on('click', function () {

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('returncustomConfirmModal')
    );

    modal.hide();

     let customer_code = $(this).data('customer_code');

    returnContract(customer_code);

});

function returnContract(customer_code) {
    if (ReturncarImageQueue.length > 0) {
        laddaReturnContract.start();
        
        let formData = new FormData();
        ReturncarImageQueue.forEach((item) => {
            formData.append('car_images[]', item.file);
        });

        $.ajax({
            url: '/ReturnCompressUploadImage',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                ReturnuploadedFileNames.push(...(res.files || []));
                ReturncarImageQueue = [];
                executeReturnContract(customer_code);
            },
            error: function () {
                laddaReturnContract.stop();
                setupDropdown('dropdownContent', 'error', svgError + "Failed to upload return images.", 'click');
            }
        });
    } else {
        laddaReturnContract.start();
        executeReturnContract(customer_code);
    }
}

function executeReturnContract(customer_code)
{
   
   
    let agreement_id = $('#txt_return_modal_agreement_id').val();
    let agreement_no = $('#txt_return_modal_agreement_no').val();
    let booking_ids=$('#txt_return_modal_booking_ids').val();
    let vehicle_ids=$('#return_hid_vehicle_id').val();
    
    let return_date_in=$('#dt_in').val();
         let km_out = ($('#km_out').val() || '').trim();
         let km_in = ($('#km_in').val() || '').trim();
        
        let km_used = 0;
        
        if (km_out !== '' && km_in !== '') {
        
            km_out = parseFloat(km_out);
            km_in = parseFloat(km_in);
        
            if (!isNaN(km_out) && !isNaN(km_in) && km_in >= km_out) {
                km_used = km_in - km_out;
            }
        
        }
    const allVehicleReturnImages = ReturnexistingFileNames.concat(ReturnuploadedFileNames);
    console.log(allVehicleReturnImages);
     let receiver_name    = $.trim($('#received_by_name').val());
    
    let hasReceiverSign = returnSignaturePad && !returnSignaturePad.isEmpty();

    if (!hasReceiverSign) {
        if (laddaReturnContract) laddaReturnContract.stop();
        if (window.returnStepperInstance) window.returnStepperInstance.to(4);
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please provide receiver signature',
            'click'
        );

        return;
    }

    // Hirer signature validation
    if (receiver_name == '') {
        if (laddaReturnContract) laddaReturnContract.stop();
        if (window.returnStepperInstance) window.returnStepperInstance.to(4);
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please enter receiver name',
            'click'
        );

        return;
    }

    let cur_veh_id = $('#returncontractvehicle_ids').val() || (typeof vehicle_ids !== 'undefined' ? vehicle_ids : '');
    let cur_veh_no = $.trim($('#returncontract_vehiclenumber').text()) || $.trim($('#return_veh_no').text()) || '';

    let violations = [];
    $('#violations_tbody tr').each(function() {
        let vdate = $.trim($(this).find('.violation-date').val());
        let $titleInput = $(this).find('.violation-title');
        let title = $.trim($titleInput.val());
        let fee = $.trim($(this).find('.violation-fee').val());
        let remarks = $.trim($(this).find('.violation-remarks').val());
        let ledger_id = $titleInput.attr('data-ledger-id') || (violationHeadsMap[title] || 0);

        if (title !== '' || fee !== '' || remarks !== '' || vdate !== '') {
            violations.push({
                vehicle_id: cur_veh_id,
                vehicle_number: cur_veh_no,
                violation_date: vdate !== '' ? vdate : new Date().toISOString().split('T')[0],
                title: title,
                ledger_id: ledger_id ? parseInt(ledger_id) : 0,
                fee: fee !== '' ? parseFloat(fee) : 0,
                remarks: remarks
            });
        }
    });

   laddaReturnContract.start();
    let receiver_signature = '';
    
    if (
       returnSignaturePad &&
        !returnSignaturePad.isEmpty()
    ) {
    
        receiver_signature =
             returnSignaturePad.toDataURL();
    
    }

    let earlyReturnReductionData = null;
    if ($('#return_early_reduction_area').css('display') !== 'none' && !window.earlyReturnReductionPosted) {
        let durVal = parseFloat($('#ret_early_duration').val()) || 0;
        if (durVal > 0) {
            earlyReturnReductionData = {
                period_from: formatToDbDateTime($('#ret_early_from').val()),
                period_to: formatToDbDateTime($('#ret_early_to').val()),
                service_id: $('#ret_early_service').val(),
                service_name: $('#ret_early_service option:selected').text().trim(),
                rate_type_id: $('#ret_early_rate_type').val(),
                rate_type: $('#ret_early_rate_type option:selected').text().trim(),
                duration: $('#ret_early_duration').val(),
                unit_price: $('#ret_early_unit_price').val(),
                vat: $('#ret_early_vat').val(),
                total_amt: $('#ret_early_total').val(),
                is_zero_cost: $('#chk_early_zero_amount').is(':checked') ? 1 : 0
            };
        }
    }

    let otherFees = [];
    $('#other_fee_tbody tr').each(function() {
        let item = $.trim($(this).find('.fee-item').val() || '');
        let price = parseFloat($(this).find('.fee-price').val() || 0) || 0;
        let actualAmount = parseFloat($(this).find('.fee-actual-amount').val() || 0) || 0;
        let remarks = $.trim($(this).find('.fee-remarks').val() || '');
        if (item !== '' || price > 0 || actualAmount > 0 || remarks !== '') {
            otherFees.push({
                item: item,
                price: price,
                actual_amount: actualAmount > 0 ? actualAmount : price,
                remarks: remarks
            });
        }
    });

    let overdueExtensionData = null;
    if ($('#return_balance_extension_area').css('display') !== 'none') {
        let ovDur = parseFloat($('#ret_ext_duration').val()) || 0;
        if (ovDur > 0) {
            overdueExtensionData = {
                period_from: formatToDbDateTime($('#ret_ext_from').val()),
                period_to: formatToDbDateTime($('#ret_ext_to').val()),
                service_id: $('#ret_ext_service').val(),
                service_name: $('#ret_ext_service option:selected').text().trim(),
                rate_type_id: $('#ret_ext_rate_type').val(),
                rate_type: $('#ret_ext_rate_type option:selected').text().trim(),
                duration: $('#ret_ext_duration').val(),
                unit_price: $('#ret_ext_unit_price').val(),
                vat: $('#ret_ext_vat').val(),
                vat_amount: $('#ret_ext_vat_amount').val(),
                total_amt: $('#ret_ext_total').val(),
                is_zero_cost: $('#chk_ext_zero_amount').is(':checked') ? 1 : 0,
                waive_remarks: $.trim($('#ret_waive_remarks').val() || '')
            };
        }
    }

                $.ajax({
                    url: '/ContractListController',
                    type: 'POST',
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                
                    data: JSON.stringify({
                        action: 'returnContractGeneration',
                        agreementid: agreement_id,
                        agreement_no: agreement_no,
                        booking_ids:booking_ids,
                        vehicle_ids: vehicle_ids,
                        km_in: km_in,
                        km_used:km_used,
                        return_date_in: return_date_in,
                        return_fuel_level: ($('#return_fuel_level').val() || '').trim(),
                        return_note: ($('#return_note').val() || '').trim(),
                        return_checklist: {
                            ret_chk_tools: $('#ret_chk_tools').is(':checked') ? 'Yes' : 'No',
                            ret_chk_spare: $('#ret_chk_spare').is(':checked') ? 'Yes' : 'No',
                            ret_chk_wcup: $('#ret_chk_wcup').is(':checked') ? 'Yes' : 'No',
                            ret_chk_radio: $('#ret_chk_radio').is(':checked') ? 'Yes' : 'No',
                            ret_chk_scratches: $('#ret_chk_scratches').is(':checked') ? 'Yes' : 'No',
                            ret_chk_seats: $('#ret_chk_seats').is(':checked') ? 'Yes' : 'No',
                            ret_survey_confirmed: $('#ret_survey_confirmed').is(':checked') ? 'Yes' : 'No'
                        },
                        car_survey_in: window.CarSurveyWidget ? CarSurveyWidget.getMarks('ret_survey_in') : [],
                        returnvehicleimages: allVehicleReturnImages,
                        receiver_name:receiver_name,
                        ReceiverSign: receiver_signature,
                        customer_code:customer_code,
                        violations: violations,
                        violations_checked: $('#chk_violations_checked').is(':checked') ? 1 : 0,
                        other_fees: otherFees,
                        overdue_extension: overdueExtensionData,
                        early_return_reduction: earlyReturnReductionData
                    }),
                
                    success: function (res) {
                        console.log(res);
                        laddaReturnContract.stop();
                       if (res.status)
                        {
                            window.__returnSuccess = true;
                            setupDropdown(
                                'dropdownContent',
                                'success',
                                svgSuccess + res.message,
                                'click'
                            );
                        
                            const receiptInfo = {
                                contract_id: agreement_id || '',
                                customer_code: customer_code || '',
                                agreement_no: agreement_no || ''
                            };

                            const qpEmbed = new URLSearchParams(window.location.search).get('embed_return') === '1';
                            if (qpEmbed && window.parent && window.parent !== window) {
                                window.__pendingReceiptPrompt = receiptInfo;
                            }

                            let modal = bootstrap.Modal.getInstance(
                                document.getElementById('ReturncontractModal')
                            );
                            if (modal) {
                                modal.hide();
                            }
                            searchContractList();

                            if (!(qpEmbed && window.parent && window.parent !== window)) {
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Vehicle Returned Successfully',
                                        text: 'Do you want to generate a Receipt for agreement ' + (agreement_no || '') + '?',
                                        icon: 'success',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, Generate Receipt',
                                        cancelButtonText: 'No',
                                        confirmButtonColor: '#1b3d94',
                                        didOpen: function (popup) {
                                            const c = popup.closest('.swal2-container');
                                            if (c) c.style.setProperty('z-index', '999999', 'important');
                                        }
                                    }).then(function (result) {
                                        if (result.isConfirmed && window.ReturnReceiptModal) {
                                            window.ReturnReceiptModal.open(receiptInfo);
                                        }
                                    });
                                } else if (confirm('Vehicle returned successfully. Do you want to generate a Receipt for ' + (agreement_no || '') + '?')) {
                                    if (window.ReturnReceiptModal) window.ReturnReceiptModal.open(receiptInfo);
                                }
                            }
                            return;
                        }
                        else
                        {
                            setupDropdown(
                                'dropdownContent',
                                'error',
                                svgError + res.message,
                                'click'
                            );

                            return;
                        }
                    },
                
                    error: function (xhr) {
                        laddaReturnContract.stop();
                        console.log(xhr.responseText);
                    }
                });
        
      
}

//Get Contract Details

$(document).on('click', '#contractTable li a.view_contract_details', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     
    let status = $(this).closest('tr').find('.status-cell span').text().trim();


        $('#viewcontract_agreement_ref').text(agreement_no);
         $('#txt_viewcontract_modal_agreement_id').val(id);
         $('#txt_viewcontract_modal_agreement_no').val(agreement_no);
          $('#txt_viewcontract_modal_booking_ids').val(booking_ids);
         
        openviewcontractModal(id,vehicleid,customer_code,model_ids);
   
});

function openviewcontractModal(id,vehicleid,customer_code,model_ids) {

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            agreementid:id,vehicleid:vehicleid,customer_code:customer_code,model_ids:model_ids
        }),
        success: function (res) {
          populateviewContractModal(res);
            new bootstrap.Modal(document.getElementById('viewcontractModal')).show();
        }
    });
}
function populateviewContractModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;
 
        $('#viewcontract_c_name').text(data.customer.customer_name || '');
        $('#viewcontract_c_code').text(data.customer.customer_id || '');
        $('#viewcontract_c_mobile').text(data.customer.customer_mobile || '');
        $('#viewcontract_c_email').text(data.customer.customer_email || '');
        $('#viewcontract_c_attn').text(data.customer.customer_attn || '');
        $('#viewcontract_c_attr').text(data.customer.customer_addr || '');
         
        $('#viewcontract_v_no').text(data.vehicle.vehicle_number || '');
        $('#viewcontract_v_model').text(data.vehicle.model_names || '');
        $('#viewcontract_v_brand').text(data.vehicle.brand_name || '');
        $('#viewcontract_v_category').text(data.vehicle.category_name || '');
        $('#viewcontract_v_color').text(data.vehicle.vehicle_color || '');
        $('#viewcontract_v_year').text(data.vehicle.vehicle_year || '');
        $('#viewcontract_v_passing').text(data.vehicle.formatted_next_passing_date || '');
        $('#viewcontract_hid_nxt_passing').val(data.vehicle.next_passing_date || '');  
        $('#viewcontract_v_maintenance').text(data.vehicle.formatted_next_maintenance_date || '');
        $('#viewcontract_hid_nxt_maintenance').val(data.vehicle.next_maintenance_date || '');  
        $('#viewcontract_v_insurance').text(data.vehicle.formatted_next_insurance_date || ''); 
        $('#viewcontract_hid_nxt_insurance').val(data.vehicle.next_insurance_date || '');  
        
        
        $('#viewcontract_hid_vehicle_id').val(data.vehicle.ids || '');
        $('#viewcontract_hid_category_id').val(data.vehicle.category_id || '');
        $('#viewcontract_hid_model_id').val(data.vehicle.model_id || '');
        $('#viewcontract_hid_vehicle_no').val(data.vehicle.vehicle_number || '');
        
       
        
        
        data.price_list.forEach(function(item) {
        
            switch(item.item) {
                case "Price per hour rental without driver":
                    $('#viewcontract_wod_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per hour rental with driver":
                    $('#viewcontract_wd_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental without driver":
                    $('#viewcontract_wod_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental with driver":
                    $('#viewcontract_wd_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental without driver":
                    $('#viewcontract_wod_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental with driver":
                    $('#viewcontract_wd_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental without driver":
                    $('#viewcontract_wod_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental with driver":
                   $('#viewcontract_wd_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
            }
        });
       
        let contract = data.contract || {};
        let bookDetails = JSON.parse(contract.book_details_json || '{}');
         let driverDetails = JSON.parse(contract.driver_details || '{}');
         let vehicle_accessiories_details = JSON.parse(contract.vehicle_accessories_details || '{}');
         let customer_driver_attachments = JSON.parse(contract.customer_driver_attachments || '[]');
         let vehicerentoutImages = JSON.parse(contract.vehicle_rentout_images || '[]');
        $('#viewcontractchk_tools').prop(
            'checked',
            vehicle_accessiories_details.chk_tools && vehicle_accessiories_details.chk_tools === 'Yes'
        );
         $('#viewcontractchk_spare').prop(
            'checked',
            vehicle_accessiories_details.chk_spare && vehicle_accessiories_details.chk_spare === 'Yes'
        );
         $('#viewcontractchk_radio').prop(
            'checked',
            vehicle_accessiories_details.chk_radio && vehicle_accessiories_details.chk_radio === 'Yes'
        );
        $('#viewcontractkm_out').val(vehicle_accessiories_details.vehicle_km_out || 0);
         $('#viewcontractkm_in').val(contract.km_in || 0);
        $('#viewcontractfuel_level').val(vehicle_accessiories_details.fuel_level || '');
        
        $('#viewcontractdt_out').val(vehicle_accessiories_details.date_out || '');
        $('#viewcontractdt_in').val(contract.return_date || '');
        $('#viewcontractdt_contract_date').val(contract.agreement_date || '');
        
       $('#viewcontractcust_driver').val(contract.customer_driver_name || '');
        $('#viewcontract_agreement_status').html(typeof window.getContractStatusBadgeHtml === 'function' ? window.getContractStatusBadgeHtml(contract.agreement_status) : (contract.agreement_status || ''));
       
       $('#viewcontractcust_driver_contact_no').val(contract.customer_driver_contact_number || '');
        $('.driverclass').show(); 
     
        $('#viewcontractd_name').text(
            driverDetails.driver_name === 'Select Driver'
                ? ''
                : driverDetails.driver_name
        );
        $('#viewcontractd_mobile').text(driverDetails.driver_mobile);
        $('#viewcontractd_license_no').text(driverDetails.driver_license_no);
        $('#viewcontractd_license_issue_place').text(driverDetails.driver_license_issplace);
        $('#viewcontractd_licenseissueDate').text(driverDetails.driver_license_expdate);
        $('#viewcontractd_licenseexpiryDate').text(driverDetails.driver_license_expdate);
        let termsCondition = contract.terms_condition || '';
       fullEditorOnBody.root.innerHTML = termsCondition;
         if (
            contract.hirer_signature &&
            contract.hirer_signature.trim() !== ''
        ) {

            $('#latest_hirer_signature')
                .attr('src', contract.hirer_signature)
                .show();

            $('#no_hirer_signature')
                .hide();

        } else {

            $('#latest_hirer_signature')
                .hide();

            $('#no_hirer_signature')
                .show()
                .text('No Hirer Signature Applied');

        }

        $('#latest_hirer_name')
            .text(contract.hirer_name || '-');

        $('#latest_hirer_date')
            .text(contract.hirer_signature_date || '-');

        if (
            contract.delivered_signature &&
            contract.delivered_signature.trim() !== ''
        ) {

            $('#latest_delivery_signature')
                .attr('src', contract.delivered_signature)
                .show();

            $('#no_delivery_signature')
                .hide();

        }
        else {

            $('#latest_delivery_signature')
                .hide();

            $('#no_delivery_signature')
                .show()
                .text('No Delivered Signature Applied');

        }

        $('#latest_delivery_name')
            .text(contract.delivered_signatory || '-');

        $('#latest_delivery_date')
            .text(contract.delivered_signature_date || '-');
          if (
            contract.receiver_signature &&
            contract.receiver_signature.trim() !== ''
        ) {

            $('#latest_receiver_signature')
                .attr('src', contract.receiver_signature)
                .show();

            $('#no_receiver_signature')
                .hide();

        }else {

            $('#latest_receiver_signature')
                .hide();

            $('#no_receiver_signature')
                .show()
                .text('No Delivered Signature Applied');

        }

        $('#latest_receiver_name')
            .text(contract.receiver_name || '-');

        $('#latest_receiver_date')
            .text(contract.receiver_signature_datetime || '-');

    
$('#viewcontractcontractcustdriverdocpreview').empty();
 existingAttachments = {
    vehicles: []
};
 existingAttachments = JSON.parse(
    contract.customer_driver_attachments || '{"vehicles":[]}'
);

 bookingMaster = {
    vehicles: []
};
 carImageQueue = [];
if (
    existingAttachments.vehicles &&
    Array.isArray(existingAttachments.vehicles)
) {

    existingAttachments.vehicles.forEach(vehicle => {

         vehiclesObj = {
            documentName: vehicle.documentName || '',
            files: []
        };

        if (Array.isArray(vehicle.files)) {

            vehicle.files.forEach(fileUrl => {

                vehiclesObj.files.push(fileUrl);

                let previewSrc = getDocumentPreview(fileUrl);

                let id = 'db_' + Math.random().toString(36).substr(2, 9);

                let liHtml = `
                    <li
                        id="doc-${id}"
                        data-img="${fileUrl}"
                        data-file="${fileUrl}"
                        data-type="db"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="${vehicle.documentName}"
                        class="avatar avatar-lg pull-up position-relative">

                        <img class="rounded-circle vehicle-doc-preview"
                             src="${previewSrc}"
                             style="
                                width:70px;
                                height:70px;
                                object-fit:cover;
                                cursor:pointer;
                             " />
                    </li>
                `;

                $('#viewcontractcontractcustdriverdocpreview').append(liHtml);

            });
        }

        bookingMaster.vehicles.push(vehiclesObj);
    });
}
             $('#viewcontractpreview').empty();  
          existingVehicleImages = [];
          existingFileNames = [];
          uploadedFileNames = [];
         existingVehicleImages = JSON.parse(contract.vehicle_rentout_images || '[]');
        
        
         existingVehicleImages.forEach(img => {
             
        existingFileNames.push(img);
        let id = 'db_' + Math.random().toString(36).substr(2, 9);

        $('#viewcontractpreview').append(`
            <div class="position-relative" id="img-${id}" data-file="${img}">
                
                <img src="../uploads/rentvehicleImages/${img}" 
                     class="rounded border vehicle-preview-img"
                     data-id="${id}"
                      data-file="${img}"
                     style="width:80px;height:80px;object-fit:cover;cursor:pointer;">

                
            </div>
        `);
        
         });
        $('#viewcontractreturnpreview').empty();  
          existingVehicleImagesReturn = [];
          existingFileNamesReturn = [];
          uploadedFileNamesReturn = [];
         existingVehicleImagesReturn = JSON.parse(contract.vehicle_return_images || '[]');
        
        
         existingVehicleImagesReturn.forEach(img => {
             
        existingFileNamesReturn.push(img);
        let id = 'db_' + Math.random().toString(36).substr(2, 9);

        $('#viewcontractreturnpreview').append(`
            <div class="position-relative" id="img-${id}" data-file="${img}">
                
                <img src="../uploads/returntvehicleImages/${img}" 
                     class="rounded border vehicle-preview-img"
                     data-id="${id}"
                      data-file="${img}"
                     style="width:80px;height:80px;object-fit:cover;cursor:pointer;">

                
            </div>
        `);

    });

      listExtendedListviewcontract(data.contract.ids);
} 
  var viewcontractextensiontable;
function listExtendedListviewcontract(agreement_ids) 
{

    if ($.fn.DataTable.isDataTable('#contractviewcontractTable')) {
       $('#contractviewcontractTable').DataTable().destroy();
        $('#contractviewcontractTable tbody').empty();
    }
    
    
   viewcontractextensiontable = $('#contractviewcontractTable').DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: function () {

            return JSON.stringify({
                action: 'ListContractExtensionsReturn',
                agreementid: agreement_ids,
                vehicleid: $('#return_hid_vehicle_id').val()
            });
        },
        dataSrc: function (json) {
            if (typeof handleReturnCoverageResponse === 'function') {
                handleReturnCoverageResponse(json);
            }
            return json.data || [];
        }
    },
     dom: 't',
    columns: [

       {
            data: null,
            orderable: false,
            searchable: false,
           
            render: function (data, type, row, meta) {
        
                return `
                    <div class="d-flex align-items-center gap-2">
        
                        <span>
                            ${meta.row + 1}
                        </span>
        
                        
                    </div>
                `;
            }
        },
 
       
        {
            data: 'extension_date_format'
        },
        {
            data: null,
            render: function (data, type, row) {
                return `
                        <div>
                            <strong><small>${row.from_date_format} - ${row.to_date_format}</small>
                         </strong>
                        </div>
                        `;
               
            }
        },
       
        {
            data: null,
            render: function (data, type, row) {
                return `
                        <div>
                            <strong>${row.service_name}</strong><br>
                            <small>${row.rate_type}</small><small>, Duration: ${row.duration}</small><br>
                         <small>Min Price: ${row.min_price}</small> , Qtn Ref: ${row.qtn_ref_no}</small>
                        </div>
                        `;
                
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                return `
                        <div>
                            <strong>Total: ${row.total_amt}</strong><br>
                            <small>Unit Price: ${row.unit_price}</small><small>, VAT: ${row.duration}</small><br>
                            <small>${row.otp_details}</small>
                            
                        </div>
                        `;
                
            }
        },
       {
            data: 'booking_notes'
        }
    ]
});
    
    
}

   $('#contractviewcontractTable').on('draw.dt', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});
 $(document).on('click', '#viewcontractcontractcustdriverdocpreview li', function() {

    currentPreviewLi = $(this);

    let fileUrl = $(this).data('img');

    if (!fileUrl) return;

    let ext = fileUrl.split('.').pop().toLowerCase();

    let html = '';

    // IMAGE FILES
    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {

        html = `<img src="${fileUrl}" class="img-fluid rounded" style="max-height:70vh;">`;
    }

    // PDF FILE
    else if (ext === 'pdf') {

        html = `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
    }

    // DOC / EXCEL / PPT
    else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {

        html = `
        <iframe
            src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true"
            width="100%"
            height="600px"
            style="border:none;">
        </iframe>`;
    }

    // FALLBACK
    else {

        html = `
        <div class="alert alert-warning">
            Preview not available.
            <br>
            <a href="${fileUrl}" target="_blank" class="btn btn-primary mt-2">
                Download File
            </a>
        </div>`;
    }

    $('#filePreviewBody').html(html);

    $('#filePreviewModal').modal('show');
});


//Contract Ledger
const userRole = '<?= $_SESSION['user_role_name'] ?? '' ?>';
const currentUserId = '<?= $_SESSION['user_id'] ?? 0 ?>';
const todayStr = '<?= date('Y-m-d') ?>';
let ledgerTable = null;
$(document).on('click', '#contractTable .contract_ledger', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     
    let status = $(this).closest('tr').find('.status-cell span').text().trim();


        $('#ledger_agreement_ref').text(agreement_no);
         $('#txt_ledger_modal_agreement_id').val(id);
         $('#txt_ledger_modal_agreement_no').val(agreement_no);
          $('#txt_ledger_modal_booking_ids').val(booking_ids);
          $('#txt_ledger_modal_vehicle_ids').val(vehicleid);
          $('#txt_ledger_modal_model_ids').val(model_ids);
          $('#txt_ledger_modal_customer_code').val(customer_code);
          $('#display_agreement_no').text(agreement_no);
          
          
         let tooltip = bootstrap.Tooltip.getInstance(btn);
            if (tooltip) {
                tooltip.hide();
            }
       opencontractLedgerModal(id,vehicleid,customer_code,model_ids);
   
});

function opencontractLedgerModal(id,vehicleid,customer_code,model_ids) {

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            agreementid:id,vehicleid:vehicleid,customer_code:customer_code,model_ids:model_ids
        }),
        success: function (res) {
         populatecontractLedgerModal(res);
            new bootstrap.Modal(document.getElementById('contractLedgerModal')).show();
        }
    });
}
function populatecontractLedgerModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;
 
        $('#display_customer_name').text(data.customer.customer_name +' | '+data.customer.customer_id || '');
        $('#hid_customer_code_ledger').val(data.customer.customer_id || '');
        $('#display_mobile').text(data.customer.customer_mobile || '');
        $('#display_email').text(data.customer.customer_email || '');
       
        let contract = data.contract || {};
        $('#display_booking_ref').text(data.contract.agreement_group_ref_no || '');
        $('#display_quotation_no').text(data.contract.quotation_number || '');
        $('#txt_ledger_modal_quotation_number').val(data.contract.quotation_number);
        $('#txt_ledger_modal_booking_ref').val(data.contract.agreement_group_ref_no);
        $('.min-pricing-text').text('Min: 0.000');
        $('#txtAmounthidden').val('0');
         $('#txtAmount').val('');
        loadHeads();
        refreshLedger(data.contract.ids);
        
       
   
} 
    
        
function loadHeads(selectedName = null) {

    const $select = $('#selTransType');

    // destroy old select2
    if ($select.data('select2')) {
        $select.select2('destroy');
    }

    $.get(
        '/CustomerLedgerController',
        { action: 'GetLedgerHeadsContract' },

        function(data) {

            $select.empty();

            $select.append(
                '<option value="">Select Type</option>'
            );

            if (data.status) {

                data.data.forEach(function(head) {

                    $select.append(`
                        <option 
                            value="${head.id}"
                            data-head-type="${head.head_type}" data-ledger-type="${head.ledger_type}"
                            ${selectedName == head.id ? 'selected' : ''}
                        >
                            ${head.text}
                        </option>
                    `);

                });

                // initialize AFTER append
                $select.select2({
                    placeholder: 'Search Type',
                    width: '100%'
                });

            }

        },
        'json'
    );
}
function refreshLedger(code) {
            if ($.fn.DataTable.isDataTable('#tblLedger')) {
                $('#tblLedger').DataTable().destroy();
            }

            ledgerTable = $('#tblLedger').DataTable({
                ajax: {
                    url: '/CustomerLedgerController',
                    data: { action: 'GetContractLedgerData', contract_id: code },
                    dataSrc: function(json) {
                        let totDebit = 0, totCredit = 0;
                        json.data.forEach(r => {
                            totDebit += parseFloat(r.debit);
                            totCredit += parseFloat(r.credit);
                        });
                        $('#lblTotalDebit').text(totDebit.toFixed(3));
                        $('#lblTotalCredit').text(totCredit.toFixed(3));
                        $('#lblBalance').text((totDebit - totCredit).toFixed(3));
                        return json.data;
                    }
                },
                columns: [
                    { 
                        data: 'trans_date',
                        render: v => moment(v).format('DD-MM-YYYY')
                    },
                    { 
                        data: null, 
                        render: r => `<div class="fw-bold">${r.trans_type}</div><small class="text-muted">${r.payment_method}</small>`
                    },
                    { 
                        data: null, 
                        render: r => {
                            let out = '';
                            
                            // Top Line: Ref / Check No and Cheque Date
                            out += `<div class="fw-bold">
                                ${r.ref_no || '-'}
                                ${r.cheque_date ? `<span class="text-info fw-normal ms-2" style="font-size:11px">(${moment(r.cheque_date).format('DD-MM-YYYY')})</span>` : ''}
                            </div>`;

                            // Bank Details
                            if(r.bank_name) {
                                out += `<div style="font-size:10px" class="text-primary"><i class="ri-bank-line me-1"></i>From: ${r.bank_name} ${r.account_no ? '('+r.account_no+')' : ''}</div>`;
                            }
                            if(r.company_bank_name) {
                                out += `<div style="font-size:10px" class="text-success"><i class="ri-bank-fill me-1"></i>To: ${r.company_bank_name} ${r.company_account_no ? '('+r.company_account_no+')' : ''}</div>`;
                            }
                            
                            // Collection Details
                            if(r.cheque_status === 'Collected' && r.collected_at) {
                                out += `<div style="font-size:10px" class="text-success fw-medium"><i class="ri-checkbox-circle-line me-1"></i>Collected: ${moment(r.collected_at).format('DD-MM-YYYY')}</div>`;
                            }

                            // References (Quotation/Booking)
                            if(r.quotation_no || r.booking_no || r.agreement_no) {
                               
                                out += `<div style="font-size:10px" class="text-muted">`;

                                    if (r.agreement_no) {
                                        out += `<div><i class="ri-links-line me-1"></i>Agreement No.: ${r.agreement_no}</div>`;
                                    }
                                    
                                    if (r.booking_no) {
                                        out += `<div><i class="ri-bookmark-line me-1"></i>Booking Ref: ${r.booking_no}</div>`;
                                    }
                                    
                                    if (r.quotation_no) {
                                        out += `<div><i class="ri-file-list-line me-1"></i>Qtn Ref No: ${r.quotation_no}</div>`;
                                    }
                                    if (r.description) {
                                        out += `<div><i class="ri-file-list-line me-1"></i>Des: ${r.description}</div>`;
                                    }
                                    
                                    out += `</div>`;
                            }
                            
                            return out;
                        }
                    },
                    { data: 'debit', className: 'text-end text-danger', render: v => v > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { data: 'credit', className: 'text-end text-success', render: v => v > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { 
                        data: 'running_balance', 
                        className: 'text-end fw-bold', 
                        render: v => `<span class="${v >= 0 ? 'text-primary' : 'text-danger'}">${v.toFixed(3)}</span>`
                    },
                    {
                        data: 'ids',
                        render: (id, type, row) => {
                            const isAdmin = userRole.toLowerCase().includes('admin');
                            const isToday = moment(row.created_at).format('YYYY-MM-DD') === todayStr;
                            const canModify = true; // Enabled for all users as requested
                            
                            if(!canModify) return '';

                            let btns = `<div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-icon text-primary btn-edit" data-id="${id}" title="Edit"><span class="ri ri-edit-line ri-xl"></span></button>
                                <button type="button" class="btn btn-sm btn-icon text-danger btn-delete" data-id="${id}" title="Delete"><span class="ri ri-delete-bin-line ri-xl"></span></button>`;
                            
                            if (row.payment_method === 'Cheque') {
                                if (row.cheque_status === 'Pending') {
                                    btns += `
                                        <button class="btn btn-sm btn-icon text-success btn-status-main" data-id="${id}" data-status="Collected" title="Collect Cheque"><span class="ri ri-check-line ri-xl"></span></button>
                                        <button class="btn btn-sm btn-icon text-warning btn-status-main" data-id="${id}" data-status="Bounced" title="Bounce Cheque"><span class="ri ri-close-line ri-xl"></span></button>
                                    `;
                                } else {
                                    btns += `<button class="btn btn-sm btn-icon text-secondary btn-status-main" data-id="${id}" data-status="Pending" title="Revoke Status"><span class="ri ri-refresh-line ri-xl"></span></button>`;
                                }
                            }
                            
                            btns += `</div>`;
                            return btns;
                        }
                    }
                ],
                createdRow: function(row, data) {
                    if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                    else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
                },
                order: [[0, 'asc'], [5, 'asc']], // Sort by date then by id
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                pageLength: 25
            });
        }
        
   // Add Head Modal logic
        $('#btnAddHead').on('click', () => $('#modalAddHead').modal('show'));
        $('#frmAddHead').on('submit', function(e) {
            e.preventDefault();
            const name = $('#txtNewHeadName').val();
            const type = $('#selNewHeadType').val();
            $.post('/CustomerLedgerController', { action: 'SaveLedgerHead', head_name: name, head_type: type }, function(res) {
                if(res.status) {
                    setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess + 'Ledger Head added successfully',
                        'click'
                    );
                  
                    $('#modalAddHead').modal('hide');
                    $('#frmAddHead')[0].reset();
                    loadHeads(name);
                }
            }, 'json');
        });

        // Add Bank Modal logic
        $('#btnAddBank').on('click', () => $('#modalAddBank').modal('show'));
        $('#frmAddBank').on('submit', function(e) {
            e.preventDefault();
            const name = $('#txtNewBankName').val();
            const acc = $('#txtNewAccountNo').val();
            $.post('/CustomerLedgerController', { action: 'SaveBank', bank_name: name, account_no: acc }, function(res) {
                if(res.status) {
                     setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess + 'Bank added successfully',
                        'click'
                    );
                   
                    $('#modalAddBank').modal('hide');
                    $('#frmAddBank')[0].reset();
                    loadBanks(res.last_id); 
                }
            }, 'json');
        });
        $(document).on('input', '#txtAmount', function () {
        
            let value = $(this).val();
        
            // Allow only numbers and one decimal point
            value = value.replace(/[^0-9.]/g, '');
        
            // Prevent multiple decimal points
            value = value.replace(/(\..*?)\..*/g, '$1');
        
            $(this).val(value);
        
        });
        // Toggle Payment Method select based on type
        $('#selTransType').on('change', function() {
            const headType = $(this).find(':selected').data('head-type');
             const ledgerType = $(this).find(':selected').data('ledger-type');
             
              let model_ids = $('#txt_ledger_modal_model_ids').val();
              let head_ids = $(this).val();
               $('.min-pricing-text').text('Min: 0.000');
               $('#txtAmounthidden').val('0');
               $('#txtAmount').val('');
            if(headType === 'Debit') {
                $('#divPaymentMethod').addClass('d-none');
                $('#selPaymentMethod').val('N/A').trigger('change');
                 $('#divReference').addClass('d-none');
                 
                if(ledgerType=='Yes')
                {
                    
                     $.post('/CustomerLedgerController', { action: 'getmodel_price', model_ids: model_ids, head_ids: head_ids }, function(res) {
                          let amount = 0.000;

                            if (res.status && res.data.length > 0) {
                                amount = parseFloat(res.data[0].amount || 0).toFixed(3);
                            }
                        
                            $('#txtAmount').val(amount);

                           
                            $('.min-pricing-text').text('Min: '+amount);
                            $('#txtAmounthidden').val(amount);
                        
                       
                    }, 'json');
                }
            } else {
                $('#divPaymentMethod').removeClass('d-none');
                 $('#divReference').removeClass('d-none');
            }
        });
        
         // Handle Payment Method change for Bank visibility
        $('#selPaymentMethod').on('change', function() {
            const method = $(this).val();
            if(method === 'Cheque') {
                $('#divBank').removeClass('d-none');
                $('#divCompanyBank').removeClass('d-none');
                $('#divChequeDate').removeClass('d-none');
                $('#divReference').removeClass('col-12').addClass('col-6');
                $('#txtChequeDate').attr('required', true);
                loadBanks();
                loadCompanyBanks();
            } else if(method === 'BankTransfer') {
                $('#divBank').addClass('d-none');
                $('#divCompanyBank').removeClass('d-none');
                $('#divChequeDate').addClass('d-none');
                $('#divReference').removeClass('col-6').addClass('col-12');
                $('#txtChequeDate').attr('required', false);
                loadCompanyBanks();
            } else {
                $('#divBank').addClass('d-none');
                $('#divCompanyBank').addClass('d-none');
                $('#divChequeDate').addClass('d-none');
                $('#divReference').removeClass('col-6').addClass('col-12');
                $('#txtChequeDate').attr('required', false);
                $('#selBank').val(null).trigger('change');
                $('#selCompanyBank').val(null).trigger('change');
            }
        });

        function loadCompanyBanks(selectedId = null) {
            $.get('/CustomerLedgerController', { action: 'GetBanks' }, function(data) {
                $('#selCompanyBank').empty().append('<option value="">Select Company Bank</option>');
                if(data.status && data.data) {
                    data.data.forEach(bank => {
                        const option = new Option(`${bank.text} (${bank.account_no})`, bank.id, false, bank.id == selectedId);
                        $('#selCompanyBank').append(option);
                    });
                    $('#selCompanyBank').trigger('change');
                }
            }, 'json');
        }

        function loadBanks(selectedId = null) {
            $.get('/CustomerLedgerController', { action: 'GetBanks' }, function(data) {
                $('#selBank').empty().append('<option value="">Select Bank</option>');
                // res is already parsed if dataType is 'json'
                if(data.status && data.data) {
                    data.data.forEach(bank => {
                        const option = new Option(bank.text, bank.id, false, bank.id == selectedId);
                        $('#selBank').append(option);
                    });
                    $('#selBank').trigger('change');
                }
            }, 'json');
        }
        
    // Form Submission
        $('#frmTransaction').on('submit', function(e) {
            e.preventDefault();
            let headType = $('#selTransType option:selected').data('head-type');
            const formData = $(this).serialize() + '&quotation_no=' + $('#txt_ledger_modal_quotation_number').val() + '&booking_no=' + $('#txt_ledger_modal_booking_ref').val()+ '&customer_code=' + $('#txt_ledger_modal_customer_code').val()+ '&agreement_no=' + $('#txt_ledger_modal_agreement_no').val()+ '&agreement_id=' + $('#txt_ledger_modal_agreement_id').val()+ '&booking_id=' + $('#txt_ledger_modal_booking_ids').val()+ '&trans_name=' + $('#selTransType option:selected').text()+ '&head_type=' + headType;
            
            $.post('/CustomerLedgerController', formData, function(res) {
                if(res.status) {
                    $('#frmTransaction')[0].reset();
                    $('#txtTransId').val('');
                    $('#btnCancelEdit').addClass('d-none');
                    $('#btnSave').text('Save Transaction');
                    refreshLedger($('#txt_ledger_modal_agreement_id').val());
                    setupDropdown(
                        'dropdownContent',
                        'success',
                        svgSuccess + res.message,
                        'click'
                    );
                    
                } else {
                     setupDropdown(
                        'dropdownContent',
                        'error',
                        svgError + res.message,
                        'click'
                    );
                   
                }
            }, 'json');
        });

        // Edit Button Click
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            $.get('/CustomerLedgerController', { action: 'GetTransaction', ids: id }, function(res) {
                if(res.status && res.data.length > 0) {
                    const row = res.data[0];
                    $('#txtTransId').val(row.ids);
                    $('#txtDate').val(row.trans_date);
                    //$('#selTransType').val(row.trans_type).trigger('change');
                    $('#selTransType option').filter(function() {

                        return $(this).text().trim().toLowerCase() === 
                               row.trans_type.trim().toLowerCase();
                    
                    }).prop('selected', true);
                    
                    $('#selTransType').trigger('change');
                    $('#selPaymentMethod').val(row.payment_method).trigger('change');
                    $('#txtAmount').val(row.debit > 0 ? row.debit : row.credit);
                    $('#txtReference').val(row.ref_no);
                    $('#txtDescription').val(row.description);
                    if(row.bank_id) {
                        setTimeout(() => loadBanks(row.bank_id), 100);
                    }
                    if(row.company_bank_id) {
                        setTimeout(() => loadCompanyBanks(row.company_bank_id), 100);
                    }
                    $('#txtChequeDate').val(row.cheque_date);
                    $('#selQuotation').val(row.quotation_no);
                    $('#selBooking').val(row.booking_no);
                    
                    $('#btnSave').text('Update Transaction');
                    $('#btnCancelEdit').removeClass('d-none');
                    $('html, body').animate({ scrollTop: $('#frmTransaction').offset().top - 100 }, 500);
                }
            }, 'json');
        });

        $('#btnCancelEdit').on('click', function() {
            $('#frmTransaction')[0].reset();
            $('#txtTransId').val('');
            $('#selPaymentMethod').trigger('change');
            $('#btnCancelEdit').addClass('d-none');
            $('#btnSave').text('Save Transaction');
        });

        // Delete Button Click
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this transaction? This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/CustomerLedgerController', { action: 'DeleteTransaction', ids: id }, function(res) {
                        if(res.status) {
                            ledgerTable.ajax.reload(null, false);
                             setupDropdown(
                                    'dropdownContent',
                                    'success',
                                    svgSuccess + 'Transaction deleted successfully',
                                    'click'
                                );
                          
                        } else {
                            setupDropdown(
                                    'dropdownContent',
                                    'error',
                                    svgError + res.message,
                                    'click'
                                );
                           
                        }
                    }, 'json');
                }
            });
        });

        // Cheque Status Update from Main Table
        $(document).on('click', '.btn-status-main', function() {
            const id = $(this).data('id');
            const status = $(this).data('status');
            const msg = status === 'Pending' ? 'Revoke cheque status back to Pending?' : `Mark cheque as ${status}?`;
            
            Swal.fire({
                title: 'Are you sure?',
                text: msg,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/CustomerLedgerController', { action: 'UpdateChequeStatus', ids: id, status: status }, function(res) {
                        if(res.status) {
                            ledgerTable.ajax.reload(null, false);
                            if(calendar) calendar.refetchEvents();
                            setupDropdown(
                                    'dropdownContent',
                                    'success',
                                    svgSuccess + 'Status updated successfully',
                                    'click'
                                );
                            
                        } else {
                             setupDropdown(
                                    'dropdownContent',
                                    'error',
                                    svgError + res.message,
                                    'click'
                                );
                            
                        }
                    }, 'json');
                }
            });
        });
        
        // Initialize Notyf
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' },
            types: [
                { type: 'success', background: '#72e128', icon: { className: 'ri-checkbox-circle-fill', tagName: 'i', color: 'white' } },
                { type: 'error', background: '#ff4d49', icon: { className: 'ri-close-circle-fill', tagName: 'i', color: 'white' } }
            ]
        });

        function showToast(msg, type = 'success') {
            notyf.open({ type: type, message: msg });
        }
        
        // --- Cheque Calendar Logic ---
 let calendar = null;
let detailsTable = null;

$('#btnOpenCalendar').on('click', function() {

    $('#chequecollectioncalenderagrno')
        .text($.trim($('#txt_ledger_modal_agreement_no').val()));

    $('#chequecollectioncalenderagrid')
        .val($('#txt_ledger_modal_agreement_id').val());

    $('#modalChequeCalendar').modal('show');

    setTimeout(() => {

        if (!calendar) {
            initCalendar();
        } else {

            calendar.refetchEvents();
            calendar.render();
        }

    }, 300);

});

function initCalendar() {

    const calendarEl = document.getElementById('chequeCalendar');

    calendar = new Calendar(calendarEl, {

        plugins: [dayGridPlugin],

        initialView: 'dayGridMonth',

        contentHeight: 450,

        aspectRatio: 1.8,

        events: function(info, successCallback, failureCallback) {

            $.get('/CustomerLedgerController', {
        
                action: 'GetChequeCalendarEventsContract',
                contract_id: $('#chequecollectioncalenderagrid').val()
        
            }, function(data) {
        
                console.log(data);
        
                successCallback(data);
        
            }, 'json')
        
            .fail(function(err) {
        
                console.log(err);
        
                failureCallback(err);
        
            });
        
        },

        eventClick: function(info) {

            showChequeDetails(info.event.extendedProps.date);

        }

    });

    calendar.render();
}

// $('#modalChequeCalendar').on('shown.bs.modal', function () {

//     if (calendar) {

//         calendar.updateSize();

//     }

// });
        // $('#selCalendarCustomer').select2({
        //     dropdownParent: $('#modalChequeCalendar'),
        //     placeholder: 'Filter by Customer...',
        //     allowClear: true,
        //     ajax: {
        //         url: '/CustomerLedgerController',
        //         dataType: 'json',
        //         delay: 250,
        //         data: params => ({ q: params.term, action: 'SearchCustomer' }),
        //         processResults: data => ({ results: data.map(i => ({ id: i.customer_code, text: i.customer_name })) })
        //     }
        // }).on('change', function() {
        //     const code = $(this).val();
        //     if(code) {
        //         loadPendingSummary(code);
        //     } else {
        //         $('#divPendingSummary').addClass('d-none');
        //     }
        //     if(calendar) calendar.refetchEvents();
        // });

        function loadPendingSummary(code) {
            $.get('/CustomerLedgerController', { action: 'GetPendingCheques', customer_code: code }, function(res) {
                if(res.status && res.data.length > 0) {
                    $('#divPendingSummary').removeClass('d-none');
                    $('#pendingBadges').empty();
                    res.data.forEach(c => {
                        const dateStr = moment(c.cheque_date).format('DD MMM');
                        const amountStr = parseFloat(c.amount).toFixed(3);
                        const badge = `<span class="badge bg-label-warning border border-warning" title="Ref: ${c.ref_no}">
                            <small class="d-block text-dark" style="font-size:9px">${dateStr}</small>
                            ${amountStr}
                        </span>`;
                        $('#pendingBadges').append(badge);
                    });
                } else {
                    $('#divPendingSummary').addClass('d-none');
                }
            }, 'json');
        }

        function showChequeDetails(date) {
            $('#lblSelectedDate').text(moment(date).format('DD MMM YYYY'));
            if (detailsTable) detailsTable.destroy();

            detailsTable = $('#tblChequeDetails').DataTable({
                ajax: {
                    url: '/CustomerLedgerController',
                    data: { action: 'GetChequesByDateContract', date: date, contract_id: $('#chequecollectioncalenderagrid').val() },
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'customer_name' },
                    { data: 'ref_no' },
                    { 
                        data: 'credit', 
                        className: 'text-end fw-bold',
                        render: v => parseFloat(v).toFixed(3)
                    },
                    { 
                        data: 'cheque_status',
                        render: v => `<span class="badge ${v === 'Collected' ? 'bg-success' : (v === 'Bounced' ? 'bg-danger' : 'bg-warning')}">${v}</span>`
                    },
                    {
                        data: 'ids',
                        render: (id, type, row) => {
                            if (row.cheque_status === 'Pending') {
                                return `
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-success btn-status px-2" data-id="${id}" data-status="Collected">Collect</button>
                                        <button class="btn btn-sm btn-danger btn-status px-2" data-id="${id}" data-status="Bounced">Bounce</button>
                                    </div>
                                `;
                            } else {
                                return `<button class="btn btn-sm btn-outline-secondary btn-status" data-id="${id}" data-status="Pending"><span class="ri-refresh-line me-1"></span>Revert</button>`;
                            }
                        }
                    }
                ],
                paging: false,
                info: false,
                searching: false,
                createdRow: function(row, data) {
                    if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                    else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
                }
            });
            $('#modalChequeDetails').modal('show');
        }

        $(document).on('click', '.btn-status', function() {
            const id = $(this).data('id');
            const status = $(this).data('status');
            $.post('/CustomerLedgerController', { action: 'UpdateChequeStatus', ids: id, status: status }, function(res) {
                if(res.status) {
                    detailsTable.ajax.reload();
                    calendar.refetchEvents();
                    if(ledgerTable) ledgerTable.ajax.reload();
                    showToast('Status updated successfully', 'success');
                } else {
                    showToast(res.message, 'error');
                }
            }, 'json');
        });
        
        //Close Contract
        $(document).on('click', '#contractTable li a.close_contract_button', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     
    let status = $(this).closest('tr').find('.status-cell span').text().trim();

 $('#close_otp_require_basic_details').val('');
    if (status === 'Returned'  || status === 'Cancelled') {
        
         Swal.fire({
                title: 'Are you sure?',
                text: "You want to close the contract? ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/CustomerLedgerController', {
                            action: 'GetContractLedgerBalance',
                            contract_id: id
                        }, function(res) {
                        
                            if (!res.status) {
                                setupDropdown(
                                    'dropdownContent',
                                    'error',
                                    svgError + res.message,
                                    'click'
                                );
                                return;
                            }
                            let otpData = {
                                    balance: res.balance,
                                    total_debit: res.total_debit,
                                    total_credit: res.total_credit,
                                    agreement_no: res.agreement_no,
                                    customer_name: res.customer_name,
                                    customer_code: res.customer_code,
                                    customer_mobile: res.customer_mobile,
                                    customer_email: res.customer_email,
                                    vehicle_no: res.vehicle_no,
                                    model_name: res.model_name,
                                    service_type: res.service_type,
                                    contract_id: res.contract_id
                                    
                                };

                            $('#close_otp_require_basic_details').val(JSON.stringify(otpData));
                            console.log(JSON.stringify(otpData));
                         
                            let balance = parseFloat(res.balance || 0);
                        
                            if (balance > 0) {
                        
                                Swal.fire({
                                    title: 'Outstanding Balance Found',
                                    html: `
                                        Contract balance: <b>${balance.toFixed(3)} BHD</b><br><br>
                                        Contract closure requires OTP verification.
                                        <br>
                                        Do you want to proceed?
                                    `,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Proceed',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                        
                                    if (result.isConfirmed) {
                                      
                                    $('#closeenableOTP').modal('show');
                                      
                                    }
                        
                                });
                        
                            } else {
                        
                                // Balance is zero or negative
                                closeContract(id);
                        
                            }
                        
                        }, 'json');
                }
            });
        
    } 
    else if (status === 'Closed')
    {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'The contract status has already been marked as Closed.',
                'click'
            );
            return;
    }
    else if (status === 'Rentout' || status === 'Extended') 
    {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'Kindly return the contract and proceed with its closure.',
                'click'
            );
            return;
    }
    
    else   {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'The contract cannot be closed',
                'click'
            );
            return;
        
    } 
   
});

$(document).on('input', '#closemodalEnableOTPPhone', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

$('#close_btn_otp_mobile_submit').on('click', function (e) {

    let otp_mobile = $.trim($('#closemodalEnableOTPPhone').val());
    let other_details = $('#close_otp_require_basic_details').val();

    // ❌ validation
    if (!otp_mobile) {

        setupDropdown(
            'dropdownContent',
            'error',
            svgError + ' Please enter the phone number.',
            'click'
        );

        return;
    }

    // ❌ length validation
    if (otp_mobile.length < 8) {

        setupDropdown(
            'dropdownContent',
            'error',
            svgError + ' Please enter a valid phone number.',
            'click'
        );

        return;
    }

    let closeenableOtpModal = document.getElementById('closeenableOTP');

    // ✅ wait for modal to fully close
    closeenableOtpModal.addEventListener('hidden.bs.modal', function handler() {

        generateAndSendOtpClose(otp_mobile, other_details);

        // ✅ remove listener
        closeenableOtpModal.removeEventListener('hidden.bs.modal', handler);

    });

    // ✅ hide modal
    let modalInstance = bootstrap.Modal.getInstance(closeenableOtpModal);

    if (modalInstance) {
        modalInstance.hide();
    } else {
        $('#closeenableOTP').modal('hide');
    }

});
function generateAndSendOtpClose(mobileNumber,other_details, callback) {

    $.ajax({
        url: '/GenerateOtp',
        type: 'POST',
        dataType: 'json',
        data: {
            mobile: mobileNumber
        },
        success: function (res) {

            if (res.status) {

               $('#close_otp_input').val(res.otpval);
               $('#close_txt_mobile_number_otp_send').val(mobileNumber);
                $('#close_otp_otherdata').val(other_details);
               $('#close_span_mobile_otp').text(mobileNumber);
               $('#close_otpModal').modal('show');
                
                
                // return OTP reference if needed
                if (callback) callback(true, res);

            } else {

                setupDropdown(
                    'dropdownContent',
                    'error',
                    svgError + ' Failed to send OTP',
                    'click'
                );

                if (callback) callback(false, res);
            }
        },
        error: function () {

            setupDropdown(
                'dropdownContent',
                'error',
                svgError + ' Server error while sending OTP',
                'click'
            );

            if (callback) callback(false, null);
        }
    });
}
$('#close_otpcancel').on('click', function (e) {
    $('#closemodalEnableOTPPhone').val('');
    $('#close_txt_mobile_number_otp_send').val('');
     $('#close_otp_input').val('');
      $('#close_span_mobile_otp').text('');
      $('#close_otp_otherdata').val('');
});

$('#close_btn_verify_otp').on('click', function () {

    let otp_mobile_number = $('#close_txt_mobile_number_otp_send').val();
    let otp_code = $('#close_otp_input').val();
    let other_details=$('#close_otp_otherdata').val();
    let data = JSON.parse($('#close_otp_otherdata').val());
    
    let contract_id=data.contract_id;
    if (!otp_code) {

        setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please enter OTP',
            'click'
        );

        return;
    }

    $.ajax({

        url: '/CloseVerifyOtp',
        type: 'POST',
        dataType: 'json',

        data: {
            mobile: otp_mobile_number,
            otp: otp_code,
            other_details:other_details
        },

        success: function (res) {

            
            if (res.status) {

                otpVerified = true;
            
               
                $('#close_confirmMessageOTP').html(
                    'OTP validation completed successfully.<br><br>' +
                    '<b>Shall we proceed with contract closure?</b>'
                );
             $('#hid_contratc_id_closure').val(contract_id);
             $('#hid_close_otp_message').val(res.info_message);
                // ✅ Get OTP modal instance
                let otpModalEl = document.getElementById('close_otpModal');
            
                // ✅ Wait until modal fully hidden
                otpModalEl.addEventListener('hidden.bs.modal', function handler() {
            
                    // ✅ Open confirmation modal
                    let confirmModalvar = new bootstrap.Modal(
                        document.getElementById('close_customConfirmModalAfterOTPValidation')
                    );
            
                    confirmModalvar.show();
            
                    // ✅ Remove listener after first execution
                    otpModalEl.removeEventListener('hidden.bs.modal', handler);
            
                });
            
                // ✅ Hide OTP modal
                let otpModal = bootstrap.Modal.getInstance(otpModalEl);
            
                if (otpModal) {
                    otpModal.hide();
                } else {
                    $('#close_otpModal').modal('hide');
                }
            }
            else {

                setupDropdown(
                    'dropdownContent',
                    'error',
                    svgError + res.message,
                    'click'
                );
            }
        }
    });
});

$('#closeconfirmOTPYesBtn').on('click', function () {
let contract_id=$('#hid_contratc_id_closure').val();
let close_otp_msg=$('#hid_close_otp_message').val();

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('close_customConfirmModalAfterOTPValidation')
    );

    modal.hide();

   closeContract(contract_id,close_otp_msg);

});

function closeContract(contract_id,close_otp_msg = null)
{
   
   
    let agreement_id = $.trim(contract_id);
   
                $.ajax({
                    url: '/ContractListController',
                    type: 'POST',
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                
                    data: JSON.stringify({
                        action: 'closeContract',
                        agreementid:agreement_id,
                        close_otp_msg:close_otp_msg ?? null
                       
                    }),
                
                    success: function (res) {
                    
                       if (res.status)
                        {
                         
                            setupDropdown(
                                'dropdownContent',
                                'success',
                                svgSuccess + res.message,
                                'click'
                            );
                        
                           
                        searchContractList();
                            return;
                        }
                        else
                        {
                            setupDropdown(
                                'dropdownContent',
                                'error',
                                svgError + res.message,
                                'click'
                            );

                            return;
                        }
                    },
                
                    error: function (xhr) {
                       
                        console.log(xhr.responseText);
                    }
                });
        
      
}

// Replace
$(document).on('click', '#contractTable li a.replace_contract_btn', function (e) {

     let btn = this;

     let id = $(this).data('id'); 

     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer');
     let agreement_no = $(this).data('contract');
     let model_ids = $(this).data('model');
     let booking_ids = $(this).data('booking_id');
     
    let status = $(this).closest('tr').find('.status-cell span').text().trim();


    if (status === 'Rentout') {
        window.location.href = '/VehicleReplacement?contract_id=' + encodeURIComponent(id);
        return;
    } else {
        setupDropdown(
            'dropdownContent',
            'danger',
            svgSuccess + 'Vehicle replacement is only allowed for contracts with Rentout status.',
            'click'
        );
        return;
    } 
   
});

function openReplaceModal(id,vehicleid,customer_code,model_ids) {
    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            agreementid:id,vehicleid:vehicleid,customer_code:customer_code,model_ids:model_ids
        }),
        success: function (res) {
            populatereplaceContractModal(res);
            new bootstrap.Modal(document.getElementById('ReplacecontractModal')).show();
        }
    });
}

function populatereplaceContractModal(d) {
    let data = (typeof d === "string") ? JSON.parse(d) : d;
    data = data || {};
    let customer = data.customer || {};
    let vehicle = data.vehicle || {};
    let contract = data.contract || {};

    $('#replace_c_name').text(customer.customer_name || '');
    $('#replace_c_code').text(customer.customer_id || '');
    $('#replace_c_mobile').text(customer.customer_mobile || '');
    $('#replace_c_email').text(customer.customer_email || '');
    $('#replace_c_attn').text(customer.customer_attn || '');
    $('#replace_c_attr').text(customer.customer_addr || '');
    
    $('#replace_v_no').text(vehicle.vehicle_number || '');
    $('#replace_v_model').text(vehicle.model_names || '');
    $('#replace_v_brand').text(vehicle.brand_name || '');
    $('#replace_v_category').text(vehicle.category_name || '');
    $('#replace_v_color').text(vehicle.vehicle_color || '');
    $('#replace_v_year').text(vehicle.vehicle_year || '');
    $('#replace_v_passing').text(vehicle.formatted_next_passing_date || '');
    $('#replace_v_maintenance').text(vehicle.formatted_next_maintenance_date || '');
    $('#replace_v_insurance').text(vehicle.formatted_next_insurance_date || '');

    $('#replace_old_hid_vehicle_id').val(vehicle.ids || '');
    $('#replace_old_hid_category_id').val(vehicle.category_id || '');
    $('#replace_old_hid_model_id').val(vehicle.model_id || '');
    $('#replace_old_hid_vehicle_no').val(vehicle.vehicle_number || '');
    $('#badge_old_veh_no').text(vehicle.vehicle_number || '');

    let vehicle_accessiories_details = {};
    if (contract && contract.vehicle_accessories_details) {
        try { vehicle_accessiories_details = JSON.parse(contract.vehicle_accessories_details || '{}'); } catch(e) {}
    }

    // Checkboxes old vehicle
    $('#chk_replace_old_tools').prop('checked', vehicle_accessiories_details.chk_tools === 'Yes' || vehicle_accessiories_details.chk_tools === true);
    $('#chk_replace_old_spare').prop('checked', vehicle_accessiories_details.chk_spare === 'Yes' || vehicle_accessiories_details.chk_spare === true);
    $('#chk_replace_old_radio').prop('checked', vehicle_accessiories_details.chk_radio === 'Yes' || vehicle_accessiories_details.chk_radio === true);

    // Metrics old vehicle
    let oldKmOutVal = parseFloat(contract.km_out) || parseFloat(vehicle_accessiories_details.vehicle_km_out) || parseFloat(vehicle.odo_meter) || 0;
    let oldKmInVal = (contract.km_in !== undefined && contract.km_in !== null && contract.km_in !== '') ? contract.km_in : '';
    $('#replace_old_km_out').val(oldKmOutVal);
    $('#replace_old_km_in').val(oldKmInVal);
    if (oldKmInVal !== '') {
        let kmInNum = parseFloat(oldKmInVal) || 0;
        $('#replace_old_km_used').val(Math.max(0, kmInNum - oldKmOutVal));
    } else {
        $('#replace_old_km_used').val('');
    }

    $('#replace_old_fuel_in').val(vehicle_accessiories_details.fuel_level || vehicle.fuel_level || '');
    
    let dtOutVal = vehicle_accessiories_details.date_out || vehicle_accessiories_details.vehicle_date_out || contract.date_out || '';
    if (dtOutVal) {
        dtOutVal = dtOutVal.replace(' ', 'T');
        if (dtOutVal.length > 16) {
            dtOutVal = dtOutVal.slice(0, 16);
        }
    }
    $('#replace_old_dt_out').val(dtOutVal);

    let dtInVal = (contract.date_in && contract.date_in !== '0000-00-00 00:00:00') ? contract.date_in.replace(' ', 'T').slice(0, 16) : getAsiaBahrainNowISO();
    $('#replace_old_dt_in').val(dtInVal);

    // Old vehicle rentout images preview (from tbl_vehicle_rentout_contracts)
    $('#replace_old_preview').empty();
    let existingVehicleImages = [];
    if (contract && contract.vehicle_rentout_images) {
        let rawImgs = contract.vehicle_rentout_images;
        if (typeof rawImgs === 'string') {
            try {
                let parsed = JSON.parse(rawImgs);
                if (typeof parsed === 'string') {
                    try { parsed = JSON.parse(parsed); } catch(e2) {}
                }
                if (Array.isArray(parsed)) {
                    existingVehicleImages = parsed;
                } else if (typeof parsed === 'string') {
                    existingVehicleImages = parsed.split(',');
                }
            } catch(e) {
                if (rawImgs.includes(',')) {
                    existingVehicleImages = rawImgs.split(',');
                } else if (rawImgs.trim() !== '') {
                    existingVehicleImages = [rawImgs.trim()];
                }
            }
        } else if (Array.isArray(rawImgs)) {
            existingVehicleImages = rawImgs;
        }
    }

    if (Array.isArray(existingVehicleImages) && existingVehicleImages.length > 0) {
        existingVehicleImages.forEach(img => {
            img = (typeof img === 'string') ? $.trim(img.replace(/[\[\]\\"]/g, '')) : '';
            if (img) {
                $('#replace_old_preview').append(`
                    <div class="position-relative">
                        <img src="../uploads/rentvehicleImages/${img}" class="rounded border vehicle-preview-img" style="width:75px;height:75px;object-fit:cover;cursor:pointer;" title="View Full Image">
                    </div>
                `);
            }
        });
    } else {
        $('#replace_old_preview').html('<small class="text-muted fst-italic">No rentout images found</small>');
    }

    // Clear return preview for old vehicle & new vehicle
    $('#replace_old_return_preview').empty();
    $('#replace_new_preview').empty();
    oldVehicleReturnUploadedImages = [];
    newVehicleRentoutUploadedImages = [];

    // Clear & Load Violations for old vehicle
    $('#replace_violations_tbody').empty();
    $('#chk_replace_violations_checked').prop('checked', false);

    let existingViolations = [];
    if (contract && contract.violations_json) {
        if (typeof contract.violations_json === 'string') {
            try { existingViolations = JSON.parse(contract.violations_json); } catch(e) {}
        } else if (Array.isArray(contract.violations_json)) {
            existingViolations = contract.violations_json;
        }
    }
    if (Array.isArray(existingViolations) && existingViolations.length > 0) {
        existingViolations.forEach(function(v) {
            if (v) {
                addReplaceViolationRow(v.violation_date || v.date || '', v.title || '', v.fee || '', v.remarks || '');
            }
        });
    }

    if ($.fn.select2 && $('#replace_select_new_vehicle').hasClass('select2-hidden-accessible')) {
        $('#replace_select_new_vehicle').val('').trigger('change.select2');
    } else {
        $('#replace_select_new_vehicle').val('');
    }
    $('#replace_new_veh_card').addClass('d-none');
    $('#chk_replace_new_tools').prop('checked', false);
    $('#chk_replace_new_spare').prop('checked', false);
    $('#chk_replace_new_radio').prop('checked', false);
    $('#replace_new_km_out').val('');
    $('#replace_new_fuel_out').val('');
    $('#replace_new_dt_out').val(getAsiaBahrainNowISO());
    let sessionStaffName = '<?php echo htmlspecialchars($_SESSION['profile_name'] ?? $_SESSION['user_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>';
    $('#replace_staff_name').val(sessionStaffName);
    if (replaceStaffSignaturePad) {
        replaceStaffSignaturePad.clear();
    }

    loadViolationHeadsList();
    loadAvailableVehiclesList(vehicle.category_id || vehicle.vehicle_category_id || vehicle.category_name || $('#replace_v_category').text().trim() || '');
    listExtendedListReplace(contract.ids);
}
  var replaceextensiontable;
function listExtendedListReplace(agreement_ids) 
{

    if ($.fn.DataTable.isDataTable('#contractReplaceTable')) {
       $('#contractReplaceTable').DataTable().destroy();
        $('#contractReplaceTable tbody').empty();
    }
    
    
   replaceextensiontable = $('#contractReplaceTable').DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: function () {

            return JSON.stringify({
                action: 'ListContractExtensionsReturn',
                agreementid: agreement_ids,
                vehicleid: $('#return_hid_vehicle_id').val()
            });
        },
        dataSrc: function (json) {
            if (typeof handleReturnCoverageResponse === 'function') {
                handleReturnCoverageResponse(json);
            }
            return json.data || [];
        }
    },
     dom: 't',
    columns: [

       {
            data: null,
            orderable: false,
            searchable: false,
           
            render: function (data, type, row, meta) {
        
                return `
                    <div class="d-flex align-items-center gap-2">
        
                        <span>
                            ${meta.row + 1}
                        </span>
        
                        
                    </div>
                `;
            }
        },
 
       
        {
            data: 'extension_date_format'
        },
        {
            data: null,
            render: function (data, type, row) {
                return `
                        <div>
                            <strong><small>${row.from_date_format} - ${row.to_date_format}</small>
                         </strong>
                        </div>
                        `;
               
            }
        },
       
        {
            data: null,
            render: function (data, type, row) {
                return `
                        <div>
                            <strong>${row.service_name}</strong><br>
                            <small>${row.rate_type}</small><small>, Duration: ${row.duration}</small><br>
                         <small>Min Price: ${row.min_price}</small> , Qtn Ref: ${row.qtn_ref_no}</small>
                        </div>
                        `;
                
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                return `
                        <div>
                            <strong>Total: ${row.total_amt}</strong><br>
                            <small>Unit Price: ${row.unit_price}</small><small>, VAT: ${row.duration}</small><br>
                            <small>${row.otp_details}</small>
                            
                        </div>
                        `;
                
            }
        },
       {
            data: 'booking_notes'
        }
    ]
});
    
    
}

   $('#contractReplaceTable').on('draw.dt', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});



// let currentVehiclePreviewId = null;



// $(document).on('click', '.vehicle-preview-img', function () {

//     let id  = $(this).data('id');
//     let src = $(this).attr('src'); // safer than data-src

//     currentVehiclePreviewId = id;

//     // clear previous content (important)
//     $('#VehiclefilePreviewBody').empty().html(`
//         <img src="${src}" 
//              class="img-fluid rounded shadow" 
//              style="max-height:70vh;">
//     `);

//     let modalEl = document.getElementById('imagePreviewModal');

//     let modal = bootstrap.Modal.getInstance(modalEl);
//     if (!modal) {
//         modal = new bootstrap.Modal(modalEl);
//     }

//     modal.show();
// });

// --- REPLACE VEHICLE HANDLERS ---
var availableParkingVehicles = [];

function loadAvailableVehiclesList(categoryId) {
    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'getAvailableVehicles',
            category_id: categoryId || ''
        }),
        dataType: 'json',
        success: function(res) {
            if (res && res.status && Array.isArray(res.data)) {
                availableParkingVehicles = res.data;
                let optionsHtml = '<option value="">-- Select Replacement Vehicle --</option>';
                res.data.forEach(function(veh) {
                    let catModel = (veh.category_name || '') + ' ' + (veh.model_name || '');
                    optionsHtml += `<option value="${veh.ids}">${veh.vehicle_number} - ${catModel} (${veh.vehicle_color || ''})</option>`;
                });
                let $sel = $('#replace_select_new_vehicle');
                $sel.html(optionsHtml);

                if ($.fn.select2) {
                    if ($sel.hasClass('select2-hidden-accessible')) {
                        $sel.select2('destroy');
                    }
                    $sel.select2({
                        dropdownParent: $('#ReplacecontractModal'),
                        placeholder: '-- Select Replacement Vehicle --',
                        allowClear: true,
                        width: '100%'
                    });
                }
            }
        }
    });
}

$(document).on('change select2:select select2:clear', '#replace_select_new_vehicle', function() {
    let vehId = $(this).val();
    if (!vehId) {
        $('#replace_new_veh_card').addClass('d-none');
        $('#replace_new_km_out').val('');
        $('#replace_new_fuel_out').val('');
        return;
    }

    let selected = availableParkingVehicles.find(v => String(v.ids) === String(vehId));
    if (selected) {
        $('#replace_new_veh_card').removeClass('d-none');
        $('#replace_new_v_no').text(selected.vehicle_number || '-');
        let titleStr = (selected.model_name || selected.category_name || '-').toUpperCase();
        $('#replace_new_v_title').text(titleStr);
        $('#replace_new_v_category').text(selected.category_name || '-');
        $('#replace_new_v_model').text(selected.model_name || '-');
        $('#replace_new_v_color').text(selected.vehicle_color || '-');
        $('#replace_new_v_year').text(selected.manufacture_year || selected.vehicle_year || '-');
        $('#replace_new_v_fuel').text(selected.fuel_type || 'Petrol');
        $('#replace_new_v_fuel_level').text(selected.fuel_level || '-');
        $('#replace_new_v_gear').text(selected.gear_type || 'Automatic');
        $('#replace_new_v_chassis').text(selected.chassis_number || 'N/A');

        let status = selected.vehicle_status || 'Available';
        $('#replace_new_v_status').text(status);

        // Status badge color
        if (typeof window.applyVehicleStatusBadge === 'function') {
            window.applyVehicleStatusBadge('#replace_new_v_status_badge', status);
        } else {
            $('#replace_new_v_status_badge').text(status).attr('class', 'badge bg-secondary');
        }

        $('#replace_new_v_passing').text(selected.next_passing_date || 'NA');
        $('#replace_new_v_insurance').text(selected.next_insurance_date || 'NA');
        $('#replace_new_v_maintenance').text(selected.next_maintenance_date || 'NA');

        let imgSrc = 'uploads/vehicleImages/default.png';
        if (selected.last_image) {
            imgSrc = 'uploads/vehicleImages/' + $.trim(selected.last_image);
        } else if (selected.vehicle_images) {
            try {
                let imgs = typeof selected.vehicle_images === 'string' ? JSON.parse(selected.vehicle_images) : selected.vehicle_images;
                if (Array.isArray(imgs) && imgs.length > 0) {
                    imgSrc = 'uploads/vehicleImages/' + $.trim(imgs[imgs.length - 1]);
                }
            } catch(e) {}
        }
        $('#replace_new_v_img').attr('src', imgSrc);
        $('#replace_new_v_view_btn').attr('data-id', selected.ids).data('id', selected.ids);

        $('#replace_new_km_out').val(selected.odo_meter || 0);
        $('#replace_new_fuel_out').val(selected.fuel_level || '');
        $('#replace_new_dt_out').val(getAsiaBahrainNowISO());
    }
});

// Replace Contract Modal Image Upload Queues & Handlers
let replaceOldReturnImageQueue = [];
let replaceNewRentoutImageQueue = [];

// 1. Old Vehicle Return Images Selection / Camera & Preview
$(document).on('change', '#replace_old_return_car_images', function(e) {
    $('#replace_old_return_progressBar').css('width', '0%').removeClass('bg-success bg-danger');
    let files = e.target.files;
    Array.from(files).forEach(file => {
        let id = 'old_ret_' + Date.now() + Math.random().toString(36).substr(2, 5);
        replaceOldReturnImageQueue.push({ id: id, file: file });

        let reader = new FileReader();
        reader.onload = function(evt) {
            $('#replace_old_return_preview').append(`
                <div class="position-relative me-1 mb-1" id="img-${id}">
                    <img src="${evt.target.result}" class="rounded border vehicle-preview-img" style="width:75px;height:75px;object-fit:cover;cursor:pointer;">
                    <span class="btn-remove-replace-old-img" data-id="${id}" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:white;border-radius:50%;padding:1px 5px;cursor:pointer;font-size:11px;line-height:1;" title="Remove image">✕</span>
                </div>
            `);
        };
        reader.readAsDataURL(file);
    });
    $(this).val('');
});

$(document).on('click', '.btn-remove-replace-old-img', function() {
    let id = $(this).attr('data-id');
    replaceOldReturnImageQueue = replaceOldReturnImageQueue.filter(item => item.id !== id);
    $(`#img-${id}`).remove();
});

function uploadReplaceOldReturnImages() {
    return new Promise((resolve, reject) => {
        if (replaceOldReturnImageQueue.length === 0) {
            resolve();
            return;
        }

        let formData = new FormData();
        replaceOldReturnImageQueue.forEach(item => {
            formData.append('car_images[]', item.file);
        });

        $.ajax({
            url: '/ReturnCompressUploadImage',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                let uploaded = res.files || [];
                oldVehicleReturnUploadedImages.push(...uploaded);
                replaceOldReturnImageQueue = [];
                resolve();
            },
            error: function() {
                reject('Failed to upload old vehicle return images.');
            }
        });
    });
}

// 2. New Replacement Vehicle Rentout Images Selection / Camera & Preview
$(document).on('change', '#replace_new_car_images', function(e) {
    $('#replace_new_progressBar').css('width', '0%').removeClass('bg-success bg-danger');
    let files = e.target.files;
    Array.from(files).forEach(file => {
        let id = 'new_rent_' + Date.now() + Math.random().toString(36).substr(2, 5);
        replaceNewRentoutImageQueue.push({ id: id, file: file });

        let reader = new FileReader();
        reader.onload = function(evt) {
            $('#replace_new_preview').append(`
                <div class="position-relative me-1 mb-1" id="img-${id}">
                    <img src="${evt.target.result}" class="rounded border vehicle-preview-img" style="width:75px;height:75px;object-fit:cover;cursor:pointer;">
                    <span class="btn-remove-replace-new-img" data-id="${id}" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:white;border-radius:50%;padding:1px 5px;cursor:pointer;font-size:11px;line-height:1;" title="Remove image">✕</span>
                </div>
            `);
        };
        reader.readAsDataURL(file);
    });
    $(this).val('');
});

$(document).on('click', '.btn-remove-replace-new-img', function() {
    let id = $(this).attr('data-id');
    replaceNewRentoutImageQueue = replaceNewRentoutImageQueue.filter(item => item.id !== id);
    $(`#img-${id}`).remove();
});

function uploadReplaceNewRentoutImages() {
    return new Promise((resolve, reject) => {
        if (replaceNewRentoutImageQueue.length === 0) {
            resolve();
            return;
        }

        let formData = new FormData();
        replaceNewRentoutImageQueue.forEach(item => {
            formData.append('car_images[]', item.file);
        });

        $.ajax({
            url: '/CompressUploadImage',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                let uploaded = res.files || [];
                newVehicleRentoutUploadedImages.push(...uploaded);
                replaceNewRentoutImageQueue = [];
                resolve();
            },
            error: function() {
                reject('Failed to upload replacement vehicle images.');
            }
        });
    });
}

$(document).on('input', '#replace_old_km_in', function() {
    let kmOut = parseFloat($('#replace_old_km_out').val()) || 0;
    let kmIn = parseFloat($(this).val()) || 0;
    let used = kmIn >= kmOut ? (kmIn - kmOut) : 0;
    $('#replace_old_km_used').val(used.toFixed(0));
});

function getAsiaBahrainNowISO() {
    try {
        return new Date().toLocaleString('sv-SE', { timeZone: 'Asia/Bahrain' }).replace(' ', 'T').slice(0, 16);
    } catch(e) {
        let now = new Date();
        return now.getFullYear() + '-' +
            String(now.getMonth() + 1).padStart(2, '0') + '-' +
            String(now.getDate()).padStart(2, '0') + 'T' +
            String(now.getHours()).padStart(2, '0') + ':' +
            String(now.getMinutes()).padStart(2, '0');
    }
}

function getAsiaBahrainDateISO() {
    try {
        return new Date().toLocaleString('sv-SE', { timeZone: 'Asia/Bahrain' }).split(' ')[0];
    } catch(e) {
        let now = new Date();
        return now.getFullYear() + '-' +
            String(now.getMonth() + 1).padStart(2, '0') + '-' +
            String(now.getDate()).padStart(2, '0');
    }
}

function addReplaceViolationRow(vdate, title, fee, remarks) {
    vdate = vdate || getAsiaBahrainDateISO();
    title = title || '';
    fee = fee || '';
    remarks = remarks || '';
    let rowCount = $('#replace_violations_tbody tr').length + 1;
    let $row = $(`
        <tr>
            <td class="text-center align-middle row-num">${rowCount}</td>
            <td>
                <input type="date" class="form-control form-control-sm violation-date" value="${vdate}">
            </td>
            <td>
                <input type="text" list="violation_heads_list" class="form-control form-control-sm violation-title" placeholder="Search / select violation title" value="${title}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm violation-fee" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0.000" value="${fee}">
            </td>
            <td>
                <textarea class="form-control form-control-sm violation-remarks" rows="2" placeholder="Enter remarks">${remarks}</textarea>
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-replace-violation px-2 py-1" title="Remove Violation">
                    <i class="ri ri-delete-bin-line fs-5"></i>
                </button>
            </td>
        </tr>
    `);
    $('#replace_violations_tbody').append($row);
    renumberReplaceViolationRows();
}

function renumberReplaceViolationRows() {
    $('#replace_violations_tbody tr').each(function(idx) {
        $(this).find('.row-num').text(idx + 1);
    });
}

$(document).on('click', '#btn_replace_add_violation_row', function() {
    addReplaceViolationRow();
});

$(document).on('click', '.btn-remove-replace-violation', function() {
    $(this).closest('tr').remove();
    renumberReplaceViolationRows();
});

$(document).on('click', '#btn_replace_add_violation_head_master', function() {
    $('#new_violation_head_name').val('');
    $('#modalAddViolationHead').modal('show');
    setTimeout(function() {
        $('#new_violation_head_name').focus();
    }, 400);
});

$(document).on('click', '#btn_replace_next_step', function() {
    let oldKmOut = parseFloat($('#replace_old_km_out').val()) || 0;
    let oldKmInRaw = $.trim($('#replace_old_km_in').val());
    if (oldKmInRaw === '') {
        setupDropdown('dropdownContent', 'error', svgError + 'Please enter KM In for the current vehicle.', 'click');
        return;
    }
    let oldKmIn = parseFloat(oldKmInRaw);
    if (isNaN(oldKmIn) || oldKmIn < oldKmOut) {
        setupDropdown('dropdownContent', 'error', svgError + 'KM In for current vehicle must be greater than or equal to KM Out (' + oldKmOut + ').', 'click');
        return;
    }

    let hasViolations = $('#replace_violations_tbody tr').length > 0;
    if (hasViolations && !$('#chk_replace_violations_checked').is(':checked')) {
        setupDropdown('dropdownContent', 'error', svgError + 'Please confirm checking traffic violations by checking the checkbox.', 'click');
        return;
    }

    if (replaceStepper) {
        replaceStepper.next();
    }
});

$(document).on('click', '#btn_replace_prev_step', function() {
    if (replaceStepper) {
        replaceStepper.previous();
    }
});

$(document).on('click', '#btn_submit_replace_contract', function() {
    let agreementId = $('#txt_replace_modal_agreement_id').val();
    let agreementNo = $('#txt_replace_modal_agreement_no').val();
    let newVehId = $('#replace_select_new_vehicle').val();

    if (!newVehId) {
        setupDropdown('dropdownContent', 'error', svgError + 'Please select a replacement vehicle.', 'click');
        return;
    }

    let oldKmOut = parseFloat($('#replace_old_km_out').val()) || 0;
    let oldKmInRaw = $.trim($('#replace_old_km_in').val());
    if (oldKmInRaw === '') {
        setupDropdown('dropdownContent', 'error', svgError + 'Please enter KM In for the current vehicle.', 'click');
        return;
    }
    let oldKmIn = parseFloat(oldKmInRaw);
    if (isNaN(oldKmIn) || oldKmIn < oldKmOut) {
        setupDropdown('dropdownContent', 'error', svgError + 'KM In for current vehicle must be greater than or equal to KM Out (' + oldKmOut + ').', 'click');
        return;
    }

    let hasViolations = $('#replace_violations_tbody tr').length > 0;
    if (hasViolations && !$('#chk_replace_violations_checked').is(':checked')) {
        setupDropdown('dropdownContent', 'error', svgError + 'Please confirm checking traffic violations by checking the checkbox.', 'click');
        return;
    }

    let oldVehNo = $('#replace_old_hid_vehicle_no').val();
    let oldVehId = $('#replace_old_hid_vehicle_id').val();
    let oldKmUsed = parseFloat($('#replace_old_km_used').val()) || (oldKmIn - oldKmOut);
    let oldFuelIn = $('#replace_old_fuel_in').val();
    let oldDtIn = $('#replace_old_dt_in').val();

    let oldAccessories = {
        chk_tools: $('#chk_replace_old_tools').is(':checked') ? 'Yes' : 'No',
        chk_spare: $('#chk_replace_old_spare').is(':checked') ? 'Yes' : 'No',
        chk_radio: $('#chk_replace_old_radio').is(':checked') ? 'Yes' : 'No'
    };

    let violations = [];
    $('#replace_violations_tbody tr').each(function() {
        let vdate = $.trim($(this).find('.violation-date').val());
        let $titleInput = $(this).find('.violation-title');
        let title = $.trim($titleInput.val());
        let fee = $.trim($(this).find('.violation-fee').val());
        let remarks = $.trim($(this).find('.violation-remarks').val());
        let ledger_id = $titleInput.attr('data-ledger-id') || (typeof violationHeadsMap !== 'undefined' && violationHeadsMap[title] ? violationHeadsMap[title] : 0);

        if (title !== '' || fee !== '' || remarks !== '' || vdate !== '') {
            violations.push({
                vehicle_id: oldVehId,
                vehicle_number: oldVehNo,
                violation_date: vdate !== '' ? vdate : new Date().toISOString().split('T')[0],
                title: title,
                ledger_id: ledger_id ? parseInt(ledger_id) : 0,
                fee: fee !== '' ? parseFloat(fee) : 0,
                remarks: remarks
            });
        }
    });

    let selectedNew = availableParkingVehicles.find(v => String(v.ids) === String(newVehId)) || {};
    let newKmOut = parseFloat($('#replace_new_km_out').val()) || parseFloat(selectedNew.odo_meter) || 0;
    let newFuelOut = $('#replace_new_fuel_out').val() || selectedNew.fuel_level || '';
    let newDtOut = $('#replace_new_dt_out').val();

    let newAccessories = {
        chk_tools: $('#chk_replace_new_tools').is(':checked') ? 'Yes' : 'No',
        chk_spare: $('#chk_replace_new_spare').is(':checked') ? 'Yes' : 'No',
        chk_radio: $('#chk_replace_new_radio').is(':checked') ? 'Yes' : 'No'
    };

    let staffName = $.trim($('#replace_staff_name').val());
    if (staffName === '') {
        setupDropdown('dropdownContent', 'error', svgError + 'Please enter the name of the responsible staff.', 'click');
        return;
    }

    if (!replaceStaffSignaturePad || replaceStaffSignaturePad.isEmpty()) {
        setupDropdown('dropdownContent', 'error', svgError + 'Please provide the signature of the responsible staff.', 'click');
        return;
    }
    let staffSignature = replaceStaffSignaturePad.toDataURL();

    let payload = {
        action: 'replaceContractGeneration',
        agreementid: agreementId,
        agreement_no: agreementNo,
        old_vehicle_id: oldVehId,
        old_vehicle_no: oldVehNo,
        old_km_in: oldKmIn,
        old_km_used: oldKmUsed,
        old_fuel_in: oldFuelIn,
        old_dt_in: oldDtIn,
        old_accessories: oldAccessories,
        old_return_images: oldVehicleReturnUploadedImages,
        violations: violations,
        new_vehicle_id: newVehId,
        new_vehicle_no: selectedNew.vehicle_number || '',
        new_category_id: selectedNew.vehicle_category_id || '',
        new_model_id: selectedNew.vehicle_model_id || '',
        new_km_out: newKmOut,
        new_fuel_out: newFuelOut,
        new_dt_out: newDtOut,
        new_accessories: newAccessories,
        new_rentout_images: newVehicleRentoutUploadedImages,
        replace_remarks: $('#replace_remarks').val(),
        staff_name: staffName,
        staff_signature: staffSignature
    };

    let $btn = $(this);
    $btn.prop('disabled', true);

    // Upload both image queues first, then submit
    Promise.all([uploadReplaceOldReturnImages(), uploadReplaceNewRentoutImages()])
        .then(function() {
            // Update payload with freshly uploaded images
            payload.old_return_images = oldVehicleReturnUploadedImages;
            payload.new_rentout_images = newVehicleRentoutUploadedImages;

            $.ajax({
                url: '/ContractListController',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',
                success: function(res) {
                    $btn.prop('disabled', false);
                    if (res && res.status) {
                        let modalEl = document.getElementById('ReplacecontractModal');
                        let modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        setupDropdown('dropdownContent', 'success', svgSuccess + (res.message || 'Vehicle replaced successfully!'), 'click');
                        if (typeof table !== 'undefined' && table.ajax) {
                            table.ajax.reload(null, false);
                        }
                    } else {
                        setupDropdown('dropdownContent', 'error', svgError + (res.message || 'Failed to replace vehicle'), 'click');
                    }
                },
                error: function() {
                    $btn.prop('disabled', false);
                    setupDropdown('dropdownContent', 'error', svgError + 'An error occurred while replacing vehicle.', 'click');
                }
            });
        })
        .catch(function(errMsg) {
            $btn.prop('disabled', false);
            setupDropdown('dropdownContent', 'error', svgError + (errMsg || 'Failed to upload images before replacing vehicle.'), 'click');
        });
});

// Other Fees Logic
function addOtherFeeRow(item, price, actual_amount, remarks) {
    item = item || '';
    price = price || '';
    actual_amount = actual_amount || '';
    remarks = remarks || '';
    let rowCount = $('#other_fee_tbody tr').length + 1;
    let $row = $(`
        <tr>
            <td class="text-center align-middle fee-row-num">${rowCount}</td>
            <td>
                <input type="text" class="form-control form-control-sm fee-item" placeholder="Fee Item" value="${item}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm fee-price" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0.000" value="${price}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm fee-actual-amount" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0.000" value="${actual_amount}">
            </td>
            <td>
                <textarea class="form-control form-control-sm fee-remarks" rows="1" placeholder="Enter remarks">${remarks}</textarea>
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-fee px-2 py-1" title="Remove">
                    <i class="ri ri-delete-bin-line fs-5"></i>
                </button>
            </td>
        </tr>
    `);
    $('#other_fee_tbody').append($row);
    renumberFeeRows();
}

function renumberFeeRows() {
    $('#other_fee_tbody tr').each(function(idx) {
        $(this).find('.fee-row-num').text(idx + 1);
    });
}

$(document).on('click', '#add_other_fee_row', function() {
    addOtherFeeRow();
});

$(document).on('click', '.btn-remove-fee', function() {
    $(this).closest('tr').remove();
    renumberFeeRows();
});

window.calcOdoDiff = function() {
    let kmOut = parseFloat($('#km_out').val()) || 0;
    let kmIn = parseFloat($('#km_in').val()) || 0;
    if (kmIn >= kmOut) {
        $('#odo_diff').val(kmIn - kmOut);
    } else {
        $('#odo_diff').val('');
    }
};

});

// OVERRIDE btn_vehicle_view to open Vehicle Profile modal (same as DirectContract)
$(document).ready(function() {
    $(document).off('click', '.btn_vehicle_view').on('click', '.btn_vehicle_view', function(e) {
        e.preventDefault();
        e.stopPropagation();
        let vehicleId = $(this).data('id') || $(this).attr('data-id');
        if (vehicleId) {
            openVehicleProfile(vehicleId);
        }
    });
});

$(document).on('show.bs.modal', '#vehicleProfileModal', function() {
    let highestZ = 1050;
    $('.modal.show').each(function() {
        if (this.id !== 'vehicleProfileModal') {
            let z = parseInt($(this).css('z-index')) || 1050;
            if (z > highestZ) highestZ = z;
        }
    });
    $(this).css('z-index', highestZ + 20);
    setTimeout(function() {
        $('.modal-backdrop').last().css('z-index', highestZ + 10);
    }, 10);
});

$(document).on('hidden.bs.modal', '#vehicleProfileModal', function() {
    if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open');
    }
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
                    let expRet = v.expected_return_date ? (window.dayjs ? dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : (window.moment ? moment(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : v.expected_return_date)) : "N/A";
                    $("#vpReturnDate").text(expRet);
                } else if (v.vehicle_status === 'Staff Use' && v.current_user_name) {
                    $("#vpStaffDiv").show();
                    $("#vpStaffName").text(v.current_user_name);
                    $("#vpStaffContact").text(v.current_user_contact || "No Contact");
                    $("#vpStaffRef").text(v.contract_ref || "N/A");
                    let expRet = v.expected_return_date ? (window.dayjs ? dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : (window.moment ? moment(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : v.expected_return_date)) : "N/A";
                    $("#vpStaffReturnDate").text(expRet);
                }
                
                // Status badge
                if (typeof window.applyVehicleStatusBadge === "function") {
                    window.applyVehicleStatusBadge("#vpStatusBadge", v.vehicle_status);
                } else {
                    $("#vpStatusBadge").attr("class", "badge bg-label-primary").text(v.vehicle_status || "Unknown");
                }
                
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
<script src="../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
   
  </body>
  
</html>
