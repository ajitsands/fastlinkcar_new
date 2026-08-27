
$(document).ready(function () {
 $('#hid_model_id').val(0);

$('[data-bs-toggle="tooltip"]').tooltip();
$('#statusTabs .nav-link').on('click', function(e){
    e.preventDefault(); // prevent default anchor jump
    
    // Add active class
    $('#statusTabs .nav-link').removeClass('active');
    $(this).addClass('active');
    
    const targetId = $(this).attr('href'); 
    const $target = $(targetId);
    
    if($target.length){
        $('html, body').animate({
            scrollTop: $target.offset().top - 100 // adjust for fixed header
        }, 500);
    }
});
 
function formatDate(dateStr) {
 
    let months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    let parts = dateStr.split('-');

    return parts[2] + ' ' + months[parseInt(parts[1]) - 1] + ' ' + parts[0];
}
//Vehicle Info Modal
 function getFilePreview(ext, url) {
    const map = {
        pdf: '/assets/icons/pdf.png',
        doc: '/assets/icons/word.png',
        docx: '/assets/icons/word.png',
        xls: '/assets/icons/excel.png',
        xlsx: '/assets/icons/excel.png',
        zip: '/assets/icons/zip.png',
        rar: '/assets/icons/zip.png',
        txt: '/assets/icons/txt.png'
    };

    const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (imageExts.includes(ext)) {
        return url || '';
    }

    return map[ext] || '/assets/icons/file.png';
}

// SandsAlert Common Function
  document.querySelectorAll('.popup-buttons button').forEach(function(button) {
            button.addEventListener('click', function() {
              
              var popupOverlay = document.getElementById('popupOverlay');
              var popupContainer = document.getElementById('popupContainer');
              popupOverlay.style.display = 'none';
              popupContainer.style.display = 'none';
              // Check which button was clicked
              if (button.classList.contains('ok')) {
                // OK button clicked, perform action
                 var messageMatter = $('#message_matter');
            var switchData = messageMatter.attr('data-switch-values');
           // var param = messageMatter.attr('data-param'); 
                switch (switchData) {
                    case 'deletePasingTimeline':
                       deletePasingTimeline();
                        
                    break;
                    case 'deleteInsuranceTimeline':
                       deleteInsuranceTimeline();
                        
                    break;
                    case 'deleteMaintenanceTimeline':
                       deleteMaintenanceTimeline();
                        
                    break;
				
                    default:
                        setupDropdown('dropdownContent','error',svgSuccess+'No action defined for this message.','click');
                }
              } else if (button.classList.contains('cancel')) {
                // Cancel button clicked, do nothing
               
                setupDropdown('dropdownContent','error',svgSuccess+'Action canceled!','click');
              }
            });
        });
 let passingHistory = [];
 let insuranceHistory = [];
 let maintenanceHistory = [];
 
 $(document).on('click', '.btn_vehicle_view', function() {
    let vehicleId = $(this).data('id');
      const $btn = $(this);
    $('#hid_vehicle_id_info_modal').val(vehicleId);
    resetPassingForm();
    resetInsuranceForm();
    resetMaintenanceForm();
    $('#passingFormCard').addClass('d-none');
    $('#insuranceFormCard').addClass('d-none');
    $('#maintenanceFormCard').addClass('d-none');
    let modal = new bootstrap.Modal(document.getElementById('vehicleDetailsModal'));
    modal.show();

    let parentCard = $(this).closest('.vehicle-card');
    let selectBtn = parentCard.find('.btn_vehicle_select');
    
     $('.span_hwod').html(selectBtn.data('pricehwod'));
     $('.span_hwd').html(selectBtn.data('pricehwd'));
     $('.span_dwod').html(selectBtn.data('pricedwod'));
     $('.span_dwd').html(selectBtn.data('pricedwd'));
     $('.span_wwod').html(selectBtn.data('pricewwod'));
     $('.span_wwd').html(selectBtn.data('pricewwd'));
     $('.span_mwod').html(selectBtn.data('pricemwod'));
     $('.span_mwd').html(selectBtn.data('pricemwd'));

    $.ajax({
        url: '/VehicleStatusController',
        method: 'POST',
        data: {
            action: 'get_vehicle_full_details',
            vehicleId: vehicleId
        },
        success: function(response) {
            
         let res = response.data[0];
            let lastImage = response.last_image;
            let vehicleStatushtml = response.vehicleStatushtml;
            let other = JSON.parse(res.other_details_json || "{}");
            passingHistory = JSON.parse(res.passing_histroy || "[]");
            insuranceHistory = JSON.parse(res.insurance_histroy || "[]");
            maintenanceHistory = JSON.parse(res.maintenance_histroy || "[]");
            $('#vehicleCategoryinfo').text(res.category_name || '-');
            $('#vehicleBrandinfo').text(res.brand_name || '-');
            
            $('#vehicleModelinfo').text(res.model_names || '-');
            $('#vehicleNumber').text(res.vehicle_number || '-');
            $('#div_common_car_number').text(res.vehicle_number || '-');
            $('#div_common_car_name').text(res.model_names || '-');
            
            $('#vehicleYear').text(res.vehicle_year || '-');
            $('#vehicleColor').text(res.vehicle_color || '-');
          
            $('#purchaseDate').text(formatDate(res.vehicle_purchase_date) || '-');
            $('#purchaseCost').text(other.vehiclePurchasePrice || '-');
            
            $('#costHour').text(other.vehiclePricePerHour || 0);
            $('#costDay').text(other.vehiclePricePerDay || 0);
            $('#costMonth').text(other.vehiclePricePerMonth || 0);
            
            $('#remarks').text(other.vehicleDescription || '-');
            let imageUrlModal = '/uploads/vehicleImages/' + lastImage;

            $('#vehicleImageModal').attr('src', imageUrlModal);
            $('#div_modal_status').html(vehicleStatushtml);
            
     
         
            let imageHtml = '';
            
            
            let imagesRaw = res.image_json;

                    let images = [];
                    
                    try {
                      let parsed = JSON.parse(imagesRaw);
                    
                      if (typeof parsed === 'string') {
                        parsed = JSON.parse(parsed);
                      }
                    
                      if (Array.isArray(parsed)) {
                        images = parsed;
                      }
                    
                    } catch (e) {
                      console.error("Image JSON parse error:", e);
                      images = [];
                    }

               
                
                images.forEach(img => {
                    
                  imageHtml += `
                    <li class="avatar avatar-lg pull-up me-1 open-file-docs"
                        data-img="/uploads/vehicleImages/${img}"
                        data-name="${img}"
                        title="${img}">
                        
                      <img class="rounded-circle" src="/uploads/vehicleImages/${img}">
                    </li>
                  `;
                });
                
                $('#vehicleImagesList').html(imageHtml);
                let docs = [];

                    let attachments = res.vehicle_attachments || {};
                    
                    if (typeof attachments === "string") {
                        try {
                            attachments = JSON.parse(attachments);
                        } catch {
                            attachments = {};
                        }
                    }
                    
                    attachments?.vehicles?.forEach(v =>
                        v.files?.forEach(file =>
                            docs.push({
                                name: v.documentName || '',
                                url: file
                            })
                        )
                    );
            
            let docHtml = '';

                docs.forEach(doc => {
                    let exts = doc.url.split('.').pop().toLowerCase();
                    let previewSrcs = getFilePreview(exts, doc.url);
                 docHtml += `
                    <li class="avatar avatar-lg pull-up me-1 open-file-docs"
                        data-img="${doc.url}"
                        data-name="${doc.name}"
                        title="${doc.name}">
                        
                      <img class="rounded-circle" src="${previewSrcs}">
                       <div style="font-size:11px; max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                ${doc.name}
                            </div>
                    </li>
                    `;
                });
 
    
   
          $('#vehicleDocsList').html(docHtml);
           ensureHistoryIds(passingHistory); 
            ensureHistoryIds(insuranceHistory); 
             ensureHistoryIds(maintenanceHistory); 

           
          renderPassingTimeline(passingHistory);
          renderInsuranceTimeline(insuranceHistory); 
          renderMaintenanceTimeline(maintenanceHistory); 
          loadBookingTable(vehicleId);
          loadContractTable(vehicleId);

        },
        error: function() {
            $('#vehicleInfoContent').html('<div class="text-danger">Failed to load data</div>');
        }
    });
});
function renderPassingTimeline(passingHistory=null) {

    let passtimelineHtml = '';

    [...passingHistory].reverse().forEach((passitem, passindex) => {

        let passoriginalIndex = passingHistory.length - 1 - passindex;
    
    
        let passattachmentsHtml = '<ul id="Passing_img_list" class="list-unstyled d-flex align-items-center avatar-group mb-0">';
    
        if (passitem.documents && passitem.documents.length > 0) {
            passitem.documents.forEach(passdoc => {
                if (!passdoc.url) return; // ✅ skip invalid entries
              let passtimeexts = passdoc.url.split('.').pop().toLowerCase();
              let passtimeurl ='httpdocs'+passdoc.url;
              let passtimepreviewSrcs = getFilePreview(passtimeexts, passtimeurl);
                passattachmentsHtml += `
                    <li data-img="httpdocs${passdoc.url}" data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="${passdoc.name}"
                        class="avatar avatar-lg pull-up me-1 open-file-docs">
                        
                        <img class="rounded-circle" src="${passtimepreviewSrcs}">
                    </li>
                `;
            });
        }
         passattachmentsHtml += '</ul>';
        passtimelineHtml += `
        <li class="timeline-item timeline-item-transparent border-dashed" data-index="${passoriginalIndex}">
            <span class="timeline-point timeline-point-primary"></span>
    
            <div class="timeline-event">
    
                <div class="timeline-header mb-3">
                    <h6 class="mb-0 timeline-title">${passitem.added_info}</h6>
    
                    <div class="d-flex justify-content-end mb-2">
                        <button class="btn btn-sm btn-outline-primary me-1 editPassingTimeline" data-id="${passitem.id}" data-index="${passoriginalIndex}">Edit</button>
                        <button class="btn btn-sm btn-outline-danger deletePassingTimeline" data-id="${passitem.id}" data-index="${passoriginalIndex}">Delete</button>
                    </div>
                </div>
    
                <div class="row g-2 mb-2">
    
                    <div class="col-md-6">
                        <small class="text-muted">Next Passing Date</small>
                        <div class="fw-medium">${formatDate(passitem.next_date)}</div>
                    </div>
    
                    <div class="col-md-6">
                        <small class="text-muted">Done Date</small>
                        <div class="fw-medium">${formatDate(passitem.done_date)}</div>
                    </div>
    
                    <div class="col-md-12">
                        <small class="text-muted">Remarks</small>
                        <p class="mb-1">${passitem.remarks || ''}</p>
                    </div>
    
                </div>
    
                <!-- Attachments -->
                <div class="mb-2">
                    <small class="text-muted d-block mb-1">Attachments</small>
    
                    <ul class="users-list d-flex align-items-center avatar-group m-0">
                        ${passattachmentsHtml}
                    </ul>
                </div>
    
            </div>
        </li>
        `;
    });
    $('#ul_passing_histroy_timeline').html(passtimelineHtml);
}
function renderInsuranceTimeline(insuranceHistory=null) {

    let insurancetimelineHtml = '';

    [...insuranceHistory].reverse().forEach((insuranceitem, insuranceindex) => {

        let insuranceoriginalIndex = insuranceHistory.length - 1 - insuranceindex;
    
    
        let insuranceattachmentsHtml = '<ul id="insurance_img_list" class="list-unstyled d-flex align-items-center avatar-group mb-0">';
    
        if (insuranceitem.documents && insuranceitem.documents.length > 0) {
            insuranceitem.documents.forEach(insurancedoc => {
                 if (!insurancedoc.url) return; // ✅ skip invalid entries
              let insurancetimeexts = insurancedoc.url.split('.').pop().toLowerCase();
              let insurancetimeurl ='httpdocs'+insurancedoc.url;
              let insurancetimepreviewSrcs = getFilePreview(insurancetimeexts, insurancetimeurl);
                insuranceattachmentsHtml += `
                    <li data-img="httpdocs${insurancedoc.url}" data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="${insurancedoc.name}"
                        class="avatar avatar-lg pull-up me-1 open-file-docs">
                        
                        <img class="rounded-circle" src="${insurancetimepreviewSrcs}">
                    </li>
                `;
            });
        }
         insuranceattachmentsHtml += '</ul>';
        insurancetimelineHtml += `
        <li class="timeline-item timeline-item-transparent border-dashed" data-index="${insuranceoriginalIndex}">
            <span class="timeline-point timeline-point-success"></span>
    
            <div class="timeline-event">
    
                <div class="timeline-header mb-3">
                    <h6 class="mb-0 timeline-title">${insuranceitem.added_info}</h6>
    
                    <div class="d-flex justify-content-end mb-2">
                        <button class="btn btn-sm btn-outline-primary me-1 editInsuranceTimeline" data-id="${insuranceitem.id}" data-index="${insuranceoriginalIndex}">Edit</button>
                        <button class="btn btn-sm btn-outline-danger deleteInsuranceTimeline" data-id="${insuranceitem.id}" data-index="${insuranceoriginalIndex}">Delete</button>
                    </div>
                </div>
    
                <div class="row g-2 mb-2">
    
                    <div class="col-md-6">
                        <small class="text-muted">Next Insurance Date</small>
                        <div class="fw-medium">${formatDate(insuranceitem.next_date)}</div>
                    </div>
    
                    <div class="col-md-6">
                        <small class="text-muted">Done Date</small>
                        <div class="fw-medium">${formatDate(insuranceitem.done_date)}</div>
                    </div>
    
                    <div class="col-md-12">
                        <small class="text-muted">Remarks</small>
                        <p class="mb-1">${insuranceitem.remarks || ''}</p>
                    </div>
    
                </div>
    
                <!-- Attachments -->
                <div class="mb-2">
                    <small class="text-muted d-block mb-1">Attachments</small>
    
                    <ul class="users-list d-flex align-items-center avatar-group m-0">
                        ${insuranceattachmentsHtml}
                    </ul>
                </div>
    
            </div>
        </li>
        `;
    });
    $('#ul_insurance_histroy_timeline').html(insurancetimelineHtml);
}

function renderMaintenanceTimeline(maintenanceHistory=null) {

    let maintenancetimelineHtml = '';

    [...maintenanceHistory].reverse().forEach((maintenanceitem, maintenanceindex) => {

        let maintenanceoriginalIndex = maintenanceHistory.length - 1 - maintenanceindex;
    
    
        let maintenanceattachmentsHtml = '<ul id="maintenance_img_list" class="list-unstyled d-flex align-items-center avatar-group mb-0">';
    if (maintenanceitem.documents && maintenanceitem.documents.length > 0) {
    maintenanceitem.documents.forEach(maintenancedoc => {

        if (!maintenancedoc.url) return; // ✅ skip invalid entries

        let maintenancetimeexts = maintenancedoc.url.split('.').pop().toLowerCase();
        let maintenancetimeurl = 'httpdocs' + maintenancedoc.url;
        let maintenancetimepreviewSrcs = getFilePreview(maintenancetimeexts, maintenancetimeurl);

        maintenanceattachmentsHtml += `
            <li data-img="httpdocs${maintenancedoc.url}" class="avatar avatar-lg pull-up me-1 open-file-docs">
                <img class="rounded-circle" src="${maintenancetimepreviewSrcs}">
            </li>
        `;
    });
}
        
        maintenanceattachmentsHtml += '</ul>';
        maintenancetimelineHtml += `
        <li class="timeline-item timeline-item-transparent border-dashed" data-index="${maintenanceoriginalIndex}">
            <span class="timeline-point timeline-point-info"></span>
    
            <div class="timeline-event">
    
                <div class="timeline-header mb-3">
                    <h6 class="mb-0 timeline-title">${maintenanceitem.added_info}</h6>
    
                    <div class="d-flex justify-content-end mb-2">
                        <button class="btn btn-sm btn-outline-primary me-1 editMaintenanceTimeline" data-id="${maintenanceitem.id}" data-index="${maintenanceoriginalIndex}">Edit</button>
                        <button class="btn btn-sm btn-outline-danger deleteMaintenanceTimeline" data-id="${maintenanceitem.id}" data-index="${maintenanceoriginalIndex}">Delete</button>
                    </div>
                </div>
    
                <div class="row g-2 mb-2">
    
                    <div class="col-md-6">
                        <small class="text-muted">Next Maintenance Date</small>
                        <div class="fw-medium">${formatDate(maintenanceitem.next_date)}</div>
                    </div>
    
                    <div class="col-md-6">
                        <small class="text-muted">Done Date</small>
                        <div class="fw-medium">${formatDate(maintenanceitem.done_date)}</div>
                    </div>
    
                    <div class="col-md-12">
                        <small class="text-muted">Remarks</small>
                        <p class="mb-1">${maintenanceitem.remarks || ''}</p>
                    </div>
    
                </div>
    
                <!-- Attachments -->
                <div class="mb-2">
                    <small class="text-muted d-block mb-1">Attachments</small>
    
                    <ul class="users-list d-flex align-items-center avatar-group m-0">
                        ${maintenanceattachmentsHtml}
                    </ul>
                </div>
    
            </div>
        </li>
        `;
    });
    $('#ul_maintenance_histroy_timeline').html(maintenancetimelineHtml);
}
$(document).on('click','.open-file-docs', function () {

    let fileUrl = $(this).data('img');
    let fileName = $(this).data('name');

    let ext = fileUrl.split('.').pop().toLowerCase();

    $('#filePreviewTitle').text(fileName);

    let content = '';

    // Image preview
    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
        content = `<img src="${fileUrl}" class="img-fluid rounded">`;
    }

    // PDF preview
    else if (ext === 'pdf') {
        content = `
            <iframe src="${fileUrl}" 
                    width="100%" 
                    height="600px"
                    style="border:none;">
            </iframe>`;
    }

    // Other files
    else {
        content = `
            <div class="text-center">
                <p>Preview not available</p>
                <a href="${fileUrl}" target="_blank" class="btn btn-primary">
                    Open / Download
                </a>
            </div>`;
    }

    $('#filePreviewBody').html(content);

    $('#filePreviewModal').modal('show');
});

// let fileStore = {
//   passing: []
// };

let fileStore = {
    passing: [],
    insurance: [],
    maintenance: []
};


function uploadModuleFiles(moduleKey, callback) {

    let files = fileStore[moduleKey] || [];

    let wrapper = $('#' + moduleKey + 'UploadProgressWrapper');
    let progressBar = $('#' + moduleKey + 'UploadProgressBar');

    if (!files || files.length === 0) {
        wrapper.hide();
        callback([]);
        return;
    }

    let uploadedResults = [];
    let completed = 0;
    let totalFiles = files.length;

    wrapper.removeClass('d-none').show();

    files.forEach((file) => {

        let formData = new FormData();
        formData.append("module", moduleKey);
        formData.append("files[]", file);

        $.ajax({
            url: '/UploadVehicleDocs',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,

            xhr: function () {
                let xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {

                        let percent = evt.loaded / evt.total;

                        let overall = Math.round(((completed + percent) / totalFiles) * 100);

                        progressBar
                            .css('width', overall + '%')
                            .text(overall + '%');
                    }
                });

                return xhr;
            },

            success: function (res) {

                if (typeof res === "string") {
                    res = JSON.parse(res);
                }

                // ✅ Extract only files
                if (res.status === "success" && Array.isArray(res.files)) {
                    uploadedResults.push(...res.files);
                }

                completed++;

                // ✅ All files uploaded
                if (completed === totalFiles) {

                    progressBar
                        .css('width', '100%')
                        .text('Completed');

                    setTimeout(() => {
                        wrapper.fadeOut();
                        progressBar.css('width', '0%').text('');
                    }, 800);

                    callback(uploadedResults); // ✅ ONLY files returned
                }
            },

            error: function () {
                alert('File upload failed');
            }
        });
    });
}
// For Vehicle Passing Details
 let editPassingTarget = null;

