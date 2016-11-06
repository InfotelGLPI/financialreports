ALTER TABLE `glpi_plugin_state_profiles`
  DROP COLUMN `interface`,
  DROP COLUMN `is_default`;

DROP TABLE IF EXISTS `glpi_plugin_state_repelled`;
CREATE TABLE `glpi_plugin_state_repelled` (
  `ID`            INT(11) NOT NULL AUTO_INCREMENT,
  `FK_device`     INT(11) NOT NULL DEFAULT '0',
  `device_type`   INT(11) NOT NULL DEFAULT '0',
  `date_repelled` DATE    NULL     DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_device` (`FK_device`, `device_type`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;