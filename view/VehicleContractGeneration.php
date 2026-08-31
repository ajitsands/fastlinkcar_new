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
    z-index: 1000000 !important;
   
}
#customConfirmModal {
    z-index: 1000000 !important;
   
}
#signatureModal {
    z-index: 999999 !important;
   
}
#signatureModalView {
    z-index: 999999 !important;
   
}
#walkInsModal {
    z-index: 999999 !important;
}

#QtnAddNewCustomerModal {
     z-index: 1000000 !important;
}
#vehicleDetailsModal {
     z-index: 1000000 !important;
}
#modalvehicleimages {
     z-index: 1000000 !important;
}
#checkavailabilityModal {
     z-index: 1000000 !important;
}
#bookingSummaryModal {
     z-index: 1000000 !important;
}
#selectedVehiclesFooter::-webkit-scrollbar {
    z-index: 1000000 !important;
    height: 6px;
}

#selectedVehiclesFooter::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}


#termsTable th,
#termsTable td {
    padding: 4px 8px !important;   /* reduce padding */
    font-size: 13px;               /* smaller text */
    vertical-align: middle;
}
.card-headernew {
    min-height: auto !important;
    padding-top: 6px !important;
    padding-bottom: 6px !important;
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
               <?php include('templates/VehicleContractGeneration/vehicle_contract_body.php'); ?>
               
              <?php include('templates/VehicleReservation/add_new_customer_modal.php'); ?>
              <?php include('templates/VehicleReservation/custom_confirm_modal.php'); ?>
              <?php include('templates/VehicleReservation/confirm_action_modal.php'); ?>
               <?php include('templates/VehicleContractGeneration/signature_modal.php'); ?>
               <?php include('templates/VehicleContractGeneration/signature_view_modal.php'); ?>
              <?php include('templates/VehicleContractGeneration/confirmafteroptvalidation_modal.php'); ?>
              <?php include('templates/VehicleContractGeneration/vehicle_contract_modal.php'); ?>
              
              <?php include('templates/VehicleContractGeneration/customer_driver_documents_upload.php'); ?>
              <?php include('templates/VehicleContractGeneration/vehicle_image_preview_modal.php'); ?>
              <?php include('templates/VehicleContractGeneration/otp_verify_modal.php'); ?>
              
              <?php include('templates/VehicleContractGeneration/otp_submit_modal.php'); ?>
             
              <?php include('templates/VehicleContractGeneration/terms_condition_modal.php'); ?>
               <?php include('templates/VehicleContractGeneration/walkin_contract_model.php'); ?>
               
              
             
                   
                         <?php include('templates/VehicleContractGeneration/vehicleFloatingFooter.php'); ?>
                         <?php include('templates/VehicleStatus/vehicle_filepreview_modal.php'); ?>
                         <?php include('templates/VehicleContractGeneration/reservation_preview_modal.php'); ?>
                         <?php include('templates/VehicleReservation/vehicle_images_slider.php'); ?>
                         <?php include('templates/VehicleReservation/custom_confirm_modal.php'); ?>
                         <?php include('templates/VehicleReservation/confirm_action_modal.php'); ?>
                          <?php include('templates/VehicleReservation/view_notes_modal.php'); ?>
                          <?php include('templates/VehicleReservation/vehicle_availability_model.php'); ?>
                          <?php include('templates/VehicleReservation/booking_listupon_avail_check.php'); ?>
                          <?php include('templates/VehicleReservation/vehicleAvailFloatingBar.php'); ?>
                        
             
              
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
 <?php include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
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
             const fullEditor = new Quill('#full-editor', {
                bounds: '#full-editor',
                placeholder: 'Terms & Condition',
                modules: {
                  syntax: true,
                  toolbar: fullToolbar
                },
                theme: 'snow'
              });
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

$('.addCustomerBtn').click(function () {
       
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
        address: $("#bookingCustomerAddress_onmodal").val(),
        clientsDoc: [] 
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
    
    
            } else {
                setupDropdown(
                    'dropdownContent',
                    'danger',
                    svgSuccess + res.message,
                    'click'
                );
            }
    
        },
        error: function() {
            setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + ' Error saving customer',
                'click'
            );
        }
    });
    }
  $(document).on("click", "#btn_add_new_customer", function () {

    saveCustomer('AddNewCustomer');

});
 $(document).on("click", "#btnMainSearch", function () {
    
   
   searchBookingList();

});
function searchBookingList()
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
  
   load_booking_list(customer_code, filter_from, filter_to, booking_status);
}

 var table;
 load_booking_list();
function load_booking_list(
    customer_code = 'All',
    filter_from = '',
    filter_to = '',
    booking_status = 'All'
) {

    // Destroy existing table
    if ($.fn.DataTable.isDataTable('#bookingTable1')) {
        $('#bookingTable1').DataTable().destroy();
        $('#bookingTable1 tbody').empty();
    }
     table = $('#bookingTable1').DataTable({
     ajax: {
            url: '/VehicleContractGeneration',
            type: 'POST',
            contentType: 'application/json',
            data: function (d) {
                return JSON.stringify({
                    action: 'ListBookings',
                    customer_code: customer_code,
                    filter_from: filter_from,
                    filter_to: filter_to,
                    booking_status: booking_status
                });
            },
            dataSrc: 'data',
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        },
    //ajax: '/VehicleContractGeneration',
   columns: [
    {
        className: 'dt-control',
        orderable: false,
        data: null,
        defaultContent: '<i class="ri-add-line"></i>'
    },
    { data: 'booking_ref' },
    {
    data: null,
    render: function (d) {
        return `
            <div>
                <strong>${d.customer_name}</strong><br>
                <small>Code: ${d.customer_code}</small>
             <small>☎ ${d.mobile}</small>
            </div>
            `;
        }
    },

   {
    data: null,
    render: function (d) {

        let total = d.entries.length;

        return `
            <div class="d-flex gap-2 align-items-center">
            <!-- Total -->
                <span class="badge  bg-dark d-flex align-items-center justify-content-center"
                      style="width:25px;height:25px;"
                      data-bs-toggle="tooltip"
                      title="Total Bookings: ${total}">
                    ${total}
                </span> =>
                <!-- Pending -->
                <span class="badge rounded-circle bg-warning d-flex align-items-center justify-content-center pending_span_count"
                      data-bs-toggle="tooltip"
                      title="Pending Bookings: ${d.pending_count}">
                    ${d.pending_count}
                </span>
                <!-- Confirmed -->
                <span class="badge rounded-circle bg-info d-flex align-items-center justify-content-center confirmed_span_count"
                      data-bs-toggle="tooltip"
                      title="Confirmed Bookings: ${d.confirmed_count}">
                    ${d.confirmed_count}
                </span>

                <!-- Completed -->
                <span class="badge rounded-circle bg-success d-flex align-items-center justify-content-center rentout_span_count"
                      style="width:25px;height:25px;"
                      data-bs-toggle="tooltip"
                      title="Rentout Bookings: ${d.rentout_count}">
                    ${d.rentout_count}
                </span>
                
                <!-- Completed -->
                <span class="badge rounded-circle bg-primary d-flex align-items-center justify-content-center return_span_count"
                      style="width:25px;height:25px;"
                      data-bs-toggle="tooltip"
                      title="Return Bookings: ${d.return_count}">
                    ${d.return_count}
                </span>
                
                 <span class="badge rounded-circle bg-danger d-flex align-items-center justify-content-center cancelled_span_count"
                      data-bs-toggle="tooltip"
                      title="Cancelled Bookings: ${d.cancelled_count}">
                    ${d.cancelled_count}
                </span>

                <span class="badge rounded-circle bg-secondary d-flex align-items-center justify-content-center closed_span_count"
                      data-bs-toggle="tooltip"
                      title="Closed Bookings: ${d.closed_count}">
                    ${d.closed_count}
                </span>

            </div>
        `;
    }
},

    {
        data: null,
        render: function (data) {
          
            return `
                <button class="btn btn-sm btn-primary bookingReport" data-id="${data.booking_ref}" data-bs-toggle="tooltip"
                                title="Booking Report">
                    <i class="ri ri-file-chart-line"></i>
                </button>
                
            `;
        }
    }
]
});
}


