<div class="modal fade" id="ReplacecontractModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header bg-primary text-white">
        <div>
          <h5 class="mb-0 text-white"><i class="ri-repeat-line me-1"></i> Replace Vehicle</h5>
          <small>
           Agreement No: <span class="fw-bold" id="replace_agreement_ref"></span>
          </small>
        </div>
        <input type="hidden" value="" id="txt_replace_modal_agreement_id">
        <input type="hidden" value="" id="txt_replace_modal_agreement_no">
        <input type="hidden" value="" id="txt_replace_modal_booking_ids">
        
        <input type="hidden" value="" id="replace_old_hid_vehicle_id">
        <input type="hidden" value="" id="replace_old_hid_category_id">
        <input type="hidden" value="" id="replace_old_hid_model_id">
        <input type="hidden" value="" id="replace_old_hid_vehicle_no">

        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="row g-3">
          
          <!-- SECTION 1: CUSTOMER & CONTRACT DETAILS -->
          <div class="col-12 col-md-6 d-none">
             <div class="accordion" id="acc_replace_customer">
               <div class="accordion-item mb-1">
                 <h2 class="accordion-header fw-bold">
                   <button class="accordion-button text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#replace_custSec">
                     <i class="ri-user-line me-1"></i> Customer Details
                   </button>
                 </h2>
                 <div id="replace_custSec" class="accordion-collapse collapse show">
                   <div class="accordion-body">
                     <div class="row g-2 fs-6">
                       <div class="col-12 col-md-6 d-flex justify-content-between">
                         <span class="text-muted">Customer Name:</span>
                         <span class="fw-semibold" id="replace_c_name"></span>
                       </div>
                       <div class="col-12 col-md-6 d-flex justify-content-between">
                         <span class="text-muted">Customer Code:</span>
                         <span class="fw-semibold" id="replace_c_code"></span>
                       </div>
                       <div class="col-12 col-md-6 d-flex justify-content-between">
                         <span class="text-muted">Contact Number:</span>
                         <span class="fw-semibold" id="replace_c_mobile"></span>
                       </div>
                       <div class="col-12 col-md-6 d-flex justify-content-between">
                         <span class="text-muted">Email:</span>
                         <span class="fw-semibold" id="replace_c_email"></span>
                       </div>
                       <div class="col-12 col-md-6 d-flex justify-content-between">
                         <span class="text-muted">Attn:</span>
                         <span class="fw-semibold" id="replace_c_attn"></span>
                       </div>
                       <div class="col-12 col-md-6 d-flex justify-content-between">
                         <span class="text-muted">Address:</span>
                         <span class="fw-semibold" id="replace_c_attr"></span>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
          </div>



          <!-- SECTION 2: OLD VEHICLE RETURN & VIOLATIONS (Stepper Wrapper) -->
          <div class="col-12 mt-2">
            <div id="replaceVehicleStepper" class="bs-stepper linear">
              <div class="bs-stepper-header" role="tablist">
                <div class="step" data-target="#replace-step-1">
                  <button type="button" class="step-trigger" role="tab" id="replace-step-1-trigger">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">
                      <span class="bs-stepper-title">Return Old Vehicle</span>
                    </span>
                  </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#replace-step-2">
                  <button type="button" class="step-trigger" role="tab" id="replace-step-2-trigger">
                    <span class="bs-stepper-circle">2</span>
                    <span class="bs-stepper-label">
                      <span class="bs-stepper-title">Select Replacement</span>
                    </span>
                  </button>
                </div>
              </div>
              <div class="bs-stepper-content pt-3">
                <form id="replaceVehicleForm" onSubmit="return false">
                  <!-- Step 1: Return Old Vehicle -->
                  <div id="replace-step-1" class="content">

                    <div class="card border border-primary-subtle shadow-sm mb-3">
                      <div class="card-header bg-primary-subtle text-primary fw-bold py-2 d-flex align-items-center justify-content-between">
                        <span><i class="ri-car-line me-1"></i> Current Contract Vehicle Info</span>
                        <span id="replace_v_brand" class="d-none"></span>
                        <span id="replace_v_passing" class="d-none"></span>
                        <span id="replace_v_maintenance" class="d-none"></span>
                      </div>
                      <div class="card-body py-3">
                        <div class="row g-3 fs-6">
                          <div class="col-6 col-md-4 col-lg-2">
                            <span class="text-muted small d-block mb-1"><i class="ri-price-tag-3-line me-1"></i>Category</span>
                            <span class="fw-semibold text-dark" id="replace_v_category">-</span>
                          </div>
                          <div class="col-6 col-md-4 col-lg-2">
                            <span class="text-muted small d-block mb-1"><i class="ri-car-fill me-1"></i>Model</span>
                            <span class="fw-semibold text-dark" id="replace_v_model">-</span>
                          </div>
                          <div class="col-6 col-md-4 col-lg-2">
                            <span class="text-muted small d-block mb-1"><i class="ri-hashtag me-1"></i>Vehicle No</span>
                            <span class="fw-semibold text-dark" id="replace_v_no">-</span>
                          </div>
                          <div class="col-6 col-md-4 col-lg-2">
                            <span class="text-muted small d-block mb-1"><i class="ri-palette-line me-1"></i>Color</span>
                            <span class="fw-semibold text-dark" id="replace_v_color">-</span>
                          </div>
                          <div class="col-6 col-md-4 col-lg-2">
                            <span class="text-muted small d-block mb-1"><i class="ri-calendar-line me-1"></i>Year</span>
                            <span class="fw-semibold text-dark" id="replace_v_year">-</span>
                          </div>
                          <div class="col-6 col-md-4 col-lg-2">
                            <span class="text-muted small d-block mb-1"><i class="ri-shield-check-line me-1"></i>Next Insurance</span>
                            <span class="fw-semibold text-dark" id="replace_v_insurance">-</span>
                          </div>
                        </div>
                      </div>
                    </div>



                     <div class="card border border-danger mb-0">
                       <div class="card-header bg-danger-subtle text-danger fw-bold d-flex justify-content-between align-items-center">
                         <span><i class="ri-logout-box-r-line me-1"></i> OLD VEHICLE DETAILS & TRAFFIC VIOLATIONS</span>
                         <span class="badge bg-danger text-white fs-6" id="badge_old_veh_no"></span>
                       </div>
               <div class="card-body">
                 <div class="row g-3 mt-1">
                   
                   <!-- Old Vehicle Checklist & Metrics -->
                   <div class="col-12 col-lg-6">
                     <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="ri-checkbox-multiple-line"></i> Old Vehicle Return Checklist</h6>
                     <div class="row g-2 mb-3">
                       <div class="col-md-4">
                         <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="chk_replace_old_tools" disabled style="pointer-events:none;">
                           <label class="form-check-label" for="chk_replace_old_tools">Jack & Tools</label>
                         </div>
                       </div>
                       <div class="col-md-4">
                         <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="chk_replace_old_spare" disabled style="pointer-events:none;">
                           <label class="form-check-label" for="chk_replace_old_spare">Spare Tyre</label>
                         </div>
                       </div>
                       <div class="col-md-4">
                         <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="chk_replace_old_radio" disabled style="pointer-events:none;">
                           <label class="form-check-label" for="chk_replace_old_radio">Radio</label>
                         </div>
                       </div>
                     </div>

                     <div class="row g-2">
                       <div class="col-6 col-md-3">
                         <div class="form-floating form-floating-outline">
                           <input type="text" id="replace_old_km_out" class="form-control form-control-sm" readonly>
                           <label for="replace_old_km_out">Rentout Odometer reading</label>
                         </div>
                       </div>
                       <div class="col-6 col-md-3">
                         <div class="form-floating form-floating-outline">
                           <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="replace_old_km_in" class="form-control form-control-sm" placeholder="Enter Return Odometer reading">
                           <label for="replace_old_km_in">Return Odometer reading *</label>
                         </div>
                       </div>
                       <div class="col-6 col-md-3">
                         <div class="form-floating form-floating-outline">
                           <input type="text" id="replace_old_km_used" class="form-control form-control-sm bg-light" readonly>
                           <label for="replace_old_km_used">Odometer difference</label>
                         </div>
                       </div>
                       <div class="col-6 col-md-3">
                         <div class="form-floating form-floating-outline">
                           <input type="text" id="replace_old_fuel_in" class="form-control form-control-sm" placeholder="e.g. Full, Half">
                           <label for="replace_old_fuel_in">Fuel Level</label>
                         </div>
                       </div>
                       <div class="col-12 col-md-6">
                         <div class="form-floating form-floating-outline">
                           <input type="datetime-local" id="replace_old_dt_out" class="form-control form-control-sm" readonly>
                           <label for="replace_old_dt_out">Vehicle Out Date Time</label>
                         </div>
                       </div>
                       <div class="col-12 col-md-6">
                         <div class="form-floating form-floating-outline">
                           <input type="datetime-local" id="replace_old_dt_in" class="form-control form-control-sm">
                           <label for="replace_old_dt_in">Vehicle In Date Time *</label>
                         </div>
                       </div>
                     </div>

                     <!-- Old Vehicle Rentout Images Preview -->
                     <div class="mt-3">
                       <label class="form-label fw-semibold text-muted">Old Vehicle Rentout Images</label>
                       <div id="replace_old_preview" class="d-flex flex-wrap gap-2 p-2 border rounded bg-light" style="min-height:60px;"></div>
                     </div>

                     <!-- Old Vehicle Return Images Upload -->
                     <div class="mt-3">
                       <label class="form-label fw-semibold text-dark">Upload Old Vehicle Return Images</label>
                       <input type="file" id="replace_old_return_car_images" class="form-control form-control-sm mb-2" multiple accept="image/*" capture="environment">
                       <div id="replace_old_return_preview" class="d-flex flex-wrap gap-2 mb-2"></div>
                     </div>
                   </div>

                   <!-- Old Vehicle Traffic Violations Section -->
                   <div class="col-12 col-lg-6 border-start ps-lg-3">
                     <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="ri-alarm-warning-line"></i> Traffic Violations (Current Vehicle)</h6>
                     
                     <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                       <div>
                         <a href="https://services.bahrain.bh" target="_blank" rel="noopener noreferrer" class="text-primary fw-bold text-decoration-underline d-inline-flex align-items-center gap-1 fs-6">
                           Check Traffic Violations on services.bahrain.bh <i class="ri ri-external-link-line fs-5 ms-1"></i>
                         </a>
                       </div>
                       <div class="d-flex gap-2">
                         <button type="button" class="btn btn-sm btn-outline-primary" id="btn_replace_add_violation_head_master">
                           <i class="ri-add-line me-1"></i> Add Master
                         </button>
                         <button type="button" class="btn btn-sm btn-primary" id="btn_replace_add_violation_row">
                           <i class="ri-add-line me-1"></i> Add Violation
                         </button>
                       </div>
                     </div>

                     <datalist id="violation_heads_list"></datalist>
                     <div class="table-responsive mb-3">
                       <table class="table table-bordered align-middle table-sm" id="table_replace_violations">
                         <thead class="table-light">
                           <tr>
                             <th width="4%" class="text-center">#</th>
                             <th width="15%">Violation Date</th>
                             <th width="24%">Violation Title</th>
                             <th width="18%">Fees (BHD)</th>
                             <th width="33%">Remarks</th>
                             <th width="6%" class="text-center">Action</th>
                           </tr>
                         </thead>
                         <tbody id="replace_violations_tbody">
                           <!-- Dynamic violation rows -->
                         </tbody>
                       </table>
                     </div>

                     <div class="form-check">
                       <input class="form-check-input" type="checkbox" id="chk_replace_violations_checked">
                       <label class="form-check-label fw-semibold text-danger" for="chk_replace_violations_checked">
                         I have checked traffic violations for this vehicle.
                       </label>
                     </div>
                   </div>

                 </div>
                </div>
              </div>
              <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-next" id="btn_replace_next_step">
                  <span class="align-middle d-sm-inline-block d-none">Next</span> <i class="ri-arrow-right-line"></i>
                </button>
              </div>
            </div>

          <!-- SECTION 3: NEW REPLACEMENT VEHICLE SELECTION & RENT OUT -->
          <!-- Step 2: Select Replacement -->
          <div id="replace-step-2" class="content">
             <div class="card border border-success mb-0">
               <div class="card-header bg-success-subtle text-success fw-bold d-flex justify-content-between align-items-center">
                 <span><i class="ri-login-box-r-line me-1"></i> NEW REPLACEMENT VEHICLE & RENT OUT CHECKLIST</span>
                 <span class="badge bg-success text-white fs-6">Available Vehicles</span>
               </div>
               <div class="card-body">
                 <div class="row g-3 mt-1">
                   
                   <!-- Select Replacement Vehicle -->
                   <div class="col-12 col-md-6">
                     <div class="form-floating form-floating-outline mb-3">
                       <select id="replace_select_new_vehicle" class="select2 form-select form-select-sm" style="width:100%" data-allow-clear="true">
                         <option value="">-- Select Replacement Vehicle --</option>
                       </select>
                       <label for="replace_select_new_vehicle">Choose Available Vehicle *</label>
                     </div>

                       <!-- Selected Vehicle Card (DirectContract App Style) -->
                       <div id="replace_new_veh_card" class="d-none mt-2">
                         <div class="card h-100 shadow-sm border-0 vehicle-card rounded-4 overflow-hidden" style="transition: transform 0.2s, box-shadow 0.2s;">
                           <div class="row g-0 h-100">
                             <!-- Left Side Image -->
                             <div class="col-5 bg-white border-end position-relative vehicle-image p-0" style="cursor:pointer; min-height:140px;">
                               <img id="replace_new_v_img" src="uploads/vehicleImages/default.jpg" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:contain;object-position:center;padding:0.5rem;" alt="Vehicle Image" onerror="this.src='uploads/vehicleImages/default.jpg';">
                               <span class="badge rounded-pill bg-success shadow-sm position-absolute top-0 start-0 m-2" id="replace_new_v_status_badge" style="font-size:0.65rem;">Available</span>
                             </div>
                             <!-- Right Side Details -->
                             <div class="col-7">
                               <div class="card-body p-2 d-flex flex-column h-100">
                                 <div class="mb-2">
                                   <h5 class="mb-0 fw-bold text-danger text-truncate" id="replace_new_v_no">-</h5>
                                   <small class="text-body fw-semibold text-truncate d-block" id="replace_new_v_title" style="font-size:0.95rem;">-</small>
                                 </div>
                                 <div class="row g-1 mb-2 mt-auto" style="font-size:0.85rem;">
                                   <div class="col-12 d-flex align-items-center text-truncate text-secondary fw-semibold">
                                     <i class="ri ri-barcode-line me-1"></i> <span id="replace_new_v_chassis">N/A</span>
                                   </div>
                                   <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                     <i class="ri ri-calendar-check-line me-1"></i> <span id="replace_new_v_year">-</span>
                                   </div>
                                   <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                     <i class="ri ri-palette-line me-1"></i> <span id="replace_new_v_color">-</span>
                                   </div>
                                   <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                     <i class="ri ri-gas-station-line me-1"></i> <span id="replace_new_v_fuel">Petrol</span>
                                   </div>
                                   <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                     <i class="ri ri-car-line me-1"></i> <span id="replace_new_v_gear">Automatic</span>
                                   </div>
                                 </div>
                                 <div class="d-flex gap-1 border-top pt-2 mt-auto">
                                   <button type="button" class="btn btn-sm btn-outline-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_view px-1" id="replace_new_v_view_btn" data-id="" data-bs-toggle="tooltip" title="View Details" style="font-size:0.85rem;">
                                     <i class="ri ri-information-2-line me-1"></i> Details
                                   </button>
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                         <!-- Hidden helper fields -->
                         <span id="replace_new_v_category" class="d-none"></span>
                         <span id="replace_new_v_model" class="d-none"></span>
                         <span id="replace_new_v_fuel_level" class="d-none"></span>
                         <span id="replace_new_v_status" class="d-none"></span>
                         <span id="replace_new_v_passing" class="d-none"></span>
                         <span id="replace_new_v_insurance" class="d-none"></span>
                         <span id="replace_new_v_maintenance" class="d-none"></span>
                        </div>
                    </div>

                   <!-- New Vehicle Rentout Checklist & Images -->
                   <div class="col-12 col-md-6">
                     <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="ri-checkbox-circle-line"></i> Replacement Vehicle Rentout Checklist</h6>
                     <div class="row g-2 mb-3">
                       <div class="col-md-4">
                         <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="chk_replace_new_tools">
                           <label class="form-check-label" for="chk_replace_new_tools">Jack & Tools</label>
                         </div>
                       </div>
                       <div class="col-md-4">
                         <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="chk_replace_new_spare">
                           <label class="form-check-label" for="chk_replace_new_spare">Spare Tyre</label>
                         </div>
                       </div>
                       <div class="col-md-4">
                         <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="chk_replace_new_radio">
                           <label class="form-check-label" for="chk_replace_new_radio">Radio</label>
                         </div>
                       </div>
                     </div>

                     <div class="row g-2 mb-3">
                       <div class="col-6 col-md-4">
                         <div class="form-floating form-floating-outline">
                           <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="replace_new_km_out" class="form-control form-control-sm" placeholder="0">
                           <label for="replace_new_km_out">Rentout Km (New) *</label>
                         </div>
                       </div>
                       <div class="col-6 col-md-4">
                         <div class="form-floating form-floating-outline">
                           <input type="text" id="replace_new_fuel_out" class="form-control form-control-sm" placeholder="e.g. Full">
                           <label for="replace_new_fuel_out">Fuel Out (New)</label>
                         </div>
                       </div>
                       <div class="col-12 col-md-4">
                         <div class="form-floating form-floating-outline">
                           <input type="datetime-local" id="replace_new_dt_out" class="form-control form-control-sm">
                           <label for="replace_new_dt_out">Rentout Date (New)</label>
                         </div>
                       </div>
                     </div>

                     <!-- New Vehicle Rentout Images Upload -->
                     <div class="mb-2">
                       <label class="form-label fw-semibold text-dark">Upload Replacement Vehicle Rentout Images</label>
                       <input type="file" id="replace_new_car_images" class="form-control form-control-sm mb-2" multiple accept="image/*" capture="environment">
                       <div id="replace_new_preview" class="d-flex flex-wrap gap-2 mb-2"></div>
                     </div>
                   </div>

                    <!-- Replacement Reason / Remarks -->
                    <div class="col-12">
                      <div class="form-floating form-floating-outline">
                        <textarea id="replace_remarks" class="form-control" style="height:70px;" placeholder="Reason for replacement..."></textarea>
                        <label for="replace_remarks">Replacement Remarks / Reason for Replacement</label>
                      </div>
                    </div>

                    <!-- Responsible Staff Name & Signature Section -->
                    <div class="col-12 mt-3 pt-3 border-top">
                      <h6 class="fw-bold text-dark mb-3"><i class="ri-user-follow-line"></i> Responsible Staff Details</h6>
                      <div class="row g-3 align-items-start">
                        <div class="col-12 col-md-5">
                          <label class="form-label fw-semibold text-dark mb-1" for="replace_staff_name">Responsible Staff Name</label>
                          <input type="text" id="replace_staff_name" class="form-control" placeholder="Enter Staff Name" value="<?php echo htmlspecialchars($_SESSION['profile_name'] ?? $_SESSION['user_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="col-12 col-md-7">
                          <label class="form-label fw-semibold text-dark mb-1">Responsible Staff Signature</label>
                          <div class="p-1 border rounded bg-white">
                            <canvas id="ReplaceStaffSignature-pad" width="600" height="150" style="width:100%; border:1px solid #ccc; border-radius:5px; background:#fff; touch-action: none;"></canvas>
                          </div>
                          <div class="mt-2 d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="clear_replacestaffsignature">
                              <i class="ri-erase-line me-1"></i> Clear Signature
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary btn-prev" id="btn_replace_prev_step">
                  <i class="ri-arrow-left-line"></i> <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button type="button" class="btn btn-success px-4 ladda-button" id="btn_submit_replace_contract">
                  <span class="ladda-label"><i class="ri-refresh-line me-1"></i> Replace Vehicle</span>
                </button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>

        </div>
      </div>

    </div>
  </div>
</div>