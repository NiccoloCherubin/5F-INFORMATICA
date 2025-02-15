<?php
include 'php/header.php';
include 'php/db.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultati Gare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Risultati Gare</h2>

    <?php
    // Ottieni tutte le gare
    $query_gare = "SELECT * FROM Gare";
    $stmt_gare = $pdo->query($query_gare);

    while ($gara = $stmt_gare->fetch(PDO::FETCH_ASSOC)) {
        echo "<h3>Gara: " . htmlspecialchars($gara['nome']) . " (Data: " . $gara['data'] . ")</h3>";
        echo "<table class='table table-striped'>";
        echo "<thead>
                <tr>
                    <th>Pilota</th>
                    <th>Numero</th>
                    <th>Casa Automobilistica</th>
                    <th>Tempo Veloce</th>
                    <th>Posizione Finale</th>
                    <th>Punti Assegnati</th>
                </tr>
              </thead>
              <tbody>";

        // Query per ottenere i dati di partecipazione
        $query_partecipazione = "
            SELECT 
                p.nome AS pilota_nome, 
                p.cognome AS pilota_cognome, 
                p.numero, 
                c.nome AS casa_nome,
                pa.posizione_finale,
                pa.tempo_veloce,
                pa.punti_assegnati
            FROM 
                Partecipare pa
            INNER JOIN 
                Piloti p ON pa.Piloti_id = p.id
            INNER JOIN 
                Gare g ON pa.Gare_id = g.id
            INNER JOIN 
                Case_Automobilistiche c ON p.casa_id = c.id
            WHERE 
                pa.Gare_id = :gara_id
            ORDER BY 
                pa.posizione_finale";

        $stmt_partecipazione = $pdo->prepare($query_partecipazione);
        $stmt_partecipazione->execute(['gara_id' => $gara['id']]);

        // Mostra i risultati
        while ($partecipazione = $stmt_partecipazione->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($partecipazione['pilota_nome'] . " " . $partecipazione['pilota_cognome']) . "</td>
                    <td>" . htmlspecialchars($partecipazione['numero']) . "</td>
                    <td>" . htmlspecialchars($partecipazione['casa_nome']) . "</td>
                    <td>" . htmlspecialchars($partecipazione['tempo_veloce']) . "</td>
                    <td>" . htmlspecialchars($partecipazione['posizione_finale']) . "</td>
                    <td>" . htmlspecialchars($partecipazione['punti_assegnati']) . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    }
    ?>
</div>
</body>
</html>
