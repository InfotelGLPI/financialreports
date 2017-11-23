<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 financialreports plugin for GLPI
 Copyright (C) 2009-2016 by the financialreports Development Team.

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


if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

/**
 * Class PluginFinancialreportsConfig
 */
class PluginFinancialreportsConfig extends CommonDBTM {

   public static $rightname = 'plugin_financialreports';

   static function canPurge() {
      return Session::haveRight(self::$rightname, READ);
   }

   function showForm() {
      global $DB;

      $query = "SELECT * FROM
               `" . $this->getTable() . "`
               ORDER BY `states_id` ASC";

      $used = array();

      if ($result = $DB->query($query)) {
         $number = $DB->numrows($result);
         if ($number != 0) {

            $rand = mt_rand();
            echo "<div align='center'>";
            Html::openMassiveActionsForm('mass' . __CLASS__ . $rand);
            $massiveactionparams = ['item'             => __CLASS__,
                                    'specific_actions' => ['purge' => _x('button', 'Delete permanently')],
                                    'container'        => 'mass' . __CLASS__ . $rand];
            Html::showMassiveActions($massiveactionparams);

            echo "<table class='tab_cadre_fixe' cellpadding='5'>";
            echo "<tr>";
            echo "<th>" . Html::getCheckAllAsCheckbox('mass' . __CLASS__ . $rand) . "</th>";
            echo "<th>" . __('Status') . "</th>";
            echo "</tr>";
            while ($ligne = $DB->fetch_array($result)) {
               $used[$ligne["states_id"]] = $ligne["states_id"];

               echo "<tr class='tab_bg_1'>";
               echo "<td width='10'>";
               echo Html::showMassiveActionCheckBox(__CLASS__, $ligne["id"]);
               echo "</td>";
               echo "<td>" . Dropdown::getDropdownName("glpi_states", $ligne["states_id"]) . "</td>";
               echo "</tr>";
            }
            echo "</table></div>";

            $massiveactionparams['ontop'] = false;
            Html::showMassiveActions($massiveactionparams);
            Html::closeForm();

            echo "<div align='center'><form method='post' action='" . $this->getFormURL() . "'>";
            echo "<table class='tab_cadre_fixe' cellpadding='5'><tr ><th colspan='2'>";
            echo __('Disposal status', 'financialreports') . " : </th></tr>";
            echo "<tr class='tab_bg_1'><td>";
            Dropdown::show('State', array('name'  => "states_id",
                                          'used'  => $used,
                                          'value' => $ligne["states_id"]));
            echo "</td>";
            echo "<td>";
            echo "<div align='center'>";
            echo "<input type='submit' name='add_state' value='" . _sx('button', 'Post') . "' class='submit' >";
            echo "</div></td></tr>";
            echo "</table>";
            Html::closeForm();
            echo "</div>";

         } else {
            echo "<div align='center'><form method='post' action='" . $this->getFormURL() . "'>";
            echo "<table class='tab_cadre' cellpadding='5'><tr ><th colspan='2'>";
            echo __('Disposal status', 'financialreports') . " : </th></tr>";
            echo "<tr class='tab_bg_1'><td>";
            Dropdown::show('State', array('name' => "states_id"));
            echo "</td>";
            echo "<td>";
            echo "<div align='center'>";
            echo "<input type='submit' name='add_state' value='" . _sx('button', 'Post') . "' class='submit' >";
            echo "</div></td></tr>";
            echo "</table>";
            Html::closeForm();
            echo "</div>";
         }
      }
   }

}