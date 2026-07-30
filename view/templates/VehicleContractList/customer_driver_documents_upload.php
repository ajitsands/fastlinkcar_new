<div class="modal fade" id="addRentalCustDriverImageModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
    <form id="addCustDriverDetails" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropRentalCarModalTitle">Driver Documents</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col mb-0 mt-2">
                    <label for="rentCustDriverImageName" class="form-label">Document Name</label>
                    <input class="form-control form-control-sm" 
                           id="rentCustDriverImageName" 
                           name="rentCustDriverImageName" 
                           type="text">
            </div>
            
            
             <div class="row">
                  <div class="col mb-6 mt-2">
                    
                    
                    <div class="mb-2">
                        <label for="rentCustDriverImage_document" class="form-label">Select Document</label>
                        <input class="form-control form-control-sm"
                           id="rentCustDriverImage_document"
                           type="file"
                           multiple
                           accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx">
                    </div>
                    <div class="progress" style="height:20px;">
                        <div class="progress-bar" id="uploadrentCustDriverImageDocumentProgress" role="progressbar" style="width:0%">
                            0%
                        </div>
                    </div>
                    
                    <div id="uploadrentCustDriverImageDocumentStatus"></div>
                    
                    <div class="d-flex align-items-center justify-content-between mb-2">
            
                        <div id="rentCustDriverImage_upload_status"></div>
                    
                        <div id="rentCustDriverImage_loader_spinner"
                             class="spinner-border spinner-border-sm text-secondary"
                             role="status"
                             style="display:none;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    
                    </div>
                    
                    
                    
                    
                  </div>
                </div>
            
            
        </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary" id="addrentCarImageButton">Upload</button>
      </div>
    </form>
    </div>
</div>    
<div class="modal fade" id="filePreviewModal" tabindex="-1" style="z-index: 10075 !important;">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">File Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center" id="filePreviewBody">
        <!-- dynamic content -->
      </div>
      <div class="modal-footer">
            <!--<button type="button" class="btn btn-danger" id="deletePreviewImageBtn">Delete</button>-->
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>    