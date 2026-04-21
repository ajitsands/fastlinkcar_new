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
    <meta name="description" content="" />

    <?php include ROOT_PATH . '/view/templates/head.php'; ?>

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
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
#confirmActionModal,
#confirmActionModal * {
    pointer-events: auto !important;
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
             
              <!-- Product List Table -->
               <?php include ROOT_PATH . '/view/templates/VehicleContractGeneration/vehicle_contract_body.php'; ?>
              <?php include ROOT_PATH . '/view/templates/VehicleReservation/add_new_customer_modal.php'; ?>
              <?php include ROOT_PATH . '/view/templates/VehicleReservation/custom_confirm_modal.php'; ?>
              <?php include ROOT_PATH . '/view/templates/VehicleReservation/confirm_action_modal.php'); ?>  
              <?php include ROOT_PATH . '/view/templates/VehicleContractGeneration/vehicle_contract_modal.php'; ?>
             
              
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
 <div id="dropdownContent" style="text-align:center;"></div> 
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

    <!-- endbuild -->

    <!-- Vendors JS -->
     <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    <!-- Main JS -->

    <!--<script src="<?= $_ENV['BASE_URL'] ?>assets/js/main.js"></script>-->

    <!-- Page JS -->
    <!--<script src="<?= $_ENV['BASE_URL'] ?>assets/js/app-ecommerce-product-list.js"></script>-->
    <!-- jQuery first -->
