<form id="VehicleDetailsForm" name="VehicleDetailsForm">

<div class="layout-demo-placeholder ">
	
	<div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="card mb-6">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">Masters Configuration</h5>
                      </div>
                      <div class="card-body">
                           <div class="col-xl-12">
                         
                           <div class="nav-align-top">
                            <ul class="nav nav-pills mb-4" role="tablist">
                              <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link waves-effect waves-light active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-category" aria-controls="navs-pills-top-category" aria-selected="true">
                                  Category
                                </button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-brand" aria-controls="navs-pills-top-brand" aria-selected="false">
                                  Brand
                                </button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-model" aria-controls="navs-pills-top-model" aria-selected="false">
                                  Model
                                </button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-pricing" aria-controls="navs-pills-top-pricing" aria-selected="false">
                                  Pricing
                                </button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-status-colors" aria-controls="navs-pills-top-status-colors" aria-selected="false">
                                  Status Colors
                                </button>
                              </li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane fade active show" id="navs-pills-top-category" role="tabpanel">
                                  
                                    <?php include('vehicleMasterCategory.php'); ?>
                                
                              </div>
                              <div class="tab-pane fade" id="navs-pills-top-brand" role="tabpanel">
                                  <?php include('vehicleMasterBrand.php'); ?>
                                
                              </div>
                              <div class="tab-pane fade" id="navs-pills-top-model" role="tabpanel">
                                <?php include('vehicleMasterModel.php'); ?>
                              </div>
                              <div class="tab-pane fade" id="navs-pills-top-pricing" role="tabpanel">
                                <?php include('vehicleMasterPricing.php'); ?>
                              </div>
                              <div class="tab-pane fade" id="navs-pills-top-status-colors" role="tabpanel">
                                <?php include('vehicleMasterStatusColors.php'); ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
             </div>
            
            
        </div>
               
                <!--<div class="row">-->
                <!--   First column-->
                <!--   <div class="col-12 col-lg-2">-->
                <!--      <div class="card shadow-sm">-->
                        
                <!--         <div class="card-header p-2">-->
                <!--              <input type="text" id="vehicleSearch" class="form-control" placeholder="Type to search vehicles...">-->
                <!--            </div>-->
                    
                <!--        <div class="card-body p-2">-->
                <!--          <div class="table-responsive">-->
                <!--            <table id="vehicleTable" class="table table-sm table-hover align-middle">-->
                <!--              <thead class="">-->
                <!--                <tr>-->
                <!--                  <th>#</th>-->
                <!--                  <th>Model</th>-->
                <!--                  <th>No</th>-->
                <!--                  <th>Year</th>-->
                <!--                </tr>-->
                <!--              </thead>-->
                <!--              <tbody>-->
                             
                <!--              </tbody>-->
                <!--            </table>-->
                <!--          </div>-->
                <!--        </div>-->
                    
                <!--      </div>-->
                <!--    </div>-->
                <!--    <div class="col-12 col-lg-4">-->
                <!--      <div class="card shadow-sm">-->
                        
                <!--         <div class="card-header p-2">-->
                <!--              <input type="text" id="vehicleSearch" class="form-control" placeholder="Type to search vehicles...">-->
                <!--            </div>-->
                    
                <!--        <div class="card-body p-2">-->
                <!--          <div class="table-responsive">-->
                <!--            <table id="vehicleTable" class="table table-sm table-hover align-middle">-->
                <!--              <thead class="">-->
                <!--                <tr>-->
                <!--                  <th>#</th>-->
                <!--                  <th>Model</th>-->
                <!--                  <th>No</th>-->
                <!--                  <th>Year</th>-->
                <!--                </tr>-->
                <!--              </thead>-->
                <!--              <tbody>-->
                             
                <!--              </tbody>-->
                <!--            </table>-->
                <!--          </div>-->
                <!--        </div>-->
                    
                <!--      </div>-->
                <!--    </div>-->
                <!--  <div class="col-12 col-lg-6">-->
                <!--     Product Information -->
                <!--    <div class="card mb-6">-->
                <!--      <div class="card-header">-->
                <!--        <h5 class="card-tile mb-0">Vehicle Master Configuration</h5>-->
                <!--      </div>-->
                <!--      <div class="card-body">-->
                        

                <!--       <div class="row g-3 mb-4">-->

                <!--           Vehicle Model -->
                <!--          <div class="col-12 col-md-6 col-lg-3">-->
                <!--              <div class="form-floating form-floating-outline mb-5">-->
                <!--               <div id="dropdownContainer">-->
                                
                <!--                </div>-->
                <!--            </div>-->
                <!--          </div>-->
                        
                <!--           Vehicle Number -->
                <!--          <div class="col-12 col-md-6 col-lg-3">-->
                <!--            <div class="form-floating form-floating-outline mb-5">-->
                <!--              <input type="text" class="form-control" id="vehicleNumber" placeholder="Vehicle Number" name="vehicleNumber">-->
                <!--              <label for="vehicleNumber">Vehicle Number</label>-->
                <!--            </div>-->
                <!--          </div>-->
                        
                <!--           Vehicle Year -->
                <!--          <div class="col-12 col-md-6 col-lg-3">-->
                <!--            <div class="form-floating form-floating-outline mb-5">-->
                <!--              <input type="number" class="form-control" id="vehicleYear" name="vehicleYear" placeholder="Vehicle Year">-->
                <!--              <label for="vehicleYear">Year</label>-->
                <!--            </div>-->
                <!--          </div>-->
                        
                <!--           Vehicle Color -->
                <!--          <div class="col-12 col-md-6 col-lg-3">-->
                <!--            <div class="form-floating form-floating-outline mb-5">-->
                <!--              <input type="text" class="form-control" id="vehicleColor" name="vehicleColor" placeholder="Vehicle Color">-->
                <!--              <label for="vehicleColor">Color</label>-->
                <!--            </div>-->
                <!--          </div>-->
                        
                <!--           Fuel Type -->
                <!--          <div class="col-12 col-md-6 col-lg-3">-->
                <!--            <div class="form-floating form-floating-outline mb-5">-->
                <!--              <select id="vehicleFuelType" name="vehicleFuelType" class="form-select">-->
                <!--                <option value="" disabled selected>Select Fuel</option>-->
                <!--                <option value="Petrol">Petrol</option>-->
                <!--                <option value="Diesel">Diesel</option>-->
                <!--                <option value="EV">EV</option>-->
                <!--              </select>-->
                <!--              <label for="vehicleFuelType">Fuel Type</label>-->
                <!--            </div>-->
                <!--          </div>-->
                      
                <!--           Gear Type -->
                <!--          <div class="col-12 col-md-6 col-lg-3">-->
                <!--            <div class="form-floating form-floating-outline mb-5">-->
                <!--              <select id="vehicleGearType" name="vehicleGearType" class="form-select">-->
                <!--                <option value="" disabled selected>Select Gear</option>-->
                <!--                <option value="Automatic">Automatic</option>-->
                <!--                <option value="Manual">Manual</option>-->
                <!--              </select>-->
                <!--              <label for="vehicleGearType">Gear Type</label>-->
                <!--            </div>-->
                <!--          </div>-->
                <!--            Purchase date -->
                <!--          <div class="col-12 col-md-6 col-lg-3">-->
                <!--            <div class="form-floating form-floating-outline mb-5">-->
                <!--              <input type="date" class="form-control" id="vehiclePurchaseDate" placeholder="dd-mm-yyyy" name="vehiclePurchaseDate" aria-label="Product barcode">-->
                <!--                            <label for="vehiclePurchaseDate">Purchase Date</label>-->
                <!--            </div>-->
                <!--          </div>-->
                <!--            Purchase Cost -->
                <!--          <div class="col-12 col-md-6 col-lg-3">-->
                <!--            <div class="form-floating form-floating-outline mb-5">-->
                <!--              <div class="input-group">-->
                <!--                    <span class="input-group-text">BHD</span>-->
                <!--                    <div class="form-floating form-floating-outline">-->
                <!--                      <input -->
                <!--                        type="number" -->
                <!--                        step="0.01" -->
                <!--                        class="form-control" -->
                <!--                        id="purchasePrice" name="purchasePrice" -->
                <!--                        placeholder="Purchase Cost">-->
                <!--                      <label for="purchasePrice">Purchase Cost</label>-->
                <!--                    </div>-->
                <!--                  </div>-->
                <!--            </div>-->
                <!--          </div>-->
                          
                <!--         <div class="col-12">-->
                <!--              <div class="form-floating form-floating-outline mb-5">-->
                <!--                  <textarea -->
                <!--                      class="form-control" -->
                <!--                      id="vehicleDescription" -->
                <!--                      name="vehicleDescription" -->
                <!--                      placeholder="Vehicle Description"-->
                <!--                      style="height: 100px;"></textarea>-->
                                
                <!--                <label for="vehicleDescription">Vehicle Description</label>-->
                <!--              </div>-->
                <!--            </div>-->
                        
                <!--        </div>-->
                <!--         Comment -->
                <!--      <div class="row g-3 mb-4">-->
                          
                        
                          
                <!--               Per Hour -->
                <!--              <div class="col-12 col-md-4">-->
                <!--                <div class="input-group">-->
                <!--                  <span class="input-group-text">BHD</span>-->
                <!--                   <div class="form-floating form-floating-outline">-->
                <!--                    <input type="number" step="0.01" class="form-control" id="pricePerHour" name="pricePerHour" placeholder="Price / Hour">-->
                <!--                    <label for="pricePerHour">Price / Hour</label>-->
                <!--                  </div>-->
                <!--                </div>-->
                <!--              </div>-->
                           
                <!--               Per Day -->
                <!--              <div class="col-12 col-md-4">-->
                <!--                <div class="input-group">-->
                <!--                  <span class="input-group-text">BHD</span>-->
                <!--                   <div class="form-floating form-floating-outline">-->
                <!--                    <input type="number" step="0.01" class="form-control" id="pricePerDay" name="pricePerDay" placeholder="Price / Day">-->
                <!--                    <label for="pricePerDay">Price / Day</label>-->
                <!--                  </div>-->
                <!--                </div>-->
                <!--              </div>-->
                            
                <!--               Per Month -->
                <!--              <div class="col-12 col-md-4">-->
                <!--                  <div class="input-group">-->
                <!--                    <span class="input-group-text">BHD</span>-->
                <!--                    <div class="form-floating form-floating-outline">-->
                <!--                      <input -->
                <!--                        type="number" -->
                <!--                        step="0.01" -->
                <!--                        class="form-control" -->
                <!--                        id="pricePerMonth" name="pricePerMonth" -->
                <!--                        placeholder="Price / Month">-->
                <!--                      <label for="pricePerMonth">Price / Month</label>-->
                <!--                    </div>-->
                <!--                  </div>-->
                <!--                </div>-->
                            
                <!--            </div>-->
                       
                <!--           <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-5 pt-1">-->

                <!--                 Left: Image Preview -->
                <!--                <ul id="rentalCarImages"-->
                <!--                    class="list-unstyled d-flex align-items-center avatar-group mb-0">-->
                <!--                </ul>-->
                            
                <!--                 Right: Button -->
                <!--                <a href="javascript:;" class="ms-auto">-->
                <!--                    <span class="badge bg-label-primary rounded-pill openAddRentalCarImageModal">-->
                <!--                        Add Vehicle Documents-->
                <!--                    </span>-->
                <!--                </a>-->
                            
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--    <div class="card mb-4">-->
  
                <!--      <div class="card-header d-flex justify-content-between align-items-center">-->
                <!--        <h5 class="mb-0 card-title">Vehicle Images</h5>-->
                <!--        <small class="text-muted">Max upto 10</small>-->
                <!--      </div>-->
                    
                <!--      <div class="card-body">-->
                    
                       
                    
                <!--         <div class="d-flex flex-column gap-2">-->

                <!--          <input class="form-control form-control-sm" type="file" id="vehicleImages" multiple>-->
                        
                <!--          <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0" id="imagePreview"></ul>-->
                        
                <!--        </div>-->
                    
                    
                    
                <!--      </div>-->
                    
                <!--    </div>-->
                 
                   
                <!--   <div class="card mb-4">-->
                <!--      <div class="card-body d-flex justify-content-between">-->
                    
                <!--        <button type="button" class="btn btn-secondary" id="btn_cancel">Cancel</button>-->
                    
                <!--        <div class="d-flex gap-2">-->
                <!--          <button class="btn btn-primary" type="button" id="saveVehicleData">Save</button>-->
                          
                <!--        </div>-->
                    
                <!--      </div>-->
                <!--    </div>-->
                <!--  </div>-->
                 
                  
                  
                <!--</div>-->
              </div>
        
</div>
</form>