<form id="VehicleDetailsForm" name="VehicleDetailsForm">

    <div class="layout-demo-wrapper mt-0">

        <div class="container-fluid flex-grow-1 container-p-y">

            <!-- Add User -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Add a New User</h4>
                    <p class="mb-0">You can add more user here</p>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <!--<button class="btn btn-outline-secondary waves-effect">Discard</button>-->

                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="refreshUserData" onclick="location.reload();"><i class="menu-icon icon-base ri ri-refresh-line"></i> Refresh</button>
                </div>
            </div>

            <div class="row">
                <!-- First column-->
                <div class="col-12 col-lg-6">
                    <!-- User Information -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">User Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="profileName" placeholder="Name" name="profileName">
                                        <label for="profileName">Name</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="select2Basic" class="select2 form-select" data-allow-clear="true" data-placeholder="Select Role">
                                            <!-- <select id="select2Basic" class="form-select form-select-sm" data-allow-clear="true" data-placeholder="Select Role"> -->
                                            <option value="" disable>Select Role</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                        </select>
                                        <label for="select2Basic" class="form-label">User Role</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row gx-5 mb-5">
                                <div class="col">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="userName" placeholder="User Name" name="userName" aria-label="User Name">
                                        <label for="userName">User Name</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="userPassword" placeholder="Password" name="userPassword" aria-label="User Password">
                                        <label for="userPassword">User Password</label>
                                    </div>
                                </div>
                                <!-- <div class="col">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control" id="vehiclePurchaseDate" placeholder="dd-mm-yyyy" name="vehiclePurchaseDate" aria-label="Product barcode">
                                        <label for="vehiclePurchaseDate">Purchase Date</label>
                                    </div>
                                </div> -->
                            </div>
                            <!-- Multiple -->
                            <div class="form-floating form-floating-outline">
                                <select id="select2Multiple" class="select2 form-select" data-placeholder="Select Companies" multiple>

                                    <option value="AA Car Rental">AA Car Rental</option>
                                    <option value="Class Rental car">Class Rental car</option>

                                </select>
                                <label for="select2Multiple" class="form-label">Company Name</label>
                            </div>
                        </div>
                    </div>
                    <!-- /User Information -->
                    <!-- Media -->
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">User Image</h5>
                            <a href="javascript:void(0);" class="fw-medium">Max upto 10 Numbers</a>
                        </div>
                        <div class="card-body">
                            <!--<form action="/upload" class="dropzone needsclick dz-clickable" id="dropzone-basic">-->
                            <!--  <div class="dz-message needsclick my-12">-->
                            <!--    <div class="d-flex justify-content-center">-->
                            <!--      <div class="avatar">-->
                            <!--        <span class="avatar-initial rounded-3 bg-label-secondary">-->
                            <!--          <i class="icon-base ri ri-upload-2-line icon-24px"></i>-->
                            <!--        </span>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--    <p class="h4 needsclick my-2">Drag and drop your image here</p>-->
                            <!--    <small class="note text-body-secondary d-block fs-6 my-2">or</small>-->
                            <!--    <span class="needsclick btn btn-sm btn-outline-primary waves-effect" id="btnBrowse">Browse image</span>-->
                            <!--  </div>-->

                            <!--</form>-->


                            <div class="d-flex align-items-center">
                                <input class="form-control form-control-sm" type="file" id="userImages" multiple>
                                <div class="ms-auto">
                                    <div class="d-flex align-items-center">
                                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 " id="imagePreview">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="refreshUserData"> Add User</button>
                            </div>

                        </div>


                    </div>
                    <!-- /Media -->


                </div>
                <!-- /Second column -->

                <!-- Second column -->
                <div class="col-12 col-lg-6">
                    <!-- Pricing Card -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-title mb-0"> List of Users</h5>
                        </div>
                        <div class="card-body">
                            <!-- <div class="card-header border-bottom">
                                <h5 class="card-title mb-4">Filter</h5>
                                <div class="d-flex justify-content-between align-items-center row gap-5 gx-6 gap-md-0">
                                    <div class="col-md-4 product_status"></div>
                                    <div class="col-md-4 product_category"></div>
                                    <div class="col-md-4 product_stock"></div>
                                </div>
                            </div> -->
                            <div class="card-datatable table-responsive">
                                <table class="datatables-products table" id="vehicleTable">
                                    <thead>
                                        <tr>

                                            <th>Image</th>
                                            <th>Vehicle</th>
                                            <th>Number</th>
                                            <th>Model</th>
                                            <th>Category</th>
                                            <th>Fuel</th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Pricing Card -->

                </div>
                <!-- /Second column -->
            </div>
        </div>

    </div>


</form>