function resetPassingForm() {
  $('#nextDate').val('');
  $('#passingDate').val('');
  $('#addedinfo').val('');
  $('#passingremarks').val('');
  $('#passingattachments').val('');
  $('#PassingfilePreview').html('');
  selecteddocFiles= [];
  editPassingTarget = null;
  index = null;
  $('#formTitle').text('Add Passing Details');
  $('#passingUploadProgressWrapper').hide();
  $('#passingUploadProgressBar').css('width', '0%').text('0%');
}

$('#addTimelineBtn').click(function () {

  editPassingTarget = null;
  
 resetPassingForm();
  $('#passingFormCard').removeClass('d-none');
  
});




function generateUniqueId() {
    return Date.now() + '_' + Math.random().toString(36).substr(2, 9);
}
function ensureHistoryIds(history) {

    if (!Array.isArray(history)) return;

    history.forEach(item => {

        // ✅ Ensure record ID
        if (!item.id) {
            item.id = generateUniqueId();
        }

        // ✅ Ensure document IDs inside each record
        if (Array.isArray(item.documents)) {
            item.documents.forEach(doc => {
                if (!doc.id) {
                    doc.id = generateUniqueId();
                }
            });
        }
    });
}

function renderFilePreview(moduleKey, containerId, historyData, index) {

    let container = $('#' + containerId);
    container.empty();

    let files = fileStore[moduleKey] || [];

    // ✅ EXISTING FILES (EDIT MODE)
    if (
        index !== null &&
        historyData[index] &&
        Array.isArray(historyData[index].documents)
    ) {

        let item = historyData[index];

        item.documents.forEach(doc => {

            if (!doc || !doc.url) return;

            // ✅ Ensure ID
            if (!doc.id) {
                doc.id = Date.now() + '_' + Math.random();
            }

            let ext = doc.url.includes('.') 
                ? doc.url.split('.').pop().toLowerCase()
                : '';

            let previewSrc = getFilePreview(ext, doc.url);

            let finalSrc = ['jpg','jpeg','png','gif','webp'].includes(ext)
                ? 'httpdocs/' + doc.url
                : previewSrc;

            container.append(buildPreviewItem({
                previewIcon: finalSrc,
                fileUrl: 'httpdocs/' + doc.url,
                fileName: doc.name || '',
                type: 'existing',
                id: doc.id,
                module: moduleKey
            }));
        });
    }

    // ✅ NEW FILES
    files.forEach(file => {

        if (!file || !file.name) return;

        // ✅ assign unique ID
        if (!file._id) {
            file._id = Date.now() + '_' + Math.random();
        }

        let blobUrl = URL.createObjectURL(file);

        let ext = file.name.includes('.') 
            ? file.name.split('.').pop().toLowerCase()
            : '';

        let previewSrc = getFilePreview(ext, blobUrl);

        container.append(buildPreviewItem({
            previewIcon: previewSrc,
            fileUrl: blobUrl,
            fileName: file.name,
            type: 'new',
            id: file._id,
            module: moduleKey
        }));
    });
}

