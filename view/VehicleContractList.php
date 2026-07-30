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
    background: linear-gradient(135deg, #f12526, #c81e1f);
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
    border-left: 5px solid #e35d6a; /* blue highlight */
}
.modern-check {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #0d6efd;
}

tr.shown {
    background-color: #fff3cd !important; /* highlight parent row */
}
#dropdownContent {
     position: fixed !important;
    z-index: 999999 !important;
   
}
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


// Clear Signature
$(document).on('click', '#clear_returnsignature', function () {

    if (returnSignaturePad) {

        returnSignaturePad.clear();
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


 $(document).on("click", "#btnMainSearch", function () {
    
   
   searchContractList();

});
function searchContractList()
{
    let customer_code = $.trim($('#customer_code').val()) || 'All';
    let filter_from=$('#filter_from_date').val();
    let filter_to=$('#filter_to_date').val();
    let booking_status=$('#select_booking_status').val();
     
  
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
  
   load_contract_list(customer_code, filter_from, filter_to, booking_status);
}

  var table;
 load_contract_list();
function load_contract_list(
    customer_code = 'All',
    filter_from = '',
    filter_to = '',
    booking_status = 'All'
) {

    // Destroy existing table
    if ($.fn.DataTable.isDataTable('#contractTable')) {
       $('#contractTable').DataTable().destroy();
        $('#contractTable tbody').empty();
    }
    
    
   table = $('#contractTable').DataTable({
    processing: true,
    serverSide: false,
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
                    booking_status: booking_status
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

        // Agreement No
        {
            data: 'agreement_no',
            render: function (data, type, row) {

                return `
                    <div class="fw-semibold">
                        ${data}
                    </div>
                `;
            }
        },

        // Agreement Date
        {
            data: 'agreement_date_format'
        },

        // Customer
        {
            data: null,
            render: function (data, type, row) {
             return `
                        <div>
                            <strong>${row.customer_name}</strong><br>
                            <small>Code: ${row.customer_code}</small>
                         <small>☎ ${row.mobile}.</small>
                        </div>
                        `;
                
            }
        },

        // Vehicle
        {
            data: null,
            render: function (data, type, row) {
                return `
                        <div>
                            <strong>${row.vehicle_no}</strong><br>
                            <small>Code: ${row.category_name}</small>
                         <small>, ${row.model_name}</small>
                        </div>
                        `;
                
            }
        },

        // Period
        {
            data: null,
            render: function (data, type, row) {
               return `
                        <div>
                            <strong>
                                <small>
                                    ${(row.from_date_format || '')} to ${(row.to_date_format || '')}
                                </small>
                            </strong>
                        </div>
                    `;
               
            }
        },

        // Status
        {
            data: 'agreement_status',
            className: 'status-cell',
            render: function (data) {

                let badgeClass = 'bg-secondary';

                if (data == 'Generated') {
                    badgeClass = 'bg-warning';
                }
                else if (data == 'Rentout') {
                    badgeClass = 'bg-success';
                }
                else if (data == 'Extended') {
                    badgeClass = 'bg-success';
                }
                else if (data == 'Returned') {
                    badgeClass = 'bg-primary';
                }
                else if (data == 'Closed') {
                    badgeClass = 'bg-success';
                }
                else if (data == 'Onhold') {
                    badgeClass = 'bg-danger';
                }
                else if (data == 'Cancelled') {
                    badgeClass = 'bg-danger';
                }
                else  {
                    badgeClass = 'bg-danger';
                }

                return `
                    <span class="badge ${badgeClass}">
                        ${data}
                    </span>
                `;
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
                            
                                ${row.agreement_status === 'Generated' ? `
                                <li>
                                    <a class="dropdown-item text-danger fw-semibold changeStatus"
                                       data-id="${row.booking_ids}"
                                       data-status="Rentout"
                                       data-vehicleid="${row.vehicle_id}"
                                       style="cursor:pointer;">
                                        🚗 Rent Out
                                    </a>
                                </li>
                                ` : ''}
                                <li>
                                    <a class="dropdown-item rounded text-success fw-semibold print_agreement_btn" href="javascript:void(0)"
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
                                    <a class="dropdown-item rounded text-info fw-semibold send_agreement_btn"
                                       href="javascript:void(0)"
                                       data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}">
                                        <i class="ri ri-send-plane-fill me-2"></i>
                                        Send Agreement
                                    </a>
                                </li>
            
                                <li>
                                    <a class="dropdown-item rounded text-warning fw-semibold extend_contract_btn"
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
                                    <a class="dropdown-item rounded text-primary fw-semibold extend_list_btn"
                                       href="javascript:void(0)"
                                        data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}">
            
                                        <i class="ri ri-calendar-event-line me-2"></i>
                                        Extended List
                                    </a>
                                </li>
            
                                <li><hr class="dropdown-divider my-2"></li>
                                
                                 <li>
                                    <a class="dropdown-item rounded text-warning fw-semibold return_contract_btn"
                                       href="javascript:void(0)"
                                         data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}">
            
                                        <i class="ri ri-roadster-line me-2"></i>
                                        Return Vehicle
                                    </a>
                                </li>
                                 <li>
                                    <a class="dropdown-item rounded text-danger fw-semibold replace_contract_btn"
                                       href="javascript:void(0)"
                                         data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}">
            
                                        <i class="ri ri-roadster-line me-2"></i>
                                        Replace Vehicle
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded text-success fw-semibold close_contract_button"
                                       href="javascript:void(0)"
                                        data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}"">
            
                                        <i class="ri ri-lock-line me-2"></i>
                                        Close Contract
                                    </a>
                                </li>
                               <li>
                                    <a class="dropdown-item rounded text-primary fw-semibold view_contract_details"
                                       href="javascript:void(0)"
                                       data-id="${row.ids}"
                                       data-vehicle="${row.vehicle_id}"
                                       data-model="${row.model_id}"
                                       data-customer="${row.customer_code}"
                                       data-contract="${row.agreement_no}"
                                       data-booking_id="${row.booking_ids}">
            
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



   $('#contractTable').on('draw.dt', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
}); 

$(document).on('click', '.changeStatus', function () {

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

                listExtendedList(agreement_ids);

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
            new bootstrap.Modal(document.getElementById('ReturncontractModal')).show();
        }
    });
}
function populatereturnContractModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;
   
        $('#return_c_name').text(data.customer.customer_name || '');
        $('#return_c_code').text(data.customer.customer_id || '');
        $('#return_c_mobile').text(data.customer.customer_mobile || '');
        $('#return_c_email').text(data.customer.customer_email || '');
        $('#return_c_attn').text(data.customer.customer_attn || '');
        $('#return_c_attr').text(data.customer.customer_addr || '');
        
        $('#return_v_no').text(data.vehicle.vehicle_number || '');
        $('#return_v_model').text(data.vehicle.model_names || '');
        $('#return_v_brand').text(data.vehicle.brand_name || '');
        $('#return_v_category').text(data.vehicle.category_name || '');
        $('#return_v_color').text(data.vehicle.vehicle_color || '');
        $('#return_v_year').text(data.vehicle.vehicle_year || '');
        $('#return_v_passing').text(data.vehicle.formatted_next_passing_date || '');
        $('#return_hid_nxt_passing').val(data.vehicle.next_passing_date || '');  
        $('#return_v_maintenance').text(data.vehicle.formatted_next_maintenance_date || '');
        $('#return_hid_nxt_maintenance').val(data.vehicle.next_maintenance_date || '');  
        $('#return_v_insurance').text(data.vehicle.formatted_next_insurance_date || ''); 
        $('#return_hid_nxt_insurance').val(data.vehicle.next_insurance_date || '');  
        
        
        $('#return_hid_vehicle_id').val(data.vehicle.ids || '');
        $('#return_hid_category_id').val(data.vehicle.category_id || '');
        $('#return_hid_model_id').val(data.vehicle.model_id || '');
        $('#return_hid_vehicle_no').val(data.vehicle.vehicle_number || '');
        
       
        
        
        data.price_list.forEach(function(item) {
        
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
        $('#km_out').val(vehicle_accessiories_details.vehicle_km_out || 0);
         $('#km_in').val(vehicle_accessiories_details.vehicle_km_in || 0);
        $('#fuel_level').val(vehicle_accessiories_details.fuel_level || '');
        
        $('#dt_out').val(vehicle_accessiories_details.date_out || '');
        $('#dt_out').val(vehicle_accessiories_details.date_in || '');
        $('#dt_contract_date').val(contract.agreement_date || '');
        
       $('#cust_driver').val(contract.customer_driver_name || '');
       $('#cust_driver_contact_no').val(contract.customer_driver_contact_number || '');
        $('.driverclass').show(); 
     
        $('#d_name').text(
            driverDetails.driver_name === 'Select Driver'
                ? ''
                : driverDetails.driver_name
        );
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

    // });

      listExtendedListReturn(data.contract.ids);
} 
  var returnextensiontable;
function listExtendedListReturn(agreement_ids) 
{

    if ($.fn.DataTable.isDataTable('#contractReturnTable')) {
       $('#contractReturnTable').DataTable().destroy();
        $('#contractReturnTable tbody').empty();
    }
    
    
   returnextensiontable = $('#contractReturnTable').DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: function () {

            return JSON.stringify({
                action: 'ListContractExtensionsReturn',
                  agreementid: agreement_ids
            });
        },
        dataSrc: 'data'
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

   $('#contractReturnTable').on('draw.dt', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
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
         $('#elist_txt_extend_modal_agreement_id').val(id);
         $('#elist_txt_extend_modal_agreement_no').val(agreement_no);
          $('#elist_txt_extend_modal_booking_ids').val(booking_ids);
         
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
   
        $('#elist_c_name').text(data.customer.customer_name || '');
        $('#elist_c_code').text(data.customer.customer_id || '');
        $('#elist_c_mobile').text(data.customer.customer_mobile || '');
        $('#elist_c_email').text(data.customer.customer_email || '');
        $('#elist_c_attn').text(data.customer.customer_attn || '');
        $('#elist_c_attr').text(data.customer.customer_addr || '');
        
        $('#elist_v_no').text(data.vehicle.vehicle_number || '');
        $('#elist_v_model').text(data.vehicle.model_names || '');
        $('#elist_v_brand').text(data.vehicle.brand_name || '');
        $('#elist_v_category').text(data.vehicle.category_name || '');
        $('#elist_v_color').text(data.vehicle.vehicle_color || '');
        $('#elist_v_year').text(data.vehicle.vehicle_year || '');
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
        
       
        
        
        data.price_list.forEach(function(item) {
        
            switch(item.item) {
                case "Price per hour rental without driver":
                    $('#elist_wod_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per hour rental with driver":
                    $('#elist_wd_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental without driver":
                    $('#elist_wod_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental with driver":
                    $('#elist_wd_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental without driver":
                    $('#elist_wod_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental with driver":
                    $('#elist_wd_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental without driver":
                    $('#elist_wod_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental with driver":
                   $('#elist_wd_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
            }
        });
       
        let contract = data.contract || {};
     
       listExtendedList(data.contract.ids);
}     


  var extensiontable;
function listExtendedList(agreement_ids) 
{

    if ($.fn.DataTable.isDataTable('#contractExtensionTable')) {
       $('#contractExtensionTable').DataTable().destroy();
        $('#contractExtensionTable tbody').empty();
    }
    
    
   extensiontable = $('#contractExtensionTable').DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: function () {

            return JSON.stringify({
                action: 'ListContractExtensions',
                  agreementid: agreement_ids
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
 
        {
            data: 'agreement_no',
            render: function (data, type, row) {

                return `
                    <div class="fw-semibold">
                        ${data}
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
        },

        
        // Actions
        {
            data: null,
            orderable: false,
            render: function (data, type, row) {

                return `
            
                    <button class="btn btn-sm btn-primary shadow-sm rounded-pill deleteExtension"
                                data-id="${row.ids}"
                                 data-agreement_ids="${row.agreement_ids}"
                                data-contract="${row.agreement_no}"
                                data-customer_code="${row.customer_code}"
                                data-booking_id="${row.booking_ids}"
                                data-vehicle="${row.vehicle_id}"
                              >
                           Delete Extension
            
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
        }
    });
}

function populateExtendContractModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;
   
        $('#extend_c_name').text(data.customer.customer_name || '');
        $('#extend_c_code').text(data.customer.customer_id || '');
        $('#extend_c_mobile').text(data.customer.customer_mobile || '');
        $('#extend_c_email').text(data.customer.customer_email || '');
        $('#extend_c_attn').text(data.customer.customer_attn || '');
        $('#extend_c_attr').text(data.customer.customer_addr || '');
        
        $('#extend_v_no').text(data.vehicle.vehicle_number || '');
        $('#extend_v_model').text(data.vehicle.model_names || '');
        $('#extend_v_brand').text(data.vehicle.brand_name || '');
        $('#extend_v_category').text(data.vehicle.category_name || '');
        $('#extend_v_color').text(data.vehicle.vehicle_color || '');
        $('#extend_v_year').text(data.vehicle.vehicle_year || '');
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
        let extend_end_date=data.extend_end_date
        // Set values
        
        $('#extend_b_from').val(extend_end_date || contract.service_end_date_time);
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
   
   let from = new Date($('#extend_b_from').val());
   let to = new Date($('#extend_b_to').val());
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
       
        let fromDate = new Date(from);
        let toDate   = new Date(to);
        if(toDate < fromDate){
        let fromDate = new Date(from);
        let toDate   = new Date(to);

        if(toDate < fromDate){
             setupDropdown('dropdownContent','error',svgSuccess+'To date must be after from date','click');
            
            $(this).val('');
        }

    }

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
    
    if (new Date($('#extend_b_to').val()) < new Date($('#extend_b_from').val())) {
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
            book_period_from: $('#extend_b_from').val(),
            book_period_to: $('#extend_b_to').val()
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
     let from = new Date($('#extend_b_from').val());
     let to = new Date($('#extend_b_to').val());

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
                period_from: $('#extend_b_from').val(),
                period_to: $('#extend_b_to').val(),
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

       if (!$('#km_in').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide km in", 'click');
        return;
    }

    if (!$('#dt_in').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide date in", 'click');
        return;
    }
    if (!$('#received_by_name').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide receiver name", 'click');
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

function returnContract(customer_code)
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
    
    let hasReceiverSign    = !returnSignaturePad.isEmpty();

    
    if (!hasReceiverSign ) {
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
         setupDropdown(
            'dropdownContent',
            'error',
            svgError + 'Please enter receiver name',
            'click'
        );

        return;
        

    }

   laddaReturnContract.start();
    let receiver_signature = '';
    
    if (
       returnSignaturePad &&
        !returnSignaturePad.isEmpty()
    ) {
    
        receiver_signature =
             returnSignaturePad.toDataURL();
    
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
                        returnvehicleimages: allVehicleReturnImages,
                        receiver_name:receiver_name,
                        ReceiverSign: receiver_signature,
                        customer_code:customer_code
                       
                       
                    }),
                
                    success: function (res) {
                        console.log(res);
                        laddaReturnContract.stop();
                       if (res.status)
                        {
                            setupDropdown(
                                'dropdownContent',
                                'success',
                                svgSuccess + res.message,
                                'click'
                            );
                        
                            let modal = bootstrap.Modal.getInstance(
                                document.getElementById('ReturncontractModal')
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
        $('#viewcontract_agreement_status').text(contract.agreement_status);
       
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
                  agreementid: agreement_ids
            });
        },
        dataSrc: 'data'
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


    if (status === 'Extended' || status === 'Rentout') {
        
        
         $('#replace_agreement_ref').text(agreement_no);
         $('#txt_replace_modal_agreement_id').val(id);
         $('#txt_replace_modal_agreement_no').val(agreement_no);
          $('#txt_replace_modal_booking_ids').val(booking_ids);
         
        openReplaceModal(id,vehicleid,customer_code,model_ids);
        
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
                svgSuccess + 'The vehicle cannot be replaced.',
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
   
        $('#replace_c_name').text(data.customer.customer_name || '');
        $('#replace_c_code').text(data.customer.customer_id || '');
        $('#replace_c_mobile').text(data.customer.customer_mobile || '');
        $('#replace_c_email').text(data.customer.customer_email || '');
        $('#replace_c_attn').text(data.customer.customer_attn || '');
        $('#replace_c_attr').text(data.customer.customer_addr || '');
        
        $('#replace_v_no').text(data.vehicle.vehicle_number || '');
        $('#replace_v_model').text(data.vehicle.model_names || '');
        $('#replace_v_brand').text(data.vehicle.brand_name || '');
        $('#replace_v_category').text(data.vehicle.category_name || '');
        $('#replace_v_color').text(data.vehicle.vehicle_color || '');
        $('#replace_v_year').text(data.vehicle.vehicle_year || '');
        $('#replace_v_passing').text(data.vehicle.formatted_next_passing_date || '');
        $('#replace_hid_nxt_passing').val(data.vehicle.next_passing_date || '');  
        $('#replace_v_maintenance').text(data.vehicle.formatted_next_maintenance_date || '');
        $('#replace_hid_nxt_maintenance').val(data.vehicle.next_maintenance_date || '');  
        $('#replace_v_insurance').text(data.vehicle.formatted_next_insurance_date || ''); 
        $('#replace_hid_nxt_insurance').val(data.vehicle.next_insurance_date || '');  
        
        
        $('#replace_hid_vehicle_id').val(data.vehicle.ids || '');
        $('#replace_hid_category_id').val(data.vehicle.category_id || '');
        $('#replace_hid_model_id').val(data.vehicle.model_id || '');
        $('#replace_hid_vehicle_no').val(data.vehicle.vehicle_number || '');
        
       
        
        
        data.price_list.forEach(function(item) {
        
            switch(item.item) {
                case "Price per hour rental without driver":
                    $('#replace_wod_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per hour rental with driver":
                    $('#replace_wd_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental without driver":
                    $('#replace_wod_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental with driver":
                    $('#replace_wd_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental without driver":
                    $('#replace_wod_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental with driver":
                    $('#replace_wd_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental without driver":
                    $('#replace_wod_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental with driver":
                   $('#replace_wd_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
            }
        });
       
        let contract = data.contract || {};
        let bookDetails = JSON.parse(contract.book_details_json || '{}');
         let driverDetails = JSON.parse(contract.driver_details || '{}');
         let vehicle_accessiories_details = JSON.parse(contract.vehicle_accessories_details || '{}');
         let customer_driver_attachments = JSON.parse(contract.customer_driver_attachments || '[]');
         let vehicerentoutImages = JSON.parse(contract.vehicle_rentout_images || '[]');
        $('#replacechk_tools').prop(
            'checked',
            vehicle_accessiories_details.chk_tools && vehicle_accessiories_details.chk_tools === 'Yes'
        );
         $('#replacechk_spare').prop(
            'checked',
            vehicle_accessiories_details.chk_spare && vehicle_accessiories_details.chk_spare === 'Yes'
        );
         $('#replacechk_radio').prop(
            'checked',
            vehicle_accessiories_details.chk_radio && vehicle_accessiories_details.chk_radio === 'Yes'
        );
        $('#replacekm_out').val(vehicle_accessiories_details.vehicle_km_out || 0);
         $('#replacekm_in').val(vehicle_accessiories_details.vehicle_km_in || 0);
        $('#replacefuel_level').val(vehicle_accessiories_details.fuel_level || '');
        
        $('#replacedt_out').val(vehicle_accessiories_details.date_out || '');
        $('#replacedt_out').val(vehicle_accessiories_details.date_in || '');
        $('#replacedt_contract_date').val(contract.agreement_date || '');
        
       $('#replacecust_driver').val(contract.customer_driver_name || '');
       $('#replacecust_driver_contact_no').val(contract.customer_driver_contact_number || '');
        $('.replacedriverclass').show(); 
     
        $('#replaced_name').text(
            driverDetails.driver_name === 'Select Driver'
                ? ''
                : driverDetails.driver_name
        );
        $('#replaced_mobile').text(driverDetails.driver_mobile);
        $('#replaced_license_no').text(driverDetails.driver_license_no);
        $('#replaced_license_issue_place').text(driverDetails.driver_license_issplace);
        $('#replaced_licenseissueDate').text(driverDetails.driver_license_expdate);
        $('#replaced_licenseexpiryDate').text(driverDetails.driver_license_expdate);
       
$('#replacecontractcustdriverdocpreview').empty();
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

                $('#replacecontractcustdriverdocpreview').append(liHtml);

            });
        }

        bookingMaster.vehicles.push(vehiclesObj);
    });
}
             $('#replacepreview').empty();  
          existingVehicleImages = [];
          existingFileNames = [];
          uploadedFileNames = [];
         existingVehicleImages = JSON.parse(contract.vehicle_rentout_images || '[]');
        
        
         existingVehicleImages.forEach(img => {
             
        existingFileNames.push(img);
        let id = 'db_' + Math.random().toString(36).substr(2, 9);

        $('#replacepreview').append(`
            <div class="position-relative" id="img-${id}" data-file="${img}">
                
                <img src="../uploads/rentvehicleImages/${img}" 
                     class="rounded border vehicle-preview-img"
                     data-id="${id}"
                      data-file="${img}"
                     style="width:80px;height:80px;object-fit:cover;cursor:pointer;">

                
            </div>
        `);
        
         });
        $('#replacepreview').empty();  
          existingVehicleImagesReturn = [];
          existingFileNamesReturn = [];
          uploadedFileNamesReturn = [];
   

      listExtendedListReplace(data.contract.ids);
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
                  agreementid: agreement_ids
            });
        },
        dataSrc: 'data'
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

});

</script>

   
  </body>
  
</html>
