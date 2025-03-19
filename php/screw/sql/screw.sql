CREATE DATABASE ecommerce;
USE ecommerce;

-- Tabella utenti
CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    data_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabella prodotti
CREATE TABLE prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descrizione TEXT NOT NULL,
    prezzo DECIMAL(10,2) NOT NULL,
    immagine VARCHAR(255) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    categoria VARCHAR(100),
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabella varianti prodotto
CREATE TABLE varianti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prodotto_id INT NOT NULL,
    misura VARCHAR(50) NOT NULL,
    prezzo DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (prodotto_id) REFERENCES prodotti(id) ON DELETE CASCADE
);

-- Tabella carrello
CREATE TABLE carrello (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utente_id INT NOT NULL,
    prodotto_id INT NOT NULL,
    variante_id INT DEFAULT NULL,
    quantita INT NOT NULL DEFAULT 1,
    FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE,
    FOREIGN KEY (prodotto_id) REFERENCES prodotti(id) ON DELETE CASCADE,
    FOREIGN KEY (variante_id) REFERENCES varianti(id) ON DELETE SET NULL
);

-- Tabella ordini
CREATE TABLE ordini (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utente_id INT NOT NULL,
    totale DECIMAL(10,2) NOT NULL,
    data_ordine TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE
);

-- Tabella dettagli ordini
CREATE TABLE dettagli_ordini (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ordine_id INT NOT NULL,
    prodotto_id INT NOT NULL,
    variante_id INT DEFAULT NULL,
    quantita INT NOT NULL,
    prezzo DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (ordine_id) REFERENCES ordini(id) ON DELETE CASCADE,
    FOREIGN KEY (prodotto_id) REFERENCES prodotti(id) ON DELETE CASCADE,
    FOREIGN KEY (variante_id) REFERENCES varianti(id) ON DELETE SET NULL
);

-- Tabella per i bundle
CREATE TABLE bundle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    prezzo DECIMAL(10,2) NOT NULL,
    immagine VARCHAR(255) NOT NULL
);

-- Associazione bundle-prodotti
CREATE TABLE bundle_prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bundle_id INT NOT NULL,
    prodotto_id INT NOT NULL,
    FOREIGN KEY (bundle_id) REFERENCES bundle(id) ON DELETE CASCADE,
    FOREIGN KEY (prodotto_id) REFERENCES prodotti(id) ON DELETE CASCADE
);

INSERT INTO prodotti (id, nome, descrizione, prezzo, immagine, stock, categoria) VALUES
(1, 'Punta da Trapano', 'Punta da trapano di alta qualità per forare muri di cemento, mattoni o pietra.', 9.99, 'https://www.fixon.it/image/cache/fischer/sdx-16-k-d-c-1000x1000.jpg', 50, 'Strumenti'),
(2, 'Set di Viti in Acciaio Inox', 'Set completo di viti in acciaio inox resistenti alla corrosione.', 7.99, 'https://m.media-amazon.com/images/I/8128K3rW8uL.jpg', 100, 'Materiali'),
(3, 'Trapano a Percussione 800W', 'Trapano potente a percussione da 800W, ideale per forare cemento, muratura, legno e metallo.', 69.99, 'https://m.media-amazon.com/images/I/61VVb1WNa5L.jpg', 30, 'Strumenti'),
(4, 'Chiave Inglese Regolabile', 'Chiave inglese regolabile in acciaio, perfetta per serraggi e lavori su tubazioni.', 15.99, 'https://www.beps.it/items/grado/utensili--lampade-da-lavoro-e-torce/chiave/jpg/1767237_comp_900x900.jpg', 40, 'Strumenti'),
(5, 'Tasselli per Muro', 'Tasselli in nylon resistenti, ideali per il fissaggio di viti in muro, mattoni e cemento.', 4.99, 'https://m.media-amazon.com/images/I/71HaODDdqkL._AC_UF894,1000_QL80_.jpg', 200, 'Materiali'),
(6, 'Pinza Multifunzione', 'Pinza multifunzione robusta, perfetta per tagliare, stringere e tenere oggetti.', 22.99, 'https://www.velamp.com/21590-large_default/pinza-multifunzione-16-in-1-arancione.jpg', 20, 'Strumenti');

INSERT INTO varianti (prodotto_id, misura, prezzo) VALUES
(1, '5mm', 9.99),
(1, '8mm', 12.99),
(1, '10mm', 15.99),
(2, '4mm x 20mm', 7.99),
(2, '5mm x 30mm', 9.99),
(2, '6mm x 40mm', 11.99),
(4, '6"', 15.99),
(4, '8"', 18.99),
(4, '10"', 21.99),
(5, '6mm', 4.99),
(5, '8mm', 5.99),
(5, '10mm', 6.99),
(6, '200mm', 22.99),
(6, '250mm', 25.99);

INSERT INTO bundle (id, nome, prezzo, immagine) VALUES
(1, 'Bundle Strumenti Base', 29.99, 'https://media.istockphoto.com/id/1140180560/it/foto/esplosione-di-polvere-colorata-su-sfondo-nero.jpg?s=612x612&w=0&k=20&c=GEXA0Rr2homGuDTz5hzv42NG4DVM_sZJ2w3muj2Tzms='),
(2, 'Bundle Strumenti Avanzato', 99.99, 'https://www.studiolegaleadamo.it/wp-content/uploads/2024/10/Uso-immagini-copyright-foto.jpeg');

INSERT INTO bundle_prodotti (bundle_id, prodotto_id) VALUES
(1, 1), (1, 2), (1, 3),
(2, 4), (2, 5), (2, 6);

