<?php
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
 * Exeweb module admin settings and defaults
 *
 * @package    mod_exeweb
 * @copyright  2009 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once("$CFG->libdir/resourcelib.php");

    $displayoptions = resourcelib_get_displayoptions([ RESOURCELIB_DISPLAY_AUTO,
                                                        RESOURCELIB_DISPLAY_EMBED,
                                                        RESOURCELIB_DISPLAY_FRAME,
                                                        RESOURCELIB_DISPLAY_DOWNLOAD,
                                                        RESOURCELIB_DISPLAY_OPEN,
                                                        RESOURCELIB_DISPLAY_NEW,
                                                        RESOURCELIB_DISPLAY_POPUP,
                                                     ]);
    $defaultdisplayoptions = [
        RESOURCELIB_DISPLAY_AUTO,
        RESOURCELIB_DISPLAY_EMBED,
        RESOURCELIB_DISPLAY_DOWNLOAD,
        RESOURCELIB_DISPLAY_OPEN,
        RESOURCELIB_DISPLAY_POPUP,
    ];

    // General settings.
    $settings->add(new admin_setting_configtext('exeweb/framesize',
        get_string('framesize', 'exeweb'), get_string('configframesize', 'exeweb'), 130, PARAM_INT));
    $settings->add(new admin_setting_configmultiselect('exeweb/displayoptions',
        get_string('displayoptions', 'exeweb'), get_string('configdisplayoptions', 'exeweb'),
        $defaultdisplayoptions, $displayoptions));

    // Modedit defaults.
    $settings->add(new admin_setting_heading('exewebmodeditdefaults', get_string('modeditdefaults', 'admin'),
                get_string('condifmodeditdefaults', 'admin')));

    $settings->add(new admin_setting_configcheckbox('exeweb/printintro',
        get_string('printintro', 'exeweb'), get_string('printintroexplain', 'exeweb'), 1));
    $settings->add(new admin_setting_configselect('exeweb/display',
        get_string('displayselect', 'exeweb'), get_string('displayselectexplain', 'exeweb'), RESOURCELIB_DISPLAY_AUTO,
        $displayoptions));
    $settings->add(new admin_setting_configcheckbox('exeweb/showsize',
        get_string('showsize', 'exeweb'), get_string('showsize_desc', 'exeweb'), 0));
    $settings->add(new admin_setting_configcheckbox('exeweb/showtype',
        get_string('showtype', 'exeweb'), get_string('showtype_desc', 'exeweb'), 0));
    $settings->add(new admin_setting_configcheckbox('exeweb/showdate',
        get_string('showdate', 'exeweb'), get_string('showdate_desc', 'exeweb'), 0));
    $settings->add(new admin_setting_configtext('exeweb/popupwidth',
        get_string('popupwidth', 'exeweb'), get_string('popupwidthexplain', 'exeweb'), 620, PARAM_INT, 7));
    $settings->add(new admin_setting_configtext('exeweb/popupheight',
        get_string('popupheight', 'exeweb'), get_string('popupheightexplain', 'exeweb'), 450, PARAM_INT, 7));
    $options = ['0' => get_string('none'), '1' => get_string('allfiles'), '2' => get_string('htmlfilesonly'), ];
    $settings->add(new admin_setting_configselect('exeweb/filterfiles',
        get_string('filterfiles', 'exeweb'), get_string('filterfilesexplain', 'exeweb'), 0, $options));
}
