create DATABASE Campionato_Automobilistico;
USE Campionato_Automobilistico;

-- Tabella NAZIONALITA
CREATE TABLE Nazionalita (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descrizione VARCHAR(50) NOT null unique
);

-- Tabella Case_Automobilistiche
CREATE TABLE Case_Automobilistiche (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT null unique
);

-- Tabella Colore_Livree
CREATE TABLE Colore_Livree (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descrizione VARCHAR(50) NOT null unique
);

-- Relazione Case_Automobilistiche -> Colore_Livree
CREATE TABLE Decidere (
    casa_id INT,
    livrea_id INT,
    PRIMARY KEY (casa_id, livrea_id),
    FOREIGN KEY (casa_id) REFERENCES Case_Automobilistiche(id) ON DELETE CASCADE,
    FOREIGN KEY (livrea_id) REFERENCES Colore_Livree(id) ON DELETE CASCADE
);

-- Tabella Piloti
CREATE TABLE Piloti (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    numero INT NOT NULL UNIQUE,
    nazionalita_id INT NOT NULL,
    FOREIGN KEY (nazionalita_id) REFERENCES Nazionalita(id) ON DELETE cascade
);

-- Relazione Piloti -> Case_Automobilistiche
CREATE TABLE Appartenere (
    Piloti_id INT,
    casa_id INT,
    PRIMARY KEY (Piloti_id, casa_id),
    FOREIGN KEY (Piloti_id) REFERENCES Piloti(id) ON DELETE CASCADE,
    FOREIGN KEY (casa_id) REFERENCES Case_Automobilistiche(id) ON DELETE CASCADE
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


INSERT INTO Nazionalita (descrizione) VALUES
('Italia'),
('Gran Bretagna'),
('Germania'),
('Francia'),
('Spagna');

INSERT INTO Case_Automobilistiche (nome) VALUES
('Ferrari'),
('Mercedes'),
('Red Bull Racing'),
('McLaren'),
('Alpine');

INSERT INTO Colore_Livree (descrizione) VALUES
('Rosso'),
('Argento'),
('Blu'),
('Arancione'),
('Verde');

INSERT INTO Decidere (casa_id, livrea_id) VALUES
(1, 1), -- Ferrari -> Rosso
(2, 2), -- Mercedes -> Argento
(3, 3), -- Red Bull Racing -> Blu
(4, 4), -- McLaren -> Arancione
(5, 5); -- Alpine -> Verde


INSERT INTO Piloti (nome, cognome, numero, nazionalita_id) VALUES
('Sebastian', 'Vettel', 5, 1), -- Vettel (Italia)
('Lewis', 'Hamilton', 44, 2), -- Hamilton (Gran Bretagna)
('Max', 'Verstappen', 33, 3), -- Verstappen (Germania)
('Lando', 'Norris', 4, 2), -- Norris (Gran Bretagna)
('Esteban', 'Ocon', 31, 4); -- Ocon (Francia)

INSERT INTO Appartenere (Piloti_id, casa_id) VALUES
(1, 1), -- Vettel -> Ferrari
(2, 2), -- Hamilton -> Mercedes
(3, 3), -- Verstappen -> Red Bull Racing
(4, 4), -- Norris -> McLaren
(5, 5); -- Ocon -> Alpine

INSERT INTO Gare (nome, data) VALUES
('Gran Premio d\'Italia', '2025-09-06'),
('Gran Premio di Monaco', '2025-05-24'),
('Gran Premio di Spagna', '2025-06-14');

INSERT INTO Partecipare (Piloti_id, Gare_id) VALUES
(1, 1), -- Vettel partecipa al Gran Premio d'Italia
(2, 1), -- Hamilton partecipa al Gran Premio d'Italia
(3, 2), -- Verstappen partecipa al Gran Premio di Monaco
(4, 3), -- Norris partecipa al Gran Premio di Spagna
(5, 2); -- Ocon partecipa al Gran Premio di Monaco

INSERT INTO Risultati (Piloti_id, Gare_id, posizione_finale, tempo_veloce, punti_assegnati) VALUES
(1, 1, 1, '01:20:30', 25), -- Vettel 1° al Gran Premio d'Italia
(2, 1, 2, '01:21:00', 18), -- Hamilton 2° al Gran Premio d'Italia
(3, 2, 1, '01:23:00', 25), -- Verstappen 1° al Gran Premio di Monaco
(4, 3, 1, '01:22:30', 25), -- Norris 1° al Gran Premio di Spagna
(5, 2, 2, '01:24:00', 18); -- Ocon 2° al Gran Premio di Monaco


