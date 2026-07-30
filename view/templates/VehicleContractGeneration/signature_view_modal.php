<div class="modal fade" id="signatureModalView" tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header custom-modal-header">

                <h5 class="modal-title">

                    <i class="ri-quill-pen-line"></i>
                    Contract Signatures

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <input id="signaturebook_idsModal" type="hidden">
                <div class="row mb-4">
                    <div class="col-md-6">
                
                        <div class="card border shadow-sm h-100">
                
                            <div class="card-header ">
                
                                <h6 class="mb-0">
                
                                    <i class="ri-quill-pen-line"></i>
                                     Hirer Signature 
                
                                </h6>
                
                            </div>
                
                            <div class="card-body text-center">
                
                                <div id="latest_hirer_signature_container">
                
                                    <img id="latest_hirer_signature"
                                         class="img-fluid border rounded p-2 mb-3"
                                         style="max-height:150px; display:none;">
                
                                    <div id="no_hirer_signature"
                                         class="text-muted">
                
                                        No Hirer Signature Applied
                
                                    </div>
                
                                </div>
                
                                <table class="table table-sm mt-2">
                
                                    <tr>
                
                                        <th width="120">
                                            Signed By
                                        </th>
                
                                        <td id="latest_hirer_name">-</td>
                
                                    </tr>
                
                                    <tr>
                
                                        <th width="140">
                                            Signed Date
                                        </th>
                
                                        <td id="latest_hirer_date">-</td>
                
                                    </tr>
                
                                </table>
                
                            </div>
                
                        </div>
                
                    </div>
                   
                    <div class="col-md-6">
                
                        <div class="card border shadow-sm h-100">
                
                            <div class="card-header ">
                
                                <h6 class="mb-0">
                
                                    <i class="ri-user-received-line"></i>
                                     Delivered Signature 
                
                                </h6>
                
                            </div>
                
                            <div class="card-body text-center">
                
                                <div id="latest_delivery_signature_container">
                
                                    <img id="latest_delivery_signature"
                                         class="img-fluid border rounded p-2 mb-3"
                                         style="max-height:150px; display:none;">
                
                                    <div id="no_delivery_signature"
                                         class="text-muted">
                
                                        No Delivered Signature Applied
                
                                    </div>
                
                                </div>
                
                                <table class="table table-sm mt-2">
                
                                    <tr>
                
                                        <th width="120">
                                            Signed By
                                        </th>
                
                                        <td id="latest_delivery_name">-</td>
                
                                    </tr>
                
                                    <tr>
                
                                        <th width="140">
                                            Signed Date
                                        </th>
                
                                        <td id="latest_delivery_date">-</td>
                
                                    </tr>
                
                                </table>
                
                            </div>
                
                        </div>
                
                    </div>
                
                </div>

            </div>

            <div class="modal-footer ">
               <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-info btnOpenSignatureModal"
                        data-bs-toggle="tooltip"
                                title="Apply Signature">

                   <i class="ri ri-quill-pen-line"></i>
                    Apply Signatures

                </button>

            </div>

        </div>

    </div>

</div>