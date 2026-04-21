<?php
include ROOT_PATH . '/view/envinclude.php';
?>
<!doctype html>

<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-wide"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/"
    data-template="horizontal-menu-template-no-customizer">

<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>


    <!-- Helpers -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">


    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/spinkit/spinkit.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
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
          background-color: #f12526; /* Bootstrap primary */
          color: white;
        }
        .table-active {
            background-color: #f12526 !important; /* Red background */
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
    border: 2px solid #f12526;       /* red border for selection */
    background-color: #fff0f0;       /* light highlight */
    box-shadow: 0 0 10px rgba(241, 37, 38, 0.4); /* optional glow */
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
    background-color: #f12526;
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
                    
                        <!-- Layout Demo -->
                        
                        <?php include ROOT_PATH . '/view/templates/VehicleReservation/VehicleReservationBody.php'; ?>
                        <?php include ROOT_PATH . '/view/templates/VehicleReservation/add_new_customer_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleReservation/vehicleFloatingFooter.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleReservation/reservation_preview_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleReservation/vehicle_images_slider.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleReservation/custom_confirm_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleReservation/confirm_action_modal.php'; ?>
                          <?php include ROOT_PATH . '/view/templates/VehicleReservation/view_notes_modal.php'; ?>
                          <?php include ROOT_PATH . '/view/templates/VehicleReservation/vehicle_availability_model.php'; ?>
                          <?php include ROOT_PATH . '/view/templates/VehicleReservation/booking_listupon_avail_check.php'; ?>
                          <?php include ROOT_PATH . '/view/templates/VehicleReservation/vehicleAvailFloatingBar.php'; ?>
                         
                          
                     
                        <!--/ Layout Demo -->
                    
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
    <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicleInfoModal.php'; ?>
   

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-selects.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
   
    <script>
$(document).ready(function() {
    
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
    $('#customerPhone').val(data.customer_mobile);
    $('#customerEmail').val(data.customer_email);
    $('#customerAddress').val(data.customer_address);
    $('#customerAttention').val(data.customer_attn);
    
});


$('#selectCustomerFromSelect2').on('select2:clear', function () {
    $('#customerName').val('');
    $('#customer_code').val('');
    $('#customerPhone').val('');
    $('#customerEmail').val('');
    $('#customerAddress').val('');
    $('#customerAttention').val('');
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
<table class="table table-bordered" style="table-layout: fixed; width: 100%;">
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
    modelloadDropdown();

    function modelloadDropdown() {
       $('#dropdownContainer').html(`
            <div class="text-center p-3">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="mt-2">Loading models...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadVehicleModelReservation',
            type: 'GET',
            success: function (response) {
                $('#dropdownContainer').html(response);

                $('#vehicleModel').select2({
                    placeholder: "Select Model",
                    allowClear: true,
                    width: '100%'
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
     $('#ModelRef').val(modelId).trigger('change');;
    let fromdate= $('.from_datetime').val();
    let todate =  $('.to_datetime').val();
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
        fromDate: $('.from_datetime').val(),
        toDate: $('.to_datetime').val(),
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
        quotation_ref: $('#quotationRef').val(),
        book_through: $('#bookingTypeMain').val()
    };
}


$(document).on('click', '.btn_vehicle_select', function () {

    const $btn = $(this);
    const $card = $btn.closest('.vehicle-card');
    const bookingDetails = getBookingDetails();

    // ✅ VALIDATION
    if (!bookingDetails.customerCode?.trim()) {
        setupDropdown('dropdownContent', 'error', svgError + "Please select customer or quotation", 'click');
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

    // Handle string JSON
    if (typeof images === "string") {
        images = JSON.parse(images);
    }

    // ✅ Reverse order (last image first)
    images = images.slice().reverse();

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

    new bootstrap.Modal(document.getElementById('modalvehicleimages')).show();
}




 let DecimalPositions = 3;  
function line_item_calculation()
{
   
   let from = new Date($('.from_datetime').val());
   let to = new Date($('.to_datetime').val());
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

$('.service').on('change', function () {

    let vatValue = $(this).find('option:selected').data('id');

    if (vatValue !== undefined) {
        $('.vat').val(vatValue);
    }

    // optional: trigger recalculation
    $('.vat').trigger('input');
});
$('.service, .rate_type, .from_datetime, .to_datetime, .price, .vat .duration')
.on('input change', function () {
    let modelId = $('#ModelRef').val();
    let fromDate = $('.from_datetime').val();
    let toDate   = $('.to_datetime').val();
    
    if (modelId !== '' && fromDate !== '' && toDate !== '') {
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
        let from = new Date(fromDate);
        let to = new Date(toDate);
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
    let from = new Date(fromDate);
    let to = new Date(toDate);
       
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
    
        let fromDate = $('.from_datetime').val();
        let toDate = $('.to_datetime').val();
        let from = new Date(fromDate);
        let to = new Date(toDate);
        
       
    let serviceType = $('#select_service_type').val();
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
                renderVehicleTable(selectedVehicles);
                 $('#bookingSummaryModal').modal('show');
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


});
</script>

</body>

</html>