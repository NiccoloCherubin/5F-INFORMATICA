<?php
include_once 'php/Database.php';
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['ruolo_id']) || $_SESSION['ruolo_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: read.php?error=Invalid%20product%20ID");
    exit();
}

$product_id = $_GET['id'];

try {
    // Prepare and execute delete statement
    $stmt = Database::connect()->prepare("DELETE FROM elettrotecnica.prodotti WHERE id = :id");
    $stmt->execute(['id' => $product_id]);

    // Redirect with success message
    header("Location: read.php?message=Prodotto%20eliminato%20con%20successo");
    exit();
} catch (Exception $e) {
    // Redirect with error message if deletion fails
    header("Location: read.php?error=Errore%20durante%20l'eliminazione%20del%20prodotto:%20" . urlencode($e->getMessage()));
    exit();
}