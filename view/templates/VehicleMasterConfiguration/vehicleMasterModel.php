<div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                       <div class="d-flex align-items-center justify-content-between mb-3 mt-0">
                           <div>
                               <h5 class="card-title mb-0">Model Details</h5>
                               <small class="text-muted">Add or manage vehicle model information</small>
                           </div>
                           <div id="modelStatusBadgeContainer">
                               <span class="badge bg-label-success" id="modelStatusBadge">New Entry</span>
                           </div>
                       </div>
                       
                       <input type="hidden" id="modelStatus" name="model_status" value="Active">
                      
                      <div class="row g-3 mb-4">
                         <div class="col-12 col-md-6 col-lg-6">
                              <div class="form-floating form-floating-outline mb-3">
                               <div id="dropdownContainerCategory">
                                
                                </div>
                            </div>
                          </div>
                           <div class="col-12 col-md-6 col-lg-6">
                              <div class="form-floating form-floating-outline mb-3">
                               <div id="dropdownContainerBrand">
                                
                                </div>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-floating form-floating-outline mb-3">
                              <input type="text" class="form-control" id="modelName" placeholder="Model Name" name="modelName">
                              <label for="modelName">Model Name</label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="d-flex flex-column gap-2 form-floating form-floating-outline">
    
                              <input class="form-control form-control-sm" type="file" id="modelImages"  accept="image/*">
                            
                              <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0" id="modelimagePreview"></ul>
                            
                            </div>
                             </div>
                            
                          <div class="col-12 col-md-12 col-lg-12">
                              <div class="form-floating form-floating-outline mb-3">
                                  <textarea 
                                      class="form-control" 
                                      id="modelDescription" 
                                      name="modelDescription" 
                                      placeholder="Model Description"
                                      style="height: 80px;"></textarea>
                                
                                <label for="modelDescription">Model Description</label>
                              </div>
                            </div>
                       
                         
                         <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    
                        <button type="button" class="btn btn-secondary" id="btn_model_cancel">
                            <i class="ri-refresh-line me-1"></i> Reset / Clear
                        </button>
                    
                        <div class="d-flex gap-2">
                          <button type="button" class="btn btn-warning d-none" id="toggleModelStatusBtn" data-permission="vehicle_config_manage">
                              <i class="ri-close-circle-line me-1"></i> Deactivate
                          </button>
                          <button class="btn btn-primary" type="button" id="saveModelData" data-permission="vehicle_config_manage">
                              <i class="ri-save-line me-1"></i> Save
                          </button>
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
                            <table id="vehicleModelTable" class="table table-sm table-hover align-middle ">
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