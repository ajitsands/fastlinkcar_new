window.ReturnReceiptModal = (function () {
    function esc(s) {
        return $('<div>').text(s || '').html();
    }

    function fmtDisplayDate(val) {
        if (!val) return '-';
        const s = String(val).substring(0, 10);
        const parts = s.split('-');
        if (parts.length === 3 && parts[0].length === 4) {
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            const mIdx = parseInt(parts[1], 10) - 1;
            if (mIdx >= 0 && mIdx < 12) {
                return `${parts[2]}-${months[mIdx]}-${parts[0]}`;
            }
        }
        return s;
    }

    function loadLedger(contractId) {
        $('#rr_ledger_tbody').html('<tr><td colspan="8" class="text-center text-muted py-2">Loading ledger...</td></tr>');
        $.getJSON('/CustomerLedgerController', {
            action: 'GetContractLedgerData',
            contract_id: contractId
        }, function (res) {
            const d = (typeof res === 'string') ? JSON.parse(res) : res;
            const rows = (d && Array.isArray(d.data)) ? d.data : (Array.isArray(d) ? d : []);
            let totalDebit = 0;
            let totalCredit = 0;
            let running = 0;
            if (!rows.length) {
                $('#rr_ledger_tbody').html('<tr><td colspan="8" class="text-center text-muted py-2">No ledger entries found</td></tr>');
                $('#rr_led_total_debit, #rr_led_total_credit, #rr_led_balance').text('0.000');
                return;
            }
            const html = rows.map((r, idx) => {
                const deb = parseFloat(r.debit || 0);
                const cred = ((r.cheque_status || '') === 'Bounced') ? 0 : parseFloat(r.credit || 0);
                totalDebit += deb;
                totalCredit += cred;
                running += (deb - cred);
                const dt = fmtDisplayDate(r.trans_date || r.created_at);
                const desc = r.description || r.remarks || r.notes || '-';
                const methodBadge = (r.payment_method && r.payment_method !== 'N/A') ? ` <span class="badge bg-label-info">${esc(r.payment_method)}</span>` : '';
                const candRef = String(r.receipt_no || r.voucher_no || r.ref_no || r.trans_type || '').trim();
                const isReceiptRow = cred > 0 && /\/CM\/|CM\//i.test(candRef);
                const printCell = isReceiptRow
                    ? `<button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rr-print-ledger-receipt" data-receipt="${esc(candRef)}" title="Print Receipt ${esc(candRef)}"><i class="ri-printer-line"></i></button>`
                    : '-';
                return `
                    <tr>
                        <td>${idx + 1}</td>
                        <td class="text-nowrap">${esc(dt)}</td>
                        <td><span class="badge bg-label-primary">${esc(r.trans_type || '-')}</span>${methodBadge}</td>
                        <td>${esc(desc)}</td>
                        <td class="text-end">${deb > 0 ? deb.toFixed(3) : '-'}</td>
                        <td class="text-end text-success">${cred > 0 ? cred.toFixed(3) : '-'}</td>
                        <td class="text-end fw-semibold">${running.toFixed(3)}</td>
                        <td class="text-center">${printCell}</td>
                    </tr>
                `;
            }).join('');
            const bal = Math.max(0, totalDebit - totalCredit);
            $('#rr_ledger_tbody').html(html);
            $('#rr_led_total_debit').text(totalDebit.toFixed(3));
            $('#rr_led_total_credit').text(totalCredit.toFixed(3));
            $('#rr_led_balance').text(bal.toFixed(3));
            $('#rr_advance').val(totalCredit.toFixed(3));
            $('#rr_balance').val(bal.toFixed(3));
            if (!$('#rr_generated_receipt_no').val()) {
                $('#rr_amount').val(bal.toFixed(3));
            }
        });
    }

    function open(opts) {
        const contractId = opts.contract_id;
        if (!contractId) return;

        $('#rr_contract_id').val(contractId);
        $('#rr_agreement_no').val(opts.agreement_no || '');
        $('#rr_agreement_no_display').val(opts.agreement_no || '');
        $('#rr_agreement_label').text(opts.agreement_no || ('#' + contractId));
        $('#rr_customer_code').val(opts.customer_code || '');
        $('#rr_receipt_no').val('Auto (Sequential)');
        $('#rr_generated_receipt_no').val('');
        $('#rr_receipt_date').val(new Date().toISOString().slice(0, 10));
        $('#rr_amount').val('0.000');
        $('#rr_tax_amount').val('0.000');
        $('#rr_note').val('');
        $('#rr_cheque_no, #rr_cheque_date, #rr_cheque_bank').val('');
        $('#rr_payment_type').val(opts.default_payment_type || 'FULL SETTLEMENT');
        $('#rr_payment_mode').val('Cash').trigger('change');
        $('#rr_success_banner').addClass('d-none').removeClass('d-flex');
        $('#rr_btn_print, #rr_btn_whatsapp').addClass('d-none');
        $('#rr_btn_generate').prop('disabled', false).show();

        const modalEl = document.getElementById('returnReceiptVoucherModal');
        $(modalEl).off('hidden.bs.modal.rrClose');
        if (typeof opts.onClose === 'function') {
            $(modalEl).on('hidden.bs.modal.rrClose', function () {
                opts.onClose();
            });
        }
        bootstrap.Modal.getOrCreateInstance(modalEl).show();

        $.ajax({
            url: '/ContractListController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'GetContractDetails',
                agreementid: contractId,
                customer_code: opts.customer_code || ''
            }),
            success: function (res) {
                const d = (typeof res === 'string') ? JSON.parse(res) : res;
                if (!d || !d.contract) return;
                const c = d.contract;
                const cust = d.customer || {};
                const veh = d.vehicle || {};

                $('#rr_agreement_no').val(c.agreement_no || opts.agreement_no || '');
                $('#rr_agreement_no_display').val(c.agreement_no || opts.agreement_no || '');
                $('#rr_agreement_label').text(c.agreement_no || opts.agreement_no || '');
                $('#rr_customer_code').val(cust.customer_id || c.customer_code || opts.customer_code || '');
                $('#rr_customer_name').val(cust.customer_name || c.customer_name || '');
                $('#rr_customer_phone').val(cust.customer_mobile || '');
                $('#rr_customer_email').val(cust.customer_email || '');
                $('#rr_customer_cpr').val(cust.customer_cr_cpr || '');
                $('#rr_customer_address').val(cust.customer_addr || cust.customer_address || '');
                $('#rr_company_id').val(c.company_id || 1);
                $('#rr_vehicle_id').val(c.vehicle_id || '');
                $('#rr_model_id').val(c.vehicle_model_id || '');
                $('#rr_booking_ids').val(c.booking_ids || 0);
                $('#rr_vehicle_no').val(c.vehicle_no || veh.vehicle_number || '');
                $('#rr_vehicle_color').val(veh.vehicle_color || '');
                $('#rr_car_type').val([veh.model_names || '', c.vehicle_no || veh.vehicle_number || ''].filter(Boolean).join(' - '));

                if (c.service_start_date_time) $('#rr_from_date').val(String(c.service_start_date_time).substring(0, 10));
                if (c.return_date || c.service_end_date_time) {
                    $('#rr_to_date').val(String(c.return_date || c.service_end_date_time).substring(0, 10));
                }
            }
        });

        loadLedger(contractId);
    }

    function printReceiptByNo(recNo) {
        const cleanNo = $.trim(recNo || '');
        if (!cleanNo) return;
        fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent(cleanNo))
            .then(r => r.text())
            .then(token => {
                if (token) window.open('/CashMemoPrint?token=' + encodeURIComponent(token.trim()), '_blank');
            });
    }

    function printReceipt() {
        printReceiptByNo($('#rr_generated_receipt_no').val());
    }

    $(document).on('click', '.rr-print-ledger-receipt', function () {
        printReceiptByNo($(this).data('receipt'));
    });

    function sendWhatsApp() {
        const recNo = $.trim($('#rr_generated_receipt_no').val());
        if (!recNo) return;
        const phoneRaw = ($('#rr_customer_phone').val() || '').replace(/[^0-9]/g, '');
        const phone = phoneRaw.length === 8 ? ('973' + phoneRaw) : phoneRaw;
        const msg = [
            '*FAST LINK CAR RENTAL - RECEIPT VOUCHER*',
            'Receipt No: ' + recNo,
            'Date: ' + ($('#rr_receipt_date').val() || ''),
            'Agreement No: ' + ($('#rr_agreement_no').val() || ''),
            'Customer: ' + ($('#rr_customer_name').val() || ''),
            'Vehicle: ' + ($('#rr_car_type').val() || ''),
            'Payment Type: ' + ($('#rr_payment_type').val() || ''),
            'Payment Mode: ' + ($('#rr_payment_mode').val() || ''),
            'Amount Paid: ' + (parseFloat($('#rr_amount').val()) || 0).toFixed(3) + ' BHD',
            'Remaining Balance: ' + ($('#rr_led_balance').text() || '0.000') + ' BHD'
        ].join('\n');
        const url = phone ? ('https://wa.me/' + phone + '?text=' + encodeURIComponent(msg)) : ('https://wa.me/?text=' + encodeURIComponent(msg));
        window.open(url, '_blank');
    }

    $(document).on('change', '#rr_payment_mode', function () {
        if ($(this).val() === 'Cheque') {
            $('.rr-cheque-field').removeClass('d-none');
        } else {
            $('.rr-cheque-field').addClass('d-none');
        }
    });

    $(document).on('click', '#rr_btn_print, #rr_banner_print_btn', printReceipt);
    $(document).on('click', '#rr_btn_whatsapp, #rr_banner_wa_btn', sendWhatsApp);

    $(document).on('click', '#rr_btn_generate', function () {
        const amt = parseFloat($('#rr_amount').val()) || 0;
        const tax = parseFloat($('#rr_tax_amount').val()) || 0;
        if (amt <= 0) {
            if (typeof Swal !== 'undefined') Swal.fire('Invalid Amount', 'Please enter a receipt amount greater than 0.', 'warning');
            else alert('Please enter a receipt amount greater than 0.');
            return;
        }
        const totalAmt = amt + tax;
        const payMode = $('#rr_payment_mode').val() || 'Cash';
        const payType = $('#rr_payment_type').val() || 'RENT';
        const noteParts = [payType];
        if ($('#rr_note').val()) noteParts.push($('#rr_note').val().trim());
        if (payMode === 'Cheque' && $('#rr_cheque_bank').val()) noteParts.push('Bank: ' + $('#rr_cheque_bank').val().trim());

        const $btn = $('#rr_btn_generate');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Generating...');

        const payload = {
            company_id: $('#rr_company_id').val() || 1,
            cashmemo_id: '',
            cashmemo_number: '',
            original_draft: 'No',
            action_type: 'new',
            save_type: 'confirm',
            customer_name: $('#rr_customer_name').val(),
            customer_code: $('#rr_customer_code').val(),
            customer_phone: $('#rr_customer_phone').val(),
            customer_email: $('#rr_customer_email').val(),
            customer_cpr_cr: $('#rr_customer_cpr').val(),
            customer_address: $('#rr_customer_address').val(),
            cashmemo_date: $('#rr_receipt_date').val(),
            cashmemo_notes: noteParts.join(' - '),
            cashmemo_payment_type: payMode,
            cashmemo_cheque_date: $('#rr_cheque_date').val() || '',
            cashmemo_cheque_ref_no: $('#rr_cheque_no').val() || '',
            contract_id: $('#rr_contract_id').val(),
            agreement_no: $('#rr_agreement_no').val(),
            vehicle_id: $('#rr_model_id').val(),
            booking_ids: $('#rr_booking_ids').val() || 0,
            vehicle_model_id: $('#rr_vehicle_id').val(),
            model_name: $('#rr_car_type').val(),
            vehicleno: $('#rr_vehicle_no').val(),
            vehiclecolor: $('#rr_vehicle_color').val(),
            items: [{
                item_name: payType + ' (' + ($('#rr_agreement_no').val() || '') + ')',
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
            .done(function (res) {
                const d = (typeof res === 'string') ? JSON.parse(res) : res;
                if (d && String(d.status).toLowerCase() === 'success') {
                    const recNo = d.message || '';
                    $('#rr_generated_receipt_no').val(recNo);
                    $('#rr_receipt_no').val(recNo);
                    $('#rr_generated_no_badge').text(recNo);
                    $('#rr_success_banner').removeClass('d-none').addClass('d-flex');
                    $('#rr_btn_print, #rr_btn_whatsapp').removeClass('d-none');
                    $btn.hide();
                    loadLedger($('#rr_contract_id').val());
                } else {
                    $btn.prop('disabled', false).html('<i class="ri-check-double-line me-1"></i> Generate Receipt');
                    if (typeof Swal !== 'undefined') Swal.fire('Error', (d && d.message) || 'Failed to generate receipt', 'error');
                }
            })
            .fail(function () {
                $btn.prop('disabled', false).html('<i class="ri-check-double-line me-1"></i> Generate Receipt');
            });
    });

    return { open };
})();
