ALTER TABLE `glpi_plugin_state_parameters`
  ADD `monitor` VARCHAR(50)
  AFTER `server`;
ALTER TABLE `glpi_plugin_state_parameters`
  ADD `phone` VARCHAR(50)
  AFTER `networking`;