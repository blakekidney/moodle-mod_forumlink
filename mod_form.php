<?php

/**
 * The main forumlink configuration form.
 *
 * @package    mod_forumlink
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 *
 * @package    mod_forumlink
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_forumlink_mod_form extends moodleform_mod {
    
    /**
     * Defines forms elements
	 * @see: https://docs.moodle.org/dev/lib/formslib.php_Form_Definition
     */
    function definition() {
        global $DB, $COURSE;
        
		//----------------------------------------------------
		//Pull the list of forums from the database.
		$forums = array('0' => 'Please select a forum.');
		$results = $DB->get_records(
			'forum', 							//table
			array('course' => $COURSE->id), 	//conditions
			'name', 							//sort
			'id, type, name'					//fields
		);
		if($results) {
			foreach($results as $row) {
				$forums[$row->id] = $row->name;
			}
		}		
		
		//----------------------------------------------------
		$mform = $this->_form;
		
		//----------------------------------------------------
		// Adding the "general" fieldset, where all the common settings are showed.
        $mform->addElement('header', 'general', get_string('general', 'form'));

		//----------------------------------------------------
        // Adding the standard "name" field.
        $mform->addElement(
			'text',										//type of element 
			'name', 									//name of the element
			get_string('forumlinkname', 'forumlink'), 	//label
			array('size' => '64')						//html attributes
		);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
		$mform->addHelpButton('name', 'forumlinkname', 'forumlink');
		
		//----------------------------------------------------
		// Adding the select for the forum
		$mform->addElement(
			'select', 									//type of element 
			'forumid', 									//name of the element
			get_string('forumlinkforum', 'forumlink'), 	//label
			$forums 									//array of options for the select box
		);
		$mform->setType('forumid', PARAM_INT);
		$mform->addRule('forumid', null, 'required', null, 'client');
		$mform->addHelpButton('forumid', 'forumlinkforum', 'forumlink');
		
		//----------------------------------------------------
        // Add standard elements, common to all modules.
        $this->standard_coursemodule_elements();

		//----------------------------------------------------
        // Add standard buttons, common to all modules.
        $this->add_action_buttons();
        
    }

    function data_preprocessing(&$default_values) {
        
    }

}
