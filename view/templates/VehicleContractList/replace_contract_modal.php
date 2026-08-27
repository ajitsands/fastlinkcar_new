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

          <div class="col-12">
            <div class="card border border-primary-subtle shadow-sm mb-2">
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
          </div>

          <!-- BOOKINGS & EXTENSIONS LIST -->
          <div class="col-12 d-none">
             <div class="accordion" id="acc_replace_bookings">
               <div class="accordion-item mb-1">
                 <h2 class="accordion-header fw-bold">
                   <button class="accordion-button text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#replace_bookingsSec">
                     <i class="ri-file-list-line me-1"></i> Bookings & Extensions Details
                   </button>
                 </h2>
                 <div id="replace_bookingsSec" class="accordion-collapse collapse show">
                   <div class="accordion-body">
                     <div class="table-responsive">
                       <table id="contractReplaceTable" class="table table-bordered table-sm align-middle w-100">
                         <thead class="table-light">
                           <tr>
                             <th>#</th>
                             <th>Date</th>
                             <th>Period</th>
                             <th>Details</th>
                             <th>Pricing</th>
                             <th>Notes</th>
                           </tr>
                         </thead>
                       </table>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
          </div>

          <!-- SECTION 2: OLD VEHICLE RETURN & VIOLATIONS -->
          <div class="col-12">
             <div class="card border border-danger mb-3">
               <div class="card-header bg-danger-subtle text-danger fw-bold d-flex justify-content-between align-items-center">
                 <span><i class="ri-logout-box-r-line me-1"></i> STEP 1: RETURN OLD VEHICLE DETAILS & TRAFFIC VIOLATIONS</span>
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
                           <label for="replace_old_km_out">KM Out</label>
                         </div>
                       </div>
                       <div class="col-6 col-md-3">
                         <div class="form-floating form-floating-outline">
                           <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" id="replace_old_km_in" class="form-control form-control-sm" placeholder="Enter KM In">
                           <label for="replace_old_km_in">KM In *</label>
                         </div>
                       </div>
                       <div class="col-6 col-md-3">
                         <div class="form-floating form-floating-outline">
                           <input type="text" id="replace_old_km_used" class="form-control form-control-sm bg-light" readonly>
                           <label for="replace_old_km_used">KM Used</label>
                         </div>
                       </div>
                       <div class="col-6 col-md-3">
                         <div class="form-floating form-floating-outline">
                           <input type="text" id="replace_old_fuel_in" class="form-control form-control-sm" placeholder="e.g. Full, Half">
                           <label for="replace_old_fuel_in">Fuel In</label>
                         </div>
                       </div>
                       <div class="col-12 col-md-6">
                         <div class="form-floating form-floating-outline">
                           <input type="datetime-local" id="replace_old_dt_out" class="form-control form-control-sm" readonly>
                           <label for="replace_old_dt_out">Date Time Out</label>
                         </div>
                       </div>
                       <div class="col-12 col-md-6">
                         <div class="form-floating form-floating-outline">
                           <input type="datetime-local" id="replace_old_dt_in" class="form-control form-control-sm">
                           <label for="replace_old_dt_in">Date Time In *</label>
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
                       <div class="progress mb-2" style="height:6px;">
                         <div class="progress-bar bg-danger" id="replace_old_return_progressBar" style="width:0%"></div>
                       </div>
                       <button type="button" id="replace_old_return_uploadBtn" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1">
                         <span class="spinner-border spinner-border-sm d-none" id="replace_old_return_loader" role="status" aria-hidden="true"></span>
                         <i class="ri-upload-cloud-line me-1" id="replace_old_return_icon"></i> Upload Return Images
                       </button>
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
          </div>

          <!-- SECTION 3: NEW REPLACEMENT VEHICLE SELECTION & RENT OUT -->
          <div class="col-12">
             <div class="card border border-success">
               <div class="card-header bg-success-subtle text-success fw-bold d-flex justify-content-between align-items-center">
                 <span><i class="ri-login-box-r-line me-1"></i> STEP 2: SELECT NEW REPLACEMENT VEHICLE & RENT OUT CHECKLIST</span>
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

                      <!-- Selected Vehicle Card (Exact App vehicle-card Style) -->
                      <div id="replace_new_veh_card" class="vehicle-card d-flex flex-column p-2 border rounded shadow-sm position-relative bg-white d-none mt-2">
                        <div class="d-flex align-items-center">
                          <div class="me-2 vehicle-image">
                            <img id="replace_new_v_img" src="uploads/vehicleImages/default.jpg" class="rounded-circle border" style="width:60px;height:60px;object-fit:cover;" onerror="this.src='uploads/vehicleImages/default.jpg';">
                          </div>

                          <div class="flex-grow-1">
                            <h5 class="card-title mb-0 veh_no text-dark fw-bold" id="replace_new_v_no">-</h5>

                            <div class="text-muted small fw-bold text-dark" id="replace_new_v_title">-</div>

                            <div class="d-flex align-items-center gap-2 mt-1 small text-muted flex-wrap">
                              <span><i class="icon-base ri ri-calendar-check-line me-1"></i><span id="replace_new_v_year">-</span></span>
                              <span><i class="icon-base ri ri-palette-line me-1"></i><span id="replace_new_v_color">-</span></span>
                              <span><i class="icon-base ri ri-gas-station-line me-1"></i><span id="replace_new_v_fuel">Petrol</span></span>
                            </div>

                            <div class="mt-1 d-flex align-items-center gap-2">
                              <span><i class="icon-base ri ri-car-line me-1"></i><span id="replace_new_v_gear">Automatic</span></span>
                              <span class="badge rounded-pill bg-success text-white" id="replace_new_v_status">Available</span>
                            </div>
                          </div>

                          <!-- BUTTONS -->
                          <div class="d-flex flex-column gap-2 ms-2">
                            <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 action-btn btn_vehicle_view" id="replace_new_v_view_btn" data-id="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View Details">
                              <i class="ri ri-information-2-line icon-18px"></i>
                            </button>
                          </div>
                        </div>

                        <!-- BOTTOM SECTION -->
                        <div class="mt-3 small text-muted border-top pt-2">
                          <div class="d-flex justify-content-between">
                            <span><i class="ri-calendar-check-line text-success me-1"></i>Passing</span>
                            <span id="replace_new_v_passing">NA</span>
                          </div>

                          <div class="d-flex justify-content-between">
                            <span><i class="ri-shield-check-line text-info me-1"></i>Insurance</span>
                            <span id="replace_new_v_insurance">NA</span>
                          </div>

                          <div class="d-flex justify-content-between">
                            <span><i class="ri-tools-line text-danger me-1"></i>Maintenance</span>
                            <span id="replace_new_v_maintenance">NA</span>
                          </div>
                        </div>

                        <!-- Hidden helper elements -->
                        <span id="replace_new_v_category" class="d-none"></span>
                        <span id="replace_new_v_model" class="d-none"></span>
                        <span id="replace_new_v_fuel_level" class="d-none"></span>
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
                           <label for="replace_new_km_out">KM Out (New) *</label>
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
                           <label for="replace_new_dt_out">Date Out (New)</label>
                         </div>
                       </div>
                     </div>

                     <!-- New Vehicle Rentout Images Upload -->
                     <div class="mb-2">
                       <label class="form-label fw-semibold text-dark">Upload Replacement Vehicle Rentout Images</label>
                       <input type="file" id="replace_new_car_images" class="form-control form-control-sm mb-2" multiple accept="image/*" capture="environment">
                       <div id="replace_new_preview" class="d-flex flex-wrap gap-2 mb-2"></div>
                       <div class="progress mb-2" style="height:6px;">
                         <div class="progress-bar bg-success" id="replace_new_progressBar" style="width:0%"></div>
                       </div>
                       <button type="button" id="replace_new_uploadBtn" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1">
                         <span class="spinner-border spinner-border-sm d-none" id="replace_new_loader" role="status" aria-hidden="true"></span>
                         <i class="ri-upload-cloud-line me-1" id="replace_new_icon"></i> Upload Rentout Images
                       </button>
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
                          <div class="form-floating form-floating-outline mb-2">
                            <input type="text" id="replace_staff_name" class="form-control" placeholder="Enter Staff Name" value="<?php echo htmlspecialchars($_SESSION['profile_name'] ?? $_SESSION['user_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <label for="replace_staff_name">Responsible Staff Name</label>
                          </div>
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
          </div>

        </div>
      </div>

      <!-- FOOTER -->
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary px-4 ladda-button" id="btn_submit_replace_contract">
          <span class="ladda-label"><i class="ri-refresh-line me-1"></i> Replace Vehicle</span>
        </button>
      </div>

    </div>
  </div>
</div>