<div class="container-fluid flex-grow-1" style="padding-top: 6px !important;">
 <div class="d-flex justify-content-end align-items-center py-1 mb-1">
    <div class="d-flex align-items-center">
        <label for="filterCompany" class="form-label mb-0 me-2 fw-bold text-nowrap">Company:</label>
        <select id="filterCompany" class="form-select form-select-sm" style="width: 250px;">
            <option value="All">All</option>
            <?php
            if (!empty($_SESSION['company_json'])) {
                $cData = json_decode($_SESSION['company_json'], true);
                if (is_array($cData)) {
                    foreach ($cData as $c) {
                        echo '<option value="' . htmlspecialchars($c['ids']) . '">' . htmlspecialchars($c['company_name']) . '</option>';
                    }
                }
            }
            ?>
        </select>
        <button id="btnPrint" class="btn btn-sm btn-outline-primary ms-2" onclick="downloadPDF()">
            <i class="ri-file-pdf-line me-1"></i> Export Pdf
        </button>
    </div>
 </div>
          
         
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
                          <li class="nav-item li_Vehicle_list" data-status="Sold">
                            <button
                              type="button"
                              class="nav-link"
                              role="tab"
                              data-bs-toggle="tab"
                              data-bs-target="#navs-justified-sold"
                              aria-controls="navs-justified-sold"
                              aria-selected="false">
                              <span class="d-none d-sm-inline-flex align-items-center"
                                ><i class="icon-base ri ri-price-tag-3-line icon-sm me-2"></i>Sold Vehicles</span
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
                          <div class="tab-pane fade" id="navs-justified-sold" role="tabpanel">
                            <?php include("vehicleinsight_soldvehicles.php");?>
                          </div>
                        </div>
        </div>
     
   
   
  </div>

  <!-- Main Content Row -->
  <!-- End Main Row -->

</div>


