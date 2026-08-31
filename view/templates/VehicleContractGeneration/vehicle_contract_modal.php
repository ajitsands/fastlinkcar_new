<div class="modal fade" id="contractModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Generate Contract</h5>
          <small>Booking Ref: <span class=" fw-bold" id="booking_ref"></span></small>
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
      
      <div class="modal-body p-0">
        
        <div class="bs-stepper wizard-modern mt-2" id="contractWizard">
          <div class="bs-stepper-header px-4">
            <div class="step" data-target="#tab-customer-vehicle">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-user-line"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Customer & Vehicle</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#tab-booking-details">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-calendar-line"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Booking Details</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#tab-checklist-driver">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-list-check"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Checklist & Driver</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#tab-images-terms">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-image-line"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Images & Terms</span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#tab-signatures">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-quill-pen-line"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Signatures</span>
                </span>
              </button>
            </div>
          </div>
          
          <div class="bs-stepper-content px-4">
          
                <!-- TAB 1: Customer & Vehicle -->
                <div id="tab-customer-vehicle" class="content">
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-md-6">
                            <h6 class="fw-bold text-danger mb-1" style="font-size:13px;">Customer Details</h6>
                            <div class="p-2 rounded h-100" style="background-color: #fff1f1; border: 1px solid #ffc9c9;">
                                <div class="row g-1">
                                    <div class="col-6 mb-1">
                                        <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Customer Name</div>
                                        <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;" id="c_name"></div>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Customer Code</div>
                                        <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;" id="c_code"></div>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Contact Number</div>
                                        <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;" id="c_mobile"></div>
                                    </div>
                                    <div class="col-6 mb-1">
                                        <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Email</div>
                                        <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;" id="c_email"></div>
                                    </div>
                                    <div class="col-12 mt-1">
                                        <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Attn & Address</div>
                                        <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;"><span id="c_attn"></span> - <span id="c_attr"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <h6 class="fw-bold text-danger mb-1" style="font-size:13px;">Vehicle Details</h6>
                            <div class="p-2 rounded h-100" style="background-color: #fff1f1; border: 1px solid #ffc9c9;">
                                <div class="d-flex align-items-start gap-2">
                                    <div style="width: 100px; flex-shrink: 0;">
                                        <div id="v_image_carousel" class="carousel slide" data-bs-ride="carousel" style="border-radius: 6px; overflow: hidden; height: 80px; display: none;">
                                            <div class="carousel-inner h-100" id="v_carousel_inner"></div>
                                        </div>
                                        <div id="v_no_images" class="text-center text-muted small fst-italic" style="border: 1px dashed #ccc; border-radius: 6px; height: 80px; line-height: 80px; font-size: 10px;">
                                            No Images
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="row g-1">
                                            <div class="col-6 mb-1">
                                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Category</div>
                                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;" id="v_category"></div>
                                            </div>
                                            <div class="col-6 mb-1">
                                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Model</div>
                                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;" id="v_model"></div>
                                            </div>
                                            <div class="col-6 mb-1">
                                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Vehicle No</div>
                                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;" id="v_no"></div>
                                            </div>
                                            <div class="col-6 mb-1">
                                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Chassis No</div>
                                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;" id="v_chassis"></div>
                                            </div>
                                            <div class="col-6 mt-1">
                                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Color / Year</div>
                                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;"><span id="v_color"></span> / <span id="v_year"></span></div>
                                            </div>
                                            <div class="col-6 mt-1">
                                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Next Ins. / Pass.</div>
                                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;">
                                                    <span id="v_insurance" class="me-1"></span> | <span id="v_passing" class="ms-1"></span>
                                                </div>
                                                <input type="hidden" id="hid_nxt_insurance">
                                                <input type="hidden" id="hid_nxt_passing">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-danger mb-1" style="font-size:13px; margin-top: 50px;">Pricing Setup</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-3">
                            <div class="border rounded px-2 py-1 bg-lighter">
                                <div class="text-center text-muted fw-bold border-bottom mb-1" style="font-size: 11px;">Hour</div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted" style="font-size: 10px;">W/O Driver</span>
                                    <strong class="text-success" style="font-size: 10px;"><span id="wod_hourly">0.000</span> <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted" style="font-size: 10px;">With Driver</span>
                                    <strong class="text-success" style="font-size: 10px;"><span id="wd_hourly">0.000</span> <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="border rounded px-2 py-1 bg-lighter">
                                <div class="text-center text-muted fw-bold border-bottom mb-1" style="font-size: 11px;">Day</div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted" style="font-size: 10px;">W/O Driver</span>
                                    <strong class="text-success" style="font-size: 10px;"><span id="wod_daily">0.000</span> <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted" style="font-size: 10px;">With Driver</span>
                                    <strong class="text-success" style="font-size: 10px;"><span id="wd_daily">0.000</span> <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="border rounded px-2 py-1 bg-lighter">
                                <div class="text-center text-muted fw-bold border-bottom mb-1" style="font-size: 11px;">Week</div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted" style="font-size: 10px;">W/O Driver</span>
                                    <strong class="text-success" style="font-size: 10px;"><span id="wod_weekly">0.000</span> <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted" style="font-size: 10px;">With Driver</span>
                                    <strong class="text-success" style="font-size: 10px;"><span id="wd_weekly">0.000</span> <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="border rounded px-2 py-1 bg-lighter">
                                <div class="text-center text-muted fw-bold border-bottom mb-1" style="font-size: 11px;">Month</div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted" style="font-size: 10px;">W/O Driver</span>
                                    <strong class="text-success" style="font-size: 10px;"><span id="wod_monthly">0.000</span> <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted" style="font-size: 10px;">With Driver</span>
                                    <strong class="text-success" style="font-size: 10px;"><span id="wd_monthly">0.000</span> <?= defined('SYS_CURRENCY_CODE') ? SYS_CURRENCY_CODE : 'BHD' ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-next" onclick="contractWizard.next()">Next <i class="ri-arrow-right-line ms-1"></i></button>
                    </div>
                </div>

                <!-- TAB 2: Booking Details -->
                <div id="tab-booking-details" class="content">
                    <h6 class="fw-bold text-danger mb-2" style="font-size:13px;">Booking Details</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-3 mb-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">From</label>
                            <input type="datetime-local" id="b_from" class="form-control form-control-sm watch-field">
                        </div>
                        <div class="col-12 col-md-3 mb-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">To</label>
                            <input type="datetime-local" id="b_to" class="form-control form-control-sm watch-field">
                        </div>
                        <div class="col-12 col-md-3 mb-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">Type</label>
                            <select class="rate_type form-select form-select-sm watch-field" id="rate_type">
                                <option value="0">Select</option>
                                <option value="hour">Hourly</option>
                                <option value="day">Daily</option>
                                <option value="week">Weekly</option>
                                <option value="month">Monthly</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">Service</label>
                            <select class="service form-select form-select-sm watch-field" id="service">
                                <option value="0">Select Service</option>
                                <option value="1" data-id="10">Rental Without Driver</option>
                                <option value="2" data-id="0">Rental With Driver</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2 mb-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">Duration</label>
                            <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="b_duration" class="form-control form-control-sm watch-field">
                        </div>
                        <div class="col-12 col-md-2 mb-1" style="position: relative;">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">Unit Price</label>
                            <span class="min-price-text badge bg-danger" style="position:absolute; top: 0; right: 5px; font-size:9px; z-index:2; padding: 2px 4px;">Min: 0.000</span>
                            <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" class="price nav form-control form-control-sm watch-field" value="0" id="price">
                            <input type="hidden" class="minprice nav form-control" value="0">
                        </div>
                        <div class="col-12 col-md-2 mb-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">VAT %</label>
                            <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="b_vat" class="form-control form-control-sm watch-field">
                        </div>
                        <div class="col-12 col-md-3 mb-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">Total</label>
                            <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="b_total" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 col-md-3 mb-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">Quotation Ref. No.</label>
                            <input type="text" id="b_qtn_ref_no" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-12 mt-1">
                            <label class="text-muted d-block" style="font-size: 10px; margin-bottom: 2px;">Booking Notes</label>
                            <textarea class="form-control form-control-sm" style="height: 60px;" id="txt_booking_notes" name="txt_booking_notes" placeholder="Booking Notes"></textarea>
                        </div>
                        <div class="col-12 mt-2" id="otpdiv">
                            <div class="alert alert-info py-1 px-2 mb-0" style="font-size: 11px;">
                                <p class="mb-0" id="p_otp_minprice_info"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-secondary btn-prev" onclick="contractWizard.previous()"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                        <button class="btn btn-primary btn-next" onclick="contractWizard.next()">Next <i class="ri-arrow-right-line ms-1"></i></button>
                    </div>
                </div>

                <!-- TAB 3: Checklist & Driver -->
                <div id="tab-checklist-driver" class="content">
                    <h6 class="fw-bold text-danger mb-3">Vehicle Checklist & Handover</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-2">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="chk_tools">
                                <label class="form-check-label">Jack & Tools</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="chk_spare">
                                <label class="form-check-label">Spare Tyre</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chk_radio">
                                <label class="form-check-label">Radio</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="date" id="dt_contract_date" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                <label>Contract Date</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" id="fuel_level" class="form-control">
                                <label>Fuel Level</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="km_out" class="form-control">
                                <label>Odometer Reading</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="datetime-local" id="dt_out" class="form-control">
                                <label>Rentout Time</label>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-danger mb-3">Customer Driver</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="cust_driver" class="form-control">
                                <label>Customer Driver Name</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="cust_driver_contact_no" class="form-control">
                                <label>Contact Number</label>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <a href="javascript:;" class="openAddCustDriverDocModal badge bg-label-primary rounded-pill p-2">
                                Customer Driver Documents
                            </a>
                            <button type="button" id="openCameraCapture" style="display:none;" class="btn btn-sm btn-outline-info rounded-pill ms-2"><i class="ri-camera-line"></i> Camera</button>
                            <input type="file" id="cameraCaptureInput" accept="image/*" capture="environment" multiple style="display:none;">
                        </div>
                        <div class="col-12 mt-2">
                            <ul id="contractcustdriverdocpreview" class="list-unstyled d-flex align-items-center avatar-group mb-0"></ul>
                        </div>
                    </div>
                    
                    <div id="assign_company_driver_section" style="display: none;">
                        <h6 class="fw-bold text-danger mb-1" style="font-size:13px;">Assign Company Driver</h6>
                        <div class="row g-2 mb-3">
                            <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline mb-1 h-100">
                                    <div id="dropdownContainer"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="p-2 rounded h-100 driverclass" style="background-color: #fff1f1; border: 1px solid #ffc9c9;">
                                    <div class="row g-1">
                                        <div class="col-4 mb-1">
                                            <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Name</div>
                                            <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_name"></div>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Contact Number</div>
                                            <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_mobile"></div>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <div class="text-muted" style="font-size: 10px; line-height: 1.2;">License Number</div>
                                            <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_license_no"></div>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Issue Place</div>
                                            <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_license_issue_place"></div>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <div class="text-muted" style="font-size: 10px; line-height: 1.2;">License Issue Date</div>
                                            <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_licenseissueDate"></div>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <div class="text-muted" style="font-size: 10px; line-height: 1.2;">License Expiry Date</div>
                                            <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_licenseexpiryDate"></div>
                                        </div>
                                        <div class="col-12 mt-2" id="company_driver_docs_container" style="display:none;">
                                            <div class="text-muted mb-1" style="font-size: 10px; line-height: 1.2;">Driver Documents</div>
                                            <ul id="company_driver_docs_preview" class="list-unstyled d-flex align-items-center avatar-group mb-0"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-secondary btn-prev" onclick="contractWizard.previous()"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                        <button class="btn btn-primary btn-next" onclick="contractWizard.next()">Next <i class="ri-arrow-right-line ms-1"></i></button>
                    </div>
                </div>

                <!-- TAB 4: Images & Terms -->
                <div id="tab-images-terms" class="content">
                    <div class="row">
                        <div class="col-12 col-lg-6 border-end pe-4">
                            <h6 class="fw-bold text-danger mb-3">Rentout Images</h6>
                            <div class="p-4 border border-dashed rounded text-center mb-3">
                                <i class="ri-camera-lens-fill text-muted" style="font-size: 2rem;"></i>
                                <p class="mb-2 text-muted">Take photos or select images to auto-upload.</p>
                                <label for="carImages" class="btn btn-outline-primary btn-sm rounded-pill" style="cursor: pointer;">
                                    <i class="ri-camera-line me-1"></i> Capture / Select Images
                                </label>
                                <!-- Direct auto-upload input, hidden -->
                                <input type="file" id="carImages" class="d-none" multiple accept="image/*" capture="environment">
                            </div>
                            


                            <div id="preview" class="d-flex flex-wrap gap-2 mt-3"></div>
                        </div>
                        
                        <div class="col-12 col-lg-6 ps-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-danger mb-0">Terms & Conditions</h6>
                                <button id="btn_terms_condition" class="btn btn-primary btn-sm">
                                    <span class="ri-settings-3-line me-1"></span> Manage Terms
                                </button>
                            </div>
                            
                            <div class="d-flex gap-4 mb-3 border-bottom pb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="terms_option" id="terms_default" value="default" checked>
                                    <label class="form-check-label fw-bold" for="terms_default">
                                        Default Terms
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="terms_option" id="terms_custom" value="custom">
                                    <label class="form-check-label fw-bold" for="terms_custom">
                                        Custom Terms
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Selected Term Title Display -->
                            <div id="selected_term_display" class="border rounded p-3 bg-light" style="min-height: 80px; margin-bottom:10px;">
                                <div class="d-flex align-items-center h-100">
                                    <i class="ri-file-text-line fs-3 text-primary me-3"></i>
                                    <div>
                                        <div class="text-muted small fw-bold text-uppercase mb-1" id="selected_term_type_label">Default Term</div>
                                        <h6 class="mb-0 fw-bold" id="selected_term_title_label">
                                            <div class="spinner-border spinner-border-sm text-secondary" role="status"></div> Loading...
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden Editor to retain existing JS logic compatibility -->
                            <div id="custom_terms_container" style="display: none;">
                                <div id="full-editor-onbody"></div>
                            </div>
                            <input type="hidden" id="custom_term_title_hidden" value="">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-secondary btn-prev" onclick="contractWizard.previous()"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                        <button class="btn btn-primary btn-next" onclick="contractWizard.next()">Next <i class="ri-arrow-right-line ms-1"></i></button>
                    </div>
                </div>

                <!-- TAB 5: Signatures -->
                <div id="tab-signatures" class="content">
                    <h6 class="fw-bold text-danger mb-3">Signatures</h6>
                    
                    <div class="row mb-4" >
                        <div class="col-md-6">
                            <label class="fw-bold">
                                Hirer Signature
                            </label>
                            <input type="text"
                                   class="form-control mb-2"
                                   id="hirer_name_wizard"
                                   placeholder="Hirer Name">
                            <canvas id="hirerCanvas_wizard"
                                    style="width:100%;
                                           height:250px;
                                           border:1px solid #ccc;
                                           border-radius:10px;
                                           background:#fff;">
                            </canvas>
                            <button class="btn btn-danger btn-sm mt-2"
                                    id="btnClearHirer_wizard">
                                Clear
                            </button>
                        </div>
    
                        <div class="col-md-6">
                            <label class="fw-bold">
                                Delivered By Signature
                            </label>
                            <input type="text"
                                   class="form-control mb-2"
                                   id="delivery_name_wizard"
                                   placeholder="Delivered By Name">
                            <canvas id="deliveryCanvas_wizard"
                                    style="width:100%;
                                           height:250px;
                                           border:1px solid #ccc;
                                           border-radius:10px;
                                           background:#fff;">
                            </canvas>
                            <button class="btn btn-danger btn-sm mt-2"
                                    id="btnClearDelivery_wizard">
                                Clear
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-secondary btn-prev" onclick="contractWizard.previous()"><i class="ri-arrow-left-line me-1"></i> Previous</button>
                    </div>
                </div>

          </div>
        </div>

      </div>
      
      <!-- FOOTER -->
      <div class="modal-footer d-flex justify-content-between align-items-center border-top pt-4 mt-3">
        <div>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-success px-4 ladda-button" id="btn_save_contract">
              <span class="ladda-label">Save Contract</span>
          </button>
          <button type="button" class="btn btn-primary px-4 ladda-button" id="btn_save_rentout_contract">
              <span class="ladda-label">Save Contract & Rentout</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Driver Document Slider Modal -->
<div class="modal fade" id="companyDriverDocSliderModal" tabindex="-1" style="z-index: 10075 !important;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="driverDocModalTitle">Driver Documents</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0 bg-light">
                <div id="driverDocCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner" id="driverDocCarouselInner" style="min-height: 400px;"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#driverDocCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded p-2" aria-hidden="true" style="width: 2.5rem; height: 2.5rem;"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#driverDocCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded p-2" aria-hidden="true" style="width: 2.5rem; height: 2.5rem;"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>