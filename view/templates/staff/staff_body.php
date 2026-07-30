<form id="DriverDetailsForm" name="DriverDetailsForm">

<div class="layout-demo-placeholder ">
	
	<div class="container-fluid flex-grow-1 container-p-y">

               
                <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">Staff Registration Details</h5>
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
                              <input type="text" class="form-control" id="drivinglicenseno" name="drivinglicenseno" placeholder=" License No.">
                              <label for="drivinglicenseno"> License No.</label>
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
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <select id="driverStatus" name="driverStatus" class="form-select" >
                                <option value="" disabled="" selected="">Select Staff Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                              <label for="driverStatus">Status</label>
                            </div>
                          </div>
                        
                          
                         <div class="col-12 col-md-6 col-lg-8">
                              <div class="form-floating form-floating-outline mb-5">
                                  <textarea 
                                      class="form-control" 
                                      id="driverAddress" 
                                      name="driverAddress" 
                                      placeholder="Address"
                                      style="height: 100px;"></textarea>
                                
                                <label for="driverAddress"> Address</label>
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
                                <a href="javascript:;" class="ms-auto">
                                    <span class="badge bg-label-primary rounded-pill openAddRentalCarImageModal">
                                        Add Staff Documents
                                    </span>
                                </a>
                            
                            </div>
                        </div>
                    </div>
                   
                   
                    <div class="col-12 ">
                      <div class="d-flex justify-content-between">
                    
                        <button type="button" class="btn btn-secondary" id="btn_cancel">Cancel</button>
                    
                        <div class="d-flex gap-2">
                          <button class="btn btn-primary" type="button" id="saveDriverData">Save</button>
                          
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