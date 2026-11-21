$(document).ready(function() {
    let dtAssigned;
    
    function showAlert(icon, title, text) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonText: 'OK',
                customClass: { confirmButton: 'btn btn-primary' },
                buttonsStyling: false
            });
        } else {
            alert(title + ": " + text);
        }
    }

    // Set default filter dates to current year
    let _date = new Date();
    let firstDay = new Date(_date.getFullYear(), 0, 1).toLocaleDateString('en-CA');
    let lastDay = new Date(_date.getFullYear(), 11, 31).toLocaleDateString('en-CA');
    $('#filterFromDate').val(firstDay);
    $('#filterToDate').val(lastDay);

    function formatMaintDate(dateStr, includeTime = false) {
        if (!dateStr) return '';
        const raw = String(dateStr).trim();
        if (!raw) return '';
        if (typeof dayjs === 'function') {
            const d = dayjs(raw);
            if (d.isValid()) {
                return includeTime ? d.format('DD-MMM-YYYY HH:mm') : d.format('DD-MMM-YYYY');
            }
        }
        const normalized = raw.includes(' ') && !raw.includes('T') ? raw.replace(' ', 'T') : raw;
        const dt = new Date(normalized);
        if (isNaN(dt.getTime())) return raw;
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const dd = String(dt.getDate()).padStart(2, '0');
        const mmm = months[dt.getMonth()];
        const yyyy = dt.getFullYear();
        if (!includeTime) return `${dd}-${mmm}-${yyyy}`;
        const hh = String(dt.getHours()).padStart(2, '0');
        const mm = String(dt.getMinutes()).padStart(2, '0');
        return `${dd}-${mmm}-${yyyy} ${hh}:${mm}`;
    }

    // Initialize Select2
    $('#selCompany, #selVehicle, #selGarage').each(function() {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });

    // Handle Company Change
    $('#selCompany').on('change', function() {
        let companyId = $(this).val();
        if (!companyId) {
            $('#selVehicle').html('<option value="">Choose Vehicle...</option>').trigger('change');
            return;
        }

        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_vehicles_by_company', company_id: companyId }),
            success: function(response) {
                if (response.status === 'success') {
                    let vHtml = '<option value="">Choose Vehicle...</option>';
                    response.data.vehicles.forEach(v => {
                        vHtml += `<option value="${v.ids}">${v.vehicle_number} - ${v.brand_name} ${v.model_name}</option>`;
                    });
                    $('#selVehicle').html(vHtml).trigger('change');
                }
            }
        });
    });

    // Store services options globally to reuse when cloning rows
    let serviceOptionsHtml = '<option value="">Select Service...</option>';

    // Fetch and display vehicle details on selection
    $('#selVehicle').on('change', function() {
        let vehicleId = $(this).val();
        if (!vehicleId) {
            $('#vehicleDetailsCard').addClass('d-none');
            $('#vehiclePlaceholderCard').removeClass('d-none');
            return;
        }

        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_vehicle_details', vehicle_id: vehicleId }),
            success: function(response) {
                if (response.status === 'success') {
                    let v = response.data.vehicle;
                    let assign = response.data.assignment;
                    
                    let fleetType = v.is_outsourced === 'Yes' 
                        ? `<span class="badge bg-label-warning px-2 py-1">Outsourced (${v.outsourcing_company_name || 'N/A'})</span>`
                        : `<span class="badge bg-label-success px-2 py-1">Own Fleet</span>`;

                    let html = `
                        <div class="row g-4 w-100 m-0">
                            <!-- Reg No -->
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-primary me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-barcode-box-line fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">Reg No</h6>
                                    <small class="text-muted">${v.vehicle_number || 'N/A'}</small>
                                </div>
                            </div>
                            <!-- Chassis No -->
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-secondary me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-qr-code-line fs-4 text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">Chassis No</h6>
                                    <small class="text-muted">${v.chassis_number || 'N/A'}</small>
                                </div>
                            </div>
                            <!-- Vehicle Details -->
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-info me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-steering-2-line fs-4 text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">Vehicle</h6>
                                    <small class="text-muted">${v.brand_name || ''} ${v.model_name || ''} (${v.category_name || 'N/A'})</small>
                                </div>
                            </div>
                            <!-- Status -->
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-danger me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-information-line fs-4 text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">Status</h6>
                                    ${typeof window.getVehicleStatusBadgeHtml === 'function' ? window.getVehicleStatusBadgeHtml(v.vehicle_status) : `<span class="badge bg-label-info">${v.vehicle_status}</span>`}
                                </div>
                            </div>
                            <!-- Next Insurance -->
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-warning me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-shield-check-line fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">Next Insurance</h6>
                                    <small class="text-muted">${v.next_insurance_date ? (formatMaintDate(v.next_insurance_date) || 'Not Set') : 'Not Set'}</small>
                                </div>
                            </div>
                            <!-- Next Passing -->
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-secondary me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-car-washing-line fs-4 text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">Next Passing</h6>
                                    <small class="text-muted">${v.next_passing_date ? (formatMaintDate(v.next_passing_date) || 'Not Set') : 'Not Set'}</small>
                                </div>
                            </div>
                            <!-- Reg Company -->
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-dark me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-bank-card-line fs-4 text-dark"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">Reg Company</h6>
                                    <small class="text-muted">${v.reg_company_name || 'N/A'}</small>
                                </div>
                            </div>
                            <!-- Fleet Type -->
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-success me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-building-4-line fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">Fleet Type</h6>
                                    <div class="mt-1">${fleetType}</div>
                                </div>
                            </div>
                        </div>
                    `;

                    if (assign) {
                        let expectedReturnHtml = '';
                        if (assign.expected_return) {
                            let formattedDate = formatMaintDate(assign.expected_return, true) || assign.expected_return;
                            
                            expectedReturnHtml = `
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-danger me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-calendar-event-line fs-4 text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium text-danger">Expected Return</h6>
                                    <small class="text-muted">${formattedDate}</small>
                                </div>
                            </div>`;
                        }

                        let contractRefHtml = '';
                        if (assign.contract_ref) {
                            let label = v.vehicle_status === 'Rentout' ? 'Agreement No' : 'Booking No';
                            contractRefHtml = `
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-warning me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-file-text-line fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium">${label}</h6>
                                    <small class="text-muted fw-bold">${assign.contract_ref}</small>
                                </div>
                            </div>`;
                        }
                        
                        let mobileHtml = assign.customer_mobile ? `<div class="mt-1"><small class="text-muted"><i class="ri ri-phone-line align-middle"></i> ${assign.customer_mobile}</small></div>` : '';

                        html += `
                        <div class="row g-4 w-100 m-0 mt-4 pt-4 border-top border-secondary border-opacity-25">
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-label-primary me-3" style="width: 38px; height: 38px;">
                                    <i class="ri ri-user-line fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-medium text-primary">Assigned To</h6>
                                    <div class="lh-1 mt-1"><small class="text-muted">${assign.customer_name || 'N/A'}</small></div>
                                    ${mobileHtml}
                                </div>
                            </div>
                            ${contractRefHtml}
                            ${expectedReturnHtml}
                        </div>`;
                    }
                    
                    $('#vehicleDetailsContent').html(html);
                    $('#vehiclePlaceholderCard').addClass('d-none');
                    $('#vehicleDetailsCard').removeClass('d-none');
                } else {
                    $('#vehicleDetailsCard').addClass('d-none');
                    $('#vehiclePlaceholderCard').removeClass('d-none');
                }
            },
            error: function() {
                $('#vehicleDetailsCard').addClass('d-none');
                $('#vehiclePlaceholderCard').removeClass('d-none');
            }
        });
    });

    // Load initial dropdown data
    loadDropdownData();
    loadAssignedVehicles();

    function loadDropdownData() {
        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_dropdowns' }),
            success: function(response) {
                if (response.status === 'success') {
                    // Populate Garages
                    let gHtml = '<option value="">Choose Garage...</option>';
                    response.data.garages.forEach(g => {
                        gHtml += `<option value="${g.ids}">${g.garage_name}</option>`;
                    });
                    $('#selGarage').html(gHtml).trigger('change');

                    // Populate Services
                    response.data.services.forEach(s => {
                        serviceOptionsHtml += `<option value="${s.ids}" data-unit="${s.unit || ''}" data-charge="${s.charge_per_unit || 0}">${s.service_name}</option>`;
                    });
                    
                    let firstServiceDropdown = $('.sel-service').first();
                    firstServiceDropdown.html(serviceOptionsHtml).trigger('change');
                    firstServiceDropdown.select2({
                        dropdownParent: firstServiceDropdown.parent()
                    });

                    // Trigger company change to load vehicles if a company is pre-selected
                    if ($('#selCompany').val()) {
                        $('#selCompany').trigger('change');
                    }
                } else {
                    showAlert('error', 'Error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Failed to load dropdown data.');
            }
        });
    }

    // Add new service row
    $('#btnAddService').on('click', function() {
        let newRow = `
        <div class="service-row row align-items-end mb-3 pb-3 border-bottom g-3">
            <div class="col-12 col-md-3">
                <div class="form-floating form-floating-outline mb-5">
                    <select class="form-select select2 sel-service" name="services[]" required>
                        ${serviceOptionsHtml}
                    </select>
                    <label>Service</label>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="form-floating form-floating-outline mb-5">
                    <input type="number" step="0.01" class="form-control inp-qty" name="qty[]" value="1" placeholder="Qty" required>
                    <label>Qty</label>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control inp-unit" name="unit[]" placeholder="Unit" required>
                    <label>Unit</label>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" name="remarks[]" placeholder="Enter remarks">
                    <label>Remarks</label>
                </div>
            </div>
            <div class="col-12 col-md-1 text-end mb-5">
                <button type="button" class="btn btn-danger btn-icon btnRemoveService"><i class="ri ri-delete-bin-line"></i></button>
            </div>
        </div>`;
        $('#serviceListContainer').append(newRow);
        
        // Initialize Select2 on the newly added select
        $('#serviceListContainer').find('.service-row:last .sel-service').select2({
            dropdownParent: $('#serviceListContainer').find('.service-row:last .col-md-3')
        });

        // Enable remove buttons if more than 1
        toggleRemoveButtons();
    });

    $(document).on('change', '.sel-service', function() {
        let selectedOption = $(this).find('option:selected');
        let unit = selectedOption.data('unit') || '';
        $(this).closest('.service-row').find('.inp-unit').val(unit);
    });

    // Remove service row
    $(document).on('click', '.btnRemoveService', function() {
        $(this).closest('.service-row').remove();
        toggleRemoveButtons();
    });

    function toggleRemoveButtons() {
        let count = $('.service-row').length;
        if (count > 1) {
            $('.btnRemoveService').prop('disabled', false);
        } else {
            $('.btnRemoveService').prop('disabled', true);
        }
    }

    // Submit Request
    $('#frmMaintenanceRequest').on('submit', function(e) {
        e.preventDefault();
        
        // Gather data
        let formData = {
            action: 'save_request',
            company_id: $('#selCompany').val(),
            vehicle_id: $('#selVehicle').val(),
            garage_id: $('#selGarage').val(),
            services: []
        };
        
        $('.service-row').each(function() {
            let s_id = $(this).find('.sel-service').val();
            let rem = $(this).find('input[name="remarks[]"]').val();
            let qty = $(this).find('.inp-qty').val() || 1;
            let unit = $(this).find('.inp-unit').val() || '';
            if(s_id) {
                formData.services.push({
                    service_id: s_id,
                    remarks: rem,
                    qty: qty,
                    unit: unit
                });
            }
        });

        if (formData.services.length === 0) {
            showAlert('warning', 'Warning', 'Please add at least one service.');
            return;
        }

        let editId = $('#editRequestId').val();
        if (editId) {
            formData.request_id = editId;
        }

        let btn = $('#btnSubmitRequest');
        btn.prop('disabled', true).html('<i class="ri-loader-4-line spin"></i> Saving...');

        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                btn.prop('disabled', false).html($('#editRequestId').val() ? '<i class="ri ri-save-line me-1"></i> Update' : '<i class="ri ri-save-line me-1"></i> Save');
                if (response.status === 'success') {
                    showAlert('success', 'Success', $('#editRequestId').val() ? `Maintenance Request Updated Successfully` : `Maintenance Request Created: ${response.data.request_no}`);
                    $('#btnResetRequest').click();
                    loadAssignedVehicles();
                } else {
                    showAlert('error', 'Error', response.message || 'Failed to save maintenance request.');
                }
            },
            error: function() {
                btn.prop('disabled', false).html($('#editRequestId').val() ? '<i class="ri ri-save-line me-1"></i> Update' : '<i class="ri ri-save-line me-1"></i> Save');
                showAlert('error', 'Error', 'Failed to save maintenance request.');
            }
        });
    });

    $('#btnResetRequest').on('click', function() {
        $('#frmMaintenanceRequest')[0].reset();
        $('#selCompany, #selVehicle, #selGarage').val('').trigger('change');
        $('#serviceListContainer .service-row:not(:first)').remove();
        let firstServiceDropdown = $('.sel-service').first();
        firstServiceDropdown.val('').trigger('change');
        $('.inp-qty').first().val('1');
        $('.inp-unit').first().val('');
        $('input[name="remarks[]"]').first().val('');
        
        $('#vehicleDetailsCard').addClass('d-none');
        $('#vehiclePlaceholderCard').removeClass('d-none');

        // Reset edit mode
        $('#editRequestId').val('');
        $('#formTitle').text('Maintenance Requests');
        $('#formSubtitle').text('Create a new maintenance request');
        $('#formModeBadge').removeClass('bg-label-warning').addClass('bg-label-success').text('New Entry');
        $('#btnSubmitRequest').html('<i class="ri ri-save-line me-1"></i> Save');
        $('#selCompany').prop('disabled', false);
    });

    function loadAssignedVehicles() {
        if (dtAssigned) {
            dtAssigned.destroy();
        }
        
        let fromDate = $('#filterFromDate').val();
        let toDate = $('#filterToDate').val();
        let status = $('#filterStatus').val();
        let companyId = $('#filterCompany').val();
        
        dtAssigned = $('#tblAssignedVehicles').DataTable({
            ajax: {
                url: '/MaintenanceController',
                type: 'POST',
                contentType: 'application/json',
                data: function ( d ) {
                    return JSON.stringify({ 
                        action: "get_requests",
                        fromDate: fromDate,
                        toDate: toDate,
                        status: status,
                        company_id: companyId
                    });
                },
                dataSrc: function (json) {
                    return json.data || [];
                }
            },
            columns: [
                {
                    data: 'request_no',
                    render: function(data, type, row) {
                        if (type === 'sort' || type === 'type') return data || '';
                        let st = row.status || '';
                        let badge = 'bg-label-primary';
                        if (st === 'Completed') badge = 'bg-label-success';
                        else if (st === 'In Progress') badge = 'bg-label-warning';
                        else if (st === 'Approved') badge = 'bg-label-info';
                        let statusHtml = st ? `<div class="mt-1"><span class="badge ${badge}">${st}</span></div>` : '';
                        return `<b>${data || '-'}</b>${statusHtml}`;
                    }
                },
                { 
                    data: null, 
                    render: function(data, type, row) {
                        let outsourceText = row.is_outsourced === 'Yes' ? (row.outsourcing_company_name ? `Outsource (${row.outsourcing_company_name})` : 'Outsource') : 'Fleet';
                        let typeBadge = row.is_outsourced === 'Yes' ? `<span class="badge bg-label-warning">${outsourceText}</span>` : `<span class="badge bg-label-primary">${outsourceText}</span>`;
                        let statusBadge = row.vehicle_status ? (typeof window.getVehicleStatusBadgeHtml === 'function' ? window.getVehicleStatusBadgeHtml(row.vehicle_status) : `<span class="badge bg-label-info">${row.vehicle_status}</span>`) : '';
                        let company = row.registration_company ? `<span class="badge bg-label-secondary"><i class="ri ri-building-line align-middle me-1"></i>${row.registration_company}</span>` : '';
                        let chassis = row.chassis_number ? `<small class="text-muted d-block"><i class="ri ri-barcode-line align-middle"></i> ${row.chassis_number}</small>` : '';
                        
                        return `<b>${row.vehicle_number}</b>
                                <br><small class="text-muted">${row.brand_name} ${row.model_name}</small>
                                ${chassis}
                                <div class="d-flex flex-wrap gap-1 mt-1">
                                    ${typeBadge}
                                    ${statusBadge}
                                    ${company}
                                </div>`;
                    } 
                },
                { 
                    data: null,
                    render: function(data, type, row) {
                        let html = `<b>${row.garage_name || '-'}</b>`;
                        
                        let details = [];
                        if (row.contact_person) {
                            details.push(`<span class="text-muted"><i class="ri ri-user-line align-middle me-1"></i>${row.contact_person}</span>`);
                        }
                        if (row.contact_number) {
                            details.push(`<span class="text-muted"><i class="ri ri-phone-line align-middle me-1"></i>${row.contact_number}</span>`);
                        }
                        if (row.email_id) {
                            details.push(`<span class="text-muted"><i class="ri ri-mail-line align-middle me-1"></i>${row.email_id}</span>`);
                        }
                        
                        if (details.length > 0) {
                            html += `<div class="d-flex flex-wrap gap-2 mt-1" style="font-size: 0.85rem;">
                                        ${details.join('')}
                                     </div>`;
                        }
                        return html;
                    }
                },
                { 
                    data: 'created_on',
                    render: function(data, type) {
                        if (type === 'sort' || type === 'type') return data || '';
                        return data ? formatMaintDate(data) : '';
                    }
                },
                {
                    data: 'ids',
                    render: function(data, type, row) {
                        let printBtn = `<button type="button" class="btn btn-sm btn-icon btn-primary me-1" onclick="window.open('/pdf/maintenance_report.php?id=${data}', '_blank')" title="Print"><i class="ri ri-printer-line text-white"></i></button>`;
                        let approveBtn = '';
                        let editBtn = '';
                        let releaseBtn = '';
                        let receiveBtn = '';
                        let viewBtn = '';

                        if (typeof hasPermission === 'function' && hasPermission('maintenance_request_manage')) {
                            if(row.status === 'Pending') {
                                editBtn = `<button type="button" class="btn btn-sm btn-icon btn-warning me-1 btnEditRequest" data-id="${data}" title="Edit"><i class="ri ri-pencil-line text-white"></i></button>`;
                                if (typeof hasPermission === 'function' && hasPermission('maintenance_request_approve')) {
                                    approveBtn = `<button type="button" class="btn btn-sm btn-icon btn-success btnApproveRequest" data-id="${data}" title="Approve"><i class="ri ri-check-double-line text-white"></i></button>`;
                                }
                            } else if(row.status === 'Approved') {
                                releaseBtn = `<button type="button" class="btn btn-sm btn-icon btn-info me-1 btnReleaseRequest" data-id="${data}" data-vstatus="${row.vehicle_status || ''}" data-odometer="${row.present_odometer || ''}" title="Release to Maintenance"><i class="ri ri-send-plane-line text-white"></i></button>`;
                            } else if(row.status === 'In Progress') {
                                // Pass some details to the button for the modal
                                let vDetails = `${row.vehicle_number} (${row.brand_name} ${row.model_name})`;
                                receiveBtn = `<button type="button" class="btn btn-sm btn-icon btn-success me-1 btnReceiveRequest" data-id="${data}" data-ref="${row.request_no}" data-vdetails="${vDetails}" data-garage="${row.garage_name}" title="Receive from Maintenance"><i class="ri ri-download-cloud-2-line text-white"></i></button>`;
                            }
                        }
                        
                        if(row.status === 'Completed' || row.status === 'In Progress' || row.status === 'Approved') {
                            viewBtn = `<button type="button" class="btn btn-sm btn-icon btn-warning me-1 btnViewDetails" data-id="${data}" title="Cost Allocation & Details"><i class="ri ri-money-dollar-circle-line text-white"></i></button>`;
                        }
                        return `<div class="d-flex">${printBtn}${editBtn}${approveBtn}${releaseBtn}${receiveBtn}${viewBtn}</div>`;
                    }
                }
            ],
            order: [[0, 'desc']],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        });
    }

    $('#btnFilterSearch').on('click', function() {
        loadAssignedVehicles();
    });

    $('#tblRequests tbody').on('click', 'tr', function(e) {
        if ($(e.target).closest('button, a').length > 0) {
            return; // Ignore if they clicked on an action button
        }

        let table = $('#tblRequests').DataTable();
        let rowData = table.row(this).data();
        if (!rowData) return;

        let reqId = rowData.ids;
        
        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_request_details', request_id: reqId }),
            success: function(res) {
                if(res.status === 'success') {
                    let req = res.data.request;
                    let srvs = res.data.services;
                    
                    // Set edit mode (viewable by everyone)
                    $('#editRequestId').val(req.ids);
                    $('#formTitle').text('View Request: ' + req.request_no);
                    $('#formSubtitle').text('Viewing an existing maintenance request');
                    $('#formModeBadge').removeClass('bg-label-success').addClass('bg-label-info').text('View Mode');
                    $('#btnSubmitRequest').html('<i class="ri ri-save-line me-1"></i> Update');

                    // Populate fields
                    $('#selCompany').val(req.company_id).trigger('change');
                    
                    // Wait for vehicle dropdown to populate, then set
                    setTimeout(() => {
                        $('#selVehicle').val(req.vehicle_id).trigger('change');
                        $('#selGarage').val(req.garage_id).trigger('change');
                        
                        // Populate Services
                        $('#serviceListContainer .service-row:not(:first)').remove();
                        let firstRow = $('.service-row').first();
                        
                        if (srvs.length > 0) {
                            firstRow.find('.sel-service').val(srvs[0].service_id).trigger('change');
                            firstRow.find('.inp-qty').val(srvs[0].qty);
                            firstRow.find('.inp-unit').val(srvs[0].unit);
                            firstRow.find('input[name="remarks[]"]').val(srvs[0].remarks);
                            
                            for (let i = 1; i < srvs.length; i++) {
                                $('#btnAddService').click();
                                let lastRow = $('.service-row').last();
                                lastRow.find('.sel-service').val(srvs[i].service_id).trigger('change');
                                lastRow.find('.inp-qty').val(srvs[i].qty);
                                lastRow.find('.inp-unit').val(srvs[i].unit);
                                lastRow.find('input[name="remarks[]"]').val(srvs[i].remarks);
                            }
                        }
                    }, 500);

                    // Scroll to form
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                } else {
                    showAlert('error', 'Error', res.message || 'Failed to fetch details');
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Failed to fetch request details');
            }
        });
    });

    $(document).on('click', '.btnEditRequest', function() {
        let reqId = $(this).data('id');
        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_request_details', request_id: reqId }),
            success: function(res) {
                if(res.status === 'success') {
                    let req = res.data.request;
                    let srvs = res.data.services;
                    
                    // Set edit mode
                    $('#editRequestId').val(req.ids);
                    $('#formTitle').text('Edit Request: ' + req.request_no);
                    $('#formSubtitle').text('Modifying an existing maintenance request');
                    $('#formModeBadge').removeClass('bg-label-success').addClass('bg-label-warning').text('Edit Mode');
                    $('#btnSubmitRequest').html('<i class="ri ri-save-line me-1"></i> Update');

                    // Populate fields
                    $('#selCompany').val(req.company_id).trigger('change');
                    $('#selCompany').prop('disabled', true);
                    
                    // Wait for vehicle dropdown to populate, then set
                    setTimeout(() => {
                        $('#selVehicle').val(req.vehicle_id).trigger('change');
                        $('#selGarage').val(req.garage_id).trigger('change');
                        
                        // Populate Services
                        $('#serviceListContainer .service-row:not(:first)').remove();
                        let firstRow = $('.service-row').first();
                        
                        if (srvs.length > 0) {
                            firstRow.find('.sel-service').val(srvs[0].service_id).trigger('change');
                            firstRow.find('.inp-qty').val(srvs[0].qty);
                            firstRow.find('.inp-unit').val(srvs[0].unit);
                            firstRow.find('input[name="remarks[]"]').val(srvs[0].remarks);
                            
                            for (let i = 1; i < srvs.length; i++) {
                                $('#btnAddService').click();
                                let lastRow = $('.service-row').last();
                                lastRow.find('.sel-service').val(srvs[i].service_id).trigger('change');
                                lastRow.find('.inp-qty').val(srvs[i].qty);
                                lastRow.find('.inp-unit').val(srvs[i].unit);
                                lastRow.find('input[name="remarks[]"]').val(srvs[i].remarks);
                            }
                        }
                    }, 500); // 500ms should be enough for the company dropdown's AJAX to finish

                    // Scroll to form
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                } else {
                    showAlert('error', 'Error', res.message || 'Failed to fetch details');
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Failed to fetch request details');
            }
        });
    });

    let pendingApproveId = null;
    let pendingApproveRow = null;

    $(document).on('click', '.btnApproveRequest', function() {
        pendingApproveId = $(this).data('id');
        pendingApproveRow = $(this).closest('tr');

        if (typeof SaNDSAlert !== 'undefined') {
            SaNDSAlert(
                'Are you sure you want to approve this request?',
                'ApproveMaintenanceRequest',
                'warning',
                '#f39c12',
                'Yes Approve',
                'Cancel',
                'Approve Request'
            );
        } else {
            if(confirm("Are you sure you want to approve this request?")) {
                processApprove(pendingApproveId, pendingApproveRow);
            }
        }
    });

    $(document).on('click', '#msg_popup_canceled', function () {
        $('#popupOverlay').hide();
        $('#popupContainer').hide();
    });

    $(document).on('click', '#msg_popup_confirmed', function () {
        let action = $('#message_matter').attr('data-switch-values');
        if (action === 'ApproveMaintenanceRequest') {
            if (pendingApproveId && pendingApproveRow) {
                processApprove(pendingApproveId, pendingApproveRow);
                pendingApproveId = null;
                pendingApproveRow = null;
            }
        }
    });

    function processApprove(id, rowElem) {
            $.ajax({
                url: '/MaintenanceController',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ action: 'approve_request', request_id: id }),
                success: function(res) {
                    $('#popupOverlay').hide();
                    $('#popupContainer').hide();
                    if(res.status === 'success') {
                        showAlert('success', 'Success', 'Request approved successfully.');
                        
                        // Update status in DataTable row instantly
                        let statusTd = rowElem.find('td:nth-child(5)'); // Index 5 for Status column
                        if(statusTd.length === 0) statusTd = rowElem.find('td').eq(4); // fallback
                        let badge = rowElem.find('.badge').filter(function() { return $(this).text() === 'Pending'; });
                        if (badge.length) {
                            badge.removeClass('bg-label-primary bg-label-warning').addClass('bg-label-info').text('Approved');
                        }
                        
                        // Replace edit and approve with release button
                        let dataId = pendingApproveId || id;
                        let actionsDiv = rowElem.find('td:last-child .d-flex');
                        rowElem.find('.btnEditRequest, .btnApproveRequest').remove();
                        // Get vehicle status if possible, else it will be refetched by loadAssignedVehicles later
                        let vstatus = rowElem.data('vstatus') || 'Available'; // Fallback
                        let odometer = rowElem.data('odometer') || '';
                        actionsDiv.append(`<button type="button" class="btn btn-sm btn-icon btn-info me-1 btnReleaseRequest" data-id="${dataId}" data-vstatus="${vstatus}" data-odometer="${odometer}" title="Release to Maintenance"><i class="ri ri-send-plane-line text-white"></i></button>`);
                        
                        loadAssignedVehicles();
                    } else {
                        showAlert('error', 'Error', res.message || 'Failed to approve');
                    }
                },
                error: function() {
                    showAlert('error', 'Error', 'Failed to approve request');
                }
            });
        }

    let pendingReleaseRow = null;

    $(document).on('click', '.btnReleaseRequest', function() {
        let vstatus = $(this).data('vstatus');
        let reqId = $(this).data('id');
        pendingReleaseRow = $(this).closest('tr');
        
        // If datatable doesn't provide it directly, we assume valid and let server handle or refetch it.
        // Assuming loadAssignedVehicles correctly fetches vehicle_status
        if (vstatus && vstatus !== 'Parking' && vstatus !== 'Available') {
            showAlert('warning', 'Action Cannot Be Performed', 'The action cannot be performed from here, first return the vehicle and continue.');
            return;
        }

        $('#frmReleaseMaintenance')[0].reset();
        $('#releaseRequestId').val(reqId);
        
        // Default datetime to current
        let now = new Date();
        let offset = now.getTimezoneOffset() * 60000;
        let localISOTime = (new Date(now - offset)).toISOString().slice(0, 16);
        $('#releaseDateTime').val(localISOTime);
        
        let presentOdometer = $(this).data('odometer');
        if (presentOdometer) {
            $('#releaseOdometer').val(presentOdometer);
        } else {
            $('#releaseOdometer').val('');
        }
        
        $('#releaseMaintenanceModal').modal('show');
    });

    $('#btnSubmitRelease').on('click', function() {
        let reqId = $('#releaseRequestId').val();
        let logDatetime = $('#releaseDateTime').val();
        let odometer = $('#releaseOdometer').val();
        let remarks = $('#releaseRemarks').val();

        if (!logDatetime || !odometer) {
            showAlert('warning', 'Validation', 'Date/Time and Odometer Reading are required.');
            return;
        }

        let btn = $(this);
        let origHtml = btn.html();
        btn.prop('disabled', true).html('<i class="ri-loader-4-line spin"></i> Processing...');

        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ 
                action: 'release_request', 
                request_id: reqId,
                log_datetime: logDatetime,
                odometer: odometer,
                remarks: remarks
            }),
            success: function(res) {
                if(res.status === 'success') {
                    $('#releaseMaintenanceModal').modal('hide');
                    showAlert('success', 'Success', 'Vehicle released to maintenance successfully.');
                    
                    if (pendingReleaseRow) {
                        let badge = pendingReleaseRow.find('.badge').filter(function() { return $(this).text() === 'Approved'; });
                        if (badge.length) {
                            badge.removeClass('bg-label-info').addClass('bg-label-warning').text('In Progress');
                        }
                        pendingReleaseRow.find('.btnReleaseRequest').remove();
                    }
                    
                    loadAssignedVehicles();
                } else {
                    showAlert('error', 'Error', res.message || 'Failed to release vehicle. ' + (res.debug ? res.debug : ''));
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Failed to process the request.');
            },
            complete: function() {
                btn.prop('disabled', false).html(origHtml);
            }
        });
    });

    let pendingReceiveRow = null;

    $(document).on('click', '.btnReceiveRequest', function() {
        let reqId = $(this).data('id');
        let refNo = $(this).data('ref');
        let vDetails = $(this).data('vdetails');
        let garage = $(this).data('garage');
        pendingReceiveRow = $(this).closest('tr');

        $('#frmReceiveMaintenance')[0].reset();
        $('#receiveRequestId').val(reqId);
        
        $('#recvVehicleDetails').text(vDetails || '--');
        $('#recvRequestRef').text(refNo || '--');
        $('#recvGarageDetails').text(garage || '--');

        // Default datetime to current
        let now = new Date();
        let offset = now.getTimezoneOffset() * 60000;
        let localISOTime = (new Date(now - offset)).toISOString().slice(0, 16);
        $('#receiveDateTime').val(localISOTime);

        $('#recvOdometerOut').text('--');

        // Fetch services
        $('#recvServicesList').html('<tr><td colspan="4" class="text-center text-muted"><i class="ri-loader-4-line spin"></i> Loading services...</td></tr>');
        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_request_details', request_id: reqId }),
            success: function(res) {
                if(res.status === 'success') {
                    if (res.data.request && res.data.request.odometer_out) {
                        $('#recvOdometerOut').text(res.data.request.odometer_out);
                    }
                    
                    if (res.data.services.length > 0) {
                        let sHtml = '';
                        res.data.services.forEach(s => {
                            sHtml += `<tr>
                                <td>${s.service_name || s.service_id}</td>
                                <td>${s.qty}</td>
                                <td>${s.unit}</td>
                                <td>${s.remarks || '-'}</td>
                            </tr>`;
                        });
                        $('#recvServicesList').html(sHtml);
                    } else {
                        $('#recvServicesList').html('<tr><td colspan="4" class="text-center text-muted">No services found.</td></tr>');
                    }
                } else {
                    $('#recvServicesList').html('<tr><td colspan="4" class="text-center text-danger">Error: ' + res.message + '</td></tr>');
                }
            },
            error: function() {
                $('#recvServicesList').html('<tr><td colspan="4" class="text-center text-danger">Failed to load services.</td></tr>');
            }
        });

        $('#receiveMaintenanceModal').modal('show');
    });

    $('#btnSubmitReceive').on('click', function() {
        let reqId = $('#receiveRequestId').val();
        let newStatus = $('#receiveNewStatus').val();
        let logDatetime = $('#receiveDateTime').val();
        let odometer = $('#receiveOdometer').val();
        let remarks = $('#receiveRemarks').val();

        if (!logDatetime || !odometer || !newStatus) {
            showAlert('warning', 'Validation', 'Status, Date/Time In, and Odometer Reading are required.');
            return;
        }

        let btn = $(this);
        let origHtml = btn.html();
        btn.prop('disabled', true).html('<i class="ri-loader-4-line spin"></i> Processing...');

        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ 
                action: 'receive_request', 
                request_id: reqId,
                new_status: newStatus,
                log_datetime: logDatetime,
                odometer: odometer,
                remarks: remarks
            }),
            success: function(res) {
                if(res.status === 'success') {
                    $('#receiveMaintenanceModal').modal('hide');
                    showAlert('success', 'Success', 'Vehicle received from maintenance successfully.');
                    loadAssignedVehicles();
                } else {
                    showAlert('error', 'Error', res.message || 'Failed to receive vehicle. ' + (res.debug ? res.debug : ''));
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Failed to process the request.');
            },
            complete: function() {
                btn.prop('disabled', false).html(origHtml);
            }
        });
    });

    function calculateTotalCost() {
        let total = 0;
        $('.service-cost').each(function() {
            let val = parseFloat($(this).val()) || 0;
            total += val;
        });
        let additional = parseFloat($('#viewAdditionalCharges').val()) || 0;
        total += additional;
        $('#viewTotalCost').text(total.toFixed(3));
    }

    $(document).on('input', '.service-cost, #viewAdditionalCharges', calculateTotalCost);

    $('#btnAddServiceRow').on('click', function() {
        let emptyRow = `<tr>
            <td class="align-middle">
                <select class="form-select form-select-sm cost-service-id">${serviceOptionsHtml}</select>
            </td>
            <td class="align-middle">
                <input type="number" step="any" min="0" class="form-control form-control-sm cost-qty" value="1">
            </td>
            <td class="align-middle">
                <input type="text" class="form-control form-control-sm cost-unit" value="">
            </td>
            <td class="align-middle">
                <input type="text" class="form-control form-control-sm cost-remarks" value="">
            </td>
            <td>
                <input type="number" step="0.001" min="0" class="form-control form-control-sm text-end service-cost" data-id="" data-charge="0" value="0.000">
            </td>
        </tr>`;
        
        if($('#viewServicesList').find('td').length === 1) {
            $('#viewServicesList').empty(); // Clear "No services found"
        }
        $('#viewServicesList').append(emptyRow);
    });

    $(document).on('change', '.cost-service-id', function() {
        let opt = $(this).find('option:selected');
        let charge = opt.data('charge') || 0;
        let unit = opt.data('unit') || '';
        let row = $(this).closest('tr');
        row.find('.cost-unit').val(unit);
        let qty = row.find('.cost-qty').val() || 1;
        let cost = parseFloat(qty) * parseFloat(charge);
        row.find('.service-cost').val(cost.toFixed(3));
        row.find('.service-cost').data('charge', charge);
        calculateTotalCost();
    });

    $(document).on('input', '.cost-qty', function() {
        let row = $(this).closest('tr');
        let charge = row.find('.service-cost').data('charge') || 0;
        let qty = $(this).val() || 0;
        let cost = parseFloat(qty) * parseFloat(charge);
        row.find('.service-cost').val(cost.toFixed(3));
        calculateTotalCost();
    });

    $(document).on('click', '.btnViewDetails', function() {
        let reqId = $(this).data('id');
        $('#viewRequestId').val(reqId);
        
        // Reset modal fields
        $('#viewVehicleDetails, #viewRequestRef, #viewGarageDetails, #viewStatusBadge').text('--');
        $('#viewOutDate, #viewOutOdometer, #viewOutLoggedBy').text('--');
        $('#viewInDate, #viewInOdometer, #viewInLoggedBy').text('--');
        $('#viewOdometerDiff').text('--');
        $('#viewServicesList').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
        $('#viewAdditionalCharges').val('0.000');
        $('#viewAdditionalChargesRemarks').val('');
        $('#viewTotalCost').text('0.000');

        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'get_full_request_details', request_id: reqId }),
            success: function(res) {
                if(res.status === 'success') {
                    let req = res.data.request;
                    let outLog = res.data.log_out;
                    let inLog = res.data.log_in;
                    let services = res.data.services;

                    $('#viewVehicleDetails').text(`${req.vehicle_number} (${req.brand_name} ${req.model_name})`);
                    $('#viewRequestRef').text(req.request_no);
                    $('#viewGarageDetails').text(`${req.garage_name} (Contact: ${req.contact_person || 'N/A'})`);
                    $('#viewStatusBadge').text(req.status);

                    let outOdo = null;
                    let inOdo = null;

                    if (outLog) {
                        $('#viewOutDate').text(formatMaintDate(outLog.log_datetime, true) || outLog.log_datetime);
                        $('#viewOutOdometer').text(outLog.odometer);
                        $('#viewOutLoggedBy').text(outLog.created_name);
                        outOdo = parseFloat(outLog.odometer);
                    }
                    if (inLog) {
                        $('#viewInDate').text(formatMaintDate(inLog.log_datetime, true) || inLog.log_datetime);
                        $('#viewInOdometer').text(inLog.odometer);
                        $('#viewInLoggedBy').text(inLog.created_name);
                        inOdo = parseFloat(inLog.odometer);
                    }

                    if (outOdo !== null && inOdo !== null && !isNaN(outOdo) && !isNaN(inOdo)) {
                        $('#viewOdometerDiff').text((inOdo - outOdo).toFixed(1));
                    }

                    $('#viewAdditionalCharges').val(parseFloat(req.additional_charges || 0).toFixed(3));
                    $('#viewAdditionalChargesRemarks').val(req.additional_charges_remarks || '');

                    if (services.length > 0) {
                        let sHtml = '';
                        services.forEach(s => {
                            let dbCost = parseFloat(s.cost || 0);
                            let masterCharge = parseFloat(s.charge_per_unit || 0);
                            let qty = parseFloat(s.qty || 1);
                            let defaultCost = dbCost > 0 ? dbCost : (qty * masterCharge);
                            let cost = defaultCost.toFixed(3);
                            sHtml += `<tr>
                                <td class="align-middle">
                                    <input type="hidden" class="cost-service-id" value="${s.service_id}">
                                    ${s.service_name || s.service_id}
                                </td>
                                <td class="align-middle">
                                    <input type="number" step="any" min="0" class="form-control form-control-sm cost-qty" value="${qty}">
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control form-control-sm cost-unit" value="${s.unit || ''}">
                                </td>
                                <td class="align-middle">
                                    <input type="text" class="form-control form-control-sm cost-remarks" value="${s.remarks || ''}">
                                </td>
                                <td>
                                    <input type="number" step="0.001" min="0" class="form-control form-control-sm text-end service-cost" data-id="${s.ids}" data-charge="${masterCharge}" value="${cost}">
                                </td>
                            </tr>`;
                        });
                        $('#viewServicesList').html(sHtml);
                    } else {
                        $('#viewServicesList').html('<tr><td colspan="5" class="text-center text-muted">No services found.</td></tr>');
                    }

                    calculateTotalCost();
                    $('#viewRequestModal').modal('show');
                } else {
                    showAlert('error', 'Error', res.message || 'Failed to load details.');
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Failed to communicate with server.');
            }
        });
    });

    $('#btnSaveCosts').on('click', function() {
        let reqId = $('#viewRequestId').val();
        let addCharges = $('#viewAdditionalCharges').val();
        let addChargesRemarks = $('#viewAdditionalChargesRemarks').val();
        let servicesData = [];
        
        $('.service-cost').each(function() {
            let row = $(this).closest('tr');
            servicesData.push({
                ids: $(this).data('id'),
                service_id: row.find('.cost-service-id').val(),
                qty: row.find('.cost-qty').val(),
                unit: row.find('.cost-unit').val(),
                remarks: row.find('.cost-remarks').val(),
                cost: $(this).val()
            });
        });

        let btn = $(this);
        let origHtml = btn.html();
        btn.prop('disabled', true).html('<i class="ri-loader-4-line spin me-1"></i> Saving...');

        $.ajax({
            url: '/MaintenanceController',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ 
                action: 'save_request_costs', 
                request_id: reqId,
                additional_charges: addCharges,
                additional_charges_remarks: addChargesRemarks,
                services: servicesData
            }),
            success: function(res) {
                if (res.status === 'success') {
                    showAlert('success', 'Success', 'Costs saved successfully!');
                    $('#viewRequestModal').modal('hide');
                } else {
                    showAlert('error', 'Error', res.message || 'Failed to save costs.');
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Failed to communicate with server.');
            },
            complete: function() {
                btn.prop('disabled', false).html(origHtml);
            }
        });
    });

    // Modal Add Garage
    $('#btnSaveGarage').on('click', function() {
        let name = $('#newGarageName').val().trim();
        if (!name) {
            showAlert('warning', 'Validation', 'Garage Name is required.');
            return;
        }

        let postData = {
            action: 'AddGarage',
            garage_name: name,
            address: '',
            email_id: '',
            contact_person: $('#newGarageContact').val().trim(),
            contact_number: $('#newGaragePhone').val().trim()
        };

        let btn = $(this);
        let origHtml = btn.html();
        btn.prop('disabled', true).html('<i class="ri-loader-4-line spin"></i> Saving...');

        $.ajax({
            url: '/GarageController',
            type: 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            success: function(res) {
                let resObj = typeof res === 'string' ? JSON.parse(res) : res;
                if(resObj.status) {
                    $('#addGarageModal').modal('hide');
                    $('#frmAddGarage')[0].reset();
                    showAlert('success', 'Success', 'Garage added successfully.');
                    
                    // Reload Garages dropdown
                    let reqData = { action: 'get_dropdowns' };
                    let compId = $('#selCompany').val();
                    if (compId) reqData.company_id = compId;
                    
                    $.ajax({
                        url: '/MaintenanceController',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(reqData),
                        success: function(resp) {
                            if (resp.status === 'success') {
                                let gHtml = '<option value="">Choose Garage...</option>';
                                resp.data.garages.forEach(g => {
                                    gHtml += `<option value="${g.ids}">${g.garage_name}</option>`;
                                });
                                let prevVal = $('#selGarage').val();
                                $('#selGarage').html(gHtml);
                                // The newly added garage will be at the end, or we just select it if we could get the ID, but we just trigger change
                                if (prevVal) $('#selGarage').val(prevVal).trigger('change');
                            }
                        }
                    });
                } else {
                    showAlert('error', 'Error', resObj.message || 'Failed to add Garage');
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Something went wrong.');
            },
            complete: function() {
                btn.prop('disabled', false).html(origHtml);
            }
        });
    });

    // Modal Add Service
    $('#btnSaveService').on('click', function() {
        let name = $('#newServiceName').val().trim();
        if (!name) {
            showAlert('warning', 'Validation', 'Service Name is required.');
            return;
        }

        let postData = {
            action: 'AddGarageService',
            service_name: name,
            unit: '',
            charge_per_unit: $('#newServiceCharge').val().trim() || 0
        };

        let btn = $(this);
        let origHtml = btn.html();
        btn.prop('disabled', true).html('<i class="ri-loader-4-line spin"></i> Saving...');

        $.ajax({
            url: '/GarageController',
            type: 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            success: function(res) {
                let resObj = typeof res === 'string' ? JSON.parse(res) : res;
                if(resObj.status) {
                    $('#addServiceModal').modal('hide');
                    $('#frmAddService')[0].reset();
                    showAlert('success', 'Success', 'Service added successfully.');
                    
                    // Reload Services options
                    $.ajax({
                        url: '/MaintenanceController',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ action: 'get_dropdowns' }),
                        success: function(resp) {
                            if (resp.status === 'success') {
                                serviceOptionsHtml = '<option value="">Select Service...</option>';
                                resp.data.services.forEach(s => {
                                    serviceOptionsHtml += `<option value="${s.ids}" data-unit="${s.unit || ''}" data-charge="${s.charge_per_unit || 0}">${s.service_name}</option>`;
                                });
                                // Re-populate all service dropdowns but keep selected values
                                $('.sel-service').each(function() {
                                    let prevVal = $(this).val();
                                    $(this).html(serviceOptionsHtml);
                                    if(prevVal) {
                                        $(this).val(prevVal).trigger('change');
                                    }
                                });
                            }
                        }
                    });
                } else {
                    showAlert('error', 'Error', resObj.message || 'Failed to add Service');
                }
            },
            error: function() {
                showAlert('error', 'Error', 'Something went wrong.');
            },
            complete: function() {
                btn.prop('disabled', false).html(origHtml);
            }
        });
    });

});
