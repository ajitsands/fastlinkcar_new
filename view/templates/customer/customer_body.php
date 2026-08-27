<form id="CustomerDetailsForm" name="CustomerDetailsForm">

<div class="layout-demo-placeholder ">
	
	<div class="container-fluid flex-grow-1 container-p-y">

               
                <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-tile mb-0">Customer Registration Details</h5>
                        <span class="badge bg-label-success" id="customerStatusBadge">New Entry</span>
                      </div>
                      <div class="card-body">
                        

                       <div class="row g-3 mb-4">
                        
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="customerName" placeholder="Name" name="customerName">
                              <label for="customerName">Name</label>
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
                              <label for="cprno">CR/CPR No.</label>
                            </div>
                          </div>
                        
                         <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="date" class="form-control" id="cprexpiryDate" placeholder="dd-mm-yyyy" name="cprexpiryDate" aria-label="CPR Expiry Date">
                                <label for="cprexpiryDate">CR/CPR Expiry Date</label>
                            </div>
                          </div>
                          
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="custattn" name="custattn" placeholder="Attention">
                              <label for="custattn">Attention</label>
                            </div>
                          </div>
                        
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              
                                    <select id="customer_type_onmodal" name="customer_type_onmodal" class="form-select form-select-sm">
                                              <option value="" disabled="" selected="">Select</option>
                                              <option value="Individual">Individual</option>
                                              <option value="Corporate">Corporate</option>
                                              <option value="Agency">Agency</option>
                                              
                                    </select>
                                    <label for="customer_type_onmodal" class="form-label">Customer Type</label>
                            </div>
                          </div>
                        
                          
                         <div class="col-12 col-md-6 col-lg-8">
                              <div class="form-floating form-floating-outline mb-5">
                                  <textarea 
                                      class="form-control" 
                                      id="customerAddress" 
                                      name="customerAddress" 
                                      placeholder="Customer Address"
                                      style="height: 100px;"></textarea>
                                
                                <label for="customerAddress">Customer Address</label>
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
                                <a href="javascript:;" class="ms-auto" data-permission="customers_manage">
                                    <span class="badge bg-label-primary rounded-pill openAddRentalCarImageModal">
                                        Add Customer Documents
                                    </span>
                                </a>
                            
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 action-buttons-wrapper mt-4">
                                <button type="button" class="btn btn-secondary" id="btn_cancel">
                                    <i class="ri-refresh-line me-1"></i> Reset / Cancel
                                </button>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-warning d-none" id="toggleCustomerStatusBtn" data-permission="customers_manage">
                                        <i class="ri-toggle-line me-1"></i> Deactivate
                                    </button>
                                    <button type="button" class="btn btn-primary" id="saveCustomerData" data-permission="customers_manage">
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
                              <input type="text" id="customerSearch" class="form-control" placeholder="Type to search customers...">
                            </div>
                    
                        <div class="card-body p-2">
                          <div class="table-responsive">
                            <table id="customerTable" class="table table-sm table-hover align-middle">
                              <thead class="">
                                <tr>
                                  <th>#</th>
                                  <th>Name</th>
                                  <th>Contact No.</th>
                                  <th>CR/Cpr</th>
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