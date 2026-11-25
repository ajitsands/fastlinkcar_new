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
$decimals = !empty($_ENV['DECIMALS']) ? (int)$_ENV['DECIMALS'] : 3;
require_once ROOT_PATH . '/pdf/print_settings_helper.php';
$cmCompanyId = !empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1;
$cmPrintSettings = getPrintSettings(null, $cmCompanyId);

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$userCompanyJson = isset($_SESSION['company_json']) ? json_decode($_SESSION['company_json'], true) : [];
$userCompanyIds = [];
if (is_array($userCompanyJson)) {
    foreach ($userCompanyJson as $c) {
        if (isset($c['ids'])) {
            $userCompanyIds[] = $c['ids'];
        }
    }
}

$companies = [];
try {
    if (!empty($userCompanyIds)) {
        $placeholders = implode(',', array_fill(0, count($userCompanyIds), '?'));
        $stmt = $pdo->prepare("SELECT ids, company_name, company_code FROM tbl_company WHERE ids IN ($placeholders) AND status = 'Active' ORDER BY company_name");
        $stmt->execute($userCompanyIds);
    } else {
        $stmt = $pdo->query("SELECT ids, company_name, company_code FROM tbl_company WHERE status = 'Active' ORDER BY company_name");
    }
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
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


   

   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/spinkit/spinkit.css" />
    
    <link rel="stylesheet" href="../assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/editor.css" />
    
    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">
    
        <!-- Ladda CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" />
    
    <link rel="stylesheet" href="../assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/highlight/highlight.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/quill/editor.css" />
    
    
     <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="../assets/js/config.js"></script>

    
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
    <style>

        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ccc; padding:6px; text-align:center; }
        input { width:100%; }
        .btn { padding:6px 12px; cursor:pointer; }

        
        #itemTable {
            width: 100%;
            table-layout: fixed;
        }
        
        #itemTable th,
        #itemTable td {
            padding: 6px;
            text-align: center;
        }
       
        /* Column widths */
        .col-sl { width: 60px; }
        .col-item { width: auto; }
        .col-service { width: 300px; }
        .col-unit { width: 110px; }
        .col-from { width: 160px; }
        .col-to { width: 160px; }
        .col-qty { width: 90px; }
        .col-price { width: 110px; }
        .col-vat { width: 80px; }
        .col-total { width: 110px; }
        .col-action { width: 60px; }
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
  
  .btn-icon-square {
    width: 30px;
    height: 30px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
        /* Input styling */
        #itemTable input {
            width: 100%;
            text-align: right;
        }

.item_name {
    text-align: left !important;
}

/* Remove arrows in Chrome, Safari, Edge */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Remove arrows in Firefox */
input[type=number] {
    -moz-appearance: textfield;
}

.remove {
    color: red;
    cursor: pointer;
}

.remove:hover {
    color: darkred;
}
   
.row-highlight {
    background-color: #ffe5e5;
    transition: background-color 0.3s ease;
}

tr.active-row {
    background-color: #e8f2ff;
}

.offcanvas-half {
    width: 80% !important;
}

@media (max-width: 768px) {
    .offcanvas-half {
        width: 100% !important;
    }
}


/* Table header style */
#helpTable thead th {
    background-color: #1b3d94;   /* Blue header (Bootstrap primary) */
    color: #fff;                 /* White text */
    padding: 6px 8px;            /* Narrow padding */
    font-size: 13px;             /* Slightly smaller text */
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid #ff4d49;
}

/* Table body cell padding */
#helpTable tbody td {
    padding: 4px 6px;
    vertical-align: middle;
}

/* Footer style (totals) */
#helpTable tfoot td {
    padding: 6px 8px;
    font-weight: 600;
}
.dt-search {
    margin: 0 !important;
    padding: 2px 0;
}

.dt-search input {
    height: 28px;
    padding: 2px 6px;
    font-size: 13px;
}

#itemSearchTable_filter {
    width: 100% !important;       /* make wrapper full width */
    display: block;               /* block element */
    text-align: left;             /* optional, aligns input left */
    margin-bottom: 10px;          /* optional spacing */
}

#itemSearchTable_filter input {
    width: 100% !important;       /* input takes full width */
    box-sizing: border-box;       /* includes padding in width */
    padding: 6px 10px;            /* optional nicer padding */
}
div.dt-container div.dt-search input {
    margin-inline: 0.5rem 0;
    width: 100%;
}
#itemSearchTable thead {
    display: none;
}
#itemSearchTable_filter label {
    display: none;
}

#itemSearchTable tbody tr.row-focus > td,
#itemSearchTable tbody tr.row-selected > td {
    background-color: var(--bs-primary) !important;
    color: #ffffff !important;
    border-color: #ffffff !important;
}
#termsTable th,
#termsTable td {
    padding: 4px 8px !important;   /* reduce padding */
    font-size: 13px;               /* smaller text */
    vertical-align: middle;
}
#introTable th,
#introTable td {
    padding: 4px 8px !important;   /* reduce padding */
    font-size: 13px;               /* smaller text */
    vertical-align: middle;
}
#introTable td.description,
#termsTable td.description {
    display: -webkit-box;
    -webkit-line-clamp: 3;         /* show only 3 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word;
    max-width: 400px;              /* optional: adjust column width */
}
.modal-footer {
    border-top: 1px solid #dee2e6;
    padding-top: 25px;
}
.ledger_item {
    font-family: "Arial", sans-serif;
    font-size: 14px;
}

.ui-autocomplete {
    font-family: "Arial", sans-serif;
    font-size: 14px;
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
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
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 55px !important">
                        <!-- Layout Demo -->
                        <?php //echo "DB NAME : ".$_ENV['DB_NAME'];
                        ?>
                        <?php include('templates/cash_memo/cash_memo_body.php'); ?>
                        
                        <!--/ Layout Demo -->
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
    
    
<!-- SaNDS Popup -->
    <div id="dropdownContent" style="text-align:center;"></div>    
 <!--Modal Starts Here -->
<!-- Button trigger modal -->



 <!--Off Canvas for Diplsy The Quotation List -->
  <?php include('templates/cash_memo/cash_memo_list_modal.php'); ?>

<!--// Modal For Alart -->
<!-- Modal -->

<?php include('templates/cash_memo/contract_ledger_modal.php'); ?>
<?php include('templates/cash_memo/contract_ledger_supporting_modals.php'); ?>

<?php include('templates/cash_memo/customer_ledgr_modal.php'); ?>
<?php include('templates/cash_memo/signature_modal.php'); ?>




    <?php include('templates/scripts.php'); ?>
<!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="../assets/vendor/libs/select2/select2.js"></script>
    <script src="../assets/js/forms-selects.js"></script>
    
    <script src="../assets/sands/settings.js"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script>
        window.LEDGER_PRINT_SETTINGS = <?= json_encode($cmPrintSettings, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    </script>
        <!-- Ladda & Spin.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
    
    
    <script src="../assets/vendor/libs/quill/katex.js"></script>
    <script src="../assets/vendor/libs/highlight/highlight.js"></script>
    <script src="../assets/vendor/libs/quill/quill.js"></script>
    <script src="../assets/vendor/libs/moment/moment.js"></script>
   
       <!-- Page JS -->
    <script src="../../assets/js/ui-popover.js"></script>
     <script src="../assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
     <script src="../assets/vendor/libs/notyf/notyf.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <!--<script src="../assets/js/forms-editors.js"></script>-->
<script>
     $(document).ready(function() {
   var todayFilter = new Date();

    // First day of current month
    var firstDay = new Date(todayFilter.getFullYear(), todayFilter.getMonth(), 1);

    // Format date as YYYY-MM-DD
    function formatDate(date) {
        return date.getFullYear() + '-' +
            String(date.getMonth() + 1).padStart(2, '0') + '-' +
            String(date.getDate()).padStart(2, '0');
    }

    $('#from_date_filter').val(formatDate(firstDay));
    $('#to_date_filter').val(formatDate(todayFilter));
    
          $('#cashmemo_id').val('');
          $('#original_draft').val('');
          $('#cashmemo_number').val('');
        
            let today = new Date().toISOString().split('T')[0];
            $('#cashmemo_date').val(today);
         
      let DecimalPositions = <?php echo (int)($decimals ?? 3); ?>;   
        let saved = localStorage.getItem('printSettings');
        if (saved) {
            let settings = JSON.parse(saved);
    
            if (settings.decimals) {
                DecimalPositions = settings.decimals;
            }
        }
        
   
    
  function initLedgerAutocomplete(element,contract_ids){
 
    element.autocomplete({
        source: "/getLedgerDetails",
        data: {
            contract_ids: contract_ids
        },
        minLength: 1,

        select: function(event, ui){

            let row = $(this).closest('tr');

            row.find('.ledger_item').val(ui.item.value);
            // row.find('.vehicle_category_id').val(ui.item.id);
            // row.find('.vehicle_modal_pic').val(ui.item.vehicle_modal_pic);
            

            return false;
        }
    });

}



$(document).on('blur','.to_datetime',function(){

    let row = $(this).closest('tr');

    let from = row.find('.from_datetime').val();
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
 // Full Toolbar
              // --------------------------------------------------------------------
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
          
      
      let qPressed = false;
        function addRow() {
          
            let row = `
            <tr>
                <td class="slno"></td>
              
                <td>
                    <input type="text" class="ledger_item form-control form-control-sm watch-field" style="text-align: left;">
                  
              
                </td>
               
                <td><input type="number" class="qty nav form-control form-control-sm" step="any" value="1"></td>
                <td>
                    <div style="position:relative; display:inline-block; width:100%;">
                        
                       
                
                        <!-- Input -->
                        <input type="number"
                               class="price nav form-control form-control-sm mb-0"
                               step="any"
                               value="0"
                               style="padding-top:12px;">
                    </div>
                </td>
                <td><input type="number" class="vat nav form-control form-control-sm" step="0.1" value="<?php echo htmlspecialchars($_ENV['TAX_PERCENTAGE'] ?? '10'); ?>"></td>
                <td class="line_total">0.00</td>
                <td>
                    <span class="icon-base ri ri-delete-bin-6-line icon-22px remove"></span>
                </td>
            </tr>`;
            
            $('#itemTable tbody').append(row);
             let lastRow = $('#itemTable tbody tr:last');

                initLedgerAutocomplete(lastRow.find('.ledger_item'));
                
                renumberRows();
            $('#itemTable tbody tr:last .ledger_item').focus();
        }
 

$(document).on('blur','.price, .vat .qty', line_item_calculation);
$(document).on('keyup change', '.price', line_item_calculation);
$(document).on('keyup change', '.vat', line_item_calculation);
$(document).on('keyup change', '.qty', line_item_calculation);
$(document).on('keyup change', '#total_discount', line_item_calculation);


function line_item_calculation()
{
   
    let row = $(this).closest('tr');
    let from = new Date(row.find('.from_datetime').val());
    let to = new Date(row.find('.to_datetime').val());
  
        let price = parseFloat(row.find('.price').val()) || 0;
          
       
        let qty = parseFloat(row.find('.qty').val()) || 0;
        let vat = parseFloat(row.find('.vat').val()) || 0;

       // let total = (price * qty * duration_count) * (1 + vat/100);
         let total = (price * qty ) * (1 + vat/100);
        row.find('.line_total').text(total.toFixed(DecimalPositions));
        calculateTotals();

 //   }
}
function renumberRows() {
    $('#itemTable tbody tr').each(function(index) {
        $(this).find('.slno').text(index + 1);
    });
}

$(document).on('wheel', 'input[type=number]', function(e) {
    $(this).blur();
});

function calculateTotals() {
    let subtotal = 0;

    $('#itemTable tbody tr').each(function () {
        let qty   = parseFloat($(this).find('.qty').val()) || 0;
        let price = parseFloat($(this).find('.price').val()) || 0;

        subtotal += qty * price;
    });

    // Discount %
    let discountPercent = parseFloat($('#total_discount').val()) || 0;
    let discountAmount = subtotal * discountPercent / 100;

    // Amount after discount
    let afterDiscount = subtotal - discountAmount;

    // VAT calculation
    let vatTotal = 0;

    $('#itemTable tbody tr').each(function () {
        let qty   = parseFloat($(this).find('.qty').val()) || 0;
        let price = parseFloat($(this).find('.price').val()) || 0;
        let vat   = parseFloat($(this).find('.vat').val()) || 0;

        let line = qty * price;

        // Proportional discount allocation
        let discountedLine = subtotal > 0
            ? line * (afterDiscount / subtotal)
            : 0;

        vatTotal += discountedLine * vat / 100;
    });

    let grandTotal = afterDiscount + vatTotal;

    // Display values
    $('#subtotal').text(subtotal.toFixed(DecimalPositions));
    $('#total_discount_amount').text(discountAmount.toFixed(DecimalPositions));
    $('#after_discount_amount').text(afterDiscount.toFixed(DecimalPositions));
    $('#vat_total').text(vatTotal.toFixed(DecimalPositions));
    $('#grand_total').text(grandTotal.toFixed(DecimalPositions));

    // Total including VAT before discount (optional)
    $('#allItemSubtotal').text(
        (subtotal + vatTotal).toFixed(DecimalPositions)
    );
}
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

//customer filter
$('#filterOffcanvas').on('shown.bs.offcanvas', function () {
    $('#selectCustomerFromSelect2_filter').select2({
        dropdownParent: $('#cashmemoCanvas')
    });
});
$('#selectCustomerFromSelect2_filter').select2({
     dropdownParent: $('#cashmemoCanvas'),
    placeholder: 'Search customer by name, mobile or CPR/CR',
    allowClear: true,
    minimumInputLength: 2,
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
                    id: item.customer_code,
                    text: item.customer_name,
                    customer_name: item.customer_name,
                    customer_mobile: item.customer_mobile,
                    customer_address: item.customer_addr,
                    customer_email: item.customer_email,
                    customer_code: item.customer_code,
                    customer_attn: item.customer_attn,
                    customer_cr_cpr: item.customer_cr_cpr
                }))
            };
        }
    },
    templateResult: formatCustomer,
    templateSelection: formatCustomerSelection
});

