<?php
session_start();

// Controllo se la sessione è scaduta (60 secondi)
if (!isset($_SESSION['start_time']) || (time() - $_SESSION['start_time'] > 60)) {
    session_unset();
    session_destroy();
    echo '<!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sessione Scaduta</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>Sessione Scaduta!</h1>
            <p>Il tempo per compilare il modulo è scaduto.<br> Torna alla pagina iniziale per riprovare.</p>
            <a href="index.php">Torna alla pagina iniziale</a>
        </div>
    </body>
    </html>';
    exit;
}

// Controllo se sono stati inviati dati validi
if (!isset($_POST['voti']) || !is_array($_POST['voti'])) {
    echo '<!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Errore</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>Errore!</h1>
            <p>Nessun dato valido ricevuto.</p>
            <a href="index.php">Torna alla pagina iniziale</a>
        </div>
    </body>
    </html>';
    exit;
}

// Recupero dei voti e validazione
$voti = $_POST['voti'];
$risultati = [];

foreach ($voti as $citta => $voto) {
    if (is_numeric($voto) && $voto >= 1 && $voto <= 5) {
        $risultati[$citta] = (int) $voto;
    }
}

// Controllo se almeno una città è stata votata
if (empty($risultati)) {
    echo '<!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Errore</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>Errore!</h1>
            <p>Devi valutare almeno una città.</p>
            <a href="index.php">Torna alla pagina iniziale</a>
        </div>
    </body>
    </html>';
    exit;
}

// Ordina i risultati dal voto più alto al più basso
arsort($risultati);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classifica delle Città</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Classifica delle Città Valutate</h1>
    <table border="1">
        <tr>
            <th>Città</th>
            <th>Voto</th>
        </tr>
        <?php foreach ($risultati as $citta => $voto) : ?>
            <tr>
                <td><?= htmlspecialchars($citta) ?></td>
                <td><?= $voto ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Torna alla pagina iniziale</a>
</div>
</body>
</html>
