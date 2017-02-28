delete from answer  where not exists (select ID  from users where users.ID=answer.USERID); 
ALTER TABLE answer ADD FOREIGN KEY (`USERID`) 
REFERENCES users (`ID`) ON DELETE cascade ON UPDATE CASCADE;

