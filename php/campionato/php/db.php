<?php
$host = "localhost"; // o l'indirizzo del tuo server MySQL
$dbname = "Campionato_Automobilistico";
$username = "root"; // o il tuo username MySQL
$password = ""; // o la tua password MySQL

try {
    // Connessione al database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
