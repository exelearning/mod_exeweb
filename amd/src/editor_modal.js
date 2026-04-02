// This file is part of Moodle - http://moodle.org/

/* eslint-disable no-console */

import {get_string as getString} from 'core/str';
import Log from 'core/log';

let overlay = null;
let iframe = null;
let saveBtn = null;
let loadingModal = null;
let editorOrigin = '*';
let openRequestSent = false;
let openRequestId = null;
let exportRequestId = null;
let isSaving = false;
let hasUnsavedChanges = false;
let session = null;
let requestCounter = 0;
let openAttemptCount = 0;
let openResponseTimer = null;

const MAX_OPEN_ATTEMPTS = 3;
const OPEN_RESPONSE_TIMEOUT_MS = 3000;
const FIXED_EXPORT_FORMAT = 'elpx';

const getOrigin = (url) => {
    try {
        return new URL(url, window.location.href).origin;
    } catch {
        return '*';
    }
};

const nextRequestId = (prefix) => {
    requestCounter += 1;
    return `${prefix}-${Date.now()}-${requestCounter}`;
};

const updatePackageUrlRevision = (url, revision) => {
    if (!url || !revision) {
        return url;
    }
    const normalizedRevision = String(revision).replace(/[^0-9]/g, '');
    if (!normalizedRevision) {
        return url;
    }
    const updated = url.replace(/(\/mod_exeweb\/package\/)(\d+)(\/)/, `$1${normalizedRevision}$3`);
    if (updated === url) {
        return url;
    }
    const separator = updated.includes('?') ? '&' : '?';
    return `${updated}${separator}v=${normalizedRevision}-${Date.now()}`;
};

const persistUpdatedPackageUrl = (newUrl) => {
    if (!newUrl || !session) {
        return;
    }
    session.packageUrl = newUrl;
    const selector = `[data-action="mod_exeweb/editor-open"][data-cmid="${String(session.cmid)}"]`;
    const openButton = document.querySelector(selector);
    if (openButton?.dataset) {
        openButton.dataset.packageurl = newUrl;
    }
};

const updateContentUrlRevision = (url, revision) => {
    if (!url || !revision) {
        return url;
    }
    const normalizedRevision = String(revision).replace(/[^0-9]/g, '');
    if (!normalizedRevision) {
        return url;
    }
    const updated = url.replace(/(\/mod_exeweb\/content\/)(\d+)(\/)/, `$1${normalizedRevision}$3`);
    if (updated === url) {
        return url;
    }
    const separator = updated.includes('?') ? '&' : '?';
    return `${updated}${separator}v=${normalizedRevision}-${Date.now()}`;
};

const refreshActivityIframe = (revision) => {
    const activityIframe = document.getElementById('exewebobject');
    if (!activityIframe || !activityIframe.src) {
        return;
    }
    const refreshedSrc = updateContentUrlRevision(activityIframe.src, revision);
    if (refreshedSrc && refreshedSrc !== activityIframe.src) {
        activityIframe.src = refreshedSrc;
    }
};

const setSaveLabel = async(key, fallback) => {
    if (!saveBtn) {
        return;
    }
    try {
        const text = await getString(key, key === 'closebuttontitle' ? 'core' : 'mod_exeweb');
        saveBtn.innerHTML = '<i class="fa fa-graduation-cap mr-1" aria-hidden="true"></i> ' + text;
    } catch {
        saveBtn.innerHTML = '<i class="fa fa-graduation-cap mr-1" aria-hidden="true"></i> ' + fallback;
    }
};

const createLoadingModal = async() => {
    const modal = document.createElement('div');
    modal.className = 'exeweb-loading-modal';
    modal.id = 'exeweb-loading-modal';

    let savingText = 'Saving...';
    let waitText = 'Please wait while the file is being saved.';
    try {
        savingText = await getString('saving', 'mod_exeweb');
        waitText = await getString('savingwait', 'mod_exeweb');
    } catch {
        // Use defaults.
    }

    modal.innerHTML = `
        <div class="exeweb-loading-modal__content">
            <div class="exeweb-loading-modal__spinner"></div>
            <h3 class="exeweb-loading-modal__title">${savingText}</h3>
            <p class="exeweb-loading-modal__message">${waitText}</p>
        </div>
    `;

    document.body.appendChild(modal);
    return modal;
};

const showLoadingModal = async() => {
    if (!loadingModal) {
        loadingModal = await createLoadingModal();
    }
    loadingModal.classList.add('is-visible');
};

const hideLoadingModal = () => {
    if (loadingModal) {
        loadingModal.classList.remove('is-visible');
    }
};

const removeLoadingModal = () => {
    if (loadingModal) {
        loadingModal.remove();
        loadingModal = null;
    }
};

const checkUnsavedChanges = async() => {
    if (!hasUnsavedChanges) {
        return false;
    }
    let message = 'You have unsaved changes. Are you sure you want to close?';
    try {
        message = await getString('unsavedchanges', 'mod_exeweb');
    } catch {
        // Use default.
    }
    return !window.confirm(message);
};

