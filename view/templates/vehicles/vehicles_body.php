<form id="VehicleDetailsForm" name="VehicleDetailsForm">

<div class="layout-demo-placeholder ">
	
	<div class="container-fluid flex-grow-1 container-p-y">

               
                <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                      <div class="card-header d-flex align-items-center justify-content-between">
                          <h5 class="card-title mb-0">
                              <i class="ri-car-line me-2 text-primary"></i>Vehicle Registration Details
                          </h5>
                          <div id="statusBadgeContainer">
                              <span class="badge bg-label-success" id="vehicleStatusBadge">New Entry</span>
                          </div>
                      </div>
                      <div class="card-body">
                        

                       <div class="row g-3 mb-4">

                          <!-- Registration Company Access -->
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-3">
                              <select id="belongsToCompanyID" name="belongsToCompanyID" class="form-select">
                              </select>
                              <label for="belongsToCompanyID">Registration Company</label>
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
                              <label for="outsourcingCompanyId">Outsourcing Company</label>
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
                              <label for="vehicleNumber">Vehicle Number</label>
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
                              <label for="vehicleYear">Year</label>
                            </div>
                          </div>
                        
                          <!-- Vehicle Color -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="vehicleColor" name="vehicleColor" placeholder="Vehicle Color">
                              <label for="vehicleColor">Color</label>
                            </div>
                          </div>
                        
                          <!-- Fuel Type -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-5">
                              <select id="vehicleFuelType" name="vehicleFuelType" class="form-select">
                                <option value="" disabled selected>Select Fuel</option>
                                <option value="Petrol">Petrol</option>
                                <option value="Diesel">Diesel</option>
                                <option value="EV">EV</option>
                              </select>
                              <label for="vehicleFuelType">Fuel Type</label>
                            </div>
                          </div>
                      
                          <!-- Gear Type -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-5">
                              <select id="vehicleGearType" name="vehicleGearType" class="form-select">
                                <option value="" disabled selected>Select Gear</option>
                                <option value="Automatic">Automatic</option>
                                <option value="Manual">Manual</option>
                              </select>
                              <label for="vehicleGearType">Gear Type</label>
                            </div>
                          </div>
                           <!-- Purchase date -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="date" class="form-control" id="vehiclePurchaseDate" placeholder="dd-mm-yyyy" name="vehiclePurchaseDate" aria-label="Product barcode">
                                            <label for="vehiclePurchaseDate">Purchase Date</label>
                            </div>
                          </div>
                           <!-- Purchase Cost -->
                          <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-floating form-floating-outline mb-5">
                              <div class="input-group">
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
                          </div>
                          
                         <div class="col-12">
                              <div class="form-floating form-floating-outline mb-5">
                                  <textarea 
                                      class="form-control" 
                                      id="vehicleDescription" 
                                      name="vehicleDescription" 
                                      placeholder="Vehicle Description"
                                      style="height: 100px;"></textarea>
                                
                                <label for="vehicleDescription">Vehicle Description</label>
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