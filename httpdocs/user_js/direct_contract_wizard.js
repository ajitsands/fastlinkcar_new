let dcWizardObj = null;
let dcSelectedVehicles = [];
let dcCanvases = {};
let dcUploadedImages = {};
let dcCustomerDriverDocs = {};
let currentCustDriverDocVid = null;
let dcCurrentStep = 0;
let dcWizardInstance = null;

// Setup datepickers and select2 when the modal opens

function initScratchCanvas(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;
    const ctx = canvas.getContext("2d");
    
    // Set actual internal dimensions to match CSS dimensions to fix mouse offset
    canvas.width = canvas.offsetWidth || canvas.clientWidth || 600;
    canvas.height = canvas.offsetHeight || canvas.clientHeight || 250;
    
    ctx.strokeStyle = "black";
    ctx.lineWidth = 3;
    ctx.lineCap = "round";
    
    let isDrawing = false;
    
    const startDrawing = (e) => {
        isDrawing = true;
        draw(e);
    };
    
    const stopDrawing = () => {
        isDrawing = false;
        ctx.beginPath();
    };
    
    const draw = (e) => {
        if (!isDrawing) return;
        const rect = canvas.getBoundingClientRect();
        let clientX = e.clientX;
        let clientY = e.clientY;
        
        if (e.touches && e.touches.length > 0) {
            clientX = e.touches[0].clientX;
            clientY = e.touches[0].clientY;
            e.preventDefault();
        }
        
        const x = clientX - rect.left;
        const y = clientY - rect.top;
        
        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);
    };
    
    canvas.addEventListener("mousedown", startDrawing);
    canvas.addEventListener("mousemove", draw);
    canvas.addEventListener("mouseup", stopDrawing);
    canvas.addEventListener("mouseout", stopDrawing);
    
    canvas.addEventListener("touchstart", startDrawing, {passive: false});
    canvas.addEventListener("touchmove", draw, {passive: false});
    canvas.addEventListener("touchend", stopDrawing);
    
    return { canvas, ctx };
}

function clearCanvas(canvasId) {
    const canvasObj = dcCanvases[canvasId];
    if (canvasObj) {
        canvasObj.ctx.clearRect(0, 0, canvasObj.canvas.width, canvasObj.canvas.height);
    }
}

