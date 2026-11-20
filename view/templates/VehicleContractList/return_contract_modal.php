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
          <input type="hidden" value="" id="txt_return_modal_booking_ref_no">
          
          <input type="hidden" value="" id="return_hid_vehicle_id">
          <input type="hidden" value="" id="return_hid_category_id">
          <input type="hidden" value="" id="return_hid_model_id">
          <input type="hidden" value="" id="return_hid_vehicle_no">

          <div class="d-none">
            <span id="return_wod_hourly">0.000</span>
            <span id="return_wd_hourly">0.000</span>
            <span id="return_wod_daily">0.000</span>
            <span id="return_wd_daily">0.000</span>
            <span id="return_wod_weekly">0.000</span>
            <span id="return_wd_weekly">0.000</span>
            <span id="return_wod_monthly">0.000</span>
            <span id="return_wd_monthly">0.000</span>
          </div>
         
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
                  <span class="bs-stepper-title">Checklist, Driver &amp; Images</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <!-- Step 3 (Violations & Other Fees) -->
            <div class="step" data-target="#tab-return-step-4">
              <button type="button" class="step-trigger" role="tab" id="return-step-4-trigger">
                <span class="bs-stepper-circle">3</span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Violations &amp; Other Fees</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <!-- Step 4 (Signature) -->
            <div class="step" data-target="#tab-return-step-6">
              <button type="button" class="step-trigger" role="tab" id="return-step-6-trigger">
                <span class="bs-stepper-circle">4</span>
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
                .return-info-card { background: #f4f7fe; border: 1px solid #cbd7f6; border-radius: 8px; padding: 14px; }
                .return-info-card .section-title { color: #1b3d94; font-weight: 700; font-size: 0.9rem; margin-bottom: 10px; }
                .return-field-label { color: #888; font-size: 0.75rem; margin-bottom: 1px; }
                .return-field-value { font-weight: 600; font-size: 0.88rem; color: #222; }
                .pricing-setup-title { color: #1b3d94; font-weight: 700; font-size: 0.9rem; margin-bottom: 8px; }
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

              
              <hr class="my-4">
              
              <!-- Vehicle Return Date & Coverage Check Bar -->
              <div class="card mb-3 border-danger shadow-none" style="background: #fff8f8; border-radius: 8px;">
                <div class="card-body p-3">
                  <div class="row align-items-center g-3">
                    <div class="col-12 col-md-5">
                      <label class="form-label fw-bold text-dark mb-1" for="return_vehicle_date_in">
                        <i class="ri-calendar-check-line text-danger me-1"></i> Vehicle Return Date &amp; Time <span class="text-danger">*</span>
                      </label>
                      <input type="datetime-local" id="return_vehicle_date_in" class="form-control border-danger fw-bold">
                    </div>
                    <div class="col-12 col-md-7">
                      <div id="return_coverage_status_badge" class="pt-md-4">
                        <!-- Dynamic coverage badge will be rendered here -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0 fw-bold" style="color: #1b3d94;">Original Contract Details</h5>
                <small class="text-muted"><i class="ri-file-text-line me-1"></i>Agreed contract &amp; coverage summary</small>
              </div>

              <div id="original_contract_details_box" class="card mb-3 shadow-sm" style="border: 1px solid #dbe3f3; background: #ffffff; border-radius: 8px;">
                <div class="card-body p-3">
                  <div class="row g-2 small">
                    <div class="col-md-4">
                      <span class="text-muted d-block">Full Contract Period</span>
                      <strong id="orig_full_period">-</strong>
                    </div>
                    <div class="col-md-3">
                      <span class="text-muted d-block">Service Type</span>
                      <strong id="orig_service_type">-</strong>
                    </div>
                    <div class="col-md-2">
                      <span class="text-muted d-block">Rate Type &amp; Price</span>
                      <strong id="orig_rate_info">-</strong>
                    </div>
                    <div class="col-md-3">
                      <span class="text-muted d-block">VAT % / Contract Value</span>
                      <strong style="color: #1b3d94;"><span id="orig_vat_pct">0</span>% | <span id="orig_contract_value">0.000</span> BHD</strong>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Overdue / Extended Period Area (Auto-calculated when return date exceeds coverage) -->
              <div id="return_balance_extension_area" class="card mb-3 shadow-sm" style="display: none; border: 1px solid #f59e0b; background: #fffdf5; border-radius: 8px;">
                <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background: #fef3c7; border-bottom: 1px solid #fde68a;">
                  <h6 class="mb-0 fw-bold text-dark">
                    <i class="ri-calendar-event-line text-warning me-1"></i> Overdue Period Details
                  </h6>
                  <span class="badge bg-danger fs-7" id="return_balance_days_badge">0 Days Overdue</span>
                </div>
                <div class="card-body p-3">
                  <!-- Clean Summary Row (matches Original Contract Details) -->
                  <div class="row g-2 small mb-3">
                    <div class="col-md-4">
                      <span class="text-muted d-block">Overdue Period</span>
                      <strong id="ov_sum_period">-</strong>
                    </div>
                    <div class="col-md-3">
                      <span class="text-muted d-block">Overdue Days / Duration</span>
                      <strong id="ov_sum_duration">-</strong>
                    </div>
                    <div class="col-md-2">
                      <span class="text-muted d-block">Rate Type &amp; Price</span>
                      <strong id="ov_sum_rate">-</strong>
                    </div>
                    <div class="col-md-3">
                      <span class="text-muted d-block">VAT % / Overdue Value</span>
                      <strong class="text-danger"><span id="ov_sum_vat_pct">0</span>% (<span id="ov_sum_vat_amt">0.000</span>) | <span id="ov_sum_total">0.000</span> BHD</strong>
                    </div>
                  </div>

                  <!-- Controls Row: Waive Off (with Remarks) & Change Overdue Value (No / Yes) -->
                  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-2 rounded" style="background: rgba(255, 193, 7, 0.14); border: 1px dashed #f59e0b;">
                    <div class="d-flex align-items-center gap-3">
                      <span class="small fw-bold text-dark">Waive Off Overdue Value?</span>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="ret_overdue_waive_mode" id="ret_overdue_waive_no" value="no" checked>
                        <label class="form-check-label small fw-semibold" for="ret_overdue_waive_no">No</label>
                      </div>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="ret_overdue_waive_mode" id="ret_overdue_waive_yes" value="yes">
                        <label class="form-check-label small fw-semibold text-danger" for="ret_overdue_waive_yes">Yes</label>
                      </div>
                      <input type="checkbox" id="chk_ext_zero_amount" class="d-none">
                    </div>

                    <div class="d-flex align-items-center gap-3" id="ret_change_overdue_wrap">
                      <span class="small fw-bold text-dark">Change Overdue Value?</span>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="ret_overdue_edit_mode" id="ret_overdue_edit_no" value="no" checked>
                        <label class="form-check-label small fw-semibold" for="ret_overdue_edit_no">No</label>
                      </div>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="ret_overdue_edit_mode" id="ret_overdue_edit_yes" value="yes">
                        <label class="form-check-label small fw-semibold" style="color: #1b3d94;" for="ret_overdue_edit_yes">Yes</label>
                      </div>
                    </div>
                  </div>

                  <!-- Waive Off Remarks (shown only when Waive Off = Yes) -->
                  <div id="ret_waive_remarks_area" class="mt-3" style="display: none;">
                    <label class="form-label small mb-1 fw-semibold text-danger">Waive Off Remarks <span class="text-danger">*</span></label>
                    <input type="text" id="ret_waive_remarks" class="form-control form-control-sm" placeholder="Enter reason for waiving off overdue value...">
                  </div>

                  <!-- Editable Overdue Fields (shown only when Change Overdue Value = Yes) -->
                  <div id="ret_overdue_edit_fields" class="row g-3 mt-1" style="display: none;">
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Overdue From</label>
                      <input type="datetime-local" id="ret_ext_from" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Overdue To (Return Date)</label>
                      <input type="datetime-local" id="ret_ext_to" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Service</label>
                      <select class="form-select form-select-sm" id="ret_ext_service">
                        <option value="1" data-vat="10">Rental Without Driver</option>
                        <option value="2" data-vat="0">Rental With Driver</option>
                      </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Rate Type</label>
                      <select class="form-select form-select-sm" id="ret_ext_rate_type">
                        <option value="day" selected>Daily</option>
                        <option value="hour">Hourly</option>
                        <option value="week">Weekly</option>
                        <option value="month">Monthly</option>
                      </select>
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">
                      <label class="form-label small mb-1 fw-semibold">Overdue Days</label>
                      <input type="number" id="ret_ext_duration" class="form-control form-control-sm" min="1" step="1">
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">
                      <label class="form-label small mb-1 fw-semibold">Rate / Price (BHD)</label>
                      <input type="text" id="ret_ext_unit_price" class="form-control form-control-sm" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">
                      <label class="form-label small mb-1 fw-semibold">VAT %</label>
                      <input type="text" id="ret_ext_vat" class="form-control form-control-sm" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" value="10">
                    </div>
                    <div class="col-6 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">VAT Amount (BHD)</label>
                      <input type="text" id="ret_ext_vat_amount" class="form-control form-control-sm bg-light fw-semibold" readonly value="0.000">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Overdue Value (BHD)</label>
                      <input type="text" id="ret_ext_total" class="form-control form-control-sm bg-light fw-bold text-danger" readonly value="0.000">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Early Return Area (Shown when vehicle returns before covered end date) -->
              <div id="return_early_reduction_area" class="card mt-3 shadow-sm" style="display: none; border: 1px solid #93c5fd; background: #f4f7fe; border-radius: 8px;">
                <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background: #e8eefc; border-bottom: 1px solid #cbd7f6;">
                  <h6 class="mb-0 fw-bold" style="color: #1b3d94;">
                    <i class="ri-information-line me-1"></i> Early Return Notice
                  </h6>
                  <span class="badge bg-primary fs-7" id="return_early_days_badge">0 Days Left</span>
                </div>
                <div class="card-body p-3">
                  <div class="alert alert-primary py-2 px-3 mb-3 small d-flex align-items-center" id="return_early_info_msg" style="background: #eef3fc; border-color: #b8c8f5; color: #1b3d94;">
                    <i class="ri-information-line fs-5 me-2 flex-shrink-0"></i>
                    <div>
                      <strong>Early Return Detected:</strong> This vehicle is being returned before the covered contract/extension end date. No deduction is applied by default.
                    </div>
                  </div>
                  
                  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-2 rounded" style="background: rgba(27, 61, 148, 0.06); border: 1px dashed #1b3d94;">
                    <div class="d-flex align-items-center gap-3">
                      <span class="small fw-bold text-dark">Include Early Return Deduction?</span>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="ret_early_deduct_mode" id="ret_early_deduct_no" value="no" checked>
                        <label class="form-check-label small fw-semibold" for="ret_early_deduct_no">No</label>
                      </div>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="ret_early_deduct_mode" id="ret_early_deduct_yes" value="yes">
                        <label class="form-check-label small fw-semibold text-danger" for="ret_early_deduct_yes">Yes</label>
                      </div>
                      <input type="checkbox" id="chk_early_zero_amount" class="d-none" checked>
                    </div>
                    <small class="text-muted">Select Yes to calculate and deduct unused days</small>
                  </div>

                  <div id="ret_early_edit_fields" class="row g-3 mt-1" style="display: none;">
                    <!-- Return Date (From) -->
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Return Date (From) <span class="text-danger">*</span></label>
                      <input type="datetime-local" id="ret_early_from" class="form-control form-control-sm">
                    </div>

                    <!-- Contract End Date (To) -->
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Covered End Date (To) <span class="text-danger">*</span></label>
                      <input type="datetime-local" id="ret_early_to" class="form-control form-control-sm">
                    </div>

                    <!-- Service Selection -->
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Service <span class="text-danger">*</span></label>
                      <select class="form-select form-select-sm" id="ret_early_service">
                        <option value="1" data-vat="10">Rental Without Driver</option>
                        <option value="2" data-vat="0">Rental With Driver</option>
                      </select>
                    </div>

                    <!-- Rate Type Selection -->
                    <div class="col-12 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Rate Type <span class="text-danger">*</span></label>
                      <select class="form-select form-select-sm" id="ret_early_rate_type">
                        <option value="day" selected>Daily</option>
                        <option value="hour">Hourly</option>
                        <option value="week">Weekly</option>
                        <option value="month">Monthly</option>
                      </select>
                    </div>

                    <!-- Days / Duration Left -->
                    <div class="col-6 col-sm-4 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Days Left <span class="text-danger">*</span></label>
                      <input type="number" id="ret_early_duration" class="form-control form-control-sm" min="0" step="1">
                    </div>

                    <!-- Unit Rate -->
                    <div class="col-6 col-sm-4 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Rate / Price (BHD) <span class="text-danger">*</span></label>
                      <input type="text" id="ret_early_unit_price" class="form-control form-control-sm" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                    </div>

                    <!-- VAT % -->
                    <div class="col-6 col-sm-4 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">VAT %</label>
                      <input type="text" id="ret_early_vat" class="form-control form-control-sm" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" value="10">
                    </div>

                    <!-- Total Reduced Amount -->
                    <div class="col-6 col-sm-6 col-md-3">
                      <label class="form-label small mb-1 fw-semibold">Deducted Amount (BHD)</label>
                      <input type="text" id="ret_early_total" class="form-control form-control-sm bg-light fw-bold text-danger" readonly value="0.000">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Prominent Total Summary Bar -->
              <div id="return_financial_summary_box" class="card mt-3 shadow" style="border: 2px solid #1b3d94; background: linear-gradient(135deg, #f4f7fe, #ffffff); border-radius: 10px;">
                <div class="card-body py-3 px-3">
                  <div class="row text-center g-2 align-items-center">
                    <div class="col-md-3 border-end">
                      <div class="small text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Contract Period</div>
                      <div class="fw-bold small mt-1" id="ret_sum_full_period">-</div>
                    </div>
                    <div class="col-md-3 border-end">
                      <div class="small text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Contract Value</div>
                      <div class="fw-bold fs-5 mt-1" style="color: #1b3d94;"><span id="ret_sum_agreed_total">0.000</span> <small>BHD</small></div>
                    </div>
                    <div class="col-md-3 border-end">
                      <div class="small text-muted text-uppercase fw-semibold" style="font-size: 11px;" id="ret_sum_third_label">Total Overdue</div>
                      <div class="fw-bold fs-5 text-danger mt-1"><span id="ret_sum_overdue_total">0.000</span> <small>BHD</small></div>
                    </div>
                    <div class="col-md-3">
                      <div class="small text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total</div>
                      <div class="fw-bolder fs-4 text-success mt-1"><span id="ret_sum_grand_total">0.000</span> <small>BHD</small></div>
                    </div>
                  </div>
                </div>
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
              <h6 class="mb-2 fw-bold text-uppercase" style="color: #1b3d94; font-size: 12px; letter-spacing: 0.4px;">Vehicle Checklist &amp; Rentout Details</h6>
              <div class="mb-3 px-3 py-2 rounded border" style="background: #f8faff; border-color: #dbe3f3 !important;">
                <input type="hidden" id="dt_contract_date" value="<?php echo date('Y-m-d') ?>">
                <input type="hidden" id="fuel_level" value="">
                <input type="hidden" id="km_out" value="">
                <input type="hidden" id="dt_out" value="">
                <input type="hidden" id="cust_driver" value="">
                <input type="hidden" id="cust_driver_contact_no" value="">

                <div class="row g-2 align-items-start" style="font-size: 12.5px;">
                  <div class="col-md-5">
                    <span class="d-block text-uppercase fw-semibold" style="font-size: 10.5px; color: #64748b;">Rentout Checklist</span>
                    <div class="d-flex flex-wrap gap-3 mt-1">
                      <div class="form-check form-check-inline mb-0 me-1">
                        <input class="form-check-input" type="checkbox" id="chk_tools" disabled style="opacity: 1;">
                        <label class="form-check-label fw-semibold" style="color: #1e293b; opacity: 1;">Tools Kit</label>
                      </div>
                      <div class="form-check form-check-inline mb-0 me-1">
                        <input class="form-check-input" type="checkbox" id="chk_spare" disabled style="opacity: 1;">
                        <label class="form-check-label fw-semibold" style="color: #1e293b; opacity: 1;">S. Wheel</label>
                      </div>
                      <div class="form-check form-check-inline mb-0 me-1">
                        <input class="form-check-input" type="checkbox" id="chk_wcup" disabled style="opacity: 1;">
                        <label class="form-check-label fw-semibold" style="color: #1e293b; opacity: 1;">W. Cup</label>
                      </div>
                      <div class="form-check form-check-inline mb-0 me-1">
                        <input class="form-check-input" type="checkbox" id="chk_radio" disabled style="opacity: 1;">
                        <label class="form-check-label fw-semibold" style="color: #1e293b; opacity: 1;">Radio</label>
                      </div>
                      <div class="form-check form-check-inline mb-0 me-1">
                        <input class="form-check-input" type="checkbox" id="chk_scratches" disabled style="opacity: 1;">
                        <label class="form-check-label fw-semibold" style="color: #1e293b; opacity: 1;">Scratches Mark X</label>
                      </div>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="checkbox" id="chk_seats" disabled style="opacity: 1;">
                        <label class="form-check-label fw-semibold" style="color: #1e293b; opacity: 1;">Seats Cleanness</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 col-md-2">
                    <span class="d-block text-uppercase fw-semibold" style="font-size: 10.5px; color: #64748b;">Rentout Date</span>
                    <strong style="color: #1e293b;" id="disp_dt_out">-</strong>
                  </div>
                  <div class="col-6 col-md-1">
                    <span class="d-block text-uppercase fw-semibold" style="font-size: 10.5px; color: #64748b;">Fuel</span>
                    <strong style="color: #1e293b;" id="disp_fuel_level">-</strong>
                  </div>
                  <div class="col-6 col-md-1">
                    <span class="d-block text-uppercase fw-semibold" style="font-size: 10.5px; color: #64748b;">KM Out</span>
                    <strong style="color: #1e293b;" id="disp_km_out">-</strong>
                  </div>
                  <div class="col-6 col-md-3">
                    <span class="d-block text-uppercase fw-semibold" style="font-size: 10.5px; color: #64748b;">Customer Driver / Other Driver</span>
                    <strong style="color: #1e293b;"><span id="disp_cust_driver">-</span> <span class="text-muted fw-normal">|</span> <span id="disp_cust_driver_contact_no">-</span></strong>
                    <div class="small text-muted" style="font-size: 11px;">CPR: <span id="disp_cust_driver_cpr">-</span> <span class="mx-1">|</span> Phone: <span id="disp_cust_driver_phone">-</span></div>
                  </div>
                </div>
                <ul id="contractcustdriverdocpreview" class="list-unstyled d-flex align-items-center avatar-group mb-0 mt-1"></ul>
              </div>

              <h6 class="mb-2 fw-bold text-uppercase" style="color: #1b3d94; font-size: 12px; letter-spacing: 0.4px;">Return Details (To Fill)</h6>
              <div class="row g-3 mb-3">
                  <div class="col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,''); calcOdoDiff();" id="km_in" class="form-control border-primary" required>
                        <label>Return Odometer Reading <span class="text-danger">*</span></label>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="odo_diff" class="form-control fw-bold" style="background-color: #f8faff; border: 1px solid #cbd5e1; color: #1b3d94;" readonly>
                        <label>Odometer Difference</label>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="datetime-local" id="dt_in" class="form-control border-primary" required>
                        <label>Date Time In <span class="text-danger">*</span></label>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="return_fuel_level" list="return_fuel_levels_list" class="form-control border-primary" placeholder="E - F">
                        <datalist id="return_fuel_levels_list">
                          <option value="Empty (E)">
                          <option value="1/4">
                          <option value="1/2">
                          <option value="3/4">
                          <option value="Full (F)">
                        </datalist>
                        <label>Return Fuel (E–F)</label>
                      </div>
                  </div>
              </div>

              <div class="p-3 mb-3 rounded border" style="background-color: #f8faff; border-color: #dbe4ff !important;">
                <span class="d-block text-uppercase fw-semibold mb-2" style="font-size: 10.5px; color: #1b3d94;">Return Checklist (IN)</span>
                <div class="d-flex flex-wrap gap-3 mb-2">
                  <div class="form-check form-check-inline mb-0">
                    <input class="form-check-input" type="checkbox" id="ret_chk_tools">
                    <label class="form-check-label fw-semibold" for="ret_chk_tools">Tools Kit</label>
                  </div>
                  <div class="form-check form-check-inline mb-0">
                    <input class="form-check-input" type="checkbox" id="ret_chk_spare">
                    <label class="form-check-label fw-semibold" for="ret_chk_spare">S. Wheel</label>
                  </div>
                  <div class="form-check form-check-inline mb-0">
                    <input class="form-check-input" type="checkbox" id="ret_chk_wcup">
                    <label class="form-check-label fw-semibold" for="ret_chk_wcup">W. Cup</label>
                  </div>
                  <div class="form-check form-check-inline mb-0">
                    <input class="form-check-input" type="checkbox" id="ret_chk_radio">
                    <label class="form-check-label fw-semibold" for="ret_chk_radio">Radio</label>
                  </div>
                  <div class="form-check form-check-inline mb-0">
                    <input class="form-check-input" type="checkbox" id="ret_chk_scratches">
                    <label class="form-check-label fw-semibold" for="ret_chk_scratches">Scratches Mark X</label>
                  </div>
                  <div class="form-check form-check-inline mb-0">
                    <input class="form-check-input" type="checkbox" id="ret_chk_seats">
                    <label class="form-check-label fw-semibold" for="ret_chk_seats">Seats Cleanness</label>
                  </div>
                </div>
                <div class="row g-2 align-items-center mt-1">
                  <div class="col-md-7">
                    <input type="text" id="return_note" class="form-control form-control-sm" placeholder="Return Note / Remarks...">
                  </div>
                  <div class="col-md-5">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox" id="ret_survey_confirmed" checked>
                      <label class="form-check-label small text-muted" for="ret_survey_confirmed">
                        I surveyed the car and didn't find any other damages.
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <h6 class="mb-2 fw-bold text-uppercase" style="color: #1b3d94; font-size: 12px; letter-spacing: 0.4px;">Vehicle Return Images</h6>
              <input type="file" id="returncarImages" class="form-control mb-3" multiple accept="image/*" capture="environment">
              <div id="returnpreview" class="d-flex flex-wrap gap-2 mb-3"></div>

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

                               <div class="form-check mt-3 mb-4">
                                   <input class="form-check-input" type="checkbox" id="chk_violations_checked">
                                   <label class="form-check-label fw-bold text-danger" for="chk_violations_checked">
                                       I confirm that vehicle violations have been checked on services.bahrain.bh
                                   </label>
                               </div>

              <hr class="my-3">

              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0 fw-bold" style="color: #1b3d94;">Other Fees Entries</h5>
                <button type="button" class="btn btn-sm btn-primary" id="add_other_fee_row">
                  <i class="ri-add-line me-1"></i> Add New
                </button>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered align-middle table-sm">
                  <thead class="table-light">
                    <tr>
                      <th width="5%">#</th>
                      <th width="30%">Fee Item</th>
                      <th width="15%">Price</th>
                      <th width="15%">Actual Amount</th>
                      <th width="25%">Remarks</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tbody id="other_fee_tbody"></tbody>
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

<!-- Modal: Confirm Return Balance Extension -->
<div class="modal fade" id="confirmReturnExtensionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-body text-center p-4">
        <div class="mb-3">
          <i class="ri-calendar-check-line text-success" style="font-size: 40px;"></i>
        </div>
        <h6 class="fw-bold mb-2">Confirm Extension</h6>
        <div id="confirmReturnExtensionMessage" class="mb-3 small text-muted">
          Extend contract and create ledger posting?
        </div>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="btnConfirmReturnExtensionYes" class="btn btn-success btn-sm px-3">Yes, Confirm &amp; Post</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Confirm Early Return Reduction -->
<div class="modal fade" id="confirmEarlyReductionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-body text-center p-4">
        <div class="mb-3">
          <i class="ri-refund-2-line text-danger" style="font-size: 40px;"></i>
        </div>
        <h6 class="fw-bold mb-2">Confirm Early Return Credit</h6>
        <div id="confirmEarlyReductionMessage" class="mb-3 small text-muted">
          Post credit reduction to customer ledger?
        </div>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="btnConfirmEarlyReductionYes" class="btn btn-danger btn-sm px-3">Yes, Post Credit</button>
        </div>
      </div>
    </div>
  </div>
</div>