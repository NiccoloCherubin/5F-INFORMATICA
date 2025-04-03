<?php
include_once 'php/Database.php';
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['ruolo_id']) || $_SESSION['ruolo_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: read.php?error=Metodo%20non%20consentito");
    exit();
}

// Validate and sanitize input
$descrizione = $_POST['descrizione'] ?? '';
$costo = $_POST['costo'] ?? 0;
$quantita = $_POST['quantita'] ?? 0;
$data_produzione = $_POST['data_produzione'] ?? date('Y-m-d');

if (empty($descrizione)) {
    header("Location: read.php?error=Descrizione%20obbligatoria");
    exit();
}

try {
    // Prepare and execute insert statement
    $stmt = Database::connect()->prepare("INSERT INTO elettrotecnica.prodotti (descrizione, costo, quantita, data_produzione) VALUES (:descrizione, :costo, :quantita, :data_produzione)");
    $stmt->execute([
        'descrizione' => $descrizione,
        'costo' => $costo,
        'quantita' => $quantita,
        'data_produzione' => $data_produzione
    ]);

    // Redirect with success message
    header("Location: read.php?message=Prodotto%20aggiunto%20con%20successo");
    exit();
} catch (Exception $e) {
    // Redirect with error message if insertion fails
    header("Location: read.php?error=Errore%20durante%20l'aggiunta%20del%20prodotto:%20" . urlencode($e->getMessage()));
    exit();
}