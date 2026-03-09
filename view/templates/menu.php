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
           <div data-i18n="Activities">Activities</div>
         </a>

         <ul class="menu-sub">
           <li class="menu-item <?php if ($decrypt[0] == '2-1') {
                                  echo 'active';
                                } ?>">
             <a href="/RegisterVehicles?val=<?php echo $this->encryption->encrypt('2,2-1'); ?>" class="menu-link">

               <i class="menu-icon icon-base ri ri-car-line"></i>
               <div data-i18n="Register">Register</div>
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


         </ul>
       </li>
     </ul>
   </div>
 </aside>