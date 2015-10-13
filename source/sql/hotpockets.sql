--database for hotpockets--
--michael shershin--



---drops  database--
drop database if exists hotpockets;
--create database--
create database hotpockets;
--drop children and drop them hard
drop table if exists admin;
drop table if exists majors;
drop table if exitst minors;
drop table if exists dcc;
--drop the parents--
drop table if exists users;
drop table if exists transfer;
drop table if exists marist;

--creating enum--
create type cem as enum ('core', 'elective', 'major');




--creating tables whoot whoot mother fuckers--
create table users(
  user_id serial not null,
  first_name text,
  last_name text,
  email text unique,
  password text,
  primary key(user_id)
);
create table admin(
  user_id serial not null references users(user_id),
  primary key(user_id)
);
create table dcc(
  dcrn int not null,
  subject text,
  course_num int,
  course_title text,
  primary key(dcrn)
);
create table marist(
  crn int not null,
  subject text,
  course_num int,
  course_title int,
  primary key(crn)
);
create table majors(
  major_id serial not null,
  crn int not null references marist(crn),
  major_name text,
  credits int,
  primary key(major_id)
);
create table minors(
  minor_id serial not null,
  crn int not null references marsit(crn),
  major_name text,
  primary key(minor_id)
);
create table transfer(
  transfer_id serial not null,
  crn int not null references marsit(crn),
  dcrn int not null references dcc(dcrn),
  user_id serial not null references users(user_id),
  course_cem cem,
  primary key (transfer_id)
);
