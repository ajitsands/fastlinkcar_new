<div class="offcanvas offcanvas-end offcanvas-half" tabindex="-1" id="invoiceCanvas">
    <div class="offcanvas-header bg-danger pb-2">
        <h5 id="canvasTitle" class="offcanvas-title text-white">Invoices</h5><input type="hidden" id="txt_qtn_draft">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body pt-0 ">
         <div class="row g-3 align-items-end mb-3">

    <div class="col-md-2">
        <label for="company_id_filter" class="form-label">Company</label>
        <select class="form-select form-select-sm" id="company_id_filter" name="company_id_filter">
            <option value="all">All</option>
            <?php foreach ($companies as $c): ?>
                <option value="<?php echo htmlspecialchars($c['ids']); ?>" data-code="<?php echo htmlspecialchars($c['company_code']); ?>" data-name="<?php echo htmlspecialchars($c['company_name']); ?>">
                    <?php echo htmlspecialchars($c['company_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-2">
        <label for="from_date_filter" class="form-label">From Date</label>
        <input type="date" id="from_date_filter" class="form-control form-control-sm">
    </div>

    <div class="col-md-2">
        <label for="to_date_filter" class="form-label">To Date</label>
        <input type="date" id="to_date_filter" class="form-control form-control-sm">
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

    <div class="col-md-2 ">
        <button type="button" class="btn btn-primary" id="btn_filter">
            <i class="mdi mdi-magnify me-1"></i> Search
        </button>
    </div>

</div>
       
        <table class="table table-bordered" id="invoiceList">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Subtotal</th>
                    <th>VAT</th>
                    <th>Total</th>
                    <th>Action</th>
                    <th>Print</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
