<div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                       <div class="mb-1 mt-0">
                          <h5 class="card-title mb-0">Model Details</h5>
                          <small class="text-muted">Add or manage vehicle model information</small>
                        </div>
                      
                      <div class="row g-3 mb-4">
                         <div class="col-12 col-md-6 col-lg-6">
                              <div class="form-floating form-floating-outline mb-5">
                               <div id="dropdownContainerCategory">
                                
                                </div>
                            </div>
                          </div>
                           <div class="col-12 col-md-6 col-lg-6">
                              <div class="form-floating form-floating-outline mb-5">
                               <div id="dropdownContainerBrand">
                                
                                </div>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="modelName" placeholder="Model Name" name="modelName">
                              <label for="modelName">Model Name</label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-floating form-floating-outline mb-5">
                              <select id="modelStatus" name="modelStatus" class="form-select" >
                                <option value="" disabled="" selected="">Select Model Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                              
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="d-flex flex-column gap-2 form-floating form-floating-outline">
    
                              <input class="form-control form-control-sm" type="file" id="modelImages"  accept="image/*">
                            
                              <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0" id="modelimagePreview"></ul>
                            
                            </div>
                             </div>
                            
                          <div class="col-12 col-md-6 col-lg-6">
                              <div class="form-floating form-floating-outline mb-5">
                                  <textarea 
                                      class="form-control" 
                                      id="modelDescription" 
                                      name="modelDescription" 
                                      placeholder="Model Description"
                                      style="height: 100px;"></textarea>
                                
                                <label for="modelDescription">Model Description</label>
                              </div>
                            </div>
                       
                         
                         <div class="col-12 d-flex justify-content-between">
                    
                        <button type="button" class="btn btn-secondary" id="btn_model_cancel">Cancel</button>
                    
                        <div class="d-flex gap-2">
                          <button class="btn btn-primary" type="button" id="saveModelData">Save</button>
                          <input type="hidden" id="modelId">
                          
                        </div>
                    
                      </div>
                        </div>
                   
                  </div>
                  <div class="col-12 col-lg-4">
                      <div class="card shadow-sm">
                         <div class="card-header p-2">
                              <input type="text" id="vehicleModelSearch" class="form-control" placeholder="Type to search model...">
                            </div>
                        <div class="card-body p-2">
                          <div class="table-responsive">
                            <table id="vehicleModelTable" class="table table-sm table-hover align-middle customdataTable">
                              <thead class="">
                                <tr>
                                  <th>#</th>
                                  <th>Model</th>
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