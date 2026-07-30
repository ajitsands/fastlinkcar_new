<div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 50px !important;">
 <h4 class="fw-bold py-3">Vehicle Insights</h4>
          
         
  <!-- Nav Tabs -->
  <div class="row mb-1 ">
  
         <div class="nav-align-top ">
             <ul class="nav nav-tabs nav-fill" role="tablist">
                          <li class="nav-item">
                            <button
                              type="button"
                              class="nav-link active"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-home"
                              aria-controls="navs-justified-home"
                              aria-selected="true">
                              <span class="d-none d-sm-inline-flex align-items-center">
                                <i class="icon-base ri ri-search-line icon-sm me-2"></i>Search Vehicle
                                
                              
                            </button>
                          </li>
                          <li class="nav-item li_Vehicle_list" data-status="All">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-profile"
                              aria-controls="navs-justified-profile"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-apps-2-line icon-sm me-2"></i>All Vehicles</span
                              >
                             
                            </button>
                          </li>
                          <li class="nav-item li_Vehicle_list" data-status="Available">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-available"
                              aria-controls="navs-justified-messages"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-car-line icon-sm me-2"></i>Available Vehicles</span
                              >
                             
                            </button>
                          </li>
                          <li class="nav-item li_Vehicle_list" data-status="Parking">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-parking"
                              aria-controls="navs-justified-messages"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-parking-box-line icon-sm me-2"></i>Parking Vehicles</span
                              >
                             
                            </button>
                          </li>
                           <li class="nav-item li_Vehicle_list" data-status="Staffuse">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-staffuse"
                              aria-controls="navs-justified-messages"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-user-star-line icon-sm me-2"></i>Staff Use Vehicles</span
                              >
                             
                            </button>
                          </li>
                          <li class="nav-item li_Vehicle_list" data-status="Rentout">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-rentout"
                              aria-controls="navs-justified-messages"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-route-line icon-sm me-2"></i>Rentout Vehicles</span
                              >
                             
                            </button>
                          </li>
                          <li class="nav-item li_Vehicle_list" data-status="Maintenance">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-maintenance"
                              aria-controls="navs-justified-messages"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-tools-line icon-sm me-2"></i>Maintenance Vehicles</span
                              >
                             
                            </button>
                          </li>
                          <li class="nav-item li_Vehicle_list" data-status="Blocked">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-blocked"
                              aria-controls="navs-justified-messages"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-prohibited-line icon-sm me-2"></i>Blocked Vehicles</span
                              >
                             
                            </button>
                          </li>
                        </ul>
             <div class="tab-content">
                          <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                            <?php include("vehicleinsight_searchtab.php");?>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                           <?php include("vehicleinsight_allvehicles.php");?>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-available" role="tabpanel">
                            <?php include("vehicleinsight_availablevehicles.php");?>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-parking" role="tabpanel">
                            <?php include("vehicleinsight_parkingvehicles.php");?>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-staffuse" role="tabpanel">
                            <?php include("vehicleinsight_staffusevehicles.php");?>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-rentout" role="tabpanel">
                            <?php include("vehicleinsight_rentoutvehicles.php");?>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-maintenance" role="tabpanel">
                            <?php include("vehicleinsight_maintenancevehicles.php");?>
                          </div>
                           <div class="tab-pane fade" id="navs-justified-blocked" role="tabpanel">
                            <?php include("vehicleinsight_blockedvehicles.php");?>
                          </div>
                        </div>
        </div>
     
   
   
  </div>

  <!-- Main Content Row -->
  <!-- End Main Row -->

</div>


