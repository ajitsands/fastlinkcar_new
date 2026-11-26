<!-- Comprehensive 4-Tab Contract Audit Modal -->
<div class="modal fade" id="comprehensiveContractAuditModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:96%;">
    <div class="modal-content">
      <div class="modal-header text-white py-2" style="background: linear-gradient(135deg, #1b3d94, #2563eb);">
        <div>
          <h5 class="modal-title text-white mb-0">
            <i class="ri-file-shield-2-line me-1"></i> Comprehensive Contract Audit — <span id="cca_agreement_no">-</span>
          </h5>
          <small class="text-white-50">
            Status: <span id="cca_status_text" class="fw-bold text-white">-</span> ·
            Company: <span id="cca_company_name" class="fw-semibold text-white">-</span> ·
            Agreement Date: <span id="cca_agreement_date" class="fw-semibold text-white">-</span>
          </small>
        </div>
        <div class="d-flex align-items-center gap-2 ms-auto me-2">
          <button type="button" id="cca_btn_print_agreement" class="btn btn-sm btn-light text-primary fw-semibold">
            <i class="ri-file-text-line me-1"></i> Print Agreement
          </button>
          <button type="button" id="cca_btn_print_audit" class="btn btn-sm btn-warning text-dark fw-semibold">
            <i class="ri-printer-line me-1"></i> Print Audit Report
          </button>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-3 bg-light">
        <div id="cca_loading" class="text-center py-5">
          <div class="spinner-border text-primary" role="status"></div>
          <div class="small text-muted mt-2">Loading comprehensive contract audit...</div>
        </div>

        <div id="cca_content" class="d-none">
          <!-- Navigation Tabs -->
          <ul class="nav nav-tabs nav-fill bg-white rounded-top border px-2 pt-2 mb-0" id="ccaTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active fw-semibold" id="cca-tab-overview-btn" data-bs-toggle="tab" data-bs-target="#ccaTabOverview" type="button" role="tab">
                <i class="ri-car-line me-1"></i> Contract &amp; Current Vehicle
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-semibold" id="cca-tab-repl-btn" data-bs-toggle="tab" data-bs-target="#ccaTabReplacements" type="button" role="tab">
                <i class="ri-repeat-line me-1"></i> Replacements <span id="cca_repl_badge" class="badge bg-secondary ms-1">0</span>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-semibold" id="cca-tab-ledger-btn" data-bs-toggle="tab" data-bs-target="#ccaTabLedger" type="button" role="tab">
                <i class="ri-book-open-line me-1"></i> Complete Ledger, Receipts &amp; SOA
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-semibold" id="cca-tab-activities-btn" data-bs-toggle="tab" data-bs-target="#ccaTabActivities" type="button" role="tab">
                <i class="ri-history-line me-1"></i> Invoices, Activities &amp; Logs
              </button>
            </li>
          </ul>

          <div class="tab-content bg-white border border-top-0 rounded-bottom p-3 shadow-sm">
            <!-- TAB 1: CONTRACT & CURRENT VEHICLE -->
            <div class="tab-pane fade show active" id="ccaTabOverview" role="tabpanel">
              <div class="row g-3 mb-3">
                <div class="col-12 col-lg-6">
                  <div class="p-3 rounded border h-100" style="background:#f8fafc;">
                    <h6 class="fw-bold text-primary border-bottom pb-2 mb-2"><i class="ri-user-line me-1"></i> Customer &amp; Driver Details</h6>
                    <div class="row g-1 small" id="cca_customer_grid"></div>
                  </div>
                </div>
                <div class="col-12 col-lg-6">
                  <div class="p-3 rounded border h-100" style="background:#f8fafc;">
                    <h6 class="fw-bold text-primary border-bottom pb-2 mb-2"><i class="ri-car-line me-1"></i> Current Vehicle &amp; Contract Period</h6>
                    <div class="row g-1 small" id="cca_vehicle_grid"></div>
                  </div>
                </div>
              </div>

              <!-- Checklist & Car Survey -->
              <div class="p-3 rounded border mb-3 bg-white">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="ri-checkbox-multiple-line text-primary me-1"></i> Vehicle Checklist &amp; Car Survey</h6>
                <div id="cca_checklist_badges" class="d-flex flex-wrap gap-2 mb-3"></div>
                <div class="row g-3 text-center">
                  <div class="col-md-6">
                    <div class="small fw-semibold text-muted mb-1">Car Survey (OUT)</div>
                    <canvas id="cca_survey_out_canvas" width="360" height="220" class="border rounded bg-light" style="max-width:100%;"></canvas>
                  </div>
                  <div class="col-md-6" id="cca_survey_in_col">
                    <div class="small fw-semibold text-muted mb-1">Car Survey (IN - Return)</div>
                    <canvas id="cca_survey_in_canvas" width="360" height="220" class="border rounded bg-light" style="max-width:100%;"></canvas>
                  </div>
                </div>
              </div>

              <!-- Images & Signatures -->
              <div class="row g-3">
                <div class="col-12 col-lg-6">
                  <div class="p-3 rounded border h-100 bg-white">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="ri-image-line text-primary me-1"></i> Vehicle Rentout &amp; Return Images</h6>
                    <div class="small fw-semibold text-muted mb-1">Rentout Images</div>
                    <div id="cca_rentout_images" class="d-flex flex-wrap gap-2 mb-3"></div>
                    <div class="small fw-semibold text-muted mb-1">Return Images</div>
                    <div id="cca_return_images" class="d-flex flex-wrap gap-2"></div>
                  </div>
                </div>
                <div class="col-12 col-lg-6">
                  <div class="p-3 rounded border h-100 bg-white">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="ri-quill-pen-line text-primary me-1"></i> Contract Signatures</h6>
                    <div class="row g-2 text-center" id="cca_signatures_grid"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- TAB 2: VEHICLE REPLACEMENTS -->
            <div class="tab-pane fade" id="ccaTabReplacements" role="tabpanel">
              <div id="cca_replacements_container"></div>
            </div>

            <!-- TAB 3: COMPLETE LEDGER, RECEIPT PRINT & SOA -->
            <div class="tab-pane fade" id="ccaTabLedger" role="tabpanel">
              <div class="row g-2 mb-3 align-items-center">
                <div class="col-6 col-md-3">
                  <div class="p-2 rounded border bg-light text-center">
                    <div class="small text-muted">Total Debit (Billed)</div>
                    <div class="fw-bold text-danger fs-6" id="cca_ledger_debit">0.000 BHD</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-2 rounded border bg-light text-center">
                    <div class="small text-muted">Total Credit (Paid)</div>
                    <div class="fw-bold text-success fs-6" id="cca_ledger_credit">0.000 BHD</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-2 rounded border bg-light text-center">
                    <div class="small text-muted">Net Balance</div>
                    <div class="fw-bold text-primary fs-6" id="cca_ledger_balance">0.000 BHD</div>
                  </div>
                </div>
                <div class="col-6 col-md-3 text-end">
                  <button type="button" id="cca_btn_print_soa" class="btn btn-primary w-100">
                    <i class="ri-file-list-3-line me-1"></i> Print Contract SOA
                  </button>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Ref No.</th>
                      <th>Description</th>
                      <th>Method</th>
                      <th class="text-end">Debit</th>
                      <th class="text-end">Credit</th>
                      <th class="text-end">Balance</th>
                      <th class="text-center">Receipt</th>
                    </tr>
                  </thead>
                  <tbody id="cca_ledger_tbody"></tbody>
                </table>
              </div>
            </div>

            <!-- TAB 4: INVOICES, ACTIVITIES & LOGS -->
            <div class="tab-pane fade" id="ccaTabActivities" role="tabpanel">
              <div class="row g-3">
                <div class="col-12">
                  <h6 class="fw-bold text-primary border-bottom pb-1 mb-2"><i class="ri-bill-line me-1"></i> Invoices</h6>
                  <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered align-middle mb-0">
                      <thead class="table-light">
                        <tr>
                          <th>Invoice No</th>
                          <th>Invoice Date</th>
                          <th>Due Date</th>
                          <th class="text-end">VAT</th>
                          <th class="text-end">Grand Total</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="cca_invoices_tbody"></tbody>
                    </table>
                  </div>
                </div>

                <div class="col-12 col-lg-6">
                  <h6 class="fw-bold text-primary border-bottom pb-1 mb-2"><i class="ri-calendar-event-line me-1"></i> Contract Extensions</h6>
                  <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered align-middle mb-0">
                      <thead class="table-light">
                        <tr>
                          <th>Extended Period</th>
                          <th>Duration</th>
                          <th class="text-end">Amount</th>
                        </tr>
                      </thead>
                      <tbody id="cca_extensions_tbody"></tbody>
                    </table>
                  </div>
                </div>

                <div class="col-12 col-lg-6">
                  <h6 class="fw-bold text-danger border-bottom pb-1 mb-2"><i class="ri-alarm-warning-line me-1"></i> Traffic Violations</h6>
                  <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered align-middle mb-0">
                      <thead class="table-light">
                        <tr>
                          <th>Date</th>
                          <th>Violation</th>
                          <th class="text-end">Fee</th>
                          <th>Remarks</th>
                        </tr>
                      </thead>
                      <tbody id="cca_violations_tbody"></tbody>
                    </table>
                  </div>
                </div>

                <div class="col-12">
                  <h6 class="fw-bold text-dark border-bottom pb-1 mb-2"><i class="ri-route-line me-1"></i> Vehicle Movements &amp; Activity Logs</h6>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle mb-0">
                      <thead class="table-light">
                        <tr>
                          <th>Date &amp; Time</th>
                          <th>Activity / Action</th>
                          <th>Vehicle</th>
                          <th>Transition / Location</th>
                          <th>Odometer / Fuel</th>
                          <th>Details / Remarks</th>
                        </tr>
                      </thead>
                      <tbody id="cca_logs_tbody"></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer py-2 bg-light">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
    let ccaCurrentData = null;

    function ccaEsc(str) {
        if (str === null || str === undefined) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function ccaFmtDate24(val, dateOnly) {
        if (!val || val === '0000-00-00' || val === '0000-00-00 00:00:00') return '-';
        const s = String(val).trim();
        const isDOnly = dateOnly || /^\d{4}-\d{2}-\d{2}$/.test(s);
        const dt = new Date(s.replace(' ', 'T'));
        if (isNaN(dt.getTime())) return s;
        return isDOnly
            ? dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })
            : dt.toLocaleString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false });
    }

    function ccaParseJson(val, fallback) {
        if (!val) return fallback;
        if (typeof val === 'object') return val;
        try { return JSON.parse(val) || fallback; } catch (e) { return fallback; }
    }

    function ccaRenderChecklistBadges(acc) {
        acc = ccaParseJson(acc, {});
        const items = [
            ['chk_tools', 'Tools Kit'],
            ['chk_spare', 'S. Wheel'],
            ['chk_wcup', 'W. Cup'],
            ['chk_radio', 'Radio'],
            ['chk_scratches', 'Scratches Mark X'],
            ['chk_seats', 'Seats Cleanness']
        ];
        return items.map(([k, label]) => {
            const ok = acc[k] === 'Yes' || acc[k] === true || acc[k] === 1 || acc[k] === '1';
            return `<span class="badge ${ok ? 'bg-label-success' : 'bg-label-secondary'} border">${ok ? '✓' : '✕'} ${label}</span>`;
        }).join('');
    }

    function ccaRenderImages(imgs, folder) {
        const arr = ccaParseJson(imgs, []);
        if (!Array.isArray(arr) || !arr.length) {
            return '<small class="text-muted fst-italic">No images recorded</small>';
        }
        return arr.map(img => `
            <a href="../uploads/${folder}/${ccaEsc(img)}" target="_blank" title="Open Full Image">
                <img src="../uploads/${folder}/${ccaEsc(img)}" onerror="this.style.display='none';" class="rounded border" style="width:72px;height:72px;object-fit:cover;">
            </a>
        `).join('');
    }

    function ccaOpenEncrypted(path, docNo) {
        if (!docNo) return;
        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(docNo))
            .then(r => r.text())
            .then(token => {
                if (token && token.trim()) window.open(path + '?token=' + encodeURIComponent(token.trim()), '_blank');
            });
    }

    window.openComprehensiveContractAuditModal = function(contractId) {
        if (!contractId) return;
        ccaCurrentData = null;
        $('#cca_loading').removeClass('d-none');
        $('#cca_content').addClass('d-none');
        $('#cca-tab-overview-btn').tab('show');
        new bootstrap.Modal(document.getElementById('comprehensiveContractAuditModal')).show();

        $.ajax({
            url: '/ContractHistoryController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'getContractFullDetails', agreement_id: contractId }),
            dataType: 'json',
            success: function(res) {
                if (!res || !res.status || !res.contract) {
                    $('#cca_loading').html('<div class="alert alert-danger mb-0">' + ccaEsc((res && res.message) ? res.message : 'Failed to load contract details.') + '</div>');
                    return;
                }
                ccaCurrentData = res;
                const c = res.contract || {};
                const cust = res.customer || {};
                const veh = res.current_vehicle || {};
                const cdj = ccaParseJson(c.contract_details_json, {});
                const vdj = ccaParseJson(c.vechile_details, {});
                const acc = ccaParseJson(c.vehicle_accessories_details, {});
                const drv = ccaParseJson(c.driver_details, {});

                $('#cca_agreement_no').text(c.agreement_no || '-');
                $('#cca_status_text').text(c.agreement_status || '-');
                $('#cca_company_name').text(c.company_name || '-');
                $('#cca_agreement_date').text(ccaFmtDate24(c.agreement_date, false));

                // Tab 1: Customer & Driver
                const custRows = [
                    ['Customer Name', cust.customer_name || c.customer_name || '-'],
                    ['Customer Code', c.customer_code || '-'],
                    ['CPR / CR No', cust.cpr_no || '-'],
                    ['Mobile', cust.mobile_number || '-'],
                    ['Email', cust.customer_email || '-'],
                    ['Address', cust.customer_address || '-'],
                    ['Customer Driver', c.customer_driver_name ? (c.customer_driver_name + ' (' + (c.customer_driver_contact_number || '') + ')') : '-'],
                    ['Company Driver', drv.driver_name || '-']
                ];
                $('#cca_customer_grid').html(custRows.map(([k, v]) => `<div class="col-5 text-muted">${k}:</div><div class="col-7 fw-semibold text-break">${ccaEsc(v)}</div>`).join(''));

                // Tab 1: Current Vehicle & Contract Period
                const rateType = cdj.rate_type || c.service_type || 'Daily';
                const unitPrice = cdj.unit_price || cdj.rate || cdj.daily_rate || '0.000';
                const vehRows = [
                    ['Vehicle Reg No', veh.vehicle_number || c.vehicle_no || '-'],
                    ['Category / Model', [veh.category_name || c.category_name || vdj.category_name, veh.model_name || c.model_name || vdj.model_name].filter(Boolean).join(' / ') || '-'],
                    ['Year / Color', [veh.vehicle_year || vdj.vehicle_year, veh.vehicle_color || vdj.vehicle_color].filter(Boolean).join(' / ') || '-'],
                    ['Rate & Unit Price', `${rateType} · ${parseFloat(unitPrice || 0).toFixed(3)} BHD`],
                    ['Start Date', ccaFmtDate24(c.service_start_date_time, false)],
                    ['Expected Return', ccaFmtDate24(c.service_end_date_time, false)],
                    ['KM Out / KM In', `${c.km_out || 0} / ${c.km_in || '-'}`],
                    ['Fuel Out / Ins / Pass', `${cdj.fuel_out || cdj.fuel_level || '-'} | Ins: ${ccaFmtDate24(veh.next_insurance_date, true)} | Pass: ${ccaFmtDate24(veh.next_passing_date, true)}`]
                ];
                $('#cca_vehicle_grid').html(vehRows.map(([k, v]) => `<div class="col-5 text-muted">${k}:</div><div class="col-7 fw-semibold">${ccaEsc(v)}</div>`).join(''));

                // Checklist & Surveys
                $('#cca_checklist_badges').html(ccaRenderChecklistBadges(acc));
                setTimeout(function() {
                    if (window.CarSurveyWidget) {
                        CarSurveyWidget.init('cca_survey_out_canvas', acc.car_survey_out || [], { readOnly: true });
                        if (Array.isArray(acc.car_survey_in) && acc.car_survey_in.length) {
                            $('#cca_survey_in_col').removeClass('d-none');
                            CarSurveyWidget.init('cca_survey_in_canvas', acc.car_survey_in, { readOnly: true });
                        } else {
                            $('#cca_survey_in_col').addClass('d-none');
                        }
                    }
                }, 100);

                // Images
                $('#cca_rentout_images').html(ccaRenderImages(c.vehicle_rentout_images, 'rentvehicleImages'));
                $('#cca_return_images').html(ccaRenderImages(c.vehicle_return_images, 'returnvehicleImages'));

                // Signatures
                const sigs = [
                    ['Hirer Signature', c.hirer_signature, c.hirer_name, c.hirer_signature_date],
                    ['Delivered By', c.delivered_signature, c.delivered_signatory || c.delivered_by, c.delivered_signature_date],
                    ['Receiver (Return)', c.receiver_signature, c.receiver_name, c.receiver_signature_datetime]
                ];
                $('#cca_signatures_grid').html(sigs.map(([title, img, name, dt]) => `
                    <div class="col-4">
                        <div class="border rounded p-2 h-100 bg-light">
                            <div class="small fw-bold text-dark mb-1">${title}</div>
                            ${img ? `<img src="${ccaEsc(img)}" style="max-height:60px;max-width:100%;object-fit:contain;background:#fff;border:1px solid #eee;border-radius:4px;">` : '<div class="text-muted small py-2">Not Signed</div>'}
                            <div class="small fw-semibold mt-1">${ccaEsc(name || '-')}</div>
                            <div class="text-muted" style="font-size:10px;">${ccaFmtDate24(dt, false)}</div>
                        </div>
                    </div>
                `).join(''));

                // Tab 2: Replacements
                const repls = Array.isArray(res.replaced_history) ? res.replaced_history : [];
                $('#cca_repl_badge').text(repls.length);
                if (!repls.length) {
                    $('#cca_replacements_container').html('<div class="text-center text-muted py-4">No vehicle replacements occurred on this contract.</div>');
                } else {
                    const replHtml = repls.map((r, idx) => {
                        const ov = r.old_vehicle || {};
                        const nv = r.new_vehicle || {};
                        const oAcc = ov.accessories || {};
                        const nAcc = nv.accessories || {};
                        return `
                        <div class="card border mb-3">
                          <div class="card-header bg-warning-subtle py-2 d-flex flex-wrap justify-content-between align-items-center">
                            <span class="fw-bold text-dark"><i class="ri-repeat-line me-1"></i> Replacement #${idx + 1} (${ccaEsc(r.replacement_id || '')})</span>
                            <span class="small fw-semibold">${ccaFmtDate24(r.replaced_on, false)} · By: ${ccaEsc(r.staff_name || 'Staff')}</span>
                          </div>
                          <div class="card-body p-3">
                            <div class="small text-muted mb-2">
                              <strong>Parking In:</strong> ${ccaEsc(r.parking_location_in || 'Main Parking')} |
                              <strong>Check-In Type:</strong> ${ccaEsc(r.check_in_type || 'Replacement')} |
                              <strong>Out Location:</strong> ${ccaEsc(r.out_location || 'Main Parking')} |
                              <strong>Reason:</strong> ${ccaEsc(r.remarks || '-')}
                            </div>
                            <div class="row g-3">
                              <div class="col-md-6">
                                <div class="p-2 rounded border border-danger-subtle bg-light h-100">
                                  <div class="fw-bold text-danger mb-1">Old Vehicle Returned: ${ccaEsc(ov.vehicle_number || '-')} (${ccaEsc(ov.category_name || '')} ${ccaEsc(ov.model_name || '')})</div>
                                  <div class="small mb-2">KM Out: <strong>${ov.km_out || 0}</strong> → KM In: <strong>${ov.km_in || 0}</strong> (Used: <strong>${ov.km_used || 0}</strong>) | Fuel In: <strong>${ccaEsc(ov.fuel_level_in || '-')}</strong></div>
                                  <div class="d-flex flex-wrap gap-1 mb-2">${ccaRenderChecklistBadges(oAcc)}</div>
                                  <div class="small fw-semibold text-muted mb-1">Return Images</div>
                                  <div class="d-flex flex-wrap gap-1 mb-2">${ccaRenderImages(ov.old_return_images, 'returnvehicleImages')}</div>
                                  <canvas id="cca_repl_old_survey_${idx}" width="320" height="190" class="border rounded bg-white" style="max-width:100%;"></canvas>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="p-2 rounded border border-success-subtle bg-light h-100">
                                  <div class="fw-bold text-success mb-1">New Vehicle Issued: ${ccaEsc(nv.vehicle_number || '-')} (${ccaEsc(nv.category_name || '')} ${ccaEsc(nv.model_name || '')})</div>
                                  <div class="small mb-2">KM Out: <strong>${nv.km_out || 0}</strong> | Fuel Out: <strong>${ccaEsc(nv.fuel_level_out || '-')}</strong></div>
                                  <div class="d-flex flex-wrap gap-1 mb-2">${ccaRenderChecklistBadges(nAcc)}</div>
                                  <div class="small fw-semibold text-muted mb-1">Release Images</div>
                                  <div class="d-flex flex-wrap gap-1 mb-2">${ccaRenderImages(nv.new_rentout_images, 'rentvehicleImages')}</div>
                                  <canvas id="cca_repl_new_survey_${idx}" width="320" height="190" class="border rounded bg-white" style="max-width:100%;"></canvas>
                                </div>
                              </div>
                            </div>
                            ${r.staff_signature ? `<div class="mt-2 pt-2 border-top d-flex align-items-center gap-3"><span class="small fw-semibold">Concerned Staff Signature (${ccaEsc(r.staff_name || '')}):</span><img src="${ccaEsc(r.staff_signature)}" style="height:45px;border:1px solid #ddd;border-radius:4px;background:#fff;"></div>` : ''}
                          </div>
                        </div>`;
                    }).join('');
                    $('#cca_replacements_container').html(replHtml);
                    setTimeout(function() {
                        if (window.CarSurveyWidget) {
                            repls.forEach((r, idx) => {
                                const oMarks = (r.old_vehicle && r.old_vehicle.accessories && r.old_vehicle.accessories.car_survey_in) ? r.old_vehicle.accessories.car_survey_in : [];
                                const nMarks = (r.new_vehicle && r.new_vehicle.accessories && r.new_vehicle.accessories.car_survey_out) ? r.new_vehicle.accessories.car_survey_out : [];
                                CarSurveyWidget.init('cca_repl_old_survey_' + idx, oMarks, { readOnly: true });
                                CarSurveyWidget.init('cca_repl_new_survey_' + idx, nMarks, { readOnly: true });
                            });
                        }
                    }, 150);
                }

                // Tab 3: Complete Ledger, Receipts & SOA
                const led = res.ledger || {};
                const entries = Array.isArray(led.entries) ? led.entries : [];
                $('#cca_ledger_debit').text(parseFloat(led.total_debit || 0).toFixed(3) + ' BHD');
                $('#cca_ledger_credit').text(parseFloat(led.total_credit || 0).toFixed(3) + ' BHD');
                $('#cca_ledger_balance').text(parseFloat(led.balance || 0).toFixed(3) + ' BHD');

                if (!entries.length) {
                    $('#cca_ledger_tbody').html('<tr><td colspan="9" class="text-center text-muted">No ledger entries found.</td></tr>');
                } else {
                    let runBal = 0;
                    const ledHtml = entries.map(e => {
                        const deb = parseFloat(e.debit || 0);
                        const crd = parseFloat(e.credit || 0);
                        runBal += (deb - crd);
                        const recNo = (crd > 0 && e.ref_no) ? e.ref_no : '';
                        return `<tr>
                            <td class="text-nowrap">${ccaFmtDate24(e.trans_date, true)}</td>
                            <td>${ccaEsc(e.trans_type || '-')}</td>
                            <td>${ccaEsc(e.ref_no || '-')}</td>
                            <td>${ccaEsc(e.description || '-')}</td>
                            <td>${ccaEsc(e.payment_method || '-')}</td>
                            <td class="text-end text-danger">${deb > 0 ? deb.toFixed(3) : '-'}</td>
                            <td class="text-end text-success">${crd > 0 ? crd.toFixed(3) : '-'}</td>
                            <td class="text-end fw-bold">${runBal.toFixed(3)}</td>
                            <td class="text-center">
                                ${recNo ? `<button type="button" class="btn btn-xs btn-outline-success cca-print-receipt" data-receipt="${ccaEsc(recNo)}"><i class="ri-receipt-line me-1"></i>Print</button>` : '-'}
                            </td>
                        </tr>`;
                    }).join('');
                    $('#cca_ledger_tbody').html(ledHtml);
                }

                // Tab 4: Invoices, Extensions, Violations & Logs
                const invs = Array.isArray(res.invoices) ? res.invoices : [];
                $('#cca_invoices_tbody').html(invs.length ? invs.map(i => `<tr>
                    <td class="fw-semibold">${ccaEsc(i.invoice_no || '-')}</td>
                    <td>${ccaFmtDate24(i.invoice_date, true)}</td>
                    <td>${ccaFmtDate24(i.invoice_due_date, true)}</td>
                    <td class="text-end">${parseFloat(i.vat_total || 0).toFixed(3)}</td>
                    <td class="text-end fw-bold">${parseFloat(i.grand_total || 0).toFixed(3)}</td>
                    <td><span class="badge ${String(i.draft) === '1' ? 'bg-label-warning' : 'bg-label-success'}">${String(i.draft) === '1' ? 'Draft' : 'Final'}</span></td>
                </tr>`).join('') : '<tr><td colspan="6" class="text-center text-muted">No invoices found.</td></tr>');

                const exts = Array.isArray(res.extensions) ? res.extensions : [];
                $('#cca_extensions_tbody').html(exts.length ? exts.map(x => `<tr>
                    <td>${ccaFmtDate24(x.extended_from_date || x.from_date, false)} → ${ccaFmtDate24(x.extended_to_date || x.to_date, false)}</td>
                    <td>${ccaEsc((x.duration || '') + ' ' + (x.rate_type || ''))}</td>
                    <td class="text-end fw-bold">${parseFloat(x.total_amount || 0).toFixed(3)}</td>
                </tr>`).join('') : '<tr><td colspan="3" class="text-center text-muted">No extensions.</td></tr>');

                const viols = Array.isArray(res.violations) ? res.violations : [];
                $('#cca_violations_tbody').html(viols.length ? viols.map(v => `<tr>
                    <td>${ccaFmtDate24(v.violation_date, true)}</td>
                    <td>${ccaEsc(v.title || '-')}</td>
                    <td class="text-end fw-bold">${parseFloat(v.fee || 0).toFixed(3)}</td>
                    <td>${ccaEsc(v.remarks || '-')}</td>
                </tr>`).join('') : '<tr><td colspan="4" class="text-center text-muted">No traffic violations.</td></tr>');

                const movs = Array.isArray(res.movements) ? res.movements : [];
                const extraLogs = [];
                ['log_json', 'rentout_log_json', 'return_log_json', 'close_log_json'].forEach(col => {
                    const parsed = ccaParseJson(c[col], null);
                    if (Array.isArray(parsed)) {
                        parsed.forEach(item => extraLogs.push(item));
                    } else if (parsed && typeof parsed === 'object') {
                        extraLogs.push(Object.assign({ log_source: col }, parsed));
                    }
                });

                let logRowsHtml = movs.map(m => `<tr>
                    <td class="text-nowrap">${ccaFmtDate24(m.created_at || m.movement_date, false)}</td>
                    <td><span class="badge bg-label-primary">${ccaEsc(m.action_type || '-')}</span></td>
                    <td>${ccaEsc(m.vehicle_number || '-')}</td>
                    <td>${ccaEsc((m.old_status || '-') + ' → ' + (m.new_status || '-'))} (${ccaEsc(m.location_from || '-')} → ${ccaEsc(m.location_to || '-')})</td>
                    <td>KM: ${ccaEsc(m.odometer || '-')} | Fuel: ${ccaEsc(m.fuel_level || '-')}</td>
                    <td>${ccaEsc(m.remarks || '-')}</td>
                </tr>`).join('');

                extraLogs.forEach(lg => {
                    logRowsHtml += `<tr>
                        <td class="text-nowrap">${ccaFmtDate24(lg.datetime || lg.date || lg.created_at, false)}</td>
                        <td><span class="badge bg-label-secondary">${ccaEsc(lg.action || lg.log_source || 'Contract Log')}</span></td>
                        <td>-</td>
                        <td>${ccaEsc(lg.user_name || lg.user || '-')}</td>
                        <td>-</td>
                        <td>${ccaEsc(lg.remarks || lg.note || JSON.stringify(lg))}</td>
                    </tr>`;
                });

                $('#cca_logs_tbody').html(logRowsHtml || '<tr><td colspan="6" class="text-center text-muted">No activity logs found.</td></tr>');

                $('#cca_loading').addClass('d-none');
                $('#cca_content').removeClass('d-none');
            },
            error: function() {
                $('#cca_loading').html('<div class="alert alert-danger mb-0">Error loading contract details.</div>');
            }
        });
    };

    $(document).on('click', '.cca-print-receipt', function() {
        ccaOpenEncrypted('/CashMemoPrint', $(this).data('receipt'));
    });

    $('#cca_btn_print_agreement').on('click', function() {
        if (ccaCurrentData && ccaCurrentData.contract && ccaCurrentData.contract.agreement_no) {
            ccaOpenEncrypted('/PrintAgreement', ccaCurrentData.contract.agreement_no);
        }
    });

    $('#cca_btn_print_audit').on('click', function() {
        if (ccaCurrentData && ccaCurrentData.contract && ccaCurrentData.contract.ids) {
            window.open('/ContractHistoryExport?agreement_id=' + encodeURIComponent(ccaCurrentData.contract.ids), '_blank');
        }
    });

    $('#cca_btn_print_soa').on('click', function() {
        if (!ccaCurrentData || !ccaCurrentData.contract) return;
        const c = ccaCurrentData.contract;
        const cust = ccaCurrentData.customer || {};
        const led = ccaCurrentData.ledger || {};
        const entries = Array.isArray(led.entries) ? led.entries : [];
        let runBal = 0;
        const rows = entries.map(e => {
            const d = parseFloat(e.debit || 0);
            const cr = parseFloat(e.credit || 0);
            runBal += (d - cr);
            return `<tr>
                <td>${ccaFmtDate24(e.trans_date, true)}</td>
                <td>${ccaEsc(e.trans_type || '-')}</td>
                <td>${ccaEsc(e.ref_no || '-')}</td>
                <td>${ccaEsc(e.description || '-')}</td>
                <td style="text-align:right;">${d > 0 ? d.toFixed(3) : '-'}</td>
                <td style="text-align:right;">${cr > 0 ? cr.toFixed(3) : '-'}</td>
                <td style="text-align:right;font-weight:bold;">${runBal.toFixed(3)}</td>
            </tr>`;
        }).join('');
        const w = window.open('', '_blank');
        w.document.write(`<!doctype html><html><head><title>SOA - ${ccaEsc(c.agreement_no)}</title>
            <style>body{font-family:Arial,sans-serif;padding:20px;font-size:12px;} table{width:100%;border-collapse:collapse;margin-top:12px;} th,td{border:1px solid #cbd5e1;padding:6px;} th{background:#f1f5f9;text-align:left;} .hdr{display:flex;justify-content:space-between;border-bottom:2px solid #1b3d94;padding-bottom:8px;}</style>
            </head><body>
            <div class="hdr"><div><h3 style="margin:0;color:#1b3d94;">STATEMENT OF ACCOUNT (SOA)</h3><div>Agreement: <strong>${ccaEsc(c.agreement_no)}</strong> | Company: ${ccaEsc(c.company_name || '')}</div></div>
            <div style="text-align:right;"><div>Customer: <strong>${ccaEsc(cust.customer_name || c.customer_name || '')}</strong></div><div>Printed: ${ccaFmtDate24(new Date().toISOString(), false)}</div></div></div>
            <table><thead><tr><th>Date</th><th>Type</th><th>Ref No</th><th>Description</th><th style="text-align:right;">Debit</th><th style="text-align:right;">Credit</th><th style="text-align:right;">Balance</th></tr></thead>
            <tbody>${rows || '<tr><td colspan="7" style="text-align:center;">No entries</td></tr>'}</tbody>
            <tfoot><tr><th colspan="4" style="text-align:right;">Totals (BHD)</th><th style="text-align:right;">${parseFloat(led.total_debit || 0).toFixed(3)}</th><th style="text-align:right;">${parseFloat(led.total_credit || 0).toFixed(3)}</th><th style="text-align:right;">${parseFloat(led.balance || 0).toFixed(3)}</th></tr></tfoot></table>
            <script>window.onload=function(){window.print();};<\/script></body></html>`);
        w.document.close();
    });
})();
</script>
