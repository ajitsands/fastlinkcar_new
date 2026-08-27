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
                    <h6 class="fw-bold text-danger mb-2">Customer Details</h6>
                    <div class="row g-2 mb-3 p-2 border rounded bg-lighter">
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Customer Name</span>
                            <span class="fw-semibold small" id="c_name"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Customer Code</span>
                            <span class="fw-semibold small" id="c_code"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Contact Number</span>
                            <span class="fw-semibold small" id="c_mobile"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Email</span>
                            <span class="fw-semibold small text-truncate d-inline-block w-100" id="c_email"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Attn & Address</span>
                            <span class="fw-semibold small"><span id="c_attn"></span> - <span id="c_attr"></span></span>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold text-danger mb-2">Vehicle Details</h6>
                    <div class="row g-2 mb-3 p-2 border rounded bg-lighter">
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Category</span>
                            <span class="fw-semibold small" id="v_category"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Model</span>
                            <span class="fw-semibold small" id="v_model"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Vehicle No</span>
                            <span class="fw-semibold small" id="v_no"></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Color / Year</span>
                            <span class="fw-semibold small"><span id="v_color"></span> / <span id="v_year"></span></span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="text-muted d-block small">Next Ins. / Pass. / Maint.</span>
                            <span class="fw-semibold small">
                                <span id="v_insurance" class="me-1"></span> | 
                                <span id="v_passing" class="mx-1"></span> | 
                                <span id="v_maintenance" class="ms-1"></span>
                            </span>
                            <input type="hidden" id="hid_nxt_insurance">
                            <input type="hidden" id="hid_nxt_passing">
                            <input type="hidden" id="hid_nxt_maintenance">
                        </div>
                    </div>

                    <h6 class="fw-bold text-danger mb-2">Pricing Rates</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <div class="p-2 border rounded bg-lighter h-100">
                                <div class="fw-semibold mb-2 text-primary border-bottom pb-1 small">Without Driver</div>
                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <div><span class="text-muted small">Hourly: </span><span class="fw-semibold small" id="wod_hourly">0.000</span></div>
                                    <div><span class="text-muted small">Daily: </span><span class="fw-semibold small" id="wod_daily">0.000</span></div>
                                    <div><span class="text-muted small">Weekly: </span><span class="fw-semibold small" id="wod_weekly">0.000</span></div>
                                    <div><span class="text-muted small">Monthly: </span><span class="fw-semibold small" id="wod_monthly">0.000</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="p-2 border rounded bg-lighter h-100">
                                <div class="fw-semibold mb-2 text-info border-bottom pb-1 small">With Driver</div>
                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <div><span class="text-muted small">Hourly: </span><span class="fw-semibold small" id="wd_hourly">0.000</span></div>
                                    <div><span class="text-muted small">Daily: </span><span class="fw-semibold small" id="wd_daily">0.000</span></div>
                                    <div><span class="text-muted small">Weekly: </span><span class="fw-semibold small" id="wd_weekly">0.000</span></div>
                                    <div><span class="text-muted small">Monthly: </span><span class="fw-semibold small" id="wd_monthly">0.000</span></div>
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
                    <h6 class="fw-bold text-danger mb-3">Booking Details</h6>
                    <div class="row g-3 mb-3">
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
                                <select class="rate_type form-control form-control-sm watch-field" id="rate_type">
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
                                <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="b_duration" class="form-control watch-field">
                                <label>Duration</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div style="position:relative;" class="form-floating form-floating-outline">
                                <span class="min-price-text badge bg-danger" style="position:absolute; top:-8px; right:8px; font-size:10px; z-index:2;">
                                    Min: 0.000
                                </span>
                                <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" class="price nav form-control form-control-sm watch-field" value="0" style="padding-top:12px;" id="price" >
                                <label class="form-label small">Unit Price</label>
                            </div>
                            <input type="hidden" class="minprice nav form-control" value="0">
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="b_vat" class="form-control watch-field">
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
                                <label for="txt_booking_notes">Booking Notes</label>
                            </div>
                        </div>
                        <div class="col-12" id="otpdiv">
                            <div class="alert alert-info">
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
                        <div class="col-md-3">
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
                                <label>KM Out</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="datetime-local" id="dt_out" class="form-control">
                                <label>Date Time Out</label>
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
                    
                    <h6 class="fw-bold text-danger mb-3">Assign Company Driver</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline mb-1">
                                <div id="dropdownContainer"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 p-3 border rounded driverclass">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted d-block fs-6">Name</span>
                                    <span class="fw-semibold driverClasstext" id="d_name"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted d-block fs-6">Contact Number</span>
                                    <span class="fw-semibold driverClasstext" id="d_mobile"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted d-block fs-6">License Number</span>
                                    <span class="fw-semibold driverClasstext" id="d_license_no"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="text-muted d-block fs-6">Issue Place</span>
                                    <span class="fw-semibold driverClasstext" id="d_license_issue_place"></span>
                                </div>
                                <div class="col-md-6">
                                    <span class="text-muted d-block fs-6">Issue Date</span>
                                    <span class="fw-semibold driverClasstext" id="d_licenseissueDate"></span>
                                </div>
                                <div class="col-md-6">
                                    <span class="text-muted d-block fs-6">Expiry Date</span>
                                    <span class="fw-semibold driverClasstext" id="d_licenseexpiryDate"></span>
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
                            <h6 class="fw-bold text-danger mb-3">Vehicle Images</h6>
                            <div class="p-4 border border-dashed rounded text-center mb-3">
                                <i class="ri-camera-lens-fill text-muted" style="font-size: 2rem;"></i>
                                <p class="mb-2 text-muted">Take photos or select images to auto-upload.</p>
                                <label for="carImages" class="btn btn-outline-primary btn-sm rounded-pill" style="cursor: pointer;">
                                    <i class="ri-camera-line me-1"></i> Capture / Select Images
                                </label>
                                <!-- Direct auto-upload input, hidden -->
                                <input type="file" id="carImages" class="d-none" multiple accept="image/*" capture="environment">
                            </div>
                            
                            <div class="progress mb-3" style="height:8px;">
                                <div class="progress-bar" id="globalProgressBar" style="width:0%"></div>
                            </div>
                            <div id="uploadLoader" class="text-center mt-2 d-none">
                                <div class="spinner-border spinner-border-sm text-primary"></div>
                                <span class="ms-2">Uploading images...</span>
                            </div>
                            <div id="preview" class="d-flex flex-wrap gap-2 mt-3"></div>
                        </div>
                        
                        <div class="col-12 col-lg-6 ps-4">
                            <h6 class="fw-bold text-danger mb-3">Terms & Conditions</h6>
                            <div id="full-editor-onbody" style="height: 300px; margin-bottom:10px;"></div>
                            <button id="btn_terms_condition" class="btn btn-primary mt-3 btn-sm">
                                <span class="ri-save-line me-1"></span> Save Terms
                            </button>
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
                                   id="hirer_name"
                                   placeholder="Hirer Name">
                            <canvas id="hirerCanvas"
                                    style="width:100%;
                                           height:250px;
                                           border:1px solid #ccc;
                                           border-radius:10px;
                                           background:#fff;">
                            </canvas>
                            <button class="btn btn-danger btn-sm mt-2"
                                    id="btnClearHirer">
                                Clear
                            </button>
                        </div>
    
                        <div class="col-md-6">
                            <label class="fw-bold">
                                Delivered By Signature
                            </label>
                            <input type="text"
                                   class="form-control mb-2"
                                   id="delivery_name"
                                   placeholder="Delivered By Name">
                            <canvas id="deliveryCanvas"
                                    style="width:100%;
                                           height:250px;
                                           border:1px solid #ccc;
                                           border-radius:10px;
                                           background:#fff;">
                            </canvas>
                            <button class="btn btn-danger btn-sm mt-2"
                                    id="btnClearDelivery">
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
      <div class="modal-footer d-flex justify-content-end align-items-center border-top">
        <div>
            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success px-4 ladda-button" id="btn_save_contract">
                <span class="ladda-label">Save Contract</span>
            </button>
        </div>
      </div>

    </div>
  </div>
</div>