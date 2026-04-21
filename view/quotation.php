<?php

// if (!isset($_SESSION['LOGIN_STATUS'])) {
//     header("Location: /Login");
//     exit();
// }
?>

<?php
include ROOT_PATH . '/view/envinclude.php';
$decimals = $_ENV['DECIMALS'];
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


   

   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/spinkit/spinkit.css" />
    
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/editor.css" />
    
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>alertmessage/css/sands_alert_style.css">
    
        <!-- Ladda CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" />
    
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/highlight/highlight.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/editor.css" />
    
     <!-- Helpers -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/config.js"></script>

    
    
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
        .col-service { width: 170px; }
        .col-unit { width: 110px; }
        .col-from { width: 180px; }
        .col-to { width: 180px; }
        .col-qty { width: 80px; }
        .col-price { width: 90px; }
        .col-duration { width: 80px; }
        .col-vat { width: 70px; }
        .col-total { width: 100px; }
        .col-action { width: 60px; }
        
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
.vehicle_category {
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
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 55px !important">
                        <!-- Layout Demo -->
                        <?php //echo "DB NAME : ".$_ENV['DB_NAME'];
                        ?>
                        <?php include ROOT_PATH . '/view/templates/quotation/quotation_body.php'; ?>
                        
                        <!--/ Layout Demo -->
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
    
    
<!-- SaNDS Popup -->
    <div id="dropdownContent" style="text-align:center;"></div>    
 <!--Modal Starts Here -->
<!-- Button trigger modal -->


<!-- Modal -->
 <?php include ROOT_PATH . '/view/templates/quotation/quotation_help_modal.php'; ?>

 <!--Off Canvas for Diplsy The Quotation List -->
  <?php include ROOT_PATH . '/view/templates/quotation/quotation_list_modal.php'; ?>

<!--// Modal For Alart -->
<!-- Modal -->

<?php include ROOT_PATH . '/view/templates/quotation/quotation_introduction_modal.php'; ?>
<?php include ROOT_PATH . '/view/templates/quotation/add_new_customer_modal.php'; ?>
 <?php include ROOT_PATH . '/view/templates/quotation/quotation_save_choice_modal.php'; ?>


<!--Print Settings Modal-->
<?php include ROOT_PATH . '/view/templates/quotation/quotation_print_settings_modal.php'; ?>


<!--Terms and Condition Modal-->
<?php include ROOT_PATH . '/view/templates/quotation/quotation_terms_condition_modal.php'; ?>

<!--search Items -->
<?php include ROOT_PATH . '/view/templates/quotation/quotation_item_search_modal.php'; ?>


    <?php include ROOT_PATH . '/view/templates/scripts.php'); ?>
<!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-selects.js"></script>
    
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>
        <!-- Ladda & Spin.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
    
    
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/katex.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/highlight/highlight.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/quill/quill.js"></script>
   
       <!-- Page JS -->
    <script src="<?= $_ENV['BASE_URL'] ?>assets/js/ui-popover.js"></script>

    <!--<script src="<?= $_ENV['BASE_URL'] ?>assets/js/forms-editors.js"></script>-->
