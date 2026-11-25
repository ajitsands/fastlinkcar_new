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
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <style>
    html, body {
    overflow-x: hidden;
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
        #modelsTable thead {
            display: none;
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

.bg-purple {
    background: #7950f2 !important;

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
                        
                        <?php include ROOT_PATH . '/view/templates/VehicleReturnReport/vehicle_return_report_body.php'; ?>
                         <?php include('templates/VehicleReservation/vehicle_images_slider.php'); ?>
                         <?php include('templates/VehicleStatus/vehicle_return_calender.php'); ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleStatus/vehicle_filepreview_modal.php'; ?>
                         <?php include ROOT_PATH . '/view/templates/VehicleInsight/vehicle_change_status_modal.php'; ?>
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
     <?php include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
     <?php include('templates/vehicles/vehicle_profile_modal.php'); ?>
   

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-selects.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
    <script>
$(document).ready(function() {
$('#vehicleModelAvail').select2({
    dropdownParent: $('#dropdownContaineravail'),
    width: '100%',
     allowClear: true
}); 


    modelloadDropdown();

    function modelloadDropdown() {
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
    
// ✅ Set default date = today
   let fromDate = new Date();
let toDate = new Date();

toDate.setDate(toDate.getDate() + 10);

$('#filter_from_date').val(fromDate.toISOString().split('T')[0]);
$('#filter_to_date').val(toDate.toISOString().split('T')[0]);
loadVehiclesTable();
  let vehicleReturnCalendar;
let calendarReturnInitialized = false;

$('#openReturnCalendarBtn').on('click', function () {

    let modalEl = document.getElementById('ReturncalendarModal');
    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);

    modal.show();

    setTimeout(() => {
        loadReturnVehicleCalendar();
    }, 300);
});

function loadReturnVehicleCalendar() {

    let calendarEl = document.getElementById('ReturnvehicleCalendar'); // âœ… FIXED

    // destroy old instance (VERY IMPORTANT)
    if (vehicleReturnCalendar) {
        vehicleReturnCalendar.destroy();
    }

    vehicleReturnCalendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        height: "auto",
        expandRows: true,

        events: function (fetchInfo, successCallback) {

            $.ajax({
                url: '/LoadVehicleByUserSellection',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'return_vehicle_calendar'
                }),

                success: function (response) {

                    let events = [];

                    response.data.forEach(v => {

                        if (!v.return_date) return;

                        events.push({
                            title: `${v.vehicle_no} - ${v.model_name}`,
                            start: v.return_date,

                            extendedProps: {
                                ids: v.ids,
                                vehicle_id: v.vehicle_id || v.ids,
                                status: v.agreement_status || '',
                                customer_name: v.customer_name || '',
                                customer_mobile: v.customer_mobile || '',
                                agreement_no: v.agreement_no || '',
                                type: 'Return'
                            }
                        });

                    });

                    successCallback(events);
                }
            });
        },

        eventContent: function (info) {

            let p = info.event.extendedProps || {};

            let badgeClass = (p.status === 'Extended') ? 'bg-primary' : 'bg-info';

            return {
                html: `
<div class="cursor-pointer btn_vehicle_view shadow-sm"
     data-id="${p.vehicle_id || p.ids}"
     style="
        position:relative;
        font-size:11px;
        line-height:1.3;
        padding:6px;
        border-radius:6px;
        background:#fff;
        border-left:4px solid ${p.status === 'Extended' ? '#7950f2' : '#0dcaf0'};
    ">

    <!-- STATUS BADGE -->
   

    <!-- VEHICLE -->
    <div class="fw-bold text-truncate" style="padding-right:50px;">
        <i class="ri ri-car-line"></i> ${info.event.title}
    </div>

    <!-- CUSTOMER -->
    <div style="font-size:10px;" class="text-muted text-truncate">
        <i class="ri ri-user-line"></i> ${p.customer_name} ${p.customer_mobile ? '(' + p.customer_mobile + ')' : ''}
    </div>

    <!-- AGREEMENT -->
    <div style="font-size:10px;">
        <i class="ri ri-file-paper-2-line"></i> <b>${p.agreement_no}</b>
    </div>

</div>
`
            };
        }

    });

    vehicleReturnCalendar.render();
}
function getFilePreview(ext, url) {
    const map = {
        pdf: '/assets/icons/pdf.png',
        doc: '/assets/icons/word.png',
        docx: '/assets/icons/word.png',
        xls: '/assets/icons/excel.png',
        xlsx: '/assets/icons/excel.png',
        zip: '/assets/icons/zip.png',
        rar: '/assets/icons/zip.png',
        txt: '/assets/icons/txt.png'
    };

    const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (imageExts.includes(ext)) {
        return url || '';
    }

    return map[ext] || '/assets/icons/file.png';
}
 function loadVehiclesTable() {
    $('#AllvehicleContainer').html('<div class="p-3 text-center">Loading...</div>');

    $.ajax({
      url: '/VehicleInsightController',
      method: 'POST',
      data: {
        action: 'get_vehicle_return_details',
        filter_from_date: $('#filter_from_date').val(),
        filter_to_date: $('#filter_to_date').val(),
        modelId: $('#vehicleModelAvail').val() || 'All'
      },
      dataType: 'json',
      success: function(response) {

        $('#AllvehicleContainer').html(response.html);
         $('[data-bs-toggle="tooltip"]').tooltip();
         $('#AllvehicleAvailabilityBar').show();
          
          $('#AllvehicleAvailabilityContent').html('');
   
        let content = '';
        let total = 0;

        // ✅ Use response.summary instead of response.rows
        if (response.summary) {
    
            let parsedSummary = JSON.parse(response.summary);
     
            $.each(parsedSummary, function(model, count) {
    
                total += count;
    
                let badgeClass = count > 0 ? 'bg-primary' : 'bg-danger';
    
                content += `
                    <span class="badge ${badgeClass} me-2">
                        ${model}: ${count}
                    </span>
                `;
            });

        content = `<strong class="me-3">Total: ${total}</strong>` + content ;
                     $('#AllvehicleAvailabilityBar').show();
                    $('#AllvehicleAvailabilityContent').html(content);
                   
                    
                }
            else {
                 $('#AllvehicleAvailabilityBar').hide();
                $('#AllvehicleAvailabilityContent').html('');
            }
            $('#AllvehicleContainer .vehicle-card').each(function() {
                var $btn = $(this).find('.btn_vehicle_select');
                var vehicleId = $btn.data('id');

               
            });
      },
      error: function() {
         
        $('#AllvehicleContainer').html('<div class="text-danger">Failed to load</div>');
      }
    });
  }