function buildPreviewItem({ previewIcon, fileUrl, fileName, type, id, module }) {

    return `
    <li class="avatar avatar-lg pull-up me-1 open-preview"
        data-img="${fileUrl}"
        data-name="${fileName}"
        data-type="${type}"
        data-id="${id}"
        data-module="${module}"
        title="${fileName}">

        <img class="rounded-circle" src="${previewIcon}" />

        <span class="remove-file"
              data-type="${type}"
              data-id="${id}"
              data-module="${module}">&times;</span>

    </li>`;
}
let moduleConfig = {
    passing: {
        history: () => passingHistory,
        getEditIndex: () => editPassingTarget,
        previewId: 'PassingfilePreview'
    },
    insurance: {
        history: () => insuranceHistory,
        getEditIndex: () => editInsuranceTarget,
        previewId: 'InsurancefilePreview'
    },
    maintenance: {
        history: () => maintenanceHistory,
        getEditIndex: () => editMaintenanceTarget,
        previewId: 'MaintenancefilePreview'
    }
};
$(document).on('click', '.remove-file', function (e) {

    e.stopPropagation();

    let module = $(this).data('module');
    let type = $(this).data('type');
    let id = $(this).data('id');

   let config = moduleConfig[module];
if (!config) return;

let history = config.history(); // ✅ dynamic reference
let historyIndex = config.getEditIndex();

    // ✅ NEW FILES
    if (type === 'new') {

        fileStore[module] = (fileStore[module] || []).filter(file => file._id !== id);

        renderFilePreview(module, config.previewId, history, historyIndex);
        return;
    }

    // ✅ EXISTING FILES (REMOVE ALWAYS WORKS)
    if (type === 'existing') {

        // 🔹 Try edit mode first
        if (historyIndex !== null && history[historyIndex]) {

            history[historyIndex].documents =
                (history[historyIndex].documents || []).filter(doc => doc.id !== id);

        } 
        else {
            
            // 🔹 Fallback: find record globally by document id
            let record = history.find(item =>
                item.documents && item.documents.some(doc => doc.id === id)
            );

            if (record) {
                record.documents =
                    record.documents.filter(doc => doc.id !== id);
            } else {
                console.warn('Record not found for document id:', id);
                return;
            }
        }

        renderFilePreview(module, config.previewId, history, historyIndex);
    }
});


