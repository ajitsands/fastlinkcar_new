<!-- Modal -->
<div class="modal fade" id="addRentalCarImageModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
    <form id="addRentalCarDetails" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropRentalCarModalTitle">Client document attachments</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col mb-0 mt-2">
                    <label for="rentCarImageName" class="form-label">Image Name</label>
                    <input class="form-control form-control-sm" 
                           id="rentCarImageName" 
                           name="rentCarImageName" 
                           type="text">
            </div>
            
            
             <div class="row">
                  <div class="col mb-6 mt-2">
                    
                    
                    <div class="mb-2">
                        <label for="rentCarImage_document" class="form-label">Car Document</label>
                        <input class="form-control form-control-sm" 
                               id="rentCarImage_document" 
                               name="rentCarImage_document" 
                               type="file" multiple>
                    </div>
                    <div class="progress" style="height:20px;">
                        <div class="progress-bar" id="uploadrentCarImageDocumentProgress" role="progressbar" style="width:0%">
                            0%
                        </div>
                    </div>
                    
                    <div id="uploadrentCarImageDocumentStatus"></div>
                    
                    <div class="d-flex align-items-center justify-content-between mb-2">
            
                        <div id="rentCarImage_upload_status"></div>
                    
                        <div id="rentCarImage_loader_spinner"
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