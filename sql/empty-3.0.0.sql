DROP TABLE IF EXISTS `glpi_plugin_financialreports_configs`;
CREATE TABLE `glpi_plugin_financialreports_configs` (
  `id`        int unsigned NOT NULL AUTO_INCREMENT,
  `states_id` int unsigned NOT NULL DEFAULT '0'
  COMMENT 'RELATION to glpi_states (id)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `glpi_plugin_financialreports_parameters`;
CREATE TABLE `glpi_plugin_financialreports_parameters` (
  `id`                            int unsigned NOT NULL        AUTO_INCREMENT,
  `computers_otherserial`         VARCHAR(255)
                                  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notebooks_otherserial`         VARCHAR(255)
                                  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servers_otherserial`           VARCHAR(255)
                                  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monitors_otherserial`          VARCHAR(255)
                                  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `printers_otherserial`          VARCHAR(255)
                                  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peripherals_otherserial`       VARCHAR(255)
                                  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `networkequipments_otherserial` VARCHAR(255)
                                  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phones_otherserial`            VARCHAR(255)
                                  COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `glpi_plugin_financialreports_parameters` (`computers_otherserial`, `notebooks_otherserial`, `servers_otherserial`, `monitors_otherserial`, `printers_otherserial`, `peripherals_otherserial`, `networkequipments_otherserial`, `phones_otherserial`)
VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
