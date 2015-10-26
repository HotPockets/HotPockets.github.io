--database for hotpockets--
--michael shershin--



---drops  database--
drop database if exists hotpockets;
--create database--
create database hotpockets;
--drop children and drop them hard
drop table if exists admin;
drop table if exists majors;
drop table if exists minors;
drop table if exists transfer;

--drop the parents--
drop table if exists dcc;
drop table if exists users;
drop table if exists marist;


--droping the uniqueness--
drop index if exists course;


--drop enums--
drop type cem;

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
  dcrn serial not null,
  subject text,
  course_num int,
  course_title text,
  primary key(dcrn)
);
create table marist(
  crn serial not null,
  subject text,
  course_num text,
  course_title text,
  credits int,
  primary key(crn)
);
create table majors(
  major_id serial not null,
  crn serial references not null marist(subject),
  major_name text,
  credits int,
  primary key(major_id)
);
create table minors(
  minor_id serial not null,
  crn serial references not null marist(crn),
  major_name text,
  primary key(minor_id)
);
create table transfer(
  transfer_id serial not null,
  crn serial references not null marist(crn),
  dcrn serial not null references dcc(dcrn),
  user_id serial not null references users(user_id),
  course_cem cem,
  primary key (transfer_id)
);
