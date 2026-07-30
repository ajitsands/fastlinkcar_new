 <!-- Calendar Modal -->
    <div class="modal fade" id="modalChequeCalendar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cheque Collection Calendar : <span id="chequecollectioncalenderagrno"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        
                        <input type="hidden" id="chequecollectioncalenderagrid">
                        <div class="col-md-6" style="display:none">
                            <label class="form-label">Filter by Customer</label>
                            <select id="selCalendarCustomer" class="form-select select2-modal"></select>
                        </div>
                        <div class="col-md-6 d-none" id="divPendingSummary">
                            <label class="form-label">Pending Cheques Summary</label>
                            <div id="pendingBadges" class="d-flex flex-wrap gap-1"></div>
                        </div>
                    </div>
                    <div id="chequeCalendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cheque Details Modal -->
    <div class="modal fade" id="modalChequeDetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cheques for <span id="lblSelectedDate"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tblChequeDetails" class="table table-sm border-top">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Reference</th>
                                    <th class="text-end">Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Add Bank -->
    <div class="modal fade" id="modalAddBank" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmAddBank">
                        <div class="mb-3">
                            <label class="form-label">Bank Name</label>
                            <input type="text" class="form-control" id="txtNewBankName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Number (Optional)</label>
                            <input type="text" class="form-control" id="txtNewAccountNo">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Bank</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Add Head -->
    <div class="modal fade" id="modalAddHead" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Head</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmAddHead">
                        <div class="mb-3">
                            <label class="form-label">Head Name</label>
                            <input type="text" class="form-control" id="txtNewHeadName" required placeholder="e.g. Refund">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="selNewHeadType" required>
                                <option value="Credit">Credit (Money Received)</option>
                                <option value="Debit">Debit (Charge/Invoice)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Head</button>
                    </form>
                </div>
            </div>
        </div>
    </div>