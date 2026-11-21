<?php
$allowedCompanies = [];
if (!empty($_SESSION['company_json'])) {
    $companyData = json_decode($_SESSION['company_json'], true);
    if (is_array($companyData)) {
        $allowedCompanies = $companyData;
    }
}
// Fallback if not set via session JSON
if (empty($allowedCompanies) && !empty($_SESSION['company_id'])) {
    $allowedCompanies = [
        ['ids' => $_SESSION['company_id'], 'company_name' => $_SESSION['company_name'] ?? 'Default Company']
    ];
}
$isSingleCompany = count($allowedCompanies) <= 1;
?>
<form id="frmMaintenanceRequest" name="frmMaintenanceRequest">

<div class="layout-demo-placeholder ">
	
	<div class="container-fluid flex-grow-1 container-p-y">

        <div class="row">
            <!-- First column (Form) -->
            <div class="col-12 col-lg-8 mb-4" data-permission="maintenance_request_manage">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-3 border-bottom-0">
                        <div>
                            <h5 class="card-title mb-0" id="formTitle">Maintenance Requests</h5>
                            <small class="text-muted" id="formSubtitle">Create a new maintenance request</small>
                        </div>
                        <div>
                            <span class="badge bg-label-success" id="formModeBadge">New Entry</span>
                        </div>
                    </div>
                    
                    <div class="card-body mt-3">
                        <input type="hidden" name="request_id" id="editRequestId" value="">
                        
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline mb-5">
                                    <select class="form-select select2" id="selCompany" name="company_id" <?= $isSingleCompany ? 'readonly' : '' ?> required>
                                        <?php if (!$isSingleCompany): ?>
                                            <option value="">Choose Company...</option>
                                        <?php endif; ?>
                                        <?php foreach ($allowedCompanies as $comp): ?>
                                            <option value="<?= htmlspecialchars($comp['ids']) ?>"><?= htmlspecialchars($comp['company_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="selCompany">Select Company</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-floating form-floating-outline mb-5">
                                    <select class="form-select select2" id="selVehicle" name="vehicle_id" required>
                                        <option value="">Choose Vehicle...</option>
                                    </select>
                                    <label for="selVehicle">Select Vehicle</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex align-items-center mb-5">
                                    <div class="form-floating form-floating-outline flex-grow-1">
                                        <select class="form-select select2" id="selGarage" name="garage_id" required>
                                            <option value="">Choose Garage...</option>
                                        </select>
                                        <label for="selGarage">Select Garage</label>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-icon ms-2" data-bs-toggle="modal" data-bs-target="#addGarageModal" title="Add New Garage">
                                        <i class="ri ri-add-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <div class="mb-3">
                            <h6 class="mb-3 d-flex align-items-center">
                                Assign Services
                                <button type="button" class="btn btn-sm btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                    <i class="ri ri-add-line me-1"></i> Add Service to Master
                                </button>
                            </h6>
                            <div id="serviceListContainer">
                                <!-- Dynamic Service Rows -->
                                <div class="service-row row align-items-end mb-3 pb-3 border-bottom g-3">
                                    <div class="col-12 col-md-3">
                                        <div class="form-floating form-floating-outline mb-5">
                                            <select class="form-select select2 sel-service" name="services[]" required>
                                                <option value="">Select Service...</option>
                                            </select>
                                            <label>Service</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-floating form-floating-outline mb-5">
                                            <input type="number" step="0.01" class="form-control inp-qty" name="qty[]" value="1" placeholder="Qty" required>
                                            <label>Qty</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-floating form-floating-outline mb-5">
                                            <input type="text" class="form-control inp-unit" name="unit[]" placeholder="Unit" required>
                                            <label>Unit</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-floating form-floating-outline mb-5">
                                            <input type="text" class="form-control" name="remarks[]" placeholder="Enter remarks">
                                            <label>Remarks</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-1 text-end mb-5">
                                        <button type="button" class="btn btn-danger btn-icon btnRemoveService" disabled><i class="ri ri-delete-bin-line"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddService">
                                <i class="ri ri-add-line me-1"></i> Add Another Service
                            </button>
                        </div>
                        
                        <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-outline-secondary me-2" id="btnClearForm" data-permission="maintenance_request_manage">Clear</button>
                            <button type="submit" class="btn btn-primary" id="btnSubmitRequest" data-permission="maintenance_request_manage">
                                <i class="ri ri-save-line me-1"></i> Save Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second column (Vehicle Info) -->
            <div class="col-12 col-lg-4 mb-4">
                <!-- Placeholder Card -->
                <div class="card shadow-sm h-100" id="vehiclePlaceholderCard" data-permission="maintenance_request_manage">
                    <div class="card-body p-5 d-flex flex-column align-items-center justify-content-center text-center text-muted">
                        <div class="bg-label-secondary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="ri ri-car-line" style="font-size: 2.5rem;"></i>
                        </div>
                        <h6 class="text-muted fw-bold mb-1">No Vehicle Selected</h6>
                        <small>Please select a vehicle from the dropdown to view its details.</small>
                    </div>
                </div>
                
                <!-- Vehicle Details Card -->
                <div class="card shadow-sm d-none h-100" id="vehicleDetailsCard">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 d-flex align-items-center"><i class="ri ri-car-line me-2"></i>Vehicle Information</h5>
                        <div id="vehicleDetailsContent" class="w-100">
                            <!-- Populated via JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Second row (Table) -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header p-3 border-bottom d-flex flex-wrap align-items-center gap-3">
                        <h5 class="m-0 me-auto">Maintenance Requests History</h5>
                        <div class="d-flex align-items-center gap-2">
                            <input type="date" id="filterFromDate" class="form-control form-control-sm">
                            <span>to</span>
                            <input type="date" id="filterToDate" class="form-control form-control-sm">
                        </div>
                        <div class="form-floating form-floating-outline" style="width:150px;">
                            <select id="filterCompany" class="form-select form-select-sm" <?= $isSingleCompany ? 'readonly' : '' ?>>
                                <?php if (!$isSingleCompany): ?>
                                    <option value="All">All Companies</option>
                                <?php endif; ?>
                                <?php foreach ($allowedCompanies as $comp): ?>
                                    <option value="<?= htmlspecialchars($comp['ids']) ?>"><?= htmlspecialchars($comp['company_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label>Company</label>
                        </div>
                        <div class="form-floating form-floating-outline" style="width:150px;">
                            <select id="filterStatus" class="form-select form-select-sm">
                                <option value="All">All Statuses</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                            <label>Status</label>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" id="btnFilterSearch"><i class="ri ri-search-line me-1"></i>Search</button>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle w-100" id="tblAssignedVehicles">
                                <thead>
                                    <tr>
                                        <th>Ref No / Status</th>
                                        <th>Vehicle Details</th>
                                        <th>Garage</th>
                                        <th>Assigned Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
</form>

<!-- Add Garage Modal -->
<div class="modal fade" id="addGarageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title">Add New Garage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmAddGarage">
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="newGarageName" name="garage_name" placeholder="Garage Name" required>
                        <label for="newGarageName">Garage Name *</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="newGarageContact" name="contact_person" placeholder="Contact Person">
                        <label for="newGarageContact">Contact Person</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="newGaragePhone" name="contact_number" placeholder="Contact Number">
                        <label for="newGaragePhone">Contact Number</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveGarage"><i class="ri ri-save-line me-1"></i> Save Garage</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title">Add New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmAddService">
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="newServiceName" name="service_name" placeholder="Service Name" required>
                        <label for="newServiceName">Service Name *</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="number" step="0.01" class="form-control" id="newServiceCharge" name="charge_per_unit" placeholder="Charge">
                        <label for="newServiceCharge">Standard Charge (Optional)</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveService"><i class="ri ri-save-line me-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Release to Maintenance Modal -->
<div class="modal fade" id="releaseMaintenanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title"><i class="ri ri-send-plane-line me-2"></i>Release to Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmReleaseMaintenance">
                    <input type="hidden" id="releaseRequestId" name="request_id">
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="datetime-local" class="form-control" id="releaseDateTime" name="log_datetime" required>
                        <label for="releaseDateTime">Date & Time Out *</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="number" class="form-control" id="releaseOdometer" name="odometer" placeholder="Odometer Reading" required>
                        <label for="releaseOdometer">Odometer Reading *</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <textarea class="form-control" id="releaseRemarks" name="remarks" placeholder="Remarks" style="height: 80px;"></textarea>
                        <label for="releaseRemarks">Remarks</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSubmitRelease"><i class="ri ri-send-plane-line me-1"></i> Release</button>
            </div>
        </div>
    </div>
</div>

<!-- Receive from Maintenance Modal -->
<div class="modal fade" id="receiveMaintenanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title"><i class="ri ri-download-cloud-2-line me-2"></i>Receive from Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-12 col-md-3">
                        <small class="text-muted text-uppercase">Vehicle Details</small>
                        <h6 class="mb-0 mt-1" id="recvVehicleDetails">--</h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="text-muted text-uppercase">Request Ref</small>
                        <h6 class="mb-0 mt-1 fw-bold text-primary" id="recvRequestRef">--</h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="text-muted text-uppercase">Garage Details</small>
                        <h6 class="mb-0 mt-1" id="recvGarageDetails">--</h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="text-muted text-uppercase">Odometer Out</small>
                        <h6 class="mb-0 mt-1" id="recvOdometerOut">--</h6>
                    </div>
                </div>

                <h6 class="mb-2 border-bottom pb-2">Requested Services</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="recvServicesList">
                            <tr><td colspan="4" class="text-center text-muted">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="mb-2 border-bottom pb-2">Return Details</h6>
                <form id="frmReceiveMaintenance">
                    <input type="hidden" id="receiveRequestId" name="request_id">
                    
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select" id="receiveNewStatus" name="new_status" required>
                                    <option value="Parking" selected>Parking</option>
                                    <option value="Available">Available</option>
                                </select>
                                <label for="receiveNewStatus">New Status *</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="datetime-local" class="form-control" id="receiveDateTime" name="log_datetime" required>
                                <label for="receiveDateTime">Date & Time In *</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="receiveOdometer" name="odometer" placeholder="Odometer Reading" required>
                                <label for="receiveOdometer">Odometer Reading In *</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea class="form-control" id="receiveRemarks" name="remarks" placeholder="Remarks" style="height: 60px;"></textarea>
                                <label for="receiveRemarks">Remarks (Optional)</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSubmitReceive"><i class="ri ri-check-double-line me-1"></i> Confirm Receive</button>
            </div>
        </div>
    </div>
</div>


<!-- View/Cost Details Modal -->
<div class="modal fade" id="viewRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title"><i class="ri ri-file-info-line me-2"></i>Maintenance Details & Cost Allocation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-12 col-md-3">
                        <small class="text-muted text-uppercase">Vehicle Details</small>
                        <h6 class="mb-0 mt-1" id="viewVehicleDetails">--</h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="text-muted text-uppercase">Request Ref</small>
                        <h6 class="mb-0 mt-1 fw-bold text-primary" id="viewRequestRef">--</h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="text-muted text-uppercase">Garage Details</small>
                        <h6 class="mb-0 mt-1" id="viewGarageDetails">--</h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small class="text-muted text-uppercase">Status</small>
                        <h6 class="mb-0 mt-1" id="viewStatusBadge">--</h6>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="mb-2 border-bottom pb-2">Movement History</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>Date & Time</th>
                                        <th>Odometer</th>
                                        <th>Logged By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Out to Maintenance</td>
                                        <td id="viewOutDate">--</td>
                                        <td id="viewOutOdometer">--</td>
                                        <td id="viewOutLoggedBy">--</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Received from Maintenance</td>
                                        <td id="viewInDate">--</td>
                                        <td id="viewInOdometer">--</td>
                                        <td id="viewInLoggedBy">--</td>
                                    </tr>
                                    <tr class="table-secondary">
                                        <td colspan="2" class="text-end fw-bold">Odometer Difference (Km)</td>
                                        <td id="viewOdometerDiff" class="fw-bold text-danger">--</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <form id="frmSaveCosts">
                    <input type="hidden" id="viewRequestId" name="request_id">
                    <h6 class="mb-2 border-bottom pb-2">Requested Services & Cost Allocation</h6>
                    <div class="table-responsive mb-3">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Service Name</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Remarks</th>
                                    <th style="width:150px;">Cost (BD)</th>
                                </tr>
                            </thead>
                            <tbody id="viewServicesList">
                                <tr><td colspan="5" class="text-center">Loading...</td></tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnAddServiceRow">
                                            <i class="ri ri-add-line align-middle me-1"></i> Add Service
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end align-middle fw-bold">Additional Charges (BD)</td>
                                    <td colspan="2">
                                        <input type="text" class="form-control form-control-sm" id="viewAdditionalChargesRemarks" placeholder="Remarks for additional charges">
                                    </td>
                                    <td>
                                        <input type="number" step="0.001" min="0" class="form-control form-control-sm text-end cost-input" id="viewAdditionalCharges" name="additional_charges" value="0.000">
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="4" class="text-end align-middle fw-bold">Total Cost (BD)</td>
                                    <td class="fw-bold text-end fs-5" id="viewTotalCost">0.000</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btnSaveCosts" data-permission="maintenance_request_manage"><i class="ri ri-save-line me-1"></i> Save Costs</button>
            </div>
        </div>
    </div>
</div>
