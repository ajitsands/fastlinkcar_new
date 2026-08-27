<?php
$allowedCompanies = [];
if (!empty($_SESSION['company_json'])) {
    $companyData = json_decode($_SESSION['company_json'], true);
    if (is_array($companyData)) {
        $allowedCompanies = $companyData;
    }
}
$isSingleCompany = count($allowedCompanies) <= 1;
?>
<div class="card mb-4" id="vehicleInsuranceContainer">
    <div class="card-header custom-modal-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-white">Vehicle Insurance & Passings</h5>
    </div>
    
    <div class="card-body mt-3">
        <div class="row mb-3 g-3">
            <div class="col-12 col-md-4">
                <input type="text" id="tableSearch" class="form-control" placeholder="Search vehicle or model...">
            </div>
            
            <div class="col-12 col-md-4">
                <select id="companyFilter" class="form-select" <?= $isSingleCompany ? 'disabled' : '' ?>>
                    <?php if (!$isSingleCompany): ?>
                        <option value="">All Companies</option>
                    <?php endif; ?>
                    <?php foreach ($allowedCompanies as $comp): ?>
                        <option value="<?= htmlspecialchars($comp['ids']) ?>"><?= htmlspecialchars($comp['company_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12 col-md-4">
                <select id="statusFilter" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="Overdue">Overdue</option>
                    <option value="0_30">0-30 Days</option>
                    <option value="30_60">30-60 Days</option>
                    <option value="60_90">60-90 Days</option>
                    <option value="greater_90">Greater than 90 Days</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="insuranceTable" style="width:100%">
                <thead style="background: linear-gradient(135deg, #f12526, #c81e1f); color: white;">
                    <tr>
                        <th style="color: white;">Vehicle Number</th>
                        <th style="color: white;">Model</th>
                        <th style="color: white;">Next Insurance</th>
                        <th style="color: white;">Next Passing</th>
                        <th style="color: white;">Status</th>
                        <th style="color: white;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Entry Modal -->
<div class="modal fade" id="addEntryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="addEntryModalTitle">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addEntryForm" onsubmit="event.preventDefault(); submitAddEntry();">
                <div class="modal-body">
                    <input type="hidden" id="entryVehicleId" name="vehicle_id">
                    <input type="hidden" id="entryType" name="type">
                    
                    <div class="mb-3">
                        <label class="form-label">Date (Expiry / Next Due)</label>
                        <input type="date" class="form-control" id="entryDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount (Optional)</label>
                        <input type="number" step="0.01" class="form-control" id="entryAmount" name="amount">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Attachment (Optional)</label>
                        <input type="file" class="form-control" id="entryAttachment" name="attachment">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea class="form-control" id="entryRemarks" name="remarks" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Timeline Modal -->
<div class="modal fade" id="timelineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title">History Timeline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div id="timelineContainer" class="timeline-container">
                    <!-- Populated by JS -->
                </div>
            </div>
        </div>
    </div>
</div>
