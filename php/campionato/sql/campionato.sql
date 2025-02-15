-- Creazione del database
CREATE DATABASE Campionato_Automobilistico;
USE Campionato_Automobilistico;

-- Tabella NAZIONALITA
CREATE TABLE Nazionalita (
id INT PRIMARY KEY AUTO_INCREMENT,
descrizione VARCHAR(50) NOT NULL UNIQUE
);

-- Tabella Colore_Livree
CREATE TABLE Colore_Livree (
id INT PRIMARY KEY AUTO_INCREMENT,
descrizione VARCHAR(50) NOT NULL UNIQUE
);

-- Tabella Case_Automobilistiche
CREATE TABLE Case_Automobilistiche (
id INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(50) NOT NULL UNIQUE,
livrea_id INT NOT NULL,
FOREIGN KEY (livrea_id) REFERENCES Colore_Livree(id) ON DELETE CASCADE
);

-- Tabella Piloti
CREATE TABLE Piloti (
id INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(50) NOT NULL,
cognome VARCHAR(50) NOT NULL,
numero INT NOT NULL UNIQUE,
nazionalita_id INT NOT NULL,
casa_id INT NOT NULL,
FOREIGN KEY (casa_id) REFERENCES Case_Automobilistiche(id) ON DELETE CASCADE,
FOREIGN KEY (nazionalita_id) REFERENCES Nazionalita(id) ON DELETE CASCADE
);

-- Tabella Gare
CREATE TABLE Gare (
id INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(50) NOT NULL,
data DATE NOT NULL
);

-- Relazione Piloti -> Gare (partecipazione)
CREATE TABLE Partecipare (
Piloti_id INT,
Gare_id INT,
PRIMARY KEY (Piloti_id, Gare_id),
FOREIGN KEY (Piloti_id) REFERENCES Piloti(id) ON DELETE CASCADE,
FOREIGN KEY (Gare_id) REFERENCES Gare(id) ON DELETE CASCADE
);

-- Tabella Risultati (relativa a ogni Gara)
CREATE TABLE Risultati (
id INT PRIMARY KEY AUTO_INCREMENT,
Piloti_id INT NOT NULL,
Gare_id INT NOT NULL,
posizione_finale INT NOT NULL,
tempo_veloce TIME NOT NULL,
punti_assegnati INT NOT NULL,
FOREIGN KEY (Piloti_id) REFERENCES Piloti(id) ON DELETE CASCADE,
FOREIGN KEY (Gare_id) REFERENCES Gare(id) ON DELETE CASCADE
);

-- Inserimento dati
INSERT INTO Nazionalita (descrizione) VALUES
('Italia'),
('Gran Bretagna'),
('Germania'),
('Francia'),
('Spagna');

INSERT INTO Colore_Livree (descrizione) VALUES
('Rosso'),
('Argento'),
('Blu'),
('Arancione'),
('Verde');

INSERT INTO Case_Automobilistiche (nome, livrea_id) VALUES
('Ferrari', 1),        -- Ferrari -> Rosso
('Mercedes', 2),      -- Mercedes -> Argento
('Red Bull Racing', 3), -- Red Bull Racing -> Blu
('McLaren', 4),        -- McLaren -> Arancione
('Alpine', 5);         -- Alpine -> Verde

INSERT INTO Piloti (nome, cognome, numero, nazionalita_id, casa_id) VALUES
('Sebastian', 'Vettel', 5, 1, 1),   -- Vettel (Italia) -> Ferrari
('Lewis', 'Hamilton', 44, 2, 2),    -- Hamilton (Gran Bretagna) -> Mercedes
('Max', 'Verstappen', 33, 3, 3),    -- Verstappen (Germania) -> Red Bull Racing
('Lando', 'Norris', 4, 2, 4),       -- Norris (Gran Bretagna) -> McLaren
('Esteban', 'Ocon', 31, 4, 5);      -- Ocon (Francia) -> Alpine

INSERT INTO Gare (nome, data) VALUES
('Gran Premio d\'Italia', '2025-09-06'),
('Gran Premio di Monaco', '2025-05-24'),
('Gran Premio di Spagna', '2025-06-14');

INSERT INTO Partecipare (Piloti_id, Gare_id) VALUES
(1, 1),  -- Vettel partecipa al Gran Premio d'Italia
(2, 1),  -- Hamilton partecipa al Gran Premio d'Italia
(3, 2),  -- Verstappen partecipa al Gran Premio di Monaco
(4, 3),  -- Norris partecipa al Gran Premio di Spagna
(5, 2);  -- Ocon partecipa al Gran Premio di Monaco

INSERT INTO Risultati (Piloti_id, Gare_id, posizione_finale, tempo_veloce, punti_assegnati) VALUES
(1, 1, 1, '01:20:30', 25),  -- Vettel 1° al Gran Premio d'Italia
(2, 1, 2, '01:21:00', 18),  -- Hamilton 2° al Gran Premio d'Italia
(3, 2, 1, '01:23:00', 25),  -- Verstappen 1° al Gran Premio di Monaco
(4, 3, 1, '01:22:30', 25),  -- Norris 1° al Gran Premio di Spagna
(5, 2, 2, '01:24:00', 18);  -- Ocon 2° al Gran Premio di Monaco
