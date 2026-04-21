<div class="modal fade" id="checkavailabilityModal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header custom-modal-header">
        <h5 class="modal-title">Check Vehicle Availability</h5>
        <button type="button" class="btn-close AvailcancelBtn" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">From Date & Time</label>
          <input type="datetime-local" id="fromDateTimeavail" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">To Date & Time</label>
          <input type="datetime-local" id="toDateTimeavail" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Vehicle Model</label>
          <div id="dropdownContaineravail"  class="left-scroll-area w-100">
                    
            </div>
          
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary AvailcancelBtn" data-bs-dismiss="modal" >Cancel</button>
        <button  class="btn btn-success" id="btnSubmitAvailability">Check</button>
      </div>

    </div>
  </div>
</div>