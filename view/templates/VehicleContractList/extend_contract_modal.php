<div class="modal fade" id="extendcontractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Extend Contract</h5>
          <small>
            Agreement No: <span class=" fw-bold" id="agreement_ref"></span>
          </small>
        </div>
         <input type="hidden" value="" id="txt_extend_modal_agreement_id">
          <input type="hidden" value="" id="txt_extend_modal_agreement_no">
          <input type="hidden" value="" id="txt_extend_modal_booking_ids">
           <input type="hidden" value="" id="txt_extend_modal_booking_nos">
          
          
          <input type="hidden" value="" id="extend_hid_vehicle_id">
          <input type="hidden" value="" id="extend_hid_category_id">
          <input type="hidden" value="" id="extend_hid_model_id">
          <input type="hidden" value="" id="extend_hid_vehicle_no">
          
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
                    <span class="fw-semibold" id="extend_c_name"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Customer Code: </span>
                    <span class="fw-semibold" id="extend_c_code"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Contact Number: </span>
                    <span class="fw-semibold" id="extend_c_mobile"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Email: </span>
                    <span class="fw-semibold" id="extend_c_email"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Attn: </span>
                    <span class="fw-semibold" id="extend_c_attn"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Address: </span>
                    <span class="fw-semibold" id="extend_c_attr"></span>
                  </div>
                </div>
                </div>
                 

                </div>

              </div>
                    </div>
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
                                <span class="fw-semibold" id="extend_v_category"></span>
                              </div>
                            </div>
                    
                            <!-- Model -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Model: </span>
                                <span class="fw-semibold" id="extend_v_model"></span>
                              </div>
                            </div>
                    
                            <!-- Vehicle No -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Vehicle No: </span>
                                <span class="fw-semibold" id="extend_v_no"></span>
                              </div>
                            </div>
                    
                            <!-- Color -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Color: </span>
                                <span class="fw-semibold" id="extend_v_color"></span>
                              </div>
                            </div>
                            <!-- Year -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Year: </span>
                                <span class="fw-semibold" id="extend_v_year"></span>
                              </div>
                            </div>
                    
                            
                    
                            <!-- Insurance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">NextInsurance: </span>
                                <span class="fw-semibold" id="extend_v_insurance"></span>
                                <input type="hidden" id="extend_hid_nxt_insurance">
                              </div>
                            </div>
                    
                            <!-- Passing -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  bg-white d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Passing: </span>
                                <span class="fw-semibold" id="extend_v_passing"></span>
                                <input type="hidden" id="extend_hid_nxt_passing">
                              </div>
                            </div>
                            
                            <!-- Maintenance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Maintenance: </span>
                                <span class="fw-semibold" id="extend_v_maintenance"></span>
                                <input type="hidden" id="extend_hid_nxt_maintenance">
                              </div>
                            </div>
                            
                          </div>
                        
                      </div>
                    
                    </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded bg-white">
                
                          <div class="fw-semibold mb-2 text-primary">
                            Price Rate - Without Driver
                          </div>
                
                          <div class="row g-2">
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Hourly</span>
                              <span class="fw-semibold" id="extend_wod_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="extend_wod_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="extend_wod_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="extend_wod_monthly">0.000</span>
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
                              <span class="fw-semibold" id="extend_wd_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="extend_wd_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="extend_wd_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="extend_wd_monthly">0.000</span>
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
                   <div class="accordion-item mb-1 ">
                      <h2 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#bookSec">
                            Extension Details
                          </button>
                        </h2>

                      <div id="bookSec" class="accordion-collapse collapse show">
                          <div class="accordion-body">
            
                            <div class="row g-3">
            
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="datetime-local" id="extend_b_from" class="form-control extend_watch-field">
                                  <label>From</label>
                                </div>
                              </div>
            
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="datetime-local" id="extend_b_to" class="form-control extend_watch-field">
                                  <label>To</label>
                                </div>
                              </div>
                              
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <select class="extend_rate_type form-control form-control-sm extend_watch-field" id="extend_rate_type" >
                                    <option value="0">Select</option>
                                    <option value="hour">Hourly</option>
                                    <option value="day">Daily</option>
                                     <option value="week">Weekly</option>
                                    <option value="month">Monthly</option>
                                  </select>
                                 <label class="form-label small">Type</label>
                                </div>
                              </div>
                              
                              
            
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <select class="extend_service form-control form-control-sm extend_watch-field" id="extend_service">
                                    <option value="0">Select Service</option>
                                    <option value="1" data-id="10">Rental Without Driver</option>
                                    <option value="2" data-id="0">Rental With Driver</option>
                                  </select>
                                  <label class="form-label small">Service</label>
                                </div>
                              </div>
                                <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="extend_b_duration" class="form-control extend_watch-field">
                                  <label>Duration</label>
                                </div>
                              </div>
                              <div class="col-12 col-md-4">
                                
                                <div style="position:relative;" class="form-floating form-floating-outline">
                                
                                   <span class="extend_min-price-text badge bg-danger" style="position:absolute; top:-8px; right:8px; font-size:10px; z-index:2;">
                                    Min: 0.000
                                </span>
                                    <!-- Input -->
                                    <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" class="extend_price nav form-control form-control-sm extend_watch-field" value="0" style="padding-top:12px;" id="extend_price" >
                                     <label class="form-label small">Unit Price</label>
                                </div>
                                
                                <input type="hidden" class="extend_minprice nav form-control" value="0">
                                
                                
                                </div>
                              <div class="col-12 col-md-4">
                                 <div class="form-floating form-floating-outline">
                                  <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="extend_b_vat" class="form-control extend_watch-field">
                                  <label>VAT %</label>
                                </div>
                                 
                                </div>
                    
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="extend_b_total" class="form-control">
                                  <label>Total</label>
                                </div>
                              </div>
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="text" id="extend_b_qtn_ref_no" class="form-control" >
                                  <label>Quotation Ref. No.</label>
                                </div>
                              </div>
                              
                              <div class="col-12">
                                 <div class="form-floating form-floating-outline">
                                    <textarea class="form-control form-control-sm h-px-100" id="extend_txt_booking_notes" name="extend_txt_booking_notes" placeholder="Notes"></textarea>
                                    <label for="Notes">Notes</label>
                                  </div>
                                </div>
                                
                              <div class="col-12 " id="extend_otpdiv">
                               <div class="alert alert-info">
                                     
                                      <p class="mb-0" id="extend_p_otp_minprice_info"></p>
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
        <button class="btn btn-success px-4 ladda-button" id="btn_extend_contract"><span class="ladda-label">
        Extend Contract
    </span></button>
      </div>

    </div>
  </div>
</div>