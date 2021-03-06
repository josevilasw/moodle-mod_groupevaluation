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
 * This file keeps track of upgrades to the groupevaluation module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package    mod_groupevaluation
 * @copyright  Jose Vilas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute groupevaluation upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_groupevaluation_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.


    if ($oldversion < 2017040501) {

        // Define field timecreated to be added to groupevaluation.
        $table = new xmldb_table('groupevaluation_tags');
        $field = new xmldb_field('position', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, false, null, '0');

        // Add field timecreated.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Another save point reached.
        upgrade_mod_savepoint(true, 2017040501, 'groupevaluation');
    }

    /*
     * And that's all. Please, examine and understand the 3 example blocks above. Also
     * it's interesting to look how other modules are using this script. Remember that
     * the basic idea is to have "blocks" of code (each one being executed only once,
     * when the module version (version.php) is updated.
     *
     * Lines above (this included) MUST BE DELETED once you get the first version of
     * yout module working. Each time you need to modify something in the module (DB
     * related, you'll raise the version and add one upgrade block here.
     *
     * Finally, return of upgrade result (true, all went good) to Moodle.
     */
    return true;
}
