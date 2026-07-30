<?php
session_start();

function checkLogin()
{
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header("Location: /Logout");
        exit();
    }
}

checkLogin();
?>
<?php 
// view/expected_return_report.php
include ROOT_PATH . '/view/envinclude.php';

// Helper function to render a vehicle card in JS
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
          
          <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports /</span> Expected Return Vehicles</h4>
          
          <!-- Filter Card -->
          <div class="card mb-4">
            <div class="card-body">
              <form id="filterForm">
                <div class="row g-3 align-items-end">
                  <div class="col-md-4">
                    <label class="form-label" for="start_date">From Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>" required />
                  </div>
                  <div class="col-md-4">
                    <label class="form-label" for="end_date">To Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required />
                  </div>
                  <div class="col-md-4">
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 w-100 w-md-auto" id="btnSearch">
                        <i class="ri-search-line"></i> Search Vehicles
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Loader -->
          <div id="loader" class="text-center d-none my-5">
              <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
              </div>
          </div>

          <!-- Results Section -->
          <div id="resultsContainer" class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 d-none">
              <!-- Cards will be populated here by JavaScript -->
          </div>

          <!-- No Data State -->
          <div id="noDataContainer" class="text-center my-5 d-none">
              <i class="ri-car-line text-muted mb-3" style="font-size: 3rem;"></i>
              <h5 class="text-muted">No vehicles expected to return in this date range.</h5>
          </div>

                    </div>
                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

<script>
$(document).ready(function() {
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();

        if(!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        if(new Date(startDate) > new Date(endDate)) {
            alert('From Date cannot be later than To Date.');
            return;
        }

        // UI State
        $('#btnSearch').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Searching...');
        $('#resultsContainer').empty().addClass('d-none');
        $('#noDataContainer').addClass('d-none');
        $('#loader').removeClass('d-none');

        $.ajax({
            url: '/ExpectedReturns',
            type: 'POST',
            data: {
                action: 'search',
                start_date: startDate,
                end_date: endDate
            },
            dataType: 'json',
            success: function(response) {
                $('#loader').addClass('d-none');
                $('#btnSearch').prop('disabled', false).html('<i class="ri-search-line"></i> Search Vehicles');

                if (response.status === 'success') {
                    if (response.data.length > 0) {
                        $('#resultsContainer').removeClass('d-none');
                        response.data.forEach(function(v) {
                            $('#resultsContainer').append(createCard(v));
                        });
                    } else {
                        $('#noDataContainer').removeClass('d-none');
                    }
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                $('#loader').addClass('d-none');
                $('#btnSearch').prop('disabled', false).html('<i class="ri-search-line"></i> Search Vehicles');
                alert('An error occurred while fetching the report.');
            }
        });
    });

    function createCard(v) {
        return `
        <div class="col">
          <div class="card h-100">
            <img class="card-img-top" src="${v.image}" alt="Vehicle Image" style="height: 200px; object-fit: cover;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-1">
                <h5 class="card-title mb-0 pe-2">${v.model}</h5>
                <span class="badge bg-label-danger">${v.status}</span>
              </div>
              <h6 class="card-subtitle text-muted mb-3">${v.number} | ${v.year}</h6>
              
              <div class="mt-3" style="font-size: 0.85rem;">
                <div class="mb-1 text-truncate" title="${v.customer_name}"><strong>On Rent To:</strong> ${v.customer_name}</div>
                <strong class="text-danger">Expected Return:</strong><br>
                ${v.expected_return}
              </div>
            </div>
          </div>
        </div>`;
    }
});
</script>

</body>
</html>
