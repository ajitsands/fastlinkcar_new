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
    <link rel="stylesheet" href="../assets/vendor/libs/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/notyf/notyf.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/editor.css" />
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
              <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Filter</h5>
                 <div class="row align-items-end g-2">

    <!-- Date -->
    
     <div class="col-md-2">
        <div class="form-floating form-floating-outline">
             <select id="month_select" name="month_select" class="form-control select2">
           
                <?php
                $currentMonth = date('Y-m');
            
                for ($i = 0; $i < 12; $i++) {
            
                    $monthDate = date('Y-m-01', strtotime("-$i month"));
            
                    $startDate = date('Y-m-01', strtotime($monthDate));
                    $endDate   = date('Y-m-t', strtotime($monthDate));
            
                    $monthText = date('F Y', strtotime($monthDate));
            
                    $selected = (date('Y-m', strtotime($monthDate)) == $currentMonth)
                        ? 'selected'
                        : '';
                    ?>
                    
                    <option
                        value="<?= $startDate; ?>"
                        data-end-date="<?= $endDate; ?>"
                        <?= $selected; ?>
                    >
                        <?= $monthText; ?>
                    </option>
            
                <?php } ?>
            </select>
              
            <label for="Month">Month</label>
        </div>
    </div>

    <!-- Dropdown -->
    <div class="col-md-4">
        <div class="form-floating form-floating-outline">
       
         <label>Contract Status</label>
            <select class="form-control select2" id="sel_contract_status">
                <option value="All">All Contracts</option>
                <option value="Rentout">Rentout & Extended</option>
                <option value="Returned">Returned</option>
                <option value="Closed">Closed</option>
            </select>
        </div>
    </div>

    <!-- Search Button -->
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnSearch">
    <i class="ri ri-search-line me-1"></i> Search
</button>
    </div>
    
</div>
                </div>
                <div class="card-datatable table-responsive">
                  <table class="datatables-products table" id="vehicleTable">
                    <thead>
                      <tr>
                    <th>Sn</th>
                    <th>Customer</th>
                    <th>Model</th>
                    <th>Vehicle</th>
                    <th>Agreement</th>
                    <th>View Contract </th>
                    <th>Contract Ledger </th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <?php include('templates/VehicleStatus/vehicle_filepreview_modal.php'); ?>
              <?php include('templates/VehicleContractList/view_contract_details_modal.php'); ?>
                <?php include('templates/VehicleContractList/contract_ledger_modal.php'); ?>
                <?php include('templates/VehicleContractList/contract_ledger_supporting_modals.php'); ?>
                   <!-- slider modal -->
 
  <!--/ slider modal -->
             
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
     <script src="../assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
     <script src="../assets/vendor/libs/notyf/notyf.js"></script>
    <script src="../assets/vendor/libs/quill/katex.js"></script>
    <script src="../assets/vendor/libs/highlight/highlight.js"></script>
    <script src="../assets/vendor/libs/quill/quill.js"></script>
    <script src="../assets/vendor/libs/moment/moment.js"></script>
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

  $('#vehicleModelAvail').select2({
    dropdownParent: $('#dropdownContaineravail'),
    width: '100%',
     allowClear: true
}); 


   
    
// ✅ Set default date = today
    let today = new Date().toISOString().split('T')[0];
    $('#filter_date').val(today);
 
    // ✅ Initialize DataTable
    var table = $('#vehicleTable').DataTable({
        pageLength: 100,
        processing: true,
        ajax: {
            url: '/LoadVehicleByUserSellection',
            type: 'POST',
            contentType: 'application/json',
            data: function (d) {
                return JSON.stringify({
                    action: 'unbilled_invocies',
                    filter_start_date: $('#month_select').val(),
                    filter_end_date: $('#month_select option:selected').data('end-date'),
                    contract_status: $('#sel_contract_status').val() || 'All'
                });
            },
            dataSrc: 'data',
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        },
                     
        columns: [

            // ✅ Serial Number
            {
                data: null,
                title: '#',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'customer_name' ,
                 render: function (data, type, row, meta) {
                    return  `<span class="small fw-bold">${data}</span>`;
                }
            },
            { data: 'model_name' ,
                 render: function (data, type, row, meta) {
                    return  `<span class="small fw-bold">${data}</span>`;
                }
            },
            { data: 'vehicle_no' ,
                 render: function (data, type, row, meta) {
                     return  `<span class="small fw-bold">${data}</span>`;
                }
            },
             { data: 'agreement_no' ,
                 render: function (data, type, row, meta) {
                     return  `<div class="view_contract " style=" cursor: pointer;text-decoration: underline;color: #0d6efd;opacity: 0.8;" data-contract="${data}">
                            <div class="fw-bold small">${data}</div>
                            <div class="text-muted" style="font-size:11px;"><span class="status-cell">${row.source_type}</span>
                                
                            </div>
                           
                        </div>`;
                }
            },

            // ✅ Actions
            {
                data: 'ids',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                          <button
                            type="button"
                            class="btn btn-primary btn-sm view_contract_details"
                            data-id="${row.ids}"
                            data-vehicle="${row.vehicle_id}"
                            data-model="${row.model_id}"
                            data-customer="${row.customer_code}"
                            data-contract="${row.agreement_no}"
                            data-booking_id="${row.booking_ids}"
                        >
                            <i class="ri ri-file-list-line me-1"></i>
                            View Contract
                        </button>`;
                }
            },
            {
                data: 'ids',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
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
            
                        </button>`;
                }
            }
            

        ]
    });

    // ✅ Search Button Click
    $('#btnSearch').on('click', function () {

        let btn = $(this);
        btn.prop('disabled', true).html('<i class="ri ri-loader-4-line spin"></i>');

        table.ajax.reload(function () {
            btn.prop('disabled', false).html('<i class="ri-search-line"></i> Search');
        });
    });
        
  $(document).on('click', '#vehicleTable div.view_contract', function (e) {

     let btn = this;

     
     let agreement_no = $(this).data('contract');
     
  fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(agreement_no)))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/PrintAgreement?token=' + encodeURIComponent(token), '_blank');
        });
    

});       


//Contract Ledger
const userRole = '<?= $_SESSION['user_role_name'] ?? '' ?>';
const currentUserId = '<?= $_SESSION['user_id'] ?? 0 ?>';
const todayStr = '<?= date('Y-m-d') ?>';
let ledgerTable = null;
$(document).on('click', '#vehicleTable .contract_ledger', function (e) {

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
       //Get Contract Details

$(document).on('click', '#vehicleTable button.view_contract_details', function (e) {

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
});

</script>

   
  </body>
  
</html>