$('#selectCustomerFromSelect2_filter').on('select2:select', function (e) {

    const data = e.params.data;

    $('#customer_code_filter').val(data.customer_code);

});

$('#selectCustomerFromSelect2_filter').on('select2:clear', function () {

    $('#customer_code_filter').val('');

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
                    customer_cr_cpr: item.customer_cr_cpr
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
    $('#customer_name').val(data.customer_name);
    $('#customer_phone').val(data.customer_mobile);
    $('#customer_email').val(data.customer_email);
    $('#customer_cpr_cr').val(data.customer_cr_cpr);
    $('#customer_address').val(data.customer_address);
    
    initagreementload('cashmemo_selagreement');
});


$('#selectCustomerFromSelect2').on('select2:clear', function () {
    $('#customer_name').val('');
    $('#customer_code').val('');
    $('#customer_phone').val('');
    $('#customer_email').val('');
    $('#customer_cpr_cr').val('');
    $('#customer_address').val('');
    $('#quotation_attention').val('');
    initagreementload('cashmemo_selagreement');
}); 
function initagreementload(element,selectedId = null) {
    let customerCode = $.trim($('#customer_code').val()) || 0;
    let companyId = $('#company_id').val() || '';
     const $dropdown = $('#' + element);
    $.ajax({
        url: "/getAgreementOptions",
        data: {
            customer_code: customerCode,
            company_id: companyId
        },
        method: "GET",
        dataType: "json", // ensures it parses JSON
        success: function(data) {
           
            $dropdown.empty(); 
            $dropdown.append('<option value="0">Select Agreement No.</option>'); // placeholder

            data.forEach(function(item) {
                $dropdown.append(`
                    <option 
                        value="${item.id}" 
                        data-vehicle="${item.vehicle_id}" 
                        data-vehicleno="${item.vehicle_no}" 
                        data-fromperiod="${item.period_from}" 
                        data-toperiod="${item.period_to}"  
                        data-booking_ids="${item.booking_ids}"  
                        data-customer_code="${item.customer_code}"  
                        data-vehicle_model_id="${item.vehicle_model_id}"
                        data-model_name="${item.model_name}"
                        data-color="${item.vehicle_color}">
                        ${item.value}
                    </option>
                `);
              
            });
            
            if (selectedId) {
                $dropdown.val(String(selectedId)).trigger('change');
            }
           
        },
        error: function(xhr, status, error) {
            console.error("Failed to load services:", error);
        }
    });

    // Remove previous handlers and add change handler
    // $dropdown.off('change').on('change', function() {
    //     let selected = $(this).find('option:selected');
    //     $('#cashmemo_car_type').val(selected.data('model_name') ||'');
    //     $('#cashmemo_car_no').val(selected.data('vehicleno') || '');
    //     $('#cashmemo_color').val(selected.data('color') || '');
    //     $('#cashmemo_hidvehicle_id').val(selected.data('vehicle') || '');
    //     $('#cashmemo_hidbooking_ids').val(selected.data('booking_ids') || '');
    //     $('#cashmemo_hidvehicle_model_id').val(selected.data('vehicle_model_id') || '');
    // });
}

$(document).on('change', '#company_id', function() {
    let selected = $(this).find('option:selected');
    $('#company_code').val(selected.data('code') || '');
    $('#company_name').val(selected.data('name') || '');
    initagreementload('cashmemo_selagreement');
});

let isLoadingCashmemoEdit = false;

function loadReceiptPaymentTypes(selectedVal = null) {
    $.post('/CashMemoController', { action: 'GetReceiptPaymentTypes' }, function(res) {
        try {
            const d = typeof res === 'string' ? JSON.parse(res) : res;
            if (d && d.status === 'Success' && Array.isArray(d.data)) {
                const $sel = $('#cm_payment_type');
                const current = selectedVal || $sel.val() || 'FULL SETTLEMENT';
                $sel.empty();
                d.data.forEach(item => {
                    $sel.append(new Option(item.type_name, item.type_name, false, item.type_name === current));
                });
                if (current && !$sel.find('option[value="' + current.replace(/"/g, '\\"') + '"]').length) {
                    $sel.append(new Option(current, current, true, true));
                }
            }
        } catch (e) {}
    });
}
loadReceiptPaymentTypes();

$(document).on('click', '#btnAddPaymentType', function() {
    Swal.fire({
        title: 'Add Payment Type',
        input: 'text',
        inputPlaceholder: 'e.g. SECURITY DEPOSIT, EXTENSION FEE',
        showCancelButton: true,
        confirmButtonText: 'Save',
        inputValidator: (v) => !v || !v.trim() ? 'Please enter a payment type name' : null
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            $.post('/CashMemoController', { action: 'SaveReceiptPaymentType', type_name: result.value.trim() }, function(res) {
                try {
                    const d = typeof res === 'string' ? JSON.parse(res) : res;
                    if (d && d.status === 'Success') {
                        loadReceiptPaymentTypes(d.type_name);
                        setupDropdown('dropdownContent', 'success', svgSuccess + 'Payment type added: ' + d.type_name, 'click');
                    }
                } catch (e) {}
            });
        }
    });
});

function loadAgreementBalanceForCashmemo(contractId, preserveAmount = false) {
    if (!contractId || contractId === '0') {
        $('#cm_paid_advance').val('0.000');
        $('#cm_balance_due').val('0.000');
        if (!preserveAmount) $('#cm_amount').val('0.000');
        return;
    }
    $.post('/CustomerLedgerController', { action: 'GetContractLedgerBalance', contract_id: contractId }, function(res) {
        try {
            const d = typeof res === 'string' ? JSON.parse(res) : res;
            const paid = parseFloat(d.total_credit || 0) || 0;
            const bal = Math.max(0, parseFloat(d.balance || 0) || 0);
            $('#cm_paid_advance').val(paid.toFixed(3));
            $('#cm_balance_due').val(bal.toFixed(3));
            if (!preserveAmount && !$('#cashmemo_id').val()) {
                $('#cm_amount').val(bal.toFixed(3));
            }
        } catch (e) {}
    });
}

function resetCashMemoForm() {
    $('#cashmemoForm')[0].reset();
    $('#cashmemo_id').val('');
    $('#cashmemo_number').val('');
    $('#original_draft').val('No');
    $('#cm_generated_receipt_no').val('');
    $('#cm_receipt_no_display').val('Auto (Sequential)');
    $('#cashmemoNumber').text('');
    $('#cashmemo_date').val('<?= date('Y-m-d') ?>');
    $('#cm_payment_type').val('FULL SETTLEMENT');
    $('#cash_memo_payment_method').val('Cash').trigger('change');
    $('#cm_paid_advance').val('0.000');
    $('#cm_balance_due').val('0.000');
    $('#cm_amount').val('0.000');
    $('#cm_tax_amount').val('0.000');
    $('#selectCustomerFromSelect2').val(null).trigger('change');
    $('#customer_code').val('');
    $('#cashmemo_selagreement').empty().append('<option value="">Select Agreement</option>').trigger('change');
    $('#cm_success_banner').addClass('d-none').removeClass('d-flex');
    $('#btn_save_cashmemo').html('<i class="ri-check-double-line me-1"></i> Generate Receipt');
}

$(document).on('click', '#btnNewReceiptTop, #cm_banner_new_btn', function() {
    resetCashMemoForm();
});

$(document).on('change', '#cash_memo_payment_method', function() {
    if ($(this).val() === 'Cheque') {
        $('.cm-cheque-field').removeClass('d-none');
    } else {
        $('.cm-cheque-field').addClass('d-none');
    }
});

$(document).on('click', '#cm_banner_print_btn', function() {
    const recNo = $.trim($('#cm_generated_receipt_no').val() || $('#cashmemo_number').val() || '');
    if (!recNo) return;
    fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(recNo))
        .then(r => r.text())
        .then(token => {
            if (token && token.trim()) window.open('/CashMemoPrint?token=' + encodeURIComponent(token.trim()), '_blank');
        });
});

