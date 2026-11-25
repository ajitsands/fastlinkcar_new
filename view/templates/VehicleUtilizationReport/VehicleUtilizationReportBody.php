<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card mb-4 mt-4">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Vehicle Utilization Report</h5>
        </div>
        <div class="card-body mt-3">
            <form id="frmUtilizationReport">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Company</label>
                        <select class="form-select" id="filter_company" name="company_id">
                            <!-- Populated via JS -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Vehicle</label>
                        <select class="form-select select2" id="filter_vehicle" name="vehicle_id">
                            <option value="">All Vehicles</option>
                            <!-- Populated via JS -->
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date From</label>
                        <input type="date" class="form-control" id="filter_from_date" name="from_date">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date To</label>
                        <input type="date" class="form-control" id="filter_to_date" name="to_date">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="btnSearch" class="btn btn-primary w-100">
                            <i class="ri-search-line me-1"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Report Results</h5>
            <div>
                <button type="button" class="btn btn-primary" id="btnPdf">
                    <i class="ri-file-pdf-2-line me-1"></i> Export PDF
                </button>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-start mb-0" id="utilizationReportTable" style="font-size: 13px; width: 100%;">
                    <thead>
                        <tr>
                            <th>Vehicle Details</th>
                            <th>Total Days in Period</th>
                            <th>Days Rented Out</th>
                            <th>Days Maintenance</th>
                            <th>Days Idle</th>
                            <th style="width: 200px;">Utilization %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Populated via JS -->
                        <tr>
                            <td colspan="6" class="text-center text-muted">Please select a date range and click Search.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
