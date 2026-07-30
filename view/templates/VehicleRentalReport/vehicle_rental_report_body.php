 <div class="container-fluid flex-grow-1 container-p-y">
             
              <!-- Product List Table -->
              <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Daily Rental Report</h5>
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
    <div class="col-md-4">
        <label for="selectCustomerFromSelect2_filter" class="form-label">Customer</label>
        <select id="selectCustomerFromSelect2_filter"
                name="customer_name_filter"
                class="select2 form-select"
                data-allow-clear="true"
                style="width:100%;">
        </select>

        <input type="hidden"
               id="customer_code_filter"
               name="customer_code_filter">
    </div>
    <!-- Dropdown -->
    <div class="col-md-2">
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
                    <th>Customer</th>
                    <th>C.Type</th>
                    <th>Ag. No</th>
                    <th>Reg. No</th>
                    <th>Make & Model</th>
                    <th>Ag. Date</th>
                    <th>Service</th>
                    <th>Type</th>
                    <th>Duration</th>
                    <th>Rate</th>
                    <th>VAT%</th>
                    <th>Amount</th>
                    <th>Delivered</th>
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
                        <th></th>
                        <th></th>
                        <th colspan="2" style="text-align:right">Grand Total</th>
                        <th style="text-align:right"></th>
                        <th></th>
                    </tr>
                    </tfoot>
                  </table>
                </div>


  
              </div>
             
               
                  
             
            </div>