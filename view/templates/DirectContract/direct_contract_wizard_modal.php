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
        <h6 class="fw-bold text-danger mb-3">Customer & Booking Summary</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 rounded bg-light border">
                    <h6 class="fw-bold mb-2">Customer Info</h6>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Name</small>
                            <strong id="dc_c_name"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Contact</small>
                            <strong id="dc_c_mobile"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Email</small>
                            <strong id="dc_c_email"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">CPR/CR</small>
                            <strong id="dc_c_cpr"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Customer Code</small>
                            <strong id="dc_c_code"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Attention</small>
                            <strong id="dc_c_attention"></strong>
                        </div>
                        <div class="col-12 mb-2">
                            <small class="text-muted d-block">Address</small>
                            <strong id="dc_c_address"></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded bg-light border">
                    <h6 class="fw-bold mb-2">Contract Terms</h6>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">From Date</small>
                            <strong id="dc_b_from"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">To Date</small>
                            <strong id="dc_b_to"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Rate Type</small>
                            <strong id="dc_b_type"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Service</small>
                            <strong id="dc_b_service"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Duration</small>
                            <strong id="dc_b_duration"></strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Company</small>
                            <strong id="dc_b_company"></strong>
                        </div>
                        <div class="col-12 mb-2">
                            <small class="text-muted d-block">Total Vehicles</small>
                            <strong id="dc_b_vehicles"></strong>
                        </div>
                    </div>
                </div>
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
        <div class="row mb-3">
            <div class="col-12">
                <h6 class="fw-bold text-danger mb-1">Vehicle: {MODEL} ({PLATE})</h6>
                <small class="text-muted">Chassis: {CHASSIS} | Category: {CATEGORY}</small>
            </div>
        </div>
        
        <h6 class="fw-bold text-danger mb-3">Checklist & Handover</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input dc-chk" type="checkbox" id="chk_tools_{ID}">
                    <label class="form-check-label">Jack & Tools</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input dc-chk" type="checkbox" id="chk_tyre_{ID}">
                    <label class="form-check-label">Spare Tyre</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-check mb-2">
                    <input class="form-check-input dc-chk" type="checkbox" id="chk_aid_{ID}">
                    <label class="form-check-label">First Aid Kit</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input dc-chk" type="checkbox" id="chk_mats_{ID}">
                    <label class="form-check-label">Floor Mats</label>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row g-2">
                    <div class="col-4">
                        <label class="text-muted" style="font-size:11px;">Fuel Out (1-8)</label>
                        <select class="form-select form-select-sm dc-inp" id="fuel_out_{ID}">
                            <option value="1">1/8</option><option value="2">2/8</option>
                            <option value="3">3/8</option><option value="4">4/8 (Half)</option>
                            <option value="5">5/8</option><option value="6">6/8</option>
                            <option value="7">7/8</option><option value="8" selected>8/8 (Full)</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="text-muted" style="font-size:11px;">Odometer Out</label>
                        <input type="text" class="form-control form-control-sm dc-inp" id="odo_out_{ID}" value="{ODO}">
                    </div>
                    <div class="col-4">
                        <label class="text-muted" style="font-size:11px;">Salik Out</label>
                        <input type="text" class="form-control form-control-sm dc-inp" id="salik_out_{ID}">
                    </div>
                </div>
            </div>
        </div>
        
        <h6 class="fw-bold text-danger mb-2">Scratch Pad (Optional)</h6>
        <div class="row">
            <div class="col-md-8 text-center position-relative">
                <div style="position: relative; display: inline-block;">
                    <img src="assets/img/cars/car-top.jpg" style="width:100%; max-width:600px; border:1px solid #ccc; border-radius:8px;" class="car-base-img" />
                    <canvas id="scratchCanvas_{ID}" class="scratch-canvas" style="position: absolute; top:0; left:0; width:100%; height:100%; cursor:crosshair;"></canvas>
                </div>
                <div class="mt-2 text-start">
                    <button class="btn btn-sm btn-outline-danger btn-clear-canvas" data-vid="{ID}">Clear Scratches</button>
                    <small class="text-muted ms-2">Click and drag on the car image to mark damages.</small>
                </div>
            </div>
            <div class="col-md-4">
                <label class="text-muted" style="font-size:11px;">Additional Notes</label>
                <textarea class="form-control dc-inp" id="vehicle_notes_{ID}" rows="4" placeholder="Any specific notes for this vehicle..."></textarea>
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-outline-secondary btn-prev" onclick="dcWizardObj.previous()">Previous</button>
            <button class="btn btn-primary btn-next" onclick="dcWizardObj.next()">Next</button>
        </div>
    </div>
</template>

<!-- Template for Driver & Terms Tab -->
<template id="dc-tpl-driver-terms">
    <div id="tab-dc-driver-terms" class="content">
        <h6 class="fw-bold text-danger mb-3">Driver Details & Terms</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-12">
                <label class="text-muted" style="font-size:11px;">Driver Name</label>
                <input type="text" class="form-control" id="dc_driver_name" placeholder="Enter driver name">
            </div>
            <div class="col-md-6">
                <label class="text-muted" style="font-size:11px;">Driver License No</label>
                <input type="text" class="form-control" id="dc_driver_license" placeholder="Enter license number">
            </div>
            <div class="col-md-6">
                <label class="text-muted" style="font-size:11px;">License Expiry</label>
                <input type="date" class="form-control" id="dc_driver_expiry">
            </div>
        </div>
        
        <h6 class="fw-bold text-danger mb-2">Terms & Conditions</h6>
        <div class="border rounded p-3 bg-light">
            <p class="mb-0 text-muted small">The generated contracts will use the default system Terms & Conditions.</p>
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
