<div class="modal fade" id="directContractWizardModal" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header bg-danger">
        <div>
          <h5 class="mb-0 text-white">Generate Direct Contract</h5>
          <small class="text-white">Multiple Vehicles Supported</small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      
      <div class="modal-body p-0">
        
        <div class="bs-stepper wizard-modern mt-2" id="dcWizard">
          <!-- DYNAMIC HEADER INJECTED BY JS -->
          <div class="bs-stepper-header px-4" id="dcWizardHeader">
          </div>
          
          <!-- DYNAMIC CONTENT INJECTED BY JS -->
          <div class="bs-stepper-content px-4" id="dcWizardContent">
          </div>
        </div>

      </div>
      
      <!-- FOOTER -->
      <div class="modal-footer d-flex justify-content-between align-items-center border-top pt-4 mt-3">
        <div>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-success px-4 ladda-button" id="btn_save_dc_contract">
              <span class="ladda-label">Save Contract</span>
          </button>
          <button type="button" class="btn btn-primary px-4 ladda-button" id="btn_save_rentout_dc_contract">
              <span class="ladda-label">Save Contract & Rentout</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Template for Customer & Summary Tab -->
<template id="dc-tpl-customer">
    <div id="tab-dc-customer" class="content">
        <div class="row g-3">
            <div class="col-12">
                <fieldset class="border rounded p-3" style="background-color: #fff1f1; border-color: #ffc9c9 !important;">
                    <legend class="fw-bold text-danger w-auto px-2 mb-0" style="font-size:13px; float:none; line-height:1;">Customer Details</legend>
                    <div class="row g-2">
                        <div class="col-3 mb-2">
                            <small class="text-muted d-block">Customer Name</small>
                            <strong class="text-truncate d-block" id="dc_c_name"></strong>
                        </div>
                        <div class="col-3 mb-2">
                            <small class="text-muted d-block">Customer Code</small>
                            <strong class="text-truncate d-block" id="dc_c_code"></strong>
                        </div>
                        <div class="col-3 mb-2">
                            <small class="text-muted d-block">Contact Number</small>
                            <strong class="text-truncate d-block" id="dc_c_mobile"></strong>
                        </div>
                        <div class="col-3 mb-2">
                            <small class="text-muted d-block">Email</small>
                            <strong class="text-truncate d-block" id="dc_c_email"></strong>
                        </div>
                        <div class="col-12 mt-1">
                            <small class="text-muted d-block">Attn & Address</small>
                            <strong class="text-truncate d-block"><span id="dc_c_attention"></span> - <span id="dc_c_address"></span></strong>
                        </div>
                        <div class="col-12 mt-1 d-none" id="dc_c_cpr_container">
                            <strong id="dc_c_cpr"></strong>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-12">
                <fieldset class="border rounded p-3" style="background-color: #fff1f1; border-color: #ffc9c9 !important;">
                    <legend class="fw-bold text-danger w-auto px-2 mb-0" style="font-size:13px; float:none; line-height:1;">Contract Details</legend>
                    <!-- Row 1: Dates, Service, Duration -->
                    <div class="row g-2 mb-2 border-bottom pb-2 border-danger-subtle">
                        <div class="col-3">
                            <small class="text-muted d-block">From</small>
                            <strong class="d-block text-truncate" id="dc_b_from_date" style="font-size: 11px;"></strong>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">To</small>
                            <strong class="d-block text-truncate" id="dc_b_to_date" style="font-size: 11px;"></strong>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">Service</small>
                            <strong class="text-truncate d-block" id="dc_b_service"></strong>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">Duration / Type</small>
                            <strong class="text-truncate d-block" id="dc_b_duration_type"></strong>
                        </div>
                    </div>

                    <!-- Row 2: Pricing Info -->
                    <div class="row g-2 mb-2 border-bottom pb-2 border-danger-subtle">
                        <div class="col-3">
                            <small class="text-muted d-block">Unit Price</small>
                            <strong class="text-truncate d-block">
                                <span id="dc_b_unit_price"></span> 
                                <span class="badge bg-danger ms-1" style="font-size:10px;">Min: <span id="dc_b_min_price"></span></span>
                            </strong>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">VAT Percentage</small>
                            <strong class="text-truncate d-block" id="dc_b_vat_perc"></strong>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">VAT Amount</small>
                            <strong class="text-truncate d-block" id="dc_b_vat_amt"></strong>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block">Total</small>
                            <strong class="text-truncate d-block text-danger" id="dc_b_total"></strong>
                        </div>
                    </div>
                    
                    <!-- Row 3: Vehicles & Remarks -->
                    <div class="row g-2">
                        <div class="col-3 mb-2">
                            <small class="text-muted d-block">Total Vehicles</small>
                            <strong class="text-truncate d-block" id="dc_b_vehicles"></strong>
                        </div>
                        <div class="col-3 mb-2">
                            <small class="text-muted d-block">Model of Vehicle</small>
                            <strong class="text-truncate d-block" id="dc_b_model"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Remarks</small>
                            <strong class="d-block" id="dc_b_notes" style="white-space: pre-wrap; font-size:11px;"></strong>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button class="btn btn-primary btn-next" onclick="dcWizardObj.next()">Next <i class="ri-arrow-right-line ms-1"></i></button>
        </div>
    </div>
