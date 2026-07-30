<style>
    .table tbody td {
        padding: 4px 6px !important;
        vertical-align: middle;
        font-size: 12.5px;
    }
</style>
<form id="CustomerDetailsForm" name="CustomerDetailsForm">

    <div class="layout-demo-wrapper mt-0">
        <div class="container-fluid flex-grow-1 pt-0 pb-1">

            <!-- Add User -->
           

            <div class="row">
                <!-- First column-->
                <div class="col-12">
                    <!-- User Information -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Manage Customers</h5>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="editUserId">

                            <div class="row">

                                <!-- LEFT COLUMN: Inputs (wider) -->
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
                                            <label for="customerMobile_onmodal" class="form-label">Phone Number</label>
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

                            <!-- Buttons -->
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-secondary ms-2" id="clearCustomerData"><i class="menu-icon icon-base ri ri-delete-back-2-line"></i>Clear</button>
                                <button type="submit" class="btn btn-primary" id="btn_add_new_customer"><i class="menu-icon icon-base ri ri-save-2-fill"></i> Save Customer</button>
                                <button type="submit" class="btn btn-primary" id="btn_update_customer" style="display:none;"><i class="menu-icon icon-base ri ri-file-edit-line"></i>Update Customer</button>
                            </div>
                        </div>
                    </div>
                    <!-- /User Information -->
                </div>
                <!-- /Second column -->
                <!-- Second column -->
                <div class="col-12">
                    <div class="card mb-6">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <h5 class="card-title mb-0">List of Customers</h5>

                            <!-- Custom Search -->
                            <div class="d-flex" style="gap:8px; width:300px;">
                                <input type="text" id="searchCustomer" class="form-control form-control-sm" placeholder="Search customers...">

                              
                            </div>

                        </div>

                        <div class="card-body">

                            <div class="card-datatable table-responsive">
                                <table class="datatables-products table" id="customerTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Tele</th>
                                            <th>CPR/CR</th>
                                            <th>Attn</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- /Second column -->
            </div>
        </div>

    </div>

    <!--  Reset password modal -->
    <!-- <div class="mt-4">
        <div class="modal fade" id="resetPasswordModal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="resetUserId">
                        <div class="row">
                            <div class="col mb-6 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="newPassword" class="form-control" placeholder="Enter Name">
                                    <label for="nameWithTitle">New Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" id="emailWithTitle" class="form-control" placeholder="xxxx@xxx.xx">
                                    <label for="emailWithTitle">Email</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary waves-effect waves-light">Update Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Reset password modal end -->


    <script>
        // $(document).ready(function() {

        //     loadRoles();

        // });
    </script>

</form>