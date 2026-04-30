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
 * Unit tests for mod_exeweb package handling.
 *
 * Covers the regression behind issue #42 where webzip packages received from
 * eXeLearning Online were extracted into the right itemid but
 * {@see exeweb_package::get_mainfile()} was queried with the default itemid
 * (0), leaving entrypath/entryname stale and breaking image references on the
 * served HTML page.
 *
 * @package    mod_exeweb
 * @copyright  2026 eXeLearning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_exeweb;

/**
 * Unit tests for {@see exeweb_package}.
 */
final class exeweb_package_test extends \advanced_testcase {

    /**
     * Build an in-memory zip mimicking the layout produced by Html5Exporter
     * when eXeLearning Online sends a webzip back to mod_exeweb. The structure
     * matches what the editor generates: index.html at the root, an asset
     * inside content/resources/, and a content.xml descriptor (the only file
     * the validation rules require by default).
     *
     * @return string Raw zip contents.
     */
    private function build_webzip_contents(): string {
        $tempzip = tempnam(make_request_directory(), 'exeweb_test_');
        $zip = new \ZipArchive();
        $zip->open($tempzip, \ZipArchive::OVERWRITE);
        $zip->addFromString('index.html', '<!doctype html><html><body><img src="content/resources/photo.png"></body></html>');
        $zip->addFromString('content/resources/photo.png', "PNG\x89\x50\x4e\x47\r\n\x1a\nFAKE");
        $zip->addFromString('content.xml', '<?xml version="1.0"?><package />');
        $zip->close();

        $bytes = file_get_contents($tempzip);
        @unlink($tempzip);

        return $bytes;
    }

    /**
     * Store a synthetic webzip in the package filearea at the requested itemid
     * and return the resulting stored_file. Mirrors the relevant portion of
     * set_ode.php so the test exercises the same Moodle file API calls.
     *
     * @param int $contextid
     * @param int $itemid
     * @return \stored_file
     */
    private function store_package_file(int $contextid, int $itemid): \stored_file {
        $fs = get_file_storage();
        $fileinfo = [
            'contextid' => $contextid,
            'component' => 'mod_exeweb',
            'filearea' => 'package',
            'itemid' => $itemid,
            'filepath' => '/',
            'filename' => 'package.zip',
        ];
        return $fs->create_file_from_string($fileinfo, $this->build_webzip_contents());
    }

    /**
     * Regression test: get_mainfile() must locate index.html in the same
     * itemid where expand_package() extracted the contents. The default
     * itemid 0 used by the previous implementation silently missed the entry
     * file when the package was stored on a non-zero revision (the case for
     * every online save after the first one).
     *
     * @covers \mod_exeweb\exeweb_package::expand_package
     * @covers \mod_exeweb\exeweb_package::get_mainfile
     */
    public function test_get_mainfile_uses_package_itemid(): void {
        $this->resetAfterTest();

        $course = $this->getDataGenerator()->create_course();
        $exeweb = $this->getDataGenerator()->create_module('exeweb', ['course' => $course->id]);
        $context = \context_module::instance($exeweb->cmid);

        // Simulate an online save landing on revision 3 (the regression
        // scenario reported in issue #42).
        $itemid = 3;
        $package = $this->store_package_file($context->id, $itemid);

        $contentslist = exeweb_package::expand_package($package);
        $this->assertNotEmpty($contentslist, 'expand_package must return the extracted file list');

        $mainfile = exeweb_package::get_mainfile($contentslist, $context->id, $itemid);
        $this->assertNotFalse($mainfile, 'get_mainfile must locate index.html when given the correct itemid');
        $this->assertSame('index.html', $mainfile->get_filename());
        $this->assertSame('/', $mainfile->get_filepath());

        // Default-argument behaviour exposes the bug: index.html lives at
        // itemid 3, but a call without itemid hits the default 0 and returns
        // false.
        $missingmainfile = exeweb_package::get_mainfile($contentslist, $context->id);
        $this->assertFalse($missingmainfile,
            'A call without the itemid argument must miss the entry file (regression for issue #42)');
    }

    /**
     * Verify that the package extraction places nested resources in the same
     * relative path that the HTML file references. This mirrors the URL the
     * Moodle pluginfile handler builds when serving the activity, so a hit
     * here implies the served page can resolve its assets.
     *
     * @covers \mod_exeweb\exeweb_package::expand_package
     */
    public function test_expand_package_preserves_resource_paths(): void {
        $this->resetAfterTest();

        $course = $this->getDataGenerator()->create_course();
        $exeweb = $this->getDataGenerator()->create_module('exeweb', ['course' => $course->id]);
        $context = \context_module::instance($exeweb->cmid);

        $itemid = 5;
        $package = $this->store_package_file($context->id, $itemid);

        exeweb_package::expand_package($package);

        $fs = get_file_storage();
        $resource = $fs->get_file($context->id, 'mod_exeweb', 'content', $itemid,
            '/content/resources/', 'photo.png');
        $this->assertNotFalse($resource,
            'Resources referenced by HTML must extract to the same path within the content filearea');
    }

    /**
     * Calling expand_package() twice with two different revisions reflects an
     * online save flow. After the second call only files for the latest
     * revision remain in the content filearea, matching the URL the activity
     * view will request.
     *
     * @covers \mod_exeweb\exeweb_package::expand_package
     */
    public function test_expand_package_replaces_old_revisions(): void {
        $this->resetAfterTest();

        $course = $this->getDataGenerator()->create_course();
        $exeweb = $this->getDataGenerator()->create_module('exeweb', ['course' => $course->id]);
        $context = \context_module::instance($exeweb->cmid);

        $firstpackage = $this->store_package_file($context->id, 1);
        exeweb_package::expand_package($firstpackage);

        $secondpackage = $this->store_package_file($context->id, 2);
        exeweb_package::expand_package($secondpackage);

        $fs = get_file_storage();
        $previous = $fs->get_area_files($context->id, 'mod_exeweb', 'content', 1, '', false);
        $this->assertEmpty($previous, 'Stale content from previous revisions must be cleaned up');

        $current = $fs->get_area_files($context->id, 'mod_exeweb', 'content', 2, '', false);
        $this->assertNotEmpty($current, 'Latest revision must hold the freshly extracted files');
    }
}
