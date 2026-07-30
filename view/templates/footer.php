 
<!-- Send Contract Modal -->
<div class="modal fade" id="sendContractModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Send Contract</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="send_contract_no" class="form-label">Contract Number</label>
          <input type="text" id="send_contract_no" class="form-control" placeholder="Enter Contract/Agreement Number (e.g. AA/2026/AGR/0003)">
        </div>
        <div class="d-flex flex-column gap-2 mt-4">
          <button type="button" class="btn btn-primary w-100" onclick="handleSendContract('mail')">
            <i class="ri-mail-send-line me-1"></i> Send by Mail
          </button>
          <button type="button" class="btn btn-success w-100" onclick="handleSendContract('whatsapp')">
            <i class="ri-whatsapp-line me-1"></i> Send via WhatsApp
          </button>
          <button type="button" class="btn btn-secondary w-100" onclick="handleSendContract('download')">
            <i class="ri-download-2-line me-1"></i> View and Download
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert2 CDN for handleSendContract -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
  .swal2-container {
    z-index: 10999 !important;
  }
</style>
<script>
function handleSendContract(action) {
    const contractNo = document.getElementById('send_contract_no').value.trim();
    if (!contractNo) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please enter a Contract Number.'
        });
        return;
    }

    if (action === 'mail') {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to email this contract?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Sending...',
                    text: 'Please wait while we send the email.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                fetch('/controller/send_contract_mail.php?contract_no=' + encodeURIComponent(contractNo))
                .then(res => res.text())
                .then(data => {
                    Swal.fire(
                        'Result',
                        data,
                        data.toLowerCase().includes('failed') || data.toLowerCase().includes('error') ? 'error' : 'success'
                    );
                }).catch(err => {
                    Swal.fire(
                        'Error!',
                        'Error sending mail.',
                        'error'
                    );
                });
            }
        });
    } else if (action === 'whatsapp') {
        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(contractNo))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            const url = window.location.origin + '/PrintAgreement?token=' + encodeURIComponent(token);
            const text = encodeURIComponent('Here is your car rental contract: ' + url);
            window.open('https://wa.me/?text=' + text, '_blank');
        });
    } else if (action === 'download') {
        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(contractNo))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/PrintAgreement?token=' + encodeURIComponent(token), '_blank');
        });
    }
}
</script>
<footer class="content-footer footer bg-footer-theme">
  <div class="container-fluid">
	<div
	  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
	  <div class="mb-2 mb-md-0">
		&#169;
		<script>
		  document.write(new Date().getFullYear());
		</script>
		, made with ❤️ by
		<a href="https://www.sandslab.com" target="_blank" class="footer-link fw-medium">SaNDS Lab Middle East W.L.L</a>
	  </div>
	  <div class="d-none d-lg-inline-block">
		<a href="https://www.sandslab.com" target="_blank" class="footer-link d-none d-sm-inline-block"
		  >Support</a
		>
	  </div>
	</div>
  </div>
</footer>