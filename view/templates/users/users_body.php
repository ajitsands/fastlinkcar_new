<style>
    .table tbody td {
        padding: 6px 8px !important;
        vertical-align: middle;
        font-size: 13px;
    }
    #userTable tbody tr,
    #userTable tbody tr td {
        cursor: pointer;
        outline: none !important;
        box-shadow: none !important;
    }
    #userTable tbody tr:focus,
    #userTable tbody tr:active,
    #userTable tbody tr:focus-visible,
    #userTable tbody tr td:focus,
    #userTable tbody tr td:active {
        outline: none !important;
        box-shadow: none !important;
    }
    /* Selected row and all child cells in ALL states (normal, hover, active, striped) */
    #userTable tbody tr.selected,
    #userTable tbody tr.selected > td,
    #userTable tbody tr.selected > th,
    #userTable tbody tr.selected:hover,
    #userTable tbody tr.selected:hover > td,
    #userTable tbody tr.selected:hover > th,
    #userTable.dataTable tbody tr.selected,
    #userTable.dataTable tbody tr.selected > *,
    #userTable.dataTable tbody tr.selected:hover,
    #userTable.dataTable tbody tr.selected:hover > *,
    #userTable.dataTable.table-hover tbody tr.selected:hover,
    #userTable.dataTable.table-hover tbody tr.selected:hover > *,
    #userTable.dataTable.table-striped tbody tr.selected,
    #userTable.dataTable.table-striped tbody tr.selected > *,
    #userTable.dataTable.table-striped tbody tr.selected:hover,
    #userTable.dataTable.table-striped tbody tr.selected:hover > *,
    #userTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected,
    #userTable.dataTable.table-striped > tbody > tr:nth-of-type(odd).selected > * {
        background-color: #F87C63 !important;
        color: #ffffff !important;
        box-shadow: none !important;
        outline: none !important;
    }
    /* Unselected row hover state */
    #userTable tbody tr:not(.selected):hover,
    #userTable tbody tr:not(.selected):hover > td,
    #userTable tbody tr:not(.selected):hover > th,
    #userTable.dataTable tbody tr:not(.selected):hover > *,
    #userTable.dataTable.table-hover tbody tr:not(.selected):hover > * {
        background-color: rgba(248, 124, 99, 0.15) !important;
        color: inherit !important;
    }

    /* Responsive spacing & layout adjustments */
    @media (max-width: 991.98px) {
        .container-p-y {
            padding-top: 15px !important;
        }
        .action-buttons-wrapper {
            flex-direction: column;
            align-items: stretch !important;
        }
        .action-buttons-wrapper > button,
        .action-buttons-wrapper > div {
            width: 100%;
        }
        .action-buttons-wrapper > div > button {
            flex: 1;
        }
    }
    @media (min-width: 992px) {
        .container-p-y {
            padding-top: 55px !important;
        }
    }
</style>

