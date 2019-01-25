create database regist;
use regist
create table user(
  name varchar(255) primary key not null,
  pass varchar(255) not null,
  email varchar(255),
  phone varchar(255)
)default charset=utf8;