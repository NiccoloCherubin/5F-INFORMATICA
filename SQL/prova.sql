create database dbmiur2;
/*si poteva fare use dbmiur per impostarlo come oggetto predefinito senza fare dbmiur.*/
create table dbmiur2.scuole(
nome varchar(30), /*array di caratteri di cui specifico la lunghezza*/
indirizzo varchar(30),
provincia varchar(2),
citta varchar(30)
);

/*inserire righe nel database*/

insert into dbmiur2.scuole (nome,indirizzo,provincia,citta)
values ('ITIS','via A. De Gasperi 21','RO','Rovigo');