<div class="container-fluid flex-grow-1 container-p-y">
	<div class="layout-demo-placeholder">


<form id="invocieForm">
               

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
                          Invoice Details
                        </button>
                      </h2>

                      <div id="accordionWithIcon-1" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <!--Client Information-->
                                        <input type="hidden" id="invoice_id" name="invoice_id">
                                        <input type="hidden" id="invoice_number" name="invoice_number">
                                        <input type="hidden" id="original_draft" name="original_draft">
                                        <input type="hidden" id="save_type_hidden" name="save_type_hidden">


                                        <div class="row">
                                            <div class="col-3 col-xl-3">
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="invoice_date" name ="invoice_date" type="date" placeholder="dd-mm-yyyy" >
                                                    <label for="invoice_date">Invoice Date</label>
                                                  </div>
                                            </div>
                                            <div class="col-3 col-xl-3">
                                               
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="invoice_due_date" name ="invoice_due_date" type="date" placeholder="dd-mm-yyyy" >
                                                    <label for="invoice_due_date">Invoice Due Date</label>
                                                  </div>
                                            
                                            </div>
                                            <div class="col-6 col-xl-6">
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
                                            <a href="javascript:void(0)" class="ml-1 text-danger viewCustomerLedgerBtn" title="View Customer Ledger">
                                                        <i class="ri ri-book-2-line" style="font-size:20px;"></i>
                                        </a>
                                                    
                                            
                                                </div>
                                                 <input type="hidden" id="customer_code" name="customer_code">
                                            </div>
                                         </div>
                                          <div class="row">
                                            <div class="col-3 col-xl-3">
                                                <div class="form-floating form-floating-outline mb-6">
                                                <input class="form-control form-control-sm" id="customer_phone" name ="customer_phone" type="text" placeholder="Telephone" >
                                                <label for="Telephone">Telephone</label>
                                              </div>
                                            </div>
                                            <div class="col-3 col-xl-3">
                                               
                                                <div class="form-floating form-floating-outline mb-6">
                                                <input class="form-control form-control-sm" id="customer_email" name ="customer_email" type="email" placeholder="Email" >
                                                <label for="Email">Email</label>
                                              </div>
                                            
                                            </div>
                                            <div class="col-3 col-xl-3">
                                                          
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="invoice_attention" name ="invoice_attention" type="text" placeholder="Attention" >
                                                    <label for="Attention">Attention</label>
                                                  </div>
                                           
                                        </div>
                                            <div class="col-3 col-xl-3">
                                          
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="customer_cpr_cr" name ="customer_cpr_cr" type="text" placeholder="CPR/CR" >
                                                    <label for="CPR/CR">CPR/CR</label>
                                                  </div>
                                           
                                        </div>
                            
                                         </div>
                                          <div class="row ">
                                                     
                                                        
                                                        <div class="col-3 col-xl-3">
                                                         <div class="form-floating form-floating-outline mb-6">
                                                            <textarea class="form-control form-control-sm h-px-16" id="customer_address" name="customer_address" placeholder="Address"></textarea>
                                                            <label for="Address">Address</label>
                                                          </div>
                                                    </div>
                                                         <div class="col-3 col-xl-3">
                                                               
                                                                <div class="form-floating form-floating-outline mb-6">
                                                                    <input class="form-control form-control-sm" id="transaction_no" name ="transaction_no" type="text" placeholder="" >
                                                                    <label for="transaction_no">TRN:</label>
                                                                  </div>
                                                          
                                                        </div>
                                                        <div class="col-3 col-xl-3">
                                                               
                                                                <div class="form-floating form-floating-outline mb-6">
                                                                    <input class="form-control form-control-sm" id="lpo_no" name ="lpo_no" type="text" placeholder="" >
                                                                    <label for="lpo_no">LPO NO:</label>
                                                                  </div>
                                                          
                                                        </div>
                                                        <div class="col-3 col-xl-3">
                                                               
                                                                <div class="form-floating form-floating-outline mb-6">
                                                                    <input class="form-control form-control-sm" id="qtn_ref_no" name ="qtn_ref_no" type="text" placeholder="" >
                                                                    <label for="qtn_ref_no">Quotation Ref No:</label>
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
                          Invoice Item Details &nbsp;&nbsp;<span id="invoiceNumber" style="color:red;"></span>
                        </button>
                      </h2>
                      <div id="accordionWithIcon-2" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                         
                                <!--Item Details-->
                                <table id="itemTable">
                                    <thead>
                                        <tr>
                                            <th class="col-sl">Sl No</th>
                                            <th class="col-service">Agreement No</th>
                                            <th class="col-item">Item</th>
                                            <th class="col-from" >From</th>
                                            <th class="col-to" >To</th>
                                        
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
                                            <td colspan="8" style="text-align:right;"><strong>Subtotal</strong></td>
                                            <td colspan="2"><span id="allItemSubtotal">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="text-align:right;"><strong>Subtotal before VAT</strong></td>
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
                                            <td colspan="8" style="text-align:right;"><strong>VAT Total</strong></td>
                                            <td colspan="2"><span id="vat_total">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="text-align:right;"><strong>Grand Total</strong></td>
                                            <td colspan="2"><strong><span id="grand_total">0.00</span></strong></td>
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
                               
                                <button type="button"
                                    class="btn btn-sm btn-warning  waves-effect waves-light"
                                    id="openInvoice">
                                    <span class="ri ri-add-box-line icon-18px"></span>
                                    &nbsp;&nbsp;Invoice List
                                </button>
                               
                                
                                </div>
                                <!-- Right: Save buttons -->
                                <div>
                                    
                                   
                                   
                                    <button type="submit"
                                        name="save_type" value="final"
                                        id="btn_save_invoice"
                                        class="btn btn-sm btn-success waves-effect waves-light">
                                        <span class="ri ri-save-line icon-18px"></span>
                                        &nbsp;&nbsp;Generate Invoice
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