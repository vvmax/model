create table friends(
	TEACHERID  int not null ,
	STUDENTID  int not null ,
	ACCEPTED int not null default 0,
	primary key(TEACHERID,STUDENTID)
)

