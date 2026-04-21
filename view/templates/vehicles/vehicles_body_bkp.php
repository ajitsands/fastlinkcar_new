<form id="VehicleDetailsForm" name="VehicleDetailsForm">

<div class="layout-demo-wrapper mt-0">
	
	<div class="container-fluid flex-grow-1 container-p-y">

                <!-- Add Product -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                  <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Add a new Vehicle</h4>
                    <p class="mb-0">You can add more vehicle here</p>
                  </div>
                  <div class="d-flex align-content-center flex-wrap gap-4">
                    <!--<button class="btn btn-outline-secondary waves-effect">Discard</button>-->
                    <button class="btn btn-outline-primary waves-effect" id="saveVehicleDataDraft">Save draft</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="saveVehicleData">Publish Vehicle</button>
                  </div>
                </div>

                <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">Vehicle information</h5>
                      </div>
                      <div class="card-body">
                        <div class="form-floating form-floating-outline mb-5">
                          <input type="text" class="form-control" id="vehicleName" placeholder="Name" name="vehicleName" aria-label="Vehicle Name">
                          <label for="vehicleName">Name</label>
                        </div>

                        <div class="row gx-5 mb-5">
                          <div class="col">
                            <div class="form-floating form-floating-outline">
                              <input type="number" class="form-control" id="vehicleRegNumber" placeholder="RegNumber" name="vehicleRegNumber" aria-label="Vehicle RegNumber">
                              <label for="vehicleRegNumber">Vehicle RegNumber</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" id="vehicleModal" placeholder="Modal" name="vehicleModal" aria-label="Product barcode">
                              <label for="vehicleModal">Vehicle Modal</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-floating form-floating-outline">
                              <input type="date" class="form-control" id="vehiclePurchaseDate" placeholder="dd-mm-yyyy" name="vehiclePurchaseDate" aria-label="Product barcode">
                              <label for="vehiclePurchaseDate">Purchase Date</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-floating form-floating-outline">
                              <input type="date" class="form-control" id="vehiclePassingDate" placeholder="dd-mm-yyyy" name="vehiclePassingDate" aria-label="Product barcode">
                              <label for="vehiclePassingDate">Passing Date</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-floating form-floating-outline">
                              <input type="date" class="form-control" id="vehicleInsuranceExpDate" placeholder="dd-mm-yyyy" name="vehicleInsuranceExpDate" aria-label="Product barcode">
                              <label for="vehicleInsuranceExpDate">Insurance Exp Date</label>
                            </div>
                          </div>
                        </div>
                        <!-- Comment -->
                        <div>
                          <p class="mb-1">Description (Optional)</p>
                          <div class="form-control p-0 pt-1">
                            <div class="comment-toolbar border-0 border-bottom ql-toolbar ql-snow">
                              <div class="d-flex justify-content-start">
                                <span class="ql-formats me-0">
                                  <button class="ql-bold" type="button"><svg viewBox="0 0 18 18"><path class="ql-stroke" d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z"></path><path class="ql-stroke" d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z"></path></svg></button>
                                  <button class="ql-italic" type="button"><svg viewBox="0 0 18 18"><line class="ql-stroke" x1="7" x2="13" y1="4" y2="4"></line><line class="ql-stroke" x1="5" x2="11" y1="14" y2="14"></line><line class="ql-stroke" x1="8" x2="10" y1="14" y2="4"></line></svg></button>
                                  <button class="ql-underline" type="button"><svg viewBox="0 0 18 18"><path class="ql-stroke" d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3"></path><rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="12" x="3" y="15"></rect></svg></button>
                                  <button class="ql-list" value="ordered" type="button"><svg viewBox="0 0 18 18"><line class="ql-stroke" x1="7" x2="15" y1="4" y2="4"></line><line class="ql-stroke" x1="7" x2="15" y1="9" y2="9"></line><line class="ql-stroke" x1="7" x2="15" y1="14" y2="14"></line><line class="ql-stroke ql-thin" x1="2.5" x2="4.5" y1="5.5" y2="5.5"></line><path class="ql-fill" d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z"></path><path class="ql-stroke ql-thin" d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156"></path><path class="ql-stroke ql-thin" d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109"></path></svg></button>
                                  <button class="ql-list" value="bullet" type="button"><svg viewBox="0 0 18 18"><line class="ql-stroke" x1="6" x2="15" y1="4" y2="4"></line><line class="ql-stroke" x1="6" x2="15" y1="9" y2="9"></line><line class="ql-stroke" x1="6" x2="15" y1="14" y2="14"></line><line class="ql-stroke" x1="3" x2="3" y1="4" y2="4"></line><line class="ql-stroke" x1="3" x2="3" y1="9" y2="9"></line><line class="ql-stroke" x1="3" x2="3" y1="14" y2="14"></line></svg></button>
                                  <button class="ql-link" type="button"><svg viewBox="0 0 18 18"><line class="ql-stroke" x1="7" x2="11" y1="7" y2="11"></line><path class="ql-even ql-stroke" d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z"></path><path class="ql-even ql-stroke" d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z"></path></svg></button>
                                  <button class="ql-image" type="button"><svg viewBox="0 0 18 18"><rect class="ql-stroke" height="10" width="12" x="3" y="4"></rect><circle class="ql-fill" cx="6" cy="7" r="1"></circle><polyline class="ql-even ql-fill" points="5 12 5 11 7 9 8 10 11 7 13 9 13 12 5 12"></polyline></svg></button>
                                </span>
                              </div>
                            </div>
                            <div class="comment-editor border-0 pb-1 ql-container ql-snow" id="VehicleDiscription"><div class="ql-editor ql-blank" contenteditable="true" data-placeholder="Product Description">
                            
                            </div><div class="ql-tooltip ql-hidden"><a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a><input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL"><a class="ql-action"></a><a class="ql-remove"></a></div></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- /Product Information -->
                    <!-- Media -->
                    <div class="card mb-6">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 card-title">Vehicle Image</h5>
                        <a href="javascript:void(0);" class="fw-medium">Max upto 10 Numbers</a>
                      </div>
                      <div class="card-body">
                        <!--<form action="/upload" class="dropzone needsclick dz-clickable" id="dropzone-basic">-->
                        <!--  <div class="dz-message needsclick my-12">-->
                        <!--    <div class="d-flex justify-content-center">-->
                        <!--      <div class="avatar">-->
                        <!--        <span class="avatar-initial rounded-3 bg-label-secondary">-->
                        <!--          <i class="icon-base ri ri-upload-2-line icon-24px"></i>-->
                        <!--        </span>-->
                        <!--      </div>-->
                        <!--    </div>-->
                        <!--    <p class="h4 needsclick my-2">Drag and drop your image here</p>-->
                        <!--    <small class="note text-body-secondary d-block fs-6 my-2">or</small>-->
                        <!--    <span class="needsclick btn btn-sm btn-outline-primary waves-effect" id="btnBrowse">Browse image</span>-->
                        <!--  </div>-->
                          
                        <!--</form>-->
                        
                         
                                    <div class="d-flex align-items-center">
                                        <input class="form-control form-control-sm" type="file" id="vehicleImages" multiple>
                                            <div class="ms-auto">
                                                <div class="d-flex align-items-center">
                                                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 " id="imagePreview">
                                                       
                                                    </ul>
                                                </div>
                                            </div>
                                    </div>
                        
                        
                      </div>
                      
                      
                    </div>
                    <!-- /Media -->
                  
                   
                  </div>
                  <!-- /Second column -->

                  <!-- Second column -->
                  <div class="col-12 col-lg-4">
                    <!-- Pricing Card -->
                    <div class="card mb-6">
                      <div class="card-header">
                        <h5 class="card-title mb-0">Cost Per Day</h5>
                      </div>
                      <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-lg-6">
                                <!-- Base Price -->
                                <div class="form-floating form-floating-outline mb-5">
                                  <input type="number" class="form-control" id="vehicleCostPerDay" placeholder="Cost" name="vehicleCostPerDay" aria-label="Cost Perday">
                                  <label for="vehicleCostPerDay">Per Day Cost</label>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <!-- Discounted Price -->
                                <div class="form-floating form-floating-outline mb-5">
                                  <input type="number" class="form-control" id="vehicleMaxDiscountPrice" placeholder="MaxDiscountPrice" name="vehicleMaxDiscountPrice" aria-label="Product discounted price">
                                  <label for="vehicleMaxDiscountPrice">Max Discounted Cost</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-lg-6">
                                <div class="mb-5 col ecommerce-select2-dropdown">
                                  <div class="form-floating form-floating-outline">
                                    <select id="vehicleFuelType" name="vehicleFuelType" class="form-select form-select-sm" data-placeholder="Select Fuel Type">
                                      <option value="" disable>Select Fuel type</option>
                                      <option value="Petrol">Petrol</option>
                                      <option value="Diesel">Diesel</option>
                                      <option value="EV">EV</option>
                                    </select>
                                    <label for="vendor">Fuel Type</label>
                                  </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div class="mb-5 col ecommerce-select2-dropdown">
                                  <div class="form-floating form-floating-outline">
                                    <select id="vehicleGearType" name="vehicleGearType" class="form-select form-select-sm" data-placeholder="Select Gear Type">
                                      <option value="" disable>Select Gear type</option>
                                      <option value="Automatic">Automatic</option>
                                      <option value="Manual">Manual</option>
                                    </select>
                                    <label for="vendor">Gear Type</label>
                                  </div>
                                </div>
                            </div>    
                        </div>

                        
                        
                        
                        
                        
                        <!-- Charge tax check box -->
                        <div class="form-check m-2 me-0 pb-2">
                          <input class="form-check-input" type="checkbox" value="" id="price-charge-tax" checked="">
                          <label class="form-check-label" for="price-charge-tax"> Charge tax on this product </label>
                        </div>
                        <!-- Instock switch -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-4">
                          <p class="mb-0">Available</p>
                          <div class="w-25 d-flex justify-content-end">
                            <div class="form-check form-switch me-n3 mb-0">
                              <input type="checkbox" class="form-check-input" checked="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /Pricing Card -->
                    <!-- Organize Card -->
                    <div class="card mb-6">
                      <div class="card-header">
                        <h5 class="card-title mb-0">Organize</h5>
                      </div>
                      <div class="card-body">
                          <div class="row">
                            <div class="col-6 col-lg-6">
                                <!-- Vendor -->
                                <div class="mb-5 col ecommerce-select2-dropdown">
                                  <div class="form-floating form-floating-outline">
                                    <select id="belongsToCompany" name="belongsToCompany" class="form-select form-select-sm" data-placeholder="Select Company">
                                      <option value="" disable>Select Company</option>
                                      <option value="1">AA Car Rental</option>
                                      <option value="2">Classic</option>
                                    </select>
                                    <label for="vendor">Company</label>
                                  </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <!-- Category -->
                                <div class="mb-5 col ecommerce-select2-dropdown d-flex justify-content-between align-items-center">
                                  <div class="form-floating form-floating-outline w-100 me-4">
                                    <select id="category-org" class="form-select form-select-sm" data-placeholder="Select Category">
                                      <option value="">Select Category</option>
                                      <option value="Luxury Car">Luxury Car</option>
                                      <option value="Normal Car">Normal Car</option>
                                      <option value="Van">Van</option>
                                      <option value="SUV">SUV</option>
                                      <option value="Bus">Bus</option>
                                      <option value="Truck">Truck</option>
                                    </select>
                                    <label for="category-org">Category</label>
                                  </div>
                                  <!--<div>-->
                                  <!--  <button class="btn btn-outline-primary btn-icon waves-effect">-->
                                  <!--    <i class="icon-base ri ri-add-line"></i>-->
                                  <!--  </button>-->
                                  <!--</div>-->
                                </div>
                            </div>
                                
                        </div>
                        
                        
                        
                      </div>
                    </div>
                    <!-- /Organize Card -->
                  </div>
                  <!-- /Second column -->
                </div>
              </div>
        
</div>
</form>