const postToEditor = (message, transfer) => {
    if (!iframe?.contentWindow) {
        return;
    }
    if (transfer && transfer.length) {
        iframe.contentWindow.postMessage(message, editorOrigin, transfer);
    } else {
        iframe.contentWindow.postMessage(message, editorOrigin);
    }
};

const clearOpenResponseTimer = () => {
    if (openResponseTimer) {
        clearTimeout(openResponseTimer);
        openResponseTimer = null;
    }
};

const scheduleOpenRetry = () => {
    if (openAttemptCount >= MAX_OPEN_ATTEMPTS) {
        return;
    }

    setTimeout(() => {
        openInitialPackage();
    }, 300 * openAttemptCount);
};

const armOpenResponseTimer = () => {
    clearOpenResponseTimer();
    openResponseTimer = setTimeout(() => {
        if (!openRequestSent) {
            return;
        }

        Log.error('[editor_modal] OPEN_FILE timeout waiting for response');
        openRequestSent = false;
        scheduleOpenRetry();
    }, OPEN_RESPONSE_TIMEOUT_MS);
};

const setSavingState = async(saving) => {
    isSaving = saving;
    if (!saveBtn) {
        return;
    }
    saveBtn.disabled = saving;
    if (saving) {
        await setSaveLabel('saving', 'Saving...');
        await showLoadingModal();
    } else {
        await setSaveLabel('savetomoodle', 'Save to Moodle');
        hideLoadingModal();
    }
};

const openInitialPackage = async() => {
    if (session?.skipOpenFileOnInit) {
        return;
    }
    if (openRequestSent || !session?.packageUrl) {
        return;
    }

    openRequestSent = true;
    openAttemptCount += 1;

    try {
        const response = await fetch(session.packageUrl, {credentials: 'include'});
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const bytes = await response.arrayBuffer();
        openRequestId = nextRequestId('open');

        postToEditor({
            type: 'OPEN_FILE',
            requestId: openRequestId,
            data: {
                bytes,
                filename: 'package.elpx',
            },
        });

        armOpenResponseTimer();
    } catch (error) {
        Log.error('[editor_modal] Failed to open package:', error);
        openRequestSent = false;
        scheduleOpenRetry();
    }
};

const uploadExportedFile = async(payload) => {
    const bytes = payload?.bytes;
    if (!bytes) {
        throw new Error('Missing export bytes');
    }

    const filename = payload.filename || 'package.elpx';
    const mimeType = payload.mimeType || 'application/zip';

    const blob = new Blob([bytes], {type: mimeType});
    const formData = new FormData();
    formData.append('package', blob, filename);
    formData.append('format', FIXED_EXPORT_FORMAT);
    formData.append('cmid', String(session.cmid));
    formData.append('sesskey', session.sesskey);

    const response = await fetch(session.saveUrl, {
        method: 'POST',
        body: formData,
        credentials: 'include',
    });

    const result = await response.json();
    if (!response.ok || !result?.success) {
        throw new Error(result?.error || `Save failed (${response.status})`);
    }

    const updatedPackageUrl = updatePackageUrlRevision(session.packageUrl, result.revision);
    persistUpdatedPackageUrl(updatedPackageUrl);
    refreshActivityIframe(result.revision);

    hasUnsavedChanges = false;
    await setSaveLabel('savedsuccess', 'Saved successfully');
    close(true);
};

const requestExport = async() => {
    if (isSaving || !iframe?.contentWindow) {
        return;
    }

    await setSavingState(true);
    exportRequestId = nextRequestId('export');

    postToEditor({
        type: 'REQUEST_EXPORT',
        requestId: exportRequestId,
        data: {
            format: FIXED_EXPORT_FORMAT,
            filename: 'package.elpx',
        },
    });
};

const handleBridgeMessage = async(event) => {
    if (!iframe?.contentWindow || event.source !== iframe.contentWindow || !event.data) {
        return;
    }
    if (editorOrigin !== '*' && event.origin !== editorOrigin) {
        return;
    }

    const data = event.data;

    switch (data.type) {
        case 'EXELEARNING_READY':
            postToEditor({
                type: 'CONFIGURE',
                requestId: nextRequestId('configure'),
                data: {
                    hideUI: {
                        fileMenu: true,
                        saveButton: true,
                        userMenu: true,
                    },
                },
            });
            openInitialPackage();
            break;

        case 'DOCUMENT_LOADED':
            if (saveBtn && !isSaving) {
                saveBtn.disabled = false;
            }
            break;

        case 'DOCUMENT_CHANGED':
            hasUnsavedChanges = true;
            break;

        case 'OPEN_FILE_SUCCESS':
            if (data.requestId === openRequestId && saveBtn && !isSaving) {
                saveBtn.disabled = false;
                openRequestSent = false;
                openAttemptCount = 0;
                clearOpenResponseTimer();
            }
            break;

        case 'OPEN_FILE_ERROR':
            if (data.requestId === openRequestId) {
                Log.error('[editor_modal] OPEN_FILE_ERROR:', data.error);
                openRequestSent = false;
                clearOpenResponseTimer();
                scheduleOpenRetry();
            }
            break;

        case 'EXPORT_FILE':
            if (data.requestId === exportRequestId) {
                try {
                    await uploadExportedFile(data);
                } catch (error) {
                    Log.error('[editor_modal] Upload failed:', error);
                    await setSavingState(false);
                }
            }
            break;

        case 'REQUEST_EXPORT_ERROR':
            if (data.requestId === exportRequestId) {
                Log.error('[editor_modal] REQUEST_EXPORT_ERROR:', data.error);
                await setSavingState(false);
            }
            break;

        default:
            break;
    }
};

