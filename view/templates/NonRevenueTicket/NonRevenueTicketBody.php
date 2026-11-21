<div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 20px !important;">
          
         
  <!-- Nav Tabs -->
  <div class="row mb-1 ">
  
         <div class="nav-align-top ">
             <ul class="nav nav-tabs nav-fill" role="tablist">
                        
                          
                          <li class="nav-item li_Vehicle_list " data-status="Available">
                            <button
                              type="button"
                               class="nav-link active"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-available"
                              aria-controls="navs-justified-messages"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-car-line icon-sm me-2"></i>Allocate Vehicles</span
                              >
                             
                            </button>
                          </li>
                          <li class="nav-item li_Vehicle_list" data-status="List">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-parking"
                              aria-controls="navs-justified-messages"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-parking-box-line icon-sm me-2"></i>Staff Use Vehicle List / Return Vehicle</span
                              >
                             
                            </button>
                          </li>
                          
                        </ul>
             <div class="tab-content">
                         
                          <div class="tab-pane fade show active" id="navs-justified-available" role="tabpanel">
                            <?php include("nonrevenueticket_availablevehicles.php");?>
                          </div>
                          <div class="tab-pane fade" id="navs-justified-parking" role="tabpanel">
                            <?php include("nonrevenueticket_parkingvehicles.php");?>
                          </div>
                        
                        </div>
        </div>
     
   
   
  </div>

  <!-- Main Content Row -->
  <!-- End Main Row -->

</div>


