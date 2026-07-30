<div class="container-fluid">

    <div class="row">

        <!-- Profile Information -->
        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">My Profile</h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        <!-- Profile Image -->
                      <div class="col-md-3 text-center">

    <div class="mb-3">
        <label for="profileImage" style="cursor:pointer;">
             <div id="imagePreview" 
             style="width:90px; height:90px; border:1px solid #ccc; border-radius:50%; 
                    display:flex; align-items:center; justify-content:center; 
                    margin-top:20px; overflow:hidden;">
            <img id="previewImg"
                 src="assets/img/users/default.jpg"
                 class="rounded-circle"
                 style="width:120px;height:120px;object-fit:cover;border:1px solid #ddd;">
                 </div>
        </label>
    </div>

    <input type="file"
           id="userImages"
           class="form-control form-control-sm"
           accept="image/*">
            <input type="hidden" id="uploadedImageName">

</div>


                        <!-- User Details -->
                      <div class="col-md-9">

    <div class="row">
<input type="hidden" id="hid_user_id">
        <!-- Name -->
        <div class="col-md-6">
            <div class="form-floating form-floating-outline mb-3">
                <input type="text" 
                       class="form-control"
                       id="profileName"
                       placeholder="Name">
                <label>Name</label>
            </div>
        </div>


        <!-- Username (Read Only) -->
        <div class="col-md-6">
            <div class="form-floating form-floating-outline mb-3">
                <input type="text" 
                       class="form-control"
                       id="profileUsername"
                       readonly>
                <label>Username</label>
            </div>
        </div>
 


        <!-- Email -->
        <div class="col-md-6">
            <div class="form-floating form-floating-outline mb-3">
                <input type="email" 
                       class="form-control"
                       id="profileEmail"
                       placeholder="Email">
                <label>Email</label>
            </div>
        </div>

 <!-- Role (Read Only) -->
        <div class="col-md-6">
            <div class="form-floating form-floating-outline mb-3">
                <input type="text" 
                       class="form-control"
                       id="profileRole"
                       readonly>
                <label>Role</label>
            </div>
        </div>
        <!-- Phone -->
        <div class="col-md-6">
            <div class="form-floating form-floating-outline mb-3">
                <input type="text" 
                       class="form-control"
                       id="profilePhone"
                       placeholder="Phone">
                <label>Phone</label>
            </div>
        </div>


      

    </div>

</div>


                    </div>


                    <div class="text-end">
                        <button class="btn btn-primary" id="btn_update_profile">
                            <i class="ri-save-line me-1"></i>
                            Update Profile
                        </button>
                    </div>


                </div>

            </div>

        </div>



        <!-- Reset Password -->
        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">Reset Password</h5>
                </div>


                <div class="card-body">

<input type="hidden" id="hid_password">
                    <!-- Current Password -->
                    <div class="form-floating form-floating-outline mb-3">

                        <input type="password"
                               class="form-control"
                               id="currentPassword"
                               placeholder="Current Password">

                        <label>Current Password</label>

                    </div>



                    <!-- New Password -->
                    <div class="form-floating form-floating-outline mb-3">

                        <input type="password"
                               class="form-control"
                               id="newPassword"
                               placeholder="New Password">

                        <label>New Password</label>

                    </div>



                    <!-- Confirm Password -->
                    <div class="form-floating form-floating-outline mb-3">

                        <input type="password"
                               class="form-control"
                               id="confirmPassword"
                               placeholder="Confirm Password">

                        <label>Confirm Password</label>

                    </div>



                    <button class="btn btn-danger w-100" id="btn_change_password">
                        <i class="ri-lock-password-line me-1"></i>
                        Change Password
                    </button>


                </div>

            </div>

        </div>


    </div>

</div>