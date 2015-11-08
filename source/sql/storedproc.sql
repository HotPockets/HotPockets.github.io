

CREATE OR REPLACE FUNCTION sign_up(first_name text, last_name text, email text, password text)
   RETURNS void AS
   $BODY$
   BEGIN
   insert into users(first_name, last_name, email, password)
              values($1, $2, $3, $4);
   END;
   $BODY$
   LANGUAGE 'plpgsql' VOLATILE
   COST 100;


create or replace function login(email text, password text)
  returns table(
  user_id integer
) as $func$

  BEGIN
  return query
  select u.user_id from users u where u.email = $1 and u.password = $2;
  end;

  $func$ language 'plpgsql';


/*
  create or replace function profileList(user_id integer, out createDate date)returns setof date as $$

    BEGIN
    return query select t.createDate from transfer t where t.user_id = $1;
    end;

    $$ language 'plpgsql' VOLATILE
    cost 100;

    create or replace function transferHistory(user_id integer,
      out course_num text,
      out subject text,
      out course_num text,
      out subject text,
      out course_cem)returns setof record as $$

      BEGIN
      return query select m.course_num, m.subject, d.course_num, d.subject, t.course_cem from transfer t, marist m, dcc d where t.user_id = $1;
      end;

      $$ language 'plpgsql' VOLATILE
      cost 100;


      create or replace function adminLogin(user_id integer, out user_id integer)returns setof integer as $$

        BEGIN
        return query select a.user_id from admin a, users u where u.user_id = $1 and u.user_id = a.user_id;
        end;

        $$ language 'plpgsql' VOLATILE
        cost 100;
*/
