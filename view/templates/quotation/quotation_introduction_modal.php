<div class="modal fade" id="QtnIntroductionModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Introduction</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row">
       
        <!-- Full Editor -->
                <div class="col-12">
                  
                      <div id="full-editor-introduction">
                            
                      
                  </div>
                </div>
                <div class="col-12">
                  <!--<div class="card">-->
                  <!--  <div class="card-body" style="padding-top:0px;">-->
                        <div class="table-responsive">
                            <table id="introTable" class="table table-bordered  table-hover table-sm align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Delete</th>
                                    <th>Show</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                  <!--  </div>-->
                  <!--</div>-->
                </div>
        <!-- /Full Editor -->
       
      </div>

        <div class="modal-footer  border-top d-flex">

            <!-- Left Side -->
            <div class="d-flex align-items-center me-auto">
        
                <button class="btn btn-secondary me-2" data-bs-dismiss="modal">
                    Cancel
                </button>
        
               
                <div class="input-group">
                        <input class="form-control form-control-sm"   type="text"  placeholder="Title"   id="int_name"   name="int_name">
                        <button class="btn btn-primary waves-effect me-2" id="saveintroduction" type="button" >Save</button>
                  </div>
        
               
        
            </div>
        
            <!-- Right Side -->
            <!--<button class="btn btn-info me-2" id="loadTerms">Show</button>-->
        
            <button type="button"
                id="intcopyContentBtn"
                class="btn btn-warning btn-sm">
                Apply
            </button>
        
        </div>

    </div>
  </div>
</div>