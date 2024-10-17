/*operatore between si usa quando si vuole valori compresi in un intervallo*/
select * from amministrazione.test t where t.fascia_stipendio between 4 and 6;

/*operatore in all'interno di quell'insieme*/
select * from amministrazione.test t where t.nome in("antonella","antonietta");

select t.fascia_stipendio, count(*) as assunti from amministrazione.test t group by t.fascia_stipendio ;

/*Quando ho a che fare con group by non posso utilizzare la clausola where, ma having perché possono includere funzioni di aggregazione*/
select t.fascia_stipendio, count(*) from amministrazione.test t group by t.fascia_stipendio having t.fascia_stipendio in(3,5,6) order by t.fascia_stipendio desc;

/*clausulo limit limiti la righe da visualizzare*/
select max(t.fascia_stipendio), count(*) from amministrazione.test t limit 5;

/**/
select t.codice_fiscale, sum(hour(timediff(t.uscita, t.ingresso)) * 60 + minute(timediff(t.uscita, t.ingresso))) as MinutiLavorati, count(*), avg(hour(timediff(t.uscita, t.ingresso)) * 60 + minute(timediff(t.uscita, t.ingresso))) as Media
from amministrazione.test t group by t.codice_fiscale;