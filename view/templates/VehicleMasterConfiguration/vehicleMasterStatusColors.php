<div class="row g-4">
  <div class="col-12">
    <div class="card shadow-none border">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="card-title mb-0">Vehicle Status Colors</h5>
          <small class="text-muted">Choose a badge color for each vehicle status. These colors apply across the entire portal.</small>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary btn-sm" id="btnResetStatusColors">
            <i class="ri-refresh-line me-1"></i> Reset Defaults
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="btnSaveStatusColors">
            <i class="ri-save-line me-1"></i> Save Status Colors
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle" id="statusColorsTable">
            <thead class="table-light">
              <tr>
                <th style="width: 60px;">#</th>
                <th>Vehicle Status</th>
                <th style="width: 180px;">Pick Color</th>
                <th style="width: 140px;">Hex Code</th>
                <th style="width: 220px;">Badge Preview</th>
              </tr>
            </thead>
            <tbody id="statusColorsTableBody">
              <tr><td colspan="5" class="text-center text-muted py-3">Loading status colors...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card shadow-none border">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="card-title mb-0">Contract Status Colors</h5>
          <small class="text-muted">Choose a badge color for each contract agreement status. These colors apply across all contract pages and reports.</small>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary btn-sm" id="btnResetContractStatusColors">
            <i class="ri-refresh-line me-1"></i> Reset Defaults
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="btnSaveContractStatusColors">
            <i class="ri-save-line me-1"></i> Save Contract Colors
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle" id="contractStatusColorsTable">
            <thead class="table-light">
              <tr>
                <th style="width: 60px;">#</th>
                <th>Contract Status</th>
                <th style="width: 180px;">Pick Color</th>
                <th style="width: 140px;">Hex Code</th>
                <th style="width: 220px;">Badge Preview</th>
              </tr>
            </thead>
            <tbody id="contractStatusColorsTableBody">
              <tr><td colspan="5" class="text-center text-muted py-3">Loading contract status colors...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
