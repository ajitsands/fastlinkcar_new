 <div class="row g-3 vehicle-section" id="divsearch" >

    <!-- Column 1: Car Categories -->
   <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
      <div class="card  shadow-sm">
        <div class="card-header p-2 align-items-center justify-content-between gap-1">
 
      <input type="text" id="searchTree" class="form-control w-100" placeholder="Search categories or brands...">
    </div>
        <div class="card-body p-0 " id="treeContainer" style="max-height: 600px; overflow-y: auto;">
          <!-- Dynamic content will load here -->
        </div>
      </div>
    </div>

   
    <div class="col-xl-3 col-lg-4 col-md-12 mb-3">
  <div class="card  shadow-sm">
    <div class="card-header p-2">
          <input type="text" id="modelsSearch" class="form-control" placeholder="Type to search models...">
        </div>
        
        <div class="card-body p-0 " style="max-height: 600px; overflow-y: auto;">
          <div class="table-responsive">
            <table id="modelsTable" class="table mb-0 w-100">
              <thead >
                <tr>
                  <th>Vehicle Models</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
  </div>
</div>


   <div class="col-xl-6 col-lg-4 col-md-12 col-12 mb-3">
  <div class="card  shadow-sm">

    <!-- Header -->
    <div class="card-header p-2">
        <div class="input-group">
            <input type="text" id="vehicleSearch" class="form-control" 
                   placeholder="Type to search vehicles by number...">
            <button class="btn btn-primary" type="button" id="vehicleSearchBtn">
                <i class="ri ri-search-line"></i> 
            </button>
        </div>
        <input type="hidden" id="hid_model_id" value="0" >
    </div>

    <!-- Body -->
    <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
    <div class="row mb-3" id="SearchvehicleAvailabilityBar" style="display:none">
            <div class="col-12">
        <div class="alert alert-primary d-flex align-items-center mb-0">
            <i class="ri ri-bar-chart-box-line me-2 fs-5"></i>
            <div id="SearchvehicleAvailabilityContent"></div>
        </div>
    </div>
      </div>
      <div class="row g-2" id="vehicleContainer">

      

      </div>

    </div>

  </div>
</div>


  </div>