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
 * @package    mod_exeweb
 * @copyright  2009 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_exeweb\exeweb_package;

/** EXEWEB_ORIGIN_LOCAL = local */
define('EXEWEB_ORIGIN_LOCAL', 'local');
/** EXEWEB_ORIGIN_EXEONLINE = exeonline */
define('EXEWEB_ORIGIN_EXEONLINE', 'exeonline');

/**
 * List of features supported in Exeweb module
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, false if not, null if doesn't know or string for the module purpose.
 */
function exeweb_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_ARCHETYPE:
            return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_GROUPS:
            return false;
        case FEATURE_GROUPINGS:
            return false;
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        case FEATURE_GRADE_OUTCOMES:
            return false;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_MOD_PURPOSE:
            return MOD_PURPOSE_CONTENT;

        default:
            return null;
    }
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * @param $data the data submitted from the reset course.
 * @return array status array
 */
function exeweb_reset_userdata($data) {

    // Any changes to the list of dates that needs to be rolled should be same during course restore and course reset.
    // See MDL-9367.

    return [];
}

/**
 * List the actions that correspond to a view of this module.
 * This is used by the participation report.
 *
 * Note: This is not used by new logging system. Event with
 *       crud = 'r' and edulevel = LEVEL_PARTICIPATING will
 *       be considered as view action.
 *
 * @return array
 */
function exeweb_get_view_actions() {
    return ['view', 'view all'];
}

/**
 * List the actions that correspond to a post of this module.
 * This is used by the participation report.
 *
 * Note: This is not used by new logging system. Event with
 *       crud = ('c' || 'u' || 'd') and edulevel = LEVEL_PARTICIPATING
 *       will be considered as post action.
 *
 * @return array
 */
function exeweb_get_post_actions() {
    return ['update', 'add'];
}

/**
 * Add exeweb instance.
 * @param object $data
 * @param object $mform
 * @return int new exeweb instance id
 */
function exeweb_add_instance($data, $mform) {
    global $CFG, $DB, $USER;
    require_once("$CFG->libdir/resourcelib.php");
    require_once("$CFG->dirroot/mod/exeweb/locallib.php");
    $cmid = $data->coursemodule;
    $data->timecreated = time();
    $data->timemodified = $data->timecreated;
    $data->usermodified = $USER->id;

    exeweb_set_display_options($data);

    $data->id = $DB->insert_record('exeweb', $data);

    // We need to use context now, so we need to make sure all needed info is already in db.
    $DB->set_field('course_modules', 'instance', $data->id, ['id' => $cmid]);
    $context = context_module::instance($cmid);

    if ($data->exeorigin === EXEWEB_ORIGIN_EXEONLINE) {
        // We are going to set a template file so activity is complete event if exelearning failure.
        $fs = get_file_storage();
        $templatename = get_config('exeweb', 'template');
        $templatefile = false;
        $fileinfo = [
            'contextid' => $context->id,
            'component' => 'mod_exeweb',
            'filearea' => 'package',
            'itemid' => 0,
            'filepath' => '/',
            'filename' => 'default_package.zip',
            'userid' => $USER->id,
            'source' => 'default_package.zip',
            'author' => fullname($USER),
            'license' => 'unknown',
        ];

        if (! empty($templatename)) {
            $templatefile = $fs->get_file(1, 'exeweb', 'config', 0, '/', ltrim($templatename, '/'));
        }

        if ($templatefile) {
            $package = $fs->create_file_from_storedfile($fileinfo, $templatefile);
        } else {
            $defaultpackagepath = $CFG->dirroot . '/mod/exeweb/data/default_package.zip';
            $package = $fs->create_file_from_pathname($fileinfo, $defaultpackagepath);
        }
    } else {
        // Local uploaded package.
        $package = exeweb_package::save_draft_file($data);
    }

    $contentslist = exeweb_package::expand_package($package);
    $mainfile = exeweb_package::get_mainfile($contentslist, $package->get_contextid());
    if ($mainfile !== false) {
        file_set_sortorder($context->id, 'mod_exeweb', 'content', 0, $mainfile->get_filepath(), $mainfile->get_filename(), 1);
        $data->entrypath = $mainfile->get_filepath();
        $data->entryname = $mainfile->get_filename();
        $DB->update_record('exeweb', $data);
    }

    $completiontimeexpected = !empty($data->completionexpected) ? $data->completionexpected : null;
    \core_completion\api::update_completion_date_event($cmid, 'exeweb', $data->id, $completiontimeexpected);

    return $data->id;
}

