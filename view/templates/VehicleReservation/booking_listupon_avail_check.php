<div class="modal fade" id="bookingListModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header custom-modal-header">
        <h5 class="modal-title">Unconfirmed Bookings in Selected Period</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div style="max-height: 400px; overflow-y: auto;">
          <table class="table table-bordered table-sm">
            <thead class="">
              <tr>
                <th>#</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="bookingListTableBody"></tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>