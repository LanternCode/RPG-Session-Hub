
```SQL

CREATE TABLE `sessions`.`staff` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `name` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `password` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `rank` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , `ticket_permissions` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `sessions`.`tickets` ( `id` INT NOT NULL AUTO_INCREMENT , `session_id` INT NOT NULL , `title` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL , `message` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `sessions`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL , `email` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL , `password` VARCHAR(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL , `registeredDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM;

ALTER TABLE `staff` ADD `admin_id` INT(10) NOT NULL AFTER `id`;

ALTER TABLE `sessions` ADD `quotes_all` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotes`, ADD `goddice` BOOLEAN NOT NULL DEFAULT FALSE AFTER `quotes_all`, ADD `goddice_all` BOOLEAN NOT NULL DEFAULT FALSE AFTER `goddice`;

ALTER TABLE `tickets` ADD `status` BOOLEAN NOT NULL DEFAULT FALSE AFTER `message`;

CREATE TABLE `sessions`.`ranks` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `rankID` INT(10) NULL DEFAULT NULL , `rankName` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `rankColour` VARCHAR(7) NULL DEFAULT NULL , `ticket` BOOLEAN NOT NULL DEFAULT FALSE , `browseSessions` BOOLEAN NOT NULL DEFAULT FALSE , `editSessions` BOOLEAN NOT NULL DEFAULT FALSE , `banUsers` BOOLEAN NOT NULL DEFAULT FALSE , `unbanUsers` BOOLEAN NOT NULL DEFAULT FALSE , `checkUsers` BOOLEAN NOT NULL DEFAULT FALSE , `contactUsers` BOOLEAN NOT NULL DEFAULT FALSE , `grantLowerRanks` BOOLEAN NOT NULL DEFAULT FALSE , `grantHigherRanks` BOOLEAN NOT NULL DEFAULT FALSE , `manageRanks` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`)) ENGINE = MyISAM;

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '1', 'Project Manager', '#f3bf1b', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '2', 'Admin', '#ef1111', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0');

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '3', 'Mod', '#21d10f', '1', '1', '1', '1', '0', '1', '0', '0', '0', '0');

ALTER TABLE `ranks` ADD `checkAllUsers` BOOLEAN NOT NULL DEFAULT FALSE AFTER `checkUsers`;

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `checkAllUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '4', 'Helper', '#2ba1ea', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');

INSERT INTO `ranks` (`id`, `rankID`, `rankName`, `rankColour`, `ticket`, `browseSessions`, `editSessions`, `banUsers`, `unbanUsers`, `checkUsers`, `checkAllUsers`, `contactUsers`, `grantLowerRanks`, `grantHigherRanks`, `manageRanks`) VALUES (NULL, '5', 'User', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

ALTER TABLE `quotes` ADD `session_id` INT NOT NULL AFTER `quote`;

UPDATE quotes SET session_id = 35;

ALTER TABLE `participants` CHANGE `p_id` `id` INT(11) NOT NULL;

ALTER TABLE `participants` DROP PRIMARY KEY;

ALTER TABLE `participants` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

ALTER TABLE `participants` CHANGE `id` `userId` INT(11) NOT NULL;

ALTER TABLE `users` CHANGE `password` `password` VARCHAR(258) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;

CREATE TABLE `sessions`.`invites` ( `id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL , `sessionId` INT NOT NULL , `status` INT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci COMMENT = 'status: 0 -> send, 1 -> accepted, 2 -> rejected';

CREATE TABLE `sessions`.`avatars` ( `id` INT NOT NULL , `URL` VARCHAR NOT NULL , `usedBy` INT NOT NULL DEFAULT '0' , `classId` INT NOT NULL DEFAULT '0' , `templateId` INT NOT NULL DEFAULT '0' ) ENGINE = MyISAM;

ALTER TABLE `tickets` CHANGE `session_id` `senderEmail` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;

--

ALTER TABLE `staff` DROP `ticket_permissions`;

ALTER TABLE `staff` CHANGE `rank` `rank` INT(1) NOT NULL DEFAULT '4';

ALTER TABLE `sessions` CHANGE `type` `archival` BOOLEAN NOT NULL DEFAULT FALSE;

ALTER TABLE `rolls` ADD `dice` VARCHAR(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL AFTER `session_id`;

ALTER TABLE `users` ADD `passwordResetKey` INT(255) NULL DEFAULT NULL AFTER `registeredDate`;

ALTER TABLE `users` CHANGE `passwordResetKey` `passwordResetKey` VARCHAR(255) NULL DEFAULT NULL;

---

ALTER TABLE `users` ADD `tag` INT(4) NOT NULL AFTER `username`;
ALTER TABLE `users` CHANGE `tag` `tag` VARCHAR(4) NOT NULL;

TODO list:

1. Archived sessions
2. Add custom dices, separate the tables
3. Session visitation
5. Change styles to grid
7. Invite by user tags and not emails
9. Show a vanishing popup presenting roll result
10. force refresh on roll instead of an iframe?

Completed Tasks list:

4. Remember password
6. User Tags
