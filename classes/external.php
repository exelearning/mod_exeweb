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
 * Exeweb external API
 *
 * @package    mod_exeweb
 * @category   external
 * @copyright  2015 Juan Leyva <juan@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      Moodle 3.0
 */

use core_course\external\helper_for_get_mods_by_courses;

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/externallib.php");

/**
 * Exeweb external functions
 *
 * @package    mod_exeweb
 * @category   external
 * @copyright  2015 Juan Leyva <juan@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      Moodle 3.0
 */
class mod_exeweb_external extends external_api {

    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     * @since Moodle 3.0
     */
    public static function view_exeweb_parameters() {
        return new external_function_parameters(['exewebid' => new external_value(PARAM_INT, 'exeweb instance id'), ]);
    }

    /**
     * Simulate the exeweb/view.php web interface page: trigger events, completion, etc...
     *
     * @param int $exewebid the exeweb instance id
     * @return array of warnings and status result
     * @since Moodle 3.0
     * @throws moodle_exception
     */
    public static function view_exeweb($exewebid) {
        global $DB, $CFG;
        require_once($CFG->dirroot . "/mod/exeweb/lib.php");

        $params = self::validate_parameters(self::view_exeweb_parameters(),
                                            [
                                                'exewebid' => $exewebid
                                            ]);
        $warnings = [];

        // Request and permission validation.
        $exeweb = $DB->get_record('exeweb', ['id' => $params['exewebid'], ], '*', MUST_EXIST);
        list($course, $cm) = get_course_and_cm_from_instance($exeweb, 'exeweb');

        $context = context_module::instance($cm->id);
        self::validate_context($context);

        require_capability('mod/exeweb:view', $context);

        // Call the exeweb/lib API.
        exeweb_view($exeweb, $course, $cm, $context);

        $result = [];
        $result['status'] = true;
        $result['warnings'] = $warnings;
        return $result;
    }

    /**
     * Returns description of method result value
     *
     * @return external_description
     * @since Moodle 3.0
     */
    public static function view_exeweb_returns() {
        return new external_single_structure(
            [
                'status' => new external_value(PARAM_BOOL, 'status: true if success'),
                'warnings' => new external_warnings(),
            ]
        );
    }

    /**
     * Describes the parameters for get_exewebs_by_courses.
     *
     * @return external_function_parameters
     * @since Moodle 3.3
     */
    public static function get_exewebs_by_courses_parameters() {
        return new external_function_parameters (
            [
                'courseids' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'Course id'), 'Array of course ids', VALUE_DEFAULT, []
                ),
            ]
        );
    }

    /**
     * Returns a list of files in a provided list of courses.
     * If no list is provided all files that the user can view will be returned.
     *
     * @param array $courseids course ids
     * @return array of warnings and files
     * @since Moodle 3.3
     */
    public static function get_exewebs_by_courses($courseids = []) {

        $warnings = [];
        $returnedexewebs = [];

        $params = ['courseids' => $courseids, ];
        $params = self::validate_parameters(self::get_exewebs_by_courses_parameters(), $params);

        $mycourses = [];
        if (empty($params['courseids'])) {
            $mycourses = enrol_get_my_courses();
            $params['courseids'] = array_keys($mycourses);
        }

        // Ensure there are courseids to loop through.
        if (!empty($params['courseids'])) {

            list($courses, $warnings) = external_util::validate_courses($params['courseids'], $mycourses);

            // Get the exewebs in this course, this function checks users visibility permissions.
            // We can avoid then additional validate_context calls.
            $exewebs = get_all_instances_in_courses("exeweb", $courses);
            foreach ($exewebs as $exeweb) {
                $context = context_module::instance($exeweb->coursemodule);

                helper_for_get_mods_by_courses::format_name_and_intro($exeweb, 'mod_exeweb');
                $exeweb->contentfiles = external_util::get_area_files($context->id, 'mod_exeweb', 'content');

                $returnedexewebs[] = $exeweb;
            }
        }

        $result = [
            'exewebs' => $returnedexewebs,
            'warnings' => $warnings,
        ];
        return $result;
    }

    /**
     * Describes the get_exewebs_by_courses return value.
     *
     * @return external_single_structure
     * @since Moodle 3.3
     */
    public static function get_exewebs_by_courses_returns() {
        return new external_single_structure(
            [
                'exewebs' => new external_multiple_structure(
                    new external_single_structure(array_merge(
                        helper_for_get_mods_by_courses::standard_coursemodule_elements_returns(),
                        [
                            'contentfiles' => new external_files('Files in the content'),
                            'display' => new external_value(PARAM_INT, 'How to display the exeweb'),
                            'displayoptions' => new external_value(PARAM_RAW, 'Display options (width, height)'),
                            'filterfiles' => new external_value(PARAM_INT, 'If filters should be applied to the exeweb content'),
                            'revision' => new external_value(PARAM_INT, 'Incremented when after each file changes, to avoid cache'),
                            'timemodified' => new external_value(PARAM_INT, 'Last time the exeweb was modified'),
                        ]
                    ))
                ),
                'warnings' => new external_warnings(),
            ]
        );
    }
}
