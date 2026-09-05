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

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
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

/* Dashboard Expected Return Card & Table Tight Spacing */
.card-box {
    padding: 0.75rem 1rem !important;
}
.card-box h6 {
    margin-bottom: 0.25rem !important;
}
#vehicleTable_wrapper {
    padding-top: 0 !important;
    margin-top: 0 !important;
}
#vehicleTable_wrapper .row:first-child,
#vehicleTable_wrapper .dt-action-bar,
#vehicleTable_wrapper .me-5,
#vehicleTable_wrapper .ms-n2 {
    margin-top: 0 !important;
    margin-bottom: 0.25rem !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}
#vehicleTable_wrapper table.dataTable {
    margin-top: 0 !important;
}
#vehicleTable_wrapper table.dataTable thead th {
    padding-top: 6px !important;
    padding-bottom: 6px !important;
}
#vehicleDetailsModal {
    z-index: 9999 !important;
}
#ReturncalendarModal {
    z-index: 9999 !important;
}
.bg-purple {
    background: #7950f2 !important;
}
.contract-link {
    cursor: pointer;
}

.contract-link:hover {
    text-decoration: underline;
    color: #f12526;
    opacity: 0.8;
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
                <?php include('templates/dashboard/dashboard_body.php'); ?>
            <!--/ Content -->
           <?php include('templates/VehicleStatus/vehicle_filepreview_modal.php'); ?>
               <?php include('templates/VehicleStatus/vehicleInfoModal.php'); ?>
               <?php include('templates/VehicleStatus/vehicle_calender_modal.php'); ?>
               <?php include('templates/VehicleStatus/vehicle_return_calender.php'); ?>
 
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

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

    <!-- endbuild -->

    <!-- Vendors JS -->
    
 <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/js/forms-selects.js"></script>
    <script src="../assets/sands/settings.js"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>
     <script src="../httpdocs/user_js/vehicle_info.js"></script>
     
   
<script>
$(document).ready(function() {
    
dashboard_load();
dashboard_alert_notification_load();
 function dashboard_load() {
    $.ajax({
        url: '/LoadVehicleByUserSellection',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'vehicle_dashboard_load'
        }),

        success: function(response) {

            // Parse if response is string
            let res = (typeof response === 'string')
                ? JSON.parse(response)
                : response;

            if (res.status === 'success' && res.data.length > 0) {

                const counts = res.data[0];

                $('#avail_veh_count').text(counts.available_count || 0);
                $('#park_veh_count').text(counts.parking_count || 0);
                $('#rent_veh_count').text(counts.rentout_count || 0);
                $('#block_veh_count').text(counts.blocked_count || 0);
                $('#maint_veh_count').text(counts.maintainence_count || 0);
                $('#tot_veh_count').text(counts.total_count || 0);
            }
        },

        error: function(xhr, status, error) {
            console.error('Dashboard load failed:', error);
        }
    });
}
function dashboard_alert_notification_load() 
{
    $.ajax({
        url: '/LoadVehicleByUserSellection',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'ListVehicleMaster_Due_days_dash_new',
            filter_date:new Date().toISOString().split('T')[0]
        }),

          success: function(res) {

                    let html = '';
                    let alertCount = 0;
                
                   if (res.status === 'success' && res.data.length > 0) {

    res.data.forEach(v => {

        function buildAlert(type, icon, dateLabel, ageDays, dateFormat) {

            let alertClass = 'alert-info';
            let borderColor = '#0dcaf0';

            // ignore past dates
            if (ageDays < 0) return;

            // only allow next 7 days
            if (ageDays > 7) return;

            // priority coloring
            if (ageDays <= 3) {
                alertClass = 'alert-danger';
                borderColor = '#dc3545';
            } else if (ageDays <= 5) {
                alertClass = 'alert-warning';
                borderColor = '#ffc107';
            } else {
                alertClass = 'alert-info';
                borderColor = '#0dcaf0';
            }

            return `
            <div class="alert ${alertClass} py-2 px-2 mb-2 small"
                 style="border-left:5px solid ${borderColor}; position:relative; cursor:pointer;">

                <div>
                    <i class="ri ${icon} me-1"></i>
                    <b>${type}</b><br>
                    <span class="fw-bold">${v.vehicle_number} - ${v.model_names}</span><br>
                    <small>${dateLabel} (${dateFormat || '-'})</small>
                </div>

                <button class="btn btn-sm btn-primary btn_vehicle_view"
                        data-id="${v.ids}"
                        title="View Info"
                        style="position:absolute; top:5px; right:5px; padding:2px 6px;">
                    <i class="ri ri-information-line"></i>
                </button>
            </div>`;
        }

                // PASSING
                if (v.passing_age_days !== null && v.passing_age_days >= 0 && v.passing_age_days <= 7) {
                    let msg = v.passing_age_days === 0
                        ? 'Due Today'
                        : `Due in ${v.passing_age_days} days`;
        
                    html += buildAlert(
                        'Passing Renewal',
                        'ri-car-line',
                        msg,
                        v.passing_age_days,
                        v.next_passing_date_format
                    );
                    alertCount++;
                }
        
                // INSURANCE
                if (v.insurance_age_days !== null && v.insurance_age_days >= 0 && v.insurance_age_days <= 7) {
                    let msg = v.insurance_age_days === 0
                        ? 'Due Today'
                        : `Due in ${v.insurance_age_days} days`;
        
                    html += buildAlert(
                        'Insurance Expiry',
                        'ri-shield-check-line',
                        msg,
                        v.insurance_age_days,
                        v.next_insurance_date_format
                    );
                    alertCount++;
                }
        
                // MAINTENANCE
                if (v.maintenance_age_days !== null && v.maintenance_age_days >= 0 && v.maintenance_age_days <= 7) {
                    let msg = v.maintenance_age_days === 0
                        ? 'Due Today'
                        : `Due in ${v.maintenance_age_days} days`;
        
                    html += buildAlert(
                        'Maintenance Due',
                        'ri-tools-line',
                        msg,
                        v.maintenance_age_days,
                        v.next_maintenance_date_format
                    );
                    alertCount++;
                }
        
            });
        }

$('#alertsContainer').html(html);
$('#alertCount').text(alertCount);
                
                    $('#alertsContainer').html(html);
                    $('#alertCount').text(alertCount);
                },
        error: function(xhr, status, error) {
            console.error('Dashboard load failed:', error);
        }
    });
}
let vehicleCalendar;
let calendarInitialized = false;

