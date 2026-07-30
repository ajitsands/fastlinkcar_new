<div class="container-fluid flex-grow-1 container-p-y">
	<div class="layout-demo-placeholder">


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
                                            <div class="col-2 col-xl-2">
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="quotation_date" name ="quotation_date" type="date" placeholder="dd-mm-yyyy" >
                                                    <label for="quotation_date">Date</label>
                                                  </div>
                                            </div>
                                            <div class="col-2 col-xl-2">
                                                <div class="form-floating form-floating-outline mb-6" >
                                                    <input class="form-control form-control-sm" id="quotation_prefix" name ="quotation_prefix" type="text" placeholder="Eg: CMN or LS" >
                                                    <label for="Quotation Prefix">Quotation Prefix</label>
                                                  </div>
                                            </div>
                                            <div class="col-8 col-xl-8">
                                                <div class="d-flex align-items-stretch gap-2">
                                            
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
                                                            class="btn btn-primary d-flex align-items-center justify-content-center"
                                                            title="Add New Customer">
                                                        <i class="ri ri-user-add-line" style="font-size:20px;"></i>
                                                    </button>
                                            
                                                </div>
                                                 <input type="hidden" id="customer_code" name="customer_code">
                                            </div>
                                           
                                            <div class="row">

                                                <!-- LEFT COLUMN -->
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                             <div class="col-6 col-xl-6">
                                                                <div class="form-floating form-floating-outline mb-6">
                                                                    <input class="form-control form-control-sm" id="customer_phone" name ="customer_phone" type="text" placeholder="Telephone" >
                                                                    <label for="Telephone">Telephone</label>
                                                                  </div>
                                                            </div>
                                                            <div class="col-6 col-xl-6">
                                                                <div class="form-floating form-floating-outline mb-6">
                                                                    <input class="form-control form-control-sm" id="customer_cpr_cr" name ="customer_cpr_cr" type="text" placeholder="CPR/CR" >
                                                                    <label for="Telephone">CPR/CR</label>
                                                                  </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                            
                                                        <div class="col-12">
                                                           <!--<div class="col-3 col-xl-3">-->
                                                                <div class="form-floating form-floating-outline mb-6">
                                                                    <input class="form-control form-control-sm" id="customer_email" name ="customer_email" type="email" placeholder="Email" >
                                                                    <label for="Email">Email</label>
                                                                  </div>
                                                            <!--</div>-->
                                                        </div>
                                                        <div class="col-12">
                                                           <!--<div class="col-3 col-xl-3">-->
                                                                <div class="form-floating form-floating-outline mb-6">
                                                                    <input class="form-control form-control-sm" id="quotation_attention" name ="quotation_attention" type="text" placeholder="Attention" >
                                                                    <label for="Attention">Attention</label>
                                                                  </div>
                                                            <!--</div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <!-- RIGHT COLUMN -->
                                                <div class="col-8">
                                                   <div class="col-12">
                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <textarea class="form-control form-control-sm h-px-100" id="customer_address" name="customer_address" placeholder="Address"></textarea>
                                                            <label for="Address">Address</label>
                                                          </div>
                                                    </div>
                                                    
                                                    <div class="col-12">
                                                    
                                                        <div class="form-floating form-floating-outline mb-3 position-relative">

                                                            <div class="input-group align-items-start">
                                                                <textarea 
                                                                    class="form-control form-control-sm pe-5"
                                                                    id="quoation_introduction"
                                                                    name="quoation_introduction"
                                                                    rows="4"
                                                                    placeholder="Enter introduction or click 🔍 to choose template"></textarea>
                                                                <button id="btn_open_intn_modal"
                                                                    type="button"
                                                                    class="btn  btn-outline-primary position-absolute"
                                                                    style="top:6px; right:6px; z-index:5;"
                                                                    title="Select Introduction">
                                                                    <i class="ri ri-search-line text-danger" ></i>
                                                                </button>
                                                            </div>
                                                           
                                                        </div>
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
                                        <!--<tr>-->
                                        <!--    <td colspan="10" style="text-align:right;"><strong>Discount%</strong></td>-->
                                        <!--    <td colspan="2"><input class="form-control form-control-sm text-center total_discount" id="total_discount" name ="total_discount" type="text" placeholder="Discount%" ></td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td colspan="10" style="text-align:right;"><strong>Discount Amount</strong></td>-->
                                        <!--    <td colspan="2"><span id="total_discount_amount">0.00</span></td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td colspan="10" style="text-align:right;"><strong>After Discount</strong></td>-->
                                        <!--    <td colspan="2"><span id="after_discount_amount">0.00</span></td>-->
                                        <!--</tr>-->
                                        
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
                                                      <div class="card">
                                                        <div class="card-body p-0">
                                                          <div id="full-editor-onbody">
                                                                
                                                          </div>
                                                        </div>
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
                                    id="addRow">
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
                                    <span class="ri ri-add-box-line icon-18px"></span>
                                    &nbsp;&nbsp;Quotations (Q+1)
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-dark waves-effect waves-light"
                                    id="openDraftQuotations">
                                    <span class="ri ri-add-box-line icon-18px"></span>
                                    &nbsp;&nbsp;Drafts (Q+2)
                                </button>
                                
                                </div>
                                <!-- Right: Save buttons -->
                                <div>
                                    
                                   
                                    <button type="button"
                                        name="btn_terms_condition" value="btn_terms_condition"
                                        id="btn_terms_condition"
                                        class="btn btn-sm btn-info waves-effect waves-light">
                                        <span class="ri ri-save-line icon-18px"></span>
                                        &nbsp;&nbsp;Terms & Condition (alt+i)
                                    </button>
                                    <button type="submit"
                                        name="save_type" value="final"
                                        id="btn_save_quotation"
                                        class="btn btn-sm btn-success waves-effect waves-light">
                                        <span class="ri ri-save-line icon-18px"></span>
                                        &nbsp;&nbsp;Save Quotation (alt+S)
                                    </button>
                            
                                    <button type="submit"
                                        name="save_type" value="draft"
                                        id="btn_save_quotation_draft"
                                        class="btn btn-sm btn-secondary waves-effect waves-light">
                                        <span class="ri ri-save-line icon-18px"></span>
                                        &nbsp;&nbsp;Save Draft (alt+D)
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


	 
	 
	</div>

</div>