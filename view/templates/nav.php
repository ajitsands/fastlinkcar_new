
        <nav class="layout-navbar navbar navbar-expand-xl align-items-center" id="layout-navbar">
          <div class="container-fluid">
            <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-6">
              <a href="/Dashboard" class="app-brand-link d-flex align-items-center gap-2">
                <span class="app-brand-logo demo d-flex align-items-center">
                  <img src="<?= $_ENV['BASE_URL'] ?>assets/img/logo_new/fastlinklogo_white%20(1).png" id="companyLogo" class="img-fluid app-logo" alt="Fast Link Logo" style="height: 32px; width: auto; object-fit: contain;">
                </span>
                <span class="app-brand-text demo menu-text fw-semibold text-white mb-0" style="font-size: 1.15rem; color: #ffffff !important;">Fastlink Car Rental Portal</span>
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="icon-base ri ri-close-line icon-sm"></i>
              </a>
            </div>

            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base ri ri-menu-line icon-22px"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
              <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                <!-- Search -->
                <li class="nav-item navbar-search-wrapper me-sm-2 me-xl-0">
                  <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);" >
                    <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
                  </a>
                </li>
                <!-- /Search -->

                <!-- Quick links -->
                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-sm-2 me-xl-0" style="display: none;">
                  <a
                    class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                    <i class="icon-base ri ri-star-smile-line icon-22px"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end p-0">
                    <div class="dropdown-menu-header border-bottom">
                      <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="mb-0 me-auto">Shortcuts</h6>
                        <a
                          href="javascript:void(0)"
                          class="btn btn-text-secondary rounded-pill btn-icon dropdown-shortcuts-add text-heading"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Add shortcuts">
                          <i class="icon-base ri ri-add-line text-heading"></i>
                        </a>
                      </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="icon-base ri ri-calendar-line icon-26px text-heading"></i>
                          </span>
                          <a href="app-calendar.html" class="stretched-link">Calendar</a>
                          <small>Appointments</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="icon-base ri ri-file-text-line icon-26px text-heading"></i>
                          </span>
                          <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                          <small>Manage Accounts</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="icon-base ri ri-user-line icon-26px text-heading"></i>
                          </span>
                          <a href="app-user-list.html" class="stretched-link">User App</a>
                          <small>Manage Users</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="icon-base ri ri-computer-line icon-26px text-heading"></i>
                          </span>
                          <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                          <small>Permission</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="icon-base ri ri-pie-chart-2-line icon-26px text-heading"></i>
                          </span>
                          <a href="index.html" class="stretched-link">Dashboard</a>
                          <small>User Dashboard</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="icon-base ri ri-settings-4-line icon-26px text-heading"></i>
                          </span>
                          <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                          <small>Account Settings</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="icon-base ri ri-question-line icon-26px text-heading"></i>
                          </span>
                          <a href="pages-faq.html" class="stretched-link">FAQs</a>
                          <small>FAQs & Articles</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="icon-base ri ri-tv-2-line icon-26px text-heading"></i>
                          </span>
                          <a href="modal-examples.html" class="stretched-link">Modals</a>
                          <small>Useful Popups</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <!-- Quick links -->

                <!-- Notification: Insurance & Passing Due Dates -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1" id="navExpiryNotifDropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill position-relative"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                    title="Insurance & Passing Alerts">
                    <i class="icon-base ri ri-notification-2-line icon-22px"></i>
                    <span id="navNotifBadgeCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 0.65rem; padding: 2px 5px;">0</span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end py-0" style="min-width: 340px;">
                    <li class="dropdown-menu-header border-bottom py-50">
                      <div class="dropdown-header d-flex align-items-center py-2">
                        <h6 class="mb-0 me-auto">Insurance &amp; Passing Alerts</h6>
                        <div class="d-flex align-items-center h6 mb-0">
                          <span id="navNotifHeaderCount" class="badge rounded-pill bg-label-primary fs-xsmall">0 Due</span>
                        </div>
                      </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container" style="max-height: 340px; overflow-y: auto;">
                      <ul class="list-group list-group-flush" id="navNotifList">
                        <li class="list-group-item text-center text-muted py-4 small">
                          Loading alerts...
                        </li>
                      </ul>
                    </li>
                    <li class="border-top">
                      <div class="d-grid p-3">
                        <a class="btn btn-primary btn-sm d-flex justify-content-center" href="/VehicleInsurance">
                          <small class="align-middle">View All Insurance &amp; Passings</small>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!-- Style Switcher / Light & Dark Mode Toggle -->
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-1">
                  <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill" 
                     href="javascript:void(0);" 
                     id="themeToggleBtn"
                     data-bs-toggle="dropdown" 
                     title="Toggle Theme">
                    <i class="icon-base ri ri-sun-line icon-22px" id="themeToggleIcon"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                        <span class="align-middle"><i class="ri-sun-line me-2"></i>Light</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                        <span class="align-middle"><i class="ri-moon-clear-line me-2"></i>Dark</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                        <span class="align-middle"><i class="ri-computer-line me-2"></i>System</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- / Style Switcher -->

                <!-- System Settings Button -->
                <li class="nav-item me-2 me-xl-1">
                  <a class="nav-link btn btn-icon btn-text-secondary rounded-pill" 
                     href="/SystemSettings" 
                     title="System Settings">
                    <i class="icon-base ri ri-settings-3-line icon-22px"></i>
                  </a>
                </li>
                <!-- / System Settings Button -->

<?php
$profileName = $_SESSION['profile_name'] ??  $_SESSION['user_name'] ?? 'User';
$userName = $_SESSION['user_name'] ?? 'User';
$userRole = $_SESSION['role_name'] ?? 'Admin';
$userImage = !empty($_SESSION['user_image']) 
            ? $_ENV['BASE_URL'].'assets/img/users/'.$_SESSION['user_image']
            : $_ENV['BASE_URL'].'assets/img/users/default.jpg';
?>
                <!-- User -->
               <li class="nav-item navbar-dropdown dropdown-user dropdown">

    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="<?= $userImage ?>" 
                 alt="avatar" 
                 class="rounded-circle" />
        </div>
    </a>

    <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">

        <!-- User Info -->
        <li>
            <a class="dropdown-item" href="/Profile">
                <div class="d-flex align-items-center">

                    <div class="flex-shrink-0 me-2">
                        <div class="avatar avatar-online">
                            <img src="<?= $userImage ?>"
                                 alt="profile"
                                 class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </div>

                    <div class="flex-grow-1">
                        <h6 class="mb-0 small">
                            <?= htmlspecialchars($profileName) ?>
                        </h6>
                        <small class="text-body-secondary">
                            <?= htmlspecialchars($userRole) ?>
                        </small>
                    </div>

                </div>
            </a>
        </li>

        <li>
            <div class="dropdown-divider"></div>
        </li>


        <!-- Profile -->
        <li>
            <a class="dropdown-item" href="/Profile">
                <i class="icon-base ri ri-user-3-line icon-22px me-3"></i>
                <span class="align-middle">My Profile</span>
            </a>
        </li>


        <li>
            <div class="dropdown-divider"></div>
        </li>


        <!-- Logout -->
        <li>
            <div class="d-grid px-4 pt-2 pb-1">
                <a class="btn btn-sm btn-danger d-flex" href="/Logout">
                    <small class="align-middle">Logout</small>
                    <i class="icon-base ri ri-logout-box-r-line ms-2 icon-16px"></i>
                </a>
            </div>
        </li>

    </ul>

</li>
                <!--/ User -->
              </ul>
            </div>
          </div>
        </nav>
