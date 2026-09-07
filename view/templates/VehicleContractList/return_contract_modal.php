<div class="modal fade" id="ReturncontractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
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

        
        <div id="returnStepper" class="bs-stepper linear">
          <div class="bs-stepper-header" role="tablist">
            <!-- Step 1 -->
            <div class="step" data-target="#tab-return-step-1">
              <button type="button" class="step-trigger" role="tab" id="return-step-1-trigger">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Customer &amp; Vehicle</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <!-- Step 2 -->
            <div class="step" data-target="#tab-return-step-2">
              <button type="button" class="step-trigger" role="tab" id="return-step-2-trigger">
                <span class="bs-stepper-circle">2</span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Checklist &amp; Driver</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <!-- Step 3 -->
            <div class="step" data-target="#tab-return-step-3">
              <button type="button" class="step-trigger" role="tab" id="return-step-3-trigger">
                <span class="bs-stepper-circle">3</span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Return Images</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <!-- Step 4 -->
            <div class="step" data-target="#tab-return-step-4">
              <button type="button" class="step-trigger" role="tab" id="return-step-4-trigger">
                <span class="bs-stepper-circle">4</span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Violations</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <!-- Step 5 -->
            <div class="step" data-target="#tab-return-step-5">
              <button type="button" class="step-trigger" role="tab" id="return-step-5-trigger">
                <span class="bs-stepper-circle">5</span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Other Fees</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <!-- Step 6 -->

            <div class="step" data-target="#tab-return-step-6">
              <button type="button" class="step-trigger" role="tab" id="return-step-6-trigger">
                <span class="bs-stepper-circle">6</span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Signature</span>
                </span>
              </button>
            </div>
          </div>

          <div class="bs-stepper-content">
            <!-- Step 1 -->
            <div id="tab-return-step-1" class="content">
              <style>
                .return-info-card { background: #fff5f5; border: 1px solid #f5c6c6; border-radius: 8px; padding: 14px; }
                .return-info-card .section-title { color: #c0392b; font-weight: 700; font-size: 0.9rem; margin-bottom: 10px; }
                .return-field-label { color: #888; font-size: 0.75rem; margin-bottom: 1px; }
                .return-field-value { font-weight: 600; font-size: 0.88rem; color: #222; }
                .pricing-setup-title { color: #c0392b; font-weight: 700; font-size: 0.9rem; margin-bottom: 8px; }
                /* Pricing block columns */
                .pricing-col { flex: 1; border: 1px solid #eee; border-radius: 4px; overflow: hidden; }
                .pricing-col-header { background: #f5f5f5; text-align: center; font-weight: 700; font-size: 0.82rem; color: #444; padding: 7px 4px; border-bottom: 1px solid #eee; }
                .pricing-col-row { display: flex; justify-content: space-between; align-items: center; padding: 5px 10px; font-size: 0.82rem; border-bottom: 1px solid #f5f5f5; }
                .pricing-col-row:last-child { border-bottom: none; }
                .pricing-col-row .p-label { color: #666; }
                .pricing-col-row .p-value { font-weight: 700; color: #27ae60; }
                /* Vehicle mini-slider */
                .return-v-slider { width: 90px; height: 70px; flex-shrink: 0; border-radius: 6px; overflow: hidden; position: relative; background: #ddd; }
                .return-v-slider img { width: 100%; height: 100%; object-fit: cover; position: absolute; top:0; left:0; transition: opacity 0.4s; }
                .return-v-slider .slider-dot-wrap { position: absolute; bottom: 3px; left: 0; right: 0; display: flex; justify-content: center; gap: 3px; }
                .return-v-slider .slider-dot { width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.6); cursor: pointer; transition: background 0.2s; }
                .return-v-slider .slider-dot.active { background: #fff; }
                .return-v-slider .slider-arrow { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.4); color: #fff; border: none; padding: 0 4px; font-size: 10px; line-height: 18px; cursor: pointer; border-radius: 2px; display: none; }
                .return-v-slider:hover .slider-arrow { display: block; }
                .return-v-slider .slider-arrow.prev { left: 1px; }
                .return-v-slider .slider-arrow.next { right: 1px; }
              </style>

              <!-- Row 1: Customer + Vehicle cards -->
              <div class="row g-3 mb-3">
                <!-- Customer Details -->
                <div class="col-12 col-md-6">
                  <div class="return-info-card h-100">
                    <div class="section-title">Customer Details</div>
                    <div class="row g-2">
                      <div class="col-6">
                        <div class="return-field-label">Customer Name</div>
                        <div class="return-field-value" id="return_c_name">-</div>
                      </div>
                      <div class="col-6">
                        <div class="return-field-label">Customer Code</div>
                        <div class="return-field-value" id="return_c_code">-</div>
                      </div>
                      <div class="col-6">
                        <div class="return-field-label">Contact Number</div>
                        <div class="return-field-value" id="return_c_mobile">-</div>
                      </div>
                      <div class="col-6">
                        <div class="return-field-label">Email</div>
                        <div class="return-field-value" id="return_c_email">-</div>
                      </div>
                      <div class="col-12">
                        <div class="return-field-label">Attn &amp; Address</div>
                        <div class="return-field-value"><span id="return_c_attn"></span><span id="return_c_attr"></span></div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Vehicle Details -->
                <div class="col-12 col-md-6">
                  <div class="return-info-card h-100">
                    <div class="section-title">Vehicle Details</div>
                    <div class="d-flex gap-3 align-items-start">
                      <!-- Mini Slider -->
                      <div class="return-v-slider" id="returnVSlider">
                        <img id="returnVSliderImg" src="uploads/vehicleImages/default.jpg" alt="Vehicle">
                        <button class="slider-arrow prev" id="returnVSliderPrev">&#8249;</button>
                        <button class="slider-arrow next" id="returnVSliderNext">&#8250;</button>
                        <div class="slider-dot-wrap" id="returnVSliderDots"></div>
                      </div>
                      <!-- Info grid -->
                      <div class="row g-2 flex-grow-1">
                        <div class="col-6">
                          <div class="return-field-label">Category</div>
                          <div class="return-field-value" id="return_v_category">-</div>
                        </div>
                        <div class="col-6">
                          <div class="return-field-label">Model</div>
                          <div class="return-field-value" id="return_v_model">-</div>
                        </div>
                        <div class="col-6">
                          <div class="return-field-label">Vehicle No</div>
                          <div class="return-field-value" id="return_v_no">-</div>
                        </div>
                        <div class="col-6">
                          <div class="return-field-label">Chassis No</div>
                          <div class="return-field-value" id="return_v_chassis">-</div>
                        </div>
                        <div class="col-6">
                          <div class="return-field-label">Color / Year</div>
                          <div class="return-field-value"><span id="return_v_color">-</span> / <span id="return_v_year">-</span></div>
                        </div>
                        <div class="col-6">
                          <div class="return-field-label">Next Ins. / Pass.</div>
                          <div class="return-field-value">
                            <span id="return_v_insurance">-</span>
                            <input type="hidden" id="return_hid_nxt_insurance">
                            <input type="hidden" id="return_hid_nxt_passing">
                            <input type="hidden" id="return_hid_nxt_maintenance">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              
              <hr>
              <h5 class="mb-3 fw-bold text-danger">Bookings & Extensions</h5>

            
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
        
                 
              
              <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-next">Next <i class="ri-arrow-right-line ms-1"></i></button>
              </div>
            </div>

            <!-- Step 2 -->
            <div id="tab-return-step-2" class="content">
              <h5 class="mb-3 fw-bold text-danger">Vehicle Rentout Images</h5>

               

                <div id="preview" class="d-flex flex-wrap gap-2"></div>
                
               
         
              <hr>
                            <h5 class="mb-3 fw-bold text-danger">Vehicle Checklist & Rentout Details</h5>
              <div class="return-info-card mb-4">
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
                      <input type="date" id="dt_contract_date" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>
                      <label>Contract Date</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                     <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text" id="fuel_level" class="form-control" readonly>
                          <label>Fuel Level</label>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="text" id="km_out" class="form-control" readonly>
                          <label>Rentout Odometer Reading</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-3">
                          <input type="datetime-local" id="dt_out" class="form-control" readonly>
                          <label>Date Time Out</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                      <input type="text" id="cust_driver" class="form-control" readonly>
                      <label>Customer Driver</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-floating form-floating-outline mb-3">
                      <input type="text" id="cust_driver_contact_no" class="form-control" readonly>
                      <label>Contact Number</label>
                     </div>
                   </div>
                   <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-2">
                        <ul id="contractcustdriverdocpreview" class="list-unstyled d-flex align-items-center avatar-group mb-0"></ul>
                    </div>
                   </div>
                </div>
              </div>

              <h5 class="mb-3 fw-bold text-primary">Return Details (To Fill)</h5>
              <div class="row mb-4">
                  <div class="col-md-4">
                      <div class="form-floating form-floating-outline mb-3">
                        <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,''); calcOdoDiff();" id="km_in" class="form-control border-primary" required>
                        <label>Return Odometer Reading <span class="text-danger">*</span></label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-floating form-floating-outline mb-3">
                        <input type="text" id="odo_diff" class="form-control bg-light" readonly>
                        <label>Odometer Difference</label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-floating form-floating-outline mb-3">
                        <input type="datetime-local" id="dt_in" class="form-control border-primary" required>
                        <label>Date Time In <span class="text-danger">*</span></label>
                      </div>
                  </div>
              </div>

              <div id="company_driver_section">
                <hr>
                <h5 class="mb-3 fw-bold text-danger">Company Driver Details</h5>
                <div class="return-info-card mb-4">
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
<div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary btn-prev"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                <button type="button" class="btn btn-primary btn-next">Next <i class="ri-arrow-right-line ms-1"></i></button>
              </div>
            </div>

            <!-- Step 3 -->
            <div id="tab-return-step-3" class="content">
              <h5 class="mb-3 fw-bold text-danger">Vehicle Return Images</h5>

            
                            <input type="file" id="returncarImages" class="form-control mb-3" multiple accept="image/*" capture="environment">
            
                            <div id="returnpreview" class="d-flex flex-wrap gap-2"></div>
              <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary btn-prev"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                <button type="button" class="btn btn-primary btn-next">Next <i class="ri-arrow-right-line ms-1"></i></button>
              </div>
            </div>

            <!-- Step 4 -->
            <div id="tab-return-step-4" class="content">
              <h5 class="mb-3 fw-bold text-danger">Vehicle Violations</h5>

                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                    <div>
                                        <a href="https://services.bahrain.bh" target="_blank" rel="noopener noreferrer" class="text-primary fw-bold text-decoration-underline d-inline-flex align-items-center gap-1">
                                            Check Traffic Violations on services.bahrain.bh <i class="ri ri-external-link-line fs-5 ms-1"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn_add_violation_head_master">
                                            <i class="ri-add-line me-1"></i> Add Master
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary" id="btn_add_violation_row">
                                            <i class="ri-add-line me-1"></i> Add Violation
                                        </button>
                                    </div>
                                </div>
                                <datalist id="violation_heads_list"></datalist>

                               <div class="table-responsive">
                                    <table class="table table-bordered align-middle table-sm" id="table_violations">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="20%">Violation Date</th>
                                                <th width="30%">Violation Title</th>
                                                <th width="15%">Fees</th>
                                                <th width="20%">Remarks</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                       <tbody id="violations_tbody">
                                           <!-- Dynamic rows will be added here -->
                                       </tbody>
                                   </table>
                               </div>

                               <div class="form-check mt-3">
                                   <input class="form-check-input" type="checkbox" id="chk_violations_checked">
                                   <label class="form-check-label fw-bold text-danger" for="chk_violations_checked">
                                       I confirm that vehicle violations have been checked on services.bahrain.bh
                                   </label>
                               </div>
                      
                            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary btn-prev"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                <button type="button" class="btn btn-primary btn-next">Next <i class="ri-arrow-right-line ms-1"></i></button>
              </div>
            </div>
            <!-- Step 5 -->
            <div id="tab-return-step-5" class="content">
              <h5 class="mb-3 fw-bold text-danger">Other Fees Entries</h5>


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
              <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary btn-prev"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                <button type="button" class="btn btn-primary btn-next">Next <i class="ri-arrow-right-line ms-1"></i></button>
              </div>
            </div>

            <!-- Step 6 -->
            <div id="tab-return-step-6" class="content">
              <h5 class="mb-3 fw-bold text-danger">Receiver Signature</h5>

            
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
              <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary btn-prev"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                <button type="button" class="btn btn-success px-4 ladda-button" id="btn_return_contract"><span class="ladda-label">Return Contract</span></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Add New Violation Head Master -->
<div class="modal fade" id="modalAddViolationHead" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Violation Head</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="new_violation_head_name" placeholder="Enter Violation Head Name">
                    <label for="new_violation_head_name">Violation Head Name</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary" id="btn_save_violation_head">Save Head</button>
            </div>
        </div>
    </div>
</div>