$(document).on('click', '#cm_banner_wa_btn', function() {
    const recNo = $.trim($('#cm_generated_receipt_no').val() || $('#cashmemo_number').val() || '');
    if (!recNo) return;
    const phoneRaw = ($('#customer_phone').val() || '').replace(/[^0-9]/g, '');
    const phone = phoneRaw.length === 8 ? ('973' + phoneRaw) : phoneRaw;
    const msg = [
        '*FAST LINK CAR RENTAL - RECEIPT VOUCHER*',
        'Receipt No: ' + recNo,
        'Date: ' + ($('#cashmemo_date').val() || ''),
        'Agreement No: ' + $.trim($('#cashmemo_selagreement').find(':selected').text() || ''),
        'Customer: ' + $.trim($('#selectCustomerFromSelect2').find(':selected').text() || ''),
        'Vehicle: ' + ($('#cashmemo_car_type').val() || '') + ' (' + ($('#cashmemo_car_no').val() || '') + ')',
        'Payment Type: ' + ($('#cm_payment_type').val() || ''),
        'Payment Mode: ' + ($('#cash_memo_payment_method').val() || ''),
        'Amount Paid: ' + (parseFloat($('#cm_amount').val()) || 0).toFixed(3) + ' BHD',
        'Balance Due: ' + ($('#cm_balance_due').val() || '0.000') + ' BHD'
    ].join('\n');
    const url = phone ? ('https://wa.me/' + phone + '?text=' + encodeURIComponent(msg)) : ('https://wa.me/?text=' + encodeURIComponent(msg));
    window.open(url, '_blank');
});

$(document).on('change', '#cashmemo_selagreement', function () {
    let selected = $(this).find('option:selected');

    $('#cashmemo_car_type').val(selected.data('model_name') || '');
    $('#cashmemo_car_no').val(selected.data('vehicleno') || '');
    $('#cashmemo_color').val(selected.data('color') || '');
    $('#cashmemo_hidvehicle_id').val(selected.data('vehicle') || '');
    $('#cashmemo_hidbooking_ids').val(selected.data('booking_ids') || '');
    $('#cashmemo_hidvehicle_model_id').val(selected.data('vehicle_model_id') || '');
    loadAgreementBalanceForCashmemo($(this).val(), isLoadingCashmemoEdit);
});


$(document).on('keydown', '.nav', function(e) {
    let inputs = $('.nav');
    let index = inputs.index(this);

    // ENTER → next field
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();

        if (index + 1 < inputs.length) {
            inputs.eq(index + 1).focus().select();
        } else {
            addRow();
            $('#itemTable tbody tr:last .item_name').focus();
        }
    }

    // SHIFT + ENTER → previous field
    if (e.key === 'Enter' && e.shiftKey) {
        e.preventDefault();
        if (index > 0) {
            inputs.eq(index - 1).focus();
        }
    }
    
    let current = $(this);
    let row = current.closest('tr');
    let colIndex = row.find('.nav').index(this);

    // Arrow Down
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        let nextRow = row.next();
        if (nextRow.length) {
            nextRow.find('.nav').eq(colIndex).focus();
        }
    }

    // Arrow Up
    if (e.key === 'ArrowUp') {
        e.preventDefault();
        let prevRow = row.prev();
        if (prevRow.length) {
            prevRow.find('.nav').eq(colIndex).focus();
        }
    }
});


$(document).keydown(function(e) {

    // Ignore shortcuts when typing in inputs
    let tag = e.target.tagName.toLowerCase();
    if (tag === 'input' || tag === 'textarea') return;

    // ALT + N → Add Row
    if (e.altKey && e.key.toLowerCase() === 'n') {
        e.preventDefault();
        addRow();
        $('#itemTable tbody tr:last .item_name').focus();
        return;
    }

    // ALT + S → Final Save
    if (e.altKey && e.key.toLowerCase() === 's') {
        e.preventDefault();
        saveType = 'final';
        $('#invocieForm').submit();
        return;
    }

    // ALT + D → Draft Save
    if (e.altKey && e.key.toLowerCase() === 'd') {
        e.preventDefault();
        saveType = 'draft';
        $('#invocieForm').submit();
        return;
    }
     // ALT + P → Draft Save
    if (e.altKey && e.key.toLowerCase() === 'p') {
        e.preventDefault();
        let quotationId = $('#quotation_id').val();
        printQuotation(quotationId);
        return;
    }
     // ALT + Q → Quotation List
    if (e.altKey && e.key.toLowerCase() === 'q') {
        e.preventDefault();
       // $('#from_date_filter').val('');
       // $('#to_date_filter').val('');
        openQuotationCanvas('No');
        qPressed = false;
        return;
    }
     // ALT + l → Draft List
    if (e.altKey && e.key.toLowerCase() === 'l') {
        e.preventDefault();
       // $('#from_date_filter').val('');
       // $('#to_date_filter').val('');
        openQuotationCanvas('Yes');
        qPressed = false;
        return;
    }
    // ALT + i → Draft List
   


    // Delete → remove current row
    if (e.key === 'Delete') {
        let focused = $(':focus');
        let row = focused.closest('tr');

        if (row.length && confirm("Delete this item?")) {
            row.addClass('row-highlight');

            setTimeout(function() {
                row.remove();
                renumberRows();
                calculateTotals();
            }, 300);
        }
        return;
    }

    // ESC → Help modal
    // if (e.key === "Escape") {
    //     e.preventDefault();
    //     $('#helpModal').modal('show');
    //     return;
    // }
    if (e.key === "~" || e.key === "`") {
        e.preventDefault();
        $('#helpModal').modal('show');
        return;
    }
    // Q key pressed
    if (e.key.toLowerCase() === 'q') {
        qPressed = true;
        return;
    }

    // Q + 1 → Final quotations
    if (qPressed && e.key === '1') {
        e.preventDefault();
        //$('#from_date_filter').val('');
         //$('#to_date_filter').val('');
        openQuotationCanvas('No');
        qPressed = false;
        return;
    }

 
    // Reset Q state if other key pressed
    qPressed = false;
});

$('#btn_filter').click(function () {
                
   var draft= $('#txt_qtn_draft').val();
   var startDate= $('#from_date_filter').val();
   var endDate= $('#to_date_filter').val();
   var customer_code= $('#customer_code_filter').val();
   var company_id= $('#company_id_filter').val();
   
    loadcashmemoList(draft,startDate,endDate,customer_code,company_id);

});


function openCashMemoCanvas(draft, startDate = '', endDate = '', customer_code='', company_id='') {
    let title = (draft === "Yes") ? "Draft Receipts" : "Receipts";
    $('#canvasTitle').text(title);
    $('#txt_qtn_draft').val(draft);

    // Initialize DataTable if not already
    if (!$.fn.DataTable.isDataTable('#cashmemoList')) {
        cashmemoTable = $('#cashmemoList').DataTable({
            data: [],
            pageLength: 50,
            lengthChange: false,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: false
        });
    }

    // Show offcanvas
    let canvas = new bootstrap.Offcanvas('#cashmemoCanvas');
    canvas.show();

    // Load initial data
    loadcashmemoList(draft,$('#from_date_filter').val(),$('#to_date_filter').val(),$('#customer_code_filter').val(),$('#company_id_filter').val());
}

function loadcashmemoList(draft, startDate = '', endDate = '', customer_code='', company_id='') {
    $.post('/CashMemoController', 
    { 
        draft: draft,
        startDate: startDate,
        endDate: endDate,
        customer_code: customer_code,
        company_id: company_id,
        action: 'GetCashmemo'
    }, 
    function(response) {

        let res = typeof response === "string" ? JSON.parse(response) : response;

        // Clear old data and add new rows
        cashmemoTable.clear();
        cashmemoTable.rows.add(res.data);
        cashmemoTable.draw();
    });
}