$(document).on('click', '.open-preview', function () {

    let fileUrl = $(this).data('img');
    let fileName = $(this).data('name');

    let ext = fileUrl.split('.').pop().toLowerCase();

    $('#filePreviewTitle').text(fileName);

    let content = '';

    if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
        content = `<img src="${fileUrl}" class="img-fluid">`;
    }
    else if (ext === 'pdf') {
        content = `<iframe src="${fileUrl}" width="100%" height="600px"></iframe>`;
    }
    else {
        content = `<a href="${fileUrl}" target="_blank" class="btn btn-primary">Open File</a>`;
    }

    $('#filePreviewBody').html(content);
    $('#filePreviewModal').modal('show');
});

function toggleSaveLoaderByModule(module, show = true) {

    let btn = $(`#save_${module}`);

    if (!btn.length) return;

    if (show) {
        btn.prop('disabled', true);
        btn.find('.btn-text').addClass('d-none');
        btn.find('.btn-loader').removeClass('d-none');
    } else {
        btn.prop('disabled', false);
        btn.find('.btn-text').removeClass('d-none');
        btn.find('.btn-loader').addClass('d-none');
    }
}

$(document).on('click', '.editPassingTimeline', function () {

    let id = $(this).data('id');

    let index = passingHistory.findIndex(item => item.id == id);

    if (index === -1) {
        console.error('Invalid record ID:', id);
        return;
    }

    let item = passingHistory[index];

    $('#addedinfo').val(item.added_info);
    $('#nextDate').val(item.next_date);
    $('#passingDate').val(item.done_date);
    $('#passingremarks').val(item.remarks);

    fileStore['passing'] = [];

    editPassingTarget = index;

    renderFilePreview('passing', 'PassingfilePreview', passingHistory, index);
  

    $('#formTitle').text('Save Passing Details');
    $('#passingFormCard').removeClass('d-none');
  let modalBody = $('#vehicleDetailsModal .modal-body');

    setTimeout(() => {
        modalBody.animate({
            scrollTop: $('#passingFormCard').position().top
        }, 400);
    }, 100);
});




$('#passingattachments').on('change', function (e) {

    let newFiles = Array.from(e.target.files);

    if (!fileStore['passing']) {
        fileStore['passing'] = [];
    }

    newFiles.forEach(file => {
        fileStore['passing'].push(file);
    });

    $(this).val('');

    renderFilePreview('passing', 'PassingfilePreview', passingHistory, editPassingTarget);
});

let isUploadingPassing = false;

