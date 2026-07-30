   <!-- Enable OTP Modal -->
              <div class="modal fade" id="closeenableOTP" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-body p-0">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-6">
                        <h4 class="mb-2">Enable One Time Password</h4>
                        
                      </div>
                       <input type="hidden" id="close_otp_require_basic_details">
                     
                       <div class=" mb-2 text-start text-warning" id="closeOTPModaltext"><i class="ri ri-error-warning-fill "></i><b>Contract Closure Warning</b>
        <p>An outstanding contract balance has been detected. OTP verification is required to proceed with contract closure.</p>
                      </div>
                      <p class="mb-5">
                        Enter the phone number of the authority  with country code and we will send you a verification code.
                      </p>
                      <form id="closeenableOTPForm" class="row g-5" onsubmit="return false">
                        <div class="col-12 form-control-validation">
                          <!--<div class="input-group input-group-merge">-->
                          <!--  <span class="input-group-text">BH (+973)</span>-->
                            <div class="form-floating form-floating-outline">
                              <input
                              type="text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                class="form-control phone-number-otp-mask"
                                id="closemodalEnableOTPPhone"
                                name="closemodalEnableOTPPhone"
                                placeholder="" />
                              <label for="closemodalEnableOTPPhone">Phone Number</label>
                            </div>
                          <!--</div>-->
                        </div>
                        <div class="col-12 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                          <button type="button" class="btn btn-primary" id="close_btn_otp_mobile_submit">Submit</button>
                          <button
                            type="reset"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Enable OTP Modal -->