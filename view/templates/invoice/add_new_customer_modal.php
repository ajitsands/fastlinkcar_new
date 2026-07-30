<div class="modal fade" id="QtnAddNewCustomerModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Add New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row">
        
       
                <div class="col-12">
                  
                         <div class="row">
                              <div class="col-3 mb-0 mt-2">
                                    <label for="customer_type_onmodal" class="form-label">Customer Type</label>
                                    <select id="customer_type_onmodal" name="customer_type_onmodal" class="form-select form-select-sm">
                                              <option value="" disabled="" selected="">Select</option>
                                              <option value="Individual">Individual</option>
                                              <option value="Corporate">Corporate</option>
                                              <option value="Agency">Agency</option>
                                              
                                    </select>
                            </div>
                            <div class="col-6 mb-0 mt-2">
                                    <label for="bookingCustomerName_onmodal" class="form-label">Customer Name</label>
                                    <input class="form-control form-control-sm" id="bookingCustomerName_onmodal" name="bookingCustomerName_onmodal" type="text">
                            </div>
                            <div class="col mb-0 mt-2">
                                            <label for="customerMobile_onmodal" class="form-label">Telephone</label>
                                            <input class="form-control form-control-sm" id="customerMobile_onmodal" name="customerMobile_onmodal" type="text">
                                    </div>
                           
            
                        </div>
                        <div class="row">
                              <div class="col mb-0 mt-2">
                                            <label for="customerEmail_onmodal" class="form-label">Email</label>
                                            <input class="form-control form-control-sm" id="customerEmail_onmodal" name="customerEmail_onmodal" type="text">
                            </div>
                            <div class="col-6 mb-0 mt-2">
                                    <label for="bookingCustomerAttn_onmodal" class="form-label">Attention</label>
                                    <input class="form-control form-control-sm" id="bookingCustomerAttn_onmodal" name="bookingCustomerAttn_onmodal" type="text">
                            </div>
                            <div class="col mb-0 mt-2">
                                        <div class="mb-2">
                                            <label for="customerCprCr_onmodal" class="form-label">CPR/CR</label>
                                            <input class="form-control form-control-sm" id="customerCprCr_onmodal" name="customerCprCr_onmodal" type="text">
                                        </div>
                                    </div>
                           
            
                        </div>
                        <div class="row">
                             <div class="col mb-0 mt-2">
                                    <label for="bookingCustomerAddress_onmodal" class="form-label">Address</label>
                                    <textarea class="form-control form-control-sm" id="bookingCustomerAddress_onmodal" name="bookingCustomerAddress_onmodal" ></textarea>
                            </div>
                            </div>
            
            
           
        
                      
                    
                </div>
               
       
      </div>

        <div class="modal-footer">
             <button class="btn btn-secondary me-2" data-bs-dismiss="modal">
                    Cancel
            </button>
          
            <button type="button"
                id="btn_add_new_customer"
                class="btn btn-primary me-2">
                Add
            </button>
        
        </div>

    </div>
  </div>
</div>