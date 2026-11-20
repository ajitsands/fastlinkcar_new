let dataTable = null;
let currentVehicleId = null;
let timelineDataStore = [];

const SYS_DATE_FORMAT = window.SYS_DATE_FORMAT || 'YYYY-MM-DD';

$(document).ready(function () {
    initDataTable();
    
    // Status Filter
    $('#statusFilter').on('change', function() {
        if (dataTable) {
            dataTable.draw();
        }
    });

    // Company Filter
    $('#companyFilter').on('change', function() {
        if (dataTable) {
            dataTable.ajax.reload();
        }
    });

    // Custom filtering function for DataTables
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            let filterStatus = $('#statusFilter').val();
            if (!filterStatus) return true;
            
            let rowData = settings.aoData[dataIndex]._aData;
            let insDate = rowData.next_insurance_date;
            let passDate = rowData.next_passing_date;
            
            let now = dayjs().startOf('day');
            
            // Helper function to check if a date falls in a specific bucket
            function matchesBucket(dateStr, bucket) {
                if (!dateStr) return false;
                let target = dayjs(dateStr).startOf('day');
                let diffDays = target.diff(now, 'day');
                
                if (bucket === 'Overdue' && diffDays < 0) return true;
                if (bucket === '0_30' && diffDays >= 0 && diffDays <= 30) return true;
                if (bucket === '30_60' && diffDays > 30 && diffDays <= 60) return true;
                if (bucket === '60_90' && diffDays > 60 && diffDays <= 90) return true;
                if (bucket === 'greater_90' && diffDays > 90) return true;
                
                return false;
            }
            
            // If either insurance or passing matches the bucket, show the row
            return matchesBucket(insDate, filterStatus) || matchesBucket(passDate, filterStatus);
        }
    );
});

function getInsuranceExpiryAlerts(rows) {
    const today = new Date(new Date().toDateString());
    const alerts = [];
    (rows || []).forEach(v => {
        [['next_insurance_date', 'Insurance'], ['next_passing_date', 'Passing']].forEach(([col, label]) => {
            const d = v[col];
            if (!d || d === '0000-00-00') return;
            const diff = Math.ceil((new Date(d + 'T00:00:00') - today) / 86400000);
            if (diff <= 30) {
                alerts.push({
                    vehicle_number: v.vehicle_number,
                    type: label,
                    date: d,
                    days: diff,
                    expired: diff < 0
                });
            }
        });
    });
    const $banner = $('#vehicleExpiryAlertBanner');
    if (!alerts.length) {
        $banner.hide().empty();
        return;
    }
    const expiredCnt = alerts.filter(a => a.expired).length;
    const soonCnt = alerts.length - expiredCnt;
    const tags = alerts.slice(0, 8).map(a =>
        `<span class="badge ${a.expired ? 'bg-danger' : 'bg-warning text-dark'} me-1 mb-1">${a.vehicle_number} (${a.type}: ${a.expired ? 'Expired ' + Math.abs(a.days) + 'd ago' : 'Due in ' + a.days + 'd'})</span>`
    ).join('');
    $banner.html(`
        <div class="alert ${expiredCnt > 0 ? 'alert-danger' : 'alert-warning'} d-flex align-items-start gap-2 mb-0">
            <i class="ri-alarm-warning-line fs-4 mt-1"></i>
            <div>
                <div class="fw-bold">Vehicle Insurance &amp; Passing Expiry Alerts (${expiredCnt} Expired, ${soonCnt} Expiring within 30 Days)</div>
                <div class="mt-1">${tags}${alerts.length > 8 ? ` <span class="small text-muted">+${alerts.length - 8} more</span>` : ''}</div>
            </div>
        </div>
    `).show();
}

function getSingleDateStatus(dateString) {
    if (!dateString) return `<small class="text-muted d-block lh-1 mt-1">No Data</small>`;
    
    let now = dayjs().startOf('day');
    let target = dayjs(dateString).startOf('day');
    let diffDays = target.diff(now, 'day');
    
    if (diffDays < 0) {
        return `<small class="text-danger fw-bold d-block lh-1 mt-1">Overdue by ${Math.abs(diffDays)} days</small>`;
    } else if (diffDays <= 20) {
        return `<small class="text-warning fw-bold d-block lh-1 mt-1">Expiring in ${diffDays} days</small>`;
    } else {
        return `<small class="text-success d-block lh-1 mt-1">Valid (${diffDays} days left)</small>`;
    }
}

