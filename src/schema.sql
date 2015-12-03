CREATE TABLE `Test` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Name` varchar(255) NOT NULL,
	`Rowtypeid` INT NOT NULL,
	`Otvet` varchar(255) NOT NULL,
	`Authorid` INT NOT NULL,
	`Type` INT NOT NULL,
	PRIMARY KEY (`Id`)
);

CREATE TABLE `Rowtype` (
	`Id` INT NOT NULL,
	`Name` varchar(255) NOT NULL
);

CREATE TABLE `Users` (
	`Name` varchar(255) NOT NULL,
	`Id` INT NOT NULL,
	`Login` varchar(255) NOT NULL,
	`Parol` varchar(255) NOT NULL,
	`Email` varchar(255) NOT NULL,
	`Utypeid` INT NOT NULL,
	`Schoolid` INT NOT NULL,
	`Grade` varchar(3) NOT NULL,
	`Townid` INT NOT NULL
);

CREATE TABLE `Utype` (
	`Id` INT NOT NULL,
	`Name` INT NOT NULL
);

CREATE TABLE `School` (
	`Id` INT NOT NULL,
	`Name` INT NOT NULL,
	`Townid` INT NOT NULL
);

CREATE TABLE `Town` (
	`Id` INT NOT NULL,
	`Name` varchar(80) NOT NULL
);

CREATE TABLE `Сonformity` (
	`Studentid` INT NOT NULL AUTO_INCREMENT,
	`Theatherid` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`Studentid`,`Theatherid`)
);

CREATE TABLE `Results` (
	`Testid` INT NOT NULL,
	`Userid` INT NOT NULL,
	`Aswer` varchar(255) NOT NULL,
	`Rate` INT NOT NULL DEFAULT '-1',
	`Note` TEXT NOT NULL
);

CREATE TABLE `Trueresults` (
	`testid` INT NOT NULL,
	`Answer` varchar(255) NOT NULL
);

CREATE TABLE `Feedback` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Userid` INT NOT NULL,
	`Question` TEXT NOT NULL,
	`Answer` TEXT NOT NULL,
	PRIMARY KEY (`Id`)
);

CREATE TABLE `Testtype` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Name` varchar(10) NOT NULL,
	PRIMARY KEY (`Id`)
);

ALTER TABLE `Test` ADD CONSTRAINT `Test_fk0` FOREIGN KEY (`Rowtypeid`) REFERENCES `Rowtype`(`Id`);

ALTER TABLE `Test` ADD CONSTRAINT `Test_fk1` FOREIGN KEY (`Authorid`) REFERENCES `Users`(`Id`);

ALTER TABLE `Test` ADD CONSTRAINT `Test_fk2` FOREIGN KEY (`Type`) REFERENCES `Testtype`(`Id`);

ALTER TABLE `Users` ADD CONSTRAINT `Users_fk0` FOREIGN KEY (`Utypeid`) REFERENCES `Utype`(`Id`);

ALTER TABLE `Users` ADD CONSTRAINT `Users_fk1` FOREIGN KEY (`Schoolid`) REFERENCES `School`(`Id`);

ALTER TABLE `Users` ADD CONSTRAINT `Users_fk2` FOREIGN KEY (`Townid`) REFERENCES `Town`(`Id`);

ALTER TABLE `School` ADD CONSTRAINT `School_fk0` FOREIGN KEY (`Townid`) REFERENCES `Town`(`Id`);

ALTER TABLE `Сonformity` ADD CONSTRAINT `Сonformity_fk0` FOREIGN KEY (`Studentid`) REFERENCES `Users`(`Id`);

ALTER TABLE `Сonformity` ADD CONSTRAINT `Сonformity_fk1` FOREIGN KEY (`Theatherid`) REFERENCES `Users`(`Id`);

ALTER TABLE `Results` ADD CONSTRAINT `Results_fk0` FOREIGN KEY (`Testid`) REFERENCES `Test`(`Id`);

ALTER TABLE `Results` ADD CONSTRAINT `Results_fk1` FOREIGN KEY (`Userid`) REFERENCES `Users`(`Id`);

ALTER TABLE `Trueresults` ADD CONSTRAINT `Trueresults_fk0` FOREIGN KEY (`testid`) REFERENCES `Test`(`Id`);

ALTER TABLE `Feedback` ADD CONSTRAINT `Feedback_fk0` FOREIGN KEY (`Userid`) REFERENCES `Users`(`Id`);
