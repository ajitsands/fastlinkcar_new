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
                             <strong>Mobile | CPR/CR:</strong>
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
                        
                        <div class="col-md-4 mb-2">
                            <strong>Category :</strong>
                            <span id="display_vehicle_category"></span>
                        </div>
                
                        <div class="col-md-4 mb-2">
                            <strong>Model :</strong>
                            <span id="display_vehicle_model"></span>
                        </div>
                
                        <div class="col-md-4 mb-2">
                            <strong>Vehicle No :</strong>
                            <span id="display_vehicleno"></span>
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
                            <!-- Ledger Table Card -->
                            <div class="col-lg-12">
                                <div class="card ledger-card shadow-sm">
                                    <div class="card-header border-bottom py-2 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold" style="color:#1b3d94;">Agreement Ledger Statement</h5>
                                        <button type="button" class="btn btn-sm btn-primary" id="btnContractModalPrintSOA">
                                            <i class="ri-printer-line me-1"></i> Print SOA
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblLedger" class="table table-hover border-top align-middle" style="font-size: 13px; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type / Method</th>
                                                        <th>Reference &amp; Details</th>
                                                        <th class="text-center">Flag</th>
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