function buildDirectContractWizard(bookingDetails, vehicles) {
    dcSelectedVehicles = vehicles;
    dcCanvases = {}; // Reset canvases
    dcUploadedImages = {}; // Reset uploaded images
    
    const headerContainer = $('#dcWizardHeader');
    const contentContainer = $('#dcWizardContent');
    
    headerContainer.empty();
    contentContainer.empty();
    
    // 1. Customer & Summary Tab
    headerContainer.append(`
        <div class="step" data-target="#tab-dc-customer">
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-user-line"></i></span>
                <span class="bs-stepper-label"><span class="bs-stepper-title">Summary</span></span>
            </button>
        </div>
    `);
    
    const customerTpl = document.getElementById('dc-tpl-customer').innerHTML;
    contentContainer.append(customerTpl);
    
    // Populate customer tab
    $('#dc_c_name').text(bookingDetails.customerName);
    $('#dc_c_code').text(bookingDetails.customerCode || '-');
    $('#dc_c_mobile').text($('#customerPhone').val() || '-');
    $('#dc_c_email').text($('#customerEmail').val() || '-');
    $('#dc_c_cpr').text($('#customercprcr').val() || '-');
    
    // Force DD-MMM-YYYY format for the modal as requested
    let sysFormat = 'DD-MMM-YYYY';
    
    function formatMyDate(dStr) {
        if(!dStr) return '-';
        // Parse with multiple common formats using dayjs
        let d = dayjs(dStr, ["YYYY-MM-DD HH:mm", "YYYY-MM-DD", "DD-MM-YYYY HH:mm", "DD-MM-YYYY", "DD-MMM-YYYY HH:mm", "DD/MM/YYYY HH:mm"], true);
        if(!d.isValid()) {
            // fallback non-strict
            d = dayjs(dStr);
        }
        if(d.isValid()) {
            console.log("formatMyDate: Parsed successfully. Input:", dStr, "sysFormat:", sysFormat, "Output:", d.format(sysFormat + ' HH:mm'));
            return d.format(sysFormat + ' HH:mm');
        }
        console.log("formatMyDate: Failed to parse.", dStr);
        return dStr;
    }

    let fDate = formatMyDate(bookingDetails.fromDate);
    let tDate = formatMyDate(bookingDetails.toDate);
    
    $('#dc_b_from_date').text(fDate);
    $('#dc_b_to_date').text(tDate);
    
    $('#dc_b_service').text(bookingDetails.service);
    $('#dc_b_duration_type').text(bookingDetails.duration + ' / ' + bookingDetails.rateType);
    $('#dc_b_unit_price').text(bookingDetails.unitPrice);
    $('#dc_b_min_price').text(bookingDetails.minPrice);
    $('#dc_b_vat_perc').text(bookingDetails.vatPerc);
    $('#dc_b_vat_amt').text(bookingDetails.vatAmt);
    $('#dc_b_total').text(bookingDetails.total);
    $('#dc_b_notes').text(bookingDetails.notes || '-');
    $('#dc_b_vehicles').text(vehicles.length);
    
    // For Model of vehicle, grab from the first vehicle or show 'Multiple'
    let modelName = vehicles.length > 0 ? vehicles[0].modelName : '-';
    if(vehicles.length > 1) modelName += ' (+' + (vehicles.length - 1) + ' more)';
    $('#dc_b_model').text(modelName);
    
    function formatMyDateOnly(dStr) {
        if(!dStr || dStr === '-') return '-';
        let d = dayjs(dStr, ["YYYY-MM-DD", "DD-MM-YYYY", "DD-MMM-YYYY", "DD/MM/YYYY"], true);
        if(!d.isValid()) {
            d = dayjs(dStr);
        }
        if(d.isValid()) {
            return d.format('DD-MMM-YYYY');
        }
        return dStr;
    }

    // 2. Vehicle Tabs
    vehicles.forEach((v, index) => {
        headerContainer.append(`<div class="line"></div>`);
        headerContainer.append(`
            <div class="step" data-target="#tab-dc-vehicle-${v.id}">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle"><i class="ri-car-line"></i></span>
                    <span class="bs-stepper-label"><span class="bs-stepper-title">Car ${index + 1}</span></span>
                </button>
            </div>
        `);
        
        let vehicleTpl = document.getElementById('dc-tpl-vehicle').innerHTML;
        
        let imagesArray = v.vehicleImages;
        if (typeof imagesArray === 'string') {
            try { imagesArray = JSON.parse(imagesArray); } catch(e) { imagesArray = []; }
        }
        if (!Array.isArray(imagesArray)) imagesArray = [];
        imagesArray = imagesArray.filter(img => img && img !== "default.jpg");
        
        let imageContent = '';
        if (imagesArray.length > 1) {
            let innerHtml = '';
            imagesArray.forEach((img, idx) => {
                let active = idx === 0 ? 'active' : '';
                innerHtml += `<div class="carousel-item ${active}"><img src="uploads/vehicleImages/${img}" class="img-fluid rounded mb-1 d-block w-100" style="max-height: 150px; object-fit: contain;" alt="Vehicle"></div>`;
            });
            imageContent = `
                <div id="v_carousel_${v.id}" class="carousel slide" data-bs-ride="carousel" style="width: 100%;">
                    <div class="carousel-inner">${innerHtml}</div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#v_carousel_${v.id}" data-bs-slide="prev" style="background: rgba(0,0,0,0.2); border-radius: 5px; margin: 2px;">
                        <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 1.5rem; height: 1.5rem;"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#v_carousel_${v.id}" data-bs-slide="next" style="background: rgba(0,0,0,0.2); border-radius: 5px; margin: 2px;">
                        <span class="carousel-control-next-icon" aria-hidden="true" style="width: 1.5rem; height: 1.5rem;"></span>
                    </button>
                </div>
            `;
        } else {
            let singleImg = (imagesArray.length === 1) ? ('uploads/vehicleImages/' + imagesArray[0]) : ((v.vehicleImage && v.vehicleImage !== '' && v.vehicleImage !== 'default.jpg' && v.vehicleImage !== '[]') ? ('uploads/vehicleImages/' + v.vehicleImage) : 'uploads/vehicleImages/default.jpg');
            imageContent = `<img src="${singleImg}" id="v_image_${v.id}" alt="Vehicle" class="img-fluid rounded mb-1" style="max-height: 150px; object-fit: contain; width: 100%;" onerror="this.onerror=null;this.src='uploads/vehicleImages/default.jpg';">`;
        }

        vehicleTpl = vehicleTpl.replace(/{ID}/g, v.id)
                               .replace(/{IMAGE_CONTENT}/g, imageContent)
                               .replace(/{MODEL}/g, v.modelName || 'Unknown')
                               .replace(/{PLATE}/g, v.vehicleNumber || v.vehicleNo || 'Unknown')
                               .replace(/{CHASSIS}/g, v.chassisNumber || 'Unknown')
                               .replace(/{CATEGORY}/g, v.categoryName || 'Unknown')
                               .replace(/{ODO}/g, '')
                               .replace(/{COLOR}/g, v.vehicleColor || v.color || '-')
                               .replace(/{YEAR}/g, v.vehicleYear || v.year || '-')
                               .replace(/{INSURANCE}/g, formatMyDateOnly(v.insuranceExpiry || v.insurance_expiry_date))
                               .replace(/{PASSING}/g, formatMyDateOnly(v.passingExpiry || v.passing_expiry_date));

                               
        contentContainer.append(vehicleTpl);
        
        // Auto-populate Rentout Time to current date time
        let now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        let currentDateTime = now.toISOString().slice(0, 16);
        $(`#dt_out_${v.id}`).val(currentDateTime);
        
        // Fetch latest odometer reading from tbl_vehicle_log_movement
        $.ajax({
            url: '/controller/VehicleContractGeneration/getLatestOdometer.php',
            type: 'POST',
            data: { vehicle_id: v.id },
            dataType: 'json',
            success: function(res) {
                if (res && res.status === 'success' && res.odometer !== '') {
                    $(`#km_out_${v.id}`).val(res.odometer);
                }
            }
        });
        
        // Show driver section if service is Rental with Driver (not without driver)
        let svc = bookingDetails.service ? bookingDetails.service.toLowerCase() : '';
        if (svc.includes('driver') && !svc.includes('without')) {
            $(`#assign_company_driver_section_${v.id}`).show();
        } else {
            $(`#assign_company_driver_section_${v.id}`).hide();
        }
        
        // Populate company driver dropdown for this vehicle
        let dropdownId = `#dropdownContainer_${v.id}`;
        $(dropdownId).html(`
            <div class="text-center p-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <div class="mt-2" style="font-size:10px;">Loading Driver...</div>
            </div>
        `);
        $.ajax({
            url: '/LoadDriverSelect',
            type: 'GET',
            success: function (response) {
                // Because response might contain an element with id="driverSelect", 
                // we should replace it to ensure uniqueness or just find it contextually.
                // The backend returns a select with id="driverSelect".
                // Wrap in a div to safely use .find()
                let tempDiv = $('<div>').html(response);
                let sel = tempDiv.find('select');
                if(sel.length === 0) sel = tempDiv.filter('select'); // fallback
                
                sel.attr('id', 'driverSelect_' + v.id)
                   .addClass('company-driver-select')
                   .attr('data-vid', v.id);
                   
                $(dropdownId).html(sel);

                $('#driverSelect_' + v.id).select2({
                    placeholder: "Select Driver",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#directContractWizardModal')
                });
            },
            error: function () {
                $(dropdownId).html(`<div class="text-center text-danger" style="font-size:11px;">Error loading</div>`);
            }
        });
        
    });
    
    // Bind Company Driver select changes
    $(document).on('change', '.company-driver-select', function() {
        let vid = $(this).data('vid');
        let selected = $(this).find(':selected');
        
        let driver_name = selected.text();
        let val = selected.val();

        if (val && val != '0' && val != '') {
            let contat_number = selected.data('id');
            let licenseNo = selected.data('license_no');
            let licensePlace = selected.data('license_place');
            let licenseIssue = selected.data('license_id');
            let licenseExpiry = selected.data('license_ed');
            let documents = selected.data('documents');

            $(`#company_driver_details_container_${vid}`).show();
            
            $(`#d_name_${vid}`).text(driver_name || '-');
            $(`#d_mobile_${vid}`).text(contat_number || '-');
            $(`#d_license_no_${vid}`).text(licenseNo || '-');
            $(`#d_license_issue_place_${vid}`).text(licensePlace || '-');
            $(`#d_licenseissueDate_${vid}`).text(licenseIssue || '-');
            $(`#d_licenseexpiryDate_${vid}`).text(licenseExpiry || '-');
            
            // populate `#company_driver_docs_preview`
            let docsPreview = $(`#company_driver_docs_preview_${vid}`);
            let docsContainer = $(`#company_driver_docs_container_${vid}`);
            
            docsPreview.empty();
            
            let docsArr = [];
            if (documents) {
                if (typeof documents === "string") {
                    try { 
                        let parsed = JSON.parse(documents); 
                        if (typeof parsed === "string") {
                            parsed = JSON.parse(parsed);
                        }
                        if (parsed && parsed.vehicles && Array.isArray(parsed.vehicles)) {
                            parsed.vehicles.forEach(item => {
                                if (item.files && Array.isArray(item.files)) {
                                    item.files.forEach(file => {
                                        docsArr.push({
                                            title: item.documentName || "Document",
                                            file: file
                                        });
                                    });
                                }
                            });
                        } else if (Array.isArray(parsed)) {
                            parsed.forEach(file => {
                                docsArr.push({
                                    title: "Document",
                                    file: file
                                });
                            });
                        }
                    } catch(e) {}
                }
            }
            
            if (docsArr && docsArr.length > 0) {
                docsContainer.show();
                let html = '';
                let carouselHtml = '';
                docsArr.forEach((doc, idx) => {
                    let docPath = doc.file.includes("http") ? doc.file : ("/" + doc.file);
                    html += `
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-sm pull-up company-driver-doc-img-dc" data-vid="${vid}" data-index="${idx}" title="${doc.title}" style="cursor:pointer;">
                            <img src="${docPath}" alt="${doc.title}" class="rounded-circle" onerror="this.src='/assets/img/icons/misc/doc.png'">
                        </li>
                    `;
                    let activeClass = idx === 0 ? "active" : "";
                    carouselHtml += `
                        <div class="carousel-item ${activeClass}">
                            <div class="bg-light text-center py-2 fw-bold text-dark border-bottom mb-2">${doc.title}</div>
                            <img src="${docPath}" class="d-block w-100" style="max-height:500px;object-fit:contain;" alt="${doc.title}">
                        </div>
                    `;
                });
                docsPreview.html(html);
                docsPreview.data('carousel-html', carouselHtml);
                // Initialize tooltips for dynamically added elements
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            } else {
                docsContainer.hide();
            }
        } else {
            $(`#company_driver_details_container_${vid}`).hide();
            $(`#d_name_${vid}`).text('');
            $(`#d_mobile_${vid}`).text('');
            $(`#d_license_no_${vid}`).text('');
            $(`#d_license_issue_place_${vid}`).text('');
            $(`#d_licenseissueDate_${vid}`).text('');
            $(`#d_licenseexpiryDate_${vid}`).text('');
            $(`#d_cpr_${vid}`).text('');
            $(`#company_driver_docs_container_${vid}`).hide();
            $(`#company_driver_docs_preview_${vid}`).html('');
        }
    });
    
    $(document).on('click', '.company-driver-doc-img-dc', function() {
        let vid = $(this).data('vid');
        let index = $(this).data('index');
        let carouselHtml = $(`#company_driver_docs_preview_${vid}`).data('carousel-html');
        
        $('#driverDocCarouselInner').html(carouselHtml);
        
        // Manually set the active slide to avoid Bootstrap initialization bugs
        $('#driverDocCarouselInner .carousel-item').removeClass('active');
        $('#driverDocCarouselInner .carousel-item').eq(index).addClass('active');
        
        $('#companyDriverDocSliderModal').modal('show');
    });
    
    $(document).on('click', '[id^="btn_clear_driver_"]', function() {
        let vid = $(this).attr('id').replace('btn_clear_driver_', '');
        $('#driverSelect_' + vid).val(null).trigger('change');
    });
    // 3. Terms Tab
    headerContainer.append(`<div class="line"></div>`);
    headerContainer.append(`
        <div class="step" data-target="#tab-dc-terms">
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-file-text-line"></i></span>
                <span class="bs-stepper-label"><span class="bs-stepper-title">Terms</span></span>
            </button>
        </div>
    `);
    contentContainer.append(document.getElementById('dc-tpl-terms').innerHTML);
    
    // Load Default Terms
    loadDcDefaultTerms();
    
    // 4. Signatures Tab
    headerContainer.append(`<div class="line"></div>`);
    headerContainer.append(`
        <div class="step" data-target="#tab-dc-signatures">
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-quill-pen-line"></i></span>
                <span class="bs-stepper-label"><span class="bs-stepper-title">Signatures</span></span>
            </button>
        </div>
    `);
    contentContainer.append(document.getElementById('dc-tpl-signatures').innerHTML);
    
    // Bind Clear Canvas events
    
    $('#dc_btnClearHirer_wizard').on('click', () => clearCanvas('dc_hirerCanvas_wizard'));
    $('#dc_btnClearDelivery_wizard').on('click', () => clearCanvas('dc_deliveryCanvas_wizard'));
    
    // Initialize Stepper
    const stepperEl = document.getElementById('dcWizard');
    if (dcWizardObj) {
        dcWizardObj.destroy();
    }
    dcWizardObj = new Stepper(stepperEl, {
        linear: false,
        animation: true
    });
    
    // Fix image dimensions before init canvases
    setTimeout(() => {
        dcCanvases['dc_hirerCanvas_wizard'] = initScratchCanvas('dc_hirerCanvas_wizard');
        dcCanvases['dc_deliveryCanvas_wizard'] = initScratchCanvas('dc_deliveryCanvas_wizard');
        
        // Auto-populate signature names
        if ($('#dc_hirer_name_wizard').length) {
            $('#dc_hirer_name_wizard').val(bookingDetails.customerName || '');
        }
        if ($('#dc_delivery_name_wizard').length && typeof SYSTEM_LOGGED_IN_USER !== 'undefined') {
            $('#dc_delivery_name_wizard').val(SYSTEM_LOGGED_IN_USER);
        }
    }, 500);
}

