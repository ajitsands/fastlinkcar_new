<style>
    .table tbody td {
        padding: 4px 6px !important;
        vertical-align: middle;
        font-size: 12.5px;
    }
</style>
<form id="UserDetailsForm" name="UserDetailsForm">

    <div class="layout-demo-wrapper mt-0">
        <div class="container-fluid flex-grow-1 pt-0 pb-1">

            <!-- Add User -->
           

            <div class="row">
                <!-- First column-->
                <div class="col-12">
                    <!-- User Information -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Manage Users</h5>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="editUserId">

                            <div class="row">

                                <!-- LEFT COLUMN: Inputs (wider) -->
                                <div class="col-11">

                                    <div class="row">

                                        <!-- Name + Username -->
                                        <div class="col-3">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="text" class="form-control" id="userProfileName" placeholder="Name">
                                                <label for="userProfileName">Name</label>
                                            </div>
                                            <div class="form-floating form-floating-outline mb-3 mt-2">
                                                <input type="text" class="form-control" id="userName" placeholder="Username">
                                                <label for="userName">Username</label>
                                            </div>
                                        </div>

                                        <!-- Role + Password -->
                                        <div class="col-3">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <select id="select2Basic" class="select2 form-select" data-placeholder="Select Role">
                                                    <option value="" disabled selected>Select Role</option>
                                                </select>
                                                <label for="select2Basic">Role</label>
                                            </div>
                                            <div class="form-floating form-floating-outline mb-3 mt-2">
                                                <input type="password" class="form-control" id="userPassword" placeholder="Password">
                                                <label for="userPassword">Password</label>
                                            </div>
                                        </div>

                                        <!-- Email + Company -->
                                        <div class="col-3">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="email" class="form-control" id="userEmail" placeholder="Email">
                                                <label for="userEmail">Email</label>
                                            </div>
                                            <div class="form-floating form-floating-outline mb-3 mt-2">
                                                <select id="select2Multiple" class="select2 form-select" data-placeholder="Select Company" multiple>
                                                    <option value="" disabled selected>Select Company</option>
                                                </select>
                                                <label>Company Access</label>
                                            </div>
                                        </div>

                                        <!-- Phone + File -->
                                        <div class="col-3">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="tel" class="form-control" id="userPhoneNumber" placeholder="Phone">
                                                <label for="userPhoneNumber">Phone</label>
                                            </div>
                                            <div class="form-floating form-floating-outline mb-3 mt-2">
                                                <input type="file" class="form-control form-control-sm" id="userImages">
                                                <input type="hidden" id="uploadedImageName">
                                                <label>Profile Image</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- RIGHT COLUMN: Smaller Preview -->
                                <div class="col d-flex align-items-start justify-content-center">
                                    <div id="imagePreview" style="width:70px; height:70px; border:1px solid #ccc; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-top:20px; overflow:hidden;">
                                        <img id="previewImg" src="assets/img/users/default.jpg" alt="Preview" style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </div>

                            </div>

                            <!-- Buttons -->
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-secondary ms-2" id="clearUserData"><i class="menu-icon icon-base ri ri-delete-back-2-line"></i>Clear</button>
                                <button type="submit" class="btn btn-primary" id="saveUserData"><i class="menu-icon icon-base ri ri-save-2-fill"></i> Save User</button>
                                <button type="submit" class="btn btn-primary" id="updateUserData" style="display:none;"><i class="menu-icon icon-base ri ri-file-edit-line"></i>Update User</button>
                            </div>
                        </div>
                    </div>
                    <!-- /User Information -->
                </div>
                <!-- /Second column -->
                <!-- Second column -->
                <div class="col-12">
                    <div class="card mb-6">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <h5 class="card-title mb-0">List of Users</h5>

                            <!-- Custom Search -->
                            <div class="d-flex" style="gap:8px; width:300px;">
                                <input type="text" id="searchUser" class="form-control form-control-sm" placeholder="Search users...">

                                <!-- <button class="btn btn-primary btn-sm" id="searchBtn">
                                    <i class="menu-icon icon-base ri ri-search-line"></i>
                                </button> -->
                            </div>

                        </div>

                        <div class="card-body">

                            <div class="card-datatable table-responsive">
                                <table class="datatables-products table" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- /Second column -->
            </div>
        </div>

    </div>

    <!--  Reset password modal -->
    <!-- <div class="mt-4">
        <div class="modal fade" id="resetPasswordModal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="resetUserId">
                        <div class="row">
                            <div class="col mb-6 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="newPassword" class="form-control" placeholder="Enter Name">
                                    <label for="nameWithTitle">New Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" id="emailWithTitle" class="form-control" placeholder="xxxx@xxx.xx">
                                    <label for="emailWithTitle">Email</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary waves-effect waves-light">Update Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Reset password modal end -->


    <script>
        // $(document).ready(function() {

        //     loadRoles();

        // });
    </script>

</form>