/**
 * Update exeweb instance.
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function exeweb_update_instance($data, $mform) {
    global $CFG, $DB, $USER;
    require_once("$CFG->libdir/resourcelib.php");
    $data->timecreated = time();
    $data->timemodified = $data->timecreated;
    $data->usermodified = $USER->id;    $data->id           = $data->instance;
    $data->revision++;

    exeweb_set_display_options($data);

    if ($data->exeorigin === EXEWEB_ORIGIN_LOCAL) {
        // Only save uploaded package if is local uploaded.
        $package = exeweb_package::save_draft_file($data);
        $contentslist = exeweb_package::expand_package($package);
        $mainfile = exeweb_package::get_mainfile($contentslist, $package->get_contextid());
        if ($mainfile !== false) {
            file_set_sortorder($package->get_contextid(), 'mod_exeweb', 'content', 0,
                                $mainfile->get_filepath(), $mainfile->get_filename(), 1);
            $data->entrypath = $mainfile->get_filepath();
            $data->entryname = $mainfile->get_filename();
        }
    }
    $DB->update_record('exeweb', $data);

    $completiontimeexpected = !empty($data->completionexpected) ? $data->completionexpected : null;
    \core_completion\api::update_completion_date_event($data->coursemodule, 'exeweb', $data->id, $completiontimeexpected);

    return true;
}

/**
 * Updates display options based on form input.
 *
 * Shared code used by exeweb_add_instance and exeweb_update_instance.
 *
 * @param object $data Data object
 */
function exeweb_set_display_options($data) {
    $displayoptions = [];
    if ($data->display == RESOURCELIB_DISPLAY_POPUP) {
        $displayoptions['popupwidth']  = $data->popupwidth;
        $displayoptions['popupheight'] = $data->popupheight;
    }
    if (in_array($data->display, [RESOURCELIB_DISPLAY_EMBED, RESOURCELIB_DISPLAY_FRAME])) {
        $displayoptions['printintro']   = (int)!empty($data->printintro);
    }
    if (!empty($data->showsize)) {
        $displayoptions['showsize'] = 1;
    }
    if (!empty($data->showtype)) {
        $displayoptions['showtype'] = 1;
    }
    if (!empty($data->showdate)) {
        $displayoptions['showdate'] = 1;
    }
    $data->displayoptions = serialize($displayoptions);
}

/**
 * Delete exeweb instance.
 * @param int $id
 * @return bool true
 */
