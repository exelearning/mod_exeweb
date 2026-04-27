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
$string['exeweb:template_desc'] = 'Package (.zip or .elpx) uploaded here will be used as default package for new activities. It will be shown until replaced by the one sent by eXeLearning. Do NOT unzip the package.';
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
$string['exeorigin_help'] = 'This setting determines how the package is included in the course. Options may include:

* Uploaded package - Enables a zipped eXeLearning website to be chosen via the file picker.
* Create with eXeLearning (embedded editor) - Creates the activity using the embedded editor. You can then edit it directly from the activity view page.
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
$string['embeddededitorsettings'] = 'Editor type';
$string['editormode'] = 'Editor mode';
$string['editormodedesc'] = 'Select which editor to use for creating and editing eXeLearning content. Online connection settings only apply when "eXeLearning Online" mode is selected.';
$string['editormodeonline'] = 'eXeLearning Online (remote server)';
$string['editormodeembedded'] = 'Integrated editor (embedded)';
$string['embeddednotinstalledcontactadmin'] = 'The embedded editor files are not installed. Please contact your site administrator to install it.';
$string['embeddednotinstalledadmin'] = 'The embedded editor files are not installed. You can install it from the plugin settings.';
$string['editembedded'] = 'Edit with eXeLearning';
$string['editembedded_integrated'] = 'Integrated';
$string['editembedded_help'] = 'Open the embedded eXeLearning editor to edit the content directly within Moodle.';
$string['editormissing'] = 'The eXeLearning embedded editor is not installed. Please contact your administrator.';
$string['editorreaderror'] = 'Could not read the eXeLearning embedded editor files. Please check file permissions and contact your administrator.';
$string['embeddedtypehelp'] = 'The activity will be created and you can then edit it using the embedded eXeLearning editor from the activity view page.';
$string['saving'] = 'Saving...';
$string['savedsuccess'] = 'Changes saved successfully';
$string['savetomoodle'] = 'Save to Moodle';
$string['savingwait'] = 'Please wait while the file is being saved.';
$string['unsavedchanges'] = 'You have unsaved changes. Are you sure you want to close?';
$string['typeembedded'] = 'Create with eXeLearning (embedded editor)';
$string['typeexewebcreate'] = 'Create with eXeLearning';
$string['typeexewebedit'] = 'Edit with eXeLearning';
$string['typelocal'] = 'Uploaded package';

$string['teachermodevisible'] = 'Show teacher layer selector';
$string['teachermodevisible_help'] = 'If disabled, the teacher layer selector inside the embedded resource is hidden.';

