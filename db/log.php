<?php

/**
 * Definition of log events
 *
 * @package    mod_forumlink
 * @category   log
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$logs = array(
    array('module'=>'forumlink', 'action'=>'view', 'mtable'=>'forumlink', 'field'=>'name'),
    array('module'=>'forumlink', 'action'=>'view all', 'mtable'=>'forumlink', 'field'=>'name'),
    array('module'=>'forumlink', 'action'=>'update', 'mtable'=>'forumlink', 'field'=>'name'),
    array('module'=>'forumlink', 'action'=>'add', 'mtable'=>'forumlink', 'field'=>'name'),
);