function loadDcDefaultTerms() {
    $('#dc_selected_term_title_label').html('<div class="spinner-border spinner-border-sm text-secondary" role="status"></div> Loading...');
    $.ajax({
        url: "/VehicleContractGeneration",
        type: "POST",
        contentType: "application/json",
        dataType: "json",
        data: JSON.stringify({
            action: "LoadTermsCondition"
        }),
        success: function(response) {
            if (response && response.data && Array.isArray(response.data)) {
                let defaultTerm = response.data.find(t => t.is_default == '1');
                if (defaultTerm) {
                    $('#dc-full-editor-onbody').html(defaultTerm.terms_condition);
                    $('#dc_selected_term_title_label').text(defaultTerm.t_c_name || 'Default Term');
                } else {
                    $('#dc-full-editor-onbody').html('');
                    $('#dc_selected_term_title_label').text('No Default Term Set');
                }
            } else {
                $('#dc-full-editor-onbody').html('');
                $('#dc_selected_term_title_label').text('No Terms Available');
            }
        },
        error: function() {
            $('#dc_selected_term_title_label').text('Error loading terms');
        }
    });
}

$(document).on('change', 'input[name="dc_terms_option"]', function() {
    let option = $(this).val();
    if (option === 'custom') {
        $('#dc_selected_term_type_label').text('Custom Term');
        $('#dc_selected_term_title_label').text('Custom Configuration');
        
        if($.fn.DataTable.isDataTable('#termsTable')){
            $('#termsTable').DataTable().ajax.reload(null, false);
        } else {
            initTermsTable();
        }
        
        if (typeof fullEditor !== 'undefined' && fullEditor !== null) {
            fullEditor.root.innerHTML = '';
        }
        $('#t_c_name').val('');
        $('#termsAndConditionModal').modal('show');
        
    } else if (option === 'default') {
        $('#dc_selected_term_type_label').text('Default Term');
        loadDcDefaultTerms();
    }
});

