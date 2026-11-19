<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /Logout");
    exit();
}

include ROOT_PATH . '/view/envinclude.php';
$contractListVal = $this->encryption->encrypt('3,3-4');
?>
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
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <style>
        .kpi-card {
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
            border: 1px solid #e2e8f0;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27, 61, 148, 0.12);
            border-color: #1b3d94;
        }
        .kpi-card.active-filter {
            border: 2px solid #1b3d94 !important;
            background-color: #f4f7fe;
        }
        .kpi-icon-box {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .kpi-icon-box i {
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        @media (max-width: 991.98px) {
            .container-p-y { padding-top: 15px !important; }
        }
        @media (min-width: 992px) {
            .container-p-y { padding-top: 55px !important; }
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
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                            <div>
                                <h4 class="fw-bold mb-1" style="color: #1b3d94;">
                                    <i class="ri-dashboard-3-line me-1"></i> Active Contracts Dashboard
                                </h4>
                                <p class="text-muted mb-0">Monitor all currently rented &amp; extended contracts and extend, return, or view them directly.</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="btnRefreshActive" class="btn btn-outline-primary btn-sm">
                                    <i class="ri-refresh-line me-1"></i> Refresh
                                </button>
                                <a href="/ContractList?val=<?= urlencode($contractListVal) ?>" class="btn btn-primary btn-sm">
                                    <i class="ri-file-list-3-line me-1"></i> All Contracts
                                </a>
                            </div>
                        </div>

                        <!-- KPI Summary Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6 col-md-4">
                                <div class="card kpi-card active-filter" data-filter="all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Total Active Contracts</span>
                                            <h3 class="fw-bold mb-0 mt-1" style="color: #1b3d94;" id="kpiTotalActive">0</h3>
                                        </div>
                                        <div class="kpi-icon-box rounded" style="background-color: #eef3fc; color: #1b3d94;">
                                            <i class="ri-car-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="card kpi-card" data-filter="due_today">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Due Return Today</span>
                                            <h3 class="fw-bold mb-0 mt-1 text-warning" id="kpiDueToday">0</h3>
                                        </div>
                                        <div class="kpi-icon-box rounded bg-label-warning">
                                            <i class="ri-time-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="card kpi-card" data-filter="overdue">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Overdue Returns</span>
                                            <h3 class="fw-bold mb-0 mt-1 text-danger" id="kpiOverdue">0</h3>
                                        </div>
                                        <div class="kpi-icon-box rounded bg-label-danger">
                                            <i class="ri-alarm-warning-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Summary Cards (Active Contracts Till Date) -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6 col-md-4">
                                <div class="card border" style="border-color: #dbeafe !important;">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">To Be Collected (Excl. Overdue)</span>
                                            <h3 class="fw-bold mb-0 mt-1" style="color: #1b3d94;" id="kpiToCollectExcl">0.000 BHD</h3>
                                            <small class="text-muted">Till <?= date('d-M-Y') ?> &bull; Contract total minus received</small>
                                        </div>
                                        <div class="kpi-icon-box rounded" style="background-color: #eef3fc; color: #1b3d94;">
                                            <i class="ri-wallet-3-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="card border" style="border-color: #fecaca !important;">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Overdue Total (Till <?= date('d-M-Y') ?>)</span>
                                            <h3 class="fw-bold mb-0 mt-1 text-danger" id="kpiOverdueTotal">0.000 BHD</h3>
                                            <small class="text-muted">Accrued overdue charges on active contracts</small>
                                        </div>
                                        <div class="kpi-icon-box rounded bg-label-danger">
                                            <i class="ri-timer-flash-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="card border" style="border-color: #bbf7d0 !important;">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted small fw-medium">Total To Collect (Incl. Overdue)</span>
                                            <h3 class="fw-bold mb-0 mt-1 text-success" id="kpiTotalInclOverdue">0.000 BHD</h3>
                                            <small class="text-muted">Till <?= date('d-M-Y') ?> &bull; Active contracts + overdue minus received</small>
                                        </div>
                                        <div class="kpi-icon-box rounded bg-label-success">
                                            <i class="ri-funds-line ri-24px"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Contracts Table -->
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
                                <h5 class="mb-0 fw-semibold" style="color: #1b3d94;">Active Contracts List</h5>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <select id="activeStatusFilter" class="form-select form-select-sm" style="width: 180px;">
                                        <option value="all">All Active</option>
                                        <option value="overdue">Overdue Only</option>
                                        <option value="due_today">Due Today</option>
                                        <option value="extended">Extended</option>
                                        <option value="rentout">Rentout</option>
                                    </select>
                                    <input type="text" id="activeSearchInput" class="form-control form-control-sm" style="width: 240px;" placeholder="Search agreement, customer, plate...">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="activeContractsTable" class="table table-hover align-middle w-100">
                                        <thead>
                                            <tr>
                                                <th>Agreement No</th>
                                                <th>Customer</th>
                                                <th>Vehicle</th>
                                                <th>Agreed Period</th>
                                                <th class="text-end">Received</th>
                                                <th class="text-end">Contract Total</th>
                                                <th class="text-end">Overdue Amt</th>
                                                <th class="text-end">Total Value</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <!-- Quick View Contract Modal -->
    <div class="modal fade" id="quickViewContractModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #1b3d94, #2563eb);">
                    <h5 class="modal-title text-white mb-0">
                        <i class="ri-file-text-line me-1"></i> Contract Details - <span id="qvAgreementNo"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Top Contract Meta Strip -->
                    <div class="row g-2 mb-3 p-2 rounded border bg-white align-items-center">
                        <div class="col-sm-6 col-md-3">
                            <div class="text-muted small">Agreement Date</div>
                            <div class="fw-semibold" id="qvAgreementDate">-</div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-muted small">Booking / Qtn No</div>
                            <div class="fw-semibold" id="qvBookingNo">-</div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-muted small">Company</div>
                            <div class="fw-semibold" id="qvCompanyName">-</div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="text-muted small">Status</div>
                            <div id="qvStatus">-</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <div class="p-3 rounded border bg-light h-100">
                                <div class="fw-semibold mb-2 pb-1 border-bottom" style="color: #1b3d94;">
                                    <i class="ri-user-line me-1"></i> Customer Information
                                </div>
                                <div class="row g-2 small">
                                    <div class="col-4 text-muted">Customer Name</div>
                                    <div class="col-8 fw-semibold" id="qvCustomerName">-</div>
                                    <div class="col-4 text-muted">Customer Code</div>
                                    <div class="col-8 fw-semibold" id="qvCustomerCode">-</div>
                                    <div class="col-4 text-muted">CPR / CR No</div>
                                    <div class="col-8 fw-semibold" id="qvCustomerCpr">-</div>
                                    <div class="col-4 text-muted">Phone</div>
                                    <div class="col-8 fw-semibold" id="qvCustomerPhone">-</div>
                                    <div class="col-4 text-muted">Email</div>
                                    <div class="col-8 fw-semibold text-break" id="qvCustomerEmail">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle & Rental Period -->
                        <div class="col-md-6">
                            <div class="p-3 rounded border bg-light h-100">
                                <div class="fw-semibold mb-2 pb-1 border-bottom" style="color: #1b3d94;">
                                    <i class="ri-car-line me-1"></i> Vehicle &amp; Contract Period
                                </div>
                                <div class="row g-2 small">
                                    <div class="col-4 text-muted">Vehicle No</div>
                                    <div class="col-8 fw-semibold" id="qvVehicleNo">-</div>
                                    <div class="col-4 text-muted">Category / Model</div>
                                    <div class="col-8 fw-semibold"><span id="qvVehicleCategory">-</span> / <span id="qvVehicleModel">-</span></div>
                                    <div class="col-4 text-muted">Year / Color</div>
                                    <div class="col-8 fw-semibold"><span id="qvVehicleYear">-</span> / <span id="qvVehicleColor">-</span></div>
                                    <div class="col-4 text-muted">Chassis No</div>
                                    <div class="col-8 fw-semibold" id="qvChassisNo">-</div>
                                    <div class="col-4 text-muted">Rate Type</div>
                                    <div class="col-8 fw-semibold" id="qvRateType">-</div>
                                    <div class="col-4 text-muted">Start Date</div>
                                    <div class="col-8 fw-semibold" id="qvStartDate">-</div>
                                    <div class="col-4 text-muted">Expected Return</div>
                                    <div class="col-8 fw-semibold" id="qvEndDate">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Breakdown -->
                    <div class="p-3 rounded border bg-white">
                        <div class="fw-semibold mb-2 pb-1 border-bottom" style="color: #1b3d94;">
                            <i class="ri-money-dollar-circle-line me-1"></i> Financial Summary
                        </div>
                        <div class="row g-2 text-center">
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-light border h-100">
                                    <div class="text-muted small">Contract Total</div>
                                    <div class="fw-bold mt-1" id="qvContractTotal">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-light border h-100">
                                    <div class="text-muted small">Received</div>
                                    <div class="fw-bold text-success mt-1" id="qvReceivedAmt">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-light border h-100">
                                    <div class="text-muted small">To Collect (Excl.)</div>
                                    <div class="fw-bold mt-1" style="color: #1b3d94;" id="qvToCollectExcl">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-light border h-100">
                                    <div class="text-muted small">Overdue <span id="qvOverdueDays"></span></div>
                                    <div class="fw-bold text-danger mt-1" id="qvOverdueAmt">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-light border h-100">
                                    <div class="text-muted small">To Collect (Incl.)</div>
                                    <div class="fw-bold text-success mt-1" id="qvToCollectIncl">0.000 BHD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="p-2 rounded bg-light border h-100">
                                    <div class="text-muted small">Total Value</div>
                                    <div class="fw-bold mt-1" style="color: #1b3d94;" id="qvTotalAmount">0.000 BHD</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 small text-muted" id="qvNotes"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="d-flex gap-2">
                        <button type="button" id="qvReturnBtn" class="btn btn-outline-success btn-sm btn-return-modal" data-id="">
                            <i class="ri-roadster-line me-1"></i> Return Vehicle
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" id="qvPrintBtn" class="btn btn-primary btn-sm">
                            <i class="ri-printer-line me-1"></i> Print Contract
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exact Contract List Return Modal Overlay -->
    <iframe id="returnModalIframe"
            src="about:blank"
            allowtransparency="true"
            style="display:none; position:fixed; inset:0; width:100vw; height:100vh; border:0; z-index:99999 !important; background:transparent;">
    </iframe>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script>
    (function() {
        const contractListBaseUrl = '/ContractList?val=<?= urlencode($contractListVal) ?>';
        let allContracts = [];
        let dt = null;
        let currentAgreementNo = '';

        function formatDateTime(val) {
            if (!val) return '-';
            const d = new Date(val.replace(' ', 'T'));
            if (isNaN(d.getTime())) return val;
            return d.toLocaleString('en-GB', {
                day: '2-digit', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }

        function escapeHtml(str) {
            return String(str || '').replace(/[&<>"']/g, s => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[s]));
        }

        function renderFilteredTable() {
            const filter = $('#activeStatusFilter').val();
            const search = ($('#activeSearchInput').val() || '').trim().toLowerCase();

            const filtered = allContracts.filter(c => {
                if (filter === 'overdue' && !c.is_overdue) return false;
                if (filter === 'due_today' && !c.is_due_today) return false;
                if (filter === 'extended' && c.status.toLowerCase() !== 'extended') return false;
                if (filter === 'rentout' && c.status.toLowerCase() !== 'rentout') return false;

                if (search) {
                    const hay = [
                        c.agreement_no, c.customer_name, c.customer_phone,
                        c.vehicle_no, c.vehicle_model, c.booking_no
                    ].join(' ').toLowerCase();
                    if (!hay.includes(search)) return false;
                }
                return true;
            });

            if (!dt) {
                dt = $('#activeContractsTable').DataTable({
                    data: filtered,
                    pageLength: 15,
                    order: [],
                    dom: 't<"d-flex justify-content-between align-items-center mt-3"ip>',
                    columns: [
                        {
                            data: 'agreement_no',
                            render: (v, t, row) => {
                                const isExt = String(row.status).toLowerCase() === 'extended';
                                const statusBadge = `<span class="badge ${isExt ? 'bg-label-info' : 'bg-label-success'} mt-1">${escapeHtml(row.status)}</span>`;
                                return `
                                    <a href="javascript:void(0);" class="fw-semibold qv-trigger d-block" data-id="${row.id}" style="color: #1b3d94;">
                                        ${escapeHtml(v)}
                                    </a>
                                    ${row.booking_no ? `<div class="small text-muted">${escapeHtml(row.booking_no)}</div>` : ''}
                                    ${statusBadge}
                                `;
                            }
                        },
                        {
                            data: 'customer_name',
                            render: (v, t, row) => `
                                <div class="fw-semibold">${escapeHtml(v)}</div>
                                <div class="small text-muted">
                                    <span class="me-2"><strong>Code:</strong> ${escapeHtml(row.customer_code || '-')}</span>
                                    <span><strong>CPR:</strong> ${escapeHtml(row.customer_cpr || '-')}</span>
                                </div>
                                <div class="small text-muted">
                                    <i class="ri-phone-line me-1"></i>${escapeHtml(row.customer_phone || '-')}
                                </div>
                            `
                        },
                        {
                            data: 'vehicle_no',
                            render: (v, t, row) => `
                                <div class="d-flex align-items-center gap-1 flex-wrap">
                                    <span class="badge bg-label-primary">${escapeHtml(v)}</span>
                                    <span class="fw-medium small">${escapeHtml(row.vehicle_model)}</span>
                                </div>
                                <div class="small text-muted mt-1">
                                    <span><strong>Cat:</strong> ${escapeHtml(row.vehicle_category)}</span> |
                                    <span><strong>Yr:</strong> ${escapeHtml(row.vehicle_year)}</span> |
                                    <span><strong>Clr:</strong> ${escapeHtml(row.vehicle_color)}</span>
                                </div>
                                <div class="small text-muted">
                                    <strong>Chassis:</strong> ${escapeHtml(row.chassis_number)}
                                </div>
                            `
                        },
                        {
                            data: 'start_date',
                            render: (v, t, row) => {
                                let tag = '<span class="badge bg-label-primary mt-1">On Schedule</span>';
                                if (row.is_overdue) {
                                    tag = `<span class="badge bg-label-danger mt-1">Overdue (${row.overdue_days}d)</span>`;
                                } else if (row.is_due_today) {
                                    tag = '<span class="badge bg-label-warning mt-1">Due Today</span>';
                                }
                                return `
                                    <div class="small"><strong>From:</strong> ${escapeHtml(formatDateTime(v))}</div>
                                    <div class="small"><strong>To:</strong> ${escapeHtml(formatDateTime(row.end_date))}</div>
                                    ${tag}
                                `;
                            }
                        },
                        {
                            data: 'received_amount',
                            className: 'text-end fw-semibold text-success text-nowrap',
                            render: v => Number(v || 0).toFixed(3)
                        },
                        {
                            data: 'contract_total_amount',
                            className: 'text-end fw-semibold text-nowrap',
                            render: v => Number(v || 0).toFixed(3)
                        },
                        {
                            data: 'overdue_amount',
                            className: 'text-end fw-semibold text-nowrap',
                            render: (v, t, row) => {
                                const amt = Number(v || 0).toFixed(3);
                                return row.is_overdue && Number(v) > 0
                                    ? `<span class="text-danger">${amt}</span>`
                                    : `<span class="text-muted">${amt}</span>`;
                            }
                        },
                        {
                            data: 'total_contract_value',
                            className: 'text-end fw-bold text-nowrap',
                            render: v => `<span style="color: #1b3d94;">${Number(v || 0).toFixed(3)}</span>`
                        },
                        {
                            data: 'id',
                            className: 'text-center text-nowrap',
                            orderable: false,
                            render: (id) => `
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary qv-trigger" data-id="${id}" title="View Contract">
                                        <i class="ri-eye-line me-1"></i> View
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-return-modal" data-id="${id}" title="Return Vehicle">
                                        <i class="ri-roadster-line me-1"></i> Return
                                    </button>
                                </div>
                            `
                        }
                    ]
                });
            } else {
                dt.clear().rows.add(filtered).draw();
            }

            let sumExclOverdue = 0;
            let sumOverdueAmt = 0;
            let sumInclOverdue = 0;
            filtered.forEach(c => {
                const excl = parseFloat(c.to_collect_excl_overdue !== undefined ? c.to_collect_excl_overdue : Math.max(0, (parseFloat(c.contract_total_amount) || 0) - (parseFloat(c.received_amount) || 0))) || 0;
                const ov   = parseFloat(c.overdue_amount) || 0;
                const incl = parseFloat(c.to_collect_incl_overdue !== undefined ? c.to_collect_incl_overdue : Math.max(0, (parseFloat(c.total_contract_value) || 0) - (parseFloat(c.received_amount) || 0))) || 0;
                sumExclOverdue += excl;
                sumOverdueAmt  += ov;
                sumInclOverdue += incl;
            });
            $('#kpiToCollectExcl').text(sumExclOverdue.toFixed(3) + ' BHD');
            $('#kpiOverdueTotal').text(sumOverdueAmt.toFixed(3) + ' BHD');
            $('#kpiTotalInclOverdue').text(sumInclOverdue.toFixed(3) + ' BHD');
        }

        function loadActiveContracts() {
            fetch('/ActiveContractsDashboardController')
                .then(r => r.json())
                .then(res => {
                    if (res.status !== 'success') {
                        $('#activeContractsTable tbody').html(`<tr><td colspan="9" class="text-center text-danger py-3">${escapeHtml(res.message || 'Failed to load active contracts.')}</td></tr>`);
                        return;
                    }
                    allContracts = res.data || [];
                    const s = res.summary || {};
                    $('#kpiTotalActive').text(s.total_active || 0);
                    $('#kpiDueToday').text(s.due_today || 0);
                    $('#kpiOverdue').text(s.overdue || 0);
                    renderFilteredTable();
                })
                .catch(err => {
                    console.error('Failed to load active contracts:', err);
                    $('#activeContractsTable tbody').html(`<tr><td colspan="9" class="text-center text-danger py-3">Error loading active contracts. Check console / network response.</td></tr>`);
                });
        }

        $(document).on('click', '.kpi-card', function() {
            const filter = $(this).data('filter');
            $('.kpi-card').removeClass('active-filter');
            $(this).addClass('active-filter');
            $('#activeStatusFilter').val(filter);
            renderFilteredTable();
        });

        $('#activeStatusFilter').on('change', function() {
            const val = $(this).val();
            $('.kpi-card').removeClass('active-filter');
            $(`.kpi-card[data-filter="${val}"]`).addClass('active-filter');
            renderFilteredTable();
        });

        $('#activeSearchInput').on('input', renderFilteredTable);
        $('#btnRefreshActive').on('click', loadActiveContracts);

        $(document).on('click', '.qv-trigger', function() {
            const id = parseInt($(this).data('id'), 10);
            const row = allContracts.find(c => c.id === id);
            if (!row) return;

            currentAgreementNo = row.agreement_no;
            $('#qvAgreementNo').text(row.agreement_no || '-');
            $('#qvAgreementDate').text(row.agreement_date ? formatDateTime(row.agreement_date) : '-');
            $('#qvBookingNo').text(row.booking_no || '-');
            $('#qvCompanyName').text(row.company_name || 'Fast Link');
            $('#qvStatus').html(row.is_overdue ? `<span class="badge bg-label-danger">Overdue (${row.overdue_days}d)</span>` : (row.is_due_today ? `<span class="badge bg-label-warning">Due Today</span>` : `<span class="badge bg-label-primary">${row.status || 'Active'}</span>`));

            $('#qvCustomerName').text(row.customer_name || 'N/A');
            $('#qvCustomerCode').text(row.customer_code || '-');
            $('#qvCustomerCpr').text(row.customer_cpr || '-');
            $('#qvCustomerPhone').text(row.customer_phone || '-');
            $('#qvCustomerEmail').text(row.customer_email || '-');

            $('#qvVehicleNo').text(row.vehicle_no || 'N/A');
            $('#qvVehicleCategory').text(row.vehicle_category || '-');
            $('#qvVehicleModel').text(row.vehicle_model || '-');
            $('#qvVehicleYear').text(row.vehicle_year || '-');
            $('#qvVehicleColor').text(row.vehicle_color || '-');
            $('#qvChassisNo').text(row.chassis_number || '-');
            $('#qvRateType').text(row.rate_type || '-');
            $('#qvStartDate').text(formatDateTime(row.start_date));
            $('#qvEndDate').text(formatDateTime(row.end_date));

            const cTotal = Number(row.contract_total_amount || 0);
            const recAmt = Number(row.received_amount || 0);
            const ovAmt  = Number(row.overdue_amount || 0);
            const tVal   = Number(row.total_contract_value || 0);
            const exCol  = row.to_collect_excl_overdue !== undefined ? Number(row.to_collect_excl_overdue) : Math.max(0, cTotal - recAmt);
            const inCol  = row.to_collect_incl_overdue !== undefined ? Number(row.to_collect_incl_overdue) : Math.max(0, tVal - recAmt);

            $('#qvContractTotal').text(cTotal.toFixed(3) + ' BHD');
            $('#qvReceivedAmt').text(recAmt.toFixed(3) + ' BHD');
            $('#qvToCollectExcl').text(exCol.toFixed(3) + ' BHD');
            $('#qvOverdueDays').text(row.overdue_days > 0 ? `(${row.overdue_days}d)` : '');
            $('#qvOverdueAmt').text(ovAmt.toFixed(3) + ' BHD');
            $('#qvToCollectIncl').text(inCol.toFixed(3) + ' BHD');
            $('#qvTotalAmount').text(tVal.toFixed(3) + ' BHD');
            $('#qvNotes').text(row.notes ? 'Notes: ' + row.notes : '');

            $('#qvReturnBtn').data('id', row.id).attr('data-id', row.id);

            new bootstrap.Modal(document.getElementById('quickViewContractModal')).show();
        });

        $(document).on('click', '.btn-return-modal', function() {
            const id = parseInt($(this).attr('data-id') || $(this).data('id'), 10);
            const row = allContracts.find(c => c.id === id);
            if (!row) return;

            const qvModal = bootstrap.Modal.getInstance(document.getElementById('quickViewContractModal'));
            if (qvModal) qvModal.hide();

            const params = new URLSearchParams({
                embed_return: '1',
                contract_id: row.id,
                agreement_no: row.agreement_no || '',
                vehicle_id: row.vehicle_id || '',
                customer_code: row.customer_code || '',
                model_id: row.model_id || '',
                booking_ids: row.booking_ids || '',
                booking_no: row.booking_no || row.agreement_no || ''
            });

            const iframe = document.getElementById('returnModalIframe');
            iframe.src = `${contractListBaseUrl}&${params.toString()}`;
            iframe.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });

        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'returnModalClosed') {
                const iframe = document.getElementById('returnModalIframe');
                iframe.style.display = 'none';
                iframe.src = 'about:blank';
                document.body.style.overflow = '';
                if (event.data.returned) {
                    loadActiveContracts();
                }
            }
        });

        $('#qvPrintBtn').on('click', function() {
            if (!currentAgreementNo) return;
            fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(currentAgreementNo))
                .then(r => r.text())
                .then(token => {
                    if (token) {
                        window.open('/PrintAgreement?token=' + encodeURIComponent(token.trim()), '_blank');
                    }
                });
        });

        loadActiveContracts();
    })();
    </script>
</body>
</html>
