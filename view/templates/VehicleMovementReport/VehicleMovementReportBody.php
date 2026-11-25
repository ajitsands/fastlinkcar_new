<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body py-3">
            <form id="frmMovementReport">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label form-label-sm fw-semibold mb-1" for="filter_company">Company</label>
                        <select id="filter_company" name="filter_company" class="select2 form-select form-select-sm" data-allow-clear="true">
                            <option value="">All Companies</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label form-label-sm fw-semibold mb-1" for="filter_vehicle">Vehicle</label>
                        <select id="filter_vehicle" name="filter_vehicle" class="select2 form-select form-select-sm" data-allow-clear="true">
                            <option value="">All Vehicles</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm fw-semibold mb-1" for="filter_from_date">Date From</label>
                        <input type="date" id="filter_from_date" name="filter_from_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm fw-semibold mb-1" for="filter_to_date">Date To</label>
                        <input type="date" id="filter_to_date" name="filter_to_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="button" id="btnSearch" class="btn btn-sm btn-primary flex-grow-1">
                            <i class="ri-search-line me-1"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header border-bottom py-2 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-bold" style="color: #1b3d94;">
                <i class="ri-route-line me-1"></i> Movement Logs
            </h5>
            <button id="btnExportPDF" class="btn btn-sm btn-primary">
                <i class="ri-file-pdf-line me-1"></i> Export PDF
            </button>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle text-start mb-0" id="movementReportTable" style="font-size: 13px; width: 100%;">
                    <thead>
                        <tr>
                            <th>Date &amp; Time</th>
                            <th>Vehicle Details</th>
                            <th class="text-center">Old Status</th>
                            <th>New Status &amp; Details</th>
                            <th class="text-end">Odometer</th>
                            <th class="text-end">KM Used</th>
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
</div>
