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

use basic_testcase;
use core_requirejs;
use PHPUnit\Framework\Attributes\CoversNothing;

/**
 * Guard for the files Moodle bundles from amd/build/.
 *
 * Moodle concatenates every amd/build/*.min.js of every plugin into the RequireJS
 * bundle served on all pages. A file without define() makes lib/requirejs.php echo
 * a warning before the gzip-compressed body, which corrupts the response and leaves
 * every JavaScript page waiting on core/first. Plain scripts belong in js/.
 *
 * @package    mod_exeweb
 * @category   test
 * @copyright  2026 ATE (Área de Tecnología Educativa)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[CoversNothing]
final class amd_modules_test extends basic_testcase {
    /**
     * Every module Moodle bundles for this plugin is a real AMD module.
     */
    public function test_every_bundled_module_calls_define(): void {
        $modules = array_filter(
            core_requirejs::find_all_amd_modules(false, true),
            fn(string $name): bool => str_starts_with($name, 'mod_exeweb/'),
            ARRAY_FILTER_USE_KEY
        );
        $this->assertNotEmpty($modules);
        foreach ($modules as $name => $path) {
            $this->assertMatchesRegularExpression(
                '/define\s*\(/',
                file_get_contents($path),
                "{$name} ({$path}) has no define(): move plain scripts out of amd/."
            );
        }
    }
}