$(document).on('click', '.viewCashmemo', function() {
    let id = $(this).data('id');
 $.post('/CashMemoController', 
{ 
    action: 'GetCashmemoDetails',
    cashmemo_id: id
}, 
function(response) {

    let res = typeof response === "string" ? JSON.parse(response) : response;

    if (!res.data || res.data.length === 0) {
        alert("No data found");
        return;
    }

    let q = res.data[0]; // ✅ FIX: get first record

    isLoadingCashmemoEdit = true;
    $('#cashmemo_id').val(q.id);
    $('#original_draft').val(q.draft || 'No');
    $('#cashmemo_number').val(q.cashmemo_no);
    $('#cm_receipt_no_display').val(q.cashmemo_no);
    $('#cm_generated_receipt_no').val(q.cashmemo_no);
    $('#cm_generated_no_badge').text(q.cashmemo_no);
    $('#cm_success_banner').removeClass('d-none').addClass('d-flex');
    $('#btn_save_cashmemo').html('<i class="ri-save-line me-1"></i> Update Receipt');

    $('#cashmemoNumber').text(q.cashmemo_no);
    $('#cashmemo_date').val(q.cashmemo_date);

    if (q.company_id) {
        $('#company_id').val(String(q.company_id));
        const $compOpt = $('#company_id').find('option:selected');
        $('#company_code').val($compOpt.data('code') || '');
        $('#company_name').val($compOpt.data('name') || q.company_name || '');
    }

    let option = new Option(q.customer_name, q.customer_name, true, true);
    $('#selectCustomerFromSelect2').append(option).trigger('change');

    $('input[name=customer_code]').val(q.customer_code);
    $('input[name=customer_phone]').val(q.customer_phone);
    $('input[name=customer_email]').val(q.customer_email);
    $('input[name=customer_cpr_cr]').val(q.customer_cpr_cr);
    $('#customer_address').val(q.customer_address);
    
    initagreementload('cashmemo_selagreement', q.contract_ids);
    $('input[name=cashmemo_car_type]').val(q.model_names);
    $('input[name=cashmemo_car_no]').val(q.vehicle_no);
    $('input[name=cashmemo_color]').val(q.vehicle_color);
    $('#cashmemo_hidvehicle_id').val(q.vehicle_ids);
    $('#cashmemo_hidbooking_ids').val(q.booking_ids);
    $('#cashmemo_hidvehicle_model_id').val(q.model_ids);
    $('#cashmemo_notes').val(q.cashmemo_notes);
    $('#cash_memo_payment_method').val(q.cashmemo_payment_type || 'Cash').trigger('change');
    $('#cash_memo_cheque_date').val(q.cashmemo_cheque_date);
    $('#cash_memo_cheque_ref_no').val(q.cashmemo_cheque_ref_no);

    let items = typeof q.items === "string" ? JSON.parse(q.items || '[]') : (q.items || []);
    let firstItem = Array.isArray(items) && items.length ? items[0] : null;
    if (firstItem && firstItem.item_name) {
        const typeCandidate = String(firstItem.item_name).split(' (')[0].trim();
        if ($('#cm_payment_type option[value="' + typeCandidate + '"]').length) {
            $('#cm_payment_type').val(typeCandidate);
        }
    }
    const amtVal = parseFloat(q.subtotal || (firstItem ? firstItem.price : 0) || q.grand_total || 0) || 0;
    const taxVal = parseFloat(q.vat_total || 0) || 0;
    $('#cm_amount').val(amtVal.toFixed(3));
    $('#cm_tax_amount').val(taxVal.toFixed(3));
    setTimeout(() => { isLoadingCashmemoEdit = false; }, 600);

    // close offcanvas
       
    let canvas = bootstrap.Offcanvas.getInstance(
        document.getElementById('cashmemoCanvas')
    );
    if (canvas) canvas.hide();
});
   
});


        let row=0;
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
                            case 'DeleteData':
                                DeleteRowFromTheTable();
                            break;
                            case 'DeleteTerms':
                                deleteTermsAndCondition();
                            break;
                            case 'DeleteIntroduction':
                                deleteIntroduction();
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


        $(document).on('click', '.remove', function() {
            row = $(this).closest('tr');
        
            row.addClass('row-highlight');
        
            
             SaNDSAlert('Are you sure you want to delete the Item..!','DeleteData','danger','#C70039','Yes I am Sure');
            
            
            
        });

        function DeleteRowFromTheTable()
        {
                row.remove();
                renumberRows();
                calculateTotals();
                row.removeClass('row-highlight');
                setupDropdown('dropdownContent','success',svgSuccess+'Row removed successfully','click');
        }


$('#addRow').click(addRow);

addRow();

let saveType = "final"; 


$('button[name="save_type"]').click(function(){
    saveType = $(this).val(); // 'final' or 'draft'
});

$('#cashmemoForm').submit(function(e){
    e.preventDefault();
    if (!validatecashmemoForm()) {
        return;
    }
    let cashmemoId = $('#cashmemo_id').val();
    let originalDraft = $('#original_draft').val();

    if(cashmemoId){ 
         saveCashMemo('update');

    } else {
        saveCashMemo('new');
    }
});

function saveCashMemo(action_type){
    var laddaBtn = Ladda.create(document.querySelector('#btn_save_cashmemo'));
    laddaBtn.start();

    const amt = parseFloat($('#cm_amount').val()) || 0;
    const tax = parseFloat($('#cm_tax_amount').val()) || 0;
    const totalAmt = amt + tax;
    const payType = $('#cm_payment_type').val() || 'RENT';
    const agreeNo = $.trim($('#cashmemo_selagreement').find(':selected').text());

    let items = [{
        item_name: payType + ' (' + agreeNo + ')',
        qty: 1,
        price: amt.toFixed(3),
        vat: tax > 0 && amt > 0 ? ((tax / amt) * 100).toFixed(2) : 0,
        total: totalAmt.toFixed(3)
    }];

    let data = {
        company_id: $('#company_id').val(),
        cashmemo_id: $('#cashmemo_id').val(),
        cashmemo_number: $('#cashmemo_number').val(),
        original_draft: $('#original_draft').val(),
        action_type: action_type,
        save_type: saveType,
        customer_name: $('#selectCustomerFromSelect2').find(':selected').text(),
        customer_code: $('input[name=customer_code]').val(),
        customer_phone: $('input[name=customer_phone]').val(),
        customer_email: $('input[name=customer_email]').val(),
        customer_cpr_cr: $('input[name=customer_cpr_cr]').val(),
        customer_address: $('#customer_address').val(),
        cashmemo_date: $('#cashmemo_date').val(),
        cashmemo_notes: $('#cashmemo_notes').val(),
        cashmemo_payment_type: $('#cash_memo_payment_method').val(),
        cashmemo_cheque_date: $('#cash_memo_cheque_date').val(),
        cashmemo_cheque_ref_no: $('#cash_memo_cheque_ref_no').val(),
        contract_id: $('#cashmemo_selagreement').find(':selected').val(),
        agreement_no: agreeNo,
        vehicle_id: $('#cashmemo_hidvehicle_model_id').val(),
        booking_ids: $('#cashmemo_hidbooking_ids').val(),
        vehicle_model_id: $('#cashmemo_hidvehicle_id').val(),
        model_name: $('#cashmemo_car_type').val(),
        vehicleno: $('#cashmemo_car_no').val(),
        vehiclecolor: $('#cashmemo_color').val(),
        items: items,
        subtotal: amt.toFixed(3),
        vat_total: tax.toFixed(3),
        grand_total: totalAmt.toFixed(3),
        total_discount: 0,
        total_discount_amount: 0,
        after_discount_amount: totalAmt.toFixed(3),
        allItemSubtotal: amt.toFixed(3),
        action: 'SaveCashMemo'
    };
    $.post('/CashMemoController', data)
        .done(function(res) {
            try {
                var jsonData = (typeof res === 'string') ? JSON.parse(res) : res;

                if (jsonData.status && jsonData.status.toLowerCase() === "success") {
                    const recNo = jsonData.message || $('#cashmemo_number').val() || '';
                    $('#cm_generated_receipt_no').val(recNo);
                    $('#cm_generated_no_badge').text(recNo);
                    $('#cm_receipt_no_display').val(recNo);
                    $('#cashmemoNumber').text(recNo);
                    $('#cm_success_banner').removeClass('d-none').addClass('d-flex');
                    loadAgreementBalanceForCashmemo($('#cashmemo_selagreement').val(), true);
                    setupDropdown('dropdownContent', 'success', svgSuccess + recNo + " : " + jsonData.msg_text, 'click');
                } else {
                    setupDropdown('dropdownContent', 'error', svgError + (jsonData.message || 'Unknown error'), 'click');
                }
            } catch (err) {
                setupDropdown('dropdownContent', 'error', svgError + 'Invalid server response', 'click');
                console.error('JSON parse error:', err);
            }
        })
        .fail(function(xhr, status, error) {
            setupDropdown('dropdownContent', 'error', svgError + 'Server error: ' + error, 'click');
            console.error('AJAX error:', status, error);
        })
        .always(function() {
            laddaBtn.stop();
        });
}

function validatecashmemoForm() {
    let valid = true;
    let message = "";

    if (!$('#company_id').val()) {
        message = "Company selection is required.";
        valid = false;
    }
    if (valid && !$('#selectCustomerFromSelect2').val()) {
        message = "Customer name is required.";
        valid = false;
    }
    if (valid && !$('#cashmemo_date').val()) {
        message = "Date is required.";
        valid = false;
    }
    if (valid && (!$('#cashmemo_selagreement').val() || $('#cashmemo_selagreement').val() === '0')) {
        message = "Agreement number is required.";
        valid = false;
    }
    if (valid && (parseFloat($('#cm_amount').val()) || 0) <= 0) {
        message = "Please enter a receipt amount greater than 0.";
        valid = false;
    }

    if (!valid) {
        setupDropdown('dropdownContent', 'error', svgSuccess + message, 'click');
    }
    return valid;
}
  
  


$(document).on('click', '.cashmemoprint', function () {    

    let id = $(this).data('id');
    let ref = $(this).data('ref');
    fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(ref)))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/CashMemoPrint?token=' + encodeURIComponent(token), '_blank');
        });
 

});


    $('#opencashmemo, #MenuListOfInvoices').click(function () {
           //$('#from_date_filter').val('');
          // $('#to_date_filter').val('');
           openCashMemoCanvas('No');
            
    });
    
    
            // Loading Item from Item Tables 
            // Initialize DataTable
                var itemTable = $('#itemSearchTable').DataTable({
                    ajax: '/GetItemList',
                    columns: [
                        { data: 'item_name' }
                    ],
                    dom: '<"top"f>rt<"bottom"p><"clear">',
                    language: {
                        search: "",
                        searchPlaceholder: "Search item..."
                    },
                    pageLength: 10,
                    lengthChange: false,
                    initComplete: function () {
                        $('#itemSearchTable_filter label').remove();
                        var $searchInput = $('#itemSearchTable_filter input');
                        $searchInput.val('');
                        $searchInput.attr('placeholder', 'Type to search item...');
                    }
                });
            
            let currentItemInput = null;

            $(document).on('keydown', '.item_name', function(e) {
            
                if (e.altKey && e.key.toLowerCase() === '/') {
            
                    e.preventDefault();
            
                    currentItemInput = $(this);
            
                    $('#itemSearchModal').modal('show');
            
                    itemTable.search('').draw(); // reset search
                }
            });
            $('#itemSearchTable tbody').on('click', 'tr', function () {

                let data = itemTable.row(this).data();
            
                if (currentItemInput) {
            
                    currentItemInput.val(data.item_name);
            
                    // Optional: Auto fill price & VAT
                    // let row = currentItemInput.closest('tr');
                    // row.find('.price').val(data.price);
                    // row.find('.vat').val(data.vat);
            
                    $('#itemSearchModal').modal('hide');
                    let row = currentItemInput.closest('tr'); 
                    row.find('.qty').focus().select();
                }
            
            });
            $('#itemSearchTable tbody').on('keydown', 'tr', function(e){
            
                if (e.key === 'Enter') {
                      e.preventDefault();
                    $(this).click();
                }
            
            });
            
            
            $('#itemSearchModal').on('shown.bs.modal', function () {
                $('#itemSearchTable_filter input').focus();
            });
            $('#itemSearchTable tbody').on('focus', 'tr', function () {
                $('#itemSearchTable tbody tr').removeClass('row-focus');
                $(this).addClass('row-focus');
            });
            $('#itemSearchTable tbody').on('click', 'tr', function () {

                $('#itemSearchTable tbody tr')
                    .removeClass('row-selected');
            
                $(this)
                    .removeClass('row-focus');
            });
            itemTable.on('draw', function() {
                
                // Make rows focusable
                $('#itemSearchTable tbody tr').attr('tabindex', '0');
            
                // Focus search box
                setTimeout(function(){
                    $('.dataTables_filter input').focus();
                }, 100);
            
            });


