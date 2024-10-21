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
 * Define all the backup steps that will be used by the backup_exeweb_activity_task
 *
 * @package    mod_exeweb
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Define the complete exeweb structure for backup, with file and id annotations
 */
class backup_exeweb_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo.
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated.
        $exeweb = new backup_nested_element('exeweb', ['id'], [
            'name', 'intro', 'introformat', 'tobemigrated', 'display',
            'displayoptions', 'filterfiles', 'entrypath', 'entryname',
            'revision', 'timecreated', 'timemodified', 'usermodified']);

        // Build the tree (none).

        // Define sources.
        $exeweb->set_source_table('exeweb', ['id' => backup::VAR_ACTIVITYID ]);

        // Define id annotations (none).

        // Define file annotations.
        $exeweb->annotate_files('mod_exeweb', 'intro', null); // This file areas haven't itemid.
        $exeweb->annotate_files('mod_exeweb', 'package', null); // This file areas haven't itemid.
        $exeweb->annotate_files('mod_exeweb', 'content', null); // This file areas haven't itemid.

        // Return the root element (exeweb), wrapped into standard activity structure.
        return $this->prepare_activity_structure($exeweb);
    }
}
