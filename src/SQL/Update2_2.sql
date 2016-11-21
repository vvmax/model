create table answeraccess(
	TEACHERID  int not null ,
	ANSWERID  int not null ,
	USERID int not null,
	primary key(TEACHERID,ANSWERID,USERID)
);

ALTER TABLE answeraccess ADD FOREIGN KEY (`ANSWERID`) 
REFERENCES answer (`ID`) ON DELETE cascade ON UPDATE CASCADE;
ALTER TABLE answeraccess ADD FOREIGN KEY (`TEACHERID`) 
REFERENCES users (`ID`) ON DELETE cascade ON UPDATE CASCADE;
