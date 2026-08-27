<?php
require_once ROOT_PATH . '/model/common/PermissionHelper.php';
if (!empty($_SESSION['user_id'])) {
    PermissionHelper::loadUserPermissionsIntoSession($_SESSION['user_id'], $_SESSION['user_role_id'] ?? 0, $_SESSION['user_role_name'] ?? '');
}
$decrypt = $this->encryption->decrypt($_GET['val'] ?? null);
$decrypt = explode(",", $decrypt);

  ?>
 <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0">
   <div class="container-fluid d-flex h-100">
     <ul class="menu-inner">
       <!-- Dashboards -->
       <li class="menu-item <?php if ($decrypt[0] == '1') {
                              echo 'active';
                            } ?>">
         <a href="/Home?val=<?php echo $this->encryption->encrypt('1,1-1'); ?>" class="menu-link">
           <i class="menu-icon icon-base ri ri-home-smile-line"></i>
           <div data-i18n="Dashboard">Dashboard</div>
         </a>

       </li>

       <!-- Layouts -->
       <li class="menu-item <?php if ($decrypt[0] == '2') {
                              echo 'active';
                            } ?>">
         <a href="javascript:void(0)" class="menu-link menu-toggle">
           <i class="menu-icon icon-base ri ri-layout-2-line"></i>
           <div data-i18n="Masters">Masters</div>
         </a>

         <ul class="menu-sub">
             <li class="menu-item <?php if ($decrypt[0] == '2-3') {
                                  echo 'active';
                                } ?>">
             <a href="/VehicleMasterConfiguration?val=<?php echo $this->encryption->encrypt('2,2-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-node-tree"></i>
               <div data-i18n="Vehicle Configuration">Vehicle Configuration</div>
             </a>
           </li>

           <li class="menu-item <?php if ($decrypt[0] == '2-1') {
                                  echo 'active';
                                } ?>">
             <a href="/RegisterVehicles?val=<?php echo $this->encryption->encrypt('2,2-1'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-car-line"></i>
               <div data-i18n="Vehicle Registration">Vehicle Registration</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-3') {
                                  echo 'active';
                                } ?>">
             <a href="/RegisterDrivers?val=<?php echo $this->encryption->encrypt('2,2-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-user-shared-line"></i>
               <div data-i18n="Driver Registration">Driver Registration</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-2') {
                                  echo 'active';
                                } ?>">
             <a href="/ListOfVehicles?val=<?php echo $this->encryption->encrypt('2,2-2'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-list-unordered"></i>
               <div data-i18n="List of Vehicles">List of Vehicles</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-8') {
                                  echo 'active';
                                } ?>">
             <a href="/OutsourcingCompany?val=<?php echo $this->encryption->encrypt('2,2-8'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-building-4-line"></i>
               <div data-i18n="Outsourcing Company">Outsourcing Company</div>
             </a>
           </li>

         </ul>
       </li>
       <!-- Settings -->
       <li class="menu-item <?php if ($decrypt[0] == '4') {
                              echo 'active';
                            } ?>">
         <a href="javascript:void(0)" class="menu-link menu-toggle">
           <i class="menu-icon icon-base ri ri-settings-5-line"></i>
           <div data-i18n="Settings">Settings</div>
         </a>

         <ul class="menu-sub">
           <li class="menu-item <?php if ($decrypt[0] == '4-1') {
                                  echo 'active';
                                } ?>">
             <a href="/AddUser?val=<?php echo $this->encryption->encrypt('4,4-1'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-user-add-fill"></i>
               <div data-i18n="Users">Users</div>
             </a>
           </li>
           <!-- <li class="menu-item <?php //if($decrypt[0]=='2-2'){echo 'active';}
                                      ?>">
                          <a href="/ListOfVehicles?val=<?php //echo $this->encryption->encrypt('2,2-2');
                                                        ?>" class="menu-link">
                        
                          <i class="menu-icon icon-base ri ri-list-unordered"></i>
                          <div data-i18n="List of Vehicles">List of Vehicles</div>
                         </a>
                       </li> -->

         </ul>
       </li>

       <li class="menu-item <?php if ($decrypt[0] == '3') {
                              echo 'active';
                            } ?>">
         <a href="javascript:void(0)" class="menu-link menu-toggle">
           <i class="menu-icon icon-base ri ri-layout-2-line"></i>
           <div data-i18n="Operations">Operations</div>
         </a>

         <ul class="menu-sub">
           <li class="menu-item <?php if ($decrypt[0] == '3-1') {
                                  echo 'active';
                                } ?>">
             <a href="/Quotation?val=<?php echo $this->encryption->encrypt('3,3-1'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-quote-text"></i>
               <div data-i18n="Quotation">Quotation</div>
             </a>
           </li>
            <li class="menu-item <?php if ($decrypt[0] == '3-2') {
                                  echo 'active';
                                } ?>">
             <a href="/VehicleReservation?val=<?php echo $this->encryption->encrypt('3,3-2'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-pushpin-fill"></i>
               <div data-i18n="Reservation from Quotation">Reservation from Quotation</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '3-10') {
                                 echo 'active';
                               } ?>">
            <a href="/Reservation?val=<?php echo $this->encryption->encrypt('3,3-10'); ?>" class="menu-link">

              <i class="menu-icon icon-base ri ri-survey-line"></i>
              <div data-i18n="Reservation">Reservation</div>
            </a>
          </li>
            <li class="menu-item <?php if ($decrypt[0] == '3-3') {
                                  echo 'active';
                                } ?>">
             <a href="/VehicleContract?val=<?php echo $this->encryption->encrypt('3,3-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-draft-line"></i>
               <div data-i18n="Contract Generation">Contract Generation</div>
             </a>
           </li>
            <li class="menu-item">
              <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sendContractModal" class="menu-link">
                <i class="menu-icon icon-base ri ri-send-plane-fill"></i>
                <div data-i18n="Send Contract">Send Contract</div>
              </a>
            </li>
            <li class="menu-item <?php if ($decrypt[0] == '2-6') {
                                   echo 'active';
                                 } ?>">
              <a href="/MaintenanceRequest?val=<?php echo $this->encryption->encrypt('2,2-6'); ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-tools-line"></i>
                <div data-i18n="Maintenance Request">Maintenance Request</div>
              </a>
            </li>
         </ul>
       </li>

       <li class="menu-item <?php if ($decrypt[0] == '5') { echo 'active'; } ?>">
         <a href="javascript:void(0)" class="menu-link menu-toggle">
           <i class="menu-icon icon-base ri ri-wallet-line"></i>
           <div data-i18n="Accounting">Accounting</div>
         </a>
         <ul class="menu-sub">
           <li class="menu-item <?php if ($decrypt[0] == '5-1') { echo 'active'; } ?>">
             <a href="/CustomerLedger?val=<?php echo $this->encryption->encrypt('5,5-1'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
               <div data-i18n="Customer Ledger">Customer Ledger</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '5-2') { echo 'active'; } ?>">
             <a href="/FundFlow?val=<?php echo $this->encryption->encrypt('5,5-2'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-line-chart-line"></i>
               <div data-i18n="Fund Flow Report">Fund Flow Report</div>
             </a>
           </li>
         </ul>
       </li>
     </ul>
   </div>
 </aside>

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
          <input type="text" id="send_contract_no" class="form-control" placeholder="Enter Contract Number (e.g. AA/2026/AGR/0003)">
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

<script>
function handleSendContract(action) {
    const contractNo = document.getElementById('send_contract_no').value.trim();
    if (!contractNo) {
        alert('Please enter a Contract Number.');
        return;
    }

    if (action === 'mail') {
        if(confirm('Are you sure you want to email this contract?')) {
            fetch('/controller/send_contract_mail.php?contract_no=' + encodeURIComponent(contractNo))
            .then(res => res.text())
            .then(data => {
                alert(data);
            }).catch(err => {
                alert('Error sending mail.');
            });
        }
    } else if (action === 'whatsapp') {
        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(contractNo))
        .then(res => res.text())
        .then(token => {
            if(!token) { alert('Encryption failed.'); return; }
            const url = window.location.origin + '/view_contract.php?token=' + encodeURIComponent(token);
            const text = encodeURIComponent('Here is your car rental contract: ' + url);
            window.open('https://wa.me/?text=' + text, '_blank');
        });
    } else if (action === 'download') {
        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(contractNo))
        .then(res => res.text())
        .then(token => {
            if(!token) { alert('Encryption failed.'); return; }
            window.open('/view_contract.php?token=' + encodeURIComponent(token), '_blank');
        });
    }
}
</script>