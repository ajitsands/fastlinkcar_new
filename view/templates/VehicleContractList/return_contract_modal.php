<div class="modal fade" id="ReturncontractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Return Vehicle</h5>
          <small>
           Agreement No: <span class=" fw-bold" id="return_agreement_ref"></span>
          </small>
        </div>
          <input type="hidden" value="" id="txt_return_modal_agreement_id">
          <input type="hidden" value="" id="txt_return_modal_agreement_no">
          <input type="hidden" value="" id="txt_return_modal_booking_ids">
          
          
          <input type="hidden" value="" id="return_hid_vehicle_id">
          <input type="hidden" value="" id="return_hid_category_id">
          <input type="hidden" value="" id="return_hid_model_id">
          <input type="hidden" value="" id="return_hid_vehicle_no">
         
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      
      <div class="modal-body">
       <div class="row">
           <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="accordion1">
                    <div class="accordion-item mb-1">
                        <h1 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#custSec">
                            Customer Details
                          </button>
                        </h1>

                      <div id="custSec" class="accordion-collapse collapse show">
              <div class="accordion-body">

                <div class="row g-3">
                   
                  <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Customer Name: </span>
                    <span class="fw-semibold" id="return_c_name"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Customer Code: </span>
                    <span class="fw-semibold" id="return_c_code"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Contact Number: </span>
                    <span class="fw-semibold" id="return_c_mobile"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Email: </span>
                    <span class="fw-semibold" id="return_c_email"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Attn: </span>
                    <span class="fw-semibold" id="return_c_attn"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Address: </span>
                    <span class="fw-semibold" id="return_c_attr"></span>
                  </div>
                </div>
                </div>
                 

                </div>

              </div>
                    </div>
                   
                    
                     
                  </div>
           </div>
           <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="accordion2">
                    <div class="accordion-item mb-1">
                        <h1 class="accordion-header  fw-bold">
                        <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#vehSec">
                          Vehicle Details
                        </button>
                        
                      </h1>
                     <div id="vehSec" class="accordion-collapse collapse show">
                <div class="accordion-body">
            
                 <div class="row g-3">

                      <div class="col-12">
                       
                    
                          <div class="row g-1">

                            <!-- Category -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Category: </span>
                                <span class="fw-semibold" id="return_v_category"></span>
                              </div>
                            </div>
                    
                            <!-- Model -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Model: </span>
                                <span class="fw-semibold" id="return_v_model"></span>
                              </div>
                            </div>
                    
                            <!-- Vehicle No -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Vehicle No: </span>
                                <span class="fw-semibold" id="return_v_no"></span>
                              </div>
                            </div>
                    
                            <!-- Color -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Color: </span>
                                <span class="fw-semibold" id="return_v_color"></span>
                              </div>
                            </div>
                            <!-- Year -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Year: </span>
                                <span class="fw-semibold" id="return_v_year"></span>
                              </div>
                            </div>
                    
                            
                    
                            <!-- Insurance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">NextInsurance: </span>
                                <span class="fw-semibold" id="return_v_insurance"></span>
                                <input type="hidden" id="return_hid_nxt_insurance">
                              </div>
                            </div>
                    
                            <!-- Passing -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  bg-white d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Passing: </span>
                                <span class="fw-semibold" id="return_v_passing"></span>
                                <input type="hidden" id="return_hid_nxt_passing">
                              </div>
                            </div>
                            
                            <!-- Maintenance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Maintenance: </span>
                                <span class="fw-semibold" id="return_v_maintenance"></span>
                                <input type="hidden" id="return_hid_nxt_maintenance">
                              </div>
                            </div>
                            
                          </div>
                        
                      </div>
                    
                    </div>
                <div class="row g-3" style="display:none">
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded bg-white">
                
                          <div class="fw-semibold mb-2 text-primary">
                            Price Rate - Without Driver
                          </div>
                
                          <div class="row g-2">
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Hourly</span>
                              <span class="fw-semibold" id="return_wod_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="return_wod_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="return_wod_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="return_wod_monthly">0.000</span>
                            </div>
                
                          </div>
                
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="p-3 border rounded bg-white">
                
                          <div class="fw-semibold mb-2 text-info">
                            Price Rate - With Driver
                          </div>
                
                          <div class="row g-2">
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Hourly</span>
                              <span class="fw-semibold" id="return_wd_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="return_wd_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="return_wd_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="return_wd_monthly">0.000</span>
                            </div>
                
                          </div>
                
                        </div>
                      </div>
                </div>
            
                </div>
              </div>
                    </div>
                   
          
                  </div>
           </div>
           <div class="col-12 col-md-12">
                <div class="accordion mt-4 accordion-collapse collapse show" id="accordion1">
                     <div class="accordion-item mb-1 ">
                      <h2 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#alllistbookSec">
                           Bookings & Extensions
                          </button>
                        </h2>

                      <div id="alllistbookSec" class="accordion-collapse collapse show">
                          <div class="accordion-body">
            
                            <div class="row g-3">
            
                               <table id="contractReturnTable" class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th> Date</th>
                                    <th>Period</th>
                                    <th>Details</th>
                                    <th>Pricing</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                        </table>
        
                        </div>
        
                      </div>
                    </div>
                    </div>
                </div>
           </div>
          <div class="col-12 col-md-12" style="display:none">

    <!-- Accordion -->
    <div class="accordion mt-4" id="otherFeesAccordion">

        <div class="accordion-item">

            <h2 class="accordion-header" id="headingOtherFees">

                <button class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOtherFees">

                    Other Fees Entries

                </button>

            </h2>

            <div id="collapseOtherFees"
                 class="accordion-collapse collapse show"
                 data-bs-parent="#otherFeesAccordion">

                <div class="accordion-body">

                    <div class="mb-3 text-end">

                        <button type="button"
                                class="btn btn-sm btn-primary"
                                id="add_other_fee_row">

                            Add New

                        </button>

                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered align-middle">

                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="30%">Fee Item</th>
                                    <th width="15%">Price</th>
                                    <th width="15%">Actual Amount</th>
                                    <th width="25%">Remarks</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>

                            <tbody id="other_fee_tbody">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
            <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="accordion1">
                   
                     <div class="accordion-item mb-1">
            <h2 class="accordion-header fw-bold">
              <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#imgSec">
                Vehicle Rentout Images
              </button>
            </h2>

            <div id="imgSec" class="accordion-collapse collapse show">
              <div class="accordion-body">
               

                <div id="preview" class="d-flex flex-wrap gap-2"></div>
                
               
              </div>
            </div>
          </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#returnimgSec">
                            Vehicle Return Images
                          </button>
                        </h2>
            
                        <div id="returnimgSec" class="accordion-collapse collapse show">
                          <div class="accordion-body">
            
                            <input type="file" id="returncarImages" class="form-control mb-3" multiple accept="image/*" capture="environment">
            
                            <div id="returnpreview" class="d-flex flex-wrap gap-2"></div>
                            
                           <div class="progress mt-3" style="height:8px;">
                                <div class="return-progress-bar" id="returnglobalProgressBar" style="width:0%"></div>
                            </div>
                            <div id="returnuploadLoader" class="text-center mt-2 d-none">
                                <div class="spinner-border spinner-border-sm text-primary"></div>
                                <span class="ms-2">Uploading images...</span>
                            </div>
                            <button id="returnuploadBtn" class="btn btn-primary mt-3">Upload Return Vehicle Images</button>
                          </div>
                        </div>
                      </div>
                      <!-- Signature Accordion -->
                    <div class="accordion mt-4 accordion-collapse collapse show" id="receivedSignatureAccordion">
            
                <div class="accordion-item mb-1">
            
                    <h2 class="accordion-header fw-bold" id="headingReceivedSignature">
            
                        <button class="accordion-button text-danger"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseReceivedSignature">
            
                            Receiver Signature
                        </button>
            
                    </h2>
            
                    <div id="collapseReceivedSignature"
                         class="accordion-collapse collapse show"
                         data-bs-parent="#receivedSignatureAccordion">
            
                        <div class="accordion-body">
            
                            <div class="row">
            
                                <!-- Received By Name -->
                                <div class="col-md-4 mb-3">
            
                                    <label class="form-label">
                                        Received By Name
                                    </label>
            
                                    <input type="text"
                                           class="form-control"
                                           id="received_by_name"
                                           placeholder="Enter Name">
            
                                </div>
            
                                <!-- Signature Pad -->
                                <div class="col-md-8 mb-3">
            
                                    <label class="form-label">
                                        Receiver Signature
                                    </label>
            
                                    <div class=" p-2 ">
                                       
                                       <canvas id="Returnsignature-pad"
                                            width="800"
                                            height="200"
                                            style="width:100%; border:1px solid #ccc; border-radius:5px; background:#fff;">
                                    </canvas>
            
                                    </div>
            
                                    <div class="mt-2 d-flex gap-2">
            
                                        <button type="button"
                                                class="btn btn-sm btn-secondary"
                                                id="clear_returnsignature">
            
                                            Clear
                                        </button>
            
                                        <!--<button type="button"-->
                                        <!--        class="btn btn-sm btn-success"-->
                                        <!--        id="save_signature">-->
            
                                        <!--    Save Signature-->
                                        <!--</button>-->
            
                                    </div>
            
                                </div>
            
                            </div>
            
                        </div>
            
                    </div>
            
                </div>
            
            </div>
                     
                  </div>
           </div>
           <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="accordion2">
                    
                    <div class="accordion-item mb-1">
                <h2 class="accordion-header fw-bold">
                  <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#checkSec">
                    Vehicle Checklist
                  </button>
                </h2>

            <div id="checkSec" class="accordion-collapse collapse show">
              <div class="accordion-body">

                <div class="row mb-2">

                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="chk_tools" disabled>
                      <label>Jack & Tools</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="chk_spare" disabled>
                      <label>Spare Tyre</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="chk_radio" disabled>
                      <label>Radio</label>
                    </div>
                  </div>
                
                  <div class="col-md-6">
                     <div class="form-floating form-floating-outline mb-3">
                      <input type="date" id="dt_contract_date" class="form-control"  value="<?php echo date('Y-m-d') ?>" readonly>
                      <label>Contract Date</label>
                    </div>
                    </div>
                   
                  
                   

                </div>
               <div class="row ">
                     <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text"  id="fuel_level" class="form-control" readonly>
                          <label>Fuel Level</label>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="km_out" class="form-control" readonly>
                          <label>KM Out</label>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="km_in" class="form-control">
                          <label>KM In</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="datetime-local" id="dt_out" class="form-control" readonly>
                          <label>Date Time Out</label>
                        </div>
                  </div>
                   <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="datetime-local" id="dt_in" class="form-control">
                          <label>Date Time In</label>
                        </div>
                  </div>
                   <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-3">
                      <input type="text" id="cust_driver" class="form-control" readonly>
                      <label>Customer Driver</label>
                    </div>

                    
                  </div>
                  <div class="col-md-4 ">
                     <div class="form-floating form-floating-outline">
                      <input type="text" id="cust_driver_contact_no" class="form-control" readonly>
                      <label>Contact Number</label>
                     </div>
                   </div>
                   <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-5 pt-1">

                        <!-- Left: Image Preview -->
                        <ul id="contractcustdriverdocpreview"
                            class="list-unstyled d-flex align-items-center avatar-group mb-0">
                        </ul>
                    
                        
                  
                    </div>
                    </div>
                </div>
             

              </div>
            </div>
          </div>
            <div class="accordion-item mb-1">
                     <h1 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#driverSec">
                             Company Driver Details
                          </button>
                        </h1>
                     <div id="driverSec" class="accordion-collapse collapse show">
                      <div class="accordion-body">
        
                        <div class="row g-3">
                           
                             <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Name: </span>
                                <span class="fw-semibold driverClasstext" id="d_name"></span>
                              </div>
                            </div>
                             <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Contact Number: </span>
                                <span class="fw-semibold driverClasstext" id="d_mobile"></span>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">License Number: </span>
                                <span class="fw-semibold driverClasstext" id="d_license_no"></span>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Issue Place: </span>
                                <span class="fw-semibold driverClasstext" id="d_license_issue_place"></span>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Issue Date: </span>
                                <span class="fw-semibold driverClasstext" id="d_licenseissueDate"></span>
                              </div>
                            </div>
                             <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Expiry Date: </span>
                                <span class="fw-semibold driverClasstext" id="d_licenseexpiryDate"></span>
                              </div>
                            </div>
                            
                        </div>
        
                      </div>
                    </div>
                    </div>
                      
                  
                     
           
          
                  </div>
           </div>
           <hr>
       </div>
        </div>
      <!-- FOOTER -->
      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success px-4 ladda-button" id="btn_return_contract"><span class="ladda-label">
        Return Contract
    </span></button>
      </div>

    </div>
  </div>
</div>