$('#savePassing').on('click', function () {

    if (isUploadingPassing) return; // ❌ prevent double click

    isUploadingPassing = true;

    $('#savePassing').prop('disabled', true);
    toggleSaveLoaderByModule('passing', true);


    // ✅ Step 1: Upload files
    uploadModuleFiles('passing', function (uploadedFiles) {

        try {

            // ✅ Step 2: Prepare existing documents
            let existingDocs = [];

            if (editPassingTarget !== null &&
                passingHistory[editPassingTarget]?.documents) {

                existingDocs = passingHistory[editPassingTarget].documents
                    .filter(doc => !doc.isDeleted);
            }
           
         let newDocs = [];

            (uploadedFiles || []).forEach(res => {
            
                // ✅ Handle direct file object response
                if (res && res.url) {
            
                    newDocs.push({
                        name: res.name || 'File',
                        url: res.url,
                        isNew: false,
                        id: generateUniqueId()
                    });
                }
            
                // (Optional fallback if backend later changes format)
                else if (res.status === 'success' && Array.isArray(res.files)) {
            
                    res.files.forEach(file => {
                        if (!file.url) return;
            
                        newDocs.push({
                            name: file.name || 'File',
                            url: file.url,
                            isNew: false,
                            id: generateUniqueId()
                        });
                    });
                }

});

            let finalDocs = [...existingDocs, ...newDocs];

          
            let node = {
                id: Date.now() + '_' + Math.random(),
                added_info: $('#addedinfo').val(),
                next_date: $('#nextDate').val(),
                done_date: $('#passingDate').val(),
                remarks: $('#passingremarks').val(),
                documents: finalDocs
            };

            
            if (editPassingTarget !== null) {
                passingHistory[editPassingTarget] = {
                    ...passingHistory[editPassingTarget],
                    ...node
                };
            } else {
                passingHistory.push(node);
            }

            renderPassingTimeline(passingHistory);

           
            savePassingToDB(function () {

             
                fileStore['passing'] = [];
                editPassingTarget = null;

                toggleSaveLoaderByModule('passing', false);
                $('#savePassing').prop('disabled', false);
                isUploadingPassing = false;
            });

        } catch (err) {

            console.error('Error in passing save flow:', err);

            toggleSaveLoaderByModule('passing', false);
            $('#savePassing').prop('disabled', false);
            isUploadingPassing = false;
        }

    });
});
function savePassingToDB(callback = null,actionOverride = null) {

    let formData = new FormData();

   let action_cate = actionOverride 
        ? actionOverride 
        : (editPassingTarget !== null ? 'edit' : 'add');
    

    let nextDates = passingHistory
        .map(item => item.next_date)
        .filter(date => date); 

    let next_passing_date = null;

    let today = new Date();
        today.setHours(0,0,0,0); // normalize
        
        let futureDates = nextDates.filter(date => {
            let d = new Date(date);
            d.setHours(0,0,0,0);
            return d >= today; // only today or future
        });
        
        if (futureDates.length > 0) {
            next_passing_date = futureDates.reduce((nearest, current) => {
                return new Date(current) < new Date(nearest) ? current : nearest;
            });
        }
   
    let payload = {
        action: 'passing',
        action_cate: action_cate,
        editIndex: editPassingTarget !== null ? editPassingTarget : null,
        next_passing_date: next_passing_date,
        passingHistory: passingHistory,
        vehicleId:$('#hid_vehicle_id_info_modal').val()
    };

    formData.append('payload', JSON.stringify(payload));

    $.ajax({
        url: '/VehicleStatusJsonController', // your endpoint
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {

    // If response is string → convert to JSON
    if (typeof res === "string") {
        res = JSON.parse(res);
    }

    console.log("SERVER RESPONSE:", res);

    
    if (res.status === true) {

        let rows = res.data?.rows_affected || 0;
        
         let successMessage = '';
        
            if (action_cate === 'delete') {
                successMessage = "Passing details deleted successfully";
            } else if (editPassingTarget !== null) {
                successMessage = "Passing details updated successfully";
            } else {
                successMessage = "Passing details added successfully";
            }
            
          setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + successMessage,
                'click'
            );
        
       setTimeout(function () {

            $('#dropdownContent')
                .appendTo('body')   
                .css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    zIndex: 9999999
                });
        
        }, 0);
         
      if (callback) callback();
        resetPassingForm();
       $('#passingFormCard').addClass('d-none');


    } else {
     toggleSaveLoaderByModule('passing', false);
        alert(res.message || "Something went wrong");
    }
},
        error: function (err) {
            console.error("SAVE ERROR:", err);
            toggleSaveLoaderByModule('passing', false);
            alert('Error saving data');
        }
    });
}


let deletePassingIndex = null;
$(document).on('click', '.deletePassingTimeline', function () {

    let index = $(this).data('index');

    if (index === undefined) {
        console.warn("Invalid index for delete");
        return;
    }

    deletePassingIndex = index; // ✅ store globally

    SaNDSAlert(
        'Are you sure you want to delete this entry?',
        'deletePasingTimeline',
        'danger',
        '#C70039',
        'Yes, I am sure'
    );
   
     // ✅ Fix layering AFTER render
    setTimeout(function () {
        $('#popupOverlay').css({
            zIndex: 999998,
            position: 'fixed'
        });

        $('#popupContainer').css({
            zIndex: 999999,
            position: 'fixed'
        });

    }, 0);
    
});

function deletePasingTimeline() {

    if (deletePassingIndex === null || deletePassingIndex === undefined) {
        console.warn("No index set for deletion");
        return;
    }

    passingHistory.splice(deletePassingIndex, 1);

    // Reset index
    deletePassingIndex = null;

    renderPassingTimeline(passingHistory);

    savePassingToDB(null, 'delete');
}


$('#closeFormPassing').click(function () {
    resetPassingForm();
    $('#passingFormCard').addClass('d-none');
  
});
 
 
 
 
 
 // Insurance Module
 
 
 let editInsuranceTarget = null;

function resetInsuranceForm() {
  $('#insurancenextDate').val('');
  $('#insuranceDate').val('');
  $('#insuranceaddedinfo').val('');
  $('#insuranceremarks').val('');
  $('#insuranceattachments').val('');
  $('#InsurancefilePreview').html('');
  insuranceselecteddocFiles= [];
  editInsuranceTarget = null;
  insuranceindex = null;
  $('#insuranceformTitle').text('Add Insurance Details');
  $('#insuranceUploadProgressWrapper').hide();
  $('#insuranceUploadProgressBar').css('width', '0%').text('0%');
  
}

$('#insuranceaddTimelineBtn').click(function () {

  editInsuranceTarget = null;
  
 resetInsuranceForm();
  $('#insuranceFormCard').removeClass('d-none');
  
});


$(document).on('click', '.editInsuranceTimeline', function () {

    let id = $(this).data('id');

    let index = insuranceHistory.findIndex(item => item.id == id);

    if (index === -1) {
        console.error('Invalid record ID:', id);
        return;
    }

    let item = insuranceHistory[index];

    $('#insuranceaddedinfo').val(item.added_info);
    $('#insurancenextDate').val(item.next_date);
    $('#insuranceDate').val(item.done_date);
    $('#insuranceremarks').val(item.remarks);

    fileStore['insurance'] = [];

    editInsuranceTarget = index;

    renderFilePreview('insurance', 'InsurancefilePreview', insuranceHistory, index);
  

    $('#insuranceformTitle').text('Save Insurance Details');
    $('#insuranceFormCard').removeClass('d-none');
   let modalBody = $('#vehicleDetailsModal .modal-body');

    setTimeout(() => {
        modalBody.animate({
            scrollTop: $('#insuranceFormCard').position().top
        }, 400);
    }, 100);
});

$('#insuranceattachments').on('change', function (e) {

    let newFiles = Array.from(e.target.files);

    if (!fileStore['insurance']) {
        fileStore['insurance'] = [];
    }

    newFiles.forEach(file => {
        fileStore['insurance'].push(file);
    });

    $(this).val('');

    renderFilePreview('insurance', 'InsurancefilePreview', insuranceHistory, editInsuranceTarget);
});

let isUploadingInsurance = false;

