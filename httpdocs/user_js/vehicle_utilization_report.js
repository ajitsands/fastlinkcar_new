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

    // Export PDF
    $('#btnPdf').on('click', function () {
        if (typeof jspdf === 'undefined') {
            alertSands("PDF library not loaded yet.", 'error');
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape', 'pt', 'letter');
        
        // Use preloaded high-res logo
        let imgData = highResLogoBase64;
        let logoH = 40;
        let logoW = logoH * highResLogoRatio;
        
        // Fallback to navbar logo if high-res failed to load
        if (!imgData) {
            let logo = document.getElementById('companyLogo');
            if (logo) {
                let canvas = document.createElement('canvas');
                canvas.width = logo.naturalWidth || logo.width || 150;
                canvas.height = logo.naturalHeight || logo.height || 50;
                let ctx = canvas.getContext('2d');
                ctx.drawImage(logo, 0, 0, canvas.width, canvas.height);
                imgData = canvas.toDataURL('image/png');
                
                let ratio = canvas.width / canvas.height;
                logoH = 40;
                logoW = logoH * ratio;
            }
        }

        // Extract filters for subtitle
        let compText = $('#filter_company option:selected').text();
        let vehText = $('#filter_vehicle option:selected').text();
        let dateFromRaw = $('#filter_from_date').val() || 'Start';
        let dateToRaw = $('#filter_to_date').val() || 'Now';

        function formatFilterDate(dateStr) {
            if (!dateStr || dateStr === 'Start' || dateStr === 'Now') return dateStr;
            let parts = dateStr.split('-');
            if (parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            return dateStr;
        }

        let dateFrom = formatFilterDate(dateFromRaw);
        let dateTo = formatFilterDate(dateToRaw);

        let filterString = `Company: ${compText}  |  Vehicle: ${vehText}  |  Period: ${dateFrom} to ${dateTo}`;

        // Prepare table data
        let rows = [];
        $('#utilizationReportTable tbody tr').each(function () {
            let row = [];
            let $tds = $(this).find('td');
            
            if ($tds.length === 1) {
                // No data row
                row.push({ content: $tds.text(), colSpan: 6, styles: { halign: 'center' } });
            } else {
                $tds.each(function (index) {
                    if (index === 5) {
                        // For the progress bar column, just extract the text (e.g. 75%)
                        row.push($(this).text().trim());
                    } else if (index === 0) {
                         // Vehicle details - just get raw text, replace multiple newlines with single space
                        let text = $(this).text().replace(/\s+/g, ' ').trim();
                        row.push(text);
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
            startY: 145, // Start below the titles on page 1
            theme: 'grid',
            styles: { 
                fontSize: 9, 
                font: 'helvetica',
                cellPadding: 4,
                lineColor: [200, 200, 200],
                lineWidth: 0.1
            },
            headStyles: { 
                fillColor: [138, 28, 20],
                textColor: 255,
                fontStyle: 'bold'
            },
            alternateRowStyles: { 
                fillColor: [248, 249, 250] 
            },
            // Margin top applies to subsequent pages, so it starts just below the 80pt divider line
            margin: { top: 90, left: 42.5, right: 42.5, bottom: 40 },
            didDrawPage: function (data) {
                let pageWidth = doc.internal.pageSize.getWidth();
                
                // HEADER (Repeats on every page)
                // 1. Logo
                if (imgData) {
                    // Match PrintAgreement (width ~136pt)
                    doc.addImage(imgData, 'PNG', 42.5, 20, 136, 136 / highResLogoRatio);
                }
                
                // 2. Company Name Center
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(18);
                doc.setTextColor(0, 0, 0);
                doc.text("AA CAR RENTAL CO. W.L.L.", pageWidth / 2, 40, { align: 'center' });
                
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9);
                doc.text("Salmabad, Kingdom of Bahrain", pageWidth / 2, 55, { align: 'center' });
                
                // 3. Contact Info Right
                doc.setFontSize(8);
                let rightX = pageWidth - 42.5; 
                doc.text("Tel : +973 17300322", rightX, 32, { align: 'right' });
                doc.text("Fax : +973 17300311", rightX, 44, { align: 'right' });
                doc.text("info@aarentalbh.com", rightX, 56, { align: 'right' });
                
                // Divider Line
                doc.setDrawColor(180, 180, 180);
                doc.setLineWidth(1.1); 
                doc.line(42.5, 80, pageWidth - 42.5, 80);
                
                // Titles (Only on the first page, below the header, centered)
                if (data.pageNumber === 1) {
                    // Report Title
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.setTextColor(44, 62, 80);
                    doc.text("Vehicle Utilization Report", pageWidth / 2, 100, { align: 'center' });
                    
                    // Date & Filters
                    let d = new Date();
                    let day = ("0" + d.getDate()).slice(-2);
                    let month = ("0" + (d.getMonth() + 1)).slice(-2);
                    let year = d.getFullYear();
                    let dateStr = "Generated on: " + day + "/" + month + "/" + year;
                    
                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(9);
                    doc.setTextColor(100, 100, 100);
                    
                    // Left align Generated Date
                    doc.text(dateStr, 42.5, 120);
                    
                    // Right align Filters
                    if (filterString) {
                        doc.text("Filters: " + filterString, pageWidth - 42.5, 120, { align: 'right' });
                    }
                }
                
                // FOOTER
                let str = "Page " + doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') {
                    str = str + " of " + 'totalPages';
                }
                doc.setFontSize(8);
                let pageHeight = doc.internal.pageSize.getHeight();
                doc.text(str, pageWidth / 2, pageHeight - 15, { align: 'center' });
            }
        });

        if (typeof doc.putTotalPages === 'function') {
            doc.putTotalPages('totalPages');
        }

        window.open(doc.output('bloburl'), '_blank');
    });

})(jQuery);
