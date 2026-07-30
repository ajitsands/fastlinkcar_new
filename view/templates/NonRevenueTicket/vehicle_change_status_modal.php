<div class="modal fade" id="vehicleChangeStatusModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title mb-0">Generate Non-Revenue Ticket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body">
         <div class="row g-3">
           <div class="mb-3">
              <label class="form-label fw-semibold">
                Selected Vehicles (<span id="modalvehicleBookingCount">0</span>)
              </label>

              <div id="modalselectedVehiclesList"
                   class="d-flex flex-wrap gap-2 border rounded p-2 bg-light"
                   style="max-height:120px; overflow-y:auto;">

                <div class="text-muted small">No vehicles selected</div>

              </div>
            </div>
        </div>
        <div class="row g-3">

          <!-- LEFT SIDE -->
          <div class="col-lg-5 border-end">

            <!-- BOOKING TYPE -->
                   <div class="card mb-1">
          <div class="card-header fw-semibold">Assign Staff</div>
          <div class="card-body">
             
                <div class="d-flex align-items-stretch gap-1">
            
                    <div class="form-floating form-floating-outline flex-grow-1">
                        <select id="selectStaffFromSelect2"
                                name="staff_name"
                                class="select2 form-select"
                                data-allow-clear="true"
                                style="width:100%">
                        </select>
                    
                    </div>
            
                </div>
                 
            </div>
          
        </div>
<div class="card mb-1">
        <div class="card-header fw-semibold">Staff Details</div>
        <div class="card-body">
        <input type="hidden" id="staff_id" name="staff_id">
         <div class="row g-3">

    <!-- Staff Name -->
    <div class="col-md-12">
        <label for="StaffName" class="form-label small">Staff Name</label>
        <input type="text" class="form-control form-control-sm"
               id="StaffName" placeholder="Staff Name" readonly>
    </div>

    <!-- Telephone -->
    <div class="col-md-6">
        <label for="StaffPhone" class="form-label small">Telephone</label>
        <input type="text" class="form-control form-control-sm"
               id="StaffPhone" placeholder="Telephone">
    </div>

    <!-- Email -->
    <div class="col-md-6">
        <label for="StaffEmail" class="form-label small">Email</label>
        <input type="email" class="form-control form-control-sm"
               id="StaffEmail" placeholder="Email">
    </div>

    <!-- CPR -->
    <div class="col-md-6">
        <label for="StaffCPR" class="form-label small">CPR No.</label>
        <input type="text" class="form-control form-control-sm"
               id="StaffCPR" placeholder="CPR Number">
    </div>

    <!-- CPR Expiry -->
    <div class="col-md-6">
        <label for="StaffCPRExpiry" class="form-label small">CPR Expiry</label>
        <input type="text" class="form-control form-control-sm"
               id="StaffCPRExpiry" placeholder="CPR Expiry">
        <span id="cprStatus" class="small fw-semibold mt-1 d-block"></span>
    </div>

    <!-- License -->
    <div class="col-md-6">
        <label for="StaffLicence" class="form-label small">License No.</label>
        <input type="text" class="form-control form-control-sm"
               id="StaffLicence" placeholder="License Number">
    </div>

    <!-- License Issue Place -->
    <div class="col-md-6">
        <label for="StaffLicenceIssue" class="form-label small">License Issue Place</label>
        <input type="text" class="form-control form-control-sm"
               id="StaffLicenceIssue" placeholder="Issue Place">
    </div>

    <!-- License Issue Date -->
    <div class="col-md-6">
        <label for="StaffLicenceIssueDate" class="form-label small">License Issue Date</label>
        <input type="text" class="form-control form-control-sm"
               id="StaffLicenceIssueDate" placeholder="Issue Date">
    </div>

    <!-- License Expiry -->
    <div class="col-md-6">
        <label for="StaffLicenceExpiryDate" class="form-label small">License Expiry</label>
        <input type="text" class="form-control form-control-sm"
               id="StaffLicenceExpiryDate" placeholder="License Expiry">
        <span id="licenseStatus" class="small fw-semibold mt-1 d-block"></span>
    </div>

</div>

        </div>
      </div>
       

          </div>

          <!-- RIGHT SIDE -->
          <div class="col-lg-7">

        <div class="card mb-1">
            <div class="card-header fw-semibold">Ticket Details</div>
            <div class="card-body">
           <div class="row g-2 mb-1">
    
                <div class="col-md-6">
                  <label class="form-label small">From Date</label>
                  <input type="datetime-local"
                         class="from_datetime form-control form-control-sm watch-field" id="from_datetime">
                </div>
    
                <div class="col-md-6">
                  <label class="form-label small">To Date</label>
                  <input type="datetime-local"
                         class="to_datetime form-control form-control-sm watch-field" id="to_datetime">
                </div>
    
              
              
                <div class="col-12">
                  <textarea id="booking_notes" class="form-control form-control-sm"
                            rows="6"
                            placeholder="Notes/Comments if any..."></textarea>
                </div>
    
              </div>
           </div>
       </div>
       

          </div>

        </div>
      </div>

      <!-- FOOTER -->
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="confirmnrtBtn">
         Generate Non-Revenue Ticket
        </button>
      </div>

    </div>
  </div>
</div>