<div class="modal fade" id="viewcontractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Contract Details</h5>
          <small>
           Agreement No: <span class=" fw-bold" id="viewcontract_agreement_ref"></span>, Status: <span class=" fw-bold" id="viewcontract_agreement_status"></span>
          </small>
        </div>
          <input type="hidden" value="" id="txt_viewcontract_modal_agreement_id">
          <input type="hidden" value="" id="txt_viewcontract_modal_agreement_no">
          <input type="hidden" value="" id="txt_viewcontract_modal_booking_ids">
          
          
          <input type="hidden" value="" id="viewcontract_hid_vehicle_id">
          <input type="hidden" value="" id="viewcontract_hid_category_id">
          <input type="hidden" value="" id="viewcontract_hid_model_id">
          <input type="hidden" value="" id="viewcontract_hid_vehicle_no">
           
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      
      <div class="modal-body">
       <div class="row">
           <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="accordion1">
                    <div class="accordion-item mb-1">
                        <h1 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#viewcontractcustSec">
                            Customer Details
                          </button>
                        </h1>

                      <div id="viewcontractcustSec" class="accordion-collapse collapse show">
              <div class="accordion-body">

                <div class="row g-3">
                   
                  <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Customer Name: </span>
                    <span class="fw-semibold" id="viewcontract_c_name"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Customer Code: </span>
                    <span class="fw-semibold" id="viewcontract_c_code"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Contact Number: </span>
                    <span class="fw-semibold" id="viewcontract_c_mobile"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Email: </span>
                    <span class="fw-semibold" id="viewcontract_c_email"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Attn: </span>
                    <span class="fw-semibold" id="viewcontract_c_attn"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Address: </span>
                    <span class="fw-semibold" id="viewcontract_c_attr"></span>
                  </div>
                </div>
                </div>
                 

                </div>

              </div>
                    </div>
                   
                    
                     
                  </div>
           </div>
           <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="viewcontractaccordion2">
                    <div class="accordion-item mb-1">
                        <h1 class="accordion-header  fw-bold">
                        <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#viewcontractvehSec">
                          Vehicle Details
                        </button>
                        
                      </h1>
                     <div id="viewcontractvehSec" class="accordion-collapse collapse show">
                <div class="accordion-body">
            
                 <div class="row g-3">

                      <div class="col-12">
                       
                    
                          <div class="row g-1">

                            <!-- Category -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Category: </span>
                                <span class="fw-semibold" id="viewcontract_v_category"></span>
                              </div>
                            </div>
                    
                            <!-- Model -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Model: </span>
                                <span class="fw-semibold" id="viewcontract_v_model"></span>
                              </div>
                            </div>
                    
                            <!-- Vehicle No -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Vehicle No: </span>
                                <span class="fw-semibold" id="viewcontract_v_no"></span>
                              </div>
                            </div>
                    
                            <!-- Color -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Color: </span>
                                <span class="fw-semibold" id="viewcontract_v_color"></span>
                              </div>
                            </div>
                            <!-- Year -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Year: </span>
                                <span class="fw-semibold" id="viewcontract_v_year"></span>
                              </div>
                            </div>
                    
                            
                    
                            <!-- Insurance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">NextInsurance: </span>
                                <span class="fw-semibold" id="viewcontract_v_insurance"></span>
                                <input type="hidden" id="viewcontract_hid_nxt_insurance">
                              </div>
                            </div>
                    
                            <!-- Passing -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  bg-white d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Passing: </span>
                                <span class="fw-semibold" id="viewcontract_v_passing"></span>
                                <input type="hidden" id="viewcontract_hid_nxt_passing">
                              </div>
                            </div>
                            
                            <!-- Maintenance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Maintenance: </span>
                                <span class="fw-semibold" id="viewcontract_v_maintenance"></span>
                                <input type="hidden" id="viewcontract_hid_nxt_maintenance">
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
                              <span class="fw-semibold" id="viewcontract_wod_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="viewcontract_wod_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="viewcontract_wod_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="viewcontract_wod_monthly">0.000</span>
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
                              <span class="fw-semibold" id="viewcontract_wd_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="viewcontract_wd_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="viewcontract_wd_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="viewcontract_wd_monthly">0.000</span>
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
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#viewcontractalllistbookSec">
                           Bookings & Extensions
                          </button>
                        </h2>

                      <div id="viewcontractalllistbookSec" class="accordion-collapse collapse show">
                          <div class="accordion-body">
            
                            <div class="row g-3">
            
                               <table id="contractviewcontractTable" class="table table-bordered table-sm">
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

   
   

