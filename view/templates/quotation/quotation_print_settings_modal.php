<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Quotation Configurator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!--<form action="generate_quotation.php" method="POST" target="_blank" id="configForm">-->
                  <form id="configForm" target="_blank">
                    <div class="row g-3">
                        
                        <!-- ID -->
                        <div class="col-12">
                            <label class="form-label">Quotation ID</label>
                            <input type="hidden" name="id" id="id" class="form-control" placeholder="e.g. 2939" required>
                            <input type="text" name="QtnRef" id="QtnRef" class="form-control"  required>
                        </div>

                        <!-- Orientation -->
                        <div class="col-md-6">
                            <label class="form-label">Page Orientation</label>
                            <select name="orientation" id="orientation" class="form-select">
                                <option value="L">Landscape</option>
                                <option value="P">Portrait</option>
                            </select>
                        </div>

                        <!-- Table Font -->
                        <div class="col-md-6">
                            <label class="form-label">Table Font Size</label>
                            <input type="number" step="0.5" name="font_size_table" id="font_size_table"
                                class="form-control" value="8">
                        </div>

                        <!-- Footer Logo X -->
                        <div class="col-md-6">
                            <label class="form-label">Footer Logo X (mm)</label>
                            <input type="number" name="footer_logo_x" id="footer_logo_x"
                                class="form-control" value="15">
                        </div>

                        <!-- Footer Logo Y -->
                        <div class="col-md-6">
                            <label class="form-label">Footer Logo Y (mm)</label>
                            <input type="number" name="footer_logo_y" id="footer_logo_y"
                                class="form-control" value="-35">
                        </div>

                        <!-- Page Break -->
                        <div class="col-md-6">
                            <label class="form-label">Page Break Threshold</label>
                            <input type="number" name="page_break_threshold" id="page_break_threshold"
                                class="form-control" value="30">
                        </div>

                        <!-- Seal Section -->
                        <div class="col-12 mt-3 border-top pt-3">
                            <h6 class="text-danger">Seal & Signature (Last Page)</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Seal Placement</label>
                            <select name="seal_last_pg" id="seal_last_pg" class="form-select">
                                <option value="none">None</option>
                                <option value="last_left">Bottom Left</option>
                                <option value="last_center">Bottom Center</option>
                                <option value="last_right">Bottom Right</option>
                                <option value="last_custom">Custom</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="seal_last_x_group">
                            <label class="form-label">Seal X</label>
                            <input type="number" name="seal_last_x" id="seal_last_x"
                                class="form-control" value="160">
                        </div>

                        <div class="col-md-6" id="seal_last_y_group">
                            <label class="form-label">Seal Y</label>
                            <input type="number" name="seal_last_y" id="seal_last_y"
                                class="form-control" value="0">
                        </div>

                    </div>

                    <div class="mt-4">
                        <button type="button" id="btnStandard" class="btn btn-danger w-100">
                            Generate Standard Quotation
                        </button>

                        <button type="button" 
                            class="btn btn-secondary w-100 mt-2" id="btnV2">
                            Generate Quotation V2 (With Images)
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>