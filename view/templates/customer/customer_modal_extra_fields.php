<div class="row">
    <div class="col-md-4 mb-0 mt-2">
        <label for="customer_account_id_onmodal" class="form-label">Customer Account</label>
        <select id="customer_account_id_onmodal" name="customer_account_id_onmodal" class="form-select form-select-sm">
            <option value="">Select Customer Account</option>
        </select>
    </div>
    <div class="col-md-4 mb-0 mt-2">
        <label for="nationality_onmodal" class="form-label">Nationality *</label>
        <select id="nationality_onmodal" name="nationality_onmodal" class="form-select form-select-sm">
            <option value="">Select Nationality</option>
            <option value="Bahrain">Bahrain</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="UAE">UAE</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Oman">Oman</option>
            <option value="Qatar">Qatar</option>
            <option value="India">India</option>
            <option value="Pakistan">Pakistan</option>
            <option value="Bangladesh">Bangladesh</option>
            <option value="Philippines">Philippines</option>
            <option value="Egypt">Egypt</option>
            <option value="Jordan">Jordan</option>
            <option value="Nepal">Nepal</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="UK">UK</option>
            <option value="USA">USA</option>
            <option value="Other">Other</option>
        </select>
    </div>
    <div class="col-md-4 mb-0 mt-2">
        <label for="license_no_onmodal" class="form-label">Licence No. *</label>
        <input class="form-control form-control-sm" id="license_no_onmodal" name="license_no_onmodal" type="text" placeholder="Licence No.">
    </div>
    <div class="col-md-4 mb-0 mt-2">
        <label for="license_issue_place_onmodal" class="form-label">Issue Place *</label>
        <select id="license_issue_place_onmodal" name="license_issue_place_onmodal" class="form-select form-select-sm">
            <option value="">Select Issue Place</option>
            <option value="Bahrain">Bahrain</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="UAE">UAE</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Oman">Oman</option>
            <option value="Qatar">Qatar</option>
            <option value="GCC">GCC</option>
            <option value="International">International</option>
            <option value="Other">Other</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-0 mt-2">
        <label for="license_expiry_date_onmodal" class="form-label">Licence Expire Date *</label>
        <input class="form-control form-control-sm" id="license_expiry_date_onmodal" name="license_expiry_date_onmodal" type="date">
    </div>
    <div class="col-md-4 mb-0 mt-2">
        <label for="phone_1_onmodal" class="form-label">Phone 1</label>
        <input class="form-control form-control-sm" id="phone_1_onmodal" name="phone_1_onmodal" type="text" placeholder="Phone 1">
    </div>
    <div class="col-md-4 mb-0 mt-2">
        <label for="phone_2_onmodal" class="form-label">Phone 2</label>
        <input class="form-control form-control-sm" id="phone_2_onmodal" name="phone_2_onmodal" type="text" placeholder="Phone 2">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-0 mt-2">
        <label for="fax_no_onmodal" class="form-label">Fax No.</label>
        <input class="form-control form-control-sm" id="fax_no_onmodal" name="fax_no_onmodal" type="text" placeholder="Fax No.">
    </div>
    <div class="col-md-4 mb-0 mt-2">
        <label for="website_onmodal" class="form-label">Website</label>
        <input class="form-control form-control-sm" id="website_onmodal" name="website_onmodal" type="text" placeholder="Website">
    </div>
    <div class="col-md-4 mb-0 mt-2">
        <label for="vat_reg_no_onmodal" class="form-label">VAT Registration #</label>
        <input class="form-control form-control-sm" id="vat_reg_no_onmodal" name="vat_reg_no_onmodal" type="text" placeholder="VAT Registration #">
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="p-2 rounded border" style="background-color: #fff8f8; border-color: #f5c2c7 !important;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-semibold text-danger small"><i class="ri-spam-2-line me-1"></i> Black List Information</span>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" id="is_blacklisted_onmodal" name="is_blacklisted_onmodal" value="1">
                    <label class="form-check-label text-danger small fw-semibold" for="is_blacklisted_onmodal">Black list</label>
                </div>
            </div>
            <textarea class="form-control form-control-sm" id="blacklist_description_onmodal" name="blacklist_description_onmodal" rows="2" placeholder="Blacklist Description"></textarea>
        </div>
    </div>
</div>

<script>
(function() {
    if (window.__customerExtraFieldsPrefilter) return;
    window.__customerExtraFieldsPrefilter = true;
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof jQuery === 'undefined') return;
        fetch('/CustomerAccountController?action=list&active_only=1')
            .then(r => r.json())
            .then(res => {
                const sel = document.getElementById('customer_account_id_onmodal');
                if (!sel) return;
                (res.data || []).forEach(a => {
                    const opt = document.createElement('option');
                    opt.value = a.ids;
                    opt.textContent = a.account_name;
                    sel.appendChild(opt);
                });
            })
            .catch(() => {});
        jQuery.ajaxPrefilter(function(options) {
            if (options.url && options.url.indexOf('/SaveCustomerDetails') !== -1 && typeof options.data === 'string') {
                try {
                    const parsed = JSON.parse(options.data);
                    if (parsed && typeof parsed === 'object' && parsed.action === 'AddNewCustomer') {
                        parsed.customer_account_id   = jQuery('#customer_account_id_onmodal').val() || '';
                        parsed.nationality           = jQuery('#nationality_onmodal').val() || '';
                        parsed.license_no            = jQuery('#license_no_onmodal').val() || '';
                        parsed.license_issue_place   = jQuery('#license_issue_place_onmodal').val() || '';
                        parsed.license_expiry_date   = jQuery('#license_expiry_date_onmodal').val() || '';
                        parsed.phone_1               = jQuery('#phone_1_onmodal').val() || '';
                        parsed.phone_2               = jQuery('#phone_2_onmodal').val() || '';
                        parsed.fax_no                = jQuery('#fax_no_onmodal').val() || '';
                        parsed.website               = jQuery('#website_onmodal').val() || '';
                        parsed.vat_reg_no            = jQuery('#vat_reg_no_onmodal').val() || '';
                        parsed.is_blacklisted        = jQuery('#is_blacklisted_onmodal').is(':checked') ? 1 : 0;
                        parsed.blacklist_description = jQuery('#blacklist_description_onmodal').val() || '';
                        options.data = JSON.stringify(parsed);
                    }
                } catch (e) {}
            }
        });
    });
})();
</script>