function initDataTable() {
    dataTable = $('#insuranceTable').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "/VehicleInsuranceController?action=listVehicles",
            "type": "GET",
            "data": function(d) {
                d.company_id = $('#companyFilter').val();
            },
            "dataSrc": function (json) {
                if (json.status) {
                    getInsuranceExpiryAlerts(json.data);
                    return json.data;
                }
                getInsuranceExpiryAlerts([]);
                return [];
            }
        },
        "columns": [
            {
                "data": "vehicle_number",
                "render": function(data, type, row) {
                    let html = `<div class="fw-bold fs-6">${data}</div>`;
                    if (row.is_outsourced === 'Yes') {
                        html += `<small class="d-block text-warning mt-1 lh-1"><i class="ri ri-share-forward-line align-middle"></i> Outsource: ${row.outsourcing_company || row.outsourcing_company_name || 'N/A'}</small>`;
                    }
                    return html;
                }
            },
            { 
                "data": null,
                "render": function (data, type, row) {
                    let html = `<div>${row.brand_name || ''} - ${row.model_names || ''}</div>
                            <small class="text-muted">Chassis: ${row.chassis_number || 'N/A'}</small>`;
                    html += `<small class="d-block text-success mt-1 lh-1"><i class="ri ri-building-4-line align-middle"></i> Reg Co: ${row.ownership_company || 'N/A'}</small>`;
                    return html;
                }
            },
            { 
                "data": "next_insurance_date",
                "render": function(data) {
                    let dateStr = data ? dayjs(data).format(SYS_DATE_FORMAT) : 'Not Set';
                    let statusStr = getSingleDateStatus(data);
                    return `<div>${dateStr}</div>${statusStr}`;
                }
            },
            { 
                "data": "next_passing_date",
                "render": function(data) {
                    let dateStr = data ? dayjs(data).format(SYS_DATE_FORMAT) : 'Not Set';
                    let statusStr = getSingleDateStatus(data);
                    return `<div>${dateStr}</div>${statusStr}`;
                }
            },
            {
                "data": "vehicle_status",
                "render": function (data, type, row) {
                    if (typeof window.getVehicleStatusBadgeHtml === 'function') {
                        return window.getVehicleStatusBadgeHtml(data);
                    }
                    return data; // Fallback
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function (data, type, row) {
                    let btnProfile = `<button type="button" class="btn btn-sm btn-outline-info me-1 text-nowrap" data-bs-toggle="tooltip" data-bs-placement="top" title="View Profile" onclick="openVehicleProfile(${row.vehicle_id})"><i class="ri ri-eye-line me-1"></i> Profile</button>`;
                    let btnIns = `<button type="button" class="btn btn-sm btn-outline-success me-1 text-nowrap" data-bs-toggle="tooltip" data-bs-placement="top" title="Insurance Details & Renewal" data-permission="vehicle_insurance_manage" onclick="openAddEntryModal(${row.vehicle_id}, 'insurance')"><i class="ri ri-shield-check-line me-1"></i> Insurance</button>`;
                    let btnPass = `<button type="button" class="btn btn-sm btn-outline-warning text-nowrap" data-bs-toggle="tooltip" data-bs-placement="top" title="Passing Details & Renewal" data-permission="vehicle_insurance_manage" onclick="openAddEntryModal(${row.vehicle_id}, 'passing')"><i class="ri ri-car-washing-line me-1"></i> Passing</button>`;
                    
                    return `<div class="d-flex align-items-center">${btnProfile}${btnIns}${btnPass}</div>`;
                }
            }
        ],
        "drawCallback": function(settings) {
            if (typeof applyUiPermissions === 'function') {
                applyUiPermissions();
            }
            // Initialize Bootstrap Tooltips for the newly rendered buttons
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('#insuranceTable [data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        }
    });

    // Connect custom search box
    $('#tableSearch').on('keyup', function () {
        dataTable.search(this.value).draw();
    });
}