$(document).on('click', '#dc_btn_terms_condition', function() {
    $('#dc_terms_custom').prop('checked', true).trigger('change');
});

// Manage Terms Modal Logic
function initTermsTable() {
    $('#termsTable').DataTable({
        ajax: {
            url: "/VehicleContractGeneration",
            type: "POST",
            contentType: "application/json",
            data: function () {
                return JSON.stringify({ action: "LoadTermsCondition" });
            },
            dataSrc: "data"
        },
        processing: true,
        serverSide: false,
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
                orderable: false
            },
            { data: "t_c_name" },
            {
                data: "terms_condition",
                className: "description"
            },
            {
                data: null,
                render: function(data, type, row) {
                    let isChecked = row.is_default == '1' ? 'checked' : '';
                    return `
                        <div class="form-check form-switch text-center">
                            <input class="form-check-input term-default-switch" type="checkbox" role="switch" data-id="${row.ids}" ${isChecked}>
                        </div>
                    `;
                },
                orderable: false
            },
            {
                data: null,
                render: function(data, type, row){
                    return `
                        <i class="ri ri-delete-bin-line text-danger deleteRowTermsCondition"
                           style="cursor:pointer; font-size:1.5rem;"
                           data-id="${row.ids}">
                        </i>
                    `;
                },
                orderable: false
            },
            {
                data: null,
                render: function(data, type, row){
                    return `
                        <i class="ri ri-pencil-line text-primary editRowTermsCondition"
                           style="cursor:pointer; font-size:1.5rem;"
                           data-id="${row.ids}">
                        </i>
                    `;
                },
                orderable: false
            }
        ]
    });
}

