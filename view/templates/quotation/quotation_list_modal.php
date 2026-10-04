<?php
$allowedCompanies = [];
if (!empty($_SESSION['company_json'])) {
    $companyData = json_decode($_SESSION['company_json'], true);
    if (is_array($companyData)) {
        $allowedCompanies = $companyData;
    }
}
if (empty($allowedCompanies) && !empty($_SESSION['company_id'])) {
    $allowedCompanies = [
        ['ids' => $_SESSION['company_id'], 'company_name' => $_SESSION['company_name'] ?? 'Default Company']
    ];
}
$isSingleCompany = count($allowedCompanies) <= 1;
?>
<div class="offcanvas offcanvas-end offcanvas-half" tabindex="-1" id="quotationCanvas">
    <div class="offcanvas-header bg-danger pb-2">
        <h5 id="canvasTitle" class="offcanvas-title text-white">Quotations</h5><input type="hidden" id="txt_qtn_draft">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body pt-0 ">
        <div class="row g-3 align-items-end mb-3">

    <div class="col-md-2">
        <label for="company_id_filter" class="form-label mb-1">Company</label>
        <select id="company_id_filter" class="form-select form-select-sm" <?= $isSingleCompany ? 'readonly' : '' ?>>
            <?php if (!$isSingleCompany): ?>
                <option value="All">All</option>
            <?php endif; ?>
            <?php foreach ($allowedCompanies as $comp): ?>
                <option value="<?= htmlspecialchars($comp['ids']) ?>"><?= htmlspecialchars($comp['company_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-2">
        <label for="from_date_filter" class="form-label mb-1">From Date</label>
        <input type="date" id="from_date_filter" class="form-control form-control-sm">
    </div>

    <div class="col-md-2">
        <label for="to_date_filter" class="form-label mb-1">To Date</label>
        <input type="date" id="to_date_filter" class="form-control form-control-sm">
    </div>

    <div class="col-md-4">
        <label for="selectCustomerFromSelect2_filter" class="form-label mb-1">Customer</label>
        <select id="selectCustomerFromSelect2_filter"
                name="customer_name_filter"
                class="select2 form-select form-select-sm"
                data-allow-clear="true"
                style="width:100%;">
        </select>

        <input type="hidden"
               id="customer_code_filter"
               name="customer_code_filter">
    </div>

    <div class="col-md-2 ">
        <button type="button" class="btn btn-sm btn-primary mt-4" id="btn_filter">
            <i class="ri ri-search-line me-1"></i> Search
        </button>
    </div>

</div>
       
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-hover align-middle w-100" id="quotationList">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Subtotal</th>
                    <th>VAT</th>
                    <th>Total</th>
                    <th>Approval Status</th>
                    <th>Edit</th>
                    <!--<th>Print</th>-->
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        </div>
    </div>
</div>
