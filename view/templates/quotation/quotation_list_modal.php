<div class="offcanvas offcanvas-end offcanvas-half" tabindex="-1" id="quotationCanvas">
    <div class="offcanvas-header pb-0">
        <h4 id="canvasTitle">Quotations</h4><input type="hidden" id="txt_qtn_draft">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body pt-0 ">
        <div class="row mb-1">
            <div class="col-md-4">
                <label>From Date</label>
                <input type="date" id="from_date_filter" class="form-control">
            </div>
            <div class="col-md-4">
                <label>To Date</label>
                <input type="date" id="to_date_filter" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary me-2" id="btn_filter">Search</button>
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
                    <th>Action</th>
                    <th>Print</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
