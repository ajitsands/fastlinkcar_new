<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: /Logout");
    exit();
}
include ROOT_PATH . '/view/envinclude.php';
?>
<!doctype html>
<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-wide"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="<?= $_ENV['BASE_URL'] ?>assets/"
    data-template="horizontal-menu-template-no-customizer">
<head>
    <?php include ROOT_PATH . '/view/templates/head.php'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.css" />
</head>
<body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <?php include ROOT_PATH . '/view/templates/nav.php'; ?>
            <div class="layout-page">
                <div class="content-wrapper">
                    <?php include ROOT_PATH . '/view/templates/menu.php'; ?>

                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="row g-4">
                            <!-- Left: Sold Car Information Form -->
                            <div class="col-12 col-lg-5">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold" style="color: #1b3d94;">
                                            <i class="ri-price-tag-3-line me-1"></i> SOLD CAR INFORMATION
                                        </h5>
                                        <span class="badge bg-label-danger d-none" id="svEditBadge">Editing Sale</span>
                                    </div>
                                    <div class="card-body pt-3">
                                        <form id="soldVehicleForm">
                                            <input type="hidden" id="sv_sale_id" value="0">
                                            <input type="hidden" id="sv_vehicle_id" value="0">

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Car No. <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select id="sv_car_select" class="form-select form-select-sm select2" style="width:100%;" required>
                                                        <option value="">Select Car No.</option>
                                                    </select>
                                                    <input type="text" id="sv_car_no_readonly" class="form-control form-control-sm bg-light d-none" readonly>
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Car Type</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="sv_car_type" class="form-control form-control-sm bg-light" readonly>
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Model Year</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="sv_model_year" class="form-control form-control-sm bg-light" readonly>
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Car Color</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="sv_car_color" class="form-control form-control-sm bg-light" readonly>
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Sale Date <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="date" id="sv_sale_date" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>" required>
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Current Mileage (km)</label>
                                                <div class="col-sm-8">
                                                    <input type="number" min="0" id="sv_mileage_km" class="form-control form-control-sm" placeholder="e.g. 85000">
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Buyer Name <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="sv_buyer_name" class="form-control form-control-sm" required placeholder="Enter buyer full name">
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">CPR / ID Number</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="sv_cpr_id" class="form-control form-control-sm" placeholder="Optional">
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Contact Phone</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="sv_contact_phone" class="form-control form-control-sm" placeholder="Optional">
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Contact Mobile</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="sv_contact_mobile" class="form-control form-control-sm" placeholder="Optional">
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Email</label>
                                                <div class="col-sm-8">
                                                    <input type="email" id="sv_email" class="form-control form-control-sm" placeholder="Optional">
                                                </div>
                                            </div>

                                            <div class="row g-2 align-items-center mb-2">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Sale Amount <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" step="0.001" min="0" id="sv_sale_amount" class="form-control fw-bold" required placeholder="0.000">
                                                        <span class="input-group-text">BD</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-2 mb-3">
                                                <label class="col-sm-4 col-form-label col-form-label-sm fw-semibold">Note</label>
                                                <div class="col-sm-8">
                                                    <textarea id="sv_note" class="form-control form-control-sm" rows="3" placeholder="Sale remarks..."></textarea>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                                <button type="button" class="btn btn-sm btn-outline-primary" id="btnSaveAndNew">Save and New</button>
                                                <button type="submit" class="btn btn-sm btn-primary" id="btnSaveSale">Save</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnCancelSale">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Sold Vehicles List -->
                            <div class="col-12 col-lg-7">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold" style="color: #1b3d94;">
                                            <i class="ri-list-check-2 me-1"></i> Sold Vehicles List
                                        </h5>
                                        <span class="badge bg-label-danger" id="svTotalBadge">0 Sold</span>
                                    </div>
                                    <div class="card-body pt-3">
                                        <div class="table-responsive">
                                            <table id="soldVehiclesTable" class="table table-hover table-sm align-middle w-100">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Sale Date</th>
                                                        <th>Car No / Type</th>
                                                        <th>Buyer / Contact</th>
                                                        <th class="text-end">Mileage</th>
                                                        <th class="text-end">Amount (BD)</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include ROOT_PATH . '/view/templates/footer.php'; ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/select2/select2.js"></script>
    <script>
    (function() {
        let availableVehicles = [];
        let soldRows = [];
        let dt = null;
        let saveAndNewFlag = false;

        function esc(s) {
            return String(s || '').replace(/[&<>"']/g, ch => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[ch]));
        }

        function fmtDate(val) {
            if (!val) return '-';
            const s = String(val).substring(0, 10);
            const p = s.split('-');
            return (p.length === 3 && p[0].length === 4) ? `${p[2]}-${p[1]}-${p[0]}` : s;
        }

        function notify(msg, type = 'success') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: type === 'error' ? 'error' : 'success',
                    title: msg,
                    showConfirmButton: false,
                    timer: 2600
                });
            } else {
                alert(msg);
            }
        }

        function resetForm() {
            $('#sv_sale_id').val('0');
            $('#sv_vehicle_id').val('0');
            $('#sv_car_select').removeClass('d-none').val('').trigger('change');
            if ($('#sv_car_select').data('select2')) {
                $('#sv_car_select').next('.select2-container').show();
            }
            $('#sv_car_no_readonly').addClass('d-none').val('');
            $('#sv_car_type, #sv_model_year, #sv_car_color, #sv_mileage_km, #sv_buyer_name, #sv_cpr_id, #sv_contact_phone, #sv_contact_mobile, #sv_email, #sv_sale_amount, #sv_note').val('');
            $('#sv_sale_date').val(new Date().toISOString().slice(0, 10));
            $('#svEditBadge').addClass('d-none');
            $('#btnSaveSale').text('Save');
        }

        function loadAvailableVehicles() {
            $.get('/SoldVehicleController', { action: 'list_available_vehicles' }, function(res) {
                if (!res || !res.status) return;
                availableVehicles = res.data || [];
                const $sel = $('#sv_car_select');
                if ($sel.data('select2')) $sel.select2('destroy');
                $sel.empty().append('<option value="">Select Car No.</option>');
                availableVehicles.forEach(v => {
                    const label = `${v.vehicle_number} - ${v.brand_name ? v.brand_name + ' ' : ''}${v.model_names || ''} (${v.vehicle_status || 'Available'})`;
                    $sel.append(`<option value="${v.ids}">${esc(label)}</option>`);
                });
                $sel.select2({ placeholder: 'Select Car No.', width: '100%' });
            }, 'json');
        }

        function loadSoldVehicles() {
            $.get('/SoldVehicleController', { action: 'list_sold_vehicles' }, function(res) {
                if (!res || !res.status) return;
                soldRows = res.data || [];
                $('#svTotalBadge').text(`${soldRows.length} Sold`);
                if (!dt) {
                    dt = $('#soldVehiclesTable').DataTable({
                        data: soldRows,
                        pageLength: 15,
                        order: [],
                        columns: [
                            { data: null, className: 'text-center', render: (d, t, r, m) => m.row + 1 },
                            { data: 'sale_date', className: 'text-nowrap', render: v => fmtDate(v) },
                            {
                                data: null,
                                render: r => `<div class="fw-bold text-danger">${esc(r.vehicle_number || '')}</div><small class="text-muted">${esc(r.car_type || '')} ${r.model_year ? '(' + esc(r.model_year) + ')' : ''}</small>`
                            },
                            {
                                data: null,
                                render: r => `<div class="fw-semibold">${esc(r.buyer_name || '')}</div><small class="text-muted">${esc(r.contact_mobile || r.contact_phone || r.cpr_id_number || '')}</small>`
                            },
                            { data: 'mileage_km', className: 'text-end', render: v => v !== null && v !== '' ? Number(v).toLocaleString() + ' km' : '-' },
                            { data: 'sale_amount', className: 'text-end fw-bold text-success', render: v => Number(v || 0).toFixed(3) },
                            {
                                data: 'ids',
                                className: 'text-center text-nowrap',
                                orderable: false,
                                render: id => `
                                    <button type="button" class="btn btn-sm btn-icon text-primary btn-sv-edit" data-id="${id}" title="Edit"><i class="ri-edit-line"></i></button>
                                    <button type="button" class="btn btn-sm btn-icon text-danger btn-sv-revert" data-id="${id}" title="Revert Sale"><i class="ri-arrow-go-back-line"></i></button>
                                `
                            }
                        ]
                    });
                } else {
                    dt.clear().rows.add(soldRows).draw();
                }
            }, 'json');
        }

        $('#sv_car_select').on('change', function() {
            const vid = parseInt($(this).val() || '0', 10);
            $('#sv_vehicle_id').val(vid);
            const v = availableVehicles.find(x => parseInt(x.ids, 10) === vid);
            if (!v) {
                if (parseInt($('#sv_sale_id').val() || '0', 10) === 0) {
                    $('#sv_car_type, #sv_model_year, #sv_car_color, #sv_mileage_km').val('');
                }
                return;
            }
            const cType = [v.brand_name, v.model_names].filter(Boolean).join(' - ');
            $('#sv_car_type').val(cType);
            $('#sv_model_year').val(v.vehicle_year || '');
            $('#sv_car_color').val(v.vehicle_color || '');
            $('#sv_mileage_km').val(v.mileage_km || '');
        });

        $('#btnSaveAndNew').on('click', function() {
            saveAndNewFlag = true;
            $('#soldVehicleForm').trigger('submit');
        });

        $('#btnCancelSale').on('click', function() {
            resetForm();
        });

        $('#soldVehicleForm').on('submit', function(e) {
            e.preventDefault();
            const payload = {
                action: 'save_sale',
                ids: parseInt($('#sv_sale_id').val() || '0', 10),
                vehicle_id: parseInt($('#sv_vehicle_id').val() || '0', 10),
                sale_date: $('#sv_sale_date').val(),
                mileage_km: $('#sv_mileage_km').val(),
                buyer_name: $.trim($('#sv_buyer_name').val()),
                cpr_id_number: $.trim($('#sv_cpr_id').val()),
                contact_phone: $.trim($('#sv_contact_phone').val()),
                contact_mobile: $.trim($('#sv_contact_mobile').val()),
                email: $.trim($('#sv_email').val()),
                sale_amount: $('#sv_sale_amount').val(),
                note: $.trim($('#sv_note').val())
            };

            $.ajax({
                url: '/SoldVehicleController',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                success: function(res) {
                    if (res && res.status) {
                        notify(res.message || 'Saved successfully.', 'success');
                        resetForm();
                        loadAvailableVehicles();
                        loadSoldVehicles();
                        if (saveAndNewFlag) {
                            setTimeout(() => $('#sv_car_select').select2('open'), 250);
                        }
                    } else {
                        notify((res && res.message) || 'Failed to save.', 'error');
                    }
                    saveAndNewFlag = false;
                },
                error: function() {
                    saveAndNewFlag = false;
                    notify('Network error saving vehicle sale.', 'error');
                }
            });
        });

        $(document).on('click', '.btn-sv-edit', function() {
            const id = parseInt($(this).data('id'), 10);
            const r = soldRows.find(x => parseInt(x.ids, 10) === id);
            if (!r) return;

            $('#sv_sale_id').val(r.ids);
            $('#sv_vehicle_id').val(r.vehicle_id);
            if ($('#sv_car_select').data('select2')) {
                $('#sv_car_select').next('.select2-container').hide();
            }
            $('#sv_car_select').addClass('d-none');
            $('#sv_car_no_readonly').removeClass('d-none').val(r.vehicle_number || '');
            $('#sv_car_type').val(r.car_type || '');
            $('#sv_model_year').val(r.model_year || '');
            $('#sv_car_color').val(r.car_color || '');
            $('#sv_sale_date').val(String(r.sale_date || '').substring(0, 10));
            $('#sv_mileage_km').val(r.mileage_km || '');
            $('#sv_buyer_name').val(r.buyer_name || '');
            $('#sv_cpr_id').val(r.cpr_id_number || '');
            $('#sv_contact_phone').val(r.contact_phone || '');
            $('#sv_contact_mobile').val(r.contact_mobile || '');
            $('#sv_email').val(r.email || '');
            $('#sv_sale_amount').val(Number(r.sale_amount || 0).toFixed(3));
            $('#sv_note').val(r.note || '');
            $('#svEditBadge').removeClass('d-none');
            $('#btnSaveSale').text('Update');
        });

        $(document).on('click', '.btn-sv-revert', function() {
            const id = parseInt($(this).data('id'), 10);
            const doRevert = () => {
                $.ajax({
                    url: '/SoldVehicleController',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ action: 'delete_sale', ids: id }),
                    success: function(res) {
                        if (res && res.status) {
                            notify(res.message || 'Sale reverted.', 'success');
                            loadAvailableVehicles();
                            loadSoldVehicles();
                        } else {
                            notify((res && res.message) || 'Failed to revert sale.', 'error');
                        }
                    }
                });
            };
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Revert Vehicle Sale?',
                    text: 'This will remove the sale entry and restore the vehicle status to Available.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, revert'
                }).then(r => { if (r.isConfirmed) doRevert(); });
            } else if (confirm('Revert this sale and restore vehicle to Available?')) {
                doRevert();
            }
        });

        loadAvailableVehicles();
        loadSoldVehicles();
    })();
    </script>
</body>
</html>
