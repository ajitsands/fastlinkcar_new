<!doctype html>
<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/"
  data-template="horizontal-menu-template-no-customizer">
<head>
  <title>Overdue Calculation Rules - Fastlink Car Rental</title>
  <?php include ROOT_PATH . '/view/templates/head.php'; ?>
</head>
<body>
  <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
      <?php include ROOT_PATH . '/view/templates/nav.php'; ?>

      <div class="layout-page">
        <div class="content-wrapper">
          <?php include ROOT_PATH . '/view/templates/menu.php'; ?>

          <div class="container-fluid flex-grow-1" style="padding-top: 12px !important;">
            <div class="row g-4">
              <!-- Summary Banner -->
              <div class="col-12">
                <div class="card border-0 shadow-sm">
                  <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                      <div>
                        <h5 class="mb-1 fw-bold text-primary">
                          <i class="ri ri-calculator-line me-2"></i>How Overdue Charges Are Calculated
                        </h5>
                        <p class="text-muted mb-0">
                          Reference guide for how overdue duration and charges are computed on the <strong>Active Contracts Dashboard</strong>.
                        </p>
                      </div>
                      <a href="/ActiveContractsDashboard?val=<?= $this->encryption->encrypt('7,7-1') ?>" class="btn btn-primary btn-sm">
                        <i class="ri ri-arrow-left-line me-1"></i> Back to Active Contracts
                      </a>
                    </div>

                    <div class="row g-3">
                      <div class="col-md-4">
                        <div class="border rounded p-3 h-100 bg-lighter">
                          <div class="fw-bold text-dark mb-1"><i class="ri ri-calendar-event-line text-primary me-1"></i> 1. Effective Return Date</div>
                          <small class="text-muted">
                            Uses the <strong>latest extension end date/time</strong> if the contract has been extended; otherwise uses the original contract return date/time (<code>period_to</code> / <code>service_end_date_time</code>).
                          </small>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="border rounded p-3 h-100 bg-lighter">
                          <div class="fw-bold text-dark mb-1"><i class="ri ri-time-line text-warning me-1"></i> 2. Grace Period (1 Hour)</div>
                          <small class="text-muted">
                            A uniform <strong>1-hour (3,600 seconds)</strong> grace period is applied after the effective return date/time for <strong>Hourly, Daily, Weekly, and Monthly</strong> contracts before overdue charges begin.
                          </small>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="border rounded p-3 h-100 bg-lighter">
                          <div class="fw-bold text-dark mb-1"><i class="ri ri-price-tag-3-line text-success me-1"></i> 3. Rate Source Priority</div>
                          <small class="text-muted">
                            <strong>Primary:</strong> Vehicle Model Pricing Configuration (<code>With Driver</code> or <code>Without Driver</code>).<br>
                            <strong>Fallback:</strong> Contract/Extension unit price formula if model pricing is not configured.
                          </small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Rate Type Breakdown Table -->
              <div class="col-12">
                <div class="card border-0 shadow-sm">
                  <div class="card-header border-bottom">
                    <h6 class="mb-0 fw-bold"><i class="ri ri-list-check-2 me-2 text-primary"></i>Overdue Formula by Contract Type</h6>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                      <thead class="table-light">
                        <tr>
                          <th style="width: 15%;">Contract Type</th>
                          <th style="width: 15%;">Grace Period</th>
                          <th style="width: 35%;">Calculation Rule</th>
                          <th style="width: 35%;">Fallback Formula (When Model Price Not Set)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span class="badge bg-label-info">Hourly</span></td>
                          <td>1 Hour</td>
                          <td>
                            <code>overdue_hours = ceil((now - effective_end) / 3600)</code><br>
                            <strong>Charge =</strong> <code>overdue_hours × Model Hourly Rate</code>
                          </td>
                          <td>
                            Uses contract/extension <code>unit_price</code> (or <code>formulaDaily / 24</code>).
                          </td>
                        </tr>
                        <tr>
                          <td><span class="badge bg-label-primary">Daily</span></td>
                          <td>1 Hour</td>
                          <td>
                            <code>overdue_days = ceil((now - effective_end) / 86400)</code><br>
                            <strong>Charge =</strong> <code>overdue_days × Model Daily Rate</code>
                          </td>
                          <td>
                            Uses contract/extension <code>unit_price</code> (or <code>baseAmount / duration</code>).
                          </td>
                        </tr>
                        <tr>
                          <td><span class="badge bg-label-warning">Weekly</span></td>
                          <td>1 Hour</td>
                          <td>
                            <code>completed_weeks = floor(overdue_days / 7)</code><br>
                            <code>extra_days = overdue_days % 7</code><br>
                            <strong>Charge =</strong> <code>(completed_weeks × Model Weekly Rate) + (extra_days × Model Daily Rate)</code>
                          </td>
                          <td>
                            Weekly rate = <code>unit_price</code> (or <code>formulaDaily × 7</code>);<br>
                            Daily rate = <code>unit_price / 7</code>.
                          </td>
                        </tr>
                        <tr>
                          <td><span class="badge bg-label-success">Monthly</span></td>
                          <td>1 Hour</td>
                          <td>
                            Uses calendar difference between effective return date and current time:<br>
                            <code>completed_months</code> (full calendar months) + <code>extra_days</code> (remaining days, rounded up for partial day).<br>
                            <strong>Charge =</strong> <code>(completed_months × Model Monthly Rate) + (extra_days × Model Daily Rate)</code>
                          </td>
                          <td>
                            Monthly rate = <code>unit_price</code> (or <code>formulaDaily × 30</code>);<br>
                            Daily rate = <code>unit_price / 30</code>.
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Worked Examples -->
              <div class="col-12">
                <div class="card border-0 shadow-sm">
                  <div class="card-header border-bottom">
                    <h6 class="mb-0 fw-bold"><i class="ri ri-lightbulb-line me-2 text-warning"></i>Worked Examples</h6>
                  </div>
                  <div class="card-body">
                    <div class="row g-3">
                      <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                          <div class="fw-bold mb-1">Monthly Contract (1 Month + 4 Days Late)</div>
                          <p class="small text-muted mb-0">
                            Model Monthly = <code>150.000 BHD</code>, Model Daily = <code>8.000 BHD</code>.<br>
                            Overdue = <code>(1 × 150.000) + (4 × 8.000) = <strong>182.000 BHD</strong></code>.
                          </p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                          <div class="fw-bold mb-1">Weekly Contract (10 Days Late)</div>
                          <p class="small text-muted mb-0">
                            Model Weekly = <code>45.000 BHD</code>, Model Daily = <code>8.000 BHD</code>.<br>
                            10 days = 1 week + 3 days.<br>
                            Overdue = <code>(1 × 45.000) + (3 × 8.000) = <strong>69.000 BHD</strong></code>.
                          </p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                          <div class="fw-bold mb-1">Hourly Contract (3 Hours Late)</div>
                          <p class="small text-muted mb-0">
                            Model Hourly = <code>3.000 BHD</code>.<br>
                            Past 1-hour grace period → 3 overdue hours.<br>
                            Overdue = <code>3 × 3.000 = <strong>9.000 BHD</strong></code>.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
  </div>
  <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
</body>
</html>
