<div class="modal fade" id="close_otpModal" tabindex="-1" aria-hidden="true">
 <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="ri-shield-keyhole-line text-warning"></i>
          OTP Verification
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">

        <p class="mb-3">
          Enter the OTP sent to the provided phone number : <b><span id="close_span_mobile_otp"></span></b>
        </p>
        <input type="hidden" id="close_txt_mobile_number_otp_send">
        <input type="hidden" id="close_otp_otherdata">
        
        <input
            type="text"
            id="close_otp_input"
            class="form-control text-center fs-4"
            maxlength="6"
            inputmode="numeric"
            placeholder="Enter OTP"
        >


      </div>

      <div class="modal-footer justify-content-between">

        <button class="btn btn-link" id="close_otpcancel" data-bs-dismiss="modal"
                            aria-label="Close">
         Cancel
        </button>

        <button class="btn btn-primary" id="close_btn_verify_otp">
          Verify OTP
        </button>

      </div>

    </div>
  </div>
</div>