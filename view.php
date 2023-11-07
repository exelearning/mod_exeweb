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
 * Exeweb module version information
 *
 * @package    mod_exeweb
 * @copyright  2009 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once($CFG->dirroot.'/mod/exeweb/lib.php');
require_once($CFG->dirroot.'/mod/exeweb/locallib.php');
require_once($CFG->libdir.'/completionlib.php');

$id       = optional_param('id', 0, PARAM_INT); // Course Module ID.
$r        = optional_param('r', 0, PARAM_INT);  // Exeweb instance ID.
$redirect = optional_param('redirect', 0, PARAM_BOOL);
$forceview = optional_param('forceview', 0, PARAM_BOOL);

if ($r) {
    if (!$exeweb = $DB->get_record('exeweb', ['id' => $r])) {
        throw new \moodle_exception('invalidaccessparameter');
    }
    $cm = get_coursemodule_from_instance('exeweb', $exeweb->id, $exeweb->course, false, MUST_EXIST);

} else {
    if (!$cm = get_coursemodule_from_id('exeweb', $id)) {
        throw new \moodle_exception('invalidcoursemodule');
    }
    $exeweb = $DB->get_record('exeweb', ['id' => $cm->instance], '*', MUST_EXIST);
}

$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);

require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/exeweb:view', $context);

// Completion and trigger events.
exeweb_view($exeweb, $course, $cm, $context);

$PAGE->set_url('/mod/exeweb/view.php', ['id' => $cm->id]);

$fs = get_file_storage();

$file = $fs->get_file($context->id, 'mod_exeweb', 'content', 0, $exeweb->entrypath, $exeweb->entryname);
if (! $file) {
    exeweb_print_filenotfound($exeweb, $cm, $course);
    die;
}

$displaytype = $exeweb->display;
if ($displaytype == RESOURCELIB_DISPLAY_OPEN) {
    $redirect = true;
}

// Don't redirect teachers, otherwise they can not access course or module settings.
if ($redirect && !course_get_format($course)->has_view_page() &&
        (has_capability('moodle/course:manageactivities', $context) ||
        has_capability('moodle/course:update', context_course::instance($course->id)))) {
    $redirect = false;
}

if ($redirect && !$forceview) {
    // Coming from course page or url index page
    // this redirect trick solves caching problems when tracking views ;-) .
    $path = '/'.$context->id.'/mod_exeweb/content/'.$exeweb->revision.$file->get_filepath().$file->get_filename();
    $fullurl = moodle_url::make_file_url('/pluginfile.php', $path);
    redirect($fullurl);
}

$renderer = $PAGE->get_renderer('mod_exeweb');

$PAGE->requires->js_call_amd('mod_exeweb/fullscreen', 'init');
$PAGE->requires->js_call_amd('mod_exeweb/resize', 'init', ['exewebobject', ]);
switch ($displaytype) {
    case RESOURCELIB_DISPLAY_EMBED:
        exeweb_display_embed($exeweb, $cm, $course, $file);
        break;
    case RESOURCELIB_DISPLAY_FRAME:
        exeweb_display_frame($exeweb, $cm, $course, $file);
        break;
    default:
        exeweb_print_workaround($exeweb, $cm, $course, $file);
        break;
}
