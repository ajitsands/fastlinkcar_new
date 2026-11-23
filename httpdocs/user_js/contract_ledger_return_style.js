(function() {
    let ledgerTable = null;
    let clOtherFeeHeadsMap = {};

    function escHtml(str) {
        return String(str || '').replace(/[&<>"']/g, s => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        }[s]));
    }

    function fmtLedgerDate(val) {
        if (!val) return '-';
        const s = String(val).substring(0, 10);
        const p = s.split('-');
        if (p.length === 3 && p[0].length === 4) {
            return `${p[2]}-${p[1]}-${p[0]}`;
        }
        return s;
    }

    function notifyLedger(msg, type = 'success') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type === 'error' ? 'error' : 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2600
            });
        } else {
            alert(msg);
        }
    }

    function updatePendingTotals() {
        let vTot = 0;
        $('#cl_violations_tbody .cl-v-fee').each(function() {
            vTot += parseFloat($(this).val() || '0') || 0;
        });
        let fTot = 0;
        $('#cl_other_fee_tbody tr').each(function() {
            const actual = parseFloat($(this).find('.cl-f-actual').val() || '0') || 0;
            const price = parseFloat($(this).find('.cl-f-price').val() || '0') || 0;
            fTot += (actual > 0 ? actual : price);
        });
        $('#clPendingViolationsTotal').text(vTot.toFixed(3));
        $('#clPendingFeesTotal').text(fTot.toFixed(3));
        $('#clPendingGrandTotal').text((vTot + fTot).toFixed(3));
    }

    function clLoadViolationHeads() {
        $.ajax({
            url: '/ActiveContractsDashboardController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_violation_heads' }),
            success: function(res) {
                const rows = (res && res.status === 'success' && Array.isArray(res.data)) ? res.data : [];
                let opts = '';
                rows.forEach(function(item) {
                    opts += `<option value="${escHtml(item.head_name)}">`;
                });
                $('#cl_violation_heads_list').html(opts);
                renderViolationMasterTable(rows);
            }
        });
    }

    function renderViolationMasterTable(rows) {
        if (!Array.isArray(rows) || rows.length === 0) {
            $('#cl_violation_master_tbody').html('<tr><td colspan="4" class="text-center text-muted py-3">No violation heads configured yet.</td></tr>');
            return;
        }
        const html = rows.map(function(h, idx) {
            const txCount = parseInt(h.tx_count || 0, 10);
            const canDelete = (parseInt(h.is_locked || 0, 10) === 0 && txCount === 0);
            const txBadge = txCount > 0
                ? `<span class="badge bg-label-warning">${txCount} used</span>`
                : `<span class="badge bg-label-success">0</span>`;
            const delBtn = canDelete
                ? `<button type="button" class="btn btn-sm btn-icon text-danger cl-btn-del-violation-head" data-id="${h.ids}" title="Delete"><i class="ri-delete-bin-line"></i></button>`
                : `<button type="button" class="btn btn-sm btn-icon text-muted" disabled title="Cannot delete: transactions exist"><i class="ri-delete-bin-line"></i></button>`;
            return `
                <tr>
                    <td class="text-center">${idx + 1}</td>
                    <td class="fw-semibold">${escHtml(h.head_name)}</td>
                    <td class="text-center">${txBadge}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-icon text-primary cl-btn-edit-violation-head" data-id="${h.ids}" data-name="${escHtml(h.head_name)}" title="Edit"><i class="ri-edit-line"></i></button>
                        ${delBtn}
                    </td>
                </tr>
            `;
        }).join('');
        $('#cl_violation_master_tbody').html(html);
    }

    function clLoadOtherFeeHeads() {
        const modelId = parseInt($('#txt_ledger_modal_model_ids').val() || '0', 10) || 0;
        $.ajax({
            url: '/ActiveContractsDashboardController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_other_fee_heads', model_id: modelId }),
            success: function(res) {
                clOtherFeeHeadsMap = {};
                let opts = '';
                const rows = (res && res.status === 'success' && Array.isArray(res.data)) ? res.data : [];
                rows.forEach(function(head) {
                    const name = String(head.head_name || '').trim();
                    if (!name) return;
                    clOtherFeeHeadsMap[name] = head;
                    opts += `<option value="${escHtml(name)}">`;
                });
                $('#cl_other_fee_heads_list').html(opts);
                renderFeeMasterTable(rows);
            }
        });
    }

    function renderFeeMasterTable(rows) {
        if (!Array.isArray(rows) || rows.length === 0) {
            $('#cl_fee_master_tbody').html('<tr><td colspan="5" class="text-center text-muted py-3">No fee heads configured yet.</td></tr>');
            return;
        }
        const html = rows.map(function(h, idx) {
            const isLedgerMaster = h.source === 'Ledger Master' && parseInt(h.ids, 10) > 0;
            const editBtn = isLedgerMaster
                ? `<button type="button" class="btn btn-sm btn-icon text-primary cl-btn-edit-fee-head" data-id="${h.ids}" data-name="${escHtml(h.head_name)}" data-price="${escHtml(h.standard_price)}" title="Edit Price"><i class="ri-edit-line"></i></button>`
                : '';
            const delBtn = (isLedgerMaster && parseInt(h.is_locked, 10) === 0 && parseInt(h.tx_count || 0, 10) === 0)
                ? `<button type="button" class="btn btn-sm btn-icon text-danger cl-btn-del-fee-head" data-id="${h.ids}" title="Delete"><i class="ri-delete-bin-line"></i></button>`
                : (isLedgerMaster ? `<button type="button" class="btn btn-sm btn-icon text-muted" disabled title="Cannot delete: transactions exist"><i class="ri-delete-bin-line"></i></button>` : '');
            const badgeCls = h.source === 'Pricing Master' ? 'bg-label-info' : 'bg-label-primary';
            return `
                <tr>
                    <td class="text-center">${idx + 1}</td>
                    <td class="fw-semibold">${escHtml(h.head_name)}</td>
                    <td class="text-end fw-semibold">${Number(h.standard_price || 0).toFixed(3)} BHD</td>
                    <td class="text-center"><span class="badge ${badgeCls}">${escHtml(h.source)}</span></td>
                    <td class="text-center">${editBtn}${delBtn || (editBtn ? '' : '<span class="text-muted small">-</span>')}</td>
                </tr>
            `;
        }).join('');
        $('#cl_fee_master_tbody').html(html);
    }

    function clRenumberViolations() {
        $('#cl_violations_tbody tr').each(function(idx) {
            $(this).find('.cl-v-num').text(idx + 1);
        });
        updatePendingTotals();
    }

    function clAddViolationRow(vdate = '', title = '', fee = '', remarks = '') {
        const dVal = vdate || new Date().toISOString().slice(0, 10);
        const rowCount = $('#cl_violations_tbody tr').length + 1;
        const $row = $(`
            <tr>
                <td class="text-center align-middle cl-v-num">${rowCount}</td>
                <td class="align-middle"><input type="date" class="form-control form-control-sm cl-v-date" value="${escHtml(dVal)}"></td>
                <td class="align-middle"><input type="text" list="cl_violation_heads_list" class="form-control form-control-sm cl-v-title" placeholder="Search / select violation" value="${escHtml(title)}"></td>
                <td class="align-middle"><input type="text" inputmode="decimal" class="form-control form-control-sm text-end cl-v-fee" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0.000" value="${escHtml(fee)}"></td>
                <td class="align-middle"><input type="text" class="form-control form-control-sm cl-v-remarks" placeholder="Enter remarks" value="${escHtml(remarks)}"></td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-sm btn-outline-danger cl-btn-remove-v px-2 py-1" title="Remove">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
        `);
        $('#cl_violations_tbody').append($row);
        clRenumberViolations();
        $row.find('.cl-v-title').focus();
    }

    function clRenumberFees() {
        $('#cl_other_fee_tbody tr').each(function(idx) {
            $(this).find('.cl-f-num').text(idx + 1);
        });
        updatePendingTotals();
    }

    function clAddOtherFeeRow(item = '', price = '', actualAmount = '', remarks = '') {
        const rowCount = $('#cl_other_fee_tbody tr').length + 1;
        const $row = $(`
            <tr>
                <td class="text-center align-middle cl-f-num">${rowCount}</td>
                <td class="align-middle"><input type="text" list="cl_other_fee_heads_list" class="form-control form-control-sm cl-f-item" placeholder="Select or type fee item" value="${escHtml(item)}"></td>
                <td class="align-middle"><input type="text" inputmode="decimal" class="form-control form-control-sm text-end cl-f-price" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0.000" value="${escHtml(price)}"></td>
                <td class="align-middle"><input type="text" inputmode="decimal" class="form-control form-control-sm text-end cl-f-actual" oninput="this.value=this.value.replace(/[^0-9.]/g,'')" placeholder="0.000" value="${escHtml(actualAmount)}"></td>
                <td class="align-middle"><input type="text" class="form-control form-control-sm cl-f-remarks" placeholder="Enter remarks" value="${escHtml(remarks)}"></td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-sm btn-outline-danger cl-btn-remove-f px-2 py-1" title="Remove">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
        `);
        $('#cl_other_fee_tbody').append($row);
        clRenumberFees();
        $row.find('.cl-f-item').focus();
    }

    function refreshContractLedger(contractId) {
        if (!contractId) return;
        if ($.fn.DataTable.isDataTable('#tblLedger')) {
            $('#tblLedger').DataTable().destroy();
        }
        ledgerTable = $('#tblLedger').DataTable({
            ajax: {
                url: '/CustomerLedgerController',
                data: { action: 'GetContractLedgerData', contract_id: contractId },
                dataSrc: function(json) {
                    const rows = (json && Array.isArray(json.data)) ? json.data : [];
                    let totDebit = 0, totCredit = 0;
                    rows.forEach(r => {
                        totDebit += parseFloat(r.debit || 0);
                        totCredit += parseFloat(r.credit || 0);
                    });
                    const bal = Math.max(0, totDebit - totCredit);
                    $('#cl_rr_advance').val(totCredit.toFixed(3));
                    $('#cl_rr_balance').val(bal.toFixed(3));
                    if (!$('#cl_rr_generated_receipt_no').val()) {
                        $('#cl_rr_amount').val(bal.toFixed(3));
                    }
                    return rows;
                }
            },
            columns: [
                { data: 'trans_date', className: 'text-nowrap', render: v => fmtLedgerDate(v) },
                {
                    data: null,
                    render: r => {
                        const tt = String(r.trans_type || '').trim();
                        const descStr = String(r.description || '');
                        const isReceipt = /\/CM\/|CM\//i.test(tt) || /\/CM\/|CM\//i.test(String(r.ref_no || ''));
                        const isVat = /vat/i.test(descStr);
                        let badge = '';
                        if (isReceipt) {
                            badge = isVat
                                ? '<span class="badge bg-label-secondary ms-1" style="font-size:10px;">Receipt VAT</span>'
                                : '<span class="badge bg-label-success ms-1" style="font-size:10px;">Receipt</span>';
                        }
                        const method = (r.payment_method && r.payment_method !== 'N/A')
                            ? `<span class="badge bg-label-info" style="font-size:10px;">${escHtml(r.payment_method)}</span>`
                            : '<small class="text-muted">Charge / Debit</small>';
                        let chqBadge = '';
                        if (r.payment_method === 'Cheque' && r.cheque_status) {
                            const cs = r.cheque_status;
                            const cls = cs === 'Collected' ? 'bg-label-success' : (cs === 'Bounced' ? 'bg-label-danger' : 'bg-label-warning');
                            chqBadge = ` <span class="badge ${cls}" style="font-size:10px;">${escHtml(cs)}</span>`;
                        }
                        return `<div class="fw-semibold">${escHtml(tt)}${badge}</div><div class="mt-1">${method}${chqBadge}</div>`;
                    }
                },
                {
                    data: null,
                    render: r => {
                        const lines = [];
                        const tt = String(r.trans_type || '').trim();
                        const ref = String(r.ref_no || '').trim();
                        const isReceipt = /\/CM\/|CM\//i.test(tt) || /\/CM\/|CM\//i.test(ref);
                        const recNo = /\/CM\/|CM\//i.test(tt) ? tt : (/\/CM\/|CM\//i.test(ref) ? ref : '');

                        if (isReceipt && recNo) {
                            lines.push(`<div class="fw-semibold text-primary"><i class="ri-receipt-line me-1"></i>Receipt: ${escHtml(recNo)}</div>`);
                        }
                        if (r.payment_method === 'Cheque' && (ref || r.cheque_date)) {
                            lines.push(`<div class="small"><span class="text-muted">Cheque No:</span> <strong>${escHtml(ref || '-')}</strong>${r.cheque_date ? ` <span class="text-info">(Date: ${fmtLedgerDate(r.cheque_date)})</span>` : ''}</div>`);
                        } else if (ref && ref !== '-' && ref !== recNo && ref !== $('#txt_ledger_modal_agreement_no').val()) {
                            lines.push(`<div class="small fw-semibold"><span class="text-muted">Ref:</span> ${escHtml(ref)}</div>`);
                        }
                        if (r.bank_name) {
                            lines.push(`<div style="font-size:11px" class="text-primary"><i class="ri-bank-line me-1"></i>From: ${escHtml(r.bank_name)}${r.account_no ? ' (' + escHtml(r.account_no) + ')' : ''}</div>`);
                        }
                        if (r.company_bank_name) {
                            lines.push(`<div style="font-size:11px" class="text-success"><i class="ri-bank-fill me-1"></i>To: ${escHtml(r.company_bank_name)}${r.company_account_no ? ' (' + escHtml(r.company_account_no) + ')' : ''}</div>`);
                        }
                        if (r.cheque_status === 'Collected' && r.collected_at) {
                            lines.push(`<div style="font-size:11px" class="text-success fw-medium"><i class="ri-checkbox-circle-line me-1"></i>Collected: ${fmtLedgerDate(r.collected_at)}</div>`);
                        }
                        if (r.description) {
                            lines.push(`<div style="font-size:11px" class="text-muted">${escHtml(r.description)}</div>`);
                        }
                        return lines.length ? lines.join('') : '<span class="text-muted">-</span>';
                    }
                },
                { data: 'debit', className: 'text-end text-danger text-nowrap', render: v => Number(v) > 0 ? parseFloat(v).toFixed(3) : '-' },
                { data: 'credit', className: 'text-end text-success text-nowrap', render: v => Number(v) > 0 ? parseFloat(v).toFixed(3) : '-' },
                { data: 'running_balance', className: 'text-end fw-bold text-nowrap', render: v => `<span class="${Number(v) >= 0 ? 'text-primary' : 'text-danger'}">${Number(v || 0).toFixed(3)}</span>` },
                {
                    data: 'ids',
                    className: 'text-center text-nowrap',
                    render: (id, type, r) => {
                        const recMatch = [r.receipt_no, r.voucher_no, r.trans_type, r.ref_no]
                            .map(x => String(x || '').trim())
                            .find(x => /\/CM\/|CM\//i.test(x)) || '';
                        const isReceipt = parseFloat(r.credit || 0) > 0 && recMatch !== '';
                        let btns = '';
                        if (isReceipt) {
                            btns += `<button type="button" class="btn btn-sm btn-icon text-primary cl-print-receipt-row" data-receipt="${escHtml(recMatch)}" title="Print Receipt ${escHtml(recMatch)}"><span class="ri-printer-line"></span></button>`;
                        }
                        if (r.payment_method === 'Cheque') {
                            if (r.cheque_status === 'Pending') {
                                btns += `<button type="button" class="btn btn-sm btn-icon text-success btn-cl-cheque-status" data-id="${id}" data-status="Collected" title="Mark Cheque Collected"><span class="ri-check-line"></span></button>`;
                                btns += `<button type="button" class="btn btn-sm btn-icon text-warning btn-cl-cheque-status" data-id="${id}" data-status="Bounced" title="Mark Cheque Bounced"><span class="ri-close-line"></span></button>`;
                            } else {
                                btns += `<button type="button" class="btn btn-sm btn-icon text-secondary btn-cl-cheque-status" data-id="${id}" data-status="Pending" title="Revoke Cheque Status"><span class="ri-refresh-line"></span></button>`;
                            }
                        }
                        btns += `<button type="button" class="btn btn-sm btn-icon text-danger btn-ledger-delete" data-id="${id}" title="Delete Entry"><span class="ri-delete-bin-line"></span></button>`;
                        return btns;
                    }
                }
            ],
            createdRow: function(row, data) {
                if (data.cheque_status === 'Collected') $(row).addClass('row-collected');
                else if (data.cheque_status === 'Bounced') $(row).addClass('row-bounced');
            },
            order: [[0, 'asc']],
            pageLength: 25
        });
    }

    function resetInlineReceiptForm() {
        $('#cl_rr_receipt_no').val('Auto (Sequential)');
        $('#cl_rr_generated_receipt_no').val('');
        $('#cl_rr_receipt_date').val(new Date().toISOString().slice(0, 10));
        $('#cl_rr_tax_amount').val('0.000');
        $('#cl_rr_note').val('');
        $('#cl_rr_cheque_no, #cl_rr_cheque_date, #cl_rr_cheque_bank').val('');
        $('#cl_rr_payment_type').val('FULL SETTLEMENT');
        $('#cl_rr_payment_mode').val('Cash').trigger('change');
        $('#cl_rr_success_banner').addClass('d-none').removeClass('d-flex');
        $('#cl_rr_btn_generate').prop('disabled', false).show().html('<i class="ri-check-double-line me-1"></i> Generate Receipt');
    }

    function printInlineReceiptByNo(recNo) {
        const cleanNo = $.trim(recNo || '');
        if (!cleanNo) return;
        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(cleanNo))
            .then(r => r.text())
            .then(token => {
                if (token) window.open('/CashMemoPrint?token=' + encodeURIComponent(token.trim()), '_blank');
            });
    }

    $(document).on('click', '.btn-contract-ledger', function() {
        const id = parseInt($(this).data('id'), 10);
        if (!id) return;

        $('#cl_violations_tbody').empty();
        $('#cl_other_fee_tbody').empty();
        clLoadViolationHeads();
        clLoadOtherFeeHeads();

        $.ajax({
            url: '/ContractListController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'GetContractDetails', agreementid: id, vehicleid: 0, customer_code: '', model_ids: 0 }),
            success: function(res) {
                const data = (typeof res === 'string') ? JSON.parse(res) : res;
                const cust = data.customer || {};
                const contract = data.contract || {};
                const veh = data.vehicle || {};
                const agreeNo = contract.agreement_no || '';

                resetInlineReceiptForm();
                $('#ledger_agreement_ref').text(agreeNo || ('#' + id));
                $('#txt_ledger_modal_agreement_id').val(contract.ids || id);
                $('#txt_ledger_modal_agreement_no').val(agreeNo);
                $('#txt_ledger_modal_booking_ids').val(contract.booking_ids || '');
                $('#txt_ledger_modal_quotation_number').val(contract.quotation_number || '');
                $('#txt_ledger_modal_booking_ref').val(contract.agreement_group_ref_no || '');
                $('#txt_ledger_modal_vehicle_ids').val(contract.vehicle_id || '');
                $('#txt_ledger_modal_model_ids').val(contract.vehicle_model_id || '');
                $('#txt_ledger_modal_customer_code').val(cust.customer_id || contract.customer_code || '');

                $('#cl_rr_customer_name').val(cust.customer_name || contract.customer_name || '');
                $('#cl_rr_customer_phone').val(cust.customer_mobile || '');
                $('#cl_rr_customer_email').val(cust.customer_email || '');
                $('#cl_rr_customer_cpr').val(cust.customer_cr_cpr || '');
                $('#cl_rr_customer_address').val(cust.customer_addr || cust.customer_address || '');
                $('#cl_rr_company_id').val(contract.company_id || 1);
                $('#cl_rr_vehicle_no').val(contract.vehicle_no || veh.vehicle_number || '');
                $('#cl_rr_vehicle_color').val(veh.vehicle_color || '');
                $('#cl_rr_car_type').val([veh.model_names || '', contract.vehicle_no || veh.vehicle_number || ''].filter(Boolean).join(' - '));
                if (contract.service_start_date_time) $('#cl_rr_from_date').val(String(contract.service_start_date_time).substring(0, 10));
                if (contract.return_date || contract.service_end_date_time) {
                    $('#cl_rr_to_date').val(String(contract.return_date || contract.service_end_date_time).substring(0, 10));
                }

                clAddViolationRow();
                clAddOtherFeeRow();
                clLoadOtherFeeHeads();
                refreshContractLedger(contract.ids || id);
                bootstrap.Modal.getOrCreateInstance(document.getElementById('contractLedgerModal')).show();
            }
        });
    });

    // Auto-fill standard price when selecting a fee item from Master
    $(document).on('change input', '.cl-f-item', function() {
        const $row = $(this).closest('tr');
        const itemName = $.trim($(this).val());
        const meta = clOtherFeeHeadsMap[itemName];
        if (meta && meta.standard_price !== undefined) {
            const amt = parseFloat(meta.standard_price || 0).toFixed(3);
            $row.find('.cl-f-price').val(amt);
            if (!$row.find('.cl-f-actual').val() || parseFloat($row.find('.cl-f-actual').val()) === 0) {
                $row.find('.cl-f-actual').val(amt);
            }
            updatePendingTotals();
        }
    });

    $(document).on('input', '.cl-v-fee, .cl-f-price, .cl-f-actual', updatePendingTotals);
    $(document).on('click', '#cl_btn_add_violation_row', function() { clAddViolationRow(); });
    $(document).on('click', '.cl-btn-remove-v', function() { $(this).closest('tr').remove(); clRenumberViolations(); });
    $(document).on('click', '#cl_add_other_fee_row', function() { clAddOtherFeeRow(); });
    $(document).on('click', '.cl-btn-remove-f', function() { $(this).closest('tr').remove(); clRenumberFees(); });

    function resetViolationHeadForm() {
        $('#cl_edit_violation_head_id').val('0');
        $('#cl_new_violation_head_name').val('');
        $('#cl_btn_save_violation_head').html('<i class="ri-save-line me-1"></i> Save');
        $('#cl_btn_cancel_edit_violation_head').addClass('d-none');
    }

    $(document).on('click', '#cl_btn_add_violation_head_master', function() {
        resetViolationHeadForm();
        clLoadViolationHeads();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('clModalAddViolationHead')).show();
        setTimeout(() => $('#cl_new_violation_head_name').focus(), 250);
    });

    $(document).on('click', '#cl_btn_cancel_edit_violation_head', resetViolationHeadForm);

    $(document).on('click', '.cl-btn-edit-violation-head', function() {
        $('#cl_edit_violation_head_id').val($(this).data('id'));
        $('#cl_new_violation_head_name').val($(this).data('name'));
        $('#cl_btn_save_violation_head').html('<i class="ri-save-line me-1"></i> Update');
        $('#cl_btn_cancel_edit_violation_head').removeClass('d-none');
        $('#cl_new_violation_head_name').focus();
    });

    $(document).on('click', '.cl-btn-del-violation-head', function() {
        const id = parseInt($(this).data('id'), 10);
        if (!id) return;
        const doDel = () => {
            $.ajax({
                url: '/ActiveContractsDashboardController',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ action: 'delete_violation_head', ids: id }),
                success: function(res) {
                    if (res && res.status === 'success') {
                        clLoadViolationHeads();
                        notifyLedger('Violation head deleted.', 'success');
                    } else {
                        notifyLedger((res && res.message) || 'Failed to delete violation head.', 'error');
                    }
                }
            });
        };
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete Violation Head?',
                text: 'This violation head has no transactions and will be permanently removed.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete'
            }).then(r => { if (r.isConfirmed) doDel(); });
        } else if (confirm('Delete this violation head?')) {
            doDel();
        }
    });

    $(document).on('click', '#cl_btn_save_violation_head', function() {
        const headId = parseInt($('#cl_edit_violation_head_id').val() || '0', 10) || 0;
        const headName = $.trim($('#cl_new_violation_head_name').val());
        if (!headName) {
            notifyLedger('Please enter a violation head name.', 'error');
            return;
        }
        $.ajax({
            url: '/ActiveContractsDashboardController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'save_violation_head', ids: headId, head_name: headName }),
            success: function(res) {
                if (res && res.status === 'success') {
                    resetViolationHeadForm();
                    clLoadViolationHeads();
                    notifyLedger(res.message || 'Violation head saved.', 'success');
                } else {
                    notifyLedger((res && res.message) || 'Failed to save violation head.', 'error');
                }
            }
        });
    });

    function resetFeeHeadForm() {
        $('#cl_edit_fee_head_id').val('0');
        $('#cl_new_fee_head_name').val('');
        $('#cl_new_fee_head_price').val('');
        $('#cl_btn_save_fee_head').html('<i class="ri-save-line me-1"></i> Save');
        $('#cl_btn_cancel_edit_fee_head').addClass('d-none');
    }

    $(document).on('click', '#cl_btn_add_other_fee_head', function() {
        resetFeeHeadForm();
        clLoadOtherFeeHeads();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('clModalAddFeeHead')).show();
        setTimeout(() => $('#cl_new_fee_head_name').focus(), 250);
    });

    $(document).on('click', '#cl_btn_cancel_edit_fee_head', resetFeeHeadForm);

    $(document).on('click', '.cl-btn-edit-fee-head', function() {
        $('#cl_edit_fee_head_id').val($(this).data('id'));
        $('#cl_new_fee_head_name').val($(this).data('name'));
        $('#cl_new_fee_head_price').val(Number($(this).data('price') || 0).toFixed(3));
        $('#cl_btn_save_fee_head').html('<i class="ri-save-line me-1"></i> Update');
        $('#cl_btn_cancel_edit_fee_head').removeClass('d-none');
        $('#cl_new_fee_head_price').focus();
    });

    $(document).on('click', '.cl-btn-del-fee-head', function() {
        const id = parseInt($(this).data('id'), 10);
        if (!id) return;
        $.ajax({
            url: '/ActiveContractsDashboardController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'delete_other_fee_head', ids: id }),
            success: function(res) {
                if (res && res.status === 'success') {
                    clLoadOtherFeeHeads();
                    notifyLedger('Fee head deleted.', 'success');
                } else {
                    notifyLedger((res && res.message) || 'Failed to delete fee head.', 'error');
                }
            }
        });
    });

    $(document).on('click', '#cl_btn_save_fee_head', function() {
        const headId = parseInt($('#cl_edit_fee_head_id').val() || '0', 10) || 0;
        const headName = $.trim($('#cl_new_fee_head_name').val());
        const stdPrice = parseFloat($('#cl_new_fee_head_price').val() || '0') || 0;
        if (!headName) {
            notifyLedger('Please enter a fee head name.', 'error');
            return;
        }
        $.ajax({
            url: '/ActiveContractsDashboardController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'save_other_fee_head',
                ids: headId,
                head_name: headName,
                standard_price: stdPrice
            }),
            success: function(res) {
                if (res && res.status === 'success') {
                    resetFeeHeadForm();
                    clLoadOtherFeeHeads();
                    notifyLedger(res.message || 'Other fee head saved.', 'success');
                } else {
                    notifyLedger((res && res.message) || 'Failed to save fee head.', 'error');
                }
            }
        });
    });

    $(document).on('click', '#btnPostLedgerCharges', function() {
        const cid = parseInt($('#txt_ledger_modal_agreement_id').val(), 10);
        if (!cid) return;

        const violations = [];
        $('#cl_violations_tbody tr').each(function() {
            const vdate = $.trim($(this).find('.cl-v-date').val());
            const title = $.trim($(this).find('.cl-v-title').val());
            const fee = parseFloat($(this).find('.cl-v-fee').val() || '0') || 0;
            const remarks = $.trim($(this).find('.cl-v-remarks').val());
            if (title !== '' || fee > 0) {
                violations.push({ violation_date: vdate, title: title, fee: fee, remarks: remarks });
            }
        });

        const otherFees = [];
        $('#cl_other_fee_tbody tr').each(function() {
            const item = $.trim($(this).find('.cl-f-item').val());
            const price = parseFloat($(this).find('.cl-f-price').val() || '0') || 0;
            const actual = parseFloat($(this).find('.cl-f-actual').val() || '0') || 0;
            const remarks = $.trim($(this).find('.cl-f-remarks').val());
            if (item !== '' || actual > 0 || price > 0) {
                otherFees.push({ item: item, price: price, actual_amount: actual > 0 ? actual : price, remarks: remarks });
            }
        });

        if (violations.length === 0 && otherFees.length === 0) {
            notifyLedger('Please enter at least one Violation or Other Fee.', 'error');
            return;
        }

        const $btn = $(this).prop('disabled', true);
        $.ajax({
            url: '/ActiveContractsDashboardController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'post_ledger_charges',
                contract_id: cid,
                violations: violations,
                other_fees: otherFees
            }),
            success: function(res) {
                $btn.prop('disabled', false);
                if (res && res.status === 'success') {
                    $('#cl_violations_tbody').empty();
                    $('#cl_other_fee_tbody').empty();
                    updatePendingTotals();
                    refreshContractLedger(cid);
                    $('#btnRefreshActive').trigger('click');
                    notifyLedger(res.message || 'Posted to Contract Ledger.', 'success');
                } else {
                    notifyLedger((res && res.message) || 'Failed to post entries.', 'error');
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                notifyLedger('Network error posting entries.', 'error');
            }
        });
    });

    $(document).on('click', '.btn-ledger-delete', function() {
        const id = $(this).data('id');
        const doDelete = () => {
            $.post('/CustomerLedgerController', { action: 'DeleteTransaction', ids: id }, function(res) {
                if (res && res.status) {
                    if (ledgerTable) ledgerTable.ajax.reload(null, false);
                    $('#btnRefreshActive').trigger('click');
                    notifyLedger('Entry deleted successfully.', 'success');
                } else {
                    notifyLedger((res && res.message) || 'Failed to delete entry.', 'error');
                }
            }, 'json');
        };
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Delete Entry?',
                text: 'Remove this entry from the Contract Ledger?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete'
            }).then(r => { if (r.isConfirmed) doDelete(); });
        } else if (confirm('Delete this entry?')) {
            doDelete();
        }
    });

    $(document).on('change', '#cl_rr_payment_mode', function() {
        if ($(this).val() === 'Cheque') {
            $('.cl-rr-cheque-field').removeClass('d-none');
        } else {
            $('.cl-rr-cheque-field').addClass('d-none');
        }
    });

    $(document).on('click', '#cl_rr_new_btn', function() {
        resetInlineReceiptForm();
        const bal = parseFloat($('#cl_rr_balance').val() || '0') || 0;
        $('#cl_rr_amount').val(bal.toFixed(3));
    });

    $(document).on('click', '#cl_rr_banner_print_btn', function() {
        printInlineReceiptByNo($('#cl_rr_generated_receipt_no').val());
    });

    $(document).on('click', '#cl_rr_banner_wa_btn', function() {
        const recNo = $.trim($('#cl_rr_generated_receipt_no').val());
        if (!recNo) return;
        const phoneRaw = ($('#cl_rr_customer_phone').val() || '').replace(/[^0-9]/g, '');
        const phone = phoneRaw.length === 8 ? ('973' + phoneRaw) : phoneRaw;
        const msg = [
            '*FAST LINK CAR RENTAL - RECEIPT VOUCHER*',
            'Receipt No: ' + recNo,
            'Date: ' + ($('#cl_rr_receipt_date').val() || ''),
            'Agreement No: ' + ($('#txt_ledger_modal_agreement_no').val() || ''),
            'Customer: ' + ($('#cl_rr_customer_name').val() || ''),
            'Vehicle: ' + ($('#cl_rr_car_type').val() || ''),
            'Payment Type: ' + ($('#cl_rr_payment_type').val() || ''),
            'Payment Mode: ' + ($('#cl_rr_payment_mode').val() || ''),
            'Amount Paid: ' + (parseFloat($('#cl_rr_amount').val()) || 0).toFixed(3) + ' BHD',
            'Remaining Balance: ' + ($('#cl_rr_balance').val() || '0.000') + ' BHD'
        ].join('\n');
        const url = phone ? ('https://wa.me/' + phone + '?text=' + encodeURIComponent(msg)) : ('https://wa.me/?text=' + encodeURIComponent(msg));
        window.open(url, '_blank');
    });

    $(document).on('click', '#cl_rr_btn_generate', function() {
        const amt = parseFloat($('#cl_rr_amount').val()) || 0;
        const tax = parseFloat($('#cl_rr_tax_amount').val()) || 0;
        if (amt <= 0) {
            notifyLedger('Please enter a receipt amount greater than 0.', 'error');
            return;
        }
        const totalAmt = amt + tax;
        const payMode = $('#cl_rr_payment_mode').val() || 'Cash';
        const payType = $('#cl_rr_payment_type').val() || 'RENT';
        const agreeNo = $('#txt_ledger_modal_agreement_no').val() || '';
        const cid = parseInt($('#txt_ledger_modal_agreement_id').val(), 10) || 0;
        const noteParts = [payType];
        if ($('#cl_rr_note').val()) noteParts.push($('#cl_rr_note').val().trim());
        if (payMode === 'Cheque' && $('#cl_rr_cheque_bank').val()) noteParts.push('Bank: ' + $('#cl_rr_cheque_bank').val().trim());

        const $btn = $('#cl_rr_btn_generate');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Generating...');

        const payload = {
            company_id: $('#cl_rr_company_id').val() || 1,
            cashmemo_id: '',
            cashmemo_number: '',
            original_draft: 'No',
            action_type: 'new',
            save_type: 'confirm',
            customer_name: $('#cl_rr_customer_name').val(),
            customer_code: $('#txt_ledger_modal_customer_code').val(),
            customer_phone: $('#cl_rr_customer_phone').val(),
            customer_email: $('#cl_rr_customer_email').val(),
            customer_cpr_cr: $('#cl_rr_customer_cpr').val(),
            customer_address: $('#cl_rr_customer_address').val(),
            cashmemo_date: $('#cl_rr_receipt_date').val(),
            cashmemo_notes: noteParts.join(' - '),
            cashmemo_payment_type: payMode,
            cashmemo_cheque_date: $('#cl_rr_cheque_date').val() || '',
            cashmemo_cheque_ref_no: $('#cl_rr_cheque_no').val() || '',
            contract_id: cid,
            agreement_no: agreeNo,
            vehicle_id: $('#txt_ledger_modal_model_ids').val(),
            booking_ids: $('#txt_ledger_modal_booking_ids').val() || 0,
            vehicle_model_id: $('#txt_ledger_modal_vehicle_ids').val(),
            model_name: $('#cl_rr_car_type').val(),
            vehicleno: $('#cl_rr_vehicle_no').val(),
            vehiclecolor: $('#cl_rr_vehicle_color').val(),
            items: [{
                item_name: payType + ' (' + agreeNo + ')',
                qty: 1,
                price: amt.toFixed(3),
                vat: tax > 0 && amt > 0 ? ((tax / amt) * 100).toFixed(2) : 0,
                total: totalAmt.toFixed(3)
            }],
            subtotal: amt,
            vat_total: tax,
            grand_total: totalAmt,
            total_discount: 0,
            total_discount_amount: 0,
            after_discount_amount: totalAmt,
            allItemSubtotal: amt,
            action: 'SaveCashMemo'
        };

        $.post('/CashMemoController', payload)
            .done(function(res) {
                const d = (typeof res === 'string') ? JSON.parse(res) : res;
                if (d && String(d.status).toLowerCase() === 'success') {
                    const recNo = d.message || '';
                    $('#cl_rr_generated_receipt_no').val(recNo);
                    $('#cl_rr_receipt_no').val(recNo);
                    $('#cl_rr_generated_no_badge').text(recNo);
                    $('#cl_rr_success_banner').removeClass('d-none').addClass('d-flex');
                    $btn.hide();
                    refreshContractLedger(cid);
                    $('#btnRefreshActive').trigger('click');
                    notifyLedger('Receipt ' + recNo + ' generated.', 'success');
                } else {
                    $btn.prop('disabled', false).html('<i class="ri-check-double-line me-1"></i> Generate Receipt');
                    notifyLedger((d && d.message) || 'Failed to generate receipt.', 'error');
                }
            })
            .fail(function() {
                $btn.prop('disabled', false).html('<i class="ri-check-double-line me-1"></i> Generate Receipt');
                notifyLedger('Network error generating receipt.', 'error');
            });
    });

    $(document).on('click', '.btn-cl-cheque-status', function() {
        const id = $(this).data('id');
        const status = $(this).data('status');
        const msg = status === 'Pending' ? 'Revoke cheque status back to Pending?' : `Mark cheque as ${status}?`;
        const doUpdate = () => {
            $.post('/CustomerLedgerController', { action: 'UpdateChequeStatus', ids: id, status: status }, function(res) {
                if (res && res.status) {
                    if (ledgerTable) ledgerTable.ajax.reload(null, false);
                    $('#btnRefreshActive').trigger('click');
                    notifyLedger('Cheque status updated.', 'success');
                } else {
                    notifyLedger((res && res.message) || 'Failed to update cheque status.', 'error');
                }
            }, 'json');
        };
        if (typeof Swal !== 'undefined') {
            Swal.fire({ title: 'Update Cheque Status?', text: msg, icon: 'question', showCancelButton: true, confirmButtonText: 'Yes, proceed' })
                .then(r => { if (r.isConfirmed) doUpdate(); });
        } else if (confirm(msg)) {
            doUpdate();
        }
    });

    $(document).on('click', '.cl-print-receipt-row', function() {
        printInlineReceiptByNo($(this).data('receipt'));
    });

    // Ensure nested modals (Receipt Voucher, Add Violation Head, Add Fee Head) always stack above #contractLedgerModal
    $(document).on('show.bs.modal', '.modal', function() {
        let maxZ = 1090;
        document.querySelectorAll('.modal.show').forEach(function(el) {
            const z = parseInt(window.getComputedStyle(el).zIndex, 10);
            if (!isNaN(z) && z >= maxZ) maxZ = z;
        });
        const nextZ = maxZ + 20;
        this.style.setProperty('z-index', String(nextZ), 'important');
        setTimeout(function() {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            if (backdrops.length > 0) {
                backdrops[backdrops.length - 1].style.setProperty('z-index', String(nextZ - 10), 'important');
            }
        }, 0);
    });

    $(document).on('hidden.bs.modal', '#returnReceiptVoucherModal, #clModalAddViolationHead, #clModalAddFeeHead', function() {
        if ($('#contractLedgerModal').hasClass('show')) {
            document.body.classList.add('modal-open');
            if (this.id === 'returnReceiptVoucherModal') {
                const cid = parseInt($('#txt_ledger_modal_agreement_id').val(), 10);
                if (cid) refreshContractLedger(cid);
                $('#btnRefreshActive').trigger('click');
            }
        }
    });
})();
