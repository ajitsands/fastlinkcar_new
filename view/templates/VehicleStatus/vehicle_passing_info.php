<div id="passingFormCard" class="card mb-3 d-none">

  <div class="card-header d-flex justify-content-between">
    <h6 class="mb-0" id="formTitle">Add Passing Details</h6>
    <button class="btn btn-sm btn-outline-secondary" id="closeFormPassing">Close</button>
  </div>

  <div class="card-body">
    <input type="hidden" id="editMode">
    
    <div class="row g-3">

      <div class="col-md-4">
        <label>Info</label>
        <input type="text" id="addedinfo" class="form-control">
      </div>
      

      <div class="col-md-4">
        <label>Passing Done On</label>
        <input type="date" id="passingDate" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Next Passing Date</label>
        <input type="date" id="nextDate" class="form-control">
      </div>

      <div class="col-12">
        <label>Remarks</label>
        <textarea id="passingremarks" class="form-control"></textarea>
      </div>

      <div class="col-12">
        <label>Attachments</label>
        <input type="file" id="passingattachments" class="form-control" multiple>
      </div>

      <div class="col-12">
       <ul id="PassingfilePreview" class="doc_preview_list list-unstyled users-list d-flex align-items-center avatar-group m-0"></ul>
      </div>

    </div>
<div id="passingUploadProgressWrapper" class="mt-2" style="display:none;">
    <div class="progress">
        <div id="passingUploadProgressBar"
             class="progress-bar progress-bar-striped progress-bar-animated"
             style="width:0%">0%</div>
    </div>
    <small class="text-muted">Uploading files, please wait...</small>
  </div>
    <div class="text-end mt-3">
      <button class="btn btn-primary" id="savePassing"><span class="btn-text">Save</span>
    <span class="btn-loader d-none">
        <span class="spinner-border spinner-border-sm me-1"></span>
        Saving...
    </span></button>
    </div>

  </div>
</div>

<div class="card-header">
  <button class="btn btn-sm btn-primary" id="addTimelineBtn">
    <i class="ri ri-add-circle-line me-1"></i> Add New Passing Info
  </button>
</div>
                    <ul class="timeline timeline-outline mb-0" id="ul_passing_histroy_timeline"> </ul>