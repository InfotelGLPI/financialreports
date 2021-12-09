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

define('PLUGIN_FINANCIALREPORTS_VERSION', '2.6.0');

// Init the hooks of the plugins -Needed
function plugin_init_financialreports() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['financialreports'] = true;
   $PLUGIN_HOOKS['change_profile']['financialreports'] =
      ['PluginFinancialreportsProfile', 'initProfile'];

   if (Session::getLoginUserID()) {

      Plugin::registerClass('PluginFinancialreportsProfile',
                            ['addtabon' => 'Profile']);

      if (Session::haveRight("plugin_financialreports", READ)) {

         $PLUGIN_HOOKS['reports']['financialreports']            =
            ['front/financialreport.php' => __('Report')];
         $PLUGIN_HOOKS['use_massive_action']['financialreports'] = 1;

      }

      if (Session::haveRight("plugin_financialreports", READ) || Session::haveRight("config", UPDATE)) {
         $PLUGIN_HOOKS['config_page']['financialreports'] = 'front/config.form.php';
      }
   }

}

// Get the name and the version of the plugin - Needed
/**
 * @return array
 */
function plugin_version_financialreports() {

   return [
      'name'           => _n('Financial report','Financial reports',2, 'financialreports'),
      'version'        => PLUGIN_FINANCIALREPORTS_VERSION,
      'oldname'        => 'state',
      'license'        => 'GPLv2+',
      'author'         => "<a href='http://blogglpi.infotel.com'>Infotel</a>",
      'homepage'       => 'https://github.com/InfotelGLPI/financialreports',
      'requirements'   => [
         'glpi' => [
            'min' => '10.0',
            'max' => '11.0',
            'dev' => false
         ]
      ]
   ];
}
