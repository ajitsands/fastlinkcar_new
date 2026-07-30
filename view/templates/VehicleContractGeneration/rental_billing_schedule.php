<div class="modal fade" id="billingScheduleModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Rental Billing Schedule
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- Contract Information -->
                <div class="card mb-3">
                    <div class="card-header">
                        Contract Details
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <label>Contract No</label>
                                <input type="text"
                                       class="form-control"
                                       id="txtContractNo"
                                       readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Customer</label>
                                <input type="text"
                                       class="form-control"
                                       id="txtCustomer"
                                       readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Vehicle No</label>
                                <input type="text"
                                       class="form-control"
                                       id="txtVehicle"
                                       readonly>
                            </div>

                            <div class="col-md-3">
                                <label>Rental Amount</label>
                                <input type="text"
                                       class="form-control"
                                       id="txtRentalAmount"
                                       readonly>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Billing Setup -->
                <div class="card mb-3">
                    <div class="card-header">
                        Billing Configuration
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-3">
                                <label>Billing Cycle</label>
                                <select class="form-select"
                                        id="cmbBillingCycle">
                                    <option value="Monthly">Monthly</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Quarterly">Quarterly</option>
                                    <option value="Custom">Custom</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>First Invoice Date</label>
                                <input type="date"
                                       class="form-control"
                                       id="txtInvoiceDate">
                            </div>

                            <div class="col-md-2">
                                <label>Due Days</label>
                                <input type="number"
                                       class="form-control"
                                       id="txtDueDays"
                                       value="15">
                            </div>

                            <div class="col-md-2">
                                <label>Contract End</label>
                                <input type="date"
                                       class="form-control"
                                       id="txtContractEnd"
                                       readonly>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button"
                                        class="btn btn-success w-100"
                                        id="btnGenerate">
                                    Generate
                                </button>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Schedule Grid -->
                <div class="card">

                    <div class="card-header d-flex justify-content-between">
                        <span>Invoice Schedule</span>

                        <button class="btn btn-sm btn-primary"
                                id="btnAddRow">
                            Add Schedule
                        </button>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover"
                                   id="tblInvoiceSchedule">

                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Period From</th>
                                        <th>Period To</th>
                                        <th>Amount</th>
                                        <th>VAT</th>
                                        <th>Total</th>
                                        <th width="80">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Close
                </button>

                <button type="button"
                        class="btn btn-primary"
                        id="btnSaveSchedule">
                    Save Schedule
                </button>

            </div>

        </div>
    </div>
</div>