<div class="modal fade" id="QtnAddNewCustomerModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
      <div class="modal-header custom-modal-header bg-danger">
        <h5 class="modal-title modal-title-custom text-white">Add New Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row">
        
       
                <div class="col-12">
                  
                         <div class="row">
                              <div class="col-4 mb-0 mt-2">
                                    <label for="customer_type_onmodal" class="form-label">Customer Type</label>
                                    <select id="customer_type_onmodal" name="customer_type_onmodal" class="form-select form-select-sm">
                                              <option value="" disabled="" selected="">Select</option>
                                              <option value="Individual">Individual</option>
                                              <option value="Corporate">Corporate</option>
                                              <option value="Agency">Agency</option>
                                    </select>
                            </div>
                            <div class="col-4 mb-0 mt-2">
                                    <label for="bookingCustomerName_onmodal" class="form-label">Customer Name</label>
                                    <input class="form-control form-control-sm" id="bookingCustomerName_onmodal" name="bookingCustomerName_onmodal" type="text">
                            </div>
                            <div class="col-4 mb-0 mt-2">
                                    <label for="customerMobile_onmodal" class="form-label">Telephone</label>
                                    <input class="form-control form-control-sm" id="customerMobile_onmodal" name="customerMobile_onmodal" type="text">
                            </div>
                        </div>
                        <div class="row">
                              <div class="col-4 mb-0 mt-2">
                                    <label for="customerEmail_onmodal" class="form-label">Email</label>
                                    <input class="form-control form-control-sm" id="customerEmail_onmodal" name="customerEmail_onmodal" type="text">
                            </div>
                            <div class="col-4 mb-0 mt-2">
                                    <label for="bookingCustomerAttn_onmodal" class="form-label">Attention</label>
                                    <input class="form-control form-control-sm" id="bookingCustomerAttn_onmodal" name="bookingCustomerAttn_onmodal" type="text">
                            </div>
                            <div class="col-4 mb-0 mt-2">
                                <label for="customerCprCr_onmodal" class="form-label">CPR/CR</label>
                                <input class="form-control form-control-sm" id="customerCprCr_onmodal" name="customerCprCr_onmodal" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 mb-0 mt-2">
                                <label for="cprexpiryDate_onmodal" class="form-label">CPR Expiry</label>
                                <input class="form-control form-control-sm" id="cprexpiryDate_onmodal" name="cprexpiryDate_onmodal" type="date">
                            </div>
                             <div class="col-8 mb-0 mt-2">
                                    <label for="bookingCustomerAddress_onmodal" class="form-label">Address</label>
                                    <textarea class="form-control form-control-sm" id="bookingCustomerAddress_onmodal" name="bookingCustomerAddress_onmodal" ></textarea>
                            </div>
                        </div>
                            
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4 mb-2">
                                 <!-- Left: Image Preview -->
                                 <ul id="rentalCarImages"
                                     class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                 </ul>
                             
                                 <!-- Right: Button -->
                                 <a href="javascript:;" class="ms-auto">
                                     <span class="badge bg-label-primary rounded-pill openAddRentalCarImageModal">
                                         Add Customer Documents
                                     </span>
                                 </a>
                             </div>
                      
                    
                </div>
               
       
      </div>

        <div class="modal-footer">
             <button class="btn btn-secondary me-2" data-bs-dismiss="modal">
                    Cancel
            </button>
          
            <button type="button"
                id="btn_add_new_customer"
                class="btn btn-primary me-2">
                Add
            </button>
        
        </div>

    </div>
  </div>
</div>
<script>

    let bookingMaster = {
        vehicles: []
    };

