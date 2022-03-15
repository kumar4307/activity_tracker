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
 *
 * @package    block_activity_tracker
 * @author     kumar jaganmaya <kumar.jaganmaya@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once('locallib.php');

class block_activity_tracker extends block_list {
    public function init() {
        $this->title = get_string('pluginname', 'block_activity_tracker');
    }

    public function get_content() {
        global $CFG;

        if ($this->content !== null) {
            return $this->content;
        } // if

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array('');
        $this->content->footer = '';
        require_once($CFG->dirroot.'/course/lib.php');

        $course = $this->page->course;
        $modinfo = get_fast_modinfo($course);
        $modules = $modinfo->cms;
        foreach ($modules as $cmodule) {

            if (!$cmodule->uservisible || !$cmodule->has_view()) {
                continue;
            } // if

            $moduletype = $cmodule->modname;
            $creationtime = block_activity_tracker_get_creation_time($cmodule);
            $completionstatus = block_activity_tracker_get_activity_completion_status($cmodule->id);

            $this->content->items[] = '<a href="'.$CFG->wwwroot.'/mod/'.$moduletype.'/view.php?id='.$cmodule->id.'">'
                                            .$cmodule->id.' - '.$cmodule->name.' - '.$creationtime.' - '.$completionstatus.'</a>';
            $this->content->items[] = '<hr/>';
        }// foreach

        return $this->content;
    }
    /*
     * Block Rendering scope defination start
    */
    public function applicable_formats() {
        return array('all' => false, 'mod' => false, 'my' => false, 'admin' => false,
        'tag' => false, 'course-view' => true);
    } // end
}
