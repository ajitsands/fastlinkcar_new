$(document).ready(function () {
    let highResLogoBase64 = null;
    let highResLogoRatio = 1;

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

    // Default Date From / Date To to current month
    (function setDefaultMonthDates() {
        const now = new Date();
        const yyyy = now.getFullYear();
        const mm = String(now.getMonth() + 1).padStart(2, '0');
        const lastDay = String(new Date(yyyy, now.getMonth() + 1, 0).getDate()).padStart(2, '0');
        $('#filter_from_date').val(`${yyyy}-${mm}-01`);
        $('#filter_to_date').val(`${yyyy}-${mm}-${lastDay}`);
    })();

    // Initialize Select2
    $('.select2').select2();

    // Initialize Datepickers
    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true
    });

    // Load Companies based on user access
    $.ajax({
        url: '/VehicleMovementReportController',
        type: 'POST',
        data: { action: 'get_companies' },
        dataType: 'json',
        success: function (data) {
            let html = '<option value="">All Companies</option>';
            $.each(data, function (index, item) {
                html += `<option value="${item.ids}">${item.company_name}</option>`;
            });
            $('#filter_company').html(html);
            loadVehicles(); // Load vehicles initially
            loadReport();   // Load movement logs on page open
        }
    });

    // When Company changes, reload Vehicles
    $('#filter_company').on('change', function () {
        loadVehicles();
    });

    function loadVehicles() {
        let company_id = $('#filter_company').val();
        $.ajax({
            url: '/VehicleMovementReportController',
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

    let movementDT = null;

    // Load report data
    function loadReport() {
        let company_id = $('#filter_company').val();
        let vehicle_id = $('#filter_vehicle').val();
        let from_date = $('#filter_from_date').val();
        let to_date = $('#filter_to_date').val();

        $.ajax({
            url: '/VehicleMovementReportController',
            type: 'POST',
            data: {
                action: 'get_report',
                company_id: company_id,
                vehicle_id: vehicle_id,
                from_date: from_date,
                to_date: to_date
            },
            beforeSend: function () {
                if ($.fn.DataTable.isDataTable('#movementReportTable')) {
                    $('#movementReportTable').DataTable().destroy();
                    movementDT = null;
                }
                $('#movementReportTable tbody').html('<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary" role="status"></div></td></tr>');
            },
            success: function (data) {
                if ($.fn.DataTable.isDataTable('#movementReportTable')) {
                    $('#movementReportTable').DataTable().destroy();
                }
                $('#movementReportTable tbody').html(data);
                if (!String(data).includes('No movement logs found')) {
                    movementDT = $('#movementReportTable').DataTable({
                        pageLength: 20,
                        lengthMenu: [10, 20, 50, 100],
                        ordering: false,
                        autoWidth: false,
                        dom: '<"row align-items-center mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-md-end"f>>t<"row align-items-center mt-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
                    });
                }
            },
            error: function () {
                $('#movementReportTable tbody').html('<tr><td colspan="7" class="text-center text-danger">Error loading report</td></tr>');
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

    function formatVehicleCellForPdf(td) {
        const divs = td.querySelectorAll(':scope > div');
        if (!divs.length) {
            return cellHtmlToText(td.innerHTML);
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

    function cellHtmlToText(htmlStr) {
        return String(htmlStr || '')
            .replace(/<br\s*\/?>/gi, '\n')
            .replace(/<\/div>/gi, '\n')
            .replace(/<[^>]+>/g, '')
            .replace(/&amp;/g, '&')
            .replace(/&lt;/g, '<')
            .replace(/&gt;/g, '>')
            .replace(/&nbsp;/g, ' ')
            .replace(/\n{2,}/g, '\n')
            .trim();
    }

    // Export PDF
    $('#btnExportPDF').on('click', function () {
        let table = document.getElementById("movementReportTable");
        let tbody = table ? table.querySelector("tbody") : null;

        if (!tbody || tbody.innerHTML.includes("No movement logs found") || tbody.innerHTML.trim() === '') {
            setupDropdown('dropdownContent', 'error', svgError + "No data available to print", 'click');
            return;
        }

        if (typeof window.jspdf === 'undefined') {
            alert("PDF generator library failed to load. Please check your internet connection.");
            return;
        }

        try {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'pt', 'a4');
            const ps = window.MOVEMENT_PRINT_SETTINGS || {};
            const accentRgb = hexToRgbArray(ps.accent_color, [27, 61, 148]);
            const pageWidth = doc.internal.pageSize.getWidth();
            const pageHeight = doc.internal.pageSize.getHeight();
            const marginX = 32;

            function formatFilterDate(dateStr) {
                if (!dateStr) return '';
                const parts = dateStr.split('-');
                if (parts.length === 3 && parts[0].length === 4) {
                    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    const mIdx = parseInt(parts[1], 10) - 1;
                    if (mIdx >= 0 && mIdx < 12) return `${parts[2]} ${months[mIdx]} ${parts[0]}`;
                }
                return dateStr;
            }

            let filterText = [];
            let comp = $("#filter_company option:selected").text();
            let veh = $("#filter_vehicle option:selected").text();
            if (comp && comp !== "All Companies") filterText.push("Company: " + comp);
            if (veh && veh !== "All Vehicles") filterText.push("Vehicle: " + veh);
            if ($("#filter_from_date").val()) filterText.push("From: " + formatFilterDate($("#filter_from_date").val()));
            if ($("#filter_to_date").val()) filterText.push("To: " + formatFilterDate($("#filter_to_date").val()));
            let filterString = filterText.join("  |  ");

            let imgData = ps.logo_base64 || highResLogoBase64 || '';
            let showLogo = Number(ps.show_logo !== undefined ? ps.show_logo : 1) === 1;
            let logoW = Math.min(130, Math.max(70, Number(ps.logo_width || 120) * 0.8));
            let logoH = logoW / (highResLogoRatio || 2.8);
            if (logoH > 46) {
                logoH = 46;
                logoW = logoH * (highResLogoRatio || 2.8);
            }

            const headRow = ['Date & Time', 'Vehicle Details', 'Old Status', 'New Status & Details', 'Odometer', 'KM Used', 'User'];
            const bodyRows = [];
            const rowNodes = movementDT ? movementDT.rows({ search: 'applied' }).nodes().toArray() : Array.from(tbody.querySelectorAll('tr'));
            rowNodes.forEach(function(tr) {
                const tds = tr.querySelectorAll('td');
                if (tds.length >= 7) {
                    bodyRows.push([
                        cellHtmlToText(tds[0].innerHTML),
                        formatVehicleCellForPdf(tds[1]),
                        cellHtmlToText(tds[2].innerHTML),
                        cellHtmlToText(tds[3].innerHTML),
                        cellHtmlToText(tds[4].innerHTML),
                        cellHtmlToText(tds[5].innerHTML),
                        cellHtmlToText(tds[6].innerHTML)
                    ]);
                }
            });

            doc.autoTable({
                head: [headRow],
                body: bodyRows,
                startY: 122,
                theme: 'grid',
                styles: {
                    fontSize: 8.5,
                    font: 'helvetica',
                    cellPadding: 5,
                    valign: 'middle',
                    overflow: 'linebreak',
                    lineColor: [215, 222, 235],
                    lineWidth: 0.4
                },
                headStyles: {
                    fillColor: accentRgb,
                    textColor: 255,
                    fontStyle: 'bold',
                    halign: 'left'
                },
                columnStyles: {
                    0: { cellWidth: 95 },
                    1: { cellWidth: 165 },
                    2: { cellWidth: 72, halign: 'center' },
                    3: { cellWidth: 'auto' },
                    4: { cellWidth: 62, halign: 'right' },
                    5: { cellWidth: 55, halign: 'right' },
                    6: { cellWidth: 105 }
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
                        doc.text("Vehicle Movement Report", marginX, 88);

                        let d = new Date();
                        const mNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
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
                        doc.text("Vehicle Movement Report (Cont.)", marginX, 84);
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

                    let pageStr = "Page " + doc.internal.getNumberOfPages();
                    if (typeof doc.putTotalPages === 'function') pageStr += " of totalPages";
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(8);
                    doc.setTextColor(71, 85, 105);
                    doc.text(pageStr, pageWidth - marginX, footerY, { align: 'right' });
                }
            });
            doc.putTotalPages('totalPages');

            window.open(doc.output('bloburl'), '_blank');
        } catch (err) {
            console.error("PDF Error: ", err);
            alert("An error occurred while generating the PDF. Check console for details.");
        }
    });

    // Initial load
    loadReport();
});
