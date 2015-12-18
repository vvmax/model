
create table users (
    ID int not null auto_increment primary key,
    LOGIN varchar (24) not null , 
    PASSWORD varchar (24) not null comment 'Пароль пользователя',
    SCHOOLID int ,
    FIRSTNAME varchar (64) ,
    SECONDNAME varchar (64) ,
    LASTNAME varchar (64) ,
    FORM varchar (10),
    USERTYPEID  int not null default 20,
    ACTIVE int default 1 not null,
    TOWNID int , 
    unique key (LOGIN)
);
create table usertype(
    ID int not null auto_increment primary key,
    NAME varchar (20)
);
ALTER TABLE users ADD FOREIGN KEY (`USERTYPEID`) REFERENCES usertype (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;
insert into usertype (ID,NAME) values (20,'Ученик');
insert into usertype (ID,NAME) values (10,'Учитель');
insert into usertype (ID,NAME) values (1,'admin'); 
create table schools(
    ID int not null auto_increment primary key,
    NAME varchar (20),
    TOWNID int
);
create table towns(
    ID int not null auto_increment primary key,
    NAME varchar (30)
);
ALTER TABLE users ADD FOREIGN KEY (`SCHOOLID`) REFERENCES schools (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE users ADD FOREIGN KEY (`TOWNID`) REFERENCES towns (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE schools ADD FOREIGN KEY (`TOWNID`) REFERENCES towns (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;
