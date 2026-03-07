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

/**
 * AJAX endpoint for saving packages from the embedded eXeLearning editor.
 *
 * Receives an exported package, stores it in filearea "package", then updates
 * module metadata. Old package files are deleted only after the new one is
 * successfully stored and processed.
 *
 * @package    mod_exeweb
 * @copyright  2025 eXeLearning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);

require('../../../config.php');
require_once($CFG->dirroot . '/mod/exeweb/lib.php');
require_once($CFG->dirroot . '/mod/exeweb/locallib.php');

use mod_exeweb\exeweb_package;

$cmid = required_param('cmid', PARAM_INT);
$format = 'elpx';

$cm = get_coursemodule_from_id('exeweb', $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
$exeweb = $DB->get_record('exeweb', ['id' => $cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm);
require_sesskey();
$context = context_module::instance($cm->id);
require_capability('moodle/course:manageactivities', $context);

header('Content-Type: application/json; charset=utf-8');

$newpackage = null;
$newrevision = (int)$exeweb->revision + 1;

try {
    if (empty($_FILES['package'])) {
        throw new moodle_exception('nofile', 'error');
    }

    $uploadedfile = $_FILES['package'];
    if ((int)$uploadedfile['error'] !== UPLOAD_ERR_OK) {
        throw new moodle_exception('uploadproblem', 'error');
    }
    $fs = get_file_storage();
    $defaultname = 'package.elpx';

    $filename = clean_filename($uploadedfile['name']);
    if (empty($filename)) {
        $filename = $defaultname;
    }

    $fileinfo = [
        'contextid' => $context->id,
        'component' => 'mod_exeweb',
        'filearea' => 'package',
        'itemid' => $newrevision,
        'filepath' => '/',
        'filename' => $filename,
        'userid' => $USER->id,
        'source' => $filename,
        'author' => fullname($USER),
        'license' => 'unknown',
    ];

    $newpackage = $fs->create_file_from_pathname($fileinfo, $uploadedfile['tmp_name']);

    // Keep backwards-compatible preview/index extraction when package contains website structure.
    $mainfile = false;
    try {
        $contentslist = exeweb_package::expand_package($newpackage);
        $mainfile = exeweb_package::get_mainfile($contentslist, $newpackage->get_contextid());
    } catch (Throwable $e) {
        /* ELPX may not include a web entrypoint; ignore content extraction errors. */
    }

    if ($mainfile !== false) {
        file_set_sortorder(
            $context->id,
            'mod_exeweb',
            'content',
            0,
            $mainfile->get_filepath(),
            $mainfile->get_filename(),
            1
        );
        $exeweb->entrypath = $mainfile->get_filepath();
        $exeweb->entryname = $mainfile->get_filename();
    }

    $exeweb->revision = $newrevision;
    $exeweb->timemodified = time();
    $exeweb->usermodified = $USER->id;
    $DB->update_record('exeweb', $exeweb);

    // Delete old package revisions only after successful save.
    $packagefiles = $fs->get_area_files($context->id, 'mod_exeweb', 'package', false, 'itemid, filepath, filename', false);
    foreach ($packagefiles as $storedfile) {
        if ((int)$storedfile->get_itemid() !== $newrevision) {
            $storedfile->delete();
        }
    }

    echo json_encode([
        'success' => true,
        'revision' => $exeweb->revision,
        'format' => $format,
    ]);
} catch (Throwable $e) {
    if ($newpackage) {
        $newpackage->delete();
    }
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ]);
}
