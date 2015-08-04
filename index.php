<?php
/**
 * List of forum links in course
 *
 * @package    mod_forumlink
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$id = required_param('id', PARAM_INT); // course id

$course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);

require_course_login($course, true);
$PAGE->set_pagelayout('incourse');

$params = array(
    'context' => context_course::instance($course->id)
);
$event = \mod_forumlink\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

$strforumlink       = get_string('modulename', 'forumlink');
$strforumlinks      = get_string('modulenameplural', 'forumlink');
$strname         = get_string('name');
$strintro        = get_string('moduleintro');
$strlastmodified = get_string('lastmodified');

$PAGE->set_url('/mod/forumlink/index.php', array('id' => $course->id));
$PAGE->set_title($course->shortname.': '.$strforumlinks);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add($strforumlinks);
echo $OUTPUT->header();
echo $OUTPUT->heading($strforumlinks);

if (!$forumlinks = get_all_instances_in_course('forumlink', $course)) {
    notice(get_string('thereareno', 'moodle', $strforumlinks), "$CFG->wwwroot/course/view.php?id=$course->id");
    exit;
}

$usesections = course_format_uses_sections($course->format);

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_'.$course->format);
    $table->head  = array ($strsectionname, $strname, $strintro);
    $table->align = array ('center', 'left', 'left');
} else {
    $table->head  = array ($strlastmodified, $strname, $strintro);
    $table->align = array ('left', 'left', 'left');
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($forumlinks as $forumlink) {
    $cm = $modinfo->cms[$forumlink->coursemodule];
    if ($usesections) {
        $printsection = '';
        if ($forumlink->section !== $currentsection) {
            if ($forumlink->section) {
                $printsection = get_section_name($course, $forumlink->section);
            }
            if ($currentsection !== '') {
                $table->data[] = 'hr';
            }
            $currentsection = $forumlink->section;
        }
    } else {
        $printsection = '<span class="smallinfo">'.userdate($forumlink->timemodified)."</span>";
    }

    $extra = empty($cm->extra) ? '' : $cm->extra;
    $icon = '';
    if (!empty($cm->icon)) {
        // each forumlink has an icon in 2.0
        $icon = '<img src="'.$OUTPUT->pix_url($cm->icon).'" class="activityicon" alt="'.get_string('modulename', $cm->modname).'" /> ';
    }

    $class = $forumlink->visible ? '' : 'class="dimmed"'; // hidden modules are dimmed
    $table->data[] = array (
        $printsection,
        "<a $class $extra href=\"view.php?id=$cm->id\">".$icon.format_string($forumlink->name)."</a>",
        format_module_intro('forumlink', $forumlink, $cm->id));
}

echo html_writer::table($table);

echo $OUTPUT->footer();
