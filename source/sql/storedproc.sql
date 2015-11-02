

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


create or replace function login(email text, password text, out user_id integer)returns setof integer as $$

  BEGIN
  return query select u.user_id from users u where u.email = $1 and u.password = $2;
  end;

  $$ language 'plpgsql' VOLATILE
  cost 100;
