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
 * Strings for component 'exeweb', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package    mod_exeweb
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['areapackage'] = 'Package file';
$string['badexelearningpackage'] = 'The package does not comply with the package rules defined for the site.';
$string['clicktodownload'] = 'Click {$a} link to download the file.';
$string['clicktoopen2'] = 'Click {$a} link to view the file.';
$string['configdisplayoptions'] = 'Select all options that should be available, existing settings are not modified. Hold CTRL key to select multiple fields.';
$string['configframesize'] = 'When a web page or an uploaded file is displayed within a frame, this value is the height (in pixels) of the top frame (which contains the navigation).';
$string['configparametersettings'] = 'This sets the default value for the Parameter settings pane in the form when adding some new exewebs. After the first time, this becomes an individual user preference.';
$string['configpopup'] = 'When adding a new exeweb which is able to be shown in a popup window, should this option be enabled by default?';
$string['configpopupdirectories'] = 'Should popup windows show directory links by default?';
$string['configpopupheight'] = 'What height should be the default height for new popup windows?';
$string['configpopuplocation'] = 'Should popup windows show the location bar by default?';
$string['configpopupmenubar'] = 'Should popup windows show the menu bar by default?';
$string['configpopupresizable'] = 'Should popup windows be resizable by default?';
$string['configpopupscrollbars'] = 'Should popup windows be scrollable by default?';
$string['configpopupstatus'] = 'Should popup windows show the status bar by default?';
$string['configpopuptoolbar'] = 'Should popup windows show the tool bar by default?';
$string['configpopupwidth'] = 'What width should be the default width for new popup windows?';
$string['contentheader'] = 'Content';
$string['defaultdisplaysettings'] = 'Default display settings';
$string['displayoptions'] = 'Available display options';
$string['displayselect'] = 'Display';
$string['displayselect_help'] = 'This setting, together with the file type and whether the browser allows embedding, determines how the file is displayed. Options may include:

