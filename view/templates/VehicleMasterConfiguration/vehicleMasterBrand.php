<div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                       <div class="mb-1 mt-0">
                          <h5 class="card-title mb-0">Brand Details</h5>
                          <small class="text-muted">Add or manage brand information</small>
                        </div>
                      
                      <div class="row g-3 mb-4">

                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="brandName" placeholder="Brand Name" name="brandName">
                              <label for="brandName">Brand Name</label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-floating form-floating-outline mb-5">
                              <select id="brandStatus" name="brandStatus" class="form-select" >
                                <option value="" disabled="" selected="">Select Brand Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                              <label for="brandStatus">Brand Status</label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="d-flex flex-column gap-2 form-floating form-floating-outline">
    
                              <input class="form-control form-control-sm" type="file" id="brandImages"  accept="image/*">
                            
                              <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0" id="brandimagePreview"></ul>
                            
                            </div>
                             </div>
                            
                          <div class="col-12 col-md-6 col-lg-6">
                              <div class="form-floating form-floating-outline mb-5">
                                  <textarea 
                                      class="form-control" 
                                      id="brandDescription" 
                                      name="brandDescription" 
                                      placeholder="Brand Description"
                                      style="height: 100px;"></textarea>
                                
                                <label for="brandDescription">Brand Description</label>
                              </div>
                            </div>
                       
                         
                         <div class="col-12 d-flex justify-content-between">
                    
                        <button type="button" class="btn btn-secondary" id="btn_brand_cancel">Cancel</button>
                    
                        <div class="d-flex gap-2">
                          <button class="btn btn-primary" type="button" id="saveBrandData">Save</button>
                          <input type="hidden" id="brandId">
                          
                        </div>
                    
                      </div>
                        </div>
                   
                  </div>
                  <div class="col-12 col-lg-4">
                      <div class="card shadow-sm">
                         <div class="card-header p-2">
                              <input type="text" id="vehicleBrandSearch" class="form-control" placeholder="Type to search brand...">
                            </div>
                        <div class="card-body p-2">
                          <div class="table-responsive">
                            <table id="vehicleBrandTable" class="table table-sm table-hover align-middle customdataTable">
                              <thead class="">
                                <tr>
                                  <th>#</th>
                                  <th>Brand</th>
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