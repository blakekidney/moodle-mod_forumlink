<?php

/**
 * Mandatory public API of forumlink module
 *
 * @package    mod_forumlink
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * List of features supported in URL module
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, false if not, null if doesn't know
 */
function forumlink_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_ASSIGNMENT;  //Type of module
		//yes
        case FEATURE_BACKUP_MOODLE2:          return true;		//True if module supports backup/restore of moodle2 format
        case FEATURE_MOD_INTRO:               return true;		//True if module supports intro editor
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;		//True if module supports groupmembersonly
		//no
        case FEATURE_NO_VIEW_LINK:            return false;		//True if module has no 'view' page
		case FEATURE_IDNUMBER:                return false;		//True if module supports outcomes	
        case FEATURE_GROUPS:                  return false;		//True if module supports groups
        case FEATURE_GROUPINGS:               return false;		//True if module supports groupings
        case FEATURE_GRADE_HAS_GRADE:         return false;		//True if module can provide a grade
        case FEATURE_GRADE_OUTCOMES:          return false;		//True if module supports outcomes
        case FEATURE_SHOW_DESCRIPTION:        return false;		//True if module can show description on course main page

        default: return null;
    }
}


/**
 * Add forumlink instance.
 * @param object $data
 * @param object $mform
 * @return int new forumlink instance id
 */
function forumlink_add_instance($data, $mform) {
    global $DB;
    
	$data->intro = $data->name;
	$data->introformat = 0;
	$data->timecreated = time();
    $data->timemodified = time();
    $data->id = $DB->insert_record('forumlink', $data);

    return $data->id;
}

/**
 * Update forumlink instance.
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function forumlink_update_instance($data, $mform) {
    global $DB;
	
	$data->intro = $data->name;
	$data->introformat = 0;
    $data->timemodified = time();
    $result = $DB->update_record('forumlink', $data);

    return $result;
}

/**
 * Delete forumlink instance.
 * @param int $id
 * @return bool true
 */
function forumlink_delete_instance($id) {
    global $DB;

    if (!$forumlink = $DB->get_record('forumlink', array('id'=>$id))) {
        return false;
    }

    $DB->delete_records('forumlink', array('id'=>$forumlink->id));

    return true;
}


/**
 * Returns all other caps used in module
 * @return array
 */
function forumlink_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * @param $data the data submitted from the reset course.
 * @return array status array
 */
function forumlink_reset_userdata($data) {
    return array();
}

/**
 * List the actions that correspond to a view of this module.
 * This is used by the participation report.
 *
 * Note: This is not used by new logging system. Event with
 *       crud = 'r' and edulevel = LEVEL_PARTICIPATING will
 *       be considered as view action.
 *
 * @return array
 */
function forumlink_get_view_actions() {
    return array('view', 'view all');
}

/**
 * List the actions that correspond to a post of this module.
 * This is used by the participation report.
 *
 * Note: This is not used by new logging system. Event with
 *       crud = ('c' || 'u' || 'd') and edulevel = LEVEL_PARTICIPATING
 *       will be considered as post action.
 *
 * @return array
 */
function forumlink_get_post_actions() {
    return array('update', 'add');
}


/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 *
 * See {@link get_array_of_activities()} in course/lib.php
 *
 * @param object $coursemodule
 * @return cached_cm_info info
 */
 /*
function forumlink_get_coursemodule_info($coursemodule) {
    global $DB, $CFG;
   
    if(!$forumlink = $DB->get_record('forumlink', array('id'=>$coursemodule->instance),
            'id, forumid, name')) {
        return NULL;
    }

    $info = new cached_cm_info();
    $info->name = $forumlink->name;
	
	//$link = $CFG->wwwroot.'/mod/forumlink/view.php?f='.$forumlink->forumid;
    	
	
    //if ($coursemodule->showdescription) {
        // Convert intro to html. Do not filter cached version, filters run at display time.
    //    $info->content = format_module_intro('forumlink', $forumlink, $coursemodule->id, false);
    //}
	

    return $info;
}
*/
