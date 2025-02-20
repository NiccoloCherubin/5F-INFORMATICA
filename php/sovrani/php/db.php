<?php
$host = 'localhost'; // o l'indirizzo del server
$dbname = 'utopia'; // il nome del database
$username = 'root'; // username del DB
$password = ''; // password del DB

// Creazione della connessione
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
