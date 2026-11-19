<div class="modal fade" id="vehicleProfileModal" tabindex="-1" aria-hidden="true" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1b3d94;">
                <h5 class="modal-title d-flex align-items-center gap-2 text-white">
                    <i class="ri-car-line"></i> 
                    Vehicle Profile - <span id="vpVehicleNumber" class="fw-bold"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row g-3">
                    <!-- Left Column: Images Carousel -->
                    <div class="col-md-5">
                        <div class="card h-100 shadow-none border">
                            <div class="card-header bg-light border-bottom py-1 px-2">
                                <h6 class="mb-0 fs-13"><i class="ri-image-line me-1"></i> Vehicle Images</h6>
                            </div>
                            <div class="card-body p-0 d-flex align-items-center justify-content-center bg-dark" style="min-height: 250px; max-height: 300px; overflow: hidden;">
                                <div id="vpImageCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel" style="display: none;">
                                    <div class="carousel-inner h-100" id="vpCarouselInner">
                                        <!-- Images injected here -->
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#vpImageCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#vpImageCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <div id="vpNoImagesMessage" class="text-muted text-center py-5">
                                    <i class="ri-camera-off-line ri-2x mb-1 text-secondary"></i>
                                    <p class="mb-0 fs-13">No images</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Details -->
                    <div class="col-md-7">
                        <div class="card shadow-none border mb-2">
                            <div class="card-header bg-light border-bottom py-1 px-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fs-13"><i class="ri-information-line me-1"></i> General Details</h6>
                                <span id="vpStatusBadge" class="badge bg-label-primary fs-11" style="line-height: 1;">Status</span>
                            </div>
                            <div class="card-body p-2">
                                <div class="row g-2 fs-13">
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block" style="font-size: 11px;">Vehicle Number</span>
                                        <strong class="text-primary" id="vpVehicleNumBody" style="font-size: 14px;"></strong>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block" style="font-size: 11px;">Category & Brand</span>
                                        <strong class="text-dark"><span id="vpCategory"></span> - <span id="vpBrand"></span></strong>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block" style="font-size: 11px;">Model</span>
                                        <strong class="text-dark" id="vpModel"></strong>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block" style="font-size: 11px;">Chassis Number</span>
                                        <strong class="text-dark" id="vpChassis"></strong>
                                    </div>
                                    <div class="col-sm-3">
                                        <span class="text-muted d-block" style="font-size: 11px;">Year</span>
                                        <strong class="text-dark" id="vpYear"></strong>
                                    </div>
                                    <div class="col-sm-3">
                                        <span class="text-muted d-block" style="font-size: 11px;">Color</span>
                                        <strong class="text-dark" id="vpColor"></strong>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block" style="font-size: 11px;">Engine Type / Transmission</span>
                                        <strong class="text-dark"><span id="vpFuelType"></span> / <span id="vpGearType"></span></strong>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-muted d-block" style="font-size: 11px;">Mileage (km)</span>
                                        <strong class="text-dark" id="vpMileageKm">-</strong>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-muted d-block" style="font-size: 11px;">Body Type</span>
                                        <strong class="text-dark" id="vpBodyType">-</strong>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-muted d-block" style="font-size: 11px;">Capacity (cc)</span>
                                        <strong class="text-dark" id="vpCapacityCc">-</strong>
                                    </div>
                                    <div class="col-12" id="vpRentoutDiv" style="display: none;">
                                        <div class="border border-danger rounded p-2 bg-lighter mt-1">
                                            <div class="row g-2">
                                                <div class="col-sm-5">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Rented To (Contact)</span>
                                                    <strong class="text-danger fs-12"><span id="vpCurrentUserName"></span> <span id="vpCurrentUserContact" class="badge bg-label-secondary ms-1"></span></strong>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Contract Ref</span>
                                                    <strong class="text-dark fs-12" id="vpContractRef"></strong>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Expected Return</span>
                                                    <strong class="text-danger fs-12" id="vpReturnDate"></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="vpStaffDiv" style="display: none;">
                                        <div class="border border-info rounded p-2 bg-lighter mt-1">
                                            <div class="row g-2">
                                                <div class="col-sm-5">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Assigned Staff (Contact)</span>
                                                    <strong class="text-info fs-12"><span id="vpStaffName"></span> <span id="vpStaffContact" class="badge bg-label-secondary ms-1"></span></strong>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Ticket Ref</span>
                                                    <strong class="text-dark fs-12" id="vpStaffRef"></strong>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Expected Return</span>
                                                    <strong class="text-info fs-12" id="vpStaffReturnDate"></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="vpRemarksDiv" style="display: none;">
                                        <div class="border border-warning rounded p-2 bg-lighter mt-1">
                                            <span class="text-muted d-block" style="font-size: 11px;">Status Remarks</span>
                                            <strong class="text-dark fs-12" id="vpStatusRemarks"></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-sm-5">
                                <div class="d-flex flex-column gap-2 h-100">
                                    <div class="card shadow-none border flex-shrink-0">
                                        <div class="card-header bg-light border-bottom py-1 px-2">
                                            <h6 class="mb-0 fs-13"><i class="ri-building-line me-1"></i> Ownership</h6>
                                        </div>
                                        <div class="card-body p-2 fs-13">
                                            <div class="mb-1">
                                                <span class="text-muted d-block" style="font-size: 11px;">Reg Company</span>
                                                <strong class="text-success" id="vpRegCompany"></strong>
                                            </div>
                                            <div id="vpOutsourceDiv">
                                                <span class="text-muted d-block" style="font-size: 11px;">Outsource Vendor</span>
                                                <strong class="text-warning" id="vpOutsourceCompany"></strong>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card shadow-none border flex-grow-1">
                                        <div class="card-header bg-light border-bottom py-1 px-2">
                                            <h6 class="mb-0 fs-13"><i class="ri-calendar-line me-1"></i> Important Dates</h6>
                                        </div>
                                        <div class="card-body p-2 fs-13">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Purchase Date</span>
                                                    <strong class="text-dark" id="vpPurchaseDate"></strong>
                                                </div>
                                                <div class="col-6">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Next Insurance</span>
                                                    <strong class="text-danger" id="vpNextInsurance"></strong>
                                                </div>
                                                <div class="col-6">
                                                    <span class="text-muted d-block" style="font-size: 11px;">Next Passing</span>
                                                    <strong class="text-danger" id="vpNextPassing"></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-7">
                                <div class="card shadow-none border h-100">
                                    <div class="card-header bg-light border-bottom py-1 px-2">
                                        <h6 class="mb-0 fs-13"><i class="ri-money-dollar-circle-line me-1"></i> Pricing Setup</h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <div id="vpPricingList" class="w-100">
                                            <!-- Dynamic pricing badges injected here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
