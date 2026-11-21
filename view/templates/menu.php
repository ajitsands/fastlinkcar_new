<?php $decrypt = $this->encryption->decrypt($_GET['val'] ?? null);
  $decrypt = explode(",", (string)$decrypt);
  $menuRoute = trim((string)parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
  $menuSubCode = $decrypt[1] ?? ($decrypt[0] ?? '');

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
       <!-- Active Contracts -->
       <li class="menu-item <?php if ($decrypt[0] == '7') {
                              echo 'active';
                            } ?>">
         <a href="/ActiveContractsDashboard?val=<?php echo $this->encryption->encrypt('7,7-1'); ?>" class="menu-link">
           <i class="menu-icon icon-base ri ri-file-check-line"></i>
           <div data-i18n="Active Contracts">Active Contracts</div>
         </a>
       </li>

       <!-- New Contract (Direct Contract) -->
       <li class="menu-item <?php if ($decrypt[0] == '8' || ($decrypt[1] ?? '') == '3-11') {
                              echo 'active';
                            } ?>">
         <a href="/DirectContract?val=<?php echo $this->encryption->encrypt('8,8-1'); ?>" class="menu-link">
           <i class="menu-icon icon-base ri ri-file-add-line"></i>
           <div data-i18n="New Contract">New Contract</div>
         </a>
       </li>

       <!-- Contract List -->
       <li class="menu-item <?php if (($decrypt[0] ?? '') == '3-4' || ($decrypt[1] ?? '') == '3-4') {
                              echo 'active';
                            } ?>" data-permission="contract_list_access">
         <a href="/ContractList?val=<?php echo $this->encryption->encrypt('3,3-4'); ?>" class="menu-link">
           <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
           <div data-i18n="Contract List">Contract List</div>
         </a>
       </li>

       <!-- Staff Use Allocation -->
       <li class="menu-item <?php if (($decrypt[0] ?? '') == '3-5' || ($decrypt[1] ?? '') == '3-5') {
                              echo 'active';
                            } ?>" data-permission="staff_use_allocation_access">
         <a href="/NonRevenueTickets?val=<?php echo $this->encryption->encrypt('3,3-5'); ?>" class="menu-link">
           <i class="menu-icon icon-base ri ri-user-shared-line"></i>
           <div data-i18n="Staff Use Allocation">Staff Use Allocation</div>
         </a>
       </li>

       <!-- Reservation -->
       <li class="menu-item <?php if (($decrypt[0] ?? '') == '3' && !in_array($menuSubCode, ['3-4', '3-5', '3-11'], true) && !in_array($menuRoute, ['ContractList', 'NonRevenueTickets', 'DirectContract'], true)) {
                              echo 'active';
                            } ?>">
         <a href="javascript:void(0)" class="menu-link menu-toggle">
           <i class="menu-icon icon-base ri ri-layout-2-line"></i>
           <div data-i18n="Reservation">Reservation</div>
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
         </ul>
       </li>

       <!-- Maintenance Request -->
       <li class="menu-item <?php if (in_array($menuSubCode, ['2-6', '2-9'], true) || in_array($menuRoute, ['GarageAndServiceMaster', 'MaintenanceRequest'], true)) { echo 'active'; } ?>" data-permission="garage_and_service_access,maintenance_request_access">
         <a href="javascript:void(0)" class="menu-link menu-toggle">
           <i class="menu-icon icon-base ri ri-tools-line"></i>
           <div data-i18n="Maintenance Request">Maintenance Request</div>
         </a>
         <ul class="menu-sub">
           <li class="menu-item <?php if (($decrypt[0] ?? '') == '2-9' || ($decrypt[1] ?? '') == '2-9') { echo 'active'; } ?>" data-permission="garage_and_service_access">
             <a href="/GarageAndServiceMaster?val=<?php echo $this->encryption->encrypt('2,2-9'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-tools-line"></i>
               <div data-i18n="Garage and Service Master">Garage and Service Master</div>
             </a>
           </li>
           <li class="menu-item <?php if (($decrypt[0] ?? '') == '2-6' || ($decrypt[1] ?? '') == '2-6') { echo 'active'; } ?>" data-permission="maintenance_request_access">
             <a href="/MaintenanceRequest?val=<?php echo $this->encryption->encrypt('2,2-6'); ?>" class="menu-link">
               <i class="menu-icon icon-base ri ri-settings-4-line"></i>
               <div data-i18n="Maintenance Request">Maintenance Request</div>
             </a>
           </li>
         </ul>
       </li>

       <!-- Vehicle Insurance & Passings -->
       <li class="menu-item <?php if ($decrypt[0] == '9' || ($decrypt[1] ?? '') == '2-10') {
                              echo 'active';
                            } ?>" data-permission="vehicle_insurance_access">
         <a href="/VehicleInsurance?val=<?php echo $this->encryption->encrypt('9,9-1'); ?>" class="menu-link">
           <i class="menu-icon icon-base ri ri-shield-check-line"></i>
           <div data-i18n="Vehicle Insurance & Passings">Insurance &amp; Passings</div>
         </a>
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
                    <li class="menu-item <?php if (($decrypt[0] ?? '') == '6-10' || ($decrypt[1] ?? '') == '6-10') { echo 'active'; } ?>">
                      <a href="/ContractReturnOverdueReport?val=<?php echo $this->encryption->encrypt('6,6-10'); ?>" class="menu-link">
                        <i class="menu-icon icon-base ri ri-time-line"></i>
                        <div data-i18n="Contract Return & Overdue Report">Contract Return & Overdue Report</div>
                      </a>
                    </li>
                 </ul>
        </li>

        <!-- Masters (Right-aligned before Send Contract) -->
        <li class="menu-item ms-auto <?php if (($decrypt[0] ?? '') == '2' && !in_array($menuSubCode, ['2-6', '2-9', '2-10'], true) && !in_array($menuRoute, ['GarageAndServiceMaster', 'MaintenanceRequest', 'VehicleInsurance'], true)) {
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
            <li class="menu-item <?php if (($decrypt[1] ?? '') == '2-12') {
                                   echo 'active';
                                 } ?>" data-permission="customers_access">
              <a href="/CustomerAccounts?val=<?php echo $this->encryption->encrypt('2,2-12'); ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-bank-card-line"></i>
                <div data-i18n="Customer Accounts">Customer Accounts</div>
              </a>
            </li>
            <li class="menu-item <?php if ($decrypt[0] == '2-11') {
                                   echo 'active';
                                 } ?>">
              <a href="/PrintFormatMaster?val=<?php echo $this->encryption->encrypt('2,2-11'); ?>" class="menu-link">
                <i class="menu-icon icon-base ri ri-printer-line"></i>
                <div data-i18n="Print Header & Footer">Print Header & Footer</div>
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

        <!-- Send Contract (Icon-only right-aligned action) -->
        <li id="sendContractMenuBtn" class="menu-item" data-permission="send_contract_access" title="Send Contract" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="hover" onclick="if (window.bootstrap && bootstrap.Tooltip) { var t = bootstrap.Tooltip.getInstance(this); if (t) t.hide(); } this.blur();">
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sendContractModal" class="menu-link px-3" aria-label="Send Contract" onclick="this.blur();">
            <i class="menu-icon icon-base ri ri-send-plane-fill me-0" style="font-size: 1.45rem;"></i>
          </a>
        </li>

        <!-- Dashboard (Icon-only right-aligned action) -->
        <li class="menu-item <?php if (($decrypt[0] ?? '') == '1' || $menuRoute === 'Dashboard') { echo 'active'; } ?>" data-permission="dashboard_access" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="hover" onclick="if (window.bootstrap && bootstrap.Tooltip) { var t = bootstrap.Tooltip.getInstance(this); if (t) t.hide(); } this.blur();">
          <a href="/Dashboard?val=<?php echo $this->encryption->encrypt('1,1-1'); ?>" class="menu-link px-3" aria-label="Dashboard" onclick="this.blur();">
            <i class="menu-icon icon-base ri ri-home-smile-line me-0" style="font-size: 1.45rem;"></i>
          </a>
        </li>
     </ul>
   </div>
 </aside>
