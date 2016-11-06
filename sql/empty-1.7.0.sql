DROP TABLE IF EXISTS `glpi_plugin_financialreports_profiles`;
CREATE TABLE `glpi_plugin_financialreports_profiles` (
  `id`               INT(11) NOT NULL        AUTO_INCREMENT,
  `profiles_id`      INT(11) NOT NULL        DEFAULT '0'
  COMMENT 'RELATION to glpi_profiles (id)',
  `financialreports` CHAR(1)
                     COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_id` (`profiles_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_financialreports_configs`;
CREATE TABLE `glpi_plugin_financialreports_configs` (
  `id`        INT(11) NOT NULL AUTO_INCREMENT,
  `states_id` INT(11) NOT NULL DEFAULT '0'
  COMMENT 'RELATION to glpi_states (id)',
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_financialreports_parameters`;
CREATE TABLE `glpi_plugin_financialreports_parameters` (
  `id`                            INT(11) NOT NULL        AUTO_INCREMENT,
  `computers_otherserial`         VARCHAR(255)
                                  COLLATE utf8_unicode_ci DEFAULT NULL,
  `notebooks_otherserial`         VARCHAR(255)
                                  COLLATE utf8_unicode_ci DEFAULT NULL,
  `servers_otherserial`           VARCHAR(255)
                                  COLLATE utf8_unicode_ci DEFAULT NULL,
  `monitors_otherserial`          VARCHAR(255)
                                  COLLATE utf8_unicode_ci DEFAULT NULL,
  `printers_otherserial`          VARCHAR(255)
                                  COLLATE utf8_unicode_ci DEFAULT NULL,
  `peripherals_otherserial`       VARCHAR(255)
                                  COLLATE utf8_unicode_ci DEFAULT NULL,
  `networkequipments_otherserial` VARCHAR(255)
                                  COLLATE utf8_unicode_ci DEFAULT NULL,
  `phones_otherserial`            VARCHAR(255)
                                  COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

INSERT INTO `glpi_plugin_financialreports_parameters` (`computers_otherserial`, `notebooks_otherserial`, `servers_otherserial`, `monitors_otherserial`, `printers_otherserial`, `peripherals_otherserial`, `networkequipments_otherserial`, `phones_otherserial`)
VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

DROP TABLE IF EXISTS `glpi_plugin_financialreports_disposalitems`;
CREATE TABLE `glpi_plugin_financialreports_disposalitems` (
  `id`            INT(11)                 NOT NULL AUTO_INCREMENT,
  `items_id`      INT(11)                 NOT NULL DEFAULT '0'
  COMMENT 'RELATION to various tables, according to itemtype (id)',
  `itemtype`      VARCHAR(100)
                  COLLATE utf8_unicode_ci NOT NULL
  COMMENT 'see .class.php file',
  `date_disposal` DATE                             DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unicity` (`items_id`, `itemtype`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;