/**
 * Lightweight bridge between embedded eXeLearning editor and Moodle modal.
 *
 * @module      mod_exeweb/moodle_exe_bridge
 */

/* eslint-disable no-console */

(function() {
    'use strict';

    var config = window.__MOODLE_EXE_CONFIG__ || {};
    var targetOrigin = window.__EXE_EMBEDDING_CONFIG__?.parentOrigin || '*';

    function notifyParent(type, data) {
        if (window.parent && window.parent !== window) {
            window.parent.postMessage({
                source: 'exeweb-editor',
                type: type,
                data: data || {},
            }, targetOrigin);
        }
    }

    function postProtocolMessage(message) {
        if (window.parent && window.parent !== window) {
            window.parent.postMessage(message, targetOrigin);
        }
    }

    var monitoredYdoc = null;
    var changeNotified = false;

    function monitorDocumentChanges() {
        try {
            var app = window.eXeLearning?.app;
            var ydoc = app?.project?._yjsBridge?.documentManager?.ydoc;
            if (!ydoc || typeof ydoc.on !== 'function') {
                return;
            }
            if (ydoc === monitoredYdoc) {
                return;
            }
            monitoredYdoc = ydoc;
            changeNotified = false;
            ydoc.on('update', function() {
                if (!changeNotified) {
                    changeNotified = true;
                    postProtocolMessage({type: 'DOCUMENT_CHANGED'});
                }
            });
        } catch (error) {
            console.warn('[moodle-exe-bridge] Change monitor failed:', error);
        }
    }

    async function notifyWhenDocumentLoaded() {
        try {
            var timeout = 30000;
            var start = Date.now();
            while (Date.now() - start < timeout) {
                var app = window.eXeLearning?.app;
                var manager = app?.project?._yjsBridge?.documentManager;
                if (manager) {
                    postProtocolMessage({type: 'DOCUMENT_LOADED'});
                    monitorDocumentChanges();
                    return;
                }
                await new Promise(function(resolve) {
                    setTimeout(resolve, 150);
                });
            }
        } catch (error) {
            console.warn('[moodle-exe-bridge] DOCUMENT_LOADED monitor failed:', error);
        }
    }

    // Re-attach ydoc monitor when the parent sends messages that may replace the document.
    window.addEventListener('message', function() {
        // After any parent message, re-check ydoc on next tick (it may have been replaced by OPEN_FILE).
        setTimeout(monitorDocumentChanges, 500);
    });

    async function init() {
        try {
            if (window.eXeLearning?.ready) {
                await window.eXeLearning.ready;
            }

            notifyParent('editor-ready', {
                cmid: config.cmid || null,
                packageUrl: config.packageUrl || '',
            });

            notifyWhenDocumentLoaded();

            document.addEventListener('keydown', function(event) {
                if ((event.ctrlKey || event.metaKey) && event.key === 's') {
                    event.preventDefault();
                    notifyParent('request-save');
                }
            });
        } catch (error) {
            console.error('[moodle-exe-bridge] Initialization failed:', error);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
