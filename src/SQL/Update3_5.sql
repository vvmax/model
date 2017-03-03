create table feedback(
ID int auto_increment primary key,
THEME varchar(64) ,
DESCRIPTION varchar(4000),
AUTHORID int,
ADATE datetime  
);
