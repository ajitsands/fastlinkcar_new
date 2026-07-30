<div class="modal fade" id="contractLedgerModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Contract Ledger</h5>
          <small>
            Agreement No: <span class=" fw-bold" id="ledger_agreement_ref"></span>
          </small>
        </div>
         <input type="hidden" value="" id="txt_ledger_modal_agreement_id">
          <input type="hidden" value="" id="txt_ledger_modal_agreement_no">
          <input type="hidden" value="" id="txt_ledger_modal_booking_ids">
          <input type="hidden" value="" id="txt_ledger_modal_quotation_number">
          <input type="hidden" value="" id="txt_ledger_modal_booking_ref">
          <input type="hidden" value="" id="txt_ledger_modal_vehicle_ids">
          <input type="hidden" value="" id="txt_ledger_modal_model_ids">
          <input type="hidden" value="" id="txt_ledger_modal_customer_code">
          
          
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      
      <div class="modal-body">
          
               <div class="card shadow-sm border-0 rounded-3 p-3 mb-2" id="customer_info_div">
                     
                    <div class="row">
                <h5 class="mb-3">Details</h5>
                        <div class="col-md-4 mb-2">
                            <strong>Customer Name :</strong>
                            <span id="display_customer_name"></span>
                        </div>
                
                      
                        <div class="col-md-4 mb-2">
                            <strong>Mobile :</strong>
                            <span id="display_mobile"></span>
                        </div>
                
                        <div class="col-md-4 mb-2">
                            <strong>Email :</strong>
                            <span id="display_email"></span>
                        </div>
                
                        <div class="col-md-4 mb-2">
                            <strong>Agreement No :</strong>
                            <span id="display_agreement_no"></span>
                        </div>
                
                        <div class="col-md-4 mb-2">
                            <strong>Booking Ref No :</strong>
                            <span id="display_booking_ref"></span>
                        </div>
                
                        <div class="col-md-4 mb-2">
                            <strong>Quotation No :</strong>
                            <span id="display_quotation_no"></span>
                        </div>
                
                    </div>
                
                </div>
             <div class="row mb-4 g-3">
                            <!-- Summary Cards -->
                            <div class="col-md-4">
                                <div class="card summary-card card-total-debit shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Total Debit (Owed)</h6>
                                        <h4 class="card-title mb-0" id="lblTotalDebit">0.000</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card summary-card card-total-credit shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Total Credit (Paid)</h6>
                                        <h4 class="card-title mb-0" id="lblTotalCredit">0.000</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card summary-card card-balance shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Current Balance</h6>
                                        <h4 class="card-title mb-0" id="lblBalance">0.000</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                 <div class="row g-4">
                            <!-- Search & Form Card -->
                            <div class="col-lg-4">
                                <div class="card ledger-card shadow-sm">
                                    
                                    <div class="card-body">
                                       
                                        <h5 class="mb-3">New Transaction</h5>
                                        <form id="frmTransaction">
                                            <input type="hidden" name="action" value="SaveTransaction">
                                            <input type="hidden" name="ids" id="txtTransId">
                                            <input type="hidden" name="customer_code" id="txtCustomerCode">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Transaction Date</label>
                                                <input type="date" name="trans_date" id="txtDate" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Type</label>
                                            
                                                <div class="d-flex align-items-stretch gap-2">
                                            
                                                    <div style="flex:1;">
                                                        <select name="trans_type"
                                                                id="selTransType"
                                                                class="form-select"
                                                                required>
                                                        </select>
                                                    </div>
                                            
                                                    <button class="btn btn-outline-primary"
                                                            type="button"
                                                            id="btnAddHead">
                                                        <i class="ri ri-add-line ri-xl"></i>
                                                    </button>
                                            
                                                </div>
                                            </div>
                                            <div class="mb-3" id="divPaymentMethod">
                                                <label class="form-label">Payment Method</label>
                                                <select name="payment_method" id="selPaymentMethod" class="form-select">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Cheque">Cheque</option>
                                                    <option value="BankTransfer">Bank Transfer</option>
                                                    <option value="CreditCard">Credit Card</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 d-none" id="divBank">
                                                <label class="form-label">Customer Bank (on Cheque)</label>
                                                <div class="input-group">
                                                    <select class="form-select" id="selBank" name="bank_id"></select>
                                                    <button class="btn btn-outline-primary" type="button" id="btnAddBank"><i class="ri ri-add-line ri-xl"></i></button>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-none" id="divCompanyBank">
                                                <label class="form-label">Company Bank (Deposited To)</label>
                                                <select class="form-select" id="selCompanyBank" name="company_bank_id"></select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Amount</label>
                                                <div style="position:relative;">
                
                                                   <span class="min-pricing-text badge bg-danger" style="position:absolute; top:-8px; right:8px; font-size:10px; z-index:2;">
                                                    Min: 0.000
                                                </span>
                                                
                                                     <input type="text" inputmode="decimal"  name="amount" id="txtAmount" class="form-control" required placeholder="0.000">
                                                      <input type="hidden"  name="txtAmounthidden" id="txtAmounthidden" class="form-control" >
                                                
                                                </div>
                                               
                                            </div>
                                            <div class="mb-3">
                                                <div class="row g-2">
                                                    <div class="col-12" id="divReference">
                                                        <label class="form-label">Ref / Cheque No.</label>
                                                        <input type="text" name="ref_no" id="txtReference" class="form-control" placeholder="Optional">
                                                    </div>
                                                    <div class="col-6 d-none" id="divChequeDate">
                                                        <label class="form-label">Cheque Date</label>
                                                        <input type="date" name="cheque_date" id="txtChequeDate" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" id="txtDescription" class="form-control" rows="2"></textarea>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary" id="btnSave">Save Transaction</button>
                                                <button type="button" class="btn btn-outline-secondary d-none" id="btnCancelEdit">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Ledger Table Card -->
                            <div class="col-lg-8">
                                <div class="card ledger-card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Ledger Statement</h5>
                                        <button type="button" class="btn btn-outline-primary" id="btnOpenCalendar">
                                            <span class="ri-calendar-line me-1"></span> Cheque Calendar
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblLedger" class="table table-hover border-top">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type / Method</th>
                                                        <th>Ref</th>
                                                        <th class="text-end">Debit</th>
                                                        <th class="text-end">Credit</th>
                                                        <th class="text-end">Balance</th>
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
        </div>
      <!-- FOOTER -->
      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
      
      </div>

    </div>
  </div>
</div>