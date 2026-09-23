<div class="modal fade" id="maintenanceRequestViewModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title mb-0">Maintenance Request Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Request No:</strong> <span id="viewReqNo">--</span><br>
                <strong>Date:</strong> <span id="viewReqDate">--</span><br>
                <strong>Status:</strong> <span id="viewReqStatus" class="badge bg-primary">--</span>
            </div>
            <div class="col-md-6">
                <strong>Garage:</strong> <span id="viewReqGarage">--</span><br>
                <strong>Vehicle:</strong> <span id="viewReqVehicle">--</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <strong>Odometer Out:</strong> <span id="viewReqOdoOut">--</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6 class="fw-bold mb-2">Services</h6>
                <div class="table-responsive border rounded">
                    <table class="table table-sm table-striped m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Service</th>
                                <th>Qty</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody id="viewReqServicesList">
                            <tr>
                                <td colspan="3" class="text-center text-muted">No services</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
