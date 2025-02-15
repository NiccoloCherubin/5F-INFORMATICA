<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pilota_id = $_POST['pilota_id'];
    $gara_id = $_POST['gara_id'];
    $posizione_finale = $_POST['posizione_finale'];
    $tempo_veloce = $_POST['tempo_veloce'];
    $punti_assegnati = $_POST['punti_assegnati'];

    // Query di inserimento nella tabella Risultati
    $query = "INSERT INTO Risultati (Piloti_id, Gare_id, posizione_finale, tempo_veloce, punti_assegnati) 
              VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute([$pilota_id, $gara_id, $posizione_finale, $tempo_veloce, $punti_assegnati]);
        echo "<script>alert('Pilota associato con successo alla gara!'); window.location.href='../create.php';</script>";
    } catch (PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }
}
?>