$('#bookingTable1 tbody').on('click', 'td.dt-control', function () {

    var tr = $(this).closest('tr');
    var row = table.row(tr);
    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).html('<i class="ri-add-line"></i>');
    } else {
        row.child(format(row.data())).show();
        tr.addClass('shown');
        $(this).html('<i class="ri-subtract-line"></i>');
         setTimeout(function () {
    
                $(row.child()).find('[data-bs-toggle="tooltip"]').each(function () {
                    new bootstrap.Tooltip(this);
                });
    
            }, 50);
    }
   
});
function format(d) {
    

     let html = `
        <div class="child-wrapper p-3 mt-2 mb-2 rounded">

            <div class="fw-bold mb-2 text-danger">
                Booking Ref No. - ${d.booking_ref}
            </div>

            <table class="table table-sm table-bordered table-striped mb-0">
                <thead >
                    <tr>
                        <th style="width: 35px !important; max-width: 35px !important;padding: 4px !important;"></th>
                        <th>Vehicle No</th>
                        <th>Model</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    `;

    d.entries.forEach(row => {
        html += `
            <tr data-parent="${row.booking_ref}">
            <td class="text-center">
                    <input class="form-check-input modern-check booking_checkbox"
                           type="checkbox"
                           value="${row.ids}" data-id="${row.ids}">
                </td>
                <td>${row.vehicle_no}</td>
                <td>${row.brand_name} ${row.model_name}</td>
                <td>${row.from_date_format}</td>
                <td>${row.to_date_format ?? '-'}</td>
                <td  class="status-cell">
                    <span class="badge ${
                        row.book_status === 'Booked' ? 'bg-warning ' :
                        row.book_status === 'Confirmed' ? 'bg-info' :
                        row.book_status === 'Rentout' ? 'bg-success' :
                         row.book_status === 'Extended' ? 'bg-success' :
                        row.book_status === 'Return' ? 'bg-primary' :
                        row.book_status === 'Cancelled' ? 'bg-danger' :
                        'bg-secondary'
                    }">
                        ${row.book_status}
                    </span>
                </td>
               <td class="text-nowrap">
                    <div class="d-flex gap-1">
                         <div class="dropdown">
                            <button class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" >
                               Action
                            </button>
                            <ul class="dropdown-menu">
                               
                                <li>
                                    <a class="dropdown-item changeStatus" data-id="${row.ids}" data-status="Confirmed" data-vehicleid="${row.vehicle_id}" style="cursor: pointer;">
                                        ✅ Confirm
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item changeStatus" data-id="${row.ids}" data-status="Cancelled" data-vehicleid="${row.vehicle_id}" style="cursor: pointer;">
                                        ❌ Cancel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item changeStatus" data-id="${row.ids}" data-status="Rentout" data-vehicleid="${row.vehicle_id}" style="cursor: pointer;">
                                        🚗 Rent Out
                                    </a>
                                </li>
                                
                                <li>
                                    <a class="dropdown-item deleteBooking" data-id="${row.ids}"  style="cursor: pointer;">
                                       🗑️ Delete
                                    </a>
                                </li>
                               
                              
                            </ul>
                        </div>
                        <!-- Generate Contract -->
                        <button class="btn btn-sm btn-primary generate-contract"
                                data-id="${row.ids}" data-vehicle="${row.vehicle_id}"  data-customer_code="${row.customer_code}" data-booking_ref="${row.booking_ref}" data-model_id="${row.model_id}"
                                data-bs-toggle="tooltip"
                                title="Update Contract">
                            <i class="ri ri-file-text-line"></i>
                        </button>
                
                       
                         <button class="btn btn-sm btn-info btnOpenSignature"
                                data-id="${row.ids}"
                                data-customer_name="${row.customer_name}"
                                data-bs-toggle="tooltip"
                                title="Apply Signature">
                             <i class="ri ri-quill-pen-line"></i>
                        </button>
                        <button class="btn btn-sm btn-primary btnviewSignature"
                                data-id="${row.ids}" 
                                data-bs-toggle="tooltip"
                                title="View Signature">
                             <i class="ri ri-fingerprint-line"></i>
                        </button>
                        
                         <button class="btn btn-sm btn-success print-contract"
                                data-id="${row.ids}" data-vehicle="${row.vehicle_id}"  data-customer_code="${row.customer_code}" data-booking_ref="${row.booking_ref}" data-model_id="${row.model_id}"
                                data-bs-toggle="tooltip"
                                title="Print Contract">
                             <i class="ri ri-printer-fill"></i>
                        </button>
                       
                
                    </div>
                </td>
            </tr>
        `;
    });

    html += `</tbody></table></div>`;

    return html;
}

   $('#bookingTable1').on('draw.dt', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
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
        url: '/VehicleStatusController',
        type: 'POST',
        dataType: 'json',
        data: confirmData.data,
        success: function (res) {
          
         if (!res.status) return;
 setupDropdown('dropdownContent', 'success', svgSuccess + 'Action completed successfully', 'click');
    let { btn, id, status, bookingRef } = confirmData.extra || {};
    if(status==='Deleted')
    {
        searchBookingList();
        return;
    }
    let rowEl = btn.closest('tr');

    // ✅ Update badge
    let badge = rowEl.find('.status-cell span');

    let badgeClass =
        status === 'Booked' ? 'bg-warning' :
        status === 'Confirmed' ? 'bg-info' :
        status === 'Cancelled' ? 'bg-danger' :
        status === 'Returned' ? 'bg-primary' :
        status === 'Rentout' ? 'bg-success' :
        'bg-warning';

    badge.attr('class', 'badge ' + badgeClass).text(status);

    // ✅ Find parent row
    let parentRow = null;

    table.rows().every(function () {
        let rowData = this.data();
        if (rowData.booking_ref == bookingRef) {
            parentRow = this;
        }
    });

    if (!parentRow) {
        console.error('Parent row not found');
        return;
    }

    let data = parentRow.data();

    // ✅ Update entry
    data.entries.forEach(e => {
        if (String(e.ids) === String(id)) {
            e.book_status = status;
        }
    });

    // ✅ Recalculate counts
    let counts = {
        Booked: 0,
        Confirmed: 0,
        Rentout: 0,
        Cancelled: 0,
        Return: 0
    };

    data.entries.forEach(e => {
        if (counts.hasOwnProperty(e.book_status)) {
            counts[e.book_status]++;
        }
    });

    data.pending_count = counts.Booked;
    data.confirmed_count = counts.Confirmed;
    data.rentout_count = counts.Rentout;
    data.cancelled_count = counts.Cancelled;
    data.return_count = counts.Return;

    // ✅ Update table
    parentRow.data(data).invalidate().draw(false);
        }
    });
  
    let modalEl = document.getElementById('confirmActionModal');
    let modal = bootstrap.Modal.getInstance(modalEl);

    // 🔥 Move focus BEFORE closing modal
    document.activeElement.blur();

    modal.hide();
});
$(document).on('click', '.deleteBooking', function () {

   
    let btn = $(this);
    let id = btn.data('id');
    let status = 'Deleted';
    let bookingRef = btn.closest('tr').data('parent');
    let status_val = btn.closest('tr').find('.status-cell span').text().trim();
    if (status_val === 'Rentout' || status_val === 'Extended' || status_val === 'Returned') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'This booking has been '+status_val +'. You cannot delete the booking.',
                'click'
            );
            return;
        
    }
  
     showConfirmModal({
        title: 'Delete Booking',
        message: 'Are you sure you want to delete this booking?',
        confirmText: 'Yes, Delete',
        type: 'danger',
        action: 'delete_booking',
        data: {
            action: 'delete_booking',
            bookingid: id
        },
         extra: {
            btn: btn,
            id: id,
            status: status,
            bookingRef: bookingRef
        }
    });
});

$(document).on('click', '.changeStatus', function () {

    let btn = $(this);
    let id = btn.data('id');
    let vehicleid = btn.data('vehicleid');
    let status = btn.data('status');
    let bookingRef = btn.closest('tr').data('parent');
    let status_val = btn.closest('tr')
                        .find('.status-cell span')
                        .text()
                        .trim();

    if (status_val === 'Rentout') {

        setupDropdown(
            'dropdownContent',
            'danger',
            svgSuccess + 'This booking has been rented out. You cannot change the status of the booking.',
            'click'
        );

        return;
    }
     if (status_val === 'Returned') {

        setupDropdown(
            'dropdownContent',
            'danger',
            svgSuccess + 'This booking has been returned. You cannot change the status of the booking.',
            'click'
        );

        return;
    }
    if (status_val === 'Closed') {

        setupDropdown(
            'dropdownContent',
            'danger',
            svgSuccess + 'This booking has been closed. You cannot change the status of the booking.',
            'click'
        );

        return;
    }
    // Common confirm modal function
    function openConfirmModal() {

        showConfirmModal({
            title: 'Change Status',
            message: `Are you sure you want to change status to <b>${status}</b>?`,
            confirmText: 'Yes, Change',
            type: 'primary',
            action: 'change_booking_status',

            data: {
                action: 'change_booking_status',
                bookingid: id,
                vehicleId:vehicleid,
                bookingstatus: status
            },

            extra: {
                btn: btn,
                id: id,
                status: status,
                bookingRef: bookingRef
            }
        });
    }

    // Check contract only for Rentout
    if (status === 'Rentout') {

        $.ajax({
            url: "/VehicleContractGeneration",
            type: "POST",
            contentType: "application/json",
            dataType: "json",

            data: JSON.stringify({
                bookingid: id,
                action: "checkcontarctgenerate"
            }),

            success: function (response) {

                if (!response.status) {

                    setupDropdown(
                        'dropdownContent',
                        'error',
                        svgError + 'Please generate the contract for the booking and change the status to rentout.',
                        'click'
                    );

                    return;
                }

                // Open modal only if contract exists
                openConfirmModal();
            }
        });

    } else {

        // Directly open modal for other statuses
        openConfirmModal();
    }

});

