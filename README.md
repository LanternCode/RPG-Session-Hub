
```SQL
ALTER TABLE `sessions` ADD `quotes_all` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotes`, ADD `goddice` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotes_all`, ADD `goddice_all` BOOLEAN NOT NULL DEFAULT FALSE AFTER `goddice`;

CREATE TABLE `sessions`.`staff` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `name` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `password` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `rank` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `ticket_permissions` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`)) ENGINE = MyISAM;

ALTER TABLE `staff` ADD `admin_id` INT(10) NOT NULL AFTER `id`;

ALTER TABLE `tickets` ADD `status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `message`;

TODO list:

1. Default avatars
2. How many rolls to display? Time limited?
