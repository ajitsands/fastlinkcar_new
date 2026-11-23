<form id="VehicleDetailsForm" name="VehicleDetailsForm">

<div class="layout-demo-placeholder ">
	
	<div class="container-fluid flex-grow-1 container-p-y">

                <!-- Insurance & Passing Expiry Notification Banner -->
                <div id="vehicleExpiryAlertBanner" class="mb-3" style="display: none;"></div>
               
                <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                      <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                          <h5 class="card-title mb-0">
                              <i class="ri-car-line me-2 text-primary"></i>Vehicle Registration Details
                          </h5>
                          <div class="d-flex align-items-center gap-2">
                              <button type="button" id="btnViewVehicleProfile" class="btn btn-sm btn-outline-info d-none">
                                  <i class="ri-eye-line me-1"></i> View Profile
                              </button>
                              <button type="button" id="btnOpenInsPassModal" class="btn btn-sm btn-outline-success d-none">
                                  <i class="ri-add-circle-line me-1"></i> Insurance / Passing
                              </button>
                              <a href="/VehicleInsurance?val=<?= urlencode($this->encryption->encrypt('2,2-10')) ?>" class="btn btn-sm btn-outline-primary">
                                  <i class="ri-shield-check-line me-1"></i> Vehicle Insurance
                              </a>
                              <div id="statusBadgeContainer">
                                  <span class="badge bg-label-success" id="vehicleStatusBadge">New Entry</span>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                        

                       <div class="row g-3 mb-4">

                          <!-- Registration Company Access -->
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-3">
                              <select id="belongsToCompanyID" name="belongsToCompanyID" class="form-select">
                              </select>
                              <label for="belongsToCompanyID">Registration Company <span class="text-danger">*</span></label>
                            </div>
                          </div>

                          <!-- Is Outsourced Vehicle -->
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-3">
                              <select id="isOutsourced" name="is_outsourced" class="form-select">
                                <option value="No" selected>No (Own Fleet)</option>
                                <option value="Yes">Yes (Outsourced)</option>
                              </select>
                              <label for="isOutsourced">Is Outsourced Vehicle?</label>
                            </div>
                          </div>

                          <!-- Outsourcing Company List -->
                          <div class="col-12 col-md-6 col-lg-4" id="outsourcingCompanyContainer" style="display: none;">
                            <div class="form-floating form-floating-outline mb-3">
                              <select id="outsourcingCompanyId" name="outsourcing_company_id" class="form-select">
                                <option value="" disabled selected>Select Outsourcing Company</option>
                              </select>
                              <label for="outsourcingCompanyId">Outsourcing Company <span class="text-danger">*</span></label>
                            </div>
                          </div>

                          <!-- Vehicle Model -->
                          <div class="col-12 col-md-6 col-lg-3">
                              <div class="form-floating form-floating-outline mb-5">
                               <div id="dropdownContainer">
                                
                                </div>
                            </div>
                          </div>
                        
                          <!-- Vehicle Number -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="vehicleNumber" placeholder="Vehicle Number" name="vehicleNumber">
                              <label for="vehicleNumber">Vehicle Number <span class="text-danger">*</span></label>
                            </div>
                          </div>
                        
                          <!-- Chassis Number -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="chassisNumber" placeholder="Chassis Number" name="chassisNumber">
                              <label for="chassisNumber">Chassis Number</label>
                            </div>
                          </div>
                        
                          <!-- Vehicle Year -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="number" class="form-control" id="vehicleYear" name="vehicleYear" placeholder="Vehicle Year">
                              <label for="vehicleYear">Year <span class="text-danger">*</span></label>
                            </div>
                          </div>
                        
                          <!-- Vehicle Color -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="input-group mb-3">
                              <div class="form-floating form-floating-outline">
                                <select id="vehicleColor" name="vehicleColor" class="form-select">
                                  <option value="">Select a Color</option>
                                </select>
                                <label for="vehicleColor">Car Color <span class="text-danger">*</span></label>
                              </div>
                              <button type="button" class="btn btn-outline-primary btn-add-lookup" data-lookup-type="color" data-lookup-label="Car Color" title="Add New Color">+</button>
                            </div>
                          </div>

                          <!-- Purchase date -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-3">
                              <input type="date" class="form-control" id="vehiclePurchaseDate" placeholder="dd-mm-yyyy" name="vehiclePurchaseDate" aria-label="Purchase Date">
                              <label for="vehiclePurchaseDate">Purchase Date</label>
                            </div>
                          </div>

                          <!-- Purchase Cost -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="input-group mb-3">
                              <span class="input-group-text">BHD</span>
                              <div class="form-floating form-floating-outline">
                                <input 
                                  type="number" 
                                  step="0.01" 
                                  class="form-control" 
                                  id="purchasePrice" name="purchasePrice" 
                                  placeholder="Purchase Cost">
                                <label for="purchasePrice">Purchase Cost</label>
                              </div>
                            </div>
                          </div>

                          <!-- Next Passing Date (hidden on registration; managed via Insurance & Passings) -->
                          <div class="col-12 col-md-6 col-lg-3 d-none">
                            <div class="form-floating form-floating-outline mb-3">
                              <input type="date" class="form-control" id="vehiclePassingDate" name="vehiclePassingDate">
                              <label for="vehiclePassingDate">Next Passing Date</label>
                            </div>
                          </div>

                          <!-- Next Insurance Date (hidden on registration; managed via Insurance & Passings) -->
                          <div class="col-12 col-md-6 col-lg-3 d-none">
                            <div class="form-floating form-floating-outline mb-3">
                              <input type="date" class="form-control" id="vehicleInsuranceExpDate" name="vehicleInsuranceExpDate">
                              <label for="vehicleInsuranceExpDate">Next Insurance Date</label>
                            </div>
                          </div>

                          <!-- Status -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-3">
                              <select id="vehicleStatus" name="vehicleStatus" class="form-select">
                                <option value="Available" selected>Available</option>
                                <option value="Rented">Rented</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="For Sale">For Sale</option>
                                <option value="Staff">Staff</option>
                                <option value="Sold">Sold</option>
                              </select>
                              <label for="vehicleStatus">Status</label>
                            </div>
                          </div>

                          <!-- Active -->
                          <div class="col-12 col-md-6 col-lg-3 d-flex align-items-center">
                            <div class="form-check form-switch mb-3">
                              <input class="form-check-input" type="checkbox" id="vehicleIsActive" name="vehicleIsActive" value="1" checked>
                              <label class="form-check-label fw-semibold" for="vehicleIsActive">Active</label>
                            </div>
                          </div>
                          
                          <!-- Model Pricing Preview (Read-Only from Vehicle Master Configuration) -->
                          <div class="col-12" id="modelPricingPreviewWrapper" style="display: none;">
                            <div id="modelPricingPreview" class="p-3 rounded border bg-light mb-2"></div>
                          </div>

                         <div class="col-12">
                              <div class="form-floating form-floating-outline mb-3">
                                  <textarea 
                                      class="form-control" 
                                      id="vehicleDescription" 
                                      name="vehicleDescription" 
                                      placeholder="Vehicle Description"
                                      style="height: 100px;"></textarea>
                                
                                <label for="vehicleDescription">More Descriptions</label>
                              </div>
                            </div>

                          <!-- Other Details Section -->
                          <div class="col-12">
                            <h6 class="fw-semibold border-bottom pb-2 mb-3" style="color: #1b3d94;">
                              <i class="ri-settings-4-line me-1"></i> Other Details
                            </h6>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-3">
                              <input type="number" min="0" class="form-control" id="vehicleMileageKm" name="vehicleMileageKm" placeholder="Mileage (km)">
                              <label for="vehicleMileageKm">Mileage (km)</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group mb-3">
                              <div class="form-floating form-floating-outline">
                                <select id="vehicleBodyType" name="vehicleBodyType" class="form-select">
                                  <option value="NA">NA</option>
                                </select>
                                <label for="vehicleBodyType">Body Type</label>
                              </div>
                              <button type="button" class="btn btn-outline-primary btn-add-lookup" data-lookup-type="body_type" data-lookup-label="Body Type" title="Add Body Type">+</button>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group mb-3">
                              <div class="form-floating form-floating-outline">
                                <select id="vehicleEngineType" name="vehicleEngineType" class="form-select">
                                  <option value="NA">NA</option>
                                </select>
                                <label for="vehicleEngineType">Engine Type <span class="text-danger">*</span></label>
                              </div>
                              <button type="button" class="btn btn-outline-primary btn-add-lookup" data-lookup-type="engine_type" data-lookup-label="Engine Type" title="Add Engine Type">+</button>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group mb-3">
                              <div class="form-floating form-floating-outline">
                                <select id="vehicleCapacityCc" name="vehicleCapacityCc" class="form-select">
                                  <option value="NA">NA</option>
                                </select>
                                <label for="vehicleCapacityCc">Capacity (cc)</label>
                              </div>
                              <button type="button" class="btn btn-outline-primary btn-add-lookup" data-lookup-type="capacity_cc" data-lookup-label="Capacity (cc)" title="Add Capacity (cc)">+</button>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="input-group mb-3">
                              <div class="form-floating form-floating-outline">
                                <select id="vehicleTransmission" name="vehicleTransmission" class="form-select">
                                  <option value="NA">NA</option>
                                </select>
                                <label for="vehicleTransmission">Transmission <span class="text-danger">*</span></label>
                              </div>
                              <button type="button" class="btn btn-outline-primary btn-add-lookup" data-lookup-type="transmission" data-lookup-label="Transmission" title="Add Transmission">+</button>
                            </div>
                          </div>
                        
                        </div>
                        <!-- Comment -->
                      <div class="row g-3 mb-4" style="display:none">
                          
                        
                          
                              <!-- Per Hour -->
                              <div class="col-12 col-md-4">
                                <div class="input-group">
                                  <span class="input-group-text">BHD</span>
                                   <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.01" class="form-control" id="pricePerHour" name="pricePerHour" value="0" placeholder="Price / Hour">
                                    <label for="pricePerHour">Price / Hour</label>
                                  </div>
                                </div>
                              </div>
                           
                              <!-- Per Day -->
                              <div class="col-12 col-md-4">
                                <div class="input-group">
                                  <span class="input-group-text">BHD</span>
                                   <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.01" class="form-control" id="pricePerDay" name="pricePerDay" value="0" placeholder="Price / Day">
                                    <label for="pricePerDay">Price / Day</label>
                                  </div>
                                </div>
                              </div>
                            
                              <!-- Per Month -->
                              <div class="col-12 col-md-4">
                                  <div class="input-group">
                                    <span class="input-group-text">BHD</span>
                                    <div class="form-floating form-floating-outline">
                                      <input 
                                        type="number" 
                                        step="0.01" 
                                        class="form-control" 
                                        id="pricePerMonth" value="0" name="pricePerMonth" 
                                        placeholder="Price / Month">
                                      <label for="pricePerMonth">Price / Month</label>
                                    </div>
                                  </div>
                                </div>
                            
                            </div>
                       
                           <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-5 pt-1">

                                <!-- Left: Image Preview -->
                                <ul id="rentalCarImages"
                                    class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                </ul>
                            
                                <!-- Right: Button -->
                                <a href="javascript:;" class="ms-auto" data-permission="vehicle_registration_manage">
                                    <span class="badge bg-label-primary rounded-pill openAddRentalCarImageModal">
                                        Add Vehicle Documents
                                    </span>
                                </a>
                            
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
  
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 card-title">Vehicle Images</h5>
                        <small class="text-muted">Max upto 10</small>
                      </div>
                    
                      <div class="card-body">
                    
                       
                    
                         <div class="d-flex flex-column gap-2">

                          <input class="form-control form-control-sm" type="file" id="vehicleImages" multiple data-permission="vehicle_registration_manage">
                        
                          <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0" id="imagePreview"></ul>
                        
                        </div>
                    
                    
                    
                      </div>
                    
                    </div>
                 
                   
                    <div class="card mb-4">
                      <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2 action-buttons-wrapper p-3">
                    
                        <button type="button" class="btn btn-secondary" id="btn_cancel">
                            <i class="ri-refresh-line me-1"></i> Reset / Cancel
                        </button>
                    
                        <div class="d-flex gap-2">
                          <button type="button" class="btn btn-warning d-none" id="toggleStatusBtn" data-permission="vehicle_registration_manage">
                              <i class="ri-toggle-line me-1"></i> Deactivate
                          </button>
                          <button class="btn btn-primary" type="button" id="saveVehicleData" data-permission="vehicle_registration_manage">
                              <i class="ri-save-line me-1"></i> Save Vehicle
                          </button>
                        </div>
                    
                      </div>
                    </div>
                  </div>
                 
                  <div class="col-12 col-lg-4">
                      <div class="card shadow-sm">
                        
                         <div class="card-header p-2">
                              <?php
                                $allowedCompanies = [];
                                if (!empty($_SESSION['company_json'])) {
                                    $companyData = json_decode($_SESSION['company_json'], true);
                                    if (is_array($companyData)) {
                                        $allowedCompanies = $companyData;
                                    }
                                }
                                $isSingleCompany = count($allowedCompanies) <= 1;
                              ?>
                              <select id="companyFilter" class="form-select mb-2 form-select-sm" <?= $isSingleCompany ? 'disabled' : '' ?>>
                                  <?php if (!$isSingleCompany): ?>
                                      <option value="">All Companies</option>
                                  <?php endif; ?>
                                  <?php foreach ($allowedCompanies as $comp): ?>
                                      <option value="<?= htmlspecialchars($comp['ids']) ?>"><?= htmlspecialchars($comp['company_name']) ?></option>
                                  <?php endforeach; ?>
                              </select>
                              <input type="text" id="vehicleSearch" class="form-control form-control-sm" placeholder="Type to search vehicles...">
                            </div>
                    
                        <div class="card-body p-2">
                          <div class="table-responsive">
                            <table id="vehicleTable" class="table table-sm table-hover align-middle">
                              <thead class="">
                                <tr>
                                  <th>#</th>
                                  <th>Model</th>
                                  <th>Reg/Chasis</th>
                                  <th>Year</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                             
                              </tbody>
                            </table>
                          </div>
                        </div>
                    
                      </div>
                    </div>
                  
                </div>
              </div>
        
