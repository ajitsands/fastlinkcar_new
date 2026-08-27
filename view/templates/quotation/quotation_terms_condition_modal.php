<div class="modal fade" id="termsAndConditionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header custom-modal-header bg-danger">
        <h5 class="modal-title text-white">Terms & Condition Configurator</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <style>
            /* Make the Quill placeholder look like a standard template placeholder */
            #termsAndConditionModal .ql-editor.ql-blank::before {
                font-style: normal !important;
                color: #a1acb8 !important; 
                font-family: var(--bs-font-sans-serif) !important;
                font-size: 0.8125rem !important; 
                padding-top: 5px; 
            }
            #termsAndConditionModal .ql-editor {
                font-family: var(--bs-font-sans-serif) !important;
            }
        </style>
        <div class="row">
            <div class="col-12 mb-3">
                 <div class="table-responsive">
                        <table id="termsTable" class="table table-bordered table-hover table-sm align-middle w-100">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Full Editor -->
            <div class="col-12">
                  <div id="full-editor"></div>
            </div>
            <!-- /Full Editor -->
            <div class="col-12 mt-3">
                <div class="input-group">
                    <input type="hidden" id="t_c_id" name="t_c_id">
                    <input class="form-control form-control-sm" type="text" placeholder="Title" id="t_c_name" name="t_c_name">
                    <button class="btn btn-primary waves-effect" id="saveTermsAndConditions" type="button">Save</button>
                </div>
            </div>
        </div>
      </div>

        <div class="modal-footer border-top d-flex justify-content-between align-items-center">

            <!-- Left Side -->
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        
            <!-- Right Side -->
            <button type="button"
                id="copyTCBtn"
                class="btn btn-warning btn-sm">
                Apply
            </button>
        
        </div>

    </div>
  </div>
</div>