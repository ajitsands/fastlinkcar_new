<div class="modal fade" id="customerLedgerModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <div>
          <h5 class="mb-0 text-white">Customer Ledger</h5>
          <small>
            Customer Name: <span class=" fw-bold" id="customer_ledger_customer_name"></span>
          </small>
        </div>
    
          <input type="hidden" value="" id="txt_customer_ledger_modal_customer_code">
          
          
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      
      <div class="modal-body">
          
               <div class="card shadow-sm border-0 rounded-3 p-3 mb-2" id="customer_customer_info_div">
                     
                    <div class="row">
                <h5 class="mb-3">Details</h5>
                        <div class="col-md-3 mb-2">
                            <strong>Customer Name :</strong>
                            <span id="customer_display_customer_name"></span>
                        </div>
                
                      
                        <div class="col-md-3 mb-2">
                            <strong>Mobile :</strong>
                            <span id="customer_display_mobile"></span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <strong>CPR/CR :</strong>
                            <span id="customer_display_cprcr"></span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <strong>Email :</strong>
                            <span id="customer_display_email"></span>
                        </div>
                
                        
                
                    </div>
                
                </div>
             <div class="row mb-4 g-3">
                            <!-- Summary Cards -->
                            <div class="col-md-4">
                                <div class="card summary-card card-total-debit shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Total Debit (Owed)</h6>
                                        <h4 class="card-title mb-0" id="customer_lblTotalDebit">0.000</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card summary-card card-total-credit shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Total Credit (Paid)</h6>
                                        <h4 class="card-title mb-0" id="customer_lblTotalCredit">0.000</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card summary-card card-balance shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-subtitle text-muted mb-1">Current Balance</h6>
                                        <h4 class="card-title mb-0" id="customer_lblBalance">0.000</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                 <div class="row g-4">
                            

                            <!-- Ledger Table Card -->
                            <div class="col-lg-12">
                                <div class="card ledger-card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Ledger Statement</h5>
                                        
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblCustomerLedger" class="table table-hover border-top">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Agreement No.</th>
                                                        <th>Type / Method</th>
                                                        <th>Ref</th>
                                                        <th class="text-end">Debit</th>
                                                        <th class="text-end">Credit</th>
                                                        <th class="text-end">Balance</th>
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