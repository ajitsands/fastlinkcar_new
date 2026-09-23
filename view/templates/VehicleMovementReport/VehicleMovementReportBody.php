<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card mb-4 mt-4">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Vehicle Movement Report</h5>
        </div>
        <div class="card-body mt-3">
            <form id="frmMovementReport">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Company</label>
                        <select id="filter_company" name="filter_company" class="select2 form-select" data-allow-clear="true">
                            <option value="">All Companies</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Vehicle</label>
                        <select id="filter_vehicle" name="filter_vehicle" class="select2 form-select" data-allow-clear="true">
                            <option value="">All Vehicles</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date From</label>
                        <input type="text" id="filter_from_date" name="filter_from_date" class="form-control datepicker" placeholder="DD-MM-YYYY">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date To</label>
                        <input type="text" id="filter_to_date" name="filter_to_date" class="form-control datepicker" placeholder="DD-MM-YYYY">
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
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Movement Logs</h5>
            <button id="btnExportPDF" class="btn btn-sm btn-outline-danger">
                <i class="ri-file-pdf-line me-1"></i> Export PDF
            </button>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-bordered table-sm text-start" id="movementReportTable" style="font-size: 12px; width: 100%;">
                <thead class="table-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Vehicle Details</th>
                        <th>Old Status</th>
                        <th>New Status</th>
                        <th>Odometer</th>
                        <th>KM Used</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populated by AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
