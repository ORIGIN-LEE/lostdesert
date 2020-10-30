create table raid (
   num int not null auto_increment,
   id char(15) not null,
   name  char(10) not null,
   nick  char(10) not null,
   subject char(100) not null,
   content text not null,
   regist_day char(20),
   member1 char(15),
   member2 char(15),
   member3 char(15),
   done char(1) default 'n',
   primary key(num)
)default charset=utf8;