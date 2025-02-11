<?php
$host = 'localhost'; // o l'indirizzo del tuo server
$dbname = 'Campionato_Automobilistico'; // il nome del tuo database
$username = 'root'; // il tuo username del DB
$password = ''; // la tua password del DB

// Creazione della connessione
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
