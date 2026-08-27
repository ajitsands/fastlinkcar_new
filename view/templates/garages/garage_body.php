    <!-- 1. Garage Master Section -->
    <div class="row">
      <!-- Left Column: Form -->
      <div class="col-12 col-lg-8 mb-4">
        <form id="garageForm" name="garageForm">
          <input type="hidden" id="garageId" name="garage_id">
          
          <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h5 class="card-title mb-0">
                <i class="ri-building-2-line me-2 text-primary"></i>Garage Registration Details
              </h5>
              <div id="statusBadgeContainer">
                <span class="badge bg-label-success" id="garageStatusBadge">New Entry</span>
              </div>
            </div>
            
            <div class="card-body">
              <div class="row g-3 mb-4">
                <!-- Garage Name -->
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="garageName" placeholder="Garage Name" required>
                    <label for="garageName">Garage Name <span class="text-danger">*</span></label>
                  </div>
                </div>
                
                <!-- Garage Code -->
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="garageCode" placeholder="GAR-0001">
                    <label for="garageCode">Garage Code</label>
                  </div>
                </div>

                <!-- Contact Person -->
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="contactPerson" placeholder="Contact Person">
                    <label for="contactPerson">Contact Person Name</label>
                  </div>
                </div>
                
                <!-- Contact Number -->
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="contactNumber" placeholder="Contact Number">
                    <label for="contactNumber">Contact Person Number</label>
                  </div>
                </div>

                <!-- Email ID -->
                <div class="col-12 col-md-12">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="email" class="form-control" id="emailId" placeholder="Email Address">
                    <label for="emailId">Email ID</label>
                  </div>
                </div>

                <!-- Address -->
                <div class="col-12 col-md-12">
                  <div class="form-floating form-floating-outline mb-3">
                    <textarea class="form-control" id="garageAddress" placeholder="Address" style="height: 100px;"></textarea>
                    <label for="garageAddress">Garage Address</label>
                  </div>
                </div>
              </div>

              <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 action-buttons-wrapper">
                  <button type="button" class="btn btn-secondary" id="resetGarageBtn">
                      <i class="ri-refresh-line me-1"></i> Reset / Cancel
                  </button>

                  <div class="d-flex gap-2">
                      <button type="button" class="btn btn-warning d-none" id="toggleGarageStatusBtn" data-permission="garage_and_service_manage">
                          <i class="ri-toggle-line me-1"></i> Deactivate
                      </button>
                      <button type="submit" class="btn btn-primary" id="saveGarageBtn" data-permission="garage_and_service_manage">
                          <i class="ri-save-line me-1"></i> Save Garage
                      </button>
                  </div>
              </div>

            </div>
          </div>
        </form>
      </div>
      
      <!-- Right Column: List Table -->
      <div class="col-12 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header p-2">
              <input type="text" id="garageSearch" class="form-control" placeholder="Type to search garages...">
          </div>

          <div class="card-body p-2">
            <div class="table-responsive">
              <table id="garageTable" class="table table-sm table-hover align-middle" style="width:100%">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Garage Name</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- 2. Garage Service Master Section -->
    <div class="row mt-4">
      <!-- Left Column: Form -->
      <div class="col-12 col-lg-8 mb-4">
        <form id="serviceForm" name="serviceForm">
          <input type="hidden" id="serviceId" name="service_id">
          
          <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h5 class="card-title mb-0">
                <i class="ri-tools-line me-2 text-primary"></i>Garage Service Registration Details
              </h5>
              <div id="statusBadgeContainer">
                <span class="badge bg-label-success" id="serviceStatusBadge">New Entry</span>
              </div>
            </div>
            
            <div class="card-body">
              <div class="row g-3 mb-4">
                <!-- Service Name -->
                <div class="col-12 col-md-12">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="serviceName" placeholder="Service Name" required>
                    <label for="serviceName">Service Name <span class="text-danger">*</span></label>
                  </div>
                </div>

                <!-- Unit -->
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="text" class="form-control" id="serviceUnit" placeholder="e.g. Hours, Pieces, Liters">
                    <label for="serviceUnit">Unit</label>
                  </div>
                </div>

                <!-- Charge per Unit -->
                <div class="col-12 col-md-6">
                  <div class="form-floating form-floating-outline mb-3">
                    <input type="number" step="0.01" class="form-control" id="serviceCharge" placeholder="0.00">
                    <label for="serviceCharge">Charge per Unit</label>
                  </div>
                </div>
              </div>

              <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 action-buttons-wrapper">
                  <button type="button" class="btn btn-secondary" id="resetServiceBtn">
                      <i class="ri-refresh-line me-1"></i> Reset / Cancel
                  </button>

                  <div class="d-flex gap-2">
                      <button type="button" class="btn btn-warning d-none" id="toggleServiceStatusBtn" data-permission="garage_and_service_manage">
                          <i class="ri-toggle-line me-1"></i> Deactivate
                      </button>
                      <button type="submit" class="btn btn-primary" id="saveServiceBtn" data-permission="garage_and_service_manage">
                          <i class="ri-save-line me-1"></i> Save Service
                      </button>
                  </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      
      <!-- Right Column: List Table -->
      <div class="col-12 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header p-2">
              <input type="text" id="serviceSearch" class="form-control" placeholder="Type to search services...">
          </div>

          <div class="card-body p-2">
            <div class="table-responsive">
              <table id="serviceTable" class="table table-sm table-hover align-middle" style="width:100%">
                <thead>
                  <tr>
                    <th>Service Name</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
