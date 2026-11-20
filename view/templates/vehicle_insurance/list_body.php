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
<div id="vehicleExpiryAlertBanner" class="mb-3" style="display:none;"></div>
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
                <thead style="background: linear-gradient(135deg, #1b3d94, #153075); color: white;">
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

<!-- Add / Edit Insurance & Passing Modal -->
<div class="modal fade" id="addEntryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="addEntryModalTitle">Add Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addEntryForm" onsubmit="event.preventDefault(); submitAddEntry();">
                <div class="modal-body">
                    <input type="hidden" id="entryVehicleId" name="vehicle_id">
                    <input type="hidden" id="entryType" name="type">
                    <input type="hidden" id="entryId" name="entry_id">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" id="entryDateLabel">Next Expiry Date *</label>
                            <input type="date" class="form-control" id="entryDate" name="date" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Amount (BHD)</label>
                            <input type="number" step="0.001" min="0" class="form-control" id="entryAmount" name="amount" placeholder="0.000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Attach Document (Optional)</label>
                            <input type="file" class="form-control" id="entryAttachment" name="attachment" accept=".pdf,.png,.jpg,.jpeg,.webp">
                        </div>

                        <!-- Insurance-specific fields -->
                        <div class="col-md-4 vi-ins-only">
                            <label class="form-label fw-semibold">Insurance Provider</label>
                            <input type="text" class="form-control" id="entryProvider" name="provider" placeholder="e.g. Solidarity, BNI, GIG">
                        </div>
                        <div class="col-md-4 vi-ins-only">
                            <label class="form-label fw-semibold">Policy Number</label>
                            <input type="text" class="form-control" id="entryPolicyNo" name="policy_no" placeholder="Policy No.">
                        </div>
                        <div class="col-md-4 vi-ins-only">
                            <label class="form-label fw-semibold">Insurance Type</label>
                            <select class="form-select" id="entryInsType" name="insurance_type">
                                <option value="Comprehensive">Comprehensive</option>
                                <option value="Third Party">Third Party</option>
                            </select>
                        </div>
                        <div class="col-md-4 vi-ins-only">
                            <label class="form-label fw-semibold">Policy Start Date</label>
                            <input type="date" class="form-control" id="entryStartDate" name="start_date">
                        </div>

                        <!-- Passing-specific fields -->
                        <div class="col-md-4 vi-pass-only" style="display: none;">
                            <label class="form-label fw-semibold">Passed Date</label>
                            <input type="date" class="form-control" id="entryPassedDate" name="passed_date">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Remarks</label>
                            <input type="text" class="form-control" id="entryRemarks" name="remarks" placeholder="Optional remarks...">
                        </div>

                        <div class="col-12 mt-3">
                            <div class="border-top pt-2">
                                <div class="fw-semibold small mb-2" style="color: #1b3d94;"><i class="ri-history-line me-1"></i> Renewal History</div>
                                <div id="viHistoryList" class="small text-muted" style="max-height: 220px; overflow-y: auto;"></div>
                                <div id="viEntryDetailBox" class="alert alert-light border mt-2 mb-0 small" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary d-none" id="viCancelEditBtn">Cancel Edit</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="viSaveBtn">Save Record</button>
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
