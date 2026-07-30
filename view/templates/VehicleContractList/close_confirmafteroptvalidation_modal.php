<div class="modal fade" id="close_customConfirmModalAfterOTPValidation" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow">

      <div class="modal-body text-center p-4">

        <!-- Icon -->
        <div id="confirmIcon" class="mb-3">
          <i class="ri-alert-line text-warning" style="font-size: 40px;"></i>
        </div>
        <input id="hid_contratc_id_closure" type="hidden">
        <input id="hid_close_otp_message" type="hidden">
        
        <!-- Message -->
        <div id="close_confirmMessageOTP" class="mb-3 fw-semibold">
          Are you sure?
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-light btn-sm" data-bs-dismiss="modal">
            Cancel
          </button>
          <button id="closeconfirmOTPYesBtn" class="btn btn-warning btn-sm">
            Yes, Continue
          </button>
        </div>

      </div>

    </div>
  </div>
</div>