let dcWizardObj = null;
let dcSelectedVehicles = [];
let dcCanvases = {};

function initScratchCanvas(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;
    const ctx = canvas.getContext("2d");
    
    // Resize canvas to match image dimensions
    const img = canvas.previousElementSibling;
    if (img && img.tagName === 'IMG') {
        canvas.width = img.clientWidth || 600;
        canvas.height = img.clientHeight || 300;
    }
    
    ctx.strokeStyle = "red";
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
    $('#dc_c_mobile').text($('#customerPhone').val() || '-');
    $('#dc_c_email').text($('#customerEmail').val() || '-');
    $('#dc_c_cpr').text($('#customercprcr').val() || '-');
    
    $('#dc_b_from').text(bookingDetails.fromDate);
    $('#dc_b_to').text(bookingDetails.toDate);
    $('#dc_b_type').text(bookingDetails.rateType);
    $('#dc_b_vehicles').text(vehicles.length);
    
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
        vehicleTpl = vehicleTpl.replace(/{ID}/g, v.id)
                               .replace(/{MODEL}/g, v.modelName || 'Unknown')
                               .replace(/{PLATE}/g, v.vehicleNo || 'Unknown')
                               .replace(/{CHASSIS}/g, v.chassisNumber || 'Unknown')
                               .replace(/{CATEGORY}/g, v.categoryName || 'Unknown')
                               .replace(/{ODO}/g, v.currentOdometer || '0');
                               
        contentContainer.append(vehicleTpl);
    });
    
    // 3. Driver & Terms Tab
    headerContainer.append(`<div class="line"></div>`);
    headerContainer.append(`
        <div class="step" data-target="#tab-dc-driver-terms">
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="ri-steering-2-line"></i></span>
                <span class="bs-stepper-label"><span class="bs-stepper-title">Driver</span></span>
            </button>
        </div>
    `);
    contentContainer.append(document.getElementById('dc-tpl-driver-terms').innerHTML);
    
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
    $('.btn-clear-canvas').on('click', function() {
        const vid = $(this).data('vid');
        clearCanvas(`scratchCanvas_${vid}`);
    });
    
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
        vehicles.forEach(v => {
            dcCanvases[`scratchCanvas_${v.id}`] = initScratchCanvas(`scratchCanvas_${v.id}`);
        });
        dcCanvases['dc_hirerCanvas_wizard'] = initScratchCanvas('dc_hirerCanvas_wizard');
        dcCanvases['dc_deliveryCanvas_wizard'] = initScratchCanvas('dc_deliveryCanvas_wizard');
    }, 500);
}

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
            service: $('.service').val(),
            duration: $('.duration').val()
        },
        driver: {
            name: $('#dc_driver_name').val(),
            license: $('#dc_driver_license').val(),
            expiry: $('#dc_driver_expiry').val()
        },
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
                tyre: $(`#chk_tyre_${v.id}`).is(':checked') ? 1 : 0,
                aid: $(`#chk_aid_${v.id}`).is(':checked') ? 1 : 0,
                mats: $(`#chk_mats_${v.id}`).is(':checked') ? 1 : 0
            },
            handover: {
                fuel_out: $(`#fuel_out_${v.id}`).val(),
                odo_out: $(`#odo_out_${v.id}`).val(),
                salik_out: $(`#salik_out_${v.id}`).val(),
                notes: $(`#vehicle_notes_${v.id}`).val()
            },
            scratch_base64: document.getElementById(`scratchCanvas_${v.id}`).toDataURL()
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
    submitDirectContracts(true);
});
