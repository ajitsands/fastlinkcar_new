<div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
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
          Enter the OTP sent to the provided phone number : <b><span id="span_mobile_otp"></span></b>
        </p>
        <input type="hidden" id="txt_mobile_number_otp_send">
        <input type="hidden" id="applic_unit_price">
        
        <input
            type="text"
            id="otp_input"
            class="form-control text-center fs-4"
            maxlength="6"
            inputmode="numeric"
            placeholder="Enter OTP"
        >


      </div>

      <div class="modal-footer justify-content-between">

        <button class="btn btn-link" id="otpcancel" data-bs-dismiss="modal"
                            aria-label="Close">
         Cancel
        </button>

        <button class="btn btn-primary" id="btn_verify_otp">
          Verify OTP
        </button>

      </div>

    </div>
  </div>
</div>