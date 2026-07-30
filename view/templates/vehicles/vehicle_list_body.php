 <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Filter</h5>
                 <div class="row align-items-end g-2">

    <!-- Date -->
    <div class="col-md-2">
        <div class="form-floating form-floating-outline">
            <input class="form-control form-control-sm"
                   id="filter_date"
                   name="filter_date"
                   type="date"
                   placeholder="dd-mm-yyyy">
            <label for="filter_date">Filter By</label>
        </div>
    </div>

    <!-- Dropdown -->
    <div class="col-md-4">
        <div class="form-floating form-floating-outline">
        <div id="dropdownContaineravail" class=" w-100">
         <label for="vehicleModelLbl">Select Vehicle Model</label>
        </div>
        </div>
    </div>

    <!-- Search Button -->
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnSearch">
    <i class="ri ri-search-line me-1"></i> Search
</button>
    </div>
     <div class="col-md-2">
    <button 
        class="btn btn-primary rounded-pill"
        id="openCalendarBtn"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="Open Due Calendar">
        
        <i class="ri ri-calendar-check-line fs-5"></i>
        
    </button>
</div>
</div>
                </div>
                <div class="card-datatable table-responsive">
                  <table class="datatables-products table" id="vehicleTable">
                    <thead>
                      <tr>
                          
                    <th>Sn</th>
                       <th>Model</th>
                    <th>Number</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Next Passing </th>
                    <th>Next Insurance </th>
                    <th>Next Maintenance </th>
                    <th>Purchase On</th>
                    <th>Actions</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>