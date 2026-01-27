<!-- Modal -->
<div class="modal fade" id="addNewCustomerModal" data-bs-backdrop="static" tabindex="-1" style="z-index: 10065 !important;">
    <div class="modal-dialog modal-xl">
    <form id="addDriverDetails" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropCustomerModalTitle">Add Customer Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col mb-0 mt-2">
                    <label for="bookingCustomerName" class="form-label">Customer Name</label>
                    <input class="form-control form-control-sm" id="bookingCustomerName" name="bookingCustomerName" type="text">
            </div>
            <div class="col mb-0 mt-2">
                <div class="mb-0">
                    <label for="" class="form-label">Customer Type</label>
                    <select id="driver_document_type" name="driver_document_type" class="form-select form-select-sm">
                              <option value="" disabled="" selected="">Select</option>
                              <option value="Individual">Individual</option>
                              <option value="Corporate">Corporate</option>
                              <option value="Agency">Agency</option>
                              
                    </select>
                </div>
            </div>
            
            
            <div class="row">
                  <div class="col mb-4 mt-2">
                    
                    <div class="row">
                        
                        <div class="col mb-0 mt-2">
                                <label for="customerAria" class="form-label">Area</label>
                                <input class="form-control form-control-sm" id="customerAria" name="customerAria" type="text">
                        </div>
                        <div class="col mb-0 mt-2">
                            <div class="mb-2">
                                <label for="customerBlock" class="form-label">Block</label>
                                <input class="form-control form-control-sm" id="customerBlock" name="customerBlock" type="text">
                            </div>
                        </div>    
                          <div class="col mb-0 mt-2">
                                <label for="customerRoad" class="form-label">Road</label>
                                <input class="form-control form-control-sm" id="customerRoad" name="customerRoad" type="text">
                        </div>
                        <div class="col mb-0 mt-2">
                            <div class="mb-2">
                                <label for="customerBuilding" class="form-label">Building</label>
                                <input class="form-control form-control-sm" id="customerBuilding" name="customerBuilding" type="text">
                            </div>
                        </div>
                        <div class="col mb-0 mt-2">
                                <label for="customerHouse" class="form-label">House</label>
                                <input class="form-control form-control-sm" id="customerHouse" name="customerHouse" type="text">
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col mb-0 mt-2">
                            <div class="mb-2">
                                <label for="customerCprCr" class="form-label">CPR/CR</label>
                                <input class="form-control form-control-sm" id="customerCprCr" name="customerCprCr" type="text">
                            </div>
                        </div>
                        <div class="col mb-0 mt-2">
                                <label for="customerMobile" class="form-label">Mobile</label>
                                <input class="form-control form-control-sm" id="customerMobile" name="customerHouse" type="text">
                        </div>
                       
                        <div class="col mb-0 mt-2">
                                <label for="customerMobileOther" class="form-label">Mobile Other</label>
                                <input class="form-control form-control-sm" id="customerMobileOther" name="customerMobileOther" type="text">
                        </div>
                        <div class="col mb-0 mt-2">
                            <div class="mb-2">
                                <label for="customerDirectNumber" class="form-label">Direct Number</label>
                                <input class="form-control form-control-sm" id="customerDirectNumber" name="customerDirectNumber" type="text">
                            </div>
                        </div>
                            
                    </div>
                   
        
                    
                    <div class="d-flex align-items-center justify-content-between mb-2">
            
                        <div id="customerSavingStatus"></div>
                    
                        <div id="customerSavingStatusSpinner" class="spinner-border spinner-border-sm text-secondary" role="status" style="display:none;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    
                    </div>
                    
                    
                    
                    
                  </div>
                </div>
            
            
            <div class="row">
                
                <div class="d-flex align-items-center">
                                    
                                    <div class="d-flex align-items-center">
                                      <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 " id="customerDocumentImages">
                                        
                                      </ul>
                                        
                                    </div>
                                    <div class="ms-auto">
                          
                      
                                            <div class="row g-1 p-5 pt-0">
                                                <a href="javascript:;" class="me-1 mt-1">
                                                  <span class="badge bg-label-info rounded-pill openAttachmentModal">Add More</span>
                                                </a>
                                            </div>
                                    </div>
                                </div>
            </div>
            
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" id="buttonCloseCustomerModal" data-bs-dismiss="modal" >
          Close
        </button>
        <button type="button" class="btn btn-primary" id="addCustomerDetailsButton">Add Customer</button>
      </div>
    </form>
    </div>
</div>