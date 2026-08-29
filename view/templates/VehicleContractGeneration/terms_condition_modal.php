<div class="modal fade" id="termsAndConditionModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title">Contract Terms and Conditions Configurator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row">
        
        <div class="col-12 mb-4">
             <div class="table-responsive">
                    <table id="termsTable" class="table table-bordered table-hover table-sm align-middle w-100">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Default</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
        <div class="col-12 mb-3">
            <hr class="text-muted">
            <h5 class="fw-bolder text-dark mb-3 mt-2">Add / Edit Term</h5>
        </div>

        <!-- Full Editor -->
        <div class="col-12">
            <div id="full-editor"></div>
        </div>
        
        <!-- Title & Save -->
        <div class="col-12 mt-3 mb-2 d-flex justify-content-end">
            <div class="input-group" style="max-width: 500px;">
                <input type="hidden" id="edit_term_id" value="">
                <span class="input-group-text bg-light fw-bold">Term Title</span>
                <input class="form-control form-control-sm" type="text" placeholder="Enter title for the custom term..." id="t_c_name" name="t_c_name">
                <button class="btn btn-primary waves-effect ladda-button" data-style="expand-right" id="saveTermsAndConditions" type="button"><i class="ri-save-line me-1"></i> <span>Save Term</span></button>
            </div>
        </div>
        
      </div>

      <div class="modal-footer border-top d-flex justify-content-between">
            <!-- Left Side -->
            <button class="btn btn-secondary" data-bs-dismiss="modal">
                Cancel
            </button>
        
            <!-- Right Side -->
            <button type="button" id="copyTCBtn" class="btn btn-warning">
                <i class="ri-check-line me-1"></i> Apply Selected Term
            </button>
      </div>

    </div>
  </div>
</div>