$(document).on('click', '#saveTermsAndConditions', function () {
    var laddaBtn = Ladda.create(document.querySelector('#saveTermsAndConditions'));
    laddaBtn.start();
    let htmlContentTC = (typeof fullEditor !== 'undefined' && fullEditor !== null) ? fullEditor.root.innerHTML : '';

    $.ajax({
        url: "/VehicleContractGeneration",
        type: "POST",
        contentType: "application/json",
        dataType: "json",
        data: JSON.stringify({
            action: 'SaveTermsCondition',
            terms_condition: htmlContentTC,
            t_c_name: $('#t_c_name').val()
        }),
        success: function (response) {
            setupDropdown('dropdownContent', 'success', svgSuccess + ' Terms & Condition Saved Successfully', 'click');
            laddaBtn.stop();
            if($.fn.DataTable.isDataTable('#termsTable')) $('#termsTable').DataTable().ajax.reload(null, false);
        },
        error: function () {
            setupDropdown('dropdownContent', 'danger', svgError + ' Error saving data', 'click');
            laddaBtn.stop();
        }
    });
});

let varDeleteTC = null;
$(document).on("click", ".deleteRowTermsCondition", function() {
    varDeleteTC = $(this).data("id");
    SaNDSAlert('Are you sure you want to delete this entry?','DeleteTermsDC','danger','#C70039','Yes, I am sure');
});

// Use event delegation for the popup buttons
$(document).on('click', '.popup-buttons button', function() {
    var popupOverlay = document.getElementById('popupOverlay');
    var popupContainer = document.getElementById('popupContainer');
    
    // Hide popup
    if (popupOverlay) popupOverlay.style.display = 'none';
    if (popupContainer) popupContainer.style.display = 'none';
    
    if ($(this).hasClass('ok')) {
        var switchData = $('#message_matter').attr('data-switch-values');
        if (switchData === 'DeleteTermsDC') {
            $.ajax({
                url: "/VehicleContractGeneration",
                type: "POST",
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({ tc_ids: varDeleteTC, action: "deleteTermsCondition" }),
                success: function(res) {
                    if (res.status === true) {
                        setupDropdown('dropdownContent', 'success', svgSuccess + 'Deleted successfully', 'click');
                        if($.fn.DataTable.isDataTable('#termsTable')) $('#termsTable').DataTable().ajax.reload(null, false);
                    } else {
                        setupDropdown('dropdownContent', 'error', svgError + res.message, 'click');
                    }
                },
                error: function() {
                    setupDropdown('dropdownContent', 'error', svgError + 'Server error', 'click');
                }
            });
        }
    } else if ($(this).hasClass('cancel')) {
        var switchData = $('#message_matter').attr('data-switch-values');
        if (switchData === 'DeleteTermsDC') {
            setupDropdown('dropdownContent','error',svgSuccess+'Action canceled!','click');
        }
    }
});

$(document).on("click", ".editRowTermsCondition", function() {
    var editTCId = $(this).data("id");

    $.ajax({
        url: "/VehicleContractGeneration",
        type: "POST",
        contentType: "application/json",
        dataType: "json",
        data: JSON.stringify({ action: "LoadTermsConditionToEditor", tc_ids: editTCId }),
        success: function (response) {
            if (response.status === true) {
                $('#t_c_name').val(response.title || '');
                if (typeof fullEditor !== 'undefined' && fullEditor !== null) {
                    fullEditor.root.innerHTML = response.html;
                }
                setupDropdown('dropdownContent', 'success', svgSuccess + ' Loaded Successfully', 'click');
            }
        },
        error: function(xhr) {
            setupDropdown('dropdownContent', 'danger', svgError + ' Error loading data', 'click');
        }
    });
});

