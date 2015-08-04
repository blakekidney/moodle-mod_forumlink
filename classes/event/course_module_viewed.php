<?php
/**
 * The mod_forumlink course module viewed event.
 *
 * @package    mod_forumlink
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forumlink\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The mod_forumlink course module viewed event class.
 *
 * @package    mod_forumlink
 * @since      Moodle 2.9
 * @copyright  2015 Blake Kidney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'forumlink';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }
}
