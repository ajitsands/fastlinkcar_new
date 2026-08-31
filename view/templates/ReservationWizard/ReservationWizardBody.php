<?php
// Fetch allowed companies based on user session
$loggedInCompanyId = strval($_SESSION['company_id'] ?? '1');
$userCompanyIds = [$loggedInCompanyId];
if (!empty($_SESSION['company_json'])) {
    $cArr = json_decode($_SESSION['company_json'], true);
    if (is_array($cArr)) {
        foreach ($cArr as $c) {
            if (!empty($c['ids'])) {
                $userCompanyIds[] = strval($c['ids']);
            }
        }
    }
}
$userCompanyIds = array_unique($userCompanyIds);
$allowedCompanies = [];

$pdoObj = new CommonPDOModel();
if (in_array($_SESSION['role_name'] ?? '', ['Super Admin', 'Administrator']) || ($_SESSION['role_id'] ?? 0) == 3 || ($_SESSION['role_id'] ?? 0) == 1) {
    // Super admin/admin sees all
    $sqlComp = "SELECT ids, company_name, company_code FROM tbl_company WHERE status='Active' ORDER BY ids ASC";
    $compRes = $pdoObj->ListFromTable($sqlComp);
    $allowedCompanies = json_decode($compRes, true)['data'] ?? [];
} else {
    $idListStr = implode("','", array_map('addslashes', $userCompanyIds));
    $sqlComp = "SELECT ids, company_name, company_code FROM tbl_company WHERE status='Active' AND ids IN ('{$idListStr}') ORDER BY ids ASC";
    $compRes = $pdoObj->ListFromTable($sqlComp);
    $allowedCompanies = json_decode($compRes, true)['data'] ?? [];
}