$(document).on('change', '.term-default-switch', function() {
    let tcId = $(this).data('id');
    let isChecked = $(this).is(':checked') ? 1 : 0;
    
    $.ajax({
        url: "/VehicleContractGeneration",
        type: "POST",
        contentType: "application/json",
        dataType: "json",
        data: JSON.stringify({
            action: 'SetDefaultTerm',
            tc_id: tcId,
            is_default: isChecked
        }),
        success: function(response) {
            if (response.status) {
                setupDropdown('dropdownContent', 'success', svgSuccess + ' Default term updated', 'click');
                if($.fn.DataTable.isDataTable('#termsTable')) $('#termsTable').DataTable().ajax.reload(null, false);
            } else {
                setupDropdown('dropdownContent', 'error', svgError + response.message, 'click');
            }
        }
    });
});

$(document).on('click', '#copyTCBtn', function () {
    if (typeof fullEditor !== 'undefined' && fullEditor !== null) {
        var content = fullEditor.root.innerHTML;
        var t_name = $('#t_c_name').val() || 'Custom Term';
        $('#dc-full-editor-onbody').html(content);
        $('#dc_selected_term_title_label').text(t_name);
        $('#termsAndConditionModal').modal('hide');
    }
});

$(document).on('change', '.dc-car-images', function(e) {
    let vid = $(this).data('vid');
    let files = e.target.files;
    if (!files.length) return;
    
    if (!dcUploadedImages[vid]) dcUploadedImages[vid] = [];
    
    // Show loader in preview
    $(`#preview_${vid}`).append('<div class="spinner-border spinner-border-sm text-primary dc-loader" role="status"></div>');
    
    let formData = new FormData();
    Array.from(files).forEach(file => {
        formData.append('car_images[]', file);
    });
    
    $.ajax({
        url: '/CompressUploadImage',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            $(`#preview_${vid} .dc-loader`).remove();
            
            if (res.files && res.files.length > 0) {
                res.files.forEach(filename => {
                    dcUploadedImages[vid].push(filename);
                    
                    let id = Date.now() + Math.random();
                    $(`#preview_${vid}`).append(`
                        <div class="position-relative dc-preview-item" id="img-${id.toString().replace('.','')}" data-file="${filename}">
                            <img src="/uploads/rentvehicleImages/${filename}" class="rounded border dc-rentout-img-preview" style="width:80px;height:80px;object-fit:cover;cursor:pointer;">
                            <span class="delete-img-vehicle-dc" data-vid="${vid}" data-id="${id.toString().replace('.','')}" data-file="${filename}"
                                style="position:absolute; top:-5px; right:-5px; background:red; color:white; border-radius:50%; padding:2px 6px; cursor:pointer; font-size:12px;">
                                ✕
                            </span>
                        </div>
                    `);
                });
            }
        },
        error: function() {
            $(`#preview_${vid} .dc-loader`).remove();
            alert('Error uploading images');
        }
    });
    
    $(this).val('');
});

$(document).on('click', '.delete-img-vehicle-dc', function() {
    let vid = $(this).data('vid');
    let filename = $(this).data('file');
    let id = $(this).data('id');
    
    $(`#img-${id}`).remove();
    if (dcUploadedImages[vid]) {
        dcUploadedImages[vid] = dcUploadedImages[vid].filter(f => f !== filename);
    }
});

