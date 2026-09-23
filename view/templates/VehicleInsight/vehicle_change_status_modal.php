<div class="modal fade" id="vehicleChangeStatusModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title mb-0">Vehicle Change Status</h5>
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
            <div class="mb-3">
              <label class="form-label fw-semibold">Select Status</label>
             <select id="select_service_type" name="select_service_type" class="form-select">
                    <option value="0">Select Status</option>
                    <option value="Available">Available</option>
                    <option value="Parking">Parking</option>
                    <option value="Blocked">Blocked</option>
                </select>
            </div>

       

          </div>

          <!-- RIGHT SIDE -->
          <div class="col-lg-7">

   <div class="mb-3">
              <label class="form-label">Notes/Comments</label>
              <textarea class="form-control" rows="3"
                        placeholder="Enter any notes/comments..." id="txt_notes"></textarea>
            </div>

          </div>

        </div>
      </div>

      <!-- FOOTER -->
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="confirmStatusBtn">
          Confirm Status
        </button>
      </div>

    </div>
  </div>
</div>