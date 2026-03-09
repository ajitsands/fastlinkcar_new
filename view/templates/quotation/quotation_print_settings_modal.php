<div class="modal fade" id="printSettingsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Print Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row">
        
        <!-- Decimal places -->
        <div class="col-2 mb-3">
          <label>Decimal</label>
          <input type="number" id="printDecimals" class="form-control" value="3" min="0" max="5">
        </div>
        <!-- Gap Between Lines  -->
        <div class="col-2 mb-3">
          <label>Gaps</label>
          <input type="number" id="lineItemGap" class="form-control" value="8" min="8" max="30">
        </div>
        
        <!-- Font Size -->
        <div class="col-2 mb-3">
          <label>Font</label>
          <input type="number" id="printFontSize" class="form-control" value="10" min="8" max="25">
        </div>
        <!-- Font Color -->
        <div class="col-2 mb-3">
          <label>Color</label>
           <input type="color" id="fontColor" class="form-control form-control-color" value="#000000">
        </div>
         
        <!-- Title Color -->
        <div class="col-2 mb-3">
          <label>Title</label>
           <input type="color" id="printColor" class="form-control form-control-color" value="#eeeeee">
        </div>
        
        <!-- Logo Upload -->
        <div class="mb-3">
          <label>Logo</label>
          <input type="file" id="printLogo" class="form-control" accept="image/*">
          <small id="logoFileNameDisplay" class="text-muted"></small>
        </div>
        <div class="col-3 mb-2">
            <label>Logo Alignment</label>
            <select id="printAlign" class="form-control">
                <option value="left">Left</option>
                <option value="center">Center</option>
                <option value="right">Right</option>
            </select>

        </div>
        <div class="col-2 mb-3">
          <label>Currency </label>
          <!--<input type="text" id="currencyName" class="form-control" value="">-->
           <select id="countryCode" class="form-control">
                <option value="BHD">BHD</option>
                <option value="UAE">UAE</option>
                <option value="KSA">KSA</option>
                <option value="KWT">KWT</option>
            </select>
        </div>
        <!-- Gap Between Lines  -->
        <!--<div class="col-4 mb-3">-->
        <!--  <label>Decimal Name</label>-->
        <!--  <input type="text" id="decimalName" class="form-control" value="">-->
        <!--</div>-->
        <div class="col-2 mb-3">
            <label> Style</label>
            <select id="nameStyle" class="form-control">
                <option value="normal">Normal</option>
                <option value="italic">Italic</option>
                <option value="bold">Bold</option>
                <option value="bold_italic">Bold Italic</option>
            </select>
        </div>
        <div class="col-5 mb-3">
          <label>Prepared By</label>
          <input type="text" id="preparedName" class="form-control" value="">
        </div>
        <div class="col-3 mb-3">
         
          <label>Page Orientation</label>
            <select id="pageOrientation" class="form-control">
                <option value="landscape">Landscape</option>
                <option value="portrait">Portrait</option>
            </select>
        </div>
        <div class="col-2 mb-3">
         
          <label>VAT</label>
            <select id="vat_status" class="form-control">
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select>
        </div>
        <div class="col-3 mb-3">
         
          <label>Signature Position</label>
            <select id="sig_possition" class="form-control">
                <option value="left">Left</option>
                <option value="center">Center</option>
                <option value="right">Right</option>
            </select>
        </div>
        <div class="col-2 mb-3">
         
          <label>On Page
          <a href="javascript:void(0);"
               data-bs-toggle="popover"
               data-bs-placement="top"
               data-bs-custom-class="popover-dark"
               data-bs-content="Enter 0 to place the seal and signature on the last page. Alternatively, enter the specific page number (e.g., 2, 3, or 4) where the seal and signature should appear."
               title="On Page">
                <span class="ri ri-question-line"></span>
            </a>
          
          </label>
            <input type="text" id="onPage" class="form-control" value="">
        </div>
        <div class="col-2 mb-3">
         
          <label>V Align(120)</label>
            <input type="text" id="vALign" class="form-control" value="">
        </div>
        
        <div class="col-2 mb-3">
         
          <label>Seal Left(100)</label>
            <input type="text" id="sealLeft" class="form-control" value="">
        </div>
        <div class="col-2 mb-3">
         
          <label>Seal Top(100)</label>
            <input type="text" id="sealTop" class="form-control" value="">
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="confirmPrint">Print</button>
      </div>

    </div>
  </div>
</div>