//Contract Ledger
const userRole = '<?= $_SESSION['user_role_name'] ?? '' ?>';
const currentUserId = '<?= $_SESSION['user_id'] ?? 0 ?>';
const todayStr = '<?= date('Y-m-d') ?>';
let ledgerTable = null;
$(document).on('click', '.viewContractLedgerBtn', function () {
const btn = this;
     let selected = $("#cashmemo_selagreement").find('option:selected');

    let id = selected.val();
    let agreement_no = selected.text();

    let vehicleid = selected.attr('data-vehicle');
    let vehicleNo = selected.attr('data-vehicleno');
    let fromDate = selected.attr('data-fromperiod');
    let toDate = selected.attr('data-toperiod');
    let booking_ids = selected.attr('data-booking_ids');
    let customer_code = selected.attr('data-customer_code');
    let model_ids = selected.attr('data-vehicle_model_id');
    let modelName = selected.attr('data-model_name');
    let color = selected.attr('data-color');
    
   
   if (!id || id == 0) {
        setupDropdown(
            'dropdownContent',
            'warning',
            svgSuccess + ' Please select an agreement',
            'click'
        );
        return;
    }

    $('#ledger_agreement_ref').text(agreement_no);
    $('#txt_ledger_modal_agreement_id').val(id);
    $('#txt_ledger_modal_agreement_no').val(agreement_no);
    $('#txt_ledger_modal_booking_ids').val(booking_ids);
    $('#txt_ledger_modal_vehicle_ids').val(vehicleid);
    $('#txt_ledger_modal_model_ids').val(model_ids);
    $('#txt_ledger_modal_customer_code').val(customer_code);
    $('#display_agreement_no').text(agreement_no);

    // Hide tooltip if open
    const tooltip = bootstrap.Tooltip.getInstance(btn);
    if (tooltip) {
        tooltip.hide();
    }

    opencontractLedgerModal(
        id,
        vehicleid,
        customer_code,
        model_ids
    );

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
        let mob = data.customer.customer_mobile || '';
        let cprcr = data.customer.customer_cr_cpr || '';
        $('#display_mobile').text(mob+' | '+ cprcr);
      
        $('#display_email').text(data.customer.customer_email || '');
        let vehicle = data.vehicle || {};
        
        $('#display_vehicle_category').text(data.vehicle.category_name || '');
        $('#display_vehicle_model').text(data.vehicle.model_names || '');
         $('#display_vehicleno').text(data.vehicle.vehicle_number || '');
        
        let contract = data.contract || {};
        $('#display_booking_ref').text(data.contract.agreement_group_ref_no || '');
        $('#display_quotation_no').text(data.contract.quotation_number || '');
        $('#txt_ledger_modal_quotation_number').val(data.contract.quotation_number);
        $('#txt_ledger_modal_booking_ref').val(data.contract.agreement_group_ref_no);
        $('.min-pricing-text').text('Min: 0.000');
        $('#txtAmounthidden').val('0');
         $('#txtAmount').val('');
        loadHeads();
        const contractIdToLoad = (data.contract && data.contract.ids) ? data.contract.ids : $('#txt_ledger_modal_agreement_id').val();
        refreshLedger(contractIdToLoad);
        
       
   
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
function escLedgerHtml(s) {
    return $('<div>').text(s == null ? '' : String(s)).html();
}

function getLedgerFlagObj(r) {
    const deb = parseFloat(r.debit || 0);
    const cred = parseFloat(r.credit || 0);
    if (r.payment_method === 'Cheque') {
        const st = r.cheque_status || 'Pending';
        if (st === 'Collected') return { label: 'Collected', cls: 'bg-success' };
        if (st === 'Bounced') return { label: 'Bounced', cls: 'bg-danger' };
        return { label: 'Pending Cheque', cls: 'bg-warning' };
    }
    if (cred > 0) return { label: 'Paid', cls: 'bg-label-success' };
    if (deb > 0) return { label: 'Charge', cls: 'bg-label-danger' };
    return { label: 'Info', cls: 'bg-label-secondary' };
}

function renderLedgerRefDetails(r) {
    const refNo = $.trim(r.ref_no || '');
    const agreeNo = $.trim(r.agreement_no || '');
    const bkgNo = $.trim(r.booking_no || '');
    const quotNo = $.trim(r.quotation_no || '');
    const primaryRef = refNo || agreeNo || bkgNo || quotNo || '-';

    let out = `<div class="fw-semibold text-dark">${escLedgerHtml(primaryRef)}`;
    if (r.cheque_date) {
        out += ` <span class="badge bg-label-warning ms-1"><i class="ri-calendar-line me-1"></i>Chq: ${moment(r.cheque_date).format('DD MMM YYYY')}</span>`;
    }
    out += `</div>`;

    if (r.description) {
        out += `<div class="small text-muted mt-1"><i class="ri-chat-3-line me-1"></i>${escLedgerHtml(r.description)}</div>`;
    }

    let metaBadges = [];
    if (agreeNo && agreeNo !== primaryRef) {
        metaBadges.push(`<span class="badge bg-label-primary"><i class="ri-file-text-line me-1"></i>Agr: ${escLedgerHtml(agreeNo)}</span>`);
    }
    if (bkgNo && bkgNo !== primaryRef) {
        metaBadges.push(`<span class="badge bg-label-info"><i class="ri-bookmark-line me-1"></i>Bkg: ${escLedgerHtml(bkgNo)}</span>`);
    }
    if (quotNo && quotNo !== primaryRef) {
        metaBadges.push(`<span class="badge bg-label-secondary"><i class="ri-file-list-line me-1"></i>Quot: ${escLedgerHtml(quotNo)}</span>`);
    }
    if (r.bank_name) {
        metaBadges.push(`<span class="badge bg-label-primary"><i class="ri-bank-line me-1"></i>From: ${escLedgerHtml(r.bank_name)}${r.account_no ? ' (' + escLedgerHtml(r.account_no) + ')' : ''}</span>`);
    }
    if (r.company_bank_name) {
        metaBadges.push(`<span class="badge bg-label-success"><i class="ri-bank-fill me-1"></i>To: ${escLedgerHtml(r.company_bank_name)}${r.company_account_no ? ' (' + escLedgerHtml(r.company_account_no) + ')' : ''}</span>`);
    }
    if (r.cheque_status === 'Collected' && r.collected_at) {
        metaBadges.push(`<span class="badge bg-label-success"><i class="ri-checkbox-circle-line me-1"></i>Collected: ${moment(r.collected_at).format('DD MMM YYYY')}</span>`);
    }
    if (metaBadges.length) {
        out += `<div class="d-flex flex-wrap gap-1 mt-1">${metaBadges.join('')}</div>`;
    }
    return out;
}

function openEncryptedLedgerPrint(urlPath, docNo) {
    const cleanNo = $.trim(docNo || '');
    if (!cleanNo) return;
    fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(cleanNo))
        .then(res => res.text())
        .then(token => {
            if (!token || !token.trim()) {
                Swal.fire('Error', 'Encryption failed.', 'error');
                return;
            }
            window.open(urlPath + '?token=' + encodeURIComponent(token.trim()), '_blank');
        });
}

let contractModalLedgerRows = [];
let contractModalCustomerInfo = {};
let contractModalAgreementNo = '';

$(document).on('click', '#btnContractModalPrintSOA', function() {
    if (typeof window.jspdf === 'undefined') {
        alert('PDF library not loaded yet.');
        return;
    }
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4');
    const ps = window.LEDGER_PRINT_SETTINGS || {};
    const cleanHex = String(ps.accent_color || '').replace('#', '').trim();
    const accentRgb = /^[0-9a-fA-F]{6}$/.test(cleanHex)
        ? [parseInt(cleanHex.substring(0, 2), 16), parseInt(cleanHex.substring(2, 4), 16), parseInt(cleanHex.substring(4, 6), 16)]
        : [27, 61, 148];
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const marginX = 32;
    const imgData = ps.logo_base64 || '';
    const showLogo = Number(ps.show_logo !== undefined ? ps.show_logo : 1) === 1;
    const logoW = Math.min(130, Math.max(70, Number(ps.logo_width || 120) * 0.8));
    const logoH = logoW / 2.8;

    const totDebit = $('#lblTotalDebit').text() || '0.000';
    const totCredit = $('#lblTotalCredit').text() || '0.000';
    const totBalance = $('#lblBalance').text() || '0.000';
    const agreeNo = $('#txt_ledger_modal_agreement_no').val() || contractModalAgreementNo || '-';
    const custLabel = $('#display_customer_name').text() || '';

    const bodyRows = contractModalLedgerRows.length
        ? contractModalLedgerRows.map(r => {
            const f = getLedgerFlagObj(r);
            const dt = r.trans_date ? moment(r.trans_date).format('DD MMM YYYY') : '-';
            const primaryRef = $.trim(r.ref_no || '') || $.trim(r.agreement_no || '') || $.trim(r.booking_no || '') || $.trim(r.quotation_no || '') || '-';
            const descParts = [primaryRef];
            if (r.description) descParts.push(r.description);
            if (r.bank_name) descParts.push('Bank: ' + r.bank_name);
            return [
                dt,
                r.agreement_no || agreeNo,
                `${r.trans_type || '-'}${r.payment_method && r.payment_method !== 'N/A' ? ' (' + r.payment_method + ')' : ''}`,
                descParts.join(' | '),
                f.label,
                parseFloat(r.debit || 0) > 0 ? parseFloat(r.debit).toFixed(3) : '-',
                parseFloat(r.credit || 0) > 0 ? parseFloat(r.credit).toFixed(3) : '-',
                parseFloat(r.running_balance || 0).toFixed(3)
            ];
        })
        : [[{ content: 'No ledger transactions found.', colSpan: 8, styles: { halign: 'center' } }]];

    doc.autoTable({
        head: [['Date', 'Agreement', 'Type / Method', 'Reference & Details', 'Flag', 'Debit', 'Credit', 'Balance']],
        body: bodyRows,
        startY: 128,
        theme: 'grid',
        styles: { fontSize: 8.5, font: 'helvetica', cellPadding: 5, valign: 'middle', lineColor: [215, 222, 235], lineWidth: 0.4 },
        headStyles: { fillColor: accentRgb, textColor: 255, fontStyle: 'bold' },
        columnStyles: {
            0: { cellWidth: 70 },
            1: { cellWidth: 95 },
            4: { cellWidth: 72, halign: 'center' },
            5: { cellWidth: 62, halign: 'right' },
            6: { cellWidth: 62, halign: 'right' },
            7: { cellWidth: 66, halign: 'right', fontStyle: 'bold' }
        },
        alternateRowStyles: { fillColor: [248, 250, 253] },
        margin: { top: 96, left: marginX, right: marginX, bottom: 50 },
        didDrawPage: function (data) {
            if (showLogo && imgData) {
                try { doc.addImage(imgData, 'PNG', marginX, 18, logoW, logoH); } catch (e) {}
            }
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(15);
            doc.setTextColor(accentRgb[0], accentRgb[1], accentRgb[2]);
            doc.text(String(ps.company_name || 'FAST LINK CAR RENTAL'), pageWidth / 2, 30, { align: 'center' });
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(80, 90, 105);
            if (ps.header_subtitle) doc.text(String(ps.header_subtitle), pageWidth / 2, 43, { align: 'center' });
            if (ps.header_address) doc.text(String(ps.header_address), pageWidth / 2, 55, { align: 'center' });

            let rightX = pageWidth - marginX;
            let rightY = 26;
            doc.setFontSize(8);
            if (ps.header_phone) { doc.text('Tel: ' + String(ps.header_phone), rightX, rightY, { align: 'right' }); rightY += 11; }
            if (ps.header_email) { doc.text(String(ps.header_email), rightX, rightY, { align: 'right' }); rightY += 11; }
            if (ps.header_website) { doc.text(String(ps.header_website), rightX, rightY, { align: 'right' }); }

            doc.setDrawColor(accentRgb[0], accentRgb[1], accentRgb[2]);
            doc.setLineWidth(1.2);
            doc.line(marginX, 68, pageWidth - marginX, 68);

            if (data.pageNumber === 1) {
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(12);
                doc.setTextColor(30, 41, 59);
                doc.text('AGREEMENT STATEMENT OF ACCOUNT (SOA)', marginX, 86);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(8.5);
                doc.setTextColor(71, 85, 105);
                doc.text(`Customer: ${custLabel}  |  Agreement: ${agreeNo}`, marginX, 102);
                doc.text(`Statement Date: ${moment().format('DD MMM YYYY')}`, rightX, 86, { align: 'right' });
                doc.setFont('helvetica', 'bold');
                doc.text(`Total Debit: ${totDebit}   |   Total Credit: ${totCredit}   |   Balance: ${totBalance} BHD`, rightX, 114, { align: 'right' });
            } else {
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(10);
                doc.setTextColor(71, 85, 105);
                doc.text(`Agreement SOA - ${agreeNo} (Cont.)`, marginX, 84);
            }

            let footerY = pageHeight - 28;
            doc.setDrawColor(203, 213, 225);
            doc.setLineWidth(0.6);
            doc.line(marginX, footerY - 10, pageWidth - marginX, footerY - 10);
            if (Number(ps.show_footer !== undefined ? ps.show_footer : 1) === 1) {
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(71, 85, 105);
                if (ps.footer_text) doc.text(String(ps.footer_text), marginX, footerY);
                if (ps.footer_note) {
                    doc.setFontSize(7.5);
                    doc.setTextColor(120, 130, 145);
                    doc.text(String(ps.footer_note), marginX, footerY + 11);
                }
            }
            let pageStr = 'Page ' + doc.internal.getNumberOfPages();
            if (typeof doc.putTotalPages === 'function') pageStr += ' of totalPages';
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(8);
            doc.setTextColor(71, 85, 105);
            doc.text(pageStr, rightX, footerY, { align: 'right' });
        }
    });
    if (typeof doc.putTotalPages === 'function') doc.putTotalPages('totalPages');
    window.open(doc.output('bloburl'), '_blank');
});

function refreshLedger(code) {
            if ($.fn.DataTable.isDataTable('#tblLedger')) {
                $('#tblLedger').DataTable().destroy();
            }

            contractModalAgreementNo = $('#txt_ledger_modal_agreement_no').val() || '';
            contractModalCustomerInfo = {
                customer_name: $('#display_customer_name').text() || '',
                customer_mobile: $('#display_mobile').text() || ''
            };

            ledgerTable = $('#tblLedger').DataTable({
                ajax: {
                    url: '/CustomerLedgerController',
                    data: { action: 'GetContractLedgerData', contract_id: code },
                    dataSrc: function(json) {
                        const rows = (json && Array.isArray(json.data)) ? json.data : [];
                        contractModalLedgerRows = rows;
                        let totDebit = 0, totCredit = 0;
                        rows.forEach(r => {
                            totDebit += parseFloat(r.debit || 0);
                            totCredit += parseFloat(r.credit || 0);
                        });
                        $('#lblTotalDebit').text(totDebit.toFixed(3));
                        $('#lblTotalCredit').text(totCredit.toFixed(3));
                        $('#lblBalance').text((totDebit - totCredit).toFixed(3));
                        return rows;
                    }
                },
                columns: [
                    { 
                        data: 'trans_date',
                        className: 'text-nowrap',
                        render: v => v ? moment(v).format('DD MMM YYYY') : '-'
                    },
                    { 
                        data: null, 
                        render: r => {
                            const method = (r.payment_method && r.payment_method !== 'N/A') ? `<span class="badge bg-label-info mt-1">${escLedgerHtml(r.payment_method)}</span>` : '<small class="text-muted">N/A</small>';
                            return `<div class="fw-semibold">${escLedgerHtml(r.trans_type || '-')}</div>${method}`;
                        }
                    },
                    { 
                        data: null, 
                        render: r => renderLedgerRefDetails(r)
                    },
                    {
                        data: null,
                        className: 'text-center text-nowrap',
                        render: r => {
                            const f = getLedgerFlagObj(r);
                            return `<span class="badge ${f.cls}">${escLedgerHtml(f.label)}</span>`;
                        }
                    },
                    { data: 'debit', className: 'text-end text-danger text-nowrap', render: v => parseFloat(v || 0) > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { data: 'credit', className: 'text-end text-success text-nowrap', render: v => parseFloat(v || 0) > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { 
                        data: 'running_balance', 
                        className: 'text-end fw-bold text-nowrap', 
                        render: v => {
                            const val = parseFloat(v || 0);
                            return `<span class="${val >= 0 ? 'text-primary' : 'text-danger'}">${val.toFixed(3)}</span>`;
                        }
                    },
                    {
                        data: 'ids',
                        className: 'text-nowrap',
                        render: (id, type, row) => {
                            let btns = `<div class="d-flex gap-1">
                                <button type="button" class="btn btn-icon-square btn-icon text-primary btn-edit" data-id="${id}" title="Edit"><span class="ri ri-edit-line ri-xl"></span></button>
                                <button type="button" class="btn btn-icon-square btn-icon text-danger btn-delete" data-id="${id}" title="Delete"><span class="ri ri-delete-bin-line ri-xl"></span></button>`;

                            const candReceipt = $.trim(row.matched_cashmemo_no || (parseFloat(row.credit || 0) > 0 && /\/CM\/|CM\//i.test(String(row.ref_no || '')) ? row.ref_no : ''));
                            if (candReceipt) {
                                btns += `<button type="button" class="btn btn-icon-square btn-icon text-success btn-modal-print-receipt" data-receipt="${escLedgerHtml(candReceipt)}" title="Print Receipt ${escLedgerHtml(candReceipt)}"><span class="ri-printer-line ri-xl"></span></button>`;
                            }
                            if (row.payment_method === 'Cheque') {
                                if (row.cheque_status === 'Pending') {
                                    btns += `
                                        <button class="btn btn-icon-square btn-icon text-success btn-status-main" data-id="${id}" data-status="Collected" title="Collect Cheque"><span class="ri ri-check-line ri-xl"></span></button>
                                        <button class="btn btn-icon-square btn-icon text-warning btn-status-main" data-id="${id}" data-status="Bounced" title="Bounce Cheque"><span class="ri ri-close-line ri-xl"></span></button>
                                    `;
                                } else {
                                    btns += `<button class="btn btn-icon-square btn-icon text-secondary btn-status-main" data-id="${id}" data-status="Pending" title="Revoke Status"><span class="ri ri-refresh-line ri-xl"></span></button>`;
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
                order: [],
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
        
        
    //Customer Ledger button
let CustomerledgerTable = null;
$(document).on('click', '.viewCustomerLedgerBtn', function () {

const customerLedgerbtn = this;
let customer_code =  $('#customer_code').val();

   if (!customer_code || customer_code == 0) {
        setupDropdown(
            'dropdownContent',
            'warning',
            svgSuccess + ' Please select customer',
            'click'
        );
        return;
    }

  

    // Hide tooltip if open
    const tooltip = bootstrap.Tooltip.getInstance(customerLedgerbtn);
    if (tooltip) {
        tooltip.hide();
    }

    opencustomerLedgerModal(
        customer_code
    );

});


function opencustomerLedgerModal(customer_code) {

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            customer_code:customer_code
        }),
        success: function (res) {
         populatecustomerLedgerModal(res);
            new bootstrap.Modal(document.getElementById('customerLedgerModal')).show();
        }
    });
}
let modalCustomerInfo = null;
let modalCustomerLedgerRows = [];
let modalCustomerCodeCurrent = '';

function populatecustomerLedgerModal(d) {
    let data = (typeof d === "string") ? JSON.parse(d) : d;
    modalCustomerInfo = data.customer || {};
    modalCustomerCodeCurrent = modalCustomerInfo.customer_id || '';

    $('#customer_ledger_customer_name').text(modalCustomerInfo.customer_name || '');
    $('#customer_display_customer_name').text((modalCustomerInfo.customer_name || '') + (modalCustomerInfo.customer_id ? ' | ' + modalCustomerInfo.customer_id : ''));
    $('#txt_customer_ledger_modal_customer_code').val(modalCustomerCodeCurrent);
    $('#customer_display_mobile').text(modalCustomerInfo.customer_mobile || '');
    $('#customer_display_email').text(modalCustomerInfo.customer_email || '');
    $('#customer_display_cprcr').text(modalCustomerInfo.customer_cr_cpr || '');

    loadModalCustomerContracts(modalCustomerCodeCurrent);
    refreshCustomerLedger(modalCustomerCodeCurrent, 'All');
}

function loadModalCustomerContracts(code) {
    $('#modalCustomerContractsList').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></div>');
    $.get('/CustomerLedgerController', { action: 'GetCustomerContractsSummary', customer_code: code }, function(res) {
        const contracts = (res && res.data) ? res.data : [];
        $('#lblModalContractCount').text(contracts.length);
        if (!contracts.length) {
            $('#modalCustomerContractsList').html('<div class="text-muted small text-center py-3">No agreements found.</div>');
            return;
        }
        let html = `<button type="button" class="btn btn-sm btn-outline-primary w-100 mb-1 btn-modal-filter-contract" data-id="All">Show All Agreements</button>`;
        html += contracts.map(c => {
            const statusBadge = c.is_returned ? '<span class="badge bg-label-secondary">Returned</span>' : '<span class="badge bg-label-success">Active</span>';
            const deb = parseFloat(c.total_debit || 0).toFixed(3);
            const cred = parseFloat(c.total_credit || 0).toFixed(3);
            const bal = parseFloat(c.balance || 0).toFixed(3);
            const balCls = parseFloat(c.balance || 0) > 0 ? 'text-danger' : 'text-success';
            const receipts = Array.isArray(c.receipts) ? c.receipts : [];
            let receiptBtnHtml = '';
            if (receipts.length === 1) {
                receiptBtnHtml = `<button type="button" class="btn btn-xs btn-outline-success btn-modal-print-receipt" data-receipt="${escLedgerHtml(receipts[0].cashmemo_no)}"><i class="ri-receipt-line me-1"></i>Receipt</button>`;
            } else if (receipts.length > 1) {
                const items = receipts.map(rc => `<li><a class="dropdown-item btn-modal-print-receipt" href="javascript:void(0)" data-receipt="${escLedgerHtml(rc.cashmemo_no)}">${escLedgerHtml(rc.cashmemo_no)} (${parseFloat(rc.net_total || 0).toFixed(3)})</a></li>`).join('');
                receiptBtnHtml = `<div class="btn-group">
                    <button type="button" class="btn btn-xs btn-outline-success dropdown-toggle" data-bs-toggle="dropdown"><i class="ri-receipt-line me-1"></i>Receipts (${receipts.length})</button>
                    <ul class="dropdown-menu dropdown-menu-end">${items}</ul>
                </div>`;
            }
            return `<div class="border rounded p-2 bg-light-subtle">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <a href="javascript:void(0)" class="fw-bold text-primary btn-modal-view-agreement" data-contract="${escLedgerHtml(c.agreement_no)}">${escLedgerHtml(c.agreement_no)}</a>
                        <div class="small text-muted">${escLedgerHtml(c.vehicle_no || '-')} ${c.model_name ? '· ' + escLedgerHtml(c.model_name) : ''}</div>
                    </div>
                    ${statusBadge}
                </div>
                <div class="d-flex justify-content-between small mt-2 pt-1 border-top">
                    <span>Debit: <strong>${deb}</strong></span>
                    <span>Paid: <strong class="text-success">${cred}</strong></span>
                    <span>Bal: <strong class="${balCls}">${bal}</strong></span>
                </div>
                <div class="d-flex flex-wrap gap-1 mt-2">
                    <button type="button" class="btn btn-xs btn-outline-primary btn-modal-filter-contract" data-id="${c.contract_id}"><i class="ri-list-check me-1"></i>Ledger</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary btn-modal-view-agreement" data-contract="${escLedgerHtml(c.agreement_no)}"><i class="ri-file-text-line me-1"></i>Agreement</button>
                    ${receiptBtnHtml}
                </div>
            </div>`;
        }).join('');
        $('#modalCustomerContractsList').html(html);
    }, 'json');
}

$(document).on('click', '.btn-modal-filter-contract', function() {
    refreshCustomerLedger(modalCustomerCodeCurrent, $(this).data('id'));
});
$(document).on('click', '.btn-modal-view-agreement', function() {
    openEncryptedLedgerPrint('/PrintAgreement', $(this).data('contract'));
});
$(document).on('click', '.btn-modal-print-receipt', function() {
    openEncryptedLedgerPrint('/CashMemoPrint', $(this).data('receipt'));
});

function refreshCustomerLedger(code, contractId = 'All') {
            if ($.fn.DataTable.isDataTable('#tblCustomerLedger')) {
                $('#tblCustomerLedger').DataTable().destroy();
            }

            CustomerledgerTable = $('#tblCustomerLedger').DataTable({
                ajax: {
                    url: '/CustomerLedgerController',
                    data: { action: 'GetCustomerContractLedgerData', customer_code: code, contract_id: contractId },
                    dataSrc: function(json) {
                        const rows = (json && Array.isArray(json.data)) ? json.data : [];
                        modalCustomerLedgerRows = rows;
                        let totDebit = 0, totCredit = 0;
                        rows.forEach(r => {
                            totDebit += parseFloat(r.debit || 0);
                            totCredit += parseFloat(r.credit || 0);
                        });
                        $('#customer_lblTotalDebit').text(totDebit.toFixed(3));
                        $('#customer_lblTotalCredit').text(totCredit.toFixed(3));
                        $('#customer_lblBalance').text((totDebit - totCredit).toFixed(3));
                        return rows;
                    }
                },
                columns: [
                    { 
                        data: 'trans_date',
                        className: 'text-nowrap',
                        render: v => v ? moment(v).format('DD MMM YYYY') : '-'
                    },
                    { 
                        data: null, 
                        render: r => {
                            const method = (r.payment_method && r.payment_method !== 'N/A') ? `<span class="badge bg-label-info mt-1">${escLedgerHtml(r.payment_method)}</span>` : '<small class="text-muted">N/A</small>';
                            return `<div class="fw-semibold">${escLedgerHtml(r.trans_type || '-')}</div>${method}`;
                        }
                    },
                    { 
                        data: null, 
                        render: r => renderLedgerRefDetails(r)
                    },
                    {
                        data: null,
                        className: 'text-center text-nowrap',
                        render: r => {
                            const f = getLedgerFlagObj(r);
                            return `<span class="badge ${f.cls}">${escLedgerHtml(f.label)}</span>`;
                        }
                    },
                    { data: 'debit', className: 'text-end text-danger text-nowrap', render: v => parseFloat(v || 0) > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { data: 'credit', className: 'text-end text-success text-nowrap', render: v => parseFloat(v || 0) > 0 ? parseFloat(v).toFixed(3) : '-' },
                    { 
                        data: 'running_balance', 
                        className: 'text-end fw-bold text-nowrap', 
                        render: v => {
                            const val = parseFloat(v || 0);
                            return `<span class="${val >= 0 ? 'text-primary' : 'text-danger'}">${val.toFixed(3)}</span>`;
                        }
                    },
                    {
                        data: null,
                        className: 'text-nowrap',
                        render: r => {
                            const agreeNo = $.trim(r.agreement_no || '');
                            let html = agreeNo
                                ? `<div><a href="javascript:void(0)" class="btn-modal-view-agreement fw-bold small text-primary text-decoration-underline" data-contract="${escLedgerHtml(agreeNo)}">${escLedgerHtml(agreeNo)}</a></div>`
                                : '<span class="text-muted small">-</span>';
                            const candReceipt = $.trim(r.matched_cashmemo_no || (parseFloat(r.credit || 0) > 0 && /\/CM\/|CM\//i.test(String(r.ref_no || '')) ? r.ref_no : ''));
                            if (candReceipt) {
                                html += `<button type="button" class="btn btn-xs btn-outline-primary mt-1 btn-modal-print-receipt" data-receipt="${escLedgerHtml(candReceipt)}"><i class="ri-printer-line me-1"></i>Receipt</button>`;
                            }
                            return html;
                        }
                    }
                ],
                createdRow: function(row, data) {
                    if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                    else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
                },
                order: [],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                pageLength: 25
            });
        }

$(document).on('click', '#btnModalPrintSOA', function() {
    if (!modalCustomerInfo || !modalCustomerCodeCurrent) return;
    if (typeof window.jspdf === 'undefined') {
        alert('PDF library not loaded yet.');
        return;
    }
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4');
    const ps = window.LEDGER_PRINT_SETTINGS || {};
    const cleanHex = String(ps.accent_color || '').replace('#', '').trim();
    const accentRgb = /^[0-9a-fA-F]{6}$/.test(cleanHex)
        ? [parseInt(cleanHex.substring(0, 2), 16), parseInt(cleanHex.substring(2, 4), 16), parseInt(cleanHex.substring(4, 6), 16)]
        : [27, 61, 148];
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const marginX = 32;
    const imgData = ps.logo_base64 || '';
    const showLogo = Number(ps.show_logo !== undefined ? ps.show_logo : 1) === 1;
    const logoW = Math.min(130, Math.max(70, Number(ps.logo_width || 120) * 0.8));
    const logoH = logoW / 2.8;

    const totDebit = $('#customer_lblTotalDebit').text() || '0.000';
    const totCredit = $('#customer_lblTotalCredit').text() || '0.000';
    const totBalance = $('#customer_lblBalance').text() || '0.000';

    const bodyRows = modalCustomerLedgerRows.length
        ? modalCustomerLedgerRows.map(r => {
            const f = getLedgerFlagObj(r);
            const dt = r.trans_date ? moment(r.trans_date).format('DD MMM YYYY') : '-';
            const primaryRef = $.trim(r.ref_no || '') || $.trim(r.agreement_no || '') || $.trim(r.booking_no || '') || $.trim(r.quotation_no || '') || '-';
            const descParts = [primaryRef];
            if (r.description) descParts.push(r.description);
            if (r.bank_name) descParts.push('Bank: ' + r.bank_name);
            return [
                dt,
                r.agreement_no || '-',
                `${r.trans_type || '-'}${r.payment_method && r.payment_method !== 'N/A' ? ' (' + r.payment_method + ')' : ''}`,
                descParts.join(' | '),
                f.label,
                parseFloat(r.debit || 0) > 0 ? parseFloat(r.debit).toFixed(3) : '-',
                parseFloat(r.credit || 0) > 0 ? parseFloat(r.credit).toFixed(3) : '-',
                parseFloat(r.running_balance || 0).toFixed(3)
            ];
        })
        : [[{ content: 'No ledger transactions found.', colSpan: 8, styles: { halign: 'center' } }]];

    doc.autoTable({
        head: [['Date', 'Agreement', 'Type / Method', 'Reference & Details', 'Flag', 'Debit', 'Credit', 'Balance']],
        body: bodyRows,
        startY: 128,
        theme: 'grid',
        styles: { fontSize: 8.5, font: 'helvetica', cellPadding: 5, valign: 'middle', lineColor: [215, 222, 235], lineWidth: 0.4 },
        headStyles: { fillColor: accentRgb, textColor: 255, fontStyle: 'bold' },
        columnStyles: {
            0: { cellWidth: 70 },
            1: { cellWidth: 95 },
            4: { cellWidth: 72, halign: 'center' },
            5: { cellWidth: 62, halign: 'right' },
            6: { cellWidth: 62, halign: 'right' },
            7: { cellWidth: 66, halign: 'right', fontStyle: 'bold' }
        },
        alternateRowStyles: { fillColor: [248, 250, 253] },
        margin: { top: 96, left: marginX, right: marginX, bottom: 50 },
        didDrawPage: function (data) {
            if (showLogo && imgData) {
                try { doc.addImage(imgData, 'PNG', marginX, 18, logoW, logoH); } catch (e) {}
            }
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(15);
            doc.setTextColor(accentRgb[0], accentRgb[1], accentRgb[2]);
            doc.text(String(ps.company_name || 'FAST LINK CAR RENTAL'), pageWidth / 2, 30, { align: 'center' });
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(80, 90, 105);
            if (ps.header_subtitle) doc.text(String(ps.header_subtitle), pageWidth / 2, 43, { align: 'center' });
            if (ps.header_address) doc.text(String(ps.header_address), pageWidth / 2, 55, { align: 'center' });

            let rightX = pageWidth - marginX;
            let rightY = 26;
            doc.setFontSize(8);
            if (ps.header_phone) { doc.text('Tel: ' + String(ps.header_phone), rightX, rightY, { align: 'right' }); rightY += 11; }
            if (ps.header_email) { doc.text(String(ps.header_email), rightX, rightY, { align: 'right' }); rightY += 11; }
            if (ps.header_website) { doc.text(String(ps.header_website), rightX, rightY, { align: 'right' }); }

            doc.setDrawColor(accentRgb[0], accentRgb[1], accentRgb[2]);
            doc.setLineWidth(1.2);
            doc.line(marginX, 68, pageWidth - marginX, 68);

            if (data.pageNumber === 1) {
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(12);
                doc.setTextColor(30, 41, 59);
                doc.text('STATEMENT OF ACCOUNT (SOA)', marginX, 86);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(8.5);
                doc.setTextColor(71, 85, 105);
                doc.text(`Customer: ${modalCustomerInfo.customer_name || ''} (${modalCustomerCodeCurrent})  |  Mobile: ${modalCustomerInfo.customer_mobile || '-'}`, marginX, 102);
                doc.text(`Statement Date: ${moment().format('DD MMM YYYY')}`, rightX, 86, { align: 'right' });
                doc.setFont('helvetica', 'bold');
                doc.text(`Total Debit: ${totDebit}   |   Total Credit: ${totCredit}   |   Balance: ${totBalance} BHD`, rightX, 114, { align: 'right' });
            } else {
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(10);
                doc.setTextColor(71, 85, 105);
                doc.text(`Statement of Account - ${modalCustomerInfo.customer_name || ''} (Cont.)`, marginX, 84);
            }

            let footerY = pageHeight - 28;
            doc.setDrawColor(203, 213, 225);
            doc.setLineWidth(0.6);
            doc.line(marginX, footerY - 10, pageWidth - marginX, footerY - 10);
            if (Number(ps.show_footer !== undefined ? ps.show_footer : 1) === 1) {
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(71, 85, 105);
                if (ps.footer_text) doc.text(String(ps.footer_text), marginX, footerY);
                if (ps.footer_note) {
                    doc.setFontSize(7.5);
                    doc.setTextColor(120, 130, 145);
                    doc.text(String(ps.footer_note), marginX, footerY + 11);
                }
            }
            let pageStr = 'Page ' + doc.internal.getNumberOfPages();
            if (typeof doc.putTotalPages === 'function') pageStr += ' of totalPages';
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(8);
            doc.setTextColor(71, 85, 105);
            doc.text(pageStr, rightX, footerY, { align: 'right' });
        }
    });
    if (typeof doc.putTotalPages === 'function') doc.putTotalPages('totalPages');
    window.open(doc.output('bloburl'), '_blank');
});
let hirerPad;
let deliveryPad;
$(document).on('click', '.btnOpenSignature', function () {
     let btn = $(this);
    let cashmemo_id = btn.data('id');
     $('#sig_modal_cashmemoid').val(cashmemo_id);
    
    // 🔥 2. Hide tooltip (IMPORTANT)
    let tooltip = bootstrap.Tooltip.getInstance(btn);
    if (tooltip) {
        tooltip.hide();
    }
    $('#signatureModal').modal('show');
    
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
   
   $.ajax({
       url: '/CashMemoController',
    type: 'POST',
    data: {
        action: 'GetSignDetails',
        cashmemo_id: $(this).data('id')
    },
        success: function (response) {

    if (response.data.length > 0) {

        let row = response.data[0];

        // =====================================
        // HIRER SIGNATURE
        // =====================================

        if (
            row.company_signature &&
            row.company_signature.trim() !== ''
        ) {
            
             let image = new Image();

                image.onload = function () {
                    hirerPad.clear();

                    const ctx = hirerCanvas.getContext('2d');
                    
                    ctx.clearRect(0, 0, hirerCanvas.width, hirerCanvas.height);
                    ctx.drawImage(image, 0, 0, hirerCanvas.width, hirerCanvas.height);
            
                };
            
                image.src = row.company_signature;
            
           
        } else {

           hirerPad.clear();
      

        }

        const defaultLoggedUser = <?= json_encode($_SESSION['profile_name'] ?? $_SESSION['full_name'] ?? $_SESSION['user_name'] ?? $_SESSION['username'] ?? '') ?>;
        $('#hirer_name')
            .val(row.company_sign_name
                ? row.company_sign_name
                : (row.logged_user_name || defaultLoggedUser || row.user_name || ''));

       
        $('#hirer_signed_date')
        .text(
            row.company_sign_date_time_format
                ? 'Signed on : ' + row.company_sign_date_time_format
                : ''
        );


        // =====================================
        // DELIVERY SIGNATURE
        // =====================================

        if (
            row.customer_signature &&
            row.customer_signature.trim() !== ''
        ) {

            let delimage = new Image();

                delimage.onload = function () {
                    deliveryPad.clear();

                const ctx = deliveryCanvas.getContext('2d');
                
                ctx.clearRect(0, 0, deliveryCanvas.width, deliveryCanvas.height);
                ctx.drawImage(delimage, 0, 0, deliveryCanvas.width, deliveryCanvas.height);
                };
            
                delimage.src = row.customer_signature;

        } else {

             deliveryPad.clear();

        }
         $('#delivery_name')
            .val(row.customer_sign_name
                ? row.customer_sign_name
                : (row.customer_name || ''));

       
        $('#delivery_signed_date')
        .text(
            row.customer_sign_datetime_format
                ? 'Signed on : ' + row.customer_sign_datetime_format
                : ''
        );
       

    } else {

        // =====================================
        // NO DATA RETURNED
        // =====================================
        
       hirerPad.clear();
       deliveryPad.clear();
        $('#hirer_name').val('');
        $('#hirer_signed_date').text('');
        $('#delivery_name').val('');
        $('#delivery_signed_date').text('');

    }
  

}
       
    });
   
        
});


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
    let sign_cashmemo_id=$('#sig_modal_cashmemoid').val();
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
     url: '/CashMemoController',
    type: 'POST',
    data: {
        action: "SaveSignature",
        cashmemo_id: sign_cashmemo_id,
        hirer_name: hirer_name,
        delivery_name: delivery_name,
        hirer_signature: hirer_signature,
        delivery_signature: delivery_signature
    },

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


});// CLose of Jquery

$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const preContractId = urlParams.get('contract_id');
    const preCustomerCode = urlParams.get('customer_code') || '';
    const preAgreementNo = urlParams.get('agreement_no') || '';
    if (!preContractId) return;

    $.ajax({
        url: '/ContractListController',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            action: 'GetContractDetails',
            agreementid: preContractId,
            customer_code: preCustomerCode
        }),
        success: function (res) {
            const d = (typeof res === 'string') ? JSON.parse(res) : res;
            if (!d || !d.contract) return;
            const c = d.contract;
            const cust = d.customer || {};

            const cCode = cust.customer_id || c.customer_code || preCustomerCode;
            const cName = cust.customer_name || c.customer_name || '';
            $('#customer_code').val(cCode);
            $('#customer_name').val(cName);
            $('#customer_phone').val(cust.customer_mobile || '');
            $('#customer_email').val(cust.customer_email || '');
            $('#customer_cpr_cr').val(cust.customer_cr_cpr || '');
            $('#customer_address').val(cust.customer_addr || cust.customer_address || '');
            if (cName) {
                const opt = new Option(cName, cCode, true, true);
                $('#selectCustomerFromSelect2').append(opt).trigger('change.select2');
            }

            if (c.company_id && $('#company_id option[value="' + c.company_id + '"]').length > 0) {
                $('#company_id').val(String(c.company_id));
                const selComp = $('#company_id').find('option:selected');
                $('#company_code').val(selComp.data('code') || '');
                $('#company_name').val(selComp.data('name') || '');
            }

            initagreementload('cashmemo_selagreement', preContractId);

            // Also load Contract Ledger summary and show balance due
            $.getJSON('/CustomerLedgerController', {
                action: 'GetContractLedgerData',
                contract_id: preContractId
            }, function (lRes) {
                const ld = (typeof lRes === 'string') ? JSON.parse(lRes) : lRes;
                const rows = (ld && Array.isArray(ld.data)) ? ld.data : (Array.isArray(ld) ? ld : []);
                let totalDebit = 0;
                let totalCredit = 0;
                rows.forEach(r => {
                    totalDebit += parseFloat(r.debit || 0);
                    if ((r.cheque_status || '') !== 'Bounced') {
                        totalCredit += parseFloat(r.credit || 0);
                    }
                });
                const balance = Math.max(0, totalDebit - totalCredit);
                const agrDisp = c.agreement_no || preAgreementNo || ('#' + preContractId);
                if ($('#returnReceiptLedgerBanner').length === 0) {
                    const bannerHtml = `
                        <div id="returnReceiptLedgerBanner" class="alert alert-info d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <div>
                                <strong><i class="ri-file-list-3-line me-1"></i>Contract Ledger (${$('<div>').text(agrDisp).html()}):</strong>
                                <span class="ms-2">Total Charges: <strong>${totalDebit.toFixed(3)} BHD</strong></span>
                                <span class="ms-3">Paid: <strong class="text-success">${totalCredit.toFixed(3)} BHD</strong></span>
                                <span class="ms-3">Balance Due: <strong class="text-danger">${balance.toFixed(3)} BHD</strong></span>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary viewContractLedgerBtn">
                                <i class="ri-book-open-line me-1"></i> View Contract Ledger
                            </button>
                        </div>
                    `;
                    const $target = $('#cashmemo_selagreement').closest('.card-body, .row').parent();
                    if ($target.length) $target.prepend(bannerHtml);
                }
            });
        }
    });
});


    </script>
</body>

</html>