<div class="offcanvas offcanvas-end offcanvas-half" tabindex="-1" id="cashmemoCanvas">
    <div class="offcanvas-header pb-0" style="background-color: #1b3d94 !important; color: #fff !important; padding: 15px 20px;">
        <h4 id="canvasTitle" class="mb-0 text-white">Cash Memo</h4><input type="hidden" id="txt_qtn_draft">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body pt-0 mt-3">
       <div class="row g-3 align-items-end mb-3">
       
    <div class="col-md-2">
        <label for="company_id_filter" class="form-label">Company</label>
        <select id="company_id_filter" class="form-select">
            <option value="All">All</option>
            <?php foreach ($companies as $c): ?>
                <option value="<?php echo htmlspecialchars($c['ids']); ?>"><?php echo htmlspecialchars($c['company_name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-2">
        <label for="from_date_filter" class="form-label">From Date</label>
        <input type="date" id="from_date_filter" class="form-control">
    </div>

    <div class="col-md-2">
        <label for="to_date_filter" class="form-label">To Date</label>
        <input type="date" id="to_date_filter" class="form-control">
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
       
        <table class="table table-hover align-middle" id="cashmemoList" style="font-size: 13px; width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Details</th>
                    <th class="text-end">Subtotal</th>
                    <th class="text-end">VAT</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Sign / Print</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
