<div class="container-fluid flex-grow-1 container-p-y">
	<div class="layout-demo-placeholder">


<form id="cashmemoForm">
               

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
                          Cash Memo Details
                        </button>
                      </h2>

                      <div id="accordionWithIcon-1" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <!--Client Information-->
                                        <input type="hidden" id="cashmemo_id" name="cashmemo_id">
                                        <input type="hidden" id="cashmemo_number" name="cashmemo_number">
                                        <input type="hidden" id="original_draft" name="original_draft">
                                        <input type="hidden" id="save_type_hidden" name="save_type_hidden">


                                        <div class="row">
                                            <div class="col-3 col-xl-3">
                                               
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="cashmemo_date" name ="cashmemo_date" type="date" placeholder="dd-mm-yyyy" >
                                                    <label for="cashmemo_date">Date</label>
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
                                            <div class="col-3 col-xl-3">
                                                <div class="d-flex align-items-stretch gap-2">
                                                <div class="form-floating form-floating-outline flex-grow-1">
                                                    <label for="cashmemo_selagreement"> Select Agreement</label>
                                                   <select id="cashmemo_selagreement" name="cashmemo_selagreement" class="form-select select2" ><option value="">Select Agreement</option></select>
                                                    
                                                  </div>
                                                  <a href="javascript:void(0)" class="ml-1 text-danger viewContractLedgerBtn" title="View Contract Ledger">
                                                        <i class="ri ri-book-2-line" style="font-size:20px;"></i>
                                        </a>
                                                 </div>
                                            </div>
                                         </div>
                                          <div class="row">
                                            <div class="col-2 col-xl-2">
                                                <div class="form-floating form-floating-outline mb-6">
                                                <input class="form-control form-control-sm" id="customer_phone" name ="customer_phone" type="text" placeholder="Telephone" >
                                                <label for="Telephone">Telephone</label>
                                              </div>
                                            </div>
                                            <div class="col-2 col-xl-2">
                                               
                                                <div class="form-floating form-floating-outline mb-6">
                                                <input class="form-control form-control-sm" id="customer_email" name ="customer_email" type="email" placeholder="Email" >
                                                <label for="Email">Email</label>
                                              </div>
                                            
                                            </div>
                                            <div class="col-2 col-xl-2">
                                          
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="customer_cpr_cr" name ="customer_cpr_cr" type="text" placeholder="CPR/CR" >
                                                    <label for="CPR/CR">CPR/CR</label>
                                                  </div>
                                           
                                        </div>
                                           <div class="col-2 col-xl-2">
                                                               
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="cashmemo_car_type" name ="cashmemo_car_type" type="text" placeholder="" >
                                                    <label for="cashmemo_car_type">Type of Car</label>
                                                  </div>
                                          
                                        </div>
                                        <div class="col-2 col-xl-2">
                                               
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="cashmemo_car_no" name ="cashmemo_car_no" type="text" placeholder="" >
                                                    <label for="cashmemo_car_no">Vehicle No</label>
                                                  </div>
                                          
                                        </div>
                                        <div class="col-2 col-xl-2">
                                               
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input class="form-control form-control-sm" id="cashmemo_color" name ="cashmemo_color" type="text" placeholder="" >
                                                    <label for="cashmemo_color">Color</label>
                                                  </div>
                                           <input  id="cashmemo_hidvehicle_id" name ="cashmemo_hidvehicle_id" type="hidden"  >
                                            <input  id="cashmemo_hidbooking_ids" name ="cashmemo_hidbooking_ids" type="hidden"  >
                                             <input  id="cashmemo_hidvehicle_model_id" name ="cashmemo_hidvehicle_model_id" type="hidden"  >
                                        </div>
                                           
                                         </div>
                                          <div class="row ">
                                                     
                                                        
                                                      
                                                         <div class="col-3 col-xl-3">
                                                                 <div class="form-floating form-floating-outline mb-6">
                                                                    <textarea class="form-control form-control-sm h-px-8" id="customer_address" name="customer_address" placeholder="Address"></textarea>
                                                                    <label for="Address">Address</label>
                                                                  </div>
                                                            </div>
                                                             <div class="col-2 col-xl-2" id="divCashmemoPaymentMethod">
                                                                  <div class="form-floating form-floating-outline mb-6">
                                                                <select id="cash_memo_payment_method" class="select2 form-select" data-placeholder="Select Payment Type">
                                                                       
                                                                        <option value="Cash" selected>Cash</option>
                                                                        <option value="Cheque">Cheque</option>
                                                                         <option value="Benefit">Benefit</option>
                                                                          <option value="Voucher">Voucher</option>
                                                                        <option value="Bank Transfer">Bank Transfer</option>
                                                                        <option value="Credit Card">Credit Card</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                     <label for="select2Basic">Payment Type</label>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-2 col-xl-2">
                                                                   
                                                                    <div class="form-floating form-floating-outline mb-6">
                                                                       <input type="date" name="cash_memo_cheque_date" id="cash_memo_cheque_date" class="form-control">
                                                                        <label for="cash_memo_cheque_date">Cheque Date</label>
                                                                      </div>
                                                              
                                                            </div>
                                                            <div class="col-2 col-xl-2">
                                                                   
                                                                    <div class="form-floating form-floating-outline mb-6">
                                                                       <input type="text" name="cash_memo_cheque_ref_no" id="cash_memo_cheque_ref_no" class="form-control" placeholder="Cheque/Ref No">
                                                                        <label for="cash_memo_cheque_ref_no">Cheque/Ref No</label>
                                                                      </div>
                                                              
                                                            </div>
                                                         <div class="col-3 col-xl-3">
                                                          
                                                                <div class="form-floating form-floating-outline mb-6">
                                                                    <textarea class="form-control form-control-sm h-px-8" id="cashmemo_notes" name="cashmemo_notes" placeholder="Notes"></textarea>
                                                                    <label for="cashmemo_notes">Notes</label>
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
                           Item Details &nbsp;&nbsp;<span id="cashmemoNumber" style="color:red;"></span>
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
                                            <td colspan="5" style="text-align:right;"><strong>Subtotal</strong></td>
                                            <td colspan="2"><span id="allItemSubtotal">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align:right;"><strong>Subtotal before VAT</strong></td>
                                            <td colspan="2"><span id="subtotal">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align:right;"><strong>Discount%</strong></td>
                                            <td colspan="2"><input class="form-control form-control-sm text-center total_discount" id="total_discount" name ="total_discount" type="text" placeholder="Discount%" ></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align:right;"><strong>Discount Amount</strong></td>
                                            <td colspan="2"><span id="total_discount_amount">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align:right;"><strong>After Discount</strong></td>
                                            <td colspan="2"><span id="after_discount_amount">0.00</span></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="5" style="text-align:right;"><strong>VAT Total</strong></td>
                                            <td colspan="2"><span id="vat_total">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align:right;"><strong>Grand Total</strong></td>
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
                                    id="opencashmemo">
                                    <span class="ri ri-add-box-line icon-18px"></span>
                                    &nbsp;&nbsp;Receipt List
                                </button>
                               
                                
                                </div>
                                <!-- Right: Save buttons -->
                                <div>
                                    
                                   
                                   
                                    <button type="submit"
                                        name="save_type" value="final"
                                        id="btn_save_cashmemo"
                                        class="btn btn-sm btn-success waves-effect waves-light">
                                        <span class="ri ri-save-line icon-18px"></span>
                                        &nbsp;&nbsp;Generate Receipt
                                    </button>
                            
                                   
                                </div>
                            
                            </div>
                            <!--Item Details End-->
                         
                        </div>
                      </div>
                    </div>

         
                  </div>

</form>


	 
	 
	</div>

</div>