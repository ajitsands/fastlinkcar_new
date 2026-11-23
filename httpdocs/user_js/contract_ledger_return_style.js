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
            url: '/ContractListController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'getViolationHeads' }),
            success: function(res) {
                if (res && res.status && Array.isArray(res.data)) {
                    let opts = '';
                    res.data.forEach(function(item) {
                        opts += `<option value="${escHtml(item.head_name)}">`;
                    });
                    $('#cl_violation_heads_list').html(opts);
                }
            }
        });
    }

    function clLoadOtherFeeHeads() {
        $.get('/CustomerLedgerController', { action: 'GetLedgerHeadsContract' }, function(res) {
            clOtherFeeHeadsMap = {};
            let opts = '';
            if (res && res.status && Array.isArray(res.data)) {
                res.data.forEach(function(head) {
                    if (String(head.head_type || '').toLowerCase() === 'debit') {
                        clOtherFeeHeadsMap[String(head.text || '').trim()] = {
                            id: head.id,
                            ledger_type: head.ledger_type || 'No'
                        };
                        opts += `<option value="${escHtml(head.text)}">`;
                    }
                });
            }
            $('#cl_other_fee_heads_list').html(opts);
        }, 'json');
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
                    $('#lblTotalDebit').text(totDebit.toFixed(3));
                    $('#lblTotalCredit').text(totCredit.toFixed(3));
                    $('#lblBalance').text((totDebit - totCredit).toFixed(3));
                    return rows;
                }
            },
            columns: [
                { data: 'trans_date', className: 'text-nowrap', render: v => fmtLedgerDate(v) },
                { data: null, render: r => `<div class="fw-semibold">${escHtml(r.trans_type || '')}</div><small class="text-muted">${escHtml(r.payment_method || '')}</small>` },
                {
                    data: null,
                    render: r => {
                        let out = `<div class="fw-semibold">${escHtml(r.ref_no || '-')}${r.cheque_date ? `<span class="text-info fw-normal ms-2" style="font-size:11px">(${fmtLedgerDate(r.cheque_date)})</span>` : ''}</div>`;
                        if (r.description) out += `<div style="font-size:11px" class="text-muted">${escHtml(r.description)}</div>`;
                        return out;
                    }
                },
                { data: 'debit', className: 'text-end text-danger text-nowrap', render: v => Number(v) > 0 ? parseFloat(v).toFixed(3) : '-' },
                { data: 'credit', className: 'text-end text-success text-nowrap', render: v => Number(v) > 0 ? parseFloat(v).toFixed(3) : '-' },
                { data: 'running_balance', className: 'text-end fw-bold text-nowrap', render: v => `<span class="${Number(v) >= 0 ? 'text-primary' : 'text-danger'}">${Number(v || 0).toFixed(3)}</span>` },
                {
                    data: 'ids',
                    className: 'text-center',
                    render: id => `<button type="button" class="btn btn-sm btn-icon text-danger btn-ledger-delete" data-id="${id}" title="Delete Entry"><span class="ri-delete-bin-line"></span></button>`
                }
            ],
            order: [[0, 'asc']],
            pageLength: 25
        });
    }

    function openReceiptFromLedger() {
        const cid = parseInt($('#txt_ledger_modal_agreement_id').val(), 10);
        if (!cid || !window.ReturnReceiptModal) return;
        window.ReturnReceiptModal.open({
            contract_id: cid,
            customer_code: $('#txt_ledger_modal_customer_code').val() || '',
            agreement_no: $('#txt_ledger_modal_agreement_no').val() || ''
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
                const agreeNo = contract.agreement_no || '';

                $('#ledger_agreement_ref').text(agreeNo || ('#' + id));
                $('#txt_ledger_modal_agreement_id').val(contract.ids || id);
                $('#txt_ledger_modal_agreement_no').val(agreeNo);
                $('#txt_ledger_modal_booking_ids').val(contract.booking_ids || '');
                $('#txt_ledger_modal_quotation_number').val(contract.quotation_number || '');
                $('#txt_ledger_modal_booking_ref').val(contract.agreement_group_ref_no || '');
                $('#txt_ledger_modal_vehicle_ids').val(contract.vehicle_id || '');
                $('#txt_ledger_modal_model_ids').val(contract.vehicle_model_id || '');
                $('#txt_ledger_modal_customer_code').val(contract.customer_code || '');

                $('#display_customer_name').text((cust.customer_name || '-') + (cust.customer_id ? ' | ' + cust.customer_id : ''));
                $('#display_mobile').text(cust.customer_mobile || '-');
                $('#display_booking_ref').text(contract.agreement_group_ref_no || '-');
                $('#display_quotation_no').text(contract.quotation_number || '-');

                clAddViolationRow();
                clAddOtherFeeRow();
                refreshContractLedger(contract.ids || id);
                bootstrap.Modal.getOrCreateInstance(document.getElementById('contractLedgerModal')).show();
            }
        });
    });

    // Auto-fill standard price when selecting a pricing master fee item
    $(document).on('change', '.cl-f-item', function() {
        const $row = $(this).closest('tr');
        const itemName = $.trim($(this).val());
        const meta = clOtherFeeHeadsMap[itemName];
        const modelId = $('#txt_ledger_modal_model_ids').val();
        if (meta && meta.ledger_type === 'Yes' && modelId) {
            $.post('/CustomerLedgerController', { action: 'getmodel_price', model_ids: modelId, head_ids: meta.id }, function(res) {
                if (res && res.status && res.data && res.data.length > 0) {
                    const amt = parseFloat(res.data[0].amount || 0).toFixed(3);
                    $row.find('.cl-f-price').val(amt);
                    if (!$row.find('.cl-f-actual').val()) {
                        $row.find('.cl-f-actual').val(amt);
                    }
                    updatePendingTotals();
                }
            }, 'json');
        }
    });

    $(document).on('input', '.cl-v-fee, .cl-f-price, .cl-f-actual', updatePendingTotals);
    $(document).on('click', '#cl_btn_add_violation_row', function() { clAddViolationRow(); });
    $(document).on('click', '.cl-btn-remove-v', function() { $(this).closest('tr').remove(); clRenumberViolations(); });
    $(document).on('click', '#cl_add_other_fee_row', function() { clAddOtherFeeRow(); });
    $(document).on('click', '.cl-btn-remove-f', function() { $(this).closest('tr').remove(); clRenumberFees(); });

    $(document).on('click', '#cl_btn_add_violation_head_master', function() {
        $('#cl_new_violation_head_name').val('');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('clModalAddViolationHead')).show();
        setTimeout(() => $('#cl_new_violation_head_name').focus(), 250);
    });

    $(document).on('click', '#cl_btn_save_violation_head', function() {
        const headName = $.trim($('#cl_new_violation_head_name').val());
        if (!headName) {
            notifyLedger('Please enter a violation head name.', 'error');
            return;
        }
        $.ajax({
            url: '/ContractListController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'saveViolationHead', head_name: headName }),
            success: function(res) {
                if (res && res.status) {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('clModalAddViolationHead')).hide();
                    clLoadViolationHeads();
                    notifyLedger('Violation head saved.', 'success');
                } else {
                    notifyLedger((res && res.message) || 'Failed to save violation head.', 'error');
                }
            }
        });
    });

    $(document).on('click', '#cl_btn_add_other_fee_head', function() {
        $('#cl_new_fee_head_name').val('');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('clModalAddFeeHead')).show();
        setTimeout(() => $('#cl_new_fee_head_name').focus(), 250);
    });

    $(document).on('click', '#cl_btn_save_fee_head', function() {
        const headName = $.trim($('#cl_new_fee_head_name').val());
        if (!headName) {
            notifyLedger('Please enter a fee head name.', 'error');
            return;
        }
        $.post('/CustomerLedgerController', { action: 'SaveLedgerHead', head_name: headName, head_type: 'Debit' }, function(res) {
            if (res && res.status) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('clModalAddFeeHead')).hide();
                clLoadOtherFeeHeads();
                notifyLedger('Other fee head saved.', 'success');
            } else {
                notifyLedger((res && res.message) || 'Failed to save fee head.', 'error');
            }
        }, 'json');
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

    $(document).on('click', '#btnLedgerGenerateReceipt, #btnLedgerGenerateReceiptFooter', openReceiptFromLedger);

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
