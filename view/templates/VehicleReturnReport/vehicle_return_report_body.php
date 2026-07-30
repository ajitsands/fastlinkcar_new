 <div class="container-fluid flex-grow-1 container-p-y">
             
              <!-- Product List Table -->
              <div class="card">
                <div class="card-header border-bottom">
                  <h5 class="card-title mb-4">Vehicle Expected Return Report</h5>
                 <div class="row align-items-end g-2">

    <!-- Date -->
    <div class="col-md-2">
        <div class="form-floating form-floating-outline">
            <input class="form-control form-control-sm"
                   id="filter_from_date"
                   name="filter_from_date"
                   type="date"
                   placeholder="dd-mm-yyyy">
            <label for="filter_from_date">From Date</label>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-floating form-floating-outline">
            <input class="form-control form-control-sm"
                   id="filter_to_date"
                   name="filter_to_date"
                   type="date"
                   placeholder="dd-mm-yyyy">
            <label for="filter_from_date">To Date</label>
        </div>
    </div>
    <!-- Dropdown -->
    <div class="col-md-4">
        <div class="form-floating form-floating-outline">
        <div id="dropdownContaineravail" class=" w-100">
         <label for="vehicleModelLbl">Select Vehicle Model</label>
        </div>
        </div>
    </div>

    <!-- Search Button -->
    <div class="col-md-1">
        <button class="btn btn-primary w-100 rounded-pill" id="btnSearch">
    <i class="ri ri-search-line me-1"></i> Search
</button>
    </div>
     <div class="col-md-2">
        <button class="btn btn-primary w-100 rounded-pill" id="openReturnCalendarBtn">
            <i class="ri ri-calendar-line me-1"></i>
            Open Vehicle Return Calendar
        </button>
         </div>
</div>
                </div>
                <div class="row g-3 vehicle-section" id="Alldivsearch" >

   


   <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-1">
  <div class="card  shadow-sm">

    <!-- Header -->
    <div class="card-header p-2">
        <div class="input-group">
            <input type="text" id="AllvehicleSearch" class="form-control vehicle_search_txt" data-status="All" 
                   placeholder="Type to search vehicles by number...">
            
        </div>
        
    </div>

    <!-- Body -->
    <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
      <div class="row mb-3" id="AllvehicleAvailabilityBar">
            <div class="col-12">
        <div class="alert alert-primary d-flex align-items-center mb-0">
            <i class="ri ri-bar-chart-box-line me-2 fs-5"></i>
            <div id="AllvehicleAvailabilityContent"></div>
        </div>
    </div>
      </div>
      <div class="row g-2" id="AllvehicleContainer">
                                  
      

      </div>

    </div>

  </div>
</div>


  </div>
              </div>
             
               
                  
             
            </div>