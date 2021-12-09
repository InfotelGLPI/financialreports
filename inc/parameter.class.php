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
 * Class PluginFinancialreportsParameter
 */
class PluginFinancialreportsParameter extends CommonDBTM {

   function showParameterForm() {

      $this->getFromDB('1');
      echo "<div align='center'>";
      echo "<form method='post' action=\"./config.form.php\">";
      echo "<table class='tab_cadre' cellpadding='5'>";
      echo "<tr>";
      echo "<th colspan='2'>" . __('Identification parameters of inventory number', 'financialreports') . "</th>";
      echo "</tr>";
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . _n('Computer', 'Computers', 2) . "</td>";
      echo "<td>";
      echo Html::input('computers_otherserial', ['value' => $this->fields['computers_otherserial'], 'size' => 40]);
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td>" . _n('Notebook', 'Notebooks', 2, 'financialreports') . "</td>";
      echo "<td>";
      echo Html::input('notebooks_otherserial', ['value' => $this->fields['notebooks_otherserial'], 'size' => 40]);
      echo "</td></tr>";
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . _n('Server', 'Servers', 2, 'financialreports') . "</td>";
      echo "<td>";
      echo Html::input('servers_otherserial', ['value' => $this->fields['servers_otherserial'], 'size' => 40]);
      echo "</td></tr>";
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . _n('Monitor', 'Monitors', 2) . "</td>";
      echo "<td>";
      echo Html::input('monitors_otherserial', ['value' => $this->fields['monitors_otherserial'], 'size' => 40]);
      echo "</td></tr>";
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . _n('Printer', 'Printers', 2) . "</td>";
      echo "<td>";
      echo Html::input('printers_otherserial', ['value' => $this->fields['printers_otherserial'], 'size' => 40]);
      echo "</td></tr>";
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . _n('Device', 'Devices', 2) . "</td>";
      echo "<td>";
      echo Html::input('peripherals_otherserial', ['value' => $this->fields['peripherals_otherserial'], 'size' => 40]);
      echo "</td></tr>";
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . _n('Network device', 'Network devices', 2) . "</td>";
      echo "<td>";
      echo Html::input('networkequipments_otherserial', ['value' => $this->fields['networkequipments_otherserial'], 'size' => 40]);
      echo "</td></tr>";
      echo "<tr class='tab_bg_1'>";
      echo "<td>" . _n('Phone', 'Phones', 2) . "</td>";
      echo "<td>";
      echo Html::input('phones_otherserial', ['value' => $this->fields['phones_otherserial'], 'size' => 40]);
      echo "</td></tr>";
      echo "<tr class='tab_bg_1'>";
      echo "<td colspan='2' class='center'>";
      echo Html::hidden('id', ['value' => $this->fields["id"]]);
      echo Html::submit(_sx('button', 'Post'), ['name' => 'update_parameters', 'class' => 'btn btn-primary']);
      echo "</td></tr>";
      echo "</table>";
      Html::closeForm();
      echo "</div>";
   }
}