let modalEl = document.getElementById('contractModal');

if (!modalEl) {
    console.error('Modal not found!');
    return;
}


$(document).on('click', '.generate-contract', function () {
     let btn = this;

    // 🔥 2. Hide tooltip (IMPORTANT)
    let tooltip = bootstrap.Tooltip.getInstance(btn);
    if (tooltip) {
        tooltip.hide();
    }
    
    // reset progress bar
    $('#globalProgressBar')
        .css('width', '0%')
        .removeClass('bg-success bg-danger');

    $('#uploadLoader').addClass('d-none');
    
    
     let id = $(this).data('id'); 
     let vehicleid = $(this).data('vehicle');
     let customer_code = $(this).data('customer_code');
     let booking_ref = $(this).data('booking_ref');
     let model_ids = $(this).data('model_id');
    let status = $(this).closest('tr').find('.status-cell span').text().trim();


    if (status === 'Booked' || status === 'Confirmed' ) {
        
         driverloadDropdown();
         $('#booking_ref').text(booking_ref);
         $('#txt_contract_modal_booking_id').val(id);
         $('#txt_contract_modal_booking_ref_no').val(booking_ref);
         
        openContractModal(id,vehicleid,customer_code,model_ids);
        
    } else if (status === 'Cancelled') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'This booking has been cancelled. You cannot generate a contract for cancelled bookings.',
                'click'
            );
            return;
        
    }
   else {
    setupDropdown(
        'dropdownContent',
        'danger',
        svgSuccess + `You cannot edit the contract details at the current stage. However, you can view the generated contract by clicking the 'Print Contract' button.`,
        'click'
    );
    return;
}
    

});

function openContractModal(id,vehicleid,customer_code,model_ids) {

    $.ajax({
        url: '/VehicleContractGeneration',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            bookingid:id,vehicleid:vehicleid,customer_code:customer_code,model_ids:model_ids
        }),
        success: function (res) {
          populateContractModal(res);
            new bootstrap.Modal(document.getElementById('contractModal')).show();
        }
    });
}
let existingAttachments = {
    vehicles: []
};

function populateContractModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;
   
        $('#c_name').text(data.customer.customer_name || '');
        $('#c_code').text(data.customer.customer_id || '');
        $('#c_mobile').text(data.customer.customer_mobile || '');
        $('#c_email').text(data.customer.customer_email || '');
        $('#c_attn').text(data.customer.customer_attn || '');
        $('#c_attr').text(data.customer.customer_addr || '');
        
        $('#v_no').text(data.vehicle.vehicle_number || '');
        $('#v_model').text(data.vehicle.model_names || '');
        $('#v_brand').text(data.vehicle.brand_name || '');
        $('#v_category').text(data.vehicle.category_name || '');
        $('#v_color').text(data.vehicle.vehicle_color || '');
        $('#v_year').text(data.vehicle.vehicle_year || '');
        $('#v_passing').text(data.vehicle.formatted_next_passing_date || '');
        $('#hid_nxt_passing').val(data.vehicle.next_passing_date || '');  
        $('#v_maintenance').text(data.vehicle.formatted_next_maintenance_date || '');
        $('#hid_nxt_maintenance').val(data.vehicle.next_maintenance_date || '');  
        $('#v_insurance').text(data.vehicle.formatted_next_insurance_date || ''); 
        $('#hid_nxt_insurance').val(data.vehicle.next_insurance_date || '');  
        
        
        $('#hid_vehicle_id').val(data.vehicle.ids || '');
        $('#hid_category_id').val(data.vehicle.category_id || '');
        $('#hid_model_id').val(data.vehicle.model_id || '');
        $('#hid_vehicle_no').val(data.vehicle.vehicle_number || '');
        
       
        
        
        data.price_list.forEach(function(item) {
        
            switch(item.item) {
                case "Price per hour rental without driver":
                    $('#wod_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per hour rental with driver":
                    $('#wd_hourly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental without driver":
                    $('#wod_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per day rental with driver":
                    $('#wd_daily').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental without driver":
                    $('#wod_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per week rental with driver":
                    $('#wd_weekly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental without driver":
                    $('#wod_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
                    break;
                case "Price per month rental with driver":
                   $('#wd_monthly').text(parseFloat(item.amount).toFixed(3) || '0.000');
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
        let rate_type = (data.source === 'rentout') 
            ? bookDetails.rate_type_id 
            : bookDetails.rateType;
        let service = (data.source === 'rentout') 
            ? bookDetails.service_id 
            : bookDetails.service;
        let duration = (data.source === 'rentout') 
            ? bookDetails.duration 
            : bookDetails.duration;
        let unit_price = (data.source === 'rentout') 
            ? bookDetails.unit_price 
            : bookDetails.price;
        let total_amt = (data.source === 'rentout') 
            ? bookDetails.total_amt 
            : bookDetails.total;
        let booking_notes = (data.source === 'rentout') 
            ? bookDetails.booking_notes 
            : bookDetails.notes;
        
        // Set values
        $('#b_from').val(contract.service_start_date_time || '');
        $('#b_to').val(contract.service_end_date_time || '');
        $('#b_qtn_ref_no').val(contract.quotation_number || '');
        
        $('#rate_type').val(rate_type).trigger('change');
        $('#service').val(service).trigger('change');
        
        $('#b_duration').val(duration || 0);
        $('#price').val(unit_price || 0);
        $('#b_vat').val(bookDetails.vat || 0);
        $('#b_total').val(total_amt || 0);
        $('#txt_booking_notes').val(booking_notes || '');
       
        $('#dropdownContainer #driverSelect').val(contract.driver_ids).trigger('change');
       updateMinPrice();
       
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
          let currentOdo = (data.vehicle && data.vehicle.odo_meter && data.vehicle.odo_meter != '0') ? data.vehicle.odo_meter : '';
          $('#km_out').val(vehicle_accessiories_details.vehicle_km_out || currentOdo);
        $('#fuel_level').val(vehicle_accessiories_details.fuel_level || '');
        
          let defaultDtOut = '';
          try {
              defaultDtOut = new Date().toLocaleString('sv-SE', { timeZone: 'Asia/Bahrain' }).replace(' ', 'T').slice(0, 16);
          } catch(e) {
              let now = new Date();
              defaultDtOut = now.getFullYear() + '-' +
                  String(now.getMonth() + 1).padStart(2, '0') + '-' +
                  String(now.getDate()).padStart(2, '0') + 'T' +
                  String(now.getHours()).padStart(2, '0') + ':' +
                  String(now.getMinutes()).padStart(2, '0');
          }
          $('#dt_out').val(vehicle_accessiories_details.date_out || defaultDtOut);
        let today = new Date().toISOString().split('T')[0];
        $('#dt_contract_date').val(contract.agreement_date || today);
        
       $('#cust_driver').val(contract.customer_driver_name || '');
       $('#cust_driver_contact_no').val(contract.customer_driver_contact_number || '');
       let termsCondition = contract.terms_condition || '';
       fullEditorOnBody.root.innerHTML = termsCondition;
    
// 🔥 clear preview first
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

                <span class="delete-img-vehicle"
                      data-id="${id}"
                      data-image="${img}"
                       data-file="${img}"
                      data-type="db"
                      style="position:absolute;top:-5px;right:-5px;
                             background:red;color:white;border-radius:50%;
                             padding:2px 6px;cursor:pointer;font-size:12px;">
                    ✕
                </span>
            </div>
        `);

    });
console.log(existingFileNames);
       
    }


function updateMinPrice() {
    let rateType = $('#rate_type').val();
    let service = $('#service').val();

    let prefix = (service === '1') ? 'wod_' : 'wd_';

    let selectorMap = {
        hour: prefix + 'hourly',
        day: prefix + 'daily',
        week: prefix + 'weekly',
        month: prefix + 'monthly'
    };

    let selectedId = selectorMap[rateType];

    if (selectedId && $('#' + selectedId).length) {
        let value = $.trim($('#' + selectedId).text());
        $('.min-price-text').text('Min: ' + (value || '0.000'));
        $('.minprice').val(value);
    } else {
        $('.min-price-text').text('Min: 0.000');
        $('.minprice').val(0);
    }
}

$('#rate_type, #service').on('change', function () {
    updateMinPrice();
});


 let DecimalPositions = 3;  
function line_item_calculation()
{
   
   let from = new Date($('#b_from').val());
   let to = new Date($('#b_to').val());
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

       $('#b_duration').val(duration_count);

        
        let price = parseFloat($('.price').val()) || 0;
        let qty = 1;
        let vat = parseFloat($('#b_vat').val()) || 0;

        let total = (price * qty * duration_count) * (1 + vat/100);
        
        $('#b_total').val(total.toFixed(DecimalPositions));

    }
}


$(document).on('blur','#b_to',function(){

  
    let from = $('#b_from').val();
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

$('.service').on('change', function () {

    let vatValue = $(this).find('option:selected').data('id');

    if (vatValue !== undefined) {
        $('#b_vat').val(vatValue);
    }

    // optional: trigger recalculation
    $('#b_vat').trigger('input');
    
    
    
     let serviceVal = $(this).val();

    if (serviceVal == "1") {
        // Rental Without Driver 
        $('.driverclass').hide();
        $('.driverClasstext').text('');
        driverloadDropdown();
        
    }
  
});


$('.service, .rate_type, #b_from, #b_to, .price, #b_vat #b_duration')
.on('input change', function () {
    otpVerified = false;
 $('#otpdiv').hide();
 $('#p_otp_minprice_info').text('');
    line_item_calculation();
});


$(document).on('input change', '.watch-field', function () {
   
   
    line_item_calculation();
     
});
    function driverloadDropdown() {
       $('#dropdownContainer').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading Driver...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadDriverSelect',
            type: 'GET',
            success: function (response) {
                $('#dropdownContainer').html(response);

                 $('#driverSelect').select2({
                placeholder: "Select Driver",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#dropdownContainer') // 🔥 important (modal fix)
            });
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
     $('.driverclass').hide();
let isResettingDriver = false;

$(document).on('change', '#driverSelect', function () {

    if (isResettingDriver) return; // 🚫 prevent loop

    let serviceVal = $('#service').val();

    if (serviceVal == "1") {

       

        $('.driverClasstext').text('');
        $('.driverclass').hide();

        isResettingDriver = true;
$('#dropdownContainer #driverSelect').val(0).trigger('change');
      //  $('#driverSelect').val('0'); // reset safely
        //driverloadDropdown();

        isResettingDriver = false;
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + "You cannot select a driver for Rental Without Driver service.",
            'click'
        );
        return;
    }

    // ✅ Normal flow
    let selected = $(this).find(':selected');

    let driver_name = selected.text();
    let contat_number = selected.data('id');
    let licenseNo = selected.data('license_no');
    let licensePlace = selected.data('license_place');
    let licenseIssue = selected.data('license_id');
    let licenseExpiry = selected.data('license_ed');

    $('.driverclass').show(); 
    $('#d_name').text(driver_name);
    $('#d_mobile').text(contat_number);
    $('#d_license_no').text(licenseNo);
    $('#d_license_issue_place').text(licensePlace);
    $('#d_licenseissueDate').text(licenseIssue);
    $('#d_licenseexpiryDate').text(licenseExpiry);
});

let carImageQueue = [];
let existingVehicleImages = [];

let uploadedFileNames = [];
let existingFileNames = [];


$('#carImages').on('change', function(e) {

    // reset progress bar
    $('#globalProgressBar')
        .css('width', '0%')
        .removeClass('bg-success bg-danger');

    $('#uploadLoader').addClass('d-none');

    let files = e.target.files;

    Array.from(files).forEach(file => {

        let id = Date.now() + Math.random();

        carImageQueue.push({
            id: id,
            file: file
        });

        let reader = new FileReader();

        reader.onload = function(e) {

            $('#preview').append(`
                <div class="position-relative"
                     id="img-${id}"
                     data-file="${file.name}">

                    <img src="${e.target.result}" 
                         class="rounded border vehicle-preview-img"
                         data-id="${id}"
                         data-file="${file.name}"
                         style="width:80px;height:80px;object-fit:cover;">

                    <span class="delete-img-vehicle"
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
$('#uploadBtn').on('click', function () {

    if (carImageQueue.length === 0) {
        alert('Please select images');
        return;
    }

    // reset progress
    $('#globalProgressBar')
        .css('width', '0%')
        .removeClass('bg-success bg-danger');

    // show loader
    $('#uploadLoader').removeClass('d-none');

    let formData = new FormData();

    carImageQueue.forEach((item) => {
        formData.append('car_images[]', item.file);
    });

    $.ajax({

        url: '/CompressUploadImage',
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

                    $('#globalProgressBar')
                        .css('width', percent + '%');
                }
            };

            return xhr;
        },

        success: function (res) {

            $('#globalProgressBar')
                .css('width', '100%')
                .addClass('bg-success');

            uploadedFileNames.push(
                ...(res.files || [])
            );

            // hide loader
            $('#uploadLoader').addClass('d-none');

            // clear queue after upload
            carImageQueue = [];

        },

        error: function () {

            $('#globalProgressBar')
                .addClass('bg-danger');

            $('#uploadLoader').addClass('d-none');
        }
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

$('#deleteVehiclePreviewImageBtn').on('click', function () {

    if (!currentVehiclePreviewId) return;

    let el = document.getElementById('img-' + currentVehiclePreviewId);

    if (el) {

        // get file name
        let fileName = $(el).attr('data-file');

        // 🔥 delete physical file from server
        if (fileName) {

            $.post('/DeleteUploadImage', {
                file: fileName
            });
        }

        // 🔥 DB image
        if (String(currentVehiclePreviewId).startsWith('db_')) {
       
       
        let pureFileName = fileName.split('/').pop();

        // find index
        let index = existingFileNames.indexOf(pureFileName);

        // remove from array
        if (index !== -1) {
    
            existingFileNames.splice(index, 1);
        }
   

        } else {

            // 🔥 newly uploaded image
            carImageQueue = carImageQueue.filter(
                item => item.id != currentVehiclePreviewId
            );

            uploadedFileNames = uploadedFileNames.filter(
                item => item !== fileName
            );
        }

        // remove preview
        el.remove();
    }

    // close modal
    let modalEl = document.getElementById('imagePreviewModal');

    let modal = bootstrap.Modal.getInstance(modalEl);

    if (modal) {
        modal.hide();
    }

    // clear modal body
    $('#VehiclefilePreviewBody').empty();

    currentVehiclePreviewId = null;

});


$(document).on('click', '.delete-img-vehicle', function (e) {

    e.preventDefault();
    e.stopPropagation();

    let id = $(this).data('id');

    let el = document.getElementById('img-' + id);

    if (!el) return;

    // get file name
    let fileName = $(el).attr('data-file');

    // 🔥 delete physical file from server
    if (fileName) {

        $.post('/DeleteUploadImage', {
            file: fileName
        });
    }

    // 🔥 existing DB image
    if (String(id).startsWith('db_')) {

        let pureFileName = fileName.split('/').pop();

        // find index
        let index = existingFileNames.indexOf(pureFileName);

        // remove from array
        if (index !== -1) {
    
            existingFileNames.splice(index, 1);
        }

    } else {

        // 🔥 remove from upload queue
        carImageQueue = carImageQueue.filter(
            item => item.id != id
        );

        // 🔥 remove uploaded filename array
        uploadedFileNames = uploadedFileNames.filter(
            item => item !== fileName
        );
    }

    // remove preview from DOM
    el.remove();

});



 let bookingMaster = {
        vehicles: []
    };
 let vehiclesObj = {
    documentName: '',
    files: []
};
function resetRentCustDriverUploadProgress() {
    $('#uploadrentCustDriverImageDocumentProgress')
        .css('width', '0%')
        .text('0%');

    $('#uploadrentCustDriverImageDocumentStatus').html('');
    $('#rentCustDriverImage_upload_status').html('');
}
$(document).on('click', '.openAddCustDriverDocModal', function(e) {
    
            e.preventDefault();
            e.stopPropagation();
            resetRentCustDriverUploadProgress();
            const modalEl = document.getElementById('addRentalCustDriverImageModal');

            setTimeout(() => {
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }, 300);
        });

            const validationsRentCarImage = [{
                    id: '#rentCustDriverImageName',
                    msg: 'Please enter document name'
                },
                {
                    id: '#rentCustDriverImage_document',
                    msg: 'Please select a file',
                    type: 'file'
                }
            ];
              function validateForm(displayErrorDiv, validateFor) {
                for (let v of validateFor) {
                    if (v.type === 'file') {
                        if (!$(v.id)[0].files.length) return showError(v.id, v.msg, displayErrorDiv);
                    } else {
                        if (!$(v.id).val()) return showError(v.id, v.msg, displayErrorDiv);
                    }
                }
                return true;
            }

            function showError(selector, message, displayErrorDiv) {
                $('#' + displayErrorDiv)
                    .html(`<span class="text-danger">${message}</span>`);
                $(selector).focus();
                return false;
            }
             function resizeImage(file, callback) {
                const reader = new FileReader();
                const img = new Image();

                reader.onload = e => img.src = e.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');

                    const MAX = 2000;
                    let w = img.width;
                    let h = img.height;

                    if (w > MAX || h > MAX) {
                        const ratio = Math.min(MAX / w, MAX / h);
                        w *= ratio;
                        h *= ratio;
                    }

                    canvas.width = w;
                    canvas.height = h;
                    canvas.getContext('2d').drawImage(img, 0, 0, w, h);

                    canvas.toBlob(blob => callback(blob), 'image/jpeg', 0.85);
                };

                reader.readAsDataURL(file);
            }
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

    let carRequiredControls = {
        validationStatusId: 'rentCustDriverImage_upload_status',
        validationFunctionName: validationsRentCarImage,
        fileInputId: '#rentCustDriverImage_document',
        formId: 'addCustDriverDetails',
        folderName: 'custDriverDocs',
        documentTypeControlId: '#rentCustDriverImageName',
        callFunction : uploadCustDriverFiles
    };     
   $('#addrentCarImageButton').on('click', function (e) {
                
        let clickedButton = this.id;
    
        if (clickedButton === 'addrentCarImageButton') {
    
            addBookingAndUploadImagesFunction(carRequiredControls);
        }

    
    });
    

  function addBookingAndUploadImagesFunction(RequiredControlsNames){
                    
     if (!validateForm(RequiredControlsNames.validationStatusId, RequiredControlsNames.validationFunctionName)) return;

        const files = $(RequiredControlsNames.fileInputId)[0].files;
        if (!files.length) return;

        const form = document.getElementById(RequiredControlsNames.formId);
        const tempFormData = new FormData(form);

        tempFormData.append('foldername', RequiredControlsNames.folderName);
        tempFormData.append('documentType', $(RequiredControlsNames.documentTypeControlId).val());

        let processed = 0;

        Array.from(files).forEach((file) => {

            if (file.type.startsWith('image/')) {

                resizeImage(file, function (blob) {
                    tempFormData.append('files[]', blob, file.name);
                    processed++;
                    //if (processed === files.length) uploadDriverFiles(tempFormData);
                    if (processed === files.length) RequiredControlsNames.callFunction(tempFormData);
                    
                });

            } else {

                tempFormData.append('files[]', file);
                processed++;
                //if (processed === files.length) uploadDriverFiles(tempFormData);
                if (processed === files.length) RequiredControlsNames.callFunction(tempFormData);

            }

        });

    }
    function uploadCustDriverFiles(tempFormData) {

                    $.ajax({
                        url: '/UploadDocumentsCompressed',
                        type: 'POST',
                        data: tempFormData,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            let xhr = new XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(e) {
                                if (e.lengthComputable) {
                                    let percent = Math.round((e.loaded / e.total) * 100);
                                    $('#uploadrentCustDriverImageDocumentProgress')
                                        .css('width', percent + '%')
                                        .text(percent + '%');
                                }
                            }, false);
    
                            return xhr;
                        },
                        beforeSend: function () {
                            
                            $('#uploadrentCustDriverImageDocumentProgress')
                            .css('width', '0%')
                            .text('0%');

                            $('#rentCustDriverImage_upload_status').html('Uploading...');

                            $('#rentCustDriverImage_loader_spinner').show();
                        },

                        success: function (res) {
                            $('#uploadrentCustDriverImageDocumentProgress')
                            .css('width', '100%')
                            .text('100%');
                            $('#uploadrentCustDriverImageDocumentStatus').html('Process Completed Successfully');
                            $('#rentCustDriverImage_upload_status').html(res.messsage);
                            if (res.status !== 'success') return;

                           
                            vehiclesObj = {
                                documentName: $('#rentCustDriverImageName').val(),
                                files: []
                            };
                      
                            
                            res.data.forEach(item => {

                                let fileUrl = (item.type === 'image') ? item.webp : item.file;

                                vehiclesObj.files.push(fileUrl);
                                let fileName = fileUrl.split('/').pop();

                               
                                    
                                // Preview UI
                                let previewSrc = getDocumentPreview(fileUrl);

                              let liHtml = `
                                        <li
                                            data-img="${fileUrl}"
                                            data-type="new"
                                            data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom"
                                            data-bs-placement="top"
                                            title="${res.uploaded_by}"
                                            class="avatar avatar-lg pull-up">
                                            <img class="rounded-circle"
                                                 src="${previewSrc}"
                                                 alt="${res.uploaded_by}" />
                                        </li>
                                    `;

                                $('#contractcustdriverdocpreview').append(liHtml);

                            });
                            
                            let tooltipTriggerList = [].slice.call(
                                document.querySelectorAll('[data-bs-toggle="tooltip"]')
                            );
                            tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                            
                            if (!bookingMaster.vehicles) {
                                bookingMaster.vehicles = [];
                            }
                            
                            bookingMaster.vehicles.push(vehiclesObj);

                            console.log("Master Object:", bookingMaster);

                            // Reset Form
                           
                            $('#addCustDriverDetails')[0].reset();

                            $('#rentCustDriverImage_loader_spinner').hide();
                        },
                        error: function() {
                            $('#rentCustDriverImage_upload_status').html('<span class="text-danger">Upload failed. Please try again.</span>');
                            $('#rentCustDriverImage_loader_spinner').hide();
                        }

                    });

                }
                
                 let currentPreviewLi = null;
   
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
                
    $('#deletePreviewImageBtn').on('click', function(){
                if(!currentPreviewLi) return;
            
                let imgSrc = currentPreviewLi.data('img');
            
                $.ajax({
                    url: '/DeleteUploadDocuments',
                    type: 'POST',
                    data: { file: imgSrc },
                    dataType: 'json',
                    success: function(res){
                        if(res.status === 'success'){
                            // Remove preview li
                            currentPreviewLi.remove();
                            $('#filePreviewModal').modal('hide');
                            currentPreviewLi = null;
                            removeFileFromBookingMaster(imgSrc);
                            //console.log('Deleted files:', res.deleted);
                        } else {
                            alert('Delete failed: ' + res.message);
                        }
                    },
                    error: function(xhr){
                        console.error(xhr.responseText);
                        alert('Server error while deleting files.');
                    }
                });
            });
            
    function removeFileFromBookingMaster(filePath){

                if (!bookingMaster || !Array.isArray(bookingMaster.vehicles)) return;
            
                bookingMaster.vehicles = bookingMaster.vehicles
                    .map(vehicle => {
                        if (Array.isArray(vehicle.files)) {
                            vehicle.files = vehicle.files.filter(f => f !== filePath);
                        }
                        return vehicle;
                    })
                    .filter(vehicle => Array.isArray(vehicle.files) && vehicle.files.length > 0);
            
                console.log('Updated bookingMaster:', bookingMaster);
            }
            function removeFromUploadedQueue(filePath) {

    let clean = normalizePath(filePath);

    uploadedFileNames = uploadedFileNames.filter(f =>
        normalizePath(f) !== clean
    );

    carImageQueue = carImageQueue.filter(item =>
        item.file.name !== filePath &&
        item.file !== filePath
    );
}
function normalizePath(path) {

    if (!path) return '';

    return path
        .replace(window.location.origin + '/', '')
        .replace(/^\/+/, '')
        .trim();
}

let laddaSaveContract = Ladda.create(
    document.querySelector('#btn_save_contract')
);

$('#btn_save_contract').on('click', function (e) {

saveContractValidation(e);

});
function saveContractValidation(e)
{
    if (e) {
        e.preventDefault();
    }

       if (!$('#b_from').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide from date", 'click');
        return;
    }

    if (!$('#b_to').val()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide to date", 'click');
        return;
    }
    
    if (new Date($('#b_to').val()) < new Date($('#b_from').val())) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide valid date range", 'click');
        return;
    }
    if (new Date($('#b_to').val()) < new Date($('#b_from').val())) {
        setupDropdown('dropdownContent', 'error', svgError + "Please provide valid date range", 'click');
        return;
    }
    let unitPrice = parseFloat($('#price').val()) || 0;
    let minPrice = parseFloat($('.minprice').val()) || 0;

    // ✅ OTP REQUIRED
    if (unitPrice < minPrice && !otpVerified) {

        let data = {
            customer: $('#c_name').text().trim(),
            veh_model: $('#v_model').text().trim(),
            veh_no: $('#v_no').text().trim(),
            unit_price: unitPrice,
            min_price: minPrice,
            booking_ref_no: $('#booking_ref').text().trim(),
            book_period_from: $('#b_from').val(),
            book_period_to: $('#b_to').val()
        };

        $('#otp_require_basic_details').val(JSON.stringify(data));

        $('#enableOTP').modal('show');

        return;
    }
    else
    {
         // ✅ Continue remaining validations
    proceedContractValidations();
    }

   
}

function proceedContractValidations()
{
     let from = new Date($('#b_from').val());
     let to = new Date($('#b_to').val());

    let passingDate = $('#hid_nxt_passing').val();
    let insuranceDate = $('#hid_nxt_insurance').val();
    let maintenanceDate =$('#hid_nxt_maintenance').val();
    let km_out_val = $.trim($('#km_out').val());
    let fuel_level_val = $.trim($('#fuel_level').val());
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

    if (!km_out_val) {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + ' Please provide odometer value(km out).',
            'click'
        );

        return;
    }
    if (!fuel_level_val) {
        setupDropdown(
            'dropdownContent',
            'error',
            svgError + ' Please provide fuel level.',
            'click'
        );

        return;
    }
    if (showConfirm) {

        message += '<br><b>Do you want to continue?</b>';

        $('#confirmMessage').html(message);

        new bootstrap.Modal(
            document.getElementById('customConfirmModal')
        ).show();

    } else {

        saveContract();
    }
}
$('#confirmYesBtn').on('click', function () {

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('customConfirmModal')
    );

    modal.hide();

    saveContract();

});
$('#confirmOTPYesBtn').on('click', function () {

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('customConfirmModalAfterOTPValidation')
    );

    modal.hide();

    // ✅ Continue validations after OTP success
    proceedContractValidations();

});
function saveContract()
{
   laddaSaveContract.start();
    let booking_ids = $('#txt_contract_modal_booking_id').val();
    let booking_ref_no = $('#txt_contract_modal_booking_ref_no').val();
    let agreement_date=$('#dt_contract_date').val();
    let contract_ids = $('#txt_contract_modal_contract_id').val();
    let data_source_val = $('#txt_contract_modal_data_source').val();
     var termsContentval = fullEditorOnBody.root.innerHTML;
  
const allVehicleImages = existingFileNames.concat(uploadedFileNames);

    let customer_data = {
                customer_name: $('#c_name').text().trim(),
                customer_code: $('#c_code').text().trim(),
                customer_mobile: $('#c_mobile').text().trim(),
                customer_email: $('#c_email').text().trim(),
                customer_attention: $('#c_attn').text().trim(),
                customer_address: $('#c_attr').text().trim()
                };
    let vehicle_data = {
                vehicle_id: $('#hid_vehicle_id').val(),
                category_id: $('#hid_category_id').val(),
                model_id: $('#hid_model_id').val(),
                veh_no: $('#hid_vehicle_no').val(),
                category_name: $('#v_category').text().trim(),
                model_name: $('#v_model').text().trim(),
                vehicle_color: $('#v_color').text().trim(),
                vehicle_year: $('#v_year').text().trim()
                };
    let contract_details = {
                period_from: $('#b_from').val(),
                period_to: $('#b_to').val(),
                rate_type_id: $('#rate_type').val(),
                rate_type: $('#rate_type option:selected').text(),
                service_id: $('#service').val(),
                service_name: $('#service option:selected').text(),
                duration: $('#b_duration').val(),
                unit_price: $('#price').val(),
                min_price: $('.minprice').val(),
                vat: $('#b_vat').val(),
                total_amt: $('#b_total').val(),
                qtn_ref_no: $('#b_qtn_ref_no').val(),
                booking_notes: $('#txt_booking_notes').val(),
                otp_details: $('#p_otp_minprice_info').text().trim()
                
                };     
  let company_driver_details ={
                driver_id: $('#driverSelect').val(),
                driver_name: $('#driverSelect option:selected').text(),
                driver_mobile: $('#d_mobile').text().trim(),
                driver_license_no: $('#d_license_no').text().trim(),
                driver_license_issplace: $('#d_license_issue_place').text().trim(),
                driver_license_issdate: $('#d_licenseissueDate').text().trim(),
                driver_license_expdate: $('#d_licenseexpiryDate').text().trim()
                };   
let vehicle_accessories ={
                chk_tools: $('#chk_tools').is(':checked') ? 'Yes' : 'No',
                chk_spare: $('#chk_spare').is(':checked') ? 'Yes' : 'No',
                chk_radio: $('#chk_radio').is(':checked') ? 'Yes' : 'No',
                date_out: $('#dt_out').val(),
                vehicle_km_out: $('#km_out').val(),
                fuel_level: $('#fuel_level').val(),
                cust_driver_name: $('#cust_driver').val(),
                cust_driver_contact_no: $('#cust_driver_contact_no').val(),
                cust_driver_documents: bookingMaster,
                vehicle_images:allVehicleImages
                };
                $.ajax({
                    url: '/VehicleContractGeneration',
                    type: 'POST',
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                
                    data: JSON.stringify({
                        action: 'contractGeneration',
                        booking_ids: booking_ids,
                        booking_ref_no: booking_ref_no,
                        agreement_date:agreement_date,
                        customer_data: customer_data,
                        vehicle_data: vehicle_data,
                        contract_details: contract_details,
                        company_driver_details: company_driver_details,
                        vehicle_accessories: vehicle_accessories,
                        termsContent: termsContentval,
                        contract_ids:contract_ids,
                        data_source_val:data_source_val
                    }),
                
                    success: function (res) {
                        console.log(res);
                        laddaSaveContract.stop();
                       if (res.status)
                        {
                            setupDropdown(
                                'dropdownContent',
                                'success',
                                svgSuccess + res.message,
                                'click'
                            );
                        
                            let modal = bootstrap.Modal.getInstance(
                                document.getElementById('contractModal')
                            );
                        
                            if (modal) {
                                modal.hide();
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
                        laddaSaveContract.stop();
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
 $('#otpdiv').hide();
 $('#p_otp_minprice_info').text('');

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
            
                $('#otpdiv').show();
                $('#p_otp_minprice_info').text(res.info_message);
            
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
$('#btn_terms_condition').click(function(){
    $('#termsTable').DataTable().ajax.reload(null, false);
  
    fullEditor.root.innerHTML ='';
    $('#t_c_name').val('');
    $('#termsAndConditionModal').modal('show');
})
$('#saveTermsAndConditions').click(function () {

    var laddaBtn = Ladda.create(document.querySelector('#saveTermsAndConditions'));
    laddaBtn.start();

    let htmlContentTC = fullEditor.root.innerHTML;

    $.ajax({
         url: "/VehicleContractGeneration",
            type: "POST",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({
                action: 'SaveTermsCondition',
                terms_condition: htmlContentTC,
                t_c_name: $('#t_c_name').val()
            }),

        success: function (response) {

            setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + ' Terms & Condition Saved Successfully',
                'click'
            );

            laddaBtn.stop();

            $('#termsTable').DataTable().ajax.reload(null, false);
        },

        error: function () {

            setupDropdown(
                'dropdownContent',
                'danger',
                svgError + ' Error saving data',
                'click'
            );

            laddaBtn.stop();
        }
    });

});
 
$('#termsTable').DataTable({
    ajax: {
        url: "/VehicleContractGeneration",
        type: "POST",

        contentType: "application/json",

        data: function () {
            return JSON.stringify({
                action: "LoadTermsCondition"
            });
        },

        dataSrc: "data"
    },

    processing: true,
    serverSide: false,

    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            },
            orderable: false
        },

        { data: "t_c_name" },

        {
            data: "terms_condition",
            className: "description"
        },

        {
            data: null,
            render: function(data, type, row){
                return `
                    <i class="ri ri-delete-bin-line text-danger deleteRowTermsCondition"
                       style="cursor:pointer; font-size:1.5rem;"
                       data-id="${row.ids}">
                    </i>
                `;
            },
            orderable: false
        },

        {
            data: null,
            render: function(data, type, row){
                return `
                    <i class="ri ri-eye-line text-primary showRowTermsCondition"
                       style="cursor:pointer; font-size:1.5rem;"
                       data-id="${row.ids}">
                    </i>
                `;
            },
            orderable: false
        }
    ]
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
let varDeleteTC;
$(document).on("click", ".deleteRowTermsCondition", function() {

    varDeleteTC = $(this).data("id");
    SaNDSAlert('Are you sure you want to delete this entry?','DeleteTerms','danger','#C70039','Yes, I am sure');
    
});


function deleteTermsAndCondition()
{
    $.ajax({
        url: "/VehicleContractGeneration",
        type: "POST",
        contentType: "application/json",
        dataType: "json",

        data: JSON.stringify({
            tc_ids: varDeleteTC,
            action: "deleteTermsCondition"
        }),

        success: function(res) {

            if (res.status === true) {

                setupDropdown(
                    'dropdownContent',
                    'success',
                    svgSuccess + 'Deleted successfully',
                    'click'
                );

                $('#termsTable').DataTable().ajax.reload(null, false);

            } else {

                setupDropdown(
                    'dropdownContent',
                    'error',
                    svgError + res.message,
                    'click'
                );
            }
        },

        error: function(xhr) {

            console.log(xhr.responseText);

            setupDropdown(
                'dropdownContent',
                'error',
                svgError + 'Server error',
                'click'
            );
        }
    });
}


$(document).on("click", ".showRowTermsCondition", function() {

    var showTCId = $(this).data("id");

    var laddaBtn = Ladda.create(this);
    laddaBtn.start();

    $.ajax({
        url: "/VehicleContractGeneration",
        type: "POST",
        contentType: "application/json",
        dataType: "json",

        data: JSON.stringify({
            tc_ids: showTCId,
            action: "LoadTermsConditionToEditor"
        }),

        success: function (response) {

            fullEditor.root.innerHTML = response.html;

            setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + ' Loaded Successfully',
                'click'
            );

            laddaBtn.stop();
        },

        error: function (xhr) {

            console.log(xhr.responseText);

            setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + ' Error loading data',
                'click'
            );

            laddaBtn.stop();
        }
    });

});

$('#copyTCBtn').click(function () {
                
    var content = fullEditor.root.innerHTML;
    fullEditorOnBody.root.innerHTML = content;
    $('#termsAndConditionModal').modal('hide');

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
    $('#bookingTable1 tbody .booking_checkbox:checked').each(function () {

        selectedBookingIds.push($(this).data('id'));

    });

  

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
    let customer_name = btn.data('customer_name');
    
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
     if (status === 'Returned' || status === 'Closed' || status === 'Rentout' || status === 'Extended') {
        setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess + 'You cannot apply the signature at the current stage.',
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
    
                openSignatureModal(customer_name);
            }
        });
   
        
});
function openSignatureModal(customer_name = null)
{
    
    
    $('#signatureModal').modal('show');
    if(customer_name){
        $('#hirer_name').val(customer_name);
    }
    else
    {
        $('#hirer_name').val(customer_name);
    }
     
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
         if (
    ['cancelled', 'rentout', 'extended', 'returned', 'closed']
        .includes(status.toLowerCase())
)  {

            checkbox.prop('checked', false);

            setupDropdown(
                'dropdownContent',
                'danger',
                svgSuccess +
                'You cannot apply the signature at the current stage.',
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
$(document).on('click', '.print-contract', function () {
     let btn = this;

    // 🔥 2. Hide tooltip (IMPORTANT)
    let tooltip = bootstrap.Tooltip.getInstance(btn);
    if (tooltip) {
        tooltip.hide();
    }
     let id = $(this).data('id'); 
      $.ajax({
            url: "/VehicleContractGeneration",
            type: "POST",
            contentType: "application/json",
            dataType: "json",

            data: JSON.stringify({
                bookingid: id,
                action: "checkcontarctgenerate"
            }),

            success: function (response) {

                if (!response.status) {

                    setupDropdown(
                        'dropdownContent',
                        'error',
                        svgError + 'Please generate the contract for the booking and change the status to rentout.',
                        'click'
                    );

                    return;
                }
fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(response.agreement_no)))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/PrintAgreement?token=' + encodeURIComponent(token), '_blank');
        });
                // let url = "/PrintAgreement?contract_no="+response.agreement_no;

                // window.open(url, '_blank');
            }
        });
     
});




//Direct Contract Generation or Walkin
$('#QtnAddNewCustomerModal').on('shown.bs.modal', function () {
    $(this).css('z-index', 1065);
    $('.modal-backdrop').last().css('z-index', 1060);
});
$('#btnWalkIns').on('click mouseleave blur', function () {
    var tooltip = bootstrap.Tooltip.getInstance(this);
    if (tooltip) {
        tooltip.hide();
    }
});

$('#btnWalkIns').on('click', function () {
    var modal = new bootstrap.Modal(document.getElementById('walkInsModal'));
    modal.show();
});

$('#selectCustomerFromSelect2_contract').select2({
     dropdownParent: $('#walkInsModal'),
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

    templateResult: formatCustomerContract,
    templateSelection: formatCustomerSelectionContract
});

function formatCustomerContract(customer) {
    if (!customer.id) return customer.text;

    return $(`
        <div>
            <strong>${customer.customer_name} | ${customer.customer_mobile} | ${customer.customer_cr_cpr}</strong>
        </div>
    `);
}

function formatCustomerSelectionContract(customer) {
    return customer.customer_name
        ? `${customer.customer_name}`
        : customer.text;
}


$('#selectCustomerFromSelect2_contract').on('select2:select', function (e) {
    let data = e.params.data;
    $('#customer_code_contract').val(data.customer_code);
    $('#customerName_contract').val(data.customer_name);
    $('#customerPhone_contract').val(data.customer_mobile);
    $('#customerEmail_contract').val(data.customer_email);
    $('#customerAddress_contract').val(data.customer_address);
    $('#customerAttention_contract').val(data.customer_attn);
    $('#customercprcr_contract').val(data.customer_cr_cpr);
});


$('#selectCustomerFromSelect2_contract').on('select2:clear', function () {
    $('#customerName_contract').val('');
    $('#customer_code_contract').val('');
    $('#customerPhone_contract').val('');
    $('#customerEmail_contract').val('');
    $('#customerAddress_contract').val('');
    $('#customerAttention_contract').val('');
    $('#customercprcr_contract').val('');
}); 
 $('#vehicleModel').select2({
    dropdownParent: $('#dropdownContainerContract'),
    width: '100%',
     allowClear: true
}); 

$('#vehicleModelAvail').select2({
    dropdownParent: $('#checkavailabilityModal'),
    width: '100%',
     allowClear: true
}); 
    modelloadDropdown();

   function modelloadDropdown() {

    $('#dropdownContainerContract').html(`
        <div class="text-center p-3">
            <div class="spinner-border text-primary"></div>
            <div class="mt-2">Loading models...</div>
        </div>
    `);

    $.ajax({
        url: '/LoadVehicleModelReservation',
        type: 'GET',
        success: function (response) {

            $('#dropdownContainerContract').html(response);

            $('#vehicleModel').select2({
                dropdownParent: $('#walkInsModal'),
                placeholder: 'Select Model',
                width: '100%',
                allowClear: true
            });
        }
    });
}
    function modelloadDropdownAvail() {
      $('#dropdownContaineravail').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading models...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadVehicleModelReservationAvail',
            type: 'GET',
            success: function (response) {
                $('#dropdownContaineravail').html(response);

                $('#vehicleModelAvail').select2({
                    placeholder: "Select Model",
                    dropdownParent: $('#checkavailabilityModal'),
                    allowClear: true,
                    width: '100%'
                });
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
    
$(document).on('select2:select', '#vehicleModel', function (e) {

    let modelId = $('#vehicleModel').val();
     $('#ModelRef_contract').val(modelId).trigger('change');;
    let fromdate= $('.from_datetime_contract').val();
    let todate =  $('.to_datetime_contract').val();
     fromdate = fromdate ? fromdate : 'NA';
     todate   = todate ? todate : 'NA';
        if(fromdate=='NA' || todate=='NA')
        {
          loadVehiclesTable(modelId, '0') 
        }
        else
        {
            loadVehiclesTableAvailability(modelId, fromdate, todate);
        }
    
});
  $(document).on('click', '#closeAvailabilityBar', function () {
     $('#vehicleAvailabilityContent').html('');
    $('#vehicleAvailabilityBar').hide();
});
let selectedVehicles = [];
function loadVehiclesTable(modelId, vehicleNumber) {
  
    $('#vehicleContainer').html('<div class="p-3 text-center">Loading...</div>');

    $.ajax({
      url: '/VehicleStatusController',
      method: 'POST',
      data: {
        modelId: modelId,
        vehicleNumber:vehicleNumber,
        action: 'get_vehicle_details_reservation'
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
                    $btn.html('<i class="ri ri-close-line icon-18px"></i>');
                } else {
                    $(this).removeClass('selected'); // normal
                    $btn.removeClass('btn-outline-danger').addClass('btn-primary');
                    $btn.attr('title', 'Select').attr('data-bs-original-title', 'Select');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-check-line icon-18px"></i>');
                }
            });
      },
      error: function() {
         
        $('#vehicleContainer').html('<div class="text-danger">Failed to load</div>');
      }
    });
  }
  
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
$('#vehicleSearch').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();

        $('#vehicleContainer .vehicle-card').each(function() {
           
            var vehicleNumber = $(this).find('.veh_no').text().toLowerCase();

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
        fromDate: $('.from_datetime_contract').val(),
        toDate: $('.to_datetime_contract').val(),
        rateType: $('.rate_type_contract').val(),
        service: $('.service_contract').val(),
        rateTypeText:  $.trim($('.rate_type_contract option:selected').text()),
        serviceText: $.trim($('.service_contract option:selected').text()),
        duration: $('.duration_contract').val(),
        price: $('.price_contract').val(),
        vat: $('.vat_contract').val(),
        total: $.trim($('#lineTotal_contract').text()),
        notes: $('#booking_notes_contract').val(),
        customerName: $('#customerName_contract').val(),
        customerCode: $('#customer_code_contract').val(),
        customerPhone: $('#customerPhone_contract').val(),
        customerEmail: $('#customerEmail_contract').val(),
        customerAddress: $('#customerAddress_contract').val(),
        customerAttention: $('#customerAttention_contract').val(),
        customer_cr_cpr: $('#customercprcr_contract').val(),
        quotation_ref: $('#quotationRef').val(),
        book_through: 'direct'
    };
}


$(document).on('click', '.btn_vehicle_select', function () {

    const $btn = $(this);
    const $card = $btn.closest('.vehicle-card');
    const bookingDetails = getBookingDetails();

    // ✅ VALIDATION
    if (!bookingDetails.customerCode?.trim()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please select customer", 'click');
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
    if (bookingDetails.price && bookingDetails.price != '0') {

    // ✅ Correct validation
    if (
        !bookingDetails.rateType || bookingDetails.rateType === '0' ||
        !bookingDetails.service || bookingDetails.service === '0'
    ) {
        setupDropdown('dropdownContent', 'error', svgError + "Please select type and service", 'click');
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

    if (maintenanceDate && new Date(maintenanceDate) >= from && new Date(maintenanceDate) <= to) {
        showConfirm = true;
        message += '⚠️ Maintenance date falls within selected range<br>';
    }

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

            // ✅ DB OVERLAP CHECK
            if (res.status && res.exists) {
                showConfirm = true;
                message += '⚠️ Vehicle already booked in selected date range<br>';
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
        booking: bookingDetails
    };

    const index = selectedVehicles.findIndex(v => v.id === vehicle.id);

    if (index === -1) {

        selectedVehicles.push(vehicle);

        $card.addClass('selected');
        $btn.removeClass('btn-primary').addClass('btn-outline-danger');
        $btn.attr('title', 'Deselect');
        $btn.html('<i class="ri ri-close-line icon-18px"></i>');

    } else {

        selectedVehicles.splice(index, 1);

        $card.removeClass('selected');
        $btn.removeClass('btn-outline-danger').addClass('btn-primary');
        $btn.attr('title', 'Select');
        $btn.html('<i class="ri ri-check-line icon-18px"></i>');
    }

    updateSelectedFooter();
}


 let DecimalPositions_contract = 3;  
function line_item_calculation_contract()
{
   
   let from = new Date($('.from_datetime_contract').val());
   let to = new Date($('.to_datetime_contract').val());
   let rateType = $('.rate_type_contract').val();;

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

       $('.duration_contract').val(duration_count);

        
        let price = parseFloat($('.price_contract').val()) || 0;
        let qty = 1;
        let vat = parseFloat($('.vat_contract').val()) || 0;

        let total = (price * qty * duration_count) * (1 + vat/100);
        
        $('#lineTotal_contract').text(total.toFixed(DecimalPositions_contract));

    }
}

$(document).on('blur','.to_datetime_contract',function(){

  
    let from = $('.from_datetime_contract').val();
    let to = $(this).val();
       
        let fromDate = new Date(from);
        let toDate   = new Date(to);
        if(toDate < fromDate){
        let fromDate = new Date(from);
        let toDate   = new Date(to);

        if(toDate < fromDate){
             setupDropdown('dropdownContent','error',svgSuccess+'To date must be after From date','click');
            
            $(this).val('');
        }

    }

});

$('.service_contract').on('change', function () {

    let vatValue = $(this).find('option:selected').data('id');

    if (vatValue !== undefined) {
        $('.vat_contract').val(vatValue);
    }

    // optional: trigger recalculation
    $('.vat_contract').trigger('input');
});
$('.service_contract, .rate_type_contract, .from_datetime_contract, .to_datetime_contract, .price_contract, .vat_contract, .duration_contract')
.on('input change', function () {
    let modelId = $('#ModelRef_contract').val() || 'All';
    let fromDate = $('.from_datetime_contract').val();
    let toDate   = $('.to_datetime_contract').val();
    
    if (fromDate !== '' && toDate !== '') {
        loadVehiclesTableAvailability(modelId, fromDate, toDate);
    }
    line_item_calculation_contract();
});

$(document).on('input change', '.watch-field_contract', function () {
   
    recalculate();
    line_item_calculation_contract();
     
});

$(document).on('click', '#recalcBtn', function () {
    let fromDate = $('.from_datetime_contract').val();
        let toDate = $('.to_datetime_contract').val();
        let from = new Date(fromDate);
        let to = new Date(toDate);
        let service = $('.service_contract').val();
        let rateType = $('.rate_type_contract').val();
        let modelId = $('#ModelRef_contract').val();
        
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
                line_item_calculation_contract();
            }
});
$('.minprice_contract').val('0');
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
    let fromDate = $('.from_datetime_contract').val();
    let toDate = $('.to_datetime_contract').val();
    let from = new Date(fromDate);
    let to = new Date(toDate);
       
    let service = $('.service_contract').val();
    let service_text = $('.service_contract option:selected').text();
    let rateType = $('.rate_type_contract').val();
    let modelId = $('#ModelRef_contract').val();
    
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
            $('.min-price-text_contract').text('Min price : '+unit_amt);
            $('.minprice_contract').val(unit_amt);
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
    
        let fromDate = $('.from_datetime_contract').val();
        let toDate = $('.to_datetime_contract').val();
        let from = new Date(fromDate);
        let to = new Date(toDate);
        
       
   // let serviceType = $('#select_service_type').val();
   let serviceType = 'Reserve Vehicles';
   
    if ($('#customerName_contract').val()=='' ) {
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
                renderVehicleTable(selectedVehicles);
                 $('#bookingSummaryModal').modal('show');
            break;
            case 'Create Contract':
            break;
        }
    }
    
    
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
        action: 'get_vehicle_details_reservation_avail'
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
                    $btn.html('<i class="ri ri-close-line icon-18px"></i>');
                } else {
                    $(this).removeClass('selected'); // normal
                    $btn.removeClass('btn-outline-danger').addClass('btn-primary');
                    $btn.attr('title', 'Select').attr('data-bs-original-title', 'Select');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-check-line icon-18px"></i>');
                }
            });
      },
      error: function() {
         
        $('#vehicleContainer').html('<div class="text-danger">Failed to load</div>');
      }
    });
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
        action: 'get_vehicle_details_reservation_avail'
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
                    $btn.html('<i class="ri ri-close-line icon-18px"></i>');
                } else {
                    $(this).removeClass('selected'); // normal
                    $btn.removeClass('btn-outline-danger').addClass('btn-primary');
                    $btn.attr('title', 'Select').attr('data-bs-original-title', 'Select');
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $btn.html('<i class="ri ri-check-line icon-18px"></i>');
                }
            });
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
     $('#ModelRef_contract').val(modelId).trigger('change');
     
    loadVehiclesTableAvailability(modelId,from,to);
   let modalEl = document.getElementById('checkavailabilityModal');
    let modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
        
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
 
 

