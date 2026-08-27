<div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                       <div class="d-flex align-items-center justify-content-between mb-3 mt-0">
                           <div>
                               <h5 class="card-title mb-0">Category Details</h5>
                               <small class="text-muted">Add or manage category information</small>
                           </div>
                           <div id="categoryStatusBadgeContainer">
                               <span class="badge bg-label-success" id="categoryStatusBadge">New Entry</span>
                           </div>
                       </div>
                       
                       <input type="hidden" id="categoryStatus" name="status" value="Active">
                       <div class="row g-3 mb-4">

                           <div class="col-12 col-md-6 col-lg-6">
                             <div class="form-floating form-floating-outline mb-3">
                               <input type="text" class="form-control" id="categoryName" placeholder="Category" name="categoryName">
                               <label for="categoryName">Category</label>
                             </div>
                           </div>
                           <div class="col-12 col-md-6 col-lg-6">
                             <div class="d-flex flex-column gap-2 form-floating form-floating-outline">
     
                               <input class="form-control form-control-sm" type="file" id="categoryImages"  accept="image/*">
                             
                               <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0" id="categoryimagePreview"></ul>
                             
                             </div>
                              </div>
                             
                           <div class="col-12 col-md-12 col-lg-12">
                               <div class="form-floating form-floating-outline mb-3">
                                   <textarea 
                                       class="form-control" 
                                       id="categoryDescription" 
                                       name="categoryDescription" 
                                       placeholder="Category Description"
                                       style="height: 80px;"></textarea>
                                 
                                 <label for="categoryDescription">Category Description</label>
                               </div>
                             </div>
                        
                          
                          <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
                     
                         <button type="button" class="btn btn-secondary" id="btn_category_cancel">
                             <i class="ri-refresh-line me-1"></i> Reset / Clear
                         </button>
                     
                         <div class="d-flex gap-2">
                           <button type="button" class="btn btn-warning d-none" id="toggleCategoryStatusBtn" data-permission="vehicle_config_manage">
                               <i class="ri-close-circle-line me-1"></i> Deactivate
                           </button>
                           <button class="btn btn-primary" type="button" id="saveCategoryData" data-permission="vehicle_config_manage">
                               <i class="ri-save-line me-1"></i> Save
                           </button>
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
                            <table id="vehicleCategoryTable" class="table table-sm table-hover align-middle ">
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