--database for hotpockets--
--michael shershin--



---drops  database--
--drop children and drop them hard
drop table if exists admin;
drop table if exists majors;
drop table if exists minors;
drop table if exists transcript;
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
  course_num text,
  course_title text,
  primary key(subject, course_num),
  unique(dcrn)
);
create table marist(
  crn serial not null,
  subject text not null,
  course_num text not null,
  course_title text,
  credits int,
  primary key(subject, course_num),
  unique(crn)
);
create table majors(
  major_id serial not null,
  subject text not null,
  course_num text not null,
  major_name text,
  primary key(major_id),
  foreign key(subject, course_num) references marist(subject, course_num)
);
create table minors(
  minor_id serial not null,
  subject text not null,
  course_num text not null,
  minor_name text,
  primary key(minor_id),
  foreign key(subject, course_num) references marist(subject, course_num)
);
create table transfer(
  transfer_id serial not null,
  m_subject text not null,
  m_course_num text not null,
  d_subject text not null,
  d_course_num text not null,
  primary key (transfer_id),
  foreign key(m_subject, m_course_num) references marist(subject, course_num),
  foreign key(d_subject, d_course_num) references dcc(subject, course_num)
);
create table transcript(
  trans_id serial not null,
  user_id serial not null references users(user_id),
  transfer_id serial not null references transfer(transfer_id),
  creatation_date date,
  name text,
  primary key(trans_id)
);
