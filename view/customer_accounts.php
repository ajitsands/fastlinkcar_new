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
    <style>
        @media (max-width: 991.98px) {
            .container-p-y { padding-top: 15px !important; }
        }
        @media (min-width: 992px) {
            .container-p-y { padding-top: 55px !important; }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <?php include ROOT_PATH . '/view/templates/nav.php'; ?>

            <div class="layout-page">
                <div class="content-wrapper">
                    <?php include ROOT_PATH . '/view/templates/menu.php'; ?>

                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold mb-1" style="color: #1b3d94;">
                                    <i class="ri-bank-card-line me-1"></i> Customer Accounts Master
                                </h4>
                                <p class="text-muted mb-0">Manage customer account groups and their active/inactive status.</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-12 col-lg-4">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-semibold" style="color: #1b3d94;" id="caFormTitle">Add Customer Account</h5>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" id="ca_ids" value="">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" class="form-control" id="ca_account_name" placeholder="Account Name">
                                            <label for="ca_account_name">Account Name *</label>
                                        </div>
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select class="form-select" id="ca_status">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                            <label for="ca_status">Status</label>
                                        </div>
                                        <div class="d-flex justify-content-between gap-2">
                                            <button type="button" class="btn btn-secondary" id="ca_reset_btn">
                                                <i class="ri-refresh-line me-1"></i> Reset
                                            </button>
                                            <button type="button" class="btn btn-primary" id="ca_save_btn">
                                                <i class="ri-save-line me-1"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-8">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-semibold" style="color: #1b3d94;">Customer Accounts List</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="customerAccountsTable" class="table table-hover align-middle w-100">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Account Name</th>
                                                        <th>Status</th>
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

    <div id="dropdownContent" style="text-align:center;"></div>
    <?php include ROOT_PATH . '/view/templates/scripts.php'; ?>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/settings.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>assets/sands/sands_popup.js"></script>
    <script src="<?= $_ENV['BASE_URL'] ?>alertmessage/js/sandsalert.js"></script>

    <script>
    $(document).ready(function() {
        let caTable = null;

        function resetForm() {
            $('#ca_ids').val('');
            $('#ca_account_name').val('');
            $('#ca_status').val('Active');
            $('#caFormTitle').text('Add Customer Account');
            $('#ca_save_btn').html('<i class="ri-save-line me-1"></i> Save');
        }

        function loadAccounts() {
            fetch('/CustomerAccountController?action=list')
                .then(r => r.json())
                .then(res => {
                    const rows = res.data || [];
                    if (caTable) {
                        caTable.clear().rows.add(rows).draw();
                        return;
                    }
                    caTable = $('#customerAccountsTable').DataTable({
                        data: rows,
                        responsive: true,
                        pageLength: 10,
                        columns: [
                            { data: null, render: (d, t, r, m) => m.row + 1 },
                            { data: 'account_name', render: d => `<span class="fw-semibold">${d || ''}</span>` },
                            {
                                data: 'status',
                                render: d => d === 'Active'
                                    ? '<span class="badge bg-label-success">Active</span>'
                                    : '<span class="badge bg-label-danger">Inactive</span>'
                            },
                            {
                                data: null,
                                className: 'text-center',
                                render: (d, t, row) => `
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit-ca me-1" data-id="${row.ids}">
                                        <i class="ri-edit-line"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-sm ${row.status === 'Active' ? 'btn-outline-warning' : 'btn-outline-success'} btn-toggle-ca" data-id="${row.ids}" data-status="${row.status}">
                                        ${row.status === 'Active' ? 'Deactivate' : 'Activate'}
                                    </button>
                                `
                            }
                        ]
                    });
                });
        }

        $('#ca_reset_btn').on('click', resetForm);

        $('#ca_save_btn').on('click', function() {
            const name = $.trim($('#ca_account_name').val());
            if (!name) {
                setupDropdown('dropdownContent', 'warning', svgError + 'Account Name is required.', 'click');
                return;
            }
            fetch('/CustomerAccountController', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'save',
                    ids: $('#ca_ids').val(),
                    account_name: name,
                    status: $('#ca_status').val()
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    setupDropdown('dropdownContent', 'success', svgSuccess + res.message, 'click');
                    resetForm();
                    loadAccounts();
                } else {
                    setupDropdown('dropdownContent', 'danger', svgDanger + (res.message || 'Failed'), 'click');
                }
            });
        });

        $(document).on('click', '.btn-edit-ca', function() {
            const id = parseInt($(this).data('id'), 10);
            const row = caTable.rows().data().toArray().find(r => parseInt(r.ids, 10) === id);
            if (!row) return;
            $('#ca_ids').val(row.ids);
            $('#ca_account_name').val(row.account_name);
            $('#ca_status').val(row.status);
            $('#caFormTitle').text('Edit Customer Account');
            $('#ca_save_btn').html('<i class="ri-save-line me-1"></i> Update');
        });

        $(document).on('click', '.btn-toggle-ca', function() {
            const id = parseInt($(this).data('id'), 10);
            const cur = $(this).data('status');
            const nextStatus = cur === 'Active' ? 'Inactive' : 'Active';
            fetch('/CustomerAccountController', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'toggle_status', ids: id, status: nextStatus })
            })
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    setupDropdown('dropdownContent', 'success', svgSuccess + res.message, 'click');
                    loadAccounts();
                }
            });
        });

        loadAccounts();
    });
    </script>
</body>
</html>
