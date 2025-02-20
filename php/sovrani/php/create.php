<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data_inizio = $_POST['data_inizio'];
    $data_fine = $_POST['data_fine'];

    // Recupero il numero dell'ultima immagine
    $query = "SELECT MAX(immagine) AS ultima_immagine FROM sovrani";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $immagine = ($row['ultima_immagine'] ?: 0) + 1;

    // Caricamento immagine
    $estensione = '';
    if (!empty($_FILES['immagine']['name'])) {
        // Controllo estensione
        $estensione = pathinfo($_FILES['immagine']['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Estensioni permesse
        if (!in_array(strtolower($estensione), $allowed_extensions)) {
            die("Estensione immagine non valida.");
        }

        // Rinomina e sposta l'immagine
        $nome_file = $immagine . '.' . $estensione;
        $percorso_destinazione = "../images/" . $nome_file;
        if (!move_uploaded_file($_FILES['immagine']['tmp_name'], $percorso_destinazione)) {
            die("Errore durante il caricamento dell'immagine.");
        }
    }

    // Inserimento del nuovo sovrano
    $stmt = $pdo->prepare("INSERT INTO sovrani (nome, data_inizio, data_fine, immagine, estensione, sovrano_precendente, sovrano_successivo) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Inizializza i campi sovrano_precendente e sovrano_successivo a NULL
    $sovrano_precendente = NULL;
    $sovrano_successivo = NULL;

    if ($stmt->execute([$nome, $data_inizio, $data_fine, $immagine, $estensione, $sovrano_precendente, $sovrano_successivo])) {
        // Redirigi alla pagina di visualizzazione dopo l'inserimento
        header("Location: ../visualizza.php");
        exit();
    } else {
        echo "Errore durante l'aggiunta del sovrano.";
    }
}
?>
