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
 * Unit tests for mod_exeweb locallib.
 *
 * @package    mod_exeweb
 * @category   test
 * @copyright  2026 ATE (Área de Tecnología Educativa)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_exeweb;

/**
 * Unit tests for mod_exeweb locallib.
 *
 * @package    mod_exeweb
 * @category   test
 * @copyright  2026 ATE (Área de Tecnología Educativa)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     ::exeweb_is_teacher_mode_visible
 * @covers     ::exeweb_apply_teacher_mode_param
 * @covers     ::exeweb_get_clicktoopen
 */
class locallib_test extends \advanced_testcase {

    /**
     * Loads locallib (and lib) before the test case runs.
     * @return void
     */
    public static function setUpBeforeClass(): void {
        global $CFG;
        require_once($CFG->dirroot . '/mod/exeweb/locallib.php');
    }

    /**
     * exeweb_is_teacher_mode_visible() defaults to false when the option is absent and
     * otherwise mirrors the stored per-activity flag.
     * @return void
     */
    public function test_is_teacher_mode_visible() {
        // Absent option -> default false (matches the form default and the opt-in principle).
        $this->assertFalse(exeweb_is_teacher_mode_visible((object) []));
        $this->assertFalse(exeweb_is_teacher_mode_visible((object) ['displayoptions' => '']));
        // Stored 1 -> true, stored 0 -> false.
        $this->assertTrue(
            exeweb_is_teacher_mode_visible((object) ['displayoptions' => serialize(['teachermodevisible' => 1])])
        );
        $this->assertFalse(
            exeweb_is_teacher_mode_visible((object) ['displayoptions' => serialize(['teachermodevisible' => 0])])
        );
    }

    /**
     * exeweb_apply_teacher_mode_param() adds ?exe-teacher=1 only when the activity opts in.
     * This is the centralized rule shared by every display mode (embed, popup, new, redirect).
     * @return void
     */
    public function test_apply_teacher_mode_param() {
        $base = new \moodle_url('/pluginfile.php/1/mod_exeweb/content/1/index.html');

        // Reveal on -> param appended.
        $on = (object) ['displayoptions' => serialize(['teachermodevisible' => 1])];
        $this->assertStringContainsString(
            'exe-teacher=1', exeweb_apply_teacher_mode_param(clone $base, $on)->out(false));

        // Reveal off or absent -> param not added.
        $off = (object) ['displayoptions' => serialize(['teachermodevisible' => 0])];
        $this->assertStringNotContainsString(
            'exe-teacher', exeweb_apply_teacher_mode_param(clone $base, $off)->out(false));
        $this->assertStringNotContainsString(
            'exe-teacher', exeweb_apply_teacher_mode_param(clone $base, (object) [])->out(false));
    }

    /**
     * exeweb_get_clicktoopen() embeds ?exe-teacher=1 in the click-to-open link used by the
     * popup and open display modes when the reveal setting is on, and omits it when off.
     * This is the link path that previously dropped the parameter for non-embed modes.
     * @return void
     */
    public function test_clicktoopen_contains_teacher_param() {
        $this->resetAfterTest();

        $fs = get_file_storage();
        $file = $fs->create_file_from_string([
            'contextid' => \context_system::instance()->id, 'component' => 'mod_exeweb',
            'filearea' => 'content', 'itemid' => 1, 'filepath' => '/', 'filename' => 'index.html',
        ], '<html></html>');

        // Reveal on -> the link carries the parameter.
        $on = (object) ['displayoptions' => serialize(['teachermodevisible' => 1])];
        $this->assertStringContainsString('exe-teacher=1', exeweb_get_clicktoopen($file, 1, '', $on));

        // Reveal off -> no parameter.
        $off = (object) ['displayoptions' => serialize(['teachermodevisible' => 0])];
        $this->assertStringNotContainsString('exe-teacher', exeweb_get_clicktoopen($file, 1, '', $off));
    }
}