<?php
if (empty($_GET['embed_return']) || $_GET['embed_return'] !== '1') {
    $reqPath = trim((string)parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    $routeHeaderMap = [
        'DirectContract'              => ['New Direct Contract', 'Create a new rental agreement directly for a customer and available vehicle.', 'ri-file-add-line'],
        'Dashboard'                   => ['Dashboard', 'Overview of fleet status, reservations, revenue, and operations.', 'ri-home-smile-line'],
        'AddUser'                     => ['Users & Roles Master', 'Manage system users, roles, and access permissions.', 'ri-user-settings-line'],
        'VehicleMasterConfiguration'  => ['Vehicle Master Configuration', 'Configure vehicle categories, brands, models, and model pricing.', 'ri-settings-3-line'],
        'RegisterVehicles'            => ['Vehicle Master', 'Register vehicles, specifications, pricing preview, insurance, and passing.', 'ri-car-line'],
        'RegisterDrivers'             => ['Drivers Master', 'Register and manage company drivers and license details.', 'ri-steering-2-line'],
        'RegisterStaff'               => ['Staff Master', 'Manage staff profiles and contact details.', 'ri-team-line'],
        'OutsourcingCompany'          => ['Outsourcing Companies Master', 'Manage external fleet outsourcing partner companies.', 'ri-building-2-line'],
        'GarageAndServiceMaster'      => ['Garage & Service Master', 'Manage service garages, maintenance categories, and service items.', 'ri-tools-line'],
        'VehicleInsurance'            => ['Vehicle Insurance & Passing', 'Track and renew vehicle insurance policies and passing dates.', 'ri-shield-check-line'],
        'ListofVehicles'              => ['Fleet Vehicles List', 'View and filter all registered fleet vehicles and statuses.', 'ri-list-check-2'],
        'VehicleReservation'          => ['Vehicle Reservation', 'Create and manage vehicle reservations.', 'ri-pushpin-fill'],
        'Reservation'                 => ['Reservations List', 'View, filter, and convert vehicle reservations.', 'ri-survey-line'],
        'VehicleContract'             => ['Vehicle Contract Generation', 'Generate rental contracts from approved bookings and reservations.', 'ri-file-text-line'],
        'ContractGeneration'          => ['Contract Generation', 'Generate and manage customer vehicle hire agreements.', 'ri-file-text-line'],
        'ContractList'                => ['Vehicle Contracts List', 'Search, view, print, extend, replace, and return rental contracts.', 'ri-file-list-3-line'],
        'MaintenanceRequest'          => ['Maintenance Requests', 'Log and track vehicle maintenance and garage jobs.', 'ri-settings-4-line'],
        'NonRevenueTickets'           => ['Non-Revenue Tickets (Staff Use)', 'Manage internal staff vehicle usage tickets.', 'ri-coupon-3-line'],
        'Quotation'                   => ['Quotations', 'Create and manage customer rental quotations.', 'ri-file-paper-2-line'],
        'Invoice'                     => ['Invoices', 'Generate and manage customer tax invoices.', 'ri-bill-line'],
        'CashMemo'                    => ['Cash Memo', 'Record and print customer cash memos.', 'ri-receipt-line'],
        'ExpenseVoucher'              => ['Expense Vouchers', 'Record and track operational expense vouchers.', 'ri-money-dollar-box-line'],
        'CustomerLedger'              => ['Customer Ledger', 'View customer debits, credits, payments, and running balances.', 'ri-book-open-line'],
        'FundFlow'                    => ['Fund Flow', 'Track cash and bank fund inflows and outflows.', 'ri-exchange-dollar-line'],
        'UnbilledContracts'           => ['Unbilled Contracts', 'Review active or closed contracts pending billing.', 'ri-file-warning-line'],
        'RefundForm'                  => ['Customer Refunds', 'Process and track customer deposit and credit refunds.', 'ri-refund-2-line'],
        'VehicleInsight'              => ['Vehicle Insights', 'Analyze vehicle utilization, revenue, and status history.', 'ri-bar-chart-grouped-line'],
        'VehicleMovementReport'       => ['Vehicle Movement Report', 'Track vehicle check-out, check-in, and status movements.', 'ri-route-line'],
        'VehicleUtilizationReport'    => ['Vehicle Utilization Report', 'Analyze fleet utilization rates across periods.', 'ri-pie-chart-2-line'],
        'ReturnReport'                => ['Vehicle Return Report', 'Review returned vehicles, mileage, and return dates.', 'ri-arrow-go-back-line'],
        'CustomerBalances'            => ['Customer Balance Report', 'View outstanding balances across all customers.', 'ri-scales-3-line'],
        'DailyRentalReport'           => ['Daily Rental Report', 'Daily summary of rental contracts and charges.', 'ri-file-chart-line'],
        'DailyCashReport'             => ['Daily Cash Report', 'Daily cash and payment collection summary.', 'ri-funds-line'],
        'NonRevenueTicketReport'      => ['Staff Use Report', 'Summary of non-revenue staff vehicle usage.', 'ri-coupon-3-line'],
        'ContractHistoryReport'       => ['Contract & Replacement History', 'Audit trail of contracts and vehicle replacements.', 'ri-history-line'],
        'ContractReturnOverdueReport' => ['Contract Return & Overdue Report', 'Track contract returns and overdue charges.', 'ri-time-line'],
    ];
    if (isset($routeHeaderMap[$reqPath])) {
        [$pTitle, $pDesc, $pIcon] = $routeHeaderMap[$reqPath];
        ?>
        <style>
            .content-wrapper { justify-content: flex-start !important; }
            .content-footer { margin-top: auto !important; }
            #globalPageHeader + .container-p-y,
            #globalPageHeader + .container-fluid,
            #globalPageHeader + .container-xxl,
            #globalPageHeader + .layout-demo-placeholder > .container-p-y {
                padding-top: 6px !important;
                margin-top: 0 !important;
            }
            @media (min-width: 992px) {
                #globalPageHeader { padding-top: 52px !important; padding-bottom: 0 !important; }
            }
            @media (max-width: 991.98px) {
                #globalPageHeader { padding-top: 12px !important; padding-bottom: 0 !important; }
            }
        </style>
        <div class="container-fluid pb-0" id="globalPageHeader">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #1b3d94;">
                        <i class="<?= htmlspecialchars($pIcon) ?> me-1"></i> <?= htmlspecialchars($pTitle) ?>
                    </h4>
                    <p class="text-muted mb-0"><?= htmlspecialchars($pDesc) ?></p>
                </div>
            </div>
        </div>
        <script>
        (function () {
            function tightenHeaderGap() {
                var h = document.getElementById('globalPageHeader');
                if (!h) return;
                var el = h.nextElementSibling;
                while (el && (el.tagName === 'STYLE' || el.tagName === 'SCRIPT')) {
                    el = el.nextElementSibling;
                }
                if (el) {
                    el.style.setProperty('padding-top', '6px', 'important');
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', tightenHeaderGap);
            } else {
                tightenHeaderGap();
            }
        })();
        </script>
        <?php
    }
}
?>
