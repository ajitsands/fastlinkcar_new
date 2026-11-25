<style>
  #clSectionTabs {
    gap: 0.5rem;
  }
  #clSectionTabs .nav-link {
    border: 1px solid #cbd5e1;
    background-color: #ffffff;
    color: #334155;
    border-radius: 0.5rem;
    padding: 0.55rem 1.25rem;
    font-size: 1.05rem;
    font-weight: 700;
    transition: all 0.15s ease;
  }
  #clSectionTabs .nav-link:hover:not(.active) {
    background-color: #eef3fc;
    border-color: #1b3d94;
    color: #1b3d94;
  }
  #clSectionTabs .nav-link.active {
    background-color: #1b3d94 !important;
    border-color: #1b3d94 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 10px rgba(27, 61, 148, 0.25);
  }
</style>

<div class="modal fade" id="contractLedgerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content border-0 shadow-lg">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header py-3">
        <div class="d-flex align-items-center flex-wrap gap-2">
          <h5 class="mb-0 text-white fw-bold">
            <i class="ri-book-2-line me-1"></i> Contract Ledger
          </h5>
          <span class="badge bg-white text-primary fw-bold px-2 py-1" id="ledger_agreement_ref">-</span>
        </div>
        <div class="d-flex align-items-center gap-2 ms-auto">
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

      <div class="modal-body p-3">
        <!-- TWO TABS (PAYMENTS & RECEIPTS) -->
        <div class="card shadow-sm border mb-3">
          <div class="card-header bg-light py-2 px-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
            <ul class="nav nav-pills" id="clSectionTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="cl-tab-payments-btn" data-bs-toggle="tab" data-bs-target="#clTabPayments" type="button" role="tab" aria-controls="clTabPayments" aria-selected="true">
                  <i class="ri-money-dollar-circle-line me-1"></i> Payments (Violations &amp; Other Fees)
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="cl-tab-receipts-btn" data-bs-toggle="tab" data-bs-target="#clTabReceipts" type="button" role="tab" aria-controls="clTabReceipts" aria-selected="false">
                  <i class="ri-receipt-line me-1"></i> Receipts (Generate Receipt)
                </button>
              </li>
            </ul>
            <span class="text-muted small fw-medium">Switch tabs to post charges or generate a receipt</span>
          </div>

          <div class="card-body p-3">
            <div class="tab-content p-0">
              <!-- TAB 1: PAYMENTS (VIOLATIONS & OTHER FEES) -->
              <div class="tab-pane fade show active" id="clTabPayments" role="tabpanel" aria-labelledby="cl-tab-payments-btn">
                <!-- Vehicle Violations -->
                <div class="border rounded p-3 mb-3 bg-white">
                  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                      <h6 class="mb-0 fw-bold text-danger">
                        <i class="ri-alarm-warning-line me-1"></i> Vehicle Violations
                      </h6>
                      <a href="https://services.bahrain.bh" target="_blank" rel="noopener noreferrer" class="text-primary fw-medium small text-decoration-underline d-inline-flex align-items-center gap-1">
                        Check on services.bahrain.bh <i class="ri-external-link-line"></i>
                      </a>
                    </div>
                    <div class="d-flex gap-2">
                      <button type="button" class="btn btn-sm btn-outline-primary" id="cl_btn_add_violation_head_master">
                        <i class="ri-add-line me-1"></i> Add Violation Head
                      </button>
                      <button type="button" class="btn btn-sm btn-primary" id="cl_btn_add_violation_row">
                        <i class="ri-add-line me-1"></i> Add Row
                      </button>
                    </div>
                  </div>
                  <datalist id="cl_violation_heads_list"></datalist>
                  <div class="table-responsive">
                    <table class="table table-bordered align-middle table-sm mb-0">
                      <thead class="table-light">
                        <tr>
                          <th style="width:45px;" class="text-center">#</th>
                          <th style="width:150px;">Violation Date</th>
                          <th style="min-width:220px;">Violation Title</th>
                          <th style="width:140px;" class="text-end">Fee (BHD)</th>
                          <th style="min-width:200px;">Remarks</th>
                          <th style="width:65px;" class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody id="cl_violations_tbody"></tbody>
                    </table>
                  </div>
                </div>

                <!-- Other Fees Entries -->
                <div class="border rounded p-3 bg-white">
                  <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                    <div>
                      <h6 class="mb-0 fw-bold" style="color: #1b3d94;">
                        <i class="ri-price-tag-3-line me-1"></i> Other Fees Entries
                      </h6>
                      <small class="text-muted">Select from Ledger/Pricing Master or type a custom fee. <strong>Charged Amount</strong> is posted to the ledger.</small>
                    </div>
                    <div class="d-flex gap-2">
                      <button type="button" class="btn btn-sm btn-outline-primary" id="cl_btn_add_other_fee_head">
                        <i class="ri-add-line me-1"></i> Add Fee Head
                      </button>
                      <button type="button" class="btn btn-sm btn-primary" id="cl_add_other_fee_row">
                        <i class="ri-add-line me-1"></i> Add Row
                      </button>
                    </div>
                  </div>
                  <datalist id="cl_other_fee_heads_list"></datalist>
                  <div class="table-responsive">
                    <table class="table table-bordered align-middle table-sm mb-0">
                      <thead class="table-light">
                        <tr>
                          <th style="width:45px;" class="text-center">#</th>
                          <th style="min-width:220px;">Fee Item (Master / Custom)</th>
                          <th style="width:140px;" class="text-end">Standard Price</th>
                          <th style="width:150px;" class="text-end">Charged Amount</th>
                          <th style="min-width:200px;">Remarks</th>
                          <th style="width:65px;" class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody id="cl_other_fee_tbody"></tbody>
                    </table>
                  </div>

                  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3 pt-2 border-top">
                    <div class="small text-muted">
                      Pending Violations: <strong class="text-danger" id="clPendingViolationsTotal">0.000</strong> BHD
                      &nbsp;&bull;&nbsp;
                      Pending Other Fees: <strong class="text-primary" id="clPendingFeesTotal">0.000</strong> BHD
                      &nbsp;&bull;&nbsp;
                      Total to Post: <strong class="text-dark" id="clPendingGrandTotal">0.000</strong> BHD
                    </div>
                    <button type="button" class="btn btn-success btn-sm px-3" id="btnPostLedgerCharges">
                      <i class="ri-check-double-line me-1"></i> Post Violations &amp; Other Fees to Ledger
                    </button>
                  </div>
                </div>
              </div>

              <!-- TAB 2: RECEIPTS (INLINE GENERATE RECEIPT FORM) -->
              <div class="tab-pane fade" id="clTabReceipts" role="tabpanel" aria-labelledby="cl-tab-receipts-btn">
                <input type="hidden" id="cl_rr_customer_phone">
                <input type="hidden" id="cl_rr_customer_email">
                <input type="hidden" id="cl_rr_customer_cpr">
                <input type="hidden" id="cl_rr_customer_address">
                <input type="hidden" id="cl_rr_company_id">
                <input type="hidden" id="cl_rr_car_type">
                <input type="hidden" id="cl_rr_vehicle_no">
                <input type="hidden" id="cl_rr_vehicle_color">
                <input type="hidden" id="cl_rr_customer_name">
                <input type="hidden" id="cl_rr_generated_receipt_no">

                <div id="cl_rr_success_banner" class="alert alert-success d-none align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  <div>
                    <i class="ri-checkbox-circle-fill me-1"></i>
                    <strong>Receipt Generated:</strong> <span id="cl_rr_generated_no_badge" class="badge bg-success ms-1"></span>
                  </div>
                  <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-primary" id="cl_rr_banner_print_btn">
                      <i class="ri-printer-line me-1"></i> Print / Export PDF
                    </button>
                    <button type="button" class="btn btn-sm btn-success" id="cl_rr_banner_wa_btn">
                      <i class="ri-whatsapp-line me-1"></i> Send to WhatsApp
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="cl_rr_new_btn">
                      <i class="ri-add-line me-1"></i> New Receipt
                    </button>
                  </div>
                </div>

                <div class="p-3 rounded border mb-2" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                  <div class="row g-2">
                    <div class="col-md-6">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Receipt No.</label>
                      <input type="text" id="cl_rr_receipt_no" class="form-control form-control-sm bg-white fw-bold text-primary" value="Auto (Sequential)" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Receipt Date</label>
                      <input type="date" id="cl_rr_receipt_date" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="col-md-3">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Payment Type</label>
                      <select id="cl_rr_payment_type" class="form-select form-select-sm">
                        <option value="RENT">RENT</option>
                        <option value="FULL SETTLEMENT" selected>FULL SETTLEMENT</option>
                        <option value="OVERDUE CHARGES">OVERDUE CHARGES</option>
                        <option value="VIOLATION / FINE">VIOLATION / FINE</option>
                        <option value="OTHER FEES">OTHER FEES</option>
                        <option value="ADVANCE / DEPOSIT">ADVANCE / DEPOSIT</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Payment Mode</label>
                      <select id="cl_rr_payment_mode" class="form-select form-select-sm">
                        <option value="Cash" selected>CASH</option>
                        <option value="Card">CARD</option>
                        <option value="Bank Transfer">BANK TRANSFER</option>
                        <option value="Benefit Pay">BENEFIT PAY</option>
                        <option value="Cheque">CHEQUE</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Paid (Advance)</label>
                      <input type="text" id="cl_rr_advance" class="form-control form-control-sm bg-white fw-semibold text-success text-end" readonly>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Balance Due</label>
                      <input type="text" id="cl_rr_balance" class="form-control form-control-sm bg-white fw-bold text-danger text-end" readonly>
                    </div>

                    <div class="col-md-3">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Amount <span class="text-danger">*</span></label>
                      <input type="number" step="0.001" min="0" id="cl_rr_amount" class="form-control form-control-sm fw-bold text-end" style="background-color: #e6f2ff; border-color: #60a5fa;">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Tax Amount (Incl./Extra)</label>
                      <input type="number" step="0.001" min="0" id="cl_rr_tax_amount" class="form-control form-control-sm fw-bold text-end" value="0.000" style="background-color: #e6f9ed; border-color: #4ade80;">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Note / Remarks</label>
                      <input type="text" id="cl_rr_note" class="form-control form-control-sm" placeholder="Receipt remarks...">
                    </div>

                    <div class="col-md-4 cl-rr-cheque-field d-none">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Cheque No.</label>
                      <input type="text" id="cl_rr_cheque_no" class="form-control form-control-sm" placeholder="Cheque No.">
                    </div>
                    <div class="col-md-4 cl-rr-cheque-field d-none">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Cheque Date</label>
                      <input type="date" id="cl_rr_cheque_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4 cl-rr-cheque-field d-none">
                      <label class="form-label form-label-sm mb-1 fw-semibold">Cheque Bank</label>
                      <input type="text" id="cl_rr_cheque_bank" class="form-control form-control-sm" placeholder="Bank Name">
                    </div>
                  </div>

                  <div class="d-flex justify-content-end gap-2 mt-3 pt-2 border-top">
                    <button type="button" class="btn btn-primary btn-sm px-3" id="cl_rr_btn_generate">
                      <i class="ri-check-double-line me-1"></i> Generate Receipt
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SECTION 3 (COMMON): CONTRACT LEDGER POSTINGS -->
        <div class="card shadow-sm border mb-0">
          <div class="card-header py-2 px-3 bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold fs-5" style="color: #1b3d94;">
              <i class="ri-list-check-2 me-1"></i> Contract Ledger Postings
            </h5>
            <span class="text-muted small">All posted debits &amp; receipt credits for this contract</span>
          </div>
          <div class="card-body p-3">
            <div class="table-responsive">
              <table id="tblLedger" class="table table-hover table-sm align-middle mb-0 w-100">
                <thead class="table-light">
                  <tr>
                    <th style="width:105px;">Date</th>
                    <th style="width:190px;">Type / Method</th>
                    <th>Ref / Description</th>
                    <th style="width:110px;" class="text-end">Debit</th>
                    <th style="width:110px;" class="text-end">Credit</th>
                    <th style="width:115px;" class="text-end">Balance</th>
                    <th style="width:65px;" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- FOOTER -->
      <div class="modal-footer justify-content-end py-2 px-3 bg-light">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Add / Manage Violation Heads Master -->
