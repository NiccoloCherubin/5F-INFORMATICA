create DATABASE FastRoute;
USE FastRoute;

-- Tabella Clienti
CREATE TABLE Clienti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    mail varchar(50) not null unique,
    indirizzo VARCHAR(255) NOT NULL,
    passw VARCHAR(255) NOT NULL,  -- Deve essere salvata in forma hashata
    data_uso_punteggio DATETIME
);

-- Tabella Ruoli
CREATE TABLE Ruoli (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrizione VARCHAR(50) UNIQUE NOT NULL
);

-- Tabella PERSONALE
CREATE TABLE Personale (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    mail VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,  -- Anche qui salvata in forma sicura
    Ruoli_id INT NOT NULL,
    FOREIGN KEY (Ruoli_id) REFERENCES Ruoli(id) ON DELETE CASCADE
);

-- Tabella Sedi
CREATE TABLE Sedi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrizione VARCHAR(100) NOT NULL,
    citta VARCHAR(50) NOT NULL
);

-- Tabella Stati del Plichi
CREATE TABLE Stati (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrizione VARCHAR(50) UNIQUE NOT NULL
);

-- Tabella Plichi
CREATE TABLE Plichi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_ritiro DATETIME NOT NULL,
    Stati_id INT NOT NULL,
    FOREIGN KEY (Stati_id) REFERENCES Stati(id) ON DELETE CASCADE
);


-- Tabella Destinatari
CREATE TABLE Destinatari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    indirizzo VARCHAR(255) NOT null,
    cognome varchar(50) not null
);

-- Tabella SPEDIRE (associa Clienti e Plichi)
CREATE TABLE Spedire (
    Clienti_id INT NOT NULL,
    Plichi_id INT NOT NULL,
    data DATETIME NOT NULL,
    PRIMARY KEY (Clienti_id, Plichi_id),
    FOREIGN KEY (Clienti_id) REFERENCES Clienti(id) ON DELETE CASCADE,
    FOREIGN KEY (Plichi_id) REFERENCES Plichi(id) ON DELETE CASCADE
);



-- Tabella INVIARE (associa Plichi e Sedi di partenza)
CREATE TABLE Inviare (
    Plichi_id INT NOT NULL,
    Sedi_id INT NOT NULL,
    data DATETIME NOT NULL,
    PRIMARY KEY (Plichi_id, Sedi_id),
    FOREIGN KEY (Plichi_id) REFERENCES Plichi(id) ON DELETE CASCADE,
    FOREIGN KEY (Sedi_id) REFERENCES Sedi(id) ON DELETE CASCADE
);

-- Tabella RICEVERE (associa Plichi e Sedi di arrivo)
CREATE TABLE Ricevere (
    Plichi_id INT NOT NULL,
    Sedi_id INT NOT NULL,
    data DATETIME NOT NULL,
    PRIMARY KEY (Plichi_id, Sedi_id),
    FOREIGN KEY (Plichi_id) REFERENCES Plichi(id) ON DELETE CASCADE,
    FOREIGN KEY (Sedi_id) REFERENCES Sedi(id) ON DELETE CASCADE
);

-- Tabella RITIRARE (associa Destinatari e Plichi)
CREATE TABLE Ritirare (
    Plichi_id INT NOT NULL UNIQUE,
    Destinatari_id INT NOT NULL,
    data DATETIME NOT NULL,
    data_conferma DATETIME DEFAULT NULL, -- Per la mail al mittente
    PRIMARY KEY (Plichi_id, Destinatari_id),
    FOREIGN KEY (Plichi_id) REFERENCES Plichi(id) ON DELETE CASCADE,
    FOREIGN KEY (Destinatari_id) REFERENCES Destinatari(id) ON DELETE CASCADE
);

-- Tabella LAVORARE (associa Personale e Sedi)
CREATE TABLE Lavorare (
    personale_id INT NOT NULL,
    Sedi_id INT NOT NULL,
    PRIMARY KEY (personale_id, Sedi_id),
    FOREIGN KEY (personale_id) REFERENCES Personale(id) ON DELETE CASCADE,
    FOREIGN KEY (Sedi_id) REFERENCES Sedi(id) ON DELETE CASCADE
);

INSERT INTO Ruoli (descrizione) VALUES 
('Responsabile'),
('Addetto Spedizioni'),
('Addetto Consegne');

INSERT INTO Sedi (descrizione, citta) VALUES 
('Sedi Centrale', 'Roma'),
('Filiale Nord', 'Milano'),
('Filiale Sud', 'Napoli');

INSERT INTO Stati (descrizione) VALUES 
('In attesa'),
('In transito'),
('Consegnato');

INSERT INTO Personale (nome, mail, password, Ruoli_id) VALUES 
('Prova', 'prova.prova@fastroute.com', '$2y$10$kIk7Mr3jXh9sV94.mNm7JOtJ0wPRVHaYbdwgoL6QYvA6EOTOpncWi',1); -- prova

INSERT INTO Clienti (nome, cognome, mail,indirizzo, passw) VALUES 
('Emiliano', 'Spiller', 'matteo.fuso@iisviolamarchesini.edu.it','Via Teano 14', '$2y$10$VavE.DUH/PG84NqRbIA8nuIy7aG5p/F3R8lZjN7/BMAZevltsM4I.');


INSERT INTO Destinatari (nome, cognome,indirizzo) VALUES 
('Marco', 'Neri', 'Via Torino 50, Milano'),
('Chiara' ,'Galli', 'Viale Venezia 12, Roma'),
('Francesco','Moretti', 'Piazza Dante 7, Napoli');

INSERT INTO Plichi (data_ritiro, Stati_id) VALUES 
('2025-03-10 10:30:00', 1),
('2025-03-11 15:00:00', 2),
('2025-03-12 09:15:00', 3);

INSERT INTO Spedire (Clienti_id, Plichi_id, data) VALUES 
(1, 1, '2025-03-10 10:35:00');


INSERT INTO Inviare (Plichi_id, Sedi_id, data) VALUES 
(1, 1, '2025-03-10 12:00:00'),
(2, 2, '2025-03-11 16:00:00'),
(3, 3, '2025-03-12 10:00:00');

INSERT INTO Ricevere (Plichi_id, Sedi_id, data) VALUES 
(1, 2, '2025-03-11 09:00:00'),
(2, 3, '2025-03-12 11:00:00'),
(3, 1, '2025-03-13 14:00:00');

INSERT INTO Ritirare (Plichi_id, Destinatari_id, data, data_conferma) VALUES 
(1, 1, '2025-03-11 14:00:00', '2025-03-11 14:05:00'),
(2, 2, '2025-03-12 16:00:00', '2025-03-12 16:10:00'),
(3, 3, '2025-03-13 17:00:00', '2025-03-13 17:05:00');

INSERT INTO Lavorare (personale_id, Sedi_id) VALUES 
(1, 1);


