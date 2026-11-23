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

      <div class="modal-body p-3">
        <!-- SECTION 1: DASHBOARD -->
        <div class="card border shadow-none bg-light mb-2">
          <div class="card-body py-2 px-3">
            <div class="row g-2 align-items-center small">
              <div class="col-sm-6 col-lg-4">
                <span class="text-muted">Customer:</span>
                <strong class="ms-1 text-dark" id="display_customer_name">-</strong>
              </div>
              <div class="col-sm-6 col-lg-2">
                <span class="text-muted">Mobile:</span>
                <strong class="ms-1 text-dark" id="display_mobile">-</strong>
              </div>
              <div class="col-sm-6 col-lg-3">
                <span class="text-muted">Booking Ref:</span>
                <strong class="ms-1 text-dark" id="display_booking_ref">-</strong>
              </div>
              <div class="col-sm-6 col-lg-3">
                <span class="text-muted">Quotation No:</span>
                <strong class="ms-1 text-dark" id="display_quotation_no">-</strong>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-3 g-3">
          <div class="col-md-4">
            <div class="card summary-card card-total-debit shadow-sm h-100">
              <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                <div>
                  <span class="text-muted small d-block">Total Debit (Charged)</span>
                  <h4 class="mb-0 fw-bold text-danger" id="lblTotalDebit">0.000</h4>
                </div>
                <i class="ri-arrow-up-circle-line ri-24px text-danger opacity-50"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card summary-card card-total-credit shadow-sm h-100">
              <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                <div>
                  <span class="text-muted small d-block">Total Credit (Received)</span>
                  <h4 class="mb-0 fw-bold text-success" id="lblTotalCredit">0.000</h4>
                </div>
                <i class="ri-arrow-down-circle-line ri-24px text-success opacity-50"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card summary-card card-balance shadow-sm h-100">
              <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                <div>
                  <span class="text-muted small d-block">Current Balance</span>
                  <h4 class="mb-0 fw-bold text-primary" id="lblBalance">0.000</h4>
                </div>
                <i class="ri-scales-3-line ri-24px text-primary opacity-50"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- SECTION 2: TWO TABS (PAYMENTS & RECEIPTS) -->
        <div class="card shadow-sm border mb-3">
          <div class="card-header bg-white pb-0 pt-2 px-3 border-bottom">
            <ul class="nav nav-tabs card-header-tabs" id="clSectionTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="cl-tab-payments-btn" data-bs-toggle="tab" data-bs-target="#clTabPayments" type="button" role="tab" aria-controls="clTabPayments" aria-selected="true">
                  <i class="ri-money-dollar-circle-line me-1"></i> Payments (Violations &amp; Other Fees)
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="cl-tab-receipts-btn" data-bs-toggle="tab" data-bs-target="#clTabReceipts" type="button" role="tab" aria-controls="clTabReceipts" aria-selected="false">
                  <i class="ri-receipt-line me-1"></i> Receipts
                </button>
              </li>
            </ul>
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

              <!-- TAB 2: RECEIPTS -->
              <div class="tab-pane fade" id="clTabReceipts" role="tabpanel" aria-labelledby="cl-tab-receipts-btn">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 p-2 rounded border bg-light">
                  <div class="small">
                    <span class="text-muted">Total Received:</span>
                    <strong class="text-success ms-1 me-3" id="clTabTotalReceived">0.000 BHD</strong>
                    <span class="text-muted">Balance Due:</span>
                    <strong class="text-danger ms-1" id="clTabBalanceDue">0.000 BHD</strong>
                  </div>
                  <button type="button" class="btn btn-primary btn-sm" id="btnLedgerTabGenerateReceipt">
                    <i class="ri-receipt-line me-1"></i> Generate New Receipt
                  </button>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm align-middle mb-0">
                    <thead class="table-light">
                      <tr>
                        <th style="width:110px;">Date</th>
                        <th style="width:180px;">Receipt / Ref No</th>
                        <th style="width:130px;">Method</th>
                        <th>Description</th>
                        <th style="width:130px;" class="text-end">Amount (BHD)</th>
                        <th style="width:90px;" class="text-center">Print</th>
                      </tr>
                    </thead>
                    <tbody id="cl_receipts_tbody">
                      <tr><td colspan="6" class="text-center text-muted py-3">No receipts recorded yet.</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SECTION 3 (COMMON): CONTRACT LEDGER POSTINGS -->
        <div class="card shadow-sm border mb-0">
          <div class="card-header py-2 px-3 bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold" style="color: #1b3d94;">
              <i class="ri-list-check-2 me-1"></i> Contract Ledger Postings
            </h6>
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
      <div class="modal-footer justify-content-between py-2 px-3 bg-light">
        <button type="button" class="btn btn-primary btn-sm" id="btnLedgerGenerateReceiptFooter">
          <i class="ri-receipt-line me-1"></i> Generate Receipt
        </button>
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
