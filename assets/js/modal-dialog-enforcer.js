/**
 * Global Modal Dialog Enforcer
 * --------------------------------------------------------------------------
 * Configures all modals across the entire application to behave as true dialogs:
 * 1. Clicking outside the modal dialog does NOT close the modal.
 * 2. Pressing the Escape key does NOT close the modal.
 * 3. The modal can ONLY be closed when the user clicks the modal close button ('X')
 *    or any Cancel / Dismiss / Close action button.
 * --------------------------------------------------------------------------
 */
(function () {
  'use strict';

  function enforceModalStatic(modalEl) {
    if (!modalEl || !modalEl.setAttribute) return;
    try {
      modalEl.setAttribute('data-bs-backdrop', 'static');
      modalEl.setAttribute('data-backdrop', 'static');
      modalEl.setAttribute('data-bs-keyboard', 'false');
      modalEl.setAttribute('data-keyboard', 'false');

      if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        var instance = bootstrap.Modal.getInstance(modalEl);
        if (instance && instance._config) {
          instance._config.backdrop = 'static';
          instance._config.keyboard = false;
        }
      }
    } catch (e) {
      console.warn('Error enforcing static modal on element:', e);
    }
  }

  // 1. Configure Bootstrap 5 Modal Defaults Globally
  if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
    if (bootstrap.Modal.Default) {
      bootstrap.Modal.Default.backdrop = 'static';
      bootstrap.Modal.Default.keyboard = false;
    }
    // Intercept prototype._getConfig to guarantee backdrop is always 'static' and keyboard is false
    if (bootstrap.Modal.prototype && bootstrap.Modal.prototype._getConfig) {
      var origGetConfig = bootstrap.Modal.prototype._getConfig;
      bootstrap.Modal.prototype._getConfig = function (config) {
        var cfg = origGetConfig.call(this, config);
        cfg.backdrop = 'static';
        cfg.keyboard = false;
        return cfg;
      };
    }
  }

  // 2. Configure jQuery Bootstrap Plugin Defaults (if available)
  if (typeof jQuery !== 'undefined') {
    if (jQuery.fn && jQuery.fn.modal) {
      if (jQuery.fn.modal.Constructor && jQuery.fn.modal.Constructor.Default) {
        jQuery.fn.modal.Constructor.Default.backdrop = 'static';
        jQuery.fn.modal.Constructor.Default.keyboard = false;
      }

      // Wrap $.fn.modal to ensure any options object passed dynamically also enforces static backdrop
      var origJQueryModal = jQuery.fn.modal;
      var newJQueryModal = function (config, relatedTarget) {
        if (typeof config === 'object') {
          config = config || {};
          config.backdrop = 'static';
          config.keyboard = false;
        }
        return origJQueryModal.call(this, config, relatedTarget);
      };
      for (var prop in origJQueryModal) {
        if (Object.prototype.hasOwnProperty.call(origJQueryModal, prop)) {
          newJQueryModal[prop] = origJQueryModal[prop];
        }
      }
      jQuery.fn.modal = newJQueryModal;
    }

    // Explicit delegated safety handler for dismiss buttons
    jQuery(document).on(
      'click',
      '.modal [data-bs-dismiss="modal"], .modal [data-dismiss="modal"], .modal .btn-close, .modal .close',
      function () {
        var modalEl = jQuery(this).closest('.modal')[0];
        if (modalEl) {
          if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            var inst = bootstrap.Modal.getInstance(modalEl);
            if (inst) {
              inst.hide();
              return;
            }
          }
          jQuery(modalEl).modal('hide');
        }
      }
    );

    // Enforce on show.bs.modal event
    jQuery(document).on('show.bs.modal', '.modal', function () {
      enforceModalStatic(this);
    });
  }

  // 3. Native event capture for show.bs.modal
  document.addEventListener(
    'show.bs.modal',
    function (e) {
      if (e.target && e.target.classList && e.target.classList.contains('modal')) {
        enforceModalStatic(e.target);
      }
    },
    true
  );

  // 4. Enforce on all existing modals currently in DOM
  function applyToAllExistingModals() {
    document.querySelectorAll('.modal').forEach(enforceModalStatic);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', applyToAllExistingModals);
  } else {
    applyToAllExistingModals();
  }

  // 5. Observe DOM mutations for any dynamically injected modals
  if (typeof MutationObserver !== 'undefined') {
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        mutation.addedNodes.forEach(function (node) {
          if (node.nodeType === 1) {
            if (node.classList && node.classList.contains('modal')) {
              enforceModalStatic(node);
            }
            if (node.querySelectorAll) {
              node.querySelectorAll('.modal').forEach(enforceModalStatic);
            }
          }
        });
      });
    });

    var observeTarget = document.body || document.documentElement;
    if (observeTarget) {
      observer.observe(observeTarget, { childList: true, subtree: true });
    } else {
      document.addEventListener('DOMContentLoaded', function () {
        if (document.body) {
          observer.observe(document.body, { childList: true, subtree: true });
        }
      });
    }
  }
})();
