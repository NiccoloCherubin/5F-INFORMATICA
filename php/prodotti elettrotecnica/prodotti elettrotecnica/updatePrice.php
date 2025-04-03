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

// Validate input
$product_id = $_POST['product_id'] ?? null;
$new_price = $_POST['new_price'] ?? null;

if (!$product_id || $new_price === null) {
    header("Location: read.php?error=Dati%20mancanti");
    exit();
}

try {
    // Prepare and execute update statement
    $stmt = Database::connect()->prepare("UPDATE elettrotecnica.prodotti SET costo = :costo WHERE id = :id");
    $stmt->execute([
        'costo' => $new_price,
        'id' => $product_id
    ]);

    // Redirect with success message
    header("Location: read.php?message=Prezzo%20aggiornato%20con%20successo");
    exit();
} catch (Exception $e) {
    // Redirect with error message if update fails
    header("Location: read.php?error=Errore%20durante%20l'aggiornamento%20del%20prezzo:%20" . urlencode($e->getMessage()));
    exit();
}