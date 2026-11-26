<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /Logout");
    exit();
}
include ROOT_PATH . '/view/envinclude.php';
require_once ROOT_PATH . '/pdf/print_settings_helper.php';

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;
$companies = $pdo->query("SELECT ids, company_name FROM tbl_company WHERE status = 'Active' ORDER BY ids ASC")->fetchAll(PDO::FETCH_ASSOC);

$cfCompanyId = !empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1;
$cfPrintSettings = getPrintSettings(null, $cfCompanyId);
?>
<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/" data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
    <style>
        .kpi-card {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            background: #ffffff;
        }
        .kpi-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
        }
        #tblContractFinancials { font-size: 12.5px; }
        #tblContractFinancials > thead > tr > th {
            background-color: #eef3fc !important;
            color: #1b3d94 !important;
            border-bottom: 2px solid #1b3d94 !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            font-size: 0.76rem !important;
            white-space: nowrap;
        }
        #tblContractFinancials tfoot td {
            background-color: #eef3fc !important;
            border-top: 2px solid #1b3d94 !important;
            font-weight: 700;
            color: #1b3d94;
        }
    </style>
</head>
<body>
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
  <div class="layout-container">
    <?php include ROOT_PATH . '/view/templates/nav.php'; ?>
    <div class="layout-page">
      <div class="content-wrapper">
        <?php include ROOT_PATH . '/view/templates/menu.php'; ?>

        <div class="container-fluid flex-grow-1 container-p-y">
          <!-- Top Bar: As of Date & Export Buttons -->
          <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <span class="badge bg-label-primary px-3 py-2 fs-6">
                <i class="ri-calendar-check-line me-1"></i> Report As of: <strong id="cf_as_of_date"><?= date('d M Y, H:i') ?></strong>
              </span>
              <div class="input-group input-group-sm" style="width: 210px;">
                <span class="input-group-text bg-white fw-semibold">As of Date</span>
                <input type="date" id="cf_input_as_of_date" class="form-control" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
              </div>
            </div>
            <div class="d-flex gap-2">
              <button type="button" id="cf_btn_excel" class="btn btn-outline-success btn-sm">
                <i class="ri-file-excel-2-line me-1"></i> Export to Excel
              </button>
              <button type="button" id="cf_btn_pdf" class="btn btn-primary btn-sm">
                <i class="ri-file-pdf-2-line me-1"></i> Export to PDF
              </button>
            </div>
          </div>

          <!-- KPI Dashboard Row 1 -->
          <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
              <div class="card kpi-card p-3 h-100" style="border-left:4px solid #3b82f6;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-muted small fw-semibold">Total Contracts</span>
                  <div class="kpi-icon-box bg-primary"><i class="ri-file-list-3-line"></i></div>
                </div>
                <h3 class="fw-bold mb-0" id="cf_kpi_total">0</h3>
                <small class="text-muted">All non-cancelled contracts</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card kpi-card p-3 h-100" style="border-left:4px solid #f59e0b;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-muted small fw-semibold">Active / Overdue</span>
                  <div class="kpi-icon-box bg-warning"><i class="ri-roadster-line"></i></div>
                </div>
                <h3 class="fw-bold mb-0"><span id="cf_kpi_active">0</span> <small class="text-danger fs-6">(<span id="cf_kpi_overdue_cnt">0</span> Overdue)</small></h3>
                <small class="text-muted">Currently Rentout / Extended</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card kpi-card p-3 h-100" style="border-left:4px solid #10b981;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-muted small fw-semibold">Returned / Closed</span>
                  <div class="kpi-icon-box bg-success"><i class="ri-checkbox-circle-line"></i></div>
                </div>
                <h3 class="fw-bold mb-0 text-success" id="cf_kpi_closed">0</h3>
                <small class="text-muted">Completed contracts</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card kpi-card p-3 h-100" style="border-left:4px solid #6366f1;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-muted small fw-semibold">Total Agreed Value</span>
                  <div class="kpi-icon-box bg-info"><i class="ri-money-dollar-box-line"></i></div>
                </div>
                <h3 class="fw-bold mb-0 text-primary" id="cf_kpi_agreed">0.000</h3>
                <small class="text-muted">Contract + Extensions (BHD)</small>
              </div>
            </div>
          </div>

          <!-- KPI Dashboard Row 2 -->
          <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
              <div class="card kpi-card p-3 h-100" style="border-left:4px solid #10b981;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-muted small fw-semibold">Total Collected</span>
                  <div class="kpi-icon-box bg-success"><i class="ri-hand-coin-line"></i></div>
                </div>
                <h3 class="fw-bold mb-0 text-success" id="cf_kpi_collected">0.000</h3>
                <small class="text-muted">Valid payments received (BHD)</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card kpi-card p-3 h-100" style="border-left:4px solid #ef4444;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-danger small fw-semibold">Overdue Return Amount</span>
                  <div class="kpi-icon-box bg-danger"><i class="ri-time-line"></i></div>
                </div>
                <h3 class="fw-bold mb-0 text-danger" id="cf_kpi_overdue_amt">0.000</h3>
                <small class="text-muted">Unreturned overdue charges (BHD)</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card kpi-card p-3 h-100" style="border-left:4px solid #ef4444;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-danger small fw-bold">Total Outstanding</span>
                  <div class="kpi-icon-box bg-danger"><i class="ri-arrow-down-circle-line"></i></div>
                </div>
                <h3 class="fw-bold mb-0 text-danger" id="cf_kpi_outstanding">0.000</h3>
                <small class="text-danger">Net receivable balance (BHD)</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card kpi-card p-3 h-100" style="border-left:4px solid #0ea5e9;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="text-muted small fw-semibold">Total Invoiced</span>
                  <div class="kpi-icon-box bg-primary"><i class="ri-bill-line"></i></div>
                </div>
                <h3 class="fw-bold mb-0 text-dark" id="cf_kpi_invoiced">0.000</h3>
                <small class="text-muted">Finalized tax invoices (BHD)</small>
              </div>
            </div>
          </div>

          <!-- Filter Bar -->
          <div class="card border shadow-sm mb-3">
            <div class="card-body py-2">
              <div class="row g-2 align-items-end">
                <div class="col-12 col-md-3">
                  <label class="form-label small fw-semibold mb-1">Company</label>
                  <select id="cf_filter_company" class="form-select form-select-sm">
                    <option value="all">All Companies</option>
                    <?php foreach ($companies as $comp): ?>
                      <option value="<?= (int)$comp['ids'] ?>"><?= htmlspecialchars($comp['company_name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-6 col-md-2">
                  <label class="form-label small fw-semibold mb-1">Agreement From</label>
                  <input type="date" id="cf_filter_from" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-2">
                  <label class="form-label small fw-semibold mb-1">Agreement To</label>
                  <input type="date" id="cf_filter_to" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-md-5 d-flex gap-2">
                  <button type="button" id="cf_btn_search" class="btn btn-primary btn-sm px-3">
                    <i class="ri-search-line me-1"></i> Filter
                  </button>
                  <button type="button" id="cf_btn_reset" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-refresh-line me-1"></i> Reset
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Status Pills -->
          <div class="d-flex flex-wrap gap-2 mb-3">
            <button type="button" class="btn btn-sm btn-primary cf-pill active" data-filter="all">All</button>
            <button type="button" class="btn btn-sm btn-outline-warning cf-pill" data-filter="active">Active (Rentout/Extended)</button>
            <button type="button" class="btn btn-sm btn-outline-success cf-pill" data-filter="closed">Returned / Closed</button>
            <button type="button" class="btn btn-sm btn-outline-danger cf-pill" data-filter="overdue">Overdue Return</button>
            <button type="button" class="btn btn-sm btn-outline-danger cf-pill" data-filter="unpaid">Unpaid</button>
            <button type="button" class="btn btn-sm btn-outline-info cf-pill" data-filter="partial">Partial</button>
            <button type="button" class="btn btn-sm btn-outline-success cf-pill" data-filter="paid">Paid</button>
            <button type="button" class="btn btn-sm btn-outline-secondary cf-pill" data-filter="overpaid">Overpaid</button>
          </div>

          <!-- DataTable Card -->
          <div class="card border shadow-sm">
            <div class="card-datatable table-responsive">
              <table id="tblContractFinancials" class="table table-bordered table-sm table-hover align-middle" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Contract Details</th>
                    <th>Customer Details</th>
                    <th>Vehicle Details</th>
                    <th>Period</th>
                    <th class="text-end">Agreed / Billed</th>
                    <th class="text-end">Collected</th>
                    <th class="text-end">Overdue</th>
                    <th class="text-end">Balance</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                  <tr>
                    <td colspan="5" class="text-end">Totals (BHD):</td>
                    <td class="text-end" id="cf_foot_agreed">0.000</td>
                    <td class="text-end text-success" id="cf_foot_collected">0.000</td>
                    <td class="text-end text-danger" id="cf_foot_overdue">0.000</td>
                    <td class="text-end text-danger" id="cf_foot_balance">0.000</td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

        <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
      </div>
    </div>
  </div>
</div>

<!-- Contract Ledger Modal -->
<div class="modal fade" id="cfContractLedgerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
    <div class="modal-content">
      <div class="modal-header text-white py-2" style="background: linear-gradient(135deg, #1b3d94, #2563eb);">
        <div>
          <h5 class="mb-0 text-white"><i class="ri-book-open-line me-1"></i> Contract Ledger — <span id="cf_led_agr">-</span></h5>
          <small class="text-white-50">Customer: <span id="cf_led_cust" class="fw-bold text-white">-</span></small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-3">
        <div class="row g-2 mb-3 text-center">
          <div class="col-3"><div class="p-2 rounded border bg-light"><div class="small text-muted">Agreed</div><div class="fw-bold" id="cf_led_agreed">0.000 BHD</div></div></div>
          <div class="col-3"><div class="p-2 rounded border bg-light"><div class="small text-muted">Collected</div><div class="fw-bold text-success" id="cf_led_collected">0.000 BHD</div></div></div>
          <div class="col-3"><div class="p-2 rounded border bg-light"><div class="small text-muted">Overdue</div><div class="fw-bold text-danger" id="cf_led_overdue">0.000 BHD</div></div></div>
          <div class="col-3"><div class="p-2 rounded border bg-light"><div class="small text-muted">Net Balance</div><div class="fw-bold text-primary" id="cf_led_balance">0.000 BHD</div></div></div>
        </div>
        <div class="table-responsive border rounded p-2">
          <table id="cf_led_table" class="table table-sm table-bordered table-hover align-middle mb-0 w-100" style="font-size:12.5px;">
            <thead class="table-light">
              <tr>
                <th class="text-center">#</th>
                <th>Date</th>
                <th>Type / Receipt</th>
                <th>Description</th>
                <th class="text-end">Debit</th>
                <th class="text-end">Credit</th>
                <th class="text-end">Balance</th>
              </tr>
            </thead>
            <tbody id="cf_led_tbody"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer py-2 bg-light">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
<script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<script>
$(function() {
    const CF_PRINT_SETTINGS = <?= json_encode($cfPrintSettings, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    let cfRows = [];
    let cfKpis = {};
    let cfTable = null;
    let cfFilter = 'all';

    function esc(s) {
        if (s === null || s === undefined) return '';
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function payBadge(st) {
        if (st === 'Paid') return '<span class="badge bg-label-success">Paid</span>';
        if (st === 'Overpaid') return '<span class="badge bg-success">Overpaid</span>';
        if (st === 'Partial') return '<span class="badge bg-label-warning text-dark">Partial</span>';
        if (st === 'Ledger Paid + Overdue') return '<span class="badge bg-danger">Ledger Paid + Overdue</span>';
        return '<span class="badge bg-label-danger">Unpaid</span>';
    }

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        if (settings.nTable.id !== 'tblContractFinancials' || cfFilter === 'all') return true;
        const r = cfTable.row(dataIndex).data();
        if (!r) return true;
        if (cfFilter === 'active') return !!r.is_active;
        if (cfFilter === 'closed') return !r.is_active;
        if (cfFilter === 'overdue') return (parseFloat(r.overdue_amount) || 0) > 0;
        if (cfFilter === 'unpaid') return r.payment_status === 'Unpaid';
        if (cfFilter === 'partial') return r.payment_status === 'Partial';
        if (cfFilter === 'paid') return r.payment_status === 'Paid';
        if (cfFilter === 'overpaid') return r.payment_status === 'Overpaid';
        return true;
    });

    cfTable = $('#tblContractFinancials').DataTable({
        data: [],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        ordering: false,
        columns: [
            { data: null, className: 'text-center', render: (d, t, r, m) => m.row + 1 },
            {
                data: 'agreement_no',
                render: (d, t, r) => {
                    if (t === 'filter' || t === 'sort') return `${d || ''} ${r.company_name || ''} ${r.agreement_status || ''} ${r.payment_status || ''}`;
                    const stBadge = typeof window.getContractStatusBadgeHtml === 'function'
                        ? window.getContractStatusBadgeHtml(r.agreement_status)
                        : `<span class="badge bg-secondary">${esc(r.agreement_status)}</span>`;
                    return `<div class="d-flex flex-column gap-1">
                        <div class="fw-bold text-primary">${esc(d)}</div>
                        <div class="d-flex flex-wrap gap-1"><span class="badge bg-label-danger">${esc(r.company_name)}</span>${stBadge}</div>
                        <div>${payBadge(r.payment_status)}</div>
                    </div>`;
                }
            },
            {
                data: 'customer_name',
                render: (d, t, r) => {
                    if (t === 'filter' || t === 'sort') return `${d || ''} ${r.customer_code || ''} ${r.customer_mobile || ''} ${r.customer_cpr || ''}`;
                    return `<div class="d-flex flex-column gap-1">
                        <div><strong class="text-dark">${esc(d || '-')}</strong> <span class="badge bg-label-secondary">${esc(r.customer_code || '')}</span></div>
                        <small class="text-muted"><i class="ri-phone-line me-1"></i>${esc(r.customer_mobile || '-')} ${r.customer_cpr ? '· CPR: ' + esc(r.customer_cpr) : ''}</small>
                    </div>`;
                }
            },
            {
                data: 'vehicle_no',
                render: (d, t, r) => {
                    if (t === 'filter' || t === 'sort') return `${d || ''} ${r.brand_name || ''} ${r.model_name || ''} ${r.category_name || ''}`;
                    const bm = [r.brand_name, r.model_name].filter(Boolean).join(' - ');
                    return `<div class="d-flex flex-column gap-1">
                        <div><strong>${esc(d || '-')}</strong> <span class="text-muted">${esc(bm)}</span></div>
                        <div><span class="badge bg-label-primary">${esc(r.category_name || '-')}</span> <span class="badge bg-label-info">${esc(r.rate_type)} · ${parseFloat(r.unit_price || 0).toFixed(3)}</span></div>
                    </div>`;
                }
            },
            {
                data: null,
                render: (d, t, r) => `<div class="small"><div><span class="text-muted">From:</span> <strong>${esc(r.from_date_format || '-')}</strong></div><div><span class="text-muted">To:</span> <strong>${esc(r.to_date_format || '-')}</strong></div></div>`
            },
            {
                data: 'agreed_total',
                className: 'text-end',
                render: (d, t, r) => `<strong>${parseFloat(d || 0).toFixed(3)}</strong>${r.extension_count > 0 ? `<div class="small text-muted">Ext(${r.extension_count}): ${parseFloat(r.extension_amount || 0).toFixed(3)}</div>` : ''}<div class="small text-muted">Led: ${parseFloat(r.ledger_debit || 0).toFixed(3)}</div>`
            },
            {
                data: 'collected',
                className: 'text-end text-success',
                render: (d, t, r) => `<strong>${parseFloat(d || 0).toFixed(3)}</strong>${r.invoiced_count > 0 ? `<div class="small text-muted">Inv(${r.invoiced_count}): ${parseFloat(r.invoiced_total || 0).toFixed(3)}</div>` : ''}`
            },
            {
                data: 'overdue_amount',
                className: 'text-end',
                render: (d, t, r) => parseFloat(d || 0) > 0
                    ? `<strong class="text-danger">${parseFloat(d).toFixed(3)}</strong><div class="small text-danger">${r.overdue_days}d</div>`
                    : '<span class="text-muted">0.000</span>'
            },
            {
                data: 'balance',
                className: 'text-end fw-bold',
                render: d => {
                    const b = parseFloat(d || 0);
                    if (b > 0) return `<span class="text-danger">${b.toFixed(3)}</span>`;
                    if (b < 0) return `<span class="text-success">${Math.abs(b).toFixed(3)} (Cr)</span>`;
                    return '<span class="text-secondary">0.000</span>';
                }
            },
            {
                data: 'ids',
                className: 'text-center',
                render: (d, t, r) => `<button type="button" class="btn btn-outline-primary btn-xs cf-open-ledger" data-id="${d}" title="View Contract Ledger"><i class="ri-book-open-line"></i></button>`
            }
        ],
        language: { search: '_INPUT_', searchPlaceholder: 'Search agreement, customer, vehicle...' }
    });

    function loadReport() {
        $.ajax({
            url: '/ContractFinancialController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'getReportData',
                company_id: $('#cf_filter_company').val(),
                from_date: $('#cf_filter_from').val(),
                to_date: $('#cf_filter_to').val(),
                as_of_date: $('#cf_input_as_of_date').val() || '<?= date('Y-m-d') ?>'
            }),
            dataType: 'json',
            success: function(res) {
                if (!res || !res.status) return;
                cfRows = res.data || [];
                cfKpis = res.kpis || {};
                if (cfKpis.as_of_date) $('#cf_as_of_date').text(cfKpis.as_of_date);
                $('#cf_kpi_total').text(cfKpis.total_contracts || 0);
                $('#cf_kpi_active').text(cfKpis.active_contracts || 0);
                $('#cf_kpi_overdue_cnt').text(cfKpis.overdue_contracts || 0);
                $('#cf_kpi_closed').text(cfKpis.closed_returned_contracts || 0);
                $('#cf_kpi_agreed').text(parseFloat(cfKpis.total_agreed || 0).toFixed(3));
                $('#cf_kpi_collected').text(parseFloat(cfKpis.total_collected || 0).toFixed(3));
                $('#cf_kpi_overdue_amt').text(parseFloat(cfKpis.total_overdue || 0).toFixed(3));
                $('#cf_kpi_outstanding').text(parseFloat(cfKpis.total_outstanding || 0).toFixed(3));
                $('#cf_kpi_invoiced').text(parseFloat(cfKpis.total_invoiced || 0).toFixed(3));

                $('#cf_foot_agreed').text(parseFloat(cfKpis.total_agreed || 0).toFixed(3));
                $('#cf_foot_collected').text(parseFloat(cfKpis.total_collected || 0).toFixed(3));
                $('#cf_foot_overdue').text(parseFloat(cfKpis.total_overdue || 0).toFixed(3));
                $('#cf_foot_balance').text(parseFloat(cfKpis.total_outstanding || 0).toFixed(3));

                cfTable.clear().rows.add(cfRows).draw();
            }
        });
    }

    $(document).on('click', '.cf-pill', function() {
        $('.cf-pill').removeClass('active btn-primary').addClass('btn-outline-secondary');
        $(this).addClass('active');
        cfFilter = $(this).data('filter') || 'all';
        cfTable.draw();
    });

    $('#cf_btn_search, #cf_input_as_of_date').on('change click', function(e) {
        if (e.type === 'change' && this.id !== 'cf_input_as_of_date') return;
        loadReport();
    });
    $('#cf_btn_reset').on('click', function() {
        $('#cf_filter_company').val('all');
        $('#cf_filter_from, #cf_filter_to').val('');
        $('#cf_input_as_of_date').val('<?= date('Y-m-d') ?>');
        cfFilter = 'all';
        $('.cf-pill').removeClass('active');
        $('.cf-pill[data-filter="all"]').addClass('active');
        loadReport();
    });

    $(document).on('click', '.cf-open-ledger', function() {
        const cid = parseInt($(this).data('id'), 10);
        const r = cfRows.find(x => x.ids === cid);
        if (!r) return;
        $('#cf_led_agr').text(r.agreement_no || '-');
        $('#cf_led_cust').text(`${r.customer_name || '-'} (${r.customer_code || ''})`);
        $('#cf_led_agreed').text(parseFloat(r.agreed_total || 0).toFixed(3) + ' BHD');
        $('#cf_led_collected').text(parseFloat(r.collected || 0).toFixed(3) + ' BHD');
        $('#cf_led_overdue').text(parseFloat(r.overdue_amount || 0).toFixed(3) + ' BHD');
        $('#cf_led_balance').text(parseFloat(r.balance || 0).toFixed(3) + ' BHD');

        if ($.fn.DataTable.isDataTable('#cf_led_table')) {
            $('#cf_led_table').DataTable().destroy();
        }
        $('#cf_led_tbody').html('<tr><td colspan="7" class="text-center text-muted py-3">Loading...</td></tr>');
        new bootstrap.Modal(document.getElementById('cfContractLedgerModal')).show();

        $.getJSON('/CustomerLedgerController', { action: 'GetContractLedgerData', contract_id: cid }, function(res) {
            const entries = (res && Array.isArray(res.data)) ? res.data : [];
            if (!entries.length) {
                $('#cf_led_tbody').html('<tr><td colspan="7" class="text-center text-muted py-3">No ledger entries found.</td></tr>');
                return;
            }
            let run = 0;
            const html = entries.map((e, i) => {
                const deb = parseFloat(e.debit || 0);
                const cred = ((e.cheque_status || '') === 'Bounced') ? 0 : parseFloat(e.credit || 0);
                run += (deb - cred);
                const mBadge = (e.payment_method && e.payment_method !== 'N/A') ? ` <span class="badge bg-label-info">${esc(e.payment_method)}</span>` : '';
                return `<tr>
                    <td class="text-center">${i + 1}</td>
                    <td class="text-nowrap">${esc((e.trans_date || '').slice(0, 10))}</td>
                    <td class="text-nowrap"><span class="badge bg-label-primary">${esc(e.trans_type || '-')}</span>${mBadge}</td>
                    <td>${esc(e.description || '-')}</td>
                    <td class="text-end text-danger">${deb > 0 ? deb.toFixed(3) : '-'}</td>
                    <td class="text-end text-success">${cred > 0 ? cred.toFixed(3) : '-'}</td>
                    <td class="text-end fw-bold">${run.toFixed(3)}</td>
                </tr>`;
            }).join('');
            $('#cf_led_tbody').html(html);
            $('#cf_led_table').DataTable({ pageLength: 10, ordering: false, language: { search: '_INPUT_', searchPlaceholder: 'Search ledger...' } });
        });
    });

    function hexToRgbArray(hex, fallback) {
        if (!hex || typeof hex !== 'string') return fallback;
        const clean = hex.replace('#', '').trim();
        if (!/^[0-9a-fA-F]{6}$/.test(clean)) return fallback;
        return [parseInt(clean.slice(0,2),16), parseInt(clean.slice(2,4),16), parseInt(clean.slice(4,6),16)];
    }

    $('#cf_btn_excel').on('click', function() {
        const list = cfTable.rows({ search: 'applied' }).data().toArray();
        if (!list.length) { alert('No data to export.'); return; }
        const ps = CF_PRINT_SETTINGS || {};
        const k = cfKpis || {};
        let tA = 0, tC = 0, tO = 0, tB = 0;
        const rowsHtml = list.map((r, i) => {
            tA += parseFloat(r.agreed_total || 0);
            tC += parseFloat(r.collected || 0);
            tO += parseFloat(r.overdue_amount || 0);
            tB += parseFloat(r.balance || 0);
            return `<tr><td>${i+1}</td><td>${esc(r.agreement_no)}</td><td>${esc(r.agreement_status)}</td><td>${esc(r.payment_status)}</td><td>${esc(r.customer_name)} (${esc(r.customer_code)})</td><td>${esc(r.vehicle_no)}</td><td style="text-align:right;">${parseFloat(r.agreed_total||0).toFixed(3)}</td><td style="text-align:right;">${parseFloat(r.collected||0).toFixed(3)}</td><td style="text-align:right;">${parseFloat(r.overdue_amount||0).toFixed(3)}</td><td style="text-align:right;font-weight:bold;">${parseFloat(r.balance||0).toFixed(3)}</td></tr>`;
        }).join('');
        const xls = `<html xmlns:x="urn:schemas-microsoft-com:office:excel"><head><meta charset="UTF-8"><style>table{border-collapse:collapse;font-family:Arial,sans-serif;font-size:11pt;}th,td{border:1px solid #cbd5e1;padding:5px 8px;}th{background:#eef3fc;color:#1b3d94;}</style></head><body><table>
            <tr><td colspan="10" style="font-size:14pt;font-weight:bold;color:#1b3d94;border:none;">${esc(ps.company_name || 'FAST LINK CAR RENTAL')} — Contract Financials & Status Report</td></tr>
            <tr><td colspan="10" style="font-size:10pt;color:#475569;border:none;">As of Date: ${esc(k.as_of_date || $('#cf_as_of_date').text())} | Contracts: ${k.total_contracts || 0} | Collected: ${parseFloat(k.total_collected||0).toFixed(3)} BHD | Outstanding: ${parseFloat(k.total_outstanding||0).toFixed(3)} BHD</td></tr>
            <tr><th>#</th><th>Agreement No</th><th>Contract Status</th><th>Payment Status</th><th>Customer</th><th>Vehicle</th><th>Agreed (BHD)</th><th>Collected (BHD)</th><th>Overdue (BHD)</th><th>Balance (BHD)</th></tr>
            ${rowsHtml}
            <tr style="font-weight:bold;background:#eef3fc;"><td colspan="6" style="text-align:right;">Totals (BHD)</td><td style="text-align:right;">${tA.toFixed(3)}</td><td style="text-align:right;">${tC.toFixed(3)}</td><td style="text-align:right;">${tO.toFixed(3)}</td><td style="text-align:right;">${tB.toFixed(3)}</td></tr>
            <tr><td colspan="10" style="font-size:9pt;color:#64748b;border:none;">${esc(ps.footer_text || 'Thank you for choosing Fastlink Car Rental.')}</td></tr>
        </table></body></html>`;
        const blob = new Blob(['\ufeff', xls], { type: 'application/vnd.ms-excel;charset=utf-8;' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = `Contract_Financial_Report_${new Date().toISOString().slice(0,10)}.xls`;
        a.click();
    });

    $('#cf_btn_pdf').on('click', function() {
        const list = cfTable.rows({ search: 'applied' }).data().toArray();
        if (!list.length) { alert('No data to export.'); return; }
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'pt', 'a4');
        const ps = CF_PRINT_SETTINGS || {};
        const k = cfKpis || {};
        const accentRgb = hexToRgbArray(ps.accent_color, [27, 61, 148]);
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const marginX = 32;
        const imgData = ps.logo_base64 || '';
        const showLogo = Number(ps.show_logo !== undefined ? ps.show_logo : 1) === 1;
        const logoW = Math.min(130, Math.max(70, Number(ps.logo_width || 120) * 0.8));
        const logoH = logoW / 2.8;

        let tA = 0, tC = 0, tO = 0, tB = 0;
        const bodyRows = list.map((r, i) => {
            tA += parseFloat(r.agreed_total || 0);
            tC += parseFloat(r.collected || 0);
            tO += parseFloat(r.overdue_amount || 0);
            tB += parseFloat(r.balance || 0);
            return [
                String(i + 1),
                `${r.agreement_no || ''}\n${r.agreement_status || ''} | ${r.payment_status || ''}`,
                `${r.customer_name || ''} (${r.customer_code || ''})`,
                `${r.vehicle_no || ''} (${r.category_name || ''})`,
                parseFloat(r.agreed_total || 0).toFixed(3),
                parseFloat(r.collected || 0).toFixed(3),
                parseFloat(r.overdue_amount || 0).toFixed(3),
                parseFloat(r.balance || 0).toFixed(3)
            ];
        });
        bodyRows.push([
            { content: 'Totals (BHD)', colSpan: 4, styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } },
            { content: tA.toFixed(3), styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } },
            { content: tC.toFixed(3), styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } },
            { content: tO.toFixed(3), styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } },
            { content: tB.toFixed(3), styles: { halign: 'right', fontStyle: 'bold', fillColor: [238, 243, 252] } }
        ]);

        doc.autoTable({
            head: [['#', 'Agreement & Status', 'Customer', 'Vehicle', 'Agreed (BHD)', 'Collected (BHD)', 'Overdue (BHD)', 'Balance (BHD)']],
            body: bodyRows,
            startY: 130,
            theme: 'grid',
            styles: { fontSize: 8.5, font: 'helvetica', cellPadding: 5, valign: 'middle', lineColor: [215, 222, 235], lineWidth: 0.4 },
            headStyles: { fillColor: accentRgb, textColor: 255, fontStyle: 'bold' },
            columnStyles: {
                0: { cellWidth: 26, halign: 'center' },
                4: { cellWidth: 72, halign: 'right' },
                5: { cellWidth: 72, halign: 'right' },
                6: { cellWidth: 72, halign: 'right' },
                7: { cellWidth: 76, halign: 'right', fontStyle: 'bold' }
            },
            margin: { top: 96, left: marginX, right: marginX, bottom: 48 },
            didDrawPage: function(data) {
                if (showLogo && imgData) { try { doc.addImage(imgData, 'PNG', marginX, 18, logoW, logoH); } catch (e) {} }
                doc.setFont('helvetica', 'bold'); doc.setFontSize(15); doc.setTextColor(accentRgb[0], accentRgb[1], accentRgb[2]);
                doc.text(String(ps.company_name || 'FAST LINK CAR RENTAL'), pageWidth / 2, 30, { align: 'center' });
                doc.setFont('helvetica', 'normal'); doc.setFontSize(9); doc.setTextColor(80, 90, 105);
                if (ps.header_subtitle) doc.text(String(ps.header_subtitle), pageWidth / 2, 43, { align: 'center' });
                if (ps.header_address) doc.text(String(ps.header_address), pageWidth / 2, 55, { align: 'center' });
                const rightX = pageWidth - marginX;
                let rightY = 26; doc.setFontSize(8);
                if (ps.header_phone) { doc.text('Tel: ' + String(ps.header_phone), rightX, rightY, { align: 'right' }); rightY += 11; }
                if (ps.header_email) { doc.text(String(ps.header_email), rightX, rightY, { align: 'right' }); rightY += 11; }
                if (ps.header_website) { doc.text(String(ps.header_website), rightX, rightY, { align: 'right' }); }
                doc.setDrawColor(accentRgb[0], accentRgb[1], accentRgb[2]); doc.setLineWidth(1.2); doc.line(marginX, 68, pageWidth - marginX, 68);
                if (data.pageNumber === 1) {
                    doc.setFont('helvetica', 'bold'); doc.setFontSize(12); doc.setTextColor(30, 41, 59);
                    doc.text('CONTRACT FINANCIALS & STATUS REPORT', marginX, 86);
                    doc.setFont('helvetica', 'normal'); doc.setFontSize(8.5); doc.setTextColor(71, 85, 105);
                    doc.text(`Total Contracts: ${k.total_contracts || 0} (Active: ${k.active_contracts || 0}, Closed/Returned: ${k.closed_returned_contracts || 0}, Overdue: ${k.overdue_contracts || 0})  |  Agreed: ${parseFloat(k.total_agreed || 0).toFixed(3)} BHD  |  Collected: ${parseFloat(k.total_collected || 0).toFixed(3)} BHD`, marginX, 102);
                    doc.text(`As of Date: ${k.as_of_date || $('#cf_as_of_date').text()}`, rightX, 86, { align: 'right' });
                    doc.setFont('helvetica', 'bold');
                    doc.text(`Overdue: ${parseFloat(k.total_overdue || 0).toFixed(3)} BHD  |  Total Outstanding: ${parseFloat(k.total_outstanding || 0).toFixed(3)} BHD`, rightX, 102, { align: 'right' });
                }
                const footerY = pageHeight - 28;
                doc.setDrawColor(203, 213, 225); doc.setLineWidth(0.6); doc.line(marginX, footerY - 10, pageWidth - marginX, footerY - 10);
                if (Number(ps.show_footer !== undefined ? ps.show_footer : 1) === 1) {
                    doc.setFont('helvetica', 'normal'); doc.setFontSize(8); doc.setTextColor(71, 85, 105);
                    if (ps.footer_text) doc.text(String(ps.footer_text), marginX, footerY);
                    if (ps.footer_note) { doc.setFontSize(7.5); doc.setTextColor(120, 130, 145); doc.text(String(ps.footer_note), marginX, footerY + 11); }
                }
                let pageStr = 'Page ' + doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') pageStr += ' of totalPages';
                doc.setFont('helvetica', 'bold'); doc.setFontSize(8); doc.setTextColor(71, 85, 105);
                doc.text(pageStr, rightX, footerY, { align: 'right' });
            }
        });
        if (typeof doc.putTotalPages === 'function') doc.putTotalPages('totalPages');
        window.open(doc.output('bloburl'), '_blank');
    });

    loadReport();
});
</script>
</body>
</html>
