 <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Contract Generation</h5>
                 <div class="row align-items-end g-2">
                <div class="col-md-4">
                    <div class="d-flex align-items-stretch gap-2">
            
                    <div class="form-floating form-floating-outline flex-grow-1">
                        <select id="selectCustomerFromSelect2"
                                name="customer_name"
                                class="select2 form-select"
                                data-allow-clear="true"
                                style="width:100%">
                        </select>
                    
                    </div>
            
                    <button type="button"
                            id="addCustomerBtn"
                            class="btn btn-primary d-flex align-items-center justify-content-center"
                            title="Add New Customer">
                        <i class="ri ri-user-add-line" style="font-size:20px;"></i>
                    </button>
            
                </div>
                </div>
                <input id="customer_code" name="customer_code" type="hidden">
                <input id="customerName" name="customerName" type="hidden">
                
    <!-- Date -->
    <div class="col-md-2">
        <div class="form-floating form-floating-outline">
            <input class="form-control form-control-sm"
                   id="filter_from_date"
                   name="filter_from_date"
                   type="date"
                   placeholder="dd-mm-yyyy">
            <label for="filter_from_date">From Date</label>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-floating form-floating-outline">
            <input class="form-control form-control-sm"
                   id="filter_to_date"
                   name="filter_to_date"
                   type="date"
                   placeholder="dd-mm-yyyy">
            <label for="filter_to_date">To Date</label>
        </div>
    </div>
    <div class="col-md-2">
    <div class="form-floating form-floating-outline">
        <select class="form-select form-select-sm" id="select_booking_status" name="select_booking_status">
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
            <option value="All">All</option>
        </select>
        <label for="select_booking_status">Status</label>
    </div>
</div>
    
    <!-- Search Button -->
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnSearch">
    <i class="ri ri-search-line me-1"></i> Search
</button>
    </div>

</div>
                </div>
                <div class="card-datatable table-responsive">
                  <table id="bookingTable" class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th></th> 
                                    <th>Booking Ref</th>
                                    <th>Customer</th>
                                    <th>Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                </div>
              </div>