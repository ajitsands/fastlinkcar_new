 <div class="container-fluid flex-grow-1 container-p-y">
             
              <!-- Product List Table -->
              <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Staff Use Vehicle Report</h5>
                 <div class="row align-items-end g-2">

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
            <label for="filter_from_date">To Date</label>
        </div>
    </div>
    <div class="col-md-3">
        <label for="selectStaffFromSelect2" class="form-label">Search Staff</label>
        <select id="selectStaffFromSelect2"
                name="staff_name_filter"
                class="select2 form-select"
                data-allow-clear="true"
                style="width:100%;">
        </select>

        <input type="hidden"
               id="staff_id_filter"
               name="staff_id_filter">
    </div>
     <div class="col-md-3">
        <label for="selectVehicleFromSelect2" class="form-label">Search Vehicle</label>
        <select id="selectVehicleFromSelect2"
                name="vehicle_name_filter"
                class="select2 form-select"
                data-allow-clear="true"
                style="width:100%;">
        </select>

        <input type="hidden"
               id="vehicle_id_filter"
               name="vehicle_id_filter">
    </div>
    <!-- Dropdown -->
    <div class="col-md-2" style="display:none">
         <label for="vehicleModelLbl">Vehicle Model</label>
        <div class="form-floating form-floating-outline">
           
        <div id="dropdownContaineravail" class=" w-100">
         
        </div>
        </div>
    </div>

    <!-- Search Button -->
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnSearch">
    <i class="ri ri-search-line me-1"></i> Search
</button>
    </div>
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnExport">
    <i class="ri ri-file-pdf-2-line me-1"></i> Export
</button>
    </div>
    
</div>
                </div>
                

    <div class="card-datatable table-responsive">
                  <table class="datatables-products table" id="tbl_report">
                    <thead>
                      <tr>
                    <th>SNo</th>
                    <th>Ref. No</th>
                    <th>Staff</th>
                    <th>Vehicle</th>
                    <th>Period</th>
                    <th>Notes</th>
                    <th>Return Notes</th>
                    <th>Status</th>
                      </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                  </table>
                </div>


  
              </div>
             
               
                  
             
            </div>