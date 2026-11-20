<form id="CustomerDetailsForm" name="CustomerDetailsForm">

<div class="layout-demo-placeholder ">
	
	<div class="container-fluid flex-grow-1 container-p-y">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #1b3d94;">
                            <i class="ri-group-line me-1"></i> Customers Master
                        </h4>
                        <p class="text-muted mb-0">Manage customer profiles, license details, accounts, and blacklist status.</p>
                    </div>
                </div>
               
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
                              <select id="customer_type_onmodal" name="customer_type_onmodal" class="form-select form-select-sm">
                                <option value="" disabled="" selected="">Select</option>
                                <option value="Individual">Individual</option>
                                <option value="Corporate">Corporate</option>
                                <option value="Agency">Agency</option>
                              </select>
                              <label for="customer_type_onmodal" class="form-label">Customer Type *</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <select id="customer_account_id" name="customer_account_id" class="form-select form-select-sm">
                                <option value="">Select Customer Account</option>
                              </select>
                              <label for="customer_account_id" class="form-label">Customer Account *</label>
                            </div>
                          </div>
                        
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="customerName" placeholder="Name" name="customerName">
                              <label for="customerName">Name *</label>
                            </div>
                          </div>
                        
                         
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="tel" class="form-control" id="ContactNumber" name="ContactNumber" placeholder="Contact Number" pattern="[0-9]{8,15}" >
                              <label for="ContactNumber">Contact Number *</label>
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
                              <input type="text" class="form-control" id="cprno" name="cprno" placeholder="ID Number / CPR No.">
                              <label for="cprno">ID Number (CR/CPR No.) *</label>
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
                              <select id="nationality" name="nationality" class="form-select form-select-sm">
                                <option value="">Select Nationality</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="UAE">UAE</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Oman">Oman</option>
                                <option value="Qatar">Qatar</option>
                                <option value="India">India</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Egypt">Egypt</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="UK">UK</option>
                                <option value="USA">USA</option>
                                <option value="Other">Other</option>
                              </select>
                              <label for="nationality">Nationality *</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="license_no" name="license_no" placeholder="Licence No.">
                              <label for="license_no">Licence No.</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <select id="license_issue_place" name="license_issue_place" class="form-select form-select-sm">
                                <option value="">Select Issue Place</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="UAE">UAE</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Oman">Oman</option>
                                <option value="Qatar">Qatar</option>
                                <option value="GCC">GCC</option>
                                <option value="International">International</option>
                                <option value="Other">Other</option>
                              </select>
                              <label for="license_issue_place">Issue Place</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="date" class="form-control" id="license_expiry_date" name="license_expiry_date" placeholder="dd-mm-yyyy">
                              <label for="license_expiry_date">Licence Expire Date</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="tel" class="form-control" id="phone_1" name="phone_1" placeholder="Phone 1">
                              <label for="phone_1">Phone 1</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="tel" class="form-control" id="phone_2" name="phone_2" placeholder="Phone 2">
                              <label for="phone_2">Phone 2</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="fax_no" name="fax_no" placeholder="Fax No.">
                              <label for="fax_no">Fax No.</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="website" name="website" placeholder="Website">
                              <label for="website">Website</label>
                            </div>
                          </div>

                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="vat_reg_no" name="vat_reg_no" placeholder="VAT Registration #">
                              <label for="vat_reg_no">VAT Registration #</label>
                            </div>
                          </div>
                          
                          <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="custattn" name="custattn" placeholder="Attention">
                              <label for="custattn">Attention</label>
                            </div>
                          </div>
                        
                          
                         <div class="col-12">
                              <div class="form-floating form-floating-outline mb-3">
                                  <textarea 
                                      class="form-control" 
                                      id="customerAddress" 
                                      name="customerAddress" 
                                      placeholder="Customer Address"
                                      style="height: 90px;"></textarea>
                                
                                <label for="customerAddress">Customer Address</label>
                              </div>
                            </div>

                          <!-- Black List Information -->
                          <div class="col-12">
                            <div class="p-3 rounded border" style="background-color: #fff8f8; border-color: #f5c2c7 !important;">
                              <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-semibold text-danger"><i class="ri-spam-2-line me-1"></i> Black List Information</h6>
                                <div class="form-check form-switch mb-0">
                                  <input class="form-check-input" type="checkbox" id="is_blacklisted" name="is_blacklisted" value="1">
                                  <label class="form-check-label fw-semibold text-danger" for="is_blacklisted">Black list</label>
                                </div>
                              </div>
                              <div class="form-floating form-floating-outline">
                                <textarea class="form-control" id="blacklist_description" name="blacklist_description" placeholder="Blacklist Description" style="height: 85px;"></textarea>
                                <label for="blacklist_description">Blacklist Description</label>
                              </div>
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
                                  <th>Customer Details</th>
                                  <th class="text-end">Status</th>
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