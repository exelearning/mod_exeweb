// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * AMD module for the admin embedded editor settings widget.
 *
 * Handles AJAX calls to install, update, repair, and uninstall the
 * admin-managed embedded eXeLearning editor, with progress feedback
 * and polling for long-running operations.
 *
 * @module     mod_exeweb/admin_embedded_editor
 * @copyright  2025 eXeLearning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'core/ajax', 'core/notification', 'core/str'], function($, Ajax, Notification, Str) {

    /** Maximum seconds to wait before switching to polling. */
    var ACTION_TIMEOUT_MS = 120000;

    /** Polling interval in milliseconds. */
    var POLL_INTERVAL_MS = 10000;

    /** Maximum number of polling iterations (5 minutes). */
    var MAX_POLL_ITERATIONS = 30;

    /**
     * Find the widget container element.
     *
     * @returns {jQuery} The container element.
     */
    var getContainer = function() {
        return $('.mod_exeweb-admin-embedded-editor').first();
    };

    /**
     * Return the latest-version UI elements used by the widget.
     *
     * @param {jQuery} container - The widget container.
     * @returns {{spinnerEl: jQuery, textEl: jQuery}}
     */
    var getLatestVersionElements = function(container) {
        return {
            spinnerEl: container.find('.mod_exeweb-latest-version-spinner'),
            textEl: container.find('.mod_exeweb-latest-version-text'),
        };
    };

    /**
     * Disable all action buttons in the widget.
     *
     * @param {jQuery} container - The widget container.
     */
    var disableButtons = function(container) {
        container.find('[data-action]').prop('disabled', true);
    };

    /**
     * Enable action buttons based on current status data.
     *
     * @param {jQuery} container - The widget container.
     * @param {Object} statusData - Status object from get_status response.
     */
    var enableButtons = function(container, statusData) {
        container.find('.mod_exeweb-btn-install').prop('disabled', true).hide();
        container.find('.mod_exeweb-btn-update').prop('disabled', true).hide();
        container.find('.mod_exeweb-btn-uninstall').prop('disabled', true).hide();

        if (statusData.can_install) {
            container.find('.mod_exeweb-btn-install').prop('disabled', false).show();
        }
        if (statusData.can_update) {
            container.find('.mod_exeweb-btn-update').prop('disabled', false).show();
        }
        if (statusData.can_uninstall) {
            container.find('.mod_exeweb-btn-uninstall').prop('disabled', false).show();
        }
    };

    /**
     * Show the progress bar area and hide the result area.
     *
     * @param {jQuery} container - The widget container.
     */
    var showProgress = function(container) {
        container.find('.mod_exeweb-progress-container').show();
        container.find('.mod_exeweb-result-area').hide();
    };

    /**
     * Hide the progress bar area.
     *
     * @param {jQuery} container - The widget container.
     */
    var hideProgress = function(container) {
        container.find('.mod_exeweb-progress-container').hide();
    };

    /**
     * Reload the current page after a short delay so users can see success state.
     */
    var reloadPage = function() {
        window.setTimeout(function() {
            window.location.reload();
        }, 800);
    };

    /**
     * Set the progress bar visual state.
     *
     * @param {jQuery} container - The widget container.
     * @param {string} state - One of 'active', 'success', or 'error'.
     * @param {string} [message] - Optional message to display below the bar.
     */
    var setProgressState = function(container, state, message) {
        var bar = container.find('.mod_exeweb-progress-container .progress-bar');
        var msgEl = container.find('.mod_exeweb-progress-message');

        bar.removeClass('bg-success bg-danger progress-bar-striped progress-bar-animated');
        bar.css('width', '100%');
        bar.attr('aria-valuenow', 100);

        if (state === 'active') {
            bar.addClass('progress-bar-striped progress-bar-animated');
        } else if (state === 'success') {
            bar.addClass('bg-success');
        } else if (state === 'error') {
            bar.addClass('bg-danger');
        }

        if (message !== undefined) {
            msgEl.text(message);
        } else {
            msgEl.text('');
        }
    };

    /**
     * Render the latest-version text, optionally with an update badge.
     *
     * @param {jQuery} textEl - Target element.
     * @param {string} text - Main text to show.
     * @param {string|null} badgeText - Optional badge label.
     */
    var setLatestVersionText = function(textEl, text, badgeText) {
        if (badgeText) {
            textEl.html(text + ' <span class="badge badge-warning bg-warning ms-1 ml-1">' + badgeText + '</span>');
        } else {
            textEl.text(text);
        }
    };

    /**
     * Fetch the latest-version prefix label.
     *
     * @param {string} version - Version string.
     * @returns {Promise<string>}
     */
    var getLatestVersionLabel = function(version) {
        return Str.get_string('editorlatestversionongithub', 'mod_exeweb')
            .then(function(prefix) {
                return prefix + ' v' + version;
            })
            .catch(function() {
                return 'v' + version;
            });
    };

    /**
     * Fetch the optional update-available badge label.
     *
     * @param {Object} statusData - Status object from get_status response.
     * @returns {Promise<string|null>}
     */
    var getLatestVersionBadgeLabel = function(statusData) {
        if (!statusData.update_available) {
            return Promise.resolve(null);
        }

        return Str.get_string('updateavailable', 'mod_exeweb')
            .catch(function() {
                return Str.get_string('editorupdateavailable', 'mod_exeweb', statusData.latest_version);
            })
            .catch(function() {
                return null;
            });
    };

    /**
     * Update the latest version area in the DOM.
     *
     * @param {jQuery} container - The widget container.
     * @param {Object} statusData - Status object from get_status response.
     */
    var updateLatestVersionArea = function(container, statusData) {
        var elements = getLatestVersionElements(container);
        var spinnerEl = elements.spinnerEl;
        var textEl = elements.textEl;

        spinnerEl.hide();
        textEl.show();

        if (statusData.latest_error) {
            textEl.text('(' + statusData.latest_error + ')');
        } else if (statusData.latest_version) {
            Promise.all([
                getLatestVersionLabel(statusData.latest_version),
                getLatestVersionBadgeLabel(statusData),
            ]).then(function(results) {
                setLatestVersionText(textEl, results[0], results[1]);
            }).catch(function() {
                textEl.text('v' + statusData.latest_version);
            });
        } else {
            textEl.text('');
        }
    };

    /**
     * Update all DOM elements based on a get_status response.
     *
     * @param {jQuery} container - The widget container.
     * @param {Object} statusData - Status object from get_status response.
     */
    var updateStatus = function(container, statusData) {
        updateLatestVersionArea(container, statusData);
        enableButtons(container, statusData);
    };

    /**
     * Show a result message in the result area.
     *
     * @param {jQuery} container - The widget container.
     * @param {string} message - The message text.
     * @param {string} type - Bootstrap alert type: 'success', 'danger', or 'warning'.
     */
    var showResultMessage = function(container, message, type) {
        var resultArea = container.find('.mod_exeweb-result-area');
        var msgEl = container.find('.mod_exeweb-result-message');

        msgEl.removeClass('alert-success alert-danger alert-warning')
             .addClass('alert-' + type)
             .text(message);
        resultArea.show();
    };

    /**
     * Call get_status via AJAX and return a Promise.
     *
     * @param {boolean} checklatest - Whether to query GitHub for the latest version.
     * @returns {Promise} Resolves with the status data object.
     */
    var callGetStatus = function(checklatest) {
        var requests = Ajax.call([{
            methodname: 'mod_exeweb_manage_embedded_editor_status',
            args: {checklatest: !!checklatest},
        }]);
        return requests[0];
    };

    /**
     * Call execute_action via AJAX and return a Promise.
     *
     * @param {string} action - One of: install, update, repair, uninstall.
     * @returns {Promise} Resolves with the action result object.
     */
    var callExecuteAction = function(action) {
        var requests = Ajax.call([{
            methodname: 'mod_exeweb_manage_embedded_editor_action',
            args: {action: action},
        }]);
        return requests[0];
    };

    /**
     * Refresh widget status from the server.
     *
     * @param {jQuery} container - The widget container.
     * @param {boolean} checklatest - Whether latest GitHub version should be queried.
     * @returns {Promise<Object>}
     */
    var refreshStatus = function(container, checklatest) {
        return callGetStatus(checklatest).then(function(statusData) {
            updateStatus(container, statusData);
            return statusData;
        });
    };

    /**
     * Begin a polling loop after an action timeout.
     *
     * Polls get_status every POLL_INTERVAL_MS milliseconds. Stops when:
     * - installing === false (operation done)
     * - install_stale === true (stale lock, show warning)
     * - MAX_POLL_ITERATIONS exceeded (timeout)
     *
     * @param {jQuery} container - The widget container.
     */
    var startPolling = function(container) {
        var iterations = 0;

        var poll = function() {
            iterations++;

            if (iterations > MAX_POLL_ITERATIONS) {
                Str.get_string('operationtimedout', 'mod_exeweb').then(function(msg) {
                    setProgressState(container, 'error', msg);
                    showResultMessage(container, msg, 'danger');
                    Notification.addNotification({message: msg, type: 'error'});
                    return msg;
                }).catch(function() {
                    var msg = 'Timeout';
                    setProgressState(container, 'error', msg);
                    showResultMessage(container, msg, 'danger');
                    Notification.addNotification({message: msg, type: 'error'});
                });
                callGetStatus(false).then(function(statusData) {
                    enableButtons(container, statusData);
                    return statusData;
                }).catch(function() {
                    container.find('[data-action]').prop('disabled', false);
                });
                return;
            }

            callGetStatus(false).then(function(statusData) {
                if (statusData.install_stale) {
                    Str.get_string('installstale', 'mod_exeweb').then(function(msg) {
                        setProgressState(container, 'error', msg);
                        showResultMessage(container, msg, 'warning');
                        Notification.addNotification({message: msg, type: 'warning'});
                        return msg;
                    }).catch(function() {
                        var msg = 'Error';
                        setProgressState(container, 'error', msg);
                        showResultMessage(container, msg, 'warning');
                    });
                    updateStatus(container, statusData);
                    return;
                }

                if (!statusData.installing) {
                    // Operation finished.
                    setProgressState(container, 'success');
                    hideProgress(container);
                    refreshStatus(container, true).then(function(freshStatus) {
                        return freshStatus;
                    }).catch(function() {
                        updateStatus(container, statusData);
                    });
                    return;
                }

                // Still installing — continue polling.
                Str.get_string('stillworking', 'mod_exeweb').then(function(msg) {
                    setProgressState(container, 'active', msg);
                    return msg;
                }).catch(function() {
                    setProgressState(container, 'active');
                });

                setTimeout(poll, POLL_INTERVAL_MS);
                return statusData;
            }).catch(function() {
                // On poll error, just try again unless we've hit the limit.
                setTimeout(poll, POLL_INTERVAL_MS);
            });
        };

        Str.get_string('operationtakinglong', 'mod_exeweb').then(function(msg) {
            setProgressState(container, 'active', msg);
            return msg;
        }).catch(function() {
            setProgressState(container, 'active');
        });

        setTimeout(poll, POLL_INTERVAL_MS);
    };

    /**
     * Execute an action (install/update/repair/uninstall) via AJAX.
     *
     * Handles the full lifecycle: disable buttons, show progress, call AJAX,
     * set up timeout/polling, and refresh status on completion.
     *
     * @param {jQuery} container - The widget container.
     * @param {string} action - The action to perform.
     */
    var executeAction = function(container, action) {
        disableButtons(container);
        showProgress(container);
        setProgressState(container, 'active');

        var timeoutHandle = null;
        var timedOut = false;

        timeoutHandle = setTimeout(function() {
            timedOut = true;
            startPolling(container);
        }, ACTION_TIMEOUT_MS);

        callExecuteAction(action).then(function(result) {
            if (timedOut) {
                // Polling has already taken over — ignore late AJAX result.
                return result;
            }
            clearTimeout(timeoutHandle);

            setProgressState(container, 'success');
            var message = result.message || 'Done.';
            showResultMessage(container, message, 'success');
            Notification.addNotification({message: message, type: 'success'});

            refreshStatus(container, true).then(function(statusData) {
                hideProgress(container);
                reloadPage();
                return statusData;
            }).catch(function() {
                hideProgress(container);
                reloadPage();
            });

            return result;
        }).catch(function(err) {
            if (timedOut) {
                return;
            }
            clearTimeout(timeoutHandle);

            setProgressState(container, 'error');
            var message = (err && err.message) ? err.message : 'An error occurred.';
            showResultMessage(container, message, 'danger');
            Notification.addNotification({message: message, type: 'error'});

            callGetStatus(false).then(function(statusData) {
                enableButtons(container, statusData);
                return statusData;
            }).catch(function() {
                container.find('[data-action]').prop('disabled', false);
            });
        });
    };

    /**
     * Handle a button click — confirm for uninstall, then dispatch executeAction.
     *
     * @param {jQuery} container - The widget container.
     * @param {string} action - The action string from data-action.
     */
    var handleActionClick = function(container, action) {
        if (action === 'uninstall') {
            Str.get_strings([
                {key: 'confirmuninstalltitle', component: 'mod_exeweb'},
                {key: 'confirmuninstall', component: 'mod_exeweb'},
                {key: 'yes', component: 'core'},
                {key: 'no', component: 'core'},
            ]).then(function(strings) {
                Notification.confirm(
                    strings[0],
                    strings[1],
                    strings[2],
                    strings[3],
                    function() {
                        executeAction(container, action);
                    }
                );
                return strings;
            }).catch(function() {
                // Fallback to native confirm if string fetch fails.
                if (window.confirm(container.attr('data-confirm-uninstall') || '')) {
                    executeAction(container, action);
                }
            });
        } else {
            executeAction(container, action);
        }
    };

    /**
     * Initialise the widget.
     *
     * Called from PHP via js_call_amd. Fetches the latest version from GitHub
     * and sets up button click handlers.
     *
     * @param {Object} config - Configuration object passed from PHP.
     */
    var init = function(config) {
        // config is reserved for future use (e.g. widgetId for multiple widgets).
        void config;

        var container = getContainer();
        if (!container.length) {
            return;
        }

        var elements = getLatestVersionElements(container);
        elements.spinnerEl.show();
        elements.textEl.hide();

        // Fetch full status on load so the widget can expose update availability.
        refreshStatus(container, true).then(function(statusData) {
            return statusData;
        }).catch(function() {
            elements.spinnerEl.hide();
            elements.textEl.show();
        });

        // Delegate click handler for all action buttons.
        container.on('click', '[data-action]', function(e) {
            e.preventDefault();
            var action = $(this).data('action');
            if (!action) {
                return;
            }
            handleActionClick(container, action);
        });
    };

    return {
        init: init,
    };
});
