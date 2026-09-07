<div class="modal fade" id="elistcontractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Contract Extensions</h5>
          <small>
            Agreement No: <span class="fw-bold" id="elist_agreement_ref"></span>
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

      <!-- STEPPER HEADER -->
      <div class="modal-body pb-0">
        <div id="elistStepper" class="bs-stepper linear">
          <div class="bs-stepper-header" role="tablist">
            <div class="step" data-target="#tab-elist-customer-vehicle">
              <button type="button" class="step-trigger" role="tab" id="elist-step-1-trigger">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">Customer &amp; Vehicle</span>
              </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#tab-elist-extensions">
              <button type="button" class="step-trigger" role="tab" id="elist-step-2-trigger">
                <span class="bs-stepper-circle">2</span>
                <span class="bs-stepper-label">Extension List</span>
              </button>
            </div>
          </div><!-- /stepper-header -->

          <div class="bs-stepper-content">

            <!-- ── STEP 1: Customer & Vehicle ──────────────────────── -->
            <div id="tab-elist-customer-vehicle" class="content">
              <style>
                .elist-info-card { background: #fff5f5; border: 1px solid #f5c6c6; border-radius: 8px; padding: 14px; }
                .elist-info-card .section-title { color: #c0392b; font-weight: 700; font-size: 0.9rem; margin-bottom: 10px; }
                .elist-field-label { color: #888; font-size: 0.75rem; margin-bottom: 1px; }
                .elist-field-value { font-weight: 600; font-size: 0.88rem; color: #222; }
                .elist-pricing-title { color: #c0392b; font-weight: 700; font-size: 0.9rem; margin-bottom: 8px; }
                .elist-pricing-col { flex: 1; border: 1px solid #eee; border-radius: 4px; overflow: hidden; }
                .elist-pricing-col-header { background: #f5f5f5; text-align: center; font-weight: 700; font-size: 0.82rem; color: #444; padding: 7px 4px; border-bottom: 1px solid #eee; }
                .elist-pricing-col-row { display: flex; justify-content: space-between; align-items: center; padding: 5px 10px; font-size: 0.82rem; border-bottom: 1px solid #f5f5f5; }
                .elist-pricing-col-row:last-child { border-bottom: none; }
                .elist-pricing-col-row .p-label { color: #666; }
                .elist-pricing-col-row .p-value { font-weight: 700; color: #27ae60; }
                /* Mini slider */
                .elist-v-slider { width: 90px; height: 70px; flex-shrink: 0; border-radius: 6px; overflow: hidden; position: relative; background: #ddd; }
                .elist-v-slider img { width: 100%; height: 100%; object-fit: cover; position: absolute; top:0; left:0; }
                .elist-v-slider .slider-dot-wrap { position: absolute; bottom: 3px; left: 0; right: 0; display: flex; justify-content: center; gap: 3px; }
                .elist-v-slider .slider-dot { width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.6); cursor: pointer; transition: background 0.2s; }
                .elist-v-slider .slider-dot.active { background: #fff; }
                .elist-v-slider .slider-arrow { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.4); color: #fff; border: none; padding: 0 4px; font-size: 10px; line-height: 18px; cursor: pointer; border-radius: 2px; display: none; }
                .elist-v-slider:hover .slider-arrow { display: block; }
                .elist-v-slider .slider-arrow.prev { left: 1px; }
                .elist-v-slider .slider-arrow.next { right: 1px; }
              </style>

              <!-- Row 1: Customer + Vehicle cards -->
              <div class="row g-3 mb-3">
                <!-- Customer -->
                <div class="col-12 col-md-6">
                  <div class="elist-info-card h-100">
                    <div class="section-title">Customer Details</div>
                    <div class="row g-2">
                      <div class="col-6">
                        <div class="elist-field-label">Customer Name</div>
                        <div class="elist-field-value" id="elist_c_name">-</div>
                      </div>
                      <div class="col-6">
                        <div class="elist-field-label">Customer Code</div>
                        <div class="elist-field-value" id="elist_c_code">-</div>
                      </div>
                      <div class="col-6">
                        <div class="elist-field-label">Contact Number</div>
                        <div class="elist-field-value" id="elist_c_mobile">-</div>
                      </div>
                      <div class="col-6">
                        <div class="elist-field-label">Email</div>
                        <div class="elist-field-value" id="elist_c_email">-</div>
                      </div>
                      <div class="col-12">
                        <div class="elist-field-label">Attn &amp; Address</div>
                        <div class="elist-field-value"><span id="elist_c_attn"></span><span id="elist_c_attr"></span></div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Vehicle -->
                <div class="col-12 col-md-6">
                  <div class="elist-info-card h-100">
                    <div class="section-title">Vehicle Details</div>
                    <div class="d-flex gap-3 align-items-start">
                      <!-- Mini Slider -->
                      <div class="elist-v-slider" id="elistVSlider">
                        <img id="elistVSliderImg" src="uploads/vehicleImages/default.jpg" alt="Vehicle">
                        <button class="slider-arrow prev" id="elistVSliderPrev">&#8249;</button>
                        <button class="slider-arrow next" id="elistVSliderNext">&#8250;</button>
                        <div class="slider-dot-wrap" id="elistVSliderDots"></div>
                      </div>
                      <!-- Info grid -->
                      <div class="row g-2 flex-grow-1">
                        <div class="col-6">
                          <div class="elist-field-label">Category</div>
                          <div class="elist-field-value" id="elist_v_category">-</div>
                        </div>
                        <div class="col-6">
                          <div class="elist-field-label">Model</div>
                          <div class="elist-field-value" id="elist_v_model">-</div>
                        </div>
                        <div class="col-6">
                          <div class="elist-field-label">Vehicle No</div>
                          <div class="elist-field-value" id="elist_v_no">-</div>
                        </div>
                        <div class="col-6">
                          <div class="elist-field-label">Chassis No</div>
                          <div class="elist-field-value" id="elist_v_chassis">-</div>
                        </div>
                        <div class="col-6">
                          <div class="elist-field-label">Color / Year</div>
                          <div class="elist-field-value"><span id="elist_v_color">-</span> / <span id="elist_v_year">-</span></div>
                        </div>
                        <div class="col-6">
                          <div class="elist-field-label">Next Ins. / Pass.</div>
                          <div class="elist-field-value">
                            <span id="elist_v_insurance">-</span>
                            <input type="hidden" id="elist_hid_nxt_insurance">
                            <input type="hidden" id="elist_hid_nxt_passing">
                            <input type="hidden" id="elist_hid_nxt_maintenance">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Row 2: Pricing Setup -->
              <div class="mb-3">
                <div class="elist-pricing-title">Pricing Setup</div>
                <div class="d-flex gap-2">
                  <div class="elist-pricing-col">
                    <div class="elist-pricing-col-header">Hour</div>
                    <div class="elist-pricing-col-row"><span class="p-label">W/O Driver</span><span class="p-value" id="elist_wod_hourly">0.000 BHD</span></div>
                    <div class="elist-pricing-col-row"><span class="p-label">With Driver</span><span class="p-value" id="elist_wd_hourly">0.000 BHD</span></div>
                  </div>
                  <div class="elist-pricing-col">
                    <div class="elist-pricing-col-header">Day</div>
                    <div class="elist-pricing-col-row"><span class="p-label">W/O Driver</span><span class="p-value" id="elist_wod_daily">0.000 BHD</span></div>
                    <div class="elist-pricing-col-row"><span class="p-label">With Driver</span><span class="p-value" id="elist_wd_daily">0.000 BHD</span></div>
                  </div>
                  <div class="elist-pricing-col">
                    <div class="elist-pricing-col-header">Week</div>
                    <div class="elist-pricing-col-row"><span class="p-label">W/O Driver</span><span class="p-value" id="elist_wod_weekly">0.000 BHD</span></div>
                    <div class="elist-pricing-col-row"><span class="p-label">With Driver</span><span class="p-value" id="elist_wd_weekly">0.000 BHD</span></div>
                  </div>
                  <div class="elist-pricing-col">
                    <div class="elist-pricing-col-header">Month</div>
                    <div class="elist-pricing-col-row"><span class="p-label">W/O Driver</span><span class="p-value" id="elist_wod_monthly">0.000 BHD</span></div>
                    <div class="elist-pricing-col-row"><span class="p-label">With Driver</span><span class="p-value" id="elist_wd_monthly">0.000 BHD</span></div>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-danger px-5" onclick="elistStepper.next()">Next</button>
              </div>
            </div><!-- /step 1 -->

            <!-- ── STEP 2: Extension List ───────────────────────────── -->
            <div id="tab-elist-extensions" class="content">
              <div class="table-responsive mt-2">
                <table id="contractExtensionTable" class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Agreement No</th>
                      <th>Date</th>
                      <th>Extension Period</th>
                      <th>Details</th>
                      <th>Pricing</th>
                      <th>Notes</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                </table>
              </div>

              <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary px-4" onclick="elistStepper.previous()">Back</button>
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
              </div>
            </div><!-- /step 2 -->

          </div><!-- /bs-stepper-content -->
        </div><!-- /bs-stepper -->
      </div><!-- /modal-body -->

    </div>
  </div>
</div>