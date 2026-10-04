<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Create Refund</h5>
            </div>
            <div class="card-body mt-4">
                <form id="refundForm">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="company_id">Company</label>
                            <select class="form-select" id="company_id" name="company_id">
                                <?php if (count($companies) > 1): ?>
                                    <option value="" selected>Select Company</option>
                                <?php endif; ?>
                                <?php foreach ($companies as $c): ?>
                                    <option value="<?php echo htmlspecialchars($c['company_code']); ?>" data-id="<?php echo $c['ids']; ?>">
                                        <?php echo htmlspecialchars($c['company_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="refund_date">Date</label>
                            <input type="date" class="form-control" id="refund_date" name="refund_date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="selectCustomerFromSelect2">Customer</label>
                            <select id="selectCustomerFromSelect2" name="customer_name" class="select2 form-select" data-allow-clear="true" style="width:100%"></select>
                            <input type="hidden" id="customer_code" name="customer_code">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="agreement_no">Agreement No</label>
                            <select class="form-select" id="agreement_no" name="agreement_no"></select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="amount">Amount</label>
                            <input type="number" step="0.001" class="form-control" id="amount" name="amount">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label d-block">Refund Mode</label>
                            <div class="form-check form-check-inline mt-1">
                                <input class="form-check-input" type="radio" name="refund_mode" id="modeCash" value="Cash" checked>
                                <label class="form-check-label" for="modeCash">Cash</label>
                            </div>
                            <div class="form-check form-check-inline mt-1">
                                <input class="form-check-input" type="radio" name="refund_mode" id="modeBank" value="Bank Transfer">
                                <label class="form-check-label" for="modeBank">Bank Transfer</label>
                            </div>
                            <div class="form-check form-check-inline mt-1">
                                <input class="form-check-input" type="radio" name="refund_mode" id="modeCard" value="Credit Card">
                                <label class="form-check-label" for="modeCard">Credit Card</label>
                            </div>
                            <div class="form-check form-check-inline mt-1">
                                <input class="form-check-input" type="radio" name="refund_mode" id="modeCheque" value="Cheque">
                                <label class="form-check-label" for="modeCheque">Cheque</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="reason">Reason/Remarks</label>
                            <textarea class="form-control" id="reason" name="reason" rows="2"></textarea>
                        </div>
                        <div class="col-md-12 mb-3" id="agreementSummarySection" style="display: none;">
                            <div class="alert alert-secondary p-3 mb-0" role="alert">
                                <h6 class="alert-heading fw-bold mb-2 text-primary">Agreement Summary</h6>
                                <div class="row" id="agreementSummaryContent">
                                    <!-- Populated via AJAX -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 mt-2 text-end" id="btnShowChargesContainer">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnShowChargesSection"><i class="ri ri-add-line"></i> Add Additional Charges</button>
                        </div>
                        <div class="col-md-12 mb-3" id="additionalChargesSection" style="display: none;">
                            <div class="card shadow-none border">
                                <div class="card-header border-bottom py-2 d-flex justify-content-between align-items-center bg-light">
                                    <h6 class="m-0 fw-bold">Additional Charges (Violations, Damage, etc.)</h6>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-primary" id="btnAddChargeRow">Add Charge Row</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2" id="btnHideChargesSection"><i class="ri ri-close-line"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0 table-responsive">
                                    <table class="table table-bordered table-sm mb-0" id="chargesTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="30%">Charge Type</th>
                                                <th width="40%">Description / Remarks</th>
                                                <th width="20%">Amount</th>
                                                <th width="10%" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chargesTableBody">
                                            <tr class="empty-row"><td colspan="4" class="text-center text-muted">No additional charges added</td></tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-end">Total Charges:</th>
                                                <th colspan="2"><input type="number" class="form-control form-control-sm" id="totalCharges" readonly value="0.000"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="card-footer border-top bg-white p-2 text-end">
                                    <button type="button" class="btn btn-sm btn-success" id="btnSubmitCharges">Submit Charges</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-primary" id="saveRefundBtn">Save Refund</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header card-headernew d-flex justify-content-between align-items-center py-2">
                    <h5 class="card-title mb-0">Refund List</h5>
                    <div class="d-flex align-items-center">
                        <label class="form-label me-2 mb-0" for="filter_company_id">Company</label>
                        <select class="form-select form-select-sm" id="filter_company_id" name="filter_company_id" style="width: auto;">
                            <option value="All" selected>All</option>
                            <?php foreach ($companies as $c): ?>
                                <option value="<?php echo htmlspecialchars($c['company_code']); ?>" data-id="<?php echo $c['ids']; ?>">
                                    <?php echo htmlspecialchars($c['company_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm" id="refundTable">
                        <thead>
                            <tr>
                                <th>Refund No</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Agreement No</th>
                                <th class="text-end">Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="refundTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