$('#saveInsurance').on('click', function () {

    if (isUploadingInsurance) return; // ❌ prevent double click

    isUploadingInsurance = true;

    $('#saveInsurance').prop('disabled', true);
    toggleSaveLoaderByModule('insurance', true);


    // ✅ Step 1: Upload files
    uploadModuleFiles('insurance', function (uploadedFiles) {

        try {

            // ✅ Step 2: Prepare existing documents
            let existingDocs = [];

            if (editInsuranceTarget !== null &&
                insuranceHistory[editInsuranceTarget]?.documents) {

                existingDocs = insuranceHistory[editInsuranceTarget].documents
                    .filter(doc => !doc.isDeleted);
            }
           
         let newDocs = [];

            (uploadedFiles || []).forEach(res => {
            
                // ✅ Handle direct file object response
                if (res && res.url) {
            
                    newDocs.push({
                        name: res.name || 'File',
                        url: res.url,
                        isNew: false,
                        id: generateUniqueId()
                    });
                }
            
                // (Optional fallback if backend later changes format)
                else if (res.status === 'success' && Array.isArray(res.files)) {
            
                    res.files.forEach(file => {
                        if (!file.url) return;
            
                        newDocs.push({
                            name: file.name || 'File',
                            url: file.url,
                            isNew: false,
                            id: generateUniqueId()
                        });
                    });
                }

});

            let finalDocs = [...existingDocs, ...newDocs];

          
            let node = {
                id: Date.now() + '_' + Math.random(),
                added_info: $('#insuranceaddedinfo').val(),
                next_date: $('#insurancenextDate').val(),
                done_date: $('#insuranceDate').val(),
                remarks: $('#insuranceremarks').val(),
                documents: finalDocs
            };

            
            if (editInsuranceTarget !== null) {
                insuranceHistory[editInsuranceTarget] = {
                    ...insuranceHistory[editInsuranceTarget],
                    ...node
                };
            } else {
                insuranceHistory.push(node);
            }

            renderInsuranceTimeline(insuranceHistory);

           
            saveInsuranceToDB(function () {

             
                fileStore['insurance'] = [];
                editInsuranceTarget = null;

                toggleSaveLoaderByModule('insurance', false);
                $('#saveInsurance').prop('disabled', false);
                isUploadingInsurance = false;
            });

        } catch (err) {

            console.error('Error in insurance save flow:', err);

            toggleSaveLoaderByModule('insurance', false);
            $('#saveInsurance').prop('disabled', false);
            isUploadingInsurance = false;
        }

    });
});


function saveInsuranceToDB(callback = null,actionOverride = null) {

    let formData = new FormData();

   let action_cate = actionOverride 
        ? actionOverride 
        : (editInsuranceTarget !== null ? 'edit' : 'add');
    

    let nextDates = insuranceHistory
        .map(item => item.next_date)
        .filter(date => date); 

    let next_insurance_date = null;

     let today = new Date();
        today.setHours(0,0,0,0); // normalize
        
        let futureDates = nextDates.filter(date => {
            let d = new Date(date);
            d.setHours(0,0,0,0);
            return d >= today; // only today or future
        });
        
        if (futureDates.length > 0) {
            next_insurance_date = futureDates.reduce((nearest, current) => {
                return new Date(current) < new Date(nearest) ? current : nearest;
            });
        }
   
   
    let payload = {
        action: 'insurance',
        action_cate: action_cate,
        editIndex: editInsuranceTarget !== null ? editInsuranceTarget : null,
        next_insurance_date: next_insurance_date,
        insuranceHistory: insuranceHistory,
        vehicleId:$('#hid_vehicle_id_info_modal').val()
    };

    formData.append('payload', JSON.stringify(payload));

    $.ajax({
        url: '/VehicleStatusJsonController', // your endpoint
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {

    // If response is string → convert to JSON
    if (typeof res === "string") {
        res = JSON.parse(res);
    }

    
    if (res.status === true) {

        let rows = res.data?.rows_affected || 0;
        
         let successMessage = '';
        
            if (action_cate === 'delete') {
                successMessage = "Insurance details deleted successfully";
            } else if (editPassingTarget !== null) {
                successMessage = "Insurance details updated successfully";
            } else {
                successMessage = "Insurance details added successfully";
            }
            
          setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + successMessage,
                'click'
            );
        
       setTimeout(function () {

            $('#dropdownContent')
                .appendTo('body')   
                .css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    zIndex: 9999999
                });
        
        }, 0);
         
      if (callback) callback();
        resetInsuranceForm();
       $('#insuranceFormCard').addClass('d-none');


    } else {
     toggleSaveLoaderByModule('insurance', false);
        alert(res.message || "Something went wrong");
    }
},
        error: function (err) {
            console.error("SAVE ERROR:", err);
            toggleSaveLoaderByModule('insurance', false);
            alert('Error saving data');
        }
    });
}


let deleteInsuranceIndex = null;
$(document).on('click', '.deleteInsuranceTimeline', function () {

    let index = $(this).data('index');

    if (index === undefined) {
        console.warn("Invalid index for delete");
        return;
    }

    deleteInsuranceIndex = index; // ✅ store globally

    SaNDSAlert(
        'Are you sure you want to delete this entry?',
        'deleteInsuranceTimeline',
        'danger',
        '#C70039',
        'Yes, I am sure'
    );
   
     // ✅ Fix layering AFTER render
    setTimeout(function () {
        $('#popupOverlay').css({
            zIndex: 999998,
            position: 'fixed'
        });

        $('#popupContainer').css({
            zIndex: 999999,
            position: 'fixed'
        });

    }, 0);
    
});

function deleteInsuranceTimeline() {

    if (deleteInsuranceIndex === null || deleteInsuranceIndex === undefined) {
        console.warn("No index set for deletion");
        return;
    }

    insuranceHistory.splice(deleteInsuranceIndex, 1);

    // Reset index
    deleteInsuranceIndex = null;

    renderInsuranceTimeline(insuranceHistory);

    saveInsuranceToDB(null, 'delete');
}


$('#closeFormInsurance').click(function () {
    resetInsuranceForm();
    $('#insuranceFormCard').addClass('d-none');
  
});


// Maintenance Module
 
 
 let editMaintenanceTarget = null;

function resetMaintenanceForm() {
  $('#maintenancenextDate').val('');
  $('#maintenanceDate').val('');
  $('#maintenanceaddedinfo').val('');
  $('#maintenanceremarks').val('');
  $('#maintenanceattachments').val('');
  $('#MaintenancefilePreview').html('');
   maintenanceselecteddocFiles= [];
  editMaintenanceTarget = null;
  maintenanceindex = null;
  $('#maintenanceformTitle').text('Add Maintenance Details');
  $('#maintenanceUploadProgressWrapper').hide();
$('#maintenanceUploadProgressBar').css('width', '0%').text('0%');
}

$('#maintenanceaddTimelineBtn').click(function () {

  editMaintenanceTarget = null;
  
 resetMaintenanceForm();
  $('#maintenanceFormCard').removeClass('d-none');
  
});



$(document).on('click', '.editMaintenanceTimeline', function () {

    let id = $(this).data('id');

    let index = maintenanceHistory.findIndex(item => item.id == id);

    if (index === -1) {
        console.error('Invalid record ID:', id);
        return;
    }

    let item = maintenanceHistory[index];

    $('#maintenanceaddedinfo').val(item.added_info);
    $('#maintenancenextDate').val(item.next_date);
    $('#maintenanceDate').val(item.done_date);
    $('#maintenanceremarks').val(item.remarks);

    fileStore['maintenance'] = [];

    editMaintenanceTarget = index;

    renderFilePreview('maintenance', 'MaintenancefilePreview', maintenanceHistory, index);
  

    $('#maintenanceformTitle').text('Save Maintenance Details');
    $('#maintenanceFormCard').removeClass('d-none');
  let modalBody = $('#vehicleDetailsModal .modal-body');

    setTimeout(() => {
        modalBody.animate({
            scrollTop: $('#maintenanceFormCard').position().top
        }, 400);
    }, 100);
});




$('#maintenanceattachments').on('change', function (e) {

    let newFiles = Array.from(e.target.files);

    if (!fileStore['maintenance']) {
        fileStore['maintenance'] = [];
    }

    newFiles.forEach(file => {
        fileStore['maintenance'].push(file);
    });

    $(this).val('');

    renderFilePreview('maintenance', 'MaintenancefilePreview', maintenanceHistory, editMaintenanceTarget);
});

let isUploadingMaintenance = false;

