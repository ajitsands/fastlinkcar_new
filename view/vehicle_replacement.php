<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /Logout");
    exit();
}
$preselectContractId = isset($_GET['contract_id']) ? trim($_GET['contract_id']) : '';
$preselectAgreementNo = isset($_GET['agreement_no']) ? trim($_GET['agreement_no']) : '';
$loggedUserName = $_SESSION['user_name'] ?? ($_SESSION['username'] ?? ($_SESSION['full_name'] ?? 'Staff'));
?>
<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="../assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include('templates/head.php'); ?>
    <link rel="stylesheet" href="../assets/vendor/libs/select2/select2.css" />
    <style>
        .vr-veh-card {
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .vr-veh-img-box {
            background: #f8fafc;
            min-height: 155px;
            position: relative;
            border-right: 1px solid #eef0f3;
        }
        .vr-veh-img-box img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 0.5rem;
        }
        .vr-readonly {
            background-color: #f8fafc !important;
            color: #334155;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
  <div class="layout-container">
    <?php include('templates/nav.php'); ?>
    <div class="layout-page">
      <div class="content-wrapper">
        <?php include('templates/menu.php'); ?>

        <div class="container-fluid flex-grow-1 container-p-y">
          <div id="vr_page_alert" class="d-none mb-3"></div>

          <form id="vehicleReplacementForm" onsubmit="return false;">
            <input type="hidden" id="vr_agreement_id" value="">

            <!-- CARD 1: CUSTOMER & AGREEMENT SEARCH -->
            <div class="card shadow-sm border-0 mb-3">
              <div class="card-header bg-primary-subtle text-primary fw-bold py-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <span><i class="ri-search-line me-1"></i> Step 1: Find Customer &amp; Active Agreement</span>
                <a href="/ContractList?val=<?php echo $this->encryption->encrypt('3,3-4'); ?>" class="btn btn-sm btn-outline-primary bg-white">
                  <i class="ri-arrow-left-line me-1"></i> Back to Contract List
                </a>
              </div>
              <div class="card-body pt-3 pb-3">
                <div class="row g-3 align-items-center">
                  <div class="col-12 col-md-6">
                    <label for="vr_customer_select" class="form-label fw-semibold small mb-1">
                      <i class="ri-user-search-line text-primary me-1"></i> Customer Search (Name / Mobile / CPR)
                    </label>
                    <select id="vr_customer_select" class="form-select select2" style="width:100%;">
                      <option value="">-- All Active Customers --</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="vr_curr_reg_select" class="form-label fw-semibold small mb-1">
                      <i class="ri-file-search-line text-primary me-1"></i> Agreement / Current Vehicle Search <span class="text-danger">*</span>
                    </label>
                    <select id="vr_curr_reg_select" class="form-select select2" style="width:100%;">
                      <option value="">-- Select Agreement No. or Vehicle Reg No. --</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- DETAILS CONTAINER (Auto-displayed once agreement is selected) -->
            <div id="vr_details_wrapper" class="d-none">

              <!-- CARD 2: CURRENT VEHICLE DETAILS -->
              <div class="card shadow-sm border border-danger-subtle mb-3">
                <div class="card-header bg-danger-subtle text-danger fw-bold py-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
                  <span><i class="ri-car-line me-1"></i> Current Vehicle Details &amp; Check-In</span>
                  <span class="badge bg-danger text-white" id="vr_curr_status_badge">Rentout</span>
                </div>
                <div class="card-body pt-3">
                  <div class="row g-3">
                    <div class="col-12 col-lg-8">
                      <div class="row g-3">
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="vr_curr_reg_no" class="form-control form-control-sm vr-readonly" readonly placeholder="Reg No.">
                            <label for="vr_curr_reg_no">Reg No.</label>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-5">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="vr_curr_type" class="form-control form-control-sm vr-readonly" readonly placeholder="Vehicle Type">
                            <label for="vr_curr_type">Vehicle Type</label>
                          </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-2">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="vr_curr_year" class="form-control form-control-sm vr-readonly" readonly placeholder="Year">
                            <label for="vr_curr_year">Model Year</label>
                          </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-2">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="vr_curr_color" class="form-control form-control-sm vr-readonly" readonly placeholder="Color">
                            <label for="vr_curr_color">Color</label>
                          </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="vr_km_in" class="form-control form-control-sm" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="KM In">
                            <label for="vr_km_in">KM In</label>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <select id="vr_fuel_in" class="form-select form-select-sm">
                              <option value="0%">0%</option>
                              <option value="25%">25%</option>
                              <option value="50%">50%</option>
                              <option value="75%">75%</option>
                              <option value="100%">100%</option>
                            </select>
                            <label for="vr_fuel_in">Fuel Level In</label>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <select id="vr_parking_location_in" class="form-select form-select-sm">
                              <option value="">-- Select Location --</option>
                              <option value="Main Parking">Main Parking</option>
                              <option value="Showroom">Showroom</option>
                              <option value="Airport Branch">Airport Branch</option>
                              <option value="Workshop / Garage">Workshop / Garage</option>
                              <option value="Yard">Yard</option>
                            </select>
                            <label for="vr_parking_location_in">Parking Location In *</label>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <select id="vr_check_in_type" class="form-select form-select-sm">
                              <option value="Replacement">Replacement</option>
                              <option value="Breakdown">Breakdown</option>
                              <option value="Maintenance / Service">Maintenance / Service</option>
                              <option value="Accident">Accident</option>
                              <option value="Customer Request">Customer Request</option>
                              <option value="Other">Other</option>
                            </select>
                            <label for="vr_check_in_type">Check In Type</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Current Vehicle Card -->
                    <div class="col-12 col-lg-4">
                      <div id="vr_curr_veh_card" class="vr-veh-card h-100">
                        <div class="row g-0 h-100">
                          <div class="col-5 vr-veh-img-box">
                            <img id="vr_curr_card_img" src="uploads/vehicleImages/default.jpg" onerror="this.onerror=null;this.src='uploads/vehicleImages/default.jpg';" alt="Current Vehicle">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size:0.65rem;">Rentout</span>
                          </div>
                          <div class="col-7 p-2 d-flex flex-column justify-content-between">
                            <div>
                              <h6 class="mb-0 fw-bold text-danger text-truncate" id="vr_curr_card_no">-</h6>
                              <small class="fw-semibold text-dark d-block text-truncate" id="vr_curr_card_title">-</small>
                            </div>
                            <div class="small text-secondary mt-1">
                              <div><i class="ri-calendar-line me-1"></i>Year: <strong id="vr_curr_card_year">-</strong></div>
                              <div><i class="ri-palette-line me-1"></i>Color: <strong id="vr_curr_card_color">-</strong></div>
                              <div><i class="ri-speed-up-line me-1"></i>KM Out: <strong id="vr_curr_card_km">-</strong></div>
                              <div><i class="ri-shield-check-line me-1"></i>Ins: <strong id="vr_curr_card_ins">-</strong></div>
                              <div><i class="ri-file-check-line me-1"></i>Pass: <strong id="vr_curr_card_pass">-</strong></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- CARD 3: RENTAL/LEASE AGREEMENT DETAILS -->
              <div class="card shadow-sm border border-info-subtle mb-3">
                <div class="card-header bg-info-subtle text-info fw-bold py-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
                  <span><i class="ri-file-text-line me-1"></i> Rental / Lease Agreement Details</span>
                  <span class="badge bg-info text-white" id="vr_ag_exp_return_badge"></span>
                </div>
                <div class="card-body pt-3">
                  <div class="row g-3">
                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_no" class="form-control form-control-sm vr-readonly" readonly placeholder="Agreement No.">
                        <label for="vr_ag_no">Agreement No.</label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_location" class="form-control form-control-sm vr-readonly" readonly placeholder="RA Location">
                        <label for="vr_ag_location">RA Location</label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_cpr" class="form-control form-control-sm vr-readonly" readonly placeholder="Rental CPR No.">
                        <label for="vr_ag_cpr">Rental CPR No.</label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_name" class="form-control form-control-sm vr-readonly" readonly placeholder="Rental Name">
                        <label for="vr_ag_name">Rental Name</label>
                      </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_fuel_out" class="form-control form-control-sm vr-readonly" readonly placeholder="Fuel Level Out">
                        <label for="vr_ag_fuel_out">Fuel Level Out</label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_date" class="form-control form-control-sm vr-readonly" readonly placeholder="Rental Agreement Date">
                        <label for="vr_ag_date">Rental Agreement Date</label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_amount" class="form-control form-control-sm vr-readonly" readonly placeholder="Rental Amount">
                        <label for="vr_ag_amount">Rental Amount</label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_last_repl" class="form-control form-control-sm vr-readonly" readonly placeholder="Last Replacement Date">
                        <label for="vr_ag_last_repl">Last Replacement Date</label>
                      </div>
                    </div>
                    <div class="col-6 col-md-1">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_total_repl" class="form-control form-control-sm vr-readonly" readonly placeholder="Total">
                        <label for="vr_ag_total_repl">Repl. #</label>
                      </div>
                    </div>
                    <div class="col-6 col-md-1">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="vr_ag_last_inv" class="form-control form-control-sm vr-readonly" readonly placeholder="Last Invoice">
                        <label for="vr_ag_last_inv">Last Inv.</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- CARD 4: REPLACEMENT VEHICLE DETAILS -->
              <div class="card shadow-sm border border-warning-subtle mb-3">
                <div class="card-header bg-warning-subtle text-dark fw-bold py-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
                  <span><i class="ri-swap-line text-warning me-1"></i> Replacement Vehicle Details</span>
                  <span class="small text-muted fw-normal">Filter available vehicles by Category &amp; Model</span>
                </div>
                <div class="card-body pt-3">
                  <!-- Category & Model Filters -->
                  <div class="row g-2 mb-3 p-2 bg-light rounded border">
                    <div class="col-12 col-md-5">
                      <label for="vr_filter_category" class="form-label fw-semibold small mb-1">Filter Category</label>
                      <select id="vr_filter_category" class="form-select form-select-sm select2" style="width:100%;">
                        <option value="">All Categories</option>
                      </select>
                    </div>
                    <div class="col-12 col-md-5">
                      <label for="vr_filter_model" class="form-label fw-semibold small mb-1">Filter Model</label>
                      <select id="vr_filter_model" class="form-select form-select-sm select2" style="width:100%;">
                        <option value="">All Models</option>
                      </select>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-end">
                      <button type="button" id="vr_btn_open_picker" class="btn btn-sm btn-warning w-100" title="Browse Available Vehicles">
                        <i class="ri-car-line me-1"></i> Pick Vehicle
                      </button>
                    </div>
                  </div>

                  <div class="row g-3">
                    <div class="col-12 col-lg-8">
                      <div class="row g-3">
                        <div class="col-12 col-md-5">
                          <label for="vr_new_reg_select" class="form-label fw-semibold small mb-1">Replacement Reg No. <span class="text-danger">*</span></label>
                          <div class="input-group input-group-sm">
                            <select id="vr_new_reg_select" class="form-select form-select-sm select2" style="width:calc(100% - 38px);">
                              <option value="">-- Select Available Vehicle --</option>
                            </select>
                            <button type="button" id="vr_btn_picker_icon" class="btn btn-outline-secondary" title="Browse Available Vehicles">
                              <i class="ri-roadster-line text-success"></i>
                            </button>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <label class="form-label fw-semibold small mb-1">Vehicle Type</label>
                          <input type="text" id="vr_new_type" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2">
                          <label class="form-label fw-semibold small mb-1">Model Year</label>
                          <input type="text" id="vr_new_year" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2">
                          <label class="form-label fw-semibold small mb-1">Color</label>
                          <input type="text" id="vr_new_color" class="form-control form-control-sm vr-readonly" readonly>
                        </div>

                        <div class="col-6 col-sm-4 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="vr_new_km_out" class="form-control form-control-sm" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="KM Out">
                            <label for="vr_new_km_out">KM Out</label>
                          </div>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <select id="vr_new_fuel_out" class="form-select form-select-sm">
                              <option value="0%">0%</option>
                              <option value="25%">25%</option>
                              <option value="50%">50%</option>
                              <option value="75%">75%</option>
                              <option value="100%">100%</option>
                            </select>
                            <label for="vr_new_fuel_out">Fuel Level Out</label>
                          </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <select id="vr_out_location" class="form-select form-select-sm">
                              <option value="Main Parking">Main Parking</option>
                              <option value="Showroom">Showroom</option>
                              <option value="Airport Branch">Airport Branch</option>
                              <option value="Yard">Yard</option>
                            </select>
                            <label for="vr_out_location">Out Location</label>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <input type="text" id="vr_replaced_by" class="form-control form-control-sm vr-readonly" value="<?= htmlspecialchars($loggedUserName) ?>" readonly placeholder="Replaced By">
                            <label for="vr_replaced_by">Replaced By</label>
                          </div>
                        </div>

                        <div class="col-6 col-sm-3 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <input type="date" id="vr_repl_date" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>">
                            <label for="vr_repl_date">Replacement Date *</label>
                          </div>
                        </div>
                        <div class="col-6 col-sm-3 col-md-3">
                          <div class="form-floating form-floating-outline">
                            <input type="time" id="vr_repl_time" class="form-control form-control-sm" value="<?= date('H:i') ?>">
                            <label for="vr_repl_time">Replacement Time</label>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-floating form-floating-outline">
                            <textarea id="vr_reason" class="form-control form-control-sm" style="height:58px;" placeholder="Reason for Replacement"></textarea>
                            <label for="vr_reason">Reason for Replacement</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Replacement Vehicle Card + Insurance & Passing Notification -->
                    <div class="col-12 col-lg-4">
                      <div id="vr_new_veh_card" class="vr-veh-card d-none">
                        <div class="row g-0">
                          <div class="col-5 vr-veh-img-box">
                            <img id="vr_new_card_img" src="uploads/vehicleImages/default.jpg" onerror="this.onerror=null;this.src='uploads/vehicleImages/default.jpg';" alt="Replacement Vehicle">
                            <span class="badge bg-success position-absolute top-0 start-0 m-2" style="font-size:0.65rem;">Available</span>
                          </div>
                          <div class="col-7 p-2 d-flex flex-column justify-content-between">
                            <div>
                              <h6 class="mb-0 fw-bold text-primary text-truncate" id="vr_new_card_no">-</h6>
                              <small class="fw-semibold text-dark d-block text-truncate" id="vr_new_card_title">-</small>
                            </div>
                            <div class="small text-secondary mt-1">
                              <div><i class="ri-calendar-line me-1"></i>Year: <strong id="vr_new_card_year">-</strong></div>
                              <div><i class="ri-palette-line me-1"></i>Color: <strong id="vr_new_card_color">-</strong></div>
                              <div><i class="ri-gas-station-line me-1"></i>Fuel: <strong id="vr_new_card_fuel">-</strong></div>
                              <div><i class="ri-speed-up-line me-1"></i>KM: <strong id="vr_new_card_km">-</strong></div>
                              <div><i class="ri-shield-check-line me-1"></i>Ins: <strong id="vr_new_card_ins">-</strong></div>
                              <div><i class="ri-file-check-line me-1"></i>Pass: <strong id="vr_new_card_pass">-</strong></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="vr_compliance_alert" class="mt-2 d-none"></div>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-end gap-2 py-2">
                  <button type="button" id="vr_btn_reset" class="btn btn-outline-secondary">
                    <i class="ri-refresh-line me-1"></i> Reset
                  </button>
                  <button type="submit" id="vr_btn_save" class="btn btn-primary px-4">
                    <i class="ri-save-line me-1"></i> Save Replacement
                  </button>
                </div>
              </div>
            </div>

            <!-- Empty state prompt when no agreement is selected -->
            <div id="vr_empty_prompt" class="card shadow-sm border-0">
              <div class="card-body text-center py-5 text-muted">
                <i class="ri-search-eye-line fs-1 text-primary d-block mb-2"></i>
                <h6 class="fw-bold text-dark mb-1">Select a Customer or Active Agreement Above</h6>
                <p class="small mb-0">Once an agreement is selected, current vehicle details, rental contract summary, and replacement vehicle options will appear automatically.</p>
              </div>
            </div>
          </form>
        </div>

        <?php include('templates/footer.php'); ?>
      </div>
    </div>
  </div>
</div>

<!-- Available Vehicles Picker Modal -->
<div class="modal fade" id="vrPickerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-warning-subtle py-2">
        <h6 class="modal-title fw-bold text-dark"><i class="ri-car-line me-1"></i> Select Available Replacement Vehicle</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-2 mb-3">
          <div class="col-md-4">
            <select id="vr_modal_cat" class="form-select form-select-sm"><option value="">All Categories</option></select>
          </div>
          <div class="col-md-4">
            <select id="vr_modal_mod" class="form-select form-select-sm"><option value="">All Models</option></select>
          </div>
          <div class="col-md-4">
            <input type="text" id="vr_modal_search" class="form-control form-control-sm" placeholder="Search Reg No / Color / Year...">
          </div>
        </div>
        <div id="vr_modal_grid" class="row g-3"></div>
      </div>
    </div>
  </div>
</div>

<?php include('templates/scripts.php'); ?>
<script src="../assets/vendor/libs/select2/select2.js"></script>
<script>
$(function() {
    const preContractId = <?= json_encode($preselectContractId) ?>;
    const preAgreementNo = <?= json_encode($preselectAgreementNo) ?>;

    let allContracts = [];
    let allCategories = [];
    let allModels = [];
    let allAvailableVehicles = [];
    let selectedContract = null;

    function showPageAlert(type, msg) {
        $('#vr_page_alert')
            .removeClass('d-none')
            .html(`<div class="alert alert-${type} alert-dismissible fade show py-2 px-3 mb-0" role="alert">${msg}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function fmtDate24(val, dateOnly) {
        if (!val || val === '0000-00-00' || val === '0000-00-00 00:00:00') return '-';
        const s = String(val).trim();
        const isDOnly = dateOnly || /^\d{4}-\d{2}-\d{2}$/.test(s);
        const dt = new Date(s.replace(' ', 'T'));
        if (isNaN(dt.getTime())) return s;
        return isDOnly
            ? dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })
            : dt.toLocaleString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false });
    }

    function parseDateOnly(val) {
        if (!val || val === '0000-00-00' || val === 'NA') return null;
        const s = String(val).trim().slice(0, 10);
        if (!/^\d{4}-\d{2}-\d{2}$/.test(s)) return null;
        const d = new Date(s + 'T00:00:00');
        return isNaN(d.getTime()) ? null : d;
    }

    function setSelectFuel($el, val) {
        if (!val) return;
        const v = String(val).trim();
        if ($el.find('option[value="' + v + '"]').length) {
            $el.val(v);
        }
    }

    function populateAgreementDropdown(customerCode, preserveContractId) {
        const filtered = customerCode
            ? allContracts.filter(c => String(c.customer_code) === String(customerCode))
            : allContracts;
        let html = '<option value="">-- Select Agreement No. or Vehicle Reg No. (' + filtered.length + ') --</option>';
        filtered.forEach(c => {
            html += `<option value="${c.contract_id}">${c.agreement_no} | ${c.vehicle_no} (${c.customer_name || ''})</option>`;
        });
        $('#vr_curr_reg_select').html(html);
        if (preserveContractId && filtered.some(c => String(c.contract_id) === String(preserveContractId))) {
            $('#vr_curr_reg_select').val(preserveContractId);
        } else if (customerCode && filtered.length === 1) {
            // Auto-select if customer has only 1 active agreement
            $('#vr_curr_reg_select').val(filtered[0].contract_id);
        } else {
            $('#vr_curr_reg_select').val('');
        }
        $('#vr_curr_reg_select').trigger('change.select2');
        const cid = $('#vr_curr_reg_select').val();
        const found = allContracts.find(x => String(x.contract_id) === String(cid));
        populateCurrentContract(found || null);
    }

    function populateCurrentContract(c) {
        selectedContract = c || null;
        if (!c) {
            $('#vr_agreement_id').val('');
            $('#vr_details_wrapper').addClass('d-none');
            $('#vr_empty_prompt').removeClass('d-none');
            updateComplianceNotification();
            return;
        }

        $('#vr_details_wrapper').removeClass('d-none');
        $('#vr_empty_prompt').addClass('d-none');

        $('#vr_agreement_id').val(c.contract_id);
        $('#vr_curr_status_badge').text('Rentout · ' + (c.agreement_no || ''));
        $('#vr_curr_reg_no').val(c.vehicle_no || '-');
        $('#vr_curr_type').val([c.category_name, c.model_name].filter(Boolean).join(' - '));
        $('#vr_curr_year').val(c.vehicle_year || '-');
        $('#vr_curr_color').val(c.vehicle_color || '-');
        $('#vr_km_in').val(c.km_out || '');

        // Agreement details
        $('#vr_ag_no').val(c.agreement_no || '-');
        $('#vr_ag_location').val(c.ra_location || '-');
        $('#vr_ag_cpr').val(c.customer_cpr || '-');
        $('#vr_ag_name').val(c.customer_name || '-');
        $('#vr_ag_fuel_out').val(c.fuel_level_out || '-');
        $('#vr_ag_date').val(fmtDate24(c.agreement_date, false));
        $('#vr_ag_amount').val((c.rental_amount || '0.000') + ' BHD');
        $('#vr_ag_last_repl').val(c.last_replacement_date ? fmtDate24(c.last_replacement_date, false) : 'None');
        $('#vr_ag_total_repl').val(c.total_replacement || 0);
        $('#vr_ag_last_inv').val(c.last_invoice_date ? fmtDate24(c.last_invoice_date, true) : 'None');
        $('#vr_ag_exp_return_badge').text(c.expected_return_date ? ('Expected Return: ' + fmtDate24(c.expected_return_date, false)) : '');

        // Current Vehicle Card
        $('#vr_curr_card_no').text(c.vehicle_no || '-');
        $('#vr_curr_card_title').text([c.category_name, c.model_name].filter(Boolean).join(' ') || '-');
        $('#vr_curr_card_year').text(c.vehicle_year || '-');
        $('#vr_curr_card_color').text(c.vehicle_color || '-');
        $('#vr_curr_card_km').text(c.km_out || '0');
        $('#vr_curr_card_ins').text(fmtDate24(c.next_insurance_date, true));
        $('#vr_curr_card_pass').text(fmtDate24(c.next_passing_date, true));
        $('#vr_curr_card_img').attr('src', c.last_image ? ('uploads/vehicleImages/' + c.last_image) : 'uploads/vehicleImages/default.jpg');

        updateComplianceNotification();
    }

    function populateModelDropdown($select, catId) {
        const filtered = catId
            ? allModels.filter(m => String(m.category_id) === String(catId))
            : allModels;
        let html = '<option value="">All Models</option>';
        filtered.forEach(m => {
            html += `<option value="${m.ids}">${m.model_name}</option>`;
        });
        $select.html(html).trigger('change.select2');
    }

    function getFilteredAvailableVehicles(catId, modId) {
        return allAvailableVehicles.filter(v => {
            if (catId && String(v.vehicle_category_id) !== String(catId)) return false;
            if (modId && String(v.vehicle_model_id) !== String(modId)) return false;
            return true;
        });
    }

    function refreshAvailableDropdown() {
        const catId = $('#vr_filter_category').val();
        const modId = $('#vr_filter_model').val();
        const list = getFilteredAvailableVehicles(catId, modId);
        const prevVal = $('#vr_new_reg_select').val();
        let html = '<option value="">-- Select Available Vehicle (' + list.length + ') --</option>';
        list.forEach(v => {
            const label = [v.vehicle_number, v.category_name, v.model_name, v.vehicle_color].filter(Boolean).join(' - ');
            html += `<option value="${v.ids}">${label}</option>`;
        });
        $('#vr_new_reg_select').html(html);
        if (prevVal && list.some(v => String(v.ids) === String(prevVal))) {
            $('#vr_new_reg_select').val(prevVal);
        } else {
            $('#vr_new_reg_select').val('');
            populateNewVehicle(null);
        }
        $('#vr_new_reg_select').trigger('change.select2');
    }

    function populateNewVehicle(v) {
        if (!v) {
            $('#vr_new_type, #vr_new_year, #vr_new_color, #vr_new_km_out').val('');
            $('#vr_new_veh_card').addClass('d-none');
            $('#vr_compliance_alert').addClass('d-none').html('');
            return;
        }
        $('#vr_new_type').val([v.category_name, v.model_name].filter(Boolean).join(' - '));
        $('#vr_new_year').val(v.vehicle_year || '-');
        $('#vr_new_color').val(v.vehicle_color || '-');
        $('#vr_new_km_out').val(v.odo_meter || '0');
        setSelectFuel($('#vr_new_fuel_out'), v.fuel_level);

        $('#vr_new_veh_card').removeClass('d-none');
        $('#vr_new_card_no').text(v.vehicle_number || '-');
        $('#vr_new_card_title').text([v.category_name, v.model_name].filter(Boolean).join(' ') || '-');
        $('#vr_new_card_year').text(v.vehicle_year || '-');
        $('#vr_new_card_color').text(v.vehicle_color || '-');
        $('#vr_new_card_fuel').text(v.fuel_type || 'Petrol');
        $('#vr_new_card_km').text(v.odo_meter || '0');
        $('#vr_new_card_ins').text(fmtDate24(v.next_insurance_date, true));
        $('#vr_new_card_pass').text(fmtDate24(v.next_passing_date, true));
        $('#vr_new_card_img').attr('src', v.last_image ? ('uploads/vehicleImages/' + v.last_image) : 'uploads/vehicleImages/default.jpg');

        updateComplianceNotification(v);
    }

    function updateComplianceNotification(vOverride) {
        const vehId = $('#vr_new_reg_select').val();
        const v = vOverride || allAvailableVehicles.find(x => String(x.ids) === String(vehId));
        if (!v) {
            $('#vr_compliance_alert').addClass('d-none').html('');
            return;
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const contractEnd = selectedContract ? parseDateOnly(selectedContract.expected_return_date) : null;
        const insDate = parseDateOnly(v.next_insurance_date);
        const passDate = parseDateOnly(v.next_passing_date);

        const warnings = [];
        const checkDoc = (label, dt) => {
            if (!dt) {
                warnings.push(`${label} date is not set.`);
                return;
            }
            if (dt < today) {
                warnings.push(`${label} EXPIRED on ${fmtDate24(dt.toISOString().slice(0, 10), true)}.`);
            } else if (contractEnd && dt <= contractEnd) {
                warnings.push(`${label} expires on ${fmtDate24(dt.toISOString().slice(0, 10), true)}, which falls within the contract period (Return: ${fmtDate24(selectedContract.expected_return_date, true)}).`);
            }
        };

        checkDoc('Insurance', insDate);
        checkDoc('Passing', passDate);

        if (warnings.length) {
            $('#vr_compliance_alert')
                .removeClass('d-none')
                .html(`<div class="alert alert-danger py-2 px-3 mb-0 small fw-semibold"><i class="ri-error-warning-line me-1"></i><strong>Insurance / Passing Alert:</strong><ul class="mb-0 ps-3 mt-1">${warnings.map(w => `<li>${w}</li>`).join('')}</ul></div>`);
        } else {
            $('#vr_compliance_alert')
                .removeClass('d-none')
                .html(`<div class="alert alert-success py-2 px-3 mb-0 small fw-semibold"><i class="ri-shield-check-line me-1"></i>Insurance &amp; Passing dates are valid${contractEnd ? ' through the contract return date' : ''}.</div>`);
        }
    }

    function renderPickerGrid() {
        const catId = $('#vr_modal_cat').val();
        const modId = $('#vr_modal_mod').val();
        const q = ($('#vr_modal_search').val() || '').toLowerCase().trim();
        let list = getFilteredAvailableVehicles(catId, modId);
        if (q) {
            list = list.filter(v =>
                (v.vehicle_number || '').toLowerCase().includes(q) ||
                (v.category_name || '').toLowerCase().includes(q) ||
                (v.model_name || '').toLowerCase().includes(q) ||
                (v.vehicle_color || '').toLowerCase().includes(q) ||
                String(v.vehicle_year || '').includes(q)
            );
        }
        if (!list.length) {
            $('#vr_modal_grid').html('<div class="col-12 text-center text-muted py-4">No available vehicles match the selected filters.</div>');
            return;
        }
        const html = list.map(v => `
            <div class="col-12 col-md-6 col-lg-4">
              <div class="vr-veh-card h-100 p-2 d-flex flex-column justify-content-between">
                <div class="d-flex gap-2">
                  <img src="${v.last_image ? ('uploads/vehicleImages/' + v.last_image) : 'uploads/vehicleImages/default.jpg'}" onerror="this.onerror=null;this.src='uploads/vehicleImages/default.jpg';" style="width:90px;height:70px;object-fit:contain;border-radius:6px;border:1px solid #eee;">
                  <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-bold text-primary text-truncate">${v.vehicle_number || '-'}</div>
                    <div class="small fw-semibold text-truncate">${[v.category_name, v.model_name].filter(Boolean).join(' ')}</div>
                    <div class="small text-muted">${v.vehicle_year || '-'} · ${v.vehicle_color || '-'} · KM: ${v.odo_meter || 0}</div>
                    <div class="small text-muted">Ins: ${fmtDate24(v.next_insurance_date, true)} | Pass: ${fmtDate24(v.next_passing_date, true)}</div>
                  </div>
                </div>
                <button type="button" class="btn btn-sm btn-primary mt-2 w-100 vr-pick-btn" data-id="${v.ids}">Select Vehicle</button>
              </div>
            </div>
        `).join('');
        $('#vr_modal_grid').html(html);
    }

    function loadInitData() {
        $.ajax({
            url: '/VehicleReplacementController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'initData' }),
            dataType: 'json',
            success: function(res) {
                if (!res || !res.status) return;
                allContracts = res.contracts || [];
                allCategories = res.categories || [];
                allModels = res.models || [];
                allAvailableVehicles = res.available_vehicles || [];

                if (res.replaced_by) {
                    $('#vr_replaced_by').val(res.replaced_by);
                }

                // Populate Customer Search dropdown (distinct customers with active Rentout contracts)
                const custMap = new Map();
                allContracts.forEach(c => {
                    if (c.customer_code && !custMap.has(String(c.customer_code))) {
                        custMap.set(String(c.customer_code), c);
                    }
                });
                let custHtml = '<option value="">-- All Active Customers (' + custMap.size + ') --</option>';
                custMap.forEach(c => {
                    const meta = [c.customer_mobile, c.customer_cpr].filter(Boolean).join(' / ');
                    custHtml += `<option value="${c.customer_code}">${c.customer_name || c.customer_code}${meta ? ' (' + meta + ')' : ''}</option>`;
                });
                $('#vr_customer_select').html(custHtml);

                // Populate Agreement dropdown
                populateAgreementDropdown('', '');

                // Populate Category & Model filters
                let catHtml = '<option value="">All Categories</option>';
                allCategories.forEach(cat => {
                    catHtml += `<option value="${cat.ids}">${cat.category_name}</option>`;
                });
                $('#vr_filter_category, #vr_modal_cat').html(catHtml);
                populateModelDropdown($('#vr_filter_model'), '');
                populateModelDropdown($('#vr_modal_mod'), '');
                refreshAvailableDropdown();

                if ($.fn.select2) {
                    $('#vr_customer_select, #vr_curr_reg_select, #vr_filter_category, #vr_filter_model, #vr_new_reg_select').select2({ width: '100%' });
                }

                // Preselect if linked from Contract List
                let target = null;
                if (preContractId) {
                    target = allContracts.find(c => String(c.contract_id) === String(preContractId));
                } else if (preAgreementNo) {
                    target = allContracts.find(c => String(c.agreement_no) === String(preAgreementNo));
                }
                if (target) {
                    $('#vr_customer_select').val(target.customer_code).trigger('change.select2');
                    populateAgreementDropdown(target.customer_code, target.contract_id);
                }
            }
        });
    }

    $('#vr_customer_select').on('change', function() {
        const custCode = $(this).val();
        populateAgreementDropdown(custCode, '');
    });

    $('#vr_curr_reg_select').on('change', function() {
        const cid = $(this).val();
        const c = allContracts.find(x => String(x.contract_id) === String(cid));
        if (c && c.customer_code && String($('#vr_customer_select').val()) !== String(c.customer_code)) {
            $('#vr_customer_select').val(c.customer_code).trigger('change.select2');
        }
        populateCurrentContract(c || null);
    });

    $('#vr_filter_category').on('change', function() {
        populateModelDropdown($('#vr_filter_model'), $(this).val());
        refreshAvailableDropdown();
    });

    $('#vr_filter_model').on('change', function() {
        refreshAvailableDropdown();
    });

    $('#vr_new_reg_select').on('change', function() {
        const vid = $(this).val();
        const v = allAvailableVehicles.find(x => String(x.ids) === String(vid));
        populateNewVehicle(v || null);
    });

    $('#vr_btn_open_picker, #vr_btn_picker_icon').on('click', function() {
        $('#vr_modal_cat').val($('#vr_filter_category').val());
        populateModelDropdown($('#vr_modal_mod'), $('#vr_modal_cat').val());
        $('#vr_modal_mod').val($('#vr_filter_model').val());
        renderPickerGrid();
        new bootstrap.Modal(document.getElementById('vrPickerModal')).show();
    });

    $('#vr_modal_cat').on('change', function() {
        populateModelDropdown($('#vr_modal_mod'), $(this).val());
        renderPickerGrid();
    });
    $('#vr_modal_mod, #vr_modal_search').on('change input', renderPickerGrid);

    $(document).on('click', '.vr-pick-btn', function() {
        const vid = $(this).data('id');
        $('#vr_filter_category').val($('#vr_modal_cat').val()).trigger('change.select2');
        populateModelDropdown($('#vr_filter_model'), $('#vr_modal_cat').val());
        $('#vr_filter_model').val($('#vr_modal_mod').val()).trigger('change.select2');
        refreshAvailableDropdown();
        $('#vr_new_reg_select').val(vid).trigger('change');
        const modalEl = document.getElementById('vrPickerModal');
        const m = bootstrap.Modal.getInstance(modalEl);
        if (m) m.hide();
    });

    $('#vr_btn_reset').on('click', function() {
        $('#vr_customer_select').val('').trigger('change');
        $('#vr_filter_category').val('').trigger('change');
        $('#vr_parking_location_in').val('');
        $('#vr_check_in_type').val('Replacement');
        $('#vr_reason').val('');
    });

    $('#vehicleReplacementForm').on('submit', function(e) {
        e.preventDefault();
        const payload = {
            action: 'saveReplacement',
            agreement_id: $('#vr_agreement_id').val(),
            km_in: $('#vr_km_in').val(),
            fuel_level_in: $('#vr_fuel_in').val(),
            parking_location_in: $('#vr_parking_location_in').val(),
            check_in_type: $('#vr_check_in_type').val(),
            new_vehicle_id: $('#vr_new_reg_select').val(),
            km_out: $('#vr_new_km_out').val(),
            fuel_level_out: $('#vr_new_fuel_out').val(),
            out_location: $('#vr_out_location').val(),
            replacement_date: $('#vr_repl_date').val(),
            replacement_time: $('#vr_repl_time').val(),
            reason: $('#vr_reason').val()
        };

        if (!payload.agreement_id) {
            showPageAlert('warning', 'Please select a Customer and Agreement.');
            return;
        }
        if (!payload.parking_location_in) {
            showPageAlert('warning', 'Please select Parking Location In.');
            return;
        }
        if (!payload.new_vehicle_id) {
            showPageAlert('warning', 'Please select Replacement Reg No.');
            return;
        }
        if (!payload.replacement_date) {
            showPageAlert('warning', 'Please select Replacement Date.');
            return;
        }

        const $btn = $('#vr_btn_save').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');
        $.ajax({
            url: '/VehicleReplacementController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html('<i class="ri-save-line me-1"></i> Save Replacement');
                if (res && res.status) {
                    showPageAlert('success', res.message || 'Vehicle replaced successfully! Redirecting to Contract List...');
                    setTimeout(function() {
                        window.location.href = '/ContractList?val=<?= urlencode($this->encryption->encrypt("3,3-4")) ?>';
                    }, 1200);
                } else {
                    showPageAlert('danger', (res && res.message) ? res.message : 'Failed to replace vehicle.');
                }
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="ri-save-line me-1"></i> Save Replacement');
                showPageAlert('danger', 'Server error while saving vehicle replacement.');
            }
        });
    });

    loadInitData();
});
</script>
</body>
</html>
