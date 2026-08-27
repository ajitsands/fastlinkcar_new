(function ($) {
    'use strict';

    window.USER_PERMISSIONS = window.USER_PERMISSIONS || [];

    function hasPermission(permissionKey) {
        if (!permissionKey) return true;
        if (Array.isArray(window.USER_PERMISSIONS)) {
            if (window.USER_PERMISSIONS.includes('*')) return true;
            
            // Support comma-separated OR logic
            if (permissionKey.indexOf(',') !== -1) {
                var keys = permissionKey.split(',');
                for (var i = 0; i < keys.length; i++) {
                    if (window.USER_PERMISSIONS.includes(keys[i].trim())) {
                        return true;
                    }
                }
                return false;
            }
            
            return window.USER_PERMISSIONS.includes(permissionKey);
        }
        return false;
    }

    function applyUiPermissions(container) {
        var $root = container ? $(container) : $(document);

        // 1. Hide/disable individual elements tagged with data-permission
        $root.find('[data-permission]').each(function () {
            var permKey = $(this).attr('data-permission');
            if (permKey && !hasPermission(permKey)) {
                var elemType = $(this).prop('tagName').toLowerCase();

                if (elemType === 'li' || elemType === 'tr' || elemType === 'div' || elemType === 'span' || elemType === 'a') {
                    $(this).addClass('d-none').css('display', 'none');
                } else if (elemType === 'button' || elemType === 'input' || elemType === 'select') {
                    $(this).prop('disabled', true).addClass('disabled d-none').css('display', 'none');
                } else {
                    $(this).addClass('d-none').css('display', 'none');
                }
            }
        });

        // 2. Hide parent top-level dropdown menus if all child submenus are hidden
        $('.menu-inner > .menu-item').each(function () {
            var $parentMenu = $(this);
            var $subItems = $parentMenu.find('.menu-sub .menu-item');
            if ($subItems.length > 0) {
                var visibleCount = 0;
                $subItems.each(function () {
                    if (!$(this).hasClass('d-none') && $(this).css('display') !== 'none') {
                        visibleCount++;
                    }
                });
                if (visibleCount === 0) {
                    $parentMenu.addClass('d-none').css('display', 'none');
                } else {
                    $parentMenu.removeClass('d-none').css('display', '');
                }
            }
        });
    }

    window.hasPermission = hasPermission;
    window.applyUiPermissions = applyUiPermissions;

    $(document).ready(function () {
        applyUiPermissions();

        // Re-enforce on dynamic DOM changes / DataTables redraws
        $(document).on('draw.dt', function (e, settings) {
            if (settings && settings.nTable) {
                applyUiPermissions(settings.nTable);
            }
        });

        // Trigger UI enforcement whenever window.USER_PERMISSIONS is updated dynamically
        $(document).on('permissionsUpdated', function () {
            applyUiPermissions();
        });
    });
})(jQuery);
