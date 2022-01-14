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


include('../../../inc/includes.php');

Session::checkCentralAccess();

if (!isset($_POST["start"])) $_POST["start"] = 0;
if (!isset($_POST["is_deleted"])) $_POST["is_deleted"] = "0";
if (isset($_POST["display_type"])) {

   if ($_POST["display_type"] < 0) {
      $_POST["display_type"] = -$_POST["display_type"];
      $_POST["export_all"] = 1;
   }

   $display = ['displaypc' => $_SESSION["displaypc"],
      'displaynotebook' => $_SESSION["displaynotebook"],
      'displayserver' => $_SESSION["displayserver"],
      'displaymonitor' => $_SESSION["displaymonitor"],
      'displayprinter' => $_SESSION["displayprinter"],
      'displaynetworking' => $_SESSION["displaynetworking"],
      'displayperipheral' => $_SESSION["displayperipheral"],
      'displayphone' => $_SESSION["displayphone"],
      'displaydisposal' => $_SESSION["displaydisposal"]];

   $report = new PluginFinancialreportsFinancialreport();
   $report->displayReport($_POST, $display);

}
