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
     * exeweb_is_teacher_mode_visible() defaults to true when the option is absent and
     * otherwise mirrors the stored per-activity flag.
     * @return void
     */
    public function test_is_teacher_mode_visible() {
        // Absent option -> default true (matches the form default and legacy rows).
        $this->assertTrue(exeweb_is_teacher_mode_visible((object) []));
        $this->assertTrue(exeweb_is_teacher_mode_visible((object) ['displayoptions' => '']));
        // Stored 1 -> true, stored 0 -> false.
        $this->assertTrue(
            exeweb_is_teacher_mode_visible((object) ['displayoptions' => serialize(['teachermodevisible' => 1])])
        );
        $this->assertFalse(
            exeweb_is_teacher_mode_visible((object) ['displayoptions' => serialize(['teachermodevisible' => 0])])
        );
    }
}
