create or replace view subject_dcc as
  select distinct d.subject from dcc d order by d.subject asc;
