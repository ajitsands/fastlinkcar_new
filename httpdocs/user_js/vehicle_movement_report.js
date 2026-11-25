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

    // Export PDF
    $('#btnExportPDF').on('click', function () {
        let table = document.getElementById("movementReportTable");
        let tbody = table.querySelector("tbody");
        
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
            const doc = new jsPDF('l', 'pt', 'letter');
            let pageWidth = doc.internal.pageSize.getWidth();

            function formatFilterDate(dateStr) {
                if (!dateStr || dateStr === 'Start' || dateStr === 'Now') return dateStr;
                let parts = dateStr.split('-');
                if (parts.length === 3) {
                    return parts[2] + '/' + parts[1] + '/' + parts[0];
                }
                return dateStr;
            }

            let filterText = [];
            let comp = $("#filter_company option:selected").text();
            let veh = $("#filter_vehicle option:selected").text();
            if(comp !== "All Companies") filterText.push("Company: " + comp);
            if(veh !== "All Vehicles") filterText.push("Vehicle: " + veh);
            if($("#filter_from_date").val()) filterText.push("From: " + formatFilterDate($("#filter_from_date").val()));
            if($("#filter_to_date").val()) filterText.push("To: " + formatFilterDate($("#filter_to_date").val()));
            
            let filterString = filterText.join("  |  ");
            
            // Use preloaded high-res logo
            let imgData = highResLogoBase64;
            let logoH = 40;
            let logoW = logoH * highResLogoRatio;
            
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

            doc.autoTable({
                html: table,
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
                margin: { top: 90, left: 42.5, right: 42.5, bottom: 40 },
                didDrawPage: function (data) {
                    let pageWidth = doc.internal.pageSize.getWidth();
                    
                    // HEADER
                    if (imgData) {
                        doc.addImage(imgData, 'PNG', 42.5, 20, 136, 136 / highResLogoRatio);
                    }
                    
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(18);
                    doc.setTextColor(0, 0, 0);
                    doc.text("AA CAR RENTAL CO. W.L.L.", pageWidth / 2, 40, { align: 'center' });
                    
                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(9);
                    doc.text("Salmabad, Kingdom of Bahrain", pageWidth / 2, 55, { align: 'center' });
                    
                    doc.setFontSize(8);
                    let rightX = pageWidth - 42.5; 
                    doc.text("Tel : +973 17300322", rightX, 32, { align: 'right' });
                    doc.text("Fax : +973 17300311", rightX, 44, { align: 'right' });
                    doc.text("info@aarentalbh.com", rightX, 56, { align: 'right' });
                    
                    doc.setDrawColor(180, 180, 180);
                    doc.setLineWidth(1.1); 
                    doc.line(42.5, 80, pageWidth - 42.5, 80);
                    
                    // Titles (Only on the first page, below the header, centered)
                    if (data.pageNumber === 1) {
                        doc.setFont('helvetica', 'bold');
                        doc.setFontSize(14);
                        doc.setTextColor(44, 62, 80);
                        doc.text("Vehicle Movement Report", pageWidth / 2, 100, { align: 'center' });
                        
                        let d = new Date();
                        let day = ("0" + d.getDate()).slice(-2);
                        let month = ("0" + (d.getMonth() + 1)).slice(-2);
                        let year = d.getFullYear();
                        let dateStr = "Generated on: " + day + "/" + month + "/" + year;
                        
                        doc.setFont('helvetica', 'normal');
                        doc.setFontSize(9);
                        doc.setTextColor(100, 100, 100);
                        
                        doc.text(dateStr, 42.5, 120);
                        
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
