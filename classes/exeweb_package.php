<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * exeweb url manager class.
 *
 * @package     mod_exeweb
 * @category    exeweb
 * @copyright   2023 3&Punt
 * @author      Juan Carrera <juan@treipunt.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_exeweb;

class exeweb_package {

    /**
     * Check that a Zip file contains a valid exeweb package
     *
     * @param \stored_file $file A Zip file.
     * @return array empty if no issue is found. Array of error message otherwise
     */
    public static function validate_package(\stored_file $file) {
        $errors = [];

        $mimetype = $file->get_mimetype();
        if ($mimetype !== 'application/zip') {
            $errors['packagefile'] = get_string('badexelearningpackage', 'mod_exeweb');
            return $errors;
        }

        $packer = get_file_packer('application/zip');
        if ($file->is_external_file()) { // Get zip file so we can check it is correct.
            $file->import_external_file_contents();
        }
        $filelist = $file->list_files($packer);

        if (!is_array($filelist)) {
            $errors['packagefile'] = get_string('badexelearningpackage', 'mod_exeweb');
            return $errors;
        }

        $errors = self::validate_file_list($filelist);

        return $errors;
    }


    /**
     * Validate against mandatory and forbidden files config setting.
     *
     * @param array $filelist
     * @return array
     */
    public static function validate_file_list(array $filelist) : array {
        $errors = [];

        $config = get_config('exeweb');
        $forbiddenfileslist = $config->forbiddenfileslist ?? '';
        $forbiddenfilesrearray = explode("\n", $forbiddenfileslist);
        $forbiddenfilesrearray = array_filter(array_map('trim', $forbiddenfilesrearray));
        $mandatoryfileslist = $config->mandatoryfileslist ?? '';
        $mandatoryfilesrearray = explode("\n", $mandatoryfileslist);
        $mandatoryfilesrearray = array_filter(array_map('trim', $mandatoryfilesrearray));

        // Get path names to check against.
        $filepaths = array_column($filelist, 'pathname', 'pathname');
        $firstitem = reset($filelist);
        $insidedirectory = $firstitem->is_directory ?? false;
        if ($insidedirectory) {
            $dirname = $firstitem->pathname;
            $pattern = '#^' . $dirname. '#';
            $filepaths = preg_replace($pattern, '', $filepaths);
        }
        // Check for mandatory files. Return as soon as any mandatory RE is mising.
        foreach ($mandatoryfilesrearray as $mfre) {
            $found = preg_grep($mfre, $filepaths);
            if (empty($found)) {
                $errors['packagefile'] = get_string('badexelearningpackage', 'mod_exeweb');
                return $errors;
            }
            // We unset mandatory files, so can be an exception for forbidden ones.
            foreach ($found as $key => $unused) {
                unset($filepaths[$key]);
            }
        }
        // Check for forbidden paths. Return as soon as any forbidden RE is found.
        foreach ($forbiddenfilesrearray as $ffre) {
            if (preg_grep($ffre, $filepaths)) {
                $errors['packagefile'] = get_string('badexelearningpackage', 'mod_exeweb');
                return $errors;
            }
        }
        return $errors;
    }

    /**
     * Extracts web zip package. Sets main file.
     * Called whenever exeweb changes.
     *
     * @param \stored_file $package
     * @return array|bool List of extracted files or false on error.
     */
    public static function expand_package($package) {
        // Clean old files in content area if any.
        $fs = get_file_storage();
        $fs->delete_area_files($package->get_contextid(), 'mod_exeweb', 'content');

        // Now extract files.
        $packer = get_file_packer('application/zip');
        $result = $package->extract_to_storage($packer, $package->get_contextid(), 'mod_exeweb', 'content', 0, '/');

        return $result;
    }

    /**
     * Saves uploaded package from draft area to module's.
     *
     * @param object $data
     * @return \stored_file|bool The stored package file or false.
     */
    public static function save_draft_file(object $data) {
        $fs = get_file_storage();
        $cmid = $data->coursemodule;
        $draftitemid = $data->packagefile;

        $context = \context_module::instance($cmid);
        if ($draftitemid) {
            $options = ['subdirs' => false, 'embed' => false];
            if ($data->display == RESOURCELIB_DISPLAY_EMBED) {
                $options['embed'] = true;
            }
            file_save_draft_area_files($draftitemid, $context->id, 'mod_exeweb', 'package', 0, $options);
        }
        $files = $fs->get_area_files($context->id, 'mod_exeweb', 'package', 0, '', false);
        $package = reset($files);
        return $package;
    }


    /**
     * Sets entry file from package contents by setting the sortorder.
     *
     * @param array $contentlist
     * @param integer $contextid
     * @return boolean
     */
    public static function set_mainfile(array $contentlist, int $contextid): bool {
        if (empty($contentlist)) {
            return false;
        }
        $mainfilenames = ['index.html', 'index.htm', ];
        $fs = get_file_storage();
        $filepath = '/';
        $firstfile = key($contentlist);
        if (mb_substr($firstfile, -1) === '/') {
            $filepath = '/' . $firstfile;
        }
        // Find main file and set it.
        foreach ($mainfilenames as $item) {
            $mainfile = $fs->get_file($contextid, 'mod_exeweb', 'content', 0, $filepath, $item);
            if ($mainfile !== false) {
                file_set_sortorder($contextid, 'mod_exeweb', 'content', 0, $mainfile->get_filepath(), $mainfile->get_filename(), 1);
                return true;
            }
        }
        return false;
    }

}
