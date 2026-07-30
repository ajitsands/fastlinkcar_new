 <?php $decrypt = $this->encryption->decrypt($_GET['val'] ?? null);
  $decrypt = explode(",", $decrypt);

  ?>
 <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0">
   <div class="container-fluid d-flex h-100">
     <ul class="menu-inner">
       <!-- Dashboards -->
       <li class="menu-item <?php if ($decrypt[0] == '1') {
                              echo 'active';
                            } ?>">
         <a href="/Dashboard?val=<?php echo $this->encryption->encrypt('1,1-1'); ?>" class="menu-link">
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
             <li class="menu-item <?php if ($decrypt[0] == '2-4') {
                                  echo 'active';
                                } ?>">
             <a href="/AddUser?val=<?php echo $this->encryption->encrypt('2,2-4'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-user-add-fill"></i>
               <div data-i18n="Users">Users</div>
             </a>
           </li>
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
           <li class="menu-item <?php if ($decrypt[0] == '2-6') {
                                  echo 'active';
                                } ?>">
             <a href="/RegisterStaff?val=<?php echo $this->encryption->encrypt('2,2-6'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-id-card-line"></i>
               <div data-i18n="Staff Registration">Staff Registration</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-2') {
                                  echo 'active';
                                } ?>">
             <a href="/ListofVehicles?val=<?php echo $this->encryption->encrypt('2,2-2'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-list-unordered"></i>
               <div data-i18n="List of Vehicles">List of Vehicles</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-5') {
                                  echo 'active';
                                } ?>">
             <a href="/Customers?val=<?php echo $this->encryption->encrypt('2,2-5'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-group-line"></i>
               <div data-i18n="Customers">Customers</div>
             </a>
           </li>
       

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
         
            <li class="menu-item <?php if ($decrypt[0] == '3-2') {
                                  echo 'active';
                                } ?>">
             <a href="/VehicleReservation?val=<?php echo $this->encryption->encrypt('3,3-2'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-pushpin-fill"></i>
               <div data-i18n="Vehicle Reservation">Vehicle Reservation</div>
             </a>
           </li>
            <li class="menu-item <?php if ($decrypt[0] == '3-3') {
                                  echo 'active';
                                } ?>">
             <a href="/VehicleContract?val=<?php echo $this->encryption->encrypt('3,3-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-draft-line"></i>
               <div data-i18n="Generate Contract">Generate Contract</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '3-4') {
                                  echo 'active';
                                } ?>">
             <a href="/ContractList?val=<?php echo $this->encryption->encrypt('3,3-4'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
               <div data-i18n="Contract List">Contract List</div>
             </a>
           </li>
           <li class="menu-item">
             <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sendContractModal" class="menu-link">
               <i class="menu-icon icon-base ri ri-send-plane-fill"></i>
               <div data-i18n="Send Contract">Send Contract</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '3-5') {
                                  echo 'active';
                                } ?>">
             <a href="/NonRevenueTickets?val=<?php echo $this->encryption->encrypt('3,3-5'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
               <div data-i18n="Staff Use Allocation">Staff Use Allocation</div>
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
               <li class="menu-item <?php if ($decrypt[0] == '5-3') {
                                  echo 'active';
                                } ?>">
             <a href="/Quotation?val=<?php echo $this->encryption->encrypt('5,5-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-quote-text"></i>
               <div data-i18n="Quotation">Quotation</div>
             </a>
           </li>
            <li class="menu-item <?php if ($decrypt[0] == '5-4') {
                                  echo 'active';
                                } ?>">
             <a href="/Invoice?val=<?php echo $this->encryption->encrypt('5,5-4'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-bill-line"></i>
               <div data-i18n="Invoice">Invoice</div>
             </a>
           </li>
             <li class="menu-item <?php if ($decrypt[0] == '5-5') {
                                  echo 'active';
                                } ?>">
             <a href="/CashMemo?val=<?php echo $this->encryption->encrypt('5,5-5'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-receipt-line"></i>
               <div data-i18n="Cash Memo/Receipt">Cash Memo/Receipt</div>
             </a>
           </li>
            <li class="menu-item <?php if ($decrypt[0] == '5-7') {
                                  echo 'active';
                                } ?>">
             <a href="/ExpenseVoucher?val=<?php echo $this->encryption->encrypt('5,5-7'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
               <div data-i18n="Expense Voucher">Expense Voucher</div>
             </a>
           </li>
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
            <li class="menu-item <?php if ($decrypt[0] == '5-6') { echo 'active'; } ?>">
             <a href="/UnbilledContracts?val=<?php echo $this->encryption->encrypt('5,5-6'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-file-warning-line"></i>
               <div data-i18n="Unbilled Contracts">Unbilled Contracts</div>
             </a>
           </li>
         </ul>
       </li>
       
        <li class="menu-item <?php if ($decrypt[0] == '6') { echo 'active'; } ?>">
                 <a href="javascript:void(0)" class="menu-link menu-toggle">
                   <i class="menu-icon icon-base ri ri-bar-chart-box-line"></i>
                   <div data-i18n="Reports">Reports</div>
                 </a>
                 <ul class="menu-sub">
                   <li class="menu-item <?php if ($decrypt[0] == '6-1') { echo 'active'; } ?>">
                     <a href="/VehicleInsight?val=<?php echo $this->encryption->encrypt('6,6-1'); ?>" class="menu-link">
                       <i class="menu-icon icon-base ri ri-car-line"></i>
                       <div data-i18n="Vehicle Insight">Vehicle Insight</div>
                     </a>
                   </li>
                   <li class="menu-item <?php if ($decrypt[0] == '6-2') { echo 'active'; } ?>">
                      <a href="/ReturnReport?val=<?php echo $this->encryption->encrypt('6,6-2'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-calendar-check-line"></i>
                        <div data-i18n="Expected Returns">Expected Returns</div>
                      </a>
                    </li>
                     <li class="menu-item <?php if ($decrypt[0] == '6-3') { echo 'active'; } ?>">
                      <a href="/CustomerBalances?val=<?php echo $this->encryption->encrypt('6,6-3'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-wallet-3-line"></i>
                        <div data-i18n="Customer Balances">Customer Balances</div>
                      </a>
                    </li>
                     <li class="menu-item <?php if ($decrypt[0] == '6-4') { echo 'active'; } ?>">
                      <a href="/DailyRentalReport?val=<?php echo $this->encryption->encrypt('6,6-4'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-chart-line"></i>
                        <div data-i18n="Daily Rental Report">Daily Rental Report</div>
                      </a>
                    </li>
                     <li class="menu-item <?php if ($decrypt[0] == '6-5') { echo 'active'; } ?>">
                      <a href="/DailyCashReport?val=<?php echo $this->encryption->encrypt('6,6-5'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-funds-line"></i>
                        <div data-i18n="Daily Cash Report">Daily Cash Report</div>
                      </a>
                    </li>
                    <li class="menu-item <?php if ($decrypt[0] == '6-6') { echo 'active'; } ?>">
                      <a href="/NonRevenueTicketReport?val=<?php echo $this->encryption->encrypt('6,6-6'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-coupon-3-line"></i>
                        <div data-i18n="Staff Use Report">Staff Use Report</div>
                      </a>
                    </li>
                 </ul>
        </li>
       
       
     </ul>
   </div>
 </aside>
