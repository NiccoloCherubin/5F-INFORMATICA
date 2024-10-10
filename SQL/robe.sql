select * from amministrazione.test t ;

select t.codice_fiscale,t.nome, t.cognome from amministrazione.test t ;

/*voglio che le tuple siano uniche ====> CLAUSOLA*/
select distinct t.codice_fiscale,t.nome, t.cognome from amministrazione.test t ;

/*conta tuple relazione. COUNT = FUNZIONE AGGREGAZIONE*/
select count(*) from amministrazione.test t ; 

/*SELEZIONE TUPLE SENZA RIPETIZIONI*/
select distinct t.codice_fiscale,t.nome, t.cognome from amministrazione.test t  where t.nome = "Aurelia";

select distinct t.codice_fiscale,t.nome, t.cognome from amministrazione.test t  where t.nome like "%a";

select t.codice_fiscale,t.nome, t.cognome, t.ingresso ,t.uscita from amministrazione.test t  where t.nome like "%a";

select t.codice_fiscale,t.nome, t.cognome, t.ingresso ,t.uscita from amministrazione.test t;

/*ORDINARE TABELLA IN BASE ALL'INGRESSO CON CLAUSOLA "ORDER BY"*/
select t.codice_fiscale,t.nome, t.cognome, t.ingresso ,t.uscita from amministrazione.test t order by t.ingresso ;

/*ORDINE DECRESCENTE*/
select t.codice_fiscale,t.nome, t.cognome, t.ingresso ,t.uscita from amministrazione.test t order by t.ingresso desc ;

/*ORDINE CRESCENTE*/
select t.codice_fiscale,t.nome, t.cognome, t.ingresso ,t.uscita from amministrazione.test t order by t.ingresso asc  ;
 /*FUNZIONE NOW*/
select distinct t.codice_fiscale,t.nome, t.cognome, now(),t.data_assunzione from amministrazione.test t ;

/*CALCOLARE TEMPO DANDO ALIAS AD ATTRIBUTO DI DATEDIFF*/
select distinct t.codice_fiscale,t.nome, t.cognome, now(),t.data_assunzione, datediff(now(),t.data_assunzione) as giorni from amministrazione.test t order by data_assunzione asc ;

/*CALCOLARE TEMPO IN ANNI DANDO ALIAS AD ATTRIBUTO DI DATEDIFF*/
select distinct t.codice_fiscale,t.nome, t.cognome, now(),t.data_assunzione, datediff(now(),t.data_assunzione)div(365) as anni from amministrazione.test t order by data_assunzione asc ;

select distinct t.codice_fiscale,t.nome, t.cognome, now(),t.data_assunzione, datediff(now(),t.data_assunzione)mod(365)mod(30) as mesi from amministrazione.test t order by data_assunzione asc ;

/*SOLO ANNO */
select distinct t.codice_fiscale,t.nome, t.cognome, now(),t.data_assunzione, datediff(now(),t.data_assunzione)mod(365)mod(30) as mesi, date_format(now(), "%D%M%Y") as anno, date_format(t.data_assunzione, "%D%M%Y") as formattazione from amministrazione.test t order by data_assunzione asc ;



/*INSERIMENTO MULTIPLO DA UN'ALTRA TABELLA*/
create table amministrazione.personale(
codice_fiscale nvarchar(16), 
nome nvarchar(50),
cognome nvarchar(50),
fascia_stipendio int,
data_assunzione datetime
);

insert into amministrazione.personale select distinct t.codice_fiscale,t.nome,t.cognome,t.fascia_stipendio,t.data_assunzione from amministrazione.test t;












