<div class="modal fade" id="bookingSummaryModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content border-0 shadow">

      <div class="modal-header" style="background: linear-gradient(135deg, #f12526, #c81e1f); border-bottom: none; border-radius: calc(var(--bs-modal-border-radius) - 1px) calc(var(--bs-modal-border-radius) - 1px) 0 0;">
        <h5 class="modal-title" style="color: #fff; font-size: 1.1rem; font-weight: 600;">Booking Editor</h5>
        <button class="btn-close" data-bs-dismiss="modal" style="filter: invert(1); opacity: 1;"></button>
      </div>

      <div class="modal-body p-3">
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover align-middle" style="font-size: 0.9rem;">
            <thead style="background-color: #fdf2f2 !important; border-bottom: 2px solid #f12526 !important; text-transform: uppercase; font-size: 0.85rem;">
              <tr>
                <th style="color: #f12526 !important; background-color: transparent !important; font-weight: 600;">#</th>
                <th style="color: #f12526 !important; background-color: transparent !important; font-weight: 600;">Vehicle</th>
                <th style="color: #f12526 !important; background-color: transparent !important; font-weight: 600;">Customer</th>
                <th style="color: #f12526 !important; background-color: transparent !important; font-weight: 600;">Booking</th>
                <th style="color: #f12526 !important; background-color: transparent !important; font-weight: 600;">Pricing</th>
                <th style="color: #f12526 !important; background-color: transparent !important; font-weight: 600;">Notes</th>
                <th style="color: #f12526 !important; background-color: transparent !important; font-weight: 600;">Action</th>
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