$(document).on('click', '.AvailcancelBtn', function () {
    let modalEl = document.getElementById('checkavailabilityModal');
    let modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
});
$(document).on('click', '.booking-banner', function () {

    let bookings = $(this).data('bookings');

    // Ensure it's parsed
    if (typeof bookings === 'string') {
        bookings = JSON.parse(bookings);
    }

    let rows = '';

    if (bookings && bookings.length > 0) {

        bookings.forEach((b, index) => {

            let badgeClass = 'secondary';
            if (b.status === 'Pending') badgeClass = 'warning';
            if (b.status === 'Cancelled') badgeClass = 'danger';

            rows += `
                <tr>
                    <td>${index + 1}</td>
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
        rows = `<tr><td colspan="4" class="text-center">No bookings</td></tr>`;
    }

   $('#bookingListTableBody').html(rows);
    $('#bookingListModal').modal('show');
});

function formatDate(dateStr) {
    let d = new Date(dateStr);
    return d.toLocaleDateString();
}
$('#btnSearchVehicle').on('click', function() {
        let vehicleNos = $('#vehicleSearch').val().trim();

        if(vehicleNos === '') {
             setupDropdown('dropdownContent', 'error', svgError + "Please enter a vehicle number", 'click');
                return false;
           
        }
       
        let fromDate = $('.from_datetime_contract').val();
        let toDate   = $('.to_datetime_contract').val();
        
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
            action: 'reserve_vehicles'
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
});

</script>

   
  </body>
  
</html>
