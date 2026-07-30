<div class="modal fade" id="signatureModal" tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header custom-modal-header">

                <h5 class="modal-title">

                    <i class="ri-quill-pen-line"></i>
                     Signatures

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row mb-4" >

                    <div class="col-md-6">
<input id="sig_modal_cashmemoid" type="hidden">
                        <label class="fw-bold">
                            Company Signature
                        </label>

                        <input type="text"
                               class="form-control mb-2"
                               id="hirer_name"
                               placeholder="Name">
                               <span id="hirer_signed_date" class="text-muted small"></span>

                        <canvas id="hirerCanvas"
                                style="width:100%;
                                       height:250px;
                                       border:1px solid #ccc;
                                       border-radius:10px;">
                        </canvas>

                        <button class="btn btn-danger btn-sm mt-2"
                                id="btnClearHirer">

                            Clear

                        </button>

                    </div>

                    <div class="col-md-6">

                        <label class="fw-bold">
                            Customer Acceptance Signature
                        </label>

                        <input type="text"
                               class="form-control mb-2"
                               id="delivery_name"
                               placeholder="Name">
                            <span id="delivery_signed_date" class="text-muted small"></span>
                        <canvas id="deliveryCanvas"
                                style="width:100%;
                                       height:250px;
                                       border:1px solid #ccc;
                                       border-radius:10px;">
                        </canvas>

                        <button class="btn btn-danger btn-sm mt-2"
                                id="btnClearDelivery">

                            Clear

                        </button>

                    </div>

                </div>
                

            </div>

            <div class="modal-footer">
<button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success"
                        id="btnSaveSignatures">
                    Save Signatures

                </button>

            </div>

        </div>

    </div>

</div>