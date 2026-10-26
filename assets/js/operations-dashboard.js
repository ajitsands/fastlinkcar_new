/**
 * AA CAR RENTAL - OPERATIONS DASHBOARD ENGINE
 * Supports dynamic company filtering, user access privileges, live KPIs, compliance alerts,
 * expected returns monitor, and financial collections breakdown.
 */

$(document).ready(function () {
    'use strict';

    // State Variables
    let currentCompanyId = 'all';
    let currentTimeframe = 'this_month';
    let currentCustomFrom = '';
    let currentCustomTo = '';
    let currentAlertTab = 'overdue';
    let currentTableFilter = 'all';
    
    let dashboardDataCache = null;
    let expectedReturnsDataTable = null;
    let vehicleCalendarInstance = null;
    let vehicleReturnCalendarInstance = null;

    // 1. Live Clock
    function updateClock() {
        const now = new Date();
        const options = { 
            weekday: 'short', 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true 
        };
        const clockEl = document.getElementById('dash_live_clock');
        if (clockEl) {
            clockEl.textContent = now.toLocaleDateString('en-GB', options);
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    // 2. Initialize Company Access Filter
    function initCompanyFilter() {
        $.ajax({
            url: '/DashboardController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'getCompanies' }),
            success: function (res) {
                const data = (typeof res === 'string') ? JSON.parse(res) : res;
                if (!data || !data.status) {
                    console.error('Failed to load companies:', data);
                    return;
                }

                const $select = $('#dash_company_select');
                $select.empty();

                const companies = data.companies || [];
                const isSuperAdmin = data.is_super_admin;
                const hasMultiple = data.has_multiple;
                currentCompanyId = data.default_company || 'all';

                // If user has access to multiple companies or super admin, provide "All Companies"
                if (isSuperAdmin || hasMultiple) {
                    $select.append('<option value="all">All Companies (Combined)</option>');
                }

                companies.forEach(function (c) {
                    $select.append(`<option value="${c.ids}">${c.company_name}</option>`);
                });

                // If single company assigned, lock the select
                if (!isSuperAdmin && !hasMultiple) {
                    $select.prop('disabled', true);
                    $select.addClass('bg-light');
                    $('#companyContextBadge').text(companies[0] ? companies[0].company_name : 'Single Branch');
                } else {
                    $select.val(currentCompanyId);
                    updateCompanyContextBadge();
                }

                // Initialize Select2 if available
                if ($.fn.select2) {
                    $select.select2({
                        minimumResultsForSearch: 10,
                        width: '100%'
                    });
                }

                // Initial dashboard load
                loadDashboardData();
            },
            error: function (err) {
                console.error('Error fetching companies:', err);
                loadDashboardData();
            }
        });
    }

    function updateCompanyContextBadge() {
        const text = $('#dash_company_select option:selected').text() || 'All Companies';
        $('#companyContextBadge').text(text);
    }

    // Company Change Handler
    $(document).on('change', '#dash_company_select', function () {
        currentCompanyId = $(this).val();
        updateCompanyContextBadge();
        loadDashboardData();
    });

    // 3. Timeframe Selector Handlers
    $(document).on('click', '.dash-timeframe-btn', function () {
        const tf = $(this).data('timeframe');
        if (!tf) return; // Custom toggle button handled separately

        $('.dash-timeframe-btn').removeClass('active btn-primary fw-semibold').addClass('btn-outline-secondary');
        $(this).removeClass('btn-outline-secondary').addClass('active btn-primary fw-semibold');

        currentTimeframe = tf;
        $('#dash_custom_range_bar').addClass('d-none');
        loadDashboardData();
    });

    // Custom Date Range Toggle
    $(document).on('click', '#dash_btn_custom_toggle', function () {
        $('#dash_custom_range_bar').toggleClass('d-none');
    });

    $(document).on('click', '#dash_btn_cancel_custom', function () {
        $('#dash_custom_range_bar').addClass('d-none');
    });

    $(document).on('click', '#dash_btn_apply_custom', function () {
        currentCustomFrom = $('#dash_custom_from').val();
        currentCustomTo = $('#dash_custom_to').val();
        if (!currentCustomFrom || !currentCustomTo) {
            Swal.fire('Warning', 'Please choose both start and end dates.', 'warning');
            return;
        }
        currentTimeframe = 'custom';
        $('.dash-timeframe-btn').removeClass('active btn-primary fw-semibold').addClass('btn-outline-secondary');
        $('#dash_btn_custom_toggle').removeClass('btn-outline-secondary').addClass('active btn-primary fw-semibold');
        loadDashboardData();
    });

    // Refresh Button Handler
    $(document).on('click', '#dash_btn_refresh', function () {
        loadDashboardData();
    });

    // 4. Main Data Loader
    function loadDashboardData() {
        const $icon = $('#dash_refresh_icon');
        $icon.addClass('spin');

        const postData = {
            action: 'getDashboardData',
            company_id: currentCompanyId,
            timeframe: currentTimeframe,
            from_date: currentCustomFrom,
            to_date: currentCustomTo
        };

        $.ajax({
            url: '/DashboardController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(postData),
            success: function (res) {
                $icon.removeClass('spin');
                const response = (typeof res === 'string') ? JSON.parse(res) : res;
                if (!response || !response.status) {
                    console.error('Dashboard load failed:', response);
                    return;
                }

                dashboardDataCache = response.data;
                renderDashboard(response.data);
            },
            error: function (xhr, status, error) {
                $icon.removeClass('spin');
                console.error('Dashboard AJAX error:', error);
            }
        });
    }

    // 5. Render Dashboard View
    function renderDashboard(data) {
        if (!data) return;

        const kpis = data.kpis || {};
        const fleet = data.fleet_breakdown || [];
        const payments = data.payment_methods || {};
        const categories = data.categories || [];
        const alerts = data.alerts || {};
        const returns = data.expected_returns || [];
        const recent = data.recent_contracts || [];
        const timeframeLabel = data.timeframe_label || 'Period';

        // Update Timeframe Labels
        $('.dash-timeframe-label').text(timeframeLabel);

        // ----------------- TOP KPI ROW -----------------
        // Utilization Rate
        const util = parseFloat(kpis.utilization_rate || 0);
        $('#kpi_utilization_rate').text(util.toFixed(1) + '%');
        $('#kpi_utilization_bar').css('width', Math.min(100, util) + '%');
        $('#kpi_utilization_sub').text(`${kpis.rented_fleet + kpis.extended_contracts} on road / ${kpis.active_fleet} active fleet`);

        const $utilBadge = $('#kpi_utilization_badge');
        if (util >= 75) {
            $utilBadge.text('High Demand').removeClass().addClass('badge bg-label-success fs-tiny');
            $('#kpi_utilization_bar').removeClass().addClass('progress-bar bg-success');
        } else if (util >= 50) {
            $utilBadge.text('Optimal').removeClass().addClass('badge bg-label-primary fs-tiny');
            $('#kpi_utilization_bar').removeClass().addClass('progress-bar bg-primary');
        } else {
            $utilBadge.text('Capacity Avail').removeClass().addClass('badge bg-label-warning fs-tiny');
            $('#kpi_utilization_bar').removeClass().addClass('progress-bar bg-warning');
        }

        // Active Contracts
        $('#kpi_active_contracts').text(kpis.active_contracts || 0);
        $('#kpi_active_rentout').text(kpis.rented_fleet || 0);
        $('#kpi_active_extended').text(kpis.extended_contracts || 0);

        // Overdue Returns
        const overdueCount = parseInt(kpis.overdue_count || 0);
        $('#kpi_overdue_count').text(overdueCount);
        const $cardOverdue = $('#card_overdue_container');
        const $overdueBadge = $('#kpi_overdue_badge');
        if (overdueCount > 0) {
            $cardOverdue.addClass('dash-accent-danger');
            $overdueBadge.text('Urgent (' + overdueCount + ')').removeClass().addClass('badge bg-label-danger fs-tiny');
        } else {
            $cardOverdue.removeClass('dash-accent-danger');
            $overdueBadge.text('All Clear').removeClass().addClass('badge bg-label-success fs-tiny');
        }

        // Due Today
        $('#kpi_returns_today_count').text(kpis.returns_today_count || 0);

        // Period Billings
        $('#kpi_period_revenue').text(kpis.period_revenue || '0.000');

        // Period Collections
        $('#kpi_period_collections').text(kpis.period_collections || '0.000');

        // ----------------- ROW 2: FLEET & FINANCIALS -----------------
        // Fleet Total & Breakdown
        $('#fleet_total_count').text(kpis.total_fleet || 0);
        $('#count_available').text(kpis.available_fleet || 0);
        $('#count_rentout').text(kpis.rented_fleet || 0);
        $('#count_parking').text(kpis.parking_fleet || 0);
        $('#count_maintenance').text(kpis.maintenance_fleet || 0);
        $('#count_blocked').text(kpis.blocked_fleet || 0);

        // Segmented Fleet Progress Bar
        const tot = kpis.total_fleet || 1;
        const pAvail = ((kpis.available_fleet / tot) * 100).toFixed(1);
        const pRent = ((kpis.rented_fleet / tot) * 100).toFixed(1);
        const pPark = ((kpis.parking_fleet / tot) * 100).toFixed(1);
        const pMaint = ((kpis.maintenance_fleet / tot) * 100).toFixed(1);
        const pBlock = ((kpis.blocked_fleet / tot) * 100).toFixed(1);

        const $bar = $('#fleet_segmented_bar');
        $bar.html(`
            <div class="fleet-progress-seg bg-success" style="width: ${pAvail}%;" title="Available: ${kpis.available_fleet} (${pAvail}%)"></div>
            <div class="fleet-progress-seg bg-primary" style="width: ${pRent}%;" title="On Rent: ${kpis.rented_fleet} (${pRent}%)"></div>
            <div class="fleet-progress-seg bg-info" style="width: ${pPark}%;" title="In Parking: ${kpis.parking_fleet} (${pPark}%)"></div>
            <div class="fleet-progress-seg bg-warning" style="width: ${pMaint}%;" title="Maintenance: ${kpis.maintenance_fleet} (${pMaint}%)"></div>
            <div class="fleet-progress-seg bg-danger" style="width: ${pBlock}%;" title="Blocked: ${kpis.blocked_fleet} (${pBlock}%)"></div>
        `);

        // Category Chips
        const $catChips = $('#fleet_category_chips');
        if (categories.length > 0) {
            let catHtml = '';
            categories.forEach(function (cat) {
                const catName = cat.category_name || cat.category || 'Standard Fleet';
                const total = parseInt(cat.total_count !== undefined ? cat.total_count : (cat.total !== undefined ? cat.total : 0));
                const rented = parseInt(cat.rented_count !== undefined ? cat.rented_count : (cat.rented !== undefined ? cat.rented : 0));
                const cUtil = total > 0 ? Math.round((rented / total) * 100) : 0;
                catHtml += `
                    <div class="badge bg-light text-dark border p-2 d-flex align-items-center gap-2">
                        <span class="fw-semibold">${catName}</span>
                        <span class="badge bg-primary text-white">${rented}/${total}</span>
                        <small class="text-muted">${cUtil}%</small>
                    </div>
                `;
            });
            $catChips.html(catHtml);
        } else {
            $catChips.html('<span class="text-muted small">No category data recorded</span>');
        }

        // Financial Collections & Receivables
        $('#net_outstanding_amount').text(kpis.net_outstanding || '0.000');
        $('#pay_method_cash').text(payments.cash || '0.000');
        $('#pay_method_card').text(payments.card || '0.000');
        $('#pay_method_benefit').text(payments.benefit || '0.000');
        $('#pay_method_bank').text(payments.bank || '0.000');

        // ----------------- ROW 3: ALERTS & NOTICES -----------------
        $('#total_alerts_badge').text(alerts.total_alerts || 0);
        $('#alert_tab_overdue_count').text((alerts.overdue || []).length);
        $('#alert_tab_today_count').text((alerts.due_today || []).length);
        $('#alert_tab_insurance_count').text((alerts.insurance || []).length);
        $('#alert_tab_passing_count').text((alerts.passing || []).length);
        $('#alert_tab_maint_count').text((alerts.maintenance || []).length);

        renderAlertStream(currentAlertTab, alerts);

        // ----------------- EXPECTED RETURNS TABLE -----------------
        renderExpectedReturnsTable(returns);

        // ----------------- RECENT CONTRACTS -----------------
        renderRecentContracts(recent);
    }

    // 6. Render Alert Stream by Tab (Serene, eye-friendly layout with bulletproof property fallbacks)
    function renderAlertStream(tab, alerts) {
        if (!alerts) alerts = (dashboardDataCache && dashboardDataCache.alerts) ? dashboardDataCache.alerts : {};
        const $container = $('#alerts_stream_container');
        let html = '';

        if (tab === 'overdue') {
            const list = alerts.overdue || [];
            if (list.length === 0) {
                html = `<div class="text-center py-4 text-success"><i class="ri ri-checkbox-circle-line fs-2 d-block mb-1"></i>No overdue returns currently! Outstanding fleet is compliant.</div>`;
            } else {
                list.forEach(function (item) {
                    const agrNo = item.agreement_no || item.contract_no || 'N/A';
                    const custName = item.customer || item.customer_name || 'N/A';
                    const vehNo = item.vehicle_no || item.vehicle_number || 'N/A';
                    const daysOverdue = item.days_overdue || item.overdue_days || 0;
                    const retDate = item.return_date || item.expected_return || 'N/A';

                    html += `
                        <div class="dash-alert-item dash-alert-overdue p-2 mb-2 rounded bg-white shadow-2xs position-relative">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <span class="badge bg-label-danger fs-tiny mb-1">
                                        <i class="ri ri-alarm-warning-line me-1"></i>Overdue ${daysOverdue} Days
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="fw-bold text-dark print_contract cursor-pointer" data-contract="${agrNo}" title="Click to View / Print Agreement PDF">
                                            <i class="ri ri-file-text-line text-danger me-1"></i>${agrNo}
                                        </div>
                                        <a href="/ContractList" class="btn btn-xs btn-outline-secondary py-0 px-1" title="Open in Contract List">
                                            <i class="ri ri-external-link-line" style="font-size: 11px;"></i>
                                        </a>
                                    </div>
                                    <div class="small text-muted mt-1">
                                        <i class="ri ri-user-line me-1"></i>${custName} 
                                        ${item.mobile ? `<a href="tel:${item.mobile}" class="text-muted ms-1">(${item.mobile})</a>` : ''}
                                    </div>
                                    <div class="small fw-semibold text-secondary mt-1">
                                        <span class="badge bg-light text-dark border px-1" style="font-size: 11px;">${vehNo}</span>
                                    </div>
                                </div>
                                <div class="text-end ps-2">
                                    <small class="text-muted d-block" style="font-size: 10px;">Due Since</small>
                                    <small class="fw-semibold text-danger">${retDate}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
        } else if (tab === 'due_today') {
            const list = alerts.due_today || [];
            if (list.length === 0) {
                html = `<div class="text-center py-4 text-muted"><i class="ri ri-calendar-check-line fs-2 d-block mb-1"></i>No more vehicle returns scheduled for today.</div>`;
            } else {
                list.forEach(function (item) {
                    const agrNo = item.agreement_no || item.contract_no || 'N/A';
                    const custName = item.customer || item.customer_name || 'N/A';
                    const vehNo = item.vehicle_no || item.vehicle_number || 'N/A';

                    html += `
                        <div class="dash-alert-item dash-alert-today p-2 mb-2 rounded bg-white shadow-2xs position-relative">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <span class="badge bg-label-warning fs-tiny mb-1">
                                        <i class="ri ri-time-line me-1"></i>Expected Today
                                    </span>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="fw-bold text-dark print_contract cursor-pointer" data-contract="${agrNo}" title="Click to View / Print Agreement PDF">
                                            <i class="ri ri-file-text-line text-warning me-1"></i>${agrNo}
                                        </div>
                                        <a href="/ContractList" class="btn btn-xs btn-outline-secondary py-0 px-1" title="Open in Contract List">
                                            <i class="ri ri-external-link-line" style="font-size: 11px;"></i>
                                        </a>
                                    </div>
                                    <div class="small text-muted mt-1">
                                        <i class="ri ri-user-line me-1"></i>${custName} 
                                        ${item.mobile ? `<a href="tel:${item.mobile}" class="text-muted ms-1">(${item.mobile})</a>` : ''}
                                    </div>
                                    <div class="small fw-semibold text-secondary mt-1">
                                        <span class="badge bg-light text-dark border px-1" style="font-size: 11px;">${vehNo}</span>
                                    </div>
                                </div>
                                <div class="text-end ps-2">
                                    <small class="text-muted d-block" style="font-size: 10px;">Check-in By</small>
                                    <small class="fw-bold text-warning">${item.return_time || 'EOD'}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
        } else if (tab === 'insurance') {
            const list = alerts.insurance || [];
            if (list.length === 0) {
                html = `<div class="text-center py-4 text-success"><i class="ri ri-shield-check-line fs-2 d-block mb-1"></i>All vehicle insurance policies are valid & up-to-date!</div>`;
            } else {
                list.forEach(function (item) {
                    const vehNo = item.vehicle_number || item.vehicle_no || 'N/A';
                    const model = item.model_names || item.model || '';
                    const expDate = item.expiry_date || item.date || 'N/A';
                    const days = parseInt(item.days_left !== undefined ? item.days_left : 0);

                    let badgeHtml = '';
                    if (days < 0) {
                        badgeHtml = `<span class="badge bg-label-danger fs-tiny mb-1"><i class="ri ri-error-warning-line me-1"></i>Expired ${Math.abs(days)}d ago</span>`;
                    } else if (days === 0) {
                        badgeHtml = `<span class="badge bg-label-warning fs-tiny mb-1"><i class="ri ri-time-line me-1"></i>Expires Today</span>`;
                    } else if (days <= 7) {
                        badgeHtml = `<span class="badge bg-label-danger fs-tiny mb-1"><i class="ri ri-calendar-close-line me-1"></i>${days} Days Left</span>`;
                    } else if (days <= 15) {
                        badgeHtml = `<span class="badge bg-label-warning fs-tiny mb-1"><i class="ri ri-calendar-event-line me-1"></i>${days} Days Left</span>`;
                    } else {
                        badgeHtml = `<span class="badge bg-label-info fs-tiny mb-1"><i class="ri ri-calendar-check-line me-1"></i>${days} Days Left</span>`;
                    }

                    html += `
                        <div class="dash-alert-item dash-alert-insurance p-2 mb-2 rounded bg-white shadow-2xs position-relative">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    ${badgeHtml}
                                    <div class="fw-bold text-dark d-flex align-items-center gap-1">
                                        <span class="badge bg-light text-dark border px-1" style="font-size: 11px;">${vehNo}</span>
                                        <span>${model}</span>
                                    </div>
                                    <small class="text-muted d-block mt-1">Policy Expiry: <b class="text-dark">${expDate}</b></small>
                                </div>
                                <button class="btn btn-xs btn-outline-primary btn_vehicle_view" data-id="${item.vehicle_id || item.ids}" title="View Vehicle Profile">
                                    <i class="ri ri-information-line"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
            }
        } else if (tab === 'passing') {
            const list = alerts.passing || [];
            if (list.length === 0) {
                html = `<div class="text-center py-4 text-success"><i class="ri ri-car-line fs-2 d-block mb-1"></i>All passing / registrations are current.</div>`;
            } else {
                list.forEach(function (item) {
                    const vehNo = item.vehicle_number || item.vehicle_no || 'N/A';
                    const model = item.model_names || item.model || '';
                    const expDate = item.expiry_date || item.date || 'N/A';
                    const days = parseInt(item.days_left !== undefined ? item.days_left : 0);

                    let badgeHtml = '';
                    if (days < 0) {
                        badgeHtml = `<span class="badge bg-label-danger fs-tiny mb-1"><i class="ri ri-error-warning-line me-1"></i>Expired ${Math.abs(days)}d ago</span>`;
                    } else if (days === 0) {
                        badgeHtml = `<span class="badge bg-label-warning fs-tiny mb-1"><i class="ri ri-time-line me-1"></i>Expires Today</span>`;
                    } else if (days <= 7) {
                        badgeHtml = `<span class="badge bg-label-danger fs-tiny mb-1"><i class="ri ri-calendar-close-line me-1"></i>${days} Days Left</span>`;
                    } else if (days <= 15) {
                        badgeHtml = `<span class="badge bg-label-warning fs-tiny mb-1"><i class="ri ri-calendar-event-line me-1"></i>${days} Days Left</span>`;
                    } else {
                        badgeHtml = `<span class="badge bg-label-info fs-tiny mb-1"><i class="ri ri-calendar-check-line me-1"></i>${days} Days Left</span>`;
                    }

                    html += `
                        <div class="dash-alert-item dash-alert-passing p-2 mb-2 rounded bg-white shadow-2xs position-relative">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    ${badgeHtml}
                                    <div class="fw-bold text-dark d-flex align-items-center gap-1">
                                        <span class="badge bg-light text-dark border px-1" style="font-size: 11px;">${vehNo}</span>
                                        <span>${model}</span>
                                    </div>
                                    <small class="text-muted d-block mt-1">Passing Date: <b class="text-dark">${expDate}</b></small>
                                </div>
                                <button class="btn btn-xs btn-outline-primary btn_vehicle_view" data-id="${item.vehicle_id || item.ids}" title="View Vehicle Profile">
                                    <i class="ri ri-information-line"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
            }
        } else if (tab === 'maintenance') {
            const list = alerts.maintenance || [];
            if (list.length === 0) {
                html = `<div class="text-center py-4 text-success"><i class="ri ri-tools-line fs-2 d-block mb-1"></i>No scheduled maintenance due within the next 14 days.</div>`;
            } else {
                list.forEach(function (item) {
                    const vehNo = item.vehicle_number || item.vehicle_no || 'N/A';
                    const model = item.model_names || item.model || '';
                    const expDate = item.expiry_date || item.date || 'N/A';
                    const days = parseInt(item.days_left !== undefined ? item.days_left : 0);

                    let badgeHtml = '';
                    if (days < 0) {
                        badgeHtml = `<span class="badge bg-label-danger fs-tiny mb-1"><i class="ri ri-tools-line me-1"></i>Overdue ${Math.abs(days)}d ago</span>`;
                    } else if (days === 0) {
                        badgeHtml = `<span class="badge bg-label-warning fs-tiny mb-1"><i class="ri ri-tools-line me-1"></i>Service Due Today</span>`;
                    } else {
                        badgeHtml = `<span class="badge ${days <= 3 ? 'bg-label-danger' : 'bg-label-warning'} fs-tiny mb-1"><i class="ri ri-tools-line me-1"></i>Service in ${days} Days</span>`;
                    }

                    html += `
                        <div class="dash-alert-item dash-alert-maintenance p-2 mb-2 rounded bg-white shadow-2xs position-relative">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    ${badgeHtml}
                                    <div class="fw-bold text-dark d-flex align-items-center gap-1">
                                        <span class="badge bg-light text-dark border px-1" style="font-size: 11px;">${vehNo}</span>
                                        <span>${model}</span>
                                    </div>
                                    <small class="text-muted d-block mt-1">Scheduled: <b class="text-dark">${expDate}</b></small>
                                </div>
                                <button class="btn btn-xs btn-outline-primary btn_vehicle_view" data-id="${item.vehicle_id || item.ids}" title="View Vehicle Profile">
                                    <i class="ri ri-tools-line"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
            }
        }

        $container.html(html);
    }

    // Alert Tab Switcher
    $(document).on('click', '.alert-filter-tabs .nav-link', function () {
        $('.alert-filter-tabs .nav-link').removeClass('active');
        $(this).addClass('active');
        currentAlertTab = $(this).data('alert-tab');
        renderAlertStream(currentAlertTab);
    });

    // 7. Render Expected Returns Table
    function renderExpectedReturnsTable(returnsList) {
        if (!returnsList) returnsList = (dashboardDataCache && dashboardDataCache.expected_returns) ? dashboardDataCache.expected_returns : [];

        // Compute counts
        let countAll = returnsList.length;
        let countOverdue = 0;
        let countToday = 0;
        let countUpcoming = 0;

        returnsList.forEach(function (r) {
            if (r.is_overdue) countOverdue++;
            else if (r.is_due_today) countToday++;
            else countUpcoming++;
        });

        $('#count_tbl_all').text(countAll);
        $('#count_tbl_overdue').text(countOverdue);
        $('#count_tbl_today').text(countToday);
        $('#count_tbl_upcoming').text(countUpcoming);

        // Filter based on active table button
        let filtered = returnsList;
        if (currentTableFilter === 'overdue') {
            filtered = returnsList.filter(r => r.is_overdue);
        } else if (currentTableFilter === 'today') {
            filtered = returnsList.filter(r => r.is_due_today);
        } else if (currentTableFilter === 'upcoming') {
            filtered = returnsList.filter(r => !r.is_overdue && !r.is_due_today);
        }

        if ($.fn.DataTable.isDataTable('#dashReturnsTable')) {
            $('#dashReturnsTable').DataTable().destroy();
        }

        const $tbody = $('#dashReturnsTableBody');
        $tbody.empty();

        if (filtered.length === 0) {
            $tbody.html('<tr><td colspan="8" class="text-center py-4 text-muted">No contracts match the selected filter.</td></tr>');
            return;
        }

        filtered.forEach(function (r) {
            let statusBadge = '';
            if (r.is_overdue) {
                statusBadge = `<span class="badge bg-label-danger"><i class="ri ri-alarm-warning-line me-1"></i>Overdue ${r.overdue_days}d</span>`;
            } else if (r.is_due_today) {
                statusBadge = `<span class="badge bg-label-warning"><i class="ri ri-time-line me-1"></i>Due Today</span>`;
            } else {
                statusBadge = `<span class="badge bg-label-info"><i class="ri ri-calendar-line me-1"></i>In ${r.days_left}d</span>`;
            }

            const contractStatusBadge = r.is_extended
                ? `<span class="badge bg-purple text-white fs-tiny ms-1">Extended</span>`
                : `<span class="badge bg-label-primary fs-tiny ms-1">Rentout</span>`;

            $tbody.append(`
                <tr>
                    <td class="ps-2">
                        <div class="fw-bold print_contract cursor-pointer text-primary" data-contract="${r.agreement_no}" title="Click to View / Print Contract PDF">
                            ${r.agreement_no}
                        </div>
                        <small class="text-muted d-block" style="font-size: 10px;">${r.company_name}</small>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">${r.vehicle_no}</div>
                        <small class="text-muted text-truncate d-block" style="max-width: 140px; font-size: 11px;">${r.vehicle_summary}</small>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark text-truncate" style="max-width: 160px;">${r.customer_name}</div>
                        <div class="d-flex align-items-center gap-1 text-muted" style="font-size: 11px;">
                            ${r.customer_mobile && r.customer_mobile !== 'N/A' ? `<a href="tel:${r.customer_mobile}" class="text-muted"><i class="ri ri-phone-line"></i> ${r.customer_mobile}</a>` : ''}
                            ${r.customer_cpr && r.customer_cpr !== 'N/A' ? `<span class="badge bg-light text-dark border px-1" style="font-size: 9px;">${r.customer_cpr}</span>` : ''}
                        </div>
                    </td>
                    <td><small class="text-dark">${r.start_date}</small></td>
                    <td><small class="fw-semibold text-dark">${r.expected_return}</small></td>
                    <td>
                        ${statusBadge}
                        ${contractStatusBadge}
                    </td>
                    <td class="text-end fw-bold text-dark">
                        ${r.total_agreed_amount} <small class="text-muted" style="font-size: 10px;">BHD</small>
                    </td>
                    <td class="text-center pe-2">
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            <button type="button" class="btn btn-xs btn-outline-primary print_contract d-inline-flex align-items-center gap-1" data-contract="${r.agreement_no}" title="View / Print Agreement PDF">
                                <i class="ri ri-file-text-line"></i>
                                <span>PDF</span>
                            </button>
                            <a href="/ContractList" class="btn btn-xs btn-outline-secondary d-inline-flex align-items-center" title="Open in Contract List">
                                <i class="ri ri-external-link-line"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            `);
        });

        // Initialize DataTable
        expectedReturnsDataTable = $('#dashReturnsTable').DataTable({
            pageLength: 8,
            lengthMenu: [5, 8, 15, 25, 50],
            responsive: true,
            destroy: true,
            dom: '<"d-flex justify-content-between align-items-center mb-2"f<"small"l>>t<"d-flex justify-content-between align-items-center mt-2"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search contracts...",
                lengthMenu: "_MENU_ per page",
                info: "Showing _START_ to _END_ of _TOTAL_ returns"
            }
        });
    }

    // Table Filter Button Handlers
    $(document).on('click', '.table-filter-btn', function () {
        $('.table-filter-btn').removeClass('active btn-primary btn-danger btn-warning btn-secondary').addClass('btn-outline-secondary');
        $(this).removeClass('btn-outline-secondary').addClass('active');

        const filter = $(this).data('filter');
        currentTableFilter = filter;
        if (filter === 'overdue') $(this).addClass('btn-danger');
        else if (filter === 'today') $(this).addClass('btn-warning text-dark');
        else $(this).addClass('btn-primary');

        renderExpectedReturnsTable();
    });

    // Action from KPI Cards to filter table
    $(document).on('click', '.filter-table-action', function (e) {
        e.preventDefault();
        const f = $(this).data('filter');
        $(`.table-filter-btn[data-filter="${f}"]`).trigger('click');
        $('html, body').animate({
            scrollTop: $('#dashReturnsTable').offset().top - 120
        }, 400);
    });

    // 8. Render Recent Contracts Stream
    function renderRecentContracts(recentList) {
        if (!recentList) recentList = (dashboardDataCache && dashboardDataCache.recent_contracts) ? dashboardDataCache.recent_contracts : [];
        const $tbody = $('#recent_contracts_body');
        $tbody.empty();

        if (recentList.length === 0) {
            $tbody.html('<tr><td colspan="7" class="text-center py-3 text-muted">No contracts recorded in this period.</td></tr>');
            return;
        }

        recentList.forEach(function (c) {
            $tbody.append(`
                <tr>
                    <td class="ps-2">
                        <span class="fw-bold print_contract cursor-pointer text-primary" data-contract="${c.agreement_no}">
                            ${c.agreement_no}
                        </span>
                    </td>
                    <td><small class="text-muted">${c.company_name}</small></td>
                    <td><span class="fw-semibold text-dark">${c.customer_name}</span></td>
                    <td><span class="badge bg-light text-dark border">${c.vehicle_no}</span></td>
                    <td><small class="text-muted">${c.agreement_date}</small></td>
                    <td><span class="badge bg-label-primary fs-tiny">${c.agreement_status}</span></td>
                    <td class="text-end pe-2 fw-bold text-dark">${c.rent_amount} <small class="text-muted">BHD</small></td>
                </tr>
            `);
        });
    }

    // 9. Contract View / Print Handler
    $(document).on('click', '.print_contract', function (e) {
        e.preventDefault();
        const agreement_no = $(this).data('contract');
        if (!agreement_no) return;

        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(agreement_no)))
            .then(res => res.text())
            .then(token => {
                if (!token) {
                    Swal.fire('Error', 'Unable to generate contract security token.', 'error');
                    return;
                }
                window.open('/PrintAgreement?token=' + encodeURIComponent(token), '_blank');
            })
            .catch(err => {
                console.error('Print agreement encryption error:', err);
            });
    });

    // 10. Calendar Modals Integration
    $(document).on('click', '#openCalendarBtn', function () {
        const modalEl = document.getElementById('calendarModal');
        if (!modalEl) return;
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
        setTimeout(loadVehicleCalendar, 300);
    });

    $(document).on('click', '#openReturnCalendarBtn', function () {
        const modalEl = document.getElementById('ReturncalendarModal');
        if (!modalEl) return;
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
        setTimeout(loadReturnVehicleCalendar, 300);
    });

    function loadVehicleCalendar() {
        const calendarEl = document.getElementById('vehicleCalendar');
        if (!calendarEl || !window.FullCalendar) return;

        if (vehicleCalendarInstance) {
            vehicleCalendarInstance.destroy();
        }

        vehicleCalendarInstance = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: "auto",
            expandRows: true,
            events: function (fetchInfo, successCallback) {
                $.ajax({
                    url: '/LoadVehicleByUserSellection',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ action: 'vehicle_calendar' }),
                    success: function (response) {
                        const events = [];
                        const data = (typeof response === 'string') ? JSON.parse(response) : response;
                        if (data && data.data) {
                            data.data.forEach(v => {
                                const baseTitle = `${v.vehicle_number} - ${v.model_names}`;
                                const ids = v.ids || '';

                                const parseHist = (j) => {
                                    try { return j ? JSON.parse(j) : []; } catch(e) { return []; }
                                };

                                parseHist(v.passing_histroy).forEach(h => {
                                    if (h.next_date) {
                                        events.push({ title: baseTitle, start: h.next_date, color: '#f59e0b', extendedProps: { type: 'Passing', ids } });
                                    }
                                });
                                parseHist(v.insurance_histroy).forEach(h => {
                                    if (h.next_date) {
                                        events.push({ title: baseTitle, start: h.next_date, color: '#3b82f6', extendedProps: { type: 'Insurance', ids } });
                                    }
                                });
                                parseHist(v.maintenance_histroy).forEach(h => {
                                    if (h.next_date) {
                                        events.push({ title: baseTitle, start: h.next_date, color: '#8b5cf6', extendedProps: { type: 'Maintenance', ids } });
                                    }
                                });
                            });
                        }
                        successCallback(events);
                    }
                });
            }
        });
        vehicleCalendarInstance.render();
    }

    function loadReturnVehicleCalendar() {
        const calendarEl = document.getElementById('ReturnvehicleCalendar');
        if (!calendarEl || !window.FullCalendar) return;

        if (vehicleReturnCalendarInstance) {
            vehicleReturnCalendarInstance.destroy();
        }

        vehicleReturnCalendarInstance = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: "auto",
            expandRows: true,
            events: function (fetchInfo, successCallback) {
                $.ajax({
                    url: '/LoadVehicleByUserSellection',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ action: 'return_vehicle_calendar' }),
                    success: function (response) {
                        const events = [];
                        const data = (typeof response === 'string') ? JSON.parse(response) : response;
                        if (data && data.data) {
                            data.data.forEach(v => {
                                if (!v.return_date) return;
                                events.push({
                                    title: `${v.vehicle_no} - ${v.model_name}`,
                                    start: v.return_date,
                                    extendedProps: {
                                        ids: v.ids,
                                        status: v.agreement_status || '',
                                        customer_name: v.customer_name || '',
                                        customer_mobile: v.customer_mobile || '',
                                        agreement_no: v.agreement_no || '',
                                        type: 'Return'
                                    }
                                });
                            });
                        }
                        successCallback(events);
                    }
                });
            }
        });
        vehicleReturnCalendarInstance.render();
    }

    // Start App
    initCompanyFilter();
});
