<div class="modal fade" id="vehicleBookingModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- HEADER -->
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title mb-0">Vehicle Booking</h5>
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
              <label class="form-label fw-semibold">Booking Type</label>
              <select class="form-select" id="bookingType">
                <option value="direct">Direct Booking</option>
                <option value="quotation">Against Quotation</option>
              </select>
            </div>

            <!-- CUSTOMER DETAILS -->
            <div class="mb-3 p-3 border rounded">
              <label class="form-label fw-semibold">Customer Details</label>

              <input type="text" class="form-control form-control-sm mb-2"
                     id="customerName" placeholder="Customer Name">

              <input type="text" class="form-control form-control-sm mb-2"
                     id="customerPhone" placeholder="Telephone">

              <input type="email" class="form-control form-control-sm mb-2"
                     id="customerEmail" placeholder="Email">

              <textarea class="form-control form-control-sm mb-2"
                        id="customerAddress" rows="2"
                        placeholder="Address"></textarea>

              <input type="text" class="form-control form-control-sm"
                     id="customerAttention" placeholder="Attention">
            </div>

            <!-- DATE RANGE -->
            <div class="mb-3 p-3 border rounded">
              <label class="form-label fw-semibold">Booking Details</label>

              <div class="row g-2">
                <div class="col-md-6">
                  <label class="form-label small">From Date</label>
                   
                  <input type="datetime-local" class="from_datetime form-control form-control-sm datetime_col">
                </div>

                <div class="col-md-6">
                  <label class="form-label small">To Date</label>
                  <input type="datetime-local" class="to_datetime form-control form-control-sm datetime_col">
                </div>
                <div class="col-md-6">
                  <label class="form-label small">Type</label>
                  <select class="rate_type form-control form-control-sm" >
                        <option value="0">Select</option>
                        <option value="hour">Hourly</option>
                        <option value="day">Daily</option>
                        <option value="month">Monthly</option>
                    </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label small">Service</label>
                  <select class="service form-control form-control-sm " >
                    <option value="0">Select Service</option>
                    <option value="1" data-vat="10">Rental Without Driver</option>
                    <option value="2" data-vat="0">Rental With Driver</option>
                </select>
                </div>
              </div>
            </div>

            <!-- QUOTATION REF -->
            <div class="mb-3">
              <label class="form-label">Quotation Ref No</label>
              <input type="text" class="form-control" id="quotationRef" placeholder="Optional">
            </div>
           

            <!-- NOTES -->
            <div class="mb-3">
              <label class="form-label">Notes</label>
              <textarea class="form-control" rows="3"
                        placeholder="Enter any notes..."></textarea>
            </div>

          </div>

          <!-- RIGHT SIDE -->
          <div class="col-lg-7">

            <!-- SEARCH -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Search Quotation</label>
              <input type="text" class="form-control"
                     id="searchQuotation"
                     placeholder="Type quotation no">
            </div>

            <!-- QUOTATION LIST -->
            <div id="quotationList"
                 class="mb-3 border rounded p-2"
                 style="max-height:280px; overflow-y:auto;">

              <div class="text-muted small text-center">
                No quotations found
              </div>

            </div>

         
<div class="border rounded p-3" id="quotationPreview" style="height:auto;">
              <div class="text-muted small text-center">
                Select a quotation to preview details
              </div>

            </div>

          </div>

        </div>
      </div>

      <!-- FOOTER -->
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="confirmBookingBtn">
          Confirm Booking
        </button>
      </div>

    </div>
  </div>
</div>