function exeweb_delete_instance($id) {
    global $DB;

    if (!$exeweb = $DB->get_record('exeweb', ['id' => $id])) {
        return false;
    }

    $cm = get_coursemodule_from_instance('exeweb', $id);
    \core_completion\api::update_completion_date_event($cm->id, 'exeweb', $id, null);

    // Note: all context files are deleted automatically.

    $DB->delete_records('exeweb', ['id' => $exeweb->id]);

    return true;
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 *
 * See {@link course_modinfo::get_array_of_activities()}
 *
 * @param stdClass $coursemodule
 * @return cached_cm_info info
 */
function exeweb_get_coursemodule_info($coursemodule) {
    global $CFG, $DB;
    require_once("$CFG->libdir/filelib.php");
    require_once("$CFG->dirroot/mod/exeweb/locallib.php");
    require_once($CFG->libdir.'/completionlib.php');

    $context = context_module::instance($coursemodule->id);

    if (!$exeweb = $DB->get_record('exeweb', ['id' => $coursemodule->instance],
            'id, name, display, displayoptions, revision, intro, introformat')) {
        return null;
    }

    $info = new cached_cm_info();
    $info->name = $exeweb->name;
    if ($coursemodule->showdescription) {
        // Convert intro to html. Do not filter cached version, filters run at display time.
        $info->content = format_module_intro('exeweb', $exeweb, $coursemodule->id, false);
    }

    $display = $exeweb->display;

    if ($display == RESOURCELIB_DISPLAY_POPUP) {
        $fullurl = "$CFG->wwwroot/mod/exeweb/view.php?id=$coursemodule->id&amp;redirect=1";
        $options = empty($exeweb->displayoptions) ? [] : (array) unserialize_array($exeweb->displayoptions);
        $width  = empty($options['popupwidth']) ? 620 : $options['popupwidth'];
        $height = empty($options['popupheight']) ? 450 : $options['popupheight'];
        $wh = "width=$width,height=$height,toolbar=no,location=no,menubar=no,copyhistory=no,"
                . "status=no,directories=no,scrollbars=yes,resizable=yes";
        $info->onclick = "window.open('$fullurl', '', '$wh'); return false;";

    } else if ($display == RESOURCELIB_DISPLAY_NEW) {
        $fullurl = "$CFG->wwwroot/mod/exeweb/view.php?id=$coursemodule->id&amp;redirect=1";
        $info->onclick = "window.open('$fullurl'); return false;";

    }

    // If any optional extra details are turned on, store in custom data,
    // add some file details as well to be used later by exeweb_get_optional_details() without retriving.
    // Do not store filedetails if this is a reference - they will still need to be retrieved every time.
    if (($filedetails = exeweb_get_file_details($exeweb, $coursemodule)) && empty($filedetails['isref'])) {
        $displayoptions = (array) unserialize_array($exeweb->displayoptions);
        $displayoptions['filedetails'] = $filedetails;
        $info->customdata['displayoptions'] = serialize($displayoptions);
    } else {
        $info->customdata['displayoptions'] = $exeweb->displayoptions;
    }
    $info->customdata['display'] = $display;

    return $info;
}

/**
 * Called when viewing course page. Shows extra details after the link if
 * enabled.
 *
 * @param cm_info $cm Course module information
 */
function exeweb_cm_info_view(cm_info $cm) {
    global $CFG;
    require_once($CFG->dirroot . '/mod/exeweb/locallib.php');

    $exeweb = (object) ['displayoptions' => $cm->customdata['displayoptions']];
    $details = exeweb_get_optional_details($exeweb, $cm);
    if ($details) {
        $cm->set_after_link(' ' . html_writer::tag('span', $details,
                ['class' => 'exeweblinkdetails']));
    }
}

/**
 * Lists all browsable file areas
 *
 * @package  mod_exeweb
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @return array
 */
function exeweb_get_file_areas($course, $cm, $context) {
    $areas = [];
    $areas['content'] = get_string('exewebcontent', 'mod_exeweb');
    $areas['package'] = get_string('areapackage', 'mod_exeweb');

    return $areas;
}

/**
 * File browsing support for exeweb module content area.
 *
 * @package  mod_exeweb
 * @category files
 * @param file_browser $browser file browser instance
 * @param stdClass $areas file areas
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param int $itemid item ID
 * @param string $filepath file path
 * @param string $filename file name
 * @return file_info instance or null if not found
 */
function exeweb_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    global $CFG;

    if (!has_capability('moodle/course:managefiles', $context)) {
        return null;
    }

    $fs = get_file_storage();

    if ($filearea === 'content') {
        $filepath = is_null($filepath) ? '/' : $filepath;
        $filename = is_null($filename) ? '.' : $filename;

        $urlbase = $CFG->wwwroot.'/pluginfile.php';
        if (!$storedfile = $fs->get_file($context->id, 'mod_exeweb', 'content', 0, $filepath, $filename)) {
            if ($filepath === '/' && $filename === '.') {
                $storedfile = new virtual_root_file($context->id, 'mod_exeweb', 'content', 0);
            } else {
                // Not found.
                return null;
            }
        }
        require_once("$CFG->dirroot/mod/exeweb/locallib.php");
        return new exeweb_content_file_info(
            $browser, $context, $storedfile, $urlbase, $areas[$filearea], true, true, true, false
        );
    } else if ($filearea === 'package') {
        $filepath = is_null($filepath) ? '/' : $filepath;
        $filename = is_null($filename) ? '.' : $filename;

        $urlbase = $CFG->wwwroot.'/pluginfile.php';
        if (!$storedfile = $fs->get_file($context->id, 'mod_exeweb', 'package', 0, $filepath, $filename)) {
            if ($filepath === '/' && $filename === '.') {
                $storedfile = new virtual_root_file($context->id, 'mod_exeweb', 'package', 0);
            } else {
                // Not found.
                return null;
            }
        }
        return new file_info_stored($browser, $context, $storedfile, $urlbase, $areas[$filearea], false, true, false, false);
    }

    // Note: exeweb_intro handled in file_browser automatically.

    return null;
}

