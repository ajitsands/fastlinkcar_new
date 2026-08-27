<div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                       <div class="mb-1 mt-0">
                          <h5 class="card-title mb-0">Model Pricing Details</h5>
                          <small class="text-muted">Add or manage vehicle model pricing information</small>
                        </div>
                      
                      <div class="row g-3 mb-4">
                         <div class="col-12 col-md-12 col-lg-12">
                              <div class="container">

                                <button class="btn btn-primary d-none" type="button" id="addpriceMasterBtn" data-permission="vehicle_config_manage" style="display: none !important;">+ Add Pricing Master</button>
                            
                                <table class="table" id="pricingTable">
                                     <thead>
                                         <tr>
                                             <th style="width:75%;">Item</th>
                                             <th class="text-end" style="width:25%;">Amount</th>
                                         </tr>
                                     </thead>
                            
                                    <tbody>
                                        <!-- dynamic rows -->
                                    </tbody>
                                </table>
                            
                            </div>
                          </div>
                           
                          
                         
                         <div class="col-12 d-flex justify-content-between">
                    
                        <div class="d-flex gap-2">
                          <button class="btn btn-primary" type="button" id="saveBtnPricing" data-permission="vehicle_config_manage">Save</button>
                          <input type="hidden" id="pricingmodelId">
                          
                        </div>
                    
                      </div>
                        </div>
                   
                  </div>
                  
                  <div class="col-12 col-lg-4">
                      <div class="card shadow-sm">
                         <div class="card-header p-2">
                              <input type="text" id="vehiclePricingSearch" class="form-control" placeholder="Type to search model pricing details...">
                            </div>
                        <div class="card-body p-2">
                          <div class="table-responsive">
                            <table id="vehicleModelPricingTable" class="table table-sm table-hover align-middle ">
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