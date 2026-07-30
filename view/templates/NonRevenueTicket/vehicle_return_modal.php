<div class="modal fade" id="vehicleChangeStatusModalList" tabindex="-1">
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
                Selected Vehicles (<span id="modalvehicleBookingCountList">0</span>)
              </label>

              <div id="modalselectedVehiclesList1"
                   class="d-flex flex-wrap gap-2 border rounded p-2 bg-light"
                   style="max-height:120px; overflow-y:auto;">

                <div class="text-muted small">No vehicles selected</div>

              </div>
            </div>
        </div>
     <div class="row g-3">

    <!-- ===================== BOOKED VEHICLE DETAILS ===================== -->
    <div class="col-12">
        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <div>
                    <i class="ri-file-list-3-line me-2"></i>
                    <strong>Non-Revenue ticket details for selected vehicle(s)</strong>
                </div>

               
            </div>

            <div class="card-body p-2">

                <table id="tblNonRevenueBookings"
                       class="table table-bordered table-hover table-striped table-sm align-middle w-100 mb-0">

                    <thead class="table-light">
                        <tr>
                            <th style="width:18%;">Vehicle / Ref</th>
                            <th style="width:18%;">Model</th>
                            <th style="width:22%;">Booking Period</th>
                            <th style="width:22%;">Staff Details</th>
                            <th style="width:20%;">Booking Notes</th>
                        </tr>
                    </thead>

                    <tbody></tbody>

                </table>

            </div>

        </div>
    </div>


    <!-- ===================== RETURN DETAILS ===================== -->
    <div class="col-12">

        <div class="card shadow-sm">

            <div class="card-header bg-primary text-white mb-2">
                <i class="ri-arrow-go-back-line me-2"></i>
                <strong>Return Details</strong>
            </div>

            <div class="card-body">

                <div class="row g-3">

    <!-- Return Date -->
    <div class="col-lg-3 col-md-4">
        <label class="form-label fw-semibold">
            <i class="ri-calendar-event-line text-success me-1"></i>
            Return Date & Time
        </label>

        <input type="datetime-local"
               id="to_datetime_return"
               class="form-control form-control-sm">
    </div>

    <!-- Vehicle Status -->
    <div class="col-lg-3 col-md-4">
        <label class="form-label fw-semibold">
            <i class="ri-car-line text-warning me-1"></i>
            Vehicle Status
        </label>

        <select id="select_vehicle_status"
                name="select_vehicle_status"
                class="form-select form-select-sm">
            <option value="">Select Status</option>
            <option value="Available">Available</option>
            <option value="Parking">Parking</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Blocked">Blocked</option>
        </select>
    </div>

    <!-- Return Remarks -->
    <div class="col-lg-6 col-md-12">
        <label class="form-label fw-semibold">
            <i class="ri-file-text-line text-primary me-1"></i>
            Return Remarks
        </label>

        <textarea
            id="return_notes"
            class="form-control form-control-sm"
            rows="6"
            placeholder="Enter return remarks, damages, fuel level, odometer reading or any additional comments..."></textarea>
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
        <button class="btn btn-primary" id="btnCompleteReturn">
         Complete Return
        </button>
      </div>

    </div>
  </div>
</div>