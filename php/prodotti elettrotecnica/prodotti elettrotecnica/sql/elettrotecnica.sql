create database elettrotecnica;

create table elettrotecnica.prodotti(
id int primary key auto_increment,
descrizione text not null,
costo decimal (10,2) not null,
quantita int default 0,
data_produzione date not null
)

create table elettrotecnica.ruoli(
id int primary key auto_increment,
descrizione varchar(30) not null
)

create table elettrotecnica.utenti(
id int primary key auto_increment,
nome varchar(50) not null,
cognome varchar(50) not null,
email varchar(100) not null unique,
password varchar(100) not null,
ruolo_id int,

foreign key(ruolo_id) references elettrotecnica.ruoli(id)
)

-- Updated roles table with simplified role structure
INSERT INTO elettrotecnica.ruoli (descrizione) VALUES 
('Amministratore'),
('Utente');

-- Update users table to reflect the new role structure
INSERT INTO elettrotecnica.utenti (nome, cognome, email, password, ruolo_id) VALUES 
('Giovanni', 'Rossi', 'admin@elettrotecnica.com', '$2y$10$Oo0s4kr/KdBEH.lPFbRGqODCHus6XuciZ79BJxpZolXsrAkeLVeGu', 1), -- admin
('Maria', 'Bianchi', 'maria.bianchi@elettrotecnica.com', '$2y$10$Kh4m9/XzVGeYn7..fuE.SOF0kcXUsr54u.aSORiLW2wri9hFQe8SK', 2), -- user1
('Luigi', 'Verdi', 'luigi.verdi@elettrotecnica.com', '$2y$10$0Cyle1iBGOuxYjDVRWizs.mj7/S831ECNnDLZrmuSZojTTNTCYl32', 2), -- user2
('Alessandra', 'Neri', 'alessandra.neri@elettrotecnica.com', '$2y$10$8JVmIOmLi0MgkF8ZVgEKw.wPeXH/qeu5j7XcCpRIjFvSJrcl2yhMe', 2); -- user3

-- Insert sample data into prodotti (Products) table
INSERT INTO elettrotecnica.prodotti (descrizione, costo, quantita, data_produzione) VALUES 
('Interruttore magnetotermico 16A', 45.50, 100, '2024-02-15'),
('Cavo elettrico isolato 5m', 12.75, 250, '2024-01-20'),
('Quadro elettrico modulare 12 moduli', 89.90, 50, '2024-03-10'),
('Presa elettrica standard', 7.25, 200, '2024-02-05'),
('Trasformatore di sicurezza 230V/24V', 65.30, 75, '2024-01-30'),
('Relè interruttore', 22.80, 120, '2024-03-05'),
('Contatore energia elettrica digitale', 135.60, 40, '2024-02-25'),
('Interruttore differenziale 40A', 62.40, 60, '2024-01-15');



