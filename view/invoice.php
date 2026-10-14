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
    background-color: #f12526;   /* Blue header (Bootstrap primary) */
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
/*.select2-container {*/
/*    width: 100% !important;*/
/*}*/

/*.select2-container .select2-selection--single {*/
/*    height: 38px !important;*/
/*    display: flex !important;*/
/*    align-items: center !important;*/
/*    border: 1px solid #ced4da;*/
/*}*/

/*.select2-container .select2-selection__rendered {*/
/*    line-height: 38px !important;*/
/*    padding-left: 12px !important;*/
/*}*/

/*.select2-container .select2-selection__arrow {*/
/*    height: 38px !important;*/
/*}*/

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
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 55px !important">
                        <!-- Layout Demo -->
                        <?php //echo "DB NAME : ".$_ENV['DB_NAME'];
                        ?>
                        <?php include('templates/invoice/invoice_body.php'); ?>
                        
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


<!-- Modal -->
 

 <!--Off Canvas for Diplsy The Quotation List -->
  <?php include('templates/invoice/invoice_list_modal.php'); ?>

<!--// Modal For Alart -->
<!-- Modal -->

<?php include('templates/invoice/contract_ledger_modal.php'); ?>
<?php include('templates/invoice/contract_ledger_supporting_modals.php'); ?>

<?php include('templates/invoice/customer_ledgr_modal.php'); ?>



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

    <!--<script src="../assets/js/forms-editors.js"></script>-->
