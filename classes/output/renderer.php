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
 * Defines the renderer for the exeweb module.
 *
 * @package mod_exeweb
 * @copyright   2023 3&Punt
 * @author      Juan Carrera <juan@treipunt.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_exeweb\output;

use context_course;
use context_module;
use mod_exeweb\exeonline\exeonline_redirector;
use moodle_url;

/**
 * The renderer for the exeweb module.
 *
 * @copyright 2013 Dan Marsden
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends \plugin_renderer_base {

    /**
     * Generate the exeweb's action bar
     *
     * @param \stdClass $cm The course module viewed.
     * @return string
     */
    public function generate_action_bar(\stdClass $cm): string {
        $context = [];
        $hascapability = has_capability('moodle/course:update', context_course::instance($cm->course));

        if ($hascapability) {
            if (exeweb_online_editor_available()) {
                $returnto = new moodle_url('/mod/exeweb/view.php', ['id' => $cm->id, 'forceview' => 1]);
                $context['editaction'] = exeonline_redirector::get_redirection_url($cm->id, $returnto)->out(false);
            } else if (exeweb_embedded_editor_available()) {
                $context = array_merge($context, $this->get_embedded_editor_context($cm));
            }
        }

        return $this->render_from_template('mod_exeweb/action_bar', $context);
    }

    /**
     * Returns file embedding html.
     *
     * @param \stdClass $cm
     * @param \moodleurl|string $fullurl
     * @param string $title
     * @param string $clicktoopen
     * @return string html
     */
    public function generate_embed_general(\stdClass $cm, $fullurl, $title, $clicktoopen): string {
        $context = [];
        $context['fullurl'] = ($fullurl instanceof moodle_url) ? $fullurl->out() : $fullurl;
        $context['title'] = s($title);
        $context['clicktoopen'] = $clicktoopen;

        $hascapability = has_capability('moodle/course:update', context_course::instance($cm->course));
        if ($hascapability) {
            if (exeweb_online_editor_available()) {
                $returnto = new moodle_url('/mod/exeweb/view.php', ['id' => $cm->id, 'forceview' => 1]);
                $context['editaction'] = exeonline_redirector::get_redirection_url($cm->id, $returnto)->out(false);
            } else if (exeweb_embedded_editor_available()) {
                $context = array_merge($context, $this->get_embedded_editor_context($cm, s($title)));
            }
        }

        return $this->render_from_template('mod_exeweb/embed_general', $context);
    }

    /**
     * Build context needed by embedded editor modal.
     *
     * @param \stdClass $cm
     * @param string|null $activityname
     * @return array<string, mixed>
     */
    private function get_embedded_editor_context(\stdClass $cm, ?string $activityname = null): array {
        global $DB;

        $modulecontext = context_module::instance($cm->id);
        $exeweb = $DB->get_record('exeweb', ['id' => $cm->instance], '*', MUST_EXIST);
        $packageurl = \exeweb_get_package_url($exeweb, $modulecontext);

        return [
            'editorurl' => (new moodle_url('/mod/exeweb/editor/index.php', [
                'id' => $cm->id,
                'sesskey' => sesskey(),
            ]))->out(false),
            'saveurl' => (new moodle_url('/mod/exeweb/editor/save.php'))->out(false),
            'packageurl' => $packageurl ? $packageurl->out(false) : '',
            'sesskey' => sesskey(),
            'cmid' => $cm->id,
            'activityname' => $activityname ?? format_string($exeweb->name),
        ];
    }
}