</div>
            <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="accordion1">
                   
                     <div class="accordion-item mb-1">
            <h2 class="accordion-header fw-bold">
              <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#viewcontractimgSec">
                Vehicle Rentout Images
              </button>
            </h2>

            <div id="viewcontractimgSec" class="accordion-collapse collapse show">
              <div class="accordion-body">
               

                <div id="viewcontractpreview" class="d-flex flex-wrap gap-2"></div>
                
               
              </div>
            </div>
          </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#viewcontractreturnimgSec">
                            Vehicle Return Images
                          </button>
                        </h2>
            
                        <div id="viewcontractreturnimgSec" class="accordion-collapse collapse show">
                          <div class="accordion-body">
            
                            
                            <div id="viewcontractreturnpreview" class="d-flex flex-wrap gap-2"></div>
                            
                        
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
            
                            <div class="row mb-4">
                    <div class="col-md-6">
                
                        <div class="card border shadow-sm h-100">
                
                            <div class="card-header ">
                
                                <h6 class="mb-0">
                
                                    <i class="ri-quill-pen-line"></i>
                                     Hirer Signature 
                
                                </h6>
                
                            </div>
                
                            <div class="card-body text-center">
                
                                <div id="latest_hirer_signature_container">
                
                                    <img id="latest_hirer_signature"
                                         class="img-fluid border rounded p-2 mb-3"
                                         style="max-height:150px; display:none;">
                
                                    <div id="no_hirer_signature"
                                         class="text-muted">
                
                                        No Hirer Signature Applied
                
                                    </div>
                
                                </div>
                
                                <table class="table table-sm mt-2">
                
                                    <tr>
                
                                        <th width="120">
                                            Signed By
                                        </th>
                
                                        <td id="latest_hirer_name">-</td>
                
                                    </tr>
                
                                    <tr>
                
                                        <th width="140">
                                            Signed Date
                                        </th>
                
                                        <td id="latest_hirer_date">-</td>
                
                                    </tr>
                
                                </table>
                
                            </div>
                
                        </div>
                
                    </div>
                   
                    <div class="col-md-6">
                
                        <div class="card border shadow-sm h-100">
                
                            <div class="card-header ">
                
                                <h6 class="mb-0">
                
                                    <i class="ri-user-received-line"></i>
                                     Delivered Signature 
                
                                </h6>
                
                            </div>
                
                            <div class="card-body text-center">
                
                                <div id="latest_delivery_signature_container">
                
                                    <img id="latest_delivery_signature"
                                         class="img-fluid border rounded p-2 mb-3"
                                         style="max-height:150px; display:none;">
                
                                    <div id="no_delivery_signature"
                                         class="text-muted">
                
                                        No Delivered Signature Applied
                
                                    </div>
                
                                </div>
                
                                <table class="table table-sm mt-2">
                
                                    <tr>
                
                                        <th width="120">
                                            Signed By
                                        </th>
                
                                        <td id="latest_delivery_name">-</td>
                
                                    </tr>
                
                                    <tr>
                
                                        <th width="140">
                                            Signed Date
                                        </th>
                
                                        <td id="latest_delivery_date">-</td>
                
                                    </tr>
                
                                </table>
                
                            </div>
                
                        </div>
                
                    </div>
                     <div class="col-md-6">
                
                        <div class="card border shadow-sm h-100">
                
                            <div class="card-header ">
                
                                <h6 class="mb-0">
                
                                    <i class="ri-user-received-line"></i>
                                     Receiver Signature 
                
                                </h6>
                
                            </div>
                
                            <div class="card-body text-center">
                
                                <div id="latest_receiver_signature_container">
                
                                    <img id="latest_receiver_signature"
                                         class="img-fluid border rounded p-2 mb-3"
                                         style="max-height:150px; display:none;">
                
                                    <div id="no_receiver_signature"
                                         class="text-muted">
                
                                        No Receiver Signature Applied
                
                                    </div>
                
                                </div>
                
                                <table class="table table-sm mt-2">
                
                                    <tr>
                
                                        <th width="120">
                                            Signed By
                                        </th>
                
                                        <td id="latest_receiver_name">-</td>
                
                                    </tr>
                
                                    <tr>
                
                                        <th width="140">
                                            Signed Date
                                        </th>
                
                                        <td id="latest_receiver_date">-</td>
                
                                    </tr>
                
                                </table>
                
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
           <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="accordion2">
                    
                    <div class="accordion-item mb-1">
                <h2 class="accordion-header fw-bold">
                  <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#viewcontractcheckSec">
                    Vehicle Checklist
                  </button>
                </h2>

            <div id="viewcontractcheckSec" class="accordion-collapse collapse show">
              <div class="accordion-body">

                <div class="row mb-2">

                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="viewcontractchk_tools" disabled>
                      <label>Jack & Tools</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="viewcontractchk_spare" disabled>
                      <label>Spare Tyre</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="viewcontractchk_radio" disabled>
                      <label>Radio</label>
                    </div>
                  </div>
                
                  <div class="col-md-6">
                     <div class="form-floating form-floating-outline mb-3">
                      <input type="date" id="viewcontractdt_contract_date" class="form-control"  value="<?php echo date('Y-m-d') ?>" readonly>
                      <label>Contract Date</label>
                    </div>
                    </div>
                   
                  
                   

                </div>
               <div class="row ">
                     <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text"  id="viewcontractfuel_level" class="form-control" readonly>
                          <label>Fuel Level</label>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="viewcontractkm_out" class="form-control" readonly>
                          <label>KM Out</label>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="viewcontractkm_in" class="form-control">
                          <label>KM In</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="datetime-local" id="viewcontractdt_out" class="form-control" readonly>
                          <label>Date Time Out</label>
                        </div>
                  </div>
                   <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="datetime-local" id="viewcontractdt_in" class="form-control">
                          <label>Date Time In</label>
                        </div>
                  </div>
                   <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-3">
                      <input type="text" id="viewcontractcust_driver" class="form-control" readonly>
                      <label>Customer Driver</label>
                    </div>

                    
                  </div>
                  <div class="col-md-4 ">
                     <div class="form-floating form-floating-outline">
                      <input type="text" id="viewcontractcust_driver_contact_no" class="form-control" readonly>
                      <label>Contact Number</label>
                     </div>
                   </div>
                   <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-5 pt-1">

                        <!-- Left: Image Preview -->
                        <ul id="viewcontractcontractcustdriverdocpreview"
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
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#viewcontractdriverSec">
                             Company Driver Details
                          </button>
                        </h1>
                     <div id="viewcontractdriverSec" class="accordion-collapse collapse show">
                      <div class="accordion-body">
        
                        <div class="row g-3">
                           
                             <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Name: </span>
                                <span class="fw-semibold driverClasstext" id="viewcontractd_name"></span>
                              </div>
                            </div>
                             <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Contact Number: </span>
                                <span class="fw-semibold driverClasstext" id="viewcontractd_mobile"></span>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">License Number: </span>
                                <span class="fw-semibold driverClasstext" id="viewcontractd_license_no"></span>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Issue Place: </span>
                                <span class="fw-semibold driverClasstext" id="viewcontractd_license_issue_place"></span>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Issue Date: </span>
                                <span class="fw-semibold driverClasstext" id="viewcontractd_licenseissueDate"></span>
                              </div>
                            </div>
                             <div class="col-12 col-md-6 driverclass">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Expiry Date: </span>
                                <span class="fw-semibold driverClasstext" id="viewcontractd_licenseexpiryDate"></span>
                              </div>
                            </div>
                            
                        </div>
        
                      </div>
                    </div>
                    </div>
             <div class="accordion-item">
            <h2 class="accordion-header fw-bold">
              <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#termsSec">
               Terms & Condition
              </button>
            </h2>

            <div id="termsSec" class="accordion-collapse collapse show">
              <div class="accordion-body">

                <!-- Full Editor -->
                    <div class="col-12">
                      
                          <div id="full-editor-onbody">
                                
                          
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
        
      </div>

    </div>
  </div>
</div>