<div class="container-fluid px-2 mt-1">

  <div class="row g-3">

    <!-- LEFT COLUMN -->
    <div class="col-lg-4 ">
    <div class="scroll-container scrollonfooter">
       <div class="card mb-3">
             <div class="card-header fw-semibold">Booking Type</div>
          <div class="card-body">
             
                <select id="bookingTypeMain" class="form-select">
                  <option value="quotation" selected>Against Quotation</option>
                  <option value="direct">Direct Booking</option>
                </select>
        
            
          </div>
        </div>
      <!-- QUOTATION SECTION -->
      <div id="quotationSection">

        <!-- Search -->
        <div class="card mb-3">
          <div class="card-header fw-semibold">Search Quotation</div>
          <div class="card-body">
            <input type="text" class="form-control" id="searchQuotation"
                   placeholder="Type quotation no">
          </div>
        </div>

        <!-- List -->
        <div class="card mb-3">
          <div class="card-header fw-semibold">Quotation List</div>
          <div class="card-body p-2" id="quotationList"
               style="max-height:280px; overflow-y:auto;">
            <div class="text-muted small text-center">
              No quotations found
            </div>
          </div>
        </div>

        <!-- Preview -->
        <div class="card">
          <div class="card-header fw-semibold">Quotation Preview</div>
          <div class="card-body" id="quotationPreview" style="max-height:250px; overflow-y:auto;">
            <div class="text-muted small text-center">
              Select a quotation to preview details
            </div>
          </div>
        </div>

      </div>

      <!-- DIRECT BOOKING SECTION -->
       <div id="directSection" class="d-none">

        <!-- Search -->
        <div class="card mb-3">
          <div class="card-header fw-semibold">Search Customer</div>
          <div class="card-body">
             
                <div class="d-flex align-items-stretch gap-2">
            
                    <div class="form-floating form-floating-outline flex-grow-1">
                        <select id="selectCustomerFromSelect2"
                                name="customer_name"
                                class="select2 form-select"
                                data-allow-clear="true"
                                style="width:100%">
                        </select>
                    
                    </div>
            
                    <button type="button"
                            id="addCustomerBtn"
                            class="btn btn-primary d-flex align-items-center justify-content-center"
                            title="Add New Customer">
                        <i class="ri ri-user-add-line" style="font-size:20px;"></i>
                    </button>
            
                </div>
                 
            </div>
          
        </div>

        <!-- List -->
        <div class="card mb-3">
          <div class="card-header fw-semibold">Search Vehicle Model</div>
          <div class="card-body">
                <div class="d-flex align-items-stretch gap-2" >
                   <div id="dropdownContainer"  class="left-scroll-area w-100">
                    
                    </div>
                </div>
            </div>
        </div>
      </div>
     
    </div>
    </div>

    <!-- MIDDLE COLUMN -->
    <div class="col-lg-3">
     <div class="scroll-container scrollonfooter" id="second_section" >
      <!-- CUSTOMER DETAILS -->
      <div class="card mb-1">
        <div class="card-header fw-semibold">Customer Details</div>
        <div class="card-body">
        <input type="hidden" id="customer_code" name="customer_code">
          <div class="row g-2">
          
            <div class="col-md-6">
                 <label class="form-label small">Customer Name</label>
              <input type="text" class="form-control form-control-sm"
                     id="customerName" placeholder="Customer Name" readonly>
            </div>

            <div class="col-md-6">
                 <label class="form-label small">Telephone</label>
              <input type="text" class="form-control form-control-sm"
                     id="customerPhone" placeholder="Telephone" >
            </div>

            <div class="col-md-6">
                 <label class="form-label small">Email</label>
              <input type="email" class="form-control form-control-sm"
                     id="customerEmail" placeholder="Email" >
            </div>

            <div class="col-md-6">
                 <label class="form-label small">Attention</label>
              <input type="text" class="form-control form-control-sm"
                     id="customerAttention" placeholder="Attention" >
            </div>

            <div class="col-12">
                 <label class="form-label small">Address</label>
              <textarea class="form-control form-control-sm"
                        id="customerAddress" rows="2"
                        placeholder="Address" ></textarea>
            </div>

          </div>

        </div>
      </div>

      <!-- BOOKING DETAILS -->
      <div class="card">
        <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
            <span>Booking Details</span>
            <div class="d-flex align-items-center gap-2">
        
        <!-- Calculator Icon Button -->
        <!--<i class="ri ri-calculator-line text-danger fs-3 cursor-pointer" -->
        <!--   id="recalcBtn" -->
        <!--   title="Recalculate"></i>-->

        <span class="text-primary small">
            Total: <span id="lineTotal">0.000</span>
        </span>

    </div>
            <!--<span class="text-primary small">-->
            <!--    Total: <span id="lineTotal">0.000</span>-->
            <!--</span>-->
        </div>
        <div class="card-body left-scroll-area"  >

          <input type="hidden" id="quotationRef">
           <input type="hidden" id="ModelRef" class="watch-field">

          <div class="row g-2">

            <div class="col-md-6">
              <label class="form-label small">From Date</label>
              <input type="datetime-local"
                     class="from_datetime form-control form-control-sm watch-field">
            </div>

            <div class="col-md-6">
              <label class="form-label small">To Date</label>
              <input type="datetime-local"
                     class="to_datetime form-control form-control-sm watch-field">
            </div>

            <div class="col-md-6">
              <label class="form-label small">Type</label>
              <select class="rate_type form-control form-control-sm watch-field">
                <option value="0">Select</option>
                <option value="hour">Hourly</option>
                <option value="day">Daily</option>
                 <option value="week">Weekly</option>
                <option value="month">Monthly</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label small">Service</label>
              <select class="service form-control form-control-sm watch-field">
                <option value="0">Select Service</option>
                <option value="1" data-id="10">Rental Without Driver</option>
                <option value="2" data-id="0">Rental With Driver</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label small">Duration</label>
              <input type="number" class="duration nav form-control form-control-sm"  value="0" >
            </div>
            <!--<div class="col-md-4">-->
            <!--  <label class="form-label small">Unit Price</label>-->
            <!--  <input type="number" class="price nav form-control form-control-sm"  value="0" >-->
            <!--  <input type="hidden" class="minprice nav form-control " >-->
              
            <!--   <span class="text-muted small min-price-text text-danger">-->
            <!--        Min Price: 0.000-->
            <!--      </span>-->
            <!--</div>-->
            <div class="col-md-4">

                <label class="form-label small">Unit Price</label>
                
                <div style="position:relative;">
                
                   <span class="min-price-text badge bg-danger"
                      style="position:absolute; top:-8px; right:8px; font-size:10px; z-index:2;">
                    Min: 0.000
                </span>
                
                    <!-- Input -->
                    <input type="number"
                           class="price nav form-control form-control-sm"
                           value="0"
                           style="padding-top:12px;">
                
                </div>
                
                <input type="hidden" class="minprice nav form-control">
                
                </div>
             <div class="col-md-4">
              <label class="form-label small">VAT %</label>
              <input type="number" class="vat nav form-control form-control-sm"   value="10" >
            </div>
           
            <div class="col-12">
              <textarea id="booking_notes" class="form-control form-control-sm"
                        rows="3"
                        placeholder="Booking notes if amy..."></textarea>
            </div>

          </div>

        </div>
      </div>
    </div>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="col-lg-5">
     <div class="scroll-container scrollonfooter">
      <div class="card h-100 shadow-sm">

        <div class="card-header p-2">
          <div class="input-group">
        
            <input type="text" id="vehicleSearch"
                   class="form-control"
                   placeholder="Search vehicles...">
        
            <!-- Search Button -->
            <button class="btn btn-primary" type="button" id="btnSearchVehicle">
              <i class="ri ri-search-line"></i>
            </button>
        
            <!-- Availability Button (same style) -->
            <button class="btn btn-success" type="button" id="btnCheckAvailability"  data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="Check Availability">
              <i class="ri ri-checkbox-circle-line fs-4"></i>
            </button>
        
          </div>
        </div>

        <div class="card-body p-2"
             style="max-height: calc(100vh - 200px); overflow-y:auto;">
          <div class="row g-2" id="vehicleContainer"></div>
        </div>

      </div>
    </div>
    </div>

  </div>

</div>