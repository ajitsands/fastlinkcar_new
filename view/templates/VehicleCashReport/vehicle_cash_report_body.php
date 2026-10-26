 <div class="container-fluid flex-grow-1 container-p-y">
             
              <!-- Product List Table -->
              <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Daily Cash Report</h5>
                 <div class="row align-items-end g-2">

    <!-- Company -->
    <div class="col-md-2">
        <div class="form-floating form-floating-outline">
            <select id="filter_company" name="filter_company" class="form-select form-select-sm">
                <?php if (!empty($hasMultipleCompanies)): ?>
                    <option value="all" <?= (!empty($defaultCompanyValue) && $defaultCompanyValue === 'all') ? 'selected' : '' ?>>All Companies</option>
                <?php endif; ?>
                <?php if (!empty($allowedCompanies)): ?>
                    <?php foreach ($allowedCompanies as $comp): ?>
                        <option value="<?= htmlspecialchars($comp['ids']) ?>" <?= (!empty($defaultCompanyValue) && strval($comp['ids']) === strval($defaultCompanyValue)) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($comp['company_name']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <label for="filter_company">Company</label>
        </div>
    </div>

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
        <label for="selectCustomerFromSelect2_filter" class="form-label mb-1">Customer</label>
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
         <label for="vehicleModelLbl" class="form-label mb-1">Vehicle Model</label>
         <div class="form-floating form-floating-outline">
            <div id="dropdownContaineravail" class="w-100"></div>
         </div>
    </div>

    <!-- Search Button -->
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnSearch">
            <i class="ri ri-search-line me-1"></i> Search
        </button>
    </div>
    <div class="col-md-1">
        <button class="btn btn-outline-danger w-100 rounded-pill" id="btnExport">
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
                    <th>Date</th>
                    <th>Ref No</th>
                    <th>Pay Mode</th>
                    <th>Ag. No</th>
                    <th style="min-width: 180px; text-align: left;">Customer</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Income</th>
                    <th>Expense</th>
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
                        <th style="text-align:right">Grand Total</th>
                        <th style="text-align:right"></th>
                        <th style="text-align:right"></th>
                    </tr>
                    </tfoot>
                  </table>
                 <div class="row g-2 mt-2">

    <!-- Deposit & Refund -->
    <div class="col-md-2">

        <!-- Total Deposit -->
        <div class="card border-primary shadow-sm mb-2">
            <div class="card-body p-2 text-center bg-primary bg-opacity-10">
                <small class="fw-semibold text-primary d-block">
                    <i class="fa fa-arrow-circle-down me-1"></i> Total Deposit
                </small>
                <h4 class="mb-0 fw-bold text-primary" id="depositTotal">
                    0.000
                </h4>
            </div>
        </div>

        <!-- Total Refund -->
        <div class="card border-danger shadow-sm">
            <div class="card-body p-2 text-center bg-danger bg-opacity-10">
                <small class="fw-semibold text-danger d-block">
                    <i class="fa fa-arrow-circle-up me-1"></i> Total Refund
                </small>
                <h4 class="mb-0 fw-bold text-danger" id="refundTotal">
                    0.000
                </h4>
            </div>
        </div>

    </div>

    <!-- Payment Summary -->
    <div class="col-md-10">
        <div id="paymentSummary"></div>
    </div>

</div>

                </div>


  
              </div>
             
               
                  
             
            </div>