// Embedded editor management.
$string['manageembeddededitor'] = 'Manage embedded editor';
$string['manageembeddededitor_desc'] = 'Install, update, or repair the embedded eXeLearning editor.';
$string['embeddededitorstatus'] = 'Embedded editor';
$string['editorsource_moodledata'] = 'Installed (admin-managed)';
$string['editorsource_bundled'] = 'Bundled with plugin';
$string['editorsource_none'] = 'Not installed';
$string['editorinstall'] = 'Install latest version';
$string['editorupdate'] = 'Update editor';
$string['editoruninstall'] = 'Remove';
$string['editorinstallsuccess'] = 'eXeLearning editor v{$a} installed successfully.';
$string['editoruninstallsuccess'] = 'Embedded editor installation removed.';
$string['editorversion'] = 'Version';
$string['editorinstalledat'] = 'Installed at';
$string['editorsource'] = 'Source';
$string['editoractivesource'] = 'Active source';
$string['editormoodledatadir'] = 'Data directory';
$string['editorbundleddir'] = 'Bundled directory';
$string['editorlatestversion'] = 'Latest available version';
$string['editorlatestversionongithub'] = 'Latest version on GitHub:';
$string['editorstatusinfo'] = 'The embedded editor serves static assets for the integrated eXeLearning editor. Sources are checked in order: admin-installed (moodledata), then bundled (plugin dist/).';
$string['editorgithubconnecterror'] = 'Could not connect to GitHub: {$a}';
$string['editorgithubapierror'] = 'GitHub returned HTTP status {$a}. Please try again later.';
$string['editorgithubparseerror'] = 'Could not parse the latest release information from GitHub.';
$string['editordownloaderror'] = 'Failed to download the editor package: {$a}';
$string['editordownloademptyfile'] = 'The downloaded file is empty.';
$string['editorinvalidzip'] = 'The downloaded file is not a valid ZIP archive.';
$string['editorzipextensionmissing'] = 'The PHP ZipArchive extension is not available. Please ask your server administrator to enable it.';
$string['editorextractfailed'] = 'Failed to extract the editor package: {$a}';
$string['editorextractwriteerror'] = 'Could not write extracted files to the temporary directory.';
$string['editorinvalidlayout'] = 'The package does not contain the expected editor files (index.html and asset directories).';
$string['editorinstallfailed'] = 'Failed to install the editor: {$a}';
$string['editormkdirerror'] = 'Could not create directory: {$a}';
$string['editorbackuperror'] = 'Could not back up the existing editor installation.';
$string['editorcopyfailed'] = 'Could not copy editor files to the target directory.';
$string['editorinstallconcurrent'] = 'An installation is already in progress. Please wait a few minutes and try again.';
$string['editorconfirmuninstall'] = 'Are you sure you want to remove the admin-installed editor? The bundled or remote version will be used instead.';
$string['editorupdateavailable'] = 'Update available: v{$a}';
$string['editorcurrentversion'] = 'Current version: v{$a}';
$string['editornotyetinstalled'] = 'No admin-installed editor found.';
$string['editormoodledatasource'] = 'Admin-installed (moodledata)';
$string['editorbundledsource'] = 'Bundled with plugin';
$string['editoravailable'] = 'Available';
$string['editornotavailable'] = 'Not available';
$string['editormanagelink'] = 'Manage embedded editor';
$string['editorsourceprecedence'] = 'Source precedence: admin-installed > bundled.';
$string['exeweb:manageembeddededitor'] = 'Manage the embedded eXeLearning editor installation';
$string['editorcheckingerror'] = 'Could not check for updates. GitHub may be temporarily unreachable.';
$string['editorinstallconfirm'] = 'This will download and install the latest eXeLearning editor (v{$a}) from GitHub. Continue?';
$string['editoradminrequired'] = 'The embedded eXeLearning editor is not installed. Please contact your site administrator.';
$string['editormanagementhelp'] = 'Download and install the latest eXeLearning editor from GitHub. The version installed by the administrator takes priority over the bundled one.';
$string['editorbundleddesc'] = 'A version is included with the plugin. You can install the latest version published on GitHub.';
$string['editornotinstalleddesc'] = 'Install the editor from GitHub to enable the embedded editing mode.';
$string['invalidaction'] = 'Invalid action: {$a}';
$string['installing'] = 'Installing...';
$string['checkingforupdates'] = 'Checking for updates...';
$string['operationtakinglong'] = 'Operation is taking longer than expected. Checking status...';
$string['checkingstatus'] = 'Checking status...';
$string['stillworking'] = 'Still working...';
$string['editorinstalling'] = 'Installing...';
$string['editordownloadingmessage'] = 'Downloading and installing the editor. This may take a minute...';
$string['editoruninstalling'] = 'Removing...';
$string['editoruninstallingmessage'] = 'Removing the editor installation...';
$string['operationtimedout'] = 'Operation timed out. Please check the editor status and try again.';
$string['latestversionchecking'] = 'Checking...';
$string['latestversionerror'] = 'Could not check for updates';
$string['updateavailable'] = 'Update available';
$string['installstale'] = 'Installation may have failed. Please try again.';
$string['noeditorinstalled'] = 'No editor installed';
$string['confirmuninstall'] = 'Are you sure you want to uninstall the embedded editor? This will remove the admin-installed copy from moodledata.';
$string['confirmuninstalltitle'] = 'Confirm uninstall';
$string['editorinstalledsuccess'] = 'Editor installed successfully';
$string['editoruninstalledsuccess'] = 'Editor uninstalled successfully';
$string['editorupdatedsuccess'] = 'Editor updated successfully';
$string['editorrepairsuccess'] = 'Editor repaired successfully';

$string['editoruploadmissingfile'] = 'No editor ZIP file was uploaded.';
$string['editoruploadfailed'] = 'Failed to upload the editor package: {$a}';