$('#saveMaintenance').on('click', function () {

    if (isUploadingMaintenance) return; // ❌ prevent double click

    isUploadingMaintenance = true;

    $('#saveMaintenance').prop('disabled', true);
    toggleSaveLoaderByModule('maintenance', true);


    // ✅ Step 1: Upload files
    uploadModuleFiles('maintenance', function (uploadedFiles) {

        try {

            // ✅ Step 2: Prepare existing documents
            let existingDocs = [];

            if (editMaintenanceTarget !== null &&
                maintenanceHistory[editMaintenanceTarget]?.documents) {

                existingDocs = maintenanceHistory[editMaintenanceTarget].documents
                    .filter(doc => !doc.isDeleted);
            }
           
         let newDocs = [];

            (uploadedFiles || []).forEach(res => {
            
                // ✅ Handle direct file object response
                if (res && res.url) {
            
                    newDocs.push({
                        name: res.name || 'File',
                        url: res.url,
                        isNew: false,
                        id: generateUniqueId()
                    });
                }
            
                // (Optional fallback if backend later changes format)
                else if (res.status === 'success' && Array.isArray(res.files)) {
            
                    res.files.forEach(file => {
                        if (!file.url) return;
            
                        newDocs.push({
                            name: file.name || 'File',
                            url: file.url,
                            isNew: false,
                            id: generateUniqueId()
                        });
                    });
                }

});

            let finalDocs = [...existingDocs, ...newDocs];

          
            let node = {
                id: Date.now() + '_' + Math.random(),
                added_info: $('#maintenanceaddedinfo').val(),
                next_date: $('#maintenancenextDate').val(),
                done_date: $('#maintenanceDate').val(),
                remarks: $('#maintenanceremarks').val(),
                documents: finalDocs
            };

            
            if (editMaintenanceTarget !== null) {
                maintenanceHistory[editMaintenanceTarget] = {
                    ...maintenanceHistory[editMaintenanceTarget],
                    ...node
                };
            } else {
                maintenanceHistory.push(node);
            }

            renderMaintenanceTimeline(maintenanceHistory);

           
            saveMaintenanceToDB(function () {

             
                fileStore['maintenance'] = [];
                editMaintenanceTarget = null;

                toggleSaveLoaderByModule('maintenance', false);
                $('#saveMaintenance').prop('disabled', false);
                isUploadingMaintenance = false;
            });

        } catch (err) {

            console.error('Error in maintenance save flow:', err);

            toggleSaveLoaderByModule('maintenance', false);
            $('#saveMaintenance').prop('disabled', false);
            isUploadingMaintenance = false;
        }

    });
});
function saveMaintenanceToDB(callback = null,actionOverride = null) {

    let formData = new FormData();

   let action_cate = actionOverride 
        ? actionOverride 
        : (editMaintenanceTarget !== null ? 'edit' : 'add');
    

    let nextDates = maintenanceHistory
        .map(item => item.next_date)
        .filter(date => date); 

    let next_maintenance_date = null;

     let today = new Date();
        today.setHours(0,0,0,0); // normalize
        
        let futureDates = nextDates.filter(date => {
            let d = new Date(date);
            d.setHours(0,0,0,0);
            return d >= today; // only today or future
        });
        
        if (futureDates.length > 0) {
            next_maintenance_date = futureDates.reduce((nearest, current) => {
                return new Date(current) < new Date(nearest) ? current : nearest;
            });
        }
   
   
    let payload = {
        action: 'maintenance',
        action_cate: action_cate,
        editIndex: editMaintenanceTarget !== null ? editMaintenanceTarget : null,
        next_maintenance_date: next_maintenance_date,
        maintenanceHistory: maintenanceHistory,
        vehicleId:$('#hid_vehicle_id_info_modal').val()
    };

    formData.append('payload', JSON.stringify(payload));

    $.ajax({
        url: '/VehicleStatusJsonController', 
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {

    
    if (typeof res === "string") {
        res = JSON.parse(res);
    }

    
    if (res.status === true) {

        let rows = res.data?.rows_affected || 0;
        
         let successMessage = '';
        
            if (action_cate === 'delete') {
                successMessage = "Maintenance details deleted successfully";
            } else if (editMaintenanceTarget !== null) {
                successMessage = "Maintenance details updated successfully";
            } else {
                successMessage = "Maintenance details added successfully";
            }
            
          setupDropdown(
                'dropdownContent',
                'success',
                svgSuccess + successMessage,
                'click'
            );
        
       setTimeout(function () {

            $('#dropdownContent')
                .appendTo('body')   
                .css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    zIndex: 9999999
                });
        
        }, 0);
         
      if (callback) callback();
        resetMaintenanceForm();
       $('#maintenanceFormCard').addClass('d-none');


    } else {
     toggleSaveLoaderByModule('maintenance', false);
        alert(res.message || "Something went wrong");
    }
},
        error: function (err) {
            console.error("SAVE ERROR:", err);
            toggleSaveLoaderByModule('maintenance', false);
            alert('Error saving data');
        }
    });
}


let deleteMaintenanceIndex = null;
$(document).on('click', '.deleteMaintenanceTimeline', function () {

    let index = $(this).data('index');

    if (index === undefined) {
        console.warn("Invalid index for delete");
        return;
    }
    deleteMaintenanceIndex = index; // ✅ store globally

    SaNDSAlert(
        'Are you sure you want to delete this entry?',
        'deleteMaintenanceTimeline',
        'danger',
        '#C70039',
        'Yes, I am sure'
    );
   
     // ✅ Fix layering AFTER render
    setTimeout(function () {
        $('#popupOverlay').css({
            zIndex: 999998,
            position: 'fixed'
        });

        $('#popupContainer').css({
            zIndex: 999999,
            position: 'fixed'
        });

    }, 0);
    
});

function deleteMaintenanceTimeline() {

    if (deleteMaintenanceIndex === null || deleteMaintenanceIndex === undefined) {
        console.warn("No index set for deletion");
        return;
    }

    maintenanceHistory.splice(deleteMaintenanceIndex, 1);

    // Reset index
    deleteMaintenanceIndex = null;

    renderMaintenanceTimeline(maintenanceHistory);

    saveMaintenanceToDB(null, 'delete');
}


$('#closeFormMaintenance').click(function () {
    resetMaintenanceForm();
    $('#maintenanceFormCard').addClass('d-none');
  
});


//Booking Info

