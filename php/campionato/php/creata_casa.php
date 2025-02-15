<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_casa'])) {
$nome_casa = $_POST['nome_casa'];
$colore_livrea = $_POST['colore_livrea']; // Recupera l'ID della livrea selezionata

if (empty($colore_livrea)) {
$error_message = "Errore: è necessario selezionare un colore livrea.";
} else {
// Controllo se la casa automobilistica esiste già
$query = "SELECT COUNT(*) FROM Case_Automobilistiche WHERE nome = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$nome_casa]);
$count = $stmt->fetchColumn();

if ($count > 0) {
$error_message = "Errore: la casa automobilistica esiste già.";
} else {
// Inserisci la casa automobilistica con il colore della livrea
$query = "INSERT INTO Case_Automobilistiche (nome, livrea_id) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$nome_casa, $colore_livrea]);

header("Location: ../read.php");
exit();
}
}
}
?>
