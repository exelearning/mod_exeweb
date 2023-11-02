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
 * Private exeweb module utility functions
 *
 * @package    mod_exeweb
 * @copyright  2009 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

use mod_exeweb\exeweb_package;

require_once("$CFG->libdir/filelib.php");
require_once("$CFG->libdir/resourcelib.php");
require_once("$CFG->dirroot/mod/exeweb/lib.php");

/**
 * Display embedded exeweb file.
 * @param object $exeweb
 * @param object $cm
 * @param object $course
 * @param stored_file $file main file
 * @return does not return
 */
function exeweb_display_embed($exeweb, $cm, $course, $file) {
    global $PAGE, $OUTPUT;

    $clicktoopen = exeweb_get_clicktoopen($file, $exeweb->revision);

    $context = context_module::instance($cm->id);
    $moodleurl = moodle_url::make_pluginfile_url($context->id, 'mod_exeweb', 'content', $exeweb->revision,
            $file->get_filepath(), $file->get_filename());

    $mimetype = $file->get_mimetype();
    $title    = $exeweb->name;

    // We need a way to discover if we are loading remote docs inside an iframe.
    $moodleurl->param('embed', 1);

    // Anything else - just try object tag enlarged as much as possible.
    $code = resourcelib_embed_general($moodleurl, $title, $clicktoopen, $mimetype);

    // Let the module handle the display.
    $PAGE->activityheader->set_description(exeweb_get_intro($exeweb, $cm));

    exeweb_print_header($exeweb, $cm, $course);

    echo format_text($code, FORMAT_HTML, ['noclean' => true]);

    echo $OUTPUT->footer();
    die;
}

/**
 * Display exeweb frames.
 * @param object $exeweb
 * @param object $cm
 * @param object $course
 * @param stored_file $file main file
 * @return does not return
 */
function exeweb_display_frame($exeweb, $cm, $course, $file) {
    global $PAGE, $OUTPUT, $CFG;

    $frame = optional_param('frameset', 'main', PARAM_ALPHA);

    if ($frame === 'top') {
        $PAGE->set_pagelayout('frametop');
        $PAGE->activityheader->set_description(exeweb_get_intro($exeweb, $cm, true));
        exeweb_print_header($exeweb, $cm, $course);
        echo $OUTPUT->footer();
        die;

    } else {
        $config = get_config('exeweb');
        $context = context_module::instance($cm->id);
        $fileurl = moodle_url::make_pluginfile_url($context->id, 'mod_exeweb', 'content', $exeweb->revision,
                        $file->get_filepath(), $file->get_filename());
        $navurl = "$CFG->wwwroot/mod/exeweb/view.php?id=$cm->id&amp;frameset=top";
        $title = strip_tags(format_string($course->shortname.': '.$exeweb->name));
        $framesize = $config->framesize;
        $contentframetitle = s(format_string($exeweb->name));
        $modulename = s(get_string('modulename', 'mod_exeweb'));
        $dir = get_string('thisdirection', 'langconfig');

        $file = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html dir="$dir">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>$title</title>
  </head>
  <frameset rows="$framesize,*">
    <frame src="$navurl" title="$modulename" />
    <frame src="$fileurl" title="$contentframetitle" />
  </frameset>
</html>
EOF;

        @header('Content-Type: text/html; charset=utf-8');
        echo $file;
        die;
    }
}

/**
 * Internal function - create click to open text with link.
 */
function exeweb_get_clicktoopen($file, $revision, $extra='') {
    global $CFG;

    $filename = $file->get_filename();
    $fullurl = moodle_url::make_pluginfile_url($file->get_contextid(), 'mod_exeweb', 'content', $revision,
                $file->get_filepath(), $filename);

    $string = get_string('clicktoopen2', 'mod_exeweb', "<a href=\"$fullurl\" $extra>$filename</a>");

    return $string;
}


/**
 * Print exeweb info and workaround link when JS not available.
 * @param object $exeweb
 * @param object $cm
 * @param object $course
 * @param stored_file $file main file
 * @return does not return
 */
