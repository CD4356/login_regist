`user`CREATE DATABASE regist;
USE regist
CREATE TABLE USER(
  NAME VARCHAR(255) PRIMARY KEY NOT NULL,
  pass VARCHAR(255) NOT NULL,
  email VARCHAR(255),
  phone VARCHAR(255)
)DEFAULT CHARSET=utf8;