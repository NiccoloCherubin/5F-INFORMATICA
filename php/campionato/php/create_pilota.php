<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_pilota'])) {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $numero = $_POST['numero'];
    $nazionalita_id = $_POST['nazionalita_id'];
    $casa_id = $_POST['casa_id'];

    $query = "SELECT COUNT(*) FROM Piloti WHERE numero = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$numero]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error_message = "Errore: il numero del pilota è già stato utilizzato.";
    } else {
        $query = "INSERT INTO Piloti (nome, cognome, numero, nazionalita_id, casa_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nome, $cognome, $numero, $nazionalita_id, $casa_id]);
        header("Location: ../read.php");
        exit();
    }
}
?>
