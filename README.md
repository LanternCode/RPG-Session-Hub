
```SQL
ALTER TABLE `sessions` ADD `quotes_all` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotes`, ADD `goddice` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotes_all`, ADD `goddice_all` BOOLEAN NOT NULL DEFAULT FALSE AFTER `goddice`;

CREATE TABLE `sessions`.`staff` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `name` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `password` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `rank` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `ticket_permissions` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`)) ENGINE = MyISAM;

ALTER TABLE `staff` ADD `admin_id` INT(10) NOT NULL AFTER `id`;

ALTER TABLE `tickets` ADD `status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `message`;

CREATE TABLE `sessions`.`ranks` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `rankID` INT(10) NULL DEFAULT NULL , `rankName` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `rankColour` VARCHAR(7) NULL DEFAULT NULL , `ticket` BOOLEAN NOT NULL DEFAULT FALSE , `browseSessions` BOOLEAN NOT NULL DEFAULT FALSE , `editSessions` BOOLEAN NOT NULL DEFAULT FALSE , `banUsers` BOOLEAN NOT NULL DEFAULT FALSE , `unbanUsers` BOOLEAN NOT NULL DEFAULT FALSE , `checkUsers` BOOLEAN NOT NULL DEFAULT FALSE , `contactUsers` BOOLEAN NOT NULL DEFAULT FALSE , `grantLowerRanks` BOOLEAN NOT NULL DEFAULT FALSE , `grantHigherRanks` BOOLEAN NOT NULL DEFAULT FALSE , `manageRanks` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`)) ENGINE = MyISAM;

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '1', 'Project Manager', '#f3bf1b', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '2', 'Admin', '#ef1111', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0');

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '3', 'Mod', '#21d10f', '1', '1', '1', '1', '0', '1', '0', '0', '0', '0');

ALTER TABLE `ranks` ADD `checkAllUsers` BOOLEAN NOT NULL DEFAULT FALSE AFTER `checkUsers`;

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `checkAllUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '4', 'Helper', '#2ba1ea', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `checkAllUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '5', 'User', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

TODO list:

1. Default avatars
2. How many rolls to display? Time limited?
