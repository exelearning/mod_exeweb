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

use mod_exeweb\exeonline\exeonline_redirector;
use mod_exeweb\exeweb_package;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/exeweb/locallib.php');
require_once($CFG->libdir.'/filelib.php');

class mod_exeweb_mod_form extends moodleform_mod {
    public function definition() {
        global $CFG, $PAGE;

        $PAGE->requires->jQuery();
        $PAGE->requires->js_call_amd('mod_exeweb/modform', 'init');
        $mform = $this->_form;

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

        // Package section.
        $mform->addElement('header', 'packagehdr', get_string('packagehdr', 'mod_exeweb'));
        $mform->setExpanded('packagehdr', true);

        $editmode = !empty($this->_instance);
        // Package types.
        $exeorigins = [
            EXEWEB_ORIGIN_LOCAL => get_string('typelocal', 'mod_exeweb'),
        ];
        $defaulttype = EXEWEB_ORIGIN_LOCAL;
        if (!empty($config->exeonlinebaseuri) && !empty($config->hmackey1)) {
            if ($editmode) {
                $exeorigins[EXEWEB_ORIGIN_EXEONLINE] = get_string('typeexewebedit', 'mod_exeweb');
            } else {
                $exeorigins[EXEWEB_ORIGIN_EXEONLINE] = get_string('typeexewebcreate', 'mod_exeweb');
                $defaulttype = EXEWEB_ORIGIN_EXEONLINE;
            }
        }

        // Package origin.
        $mform->addElement('select', 'exeorigin', get_string('exeorigin', 'mod_exeweb'), $exeorigins);
        $mform->setDefault('exeorigin', $defaulttype);
        $mform->setType('exeorigin', PARAM_ALPHA);
        $mform->addHelpButton('exeorigin', 'exeorigin', 'exeweb');
        // Workarround to hide static element.
        $group = [];
        $staticelement = $mform->createElement('static', 'onlinetypehelp', '',
                                                get_string('exeweb:onlinetypehelp', 'mod_exeweb'));
        $staticelement->updateAttributes(['class' => 'font-weight-bold']);
        $group[] = $staticelement;
        $mform->addGroup($group, 'typehelpgroup', '', ' ', false);
        $mform->hideIf('typehelpgroup', 'exeorigin', 'noteq', EXEWEB_ORIGIN_EXEONLINE);
        // New local package upload.
        $filemanageroptions = [];
        $filemanageroptions['accepted_types'] = ['.zip' ];
        $filemanageroptions['maxbytes'] = 0;
        $filemanageroptions['maxfiles'] = 1;
        $filemanageroptions['subdirs'] = 0;

        $mform->addElement('filepicker', 'packagefile', get_string('package', 'mod_exeweb'), null, $filemanageroptions);
        $mform->addHelpButton('packagefile', 'package', 'exeweb');
        $mform->hideIf('packagefile', 'exeorigin', 'noteq', EXEWEB_ORIGIN_LOCAL);
        // End of package section.

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

        $mform->addElement('checkbox', 'showdate', get_string('showdate', 'mod_exeweb'));
        $mform->setDefault('showdate', $config->showdate);
        $mform->addHelpButton('showdate', 'showdate', 'exeweb');

        if (array_key_exists(RESOURCELIB_DISPLAY_POPUP, $options)) {
            $mform->addElement('text', 'popupwidth', get_string('popupwidth', 'mod_exeweb'), ['size' => 3 ]);
            if (count($options) > 1) {
                $mform->hideIf('popupwidth', 'display', 'noteq', RESOURCELIB_DISPLAY_POPUP);
            }
            $mform->setType('popupwidth', PARAM_INT);
            $mform->setDefault('popupwidth', $config->popupwidth);
            $mform->setAdvanced('popupwidth', true);

            $mform->addElement('text', 'popupheight', get_string('popupheight', 'mod_exeweb'), ['size' => 3 ]);
            if (count($options) > 1) {
                $mform->hideIf('popupheight', 'display', 'noteq', RESOURCELIB_DISPLAY_POPUP);
            }
            $mform->setType('popupheight', PARAM_INT);
            $mform->setDefault('popupheight', $config->popupheight);
            $mform->setAdvanced('popupheight', true);
        }

        if (array_key_exists(RESOURCELIB_DISPLAY_EMBED, $options) ||
          array_key_exists(RESOURCELIB_DISPLAY_FRAME, $options)) {
            $mform->addElement('checkbox', 'printintro', get_string('printintro', 'mod_exeweb'));
            $mform->hideIf('printintro', 'display', 'eq', RESOURCELIB_DISPLAY_POPUP);
            $mform->hideIf('printintro', 'display', 'eq', RESOURCELIB_DISPLAY_OPEN);
            $mform->hideIf('printintro', 'display', 'eq', RESOURCELIB_DISPLAY_NEW);
            $mform->setDefault('printintro', $config->printintro);
        }

        $options = ['0' => get_string('none'), '1' => get_string('allfiles'), '2' => get_string('htmlfilesonly') ];
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
            $draftitemid = file_get_submitted_draft_itemid('packagefile');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_exeweb', 'package',
                                    false, ['subdirs' => false, 'maxfiles' => 1 ]);
            $defaultvalues['packagefile'] = $draftitemid;
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

        $type = $data['exeorigin'];

        if ($type === EXEWEB_ORIGIN_LOCAL ) {
            if (empty($data['packagefile'])) {
                $errors['packagefile'] = get_string('required');
            } else {
                $draftitemid = $data['packagefile'];

                // Get file from users draft area.
                $usercontext = context_user::instance($USER->id);
                $fs = get_file_storage();
                $files = $fs->get_area_files($usercontext->id, 'user', 'draft', $draftitemid, 'sortorder, id', false);

                if (!$files) {
                    $errors['packagefile'] = get_string('required');
                } else {
                    $file = reset($files);
                    // Validate this exeweb package.
                    $errors = array_merge($errors, exeweb_package::validate_package($file));
                }

            }
        } else if ($type !== EXEWEB_ORIGIN_EXEONLINE) {
            $errors['exeorigin'] = get_string('invalidpackage', 'mod_exeweb');
        }

        return $errors;
    }

    /**
     * Allows module to modify the data returned by form get_data().
     * This method is also called in the bulk activity completion form.
     *
     * Only available on moodleform_mod.
     *
     * @param stdClass $data the form data to be modified.
     */
    public function data_postprocessing($data) {
        parent::data_postprocessing($data);

        // Hack to get redirected to eXeLearning Online to edit package.
        if ($data->exeorigin === EXEWEB_ORIGIN_EXEONLINE ) {
            if (! isset($data->showgradingmanagement)) {
                if (isset($data->submitbutton)) {
                    // Return to activity. If it this a new activity we don't have a coursemodule yet. We'll fix it in redirector.
                    $returnto = new moodle_url("/mod/exeweb/view.php", ['id' => $data->coursemodule, 'forceview' => 1]);
                } else {
                    // Return to course.
                    $returnto = course_get_url($data->course, $data->coursesection ?? null, ['sr' => $data->sr]);
                }
                // Set this becouse modedit.php expects it.
                $data->submitbutton = true;
                // If send template is true, we'll always make an edition. On new activities,
                // It will send default/uploaded template to eXeLearning.
                $sendtemplate = get_config('exeweb', 'sendtemplate');
                $action = ($sendtemplate || ! empty($data->update)) ? 'edit' : 'add';
                $data->showgradingmanagement = true;
                $data->gradingman = new exeonline_redirector($action, $returnto);
            }
        }
    }
}
