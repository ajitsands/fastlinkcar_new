<!-- Modal -->
<div class="modal fade" id="addDriverModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
    <form id="addDriverDetails" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Client document attachments</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col mb-0 mt-2">
                    <label for="driverName" class="form-label">Driver Name</label>
                    <input class="form-control form-control-sm" 
                           id="driverName" 
                           name="driverName" 
                           type="text">
            </div>
            
            
             <div class="row">
                  <div class="col mb-6 mt-2">
                    
                    
                    <div class="mb-2">
                        <label for="driver_document" class="form-label">Driver Document</label>
                        <input class="form-control form-control-sm" 
                               id="driver_document" 
                               name="driver_document" 
                               type="file" multiple>
                    </div>
                    <div class="progress" style="height:20px;">
                        <div class="progress-bar" id="uploadDriverDocumentProgress" role="progressbar" style="width:0%">
                            0%
                        </div>
                    </div>
                    
                    <div id="uploadDriverDocumentStatus"></div>
                    
                    <div class="row">
                        <div class="col mb-0 mt-2">
                            <div class="mb-0">
                                <label for="" class="form-label">Document Type</label>
                                <select id="driver_document_type" name="driver_document_type" class="form-select form-select-sm">
                                          <option  value="" disabled selected>Select</option>
                                          <option value="DriverPhoto">Driver Photo</option>
                                          <option value="CPR">CPR COPY</option>
                                          <option value="Passport">Passport</option>
                                          <option value="Driving Licence">Driving Licence</option>
                                          <option value="Other">Other</option>
                                        </select>
                            </div>
                        </div>
                        <div class="col mb-0 mt-2">
                                <label for="driver_document_issue_location" class="form-label">Issue Location</label>
                                <input class="form-control form-control-sm" 
                                       id="driver_document_issue_location" 
                                       name="driver_document_issue_location" 
                                       type="text">
                        </div>
                            
                    </div>
                    <div class="row">
                        <div class="col mb-0 mt-2">
                            <div class="mb-2">
                                <label for="driver_document_issue_date" class="form-label">Issue Date</label>
                                 <input class="form-control form-control-sm" 
                                       id="driver_document_issue_date" 
                                       name="driver_document_issue_date" 
                                       type="date">
                            </div>
                        </div>
                        <div class="col mb-0 mt-2">
                                <label for="driver_document_expiry_date" class="form-label">Expiry Date</label>
                                <input class="form-control form-control-sm" 
                                       id="driver_document_expiry_date" 
                                       name="driver_document_expiry_date" 
                                       type="date">
                        </div>
                            
                    </div>
                      
        
                    
                    <div class="d-flex align-items-center justify-content-between mb-2">
            
                        <div id="driver_upload_status"></div>
                    
                        <div id="driver_loader_spinner"
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
        <button type="button" class="btn btn-primary" id="addDriverDetailsButton">Upload</button>
      </div>
    </form>
    </div>
</div>