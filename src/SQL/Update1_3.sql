--alter table answer add USERID integer;
--alter table answer drop USERHASH;
ALTER TABLE  `answer` CHANGE  `ADATE`  `ADATE` DATETIME NULL DEFAULT NULL;
