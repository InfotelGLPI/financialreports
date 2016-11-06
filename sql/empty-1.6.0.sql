DROP TABLE IF EXISTS `glpi_plugin_state_profiles`;
CREATE TABLE `glpi_plugin_state_profiles` (
  `ID`    INT(11) NOT NULL AUTO_INCREMENT,
  `name`  VARCHAR(255)     DEFAULT NULL,
  `state` CHAR(1)          DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `name` (`name`)
) ENGINE = MyISAM;

DROP TABLE IF EXISTS `glpi_plugin_state_config`;
CREATE TABLE `glpi_plugin_state_config` (
  `ID`    INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `state` INT(11) NOT NULL
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

DROP TABLE IF EXISTS `glpi_plugin_state_parameters`;
CREATE TABLE `glpi_plugin_state_parameters` (
  `ID`         INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `computer`   VARCHAR(50),
  `notebook`   VARCHAR(50),
  `server`     VARCHAR(50),
  `monitor`    VARCHAR(50),
  `printer`    VARCHAR(50),
  `peripheral` VARCHAR(50),
  `networking` VARCHAR(50),
  `phone`      VARCHAR(50)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

INSERT INTO `glpi_plugin_state_parameters` (`computer`, `notebook`, `server`, `monitor`, `printer`, `peripheral`, `networking`, `phone`)
VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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