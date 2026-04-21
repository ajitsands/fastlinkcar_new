<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="../assets/"
  data-template="horizontal-menu-template-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>AA Car Rental</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />

    <script src="../assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <!-- Vendor -->
    <link rel="stylesheet" href="../assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

    <link rel="stylesheet" href="../assets/sands/sands_popup.css" />
    <link rel="stylesheet" href="alertmessage/css/sands_alert_style.css">
    
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="../assets/js/config.js"></script>
    
    

    
    
	<style>
		.app-logo {
		  transition: opacity 0.3s ease;
		}
	</style>
  </head>

  <body>
          <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
    <!-- SaNDS Popup -->
    <div id="dropdownContent" style="text-align:center;"></div>    
    <!-- Content -->

    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
        <div class="authentication-inner py-6">
          <!-- Login -->
          <div class="card p-md-7 p-1">
            <!-- Logo -->
            <div class="app-brand justify-content-center mt-5">
              <img src="../assets/img/logo/logo.png" id="companyLogo" class="img-fluid app-logo" alt="Logo">
            </div>
            <!-- /Logo -->

            <div class="card-body mt-1">
			
              <form id="formAuthentication" class="mb-5" action="/Home?val=<?php echo $this->encryption->encrypt('1,1-1');?>" method="GET">
			  
				<div class="form-floating form-floating-outline mb-6">
					<select class="form-select" id="selectCompanyDropDown" >
					  <option value="" selected disabled>Choose Company</option>
					  <option value="1">AA Car Rental</option>
					  <option value="2">Class Rental Car</option>
					</select>
					<label for="selectCompanyDropDown">Choose Company</label>
				</div>
			  
			  
                <div class="form-floating form-floating-outline mb-5 form-control-validation">
                  <input
                    type="text"
                    class="form-control"
                    id="user_name"
                    name="user_name"
                    placeholder="Enter your username"
                    autofocus />
                  <label for="user_name">Username</label>
                </div>
                <div class="mb-5">
                  <div class="form-password-toggle form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input
                          type="text"
                          id="user_passkey"
                          class="form-control"
                          name="user_passkey"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="user_passkey" />
                        <label for="user_passkey">Password</label>
                      </div>
                      <span class="input-group-text cursor-pointer"
                        ><i class="icon-base ri ri-eye-off-line icon-20px"></i
                      ></span>
                    </div>
                  </div>
                </div>
                <div class="mb-5 d-flex justify-content-between mt-5">
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="remember-me"  />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                  <a href="auth-forgot-password-basic.html" class="float-end mb-1 mt-2">
                    <span>Forgot Password?</span>
                  </a>
                </div>
                <div class="mb-5">
                    <button type="button" class="btn btn-primary d-grid w-100" id="btn_login">Sign in</button>
                 
                </div>
                <div class="mb-5">
                    <button type="button" class="btn btn-primary d-grid w-100" id="btn_CheckLogin">Sign in</button>
                 
                </div>
              </form>

             

              
            </div>
          </div>
          <!-- /Login -->
          <img
            alt="mask"
            src="../assets/img/illustrations/auth-basic-login-mask-light.png"
            class="authentication-image d-none d-lg-block"
            data-app-light-img="illustrations/auth-basic-login-mask-light.png"
            data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>

    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="../assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/libs/hammer/hammer.js"></script>

    <script src="../assets/vendor/libs/i18n/i18n.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="../assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->

    <script src="../assets/js/main.js"></script>
    
    
    <!-- Page JS -->
    <script src="../assets/sands/settings.js"></script>
    <script src="../assets/sands/sands_popup.js"></script>
    <script src="../alertmessage/js/sandsalert.js"></script>
    <script src="../assets/js/sands_auth.js"></script>
    <!--<script src="../assets/js/pages-auth.js"></script>-->
     <!--<script src="../httpdocs/user_js/login.js"></script>-->
	
	<script>
		const select = document.getElementById('selectCompanyDropDown');
		const logo = document.getElementById('companyLogo');

		select.addEventListener('change', function () {
			logo.style.opacity = 0;

			setTimeout(() => {
				const logoPath = (this.value === "2")
					? "../assets/img/logo/logo_classic.png"
					: "../assets/img/logo/logo.png";
				const logoPathSmall = (this.value === "2")
					? "../assets/img/logo/logo_classic_small.png"
					: "../assets/img/logo/logo_small.png";
			
				logo.src = logoPath;
				logo.style.opacity = 1;

				localStorage.setItem('selectedCompanyLogo', logoPathSmall);
				localStorage.setItem('selectedCompanyId', this.value);

			}, 200);
		});
		
		$('#btn_login').click(function(e){
		    e.preventDefault();
		       $.ajax({
                url: "/LoginController",
                type: "POST",
                data: { companyId: $('#selectCompanyDropDown').val(),userName : $('#user_name').val(),passWord : $('#user_passkey').val() ,action : 'Authenticate' },
                success: function(response) {
    
                    let res = JSON.parse(response);
    
                    if (res.status === true) {
                        localStorage.setItem('aacar_jwt_token', res.data);
                        setupDropdown('dropdownContent','success',svgSuccess+' Login Successfull','click');
                        // Reload DataTable
                       // $('#termsTable').DataTable().ajax.reload(null, false);
                    } else {
                       
                        setupDropdown('dropdownContent','error',svgSuccess+res.message,'click');
                    }
                }
            });
		})
		
	    $('#btn_CheckLogin').click(function(e){
            e.preventDefault();
        
            let formData = Object.fromEntries(
                new FormData(document.getElementById("formAuthentication")).entries()
            );
            // for Other Insert, Update select
            //let ret = checkJWT("Validate", "aacar_jwt_token", "OtherEventController", formData); // action, tokenname, Segment of URL, form Data
            
            // for delete 
            formData.user_id = 62;
            let ret = checkJWT("Validate", "aacar_jwt_token", "OtherEventController", formData); // action, tokenname, Segment of URL, form Data
            console.log(ret);
        });
		
	
		
		//formData.userName = "Ajit Kumar";
            
		  //  validateJWT(function(status){
    //             if(!status){
    //                 //window.location.href="/Login";
    //                 console.log(status);
    //             }
    //         }, "Validate", "aacar_jwt_token", "LoginController", formData);
    //         // Action , Token Name in LocalStorage , Which Controller you send
		
		
		
	</script>

  </body>
</html>
