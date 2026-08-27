<form id="DriverDetailsForm" name="DriverDetailsForm">

<div class="layout-demo-placeholder ">
	
	<div class="container-fluid flex-grow-1 container-p-y">

               
                <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                      <div class="card-header d-flex align-items-center justify-content-between pb-3">
                        <div>
                          <h5 class="card-title mb-0">Driver Registration Details</h5>
                          <small class="text-muted">Add or manage driver information</small>
                        </div>
                        <div id="driverStatusBadgeContainer">
                            <span class="badge bg-label-success" id="driverStatusBadge">New Entry</span>
                        </div>
                      </div>
                      <div class="card-body">
                        

                       <div class="row g-3 mb-4">
                        
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="driverName" placeholder="Name" name="driverName">
                              <label for="driverName">Name</label>
                            </div>
                          </div>
                        
                         
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="tel" class="form-control" id="ContactNumber" name="ContactNumber" placeholder="Contact Number" pattern="[0-9]{8,15}" >
                              <label for="ContactNumber">Contact Number</label>
                            </div>
                          </div>
                        
                         
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="emailId" name="emailId" placeholder="Email Id">
                              <label for="emailId">Email Id</label>
                            </div>
                          </div>
                          
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="cprno" name="cprno" placeholder="CPR No.">
                              <label for="cprno">CPR No.</label>
                            </div>
                          </div>
                        
                         <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="date" class="form-control" id="cprexpiryDate" placeholder="dd-mm-yyyy" name="cprexpiryDate" aria-label="CPR Expiry Date">
                                <label for="cprexpiryDate">CPR Expiry Date</label>
                            </div>
                          </div>
                          
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="drivinglicenseno" name="drivinglicenseno" placeholder="Driving License No.">
                              <label for="drivinglicenseno">Driving License No.</label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="licenseissueplace" name="licenseissueplace" placeholder="License Issue Place">
                              <label for="licenseissueplace">License Issue Place</label>
                            </div>
                          </div>
                          
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="date" class="form-control" id="licenseissueDate" placeholder="dd-mm-yyyy" name="licenseissueDate" aria-label="License Issue Date">
                                <label for="licenseissueDate">License Issue Date</label>
                            </div>
                          </div>
                        
                         <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="date" class="form-control" id="licenseexpiryDate" placeholder="dd-mm-yyyy" name="licenseexpiryDate" aria-label="License Expiry Date">
                                <label for="licenseexpiryDate">License Expiry Date</label>
                            </div>
                          </div>
                          <input type="hidden" id="driverStatus" name="driverStatus" value="Active">
                        
                          
                         <div class="col-12 col-md-6 col-lg-8">
                              <div class="form-floating form-floating-outline mb-5">
                                  <textarea 
                                      class="form-control" 
                                      id="driverAddress" 
                                      name="driverAddress" 
                                      placeholder="Driver Address"
                                      style="height: 100px;"></textarea>
                                
                                <label for="driverAddress">Driver Address</label>
                              </div>
                            </div>
                        
                        </div>
                        <!-- Comment -->
                    
                       
                           <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-5 pt-1">

                                <!-- Left: Image Preview -->
                                <ul id="rentalCarImages"
                                    class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                </ul>
                            
                                <!-- Right: Button -->
                                <a href="javascript:;" class="ms-auto" data-permission="driver_registration_manage">
                                    <span class="badge bg-label-primary rounded-pill openAddRentalCarImageModal">
                                        Add Driver Documents
                                    </span>
                                </a>
                            
                            </div>
                            
                            <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4 pt-3 border-top">
                              <button type="button" class="btn btn-secondary" id="btn_cancel">
                                  <i class="ri-refresh-line me-1"></i> Reset / Clear
                              </button>
                              
                              <div class="d-flex gap-2">
                                  <button type="button" class="btn btn-warning d-none" id="toggleDriverStatusBtn" data-permission="driver_registration_manage">
                                      <i class="ri-close-circle-line me-1"></i> Deactivate
                                  </button>
                                  <button class="btn btn-primary" type="button" id="saveDriverData" data-permission="driver_registration_manage">
                                      <i class="ri-save-line me-1"></i> Save
                                  </button>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
                 
                  <div class="col-12 col-lg-4">
                      <div class="card shadow-sm">
                        
                         <div class="card-header p-2">
                              <input type="text" id="driverSearch" class="form-control" placeholder="Type to search drivers...">
                            </div>
                    
                        <div class="card-body p-2">
                          <div class="table-responsive">
                            <table id="driverTable" class="table table-sm table-hover align-middle">
                              <thead class="">
                                <tr>
                                  <th>#</th>
                                  <th>Name</th>
                                  <th>Contact No.</th>
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