function renderBookingTable(data) {

    let rows = '';

    data.forEach((item, index) => {

        let customer = JSON.parse(item.customer_details_json || '{}');
        let booking = JSON.parse(item.book_details_json || '{}');

        // 🧑 Customer
        let customerHtml = `
            <div><b>${customer.customer_name || '-'}</b></div>
            <div>${customer.customer_code || ''}</div>
            <div>${customer.phone || ''}</div>
            <div>${customer.email || ''}</div>
        `;

        // 📅 Booking
        let bookingHtml = `
            <div><b>From:</b> ${booking.fromDate || '-'}</div>
            <div><b>To:</b> ${booking.toDate || '-'}</div>
            <div><b>Type:</b> ${booking.rateType || '-'}</div>
            <div><b>Service:</b> ${booking.service || '-'}</div>
             <div>
                <a href="javascript:void(0)" 
                   class="viewNotes text-primary" 
                   data-notes="${encodeURIComponent(booking.notes || 'No notes available')}">
                   View Notes
                </a>
            </div>
        `;

        // 💰 Pricing
        let pricingHtml = `
            <div><b>Duration:</b> ${booking.duration || 0}</div>
            <div><b>Price:</b> ${booking.price || 0}</div>
            <div><b>VAT:</b> ${booking.vat || 0}%</div>
            <div><b>Total:</b> ${booking.total || 0}</div>
        `;

        // ⚙️ Action Dropdown
        let actionHtml = `
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    Action
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item  deleteBooking" data-id="${item.ids}" style="cursor: pointer;"><i class="ri ri-delete-bin-line me-2 text-danger"></i> Delete
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item changeStatus" data-id="${item.ids}" data-status="Confirmed" style="cursor: pointer;">
                            ✅ Confirm
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item changeStatus" data-id="${item.ids}" data-status="Cancelled" style="cursor: pointer;">
                            ❌ Cancel
                        </a>
                    </li>
                </ul>
            </div>
        `;
            let status = item.book_status || 'Booked';
            
            let statusBadge = '';
            
            if (status === 'Booked') {
                statusBadge = `<span class="badge bg-warning ">Booked</span>`;
            } else if (status === 'Confirmed') {
                statusBadge = `<span class="badge bg-success">Confirmed</span>`;
            } else if (status === 'Cancelled') {
                statusBadge = `<span class="badge bg-danger">Cancelled</span>`;
            } else {
                statusBadge = `<span class="badge bg-secondary">${status}</span>`;
            }
        rows += `
            <tr>
                <td>${index + 1}</td>
                <td><b>${item.booking_no}</b></td>
                <td>${customerHtml}</td>
                <td>${bookingHtml}</td>
                <td>${pricingHtml}</td>
               <td>${statusBadge}</td>
                <td>${actionHtml}</td>
            </tr>
        `;
    });
        if ($.fn.DataTable.isDataTable('#bookingTable')) {
            $('#bookingTable').DataTable().clear().destroy();
        }

   $('#bookingTable tbody').empty().html(rows);
    $('#bookingTable tbody').html(rows);
    let bookingTable = $('#bookingTable').DataTable({
    destroy: true,
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    paging: true,
    pageLength: 30,
    lengthChange: false,
    info: true,
    ordering: false,
    searching: true,

    // ✅ Remove default search bar
    dom: '<"row"<"col-12">><"row"<"col-12"tr>>'
});
   $('#bookingSearch').off('keyup').on('keyup', function () {
    bookingTable.search(this.value).draw();
});
}
$(document).on('click', '.viewNotes', function () {

    let notes = decodeURIComponent($(this).data('notes'));

    $('#notesContent').html(notes);

    new bootstrap.Modal(document.getElementById('notesModal')).show();
});
function loadBookingTable(vehicle_id) {

    $.ajax({
        url: '/VehicleStatusController',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'get_all_bookings',
            vehicle_id:$('#hid_vehicle_id_info_modal').val()
        },
        success: function (res) {

            if (res.status) {
                renderBookingTable(res.data);
                
            }
        }
    });
}

//Contarct Info

function renderContractTable(data) {

    let rows = '';

    data.forEach((item, index) => {

     
        rows += `
            <tr>
                <td>${index + 1}</td>
                <td> <div class="view_contract " style=" cursor: pointer;text-decoration: underline;color: #0d6efd;opacity: 0.8;" data-contract="${item.agreement_no}">
                            <div class="fw-bold small">${item.agreement_no}</div>
                            <div class="text-muted" style="font-size:11px;">
                                ${item.agreement_status}
                            </div>
                           
                        </div></td>
                <td><div>
                            <div class="fw-bold small">${item.customer_name}</div>
                            <div class="text-muted" style="font-size:11px;">
                                ${item.customer_mobile}
                            </div>
                        </div></td>
                
                <td><div>
                            <div class="fw-bold small">${item.service_type}</div>
                            <div class="text-muted" style="font-size:11px;">
                                ${item.start_date} - ${item.return_date_format}
                            </div>
                        </div></td>
                        <td>${item.days_left ?? '-'}</td>
            </tr>
        `;
    });
        if ($.fn.DataTable.isDataTable('#vehicleInfoModalContractTable')) {
            $('#vehicleInfoModalContractTable').DataTable().clear().destroy();
        }

    $('#vehicleInfoModalContractTable tbody').empty().html(rows);
    let contractTable = $('#vehicleInfoModalContractTable').DataTable({
    destroy: true,
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    paging: true,
    pageLength: 30,
    lengthChange: false,
    info: true,
    ordering: false,
    searching: true,

    // ✅ Remove default search bar
    dom: '<"row"<"col-12">><"row"<"col-12"tr>>'
});
   $('#contractSearch').off('keyup').on('keyup', function () {
    contractTable.search(this.value).draw();
});
}

function loadContractTable(vehicle_id) {

    $.ajax({
        url: '/VehicleStatusController',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'get_all_contracts',
            vehicle_id:$('#hid_vehicle_id_info_modal').val()
        },
        success: function (res) {

            if (res.status) {
                renderContractTable(res.data);
                
            }
        }
    });
}

 $(document).on('click', '#contractTable div.view_contract', function (e) {

     let btn = this;

     
     let agreement_no = $(this).data('contract');
     
  fetch('/controller/ajax_encrypt_contract.php?contract_no=' + encodeURIComponent($.trim(agreement_no)))
        .then(res => res.text())
        .then(token => {
            if(!token) { Swal.fire('Error', 'Encryption failed.', 'error'); return; }
            window.open('/PrintAgreement?token=' + encodeURIComponent(token), '_blank');
        });
    

});
let confirmData = {};

function showConfirmModal({ title, message, confirmText = 'Confirm', type = 'danger', action, data }) {

    $('#confirmModalTitle').text(title);
    $('#confirmModalMessage').html(message);

    let btn = $('#confirmActionBtn');
    btn.text(confirmText);

    btn.removeClass('btn-danger btn-primary btn-success btn-warning')
       .addClass('btn-' + type);

    // store action + data
    confirmData = { action, data };

    new bootstrap.Modal(document.getElementById('confirmActionModal')).show();
}
$(document).on('click', '#confirmActionBtn', function () {

    if (!confirmData.action) return;

    $.ajax({
        url: '/VehicleStatusController',
        type: 'POST',
        dataType: 'json',
        data: confirmData.data,
        success: function (res) {
            if (res.status) {
                
                 setupDropdown('dropdownContent', 'success', svgSuccess + 'Action completed successfully', 'click');
                 loadBookingTable($('#hid_vehicle_id_info_modal').val());
            }
        }
    });

    let modalEl = document.getElementById('confirmActionModal');
    let modal = bootstrap.Modal.getInstance(modalEl);

    // 🔥 Move focus BEFORE closing modal
    document.activeElement.blur();

    modal.hide();
});

$(document).on('click', '.deleteBooking', function () {

    let id = $(this).data('id');

     showConfirmModal({
        title: 'Delete Booking',
        message: 'Are you sure you want to delete this booking?',
        confirmText: 'Yes, Delete',
        type: 'danger',
        action: 'delete_booking',
        data: {
            action: 'delete_booking',
            bookingid: id
        }
    });
});

$(document).on('click', '.changeStatus', function () {

    let id = $(this).data('id');
    let status = $(this).data('status');
 showConfirmModal({
        title: 'Change Status',
        message: `Are you sure you want to change status to <b>${status}</b>?`,
        confirmText: 'Yes, Change',
        type: 'primary',
        action: 'change_booking_status',
        data: {
            action: 'change_booking_status',
            bookingid: id,
            bookingstatus: status
        }
    });
   
});
});