/**
 * Serves the exeweb files.
 *
 * @package  mod_exeweb
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if file not found, does not return if found - just send the file
 */
function exeweb_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=[]) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_course_login($course, true, $cm);
    if (!has_capability('mod/exeweb:view', $context)) {
        return false;
    }

    if ($filearea !== 'content') {
        // Intro is handled automatically in pluginfile.php.
        return false;
    }

    array_shift($args); // Ignore revision - designed to prevent caching problems only.

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = rtrim("/$context->id/mod_exeweb/$filearea/0/$relativepath", '/');
    do {
        if (!$file = $fs->get_file_by_hash(sha1($fullpath))) {
            if ($fs->get_file_by_hash(sha1("$fullpath/."))) {
                if ($file = $fs->get_file_by_hash(sha1("$fullpath/index.htm"))) {
                    break;
                }
                if ($file = $fs->get_file_by_hash(sha1("$fullpath/index.html"))) {
                    break;
                }
                if ($file = $fs->get_file_by_hash(sha1("$fullpath/Default.htm"))) {
                    break;
                }
            }
        }
    } while (false);

    // Should we apply filters?
    $mimetype = $file->get_mimetype();
    if ($mimetype === 'text/html' || $mimetype === 'text/plain' || $mimetype === 'application/xhtml+xml') {
        $filter = $DB->get_field('exeweb', 'filterfiles', ['id' => $cm->instance]);
        $CFG->embeddedsoforcelinktarget = true;
    } else {
        $filter = 0;
    }

    // Finally send the file.
    send_stored_file($file, null, $filter, $forcedownload, $options);
}

/**
 * Return a list of page types
 * @param string $pagetype current page type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 */
function exeweb_page_type_list($pagetype, $parentcontext, $currentcontext) {
    $modulepagetype = ['mod-exeweb-*' => get_string('page-mod-exeweb-x', 'mod_exeweb')];
    return $modulepagetype;
}

/**
 * Export file exeweb contents
 *
 * @return array of file content
 */
function exeweb_export_contents($cm, $baseurl) {
    global $CFG, $DB;
    $contents = [];
    $context = context_module::instance($cm->id);
    $exeweb = $DB->get_record('exeweb', ['id' => $cm->instance], '*', MUST_EXIST);

    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_exeweb', 'package', 0, 'sortorder DESC, id ASC', false);

    foreach ($files as $fileinfo) {
        $file = [];
        $file['type'] = 'file';
        $file['filename'] = $fileinfo->get_filename();
        $file['filepath'] = $fileinfo->get_filepath();
        $file['filesize'] = $fileinfo->get_filesize();
        $file['fileurl'] = moodle_url::make_pluginfile_url($context->id, 'mod_exeweb', 'package', $exeweb->revision,
                                            $fileinfo->get_filepath(), $fileinfo->get_filename());
        $file['timecreated'] = $fileinfo->get_timecreated();
        $file['timemodified'] = $fileinfo->get_timemodified();
        $file['sortorder'] = $fileinfo->get_sortorder();
        $file['userid'] = $fileinfo->get_userid();
        $file['author'] = $fileinfo->get_author();
        $file['license'] = $fileinfo->get_license();
        $file['mimetype'] = $fileinfo->get_mimetype();
        $file['isexternalfile'] = $fileinfo->is_external_file();
        if ($file['isexternalfile']) {
            $file['repositorytype'] = $fileinfo->get_repository_type();
        }
        $contents[] = $file;
    }

    return $contents;
}

/**
 * Register the ability to handle drag and drop file uploads
 * @return array containing details of the files / types the mod can handle
 */
function exeweb_dndupload_register() {
    return [
        'files' => [
            ['extension' => 'zip',
            'message' => get_string('dnduploadexeweb', 'mod_exeweb')]
        ]
    ];
}