function exeweb_print_workaround($exeweb, $cm, $course, $file) {
    global $CFG, $OUTPUT, $PAGE;

    // Let the module handle the display.
    $PAGE->activityheader->set_description(exeweb_get_intro($exeweb, $cm, true));

    exeweb_print_header($exeweb, $cm, $course);

    echo '<div class="exewebworkaround">';
    switch (exeweb_get_final_display_type($exeweb)) {
        case RESOURCELIB_DISPLAY_POPUP:
            $fullurl = moodle_url::make_pluginfile_url($file->get_contextid(), 'mod_exeweb', 'content', $exeweb->revision,
                            $file->get_filepath(), $file->get_filename());
                    $options = empty($exeweb->displayoptions) ? [] : (array) unserialize_array($exeweb->displayoptions);
            $width  = empty($options['popupwidth']) ? 620 : $options['popupwidth'];
            $height = empty($options['popupheight']) ? 450 : $options['popupheight'];
            $wh = "width=$width,height=$height,toolbar=no,location=no,menubar=no,copyhistory=no,"
                    . "status=no,directories=no,scrollbars=yes,resizable=yes";
            $extra = "onclick=\"window.open('$fullurl', '', '$wh'); return false;\"";
            echo exeweb_get_clicktoopen($file, $exeweb->revision, $extra);
            break;

        case RESOURCELIB_DISPLAY_NEW:
            $extra = 'onclick="this.target=\'_blank\'"';
            echo exeweb_get_clicktoopen($file, $exeweb->revision, $extra);
            break;

        case RESOURCELIB_DISPLAY_OPEN:
        default:
            echo exeweb_get_clicktoopen($file, $exeweb->revision);
            break;
    }
    echo '</div>';

    echo $OUTPUT->footer();
    die;
}

/**
 * Print exeweb header.
 * @param object $exeweb
 * @param object $cm
 * @param object $course
 * @return void
 */
function exeweb_print_header($exeweb, $cm, $course) {
    global $PAGE, $OUTPUT;

    $PAGE->set_title($course->shortname.': '.$exeweb->name);
    $PAGE->set_heading($course->fullname);
    $PAGE->set_activity_record($exeweb);
    echo $OUTPUT->header();
}

/**
 * Gets details of the file to cache in course cache to be displayed using {@link exeweb_get_optional_details()}
 *
 * @param object $exeweb Exeweb table row (only property 'displayoptions' is used here)
 * @param object $cm Course-module table row
 * @return string Size and type or empty string if show options are not enabled
 */
function exeweb_get_file_details($exeweb, $cm) {
    $options = empty($exeweb->displayoptions) ? [] : (array) unserialize_array($exeweb->displayoptions);
    $filedetails = [];
    if (!empty($options['showsize']) || !empty($options['showtype']) || !empty($options['showdate'])) {
        $context = context_module::instance($cm->id);
        $fs = get_file_storage();
        $mainfile = $fs->get_file($context->id, 'mod_exeweb', 'content', 0, $exeweb->entrypath, $exeweb->entryname);

        if (!empty($options['showsize'])) {
            $filedetails['size'] = 0;
            $files = $fs->get_area_files($context->id, 'mod_exeweb', 'content', 0, 'id', false);
            foreach ($files as $file) {
                // This will also synchronize the file size for external files if needed.
                $filedetails['size'] += $file->get_filesize();
                if ($file->get_repository_id()) {
                    // If file is a reference the 'size' attribute can not be cached.
                    $filedetails['isref'] = true;
                }
            }
        }
        if (!empty($options['showtype'])) {
            if ($mainfile) {
                $filedetails['type'] = get_mimetype_description($mainfile);
                $filedetails['mimetype'] = $mainfile->get_mimetype();
                // Only show type if it is not unknown.
                if ($filedetails['type'] === get_mimetype_description('document/unknown')) {
                    $filedetails['type'] = '';
                }
            } else {
                $filedetails['type'] = '';
            }
        }
        if (!empty($options['showdate'])) {
            if ($mainfile) {
                // Modified date may be up to several minutes later than uploaded date just because
                // teacher did not submit the form promptly. Give teacher up to 5 minutes to do it.
                if ($mainfile->get_timemodified() > $mainfile->get_timecreated() + 5 * MINSECS) {
                    $filedetails['modifieddate'] = $mainfile->get_timemodified();
                } else {
                    $filedetails['uploadeddate'] = $mainfile->get_timecreated();
                }
                if ($mainfile->get_repository_id()) {
                    // If main file is a reference the 'date' attribute can not be cached.
                    $filedetails['isref'] = true;
                }
            } else {
                $filedetails['uploadeddate'] = '';
            }
        }
    }
    return $filedetails;
}

/**
 * Gets optional details for a exeweb, depending on exeweb settings.
 *
 * Result may include the file size and type if those settings are chosen,
 * or blank if none.
 *
 * @param object $exeweb Exeweb table row (only property 'displayoptions' is used here)
 * @param object $cm Course-module table row
 * @return string Size and type or empty string if show options are not enabled
 */
