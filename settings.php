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

// Register the styles management admin page so it is reachable from
// `/admin/settings.php` and from a dedicated link below.
if ($hassiteconfig) {
    $ADMIN->add(
        'modsettings',
        new admin_externalpage(
            'mod_exeweb_styles',
            get_string('stylesmanager', 'mod_exeweb'),
            new moodle_url('/mod/exeweb/admin/styles.php'),
            ['moodle/site:config', 'mod/exeweb:manageembeddededitor']
        )
    );
}

if ($ADMIN->fulltree) {
    require_once("$CFG->libdir/resourcelib.php");

    // Editor mode setting.
    $settings->add(new admin_setting_heading('exeweb/embeddededitorsettings',
        get_string('embeddededitorsettings', 'mod_exeweb'), ''));

    $editormodedesc = get_string('editormodedesc', 'mod_exeweb');
    $editormodes = [
        'online' => get_string('editormodeonline', 'mod_exeweb'),
        'embedded' => get_string('editormodeembedded', 'mod_exeweb'),
    ];
    $settings->add(new admin_setting_configselect('exeweb/editormode',
        get_string('editormode', 'mod_exeweb'), $editormodedesc,
        'online', $editormodes));

    $settings->add(new \mod_exeweb\admin\admin_setting_embeddededitor(
        get_string('embeddededitorstatus', 'mod_exeweb'),
        ''
    ));

    // Inline style ZIP upload (native filemanager). Each dropped .zip is
    // validated + extracted + registered on save; the file is then
    // removed from the filearea so the next render starts clean.
    $settings->add(new \mod_exeweb\admin\admin_setting_stylesupload(
        'exeweb/styles_drops',
        get_string('stylesupload_label', 'mod_exeweb'),
        get_string('stylesupload_hint', 'mod_exeweb',
            display_size(\mod_exeweb\local\styles_service::get_max_zip_size())),
        'styles_drops',
        0,
        [
            'accepted_types' => ['.zip'],
            'maxbytes' => \mod_exeweb\local\styles_service::get_max_zip_size(),
            'maxfiles' => -1,
            'subdirs' => 0,
        ]
    ));

    // Uploaded styles list (checkbox per style + per-row delete link).
    $settings->add(new \mod_exeweb\admin\admin_setting_stylesuploaded(
        'exeweb/styles_uploaded'
    ));

    // Built-in styles list (checkbox per style).
    $settings->add(new \mod_exeweb\admin\admin_setting_stylesbuiltins(
        'exeweb/styles_builtins'
    ));

    $settings->add(new admin_setting_configcheckbox(
        'exeweb/stylesblockimport',
        get_string('stylesblockimport', 'mod_exeweb'),
        get_string('stylesblockimport_desc', 'mod_exeweb'),
        0
    ));

    // Connection settings (only relevant for online mode).
    // Inline JS to hide/show connection settings based on editor mode selection.
    $connectionsettingsdesc = '<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modeSelect = document.getElementById("id_s_exeweb_editormode");
        if (!modeSelect) return;
        var connectionIds = [
            "admin-connectionsettings", "admin-exeonlinebaseuri", "admin-providername",
            "admin-providerversion", "admin-hmackey1", "admin-tokenexpiration"
        ];
        function toggleConnectionSettings() {
            var mode = modeSelect.value;
            connectionIds.forEach(function(id) {
                var el = document.getElementById(id);
                if (el) el.style.display = (mode === "online") ? "" : "none";
            });
            var embeddedWidget = document.querySelector(".mod_exeweb-admin-embedded-editor-setting");
            if (embeddedWidget) embeddedWidget.style.display = (mode === "embedded") ? "" : "none";
            ["admin-styles_drops", "admin-styles_uploaded", "admin-styles_builtins",
                "admin-stylesblockimport"].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) el.style.display = (mode === "embedded") ? "" : "none";
            });
        }
        modeSelect.addEventListener("change", toggleConnectionSettings);
        toggleConnectionSettings();
    });
    </script>';
    $settings->add(new admin_setting_heading('exeweb/connectionsettings',
        get_string('exeonline:connectionsettings', 'mod_exeweb'), $connectionsettingsdesc));

    $settings->add(new admin_setting_configtext('exeweb/exeonlinebaseuri',
        get_string('exeonline:baseuri', 'mod_exeweb'),
        get_string('exeonline:baseuri_desc', 'mod_exeweb'), '', PARAM_RAW_TRIMMED));

    $settings->add(new admin_setting_configtext('exeweb/providername',
        get_string('exeonline:provider_name', 'mod_exeweb'),
        get_string('exeonline:provider_name_desc', 'mod_exeweb'), 'Moodle'));

    $moodleversion = substr($CFG->release, 0, 3);
    $settings->add(new admin_setting_configtext('exeweb/providerversion',
        get_string('exeonline:provider_version', 'mod_exeweb'),
        get_string('exeonline:provider_version_desc', 'mod_exeweb')
            . "<br><code>Current Moodle Version: "
            . $CFG->release . "</code>", $moodleversion));

    $settings->add(new admin_setting_configpasswordunmask('exeweb/hmackey1',
        get_string('exeonline:hmackey1', 'mod_exeweb'),
        get_string('exeonline:hmackey1_desc', 'mod_exeweb'), ''));

    $settings->add(new admin_setting_configduration('exeweb/tokenexpiration',
        get_string('exeonline:tokenexpiration', 'mod_exeweb'),
        get_string('exeonline:tokenexpiration_desc', 'mod_exeweb'), 86400, 1));

    // Exeweb default template.
    $filemanageroptions = [
        'accepted_types' => ['.zip', '.elpx'],
        'maxbytes' => 0,
        'maxfiles' => 1,
        'subdirs' => 0,
    ];

    $settings->add(new admin_setting_configstoredfile('exeweb/template',
        get_string('exeweb:template', 'mod_exeweb'),
        get_string('exeweb:template_desc', 'mod_exeweb'),
        'config', 0, $filemanageroptions
    ));

    $settings->add(new admin_setting_configcheckbox('exeweb/sendtemplate',
        get_string('exeweb:sendtemplate', 'mod_exeweb'), get_string('exeweb:sendtemplate_desc', 'mod_exeweb'), 0));

    // The eXeweb package validation rules.
    $mandatoryfilesre = implode("\n", [
    '/^content(v\d+)?\.xml$/',
    ]);
    $forbiddenfilesre = implode("\n", [
        '/.*\.php$/',
    ]);
    $settings->add(new admin_setting_configtextarea('exeweb/mandatoryfileslist',
        new lang_string('exeweb:mandatoryfileslist', 'mod_exeweb'),
        new lang_string('exeweb:mandatoryfileslist_desc', 'mod_exeweb'), $mandatoryfilesre, PARAM_RAW, '50', '10'));
    $settings->add(new admin_setting_configtextarea('exeweb/forbiddenfileslist',
        new lang_string('exeweb:forbiddenfileslist', 'mod_exeweb'),
        new lang_string('exeweb:forbiddenfileslist_desc', 'mod_exeweb'), $forbiddenfilesre, PARAM_RAW, '50', '10'));

    // Default display settings.
    $settings->add(new admin_setting_heading('exeweb/displaysettings',
        get_string('defaultdisplaysettings', 'mod_exeweb'), ''));

    $displayoptions = resourcelib_get_displayoptions([
        RESOURCELIB_DISPLAY_EMBED,
        RESOURCELIB_DISPLAY_FRAME,
        RESOURCELIB_DISPLAY_OPEN,
        RESOURCELIB_DISPLAY_NEW,
        RESOURCELIB_DISPLAY_POPUP,
    ]);
    $defaultdisplayoptions = [
        RESOURCELIB_DISPLAY_EMBED,
        RESOURCELIB_DISPLAY_OPEN,
        RESOURCELIB_DISPLAY_POPUP,
    ];

    // General settings.
    $settings->add(new admin_setting_configtext('exeweb/framesize',
        new lang_string('framesize', 'mod_exeweb'), new lang_string('configframesize', 'mod_exeweb'), 130, PARAM_INT));
    $settings->add(new admin_setting_configmultiselect('exeweb/displayoptions',
        new lang_string('displayoptions', 'mod_exeweb'), new lang_string('configdisplayoptions', 'mod_exeweb'),
        $defaultdisplayoptions, $displayoptions));

    // Modedit defaults.
    $settings->add(new admin_setting_heading('exewebmodeditdefaults', new lang_string('modeditdefaults', 'admin'),
                new lang_string('condifmodeditdefaults', 'admin')));

    $settings->add(new admin_setting_configcheckbox('exeweb/printintro',
        new lang_string('printintro', 'mod_exeweb'), new lang_string('printintroexplain', 'mod_exeweb'), 1));
    $settings->add(new admin_setting_configselect('exeweb/display',
        new lang_string('displayselect', 'mod_exeweb'), new lang_string('displayselectexplain', 'mod_exeweb'),
        RESOURCELIB_DISPLAY_EMBED, $displayoptions));
    $settings->add(new admin_setting_configcheckbox('exeweb/showdate',
        new lang_string('showdate', 'mod_exeweb'), new lang_string('showdate_desc', 'mod_exeweb'), 0));
    $settings->add(new admin_setting_configtext('exeweb/popupwidth',
        new lang_string('popupwidth', 'mod_exeweb'), new lang_string('popupwidthexplain', 'mod_exeweb'), 620, PARAM_INT, 7));
    $settings->add(new admin_setting_configtext('exeweb/popupheight',
        new lang_string('popupheight', 'mod_exeweb'), new lang_string('popupheightexplain', 'mod_exeweb'), 450, PARAM_INT, 7));
    $options = ['0' => new lang_string('none'), '1' => new lang_string('allfiles'), '2' => new lang_string('htmlfilesonly') ];
    $settings->add(new admin_setting_configselect('exeweb/filterfiles',
        new lang_string('filterfiles', 'mod_exeweb'), new lang_string('filterfilesexplain', 'mod_exeweb'), 0, $options));
}
