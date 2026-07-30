            <div class="container-fluid flex-grow-1 container-p-y">
             
              <div class="row g-3">

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Total Vehicles</h6>
                        <h4><span id="tot_veh_count"></span></h4>
                    </div>
                    <i class="ri ri-car-line text-primary kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Available</h6>
                        <h4 class="text-success"><span id="avail_veh_count"></span></h4>
                    </div>
                    <i class="ri ri-check-line text-success kpi-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Parking</h6>
                        <h4 class="text-info"><span id="park_veh_count"></span></h4>
                    </div>
                    <i class="ri ri-parking-line text-info kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Rented</h6>
                        <h4 class="text-danger"><span id="rent_veh_count"></span></h4>
                    </div>
                    <i class="ri ri-key-line text-danger kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Maintenance</h6>
                        <h4 class="text-warning"><span id="maint_veh_count"></span></h4>
                    </div>
                    <i class="ri ri-tools-line text-warning kpi-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-box p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>Blocked</h6>
                        <h4 class="text-danger"><span id="block_veh_count"></span></h4>
                    </div>
                    <i class="ri ri-forbid-line text-danger kpi-icon"></i>
                </div>
            </div>
        </div>

        

    </div>


    <!-- ================= SECOND ROW ================= -->
    <div class="row mt-4 g-3">

        <!-- ALERTS -->
        <div class="col-md-4">

    <div class="card p-3 card-box">

             <h6 class="mb-3">
                Alerts & Notifications
                <span class="badge bg-danger" id="alertCount">0</span>
            </h6>
            
            <div id="alertsContainer" style="max-height: 420px; overflow-y: auto;"></div>

        <!-- Calendar Button INSIDE CARD -->
        <button class="btn btn-primary w-100 mt-2" id="openCalendarBtn">
            <i class="ri ri-calendar-line me-1"></i>
            Open Calendar
        </button>

    </div>

</div>


        <div class="col-md-8">
    <div class="card card-box p-3">

       <h6 class="d-flex justify-content-between align-items-center">
            <span>Expected Return Due</span>
        
            <i class="ri ri-calendar-line fs-4 text-danger"
               style="cursor:pointer;"
               title="Return Calendar"
               data-bs-toggle="tooltip"
               data-bs-placement="top" id="openReturnCalendarBtn"></i>
        </h6>
        <table id="vehicleTable" class="table table-sm align-middle">
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Customer</th>
                    <th>Agreement</th>
                    <th>Start Date</th>
                    <th>Expected Return</th>
                    <th>Days Left</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
     
    </div>
</div>

    </div>
            </div>