const handleLegacyBridgeMessage = async(event) => {
    const data = event.data;
    if (!data || data.source !== 'exeweb-editor') {
        return;
    }

    if (data.type === 'editor-ready' && data.data?.packageUrl) {
        const incomingUrl = data.data.packageUrl;
        if (incomingUrl !== session?.packageUrl) {
            session.packageUrl = incomingUrl;
            openRequestSent = false;
            openAttemptCount = 0;
        }
        openInitialPackage();
    }

    if (data.type === 'request-save') {
        await requestExport();
    }
};

const handleMessage = async(event) => {
    await handleBridgeMessage(event);
    await handleLegacyBridgeMessage(event);
};

const handleKeydown = (event) => {
    if (event.key === 'Escape') {
        close(false);
    }
};

export const close = async(skipConfirm) => {
    if (!overlay) {
        return;
    }
    if (!skipConfirm) {
        const shouldCancel = await checkUnsavedChanges();
        if (shouldCancel) {
            return;
        }
    }

    const wasShowingLoader = isSaving || (skipConfirm === true);

    overlay.remove();
    overlay = null;
    iframe = null;
    saveBtn = null;
    session = null;
    openRequestSent = false;
    openRequestId = null;
    exportRequestId = null;
    isSaving = false;
    hasUnsavedChanges = false;
    openAttemptCount = 0;
    clearOpenResponseTimer();

    document.body.style.overflow = '';
    window.removeEventListener('message', handleMessage);
    document.removeEventListener('keydown', handleKeydown);

    if (wasShowingLoader) {
        setTimeout(() => {
            hideLoadingModal();
            removeLoadingModal();
        }, 1500);
    } else {
        hideLoadingModal();
        removeLoadingModal();
    }
};

export const open = async(cmid, editorUrl, activityName, packageUrl, saveUrl, sesskey) => {
    Log.debug('[editor_modal] Opening editor for cmid:', cmid);

    if (overlay) {
        return;
    }

    editorOrigin = getOrigin(editorUrl);
    openAttemptCount = 0;
    session = {
        cmid,
        editorUrl,
        packageUrl: packageUrl || '',
        skipOpenFileOnInit: !!packageUrl,
        saveUrl,
        sesskey,
    };

    overlay = document.createElement('div');
    overlay.id = 'exeweb-editor-overlay';
    overlay.className = 'exeweb-editor-overlay';

    const header = document.createElement('div');
    header.className = 'exeweb-editor-header';

    const title = document.createElement('span');
    title.className = 'exeweb-editor-title';
    title.textContent = activityName || '';
    header.appendChild(title);

    const buttonGroup = document.createElement('div');
    buttonGroup.className = 'exeweb-editor-buttons';

    saveBtn = document.createElement('button');
    saveBtn.className = 'btn btn-primary mr-2';
    saveBtn.id = 'exeweb-editor-save';
    saveBtn.disabled = true;
    await setSaveLabel('savetomoodle', 'Save to Moodle');
    saveBtn.addEventListener('click', requestExport);

    const closeBtn = document.createElement('button');
    closeBtn.className = 'btn btn-secondary';
    closeBtn.id = 'exeweb-editor-close';
    try {
        closeBtn.textContent = await getString('closebuttontitle', 'core');
    } catch {
        closeBtn.textContent = 'Close';
    }
    closeBtn.addEventListener('click', () => close(false));

    buttonGroup.appendChild(saveBtn);
    buttonGroup.appendChild(closeBtn);
    header.appendChild(buttonGroup);
    overlay.appendChild(header);

    iframe = document.createElement('iframe');
    iframe.className = 'exeweb-editor-iframe';
    iframe.src = editorUrl;
    iframe.setAttribute('allow', 'fullscreen');
    iframe.setAttribute('frameborder', '0');
    iframe.addEventListener('load', () => {
        if (!openRequestSent && session?.packageUrl) {
            openInitialPackage();
        }
    });
    overlay.appendChild(iframe);

    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';

    window.addEventListener('message', handleMessage);
    document.addEventListener('keydown', handleKeydown);
};

export const init = () => {
    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-action="mod_exeweb/editor-open"]');
        if (!button) {
            return;
        }

        event.preventDefault();
        open(
            button.dataset.cmid,
            button.dataset.editorurl,
            button.dataset.activityname,
            button.dataset.packageurl,
            button.dataset.saveurl,
            button.dataset.sesskey
        );
    });
};
