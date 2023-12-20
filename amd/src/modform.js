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
import {get_string as getString} from 'core/str';
import Prefetch from 'core/prefetch';

const SELECTORS = {
    ORIGIN: '#id_exeorigin',
    SUBMITBUTTON: '#id_submitbutton',
    SUBMITBUTTON2: '#id_submitbutton2'
};


const initialize = () => {
    Prefetch.prefetchStrings('mod_exeweb', ['exeweb:editonlineanddisplay', 'exeweb:editonlineandreturntocourse']);
    Prefetch.prefetchStrings('core', ['savechangesanddisplay', 'savechangesandreturntocourse']);


    // Add listener to the click event that will load the form.
    document.querySelector(SELECTORS.ORIGIN).addEventListener('change', (e) => {
        const buttonDisplay = document.querySelector(SELECTORS.SUBMITBUTTON);
        const buttonCourse = document.querySelector(SELECTORS.SUBMITBUTTON2);
        Log.debug(buttonCourse);
        if (e.target.value == 'exeonline') {
            getString('exeweb:editonlineanddisplay', 'mod_exeweb')
                .then((label) => {
                    buttonDisplay.value = label;
                    return;
                })
                .catch();
            getString('exeweb:editonlineandreturntocourse', 'mod_exeweb')
                .then((label) => {
                    Log.debug('Label buttton course: ', label);
                    buttonCourse.value = label;
                    return;
                })
                .catch();

        } else {
            getString('savechangesanddisplay', 'core')
                .then((label) => {
                    buttonDisplay.value = label;
                    return;
                })
                .catch();

            getString('savechangesandreturntocourse', 'core')
                .then((label) => {
                    buttonCourse.value = label;
                    return;
                })
                .catch();

        }
    });
};


export const init = () => {
    Log.debug('we have been started!');
    initialize();
};
