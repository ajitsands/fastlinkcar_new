<?php 
// view/vehicle_insight_report.php
include ROOT_PATH . '/view/envinclude.php';

// Helper function to render a vehicle card
function renderVehicleCard($v) {
    $statusColor = 'secondary';
    if (strtolower($v['status']) === 'available') $statusColor = 'success';
    if (strtolower($v['status']) === 'rented' || strtolower($v['status']) === 'rentout') $statusColor = 'danger';
    if (strtolower($v['status']) === 'reserved') $statusColor = 'warning';

    $html = '
    <div class="col">
      <div class="card h-100">
        <img class="card-img-top" src="'.htmlspecialchars($v['image']).'" alt="Vehicle Image" style="height: 200px; object-fit: cover;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-1">
            <h5 class="card-title mb-0 pe-2">'.htmlspecialchars($v['model']).'</h5>
            <span class="badge bg-label-'.$statusColor.'">'.((strtolower($v['status']) === 'rented' || strtolower($v['status']) === 'rentout') ? 'RentOut' : htmlspecialchars($v['status'])).'</span>
          </div>
          <h6 class="card-subtitle text-muted mb-3">'.htmlspecialchars($v['number']).' | '.htmlspecialchars($v['year']).'</h6>';

    if ((strtolower($v['status']) === 'rented' || strtolower($v['status']) === 'rentout') && $v['contract']) {
        $html .= '
          <div class="mt-3" style="font-size: 0.85rem;">
            <strong>On Rent To:</strong> '.htmlspecialchars($v['contract']['customer_name']).'<br>
            <strong class="text-danger">Expected Return:</strong><br>
            '.htmlspecialchars(date('d M Y, h:i A', strtotime($v['contract']['expected_return_date']))).'
          </div>';
    }

    if (strtolower($v['status']) === 'reserved' && !empty($v['reservations'])) {
        $next_booking = $v['reservations'][0];
        $html .= '
          <div class="mt-3" style="font-size: 0.85rem;">
            <div class="mb-1 text-truncate" title="'.htmlspecialchars($next_booking['customer_name']).'"><strong>Reserved By:</strong> '.htmlspecialchars($next_booking['customer_name']).'</div>
            <strong class="text-warning">From:</strong> '.htmlspecialchars(date('d M Y', strtotime($next_booking['start_date']))).' &nbsp;|&nbsp; 
            <strong class="text-warning">To:</strong> '.htmlspecialchars(date('d M Y', strtotime($next_booking['end_date']))).'
          </div>';
    }

    $html .= '
        </div>
      </div>
    </div>';

    return $html;
}
?>
<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
</head>
<body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <?php include ROOT_PATH . '/view/templates/nav.php'; ?>
            <div class="layout-page">
                <div class="content-wrapper">
                    <?php include ROOT_PATH . '/view/templates/menu.php'; ?>
                    <div class="container-fluid flex-grow-1 container-p-y" style="padding-top: 100px !important;">
          
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> Vehicle Insights</h4>
          
          <!-- Summary Metrics -->
          <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                      <span>Total Vehicles</span>
                      <div class="d-flex align-items-center my-2">
                        <h3 class="mb-0 me-2"><?= $summary['total'] ?></h3>
                      </div>
                    </div>
                    <span class="badge bg-label-primary rounded p-2"><i class="ri-car-line ri-sm"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                      <span>Available</span>
                      <div class="d-flex align-items-center my-2">
                        <h3 class="mb-0 me-2"><?= $summary['available'] ?></h3>
                      </div>
                    </div>
                    <span class="badge bg-label-success rounded p-2"><i class="ri-check-line ri-sm"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                      <span>On Rent</span>
                      <div class="d-flex align-items-center my-2">
                        <h3 class="mb-0 me-2"><?= $summary['rented'] ?></h3>
                      </div>
                    </div>
                    <span class="badge bg-label-danger rounded p-2"><i class="ri-steering-2-line ri-sm"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                      <span>Reserved</span>
                      <div class="d-flex align-items-center my-2">
                        <h3 class="mb-0 me-2"><?= $summary['reserved'] ?></h3>
                      </div>
                    </div>
                    <span class="badge bg-label-warning rounded p-2"><i class="ri-calendar-check-line ri-sm"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabs Navigation -->
          <div class="nav-align-top mb-4">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-all" aria-controls="navs-all" aria-selected="true">
                  All Vehicles
                </button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-available" aria-controls="navs-available" aria-selected="false">
                  Available
                </button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-rented" aria-controls="navs-rented" aria-selected="false">
                  On Rent
                </button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-reserved" aria-controls="navs-reserved" aria-selected="false">
                  Reserved Vehicles
                </button>
              </li>
            </ul>

            <div class="tab-content" style="background: transparent; padding: 20px 0; border: none; box-shadow: none;">
              
              <!-- Tab All Vehicles -->
              <div class="tab-pane fade show active" id="navs-all" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                  <?php foreach ($all_vehicles_data as $v): ?>
                    <?= renderVehicleCard($v) ?>
                  <?php endforeach; ?>
                </div>
              </div>

              <!-- Tab Available -->
              <div class="tab-pane fade" id="navs-available" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                  <?php foreach ($all_vehicles_data as $v): 
                    if (strtolower($v['status']) === 'available'): ?>
                      <?= renderVehicleCard($v) ?>
                  <?php endif; endforeach; ?>
                </div>
              </div>

              <!-- Tab On Rent -->
              <div class="tab-pane fade" id="navs-rented" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                  <?php foreach ($all_vehicles_data as $v): 
                    if (strtolower($v['status']) === 'rented' || strtolower($v['status']) === 'rentout'): ?>
                      <?= renderVehicleCard($v) ?>
                  <?php endif; endforeach; ?>
                </div>
              </div>

              <!-- Tab Reserved -->
              <div class="tab-pane fade" id="navs-reserved" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                  <?php foreach ($all_vehicles_data as $v): 
                    if (strtolower($v['status']) === 'reserved'): ?>
                      <?= renderVehicleCard($v) ?>
                  <?php endif; endforeach; ?>
                </div>
              </div>

            </div>
          </div>

                    </div>
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
</body>
</html>