// Style management.
$string['stylesmanager'] = 'Styles';
$string['stylesmanager_hint'] = 'Upload eXeLearning style packages and control which styles the embedded editor exposes.';
$string['stylesmanager_intro'] = 'Manage the eXeLearning styles available to the embedded editor. Built-in styles can be hidden individually. Uploaded styles can be enabled, disabled, or deleted at any time.';
$string['stylesmanager_manage'] = 'Manage installed styles';
$string['stylesmanager_manage_hint'] = 'Open the styles page to enable/disable built-in styles or delete uploaded ones.';
$string['stylesonlywhenembedded'] = 'The embedded editor is not enabled. Styles managed here only take effect when the editor mode is set to "embedded".';
$string['stylesblockimport'] = 'Block user-imported styles';
$string['stylesblockimport_desc'] = 'When enabled, the embedded editor hides the "User styles" tab and refuses to install a style bundled inside an imported .elpx project. Users may only choose from the admin-approved list above. This mirrors the eXeLearning ONLINE_THEMES_INSTALL=false behavior.';
$string['stylesupload_label'] = 'Style ZIP package';
$string['stylesupload_submit'] = 'Upload style';
$string['stylesupload_hint'] = 'Maximum file size: {$a}. Only .zip packages containing a valid config.xml are accepted.';
$string['stylesupload_success'] = 'Style "{$a}" installed.';
$string['stylesupload_success_many'] = 'Installed: {$a}';
$string['stylesupload_goto_settings'] = 'Upload styles from the plugin settings page';
$string['stylesupload_failed'] = 'Style upload failed.';
$string['stylesupload_missing'] = 'The uploaded file is missing or unreadable.';
$string['stylesupload_empty'] = 'The uploaded file is empty.';
$string['stylesupload_toolarge'] = 'The uploaded style exceeds the maximum allowed size of {$a}.';
$string['stylesupload_nozip'] = 'The ZipArchive PHP extension is not available.';
$string['stylesupload_badzip'] = 'The uploaded file is not a readable ZIP archive.';
$string['stylesupload_badentry'] = 'The ZIP archive contains unreadable entries.';
$string['stylesupload_unsafe'] = 'Rejected unsafe archive entry: {$a}';
$string['stylesupload_multiconfig'] = 'The archive contains more than one config.xml.';
$string['stylesupload_noconfig'] = 'The style package is missing config.xml.';
$string['stylesupload_mixedroots'] = 'The archive must contain a single root folder or place all files at the root.';
$string['stylesupload_badext'] = 'File type not allowed in style package: {$a}';
$string['stylesupload_configread'] = 'config.xml could not be read from the archive.';
$string['stylesupload_badxml'] = 'config.xml is not valid XML.';
$string['stylesupload_noname'] = 'config.xml must declare a <name> element.';
$string['stylesupload_traversal'] = 'Refused path traversal during extraction.';
$string['stylesupload_readfailed'] = 'Failed to read a file from the archive during extraction.';
$string['stylesupload_writefailed'] = 'Failed to write an extracted file.';
$string['stylesnocss'] = 'The uploaded style does not contain any stylesheet.';
$string['stylesinstallfailed'] = 'Style installation failed: {$a}';
$string['stylesuploaded'] = 'Uploaded styles';
$string['stylesuploaded_empty'] = 'No uploaded styles yet.';
$string['stylesuploaded_hint'] = 'Enable or disable uploaded styles. Uncheck to hide a style from the editor; delete to remove it permanently.';
$string['stylesbuiltin'] = 'Built-in styles';
$string['stylesbuiltin_empty'] = 'Built-in styles are not available because the embedded editor is not installed.';
$string['stylesbuiltin_hint'] = 'Uncheck a style to hide it from the editor. Disabled built-ins are not deleted; the project can always fall back to the default style.';
$string['stylestable_title'] = 'Title';
$string['stylestable_id'] = 'Id';
$string['stylestable_version'] = 'Version';
$string['stylestable_installed'] = 'Installed';
$string['stylestable_enabled'] = 'Enabled';
$string['stylestable_actions'] = 'Actions';
$string['stylesenable'] = 'Enable';
$string['stylesdisable'] = 'Disable';
$string['stylesdelete'] = 'Delete';
$string['stylesdelete_confirm'] = 'Delete this style? This cannot be undone.';
$string['stylesdelete_success'] = 'Style deleted.';
