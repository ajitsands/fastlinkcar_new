<div class="modal fade" id="elistcontractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Extension Details</h5>
          <small>
            Agreement No: <span class=" fw-bold" id="elist_agreement_ref"></span>
          </small>
        </div>
         <input type="hidden" value="" id="txt_elist_modal_agreement_id">
          <input type="hidden" value="" id="txt_elist_modal_agreement_no">
          <input type="hidden" value="" id="txt_elist_modal_booking_ids">
          
          
          <input type="hidden" value="" id="elist_hid_vehicle_id">
          <input type="hidden" value="" id="elist_hid_category_id">
          <input type="hidden" value="" id="elist_hid_model_id">
          <input type="hidden" value="" id="elist_hid_vehicle_no">
          
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      
      <div class="modal-body">
       <div class="row">
           <div class="col-12 col-md-6">
               <div class="accordion mt-4 accordion-collapse collapse show" id="accordion1">
                    <div class="accordion-item mb-1">
                        <h1 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#elistcustSec">
                            Customer Details
                          </button>
                        </h1>

                      <div id="elistcustSec" class="accordion-collapse collapse show">
              <div class="accordion-body">

                <div class="row g-3">
                   
                  <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Customer Name: </span>
                    <span class="fw-semibold" id="elist_c_name"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Customer Code: </span>
                    <span class="fw-semibold" id="elist_c_code"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Contact Number: </span>
                    <span class="fw-semibold" id="elist_c_mobile"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Email: </span>
                    <span class="fw-semibold" id="elist_c_email"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Attn: </span>
                    <span class="fw-semibold" id="elist_c_attn"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Address: </span>
                    <span class="fw-semibold" id="elist_c_attr"></span>
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
                        <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#elistvehSec">
                          Vehicle Details
                        </button>
                        
                      </h1>
                     <div id="elistvehSec" class="accordion-collapse collapse show">
                <div class="accordion-body">
            
                 <div class="row g-3">

                      <div class="col-12">
                       
                    
                          <div class="row g-1">

                            <!-- Category -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Category: </span>
                                <span class="fw-semibold" id="elist_v_category"></span>
                              </div>
                            </div>
                    
                            <!-- Model -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Model: </span>
                                <span class="fw-semibold" id="elist_v_model"></span>
                              </div>
                            </div>
                    
                            <!-- Vehicle No -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Vehicle No: </span>
                                <span class="fw-semibold" id="elist_v_no"></span>
                              </div>
                            </div>
                    
                            <!-- Color -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Color: </span>
                                <span class="fw-semibold" id="elist_v_color"></span>
                              </div>
                            </div>
                            <!-- Year -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Year: </span>
                                <span class="fw-semibold" id="elist_v_year"></span>
                              </div>
                            </div>
                    
                            
                    
                            <!-- Insurance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">NextInsurance: </span>
                                <span class="fw-semibold" id="elist_v_insurance"></span>
                                <input type="hidden" id="elist_hid_nxt_insurance">
                              </div>
                            </div>
                    
                            <!-- Passing -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  bg-white d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Passing: </span>
                                <span class="fw-semibold" id="elist_v_passing"></span>
                                <input type="hidden" id="elist_hid_nxt_passing">
                              </div>
                            </div>
                            
                            <!-- Maintenance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Maintenance: </span>
                                <span class="fw-semibold" id="elist_v_maintenance"></span>
                                <input type="hidden" id="elist_hid_nxt_maintenance">
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
                              <span class="fw-semibold" id="elist_wod_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="elist_wod_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="elist_wod_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="elist_wod_monthly">0.000</span>
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
                              <span class="fw-semibold" id="elist_wd_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="elist_wd_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="elist_wd_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="elist_wd_monthly">0.000</span>
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
                <div class="accordion-item mb-1 ">
                      <h2 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#elistbookSec">
                           List of Extensions
                          </button>
                        </h2>

                      <div id="elistbookSec" class="accordion-collapse collapse show">
                          <div class="accordion-body">
            
                            <div class="row g-3">
            
                               <table id="contractExtensionTable" class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Agreement No</th>
                                    <th> Date</th>
                                    <th>Extension Period</th>
                                    <th>Details</th>
                                    <th>Pricing</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
        
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