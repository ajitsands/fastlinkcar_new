<div class="modal fade" id="vehicleDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content border-0">

      <!-- Header -->
      <div class="modal-header custom-modal-header">
        <h5 class="modal-title mb-0">Vehicle Information</h5>
        <button type="button" class="btn-close " data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-3 ">

        <!-- Card Wrapper -->
        <div class="card shadow-sm border-0">
            <input type="hidden" id="hid_vehicle_id_info_modal" >
          <!-- Optional Card Header (Vehicle Summary) -->
          <div class="card-header bg-white border-bottom">
            <div class="d-flex align-items-center gap-3">
              <img id="vehicleImageModal" src="" 
                   class="rounded-circle border" 
                   style="width:60px;height:60px;object-fit:cover;">
              
              <div>
                <div class="fw-bold" id="div_common_car_number"></div>
                <div class="text-muted small" id="div_common_car_name"></div>
              </div>

              <div id="div_modal_status" class="ms-auto"></div>
            </div>
          </div>

          <!-- Tabs -->
          <div class="nav-align-top">

            <ul class="nav nav-pills mb-1" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-info">
                  Vehicle Info
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-passing">
                  Passing
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-insurance">
                  Insurance
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-maintenance">
                  Maintenance
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-booking">
                  Booking
                </button>
              </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
              
              
              <div class="tab-pane fade show active" id="tab-info">

                <?php include('vehicle_basicinfo.php'); ?>

             </div>

              <div class="tab-pane fade" id="tab-passing">
               <?php include('vehicle_passing_info.php'); ?>
              </div>

              <div class="tab-pane fade" id="tab-insurance">
                <?php include('vehicle_insurance_info.php'); ?>
              </div>

              <div class="tab-pane fade" id="tab-maintenance">
                <?php include('vehicle_maintenance_info.php'); ?>
              </div>

              <div class="tab-pane fade" id="tab-booking">
                 <?php include('vehicle_booking_info.php'); ?>
              </div>

            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</div>