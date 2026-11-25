<div class="container-fluid flex-grow-1 container-p-y">
    <form id="cashmemoForm">
        <input type="hidden" id="cashmemo_id" name="cashmemo_id">
        <input type="hidden" id="cashmemo_number" name="cashmemo_number">
        <input type="hidden" id="original_draft" name="original_draft" value="No">
        <input type="hidden" id="save_type_hidden" name="save_type_hidden" value="final">
        <input type="hidden" id="customer_code" name="customer_code">
        <input type="hidden" id="company_code" name="company_code" value="<?php echo count($companies) === 1 ? htmlspecialchars($companies[0]['company_code']) : ''; ?>">
        <input type="hidden" id="company_name" name="company_name" value="<?php echo count($companies) === 1 ? htmlspecialchars($companies[0]['company_name']) : ''; ?>">
        <input type="hidden" id="cashmemo_hidvehicle_id" name="cashmemo_hidvehicle_id">
        <input type="hidden" id="cashmemo_hidbooking_ids" name="cashmemo_hidbooking_ids">
        <input type="hidden" id="cashmemo_hidvehicle_model_id" name="cashmemo_hidvehicle_model_id">
        <input type="hidden" id="cm_generated_receipt_no">

        <div class="card shadow-sm border-0">
            <div class="card-header border-bottom py-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0 fw-bold" style="color: #1b3d94;">
                        <i class="ri-receipt-line me-1"></i> Cash Memo / Receipt
                    </h5>
                    <span class="badge bg-label-primary" id="cashmemoNumber"></span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-warning" id="opencashmemo">
                        <i class="ri-list-check-2 me-1"></i> Receipt List
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnNewReceiptTop">
                        <i class="ri-add-line me-1"></i> New Receipt
                    </button>
                </div>
            </div>

            <div class="card-body p-3">
                <!-- Success / Print Banner -->
                <div id="cm_success_banner" class="alert alert-success d-none align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <div>
                        <i class="ri-checkbox-circle-fill me-1"></i>
                        <strong>Receipt Saved:</strong> <span id="cm_generated_no_badge" class="badge bg-success ms-1"></span>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-primary" id="cm_banner_print_btn">
                            <i class="ri-printer-line me-1"></i> Print / Export PDF
                        </button>
                        <button type="button" class="btn btn-sm btn-success" id="cm_banner_wa_btn">
                            <i class="ri-whatsapp-line me-1"></i> Send to WhatsApp
                        </button>
                    </div>
                </div>

                <!-- Customer & Agreement Selection -->
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label form-label-sm fw-semibold mb-1" for="company_id">Company <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" id="company_id" name="company_id" required>
                            <?php if (count($companies) !== 1): ?>
                                <option value="">Select Company</option>
                            <?php endif; ?>
                            <?php foreach ($companies as $c): ?>
                                <option value="<?php echo htmlspecialchars($c['ids']); ?>" data-code="<?php echo htmlspecialchars($c['company_code']); ?>" data-name="<?php echo htmlspecialchars($c['company_name']); ?>"
                                    <?php echo count($companies) === 1 ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['company_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label form-label-sm fw-semibold mb-1">Search Customer (Name / Mobile / CPR) <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-2">
                            <div class="flex-grow-1">
                                <select id="selectCustomerFromSelect2" name="customer_name" class="select2 form-select form-select-sm" data-allow-clear="true" style="width:100%"></select>
                            </div>
                            <a href="javascript:void(0)" class="text-danger viewCustomerLedgerBtn" title="View Customer Ledger">
                                <i class="ri-book-2-line fs-5"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label form-label-sm fw-semibold mb-1" for="cashmemo_selagreement">Select Agreement <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-2">
                            <div class="flex-grow-1">
                                <select id="cashmemo_selagreement" name="cashmemo_selagreement" class="form-select form-select-sm select2" style="width:100%">
                                    <option value="">Select Agreement</option>
                                </select>
                            </div>
                            <a href="javascript:void(0)" class="text-danger viewContractLedgerBtn" title="View Contract Ledger">
                                <i class="ri-book-2-line fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Customer & Vehicle Details Strip -->
                <div class="row g-2 mb-3 p-2 rounded border bg-light-subtle">
                    <div class="col-md-2">
                        <label class="form-label form-label-sm mb-1 text-muted">Telephone</label>
                        <input class="form-control form-control-sm" id="customer_phone" name="customer_phone" type="text" placeholder="Telephone">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm mb-1 text-muted">CPR / CR</label>
                        <input class="form-control form-control-sm" id="customer_cpr_cr" name="customer_cpr_cr" type="text" placeholder="CPR/CR">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm mb-1 text-muted">Email</label>
                        <input class="form-control form-control-sm" id="customer_email" name="customer_email" type="email" placeholder="Email">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm mb-1 text-muted">Vehicle No</label>
                        <input class="form-control form-control-sm" id="cashmemo_car_no" name="cashmemo_car_no" type="text" placeholder="Vehicle No">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm mb-1 text-muted">Type of Car</label>
                        <input class="form-control form-control-sm" id="cashmemo_car_type" name="cashmemo_car_type" type="text" placeholder="Car Model">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm mb-1 text-muted">Color</label>
                        <input class="form-control form-control-sm" id="cashmemo_color" name="cashmemo_color" type="text" placeholder="Color">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label form-label-sm mb-1 text-muted">Address</label>
                        <input class="form-control form-control-sm" id="customer_address" name="customer_address" type="text" placeholder="Customer Address">
                    </div>
                </div>

                <!-- Receipt Collection Form (Matching Contract List Receipt Tab) -->
                <div class="p-3 rounded border mb-2" style="background-color: #f4f7ff; border-color: #cfe0ff !important;">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label form-label-sm mb-1 fw-semibold">Receipt No.</label>
                            <input type="text" id="cm_receipt_no_display" class="form-control form-control-sm bg-white fw-bold text-primary" value="Auto (Sequential)" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label form-label-sm mb-1 fw-semibold" for="cashmemo_date">Receipt Date <span class="text-danger">*</span></label>
                            <input type="date" id="cashmemo_date" name="cashmemo_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1 fw-semibold" for="cm_payment_type">Payment Type</label>
                            <div class="input-group input-group-sm">
                                <select id="cm_payment_type" class="form-select form-select-sm">
                                    <option value="RENT">RENT</option>
                                    <option value="FULL SETTLEMENT" selected>FULL SETTLEMENT</option>
                                    <option value="OVERDUE CHARGES">OVERDUE CHARGES</option>
                                    <option value="VIOLATION / FINE">VIOLATION / FINE</option>
                                    <option value="OTHER FEES">OTHER FEES</option>
                                    <option value="ADVANCE / DEPOSIT">ADVANCE / DEPOSIT</option>
                                </select>
                                <button type="button" class="btn btn-outline-primary" id="btnAddPaymentType" title="Add Payment Type">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1 fw-semibold" for="cash_memo_payment_method">Payment Mode</label>
                            <select id="cash_memo_payment_method" class="form-select form-select-sm">
                                <option value="Cash" selected>CASH</option>
                                <option value="Card">CARD</option>
                                <option value="Bank Transfer">BANK TRANSFER</option>
                                <option value="Benefit Pay">BENEFIT PAY</option>
                                <option value="Cheque">CHEQUE</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1 fw-semibold">Paid (Advance)</label>
                            <input type="text" id="cm_paid_advance" class="form-control form-control-sm bg-white fw-semibold text-success text-end" value="0.000" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1 fw-semibold">Balance Due</label>
                            <input type="text" id="cm_balance_due" class="form-control form-control-sm bg-white fw-bold text-danger text-end" value="0.000" readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1 fw-semibold" for="cm_amount">Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.001" min="0" id="cm_amount" class="form-control form-control-sm fw-bold text-end" value="0.000" style="background-color: #e6f2ff; border-color: #60a5fa;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1 fw-semibold" for="cm_tax_amount">Tax Amount (Incl./Extra)</label>
                            <input type="number" step="0.001" min="0" id="cm_tax_amount" class="form-control form-control-sm fw-bold text-end" value="0.000" style="background-color: #e6f9ed; border-color: #4ade80;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label form-label-sm mb-1 fw-semibold" for="cashmemo_notes">Note / Remarks</label>
                            <input type="text" id="cashmemo_notes" name="cashmemo_notes" class="form-control form-control-sm" placeholder="Receipt remarks...">
                        </div>

                        <div class="col-md-6 cm-cheque-field d-none">
                            <label class="form-label form-label-sm mb-1 fw-semibold" for="cash_memo_cheque_ref_no">Cheque / Ref No.</label>
                            <input type="text" id="cash_memo_cheque_ref_no" name="cash_memo_cheque_ref_no" class="form-control form-control-sm" placeholder="Cheque / Ref No.">
                        </div>
                        <div class="col-md-6 cm-cheque-field d-none">
                            <label class="form-label form-label-sm mb-1 fw-semibold" for="cash_memo_cheque_date">Cheque Date</label>
                            <input type="date" id="cash_memo_cheque_date" name="cash_memo_cheque_date" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3 pt-2 border-top">
                        <button type="submit" name="save_type" value="final" id="btn_save_cashmemo" class="btn btn-primary btn-sm px-4">
                            <i class="ri-check-double-line me-1"></i> Generate Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
