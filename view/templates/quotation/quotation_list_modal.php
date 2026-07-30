<div class="offcanvas offcanvas-end offcanvas-half" tabindex="-1" id="quotationCanvas">
    <div class="offcanvas-header pb-0">
        <h4 id="canvasTitle">Quotations</h4><input type="hidden" id="txt_qtn_draft">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body pt-0 ">
        <div class="row g-3 align-items-end mb-3">

    <div class="col-md-2">
        <label for="from_date_filter" class="form-label">From Date</label>
        <input type="date" id="from_date_filter" class="form-control">
    </div>

    <div class="col-md-2">
        <label for="to_date_filter" class="form-label">To Date</label>
        <input type="date" id="to_date_filter" class="form-control">
    </div>

    <div class="col-md-6">
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
       
        <table class="table table-bordered" id="quotationList">
            <thead>
                <tr class="bg-primary">
                    <th>No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Subtotal</th>
                    <th>VAT</th>
                    <th>Total</th>
                     <th>Approval Status</th>
                    <th>View</th>
                    <!--<th>Print</th>-->
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
