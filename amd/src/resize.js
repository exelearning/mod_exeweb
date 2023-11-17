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
 * Javascript helper function for mod_exeweb module.
 *
 * @module      mod_exeweb/resize
 * @copyright   2023 3&Punt
 * @author      Juan Carrera <juan@treipunt.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* eslint-disable no-console */

import Log from 'core/log';

/**
 * Resizes iFrame and container height to iframes body size.
 * This function is to be declared on window namespace so iframe onload event can find it.
 * Used as mutation observer callback.
 *
 */
export const exewebResize = function() {
    let iFrame = document.querySelector('#exewebobject');
    if (iFrame.contentWindow.document.body) {
        iFrame.style.width = '100%';
        iFrame.style.height = (iFrame.contentWindow.document.body.scrollHeight + 50) + 'px';
        Log.debug('iFrame height: ' + (iFrame.contentWindow.document.body.scrollHeight + 50) + 'px');
    }
};

/**
 * IFrame's onload handler. Used to keep iFrame's height dynamic, varying on iFrame's contents.
 *
 * @param {element} iFrame
 */
export const exewebIframeOnload = function(iFrame) {
    Log.debug('Function exewebIframeOnload.');
    exewebResize();
    // Set a mutation observer, so we can adapt to changes from iFrame's javascript (such
    // as tab clicks o hide/show sections).
    const config = {attributes: true, childList: true, subtree: true};
    const observer = new MutationObserver(exewebResize);
    observer.observe(iFrame.contentWindow.document.body, config);
};

export const init = () => {
    // Declare on window namespace so iframe onload event can find it.
    window.exewebResize = exewebResize;
    window.exewebIframeOnload = exewebIframeOnload;
    let page = document.getElementById('exewebpage');
    let iframe = document.getElementById('exewebobject');
    console.log(iframe);

    if (iframe.contentWindow.document.readyState === 'complete') {
        Log.debug('Iframe already loaded.');
        exewebIframeOnload(iframe);
        iframe.contentWindow.addEventListener('load', exewebIframeOnload.bind(this));
    } else {
        Log.debug('Adding iframe onload listener');
        const iFrameInterval = setInterval(() => {
            console.log('waiting for iframe');
            if (iframe.contentWindow.document.readyState === 'complete') {
                Log.debug('Adding iframe onload listener');
                exewebIframeOnload(iframe);
                window.clearInterval(iFrameInterval);
            }
        }, 500);
    }

    // Watch for page hanges.
    const pageObserver = new ResizeObserver(exewebResize);
    pageObserver.observe(page);
};