function getStatusBadge(insuranceDate, passingDate) {
    let now = dayjs();
    let minDate = null;
    
    if (insuranceDate && passingDate) {
        let iDate = dayjs(insuranceDate);
        let pDate = dayjs(passingDate);
        minDate = iDate.isBefore(pDate) ? iDate : pDate;
    } else if (insuranceDate) {
        minDate = dayjs(insuranceDate);
    } else if (passingDate) {
        minDate = dayjs(passingDate);
    } else {
        return `<span class="status-badge status-overdue">No Data</span>`;
    }

    let diffDays = minDate.diff(now, 'day');

    if (diffDays < 0) {
        return `<span class="status-badge status-overdue">Overdue</span>`;
    } else if (diffDays <= 20) {
        return `<span class="status-badge status-expiring">Expiring Soon (${diffDays} days)</span>`;
    } else {
        return `<span class="status-badge status-valid">Valid (${diffDays} days)</span>`;
    }
}

function formatViDate(dtStr) {
    if (!dtStr || dtStr === '0000-00-00') return '-';
    const d = dayjs(dtStr);
    return d.isValid() ? d.format('DD-MMM-YYYY') : dtStr;
}

function getVehicleRowById(vehicleId) {
    if (!dataTable) return null;
    const rows = dataTable.rows().data().toArray();
    return rows.find(r => String(r.vehicle_id) === String(vehicleId)) || null;
}

function getViHistoryArray(row, type) {
    if (!row) return [];
    const raw = type === 'passing' ? row.passing_histroy : row.insurance_histroy;
    let list = [];
    try { list = JSON.parse(raw || '[]'); } catch (e) { list = []; }
    return Array.isArray(list) ? list : [];
}

function resetViEditMode() {
    $('#entryId').val('');
    $('#viSaveBtn').text('Save Record');
    $('#viCancelEditBtn').addClass('d-none');
}

function prefillViEntry(type, entry) {
    $('#entryDate').val((entry && entry.date) ? entry.date : '');
    $('#entryAmount').val(entry && entry.amount ? entry.amount : '');
    $('#entryRemarks').val(entry && entry.remarks ? entry.remarks : '');
    $('#entryAttachment').val('');
    if (type === 'insurance') {
        $('#entryProvider').val(entry && entry.provider ? entry.provider : '');
        $('#entryPolicyNo').val(entry && entry.policy_no ? entry.policy_no : '');
        $('#entryInsType').val(entry && entry.insurance_type ? entry.insurance_type : 'Comprehensive');
        $('#entryStartDate').val(entry && entry.start_date ? entry.start_date : '');
    } else {
        $('#entryPassedDate').val(entry && entry.passed_date ? entry.passed_date : '');
    }
}

function renderViHistory(vehicleId, type) {
    const row = getVehicleRowById(vehicleId);
    const list = getViHistoryArray(row, type);
    if (!list.length) {
        $('#viHistoryList').html('<span class="text-muted fst-italic">No previous records found.</span>');
        return;
    }
    let html = `<table class="table table-sm table-bordered mb-0 align-middle">
        <thead class="table-light">
            <tr>
                <th>Next Expiry</th>
                <th>${type === 'insurance' ? 'Provider / Policy / Type / Start' : 'Passed Date'}</th>
                <th>Remarks</th>
                <th class="text-end">Amount</th>
                <th class="text-center">Doc</th>
                <th class="text-center">Action</th>
            </tr>
        </thead><tbody>`;
    list.forEach((item, idx) => {
        const details = type === 'insurance'
            ? [
                item.provider || '',
                item.policy_no ? `Policy: ${item.policy_no}` : '',
                item.insurance_type || '',
                item.start_date ? `Start: ${formatViDate(item.start_date)}` : ''
              ].filter(Boolean).join(' | ') || '-'
            : (item.passed_date ? formatViDate(item.passed_date) : '-');
        const docCell = item.attachment
            ? `<a href="${item.attachment}" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-2"><i class="ri-file-text-line"></i> View</a>`
            : '<span class="text-muted">-</span>';
        let actionBtns = `<button type="button" class="btn btn-xs btn-outline-info py-0 px-2 me-1" onclick="viewViHistoryDetail(${vehicleId}, '${type}', ${idx})" title="View Details"><i class="ri-eye-line"></i></button>`;
        if (idx === 0) {
            actionBtns += `<button type="button" class="btn btn-xs btn-outline-warning py-0 px-2 me-1" onclick="editViLastEntry(${vehicleId}, '${type}', ${idx})" title="Edit Last Entry"><i class="ri-edit-line"></i></button>`;
            actionBtns += `<button type="button" class="btn btn-xs btn-outline-danger py-0 px-2" onclick="deleteViLastEntry(${vehicleId}, '${type}', '${item.id}')" title="Delete Last Entry"><i class="ri-delete-bin-line"></i></button>`;
        }
        html += `<tr>
            <td class="fw-semibold text-nowrap">${formatViDate(item.date)}</td>
            <td>${details}</td>
            <td>${item.remarks || '-'}</td>
            <td class="text-end text-nowrap fw-semibold">${parseFloat(item.amount || 0).toFixed(3)} BHD</td>
            <td class="text-center">${docCell}</td>
            <td class="text-center text-nowrap">${actionBtns}</td>
        </tr>`;
    });
    html += '</tbody></table>';
    $('#viHistoryList').html(html);
}

