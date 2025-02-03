CREATE DATABASE libreria;
USE libreria;

-- Creazione tabella Autori
CREATE TABLE autori (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL UNIQUE
);

-- Creazione tabella Generi
CREATE TABLE generi (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL UNIQUE
);

-- Creazione tabella Libri
CREATE TABLE libri (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    titolo VARCHAR(100) NOT NULL,
    autore_ID INT NOT NULL,
    genere_ID INT NOT NULL,
    prezzo DOUBLE NOT NULL CHECK(prezzo > 0),
    anno_pubblicazione DATE NOT NULL,
    FOREIGN KEY (autore_ID) REFERENCES autori(ID) ON DELETE CASCADE,
    FOREIGN KEY (genere_ID) REFERENCES generi(ID) ON DELETE CASCADE
);

INSERT INTO autori (nome) VALUES
('Umberto Eco'),
('George Orwell'),
('Dante Alighieri'),
('Jane Austen'),
('J.R.R. Tolkien'),
('J.K. Rowling'),
('F. Scott Fitzgerald'),
('Emily Brontë'),
('Antoine de Saint-Exupéry'),
('Miguel de Cervantes'),
('Franz Kafka'),
('Lev Tolstoj'),
('Bram Stoker'),
('Mary Shelley'),
('Alessandro Manzoni'),
('James Joyce'),
('Richard Bach'),
('Cormac McCarthy'),
('Alexandre Dumas'),
('Luigi Pirandello'),
('Italo Svevo'),
('Ernest Hemingway'),
('Hermann Hesse'),
('Ray Bradbury'),
('Herman Melville'),
('Dino Buzzati'),
('Edmondo De Amicis'),
('Primo Levi'),
('Giovanni Verga'),
('Carlo Levi'),
('Arthur Conan Doyle'),
('Robert Louis Stevenson'),
('Gustave Flaubert'),
('Anonimo'),
('L. Frank Baum'),
('Carlo Collodi'),
('Albert Camus'),
('Victor Hugo'),
('Mario Puzo'),
('Stephen King'),
('Carlos Ruiz Zafón'),
('Dan Brown'),
('Tracy Chevalier');

INSERT INTO generi (nome) VALUES
('Giallo'),
('Distopico'),
('Poesia'),
('Romantico'),
('Fantasy'),
('Classico'),
('Filosofia'),
('Horror'),
('Storico'),
('Avventura'),
('Sperimentale'),
('Post-apocalittico'),
('Crime'),
('Surreale'),
('Educativo');

INSERT INTO libri (titolo, autore_ID, genere_ID, prezzo, anno_pubblicazione) VALUES
('Il nome della rosa', 1, 1, 12.99, '1980-10-01'),
('1984', 2, 2, 9.99, '1949-06-08'),
('La divina commedia', 3, 3, 15.50, '1320-01-01'),
('Orgoglio e pregiudizio', 4, 4, 8.99, '1813-01-28'),
('Il signore degli anelli', 5, 5, 20.00, '1954-07-29'),
('Harry Potter e la pietra filosofale', 6, 5, 10.99, '1997-06-26'),
('Il grande Gatsby', 7, 6, 11.99, '1925-04-10'),
('Cime tempestose', 8, 4, 9.50, '1847-12-01'),
('Il piccolo principe', 9, 7, 7.99, '1943-04-06'),
('Don Chisciotte', 10, 6, 14.75, '1605-01-16'),
('Le metamorfosi', 11, 14, 13.99, '1915-11-01'),
('Anna Karenina', 12, 4, 12.49, '1877-03-01'),
('Dracula', 13, 8, 10.49, '1897-05-26'),
('Frankenstein', 14, 8, 8.99, '1818-01-01'),
('I promessi sposi', 15, 9, 16.00, '1842-01-01'),
('Ulisse', 16, 11, 19.99, '1922-02-02'),
('La fattoria degli animali', 2, 2, 7.50, '1945-08-17'),
('Il gabbiano Jonathan Livingston', 17, 7, 5.99, '1970-01-01'),
('La strada', 18, 12, 12.99, '2006-09-26'),
('Guerra e pace', 12, 9, 18.99, '1869-01-01'),
('Il conte di Montecristo', 19, 10, 13.49, '1844-08-01'),
('Il fu Mattia Pascal', 20, 6, 10.99, '1904-04-01'),
('La coscienza di Zeno', 21, 6, 9.49, '1923-01-01'),
('Il vecchio e il mare', 22, 10, 7.99, '1952-09-01'),
('Il lupo della steppa', 23, 7, 11.50, '1927-01-01'),
('Fahrenheit 451', 24, 2, 8.99, '1953-10-19'),
('Il processo', 11, 14, 14.49, '1925-01-01'),
('Moby Dick', 25, 10, 15.00, '1851-11-14'),
('Il deserto dei Tartari', 26, 6, 12.00, '1940-01-01'),
('Cuore', 27, 15, 9.99, '1886-01-01'),
('Se questo è un uomo', 28, 9, 10.99, '1947-01-01'),
('I Malavoglia', 29, 6, 9.99, '1881-01-01'),
('Cristo si è fermato a Eboli', 30, 9, 10.50, '1945-01-01'),
('Le avventure di Sherlock Holmes', 31, 1, 7.99, '1892-01-01'),
('L’isola del tesoro', 32, 10, 8.99, '1883-01-01'),
('Madame Bovary', 33, 4, 9.50, '1857-01-01'),
('Le mille e una notte', 34, 5, 20.00, '1704-01-01'),
('Il mago di Oz', 35, 5, 6.99, '1900-01-01'),
('Pinocchio', 36, 15, 5.99, '1883-01-01'),
('Lo straniero', 37, 7, 11.99, '1942-01-01'),
('Notre-Dame de Paris', 38, 9, 12.50, '1831-01-01'),
('Il padrino', 39, 13, 13.99, '1969-01-01'),
('Shining', 40, 8, 14.49, '1977-01-01'),
('IT', 40, 8, 18.99, '1986-01-01'),
('Carrie', 40, 8, 9.99, '1974-01-01'),
('Misery', 40, 8, 13.49, '1987-01-01'),
('L’ombra del vento', 41, 1, 10.99, '2001-01-01'),
('Il codice da Vinci', 42, 1, 12.99, '2003-01-01'),
('Inferno', 42, 1, 13.99, '2013-01-01'),
('Angeli e demoni', 42, 1, 11.99, '2000-01-01'),
('Il simbolo perduto', 42, 1, 14.99, '2009-01-01'),
('La ragazza con l’orecchino di perla', 43, 9, 8.99, '1999-01-01');


