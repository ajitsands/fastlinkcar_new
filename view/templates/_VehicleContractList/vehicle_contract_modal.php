<div class="modal fade" id="contractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Generate Contract</h5>
          <small>
            Booking Ref: <span class=" fw-bold" id="booking_ref"></span>
          </small>
        </div>
         <input type="hidden" value="" id="txt_contract_modal_contract_id">
         <input type="hidden" value="" id="txt_contract_modal_data_source">
         <input type="hidden" value="" id="txt_contract_modal_booking_id">
         <input type="hidden" value="" id="txt_contract_modal_booking_ref_no">
         <input type="hidden" value="" id="hid_vehicle_id">
         <input type="hidden" value="" id="hid_category_id">
         <input type="hidden" value="" id="hid_model_id">
         <input type="hidden" value="" id="hid_vehicle_no">
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
                    <span class="fw-semibold" id="c_name"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Customer Code: </span>
                    <span class="fw-semibold" id="c_code"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Contact Number: </span>
                    <span class="fw-semibold" id="c_mobile"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Email: </span>
                    <span class="fw-semibold" id="c_email"></span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Attn: </span>
                    <span class="fw-semibold" id="c_attn"></span>
                  </div>
                </div>
                 <div class="col-12 col-md-6">
                  <div class="p-1 d-flex justify-content-between">
                    <span class="text-muted fs-6">Address: </span>
                    <span class="fw-semibold" id="c_attr"></span>
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
                                <span class="fw-semibold" id="v_category"></span>
                              </div>
                            </div>
                    
                            <!-- Model -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Model: </span>
                                <span class="fw-semibold" id="v_model"></span>
                              </div>
                            </div>
                    
                            <!-- Vehicle No -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Vehicle No: </span>
                                <span class="fw-semibold" id="v_no"></span>
                              </div>
                            </div>
                    
                            <!-- Color -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Color: </span>
                                <span class="fw-semibold" id="v_color"></span>
                              </div>
                            </div>
                            <!-- Year -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">Year: </span>
                                <span class="fw-semibold" id="v_year"></span>
                              </div>
                            </div>
                    
                            
                    
                            <!-- Insurance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  d-flex justify-content-between">
                                <span class="text-muted fs-6">NextInsurance: </span>
                                <span class="fw-semibold" id="v_insurance"></span>
                                <input type="hidden" id="hid_nxt_insurance">
                              </div>
                            </div>
                    
                            <!-- Passing -->
                            <div class="col-12 col-md-6">
                              <div class="p-1  bg-white d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Passing: </span>
                                <span class="fw-semibold" id="v_passing"></span>
                                <input type="hidden" id="hid_nxt_passing">
                              </div>
                            </div>
                            
                            <!-- Maintenance -->
                            <div class="col-12 col-md-6">
                              <div class="p-1 d-flex justify-content-between">
                                <span class="text-muted fs-6">Next Maintenance: </span>
                                <span class="fw-semibold" id="v_maintenance"></span>
                                <input type="hidden" id="hid_nxt_maintenance">
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
                              <span class="fw-semibold" id="wod_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="wod_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="wod_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="wod_monthly">0.000</span>
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
                              <span class="fw-semibold" id="wd_hourly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Daily</span>
                              <span class="fw-semibold" id="wd_daily">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Weekly</span>
                              <span class="fw-semibold" id="wd_weekly">0.000</span>
                            </div>
                
                            <div class="col-6 d-flex justify-content-between">
                              <span class="text-muted fs-6">Monthly</span>
                              <span class="fw-semibold" id="wd_monthly">0.000</span>
                            </div>
                
                          </div>
                
                        </div>
                      </div>
                </div>
            
                </div>
              </div>
                    </div>
                    <div class="accordion-item mb-1 ">
                      <h2 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#bookSec">
                            Booking Details
                          </button>
                        </h2>

                      <div id="bookSec" class="accordion-collapse collapse show">
                          <div class="accordion-body">
            
                            <div class="row g-3">
            
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="datetime-local" id="b_from" class="form-control watch-field">
                                  <label>From</label>
                                </div>
                              </div>
            
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="datetime-local" id="b_to" class="form-control watch-field">
                                  <label>To</label>
                                </div>
                              </div>
                              
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <select class="rate_type form-control form-control-sm watch-field" id="rate_type" >
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
                                  <select class="service form-control form-control-sm watch-field" id="service">
                                    <option value="0">Select Service</option>
                                    <option value="1" data-id="10">Rental Without Driver</option>
                                    <option value="2" data-id="0">Rental With Driver</option>
                                  </select>
                                  <label class="form-label small">Service</label>
                                </div>
                              </div>
                                <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="b_duration" class="form-control">
                                  <label>Duration</label>
                                </div>
                              </div>
                              <div class="col-12 col-md-4">
                                
                                <div style="position:relative;" class="form-floating form-floating-outline">
                                
                                   <span class="min-price-text badge bg-danger" style="position:absolute; top:-8px; right:8px; font-size:10px; z-index:2;">
                                    Min: 0.000
                                </span>
                                    <!-- Input -->
                                    <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" class="price nav form-control form-control-sm" value="0" style="padding-top:12px;" id="price" >
                                     <label class="form-label small">Unit Price</label>
                                </div>
                                
                                <input type="hidden" class="minprice nav form-control" value="0">
                                
                                
                                </div>
                              <div class="col-12 col-md-4">
                                 <div class="form-floating form-floating-outline">
                                  <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="b_vat" class="form-control">
                                  <label>VAT %</label>
                                </div>
                                 
                                </div>
                    
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="b_total" class="form-control">
                                  <label>Total</label>
                                </div>
                              </div>
                              <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <input type="text" id="b_qtn_ref_no" class="form-control" readonly>
                                  <label>Quotation Ref. No.</label>
                                </div>
                              </div>
                              
                              <div class="col-12">
                                 <div class="form-floating form-floating-outline">
                                    <textarea class="form-control form-control-sm h-px-100" id="txt_booking_notes" name="txt_booking_notes" placeholder="Booking Notes"></textarea>
                                    <label for="Booking Notes">Booking Notes</label>
                                  </div>
                                </div>
                                
                              <div class="col-12 " id="otpdiv">
                               <div class="alert alert-info">
                                     
                                      <p class="mb-0" id="p_otp_minprice_info"></p>
                                    </div>
                            
                            </div>
        
                        </div>
        
                      </div>
                    </div>
                    </div>
                    
                     <div class="accordion-item">
            <h2 class="accordion-header fw-bold">
              <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#imgSec">
                Vehicle Images
              </button>
            </h2>

            <div id="imgSec" class="accordion-collapse collapse show">
              <div class="accordion-body">

                <input type="file" id="carImages" class="form-control mb-3" multiple accept="image/*" capture="environment">

                <div id="preview" class="d-flex flex-wrap gap-2"></div>
                
               <div class="progress mt-3" style="height:8px;">
                    <div class="progress-bar" id="globalProgressBar" style="width:0%"></div>
                </div>
                <div id="uploadLoader" class="text-center mt-2 d-none">
                    <div class="spinner-border spinner-border-sm text-primary"></div>
                    <span class="ms-2">Uploading images...</span>
                </div>
                <button id="uploadBtn" class="btn btn-primary mt-3">Upload Vehicle Images</button>
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
                      <input class="form-check-input" type="checkbox" id="chk_tools">
                      <label>Jack & Tools</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="chk_spare">
                      <label>Spare Tyre</label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="chk_radio">
                      <label>Radio</label>
                    </div>
                  </div>
                
                  <div class="col-md-6">
                     <div class="form-floating form-floating-outline mb-3">
                      <input type="date" id="dt_contract_date" class="form-control"  value="<?php echo date('Y-m-d') ?>">
                      <label>Contract Date</label>
                    </div>
                    </div>
                   
                  
                   

                </div>
                <div class="row ">
                     <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="km_out" class="form-control">
                          <label>KM Out</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="datetime-local" id="dt_out" class="form-control">
                          <label>Date Time Out</label>
                        </div>
                  </div>
                </div>
                <div class="row ">
                    
                    <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                      <input type="text" id="cust_driver" class="form-control">
                      <label>Customer Driver</label>
                    </div>

                    
                  </div>
                  <div class="col-md-6 ">
                     <div class="form-floating form-floating-outline">
                      <input type="text" id="cust_driver_contact_no" class="form-control">
                      <label>Contact Number</label>
                     </div>
                   </div>
                   <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-5 pt-1">

                        <!-- Left: Image Preview -->
                        <ul id="contractcustdriverdocpreview"
                            class="list-unstyled d-flex align-items-center avatar-group mb-0">
                        </ul>
                    
                        <!-- Right: Button -->
                        <div class="ms-auto d-flex align-items-center gap-2">

                         
            
                        <!-- Existing Add Button -->
                        <a href="javascript:;" class="openAddCustDriverDocModal">
                            <span class="badge bg-label-primary rounded-pill">
                                Customer Driver Documents
                            </span>
                        </a>
                         <button type="button"
                                id="openCameraCapture" style="display:none;"
                                class="btn btn-sm btn-outline-info rounded-pill"><i class="ri ri-camera-line"></i> Camera
                           
                        </button>
            
                    </div>
                    <!-- hidden camera input -->
                    <input type="file"
                           id="cameraCaptureInput"
                           accept="image/*"
                           capture="environment"
                           multiple
                           style="display:none;">
                    </div>
                    </div>
                </div>

              </div>
            </div>
          </div>
                    <div class="accordion-item mb-1">
                     <h1 class="accordion-header fw-bold">
                          <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#driverSec">
                            Assign Company Driver
                          </button>
                        </h1>
                     <div id="driverSec" class="accordion-collapse collapse show">
                      <div class="accordion-body">
        
                        <div class="row g-3">
                           <div class="row g-3 align-items-start">

                              <!-- LEFT: Dropdown -->
                              <div class="col-12 col-md-6">
                                <div class="form-floating form-floating-outline mb-1">
                                  <div id="dropdownContainer"></div>
                                </div>
                              </div>

                              <!-- RIGHT: Name (Top) + Contact (Bottom) -->
                              <div class="col-12 col-md-6 d-flex flex-column justify-content-between ">
                            
                                <!-- Name (Top) -->
                                <div class="p-1 d-flex justify-content-between ">
                                  <span class="text-muted fs-6 driverclass">Name:</span>
                                  <span class="fw-semibold driverclass driverClasstext" id="d_name"></span>
                                </div>
                            
                                <!-- Contact (Bottom) -->
                                <div class="p-1 d-flex justify-content-between ">
                                  <span class="text-muted fs-6 driverclass">Contact Number:</span>
                                  <span class="fw-semibold driverclass driverClasstext" id="d_mobile"></span>
                                </div>
                            
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
                      <button id="btn_terms_condition" class="btn btn-primary mt-3"><span class="ri ri-save-line icon-18px"></span>
                                        &nbsp;&nbsp;Terms & Condition</button>
                    </div>
            <!-- /Full Editor -->
            <!--<button type="button"-->
            <!--                            name="btn_terms_condition" value="btn_terms_condition"-->
            <!--                            id="btn_terms_condition"-->
            <!--                            class="btn btn-sm btn-info waves-effect waves-light">-->
            <!--                            <span class="ri ri-save-line icon-18px"></span>-->
            <!--                            &nbsp;&nbsp;Terms & Condition-->
            <!--                        </button>-->
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
        <button class="btn btn-success px-4 ladda-button" id="btn_save_contract"><span class="ladda-label">
        Save Contract
    </span></button>
      </div>

    </div>
  </div>
</div>