</div>
</form>

<!-- Quick Add Vehicle Lookup Master Modal -->
<div class="modal fade" id="vehicleLookupMasterModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1b3d94;">
        <h6 class="modal-title text-white mb-0" id="vlModalTitle">Add New Value</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="vl_lookup_type">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" id="vl_lookup_value" placeholder="Enter value">
          <label for="vl_lookup_value" id="vl_lookup_label">Value *</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-sm" id="vl_save_btn">Add</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Insurance / Passing Modal -->
<div class="modal fade" id="vehicleInsPassModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1b3d94;">
        <h6 class="modal-title text-white mb-0"><i class="ri-shield-check-line me-1"></i> Insurance &amp; Passing - <span id="vip_vehicle_no"></span></h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="vip_entry_id" value="">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Record Type *</label>
            <select id="vip_type" class="form-select">
              <option value="insurance">Insurance</option>
              <option value="passing">Passing</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold" id="vip_date_label">Next Expiry Date *</label>
            <input type="date" id="vip_date" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Amount (BHD)</label>
            <input type="number" step="0.001" min="0" id="vip_amount" class="form-control" placeholder="0.000">
          </div>

          <!-- Insurance-specific fields -->
          <div class="col-md-4 vip-ins-only">
            <label class="form-label fw-semibold">Insurance Provider</label>
            <input type="text" id="vip_provider" class="form-control" placeholder="e.g. Solidarity, BNI, GIG">
          </div>
          <div class="col-md-4 vip-ins-only">
            <label class="form-label fw-semibold">Policy Number</label>
            <input type="text" id="vip_policy_no" class="form-control" placeholder="Policy No.">
          </div>
          <div class="col-md-4 vip-ins-only">
            <label class="form-label fw-semibold">Insurance Type</label>
            <select id="vip_ins_type" class="form-select">
              <option value="Comprehensive">Comprehensive</option>
              <option value="Third Party">Third Party</option>
            </select>
          </div>
          <div class="col-md-4 vip-ins-only">
            <label class="form-label fw-semibold">Policy Start Date</label>
            <input type="date" id="vip_start_date" class="form-control">
          </div>

          <!-- Passing-specific fields -->
          <div class="col-md-4 vip-pass-only" style="display: none;">
            <label class="form-label fw-semibold">Passed Date</label>
            <input type="date" id="vip_passed_date" class="form-control">
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Attach Document (Optional)</label>
            <input type="file" id="vip_attachment" class="form-control" accept=".pdf,.png,.jpg,.jpeg,.webp">
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Remarks</label>
            <input type="text" id="vip_remarks" class="form-control" placeholder="Optional remarks...">
          </div>

          <div class="col-12 mt-3">
            <div class="border-top pt-2">
              <div class="fw-semibold small mb-2" style="color: #1b3d94;"><i class="ri-history-line me-1"></i> Renewal History</div>
              <div id="vip_history_list" class="small text-muted" style="max-height: 220px; overflow-y: auto;"></div>
              <div id="vip_entry_detail_box" class="alert alert-light border mt-2 mb-0 small" style="display: none;"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm d-none" id="vip_cancel_edit_btn">Cancel Edit</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-sm" id="vip_save_btn">Save Record</button>
      </div>
    </div>
  </div>
</div>