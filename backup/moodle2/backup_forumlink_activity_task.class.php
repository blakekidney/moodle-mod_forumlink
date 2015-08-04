<?php

/**
 * Defines backup_forumlink_activity_task class
 *
 * @package     mod_forumlink
 * @category    backup
 * @copyright   2015 Blake Kidney
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/forumlink/backup/moodle2/backup_forumlink_stepslib.php');

/**
 * Provides all the settings and steps to perform one complete backup of the activity
 */
class backup_forumlink_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the forumlink.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_forumlink_activity_structure_step('forumlink_structure', 'forumlink.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        
		$base = preg_quote($CFG->wwwroot.'/mod/forumlink','#');

        //Access a list of all links in a course
        $pattern = '#('.$base.'/index\.php\?id=)([0-9]+)#';
        $replacement = '$@FORUMLINKINDEX*$2@$';
        $content = preg_replace($pattern, $replacement, $content);

        //Access the link supplying a course module id
        $pattern = '#('.$base.'/view\.php\?id=)([0-9]+)#';
        $replacement = '$@FORUMLINKVIEWBYID*$2@$';
        $content = preg_replace($pattern, $replacement, $content);

        //Access the link supplying an instance id
        $pattern = '#('.$base.'/view\.php\?u=)([0-9]+)#';
        $replacement = '$@FORUMLINKVIEWBYU*$2@$';
        $content = preg_replace($pattern, $replacement, $content);
		
		return $content;
    }
}