// ===============================
// OPEN CALENDAR BUTTON
// ===============================
$('#openCalendarBtn').on('click', function () {

    let modalEl = document.getElementById('calendarModal');

    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);

    modal.hide(); // ensures reset if already open

    setTimeout(() => {
        modal.show();

        setTimeout(() => {
            loadVehicleCalendar();
        }, 300);

    }, 200);
});

$(document).on('click', '#refreshCalendarBtn', function () {

    let modalEl = document.getElementById('calendarModal');

    let modal = bootstrap.Modal.getOrCreateInstance(modalEl);

    modal.hide(); // ensures reset if already open

    setTimeout(() => {
        modal.show();

        setTimeout(() => {
            loadVehicleCalendar();
        }, 300);

    }, 200);
});


function loadVehicleCalendar() {

    let calendarEl = document.getElementById('vehicleCalendar');

    // Prevent re-initialization
    if (calendarInitialized) {
        vehicleCalendar.render();
        return;
    }

    vehicleCalendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        height: "auto",
        expandRows: true,

        // ===============================
        // EVENTS LOAD (AJAX)
        // ===============================
        events: function (fetchInfo, successCallback) {

            $.ajax({
                url: '/LoadVehicleByUserSellection',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'vehicle_calendar'
                }),

                success: function (response) {

                    let events = [];

                   response.data.forEach(v => {

    let baseTitle = `${v.vehicle_number} - ${v.model_names}`;
    let status = v.vehicle_status || '';
    let ids = v.ids || '';

    // helper to safely parse JSON history
    const parseHistory = (json) => {
        try {
            if (!json) return [];
            let data = JSON.parse(json);
            return Array.isArray(data) ? data : [];
        } catch (e) {
            return [];
        }
    };

    // =========================
    // PASSING HISTORY
    // =========================
    parseHistory(v.passing_histroy).forEach(h => {
        if (h.next_date) {
            events.push({
                title: baseTitle,
                start: h.next_date,
                color: '#f59f00',
                extendedProps: {
                    status,
                    type: 'Passing',
                    ids
                }
            });
        }
    });

    // =========================
    // INSURANCE HISTORY
    // =========================
    parseHistory(v.insurance_histroy).forEach(h => {
        if (h.next_date) {
            events.push({
                title: baseTitle,
                start: h.next_date,
                color: '#1c7ed6',
                extendedProps: {
                    status,
                    type: 'Insurance',
                    ids
                }
            });
        }
    });

    // =========================
    // MAINTENANCE HISTORY
    // =========================
    parseHistory(v.maintenance_histroy).forEach(h => {
        if (h.next_date) {
            events.push({
                title: baseTitle,
                start: h.next_date,
                color: '#7950f2',
                extendedProps: {
                    status,
                    type: 'Maintenance',
                    ids
                }
            });
        }
    });

});

                    successCallback(events);
                }
            });
        },

      eventContent: function (info) {

    let props = info.event.extendedProps || {};

    let status = props.status || '-';
    let type = props.type || '-';
     let ids = props.ids || '-';

    return {
       html: `
<div class="cursor-pointer btn_vehicle_view"
     data-id="${ids}"
     style="position:relative; font-size:11px; line-height:1.1; padding:6px;">

    <div style="
        position:absolute;
        bottom:0;
        right:0;
        font-size:9px;
        background:#e03131;
        color:#fff;
        padding:2px 6px;
        border-radius:6px 0 0 0;
    ">
        ${type}
    </div>

    <div style="font-weight:400; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
        ${info.event.title}
    </div>

    <div style="display:flex; justify-content:space-between; font-size:9px; margin-top:3px;">
        <span>${status}</span>
    </div>

</div>
`
    };
}

    });

    vehicleCalendar.render();
    calendarInitialized = true;
}
loadVehicleReturn();
function loadVehicleReturn() {

    $('#vehicleTable').DataTable({
        ajax: {
            url: '/LoadVehicleByUserSellection',
            type: 'POST',
            contentType: 'application/json',

            data: function () {
                return JSON.stringify({
                    action: 'vehicle_return_due_dashboard',
                    filter_date: new Date().toISOString().split('T')[0]
                });
            },

            dataSrc: 'data'
        },

        columns: [

            // ================= VEHICLE =================
            {
                data: null,
                render: function (row) {
                    return `
                        <div>
                            <div class="fw-bold small">${row.vehicle_no}</div>
                            <div class="text-muted" style="font-size:11px;">
                                ${row.model_name || '-'}
                            </div>
                        </div>
                    `;
                }
            },

            // ================= CUSTOMER =================
            {
                data: null,
                render: function (row) {
                    return `
                        <div>
                            <div class="fw-bold small">${row.customer_name}</div>
                            <div class="text-muted" style="font-size:11px;">
                                ${row.customer_mobile}
                            </div>
                        </div>
                    `;
                }
            },

             {
                data: null,
                render: function (row) {
                    return `
                        <div class="print_contract contract-link" data-contract="${row.agreement_no}">
                            <div class="fw-bold small">${row.agreement_no}</div>
                            <div class="text-muted" style="font-size:11px;">
                                ${row.agreement_status}
                            </div>
                        </div>
                    `;
                }
            },

            // ================= START DATE =================
            { data: 'start_date' },

            // ================= RETURN DATE =================
            { data: 'return_date_format' },
            { data: 'days_left' },

            // ================= DAYS LEFT =================
            {
    data: 'days_left',
    render: function (data) {

        let days = parseInt(data || 0);

        let label = '';
        let badge = '';

        // 🔴 Overdue
        if (days < 0) {
            label = `Overdue (${Math.abs(days)} days)`;
            badge = 'bg-danger';
        }

        // 🟡 Due Soon (< 14 days)
        else if (days < 14) {
            label = 'Due Soon';
            badge = 'bg-warning text-dark';
        }

        // 🟢 Active (14 days and above)
        else {
            label = 'Active';
            badge = 'bg-success';
        }

        return `<span class="badge ${badge}">${label}</span>`;
    }
}
        ],

        pageLength: 10,
        responsive: true,
        destroy: true
    });
}

$(document).on('click', '#vehicleTable div.print_contract', function (e) {

     let btn = this;

     
     let agreement_no = $(this).data('contract');
     
  fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(agreement_no)))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/PrintAgreement?token=' + encodeURIComponent(token), '_blank');
        });
    

});

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

    let calendarEl = document.getElementById('ReturnvehicleCalendar'); // ✅ FIXED

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
     data-id="${p.ids}"
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
});

</script>

   
  </body>
  
</html>
