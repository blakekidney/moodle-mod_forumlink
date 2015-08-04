<?php

/**
 * @package    mod_forumlink
 * @subpackage backup-moodle2
 * @copyright 2015 Blake Kidney
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Define all the restore steps that will be used by the restore_forumlink_activity_task
 */

/**
 * Structure step to restore one forumlink activity
 */
class restore_forumlink_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $paths[] = new restore_path_element('forumlink', '/activity/forumlink');

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_forumlink($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();
		
		if(empty($data->timecreated)) {
            $data->timecreated = time();
        }

        if(empty($data->timemodified)) {
            $data->timemodified = time();
        }

        // insert the forumlink record
        $newitemid = $DB->insert_record('forumlink', $data);
        // immediately after inserting "activity" record, call this
        $this->apply_activity_instance($newitemid);
    }

    protected function after_execute() {
        // Add forumlink related files, no need to match by itemname (just internally handled context)
        $this->add_related_files('mod_forumlink', 'intro', null);
    }
}