$('#AllvehicleSearch').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();

        $('#AllvehicleContainer .vehicle-card').each(function() {
           
            var vehicleNumber = $(this).find('.veh_no').text().toLowerCase();

            if (vehicleNumber.indexOf(searchValue) > -1) {
                $(this).closest('.col-12').show(); 
            } else {
                $(this).closest('.col-12').hide(); 
            }
        });
    });

      


  $('#btnSearch').on('click', function() {
      
        let filter_from_date = $('#filter_from_date').val();
        let filter_to_date = $('#filter_to_date').val();
            if (!filter_from_date || !filter_to_date) {
                setupDropdown('dropdownContent', 'error', svgError + "Please select both From Date and To Date.", 'click');
                            return false;
            }
            
            // Validate date range
            if (new Date(filter_from_date) > new Date(filter_to_date)) {
                setupDropdown('dropdownContent', 'error', svgError + "From Date must be less than or equal to To Date.", 'click');
                            return false;
            }
       
        loadVehiclesTable();
       
       
    });
});

$(document).ready(function() {
    $(document).off('click', '.btn_vehicle_view').on('click', '.btn_vehicle_view', function(e) {
        e.preventDefault();
        let vehicleId = $(this).data('id');
        if (vehicleId) openVehicleProfile(vehicleId);
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

                $("#vpRentoutDiv").hide();
                $("#vpStaffDiv").hide();
                if (v.vehicle_status === 'Rentout' && v.current_user_name) {
                    $("#vpRentoutDiv").show();
                    $("#vpCurrentUserName").text(v.current_user_name);
                    $("#vpCurrentUserContact").text(v.current_user_contact || "No Contact");
                    $("#vpContractRef").text(v.contract_ref || "N/A");
                    let expRet = v.expected_return_date ? (new Date(v.expected_return_date).toLocaleString('en-GB', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}).replace(',', '')) : "N/A";
                    if (typeof dayjs !== 'undefined') {
                        expRet = v.expected_return_date ? dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : "N/A";
                    }
                    $("#vpReturnDate").text(expRet);
                } else if (v.vehicle_status === 'Staff Use' && v.current_user_name) {
                    $("#vpStaffDiv").show();
                    $("#vpStaffName").text(v.current_user_name);
                    $("#vpStaffContact").text(v.current_user_contact || "No Contact");
                    $("#vpStaffRef").text(v.contract_ref || "N/A");
                    let expRet = v.expected_return_date ? (new Date(v.expected_return_date).toLocaleString('en-GB', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}).replace(',', '')) : "N/A";
                    if (typeof dayjs !== 'undefined') {
                        expRet = v.expected_return_date ? dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A') : "N/A";
                    }
                    $("#vpStaffReturnDate").text(expRet);
                }

                $("#vpRemarksDiv").hide();
                if (v.vehicle_status_notes && v.vehicle_status_notes.trim() !== "") {
                    if (v.vehicle_status === 'Parking' || v.vehicle_status === 'Blocked' || v.vehicle_status === 'Maintenance') {
                        $("#vpRemarksDiv").show();
                        $("#vpStatusRemarks").text(v.vehicle_status_notes);
                    }
                }

                if (typeof window.applyVehicleStatusBadge === "function") {
                    window.applyVehicleStatusBadge("#vpStatusBadge", v.vehicle_status);
                } else {
                    $("#vpStatusBadge").attr("class", "badge bg-label-primary").text(v.vehicle_status || "Unknown");
                }

                $("#vpRegCompany").text(v.ownership_company || "N/A");
                if (v.is_outsourced === "Yes") {
                    $("#vpOutsourceDiv").show();
                    $("#vpOutsourceCompany").text(v.outsourcing_company_name || "N/A");
                } else {
                    $("#vpOutsourceDiv").hide();
                }

                let od = v.other_details || {};
                $("#vpFuelType").text(v.engine_type || od.vehicleFuelType || "N/A");
                $("#vpGearType").text(v.transmission || od.vehicleGearType || "N/A");

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