function viewViHistoryDetail(vehicleId, type, idx) {
    const list = getViHistoryArray(getVehicleRowById(vehicleId), type);
    const item = list[idx];
    if (!item) return;
    const extra = type === 'insurance'
        ? `<div><strong>Provider:</strong> ${item.provider || '-'} &nbsp;|&nbsp; <strong>Policy No:</strong> ${item.policy_no || '-'} &nbsp;|&nbsp; <strong>Type:</strong> ${item.insurance_type || '-'} &nbsp;|&nbsp; <strong>Start Date:</strong> ${formatViDate(item.start_date)}</div>`
        : `<div><strong>Passed Date:</strong> ${formatViDate(item.passed_date)}</div>`;
    $('#viEntryDetailBox').html(`
        <div class="d-flex justify-content-between align-items-center mb-1">
            <strong style="color:#1b3d94;">Entry Details (${type.toUpperCase()})</strong>
            <button type="button" class="btn-close btn-sm" onclick="$('#viEntryDetailBox').hide();"></button>
        </div>
        <div><strong>Next Expiry:</strong> ${formatViDate(item.date)} &nbsp;|&nbsp; <strong>Amount:</strong> ${parseFloat(item.amount || 0).toFixed(3)} BHD</div>
        ${extra}
        <div><strong>Remarks:</strong> ${item.remarks || '-'}</div>
        ${item.attachment ? `<div><strong>Document:</strong> <a href="${item.attachment}" target="_blank">Open Attachment</a></div>` : ''}
    `).show();
}

function editViLastEntry(vehicleId, type, idx) {
    const list = getViHistoryArray(getVehicleRowById(vehicleId), type);
    const item = list[idx];
    if (!item) return;
    $('#entryId').val(item.id || '');
    prefillViEntry(type, item);
    $('#viSaveBtn').text('Update Record');
    $('#viCancelEditBtn').removeClass('d-none');
}

function deleteViLastEntry(vehicleId, type, entryId) {
    if (!confirm('Delete this last renewal entry?')) return;
    const fd = new FormData();
    fd.append('vehicle_id', vehicleId);
    fd.append('entry_id', entryId);
    fd.append('type', type);
    fetch('/VehicleInsuranceController?action=deleteEntry', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.status) {
                const row = getVehicleRowById(vehicleId);
                if (row) {
                    if (type === 'passing') {
                        row.passing_histroy = JSON.stringify(res.history || []);
                        row.next_passing_date = res.next_date || '';
                    } else {
                        row.insurance_histroy = JSON.stringify(res.history || []);
                        row.next_insurance_date = res.next_date || '';
                    }
                }
                openAddEntryModal(vehicleId, type);
                dataTable.ajax.reload(null, false);
                Swal.fire('Success', res.message || 'Deleted successfully', 'success');
            } else {
                Swal.fire('Error', res.message || 'Failed to delete', 'error');
            }
        });
}

