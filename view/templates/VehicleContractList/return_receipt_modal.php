<div class="modal fade" id="returnReceiptVoucherModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header" style="background: linear-gradient(135deg, #1b3d94, #153075);">
        <div class="d-flex align-items-center flex-wrap gap-2">
          <h5 class="modal-title text-white fw-bold mb-0"><i class="ri-receipt-line me-1"></i> RECEIPT VOUCHER</h5>
          <span class="badge bg-white text-primary fw-bold" id="rr_agreement_label">-</span>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="rr_contract_id">
        <input type="hidden" id="rr_agreement_no">
        <input type="hidden" id="rr_customer_code">
        <input type="hidden" id="rr_customer_phone">
        <input type="hidden" id="rr_customer_email">
        <input type="hidden" id="rr_customer_cpr">
        <input type="hidden" id="rr_customer_address">
        <input type="hidden" id="rr_company_id">
        <input type="hidden" id="rr_vehicle_id">
        <input type="hidden" id="rr_model_id">
        <input type="hidden" id="rr_booking_ids">
        <input type="hidden" id="rr_vehicle_no">
        <input type="hidden" id="rr_vehicle_color">
        <input type="hidden" id="rr_generated_receipt_no">

        <div id="rr_success_banner" class="alert alert-success d-none align-items-center justify-content-between flex-wrap gap-2 mb-3">
          <div>
            <i class="ri-checkbox-circle-fill me-1"></i>
            <strong>Receipt Generated:</strong> <span id="rr_generated_no_badge" class="badge bg-success ms-1"></span>
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-primary" id="rr_banner_print_btn">
              <i class="ri-printer-line me-1"></i> Print / Export PDF
            </button>
            <button type="button" class="btn btn-sm btn-success" id="rr_banner_wa_btn">
              <i class="ri-whatsapp-line me-1"></i> Send to WhatsApp
            </button>
          </div>
        </div>

        <!-- Receipt Voucher Form -->
        <div class="p-3 rounded border mb-3" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
          <div class="row g-2">
            <div class="col-md-4">
              <label class="form-label form-label-sm mb-1 fw-semibold">Agreement No.</label>
              <input type="text" id="rr_agreement_no_display" class="form-control form-control-sm bg-white fw-bold text-primary" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label form-label-sm mb-1 fw-semibold">Customer Name</label>
              <input type="text" id="rr_customer_name" class="form-control form-control-sm bg-white" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label form-label-sm mb-1 fw-semibold">Car Type / Plate No.</label>
              <input type="text" id="rr_car_type" class="form-control form-control-sm bg-white" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label form-label-sm mb-1 fw-semibold">Receipt No.</label>
              <input type="text" id="rr_receipt_no" class="form-control form-control-sm bg-white fw-bold text-primary" value="Auto (Sequential)" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label form-label-sm mb-1 fw-semibold">Receipt Date</label>
              <input type="date" id="rr_receipt_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label form-label-sm mb-1 fw-semibold">Payment Type</label>
              <select id="rr_payment_type" class="form-select form-select-sm">
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
              <select id="rr_payment_mode" class="form-select form-select-sm">
                <option value="Cash" selected>CASH</option>
                <option value="Card">CARD</option>
                <option value="Bank Transfer">BANK TRANSFER</option>
                <option value="Benefit Pay">BENEFIT PAY</option>
                <option value="Cheque">CHEQUE</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label form-label-sm mb-1 fw-semibold">Paid (Advance)</label>
              <input type="text" id="rr_advance" class="form-control form-control-sm bg-white fw-semibold text-success" readonly>
            </div>
            <div class="col-md-3">
              <label class="form-label form-label-sm mb-1 fw-semibold">Balance Due</label>
              <input type="text" id="rr_balance" class="form-control form-control-sm bg-white fw-bold text-danger" readonly>
            </div>

            <div class="col-md-3">
              <label class="form-label form-label-sm mb-1 fw-semibold">Amount <span class="text-danger">*</span></label>
              <input type="number" step="0.001" min="0" id="rr_amount" class="form-control form-control-sm fw-bold" style="background-color: #e6f2ff; border-color: #60a5fa;">
            </div>
            <div class="col-md-3">
              <label class="form-label form-label-sm mb-1 fw-semibold">Tax Amount (Incl./Extra)</label>
              <input type="number" step="0.001" min="0" id="rr_tax_amount" class="form-control form-control-sm fw-bold" value="0.000" style="background-color: #e6f9ed; border-color: #4ade80;">
            </div>
            <div class="col-md-6">
              <label class="form-label form-label-sm mb-1 fw-semibold">Note / Remarks</label>
              <input type="text" id="rr_note" class="form-control form-control-sm" placeholder="Receipt remarks...">
            </div>

            <div class="col-md-4 rr-cheque-field d-none">
              <label class="form-label form-label-sm mb-1 fw-semibold">Cheque No.</label>
              <input type="text" id="rr_cheque_no" class="form-control form-control-sm" placeholder="Cheque No.">
            </div>
            <div class="col-md-4 rr-cheque-field d-none">
              <label class="form-label form-label-sm mb-1 fw-semibold">Cheque Date</label>
              <input type="date" id="rr_cheque_date" class="form-control form-control-sm">
            </div>
            <div class="col-md-4 rr-cheque-field d-none">
              <label class="form-label form-label-sm mb-1 fw-semibold">Cheque Bank</label>
              <input type="text" id="rr_cheque_bank" class="form-control form-control-sm" placeholder="Bank Name">
            </div>
          </div>
        </div>

        <!-- Contract Ledger Details List -->
        <div class="p-3 rounded border bg-white">
          <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
            <span class="fw-semibold" style="color: #1b3d94;"><i class="ri-book-open-line me-1"></i> Contract Ledger Details</span>
            <div class="small">
              Total Charges: <strong id="rr_led_total_debit">0.000</strong> |
              Paid: <strong class="text-success" id="rr_led_total_credit">0.000</strong> |
              Balance: <strong class="text-danger" id="rr_led_balance">0.000</strong>
            </div>
          </div>
          <div class="table-responsive" style="max-height: 220px; overflow-y: auto;">
            <table class="table table-sm table-bordered table-hover align-middle mb-0" style="font-size: 12px;">
              <thead class="table-light sticky-top">
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Description</th>
                  <th class="text-end">Debit</th>
                  <th class="text-end">Credit</th>
                  <th class="text-end">Balance</th>
                  <th class="text-center">Print</th>
                </tr>
              </thead>
              <tbody id="rr_ledger_tbody">
                <tr><td colspan="8" class="text-center text-muted py-2">Loading ledger...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-primary btn-sm d-none" id="rr_btn_print">
            <i class="ri-printer-line me-1"></i> Print / Export PDF
          </button>
          <button type="button" class="btn btn-outline-success btn-sm d-none" id="rr_btn_whatsapp">
            <i class="ri-whatsapp-line me-1"></i> Send to WhatsApp
          </button>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="rr_btn_generate">
            <i class="ri-check-double-line me-1"></i> Generate Receipt
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