<form id="UserDetailsForm" name="UserDetailsForm">
    <input type="hidden" id="editUserId">

    <div class="container-fluid flex-grow-1 pt-0 pb-1">
        <div class="row">
            <!-- Left Column: User Form -->
            <div class="col-12 col-lg-8 mb-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="ri-user-add-line me-2 text-primary"></i>User Registration Details
                        </h5>
                        <div id="userStatusBadgeContainer">
                            <span class="badge bg-label-success" id="userStatusBadge">New Entry</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-3">
                            <!-- Form Controls Column -->
                            <div class="col-12 col-md-9">
                                <div class="row g-3">
                                    <!-- Name -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <input type="text" class="form-control" id="userProfileName" placeholder="Name" required>
                                            <label for="userProfileName">Full Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <!-- Role -->
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-center gap-1">
                                            <div class="form-floating form-floating-outline mb-2 flex-grow-1">
                                                <select id="select2Basic" class="select2 form-select" data-placeholder="Select Role" multiple required>
                                                </select>
                                                <label for="select2Basic">Role <span class="text-danger">*</span></label>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary mb-2 px-2" id="btnOpenRoleModal" data-permission="users_manage" title="Create / Configure Role Permissions">
                                                <i class="ri-add-line me-1"></i> Roles
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Username -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <input type="text" class="form-control" id="userName" placeholder="Username" required>
                                            <label for="userName">Username <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <input type="password" class="form-control" id="userPassword" placeholder="Password">
                                            <label for="userPassword">Password <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <input type="email" class="form-control" id="userEmail" placeholder="Email">
                                            <label for="userEmail">Email ID</label>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <input type="tel" class="form-control" id="userPhoneNumber" placeholder="Phone">
                                            <label for="userPhoneNumber">Phone Number</label>
                                        </div>
                                    </div>

                                    <!-- Company Access -->
                                    <div class="col-12 col-md-12">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <select id="select2Multiple" class="select2 form-select" data-placeholder="Select Company" multiple>
                                            </select>
                                            <label for="select2Multiple">Company Access</label>
                                        </div>
                                    </div>

                                    <!-- Profile Image Upload -->
                                    <div class="col-12 col-md-12">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <input type="file" class="form-control form-control-sm" id="userImages" accept="image/*">
                                            <input type="hidden" id="uploadedImageName">
                                            <label for="userImages">Profile Image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Avatar Preview Column -->
                            <div class="col-12 col-md-3 d-flex flex-column align-items-center justify-content-center">
                                <div id="imagePreview" 
                                     style="width:110px; height:110px; border:2px dashed #7367f0; border-radius:50%; 
                                            display:flex; align-items:center; justify-content:center; 
                                            overflow:hidden; background-color: #f8f9fa;">
                                    <img id="previewImg" 
                                         src="assets/img/users/default.jpg" 
                                         alt="Preview" 
                                         style="width:100%; height:100%; object-fit:cover;">
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Section -->
                        <div class="card border shadow-none mb-3 mt-3">
                            <div class="card-header bg-light py-2 px-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-shield-keyhole-line text-primary fs-5"></i>
                                    <h6 class="mb-0 fw-semibold">User Permissions Assignment</h6>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" id="searchPermissions" class="form-control form-control-sm" placeholder="Filter permissions..." style="width: 180px;">
                                </div>
                            </div>
                            <div class="card-body p-0" style="max-height: 320px; overflow-y: auto;">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover align-middle mb-0" id="permissionsTable">
                                        <thead class="table-light sticky-top" style="z-index: 1;">
                                            <tr>
                                                <th style="width: 50px;" class="text-center">#</th>
                                                <th>Module / Permission Name</th>
                                                <th style="width: 130px;" class="text-center">Group</th>
                                                <th style="width: 120px;" class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="permissionsTbody">
                                            <!-- Dynamically populated via JS -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons Footer -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3 pt-3 border-top action-buttons-wrapper">
                            <button type="button" class="btn btn-secondary" id="clearUserData">
                                <i class="ri-refresh-line me-1"></i> Reset / Clear
                            </button>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-info d-none" id="resetUserPasswordBtn" data-permission="users_manage">
                                    <i class="ri-key-2-line me-1"></i> Reset Password
                                </button>
                                <button type="button" class="btn btn-warning d-none" id="toggleUserStatusBtn" data-permission="users_manage">
                                    <i class="ri-toggle-line me-1"></i> Deactivate
                                </button>
                                <button type="submit" class="btn btn-primary" id="saveUserData" data-permission="users_manage">
                                    <i class="ri-save-2-fill me-1"></i> Save User
                                </button>
                                <button type="submit" class="btn btn-primary" id="updateUserData" data-permission="users_manage" style="display:none;">
                                    <i class="ri-file-edit-line me-1"></i> Update User
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: User List Table -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header p-2">
                        <input type="text" id="searchUser" class="form-control" placeholder="Type to search users...">
                    </div>

                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle" id="userTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated via DataTables AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>