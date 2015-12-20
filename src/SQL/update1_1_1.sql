alter table answer add CODE varchar(32) not null;
alter table answer add unique key (CODE);
update answer set CODE=ID ;