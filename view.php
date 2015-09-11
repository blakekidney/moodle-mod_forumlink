<?php

/**
 * Forumlink module main user interface
 *
 * @package    mod_forumlink
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once($CFG->libdir . '/completionlib.php');

$id       = optional_param('id', 0, PARAM_INT);        // Course module ID
$u        = optional_param('u', 0, PARAM_INT);         // forumlink instance id

if($u) {  // Two ways to specify the module
    $forumlink = $DB->get_record('forumlink', array('id'=>$u), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('forumlink', $forumlink->id, $forumlink->course, false, MUST_EXIST);

} else {
    $cm = get_coursemodule_from_id('forumlink', $id, 0, false, MUST_EXIST);
    $forumlink = $DB->get_record('forumlink', array('id'=>$cm->instance), '*', MUST_EXIST);
}

$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);

require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/forumlink:view', $context);

$params = array(
    'context' => $context,
    'objectid' => $forumlink->id
);
$event = \mod_forumlink\event\course_module_viewed::create($params);
$event->add_record_snapshot('course_modules', $cm);
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('forumlink', $forumlink);
$event->trigger();

// Update 'viewed' state if required by completion system
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

$PAGE->set_url('/mod/forumlink/view.php', array('id' => $cm->id));

//redirect to the forum page
redirect($CFG->wwwroot.'/mod/forum/view.php?f='.$forumlink->forumid);


