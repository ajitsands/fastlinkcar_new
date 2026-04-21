<div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                       <div class="mb-1 mt-0">
                          <h5 class="card-title mb-0">Category Details</h5>
                          <small class="text-muted">Add or manage category information</small>
                        </div>
                      
                      <div class="row g-3 mb-4">

                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-floating form-floating-outline mb-5">
                              <input type="text" class="form-control" id="categoryName" placeholder="Category" name="categoryName">
                              <label for="categoryName">Category</label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-floating form-floating-outline mb-5">
                              <select id="categoryStatus" name="categoryStatus" class="form-select" >
                                <option value="" disabled="" selected="">Select Category Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                              </select>
                              <label for="categoryStatus">Category Status</label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6 col-lg-6">
                            <div class="d-flex flex-column gap-2 form-floating form-floating-outline">
    
                              <input class="form-control form-control-sm" type="file" id="categoryImages"  accept="image/*">
                            
                              <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0" id="categoryimagePreview"></ul>
                            
                            </div>
                             </div>
                            
                          <div class="col-12 col-md-6 col-lg-6">
                              <div class="form-floating form-floating-outline mb-5">
                                  <textarea 
                                      class="form-control" 
                                      id="categoryDescription" 
                                      name="categoryDescription" 
                                      placeholder="Category Description"
                                      style="height: 100px;"></textarea>
                                
                                <label for="categoryDescription">Category Description</label>
                              </div>
                            </div>
                       
                         
                         <div class="col-12 d-flex justify-content-between">
                    
                        <button type="button" class="btn btn-secondary" id="btn_category_cancel">Cancel</button>
                    
                        <div class="d-flex gap-2">
                          <button class="btn btn-primary" type="button" id="saveCategoryData">Save</button>
                          <input type="hidden" id="categoryId">
                          
                        </div>
                    
                      </div>
                        </div>
                   
                  </div>
                  <div class="col-12 col-lg-4">
                      <div class="card shadow-sm">
                         <div class="card-header p-2">
                              <input type="text" id="vehicleCategorySearch" class="form-control" placeholder="Type to search category...">
                            </div>
                        <div class="card-body p-2">
                          <div class="table-responsive">
                            <table id="vehicleCategoryTable" class="table table-sm table-hover align-middle customdataTable">
                              <thead class="">
                                <tr>
                                  <th>#</th>
                                  <th>Category</th>
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