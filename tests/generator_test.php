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

/**
 * PHPUnit data generator testcase.
 *
 * @package    mod_exeweb
 * @category phpunit
 * @covers \mod_exeweb_generator
 * @copyright 2013 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class generator_test extends \advanced_testcase {

    public function test_generator() {
        global $DB, $SITE;

        $this->resetAfterTest(true);

        // Must be a non-guest user to create exewebs.
        $this->setAdminUser();

        // There are 0 exewebs initially.
        $this->assertEquals(0, $DB->count_records('exeweb'));

        // Create the generator object and do standard checks.
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_exeweb');
        $this->assertInstanceOf('mod_exeweb_generator', $generator);
        $this->assertEquals('exeweb', $generator->get_modulename());

        // Create three instances in the site course.
        $generator->create_instance(['course' => $SITE->id]);
        $generator->create_instance(['course' => $SITE->id]);
        $exeweb = $generator->create_instance(['course' => $SITE->id]);
        $this->assertEquals(3, $DB->count_records('exeweb'));

        // Check the course-module is correct.
        $cm = get_coursemodule_from_instance('exeweb', $exeweb->id);
        $this->assertEquals($exeweb->id, $cm->instance);
        $this->assertEquals('exeweb', $cm->modname);
        $this->assertEquals($SITE->id, $cm->course);

        // Check the context is correct.
        $context = \context_module::instance($cm->id);
        $this->assertEquals($exeweb->cmid, $context->instanceid);

        // Check that generated exeweb module contains a file.
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'mod_exeweb', 'content', false, '', false);
        $file = array_values($files)[0];
        $this->assertCount(1, $files);
        $this->assertEquals('exeweb3.txt', $file->get_filename());
        $this->assertEquals('Test exeweb exeweb3.txt file', $file->get_content());

        // Create a new exeweb specifying the file name.
        $exeweb = $generator->create_instance(['course' => $SITE->id, 'defaultfilename' => 'myfile.pdf']);

        // Check that generated exeweb module contains a file with the specified name.
        $cm = get_coursemodule_from_instance('exeweb', $exeweb->id);
        $context = \context_module::instance($cm->id);
        $files = $fs->get_area_files($context->id, 'mod_exeweb', 'content', false, '', false);
        $file = array_values($files)[0];
        $this->assertCount(1, $files);
        $this->assertEquals('myfile.pdf', $file->get_filename());
        $this->assertEquals('Test exeweb myfile.pdf file', $file->get_content());

        // Create a new exeweb uploading a file.
        $exeweb = $generator->create_instance([
            'course' => $SITE->id,
            'uploaded' => true,
            'defaultfilename' => 'mod/exeweb/tests/fixtures/samplefile.txt',
        ]);

        // Check that generated exeweb module contains the uploaded samplefile.txt.
        $cm = get_coursemodule_from_instance('exeweb', $exeweb->id);
        $context = \context_module::instance($cm->id);
        $files = $fs->get_area_files($context->id, 'mod_exeweb', 'content', false, '', false);
        $file = array_values($files)[0];
        $this->assertCount(1, $files);
        $this->assertEquals('samplefile.txt', $file->get_filename());
        $this->assertEquals('Hello!', $file->get_content());

        // Try to generate a exeweb with uploaded file without specifying the file.
        try {
            $exeweb = $generator->create_instance([
                'course' => $SITE->id,
                'uploaded' => true,
            ]);
            $this->assertTrue(false, 'coding_exception expected, defaultfilename is required');
        } catch (\Exception $e) {
            $this->assertInstanceOf(\coding_exception::class, $e);
            $this->assertStringContainsString('defaultfilename option is required', $e->getMessage());
        }

        // Try to generate a exeweb with uploaded file pointing to non-existing file.
        try {
            $exeweb = $generator->create_instance([
                'course' => $SITE->id,
                'uploaded' => true,
                'defaultfilename' => 'mod/exeweb/tests/fixtures/doesnotexist.txt',
            ]);
            $this->assertTrue(false, 'coding_exception expected, defaultfilename must point to an existing file');
        } catch (\Exception $e) {
            $this->assertInstanceOf(\coding_exception::class, $e);
            $this->assertStringContainsString('defaultfilename option must point to an existing file', $e->getMessage());
        }
    }
}
