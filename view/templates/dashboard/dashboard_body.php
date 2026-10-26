<!-- ========================================== -->
<!-- EXECUTIVE FLEET OPERATIONS DASHBOARD BODY -->
<!-- ========================================== -->

<div class="container-fluid flex-grow-1 container-p-y px-3 px-md-4">

    <!-- ================= TOP HEADER & FILTER BAR ================= -->
    <div class="card dash-card mb-4 border-0 shadow-sm">
        <div class="card-body p-3 p-md-4">
            <div class="row g-3 align-items-center">
                
                <!-- Left: Title & Subtitle -->
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <div class="d-flex align-items-center gap-3">
                        <div class="dash-header-icon-box bg-label-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="ri ri-dashboard-3-line text-primary"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h4 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.3px;">Operations Dashboard</h4>
                                <span class="badge bg-label-primary fs-tiny px-2 py-1 rounded-pill" id="companyContextBadge">Loading...</span>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <i class="ri ri-time-line me-1"></i> <span id="dash_live_clock">--</span> | Live Fleet & Financial Performance
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Middle & Right: Company Filter, Timeframe, & Action Controls -->
                <div class="col-xl-8 col-lg-7 col-md-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-xl-end gap-2">
                        
                        <!-- Company Filter Dropdown (User Access Controlled) -->
                        <div style="min-width: 240px; max-width: 320px;">
                            <select class="form-select py-1 px-3 fw-medium text-dark" id="dash_company_select" style="font-size: 0.875rem;">
                                <option value="" disabled selected>Loading companies...</option>
                            </select>
                        </div>

                        <!-- Timeframe Quick Selector -->
                        <div class="btn-group btn-group-sm shadow-none" role="group" id="dash_timeframe_group">
                            <button type="button" class="btn btn-outline-secondary dash-timeframe-btn px-2" data-timeframe="today">Today</button>
                            <button type="button" class="btn btn-outline-secondary dash-timeframe-btn px-2" data-timeframe="this_week">Week</button>
                            <button type="button" class="btn btn-primary dash-timeframe-btn px-3 active fw-semibold" data-timeframe="this_month">This Month</button>
                            <button type="button" class="btn btn-outline-secondary dash-timeframe-btn px-2" data-timeframe="this_year">Year</button>
                            <button type="button" class="btn btn-outline-secondary dash-timeframe-btn px-2" data-timeframe="all_time">All</button>
                            <button type="button" class="btn btn-outline-secondary dash-timeframe-btn px-2" id="dash_btn_custom_toggle" title="Custom Date Range">
                                <i class="ri ri-calendar-2-line"></i>
                            </button>
                        </div>

                        <!-- Refresh Button -->
                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary" id="dash_btn_refresh" title="Refresh Dashboard Data">
                            <i class="ri ri-refresh-line fs-5" id="dash_refresh_icon"></i>
                        </button>

                    </div>
                </div>

            </div>

            <!-- Custom Date Range Bar (Collapsible) -->
            <div class="row mt-3 pt-3 border-top g-2 align-items-center d-none" id="dash_custom_range_bar">
                <div class="col-auto">
                    <small class="fw-bold text-muted"><i class="ri ri-calendar-event-line me-1"></i> Custom Date Range:</small>
                </div>
                <div class="col-sm-3 col-6">
                    <input type="date" class="form-control form-control-sm" id="dash_custom_from" value="<?= date('Y-m-01') ?>">
                </div>
                <div class="col-auto text-muted">to</div>
                <div class="col-sm-3 col-6">
                    <input type="date" class="form-control form-control-sm" id="dash_custom_to" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-primary px-3" id="dash_btn_apply_custom">Apply Range</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary px-2" id="dash_btn_cancel_custom">Cancel</button>
                </div>
            </div>

        </div>
    </div>


    <!-- ================= ROW 1: EXECUTIVE KPI SUMMARY CARDS (6 CARDS) ================= -->
    <div class="row g-3 mb-4">

        <!-- Card 1: Fleet Utilization Rate -->
        <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
            <div class="card dash-card h-100 dash-kpi-card border-0 shadow-sm dash-accent-emerald">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted fw-semibold fs-tiny text-uppercase tracking-wider">Fleet Utilization</span>
                        <div class="dash-kpi-icon-pill bg-label-success">
                            <i class="ri ri-pie-chart-2-line"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="mb-0 fw-bold text-dark" id="kpi_utilization_rate">0.0%</h3>
                        <span class="badge bg-label-success fs-tiny" id="kpi_utilization_badge">Optimal</span>
                    </div>
                    <div class="progress mt-2" style="height: 6px; border-radius: 4px; background: rgba(16, 185, 129, 0.15);">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" id="kpi_utilization_bar" style="width: 0%;"></div>
                    </div>
                    <small class="text-muted d-block mt-2" style="font-size: 11px;">
                        <span class="fw-bold text-dark" id="kpi_utilization_sub">0 on road / 0 active fleet</span>
                    </small>
                </div>
            </div>
        </div>

        <!-- Card 2: Active Contracts On Road -->
        <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
            <div class="card dash-card h-100 dash-kpi-card border-0 shadow-sm dash-accent-blue">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted fw-semibold fs-tiny text-uppercase tracking-wider">Active Contracts</span>
                        <div class="dash-kpi-icon-pill bg-label-primary">
                            <i class="ri ri-file-shield-2-line"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="mb-0 fw-bold text-primary" id="kpi_active_contracts">0</h3>
                        <span class="badge bg-label-primary fs-tiny">On Road</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-2 pt-1 border-top" style="font-size: 11px;">
                        <span class="text-muted">Initial Rentout: <b class="text-dark" id="kpi_active_rentout">0</b></span>
                        <span class="text-muted">Extended: <b class="text-purple" id="kpi_active_extended">0</b></span>
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size: 11px;">
                        <a href="/ContractList" class="text-primary text-decoration-none fw-semibold">View all contracts <i class="ri ri-arrow-right-s-line"></i></a>
                    </small>
                </div>
            </div>
        </div>

        <!-- Card 3: Overdue Returns (Pulsing Urgent Alert) -->
        <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
            <div class="card dash-card h-100 dash-kpi-card border-0 shadow-sm dash-accent-danger" id="card_overdue_container">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-danger fw-bold fs-tiny text-uppercase tracking-wider">Overdue Returns</span>
                        <div class="dash-kpi-icon-pill bg-label-danger pulse-alert">
                            <i class="ri ri-alarm-warning-fill text-danger"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="mb-0 fw-bold text-danger" id="kpi_overdue_count">0</h3>
                        <span class="badge bg-label-danger fs-tiny" id="kpi_overdue_badge">Urgent</span>
                    </div>
                    <div class="mt-2 pt-1 border-top text-truncate" style="font-size: 11px;">
                        <span class="text-muted">Requires follow-up / return action</span>
                    </div>
                    <small class="d-block mt-1" style="font-size: 11px;">
                        <a href="javascript:void(0);" class="text-danger text-decoration-none fw-semibold filter-table-action" data-filter="overdue">
                            Filter overdue list <i class="ri ri-arrow-right-s-line"></i>
                        </a>
                    </small>
                </div>
            </div>
        </div>

        <!-- Card 4: Returns Due Today -->
        <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
            <div class="card dash-card h-100 dash-kpi-card border-0 shadow-sm dash-accent-amber">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted fw-semibold fs-tiny text-uppercase tracking-wider">Due Today</span>
                        <div class="dash-kpi-icon-pill bg-label-warning">
                            <i class="ri ri-calendar-check-line text-warning"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mb-1">
                        <h3 class="mb-0 fw-bold text-warning" id="kpi_returns_today_count">0</h3>
                        <span class="badge bg-label-warning fs-tiny">Expected Today</span>
                    </div>
                    <div class="mt-2 pt-1 border-top text-truncate" style="font-size: 11px;">
                        <span class="text-muted">Scheduled check-ins today</span>
                    </div>
                    <small class="d-block mt-1" style="font-size: 11px;">
                        <a href="javascript:void(0);" class="text-warning text-decoration-none fw-semibold filter-table-action" data-filter="today">
                            View today's schedule <i class="ri ri-arrow-right-s-line"></i>
                        </a>
                    </small>
                </div>
            </div>
        </div>

        <!-- Card 5: Period Revenue / Billings -->
        <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
            <div class="card dash-card h-100 dash-kpi-card border-0 shadow-sm dash-accent-purple">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted fw-semibold fs-tiny text-uppercase tracking-wider">Period Billings</span>
                        <div class="dash-kpi-icon-pill bg-label-info">
                            <i class="ri ri-money-dollar-circle-line text-info"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1 mb-1">
                        <h4 class="mb-0 fw-bold text-dark" id="kpi_period_revenue">0.000</h4>
                        <small class="fw-bold text-muted">BHD</small>
                    </div>
                    <div class="mt-2 pt-1 border-top text-truncate" style="font-size: 11px;">
                        <span class="text-muted">Total rent billed in <span class="fw-semibold text-dark dash-timeframe-label">Month</span></span>
                    </div>
                    <small class="d-block mt-1" style="font-size: 11px;">
                        <a href="/DailyRentalReport" class="text-info text-decoration-none fw-semibold">
                            Rental Report <i class="ri ri-arrow-right-s-line"></i>
                        </a>
                    </small>
                </div>
            </div>
        </div>

        <!-- Card 6: Period Collections Received -->
        <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
            <div class="card dash-card h-100 dash-kpi-card border-0 shadow-sm dash-accent-teal">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted fw-semibold fs-tiny text-uppercase tracking-wider">Period Collections</span>
                        <div class="dash-kpi-icon-pill bg-label-success">
                            <i class="ri ri-wallet-3-line text-success"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-1 mb-1">
                        <h4 class="mb-0 fw-bold text-success" id="kpi_period_collections">0.000</h4>
                        <small class="fw-bold text-muted">BHD</small>
                    </div>
                    <div class="mt-2 pt-1 border-top text-truncate" style="font-size: 11px;">
                        <span class="text-muted">Actual cash/card/bank inflow</span>
                    </div>
                    <small class="d-block mt-1" style="font-size: 11px;">
                        <a href="/DailyCashReport" class="text-success text-decoration-none fw-semibold">
                            Cash Report <i class="ri ri-arrow-right-s-line"></i>
                        </a>
                    </small>
                </div>
            </div>
        </div>

    </div>


    <!-- ================= ROW 2: FLEET STATUS SPECTRUM & FINANCIAL BREAKDOWN ================= -->
    <div class="row g-3 mb-4">
        
        <!-- Left: Fleet Status Spectrum & Vehicle Categories -->
        <div class="col-xl-7 col-lg-12">
            <div class="card dash-card h-100 border-0 shadow-sm">
                <div class="card-header p-3 pb-2 border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="ri ri-car-line text-primary fs-5"></i>
                            <span>Fleet Capacity & Status Spectrum</span>
                        </h6>
                        <small class="text-muted">Total Registered Fleet: <b class="text-dark" id="fleet_total_count">0</b> vehicles</small>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-xs btn-outline-primary" id="openCalendarBtn" title="Open Vehicle Service & Insurance Calendar">
                            <i class="ri ri-calendar-event-line me-1"></i> Fleet Calendar
                        </button>
                    </div>
                </div>
                <div class="card-body p-3 pt-1">
                    
                    <!-- Segmented Fleet Progress Bar -->
                    <div class="fleet-progress-bar shadow-sm mb-3" id="fleet_segmented_bar">
                        <div class="fleet-progress-seg bg-success" style="width: 25%;" title="Available"></div>
                        <div class="fleet-progress-seg bg-primary" style="width: 50%;" title="On Rent"></div>
                        <div class="fleet-progress-seg bg-info" style="width: 10%;" title="Parking"></div>
                        <div class="fleet-progress-seg bg-warning" style="width: 10%;" title="Maintenance"></div>
                        <div class="fleet-progress-seg bg-danger" style="width: 5%;" title="Blocked"></div>
                    </div>

                    <!-- Fleet Status Pills (Exact Counts & Legend) -->
                    <div class="row g-2 mb-3 text-center">
                        <div class="col">
                            <div class="p-2 rounded-3 bg-label-success border border-success-subtle">
                                <small class="text-muted d-block" style="font-size: 11px;">Available Ready</small>
                                <h5 class="mb-0 fw-bold text-success" id="count_available">0</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-2 rounded-3 bg-label-primary border border-primary-subtle">
                                <small class="text-muted d-block" style="font-size: 11px;">On Rent</small>
                                <h5 class="mb-0 fw-bold text-primary" id="count_rentout">0</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-2 rounded-3 bg-label-info border border-info-subtle">
                                <small class="text-muted d-block" style="font-size: 11px;">In Parking</small>
                                <h5 class="mb-0 fw-bold text-info" id="count_parking">0</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-2 rounded-3 bg-label-warning border border-warning-subtle">
                                <small class="text-muted d-block" style="font-size: 11px;">Maintenance</small>
                                <h5 class="mb-0 fw-bold text-warning" id="count_maintenance">0</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-2 rounded-3 bg-label-danger border border-danger-subtle">
                                <small class="text-muted d-block" style="font-size: 11px;">Blocked</small>
                                <h5 class="mb-0 fw-bold text-danger" id="count_blocked">0</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Category Distribution Chips -->
                    <div class="pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="fw-bold text-muted text-uppercase" style="font-size: 11px;">Fleet Category Breakdown</small>
                            <small class="text-muted" style="font-size: 11px;">Rented vs Total</small>
                        </div>
                        <div class="d-flex flex-wrap gap-2" id="fleet_category_chips">
                            <!-- Populated dynamically via JS -->
                            <span class="badge bg-light text-dark border py-2 px-3">Loading categories...</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Right: Financial Inflow Breakdown & Net Receivables -->
        <div class="col-xl-5 col-lg-12">
            <div class="card dash-card h-100 border-0 shadow-sm">
                <div class="card-header p-3 pb-2 border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="ri ri-bank-card-line text-success fs-5"></i>
                            <span>Financial Collections & Receivables</span>
                        </h6>
                        <small class="text-muted">Inflow for <span class="dash-timeframe-label fw-semibold text-dark">This Month</span></small>
                    </div>
                    <a href="/CustomerBalances" class="btn btn-xs btn-outline-secondary" title="View Customer Balances Report">
                        <i class="ri ri-file-chart-line me-1"></i> Balances
                    </a>
                </div>
                <div class="card-body p-3 pt-1">
                    
                    <!-- Net Outstanding Banner -->
                    <div class="p-3 mb-3 rounded-3 bg-label-danger border border-danger-subtle d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-danger fw-semibold d-block text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">All-Time Customer Receivables</small>
                            <div class="d-flex align-items-baseline gap-1 mt-1">
                                <h4 class="mb-0 fw-bold text-danger" id="net_outstanding_amount">0.000</h4>
                                <span class="fw-bold text-danger">BHD</span>
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Total Net Outstanding Across Ledger</small>
                        </div>
                        <a href="/CustomerBalances" class="btn btn-sm btn-danger shadow-sm px-3">
                            Review <i class="ri ri-arrow-right-line ms-1"></i>
                        </a>
                    </div>

                    <!-- Payment Method Breakdown (Cash, Card, BenefitPay, Bank) -->
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 rounded-2 border bg-light d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-success text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                        <i class="ri ri-cash-line"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 11px;">Cash</small>
                                        <span class="fw-bold text-dark" id="pay_method_cash">0.000</span> <small class="text-muted" style="font-size: 10px;">BHD</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-2 border bg-light d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                        <i class="ri ri-bank-card-line"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 11px;">Card (POS)</small>
                                        <span class="fw-bold text-dark" id="pay_method_card">0.000</span> <small class="text-muted" style="font-size: 10px;">BHD</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-2 border bg-light d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-danger text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                        <i class="ri ri-smartphone-line"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 11px;">BenefitPay</small>
                                        <span class="fw-bold text-dark" id="pay_method_benefit">0.000</span> <small class="text-muted" style="font-size: 10px;">BHD</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-2 border bg-light d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-info text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                        <i class="ri ri-building-line"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 11px;">Bank / Cheque</small>
                                        <span class="fw-bold text-dark" id="pay_method_bank">0.000</span> <small class="text-muted" style="font-size: 10px;">BHD</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <!-- ================= ROW 3: OPERATIONAL ACTION CENTER & EXPECTED RETURNS TABLE ================= -->
    <div class="row g-3 mb-4">
        
        <!-- Left: Compliance & Operational Alerts Widget -->
        <div class="col-xxl-4 col-xl-5 col-lg-12">
            <div class="card dash-card h-100 border-0 shadow-sm">
                
                <div class="card-header p-3 pb-2 border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="ri ri-shield-flash-line text-danger fs-5"></i>
                            <span>Operational Alerts & Action Center</span>
                        </h6>
                        <small class="text-muted">Total Actionable Notices: <b class="text-danger" id="total_alerts_badge">0</b></small>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary" id="openReturnCalendarBtn" title="Expected Returns Calendar">
                            <i class="ri ri-calendar-line me-1"></i> Returns Cal
                        </button>
                    </div>
                </div>

                <div class="card-body p-3 pt-0">
                    
                    <!-- Alert Filter Tabs -->
                    <ul class="nav nav-pills nav-fill alert-filter-tabs gap-1 mb-3 bg-light p-1 rounded-2" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active py-1 px-2 fs-tiny fw-semibold" data-alert-tab="overdue">
                                Overdue (<span id="alert_tab_overdue_count">0</span>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link py-1 px-2 fs-tiny fw-semibold" data-alert-tab="due_today">
                                Today (<span id="alert_tab_today_count">0</span>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link py-1 px-2 fs-tiny fw-semibold" data-alert-tab="insurance">
                                Insurance (<span id="alert_tab_insurance_count">0</span>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link py-1 px-2 fs-tiny fw-semibold" data-alert-tab="passing">
                                Passing (<span id="alert_tab_passing_count">0</span>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link py-1 px-2 fs-tiny fw-semibold" data-alert-tab="maintenance">
                                Service (<span id="alert_tab_maint_count">0</span>)
                            </button>
                        </li>
                    </ul>

                    <!-- Alerts Scrollable Stream -->
                    <div id="alerts_stream_container" class="overflow-auto pe-1" style="max-height: 440px;">
                        <div class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                            <div>Loading operational alerts...</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Right: Expected Returns & Overdue Vehicles Live Monitor -->
        <div class="col-xxl-8 col-xl-7 col-lg-12">
            <div class="card dash-card h-100 border-0 shadow-sm">
                
                <div class="card-header p-3 pb-2 border-0 bg-transparent d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="ri ri-timer-line text-warning fs-5"></i>
                            <span>Expected Returns & Overdue Monitor</span>
                        </h6>
                        <small class="text-muted">Live tracking of contracts scheduled for check-in</small>
                    </div>

                    <!-- Table Quick Filters -->
                    <div class="d-flex align-items-center gap-1">
                        <div class="btn-group btn-group-sm" role="group" id="table_filter_group">
                            <button type="button" class="btn btn-primary active table-filter-btn px-2" data-filter="all">All (<span id="count_tbl_all">0</span>)</button>
                            <button type="button" class="btn btn-outline-danger table-filter-btn px-2" data-filter="overdue">Overdue (<span id="count_tbl_overdue">0</span>)</button>
                            <button type="button" class="btn btn-outline-warning table-filter-btn px-2" data-filter="today">Today (<span id="count_tbl_today">0</span>)</button>
                            <button type="button" class="btn btn-outline-secondary table-filter-btn px-2" data-filter="upcoming">Upcoming (<span id="count_tbl_upcoming">0</span>)</button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-3 pt-0">
                    
                    <div class="table-responsive">
                        <table id="dashReturnsTable" class="table table-hover table-sm align-middle w-100 mb-0" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-2" style="min-width: 110px;">Agreement</th>
                                    <th style="min-width: 140px;">Vehicle</th>
                                    <th style="min-width: 160px;">Customer Details</th>
                                    <th style="min-width: 100px;">Start Date</th>
                                    <th style="min-width: 110px;">Return Due</th>
                                    <th style="min-width: 110px;">Time Status</th>
                                    <th class="text-end" style="min-width: 80px;">Rent</th>
                                    <th class="text-center pe-2" style="width: 70px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="dashReturnsTableBody">
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <div class="spinner-border spinner-border-sm text-primary mb-1" role="status"></div>
                                        <div>Loading contract return schedules...</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <!-- ================= ROW 4: RECENT CONTRACTS STREAM ================= -->
    <div class="row g-3 mb-2">
        <div class="col-12">
            <div class="card dash-card border-0 shadow-sm">
                <div class="card-header p-3 pb-2 border-0 bg-transparent d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="ri ri-file-history-line text-primary fs-5"></i>
                            <span>Recent Contracts & Movements Stream</span>
                        </h6>
                        <small class="text-muted">Latest rental agreements executed across the operations</small>
                    </div>
                    <a href="/ContractList" class="btn btn-xs btn-outline-primary">
                        View All Contracts <i class="ri ri-arrow-right-s-line"></i>
                    </a>
                </div>
                <div class="card-body p-3 pt-1">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-2">Agreement No</th>
                                    <th>Company</th>
                                    <th>Customer</th>
                                    <th>Vehicle</th>
                                    <th>Contract Date</th>
                                    <th>Status</th>
                                    <th class="text-end pe-2">Agreed Rent</th>
                                </tr>
                            </thead>
                            <tbody id="recent_contracts_body">
                                <tr>
                                    <td colspan="7" class="text-center py-3 text-muted">Loading recent contracts...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>