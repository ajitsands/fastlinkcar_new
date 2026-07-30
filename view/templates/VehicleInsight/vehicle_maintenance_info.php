<div id="maintenanceFormCard" class="card mb-3 d-none">

  <div class="card-header d-flex justify-content-between">
    <h6 class="mb-0" id="maintenanceformTitle">Add Maintenance Details</h6>
    <button class="btn btn-sm btn-outline-secondary" id="closeFormMaintenance">Close</button>
  </div>

  <div class="card-body">
    <input type="hidden" id="maintenanceeditMode">
    
    <div class="row g-3">

      <div class="col-md-4">
        <label>Info</label>
        <input type="text" id="maintenanceaddedinfo" class="form-control">
      </div>
      

      <div class="col-md-4">
        <label>Maintenance Done On</label>
        <input type="date" id="maintenanceDate" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Next Maintenance Date</label>
        <input type="date" id="maintenancenextDate" class="form-control">
      </div>

      <div class="col-12">
        <label>Remarks</label>
        <textarea id="maintenanceremarks" class="form-control"></textarea>
      </div>

      <div class="col-12">
        <label>Attachments</label>
        <input type="file" id="maintenanceattachments" class="form-control" multiple>
      </div>

      <div class="col-12">
       <ul id="MaintenancefilePreview" class="doc_preview_list list-unstyled users-list d-flex align-items-center avatar-group m-0"></ul>
      </div>

    </div>
    <div id="maintenanceUploadProgressWrapper" class="mt-2" style="display:none;">
    <div class="progress">
        <div id="maintenanceUploadProgressBar"
             class="progress-bar progress-bar-striped progress-bar-animated"
             style="width:0%">0%</div>
    </div>
    <small class="text-muted">Uploading files, please wait...</small>
  </div>
    <div class="text-end mt-3">
      <button class="btn btn-primary" id="saveMaintenance"><span class="btn-text">Save</span>
    <span class="btn-loader d-none">
        <span class="spinner-border spinner-border-sm me-1"></span>
        Saving...
    </span></button>
    </div>

  </div>
</div>

<div class="card-header">
  <button class="btn btn-sm btn-primary" id="maintenanceaddTimelineBtn">
    <i class="ri ri-add-circle-line me-1"></i> Add New Maintenance Info
  </button>
</div>
                    <ul class="timeline timeline-outline mb-0" id="ul_maintenance_histroy_timeline"> </ul>