$(document).on('click', '#viCancelEditBtn', function() {
    const vId = $('#entryVehicleId').val();
    const type = $('#entryType').val();
    const row = getVehicleRowById(vId);
    const list = getViHistoryArray(row, type);
    resetViEditMode();
    prefillViEntry(type, list[0] || { date: type === 'passing' ? (row?.next_passing_date || '') : (row?.next_insurance_date || '') });
});

function openAddEntryModal(vehicleId, type) {
    const row = getVehicleRowById(vehicleId);
    $('#entryVehicleId').val(vehicleId);
    $('#entryType').val(type);
    $('#addEntryForm')[0].reset();
    resetViEditMode();
    $('#viEntryDetailBox').hide().empty();

    if (type === 'passing') {
        $('.vi-ins-only').hide();
        $('.vi-pass-only').show();
        $('#entryDateLabel').text('Next Passing Expiry Date *');
    } else {
        $('.vi-ins-only').show();
        $('.vi-pass-only').hide();
        $('#entryDateLabel').text('Next Insurance Expiry Date *');
    }

    const list = getViHistoryArray(row, type);
    const latest = list.length ? list[0] : null;
    prefillViEntry(type, latest || {
        date: type === 'passing' ? (row?.next_passing_date || '') : (row?.next_insurance_date || '')
    });
    renderViHistory(vehicleId, type);

    let title = (type === 'insurance' ? 'Insurance Details - ' : 'Passing Details - ') + (row?.vehicle_number || '');
    $('#addEntryModalTitle').text(title);
    
    $('#addEntryModal').modal('show');
}

function submitAddEntry() {
    let formData = new FormData($('#addEntryForm')[0]);
    let type = $('#entryType').val();
    let entryId = $('#entryId').val();
    let action = entryId ? 'updateEntry' : (type === 'insurance' ? 'addInsurance' : 'addPassing');

    $.ajax({
        url: `/VehicleInsuranceController?action=${action}`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status) {
                $('#addEntryModal').modal('hide');
                Swal.fire('Success', response.message, 'success');
                dataTable.ajax.reload(null, false); // reload without resetting pagination
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'An error occurred while saving the record', 'error');
        }
    });
}

function openTimeline(vehicleId) {
    currentVehicleId = vehicleId;
    $('#timelineContainer').html('<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div></div>');
    $('#timelineModal').modal('show');

    $.ajax({
        url: `/VehicleInsuranceController?action=getTimeline&vehicle_id=${vehicleId}`,
        type: 'GET',
        success: function(response) {
            if (response.status) {
                timelineDataStore = response.data;
                renderTimeline();
            } else {
                $('#timelineContainer').html(`<div class="alert alert-danger">${response.message}</div>`);
            }
        },
        error: function() {
            $('#timelineContainer').html(`<div class="alert alert-danger">Failed to load timeline</div>`);
        }
    });
}

function renderTimeline() {
    let html = '';
    
    if (timelineDataStore.length === 0) {
        html = '<div class="text-center text-muted p-4">No history records found.</div>';
    } else {
        timelineDataStore.forEach(item => {
            let typeClass = item.type === 'insurance' ? 'type-insurance' : 'type-passing';
            let badgeClass = item.type === 'insurance' ? 'insurance' : 'passing';
            let displayDate = dayjs(item.date).format(SYS_DATE_FORMAT);
            let createdDate = item.created_at ? dayjs(item.created_at).format('MMM D, YYYY HH:mm') : '';
            
            let attachmentHtml = '';
            if (item.attachment) {
                attachmentHtml = `<a href="${item.attachment}" target="_blank" class="attachment-link"><i class="ri ri-file-download-line"></i> Download Attachment</a>`;
            }

            let deleteBtnHtml = '';
            if (typeof window.hasPermission === 'function' && window.hasPermission('vehicle_insurance_manage')) {
                deleteBtnHtml = `<button class="delete-entry-btn" onclick="deleteEntry('${item.id}', '${item.type}')"><i class="ri ri-delete-bin-line"></i> Delete</button>`;
            }

            let amountStr = item.amount ? `<strong>Amount:</strong> BHD ${parseFloat(item.amount).toFixed(2)}<br>` : '';
            let remarksStr = item.remarks ? `<strong>Remarks:</strong> ${item.remarks}<br>` : '';

            html += `
                <div class="timeline-entry ${typeClass}">
                    <div class="timeline-header">
                        <span class="timeline-date">${displayDate}</span>
                        <span class="timeline-type-badge ${badgeClass}">${item.type}</span>
                    </div>
                    <div class="timeline-body">
                        ${amountStr}
                        ${remarksStr}
                        <small class="text-muted">Added: ${createdDate}</small>
                    </div>
                    <div class="timeline-footer">
                        ${attachmentHtml}
                        ${deleteBtnHtml}
                    </div>
                </div>
            `;
        });
    }

    $('#timelineContainer').html(html);
}

