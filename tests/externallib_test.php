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

namespace mod_exeweb;

use externallib_advanced_testcase;
use mod_exeweb_external;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/webservice/tests/helpers.php');

/**
 * External mod_exeweb functions unit tests
 *
 * @package    mod_exeweb
 * @category   external
 * @copyright  2015 Juan Leyva <juan@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      Moodle 3.0
 */
class externallib_test extends externallib_advanced_testcase {

    /**
     * Test view_exeweb
     */
    public function test_view_exeweb() {
        global $DB;

        $this->resetAfterTest(true);

        $this->setAdminUser();
        // Setup test data.
        $course = $this->getDataGenerator()->create_course();
        $exeweb = $this->getDataGenerator()->create_module('exeweb', ['course' => $course->id]);
        $context = \context_module::instance($exeweb->cmid);
        $cm = get_coursemodule_from_instance('exeweb', $exeweb->id);

        // Test invalid instance id.
        try {
            mod_exeweb_external::view_exeweb(0);
            $this->fail('Exception expected due to invalid mod_exeweb instance id.');
        } catch (\moodle_exception $e) {
            $this->assertEquals('invalidrecord', $e->errorcode);
        }

        // Test not-enrolled user.
        $user = self::getDataGenerator()->create_user();
        $this->setUser($user);
        try {
            mod_exeweb_external::view_exeweb($exeweb->id);
            $this->fail('Exception expected due to not enrolled user.');
        } catch (\moodle_exception $e) {
            $this->assertEquals('requireloginerror', $e->errorcode);
        }

        // Test user with full capabilities.
        $studentrole = $DB->get_record('role', ['shortname' => 'student']);
        $this->getDataGenerator()->enrol_user($user->id, $course->id, $studentrole->id);

        // Trigger and capture the event.
        $sink = $this->redirectEvents();

        $result = mod_exeweb_external::view_exeweb($exeweb->id);
        $result = \external_api::clean_returnvalue(mod_exeweb_external::view_exeweb_returns(), $result);

        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = array_shift($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\mod_exeweb\event\course_module_viewed', $event);
        $this->assertEquals($context, $event->get_context());
        $moodleurl = new \moodle_url('/mod/exeweb/view.php', ['id' => $cm->id]);
        $this->assertEquals($moodleurl, $event->get_url());
        $this->assertEventContextNotUsed($event);
        $this->assertNotEmpty($event->get_name());

        // Test user with no capabilities.
        // We need a explicit prohibit since this capability is only defined in authenticated user and guest roles.
        assign_capability('mod/exeweb:view', CAP_PROHIBIT, $studentrole->id, $context->id);
        // Empty all the caches that may be affected by this change.
        accesslib_clear_all_caches_for_unit_testing();
        \course_modinfo::clear_instance_cache();

        try {
            mod_exeweb_external::view_exeweb($exeweb->id);
            $this->fail('Exception expected due to missing capability.');
        } catch (\moodle_exception $e) {
            $this->assertEquals('requireloginerror', $e->errorcode);
        }

    }

    /**
     * Test test_mod_exeweb_get_exewebs_by_courses
     */
    public function test_mod_exeweb_get_exewebs_by_courses() {
        global $DB;

        $this->resetAfterTest(true);

        $course1 = self::getDataGenerator()->create_course();
        $course2 = self::getDataGenerator()->create_course();

        $student = self::getDataGenerator()->create_user();
        $studentrole = $DB->get_record('role', ['shortname' => 'student']);
        $this->getDataGenerator()->enrol_user($student->id, $course1->id, $studentrole->id);

        self::setUser($student);

        // First exeweb.
        $record = new \stdClass();
        $record->course = $course1->id;
        $exeweb1 = self::getDataGenerator()->create_module('exeweb', $record);

        // Second exeweb.
        $record = new \stdClass();
        $record->course = $course2->id;
        $exeweb2 = self::getDataGenerator()->create_module('exeweb', $record);

        // Execute real Moodle enrolment as we'll call unenrol() method on the instance later.
        $enrol = enrol_get_plugin('manual');
        $enrolinstances = enrol_get_instances($course2->id, true);
        $instance2 = new \stdClass();
        foreach ($enrolinstances as $courseenrolinstance) {
            if ($courseenrolinstance->enrol == "manual") {
                $instance2 = $courseenrolinstance;
                break;
            }
        }
        $enrol->enrol_user($instance2, $student->id, $studentrole->id);

        $returndescription = mod_exeweb_external::get_exewebs_by_courses_returns();

        // Create what we expect to be returned when querying the two courses.
        $expectedfields = ['id', 'coursemodule', 'course', 'name', 'intro', 'introformat', 'introfiles', 'lang',
                                'contentfiles', 'display', 'displayoptions', 'filterfiles', 'entrypath', 'entryname',
                                'revision', 'timecreated', 'timemodified', 'usermodified',
                                'section', 'visible', 'groupmode', 'groupingid'];

        // Add expected coursemodule and data.
        $exeweb1->coursemodule = $exeweb1->cmid;
        $exeweb1->introformat = 1;
        $exeweb1->contentformat = 1;
        $exeweb1->section = 0;
        $exeweb1->visible = true;
        $exeweb1->groupmode = 0;
        $exeweb1->groupingid = 0;
        $exeweb1->introfiles = [];
        $exeweb1->contentfiles = [];
        $exeweb1->lang = '';

        $exeweb2->coursemodule = $exeweb2->cmid;
        $exeweb2->introformat = 1;
        $exeweb2->contentformat = 1;
        $exeweb2->section = 0;
        $exeweb2->visible = true;
        $exeweb2->groupmode = 0;
        $exeweb2->groupingid = 0;
        $exeweb2->introfiles = [];
        $exeweb2->contentfiles = [];
        $exeweb2->lang = '';

        foreach ($expectedfields as $field) {
            $expected1[$field] = $exeweb1->{$field};
            $expected2[$field] = $exeweb2->{$field};
        }

        $expectedexewebs = [$expected2, $expected1];

        // Call the external function passing course ids.
        $result = mod_exeweb_external::get_exewebs_by_courses([$course2->id, $course1->id]);
        $result = \external_api::clean_returnvalue($returndescription, $result);

        // Remove the contentfiles (to be checked bellow).
        $result['exewebs'][0]['contentfiles'] = [];
        $result['exewebs'][1]['contentfiles'] = [];

        // Now, check that we retrieve the same data we created.
        $this->assertEquals($expectedexewebs, $result['exewebs']);
        $this->assertCount(0, $result['warnings']);

        // Call the external function without passing course id.
        $result = mod_exeweb_external::get_exewebs_by_courses();
        $result = \external_api::clean_returnvalue($returndescription, $result);

        // Remove the contentfiles (to be checked bellow).
        $result['exewebs'][0]['contentfiles'] = [];
        $result['exewebs'][1]['contentfiles'] = [];

        // Check that without course ids we still get the correct data.
        $this->assertEquals($expectedexewebs, $result['exewebs']);
        $this->assertCount(0, $result['warnings']);

        // Add a file to the intro.
        $fileintroname = "fileintro.txt";
        $filerecordinline = [
            'contextid' => \context_module::instance($exeweb2->cmid)->id,
            'component' => 'mod_exeweb',
            'filearea'  => 'intro',
            'itemid'    => 0,
            'filepath'  => '/',
            'filename'  => $fileintroname,
        ];
        $fs = get_file_storage();
        $timepost = time();
        $fs->create_file_from_string($filerecordinline, 'image contents (not really)');

        $result = mod_exeweb_external::get_exewebs_by_courses([$course2->id, $course1->id]);
        $result = \external_api::clean_returnvalue($returndescription, $result);

        // Check that we receive correctly the files.
        $this->assertCount(1, $result['exewebs'][0]['introfiles']);
        $this->assertEquals($fileintroname, $result['exewebs'][0]['introfiles'][0]['filename']);
        $this->assertCount(1, $result['exewebs'][0]['contentfiles']);
        $this->assertCount(1, $result['exewebs'][1]['contentfiles']);
        // Test autogenerated exeweb.
        $this->assertEquals('exeweb2.txt', $result['exewebs'][0]['contentfiles'][0]['filename']);
        $this->assertEquals('exeweb1.txt', $result['exewebs'][1]['contentfiles'][0]['filename']);

        // Unenrol user from second course.
        $enrol->unenrol_user($instance2, $student->id);
        array_shift($expectedexewebs);

        // Call the external function without passing course id.
        $result = mod_exeweb_external::get_exewebs_by_courses();
        $result = \external_api::clean_returnvalue($returndescription, $result);

        // Remove the contentfiles (to be checked bellow).
        $result['exewebs'][0]['contentfiles'] = [];
        $this->assertEquals($expectedexewebs, $result['exewebs']);

        // Call for the second course we unenrolled the user from, expected warning.
        $result = mod_exeweb_external::get_exewebs_by_courses([$course2->id]);
        $this->assertCount(1, $result['warnings']);
        $this->assertEquals('1', $result['warnings'][0]['warningcode']);
        $this->assertEquals($course2->id, $result['warnings'][0]['itemid']);
    }
}