<script>
     $(document).ready(function() {
         
         $('#company_id').on('change', function() {
            var selected = $(this).find('option:selected');
            $('#company_code').val(selected.data('code') || '');
            $('#company_name').val(selected.data('name') || '');
            $('#itemTable tbody tr').each(function() {
                initserviceload($(this).find('.service'), $(this).find('.service').val());
            });
         });

         if ($('#company_id').val()) {
             $('#company_id').trigger('change');
         }

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
   //customer filter
$('#filterOffcanvas').on('shown.bs.offcanvas', function () {
    $('#selectCustomerFromSelect2_filter').select2({
        dropdownParent: $('#invoiceCanvas')
    });
});
$('#selectCustomerFromSelect2_filter').select2({
     dropdownParent: $('#invoiceCanvas'),
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
         
         
          $('#quotation_id').val('');
          $('#original_draft').val('');
          $('#quotation_number').val('');
        
            let today = new Date().toISOString().split('T')[0];
            $('#invoice_date').val(today);
            $('#invoice_due_date').val(today);
         
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

function initserviceload(element,selectedId = null) {
    let customerCode = $.trim($('#customer_code').val()) || 0;
    let companyId = $('#company_id').val() || '';
    $.ajax({
        url: "/getAgreementOptions",
        data: {
            customer_code: customerCode,
            company_id: companyId
        },
        method: "GET",
        dataType: "json", // ensures it parses JSON
        success: function(data) {
            console.log("Service data:", data); // for debugging

            element.empty(); 
            element.append('<option value="0">Select Agreement No.</option>'); // placeholder

            data.forEach(function(item) {
                element.append(`
                    <option 
                        value="${item.id}" 
                        data-vehicle="${item.vehicle_id}" 
                        data-vehicleno="${item.vehicle_no}" 
                        data-fromperiod="${item.period_from}" 
                        data-toperiod="${item.period_to}"  
                        data-booking_ids="${item.booking_ids}"  
                        data-customer_code="${item.customer_code}"  
                        data-vehicle_model_id="${item.vehicle_model_id}"
                        data-model_name="${item.model_name}">
                        ${item.value}
                    </option>
                `);
              
            });
            
            if (selectedId) {
                element.val(String(selectedId)).trigger('change');
            }
           
        },
        error: function(xhr, status, error) {
            console.error("Failed to load services:", error);
        }
    });

    // Remove previous handlers and add change handler
    element.off('change').on('change', function() {
        let selected = $(this).find('option:selected');
        let row = $(this).closest('tr');
        // Use parseFloat to ensure VAT is numeric
        row.find('.from_datetime').val(selected.data('fromperiod') ||'');
        row.find('.to_datetime').val(selected.data('toperiod') || '');
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
            //   const fullEditor = new Quill('#full-editor', {
            //     bounds: '#full-editor',
            //     placeholder: 'Terms & Condition',
            //     modules: {
            //       syntax: true,
            //       toolbar: fullToolbar
            //     },
            //     theme: 'snow'
            //   });
            //   const fullEditorOnBody = new Quill('#full-editor-onbody', {
            //     bounds: '#full-editor-onbody',
            //     placeholder: 'Terms & Condition',
            //     modules: {
            //       syntax: true,
            //       toolbar: fullToolbar
            //     },
            //     theme: 'snow'
            //   });
            //   const fullEditorIndroduction = new Quill('#full-editor-introduction', {
            //     bounds: '#full-editor-introduction',
            //     placeholder: 'Introduction',
            //     modules: {
            //       syntax: true,
            //       toolbar: fullToolbar
            //     },
            //     theme: 'snow'
            //   });
      
      let qPressed = false;
        function addRow() {
          
            let row = `
            <tr>
                <td class="slno"></td>
               <td>
                    <div class="d-flex align-items-center">
                        <select class="service form-control form-control-sm watch-field">
                        </select>
                
                        <a href="javascript:void(0)"
                           class="ml-1 text-danger viewContractLedgerBtn"
                           title="View Contract Ledger">
                            <i class="ri ri-book-2-line" style="font-size:20px;"></i>
                        </a>
                    </div>
                </td>
                <td>
                    <input type="text" class="ledger_item form-control form-control-sm watch-field" style="text-align: left;">
                  
              
                </td>
                
                <td>
                    <input type="date" class="from_datetime form-control form-control-sm datetime_col " >
                </td>
        
                <td>
                    <input type="date" class="to_datetime form-control form-control-sm datetime_col" >
                </td>
               
                <td><input type="number" class="qty nav form-control form-control-sm" step="any" value="1"></td>
                <td>
                    <div style="position:relative; display:inline-block; width:100%;">
                        
                        <!-- ✅ Badge TOP-LEFT -->
                        <span class="min-price-text badge bg-danger"
                              style="position:absolute; top:-8px; left:6px; font-size:10px; z-index:2; padding:2px 6px;">
                            0.000
                        </span>
                
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
                initserviceload(lastRow.find('.service'));
                
                renumberRows();
            $('#itemTable tbody tr:last .service').focus();
        }
 
$(document).on('change', '.service', function () {

    let serviceId = $(this).val();
   
    let lastRow = $('#itemTable tbody tr:last');

   // initLedgerAutocomplete(lastRow.find('.ledger_item'),serviceId);


});
$(document).on('blur','.price, .vat .qty', line_item_calculation);
$(document).on('keyup change', '.price', line_item_calculation);
$(document).on('keyup change', '.vat', line_item_calculation);
$(document).on('keyup change', '.qty', line_item_calculation);
// $(document).on('input change', '.watch-field', function () {
//   recalculate($(this));
     
// });


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
// function recalculate($el)
// {
//     let row = $el.closest('tr');
//     let service = row.find('.service').val();
//     let service_text = $.trim(row.find('.service option:selected').text());
//     let rateType = row.find('.rate_type').val();
//     let modelId = row.find('.vehicle_category_id').val();
//     if( modelId && modelId !== 'All' && service && service!='0' && rateType && rateType!='0')
//     {
//          $.ajax({
//         url: '/VehicleStatusController',
//         type: 'POST',
//         data: {
//             modelId: modelId,
//             action: 'get_model_price_details'
//         },
//         success: function (response) {
//             let search_keyword=rateType+" " +service_text;
//           console.log(search_keyword);
//             let unit_amt = getAmount(response, search_keyword);
//           row.find('.min-price-text').text(unit_amt.toFixed(3));

//                 // ✅ store hidden
//                 row.find('.minprice').val(unit_amt);
//                 // ✅ optional: store in price input for validation
//                 row.find('.price').data('min', unit_amt);
//                 let price_min = parseFloat(row.find('.price').data('min')) || 0;
//                 let price = parseFloat(row.find('.price').val()) || 0;
//                 if(price!=0 && price<price_min)
//                 {
//                     row.find('.price').val(0);
//                     setupDropdown(
//                             'dropdownContent',
//                             'warning',
//                             svgSuccess + ' Price is below minimum. Please increase the unit price.',
//                             'click'
//                         );
//                         return;
//                 }
//         },
//         error: function () {
//             alert('Server error occurred');
//         }
//     });
        
//     }
   
    
// }

function validatePrice($el)
{
  let row = $el.closest('tr');
  
     let price_min = parseFloat(row.find('.price').data('min')) || 0;
     let price = parseFloat(row.find('.price').val()) || 0;
        if(price!=0 && price<price_min)
        {
            row.find('.price').val(0);
            setupDropdown(
                    'dropdownContent',
                    'warning',
                    svgSuccess + ' Price is below minimum. Please increase the unit price.',
                    'click'
                );
                return;
        }
}

$(document).on('blur', '.price', function () {
    //validatePrice($(this));
});

function line_item_calculation()
{
   
    let row = $(this).closest('tr');
    let from = new Date(row.find('.from_datetime').val());
    let to = new Date(row.find('.to_datetime').val());
   // let rateType = row.find('.rate_type').val();

    //if(from && to && to >= from){

        // let diffMs = to - from;
        // let duration_count = 0;

        // if(rateType == 'hour'){
        //     duration_count = Math.ceil(diffMs / (1000*60*60)); // hours
        // }
        // else if(rateType == 'day'){
        //     duration_count = Math.ceil(diffMs / (1000*60*60*24)); // days
        // }
        // else if (rateType == 'week') {
        // duration_count = Math.ceil(diffMs / (1000 * 60 * 60 * 24 * 7)); // weeks
        // }
        // else if(rateType == 'month'){
        //     duration_count = Math.ceil(diffMs / (1000*60*60*24*30)); // months
        // }

        // row.find('.duration').val(duration_count);

        
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
    let vat_total = 0;

 $('#itemTable tbody tr').each(function() {
        let qty = parseFloat($(this).find('.qty').val()) || 0;
        let price = parseFloat($(this).find('.price').val()) || 0;
        let vat = parseFloat($(this).find('.vat').val()) || 0;
       // let duration = parseFloat($(this).find('.duration').val()) || 0;
     
       // let line = qty * price * duration;
         let line = qty * price ;
        let vat_amt = line * vat / 100;
        let total = line + vat_amt;

        subtotal += line;
        vat_total += vat_amt;

       
    });
  
    let grand = subtotal + vat_total;
   
    
    let subtotals = parseFloat(subtotal);
    let vat_totals = parseFloat(vat_total);
    
    let allItemSubTotal = (subtotals + vat_totals).toFixed(DecimalPositions);
    
    $('#allItemSubtotal').text(allItemSubTotal);
    $('#subtotal').text(subtotal.toFixed(DecimalPositions));
    $('#vat_total').text(vat_total.toFixed(DecimalPositions));
    // $('#vat_total').text(vatAmount.toFixed(DecimalPositions));
    $('#grand_total').text(grand.toFixed(DecimalPositions));
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
    $('#quotation_attention').val(data.customer_attn);
    
    $('#itemTable tbody tr').each(function() {
        initserviceload($(this).find('.service'), $(this).find('.service').val());
    });
});


$('#selectCustomerFromSelect2').on('select2:clear', function () {
    $('#customer_name').val('');
    $('#customer_code').val('');
    $('#customer_phone').val('');
    $('#customer_email').val('');
    $('#customer_cpr_cr').val('');
    $('#customer_address').val('');
    $('#quotation_attention').val('');
    
}); 


$('#selAgreement').on('select2:select', function (e) {
    let data = e.params.data;
    let contract_ids=data.id;
    let agreement_no=data.text;
 
    loadAgreementDetails(contract_ids);
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
        //  $('#from_date_filter').val('');
        //  $('#to_date_filter').val('');
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
    loadInvoiceList(draft,startDate,endDate,customer_code,company_id);

});


function openInvoiceCanvas(draft, startDate = '', endDate = '', customer_code='') {
    let title = (draft === "Yes") ? "Draft Invoices" : "Invoices";
    $('#canvasTitle').text(title);
    $('#txt_qtn_draft').val(draft);

    // Initialize DataTable if not already
    if (!$.fn.DataTable.isDataTable('#invoiceList')) {
        invoiceTable = $('#invoiceList').DataTable({
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
    let canvas = new bootstrap.Offcanvas('#invoiceCanvas');
    canvas.show();

    // Load initial data
    loadInvoiceList(draft,$('#from_date_filter').val(),$('#to_date_filter').val(),$('#customer_code_filter').val(), $('#company_id_filter').val());
}

function loadInvoiceList(draft, startDate = '', endDate = '', customer_code='', company_id = 'all') {
    $.post('/InvoiceController', 
    { 
        draft: draft,
        startDate: startDate,
        endDate: endDate,
        customer_code: customer_code,
        company_id: company_id,
        action: 'GetInvoices'
    }, 
    function(response) {

        let res = typeof response === "string" ? JSON.parse(response) : response;

        // Clear old data and add new rows
        invoiceTable.clear();
        invoiceTable.rows.add(res.data);
        invoiceTable.draw();
    });
}


$(document).on('click', '.viewInvoice', function() {
    let id = $(this).data('id');
 $.post('/InvoiceController', 
{ 
    action: 'GetInvoicesDetails',
    invoice_id: id
}, 
function(response) {

    let res = typeof response === "string" ? JSON.parse(response) : response;

    if (!res.data || res.data.length === 0) {
        alert("No data found");
        return;
    }

    let q = res.data[0]; // ✅ FIX: get first record

    // store quotation id
    $('#invoice_id').val(q.id);
    $('#original_draft').val(q.draft);
    $('#invoice_number').val(q.invoice_no);
    $('#company_id').val(q.company_id).trigger('change');

    $('#invoiceNumber').text(q.invoice_no);
    $('#invoice_date').val(q.invoice_date);
    $('#invoice_due_date').val(q.invoice_due_date);
    
    let option = new Option(q.customer_name, q.customer_name, true, true);
    $('#selectCustomerFromSelect2').append(option).trigger('change');

    $('input[name=customer_code]').val(q.customer_code);
    $('input[name=customer_phone]').val(q.customer_phone);
    $('input[name=customer_email]').val(q.customer_email);
    $('input[name=customer_cpr_cr]').val(q.customer_cpr_cr);
    
    $('textarea[name=customer_address]').val(q.customer_address);
    $('input[name=total_discount]').val(q.total_discount);
    
    $('input[name=invoice_attention]').val(q.attention);
    $('#transaction_no').val(q.lpo_number);
    $('#lpo_no').val(q.trn_no);
    $('#qtn_ref_no').val(q.quotation_ref_no);
    
    $('#itemTable tbody').empty();

  
    let items = typeof q.items === "string" ? JSON.parse(q.items) : q.items;
  
    items.forEach(function(item) {
        addRow();
        let row = $('#itemTable tbody tr:last');
       
        // row.find('.vehicle_category_id').val(item.item_model_id);
        // row.find('.vehicle_modal_pic').val(item.item_model_pic);
        initserviceload(row.find('.service'), item.contract_id);
         row.find('.service').val(item.contract_id).trigger('change');
       initLedgerAutocomplete(row.find('.ledger_item'),item.contract_id);
       
        row.find('.ledger_item').val(item.item_name);
        row.find('.from_datetime').val(item.period_from).trigger('change');
        row.find('.to_datetime').val(item.period_to).trigger('change');
        row.find('.qty').val(item.qty);
        row.find('.price').val(item.price);
      
        row.find('.vat').val(item.vat);
        row.find('.line_total').text(item.total);
    });

    renumberRows();
    calculateTotals();

    // close offcanvas
       
    let canvas = bootstrap.Offcanvas.getInstance(
        document.getElementById('invoiceCanvas')
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
        
            
             SaNDSAlert('Are you Sure you want to delete the Item..!','DeleteData','danger','#C70039','Yes I am Sure');
            
            
            
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

$('#invocieForm').submit(function(e){
    e.preventDefault();
    if (!validateInvoiceForm()) {
        return;
    }
    let invoiceId = $('#invoice_id').val();
    let originalDraft = $('#original_draft').val();

    if(invoiceId){ 
         saveInvoice('update');

    } else {
        saveInvoice('new');
    }
});

function saveInvoice(action_type){
   
    var laddaBtn = Ladda.create(document.querySelector('#btn_save_invoice'));
    
        laddaBtn.start();
       
    let items = [];
    $('#itemTable tbody tr').each(function() {
       
        items.push({
            contract_id: $(this).find('.service').val(),
            agreement_no: $(this).find('.service option:selected').text(),
            vehicle_id: $(this).find('.service option:selected').data('vehicle'),
            vehicle_no: $(this).find('.service option:selected').data('vehicle_no'),
            booking_ids: $(this).find('.service option:selected').data('booking_ids'),
            vehicle_model_id: $(this).find('.service option:selected').data('vehicle_model_id'),
            model_name: $(this).find('.service option:selected').data('model_name'),
            vehicleno: $(this).find('.service option:selected').data('vehicleno'),
            item_name: $(this).find('.ledger_item ').val(),
            period_from: $(this).find('.from_datetime').val(),
            period_to: $(this).find('.to_datetime').val(),
            qty: $(this).find('.qty').val(),
            price: $(this).find('.price').val(),
            vat: $(this).find('.vat').val(),
            total: $(this).find('.line_total').text()
        });
    });

    

    let data = {
        invoice_id: $('#invoice_id').val(),
        invoice_number:$('#invoice_number').val(),
        original_draft: $('#original_draft').val(),
        action_type: action_type,
        save_type: saveType,
        company_id: $('#company_id').val(),
        company_code: $('#company_code').val(),
        company_name: $('#company_name').val(),
        customer_name: $('#selectCustomerFromSelect2').find(':selected').text(),
        customer_code: $('input[name=customer_code]').val(),
        customer_phone: $('input[name=customer_phone]').val(),
        customer_email: $('input[name=customer_email]').val(),
        customer_cpr_cr: $('input[name=customer_cpr_cr]').val(),
        customer_address: $('textarea[name=customer_address]').val(),
        invoice_date: $('#invoice_date').val(),
        invoice_due_date: $('#invoice_due_date').val(),
        items: items,
        subtotal: $('#subtotal').text(),
        vat_total: $('#vat_total').text(),
        grand_total: $('#grand_total').text(),
        reference_number : 0,
        total_discount : 0,
        total_discount_amount : 0,
        after_discount_amount : 0,
        allItemSubtotal : $('#allItemSubtotal').text(),
        attentionValue : $('#invoice_attention').val(),
        invocie_number : $('#invocie_number').val(),
        transaction_no : $('#transaction_no').val(),
        lpo_no : $('#lpo_no').val(),
        qtn_ref_no : $('#qtn_ref_no').val(),
        action : 'SaveInvocie'
    };
     $.post('/InvoiceController', data)
        .done(function(res) {
            try {
                var jsonData = (typeof res === 'string') ? JSON.parse(res) : res;

                if (jsonData.status && jsonData.status.toLowerCase() === "success") {
                    setupDropdown('dropdownContent', 'success', svgSuccess + jsonData.message+" : " + jsonData.msg_text, 'click');
                    setTimeout(function() {
                      location.reload();
                    }, 3000);
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
            // Stop loading buttons no matter what
            laddaBtn.stop();
         
        });
}
    
   

function validateInvoiceForm() {
    let valid = true;
    let message = "";

    
    if (!$('#selectCustomerFromSelect2').val()) {
        message = "Customer name is required.";
        valid = false;
    }

    if (!$('#invoice_date').val()) {
        message = "Invoice date is required.";
        valid = false;
    }
     if (!$('#invoice_due_date').val()) {
        message = "Invoice due date is required.";
        valid = false;
    }
    // Item rows validation
    let rowCount = $('#itemTable tbody tr').length;
    if (rowCount === 0) {
        message = "Please add atleast one row item.";
        valid = false;
    }

    $('#itemTable tbody tr').each(function(index) {
        let id = $(this).find('.service').val();

        let item = $(this).find('.ledger_item ').val();
        let qty = $(this).find('.qty').val();
        let price = $(this).find('.price').val();
       // let duration = $(this).find('.duration').val();
        let vat = $(this).find('.vat').val();

        if (!id || id == 0 || !item || !qty || !price  || !vat) {
            message = "Please fill the details in item row " + (index + 1);
            valid = false;
            return false; // break loop
        }
    });

    if (!valid) {
        setupDropdown('dropdownContent','error',svgSuccess+message,'click');
       
    }

    return valid;
}
  
$('#printQT').click(function() {
    let invoiceId = $('#invoice_id').val();// get the quotation id from data-id attribute
    printInvoice(invoiceId);           // call your function
});  


$(document).on('click', '.invoiceprint', function () {    

    let id = $(this).data('id');
    let ref = $(this).data('ref');
    fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(ref)))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/InvoicePrint?token=' + encodeURIComponent(token), '_blank');
        });
   // window.open(`/InvoicePrint?invoice_no=${ref}`, '_blank');

});
$('#openPrintSettings').click(function () {

    let id = $('#invoice_id').val();
    let ref = $('#invoice_number').val();

    window.open(`pdf/configure_quotation.php?id=${id}&ref_no=${ref}`, '_blank');
});
$('#btnStandard').on('click', function () {
    let form = $('#configForm');

    // Set action dynamically
    form.attr('action', '/QuotationPrintV1');

    // Submit form
    form.submit();
});

$('#btnV2').on('click', function () {
    let form = $('#configForm');

    // Set action dynamically
   form.attr('action', '/QuotationPrintV2');

    // Submit form
    form.submit();
});
// print button inside modal PrintQuotation
let fileName = '';
$('#printLogo').on('change', function () {
    fileName = this.files[0].name;
    console.log(fileName);
});
  




    $('#openInvoice, #MenuListOfInvoices').click(function () {
        //   $('#from_date_filter').val('');
        //   $('#to_date_filter').val('');
           openInvoiceCanvas('No');
            
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
    const row = $(this).closest('tr');


let selected = row.find('.service option:selected');
let id = row.find('.service').val();
let agreement_no = row.find('.service option:selected').text();
let vehicleid = selected.data('vehicle');
let fromDate = selected.data('fromperiod');
let toDate = selected.data('toperiod');
let booking_ids = selected.data('booking_ids');
let customer_code = selected.data('customer_code');
let model_ids = selected.data('vehicle_model_id');
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
                                <button type="button" class="btn btn-icon-square  btn-icon text-primary btn-edit" data-id="${id}" title="Edit"><span class="ri ri-edit-line ri-xl"></span></button>
                                <button type="button" class="btn btn-icon-square  btn-icon text-danger btn-delete" data-id="${id}" title="Delete"><span class="ri ri-delete-bin-line ri-xl"></span></button>`;
                            
                            if (row.payment_method === 'Cheque') {
                                if (row.cheque_status === 'Pending') {
                                    btns += `
                                        <button class="btn btn-icon-square  btn-icon text-success btn-status-main" data-id="${id}" data-status="Collected" title="Collect Cheque"><span class="ri ri-check-line ri-xl"></span></button>
                                        <button class="btn btn-icon-square  btn-icon text-warning btn-status-main" data-id="${id}" data-status="Bounced" title="Bounce Cheque"><span class="ri ri-close-line ri-xl"></span></button>
                                    `;
                                } else {
                                    btns += `<button class="btn btn-icon-square  btn-icon text-secondary btn-status-main" data-id="${id}" data-status="Pending" title="Revoke Status"><span class="ri ri-refresh-line ri-xl"></span></button>`;
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
function populatecustomerLedgerModal(d) {

    let data = (typeof d === "string") ? JSON.parse(d) : d;
 
        $('#customer_ledger_customer_name').text(data.customer.customer_name || '');
        $('#customer_display_customer_name').text(data.customer.customer_name +' | '+data.customer.customer_id || '');
        $('#txt_customer_ledger_modal_customer_code').val(data.customer.customer_id || '');
        $('#customer_display_mobile').text(data.customer.customer_mobile || '');
        $('#customer_display_cprcr').text(data.customer.customer_cr_cpr || '');
        $('#customer_display_email').text(data.customer.customer_email || '');
        
      //  loadHeads();
        refreshCustomerLedger(data.customer.customer_id);
        
       
   
}

function refreshCustomerLedger(code) {
            if ($.fn.DataTable.isDataTable('#tblCustomerLedger')) {
                $('#tblCustomerLedger').DataTable().destroy();
            }

            CustomerledgerTable = $('#tblCustomerLedger').DataTable({
                ajax: {
                    url: '/CustomerLedgerController',
                    data: { action: 'GetLedgerData', customer_code: code },
                    dataSrc: function(json) {
                        let totDebit = 0, totCredit = 0;
                        json.data.forEach(r => {
                            totDebit += parseFloat(r.debit);
                            totCredit += parseFloat(r.credit);
                        });
                        $('#customer_lblTotalDebit').text(totDebit.toFixed(3));
                        $('#customer_lblTotalCredit').text(totCredit.toFixed(3));
                        $('#customer_lblBalance').text((totDebit - totCredit).toFixed(3));
                        return json.data;
                    }
                },
                columns: [
                    { 
                        data: 'trans_date',
                        render: v => moment(v).format('DD-MM-YYYY')
                    },
                     { 
                        data: 'agreement_no',
                        
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
                    }
                ],
                createdRow: function(row, data) {
                    if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                    else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
                },
                order: [[0, 'asc'], [6, 'asc']], // Sort by date then by id
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                pageLength: 25
            });
        }


});// CLose of Jquery


    </script>
</body>

</html>