</template>

<!-- Template for Vehicle Checklist Tab -->
<template id="dc-tpl-vehicle">
    <div id="tab-dc-vehicle-{ID}" class="content dc-vehicle-tab" data-vid="{ID}">
        <h6 class="fw-bold text-danger mb-1" style="font-size:13px;">Vehicle Details</h6>
        <div class="card border-0 mb-3" style="background-color: #fce8e8; font-size: 11px;">
            <div class="card-body p-2">
                <div class="d-flex">
                    <div class="me-3 d-flex flex-column align-items-center justify-content-center" style="width: 250px;">
                        {IMAGE_CONTENT}
                    </div>
                    <div class="flex-grow-1">
                        <div class="row g-1">
                            <div class="col-6 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Category</div>
                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;">{CATEGORY}</div>
                            </div>
                            <div class="col-6 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Model</div>
                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;">{MODEL}</div>
                            </div>
                            <div class="col-6 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Vehicle No</div>
                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;">{PLATE}</div>
                            </div>
                            <div class="col-6 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Chassis No</div>
                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;">{CHASSIS}</div>
                            </div>
                            <div class="col-6 mt-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Color / Year</div>
                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;">{COLOR} / {YEAR}</div>
                            </div>
                            <div class="col-6 mt-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Next Ins. / Pass.</div>
                                <div class="fw-semibold text-truncate" style="font-size: 11px; line-height: 1.2;">
                                    <span class="me-1">{INSURANCE}</span> | <span class="ms-1">{PASSING}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <h6 class="fw-bold text-danger mb-3">Vehicle Checklist & Handover</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input dc-chk" type="checkbox" id="chk_tools_{ID}">
                    <label class="form-check-label">Jack & Tools</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input dc-chk" type="checkbox" id="chk_spare_{ID}">
                    <label class="form-check-label">Spare Tyre</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input dc-chk" type="checkbox" id="chk_radio_{ID}">
                    <label class="form-check-label">Radio</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="date" id="dt_contract_date_{ID}" class="form-control dc-inp" value="<?php echo date('Y-m-d') ?>">
                    <label>Contract Date</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" id="fuel_level_{ID}" class="form-control dc-inp">
                    <label>Fuel Level</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="km_out_{ID}" class="form-control dc-inp" value="{ODO}">
                    <label>Odometer Reading</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline mb-3">
                    <input type="datetime-local" id="dt_out_{ID}" class="form-control dc-inp">
                    <label>Rentout Time</label>
                </div>
            </div>
        </div>

        <h6 class="fw-bold text-danger mb-3">Customer Driver</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="cust_driver_{ID}" class="form-control dc-inp">
                    <label>Customer Driver Name</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="cust_driver_contact_no_{ID}" class="form-control dc-inp">
                    <label>Contact Number</label>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <a href="javascript:;" class="openAddCustDriverDocModal badge bg-label-primary rounded-pill p-2" data-vid="{ID}">
                    Customer Driver Documents
                </a>
                <button type="button" id="openCameraCapture_{ID}" style="display:none;" class="btn btn-sm btn-outline-info rounded-pill ms-2"><i class="ri-camera-line"></i> Camera</button>
                <input type="file" id="cameraCaptureInput_{ID}" accept="image/*" capture="environment" multiple style="display:none;">
            </div>
            <div class="col-12 mt-2">
                <ul id="contractcustdriverdocpreview_{ID}" class="list-unstyled d-flex align-items-center avatar-group mb-0"></ul>
            </div>
        </div>
        
        <div id="assign_company_driver_section_{ID}" style="display: none;">
            <h6 class="fw-bold text-danger mb-1" style="font-size:13px;">Assign Company Driver</h6>
            <div class="row g-2 mb-3">
                <div class="col-12 col-md-4">
                    <div class="form-floating form-floating-outline mb-1 h-100">
                        <div id="dropdownContainer_{ID}"></div>
                    </div>
                </div>
                <div class="col-12 col-md-8" id="company_driver_details_container_{ID}" style="display:none;">
                    <div class="p-2 rounded h-100 driverclass" style="background-color: #fff1f1; border: 1px solid #ffc9c9;">
                        <div class="row g-1">
                            <div class="col-4 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Name</div>
                                <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_name_{ID}"></div>
                            </div>
                            <div class="col-4 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Contact Number</div>
                                <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_mobile_{ID}"></div>
                            </div>
                            <div class="col-4 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">License Number</div>
                                <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_license_no_{ID}"></div>
                            </div>
                            <div class="col-4 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">Issue Place</div>
                                <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_license_issue_place_{ID}"></div>
                            </div>
                            <div class="col-4 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">License Issue Date</div>
                                <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_licenseissueDate_{ID}"></div>
                            </div>
                            <div class="col-4 mb-1">
                                <div class="text-muted" style="font-size: 10px; line-height: 1.2;">License Expiry Date</div>
                                <div class="fw-semibold text-truncate driverClasstext" style="font-size: 11px; line-height: 1.2;" id="d_licenseexpiryDate_{ID}"></div>
                            </div>
                            <div class="col-12 mt-2" id="company_driver_docs_container_{ID}" style="display:none;">
                                <div class="text-muted mb-1" style="font-size: 10px; line-height: 1.2;">Driver Documents</div>
                                <ul id="company_driver_docs_preview_{ID}" class="list-unstyled d-flex align-items-center avatar-group mb-0"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h6 class="fw-bold text-danger mb-3">Rentout Images</h6>
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 border border-dashed rounded text-center mb-3">
                    <i class="ri-camera-lens-fill text-muted" style="font-size: 2rem;"></i>
                    <p class="mb-2 text-muted">Take photos or select images to auto-upload.</p>
                    <label for="carImages_{ID}" class="btn btn-outline-primary btn-sm rounded-pill" style="cursor: pointer;">
                        <i class="ri-camera-line me-1"></i> Capture / Select Images
                    </label>
                    <input type="file" id="carImages_{ID}" class="d-none dc-car-images" data-vid="{ID}" multiple accept="image/*" capture="environment">
                </div>
                <div id="preview_{ID}" class="d-flex flex-wrap gap-2 mt-3"></div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-outline-secondary btn-prev" onclick="dcWizardObj.previous()">Previous</button>
            <button class="btn btn-primary btn-next" onclick="dcWizardObj.next()">Next</button>
        </div>
    </div>