<div class="modal fade" id="clModalAddViolationHead" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header custom-modal-header py-2">
        <h6 class="modal-title text-white mb-0">
          <i class="ri-alarm-warning-line me-1"></i> Violation Heads Master
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3">
        <input type="hidden" id="cl_edit_violation_head_id" value="0">
        <div class="row g-2 align-items-end mb-3 p-2 rounded border bg-light">
          <div class="col-md-9">
            <label class="form-label small fw-semibold mb-1" for="cl_new_violation_head_name">Violation Head Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" id="cl_new_violation_head_name" placeholder="Enter Violation Head Name (e.g. Speeding, Red Light, Parking)">
          </div>
          <div class="col-md-3 d-flex gap-1">
            <button type="button" class="btn btn-sm btn-primary flex-grow-1" id="cl_btn_save_violation_head">
              <i class="ri-save-line me-1"></i> Save
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="cl_btn_cancel_edit_violation_head">
              Clear
            </button>
          </div>
        </div>

        <h6 class="fw-bold small text-uppercase text-muted mb-2">Existing Violation Heads</h6>
        <div class="table-responsive" style="max-height: 320px;">
          <table class="table table-bordered table-hover table-sm align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width:45px;" class="text-center">#</th>
                <th>Violation Head Name</th>
                <th style="width:120px;" class="text-center">Transactions</th>
                <th style="width:95px;" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody id="cl_violation_master_tbody">
              <tr><td colspan="4" class="text-center text-muted py-3">Loading...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Add / Manage Other Fee Heads Master -->