$(document).on('click', '.dc-rentout-img-preview', function() {
    let src = $(this).attr('src');
    
    // Create the modal if it doesn't exist
    if ($('#rentoutImagePreviewModal').length === 0) {
        $('body').append(`
            <div class="modal fade" id="rentoutImagePreviewModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header custom-modal-header bg-danger">
                            <h5 class="modal-title mb-0 text-white">Image Preview</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center p-3">
                            <img id="rentoutImagePreviewModalImg" src="" class="img-fluid rounded" style="max-height: 80vh;">
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
    
    $('#rentoutImagePreviewModalImg').attr('src', src);
    $('#rentoutImagePreviewModal').modal('show');
});

// --- Customer Driver Documents Upload Logic ---
$(document).on('click', '.openAddCustDriverDocModal', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    currentCustDriverDocVid = $(this).data('vid');
    
    // Reset modal state
    $('#rentCustDriverImageName').val('');
    $('#rentCustDriverImage_document').val('');
    $('#uploadrentCustDriverImageDocumentProgress').css('width', '0%').text('0%');
    $('#uploadrentCustDriverImageDocumentStatus').html('');
    $('#rentCustDriverImage_upload_status').html('');
    
    $('#addRentalCustDriverImageModal').modal('show');
});

$(document).on('click', '#addrentCarImageButton', function(e) {
    // Unbind any previous clicks to prevent double submission since this is a global modal button
    e.preventDefault();
    
    let docName = $('#rentCustDriverImageName').val().trim();
    let fileInput = $('#rentCustDriverImage_document')[0];
    
    if (!docName) {
        alert('Please enter document name');
        return;
    }
    if (!fileInput.files.length) {
        alert('Please select a file');
        return;
    }
    
    let formData = new FormData();
    formData.append('foldername', 'custDriverDocs');
    formData.append('documentType', docName);
    
    Array.from(fileInput.files).forEach(file => {
        formData.append('files[]', file);
    });
    
    $('#uploadrentCustDriverImageDocumentProgress').css('width', '0%').text('0%');
    $('#rentCustDriverImage_upload_status').html('Uploading...');
    $('#rentCustDriverImage_loader_spinner').show();
    
    $.ajax({
        url: '/UploadDocumentsCompressed',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        xhr: function() {
            let xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    let percent = Math.round((e.loaded / e.total) * 100);
                    $('#uploadrentCustDriverImageDocumentProgress').css('width', percent + '%').text(percent + '%');
                }
            }, false);
            return xhr;
        },
        success: function(res) {
            $('#rentCustDriverImage_loader_spinner').hide();
            if (res && res.status === 'success') {
                $('#rentCustDriverImage_upload_status').html('<span class="text-success">Uploaded Successfully</span>');
                
                if (!dcCustomerDriverDocs[currentCustDriverDocVid]) {
                    dcCustomerDriverDocs[currentCustDriverDocVid] = [];
                }
                
                // Add to our payload state
                if (res.data && res.data.length > 0) {
                    res.data.forEach(item => {
                        let fileUrl = (item.type === 'image') ? item.webp : item.file;
                        
                        dcCustomerDriverDocs[currentCustDriverDocVid].push({
                            name: docName,
                            file: fileUrl
                        });
                        
                        // Render preview in the specific vehicle's container
                        let ext = fileUrl.split('.').pop().toLowerCase();
                        let iconPath = '/assets/icons/file.png';
                        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
                            iconPath = '/' + fileUrl;
                        } else if (ext === 'pdf') iconPath = '/assets/icons/pdf.png';
                        else if (['doc','docx'].includes(ext)) iconPath = '/assets/icons/word.png';
                        else if (['xls','xlsx'].includes(ext)) iconPath = '/assets/icons/excel.png';
                        
                        let id = Date.now() + Math.random();
                        $(`#contractcustdriverdocpreview_${currentCustDriverDocVid}`).append(`
                            <li class="avatar avatar-xl dc-cust-doc-item pull-up" style="position:relative; margin-right:10px; cursor:pointer;" data-file="${fileUrl}" data-name="${docName}" data-vid="${currentCustDriverDocVid}" id="custdoc-${id.toString().replace('.','')}">
                                <img src="${iconPath}" alt="${docName}" class="rounded-circle dc-cust-doc-preview-img" style="object-fit:cover;" title="${docName}">
                            </li>
                        `);
                    });
                }
                
                setTimeout(() => {
                    $('#addRentalCustDriverImageModal').modal('hide');
                }, 800);
            } else {
                $('#rentCustDriverImage_upload_status').html('<span class="text-danger">Upload failed</span>');
            }
        },
        error: function() {
            $('#rentCustDriverImage_loader_spinner').hide();
            $('#rentCustDriverImage_upload_status').html('<span class="text-danger">Upload error</span>');
        }
    });
});

let currentDCCustDocPreviewLi = null;

$(document).on('click', '.dc-cust-doc-item', function(e) {
    e.stopPropagation();
    currentDCCustDocPreviewLi = $(this);
    let fileUrl = '/' + $(this).data('file');
    let ext = fileUrl.split('.').pop().toLowerCase();
    
    let html = '';
    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
        html = `<img src="${fileUrl}" class="img-fluid rounded" style="max-height:70vh;">`;
    } else if (ext === 'pdf') {
        html = `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
    } else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
        html = `<iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true" width="100%" height="600px" style="border:none;"></iframe>`;
    } else {
        html = `<div class="alert alert-warning">Preview not available.<br><a href="${fileUrl}" target="_blank" class="btn btn-primary mt-2">Download File</a></div>`;
    }
    
    $('#filePreviewBody').html(html);
    
    // Setup delete button handler uniquely for this preview
    $('#deletePreviewImageBtn').off('click').on('click', function() {
        if (!currentDCCustDocPreviewLi) return;
        
        let file = currentDCCustDocPreviewLi.data('file');
        let vid = currentDCCustDocPreviewLi.data('vid');
        
        // Remove from our payload state
        if (dcCustomerDriverDocs[vid]) {
            dcCustomerDriverDocs[vid] = dcCustomerDriverDocs[vid].filter(doc => doc.file !== file);
        }
        
        currentDCCustDocPreviewLi.remove();
        $('#filePreviewModal').modal('hide');
        currentDCCustDocPreviewLi = null;
    });
    
    $('#filePreviewModal').modal('show');
});

// --- End Customer Driver Documents Upload Logic ---

