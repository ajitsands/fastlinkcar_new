<?php
$allowedCompanies = [];
if (!empty($_SESSION['company_json'])) {
    $companyData = json_decode($_SESSION['company_json'], true);
    if (is_array($companyData)) {
        $allowedCompanies = $companyData;
    }
}
if (empty($allowedCompanies) && !empty($_SESSION['company_id'])) {
    $allowedCompanies = [
        ['ids' => $_SESSION['company_id'], 'company_name' => $_SESSION['company_name'] ?? 'Default Company']
    ];
}
    $singleCompanyId = count($allowedCompanies) === 1 ? $allowedCompanies[0]['ids'] : '';
    $isSingleCompany = count($allowedCompanies) === 1;

    $userPermissions = isset($_SESSION['permissions']) ? (is_array($_SESSION['permissions']) ? $_SESSION['permissions'] : explode(',', $_SESSION['permissions'])) : [];
    $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
    $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || in_array($_SESSION['user_role_name'] ?? '', ['Super Admin', 'Admin']) || in_array(3, $loggedInRoleIds) || in_array(1, $loggedInRoleIds);
    $canManageQuotation = $isSuperAdmin || in_array('*', $userPermissions) || in_array('quotation_manage', $userPermissions);
?>

<form id="quotationForm">
               

 <!--New Accordation Starts Here -->
 
 <div class="accordion mt-0" id="accordionWithIcon">
                    <div class="accordion-item active">
                      <h2 class="accordion-header d-flex align-items-center">
                        <button
                          type="button"
                          class="accordion-button"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionWithIcon-1"
                          aria-expanded="true">
                          <i class="icon-base ri ri-bar-chart-fill me-2"></i>
                           Quotation Information
                        </button>
                      </h2>

                      <div id="accordionWithIcon-1" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <!--Client Information-->
                                        <input type="hidden" id="quotation_id" name="quotation_id">
                                        <input type="hidden" id="quotation_number" name="quotation_number">
                                        <input type="hidden" id="original_draft" name="original_draft">
                                        <input type="hidden" id="save_type_hidden" name="save_type_hidden">


                                        <div class="row">
                                            <div class="col-12 col-xl-3">
                                                <div class="form-floating form-floating-outline mb-3">
                                                    <select class="form-select select2" id="selCompany" name="company_id" data-placeholder="Select company" <?= $isSingleCompany ? 'readonly' : '' ?> required>
                                                        <?php if (!$isSingleCompany): ?>
                                                            <option value="">Choose Company...</option>
                                                        <?php endif; ?>
                                                        <?php foreach ($allowedCompanies as $comp): ?>
                                                            <option value="<?= htmlspecialchars($comp['ids']) ?>"><?= htmlspecialchars($comp['company_name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label for="selCompany">Company</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-5">
                                                <div class="d-flex align-items-stretch gap-2 mb-3">
                                                    <div class="form-floating form-floating-outline flex-grow-1">
                                                        <select id="selectCustomerFromSelect2"
                                                                name="customer_name"
                                                                class="select2 form-select"
                                                                data-allow-clear="true"
                                                                style="width:100%">
                                                        </select>
                                                        <label>Select Customer</label>
                                                    </div>
                                                    <button type="button"
                                                            id="addCustomerBtn"
                                                            data-permission="customers_manage"
                                                            class="btn btn-primary d-flex align-items-center justify-content-center"
                                                            title="Add New Customer">
                                                        <i class="ri ri-user-add-line" style="font-size:20px;"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" id="customer_code" name="customer_code">
                                            </div>
                                            <div class="col-12 col-xl-2">
                                                <div class="form-floating form-floating-outline mb-3">
                                                    <input class="form-control form-control-sm" id="quotation_date" name ="quotation_date" type="date" placeholder="dd-mm-yyyy" required>
                                                    <label for="quotation_date">Date</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-2">
                                                <div class="form-floating form-floating-outline mb-3" >
                                                    <input class="form-control form-control-sm" id="quotation_prefix" name ="quotation_prefix" type="text" placeholder="Eg: CMN or LS" >
                                                    <label for="quotation_prefix">Quotation Prefix</label>
                                                </div>
                                            </div>
                                        </div>
                                           
                                            <div class="row">

                                                <!-- LEFT COLUMN -->
                                                <div class="col-12 col-lg-4">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                             <div class="col-6 col-xl-6">
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <input class="form-control form-control-sm" id="customer_phone" name ="customer_phone" type="text" placeholder="Telephone" >
                                                                    <label for="Telephone">Telephone</label>
                                                                  </div>
                                                            </div>
                                                            <div class="col-6 col-xl-6">
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <input class="form-control form-control-sm" id="customer_cpr_cr" name ="customer_cpr_cr" type="text" placeholder="CPR/CR" >
                                                                    <label for="Telephone">CPR/CR</label>
                                                                  </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                            
                                                        <div class="col-12">
                                                           <!--<div class="col-3 col-xl-3">-->
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <input class="form-control form-control-sm" id="customer_email" name ="customer_email" type="email" placeholder="Email" >
                                                                    <label for="Email">Email</label>
                                                                  </div>
                                                            <!--</div>-->
                                                        </div>
                                                        <div class="col-12">
                                                           <!--<div class="col-3 col-xl-3">-->
                                                                <div class="form-floating form-floating-outline mb-3">
                                                                    <input class="form-control form-control-sm" id="quotation_attention" name ="quotation_attention" type="text" placeholder="Attention" >
                                                                    <label for="Attention">Attention</label>
                                                                  </div>
                                                            <!--</div>-->
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-floating form-floating-outline mb-3">
                                                                <textarea class="form-control form-control-sm" id="customer_address" name="customer_address" placeholder="Address" rows="2" style="height: 60px;"></textarea>
                                                                <label for="Address">Address</label>
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <!-- RIGHT COLUMN -->
                                                <div class="col-12 col-lg-8">
                                                    <div class="col-12">
                                                    
                                                        <div class="position-relative">
                                                            <div class="card">
                                                                <style>
                                                                    /* Make the Quill placeholder look like a standard template placeholder */
                                                                    .ql-editor.ql-blank::before {
                                                                        font-style: normal !important;
                                                                        color: #a1acb8 !important; /* Bootstrap placeholder color used in Materio */
                                                                        font-family: var(--bs-font-sans-serif) !important;
                                                                        font-size: 0.8125rem !important; /* Matches form-control-sm */
                                                                        padding-top: 5px; /* Alignment tweak */
                                                                    }
                                                                    .ql-editor {
                                                                        font-family: var(--bs-font-sans-serif) !important;
                                                                    }
                                                                </style>
                                                                <div class="card-body p-0">
                                                                    <div id="full-editor-introduction-onbody"></div>
                                                                </div>
                                                            </div>
                                                            <button id="btn_open_intn_modal"
                                                                type="button"
                                                                class="btn btn-sm btn-outline-primary position-absolute"
                                                                style="top:6px; right:6px; z-index:5;"
                                                                title="Select Introduction">
                                                                <i class="ri ri-search-line text-danger"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            </div>

                         
                                <!--Client Information End-->
                        </div>
                      </div>
                    </div>

                    <div class="accordion-item">
                      <h2 class="accordion-header d-flex align-items-center">
                        <button
                          type="button"
                          class="accordion-button"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionWithIcon-2"
                          aria-expanded="false">
                          <i class="icon-base ri ri-briefcase-line me-2"></i>
                           Item Details &nbsp;&nbsp;<span id="quotationNumber" style="color:red;"></span>
                        </button>
                      </h2>
                      <div id="accordionWithIcon-2" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                         
                                <!--Item Details-->
                                <table id="itemTable">
                                    <thead>
                                        <tr>
                                            <th class="col-sl">Sl No</th>
                                            <th class="col-item">Item</th>
                                            <th class="col-service">Service</th>
                                            <th class="col-unit">Type</th>
                                            <th class="col-from" >From</th>
                                            <th class="col-to" >To</th>
                                            <th class="col-duration">Duration</th>
                                            <th class="col-qty">Qty</th>
                                            <th class="col-price">Unit Price</th>
                                            <th class="col-vat">VAT %</th>
                                            <th class="col-total">Total</th>
                                            <th class="col-action">Action</th>
                                        </tr>
                                    </thead>

                                
                                    <tbody></tbody>
                                
                                    <tfoot>
                                         <tr>
                                            <td colspan="10" style="text-align:right;"><strong>Subtotal</strong></td>
                                            <td colspan="2"><span id="allItemSubtotal">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" style="text-align:right;"><strong>Subtotal before VAT</strong></td>
                                            <td colspan="2"><span id="subtotal">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" style="text-align:right;"><strong>Discount%</strong></td>
                                            <td colspan="2"><input class="form-control form-control-sm text-center total_discount" id="total_discount" name ="total_discount" type="number" step="0.01" min="0" max="100" placeholder="Discount%" ></td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" style="text-align:right;"><strong>Discount Amount</strong></td>
                                            <td colspan="2"><span id="total_discount_amount">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" style="text-align:right;"><strong>After Discount</strong></td>
                                            <td colspan="2"><span id="after_discount_amount">0.00</span></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="10" style="text-align:right;"><strong>VAT Total</strong></td>
                                            <td colspan="2"><span id="vat_total">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" style="text-align:right;"><strong>Grand Total</strong></td>
                                            <td colspan="2"><strong><span id="grand_total">0.00</span></strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="12" style="text-align:left;">
                                                
                                                <!-- Full Editor -->
                                                    <div class="col-12">
                                                        <div class="position-relative">
                                                            <div class="card">
                                                                <style>
                                                                    #full-editor-onbody.ql-container .ql-editor.ql-blank::before {
                                                                        font-style: normal !important;
                                                                        color: #a1acb8 !important; 
                                                                        font-family: var(--bs-font-sans-serif) !important;
                                                                        font-size: 0.8125rem !important; 
                                                                        padding-top: 5px; 
                                                                    }
                                                                    #full-editor-onbody.ql-container .ql-editor {
                                                                        font-family: var(--bs-font-sans-serif) !important;
                                                                    }
                                                                </style>
                                                                <div class="card-body p-0">
                                                                    <div id="full-editor-onbody"></div>
                                                                </div>
                                                            </div>
                                                            <button id="btn_terms_condition"
                                                                type="button"
                                                                class="btn btn-sm btn-outline-primary position-absolute"
                                                                style="top:6px; right:6px; z-index:5;"
                                                                title="Select Terms and Conditions">
                                                                <i class="ri ri-search-line text-danger"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                            <!-- /Full Editor -->
                                            </td>
                                     
                                        </tr>
                                    </tfoot>
                                </table>
                           
                            
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <!-- Left: Add Item -->
                                <div>
                                <button type="button"
                                    class="btn btn-sm btn-primary waves-effect waves-light"
                                    id="addRow"
                                    data-permission="quotation_manage">
                                    <span class="ri ri-add-box-line icon-18px"></span>
                                    &nbsp;&nbsp;Add Item (alt+N)
                                </button>
                                <!--printQT-->
                                
                                <div class="btn-group" role="group">

                                    <!-- Print -->
                                    <button type="button"
                                        class="btn btn-sm btn-primary"
                                        id="btnPrint"
                                        title="Print">
                                        <i class="ri ri-printer-line fs-5"></i>
                                        Print
                                    </button>
                                
                                    <!-- Print with Images -->
                                    <button type="button"
                                        class="btn btn-sm btn-success"
                                        id="btnPrintWithImages"
                                        title="Print With Images">
                                        <i class="ri ri-image-add-line fs-5"></i>
                                        Print With Images
                                    </button>

                                </div>
                                <button type="button"
                                    class="btn btn-sm btn-warning  waves-effect waves-light"
                                    id="openQuotations">
                                    <span class="ri ri-file-list-3-line icon-18px"></span>
                                    &nbsp;&nbsp;Quotation List
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-dark waves-effect waves-light"
                                    id="openDraftQuotations">
                                    <span class="ri ri-file-list-3-line icon-18px"></span>
                                    &nbsp;&nbsp;Drafts List
                                </button>
                                
                                </div>
                                <!-- Right: Save buttons -->
                                <div>
                                    
                                   
                                    <button type="submit"
                                        name="save_type" value="final"
                                        id="btn_save_quotation"
                                        class="btn btn-sm btn-success waves-effect waves-light ladda-button"
                                        data-style="expand-left"
                                        title="Save Quotation (alt+S)"
                                        data-permission="quotation_manage">
                                        <span class="ladda-label d-flex align-items-center">
                                            <i class="ri ri-save-line icon-18px me-1"></i> Save Quotation
                                        </span>
                                    </button>
                            
                                    <button type="submit"
                                        name="save_type" value="draft"
                                        id="btn_save_quotation_draft"
                                        class="btn btn-sm btn-secondary waves-effect waves-light ladda-button"
                                        data-style="expand-left"
                                        title="Save Draft (alt+D)"
                                        data-permission="quotation_manage">
                                        <span class="ladda-label d-flex align-items-center">
                                            <i class="ri ri-save-line icon-18px me-1"></i> Save Draft
                                        </span>
                                    </button>
                                </div>
                            
                            </div>
                            <!--Item Details End-->
                         
                        </div>
                      </div>
                    </div>

         
                  </div>

    <!--<button type="submit" class="btn">Save Quotation</button>-->
</form>

<?php if (!$canManageQuotation): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        // Disable all inputs, selects, and textareas inside the quotation form
        const form = document.getElementById('quotationForm');
        if (form) {
            const elements = form.querySelectorAll('input, select, textarea');
            elements.forEach(el => {
                el.disabled = true;
                // If it's a select2, force it to be disabled using jQuery
                if (el.classList.contains('select2-hidden-accessible')) {
                    $(el).prop('disabled', true).trigger('change.select2');
                }
            });
            
            // Remove 'Add Item' button explicitly if they can't manage
            $('.add-item-btn').remove();
            
            // Disable Quill editors
            if (typeof fullEditorOnBody !== 'undefined') {
                fullEditorOnBody.disable();
            }
            if (typeof fullEditorIntroductionOnBody !== 'undefined') {
                fullEditorIntroductionOnBody.disable();
            }
        }
    }, 500); // Give select2 and Quill time to initialize
});
</script>
<?php endif; ?>