/**
 * Handle a file that has been uploaded
 * @param object $uploadinfo details of the file / content that has been uploaded
 * @return int instance id of the newly created mod
 */
function exeweb_dndupload_handle($uploadinfo) {
    // TODO: Check package and process it.
    // Gather the required info.
    $data = new \stdClass();
    $data->course = $uploadinfo->course->id;
    $data->name = $uploadinfo->displayname;
    $data->intro = '';
    $data->introformat = FORMAT_HTML;
    $data->coursemodule = $uploadinfo->coursemodule;
    $data->files = $uploadinfo->draftitemid;

    // Set the display options to the site defaults.
    $config = get_config('exeweb');
    $data->display = $config->display;
    $data->popupheight = $config->popupheight;
    $data->popupwidth = $config->popupwidth;
    $data->printintro = $config->printintro;
    $data->showsize = (isset($config->showsize)) ? $config->showsize : 0;
    $data->showtype = (isset($config->showtype)) ? $config->showtype : 0;
    $data->showdate = (isset($config->showdate)) ? $config->showdate : 0;
    $data->filterfiles = $config->filterfiles;

    return exeweb_add_instance($data, null);
}

/**
 * Mark the activity completed (if required) and trigger the course_module_viewed event.
 *
 * @param  stdClass $exeweb  exeweb object
 * @param  stdClass $course     course object
 * @param  stdClass $cm         course module object
 * @param  stdClass $context    context object
 * @since Moodle 3.0
 */
function exeweb_view($exeweb, $course, $cm, $context) {

    // Trigger course_module_viewed event.
    $params = [
        'context' => $context,
        'objectid' => $exeweb->id
    ];

    $event = \mod_exeweb\event\course_module_viewed::create($params);
    $event->add_record_snapshot('course_modules', $cm);
    $event->add_record_snapshot('course', $course);
    $event->add_record_snapshot('exeweb', $exeweb);
    $event->trigger();

    // Completion.
    $completion = new completion_info($course);
    $completion->set_module_viewed($cm);
}

/**
 * Check if the module has any update that affects the current user since a given time.
 *
 * @param  cm_info $cm course module data
 * @param  int $from the time to check updates from
 * @param  array $filter  if we need to check only specific updates
 * @return stdClass an object with the different type of areas indicating if they were updated or not
 * @since Moodle 3.2
 */
function exeweb_check_updates_since(cm_info $cm, $from, $filter = []) {
    $updates = course_check_module_updates_since($cm, $from, ['content'], $filter);
    return $updates;
}

/**
 * This function receives a calendar event and returns the action associated with it, or null if there is none.
 *
 * This is used by block_myoverview in order to display the event appropriately. If null is returned then the event
 * is not displayed on the block.
 *
 * @param calendar_event $event
 * @param \core_calendar\action_factory $factory
 * @return \core_calendar\local\event\entities\action_interface|null
 */
function mod_exeweb_core_calendar_provide_event_action(calendar_event $event,
                                                      \core_calendar\action_factory $factory, $userid = 0) {

    global $USER;

    if (empty($userid)) {
        $userid = $USER->id;
    }

    $cm = get_fast_modinfo($event->courseid, $userid)->instances['exeweb'][$event->instance];

    $completion = new \completion_info($cm->get_course());

    $completiondata = $completion->get_data($cm, false, $userid);

    if ($completiondata->completionstate != COMPLETION_INCOMPLETE) {
        return null;
    }

    return $factory->create_instance(
        get_string('view'),
        new \moodle_url('/mod/exeweb/view.php', ['id' => $cm->id]),
        1,
        true
    );
}


/**
 * Given an array with a file path, it returns the itemid and the filepath for the defined filearea.
 *
 * @param  string $filearea The filearea.
 * @param  array  $args The path (the part after the filearea and before the filename).
 * @return array The itemid and the filepath inside the $args path, for the defined filearea.
 */
function mod_exeweb_get_path_from_pluginfile(string $filearea, array $args) : array {
    // Exeweb never has an itemid (the number represents the revision but it's not stored in database).
    array_shift($args);

    // Get the filepath.
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/' . implode('/', $args) . '/';
    }

    return [
        'itemid' => 0,
        'filepath' => $filepath,
    ];
}
