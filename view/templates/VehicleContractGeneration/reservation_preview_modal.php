<div class="modal fade" id="bookingSummaryModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Booking Editor</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Customer</th>
                <th>Booking</th>
                <th>Pricing</th>
                <th>Notes</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="vehicleTableBody"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-end gap-2">

        <!-- Cancel -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>
    
        <!-- Confirm Reservation -->
        <button type="button" class="btn btn-success" id="confirmReservation">
            Confirm Reservation
        </button>
    
    </div>

    </div>
  </div>
</div>