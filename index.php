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
 * List of all exewebs in course
 *
 * @package    mod_exeweb
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$id = required_param('id', PARAM_INT); // Course id.

$course = $DB->get_record('course', ['id' => $id], '*', MUST_EXIST);

require_course_login($course, true);
$PAGE->set_pagelayout('incourse');

$params = ['context' => context_course::instance($course->id) ];
$event = \mod_exeweb\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

$strexeweb    = get_string('modulename', 'mod_exeweb');
$strexewebs    = get_string('modulenameplural', 'mod_exeweb');
$strsectionname  = get_string('sectionname', 'format_'.$course->format);
$strname         = get_string('name');
$strintro        = get_string('moduleintro');
$strlastmodified = get_string('lastmodified');

$PAGE->set_url('/mod/exeweb/index.php', ['id' => $course->id]);
$PAGE->set_title($course->shortname.': '.$strexewebs);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add($strexewebs);
echo $OUTPUT->header();
if (!$PAGE->has_secondary_navigation()) {
    echo $OUTPUT->heading($strexewebs);
}

if (!$exewebs = get_all_instances_in_course('exeweb', $course)) {
    notice(get_string('thereareno', 'moodle', $strexewebs), "$CFG->wwwroot/course/view.php?id=$course->id");
    exit;
}

$usesections = course_format_uses_sections($course->format);

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $table->head  = [$strsectionname, $strname, $strintro];
    $table->align = ['center', 'left', 'left'];
} else {
    $table->head  = [$strlastmodified, $strname, $strintro];
    $table->align = ['left', 'left', 'left'];
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($exewebs as $exeweb) {
    $cm = $modinfo->cms[$exeweb->coursemodule];
    if ($usesections) {
        $printsection = '';
        if ($exeweb->section !== $currentsection) {
            if ($exeweb->section) {
                $printsection = get_section_name($course, $exeweb->section);
            }
            if ($currentsection !== '') {
                $table->data[] = 'hr';
            }
            $currentsection = $exeweb->section;
        }
    } else {
        $printsection = '<span class="smallinfo">'.userdate($exeweb->timemodified)."</span>";
    }

    $extra = empty($cm->extra) ? '' : $cm->extra;
    $icon = '';
    if (!empty($cm->icon)) {
        // Each exeweb file has an icon in 2.0.
        $icon = $OUTPUT->pix_icon($cm->icon, get_string('modulename', $cm->modname));
    }

    $class = $exeweb->visible ? '' : 'class="dimmed"'; // Hidden modules are dimmed.
    $table->data[] = [
        $printsection,
        "<a $class $extra href=\"view.php?id=$cm->id\">".$icon.format_string($exeweb->name)."</a>",
        format_module_intro('exeweb', $exeweb, $cm->id)];
}

echo html_writer::table($table);

echo $OUTPUT->footer();