document.addEventListener('DOMContentLoaded', function() {
function resetRentCarUploadProgress() {
    $('#uploadrentCarImageDocumentProgress')
        .css('width', '0%')
        .text('0%');

    $('#uploadrentCarImageDocumentStatus').html('');
    $('#rentCarImage_upload_status').html('');
}
 $(document).on('click', '.openAddRentalCarImageModal', function(e) {
    
            e.preventDefault();
            e.stopPropagation();
            resetRentCarUploadProgress();
            //$('#rentCarImage_upload_status').html('');
            const modalEl = document.getElementById('addRentalCarImageModal');

            setTimeout(() => {
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }, 300);
        });

            const validationsRentCarImage = [{
                    id: '#rentCarImageName',
                    msg: 'Please enter document name'
                },
                {
                    id: '#rentCarImage_document',
                    msg: 'Please select a file',
                    type: 'file'
                }
            ];
              function validateForm(displayErrorDiv, validateFor) {
                for (let v of validateFor) {
                    if (v.type === 'file') {
                        if (!$(v.id)[0].files.length) return showError(v.id, v.msg, displayErrorDiv);
                    } else {
                        if (!$(v.id).val()) return showError(v.id, v.msg, displayErrorDiv);
                    }
                }
                return true;
            }

            function showError(selector, message, displayErrorDiv) {
                $('#' + displayErrorDiv)
                    .html(`<span class="text-danger">${message}</span>`);
                $(selector).focus();
                return false;
            }
             function resizeImage(file, callback) {
                const reader = new FileReader();
                const img = new Image();

                reader.onload = e => img.src = e.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');

                    const MAX = 2000;
                    let w = img.width;
                    let h = img.height;

                    if (w > MAX || h > MAX) {
                        const ratio = Math.min(MAX / w, MAX / h);
                        w *= ratio;
                        h *= ratio;
                    }

                    canvas.width = w;
                    canvas.height = h;
                    canvas.getContext('2d').drawImage(img, 0, 0, w, h);

                    canvas.toBlob(blob => callback(blob), 'image/jpeg', 0.85);
                };

                reader.readAsDataURL(file);
            }
             function getDocumentPreview(fileUrl) {

                let extension = fileUrl.split('.').pop().toLowerCase();

                switch (extension) {
                    case 'pdf':
                        return '/assets/icons/pdf.png';

                    case 'doc':
                    case 'docx':
                        return '/assets/icons/word.png';

                    case 'xls':
                    case 'xlsx':
                        return '/assets/icons/excel.png';

                    case 'ppt':
                    case 'pptx':
                        return '/assets/icons/ppt.png';

                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                    case 'webp':
                        return fileUrl; // actual image

                    default:
                        return '/assets/icons/file.png';
                }
            }

    let carRequiredControls = {
        validationStatusId: 'rentCarImage_upload_status',
        validationFunctionName: validationsRentCarImage,
        fileInputId: '#rentCarImage_document',
        formId: 'addRentalCarDetails',
        folderName: 'customerdocs',
        documentTypeControlId: '#rentCarImageName',
        callFunction : uploadVehicleFiles
    };     
   $('#addrentCarImageButton').on('click', function (e) {
                
        let clickedButton = this.id;
    
        if (clickedButton === 'addrentCarImageButton') {
    
            addBookingAndUploadImagesFunction(carRequiredControls);
        }

    
    });
    

//   function addBookingAndUploadImagesFunction(RequiredControlsNames){
                    
//      if (!validateForm(RequiredControlsNames.validationStatusId, RequiredControlsNames.validationFunctionName)) return;

//         const files = $(RequiredControlsNames.fileInputId)[0].files;
//         if (!files.length) return;

//         const form = document.getElementById(RequiredControlsNames.formId);
//         const tempFormData = new FormData(form);

//         tempFormData.append('foldername', RequiredControlsNames.folderName);
//         tempFormData.append('documentType', $(RequiredControlsNames.documentTypeControlId).val());

//         let processed = 0;

//         Array.from(files).forEach((file) => {

//             if (file.type.startsWith('image/')) {

//                 resizeImage(file, function (blob) {
//                     tempFormData.append('files[]', blob, file.name);
//                     processed++;
//                     //if (processed === files.length) uploadDriverFiles(tempFormData);
//                     if (processed === files.length) RequiredControlsNames.callFunction(tempFormData);
                    
//                 });

//             } else {

//                 tempFormData.append('files[]', file);
//                 processed++;
//                 //if (processed === files.length) uploadDriverFiles(tempFormData);
//                 if (processed === files.length) RequiredControlsNames.callFunction(tempFormData);

//             }

//         });

//     }
    function addBookingAndUploadImagesFunction(RequiredControlsNames) {

    if (!validateForm(
        RequiredControlsNames.validationStatusId,
        RequiredControlsNames.validationFunctionName
    )) {
        return;
    }

    const files = $(RequiredControlsNames.fileInputId)[0].files;

    if (!files || files.length === 0) {
        alert('Please select at least one file.');
        return;
    }

    const form = document.getElementById(RequiredControlsNames.formId);
    const tempFormData = new FormData(form);

    tempFormData.append('foldername', RequiredControlsNames.folderName);
    tempFormData.append(
        'documentType',
        $(RequiredControlsNames.documentTypeControlId).val()
    );

    let processed = 0;

    Array.from(files).forEach(file => {

        console.log('Uploading:', file.name, file.type);

        // Compress only images
        if (file.type && file.type.startsWith('image/')) {

            resizeImage(file, function(blob) {

                tempFormData.append(
                    'files[]',
                    blob,
                    file.name
                );

                processed++;

                if (processed === files.length) {
                    RequiredControlsNames.callFunction(tempFormData);
                }
            });

        } else {

            // PDF, DOC, DOCX, XLSX, TXT, ZIP, etc.
            tempFormData.append(
                'files[]',
                file,
                file.name
            );

            processed++;

            if (processed === files.length) {
                RequiredControlsNames.callFunction(tempFormData);
            }
        }
    });
}
     function uploadVehicleFiles(tempFormData) {

                    $.ajax({
                        url: '/UploadDocumentsCompressed',
                        type: 'POST',
                        data: tempFormData,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            let xhr = new XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(e) {
                                if (e.lengthComputable) {
                                    let percent = Math.round((e.loaded / e.total) * 100);
                                    $('#uploadrentCarImageDocumentProgress')
                                        .css('width', percent + '%')
                                        .text(percent + '%');
                                }
                            }, false);
    
                            return xhr;
                        },
                        beforeSend: function () {
                            
                            $('#uploadrentCarImageDocumentProgress')
                            .css('width', '0%')
                            .text('0%');

                            $('#rentCarImage_upload_status').html('Uploading...');

                            $('#rentCarImage_loader_spinner').show();
                        },

                        success: function (res) {
                            $('#uploadrentCarImageDocumentProgress')
                            .css('width', '100%')
                            .text('100%');
                            $('#uploadrentCarImageDocumentStatus').html('Process Completed Successfully');
                            $('#rentCarImage_upload_status').html(res.messsage);
                            if (res.status !== 'success') return;

                           
                           let vehiclesObj = {
                                documentName: $('#rentCarImageName').val(),
                                files: []
                            };
                      
                            
                            res.data.forEach(item => {

                                let fileUrl = (item.type === 'image') ? item.webp : item.file;

                                vehiclesObj.files.push(fileUrl);
                                let fileName = fileUrl.split('/').pop();

                               
                                    
                                // Preview UI
                                let previewSrc = getDocumentPreview(fileUrl);

                              let liHtml = `
                                        <li
                                            data-img="${fileUrl}"
                                            data-bs-toggle="tooltip"
                                            data-popup="tooltip-custom"
                                            data-bs-placement="top"
                                            title="${res.uploaded_by}"
                                            class="avatar avatar-lg pull-up">
                                            <img class="rounded-circle"
                                                 src="${previewSrc}"
                                                 alt="${res.uploaded_by}" />
                                        </li>
                                    `;

                                $('#rentalCarImages').append(liHtml);

                            });
                            
                            let tooltipTriggerList = [].slice.call(
                                document.querySelectorAll('[data-bs-toggle="tooltip"]')
                            );
                            tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                            
                            if (!bookingMaster.vehicles) {
                                bookingMaster.vehicles = [];
                            }
                            
                            bookingMaster.vehicles.push(vehiclesObj);


                            // Reset Form
                           
                            $('#addRentalCarDetails')[0].reset();

                            $('#rentCarImage_loader_spinner').hide();
                        },
                        error: function() {
                            $('#rentCarImage_upload_status').html('<span class="text-danger">Upload failed. Please try again.</span>');
                            $('#rentCarImage_loader_spinner').hide();
                        }

                    });

                }
                
                 let currentPreviewLi = null;
            $(document).on('click', '#rentalCarImages li', function() {

                // For Delete The Uploaded Images Identify Which li User Clicks
                currentPreviewLi = $(this); // store clicked li
                let imgSrc = $(this).data('img'); // get image path
                $('#filePreviewBody img').attr('src', imgSrc);
                // Close the Delete Process and Below of the Page Return Oter Process on the Line Number 1162
            


                var fileUrl = $(this).data('img');
                var ext = fileUrl.split('.').pop().toLowerCase();

                var html = '';

                // IMAGE FILES
                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    html = `<img src="${fileUrl}" class="img-fluid rounded" style="max-height:70vh;">`;
                }

                // PDF FILE
                else if (ext === 'pdf') {
                    html = `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
                }

                // WORD / EXCEL / PPT (Preview using Google Docs Viewer)
                else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
                    html = `
                    <iframe 
                        src="https://docs.google.com/gview?url="+baseUrl+"/${encodeURIComponent(fileUrl)}&embedded=true"
                        width="100%" height="600px" style="border:none;">
                    </iframe>`;
                }

                // UNSUPPORTED FILES
                else {
                                    html = `
                        <div class="alert alert-warning">
                            Preview not available.
                            <br>
                            <a href="${fileUrl}" target="_blank" class="btn btn-primary mt-2">
                            Download File
                            </a>
                        </div>`;
                }

                $('#filePreviewBody').html(html);
                $('#filePreviewModal').modal('show');
            });
                
    $('#deletePreviewImageBtn').on('click', function(){
                if(!currentPreviewLi) return;
            
                let imgSrc = currentPreviewLi.data('img');
            
                $.ajax({
                    url: '/DeleteUploadDocuments',
                    type: 'POST',
                    data: { file: imgSrc },
                    dataType: 'json',
                    success: function(res){
                        if(res.status === 'success'){
                            // Remove preview li
                            currentPreviewLi.remove();
                            $('#filePreviewModal').modal('hide');
                            currentPreviewLi = null;
                            removeFileFromBookingMaster(imgSrc);
                          
                        } else {
                            alert('Delete failed: ' + res.message);
                        }
                    },
                    error: function(xhr){
                      
                        alert('Server error while deleting files.');
                    }
                });
            });
            
            function removeFileFromBookingMaster(filePath){

                if (!bookingMaster || !Array.isArray(bookingMaster.vehicles)) return;
            
                bookingMaster.vehicles = bookingMaster.vehicles
                    .map(vehicle => {
                        if (Array.isArray(vehicle.files)) {
                            vehicle.files = vehicle.files.filter(f => f !== filePath);
                        }
                        return vehicle;
                    })
                    .filter(vehicle => Array.isArray(vehicle.files) && vehicle.files.length > 0);
            

            }

});

</script>