* Automatic - The best display option for the file type is selected automatically
* Embed - The file is displayed within the page below the navigation bar together with the file description and any blocks
* Force download - The user is prompted to download the file
* Open - Only the file is displayed in the browser window
* In pop-up - The file is displayed in a new browser window without menus or an address bar
* In frame - The file is displayed within a frame below the navigation bar and file description
* New window - The file is displayed in a new browser window with menus and an address bar';
$string['displayselect_link'] = 'mod/exeweb/mod';
$string['displayselectexplain'] = 'Choose display type, unfortunately not all types are suitable for all files.';
$string['dnduploadexeweb'] = 'Create file exeweb';
$string['exeonline:connectionsettings'] = 'eXeLearning server connection settings';
$string['exeonline:baseuri'] = 'Remote URI';
$string['exeonline:baseuri_desc'] = 'eXeLearning Online URL';
$string['exeonline:hmackey1'] = 'Signing key';
$string['exeonline:hmackey1_desc'] = 'Key used to sign data sent to the eXeLearning server, so we can be sure it was originated in this server. Use up to 32 characters.';
$string['exeonline:tokenexpiration'] = 'Token expiration';
$string['exeonline:tokenexpiration_desc'] = 'Max time (in seconds) to edit a package in eXeLearning and get back to Moodle.';
$string['exeweb:forbiddenfileslist'] = 'Forbidden files RE list';
$string['exeweb:forbiddenfileslist_desc'] = 'A forbidden files list can be cofigured here. Enter each forbidden file as a PHP regular expresion (RE) on a new line. For example:';
$string['exeweb:mandatoryfileslist'] = ' Mandatory files RE list';
$string['exeweb:mandatoryfileslist_desc'] = 'A mandatory files list can be cofigured here. Enter each mandatory file as a PHP regular expresion (RE) a new line.';
$string['exeweb:onlinetypehelp'] = 'When you click on either save buttons at the bottom of this page, it\'ll take you to eXeLearning to create or edit there the package. When done, eXeLearning will send the newly created/edited package back to Moodle.';
$string['exeweb:sendtemplate'] = 'Send template';
$string['exeweb:sendtemplate_desc'] = 'Sends default template to eXeLearning when creating a new activity.';
$string['exeweb:template'] = 'New package template.';
$string['exeweb:template_desc'] = 'Package ulpoaded here will be used as default package for new activities. It will be show until replaced by the one sent by eXeLearning.';
$string['filenotfound'] = 'File not found, sorry.';
$string['filterfiles'] = 'Use filters on file content';
$string['filterfilesexplain'] = 'Select type of file content filtering, please note this may cause problems for some Flash and Java applets. Please make sure that all text files are in UTF-8 encoding.';
$string['filtername'] = 'Exeweb names auto-linking';
$string['forcedownload'] = 'Force download';
$string['framesize'] = 'Frame height';
$string['indicator:cognitivedepth'] = 'File cognitive';
$string['indicator:cognitivedepth_help'] = 'This indicator is based on the cognitive depth reached by the student in a File exeweb.';
$string['indicator:cognitivedepthdef'] = 'File cognitive';
$string['indicator:cognitivedepthdef_help'] = 'The participant has reached this percentage of the cognitive engagement offered by the File exewebs during this analysis interval (Levels = No view, View)';
$string['indicator:cognitivedepthdef_link'] = 'Learning_analytics_indicators#Cognitive_depth';
$string['indicator:socialbreadth'] = 'File social';
$string['indicator:socialbreadth_help'] = 'This indicator is based on the social breadth reached by the student in a File exeweb.';
$string['indicator:socialbreadthdef'] = 'File social';
$string['indicator:socialbreadthdef_help'] = 'The participant has reached this percentage of the social engagement offered by the File exewebs during this analysis interval (Levels = No participation, Participant alone)';
$string['indicator:socialbreadthdef_link'] = 'Learning_analytics_indicators#Social_breadth';
$string['invalidpackage'] = 'Invalid package';
$string['modifieddate'] = 'Modified {$a}';
$string['modulename'] = 'eXeLearning Web';
$string['modulename_help'] = 'The eXeLearning web enables a teacher to provide a eXeLearning web zip as a course resource. The package can be uploaded, but can be created or edited
directly from an eXeLearnig Online server.';
$string['modulename_link'] = 'mod/exeweb/view';
$string['modulenameplural'] = 'eXeLearnigs webs';
$string['optionsheader'] = 'Display options';
$string['package'] = 'Package file';
$string['package_help'] = 'The package file is a file containing a web zip created with eXeLearning.';
$string['packagehdr'] = 'Package';
$string['page-mod-exeweb-x'] = 'Any file module page';
$string['pluginadministration'] = 'Exeweb module administration';
$string['pluginname'] = 'Exeweb';
$string['popupheight'] = 'Pop-up height (in pixels)';
$string['popupheightexplain'] = 'Specifies default height of popup windows.';
$string['popupexeweb'] = 'This exeweb should appear in a popup window.';
$string['popupexeweblink'] = 'If it didn\'t, click here: {$a}';
$string['popupwidth'] = 'Pop-up width (in pixels)';
$string['popupwidthexplain'] = 'Specifies default width of popup windows.';
$string['printintro'] = 'Display exeweb description';
$string['printintroexplain'] = 'Display exeweb description below content? Some display types may not display description even if enabled.';
$string['privacy:metadata'] = 'The File exeweb plugin does not store any personal data.';
$string['exeweb:addinstance'] = 'Add a new exeweb';
$string['exewebcontent'] = 'Files and subfolders';
$string['exewebdetails_'] = 'Avoid mdlcode unknown-string error message';
$string['exewebdetails_size'] = 'Avoid mdlcode unknown-string error message';
$string['exewebdetails_type'] = 'Avoid mdlcode unknown-string error message';
$string['exewebdetails_date'] = 'Avoid mdlcode unknown-string error message';
$string['exewebdetails_sizetype'] = '{$a->size} {$a->type}';
$string['exewebdetails_sizedate'] = '{$a->size} {$a->date}';
$string['exewebdetails_typedate'] = '{$a->type} {$a->date}';
$string['exewebdetails_sizetypedate'] = '{$a->size} {$a->type} {$a->date}';
$string['exeorigin'] = 'Type';
$string['exeorigin_help'] = 'This setting determines how the package is included in the course. There are up to 2 options:

* Uploaded package - Enables an eXeLearning web zip package to be chosen via the file picker
* Create with eXeLearning Online - Creates the activity and takes you to eXeLearning to create the package. When done, eXeLearning will send the newly created package back to Moodle.';
$string['exeweb:exportexeweb'] = 'Export exeweb';
$string['exeweb:view'] = 'View exeweb';
$string['search:activity'] = 'File';
$string['selectmainfile'] = 'Please select the main file by clicking the icon next to file name.';
$string['showdate'] = 'Show upload/modified date';
$string['showdate_desc'] = 'Display upload/modified date on course page?';
$string['showdate_help'] = 'Displays the upload/modified date beside links to the file.

If there are multiple files in this exeweb, the start file upload/modified date is displayed.';
$string['showsize'] = 'Show size';
$string['showsize_help'] = 'Displays the file size, such as \'3.1 MB\', beside links to the file.

If there are multiple files in this exeweb, the total size of all files is displayed.';
$string['showsize_desc'] = 'Display file size on course page?';
$string['showtype'] = 'Show type';
$string['showtype_desc'] = 'Display file type (e.g. \'Word document\') on course page?';
$string['showtype_help'] = 'Displays the type of the file, such as \'Word document\', beside links to the file.

If there are multiple files in this exeweb, the start file type is displayed.

If the file type is not known to the system, it will not display.';
$string['uploadeddate'] = 'Uploaded {$a}';
$string['typeexewebcreate'] = 'Create with eXeLearning';
$string['typeexewebedit'] = 'Edit with eXeLearning';
$string['typelocal'] = 'Uploaded package';
