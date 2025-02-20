create database utopia;

use utopia;

create table utopia.sovrani(
nome varchar(100) primary key,
data_inizio date not null,
data_fine date not null,
immagine BIGINT UNSIGNED, -- per nome immagine che viene rinominata da php
estensione varchar(5),
sovrano_precendente varchar(100),
sovrano_successivo varchar(100),
foreign key (sovrano_precendente) references utopia.sovrani(nome) on delete set null,
foreign key (sovrano_successivo) references utopia.sovrani(nome) on delete set null
);