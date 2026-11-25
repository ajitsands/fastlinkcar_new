(function ($) {
    'use strict';

    let highResLogoBase64 = null;
    let highResLogoRatio = 1;

    $(document).ready(function () {
        // Preload high-res logo for PDF
        let img = new Image();
        img.onload = function() {
            let canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            let ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0);
            highResLogoBase64 = canvas.toDataURL('image/png');
            highResLogoRatio = img.width / img.height;
        };
        img.src = '/assets/img/logo/logo.png';

        // Initialize Select2
        if ($('.select2').length) {
            $('.select2').select2();
        }

        // Set default dates (start of month to today)
        const today = new Date();
        const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        
        $('#filter_to_date').val(today.toISOString().split('T')[0]);
        $('#filter_from_date').val(startOfMonth.toISOString().split('T')[0]);

        loadCompanies();

        $('#filter_company').on('change', function () {
            loadVehicles();
        });
    });

    function loadCompanies() {
        $.ajax({
            url: '/VehicleUtilizationReportController',
            type: 'POST',
            data: { action: 'get_companies' },
            dataType: 'json',
            success: function (data) {
                let html = '<option value="">All Companies</option>';
                $.each(data, function (index, item) {
                    html += `<option value="${item.ids}">${item.company_name}</option>`;
                });
                $('#filter_company').html(html);
                
                // If only 1 company is returned and we are not super admin, it might just be the active one.
                // Or if we want to auto-select, we can, but leaving as "All Companies" is fine.
                loadVehicles();
            }
        });
    }

    function loadVehicles() {
        let company_id = $('#filter_company').val();
        $.ajax({
            url: '/VehicleUtilizationReportController',
            type: 'POST',
            data: { action: 'get_vehicles', company_id: company_id },
            dataType: 'json',
            success: function (data) {
                let html = '<option value="">All Vehicles</option>';
                $.each(data, function (index, item) {
                    html += `<option value="${item.ids}">${item.display_text}</option>`;
                });
                $('#filter_vehicle').html(html);
            }
        });
    }

    // Search button click
    $('#btnSearch').on('click', function () {
        loadReport();
    });

    // Load report data
    function loadReport() {
        let company_id = $('#filter_company').val();
        let vehicle_id = $('#filter_vehicle').val();
        let from_date = $('#filter_from_date').val();
        let to_date = $('#filter_to_date').val();
        
        if (!from_date || !to_date) {
            alertSands("Please select both Date From and Date To.", 'error');
            return;
        }

        $.ajax({
            url: '/VehicleUtilizationReportController',
            type: 'POST',
            data: {
                action: 'get_report',
                company_id: company_id,
                vehicle_id: vehicle_id,
                from_date: from_date,
                to_date: to_date
            },
            beforeSend: function () {
                $('#utilizationReportTable tbody').html('<tr><td colspan="6" class="text-center"><div class="spinner-border text-primary" role="status"></div></td></tr>');
            },
            success: function (data) {
                $('#utilizationReportTable tbody').html(data);
            },
            error: function () {
                $('#utilizationReportTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Error loading report</td></tr>');
            }
        });
    }

    function hexToRgbArray(hex, fallback) {
        const clean = String(hex || '').replace('#', '').trim();
        if (/^[0-9a-fA-F]{6}$/.test(clean)) {
            return [
                parseInt(clean.substring(0, 2), 16),
                parseInt(clean.substring(2, 4), 16),
                parseInt(clean.substring(4, 6), 16)
            ];
        }
        return fallback;
    }

    // Export PDF
    $('#btnPdf').on('click', function () {
        if (typeof jspdf === 'undefined') {
            alertSands("PDF library not loaded yet.", 'error');
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape', 'pt', 'a4');
        const ps = window.UTILIZATION_PRINT_SETTINGS || {};
        const accentRgb = hexToRgbArray(ps.accent_color, [27, 61, 148]);
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const marginX = 32;

        // Use master print settings logo or preloaded fallback
        let imgData = ps.logo_base64 || highResLogoBase64 || '';
        if (!imgData) {
            let logo = document.getElementById('companyLogo');
            if (logo) {
                let canvas = document.createElement('canvas');
                canvas.width = logo.naturalWidth || logo.width || 150;
                canvas.height = logo.naturalHeight || logo.height || 50;
                let ctx = canvas.getContext('2d');
                ctx.drawImage(logo, 0, 0, canvas.width, canvas.height);
                imgData = canvas.toDataURL('image/png');
                highResLogoRatio = canvas.width / canvas.height;
            }
        }
        let showLogo = Number(ps.show_logo !== undefined ? ps.show_logo : 1) === 1;
        let logoW = Math.min(130, Math.max(70, Number(ps.logo_width || 120) * 0.8));
        let logoH = logoW / (highResLogoRatio || 2.8);
        if (logoH > 46) {
            logoH = 46;
            logoW = logoH * (highResLogoRatio || 2.8);
        }

        // Extract filters for subtitle
        let compText = $('#filter_company option:selected').text();
        let vehText = $('#filter_vehicle option:selected').text();
        let dateFromRaw = $('#filter_from_date').val() || 'Start';
        let dateToRaw = $('#filter_to_date').val() || 'Now';

        function formatFilterDate(dateStr) {
            if (!dateStr || dateStr === 'Start' || dateStr === 'Now') return dateStr;
            let parts = dateStr.split('-');
            if (parts.length === 3 && parts[0].length === 4) {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const mIdx = parseInt(parts[1], 10) - 1;
                if (mIdx >= 0 && mIdx < 12) return `${parts[2]} ${months[mIdx]} ${parts[0]}`;
            }
            return dateStr;
        }

        let dateFrom = formatFilterDate(dateFromRaw);
        let dateTo = formatFilterDate(dateToRaw);

        let filterParts = [];
        if (compText && compText !== 'All Companies') filterParts.push('Company: ' + compText);
        if (vehText && vehText !== 'All Vehicles') filterParts.push('Vehicle: ' + vehText);
        filterParts.push(`Period: ${dateFrom} to ${dateTo}`);
        let filterString = filterParts.join('  |  ');

        function formatVehicleCellForPdf(td) {
            const divs = td.querySelectorAll(':scope > div');
            if (!divs.length) {
                return $(td).text().replace(/\s+/g, ' ').trim();
            }
            const lines = [];
            divs.forEach(function (div, divIdx) {
                const spans = div.querySelectorAll(':scope > span');
                const parts = [];
                if (spans.length) {
                    spans.forEach(function (sp) {
                        const txt = $(sp).text().replace(/\s+/g, ' ').trim();
                        if (txt) parts.push(txt);
                    });
                } else {
                    const txt = $(div).text().replace(/\s+/g, ' ').trim();
                    if (txt) parts.push(txt);
                }
                if (parts.length) {
                    lines.push(parts.join(divIdx === 0 ? '  ' : ' | '));
                }
            });
            return lines.join('\n');
        }

        // Prepare table data
        let rows = [];
        $('#utilizationReportTable tbody tr').each(function () {
            let row = [];
            let $tds = $(this).find('td');

            if ($tds.length === 1) {
                row.push({ content: $tds.text(), colSpan: 6, styles: { halign: 'center' } });
            } else {
                $tds.each(function (index) {
                    if (index === 5) {
                        row.push($(this).text().trim());
                    } else if (index === 0) {
                        row.push(formatVehicleCellForPdf(this));
                    } else {
                        row.push($(this).text().trim());
                    }
                });
            }
            rows.push(row);
        });

        doc.autoTable({
            head: [['Vehicle Details', 'Total Days', 'Days Rented Out', 'Days Maintenance', 'Days Idle', 'Utilization %']],
            body: rows,
            startY: 112,
            theme: 'grid',
            styles: {
                fontSize: 8.5,
                font: 'helvetica',
                cellPadding: 5,
                valign: 'middle',
                lineColor: [215, 222, 235],
                lineWidth: 0.4
            },
            headStyles: {
                fillColor: accentRgb,
                textColor: 255,
                fontStyle: 'bold'
            },
            columnStyles: {
                1: { halign: 'right' },
                2: { halign: 'right' },
                3: { halign: 'right' },
                4: { halign: 'right' },
                5: { halign: 'right', fontStyle: 'bold' }
            },
            alternateRowStyles: {
                fillColor: [248, 250, 253]
            },
            margin: { top: 96, left: marginX, right: marginX, bottom: 50 },
            didDrawPage: function (data) {
                // MASTER HEADER
                if (showLogo && imgData) {
                    try {
                        doc.addImage(imgData, 'PNG', marginX, 18, logoW, logoH);
                    } catch (e) {}
                }

                doc.setFont('helvetica', 'bold');
                doc.setFontSize(15);
                doc.setTextColor(accentRgb[0], accentRgb[1], accentRgb[2]);
                doc.text(String(ps.company_name || 'FAST LINK CAR RENTAL'), pageWidth / 2, 30, { align: 'center' });

                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9);
                doc.setTextColor(80, 90, 105);
                if (ps.header_subtitle) doc.text(String(ps.header_subtitle), pageWidth / 2, 43, { align: 'center' });
                if (ps.header_address) doc.text(String(ps.header_address), pageWidth / 2, 55, { align: 'center' });

                doc.setFontSize(8);
                let rightX = pageWidth - marginX;
                let rightY = 26;
                if (ps.header_phone) { doc.text('Tel: ' + String(ps.header_phone), rightX, rightY, { align: 'right' }); rightY += 11; }
                if (ps.header_email) { doc.text(String(ps.header_email), rightX, rightY, { align: 'right' }); rightY += 11; }
                if (ps.header_website) { doc.text(String(ps.header_website), rightX, rightY, { align: 'right' }); }

                doc.setDrawColor(accentRgb[0], accentRgb[1], accentRgb[2]);
                doc.setLineWidth(1.2);
                doc.line(marginX, 68, pageWidth - marginX, 68);

                if (data.pageNumber === 1) {
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(12);
                    doc.setTextColor(30, 41, 59);
                    doc.text("Vehicle Utilization Report", marginX, 88);

                    let d = new Date();
                    const mNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    let dateStr = "Generated on: " + ("0" + d.getDate()).slice(-2) + " " + mNames[d.getMonth()] + " " + d.getFullYear();
                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(8.5);
                    doc.setTextColor(100, 116, 139);
                    let metaRight = dateStr + (filterString ? ("  |  " + filterString) : "");
                    doc.text(metaRight, pageWidth - marginX, 88, { align: 'right' });
                } else {
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(10);
                    doc.setTextColor(71, 85, 105);
                    doc.text("Vehicle Utilization Report (Cont.)", marginX, 84);
                }

                // MASTER FOOTER
                let footerY = pageHeight - 28;
                doc.setDrawColor(203, 213, 225);
                doc.setLineWidth(0.6);
                doc.line(marginX, footerY - 10, pageWidth - marginX, footerY - 10);

                if (Number(ps.show_footer !== undefined ? ps.show_footer : 1) === 1) {
                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(8);
                    doc.setTextColor(71, 85, 105);
                    if (ps.footer_text) doc.text(String(ps.footer_text), marginX, footerY);
                    if (ps.footer_note) {
                        doc.setFontSize(7.5);
                        doc.setTextColor(120, 130, 145);
                        doc.text(String(ps.footer_note), marginX, footerY + 11);
                    }
                }

                let str = "Page " + doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') {
                    str = str + " of totalPages";
                }
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(8);
                doc.setTextColor(71, 85, 105);
                doc.text(str, pageWidth - marginX, footerY, { align: 'right' });
            }
        });

        if (typeof doc.putTotalPages === 'function') {
            doc.putTotalPages('totalPages');
        }

        window.open(doc.output('bloburl'), '_blank');
    });

})(jQuery);
