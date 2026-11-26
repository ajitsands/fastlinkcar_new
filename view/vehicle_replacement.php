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
        .vr-section {
            border-radius: 0.5rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }
        .vr-section-current {
            background-color: #fff5f5;
            border-color: #f5c2c7;
        }
        .vr-section-agreement {
            background-color: #f0f6ff;
            border-color: #b6d4fe;
        }
        .vr-section-replacement {
            background-color: #fffbeb;
            border-color: #fde68a;
        }
        .vr-section-title {
            font-weight: 700;
            font-size: 0.92rem;
            margin-bottom: 0.85rem;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0,0,0,0.07);
            padding-bottom: 0.45rem;
        }
        .vr-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0;
        }
        .vr-readonly {
            background-color: #e9ecef !important;
            color: #334155;
        }
        .vr-veh-card {
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid #dee2e6;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .vr-veh-img-box {
            background: #fff;
            min-height: 150px;
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
          <div class="card shadow-sm border-0">
            <div class="card-body pt-3">
              <div class="d-flex justify-content-end mb-2">
                <a href="/ContractList?val=<?php echo $this->encryption->encrypt('3,3-4'); ?>" class="btn btn-sm btn-outline-secondary">
                  <i class="ri-arrow-left-line me-1"></i> Back to Contract List
                </a>
              </div>
              <form id="vehicleReplacementForm" onsubmit="return false;">
                <input type="hidden" id="vr_agreement_id" value="">

                <!-- SECTION 1: CURRENT VEHICLE DETAILS -->
                <div class="vr-section vr-section-current">
                  <div class="vr-section-title">
                    <span><i class="ri-car-line text-danger me-1"></i> Current Vehicle Details</span>
                    <span class="badge bg-label-danger" id="vr_curr_status_badge">Select Active Vehicle</span>
                  </div>

                  <div class="row g-3">
                    <div class="col-12 col-lg-8">
                      <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Reg No. <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                              <select id="vr_curr_reg_select" class="form-select form-select-sm select2" style="width:100%;">
                                <option value="">-- Select Active Vehicle / Agreement --</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Vehicle Type</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_curr_type" class="form-control form-control-sm vr-readonly" readonly>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Model Year</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_curr_year" class="form-control form-control-sm vr-readonly" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Vehicle Color</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_curr_color" class="form-control form-control-sm vr-readonly" readonly>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">KM In</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_km_in" class="form-control form-control-sm" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="Enter return odometer">
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Fuel Level In</label>
                            <div class="col-sm-8">
                              <select id="vr_fuel_in" class="form-select form-select-sm">
                                <option value="0%">0%</option>
                                <option value="25%">25%</option>
                                <option value="50%">50%</option>
                                <option value="75%">75%</option>
                                <option value="100%">100%</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Parking Location In <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                              <select id="vr_parking_location_in" class="form-select form-select-sm">
                                <option value="">-- Select Parking Location --</option>
                                <option value="Main Parking">Main Parking</option>
                                <option value="Showroom">Showroom</option>
                                <option value="Airport Branch">Airport Branch</option>
                                <option value="Workshop / Garage">Workshop / Garage</option>
                                <option value="Yard">Yard</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Check In Type</label>
                            <div class="col-sm-8">
                              <select id="vr_check_in_type" class="form-select form-select-sm">
                                <option value="Replacement">Replacement</option>
                                <option value="Breakdown">Breakdown</option>
                                <option value="Maintenance / Service">Maintenance / Service</option>
                                <option value="Accident">Accident</option>
                                <option value="Customer Request">Customer Request</option>
                                <option value="Other">Other</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Current Vehicle Card -->
                    <div class="col-12 col-lg-4">
                      <div id="vr_curr_veh_card" class="vr-veh-card d-none h-100">
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

                <!-- SECTION 2: RENTAL/LEASE AGREEMENT DETAILS -->
                <div class="vr-section vr-section-agreement">
                  <div class="vr-section-title">
                    <span><i class="ri-file-text-line text-primary me-1"></i> Rental/Lease Agreement Details</span>
                    <span class="small text-muted" id="vr_ag_exp_return_badge"></span>
                  </div>

                  <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Agreement No.</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_no" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">RA Location</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_location" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Rental CPR No.</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_cpr" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Rental Name</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_name" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Fuel Level Out</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_fuel_out" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Rental Agreement Date</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_date" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Rental Amount</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_amount" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Last Replacement Date</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_last_repl" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Total Replacement</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_total_repl" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Last Invoice Date</label>
                        <div class="col-sm-8">
                          <input type="text" id="vr_ag_last_inv" class="form-control form-control-sm vr-readonly" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- SECTION 3: REPLACEMENT VEHICLE DETAILS -->
                <div class="vr-section vr-section-replacement">
                  <div class="vr-section-title">
                    <span><i class="ri-swap-line text-warning me-1"></i> Replacement Vehicle Details</span>
                    <span class="small text-muted">Filter available vehicles by Category &amp; Model</span>
                  </div>

                  <!-- Category & Model Filters -->
                  <div class="row g-2 mb-3 p-2 bg-white rounded border">
                    <div class="col-12 col-md-5">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Filter Category</label>
                        <div class="col-sm-8">
                          <select id="vr_filter_category" class="form-select form-select-sm select2" style="width:100%;">
                            <option value="">All Categories</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-5">
                      <div class="row align-items-center g-2">
                        <label class="col-sm-4 vr-label">Filter Model</label>
                        <div class="col-sm-8">
                          <select id="vr_filter_model" class="form-select form-select-sm select2" style="width:100%;">
                            <option value="">All Models</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-center justify-content-end">
                      <button type="button" id="vr_btn_open_picker" class="btn btn-sm btn-outline-warning text-dark w-100" title="Browse Available Vehicles">
                        <i class="ri-car-line me-1"></i> Pick Vehicle
                      </button>
                    </div>
                  </div>

                  <div class="row g-3">
                    <div class="col-12 col-lg-8">
                      <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Replacement Reg No. <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                              <div class="input-group input-group-sm">
                                <select id="vr_new_reg_select" class="form-select form-select-sm select2" style="width:calc(100% - 36px);">
                                  <option value="">-- Select Available Vehicle --</option>
                                </select>
                                <button type="button" id="vr_btn_picker_icon" class="btn btn-outline-secondary" title="Browse Available Vehicles">
                                  <i class="ri-roadster-line text-success"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Vehicle Type</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_new_type" class="form-control form-control-sm vr-readonly" readonly>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Model Year</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_new_year" class="form-control form-control-sm vr-readonly" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Vehicle Color</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_new_color" class="form-control form-control-sm vr-readonly" readonly>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">KM Out</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_new_km_out" class="form-control form-control-sm" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0">
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Fuel Level Out</label>
                            <div class="col-sm-8">
                              <select id="vr_new_fuel_out" class="form-select form-select-sm">
                                <option value="0%">0%</option>
                                <option value="25%">25%</option>
                                <option value="50%">50%</option>
                                <option value="75%">75%</option>
                                <option value="100%">100%</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Out Location</label>
                            <div class="col-sm-8">
                              <select id="vr_out_location" class="form-select form-select-sm">
                                <option value="Main Parking">Main Parking</option>
                                <option value="Showroom">Showroom</option>
                                <option value="Airport Branch">Airport Branch</option>
                                <option value="Yard">Yard</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Replaced By</label>
                            <div class="col-sm-8">
                              <input type="text" id="vr_replaced_by" class="form-control form-control-sm vr-readonly" value="<?= htmlspecialchars($loggedUserName) ?>" readonly>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Replacement Date <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                              <input type="date" id="vr_repl_date" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="row align-items-center g-2">
                            <label class="col-sm-4 vr-label">Replacement Time</label>
                            <div class="col-sm-8">
                              <input type="time" id="vr_repl_time" class="form-control form-control-sm" value="<?= date('H:i') ?>">
                            </div>
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

                <!-- REASON & SAVE -->
                <div class="row g-3 align-items-start mt-1">
                  <label class="col-sm-2 vr-label pt-2">Reason for Replacement</label>
                  <div class="col-sm-10">
                    <textarea id="vr_reason" class="form-control form-control-sm" rows="3" placeholder="Enter reason for vehicle replacement..."></textarea>
                  </div>
                </div>

                <div class="mt-3 d-flex justify-content-start gap-2">
                  <button type="submit" id="vr_btn_save" class="btn btn-primary px-4">
                    <i class="ri-save-line me-1"></i> Save
                  </button>
                  <button type="button" id="vr_btn_reset" class="btn btn-outline-secondary">
                    Reset
                  </button>
                </div>
              </form>
            </div>
          </div>
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

    function populateCurrentContract(c) {
        selectedContract = c || null;
        if (!c) {
            $('#vr_agreement_id').val('');
            $('#vr_curr_type, #vr_curr_year, #vr_curr_color, #vr_km_in').val('');
            $('#vr_ag_no, #vr_ag_location, #vr_ag_cpr, #vr_ag_name, #vr_ag_fuel_out, #vr_ag_date, #vr_ag_amount, #vr_ag_last_repl, #vr_ag_total_repl, #vr_ag_last_inv').val('');
            $('#vr_ag_exp_return_badge').text('');
            $('#vr_curr_veh_card').addClass('d-none');
            $('#vr_curr_status_badge').text('Select Active Vehicle');
            updateComplianceNotification();
            return;
        }

        $('#vr_agreement_id').val(c.contract_id);
        $('#vr_curr_status_badge').text('Rentout · ' + (c.agreement_no || ''));
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
        $('#vr_curr_veh_card').removeClass('d-none');
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

                // Populate Current Vehicle / Contract dropdown
                let cHtml = '<option value="">-- Select Active Vehicle / Agreement --</option>';
                allContracts.forEach(c => {
                    cHtml += `<option value="${c.contract_id}">${c.vehicle_no} (${c.agreement_no}) - ${c.customer_name || ''}</option>`;
                });
                $('#vr_curr_reg_select').html(cHtml);

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
                    $('#vr_curr_reg_select, #vr_filter_category, #vr_filter_model, #vr_new_reg_select').select2({ width: '100%' });
                }

                // Preselect if linked from Contract List
                let target = null;
                if (preContractId) {
                    target = allContracts.find(c => String(c.contract_id) === String(preContractId));
                } else if (preAgreementNo) {
                    target = allContracts.find(c => String(c.agreement_no) === String(preAgreementNo));
                }
                if (target) {
                    $('#vr_curr_reg_select').val(target.contract_id).trigger('change');
                    populateCurrentContract(target);
                }
            }
        });
    }

    $('#vr_curr_reg_select').on('change', function() {
        const cid = $(this).val();
        const c = allContracts.find(x => String(x.contract_id) === String(cid));
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
        $('#vr_curr_reg_select').val('').trigger('change');
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
            alert('Please select Current Vehicle / Agreement.');
            return;
        }
        if (!payload.parking_location_in) {
            alert('Please select Parking Location In.');
            return;
        }
        if (!payload.new_vehicle_id) {
            alert('Please select Replacement Reg No.');
            return;
        }
        if (!payload.replacement_date) {
            alert('Please select Replacement Date.');
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
                $btn.prop('disabled', false).html('<i class="ri-save-line me-1"></i> Save');
                if (res && res.status) {
                    alert(res.message || 'Vehicle replaced successfully!');
                    window.location.href = '/ContractList?val=<?= urlencode($this->encryption->encrypt("3,3-4")) ?>';
                } else {
                    alert((res && res.message) ? res.message : 'Failed to replace vehicle.');
                }
            },
            error: function() {
                $btn.prop('disabled', false).html('<i class="ri-save-line me-1"></i> Save');
                alert('Server error while saving vehicle replacement.');
            }
        });
    });

    loadInitData();
});
</script>
</body>
</html>
