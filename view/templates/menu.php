<?php $decrypt = $this->encryption->decrypt($_GET['val'] ?? null);
  $decrypt = explode(",", $decrypt);

  ?>
 <style>
   .layout-menu-horizontal .menu-sub {
       width: max-content !important;
   }
   .layout-menu-horizontal .menu-sub .menu-link {
       white-space: nowrap !important;
   }
 </style>
 <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0">
   <div class="container-fluid d-flex h-100">
     <ul class="menu-inner">
       <!-- Dashboards -->
       <li class="menu-item <?php if ($decrypt[0] == '1') {
                              echo 'active';
                            } ?>" data-permission="dashboard_access">
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
                                } ?>" data-permission="users_access">
             <a href="/AddUser?val=<?php echo $this->encryption->encrypt('2,2-4'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-user-add-fill"></i>
               <div data-i18n="Users">Users</div>
             </a>
           </li>
             <li class="menu-item <?php if ($decrypt[0] == '2-3') {
                                  echo 'active';
                                } ?>" data-permission="vehicle_config_access,vehicle_config_manage">
             <a href="/VehicleMasterConfiguration?val=<?php echo $this->encryption->encrypt('2,2-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-node-tree"></i>
               <div data-i18n="Vehicle Configuration">Vehicle Configuration</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-1') {
                                  echo 'active';
                                } ?>" data-permission="vehicle_registration_access,vehicle_registration_manage">
             <a href="/RegisterVehicles?val=<?php echo $this->encryption->encrypt('2,2-1'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-car-line"></i>
               <div data-i18n="Vehicle Registration">Vehicle Registration</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-3') {
                                  echo 'active';
                                } ?>" data-permission="driver_registration_access,driver_registration_manage">
             <a href="/RegisterDrivers?val=<?php echo $this->encryption->encrypt('2,2-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-user-shared-line"></i>
               <div data-i18n="Driver Registration">Driver Registration</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-6') {
                                  echo 'active';
                                } ?>" data-permission="staff_registration_access,staff_registration_manage">
             <a href="/RegisterStaff?val=<?php echo $this->encryption->encrypt('2,2-6'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-id-card-line"></i>
               <div data-i18n="Staff Registration">Staff Registration</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-8') {
                                  echo 'active';
                                } ?>" data-permission="outsourcing_company_access">
             <a href="/OutsourcingCompany?val=<?php echo $this->encryption->encrypt('2,2-8'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-building-4-line"></i>
               <div data-i18n="Outsourcing Company">Outsourcing Company</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-5') {
                                  echo 'active';
                                } ?>" data-permission="customers_access">
             <a href="/Customers?val=<?php echo $this->encryption->encrypt('2,2-5'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-group-line"></i>
               <div data-i18n="Customers">Customers</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-9') {
                                  echo 'active';
                                } ?>" data-permission="garage_and_service_access">
             <a href="/GarageAndServiceMaster?val=<?php echo $this->encryption->encrypt('2,2-9'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-tools-line"></i>
               <div data-i18n="Garage and Service Master">Garage and Service Master</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-10') {
                                  echo 'active';
                                } ?>" data-permission="vehicle_insurance_access">
             <a href="/VehicleInsurance?val=<?php echo $this->encryption->encrypt('2,2-10'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-shield-line"></i>
               <div data-i18n="Vehicle Insurance & Passings">Vehicle Insurance & Passings</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-2') {
                                  echo 'active';
                                } ?>" data-permission="list_of_vehicles_access" style="display: none;">
             <a href="/ListofVehicles?val=<?php echo $this->encryption->encrypt('2,2-2'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-list-unordered"></i>
               <div data-i18n="List of Vehicles">List of Vehicles</div>
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
         
            <li style="display: none;" class="menu-item <?php if ($decrypt[0] == '3-2') {
                                  echo 'active';
                                } ?>" data-permission="vehicle_reservation_access">
             <a href="/VehicleReservation?val=<?php echo $this->encryption->encrypt('3,3-2'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-pushpin-fill"></i>
               <div data-i18n="Vehicle Reservation">Vehicle Reservation</div>
             </a>
           </li>
             <li class="menu-item <?php if ($decrypt[0] == '3-11') {
                                   echo 'active';
                                 } ?>">
             <a href="/DirectContract?val=<?php echo $this->encryption->encrypt('3,3-11'); ?>" class="menu-link">
  
                <i class="menu-icon icon-base ri ri-draft-line"></i>
              <div data-i18n="Direct Contract">Direct Contract</div>
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
            <li class="menu-item d-none <?php if ($decrypt[0] == '3-3') {
                                  echo 'active';
                                } ?>" data-permission="generate_contract_access">
             <a href="/VehicleContract?val=<?php echo $this->encryption->encrypt('3,3-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-draft-line"></i>
               <div data-i18n="Generate Contract">Generate Contract</div>
             </a>
           </li>
            <li class="menu-item <?php if ($decrypt[0] == '3-10') {
                                   echo 'active';
                                 } ?>" data-permission="generate_contract_access">
              <a href="/ContractGeneration?val=<?php echo $this->encryption->encrypt('3,3-10'); ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-survey-line"></i>
                <div data-i18n="Reservation List">Reservation List</div>
              </a>
            </li>
           <li class="menu-item <?php if ($decrypt[0] == '3-4') {
                                  echo 'active';
                                } ?>" data-permission="contract_list_access">
             <a href="/ContractList?val=<?php echo $this->encryption->encrypt('3,3-4'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
               <div data-i18n="Contract List">Contract List</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '2-6') {
                                  echo 'active';
                                } ?>" data-permission="maintenance_request_access">
             <a href="/MaintenanceRequest?val=<?php echo $this->encryption->encrypt('2,2-6'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-tools-line"></i>
               <div data-i18n="Maintenance Request">Maintenance Request</div>
             </a>
           </li>
           <li class="menu-item" data-permission="send_contract_access">
             <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sendContractModal" class="menu-link">
               <i class="menu-icon icon-base ri ri-send-plane-fill"></i>
               <div data-i18n="Send Contract">Send Contract</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '3-5') {
                                  echo 'active';
                                } ?>" data-permission="staff_use_allocation_access">
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
                                } ?>" data-permission="quotation_access">
             <a href="/Quotation?val=<?php echo $this->encryption->encrypt('5,5-3'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-quote-text"></i>
               <div data-i18n="Quotation">Quotation</div>
             </a>
           </li>
            <li class="menu-item <?php if ($decrypt[0] == '5-4') {
                                  echo 'active';
                                } ?>" data-permission="invoice_access">
             <a href="/Invoice?val=<?php echo $this->encryption->encrypt('5,5-4'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-bill-line"></i>
               <div data-i18n="Invoice">Invoice</div>
             </a>
           </li>
             <li class="menu-item <?php if ($decrypt[0] == '5-5') {
                                  echo 'active';
                                } ?>" data-permission="cash_memo_access">
             <a href="/CashMemo?val=<?php echo $this->encryption->encrypt('5,5-5'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-receipt-line"></i>
               <div data-i18n="Cash Memo/Receipt">Cash Memo/Receipt</div>
             </a>
           </li>
            <li class="menu-item <?php if ($decrypt[0] == '5-7') {
                                  echo 'active';
                                } ?>" data-permission="expense_voucher_access">
             <a href="/ExpenseVoucher?val=<?php echo $this->encryption->encrypt('5,5-7'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
               <div data-i18n="Expense Voucher">Expense Voucher</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '5-1') { echo 'active'; } ?>" data-permission="customer_ledger_access">
             <a href="/CustomerLedger?val=<?php echo $this->encryption->encrypt('5,5-1'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
               <div data-i18n="Customer Ledger">Customer Ledger</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '5-2') { echo 'active'; } ?>" data-permission="fund_flow_report_access">
             <a href="/FundFlow?val=<?php echo $this->encryption->encrypt('5,5-2'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-line-chart-line"></i>
               <div data-i18n="Fund Flow Report">Fund Flow Report</div>
             </a>
           </li>
            <li class="menu-item <?php if ($decrypt[0] == '5-6') { echo 'active'; } ?>" data-permission="unbilled_contracts_access">
             <a href="/UnbilledContracts?val=<?php echo $this->encryption->encrypt('5,5-6'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-file-warning-line"></i>
               <div data-i18n="Unbilled Contracts">Unbilled Contracts</div>
             </a>
           </li>
           <li class="menu-item <?php if ($decrypt[0] == '5-8') { echo 'active'; } ?>">
             <a href="/RefundForm?val=<?php echo $this->encryption->encrypt('5,5-8'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-refund-2-line"></i>
               <div data-i18n="Refund Form">Refund Form</div>
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
                   <li class="menu-item <?php if ($decrypt[0] == '6-1') { echo 'active'; } ?>" data-permission="vehicle_insight_access">
                     <a href="/VehicleInsight?val=<?php echo $this->encryption->encrypt('6,6-1'); ?>" class="menu-link">
                       <i class="menu-icon icon-base ri ri-car-line"></i>
                       <div data-i18n="Vehicle Insight">Vehicle Insight</div>
                     </a>
                   </li>
                   <li class="menu-item <?php if ($decrypt[0] == '6-8') { echo 'active'; } ?>" data-permission="vehicle_insight_access">
                     <a href="/VehicleMovementReport?val=<?php echo $this->encryption->encrypt('6,6-8'); ?>" class="menu-link">
                       <i class="menu-icon icon-base ri ri-route-line"></i>
                       <div data-i18n="Vehicle Movement Report">Vehicle Movement Report</div>
                     </a>
                   </li>
                   <li class="menu-item <?php if ($decrypt[0] == '6-9') { echo 'active'; } ?>" data-permission="vehicle_insight_access">
                     <a href="/VehicleUtilizationReport?val=<?php echo $this->encryption->encrypt('6,6-9'); ?>" class="menu-link">
                       <i class="menu-icon icon-base ri ri-pie-chart-line"></i>
                       <div data-i18n="Vehicle Utilization Report">Vehicle Utilization Report</div>
                     </a>
                   </li>
                   <li class="menu-item <?php if ($decrypt[0] == '6-2') { echo 'active'; } ?>" data-permission="expected_returns_access">
                      <a href="/ReturnReport?val=<?php echo $this->encryption->encrypt('6,6-2'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-calendar-check-line"></i>
                        <div data-i18n="Expected Returns">Expected Returns</div>
                      </a>
                    </li>
                     <li class="menu-item <?php if ($decrypt[0] == '6-3') { echo 'active'; } ?>" data-permission="customer_balances_access">
                      <a href="/CustomerBalances?val=<?php echo $this->encryption->encrypt('6,6-3'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-wallet-3-line"></i>
                        <div data-i18n="Customer Balances">Customer Balances</div>
                      </a>
                    </li>
                     <li class="menu-item <?php if ($decrypt[0] == '6-4') { echo 'active'; } ?>" data-permission="daily_rental_report_access">
                      <a href="/DailyRentalReport?val=<?php echo $this->encryption->encrypt('6,6-4'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-file-chart-line"></i>
                        <div data-i18n="Daily Rental Report">Daily Rental Report</div>
                      </a>
                    </li>
                     <li class="menu-item <?php if ($decrypt[0] == '6-5') { echo 'active'; } ?>" data-permission="daily_cash_report_access">
                      <a href="/DailyCashReport?val=<?php echo $this->encryption->encrypt('6,6-5'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-funds-line"></i>
                        <div data-i18n="Daily Cash Report">Daily Cash Report</div>
                      </a>
                    </li>
                    <li class="menu-item <?php if ($decrypt[0] == '6-6') { echo 'active'; } ?>" data-permission="staff_use_report_access">
                      <a href="/NonRevenueTicketReport?val=<?php echo $this->encryption->encrypt('6,6-6'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-coupon-3-line"></i>
                        <div data-i18n="Staff Use Report">Staff Use Report</div>
                      </a>
                    </li>
                    <li class="menu-item <?php if ($decrypt[0] == '6-7') { echo 'active'; } ?>" data-permission="contract_history_report_access">
                      <a href="/ContractHistoryReport?val=<?php echo $this->encryption->encrypt('6,6-7'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-history-line"></i>
                        <div data-i18n="Contract & Replacement History">Contract & Replacement History</div>
                      </a>
                    </li>
                 </ul>
        </li>
       
       
     </ul>
   </div>
 </aside>