<script>
$(document).ready(function() {

 $('#selectCustomerFromSelect2').select2({
    placeholder: 'Search customer by name or mobile',
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
                    customer_attn: item.customer_attn
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
            <strong>${customer.customer_name} | ${customer.customer_mobile}</strong>
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
 var table;
 load_booking_list();
function load_booking_list()
{
     table = $('#bookingTable').DataTable({
     ajax: {
            url: '/VehicleContractGeneration',
            type: 'POST',
            contentType: 'application/json',
            data: function (d) {
                return JSON.stringify({
                    action: 'ListBookings',
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

               

            </div>
        `;
    }
},

    {
        data: null,
        render: function (data) {
            return `
                <button class="btn btn-sm btn-primary view" data-id="${data.booking_ref}">
                    <i class="ri ri-eye-line"></i>
                </button>
                <button class="btn btn-sm btn-danger delete" data-id="${data.booking_ref}">
                    <i class="ri ri-delete-bin-line"></i>
                </button>
            `;
        }
    }
]
});
}


$('#bookingTable tbody').on('click', 'td.dt-control', function () {

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
                    <input class="form-check-input modern-check"
                           type="checkbox"
                           value="${row.ids}">
                </td>
                <td>${row.vehicle_no}</td>
                <td>${row.brand_name} ${row.model_name}</td>
                <td>${row.from_date}</td>
                <td>${row.to_date ?? '-'}</td>
                <td  class="status-cell">
                    <span class="badge ${
                        row.book_status === 'Booked' ? 'bg-warning ' :
                        row.book_status === 'Confirmed' ? 'bg-info' :
                        row.book_status === 'RentOut' ? 'bg-success' :
                        row.book_status === 'Return' ? 'bg-primary' :
                        row.book_status === 'Cancelled' ? 'bg-danger' :
                        'bg-secondary'
                    }">
                        ${row.book_status}
                    </span>
                </td>
               <td class="text-nowrap">
                    <div class="d-flex gap-1">
                
                        <!-- Generate Contract -->
                        <button class="btn btn-sm btn-primary generate-contract"
                                data-id="${row.ids}"
                                data-bs-toggle="tooltip"
                                title="Generate Contract">
                            <i class="ri ri-file-text-line"></i>
                        </button>
                
                        <div class="dropdown">
                            <button class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" >
                                Change Status
                            </button>
                            <ul class="dropdown-menu">
                               
                                <li>
                                    <a class="dropdown-item changeStatus" data-id="${row.ids}" data-status="Confirmed" style="cursor: pointer;">
                                        ✅ Confirm
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item changeStatus" data-id="${row.ids}" data-status="Cancelled" style="cursor: pointer;">
                                        ❌ Cancel
                                    </a>
                                </li>
                              
                            </ul>
                        </div>
                
                    </div>
                </td>
            </tr>
        `;
    });

    html += `</tbody></table></div>`;

    return html;
}

   $('#bookingTable').on('draw.dt', function () {
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

    new bootstrap.Modal(document.getElementById('confirmActionModal')).show();
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
    let { btn, id, status, bookingRef } = confirmData.extra;

    let rowEl = btn.closest('tr');

    // ✅ Update badge
    let badge = rowEl.find('.status-cell span');

    let badgeClass =
        status === 'Booked' ? 'bg-warning' :
        status === 'Confirmed' ? 'bg-info' :
        status === 'Cancelled' ? 'bg-danger' :
        status === 'Return' ? 'bg-primary' :
        status === 'RentOut' ? 'bg-success' :
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
        RentOut: 0,
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
    data.rentout_count = counts.RentOut;
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

    let id = $(this).data('id');

     showConfirmModal({
        title: 'Delete Booking',
        message: 'Are you sure you want to delete this booking?',
        confirmText: 'Yes, Delete',
        type: 'danger',
        action: 'delete_booking',
        data: {
            action: 'delete_booking',
            bookingid: id
        }
    });
});
$(document).on('click', '.changeStatus', function () {

    let btn = $(this);
    let id = btn.data('id');
    let status = btn.data('status');
    let bookingRef = btn.closest('tr').data('parent');

    showConfirmModal({
        title: 'Change Status',
        message: `Are you sure you want to change status to <b>${status}</b>?`,
        confirmText: 'Yes, Change',
        type: 'primary',
        action: 'change_booking_status',
        data: {
            action: 'change_booking_status',
            bookingid: id,
            bookingstatus: status
        },

        // 🔥 STORE UI CONTEXT HERE
        extra: {
            btn: btn,
            id: id,
            status: status,
            bookingRef: bookingRef
        }
    });
});

let modalEl = document.getElementById('contractModal');

if (!modalEl) {
    console.error('Modal not found!');
    return;
}


$(document).on('click', '.generate-contract', function () {
    
     let id = $(this).data('id'); // get data-id

    let status = $(this).closest('tr').find('.status-cell span').text().trim();


    if (status === 'Booked' || status === 'Confirmed' || status === 'Rentout') {
        
         driverloadDropdown();
        openContractModal(id);
        
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
                svgSuccess + 'Invalid Status',
                'click'
            );
            return;
    }
    

    // loadDemoContract(); // 🔥 load dummy data

    // new bootstrap.Modal(modalEl).show();
});
function loadDemoContract() {

    // CUSTOMER
    $('#c_name').text('John Mathew');
    $('#c_code').text('CUST-1023');
    $('#c_mobile').text('+973 33445566');

    // VEHICLE
    $('#v_model').text('Toyota Corolla 2023');
    $('#v_no').text('BAH-12345');
    $('#v_color').text('White');
    $('#v_fuel').text('Petrol');
    $('#v_gear').text('Automatic');
    $('#v_insurance').text('12-Dec-2026');
    $('#v_passing').text('10-Jan-2027');
    $('#v_maintenance').text('01-May-2026');

    // BOOKING
    $('#b_from').val('2026-04-16T10:00');
    $('#b_to').val('2026-04-18T10:00');
    $('#b_duration').val(2);
    $('#b_vat').val(10);
    $('#b_total').val(55.000);

    // DRIVER
    $('#driverSelect').html(`
        <option value="">Select Driver</option>
        <option value="1" data-lic="DL12345" data-place="Manama">Ali Hassan</option>
        <option value="2" data-lic="DL67890" data-place="Muharraq">Mohamed Salman</option>
    `);

    $('#d_lic').val('DL12345');
    $('#d_place').val('Manama');
    $('#d_issue').val('2023-01-01');
    $('#d_expiry').val('2028-01-01');

    // CHECKLIST
    $('#chk_tools').prop('checked', true);
    $('#chk_spare').prop('checked', true);
    $('#chk_radio').prop('checked', false);

    $('#km_out').val(45230);
    $('#dt_out').val('2026-04-16T10:00');

    // IMAGES (dummy preview)
    let demoImages = [
        'https://via.placeholder.com/80',
        'https://via.placeholder.com/80',
        'https://via.placeholder.com/80'
    ];

    $('#preview').html('');
    demoImages.forEach(src => {
        $('#preview').append(`
            <img src="${src}" 
                 style="width:80px;height:80px;margin:5px;border-radius:5px;">
        `);
    });
}
function openContractModal(id) {

    $.ajax({
        url: '/VehicleContractGeneration',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            bookingid: id
        }),
        success: function (res) {
           // populateContractModal(res.data);
            new bootstrap.Modal(document.getElementById('contractModal')).show();
        }
    });
}
function populateContractModal(d) {

    $('#c_name').text(d.customer_name);
    $('#c_code').text(d.customer_code);
    $('#c_mobile').text(d.mobile);

    $('#v_model').text(d.model);
    $('#v_no').text(d.vehicle_no);
    $('#v_color').text(d.color);
    $('#v_fuel').text(d.fuel);
    $('#v_gear').text(d.gear);

    $('#b_from').val(d.from_date);
    $('#b_to').val(d.to_date);
    $('#b_total').val(d.total);
}


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
    
    $(document).on('change', '#driverSelect', function () {

    let selected = $(this).find(':selected');

    // get values
    let driverId = selected.val();
    let contat_number = selected.data('id');
    let licenseNo = selected.data('license_no');
    let licensePlace = selected.data('license_place');
    let licenseIssue = selected.data('license_id');
    let licenseExpiry = selected.data('license_ed');

    // set to controls
    $('#d_mobile').html(contat_number);
    $('#d_license_no').html(licenseNo);
    $('#d_license_issue_place').html(licensePlace);
    $('#d_licenseissueDate').html(licenseIssue);
    $('#d_licenseexpiryDate').html(licenseExpiry);
    $.ajax({
    url: '/DriverController',
    data: { ids: selected.val(),action:"get_driver_documnets" },
    success: function(res) {
        renderDocuments(res);
    }
});

});
});

</script>

   
  </body>
  
</html>