function deleteEntry(entryId, type) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/VehicleInsuranceController?action=deleteEntry`,
                type: 'POST',
                data: {
                    vehicle_id: currentVehicleId,
                    entry_id: entryId,
                    type: type
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire('Deleted!', 'The record has been deleted.', 'success');
                        openTimeline(currentVehicleId); // refresh timeline
                        dataTable.ajax.reload(null, false); // refresh list
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'An error occurred during deletion.', 'error');
                }
            });
        }
    });
}


function openVehicleProfile(vehicleId) {
    $.ajax({
        url: "/AddVehicles",
        type: "POST",
        dataType: "json",
        data: JSON.stringify({ action: "get_vehicle_profile", vehicle_id: vehicleId }),
        contentType: "application/json",
        success: function(response) {
            if (response.status && response.data) {
                let v = response.data;
                
                // Populate base data
                $("#vpVehicleNumber").text(v.vehicle_number || "N/A");
                $("#vpVehicleNumBody").text(v.vehicle_number || "N/A");
                $("#vpCategory").text(v.category_name || "N/A");
                $("#vpBrand").text(v.brand_name || "N/A");
                $("#vpModel").text(v.model_names || "N/A");
                $("#vpChassis").text(v.chassis_number || "N/A");
                $("#vpYear").text(v.vehicle_year || "N/A");
                $("#vpColor").text(v.vehicle_color || "N/A");
                $("#vpPurchaseDate").text(v.formatted_purchase_date || "Not Set");
                $("#vpNextInsurance").text(v.formatted_insurance_date || "Not Set");
                $("#vpNextPassing").text(v.formatted_passing_date || "Not Set");
                
                // Current User (Rentout / Staff Use)
                $("#vpRentoutDiv").hide();
                $("#vpStaffDiv").hide();
                
                if (v.vehicle_status === 'Rentout') {
                    if (v.current_user_name) {
                        $("#vpRentoutDiv").show();
                        $("#vpCurrentUserName").text(v.current_user_name);
                        $("#vpCurrentUserContact").text(v.current_user_contact || "No Contact");
                        $("#vpContractRef").text(v.contract_ref || "N/A");
                        
                        // Format expected return date
                        let expRet = "N/A";
                        if (v.expected_return_date) {
                            expRet = dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A');
                        }
                        $("#vpReturnDate").text(expRet);
                    }
                } else if (v.vehicle_status === 'Staff Use') {
                    if (v.current_user_name) {
                        $("#vpStaffDiv").show();
                        $("#vpStaffName").text(v.current_user_name);
                        $("#vpStaffContact").text(v.current_user_contact || "No Contact");
                        $("#vpStaffRef").text(v.contract_ref || "N/A");
                        
                        // Format expected return date
                        let expRet = "N/A";
                        if (v.expected_return_date) {
                            expRet = dayjs(v.expected_return_date).format('DD-MMM-YYYY h:mm A');
                        }
                        $("#vpStaffReturnDate").text(expRet);
                    }
                }
                
                // Status badge styling
                let statusClass = "bg-label-primary";
                if(v.vehicle_status === "Available") statusClass = "bg-label-success";
                else if(v.vehicle_status === "Rentout") statusClass = "bg-label-danger";
                else if(v.vehicle_status === "Maintenance") statusClass = "bg-label-warning";
                
                $("#vpStatusBadge").attr("class", "badge " + statusClass).text(v.vehicle_status || "Unknown");
                
                // Ownership
                $("#vpRegCompany").text(v.ownership_company || "N/A");
                if (v.is_outsourced === "Yes") {
                    $("#vpOutsourceDiv").show();
                    $("#vpOutsourceCompany").text(v.outsourcing_company_name || "N/A");
                } else {
                    $("#vpOutsourceDiv").hide();
                }
                
                // Other details (JSON)
                let od = v.other_details || {};
                $("#vpFuelType").text(od.vehicleFuelType || "N/A");
                $("#vpGearType").text(od.vehicleGearType || "N/A");
                
                // Dynamic Pricing from model
                $("#vpPricingList").empty();
                if (v.model_price_json && v.model_price_json !== "") {
                    try {
                        let prices = JSON.parse(v.model_price_json);
                        if (prices && prices.length > 0) {
                            let groups = { Hour: [], Day: [], Week: [], Month: [], Year: [], Other: [] };
                            
                            prices.forEach(p => {
                                if (p.amount && p.amount !== "") {
                                    let itemLower = p.item.toLowerCase();
                                    let groupName = 'Other';
                                    if (itemLower.includes('hour')) groupName = 'Hour';
                                    else if (itemLower.includes('day')) groupName = 'Day';
                                    else if (itemLower.includes('week')) groupName = 'Week';
                                    else if (itemLower.includes('month')) groupName = 'Month';
                                    else if (itemLower.includes('year')) groupName = 'Year';
                                    
                                    let displayName = p.item;
                                    if (itemLower.includes('without driver')) displayName = 'W/O Driver';
                                    else if (itemLower.includes('with driver')) displayName = 'With Driver';
                                    
                                    groups[groupName].push({ name: displayName, amount: p.amount });
                                }
                            });
                            
                            let html = '<div class="row g-2 w-100">';
                            for (const [gName, items] of Object.entries(groups)) {
                                if (items.length > 0) {
                                    html += `<div class="col-6">
                                                <div class="border rounded px-2 py-1 bg-lighter">
                                                    <div class="text-center text-muted fw-bold border-bottom mb-1" style="font-size: 11px;">${gName}</div>`;
                                    items.forEach(i => {
                                        html += `<div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="text-muted" style="font-size: 11px;">${i.name}</span>
                                                    <strong class="text-success" style="font-size: 11px;">${i.amount} AED</strong>
                                                 </div>`;
                                    });
                                    html += `   </div>
                                              </div>`;
                                }
                            }
                            html += '</div>';
                            $("#vpPricingList").html(html);
                        }
                    } catch(e) {
                        console.error("Failed to parse model prices", e);
                    }
                }
                if ($("#vpPricingList").is(':empty')) {
                    $("#vpPricingList").html('<span class="text-muted fst-italic">No pricing setup</span>');
                }
                
                // Status badge styling
                let images = v.images || [];
                let carouselInner = $("#vpCarouselInner");
                carouselInner.empty();
                
                if (images.length > 0) {
                    $("#vpNoImagesMessage").hide();
                    $("#vpImageCarousel").show();
                    
                    images.forEach((img, idx) => {
                        let activeClass = idx === 0 ? "active" : "";
                        // Format image path correctly
                        let imgPath = img.includes("http") ? img : ("/uploads/vehicleImages/" + img); 
                        carouselInner.append(`
                            <div class="carousel-item ${activeClass} h-100">
                                <img src="${imgPath}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Vehicle Image">
                            </div>
                        `);
                    });
                } else {
                    $("#vpImageCarousel").hide();
                    $("#vpNoImagesMessage").show();
                }
                
                // Show modal
                $("#vehicleProfileModal").modal("show");
            } else {
                setupDropdown("dropdownContent", "error", response.message || "Failed to load profile", "click");
            }
        },
        error: function() {
            setupDropdown("dropdownContent", "error", "Error connecting to server", "click");
        }
    });
}



$(document).ready(function() {
    // Move modal to body to fix z-index overlay issues
    if ($("#vehicleProfileModal").length) {
        $("#vehicleProfileModal").appendTo("body");
    }
});

