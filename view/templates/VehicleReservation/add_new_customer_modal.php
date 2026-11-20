<div class="modal fade" id="QtnAddNewCustomerModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title">Add New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row">
        
       
                <div class="col-12">
                  
                         <div class="row g-2">
                              <div class="col-md-4">
                                    <label for="customer_type_onmodal" class="form-label form-label-sm mb-1">Customer Type <span class="text-danger">*</span></label>
                                    <select id="customer_type_onmodal" name="customer_type_onmodal" class="form-select form-select-sm">
                                              <option value="" disabled="" selected="">Select</option>
                                              <option value="Individual">Individual</option>
                                              <option value="Corporate">Corporate</option>
                                              <option value="Agency">Agency</option>
                                    </select>
                            </div>
                            <div class="col-md-4">
                                    <label for="bookingCustomerName_onmodal" class="form-label form-label-sm mb-1">Customer Name <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="bookingCustomerName_onmodal" name="bookingCustomerName_onmodal" type="text" placeholder="Customer Name">
                            </div>
                            <div class="col-md-4">
                                    <label for="customerMobile_onmodal" class="form-label form-label-sm mb-1">Contact Number <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="customerMobile_onmodal" name="customerMobile_onmodal" type="text" placeholder="Contact Number">
                            </div>
                        </div>
                        <div class="row g-2 mt-1">
                              <div class="col-md-4">
                                    <label for="customerEmail_onmodal" class="form-label form-label-sm mb-1">Email</label>
                                    <input class="form-control form-control-sm" id="customerEmail_onmodal" name="customerEmail_onmodal" type="text" placeholder="Email">
                            </div>
                            <div class="col-md-4">
                                    <label for="bookingCustomerAttn_onmodal" class="form-label form-label-sm mb-1">Attention</label>
                                    <input class="form-control form-control-sm" id="bookingCustomerAttn_onmodal" name="bookingCustomerAttn_onmodal" type="text" placeholder="Attention">
                            </div>
                            <div class="col-md-4">
                                <label for="customerCprCr_onmodal" class="form-label form-label-sm mb-1">ID Number (CR/CPR No.) <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm" id="customerCprCr_onmodal" name="customerCprCr_onmodal" type="text" placeholder="CPR / CR No.">
                            </div>
                        </div>
                        <div class="row g-2 mt-1">
                            <div class="col-md-4">
                                <label for="cprexpiryDate_onmodal" class="form-label form-label-sm mb-1">CR/CPR Expiry Date</label>
                                <input class="form-control form-control-sm" id="cprexpiryDate_onmodal" name="cprexpiryDate_onmodal" type="date">
                            </div>
                             <div class="col-md-8">
                                    <label for="bookingCustomerAddress_onmodal" class="form-label form-label-sm mb-1">Address</label>
                                    <textarea class="form-control form-control-sm" id="bookingCustomerAddress_onmodal" name="bookingCustomerAddress_onmodal" rows="1" placeholder="Customer Address"></textarea>
                            </div>
                        </div>
                            <?php include ROOT_PATH . '/view/templates/customer/customer_modal_extra_fields.php'; ?>
            
            
           
        
                      
                    
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