// Select the first company by default or logged in company
$defaultCompanyId = !empty($allowedCompanies) ? $allowedCompanies[0]['ids'] : $loggedInCompanyId;
$isMultiCompany = count($allowedCompanies) > 1;
?>
<div class="container-fluid px-2 mt-1">

  <div class="bs-stepper wizard-modern wizard-modern-example mt-2" id="reservationWizard">
    <!-- Wizard Header -->
    <div class="bs-stepper-header">
      <!-- Step 1 -->
      <div class="step active" data-target="#step-booking-type">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-number">01</span>
            <span class="d-flex flex-column ms-2">
              <span class="bs-stepper-title">Booking Type</span>
              <span class="bs-stepper-subtitle">Select Customer</span>
            </span>
          </span>
        </button>
      </div>
      <div class="line"></div>
      <!-- Step 2 -->
      <div class="step" data-target="#step-booking-details">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-number">02</span>
            <span class="d-flex flex-column ms-2">
              <span class="bs-stepper-title">Booking Details</span>
              <span class="bs-stepper-subtitle">Setup dates & prices</span>
            </span>
          </span>
        </button>
      </div>
      <div class="line"></div>
      <!-- Step 3 -->
      <div class="step" data-target="#step-vehicle-selection">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-number">03</span>
            <span class="d-flex flex-column ms-2">
              <span class="bs-stepper-title">Vehicle Selection</span>
              <span class="bs-stepper-subtitle">Check availability</span>
            </span>
          </span>
        </button>
      </div>
    </div>

    <!-- Wizard Content -->
    <div class="bs-stepper-content">
      <form onSubmit="return false">
        
        <!-- Step 1: Booking Type -->
        <div id="step-booking-type" class="content active dstepper-block">
          <div class="content-header mb-4">
            <h6 class="mb-0">Booking Type & Customer</h6>
            <small>Select the type of booking and locate the customer.</small>
          </div>
          
          <div class="row g-4">
            <div class="col-12 col-md-6">
              <div class="card mb-3 shadow-none border">
                <div class="card-header fw-semibold">Registration Company</div>
                <div class="card-body">
                  <select id="reservationCompanySelect" class="form-select" <?= !$isMultiCompany ? 'disabled' : '' ?>>
                    <?php foreach($allowedCompanies as $comp): ?>
                      <option value="<?= $comp['ids'] ?>" data-code="<?= htmlspecialchars($comp['company_code']) ?>" <?= $comp['ids'] == $defaultCompanyId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($comp['company_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              
              <div class="card mb-3 shadow-none border">
                <div class="card-header fw-semibold">Booking Type</div>
                <div class="card-body">
                  <select id="bookingTypeMain" class="form-select">
                    <option value="direct" selected>Direct Booking</option>
                    <option value="quotation">Against Quotation</option>
                  </select>
                </div>
              </div>

              <!-- DIRECT BOOKING SECTION -->
              <div id="directSection">
                <div class="card mb-3 shadow-none border">
                  <div class="card-header fw-semibold">Search Customer</div>
                  <div class="card-body">
                    <div class="d-flex align-items-stretch gap-2">
                      <div class="form-floating form-floating-outline flex-grow-1">
                        <select id="selectCustomerFromSelect2" name="customer_name" class="select2 form-select" data-allow-clear="true" style="width:100%"></select>
                      </div>
                      <button type="button" id="addCustomerBtn" class="btn btn-primary d-flex align-items-center justify-content-center" title="Add New Customer">
                        <i class="ri ri-user-add-line" style="font-size:20px;"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- QUOTATION SECTION -->
              <div id="quotationSection" class="d-none">
                <div class="card mb-3 shadow-none border">
                  <div class="card-header fw-semibold">Search Quotation</div>
                  <div class="card-body">
                    <input type="text" class="form-control" id="searchQuotation" placeholder="Type quotation no">
                  </div>
                </div>
                <div class="card mb-3 shadow-none border">
                  <div class="card-header fw-semibold">Quotation List</div>
                  <div class="card-body p-2 quotation-list-scroll" id="quotationList">
                    <div class="text-muted small text-center">No quotations found</div>
                  </div>
                </div>
                <div class="card shadow-none border">
                  <div class="card-header fw-semibold">Quotation Preview</div>
                  <div class="card-body quotation-preview-scroll" id="quotationPreview">
                    <div class="text-muted small text-center">Select a quotation to preview details</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <!-- CUSTOMER DETAILS -->
              <div class="card mb-1 shadow-none border">
                <div class="card-header fw-semibold">Customer Details</div>
                <div class="card-body">
                  <input type="hidden" id="customer_code" name="customer_code">
                  <div class="row g-2">
                    <div class="col-12 col-md-6">
                      <label class="form-label small">Customer Name</label>
                      <input type="text" class="form-control form-control-sm" id="customerName" placeholder="Customer Name" readonly>
                    </div>
                    <div class="col-12 col-md-6">
                      <label class="form-label small">Telephone</label>
                      <input type="text" class="form-control form-control-sm" id="customerPhone" placeholder="Telephone" >
                    </div>
                    <div class="col-12 col-md-6">
                      <label class="form-label small">Email</label>
                      <input type="email" class="form-control form-control-sm" id="customerEmail" placeholder="Email" >
                    </div>
                    <div class="col-12 col-md-6">
                      <label class="form-label small">Attention</label>
                      <input type="text" class="form-control form-control-sm" id="customerAttention" placeholder="Attention" >
                    </div>
                    <div class="col-12 col-md-6">
                      <label class="form-label small">CPR/CR</label>
                      <input type="text" class="form-control form-control-sm" id="customercprcr" placeholder="CPR/CR" >
                    </div>
                    <div class="col-12">
                      <label class="form-label small">Address</label>
                      <textarea class="form-control form-control-sm" id="customerAddress" rows="2" placeholder="Address" ></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-12 d-flex justify-content-between mt-4">
              <button type="button" class="btn btn-outline-secondary btn-prev" disabled>
                <i class="icon-base ri ri-arrow-left-line icon-sm me-sm-1 me-0"></i>
                <span class="align-middle">Previous</span>
              </button>
              <button type="button" class="btn btn-primary btn-next">
                <span class="align-middle me-1">Next</span>
                <i class="icon-base ri ri-arrow-right-line icon-sm"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Step 2: Booking Details -->
        <div id="step-booking-details" class="content">
          <div class="content-header mb-4">
            <h6 class="mb-0">Booking Details</h6>
            <small>Enter reservation dates, rates, and duration.</small>
          </div>
          
          <div class="row g-4">
            <div class="col-12">
              <div class="card shadow-none border">
                <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                  <span>Booking Details</span>
                  <div class="d-flex align-items-center gap-2">
                    <span class="text-primary small">Total: <span id="lineTotal">0.000</span></span>
                  </div>
                </div>
                <div class="card-body">
                  <input type="hidden" id="quotationRef">
                  <input type="hidden" id="ModelRef" class="watch-field">

                  <div class="row g-3">
                    <div class="col-12 col-md-4">
                      <label class="form-label small">Vehicle Model</label>
                      <div id="dropdownContainer" class="w-100"></div>
                    </div>
                    <div class="col-12 col-md-4">
                      <label class="form-label small">From Date</label>
                      <input type="text" class="from_datetime form-control form-control-sm watch-field datetime_col" placeholder="DD-MM-YYYY HH:mm" maxlength="16">
                    </div>
                    <div class="col-12 col-md-4">
                      <label class="form-label small">To Date</label>
                      <input type="text" class="to_datetime form-control form-control-sm watch-field datetime_col" placeholder="DD-MM-YYYY HH:mm" maxlength="16">
                    </div>

                    <div class="col-12 col-md-4">
                      <label class="form-label small">Type</label>
                      <select class="rate_type form-control form-control-sm watch-field">
                        <option value="0">Select</option>
                        <option value="hour">Hourly</option>
                        <option value="day">Daily</option>
                        <option value="week">Weekly</option>
                        <option value="month">Monthly</option>
                      </select>
                    </div>

                    <div class="col-12 col-md-4">
                      <label class="form-label small">Service</label>
                      <select class="service form-control form-control-sm watch-field">
                        <option value="0">Select Service</option>
                        <option value="1" data-id="10">Rental Without Driver</option>
                        <option value="2" data-id="0">Rental With Driver</option>
                      </select>
                    </div>

                    <div class="col-12 col-md-4">
                      <label class="form-label small">Duration</label>
                      <input type="number" class="duration nav form-control form-control-sm" value="0">
                    </div>
                    
                    <div class="col-12 col-md-4">
                      <label class="form-label small">Unit Price</label>
                      <div style="position:relative;">
                        <span class="min-price-text badge bg-danger" style="position:absolute; top:-8px; right:8px; font-size:10px; z-index:2;">Min: 0.000</span>
                        <input type="number" class="price nav form-control form-control-sm" value="0" style="padding-top:12px;">
                      </div>
                      <input type="hidden" class="minprice nav form-control">
                    </div>
                    
                    <div class="col-12 col-md-4">
                      <label class="form-label small">VAT %</label>
                      <input type="number" class="vat nav form-control form-control-sm" value="10">
                    </div>
                    
                    <div class="col-12">
                      <label class="form-label small">Booking Notes</label>
                      <textarea id="booking_notes" class="form-control form-control-sm" rows="3" placeholder="Booking notes if any..."></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 d-flex justify-content-between mt-4">
              <button type="button" class="btn btn-outline-secondary btn-prev">
                <i class="icon-base ri ri-arrow-left-line icon-sm me-sm-1 me-0"></i>
                <span class="align-middle">Previous</span>
              </button>
              <button type="button" class="btn btn-primary btn-next">
                <span class="align-middle me-1">Next</span>
                <i class="icon-base ri ri-arrow-right-line icon-sm"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Step 3: Vehicle Selection -->
        <div id="step-vehicle-selection" class="content">
          <div class="content-header mb-4">
            <h6 class="mb-0">Vehicle Selection</h6>
            <small>Select the model and check vehicle availability.</small>
          </div>
          
          <div class="row g-4">
            <div class="col-12">
              <div class="card shadow-none border h-100">
                <div class="card-header p-2">
                  <div class="input-group">
                    <input type="text" id="vehicleSearch" class="form-control" placeholder="Search vehicles...">
                    <button class="btn btn-primary" type="button" id="btnSearchVehicle">
                      <i class="ri ri-search-line"></i>
                    </button>
                    <button class="btn btn-success d-none" type="button" id="btnCheckAvailability" data-bs-toggle="tooltip" data-bs-placement="top" title="Check Availability">
                      <i class="ri ri-checkbox-circle-line fs-4"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-2 vehicle-scroll">
                  <div class="row g-2" id="vehicleContainer"></div>
                </div>
              </div>
            </div>

            <div class="col-12 d-flex justify-content-between mt-4">
              <button type="button" class="btn btn-outline-secondary btn-prev">
                <i class="icon-base ri ri-arrow-left-line icon-sm me-sm-1 me-0"></i>
                <span class="align-middle">Previous</span>
              </button>
              <button type="button" class="btn btn-success btn-submit d-none" id="proceedSelectedVehicles">Submit Reservation</button>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
