<!-- End Offcanvas list_of_booking_off_canvas-->


<!--<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarBooking" aria-labelledby="offcanvasEndLabel" style="width:50%">-->
<div class="offcanvas offcanvas-end car-booking-canvas"  tabindex="-1" id="offcanvasCarBooking" aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasEndLabelCarName" class="offcanvas-title">Book Now - Mercedes Benz C Class - Reg No 2564452 <span id="bookingNumber" style="color: red; font-weight:700"></span></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-0">
        <!-- Book Car -->
        <div class="card">

            <div class="card-datatable pb-1">
                <div class="row g-6">
                    <div class="col-md-6 col-xl-9">
                        <div class="form-floating form-floating-outline">
                            <!--<select id="selectCustomerFromSelect2" class="select2 form-select " data-allow-clear="true">-->
                            <!--    <option value="AK">Alaska</option>-->
                            <!--    <option value="HI">Hawaii</option>-->
                            <!--    <option value="CA">California</option>-->
                            <!--    <option value="NV">Nevada</option>-->
                            <!--</select>-->
                            <select id="selectCustomerFromSelect2" class="select2 form-select " data-allow-clear="true" style="width:100%"></select>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <button type="button" id="addNewCustomerButtom" class="btn  btn-primary waves-effect waves-light ">
                            <span class="icon-base ri ri-user-add-line icon-16px me-2"></span>Add Customer
                        </button>
                    </div>
                </div>

                <div class="row g-6 mt-1">
                    <div class="col-md-6 col-lg-6">
                        <div class="card h-100 ">
                            <div class="card-body" id="booking-card-details" style="padding: 0px;">

                            </div>
                        </div>
                    </div>

                    <!-- Customer-->
                    <div class="col-md-6 col-lg-6">
                        <div class="card h-100">
                            <div class="card-header pb-4">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-4">
                                            <img src="../../assets/img/avatars/5.png" alt="Avatar"
                                                class="rounded-circle" />
                                        </div>
                                        <div class="me-2">
                                            <h5 class="mb-0">
                                                <!--<a href="javascript:;" class="stretched-link text-heading">Ajit Kumar-->
                                                <!--    KV</a>-->
                                                     <a href="javascript:;" class="text-heading" id="bookingCustomerNameDisplay">Ajit Kumar KV</a>
                                            </h5>
                                            <div class="client-info text-body">
                                                <span class="fw-medium">Mobile : </span><span id="customerMobileDisplay">SaNDS Lab <span id="customerType"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ms-auto">
                                        <div class="dropdown z-2">
                                            <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i
                                                    class="icon-base ri ri-more-2-line icon-22px text-body-secondary"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Update</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">View details</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li><a class="dropdown-item text-danger"
                                                        href="javascript:void(0);">Deactivate</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="bg-lightest px-3 py-2 rounded-3 me-auto mb-4">
                                        <p class="mb-1"><span class="fw-medium text-heading" id="customerCprCrDisplay">732562552</span></p>
                                        <span class="text-body">CPR Number</span>
                                    </div>
                                    <div class="text-start mb-4">
                                        <p class="mb-1">
                                            <span class="text-heading fw-medium">CPR Valid Upto </span> <span
                                                class="badge rounded-pill text-bg-danger">14 Feb 21</span>
                                        </p>
                                        <p class="mb-1">
                                            <span class="text-heading fw-medium">Licence Valid Upto: </span> <span
                                                class="badge rounded-pill text-bg-success">14 Feb 27</span>
                                        </p>
                                    </div>
                                </div>
                                <p class="mb-0"><span id="customerBlockDisplay"></span>,<span id="customerRoadDisplay"></span>, <span id="customerBuildingDisplay"></span>
                                , <span id="customerHouseDisplay"><span id="customerAriaDisplay"></span>
                                </p>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 " id="driverImages">
                                                    <!--<li-->
                                                    <!--  data-bs-toggle="tooltip"-->
                                                    <!--  data-popup="tooltip-custom"-->
                                                    <!--  data-bs-placement="top"-->
                                                    <!--  title="No Driver"-->
                                                    <!--  class="avatar avatar-lg pull-up">-->
                                                    <!--  <img class="rounded-circle" src="../../assets/img/avatars/3.png" alt="Avatar" />-->
                                                    <!--</li>-->
                                                </ul>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="row g-1 p-5 pt-0">
                                                <a href="javascript:;" class="me-1 mt-1">
                                                  <span class="badge bg-label-primary rounded-pill openAddDriverModal">Add Driver</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-body border-top pb-0">
                                <div class="d-flex align-items-center mb-4">
                                    <p class="mb-1"><span class="text-heading fw-medium">Last Taken: </span> <span>18
                                            Jan 2024</span></p>
                                    <span class="badge bg-label-secondary ms-auto rounded-pill">Individual</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-body">Attachments</small>

                                </div>


                                <div class="d-flex align-items-center">
                                    
                                    <div class="d-flex align-items-center">
                                      <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 " id="documentImages">
                                        <!--<li-->
                                        <!--  data-bs-toggle="tooltip"-->
                                        <!--  data-popup="tooltip-custom"-->
                                        <!--  data-bs-placement="top"-->
                                        <!--  title="Kim Karlos"-->
                                        <!--  class="avatar avatar-lg pull-up">-->
                                        <!--  <img class="rounded-circle" src="../../assets/img/avatars/3.png" alt="Avatar" />-->
                                        <!--</li>-->
                                        
                                        
                                      </ul>
                                        
                                    </div>
                                    <div class="ms-auto">
                          
                      
                                            <div class="row g-1 p-5 pt-0">
                                                <a href="javascript:;" class="me-1 mt-1">
                                                  <span class="badge bg-label-info rounded-pill openAttachmentModal">Add More</span>
                                                </a>
                                            </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                            
                    </div>

                    <!--Customer End-->
                     
                </div>
                <form id="formBookingInfoAndPayments">
                        <div class="row g-6 mt-1 p-2">
                            <div class="col-md-4 col-lg-4">
        
                                <div class="form-floating form-floating-outline mb-3">
                                    <input class="form-control" type="date" id="rent_start_date" name="rent_start_date">
                                    <label for="rent_start_date">Start Date</label>
                                </div>
        
                            </div>
                            <div class="col-md-4 col-lg-4">
        
                                <div class="form-floating form-floating-outline mb-3">
                                    <input class="form-control" type="date" id="rent_end_date" name="rent_end_date">
                                    <label for="rent_end_date">End Date</label>
                                </div>
        
                            </div>
                            <div class="col-md-4 col-lg-2">
        
                                <div class="form-floating form-floating-outline mb-3">
                                    <input class="form-control" type="text" id="total_days_taken" name="total_days_taken"
                                        style="font-size: 20px; font-weight : 700; text-align: center;" readonly>
                                    <label for="total_days_taken">Total Days</label>
                                </div>
        
                            </div>
                            <div class="col-md-6 col-lg-2">
        
                                <div class="form-floating form-floating-outline mb-3">
                                    <input class="form-control" type="number" id="rent_per_day" name="rent_per_day">
                                    <label for="rent_per_day">Cost Perday </label>
                                </div>
        
                            </div>
                        </div>
                        
                        <div class="row g-6 p-2">
        
                            <div class="col-md-6 col-lg-3">
        
                                <div class="form-floating form-floating-outline mb-1">
                                    <input class="form-control" type="number" id="rent_total_cost" name="rent_total_cost"
                                        style="font-size: 20px; font-weight : 700; text-align: center;" readonly>
                                    <label for="rent_start_date">Total Cost</label>
                                </div>
        
                            </div>
                            <div class="col-md-6 col-lg-2">
        
                                <div class="form-floating form-floating-outline mb-1">
                                    <input class="form-control" type="text" id="rent_discount_if_any" name="rent_discount_if_any">
                                    <label for="rent_start_date">Discount</label>
                                </div>
        
                            </div>
                            <div class="col-md-6 col-lg-2">
        
                                <div class="form-floating form-floating-outline mb-1">
                                    <input class="form-control" type="text" id="rent_after_discount" name="rent_after_discount"
                                        style="font-size: 20px; font-weight : 700; text-align: center;" readonly>
                                    <label for="rent_start_date">After Discount</label>
                                </div>
        
                            </div>
                            <div class="col-md-6 col-lg-2">
        
                                <div class="form-floating form-floating-outline mb-1">
                                    <input class="form-control" type="text" id="rent_tax_any" name="rent_tax_any">
                                    <label for="rent_start_date">Tax%</label>
                                </div>
        
                            </div>
                            <div class="col-md-6 col-lg-3">
        
                                <div class="form-floating form-floating-outline mb-1">
                                    <input class="form-control" type="text" id="rent_grand_total" name="rent_grand_total"
                                        style="font-size: 20px; font-weight : 700; text-align: center;" readonly>
                                    <label for="rent_start_date">Grand Total</label>
                                </div>
        
                            </div>
                        </div>
                        <div class="row g-1 p-5 pt-0 pb-2">
                            <div class="col-md-12 col-lg-12" id="inWords">
                            </div>
                           
                        </div>
                        
                        
                        <div class="d-flex align-items-center pt-0">
                            <div class="d-flex align-items-center">
                                <div class="row g-6 p-2">
                                    <div class="col-md-6 col-lg-3 col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" style="padding-right: 0px;"> <i class="menu-icon icon-base ri ri-gas-station-line"></i> </span>
                                            <input type="text" class="form-control" placeholder="Fuel Level">
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-lg-2 col-sm-6">
                                        <div class="input-group input-group-sm form-check form-check-secondary m-3 pl-0">
                                          <input class="form-check-input " type="checkbox"  id="jack_and_tools" name="jack_and_tools"  checked>
                                          <label class="form-check-label" for="jack_and_tools">&nbsp;Jack & Tools</label>
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-lg-2 col-sm-6">
                                        <div class="input-group input-group-sm form-check form-check-secondary m-3 pl-0">
                                          <input class="form-check-input " type="checkbox" id="spare_tyre" name="spare_tyre" checked>
                                          <label class="form-check-label" for="spare_tyre">&nbsp;Spare Tyre</label>
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-lg-2 col-sm-6">
                                        <div class="input-group input-group-sm form-check form-check-secondary m-3 pl-0">
                                          <input class="form-check-input " type="checkbox" id="radio_yes_no" name="radio_yes_no" checked>
                                          <label class="form-check-label" for="radio_yes_no">&nbsp;Radio</label>
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-lg-2 col-sm-6">
                                        <div class="input-group input-group-sm form-check form-check-secondary m-3 pl-0">
                                          <input class="form-check-input " type="checkbox" id="cd_recorder" name="cd_recorder" checked>
                                          <label class="form-check-label" for="cd_recorder">&nbsp;CD Recorder</label>
                                        </div>
                                    </div>
                                  
                                </div>        
                                        
                                    
                            </div>
                            <!--<div class="ms-auto">-->
                            <!--    <div class="row g-1 p-5 pt-0">-->
                            <!--        <a href="javascript:;" class="me-1 mt-1">-->
                            <!--          <span class="badge bg-label-primary rounded-pill openAddRentalCarImageModal">Add Car Images</span>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                </form>
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0 " id="rentalCarImages">
                                <!--<li-->
                                <!--  data-bs-toggle="tooltip"-->
                                <!--  data-popup="tooltip-custom"-->
                                <!--  data-bs-placement="top"-->
                                <!--  title="Car Images"-->
                                <!--  class="avatar avatar-lg pull-up">-->
                                <!--  <img class="rounded-circle" src="../../assets/img/avatars/3.png" alt="Avatar" />-->
                                <!--</li>-->
                            </ul>
                    </div>
                    <div class="ms-auto">
                        <div class="row g-1 p-5 pt-0">
                            <a href="javascript:;" class="me-1 mt-1">
                              <span class="badge bg-label-primary rounded-pill openAddRentalCarImageModal">Add Car Images</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                
                
            </div>
            <!--/ Book Car -->

        </div>
    </div>
    <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
    
        <div>
            <button class="btn btn-outline-primary waves-effect" id="buttonCancelAll">
                <span class="icon-base ri ri-thumb-down-line me-1"></span>
                Cancel All Uploads
            </button>
        </div>
    
        <div class="d-flex gap-2">
            <button class="btn btn-secondary" data-bs-dismiss="offcanvas" id="buttonBookingOffCanvasClose">
                <span class="icon-base ri ri-close-line me-1"></span>
                Close
            </button>
    
            <button class="btn btn-primary" id="buttonConfirmBooking">
                <span class="icon-base ri ri-thumb-up-line me-1"></span>
                Confirm Booking
            </button>
        </div>
    
    </div>

</div>