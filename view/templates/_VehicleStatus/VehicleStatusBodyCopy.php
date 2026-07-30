<div class="container-fluid px-0 flex-grow-1 container-p-y">

  <!-- Nav Tabs -->
  <div class="row">
    <div class="col-12">
      <div class="nav-align-top">
        <ul class="nav nav-pills flex-column flex-sm-row mb-6 row-gap-2">
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="pages-profile-user.html">Available</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active waves-effect waves-light" href="javascript:void(0);">Rent Out</a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="pages-profile-projects.html">On Parking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="pages-profile-connections.html">On Maintenance</a>
          </li>
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="pages-profile-connections.html">Blocked</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Main Content Row -->
  <div class="row g-6">

    <!-- Column 1: Car Categories -->
    <div class="col-xl-3 col-lg-4 col-md-12">
      <div class="card h-100 shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Car Categories</h5>
          <input type="text" id="searchTree" class="form-control form-control-sm" placeholder="Search..." style="max-width:150px;">
        </div>
        <div class="card-body" id="treeContainer">
         <ul class="list-group">
    <!-- Category: Small Cars -->
    <li class="list-group-item" >
      <div class="d-flex align-items-center">
        <div class="avatar avatar-md me-2">
          <img src="httpdocs/images/vehicle_category_images/small_car.jpg" alt="Small Cars" class="rounded-circle">
        </div>
        <span class="fw-bold">SMALL CARS</span>
        <span class="badge bg-primary ms-auto">24</span>
      </div>
      <ul class="list-group mt-2 ms-4">
        <li class="list-group-item d-flex justify-content-between align-items-center" data-brand="Toyota">Toyota <span class="badge bg-warning ms-auto">8</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center" data-brand="Honda">Honda <span class="badge bg-warning ms-auto">5</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center" data-brand="Hyundai">Hyundai <span class="badge bg-warning ms-auto">6</span></li>
      </ul>
    </li>

    <!-- Category: Medium Cars -->
    <li class="list-group-item mt-2" >
      <div class="d-flex align-items-center">
        <div class="avatar avatar-md me-2">
          <img src="httpdocs/images/vehicle_category_images/medium_car.jpg" alt="Medium Cars" class="rounded-circle">
        </div>
        <span class="fw-bold">MEDIUM CARS</span>
      </div>
      <ul class="list-group mt-2 ms-4">
        <li class="list-group-item d-flex justify-content-between align-items-center" data-brand="BMW">BMW <span class="badge bg-warning ms-auto">6</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center" data-brand="Audi">Audi <span class="badge bg-warning ms-auto">2</span></li>
      </ul>
    </li>
  </ul>
        </div>
      </div>
    </div>

    <!-- Column 2: Car Models -->
    <div class="col-xl-3 col-lg-4 col-md-12">
      <div class="card h-100 shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">Car Models</h5>
        </div>
        <div class="card-body">
          <table id="modelsTable" class="table table-striped table-bordered w-100">
              <thead>
                <tr>
                  <th>Brand</th>
                  <th>Model</th>
                </tr>
              </thead>
              <tbody>
                 <tr data-brand="Toyota" ><td>Toyota</td><td>Corolla</td></tr>
    <tr data-brand="Toyota" ><td>Toyota</td><td>Camry</td></tr>
    <tr data-brand="Honda" ><td>Honda</td><td>Civic</td></tr>
    <tr data-brand="Hyundai" ><td>Hyundai</td><td>Elantra</td></tr>
    <tr data-brand="BMW" ><td>BMW</td><td>3 Series</td></tr>
    <tr data-brand="Audi" ><td>Audi</td><td>A4</td></tr>
              </tbody>
            </table>
        </div>
      </div>
    </div>

    <!-- Column 3: Vehicle List -->
    <div class="col-xl-6 col-lg-4 col-md-12">
      <div class="card h-100 shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">List of Vehicles</h5>
        </div>
        <div class="card-body">
          <table id="vehicleListTable" class="table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th>Sn</th>
                <th>Reg #</th>
                <th>Model</th>
                <th>Gear</th>
                <th>Fuel</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>

  </div> <!-- End Main Row -->

</div>