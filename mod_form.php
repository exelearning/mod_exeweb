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
 * Exeweb configuration form
 *
 * @package    mod_exeweb
 * @copyright  2023 3iPunt <contact@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/exeweb/locallib.php');
require_once($CFG->libdir.'/filelib.php');

class mod_exeweb_mod_form extends moodleform_mod {
    public function definition() {
        global $CFG, $DB;
        $mform =& $this->_form;

        $config = get_config('exeweb');

        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('name'), ['size' => '48']);
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $this->standard_intro_elements();
        $element = $mform->getElement('introeditor');
        $attributes = $element->getAttributes();
        $attributes['rows'] = 5;
        $element->setAttributes($attributes);
        $filemanageroptions = [];
        $filemanageroptions['accepted_types'] = '*';
        $filemanageroptions['maxbytes'] = 0;
        $filemanageroptions['maxfiles'] = -1;
        $filemanageroptions['mainfile'] = true;

        $mform->addElement('filemanager', 'files', get_string('selectfiles'), null, $filemanageroptions);

        // -------------------------------------------------------
        $mform->addElement('header', 'optionssection', get_string('appearance'));

        if ($this->current->instance) {
            $options = resourcelib_get_displayoptions(explode(',', $config->displayoptions), $this->current->display);
        } else {
            $options = resourcelib_get_displayoptions(explode(',', $config->displayoptions));
        }

        if (count($options) == 1) {
            $mform->addElement('hidden', 'display');
            $mform->setType('display', PARAM_INT);
            reset($options);
            $mform->setDefault('display', key($options));
        } else {
            $mform->addElement('select', 'display', get_string('displayselect', 'mod_exeweb'), $options);
            $mform->setDefault('display', $config->display);
            $mform->addHelpButton('display', 'displayselect', 'exeweb');
        }

        $mform->addElement('checkbox', 'showsize', get_string('showsize', 'mod_exeweb'));
        $mform->setDefault('showsize', $config->showsize);
        $mform->addHelpButton('showsize', 'showsize', 'exeweb');
        $mform->addElement('checkbox', 'showtype', get_string('showtype', 'mod_exeweb'));
        $mform->setDefault('showtype', $config->showtype);
        $mform->addHelpButton('showtype', 'showtype', 'exeweb');
        $mform->addElement('checkbox', 'showdate', get_string('showdate', 'mod_exeweb'));
        $mform->setDefault('showdate', $config->showdate);
        $mform->addHelpButton('showdate', 'showdate', 'exeweb');

        if (array_key_exists(RESOURCELIB_DISPLAY_POPUP, $options)) {
            $mform->addElement('text', 'popupwidth', get_string('popupwidth', 'mod_exeweb'), ['size' => 3, ]);
            if (count($options) > 1) {
                $mform->hideIf('popupwidth', 'display', 'noteq', RESOURCELIB_DISPLAY_POPUP);
            }
            $mform->setType('popupwidth', PARAM_INT);
            $mform->setDefault('popupwidth', $config->popupwidth);
            $mform->setAdvanced('popupwidth', true);

            $mform->addElement('text', 'popupheight', get_string('popupheight', 'mod_exeweb'), ['size' => 3, ]);
            if (count($options) > 1) {
                $mform->hideIf('popupheight', 'display', 'noteq', RESOURCELIB_DISPLAY_POPUP);
            }
            $mform->setType('popupheight', PARAM_INT);
            $mform->setDefault('popupheight', $config->popupheight);
            $mform->setAdvanced('popupheight', true);
        }

        if (array_key_exists(RESOURCELIB_DISPLAY_AUTO, $options) ||
          array_key_exists(RESOURCELIB_DISPLAY_EMBED, $options) ||
          array_key_exists(RESOURCELIB_DISPLAY_FRAME, $options)) {
            $mform->addElement('checkbox', 'printintro', get_string('printintro', 'mod_exeweb'));
            $mform->hideIf('printintro', 'display', 'eq', RESOURCELIB_DISPLAY_POPUP);
            $mform->hideIf('printintro', 'display', 'eq', RESOURCELIB_DISPLAY_DOWNLOAD);
            $mform->hideIf('printintro', 'display', 'eq', RESOURCELIB_DISPLAY_OPEN);
            $mform->hideIf('printintro', 'display', 'eq', RESOURCELIB_DISPLAY_NEW);
            $mform->setDefault('printintro', $config->printintro);
        }

        $options = ['0' => get_string('none'), '1' => get_string('allfiles'), '2' => get_string('htmlfilesonly'), ];
        $mform->addElement('select', 'filterfiles', get_string('filterfiles', 'mod_exeweb'), $options);
        $mform->setDefault('filterfiles', $config->filterfiles);
        $mform->setAdvanced('filterfiles', true);

        // -------------------------------------------------------
        $this->standard_coursemodule_elements();

        // -------------------------------------------------------
        $this->add_action_buttons();

        // -------------------------------------------------------
        $mform->addElement('hidden', 'revision');
        $mform->setType('revision', PARAM_INT);
        $mform->setDefault('revision', 1);
    }

    public function data_preprocessing(&$defaultvalues) {
        if ($this->current->instance) {
            $draftitemid = file_get_submitted_draft_itemid('files');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_exeweb', 'content', 0, ['subdirs' => true, ]);
            $defaultvalues['files'] = $draftitemid;
        }
        if (!empty($defaultvalues['displayoptions'])) {
            $displayoptions = (array) unserialize_array($defaultvalues['displayoptions']);
            if (isset($displayoptions['printintro'])) {
                $defaultvalues['printintro'] = $displayoptions['printintro'];
            }
            if (!empty($displayoptions['popupwidth'])) {
                $defaultvalues['popupwidth'] = $displayoptions['popupwidth'];
            }
            if (!empty($displayoptions['popupheight'])) {
                $defaultvalues['popupheight'] = $displayoptions['popupheight'];
            }
            if (!empty($displayoptions['showsize'])) {
                $defaultvalues['showsize'] = $displayoptions['showsize'];
            } else {
                // Must set explicitly to 0 here otherwise it will use system
                // default which may be 1.
                $defaultvalues['showsize'] = 0;
            }
            if (!empty($displayoptions['showtype'])) {
                $defaultvalues['showtype'] = $displayoptions['showtype'];
            } else {
                $defaultvalues['showtype'] = 0;
            }
            if (!empty($displayoptions['showdate'])) {
                $defaultvalues['showdate'] = $displayoptions['showdate'];
            } else {
                $defaultvalues['showdate'] = 0;
            }
        }
    }

    public function validation($data, $files) {
        global $USER;

        $errors = parent::validation($data, $files);

        $usercontext = context_user::instance($USER->id);
        $fs = get_file_storage();
        if (!$files = $fs->get_area_files($usercontext->id, 'user', 'draft', $data['files'], 'sortorder, id', false)) {
            $errors['files'] = get_string('required');
            return $errors;
        }
        if (count($files) == 1) {
            // No need to select main file if only one picked.
            return $errors;
        } else if (count($files) > 1) {
            $mainfile = false;
            foreach ($files as $file) {
                if ($file->get_sortorder() == 1) {
                    $mainfile = true;
                    break;
                }
            }
            // Set a default main file.
            if (!$mainfile) {
                $file = reset($files);
                file_set_sortorder($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(),
                                   $file->get_filepath(), $file->get_filename(), 1);
            }
        }
        return $errors;
    }
}
