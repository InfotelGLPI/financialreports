<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 financialreports plugin for GLPI
 Copyright (C) 2009-2022 by the financialreports Development Team.

 https://github.com/InfotelGLPI/financialreports
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of financialreports.

 financialreports is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 financialreports is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with financialreports. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

/**
 * @return bool
 */
function plugin_financialreports_install() {
   global $DB;

   include_once(PLUGIN_FINANCIALREPORTS_DIR . "/inc/profile.class.php");

   $update = false;
   if (!$DB->tableExists("glpi_plugin_state_profiles")
       && !$DB->tableExists("glpi_plugin_financialreports_configs")) {

      $DB->runFile(PLUGIN_FINANCIALREPORTS_DIR . "/sql/empty-3.0.0.sql");

   } else if ($DB->tableExists("glpi_plugin_state_parameters")
              && !$DB->fieldExists("glpi_plugin_state_parameters", "monitor")) {

      $update = true;
      $DB->runFile(PLUGIN_FINANCIALREPORTS_DIR . "/sql/update-1.5.sql");
      $DB->runFile(PLUGIN_FINANCIALREPORTS_DIR . "/sql/update-1.6.0.sql");
      $DB->runFile(PLUGIN_FINANCIALREPORTS_DIR . "/sql/update-1.7.0.sql");

   } else if ($DB->tableExists("glpi_plugin_state_profiles")
              && $DB->fieldExists("glpi_plugin_state_profiles", "interface")) {

      $update = true;
      $DB->runFile(PLUGIN_FINANCIALREPORTS_DIR . "/sql/update-1.6.0.sql");
      $DB->runFile(PLUGIN_FINANCIALREPORTS_DIR . "/sql/update-1.7.0.sql");

   } else if (!$DB->tableExists("glpi_plugin_financialreports_configs")) {

      $update = true;
      $DB->runFile(PLUGIN_FINANCIALREPORTS_DIR . "/sql/update-1.7.0.sql");

   }

   if ($update) {

      //Do One time on 0.78
      $query_  = "SELECT *
            FROM `glpi_plugin_financialreports_profiles` ";
      $result_ = $DB->query($query_);
      if ($DB->numrows($result_) > 0) {

         while ($data = $DB->fetchArray($result_)) {
            $query = "UPDATE `glpi_plugin_financialreports_profiles`
                  SET `profiles_id` = '" . $data["id"] . "'
                  WHERE `id` = '" . $data["id"] . "';";
            $DB->query($query);

         }
      }

      $query = "ALTER TABLE `glpi_plugin_financialreports_profiles`
               DROP `name` ;";
      $DB->query($query);

      Plugin::migrateItemType(
         [3450 => 'PluginFinancialreportsDisposalItem'],
         ["glpi_savedsearches", "glpi_savedsearches_users", "glpi_displaypreferences",
               "glpi_documents_items", "glpi_infocoms", "glpi_logs", "glpi_tickets"],
         ["glpi_plugin_financialreports_disposalitems"]);
   }

   //Migrate profiles to the new system
   PluginFinancialreportsProfile::initProfile();
   PluginFinancialreportsProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);

   $migration = new Migration("2.3.0");
   $migration->dropTable('glpi_plugin_financialreports_profiles');

   //2.3.0
   if ($DB->tableExists("glpi_plugin_financialreports_disposalitems")) {
      $query_  = "SELECT *
            FROM `glpi_plugin_financialreports_disposalitems` ";
      $result_ = $DB->query($query_);
      if ($DB->numrows($result_) > 0) {

         while ($data = $DB->fetchArray($result_)) {
            $query = "UPDATE `glpi_infocoms`
                  SET `decommission_date` = '" . $data["date_disposal"] . "'
                  WHERE `items_id` = '" . $data["items_id"] . "'
                        AND `itemtype` = '" . $data["itemtype"] . "';";
            $DB->query($query);

         }
      }
   }
   $migration->dropTable('glpi_plugin_financialreports_disposalitems');
   return true;
}

/**
 * @return bool
 */
function plugin_financialreports_uninstall() {
   global $DB;

   $tables = ["glpi_plugin_financialreports_configs",
                   "glpi_plugin_financialreports_parameters"];

   foreach ($tables as $table)
      $DB->query("DROP TABLE IF EXISTS `$table`;");

   //old versions	
   $tables = ["glpi_plugin_financialreports_profiles",
                   "glpi_plugin_state_profiles",
                   "glpi_plugin_state_config",
                   "glpi_plugin_state_parameters",
                   "glpi_plugin_state_repelled"];

   foreach ($tables as $table)
      $DB->query("DROP TABLE IF EXISTS `$table`;");

   //Delete rights associated with the plugin
   $profileRight = new ProfileRight();
   foreach (PluginFinancialreportsProfile::getAllRights() as $right) {
      $profileRight->deleteByCriteria(['name' => $right['field']]);
   }

   PluginFinancialreportsProfile::removeRightsFromSession();

   return true;
}


// Define database relations
/**
 * @return array
 */
function plugin_financialreports_getDatabaseRelations() {

   $plugin = new Plugin();

   if ($plugin->isActivated("financialreports"))
      return [
         "glpi_states" => ["glpi_plugin_financialreports_configs" => "states_id"]
      ];
   else
      return [];
}