<script>
     $(document).ready(function() {
          $('#quotation_id').val('');
          $('#original_draft').val('');
          $('#quotation_number').val('');
        
            let today = new Date().toISOString().split('T')[0];
            $('#quotation_date').val(today);    
         
      let DecimalPositions = <?php echo $decimals;?>;   
        let saved = localStorage.getItem('printSettings');
        if (saved) {
            let settings = JSON.parse(saved);
    
            if (settings.decimals) {
                DecimalPositions = settings.decimals;
            }
        }
        
   
    
  function initCategoryAutocomplete(element){

    element.autocomplete({
        source: "/getVehicleDetails",
        minLength: 1,

        select: function(event, ui){

            let row = $(this).closest('tr');

            row.find('.vehicle_category').val(ui.item.value);
            row.find('.vehicle_category_id').val(ui.item.id);
            row.find('.vehicle_modal_pic').val(ui.item.vehicle_modal_pic);
            

            return false;
        }
    });

}

function initserviceload(element,selectedId = null) {
    $.ajax({
        url: "/getRentalOptions",
        method: "GET",
        dataType: "json", // ensures it parses JSON
        success: function(data) {
            console.log("Service data:", data); // for debugging

            element.empty(); 
            element.append('<option value="0">Select Service</option>'); // placeholder

            data.forEach(function(item) {
                element.append(`<option 
                                    value="${item.id}" 
                                    data-vat="${parseFloat(item.vat)}">
                                    ${item.value}
                                </option>`);
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
        row.find('.vat').val(selected.data('vat') || 0);
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
              const fullEditorIndroduction = new Quill('#full-editor-introduction', {
                bounds: '#full-editor-introduction',
                placeholder: 'Introduction',
                modules: {
                  syntax: true,
                  toolbar: fullToolbar
                },
                theme: 'snow'
              });
      
      let qPressed = false;
        function addRow() {
          
            let row = `
            <tr>
                <td class="slno"></td>
                <td>
                    <input type="text" class="vehicle_category form-control form-control-sm watch-field" style="text-align: left;">
                    <input type="hidden" class="vehicle_category_id">
                    <input type="hidden" class="vehicle_modal_pic">
                     <input type="hidden" class="minprice">
              
                </td>
                <td>
                    <select class="service form-control form-control-sm watch-field">
                    </select>
                </td>
                 <td>
                    <select class="rate_type form-control form-control-sm watch-field">
                        <option value="0">Select</option>
                        <option value="hour">Hourly</option>
                         <option value="week">Weekly</option>
                        <option value="day">Daily</option>
                        <option value="month">Monthly</option>
                    </select>
                </td>
                <td>
                    <input type="datetime-local" class="from_datetime form-control form-control-sm datetime_col " >
                </td>
        
                <td>
                    <input type="datetime-local" class="to_datetime form-control form-control-sm datetime_col" >
                </td>
                <td><input type="number" class="duration nav form-control form-control-sm" step="any" value="0"></td>
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
                <td><input type="number" class="vat nav form-control form-control-sm" step="0.1" value="<?echo $_ENV['TAX_PERCENTAGE']?>"></td>
                <td class="line_total">0.00</td>
                <td>
                    <span class="icon-base ri ri-delete-bin-6-line icon-22px remove"></span>
                </td>
            </tr>`;
            
            $('#itemTable tbody').append(row);
             let lastRow = $('#itemTable tbody tr:last');

                initCategoryAutocomplete(lastRow.find('.vehicle_category'));
                initserviceload(lastRow.find('.service'));
                
                renumberRows();
            $('#itemTable tbody tr:last .vehicle_category').focus();
        }
 

$(document).on('blur','.from_datetime, .to_datetime, .rate_type, .price, .vat .qty', line_item_calculation);
$(document).on('keyup change', '.rate_type, .price, .vat .qty', line_item_calculation);
$(document).on('input change', '.watch-field', function () {
  recalculate($(this));
     
});


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
function recalculate($el)
{
    let row = $el.closest('tr');
    let service = row.find('.service').val();
    let service_text = $.trim(row.find('.service option:selected').text());
    let rateType = row.find('.rate_type').val();
    let modelId = row.find('.vehicle_category_id').val();
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
          console.log(search_keyword);
            let unit_amt = getAmount(response, search_keyword);
           row.find('.min-price-text').text(unit_amt.toFixed(3));

                // ✅ store hidden
                row.find('.minprice').val(unit_amt);
                // ✅ optional: store in price input for validation
                row.find('.price').data('min', unit_amt);
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
        },
        error: function () {
            alert('Server error occurred');
        }
    });
        
    }
   
    
}

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
    validatePrice($(this));
});

function line_item_calculation()
{
   
    let row = $(this).closest('tr');
    let from = new Date(row.find('.from_datetime').val());
    let to = new Date(row.find('.to_datetime').val());
    let rateType = row.find('.rate_type').val();

    if(from && to && to >= from){

        let diffMs = to - from;
        let duration_count = 0;

        if(rateType == 'hour'){
            duration_count = Math.ceil(diffMs / (1000*60*60)); // hours
        }
        else if(rateType == 'day'){
            duration_count = Math.ceil(diffMs / (1000*60*60*24)); // days
        }
        else if (rateType == 'week') {
        duration_count = Math.ceil(diffMs / (1000 * 60 * 60 * 24 * 7)); // weeks
        }
        else if(rateType == 'month'){
            duration_count = Math.ceil(diffMs / (1000*60*60*24*30)); // months
        }

        row.find('.duration').val(duration_count);

        
        let price = parseFloat(row.find('.price').val()) || 0;
          
       
        let qty = parseFloat(row.find('.qty').val()) || 0;
        let vat = parseFloat(row.find('.vat').val()) || 0;

        let total = (price * qty * duration_count) * (1 + vat/100);
        row.find('.line_total').text(total.toFixed(DecimalPositions));
        calculateTotals();

    }
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
        let duration = parseFloat($(this).find('.duration').val()) || 0;
     
        let line = qty * price * duration;
        let vat_amt = line * vat / 100;
        let total = line + vat_amt;

        subtotal += line;
        vat_total += vat_amt;

        //$(this).find('.line_total').text(total.toFixed(DecimalPositions));
    });
    
    // let total_discount = (subtotal*$('#total_discount').val()/100);
    // $('#total_discount_amount').text(total_discount.toFixed(DecimalPositions));
    // let after_discount = subtotal - (subtotal*$('#total_discount').val()/100);
    // $('#after_discount_amount').text(after_discount.toFixed(DecimalPositions));
    // let vatAmount = after_discount * 10/100;
    let grand = subtotal + vat_total;
    //let grand = after_discount + vatAmount;
    
    
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

 $('#saveintroduction').click(function () {
    var laddaBtn = Ladda.create(document.querySelector('#saveintroduction'));
    laddaBtn.start();
    let htmlContentIndroduction = fullEditorIndroduction.root.innerHTML;

    $.ajax({
        url: "/QuotationController",
        type: "POST",
        data: { action: 'SaveIntroduction',intrn_content: htmlContentIndroduction, intrn_title: $('#int_name').val() },
        success: function (response) { 
            setupDropdown('dropdownContent','success',svgSuccess+ ' Introduction Saved Successfully','click');
            laddaBtn.stop();
            $('#introTable').DataTable().ajax.reload(null, false);
           
        },
        error: function () {
            setupDropdown('dropdownContent','danger',svgSuccess+ ' Error saving data','click');
            laddaBtn.stop();
        }
    });

});                   

$('#btn_open_intn_modal').click(function(){
    $('#introTable').DataTable().ajax.reload(null, false);
  
    fullEditorIndroduction.root.innerHTML ='';
     $('#int_name').val('');
    $('#QtnIntroductionModal').modal('show');
})

    $('#introTable').DataTable({
        "ajax": {
            "url": "/QuotationController",
            "type": "POST",
            "data": {
                "action": "LoadIntroduction"
            }
        },  
        "processing": true,
        "serverSide": false,
        "columns": [
            { 
                "data": null, 
                "render": function (data, type, row, meta) {
                    return meta.row + 1; 
                },
                "orderable": false
            },
            { "data": "intrn_title" },
            { 
                "data": "intrn_content",
                "className": "description", // add the class for CSS
            },
           // { "data": "intrn_content" },
            { 
                "data": null,
                "render": function(data, type, row){
                    return `<i class="ri ri-delete-bin-line text-danger deleteRowIntroduction" 
                             style="cursor:pointer; font-size: 1.5rem;" 
                             data-id="${row.ids}" 
                             title="Delete this entry"></i>`;
                },
                "orderable": false
            },
            {
                "data": null,
                "render": function(data, type, row){
                    return `<i class="ri ri-eye-line text-primary showRowIntroduction" 
                             style="cursor:pointer; font-size: 1.5rem;" 
                             data-id="${row.ids}" 
                             title="View this entry"></i>`;
                },
                "orderable": false
            }
        ]
    }); 

                     
let varDeleteInt;
$(document).on("click", ".deleteRowIntroduction", function() {

    varDeleteInt = $(this).data("id");
    SaNDSAlert('Are you sure you want to delete this entry?','DeleteIntroduction','danger','#C70039','Yes, I am sure');
    
});

function deleteIntroduction()
{
    $.ajax({
        url: "/QuotationController",
        type: "POST",
        data: { id: varDeleteInt,action:"deleteIntroduction" },
        success: function(res) {

            if (res.status === true) {
                setupDropdown('dropdownContent','success',svgSuccess+'Deleted successfully','click');
                $('#introTable').DataTable().ajax.reload(null, false);
               
            } else {
                setupDropdown('dropdownContent','error',svgError+res.message,'click');
            }
        }
    });
}

$(document).on("click", ".showRowIntroduction", function() {

    var showIntrnId = $(this).data("id");

    var laddaBtn = Ladda.create(this);
    laddaBtn.start();

    $.ajax({
        url: "/QuotationController",   
        type: "POST",
        data: { id: showIntrnId,action:"LoadIntroductionToEditor" }, 
        success: function (response) {

            fullEditorIndroduction.root.innerHTML = response.html;

            setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + ' Loaded Successfully',
                'click'
            );

            laddaBtn.stop();
        },
        error: function () {

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

$('#intcopyContentBtn').click(function () {
                
    var content = fullEditorIndroduction.root.innerHTML;
    
    $('#quoation_introduction').val(content);
    $('#QtnIntroductionModal').modal('hide');

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
    $('#customer_name').val(data.customer_name);
    $('#customer_phone').val(data.customer_mobile);
    $('#customer_email').val(data.customer_email);
    $('#customer_address').val(data.customer_address);
    $('#quotation_attention').val(data.customer_attn);
    
});


$('#selectCustomerFromSelect2').on('select2:clear', function () {
    $('#customer_name').val('');
    $('#customer_code').val('');
    $('#customer_phone').val('');
    $('#customer_email').val('');
    $('#customer_address').val('');
    $('#quotation_attention').val('');
}); 


 $('#termsTable').DataTable({
        "ajax": {
            "url": "/QuotationController",
            "type": "POST",
            "data": {
                "action": "LoadTermsCondition"
            }
        },  
        "processing": true,
        "serverSide": false,
        "columns": [
            { 
                "data": null, 
                "render": function (data, type, row, meta) {
                    return meta.row + 1; 
                },
                "orderable": false
            },
            { "data": "t_c_name" },
            { "data": "terms_condition",
            "className": "description"},
            { 
                "data": null,
                "render": function(data, type, row){
                    return `<i class="ri ri-delete-bin-line text-danger deleteRowTermsCondition" 
                             style="cursor:pointer; font-size: 1.5rem;" 
                             data-id="${row.ids}" 
                             title="Delete this entry"></i>`;
                },
                "orderable": false
            },
            {
                "data": null,
                "render": function(data, type, row){
                    return `<i class="ri ri-eye-line text-primary showRowTermsCondition" 
                             style="cursor:pointer; font-size: 1.5rem;" 
                             data-id="${row.ids}" 
                             title="View this entry"></i>`;
                },
                "orderable": false
            }
        ]
    }); 
$('#saveTermsAndConditions').click(function () {
    var laddaBtn = Ladda.create(document.querySelector('#saveintroduction'));
    laddaBtn.start();
    let htmlContentTC = fullEditor.root.innerHTML;

    $.ajax({
        url: "/QuotationController",
        type: "POST",
        data: { action: 'SaveTermsCondition',terms_condition: htmlContentTC, t_c_name: $('#t_c_name').val() },
        success: function (response) { 
            setupDropdown('dropdownContent','success',svgSuccess+ ' Terms & Condition Saved Successfully','click');
            laddaBtn.stop();
            $('#termsTable').DataTable().ajax.reload(null, false);
           
        },
        error: function () {
            setupDropdown('dropdownContent','danger',svgSuccess+ ' Error saving data','click');
            laddaBtn.stop();
        }
    });

});                   



$('#btn_terms_condition').click(function(){
    $('#termsTable').DataTable().ajax.reload(null, false);
  
    fullEditor.root.innerHTML ='';
    $('#t_c_name').val('');
    $('#termsAndConditionModal').modal('show');
})

                     
let varDeleteTC;
$(document).on("click", ".deleteRowTermsCondition", function() {

    varDeleteTC = $(this).data("id");
    SaNDSAlert('Are you sure you want to delete this entry?','DeleteTerms','danger','#C70039','Yes, I am sure');
    
});

function deleteTermsAndCondition()
{
    $.ajax({
        url: "/QuotationController",
        type: "POST",
        data: { id: varDeleteTC,action:"deleteTermsCondition" },
        success: function(res) {

            if (res.status === true) {
                setupDropdown('dropdownContent','success',svgSuccess+'Deleted successfully','click');
                $('#termsTable').DataTable().ajax.reload(null, false);
               
            } else {
                setupDropdown('dropdownContent','error',svgError+res.message,'click');
            }
        }
    });
}

$(document).on("click", ".showRowTermsCondition", function() {

    var showTCId = $(this).data("id");

    var laddaBtn = Ladda.create(this);
    laddaBtn.start();

    $.ajax({
        url: "/QuotationController",   
        type: "POST",
        data: { id: showTCId,action:"LoadTermsConditionToEditor" }, 
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
        error: function () {

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
        $('#quotationForm').submit();
        return;
    }

    // ALT + D → Draft Save
    if (e.altKey && e.key.toLowerCase() === 'd') {
        e.preventDefault();
        saveType = 'draft';
        $('#quotationForm').submit();
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
        $('#from_date_filter').val('');
        $('#to_date_filter').val('');
        openQuotationCanvas('No');
        qPressed = false;
        return;
    }
     // ALT + l → Draft List
    if (e.altKey && e.key.toLowerCase() === 'l') {
        e.preventDefault();
        $('#from_date_filter').val('');
        $('#to_date_filter').val('');
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
         $('#from_date_filter').val('');
         $('#to_date_filter').val('');
        openQuotationCanvas('No');
        qPressed = false;
        return;
    }

    // Q + 2 → Draft quotations
    if (qPressed && e.key === '2') {
        e.preventDefault();
        $('#from_date_filter').val('');
        $('#to_date_filter').val('');
        openQuotationCanvas('Yes');
        qPressed = false;
        return;
    }
 if (e.altKey && e.key.toLowerCase() === 'i') {
        e.preventDefault();
        $('#termsTable').DataTable().ajax.reload(null, false);
        fullEditor.root.innerHTML ='';
        $('#t_c_name').val('');
        $('#termsAndConditionModal').modal('show');
        return;
    }
    // Reset Q state if other key pressed
    qPressed = false;
});

$('#btn_filter').click(function () {
                
   var draft= $('#txt_qtn_draft').val();
   var startDate= $('#from_date_filter').val();
   var endDate= $('#to_date_filter').val();
   
    loadQuotationList(draft,startDate,endDate);

});


function openQuotationCanvas(draft, startDate = '', endDate = '') {
    let title = (draft === "Yes") ? "Draft Quotations" : "Quotations";
    $('#canvasTitle').text(title);
    $('#txt_qtn_draft').val(draft);

    // Initialize DataTable if not already
    if (!$.fn.DataTable.isDataTable('#quotationList')) {
        quotationTable = $('#quotationList').DataTable({
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
    let canvas = new bootstrap.Offcanvas('#quotationCanvas');
    canvas.show();

    // Load initial data
    loadQuotationList(draft,startDate,endDate);
}

function loadQuotationList(draft, startDate = '', endDate = '') {
    $.post('/QuotationController', 
    { 
        draft: draft,
        startDate: startDate,
        endDate: endDate,
        action: 'GetQuotations'
    }, 
    function(response) {

        let res = typeof response === "string" ? JSON.parse(response) : response;

        // Clear old data and add new rows
        quotationTable.clear();
        quotationTable.rows.add(res.data);
        quotationTable.draw();
    });
}


$(document).on('click', '.viewQuotation', function() {
    let id = $(this).data('id');
 $.post('/QuotationController', 
{ 
    action: 'GetQuotationsDetails',
    quotation_id: id
}, 
function(response) {

    let res = typeof response === "string" ? JSON.parse(response) : response;

    if (!res.data || res.data.length === 0) {
        alert("No data found");
        return;
    }

    let q = res.data[0]; // ✅ FIX: get first record

    // store quotation id
    $('#quotation_id').val(q.id);
    $('#original_draft').val(q.draft);
    $('#quotation_number').val(q.quotation_no);

    $('#quotationNumber').text(q.quotation_no);
    $('#quotation_date').val(q.quotation_date);
    
    let option = new Option(q.customer_name, q.customer_name, true, true);
    $('#selectCustomerFromSelect2').append(option).trigger('change');

    $('input[name=customer_code]').val(q.customer_code);
    $('input[name=customer_phone]').val(q.customer_phone);
    $('input[name=customer_email]').val(q.customer_email);
    $('textarea[name=customer_address]').val(q.customer_address);
    $('input[name=total_discount]').val(q.total_discount);
    $('input[name=quotation_prefix]').val(q.user_prefix);
    $('input[name=quotation_attention]').val(q.attention);
    $('textarea[name=quoation_introduction]').val(q.introduction);
    fullEditorOnBody.clipboard.dangerouslyPasteHTML(q.terms || '');
    $('#itemTable tbody').empty();

  
    let items = typeof q.items === "string" ? JSON.parse(q.items) : q.items;
  
    items.forEach(function(item) {
        addRow();
        let row = $('#itemTable tbody tr:last');
        row.find('.vehicle_category').val(item.item_name);
        row.find('.vehicle_category_id').val(item.item_model_id);
        row.find('.vehicle_modal_pic').val(item.item_model_pic);
        initserviceload(row.find('.service'), item.service_id);
        row.find('.service').val(item.service_id).trigger('change');
        row.find('.rate_type').val(item.rate_type_id).trigger('change');
        row.find('.from_datetime').val(item.period_from).trigger('change');
        row.find('.to_datetime').val(item.period_to).trigger('change');
        row.find('.qty').val(item.qty);
        row.find('.price').val(item.price);
        row.find('.duration').val(item.duration);
        row.find('.vat').val(item.vat);
        row.find('.line_total').text(item.total);
    });

    renumberRows();
    calculateTotals();

    // close offcanvas
       
    let canvas = bootstrap.Offcanvas.getInstance(
        document.getElementById('quotationCanvas')
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

$('#quotationForm').submit(function(e){
    e.preventDefault();
    if (!validateQuotationForm()) {
        return;
    }
    let quotationId = $('#quotation_id').val();
    let originalDraft = $('#original_draft').val();
    

    if(quotationId){ 
        
        if(saveType === 'final') {
            $('#saveChoiceModal').modal('show');
        } else if(saveType === 'draft') {
            $('#saveChoiceModalDraft').modal('show');
        }

        
         $('#createNewQuote').off('click').on('click', function(){
            $('#saveChoiceModal').modal('hide');
            saveQuotation('new');
        });
       
        
        $('#updateOriginal').off('click').on('click', function(){
            if(originalDraft === 'Yes')
            {
               setupDropdown('dropdownContent', 'error', svgError + "You can either convert this quotation to draft instead of saving. ", 'click');
                return false;
            }
            else
            {
                $('#saveChoiceModal').modal('hide');
                saveQuotation('update');
            }
            
        });

        // Handle Save as Draft
        $('#updateOriginaldraft').off('click').on('click', function(){
             if(originalDraft === 'No')
            {
               setupDropdown('dropdownContent', 'error', svgError + "You can either convert this draft to quotation instead of saving. ", 'click');
                return false;
            }
            else
            {
              
                $('#saveChoiceModalDraft').modal('hide');
                saveQuotation('update');
            }
            
        });

        $('#createNewdraft').off('click').on('click', function(){
            $('#saveChoiceModalDraft').modal('hide');
            saveQuotation('new');
        });
        
        

    } else {
        
        saveQuotation('new');
    }
});

function saveQuotation(action_type){
   
    var laddaBtn = Ladda.create(document.querySelector('#btn_save_quotation'));
    var laddaBtnDraft = Ladda.create(document.querySelector('#btn_save_quotation_draft'));
        laddaBtn.start();
        laddaBtnDraft.start();
    let items = [];
    $('#itemTable tbody tr').each(function() {
        items.push({
            item_name: $(this).find('.vehicle_category').val(),
            item_model_id: $(this).find('.vehicle_category_id').val(),
            item_model_pic: $(this).find('.vehicle_modal_pic').val(),
            service_id: $(this).find('.service').val(),
            service_name: $(this).find('.service option:selected').text(),
            rate_type_id: $(this).find('.rate_type ').val(),
            rate_type_name: $(this).find('.rate_type option:selected').text(),
            period_from: $(this).find('.from_datetime').val(),
            period_to: $(this).find('.to_datetime').val(),
            qty: $(this).find('.qty').val(),
            price: $(this).find('.price').val(),
            duration: $(this).find('.duration').val(),
            vat: $(this).find('.vat').val(),
            total: $(this).find('.line_total').text()
        });
    });

                    // var loginData = JSON.parse(localStorage.getItem("quotationLoginData"));
                   
                    //     let storageloginStatus = loginData.status;
                    //     let storagecompany_id = loginData.company_id;
                    //     let storagecompany_name = loginData.company_name;
                    //     let storagecustomer_emails = loginData.customer_emails;
                    //     let storageusername = loginData.username;
                    //     let storageuserid = loginData.userid;
                   
      var termsContent = fullEditorOnBody.root.innerHTML;
      var introContent = $('#quoation_introduction').val(); 


    let data = {
        quotation_id: $('#quotation_id').val(),
        original_draft: $('#original_draft').val(),
        action_type: action_type,
        save_type: saveType,
        customer_name: $('#selectCustomerFromSelect2').find(':selected').text(),
        customer_code: $('input[name=customer_code]').val(),
        customer_phone: $('input[name=customer_phone]').val(),
        customer_email: $('input[name=customer_email]').val(),
        customer_address: $('textarea[name=customer_address]').val(),
        quotation_date: $('#quotation_date').val(),
        quotation_prefix: $('#quotation_prefix').val(),
        items: items,
        subtotal: $('#subtotal').text(),
        vat_total: $('#vat_total').text(),
        grand_total: $('#grand_total').text(),
        reference_number : 0,
        total_discount : 0,
        total_discount_amount : 0,
        after_discount_amount : 0,
        storage_company_id : 1,
        storage_company_name : 'AA Car Rental',
        storage_username : 'Admin',
        storage_userid : 1,
        allItemSubtotal : $('#allItemSubtotal').text(),
        termsContentValue : termsContent,
        introContentValue : introContent,
        attentionValue : $('#quotation_attention').val(),
        quotation_number : $('#quotation_number').val(),
        action : 'SaveQuotation'
    };
     $.post('/QuotationController', data)
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
            laddaBtnDraft.stop();
        });
}
    
   

function validateQuotationForm() {
    let valid = true;
    let message = "";

    
    if (!$('#selectCustomerFromSelect2').val()) {
        message = "Customer name is required.";
        valid = false;
    }

    if (!$('#quotation_date').val()) {
        message = "Quotation date is required.";
        valid = false;
    }
     if (!$('#quotation_prefix').val()) {
        message = "Quotation prefix is required.";
        valid = false;
    }
    // Item rows validation
    let rowCount = $('#itemTable tbody tr').length;
    if (rowCount === 0) {
        message = "Please add atleast one row item.";
        valid = false;
    }

    $('#itemTable tbody tr').each(function(index) {
        let item = $(this).find('.vehicle_category_id').val();
        let qty = $(this).find('.qty').val();
        let price = $(this).find('.price').val();
        let duration = $(this).find('.duration').val();
        let vat = $(this).find('.vat').val();

        if (!item || !qty || !price || !duration || !vat) {
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
    let quotationId = $('#quotation_id').val();// get the quotation id from data-id attribute
    printQuotation(quotationId);           // call your function
});  

$('.qtnprint').on('click', function () {

    let id = $(this).data('id');
    let ref = $(this).data('ref');
alert(ref);
    window.open(`generate_quotation.php?id=${id}&ref_no=${ref}`, '_blank');

});
$('#openPrintSettings').click(function () {
    // let saved = localStorage.getItem('printSettings');

    // if (saved) {
    //     let settings = JSON.parse(saved);

    //     $('#printDecimals').val(settings.decimals);
    //     $('#printColor').val(settings.color);
    //     $('#printFontSize').val(settings.size);
    //     $('#lineItemGap').val(settings.lineItemGap);
    //     $('#fontColor').val(settings.fontColor);
    //     // new fields
    //     $('#printAlign').val(settings.align);
        
    //     $('#currencyName').val(settings.currencyName);
    //     $('#decimalName').val(settings.decimalName);
        
    //     $('#preparedName').val(settings.preparedName);
    //     $('#pageOrientation').val(settings.pageOrientation);

        
    //     $('#vat_status').val(settings.vat_status);
    //     $('#sig_possition').val(settings.sig_possition);
    //     $('#onPage').val(settings.onPage);
    //     $('#vALign').val(settings.vALign);
    //     $('#sealLeft').val(settings.sealLeft);
    //     $('#sealTop').val(settings.sealTop);
        
    //     // show logo file name (if you have a label/span)
    //     if (settings.logoFileName) {
    //         $('#logoFileNameDisplay').text(settings.logoFileName);
    //     }
    // }
    
   // $('#id').val($('#quotation_id').val());
   // $('#QtnRef').val($('#quotation_number').val());
    
   // $('#quotationModal').modal('show');
    let id = $('#quotation_id').val();
    let ref = $('#quotation_number').val();

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
  
// $('#confirmPrint').click(function () {

//     // get existing settings first
//     let saved = localStorage.getItem('printSettings');
//     let oldSettings = saved ? JSON.parse(saved) : {};

//     let logoInput = $('#printLogo');
//     let newFileName = oldSettings.logoFileName || '';

//     // if new file selected, update filename
//     if (logoInput[0].files.length > 0) {
//         newFileName = logoInput[0].files[0].name;
//     }

//     let settings = {
//         decimals: $('#printDecimals').val(),
//         color: $('#printColor').val(),
//         size: $('#printFontSize').val(),
//         align: $('#printAlign').val(),
//         lineItemGap : $('#lineItemGap').val(),
//         fontColor : $('#fontColor').val(),
//         logoFileName: newFileName,
//         currencyName: $('#currencyName').val(),
//         decimalName : $('#decimalName').val(),
//         preparedName : $('#preparedName').val(),
//         pageOrientation : $('#pageOrientation').val(),
//         countryCode : $('#countryCode').val(),
//         vat_status : $('#vat_status').val(),
//         grand_total_inclusive_val : $('#grand_total_inclusive_val').val(),
//         sig_possition : $('#sig_possition').val(),
//         onPage : $('#onPage').val(),
//         vALign : $('#vALign').val(),
//         nameStyle : $('#nameStyle').val(),
//         sealLeft : $('#sealLeft').val(),
//         sealTop : $('#sealTop').val()
//     };

//     // save updated settings
//     localStorage.setItem('printSettings', JSON.stringify(settings));

//     // create form
//     let form = $('<form>', {
//         action: '/PrintQuotation',
//         method: 'POST',
//         target: '_blank',
//         enctype: 'multipart/form-data'
//     });

//     form.append('<input type="hidden" name="id" value="' + $('#quotation_id').val() + '">');
//     form.append('<input type="hidden" name="decimals" value="' + settings.decimals + '">');
//     form.append('<input type="hidden" name="color" value="' + settings.color.replace("#", "") + '">');
//     form.append('<input type="hidden" name="size" value="' + settings.size + '">');
//     form.append('<input type="hidden" name="align" value="' + settings.align + '">');
//     form.append('<input type="hidden" name="lineItemGap" value="' + settings.lineItemGap + '">');
//     form.append('<input type="hidden" name="fontColor" value="' + settings.fontColor + '">');
//     form.append('<input type="hidden" name="currencyName" value="' + settings.currencyName + '">');
//     form.append('<input type="hidden" name="decimalName" value="' + settings.decimalName + '">');
//     form.append('<input type="hidden" name="preparedName" value="' + settings.preparedName + '">');
//     form.append('<input type="hidden" name="pageOrientation" value="' + settings.pageOrientation + '">');
//     form.append('<input type="hidden" name="countryCode" value="' + settings.countryCode + '">');
//     form.append('<input type="hidden" name="vat_status" value="' + settings.vat_status + '">');
//     form.append('<input type="hidden" name="grand_total_inclusive_val" value="' + settings.grand_total_inclusive_val + '">');
//     form.append('<input type="hidden" name="sig_possition" value="' + settings.sig_possition + '">');
//     form.append('<input type="hidden" name="onPage" value="' + settings.onPage + '">');
//     form.append('<input type="hidden" name="vALign" value="' + settings.vALign + '">');
//     form.append('<input type="hidden" name="nameStyle" value="' + settings.nameStyle + '">');
//     form.append('<input type="hidden" name="sealLeft" value="' + settings.sealLeft + '">');
//     form.append('<input type="hidden" name="sealTop" value="' + settings.sealTop + '">');
  

//     // Case 1: new file selected
//     if (logoInput[0].files.length > 0) {
//         logoInput.attr('name', 'logo');
//         form.append(logoInput);
//     } 
//     // Case 2: use old filename
//     else if (settings.logoFileName) {
//         form.append('<input type="hidden" name="fileName" value="' + settings.logoFileName + '">');
//     }

//     $('body').append(form);
//     form.submit();
// });



    $('#openQuotations, #MenuListOfQuotations').click(function () {
           $('#from_date_filter').val('');
           $('#to_date_filter').val('');
           openQuotationCanvas('No');
            
    });
    
    $('#openDraftQuotations, #MenuListOfDraftQuotations').click(function () {
           $('#from_date_filter').val('');
           $('#to_date_filter').val('');
           openQuotationCanvas('Yes');
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



});// CLose of Jquery


    </script>
</body>

</html>