<div class="modal fade" id="clModalAddFeeHead" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header custom-modal-header py-2">
        <h6 class="modal-title text-white mb-0">
          <i class="ri-price-tag-3-line me-1"></i> Other Fee Heads Master &amp; Standard Pricing
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3">
        <input type="hidden" id="cl_edit_fee_head_id" value="0">
        <div class="row g-2 align-items-end mb-3 p-2 rounded border bg-light">
          <div class="col-md-5">
            <label class="form-label small fw-semibold mb-1" for="cl_new_fee_head_name">Fee Head Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" id="cl_new_fee_head_name" placeholder="e.g. Salik, Fuel, Cleaning, Key Loss">
          </div>
          <div class="col-md-4">
            <label class="form-label small fw-semibold mb-1" for="cl_new_fee_head_price">Standard Price (BHD)</label>
            <input type="text" inputmode="decimal" class="form-control form-control-sm text-end" id="cl_new_fee_head_price" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0.000">
          </div>
          <div class="col-md-3 d-flex gap-1">
            <button type="button" class="btn btn-sm btn-primary flex-grow-1" id="cl_btn_save_fee_head">
              <i class="ri-save-line me-1"></i> Save
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="cl_btn_cancel_edit_fee_head">
              Clear
            </button>
          </div>
        </div>

        <h6 class="fw-bold small text-uppercase text-muted mb-2">Existing Other Fee Heads &amp; Standard Pricing</h6>
        <div class="table-responsive" style="max-height: 320px;">
          <table class="table table-bordered table-hover table-sm align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width:45px;" class="text-center">#</th>
                <th>Fee Head Name</th>
                <th style="width:140px;" class="text-end">Standard Price</th>
                <th style="width:120px;" class="text-center">Source</th>
                <th style="width:95px;" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody id="cl_fee_master_tbody">
              <tr><td colspan="5" class="text-center text-muted py-3">Loading...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
