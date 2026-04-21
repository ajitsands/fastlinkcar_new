<!doctype html>

<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-wide"
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/"
  data-template="horizontal-menu-template-no-customizer">
  <head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
	<style>
	    #logTable th:first-child,
        #logTable td:first-child {
            white-space: nowrap;
            overflow: hidden;
           
            max-width: 180px; /* adjust width as needed */
        }
	</style>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <!-- Navbar -->
			<?php include ROOT_PATH . '/view/templates/nav.php'; ?>
        <!-- / Navbar -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Menu -->
				<?php include ROOT_PATH . '/view/templates/menu.php'; ?>
            <!-- / Menu -->

            <!-- Content -->
            <div class="container-fluid flex-grow-1 container-p-y">
              <!-- Layout Demo -->
              <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-2">
                      <input class="form-control" type="date" id="logDate">
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-3">
                      <button id="clearLogBtn" type="button" class="btn rounded-pill btn-primary waves-effect waves-light">
                        <span class="icon-base ri ri-check-double-line icon-16px me-2"></span>Clear Logs
                      </button>
                  </div>
              </div>
              <div class="row mt-5">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                        <table class="dt-multilingual table table-bordered table-responsive dataTable dtr-column" id="logTable" class="display" width="100%">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                  </div>
              </div>
                

                

				    
              <!--/ Layout Demo -->
            </div>
            <!--/ Content -->

            <!-- Footer -->
					<?php include ROOT_PATH . '/view/templates/footer.php'; ?>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
      </div>
      
    </div>
    
<div id="loadingOverlay" style="display:none;position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.7);z-index:9999;text-align:center;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        <p>Loading...</p>
    </div>
</div>
<!-- Modal -->
<!-- PARAMS Modal -->
<div class="modal fade" id="paramModal" tabindex="-1" aria-labelledby="paramModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paramModalLabel">PARAMS Detail</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="paramModalBody">
        <!-- Full PARAMS content will be injected here -->
      </div>
      <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="copyParamBtn"><span class="ri ri-file-copy-2-line"></span> Copy</button>
       </div>
    </div>
  </div>
</div>

    
    
	<?php include ROOT_PATH . '/view/templates/scripts.php'; ?>

    <!-- Page JS -->
<!-- jQuery first -->
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

<!-- DataTables CSS/JS -->
<link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/flatpickr/flatpickr.css" />
<!-- Row Group CSS -->
<link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

  </body>
 <script>
 $(document).ready(function() {
     
    function loadLogs(date) {
    $('#loadingOverlay').show();

    $.ajax({
        url: '/GetEventLogDetails',
        type: 'POST',
        dataType: 'json',
        data: { date: date },
        success: function(res) {
            res.columns = res.columns || [];
            res.data = res.data || [];

            // Destroy existing DataTable
            if ($.fn.DataTable.isDataTable('#logTable')) {
                $('#logTable').DataTable().destroy();
                $('#logTable thead').empty();
                $('#logTable tbody').empty();
            }

            // Handle empty data
            if (res.columns.length === 0) {
                $('#logTable thead').html('<tr><th class="text-center">No logs found</th></tr>');
                $('#logTable').DataTable({
                    data: [],
                    columns: [{ data: null }],
                    pageLength: 10,
                    language: {
                        emptyTable: "No logs till generated on your selected date"
                    }
                });
                return;
            }

            // Build table header dynamically
            let header = '<tr>';
            let columns = [];
            res.columns.forEach(function(col, index) {
                const thStyle = index === 0 ? "white-space: nowrap; background-color: #EEEBEC; padding: 10px;" : "background-color: #EEEBEC; padding: 10px;";
                header += `<th style="${thStyle}">${col}</th>`;

                // If PARAMS column, add render function
                if (col.toUpperCase() === 'PARAMS') {
                    columns.push({
                        data: col,
                        render: function(data, type, row) {
                            if (!data) return '';
                            if (typeof data === 'object') data = JSON.stringify(data);
                            if (data.length > 100) {
                                const truncated = data.substring(0, 100) + '...';
                                return `<span class="truncated-param" style="cursor:pointer; color:#007bff;" data-full="${encodeURIComponent(data)}">${truncated}</span>`;
                            }
                            return data;
                        }
                    });
                } else {
                    columns.push({ data: col });
                }
            });
            header += '</tr>';
            $('#logTable thead').html(header);

            // Initialize DataTable
            $('#logTable').DataTable({
                data: res.data,
                columns: columns,
                pageLength: 10,
                order: [[0, 'desc']],
                scrollX: true,
                destroy: true,
                processing: true,
                language: {
                    emptyTable: "No logs till generated on your selected date"
                },
                createdRow: function(row, data, dataIndex) {
                    // Make first column nowrap
                    $('td:eq(0)', row).css('white-space', 'nowrap');
                }
            });
        },
        error: function() {
            alert('Error loading logs');
        },
        complete: function() {
            $('#loadingOverlay').hide();
        }
    });
}

// PARAMS modal
$(document).on('click', '.truncated-param', function() {
    const fullText = decodeURIComponent($(this).data('full'));
    $('#paramModalBody').text(fullText);
    const myModal = new bootstrap.Modal(document.getElementById('paramModal'));
    myModal.show();
});

// Copy PARAMS content when clicking "Copy" button
$('#copyParamBtn').on('click', function() {
    const text = $('#paramModalBody').text();
    if (!text) return;

    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    }).catch(err => {
        console.error('Failed to copy: ', err);
        alert('Copy failed!');
    });
});

   
    function refreshLogs() {
        let date = $('#logDate').val() || new Date().toISOString().split('T')[0];
        loadLogs(date);
    }

    // Call on page load
    refreshLogs();

    // Call when date changes
    $('#logDate').on('change', refreshLogs);    
        
        
    // Trigger load on date change
    // $('#logDate').on('change', function () {
    //     loadLogs($(this).val());
    // });
   
    // let date = $('#logDate').val() || new Date().toISOString().split('T')[0];
    // loadLogs(date);
    
    
    $('#clearLogBtn').on('click', function() {
        let date = $('#logDate').val();
        if (!date) {
            alert('Please select a date first.');
            return;
        }
    
        if (!confirm('Are you sure you want to delete all logs for ' + date + '?')) {
            return;
        }
    
        $.ajax({
            url: '/DeleteEventLogDetails',
            type: 'POST',
            data: { date: date },
            dataType: 'json',
            success: function(res) {
                if(res.status) {
                    alert(res.message);
                    // Optionally reload the table
                    $('#logTable').DataTable().clear().draw();
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function() {
                alert('AJAX error while deleting logs.');
            }
        });
    });
   
});

</script>
</html>
