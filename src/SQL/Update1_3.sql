alter table answer add USERID integer;
alter table answer drop USERHASH;
ALTER TABLE  `answer` CHANGE  `ADATE`  `ADATE` DATETIME NULL DEFAULT NULL;
ALTER TABLE answer ADD FOREIGN KEY (`USERID`) REFERENCES users (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