function exeweb_get_optional_details($exeweb, $cm) {
    global $DB;

    $details = '';

    $options = empty($exeweb->displayoptions) ? [] : (array) unserialize_array($exeweb->displayoptions);
    if (!empty($options['showsize']) || !empty($options['showtype']) || !empty($options['showdate'])) {
        if (!array_key_exists('filedetails', $options)) {
            $filedetails = exeweb_get_file_details($exeweb, $cm);
        } else {
            $filedetails = $options['filedetails'];
        }
        $size = '';
        $type = '';
        $date = '';
        $langstring = '';
        $infodisplayed = 0;
        if (!empty($options['showsize'])) {
            if (!empty($filedetails['size'])) {
                $size = display_size($filedetails['size']);
                $langstring .= 'size';
                $infodisplayed += 1;
            }
        }
        if (!empty($options['showtype'])) {
            if (!empty($filedetails['type'])) {
                $type = $filedetails['type'];
                $langstring .= 'type';
                $infodisplayed += 1;
            }
        }
        if (!empty($options['showdate']) && (!empty($filedetails['modifieddate']) || !empty($filedetails['uploadeddate']))) {
            if (!empty($filedetails['modifieddate'])) {
                $date = get_string('modifieddate', 'mod_exeweb', userdate($filedetails['modifieddate'],
                    get_string('strftimedatetimeshort', 'langconfig')));
            } else if (!empty($filedetails['uploadeddate'])) {
                $date = get_string('uploadeddate', 'mod_exeweb', userdate($filedetails['uploadeddate'],
                    get_string('strftimedatetimeshort', 'langconfig')));
            }
            $langstring .= 'date';
            $infodisplayed += 1;
        }

        if ($infodisplayed > 1) {
            $details = get_string("exewebdetails_{$langstring}", 'mod_exeweb',
                    (object)['size' => $size, 'type' => $type, 'date' => $date]);
        } else {
            // Only one of size, type and date is set, so just append.
            $details = $size . $type . $date;
        }
    }

    return $details;
}

/**
 * Get exeweb introduction.
 *
 * @param object $exeweb
 * @param object $cm
 * @param bool $ignoresettings print even if not specified in modedit
 * @return string
 */
function exeweb_get_intro(object $exeweb, object $cm, bool $ignoresettings = false): string {
    $options = empty($exeweb->displayoptions) ? [] : (array) unserialize_array($exeweb->displayoptions);

    $extraintro = exeweb_get_optional_details($exeweb, $cm);
    if ($extraintro) {
        // Put a paragaph tag around the details.
        $extraintro = html_writer::tag('p', $extraintro, ['class' => 'exewebdetails']);
    }

    $content = "";
    if ($ignoresettings || !empty($options['printintro']) || $extraintro) {
        $gotintro = !html_is_blank($exeweb->intro);
        if ($gotintro || $extraintro) {
            if ($gotintro) {
                $content = format_module_intro('exeweb', $exeweb, $cm->id);
            }
            $content .= $extraintro;
        }
    }

    return $content;
}


/**
 * Print warning that file can not be found.
 * @param object $exeweb
 * @param object $cm
 * @param object $course
 * @return void, does not return
 */
function exeweb_print_filenotfound($exeweb, $cm, $course) {
    global $DB, $OUTPUT, $PAGE;
    $PAGE->activityheader->set_description(exeweb_get_intro($exeweb, $cm));
    exeweb_print_header($exeweb, $cm, $course);
    echo $OUTPUT->notification(get_string('filenotfound', 'mod_exeweb'));
    echo $OUTPUT->footer();
    die;
}

/**
 * Decide the best display format.
 * @param object $exeweb
 * @return int display type constant
 */
function exeweb_get_final_display_type($exeweb) {
    global $CFG, $PAGE;

    if ($exeweb->display != RESOURCELIB_DISPLAY_AUTO) {
        return $exeweb->display;
    }

    return RESOURCELIB_DISPLAY_EMBED;
}

/**
 * File browsing support class
 */
class exeweb_content_file_info extends file_info_stored {
    public function get_parent() {
        if ($this->lf->get_filepath() === '/' && $this->lf->get_filename() === '.') {
            return $this->browser->get_file_info($this->context);
        }
        return parent::get_parent();
    }
    public function get_visible_name() {
        if ($this->lf->get_filepath() === '/' && $this->lf->get_filename() === '.') {
            return $this->topvisiblename;
        }
        return parent::get_visible_name();
    }
}
