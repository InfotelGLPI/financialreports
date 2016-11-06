ALTER TABLE `glpi_plugin_state_profiles`
  RENAME `glpi_plugin_financialreports_profiles`;
ALTER TABLE `glpi_plugin_state_config`
  RENAME `glpi_plugin_financialreports_configs`;
ALTER TABLE `glpi_plugin_state_parameters`
  RENAME `glpi_plugin_financialreports_parameters`;
ALTER TABLE `glpi_plugin_state_repelled`
  RENAME `glpi_plugin_financialreports_disposalitems`;

ALTER TABLE `glpi_plugin_financialreports_profiles`
  CHANGE `ID` `id` INT(11) NOT NULL AUTO_INCREMENT,
  ADD `profiles_id` INT(11) NOT NULL DEFAULT '0'
COMMENT 'RELATION to glpi_profiles (id)',
  CHANGE `state` `financialreports` CHAR(1)
COLLATE utf8_unicode_ci DEFAULT NULL,
  ADD INDEX (`profiles_id`);

ALTER TABLE `glpi_plugin_financialreports_configs`
  CHANGE `ID` `id` INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE `state` `states_id` INT(11) NOT NULL DEFAULT '0'
COMMENT 'RELATION to glpi_states (id)';

ALTER TABLE `glpi_plugin_financialreports_parameters`
  CHANGE `ID` `id` INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE `computer` `computers_otherserial` VARCHAR(255)
COLLATE utf8_unicode_ci DEFAULT NULL,
  CHANGE `notebook` `notebooks_otherserial` VARCHAR(255)
COLLATE utf8_unicode_ci DEFAULT NULL,
  CHANGE `server` `servers_otherserial` VARCHAR(255)
COLLATE utf8_unicode_ci DEFAULT NULL,
  CHANGE `monitor` `monitors_otherserial` VARCHAR(255)
COLLATE utf8_unicode_ci DEFAULT NULL,
  CHANGE `printer` `printers_otherserial` VARCHAR(255)
COLLATE utf8_unicode_ci DEFAULT NULL,
  CHANGE `peripheral` `peripherals_otherserial` VARCHAR(255)
COLLATE utf8_unicode_ci DEFAULT NULL,
  CHANGE `networking` `networkequipments_otherserial` VARCHAR(255)
COLLATE utf8_unicode_ci DEFAULT NULL,
  CHANGE `phone` `phones_otherserial` VARCHAR(255)
COLLATE utf8_unicode_ci DEFAULT NULL;

ALTER TABLE `glpi_plugin_financialreports_disposalitems`
  CHANGE `ID` `id` INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE `FK_device` `items_id` INT(11) NOT NULL DEFAULT '0'
COMMENT 'RELATION to various tables, according to itemtype (id)',
  CHANGE `device_type` `itemtype` VARCHAR(100)
COLLATE utf8_unicode_ci NOT NULL
COMMENT 'see .class.php file',
  CHANGE `date_repelled` `date_disposal` DATE DEFAULT NULL,
  DROP INDEX `FK_device`,
  ADD UNIQUE `unicity` (`items_id`, `itemtype`);