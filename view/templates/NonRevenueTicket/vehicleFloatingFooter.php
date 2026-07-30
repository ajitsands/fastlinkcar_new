

<div id="selectedVehiclesFooter" class="position-fixed bottom-0 start-50 translate-middle-x w-100 mx-auto bg-white shadow-lg p-3 rounded-top d-none" style="z-index: 1050; max-width: 1200px;">
    <!-- Header: Selected Vehicles + Clear All -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0 fw-bold">Selected Vehicles (<span id="selectedCount">0</span>)</h6>
        <button type="button" class="btn btn-sm btn-outline-secondary" id="clearSelectedVehicles">
            Clear All
        </button>
    </div>

    <!-- Selected Vehicles Scrollable List -->
    <div id="selectedVehiclesList"  class="d-flex flex-wrap gap-2 mb-3"
     style="max-height:80px; overflow-y:auto;">
        <!-- Selected vehicle badges/cards go here -->
    </div>
    
<div class="d-flex flex-wrap align-items-center gap-2 mt-2">
    <!-- Select dropdown: half width on desktop, full width on small screens -->
    <div class="flex-grow-1 flex-md-50">
       
    </div>

    <!-- Proceed button: right aligned -->
    <div>
        <button class="btn btn-primary btn-sm" id="proceedSelectedVehicles">
            Proceed <i class="ri ri-arrow-right-line"></i>
        </button>
        <button class="btn btn-primary btn-sm" id="proceedSelectedVehiclesList" style="dispaly:none">
            Proceed <i class="ri ri-arrow-right-line"></i>
        </button>
    </div>
</div>
   
</div>