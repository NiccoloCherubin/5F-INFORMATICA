create database artifex;

create table artifex.luoghi(
id int primary key auto_increment,
descrizione varchar(50) not null unique
);

create table artifex.eventi(
id int primary key auto_increment,
descrizione varchar(50) not null unique
);

create table artifex.nazionalita(
id int primary key auto_increment,
descrizione varchar(50) not null unique
);

create table artifex.lingue(
id int primary key auto_increment,
descrizione varchar(50) not null unique
);



create table artifex.utenti(
id int primary key auto_increment,
nome varchar(50) not null,
telefono char(9) not null unique,
mail varchar(100) not null unique,
id_nazionalita int not null,
id_lingua int not null,
password varchar(100) not null,
foreign key (id_nazionalita) references artifex.nazionalita(id),
foreign key (id_lingua) references artifex.lingue(id)
);

create table artifex.guide(
id int primary key auto_increment,
nome varchar(50) not null,
cognome varchar(50) not null,
titolo_studio varchar(50) not null,
data_nascita date not null
);

create table artifex.visite(
id int primary key auto_increment,
titolo varchar(50) not null unique,
durata decimal(5,2) not null,
prezzo decimal(7,2) not null,
n_min int not null check(n_min > 0),
n_max int not null check(n_max > n_min),
id_guida int not null,
foreign key (id_guida) references artifex.guide(id)
);

-- relazione tra utente e visita
create table artifex.prenotare(
id_utente int not null,
id_visita int not null,
foreign key (id_utente) references artifex.utenti(id),
foreign key (id_visita) references artifex.visite(id),
primary key(id_utente,id_visita)
);

-- relazione tra guida e lingua
create table artifex.parlare(
id_guida int not null,
id_lingua int not null,
foreign key (id_guida) references artifex.guide(id),
foreign key (id_lingua) references artifex.lingue(id),
primary key(id_guida,id_lingua)
);

-- relazione tra visita, luogo e evento
create table artifex.avere(
id_visita int not null,
id_luogo int not null,
id_evento int not null,
foreign key (id_visita) references artifex.visite(id),
foreign key (id_luogo) references artifex.luoghi(id),
foreign key (id_evento) references artifex.eventi(id),
primary key(id_visita,id_luogo,id_evento)
);

INSERT INTO artifex.lingue (descrizione) VALUES 
('Italiano'), 
('Inglese'), 
('Francese'), 
('Tedesco');

INSERT INTO artifex.nazionalita (descrizione) VALUES 
('Italiana'), 
('Statunitense'), 
('Francese'), 
('Tedesca');

INSERT INTO artifex.luoghi (descrizione) VALUES 
('Roma - Colosseo'), 
('Firenze - Galleria degli Uffizi'), 
('Pompei - Scavi Archeologici'), 
('Venezia - Palazzo Ducale');

INSERT INTO artifex.eventi (descrizione) VALUES 
('Mattina'), 
('Pomeriggio'), 
('Visita serale'), 
('Speciale weekend');

INSERT INTO artifex.utenti (nome, telefono, mail, password,id_nazionalita, id_lingua) VALUES 
('Mario Rossi', '333112233', 'mario.rossi@email.it', '$2y$10$jaB6lmKaCSQ/N2Jhxm1R5Ouq/LI9aiux.l33DmPDlaQ.SXe6BU78S', 1, 1),
('Anna Smith', '333223344', 'anna.smith@email.com', '$2y$10$jaB6lmKaCSQ/N2Jhxm1R5Ouq/LI9aiux.l33DmPDlaQ.SXe6BU78S', 2, 2),
('Claire Dubois', '333334455', 'claire.dubois@email.fr', '$2y$10$jaB6lmKaCSQ/N2Jhxm1R5Ouq/LI9aiux.l33DmPDlaQ.SXe6BU78S', 3, 3),
('Hans Müller', '333445566', 'hans.mueller@email.de', '$2y$10$jaB6lmKaCSQ/N2Jhxm1R5Ouq/LI9aiux.l33DmPDlaQ.SXe6BU78S', 4, 4);

INSERT INTO artifex.guide (nome, cognome, titolo_studio, data_nascita) VALUES 
('Luca', 'Bianchi', 'Laurea in Storia dell’Arte', '1985-05-12'),
('Sara', 'Verdi', 'Laurea in Archeologia', '1990-08-22'),
('Paul', 'Moreau', 'Laurea in Lettere', '1982-03-18');

INSERT INTO artifex.parlare (id_guida, id_lingua) VALUES 
(1, 1), -- Luca parla Italiano
(1, 2), -- Luca parla Inglese
(2, 1), -- Sara parla Italiano
(2, 3), -- Sara parla Francese
(3, 3), -- Paul parla Francese
(3, 2); -- Paul parla Inglese

INSERT INTO artifex.visite (titolo, durata, prezzo, n_min, n_max, id_guida) VALUES 
('Galleria degli Uffizi', 2.5, 25.00, 5, 20, 1),
('Scavi di Pompei', 3.0, 30.00, 10, 30, 2),
('Colosseo e Foro Romano', 2.0, 20.00, 5, 25, 1),
('Palazzo Ducale di Venezia', 1.5, 18.00, 4, 15, 3);

INSERT INTO artifex.avere (id_visita, id_luogo, id_evento) VALUES 
(1, 2, 1), 
(2, 3, 2), 
(3, 1, 1), 
(4, 4, 3);

INSERT INTO artifex.prenotare (id_utente, id_visita) VALUES 
(1, 1), 
(2, 2), 
(3, 3), 
(4, 4),
(1, 2);

