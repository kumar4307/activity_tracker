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
 * @package    block_activity_tracker
 * @author     kumar jaganmaya <kumar.jaganmaya@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function block_activity_tracker_get_creation_time($module) {
    global $DB;
    $moduledetails = $DB->get_record('course_modules', array('id' => $module->id), 'id, instance, added');
    return gmdate("d-M-Y", $moduledetails->added);
}

function block_activity_tracker_get_activity_completion_status($cmid) {
    global $DB, $USER;

    $completionstatus = $DB->get_record('course_modules_completion', array('coursemoduleid' => $cmid, 'userid' => $USER->id));
    if ($completionstatus) {
        $completionstate = $completionstatus->completionstate;
        switch ($completionstate) {
            case 1:
            case 2:
            case 3:
               return get_string('completed', 'block_activity_tracker');
               break;
            default:
            return get_string('incomplete', 'block_activity_tracker');
        } // switch
    } else {
        return get_string('incomplete', 'block_activity_tracker');
    } // else
}
