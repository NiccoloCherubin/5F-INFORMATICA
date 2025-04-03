<?php
session_start();
$_SESSION['start_time'] = time(); // salva l'orario di inizio sessione

$citta = require 'citta.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valutazione Servizi Città</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Timer di 60 secondi per la sessione
        let tempoRimasto = 60;
        function aggiornaTimer() {
            document.getElementById("timer").innerText = "Tempo rimasto: " + tempoRimasto + " secondi"; //mostra all'utente il tempo rimanente
            if (tempoRimasto <= 0) {
                document.getElementById("formValutazione").submit(); // invia automaticamente il form alla scadenza
            } else {
                tempoRimasto--; //decrementa il timer
                setTimeout(aggiornaTimer, 1000); //aggiorna timer
            }
        }
        window.onload = aggiornaTimer;
    </script>
</head>
<body>

<h1>Valuta i Servizi delle Città</h1>
<p id="timer"></p>

<form id="formValutazione" action="action_page.php" method="post">
    <?php foreach ($citta as $nomeCitta) { ?>  <!-ciclo per valutare tutte le citta->
        <label><?= $nomeCitta ?>: </label>
        <input type="number" name="voti[<?= $nomeCitta ?>]" min="1" max="5"><br><br> <!-valutazione di una citta->
    <?php } ?>
    <input type="submit" value="Invia Valutazione">
</form>

</body>
</html>
