<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Strings for component 'exeweb', language 'en', version '4.1'.
 *
 * @package     mod_exeweb
 * @category    string
 * @copyright   1999 Martin Dougiamas and contributors
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['areapackage'] = 'Package file';
$string['badexelearningpackage'] = 'The package does not comply with the package rules defined for the site.';
$string['clicktodownload'] = 'Click {$a} link to download the file.';
$string['clicktoopen2'] = 'Click {$a} link to view the file.';
$string['configdisplayoptions'] = 'Select all options that should be available, existing settings are not modified. Hold CTRL key to select multiple fields.';
$string['configframesize'] = 'When a web page or an uploaded file is displayed within a frame, this value is the height (in pixels) of the top frame (which contains the navigation).';
$string['configparametersettings'] = 'This sets the default value for the Parameter settings pane in the form when adding some new contents. After the first time, this becomes an individual user preference.';
$string['configpopup'] = 'When adding a new content that can be shown in a popup window, should this option be enabled by default?';
$string['configpopupdirectories'] = 'Should popup windows show directory links by default?';
$string['configpopupheight'] = 'Which should be the default height for new popup windows?';
$string['configpopuplocation'] = 'Should popup windows show the location bar by default?';
$string['configpopupmenubar'] = 'Should popup windows show the menu bar by default?';
$string['configpopupresizable'] = 'Should popup windows be resizable by default?';
$string['configpopupscrollbars'] = 'Should popup windows be scrollable by default?';
$string['configpopupstatus'] = 'Should popup windows show the status bar by default?';
$string['configpopuptoolbar'] = 'Should popup windows show the tool bar by default?';
$string['configpopupwidth'] = 'Which should be the default width for new popup windows?';
$string['contentheader'] = 'Content';
$string['defaultdisplaysettings'] = 'Default display settings';
$string['displayoptions'] = 'Available display options';
$string['displayselect'] = 'Display';
$string['displayselect_help'] = 'This setting determines how the content is displayed. Options may include:

* Embed - The file is displayed in an IFRAME, below the navigation bar, together with the file description and any blocks.
* In frame - The file is displayed using a FRAMESET with two FRAMES, below the navigation bar and the file description.
* New window - The content is open on a new browser window.
* Open - The content is open on the same browser window.
* In pop-up - The file is displayed in a new browser window without menus or address bar (popup window).';
$string['displayselect_link'] = 'mod/exeweb/mod';
$string['displayselectexplain'] = 'Choose display type. Not all types are suitable for all files.';
$string['dnduploadexeweb'] = 'Create a website';
$string['exeonline:connectionsettings'] = 'eXeLearning server connection settings';
$string['exeonline:baseuri'] = 'Remote URI';
$string['exeonline:baseuri_desc'] = 'eXeLearning URL';
$string['exeonline:hmackey1'] = 'Signing key';
$string['exeonline:hmackey1_desc'] = 'Key used to sign data sent to the eXeLearning server, so we can be sure it was originated in this server. Use up to 32 characters.';
$string['exeonline:provider_name'] = 'Provider name';
$string['exeonline:provider_name_desc'] = 'Name of the eXeLearning provider. This is used to identify the provider in the eXeLearning interface.';
$string['exeonline:provider_version'] = 'Provider version';
$string['exeonline:provider_version_desc'] = 'Version of the eXeLearning provider. This is used to identify the provider in the eXeLearning interface.';
$string['exeonline:tokenexpiration'] = 'Token expiration';
$string['exeonline:tokenexpiration_desc'] = 'Max time (in seconds) to edit a package in eXeLearning and get back to Moodle.';
$string['exeweb:forbiddenfileslist'] = 'Forbidden files RE list';
$string['exeweb:forbiddenfileslist_desc'] = 'A forbidden files list can be configured here. Enter each forbidden file as a PHP regular expresion (RE) on a new line. For example:';
$string['exeweb:mandatoryfileslist'] = 'Mandatory files RE list';
$string['exeweb:mandatoryfileslist_desc'] = 'A mandatory files list can be configured here. Enter each mandatory file as a PHP regular expresion (RE) on a new line.';
$string['exeweb:onlinetypehelp'] = 'When you click on either save buttons at the bottom of this page, it\'ll take you to eXeLearning to create or edit there the package. When done, eXeLearning will send the newly created/edited package back to Moodle.';
$string['exeweb:sendtemplate'] = 'Send template';
$string['exeweb:sendtemplate_desc'] = 'Sends default template to eXeLearning when creating a new activity.';
$string['exeweb:template'] = 'New package template.';
$string['exeweb:template_desc'] = 'Package ulpoaded here will be used as default package for new activities. It will be shown until replaced by the one sent by eXeLearning. Do NOT unzip the package.';
$string['exeweb:editonlineanddisplay'] = 'Edit on eXeLearning and display';
$string['exeweb:editonlineandreturntocourse'] = 'Edit on eXeLearning and return to course';
$string['filenotfound'] = 'File not found, sorry.';
$string['filterfiles'] = 'Use filters on file content';
$string['filterfilesexplain'] = 'Select type of file content filtering, please note this may cause problems in some contents. Please make sure that all text files are in UTF-8 encoding.';
$string['filtername'] = 'Content names auto-linking';
$string['forcedownload'] = 'Force download';
$string['framesize'] = 'Frame height';
$string['indicator:cognitivedepth'] = 'File cognitive';
$string['indicator:cognitivedepth_help'] = 'This indicator is based on the cognitive depth reached by the student.';
$string['indicator:cognitivedepthdef'] = 'File cognitive';
$string['indicator:cognitivedepthdef_help'] = 'The participant has reached this percentage of the cognitive engagement offered by the content during this analysis interval (Levels = No view, View)';
$string['indicator:cognitivedepthdef_link'] = 'Learning_analytics_indicators#Cognitive_depth';
$string['indicator:socialbreadth'] = 'File social';
$string['indicator:socialbreadth_help'] = 'This indicator is based on the social breadth reached by the student.';
$string['indicator:socialbreadthdef'] = 'File social';
$string['indicator:socialbreadthdef_help'] = 'The participant has reached this percentage of the social engagement offered by the content during this analysis interval (Levels = No participation, Participant alone)';
$string['indicator:socialbreadthdef_link'] = 'Learning_analytics_indicators#Social_breadth';
$string['invalidpackage'] = 'Invalid package';
$string['modifieddate'] = 'Modified {$a}';
$string['modulename'] = 'eXeLearning (website)';
$string['modulename_help'] = 'The eXeLearning website module enables a teacher to provide an eXeLearning zipped website as a course resource. The package can be uploaded or edited
directly in eXeLearnig.';
$string['modulename_link'] = 'mod/exeweb/view';
$string['modulenameplural'] = 'eXeLearnigs (websites)';
$string['optionsheader'] = 'Display options';
$string['player:toogleFullscreen'] = 'Toggle fullscreen';
$string['package'] = 'Package file';
$string['package_help'] = 'The package file is a zip file containing a website created with eXeLearning.';
$string['packagehdr'] = 'Package';
$string['page-mod-exeweb-x'] = 'Any file module page';
$string['pluginadministration'] = 'Module administration';
$string['pluginname'] = 'eXeLearning (website)';
$string['popupheight'] = 'Pop-up height (in pixels)';
$string['popupheightexplain'] = 'Specifies default height of popup windows.';
$string['popupexeweb'] = 'This content should appear in a popup window.';
$string['popupexeweblink'] = 'If it didn\'t, click here: {$a}';
$string['popupwidth'] = 'Pop-up width (in pixels)';
$string['popupwidthexplain'] = 'Specifies default width of popup windows.';
$string['printintro'] = 'Display content description';
$string['printintroexplain'] = 'Display description below content? Some display types may not show the description even if enabled.';
$string['privacy:metadata'] = 'The eXeLearning (website) plugin does not store any personal data.';
$string['exeweb:addinstance'] = 'Add a new website';
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
$string['exeorigin_help'] = 'This setting determines how the package is included in the course. There are two options:

* Uploaded package - Enables a zipped eXeLearning website to be chosen via the file picker.
* Create/Edit with eXeLearning - Creates the activity and takes you to eXeLearning to edit the package. When done, eXeLearning will send the newly created package back to Moodle.';
$string['exeweb:exportexeweb'] = 'Export';
$string['exeweb:view'] = 'View';
$string['search:activity'] = 'File';
$string['selectmainfile'] = 'Please select the main file by clicking the icon next to the file name.';
$string['showdate'] = 'Show upload/modified date';
$string['showdate_desc'] = 'Display upload/modified date on course page?';
$string['showdate_help'] = 'Displays the upload/modified date beside the links to the file.';
$string['showsize'] = 'Show size';
$string['showsize_help'] = 'Displays the file size, such as \'3.1 MB\', beside the links to the file.';
$string['showsize_desc'] = 'Display file size on course page?';
$string['showtype'] = 'Show type';
$string['showtype_desc'] = 'Display file type (e.g. \'Word document\') on the course page?';
$string['showtype_help'] = 'Displays the type of the file, such as \'Word document\', beside the links to the file.

If there are multiple files in this content, the start file type is displayed.

If the file type is not known, it will not be displayed.';
$string['uploadeddate'] = 'Uploaded {$a}';
$string['typeexewebcreate'] = 'Create with eXeLearning';
$string['typeexewebedit'] = 'Edit with eXeLearning';
$string['typelocal'] = 'Uploaded package';
