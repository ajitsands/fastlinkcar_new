<div class="modal fade" id="extendcontractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
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
      
      
      <div class="modal-body p-3">
              <style>
                .extend-info-card { background: #f4f7fe; border: 1px solid #cbd7f6; border-radius: 8px; padding: 14px; }
                .extend-info-card .section-title { color: #1b3d94; font-weight: 700; font-size: 0.9rem; margin-bottom: 10px; }
                .extend-field-label { color: #888; font-size: 0.75rem; margin-bottom: 1px; }
                .extend-field-value { font-weight: 600; font-size: 0.88rem; color: #222; }
                .pricing-setup-title { color: #1b3d94; font-weight: 700; font-size: 0.9rem; margin-bottom: 8px; }
                /* Pricing block columns */
                .pricing-col { flex: 1; border: 1px solid #eee; border-radius: 4px; overflow: hidden; }
                .pricing-col-header { background: #f5f5f5; text-align: center; font-weight: 700; font-size: 0.82rem; color: #444; padding: 7px 4px; border-bottom: 1px solid #eee; }
                .pricing-col-row { display: flex; justify-content: space-between; align-items: center; padding: 5px 10px; font-size: 0.82rem; border-bottom: 1px solid #f5f5f5; }
                .pricing-col-row:last-child { border-bottom: none; }
                .pricing-col-row .p-label { color: #666; }
                .pricing-col-row .p-value { font-weight: 700; color: #27ae60; }
                /* Vehicle mini-slider */
                .extend-v-slider { width: 90px; height: 70px; flex-shrink: 0; border-radius: 6px; overflow: hidden; position: relative; background: #ddd; }
                .extend-v-slider img { width: 100%; height: 100%; object-fit: cover; position: absolute; top:0; left:0; transition: opacity 0.4s; }
                .extend-v-slider .slider-dot-wrap { position: absolute; bottom: 3px; left: 0; right: 0; display: flex; justify-content: center; gap: 3px; }
                .extend-v-slider .slider-dot { width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.6); cursor: pointer; transition: background 0.2s; }
                .extend-v-slider .slider-dot.active { background: #fff; }
                .extend-v-slider .slider-arrow { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.4); color: #fff; border: none; padding: 0 4px; font-size: 10px; line-height: 18px; cursor: pointer; border-radius: 2px; display: none; }
                .extend-v-slider:hover .slider-arrow { display: block; }
                .extend-v-slider .slider-arrow.prev { left: 1px; }
                .extend-v-slider .slider-arrow.next { right: 1px; }
              </style>

              <!-- Row 1: Customer + Vehicle cards -->
              <div class="row g-3 mb-3">
                <!-- Customer Details -->
                <div class="col-12 col-md-6">
                  <div class="extend-info-card h-100">
                    <div class="section-title">Customer Details</div>
                    <div class="row g-2">
                      <div class="col-6">
                        <div class="extend-field-label">Customer Name</div>
                        <div class="extend-field-value" id="extend_c_name">-</div>
                      </div>
                      <div class="col-6">
                        <div class="extend-field-label">Customer Code</div>
                        <div class="extend-field-value" id="extend_c_code">-</div>
                      </div>
                      <div class="col-6">
                        <div class="extend-field-label">Contact Number</div>
                        <div class="extend-field-value" id="extend_c_mobile">-</div>
                      </div>
                      <div class="col-6">
                        <div class="extend-field-label">Email</div>
                        <div class="extend-field-value" id="extend_c_email">-</div>
                      </div>
                      <div class="col-12">
                        <div class="extend-field-label">Attn &amp; Address</div>
                        <div class="extend-field-value"><span id="extend_c_attn"></span><span id="extend_c_attr"></span></div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Vehicle Details -->
                <div class="col-12 col-md-6">
                  <div class="extend-info-card h-100">
                    <div class="section-title">Vehicle Details</div>
                    <div class="d-flex gap-3 align-items-start">
                      <!-- Mini Slider -->
                      <div class="extend-v-slider" id="extendVSlider">
                        <img id="extendVSliderImg" src="uploads/vehicleImages/default.jpg" alt="Vehicle">
                        <button class="slider-arrow prev" id="extendVSliderPrev">&#8249;</button>
                        <button class="slider-arrow next" id="extendVSliderNext">&#8250;</button>
                        <div class="slider-dot-wrap" id="extendVSliderDots"></div>
                      </div>
                      <!-- Info grid -->
                      <div class="row g-2 flex-grow-1">
                        <div class="col-6">
                          <div class="extend-field-label">Category</div>
                          <div class="extend-field-value" id="extend_v_category">-</div>
                        </div>
                        <div class="col-6">
                          <div class="extend-field-label">Model</div>
                          <div class="extend-field-value" id="extend_v_model">-</div>
                        </div>
                        <div class="col-6">
                          <div class="extend-field-label">Vehicle No</div>
                          <div class="extend-field-value" id="extend_v_no">-</div>
                        </div>
                        <div class="col-6">
                          <div class="extend-field-label">Chassis No</div>
                          <div class="extend-field-value" id="extend_v_chassis">-</div>
                        </div>
                        <div class="col-6">
                          <div class="extend-field-label">Color / Year</div>
                          <div class="extend-field-value"><span id="extend_v_color">-</span> / <span id="extend_v_year">-</span></div>
                        </div>
                        <div class="col-6">
                          <div class="extend-field-label">Next Ins. / Pass.</div>
                          <div class="extend-field-value">
                            <span id="extend_v_insurance">-</span>
                            <input type="hidden" id="extend_hid_nxt_insurance">
                            <input type="hidden" id="extend_hid_nxt_passing">
                            <input type="hidden" id="extend_hid_nxt_maintenance">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Row 2: Pricing Setup (hidden, kept for min-price & rate lookup) -->
              <div class="mb-3 d-none">
                <div class="pricing-setup-title">Pricing Setup</div>
                <div class="d-flex gap-2">
                  <!-- Hour -->
                  <div class="pricing-col">
                    <div class="pricing-col-header">Hour</div>
                    <div class="pricing-col-row">
                      <span class="p-label">W/O Driver</span>
                      <span class="p-value" id="extend_wod_hourly">0.000 BHD</span>
                    </div>
                    <div class="pricing-col-row">
                      <span class="p-label">With Driver</span>
                      <span class="p-value" id="extend_wd_hourly">0.000 BHD</span>
                    </div>
                  </div>
                  <!-- Day -->
                  <div class="pricing-col">
                    <div class="pricing-col-header">Day</div>
                    <div class="pricing-col-row">
                      <span class="p-label">W/O Driver</span>
                      <span class="p-value" id="extend_wod_daily">0.000 BHD</span>
                    </div>
                    <div class="pricing-col-row">
                      <span class="p-label">With Driver</span>
                      <span class="p-value" id="extend_wd_daily">0.000 BHD</span>
                    </div>
                  </div>
                  <!-- Week -->
                  <div class="pricing-col">
                    <div class="pricing-col-header">Week</div>
                    <div class="pricing-col-row">
                      <span class="p-label">W/O Driver</span>
                      <span class="p-value" id="extend_wod_weekly">0.000 BHD</span>
                    </div>
                    <div class="pricing-col-row">
                      <span class="p-label">With Driver</span>
                      <span class="p-value" id="extend_wd_weekly">0.000 BHD</span>
                    </div>
                  </div>
                  <!-- Month -->
                  <div class="pricing-col">
                    <div class="pricing-col-header">Month</div>
                    <div class="pricing-col-row">
                      <span class="p-label">W/O Driver</span>
                      <span class="p-value" id="extend_wod_monthly">0.000 BHD</span>
                    </div>
                    <div class="pricing-col-row">
                      <span class="p-label">With Driver</span>
                      <span class="p-value" id="extend_wd_monthly">0.000 BHD</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Row 3: Extension Details (Single Page) -->
              <div class="pricing-setup-title border-top pt-3 mb-3">Extension Details</div>
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                    <div class="input-group position-relative">
                        <div class="form-floating form-floating-outline flex-grow-1">
                            <input type="text" id="extend_b_from" class="form-control extend_watch-field"
                                   placeholder="dd-mm-yyyy hh:mm"
                                   maxlength="16"
                                   style="font-family:monospace;"
                                   oninput="extendFormatDateInput(this)">
                            <label>From Date (dd-mm-yyyy hh:mm)</label>
                        </div>
                        <button type="button" id="btn_extend_b_from_picker" class="btn btn-outline-secondary px-2" title="Pick From Date &amp; Time" onclick="var p=document.getElementById('extend_b_from_picker'); if(p){ if(p.showPicker){ p.showPicker(); } else { p.focus(); p.click(); } }">
                            <i class="ri-calendar-line"></i>
                        </button>
                        <input type="datetime-local" id="extend_b_from_picker" tabindex="-1" style="position:absolute; right:0; bottom:0; width:1px; height:1px; opacity:0; pointer-events:none;">
                    </div>
                    </div>
                    <div class="col-12 col-md-4">
                    <div class="input-group position-relative">
                        <div class="form-floating form-floating-outline flex-grow-1">
                            <input type="text" id="extend_b_to" class="form-control extend_watch-field"
                                   placeholder="dd-mm-yyyy hh:mm"
                                   maxlength="16"
                                   style="font-family:monospace;"
                                   oninput="extendFormatDateInput(this)">
                            <label>Extension To (dd-mm-yyyy hh:mm)</label>
                        </div>
                        <button type="button" id="btn_extend_b_to_picker" class="btn btn-outline-secondary px-2" title="Pick Extension To Date &amp; Time" onclick="var p=document.getElementById('extend_b_to_picker'); if(p){ if(p.showPicker){ p.showPicker(); } else { p.focus(); p.click(); } }">
                            <i class="ri-calendar-line"></i>
                        </button>
                        <input type="datetime-local" id="extend_b_to_picker" tabindex="-1" style="position:absolute; right:0; bottom:0; width:1px; height:1px; opacity:0; pointer-events:none;">
                    </div>
                    </div>
                    <div class="col-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <select class="extend_rate_type form-select form-select-sm extend_watch-field" id="extend_rate_type">
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
                        <select class="extend_service form-select form-select-sm extend_watch-field" id="extend_service">
                        <option value="0">Select Service</option>
                        <option value="1" data-id="10">Rental Without Driver</option>
                        <option value="2" data-id="0">Rental With Driver</option>
                        </select>
                        <label class="form-label small">Service</label>
                    </div>
                    </div>
                    <div class="col-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="extend_b_duration" class="form-control extend_watch-field" readonly style="background-color:#f8f9fa;">
                        <label>Duration</label>
                    </div>
                    </div>
                    <div class="col-12 col-md-4">
                    <div style="position:relative;" class="form-floating form-floating-outline">
                        <span class="extend_min-price-text badge bg-danger" style="position:absolute; top:-8px; right:8px; font-size:10px; z-index:2;">
                        Min: 0.000
                        </span>
                        <!-- Input -->
                        <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" class="extend_price nav form-control form-control-sm extend_watch-field" value="0" style="padding-top:12px;" id="extend_price">
                        <label class="form-label small">Unit Price</label>
                    </div>
                    <input type="hidden" class="extend_minprice nav form-control" value="0">
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                        <input type="text" id="extend_b_vat" class="form-control extend_watch-field" readonly style="background-color:#f8f9fa;">
                        <label>VAT %</label>
                    </div>
                    </div>
        
                    <div class="col-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="extend_b_total" class="form-control">
                        <label>Total Amount (Editable)</label>
                    </div>
                    <small class="text-muted" style="font-size:11px;">Auto-calculated; adjust if required</small>
                    </div>
                    <div class="col-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="extend_b_qtn_ref_no" class="form-control" >
                        <label>Quotation Ref. No.</label>
                    </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                        <textarea class="form-control form-control-sm h-px-100" id="extend_txt_booking_notes" name="extend_txt_booking_notes" placeholder="Remarks / Notes"></textarea>
                        <label for="extend_txt_booking_notes">Remarks / Notes</label>
                        </div>
                    </div>
                    
                    <div class="col-12 " id="extend_otpdiv">
                    <div class="alert alert-info">
                            <p class="mb-0" id="extend_p_otp_minprice_info"></p>
                        </div>
                </div>

              </div>
      </div>

      <div class="modal-footer py-2">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success px-4 ladda-button" id="btn_extend_contract"><span class="ladda-label">Extend Contract</span></button>
      </div>
      
    </div>
  </div>
</div>