function gatherDirectContractData() {
    let payload = {
        action: 'GenerateDirectContracts',
        customer_code: $('#customer_code').val(),
        customer_name: $('#customerName').val(),
        company_id: $('#reservationCompanySelect').val(),
        booking_details: {
            fromDate: $('.from_datetime').val(),
            toDate: $('.to_datetime').val(),
            rateType: $('.rate_type').val(),
            rateTypeText: $('.rate_type option:selected').text(),
            service: $('.service').val(),
            serviceText: $('.service option:selected').text(),
            duration: $('.duration').val(),
            unitPrice: $('.price').val() || '0',
            minPrice: $('.minprice').val() || '0',
            vatPerc: $('.vat').val() || '0',
            notes: $('#booking_notes').val() || ''
        },
        terms_and_conditions: $('#dc-full-editor-onbody').html(),
        signatures: {
            hirer_name: $('#dc_hirer_name_wizard').val(),
            hirer_base64: document.getElementById('dc_hirerCanvas_wizard').toDataURL(),
            delivery_name: $('#dc_delivery_name_wizard').val(),
            delivery_base64: document.getElementById('dc_deliveryCanvas_wizard').toDataURL()
        },
        vehicles: []
    };
    
    dcSelectedVehicles.forEach(v => {
        let vData = {
            vehicle_id: v.id,
            price: v.booking?.price || 0,
            vat: v.booking?.vat || 0,
            checklist: {
                tools: $(`#chk_tools_${v.id}`).is(':checked') ? 1 : 0,
                tyre: $(`#chk_spare_${v.id}`).is(':checked') ? 1 : 0,
                radio: $(`#chk_radio_${v.id}`).is(':checked') ? 1 : 0,
                aid: $(`#chk_aid_${v.id}`).is(':checked') ? 1 : 0,
                mats: $(`#chk_mats_${v.id}`).is(':checked') ? 1 : 0
            },
            handover: {
                dt_contract_date: $(`#dt_contract_date_${v.id}`).val(),
                fuel_level: $(`#fuel_level_${v.id}`).val(),
                fuel_out: $(`#fuel_level_${v.id}`).val(), // legacy fallback
                km_out: $(`#km_out_${v.id}`).val(),
                odo_out: $(`#km_out_${v.id}`).val(), // legacy fallback
                dt_out: $(`#dt_out_${v.id}`).val(),
                salik_out: $(`#salik_out_${v.id}`).val(), // if still present
                
                // Customer Driver
                cust_driver: $(`#cust_driver_${v.id}`).val(),
                cust_driver_contact_no: $(`#cust_driver_contact_no_${v.id}`).val(),
                cust_driver_documents: dcCustomerDriverDocs[v.id] || [],
                
                // Company Driver
                company_driver_id: $(`#driverSelect_${v.id}`).val(),
                
                // Rentout Images
                rentout_images: dcUploadedImages[v.id] || []
            }
        };
        payload.vehicles.push(vData);
    });
    
    return payload;
}

function submitDirectContracts(isRentout) {
    const payload = gatherDirectContractData();
    payload.is_rentout = isRentout ? 1 : 0;
    
    let btn = isRentout ? $('#btn_save_rentout_dc_contract') : $('#btn_save_dc_contract');
    let laddaBtn = Ladda.create(btn[0]);
    laddaBtn.start();
    
    $.ajax({
        url: '/VehicleContractGeneration',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function(res) {
            laddaBtn.stop();
            if (res.status) {
                $('#directContractWizardModal').modal('hide');
                setupDropdown('dropdownContent', 'success', svgSuccess + ' Contracts Generated Successfully!', 'click');
                setTimeout(() => location.reload(), 2000);
            } else {
                setupDropdown('dropdownContent', 'error', svgError + (res.message || 'Error saving contracts'), 'click');
            }
        },
        error: function(err) {
            laddaBtn.stop();
            setupDropdown('dropdownContent', 'error', svgError + ' Server error during generation', 'click');
            console.error(err);
        }
    });
}

$(document).on('click', '#btn_save_dc_contract', function() {
    submitDirectContracts(false);
});

$(document).on('click', '#btn_save_rentout_dc_contract', function() {
    let isValid = true;
    let errorMessage = '';

    // Validate Fuel and Odometer for each selected vehicle
    if (typeof dcSelectedVehicles !== 'undefined' && dcSelectedVehicles.length > 0) {
        for (let i = 0; i < dcSelectedVehicles.length; i++) {
            let v = dcSelectedVehicles[i];
            let vName = v.vehicle_number || v.id;
            
            let fuel = $(`#fuel_level_${v.id}`).val();
            let km = $(`#km_out_${v.id}`).val();
            
            if (!fuel || fuel === '') {
                isValid = false;
                errorMessage = 'Please select fuel level for vehicle: ' + vName;
                break;
            }
            
            if (!km || km === '') {
                isValid = false;
                errorMessage = 'Please enter odometer (km out) for vehicle: ' + vName;
                break;
            }
        }
    } else {
        isValid = false;
        errorMessage = 'No vehicles selected.';
    }

    if (!isValid) {
        setupDropdown('dropdownContent', 'error', svgError + ' ' + errorMessage, 'click');
        return;
    }

    // Validate Signatures
    function isCanvasBlank(canvasId) {
        let canvas = document.getElementById(canvasId);
        if (!canvas) return true;
        let blank = document.createElement('canvas');
        blank.width = canvas.width;
        blank.height = canvas.height;
        return canvas.toDataURL() === blank.toDataURL();
    }

    if (isCanvasBlank('dc_hirerCanvas_wizard')) {
        setupDropdown('dropdownContent', 'error', svgError + ' Hirer signature is required.', 'click');
        return;
    }

    if (isCanvasBlank('dc_deliveryCanvas_wizard')) {
        setupDropdown('dropdownContent', 'error', svgError + ' Delivered by signature is required.', 'click');
        return;
    }

    submitDirectContracts(true);
});
