<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /Logout");
    exit();
}
include ROOT_PATH . '/view/envinclude.php';
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
        .cc-kpi-card {
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            border: 1px solid #e2e8f0;
        }
        .cc-kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(27, 61, 148, 0.12);
        }
        .cc-kpi-card.active-kpi {
            border: 2px solid #1b3d94 !important;
            background-color: #f4f7fe;
        }
        .row-collected { background-color: #e8fadf !important; }
        .row-bounced { background-color: #ffe5e5 !important; }
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
                        <!-- Due / Overdue Notification Banner -->
                        <div id="ccDueAlertBanner" class="alert alert-danger d-none align-items-center justify-content-between flex-wrap gap-2 shadow-sm mb-3" role="alert">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ri-alarm-warning-fill ri-22px"></i>
                                <div id="ccDueAlertText" class="fw-semibold"></div>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" id="btnFilterDueOverdue">
                                <i class="ri-filter-3-line me-1"></i> Show Due &amp; Overdue Only
                            </button>
                        </div>

                        <!-- KPI Summary Cards -->
                        <div class="row g-3 mb-3">
                            <div class="col-6 col-lg">
                                <div class="card cc-kpi-card h-100" data-filter="overdue">
                                    <div class="card-body py-2 px-3">
                                        <span class="text-muted small d-block">Overdue Pending</span>
                                        <h4 class="fw-bold text-danger mb-0" id="kpiOverdueCount">0</h4>
                                        <small class="text-danger fw-semibold" id="kpiOverdueAmt">0.000 BHD</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg">
                                <div class="card cc-kpi-card h-100" data-filter="due_today">
                                    <div class="card-body py-2 px-3">
                                        <span class="text-muted small d-block">Due Today</span>
                                        <h4 class="fw-bold text-warning mb-0" id="kpiDueTodayCount">0</h4>
                                        <small class="text-warning fw-semibold" id="kpiDueTodayAmt">0.000 BHD</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg">
                                <div class="card cc-kpi-card h-100" data-filter="upcoming">
                                    <div class="card-body py-2 px-3">
                                        <span class="text-muted small d-block">Upcoming Pending</span>
                                        <h4 class="fw-bold text-info mb-0" id="kpiUpcomingCount">0</h4>
                                        <small class="text-info fw-semibold" id="kpiUpcomingAmt">0.000 BHD</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg">
                                <div class="card cc-kpi-card h-100" data-filter="collected">
                                    <div class="card-body py-2 px-3">
                                        <span class="text-muted small d-block">Collected</span>
                                        <h4 class="fw-bold text-success mb-0" id="kpiCollectedCount">0</h4>
                                        <small class="text-success fw-semibold" id="kpiCollectedAmt">0.000 BHD</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg">
                                <div class="card cc-kpi-card h-100" data-filter="bounced">
                                    <div class="card-body py-2 px-3">
                                        <span class="text-muted small d-block">Bounced</span>
                                        <h4 class="fw-bold text-secondary mb-0" id="kpiBouncedCount">0</h4>
                                        <small class="text-secondary fw-semibold" id="kpiBouncedAmt">0.000 BHD</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cheques Table Card -->
                        <div class="card shadow-sm">
                            <div class="card-header border-bottom py-3">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label small fw-semibold mb-1">Status Filter</label>
                                        <select id="ccStatusFilter" class="form-select form-select-sm">
                                            <option value="all" selected>All Cheques</option>
                                            <option value="due_overdue">Due Today &amp; Overdue</option>
                                            <option value="pending">All Pending</option>
                                            <option value="overdue">Overdue Only</option>
                                            <option value="due_today">Due Today Only</option>
                                            <option value="upcoming">Upcoming Pending</option>
                                            <option value="collected">Collected</option>
                                            <option value="bounced">Bounced</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-semibold mb-1">From Cheque Date</label>
                                        <input type="date" id="ccFromDate" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-semibold mb-1">To Cheque Date</label>
                                        <input type="date" id="ccToDate" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-semibold mb-1">Search</label>
                                        <input type="text" id="ccSearchInput" class="form-control form-control-sm" placeholder="Cheque No, Customer, Agreement, Bank...">
                                    </div>
                                    <div class="col-md-2 d-flex gap-2">
                                        <button type="button" id="btnResetChequeFilters" class="btn btn-sm btn-outline-secondary flex-grow-1">Reset</button>
                                        <button type="button" id="btnRefreshCheques" class="btn btn-sm btn-primary flex-grow-1">
                                            <i class="ri-refresh-line me-1"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="chequeCollectionTable" class="table table-hover table-sm align-middle w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Cheque Date</th>
                                                <th>Cheque No</th>
                                                <th>Customer</th>
                                                <th>Agreement / Ref</th>
                                                <th>Bank Details</th>
                                                <th class="text-end">Amount (BHD)</th>
                                                <th class="text-center">Status</th>
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

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script>
    (function() {
        let allCheques = [];
        let dt = null;

        function esc(s) {
            return String(s || '').replace(/[&<>"']/g, ch => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[ch]));
        }

        function fmtDate(val) {
            if (!val) return '-';
            const s = String(val).substring(0, 10);
            const p = s.split('-');
            return (p.length === 3 && p[0].length === 4) ? `${p[2]}-${p[1]}-${p[0]}` : s;
        }

        function updateDueBanner(summary) {
            const ovCnt = parseInt(summary.overdue_count || 0, 10);
            const ovAmt = Number(summary.overdue_amount || 0).toFixed(3);
            const dtCnt = parseInt(summary.due_today_count || 0, 10);
            const dtAmt = Number(summary.due_today_amount || 0).toFixed(3);

            if (ovCnt > 0 || dtCnt > 0) {
                const parts = [];
                if (ovCnt > 0) parts.push(`${ovCnt} Overdue Cheque(s) (${ovAmt} BHD)`);
                if (dtCnt > 0) parts.push(`${dtCnt} Cheque(s) Due Today (${dtAmt} BHD)`);
                $('#ccDueAlertText').html(`Due Cheque Notification: ${parts.join(' &amp; ')} pending collection.`);
                $('#ccDueAlertBanner').removeClass('d-none').addClass('d-flex');
            } else {
                $('#ccDueAlertBanner').addClass('d-none').removeClass('d-flex');
            }
        }

        function getFilteredRows() {
            const stFilter = $('#ccStatusFilter').val() || 'all';
            const fromD = $('#ccFromDate').val() || '';
            const toD = $('#ccToDate').val() || '';
            const q = ($('#ccSearchInput').val() || '').trim().toLowerCase();

            return allCheques.filter(r => {
                const ds = r.due_state || 'upcoming';
                const cs = String(r.cheque_status || 'Pending').toLowerCase();
                if (stFilter === 'due_overdue' && ds !== 'overdue' && ds !== 'due_today') return false;
                if (stFilter === 'pending' && cs !== 'pending') return false;
                if (['overdue', 'due_today', 'upcoming', 'collected', 'bounced'].includes(stFilter) && ds !== stFilter) return false;

                const cd = String(r.cheque_date || '').substring(0, 10);
                if (fromD && (!cd || cd < fromD)) return false;
                if (toD && (!cd || cd > toD)) return false;

                if (q) {
                    const hay = [r.ref_no, r.customer_name, r.customer_mobile, r.agreement_no, r.trans_type, r.bank_name, r.company_bank_name].join(' ').toLowerCase();
                    if (!hay.includes(q)) return false;
                }
                return true;
            });
        }

        function renderTable() {
            const rows = getFilteredRows();
            if (!dt) {
                dt = $('#chequeCollectionTable').DataTable({
                    data: rows,
                    pageLength: 25,
                    order: [],
                    dom: 't<"d-flex justify-content-between align-items-center mt-3"ip>',
                    columns: [
                        { data: null, className: 'text-center', render: (d, t, r, meta) => meta.row + 1 },
                        {
                            data: null,
                            className: 'text-nowrap',
                            render: r => {
                                let dueBadge = '';
                                if (r.due_state === 'overdue') dueBadge = '<span class="badge bg-danger ms-1">Overdue</span>';
                                else if (r.due_state === 'due_today') dueBadge = '<span class="badge bg-warning text-dark ms-1">Due Today</span>';
                                else if (r.due_state === 'upcoming') dueBadge = '<span class="badge bg-label-info ms-1">Upcoming</span>';
                                return `<strong>${fmtDate(r.cheque_date)}</strong>${dueBadge}<div class="small text-muted">Entry: ${fmtDate(r.trans_date)}</div>`;
                            }
                        },
                        { data: 'ref_no', render: v => `<strong>${esc(v || '-')}</strong>` },
                        {
                            data: null,
                            render: r => `<div class="fw-semibold">${esc(r.customer_name || r.customer_code || '-')}</div><small class="text-muted">${esc(r.customer_mobile || '')}</small>`
                        },
                        {
                            data: null,
                            render: r => `<div>${esc(r.agreement_no || '-')}</div><small class="text-muted">${esc(r.trans_type || '')}</small>`
                        },
                        {
                            data: null,
                            render: r => {
                                let out = '';
                                if (r.bank_name) out += `<div class="small text-primary"><i class="ri-bank-line me-1"></i>From: ${esc(r.bank_name)}</div>`;
                                if (r.company_bank_name) out += `<div class="small text-success"><i class="ri-bank-fill me-1"></i>To: ${esc(r.company_bank_name)}</div>`;
                                return out || '<span class="text-muted">-</span>';
                            }
                        },
                        {
                            data: null,
                            className: 'text-end fw-bold text-nowrap',
                            render: r => Number(r.credit > 0 ? r.credit : r.debit).toFixed(3)
                        },
                        {
                            data: null,
                            className: 'text-center text-nowrap',
                            render: r => {
                                const cs = r.cheque_status || 'Pending';
                                const cls = cs === 'Collected' ? 'bg-success' : (cs === 'Bounced' ? 'bg-danger' : 'bg-warning text-dark');
                                let html = `<span class="badge ${cls}">${esc(cs)}</span>`;
                                if (cs === 'Collected' && r.collected_at) {
                                    html += `<div class="small text-success mt-1">${fmtDate(r.collected_at)}</div>`;
                                }
                                return html;
                            }
                        },
                        {
                            data: null,
                            className: 'text-center text-nowrap',
                            orderable: false,
                            render: r => {
                                const cs = r.cheque_status || 'Pending';
                                if (cs === 'Pending') {
                                    return `
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-success btn-cc-status" data-id="${r.ids}" data-status="Collected" title="Mark Collected">
                                                <i class="ri-check-line me-1"></i> Collect
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-cc-status" data-id="${r.ids}" data-status="Bounced" title="Mark Bounced">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </div>
                                    `;
                                }
                                return `
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-cc-status" data-id="${r.ids}" data-status="Pending" title="Revoke back to Pending">
                                        <i class="ri-refresh-line me-1"></i> Revoke
                                    </button>
                                `;
                            }
                        }
                    ],
                    createdRow: function(row, data) {
                        if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                        else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
                    }
                });
            } else {
                dt.clear().rows.add(rows).draw();
            }
        }

        function loadCheques() {
            $.get('/CustomerLedgerController', { action: 'GetChequesCollection' }, function(res) {
                if (!res || !res.status) return;
                allCheques = res.data || [];
                const s = res.summary || {};
                $('#kpiOverdueCount').text(s.overdue_count || 0);
                $('#kpiOverdueAmt').text(Number(s.overdue_amount || 0).toFixed(3) + ' BHD');
                $('#kpiDueTodayCount').text(s.due_today_count || 0);
                $('#kpiDueTodayAmt').text(Number(s.due_today_amount || 0).toFixed(3) + ' BHD');
                $('#kpiUpcomingCount').text(s.upcoming_count || 0);
                $('#kpiUpcomingAmt').text(Number(s.upcoming_amount || 0).toFixed(3) + ' BHD');
                $('#kpiCollectedCount').text(s.collected_count || 0);
                $('#kpiCollectedAmt').text(Number(s.collected_amount || 0).toFixed(3) + ' BHD');
                $('#kpiBouncedCount').text(s.bounced_count || 0);
                $('#kpiBouncedAmt').text(Number(s.bounced_amount || 0).toFixed(3) + ' BHD');
                updateDueBanner(s);
                renderTable();
            }, 'json');
        }

        $(document).on('click', '.cc-kpi-card', function() {
            const f = $(this).data('filter') || 'all';
            $('.cc-kpi-card').removeClass('active-kpi');
            $(this).addClass('active-kpi');
            $('#ccStatusFilter').val(f);
            renderTable();
        });

        $('#btnFilterDueOverdue').on('click', function() {
            $('.cc-kpi-card').removeClass('active-kpi');
            $('#ccStatusFilter').val('due_overdue');
            renderTable();
        });

        $('#ccStatusFilter, #ccFromDate, #ccToDate').on('change', renderTable);
        $('#ccSearchInput').on('input', renderTable);
        $('#btnRefreshCheques').on('click', loadCheques);
        $('#btnResetChequeFilters').on('click', function() {
            $('.cc-kpi-card').removeClass('active-kpi');
            $('#ccStatusFilter').val('all');
            $('#ccFromDate, #ccToDate, #ccSearchInput').val('');
            renderTable();
        });

        $(document).on('click', '.btn-cc-status', function() {
            const id = $(this).data('id');
            const status = $(this).data('status');
            const msg = status === 'Pending' ? 'Revoke cheque status back to Pending?' : `Mark this cheque as ${status}?`;
            const doUpdate = () => {
                $.post('/CustomerLedgerController', { action: 'UpdateChequeStatus', ids: id, status: status }, function(res) {
                    if (res && res.status) {
                        loadCheques();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: `Cheque marked as ${status}.`, showConfirmButton: false, timer: 2400 });
                        }
                    } else {
                        const err = (res && res.message) || 'Failed to update cheque status.';
                        if (typeof Swal !== 'undefined') Swal.fire('Error', err, 'error');
                        else alert(err);
                    }
                }, 'json');
            };
            if (typeof Swal !== 'undefined') {
                Swal.fire({ title: 'Confirm Cheque Update', text: msg, icon: 'question', showCancelButton: true, confirmButtonText: 'Yes, proceed' })
                    .then(r => { if (r.isConfirmed) doUpdate(); });
            } else if (confirm(msg)) {
                doUpdate();
            }
        });

        loadCheques();
    })();
    </script>
</body>
</html>