</template>

<!-- Template for Driver & Terms Tab -->
<!-- Template for Terms Tab -->
<template id="dc-tpl-terms">
    <div id="tab-dc-terms" class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-danger mb-0">Terms & Conditions</h6>
            <button id="dc_btn_terms_condition" class="btn btn-primary btn-sm">
                <span class="ri-settings-3-line me-1"></span> Manage Terms
            </button>
        </div>
        
        <div class="d-flex gap-4 mb-3 border-bottom pb-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dc_terms_option" id="dc_terms_default" value="default" checked>
                <label class="form-check-label fw-bold" for="dc_terms_default">
                    Default Terms
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dc_terms_option" id="dc_terms_custom" value="custom">
                <label class="form-check-label fw-bold" for="dc_terms_custom">
                    Custom Terms
                </label>
            </div>
        </div>
        
        <!-- Selected Term Title Display -->
        <div id="dc_selected_term_display" class="border rounded p-3 bg-light" style="min-height: 80px; margin-bottom:10px;">
            <div class="d-flex align-items-center h-100">
                <i class="ri-file-text-line fs-3 text-primary me-3"></i>
                <div>
                    <div class="text-muted small fw-bold text-uppercase mb-1" id="dc_selected_term_type_label">Default Term</div>
                    <h6 class="mb-0 fw-bold" id="dc_selected_term_title_label">
                        <div class="spinner-border spinner-border-sm text-secondary" role="status"></div> Loading...
                    </h6>
                </div>
            </div>
        </div>
        
        <!-- Hidden Editor -->
        <div id="dc_custom_terms_container" style="display: none;">
            <div id="dc-full-editor-onbody"></div>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-outline-secondary btn-prev" onclick="dcWizardObj.previous()">Previous</button>
            <button class="btn btn-primary btn-next" onclick="dcWizardObj.next()">Next</button>
        </div>
    </div>
</template>

<!-- Template for Signatures Tab -->
<template id="dc-tpl-signatures">
    <div id="tab-dc-signatures" class="content">
        <h6 class="fw-bold text-danger mb-3">Global Signatures</h6>
        <p class="text-muted small mb-4">These signatures will be applied to all generated contracts for the selected vehicles.</p>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="fw-bold">Hirer Signature</label>
                <input type="text" class="form-control mb-2" id="dc_hirer_name_wizard" placeholder="Hirer Name">
                <canvas id="dc_hirerCanvas_wizard" style="width:100%; height:250px; border:1px solid #ccc; border-radius:10px; background:#fff; touch-action: none;"></canvas>
                <button class="btn btn-danger btn-sm mt-2" id="dc_btnClearHirer_wizard">Clear</button>
            </div>
            <div class="col-md-6">
                <label class="fw-bold">Delivered By Signature</label>
                <input type="text" class="form-control mb-2" id="dc_delivery_name_wizard" placeholder="Delivered By Name">
                <canvas id="dc_deliveryCanvas_wizard" style="width:100%; height:250px; border:1px solid #ccc; border-radius:10px; background:#fff; touch-action: none;"></canvas>
                <button class="btn btn-danger btn-sm mt-2" id="dc_btnClearDelivery_wizard">Clear</button>
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-outline-secondary btn-prev" onclick="dcWizardObj.previous()">Previous</button>
        </div>
    </div>
</template>

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
