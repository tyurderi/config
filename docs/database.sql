CREATE TABLE `config` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `parent_id` INT(11) DEFAULT NULL,
  `label` VARCHAR(32) NOT NULL,
  `name` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `config`
  ADD CONSTRAINT `fk_config_config`
    FOREIGN KEY (`parent_id`) REFERENCES `config` (`id`);

CREATE TABLE `config_field` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `config_id` INT(11) NOT NULL,
  `label` VARCHAR(32) NOT NULL,
  `name` VARCHAR(32) NOT NULL,
  `field_type` TEXT NOT NULL,
  PRIMARY KEY(`id`)
);

ALTER TABLE `config_field`
  ADD CONSTRAINT `fk_config_field_config`
    FOREIGN KEY (`config_id`) REFERENCES `config` (`id`);

CREATE TABLE `config_column` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `config_id` INT(11) NOT NULL,
  `config_field_id` INT(11) NOT NULL,
  PRIMARY KEY(`id`)
);

ALTER TABLE `config_column`
  ADD CONSTRAINT `fk_config_column_config`
    FOREIGN KEY (`config_id`) REFERENCES `config` (`id`),
  ADD CONSTRAINT `fk_config_column_config_field`
    FOREIGN KEY (`config_field_id`) REFERENCES `config_field` (`id`);