create database hotpockets;
create table users(
  pid int,
  first_name text,
  last_name text,
  email text,
  current_school text,
  phone_num int,
  major text,
  primary key (pid)
);
#These will be the classes from Marist College
create table class_list(
  cid int,
  pid int,
  dcrn int,
  primary key(cid)
);
#These will be the classes from DCC
create table dcc(
  dcrn int,
  subject int,
  course_num int,
  course_title text,
  primary key(dcrn)
);
create table transfer(
  tid int,
  crn int,
  dcrn int,
  status text,
  group text,
  primary key(tid)
);
create table majors(
  mid int,
  crn int,
  major_name text,
  primary key(mid)
);
create table minors(
  mnid int,
  crn int,
  minor_name text,
  primary key(mnid)
);
create table marist(
  crn int,
  subject text,
  course_num int,
  course_title text,
  primary key(crn)
);
