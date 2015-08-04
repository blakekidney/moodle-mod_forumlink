<?php

/**
 * Define all the backup steps that will be used by the backup_forumlink_activity_task
 *
 * @package    mod_forumlink
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

 /**
 * Define the complete forumlink structure for backup, with file and id annotations
 */
class backup_forumlink_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        //the forumlink module stores no user info

        // Define each element separated
        $forumlink = new backup_nested_element('forumlink', array('id'), array(
            'forumid', 'name', 'intro', 'introformat', 'timemodified'));


        // Build the tree
        //nothing here for forumlinks

        // Define sources
        $forumlink->set_source_table('forumlink', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations
        //module has no id annotations

        // Define file annotations
        //$forumlink->annotate_files('mod_forumlink', 'intro', null); // This file area hasn't itemid

        // Return the root element (forumlink), wrapped into standard activity structure
        return $this->prepare_activity_structure($forumlink);

    }
}
