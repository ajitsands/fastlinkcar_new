 <div class="card">
                <div class="card-header border-bottom">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Contract Generation</h5>
                
                     <button type="button"
        class="btn btn-dark fw-semibold px-3"
        id="btnWalkIns"
        data-bs-toggle="tooltip"
        data-bs-trigger="hover"
        data-bs-placement="top"
        title="Create Direct Booking">

    <i class="ri ri-add-circle-line me-1 fs-5"></i>
    Direct Booking

</button>
                    </div>

                 <div class="row align-items-end g-2">
                <div class="col-md-2">
                    <div class="form-floating form-floating-outline flex-grow-1">
                        <select id="companySelect" name="companySelect" class="form-select" data-allow-clear="true" style="width:100%">
                            <!-- Populated via AJAX -->
                        </select>
                        <label for="companySelect">Company</label>
                    </div>
                </div>
                <div class="col-md-3">
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
                            
                            class="btn btn-primary d-none align-items-center justify-content-center addCustomerBtn"
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
            <option value="All" selected>All</option>
            <option value="Booked">Booked</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Rentout">Rentout</option>
            <option value="Returned">Returned</option>
            <option value="Cancelled">Cancelled</option>
            
        </select>
        <label for="select_booking_status">Status</label>
    </div>
</div>
    
    <!-- Search Button -->
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnMainSearch" title="Search">
    <i class="ri ri-search-line me-1"></i> Search
</button>
    </div>
   
</div>
                </div>
                <div class="card-datatable table-responsive">
                    <div class="card-header card-headernew d-flex justify-content-between align-items-center py-2">
                        <h4 class="mb-0 fs-6">  </h4>
                    
                        <div class="dropdown d-none">
                            <button 
                                class="btn btn-primary btn-sm dropdown-toggle py-1 px-2"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Actions
                            </button>
                    
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item py-1 text-info btnOpenSignatureGroup" >
                                        <i class="ri ri-quill-pen-line"></i> Apply Signature
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                   
                <div class="card-body">
                  <table id="bookingTable1" class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th></th> 
                                    <th> Ref</th>
                                    <th>Reservation Date</th>
                                    <th>Customer</th>
                                    <th>Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                </div>
                </div>
              </div>