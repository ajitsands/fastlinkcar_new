<div class="modal fade" id="contractLedgerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content border-0 shadow-lg">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div class="d-flex align-items-center flex-wrap gap-2">
          <h5 class="mb-0 text-white fw-bold">
            <i class="ri-book-2-line me-1"></i> Contract Ledger &mdash; Violations &amp; Other Fees
          </h5>
          <span class="badge bg-white text-primary fw-bold" id="ledger_agreement_ref">-</span>
        </div>
        <div class="d-flex align-items-center gap-2 ms-auto me-2">
          <button type="button" class="btn btn-light btn-sm fw-semibold text-primary" id="btnLedgerGenerateReceipt">
            <i class="ri-receipt-line me-1"></i> Generate Receipt
          </button>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <input type="hidden" value="" id="txt_ledger_modal_agreement_id">
        <input type="hidden" value="" id="txt_ledger_modal_agreement_no">
        <input type="hidden" value="" id="txt_ledger_modal_booking_ids">
        <input type="hidden" value="" id="txt_ledger_modal_quotation_number">
        <input type="hidden" value="" id="txt_ledger_modal_booking_ref">
        <input type="hidden" value="" id="txt_ledger_modal_vehicle_ids">
        <input type="hidden" value="" id="txt_ledger_modal_model_ids">
        <input type="hidden" value="" id="txt_ledger_modal_customer_code">
      </div>

      <div class="modal-body">
        <!-- Contract & Customer Summary Strip -->
        <div class="row g-2 p-3 mb-3 rounded border bg-light align-items-center small">
          <div class="col-md-4">
            <span class="text-muted">Customer:</span>
            <strong class="ms-1" id="display_customer_name">-</strong>
          </div>
          <div class="col-md-2">
            <span class="text-muted">Mobile:</span>
            <strong class="ms-1" id="display_mobile">-</strong>
          </div>
          <div class="col-md-3">
            <span class="text-muted">Booking Ref:</span>
            <strong class="ms-1" id="display_booking_ref">-</strong>
          </div>
          <div class="col-md-3">
            <span class="text-muted">Quotation No:</span>
            <strong class="ms-1" id="display_quotation_no">-</strong>
          </div>
        </div>

        <!-- Totals Strip -->
        <div class="row mb-3 g-3">
          <div class="col-md-4">
            <div class="card summary-card card-total-debit shadow-sm">
              <div class="card-body py-2 px-3">
                <span class="text-muted small">Total Debit (Charged)</span>
                <h4 class="mb-0 fw-bold text-danger" id="lblTotalDebit">0.000</h4>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card summary-card card-total-credit shadow-sm">
              <div class="card-body py-2 px-3">
                <span class="text-muted small">Total Credit (Received)</span>
                <h4 class="mb-0 fw-bold text-success" id="lblTotalCredit">0.000</h4>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card summary-card card-balance shadow-sm">
              <div class="card-body py-2 px-3">
                <span class="text-muted small">Current Balance</span>
                <h4 class="mb-0 fw-bold text-primary" id="lblBalance">0.000</h4>
              </div>
            </div>
          </div>
        </div>

        <!-- Vehicle Violations (Same as Return Modal) -->
        <div class="card shadow-sm border mb-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
              <div class="d-flex align-items-center gap-3 flex-wrap">
                <h5 class="mb-0 fw-bold text-danger">Vehicle Violations</h5>
                <a href="https://services.bahrain.bh" target="_blank" rel="noopener noreferrer" class="text-primary fw-semibold small text-decoration-underline d-inline-flex align-items-center gap-1">
                  Check Traffic Violations on services.bahrain.bh <i class="ri ri-external-link-line"></i>
                </a>
              </div>
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" id="cl_btn_add_violation_head_master">
                  <i class="ri-add-line me-1"></i> Add Master
                </button>
                <button type="button" class="btn btn-sm btn-primary" id="cl_btn_add_violation_row">
                  <i class="ri-add-line me-1"></i> Add Violation
                </button>
              </div>
            </div>

            <datalist id="cl_violation_heads_list"></datalist>

            <div class="table-responsive">
              <table class="table table-bordered align-middle table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th width="5%">#</th>
                    <th width="18%">Violation Date</th>
                    <th width="30%">Violation Title</th>
                    <th width="15%">Fees</th>
                    <th width="24%">Remarks</th>
                    <th width="8%" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody id="cl_violations_tbody"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Other Fees Entries (Same as Return Modal) -->
        <div class="card shadow-sm border mb-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h5 class="mb-0 fw-bold" style="color: #1b3d94;">Other Fees Entries</h5>
              <button type="button" class="btn btn-sm btn-primary" id="cl_add_other_fee_row">
                <i class="ri-add-line me-1"></i> Add New
              </button>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered align-middle table-sm mb-0">
                <thead class="table-light">
                  <tr>
                    <th width="5%">#</th>
                    <th width="30%">Fee Item</th>
                    <th width="15%">Price</th>
                    <th width="15%">Actual Amount</th>
                    <th width="27%">Remarks</th>
                    <th width="8%" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody id="cl_other_fee_tbody"></tbody>
              </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
              <button type="button" class="btn btn-success" id="btnPostLedgerCharges">
                <i class="ri-check-double-line me-1"></i> Post Violations &amp; Other Fees to Ledger
              </button>
            </div>
          </div>
        </div>

        <!-- Posted Ledger Statement -->
        <div class="card shadow-sm border">
          <div class="card-header py-2 d-flex justify-content-between align-items-center bg-light">
            <h6 class="mb-0 fw-bold" style="color: #1b3d94;">
              <i class="ri-list-check-2 me-1"></i> Posted Ledger Statement
            </h6>
            <button type="button" class="btn btn-outline-primary btn-sm" id="btnLedgerGenerateReceipt2">
              <i class="ri-receipt-line me-1"></i> Generate Receipt
            </button>
          </div>
          <div class="card-body p-2">
            <div class="table-responsive">
              <table id="tblLedger" class="table table-hover table-sm align-middle mb-0 w-100">
                <thead class="table-light">
                  <tr>
                    <th>Date</th>
                    <th>Type / Method</th>
                    <th>Ref / Description</th>
                    <th class="text-end">Debit</th>
                    <th class="text-end">Credit</th>
                    <th class="text-end">Balance</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- FOOTER -->
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary" id="btnLedgerGenerateReceiptFooter">
          <i class="ri-receipt-line me-1"></i> Generate Receipt
        </button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Add New Violation Head Master -->
<div class="modal fade" id="clModalAddViolationHead" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header custom-modal-header py-2">
        <h6 class="modal-title text-white mb-0">Add Violation Head</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" id="cl_new_violation_head_name" placeholder="Enter Violation Head Name">
          <label for="cl_new_violation_head_name">Violation Head Name</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-sm btn-primary" id="cl_btn_save_violation_head">Save Head</button>
      </div>
    </div>
  </div>
</div>
