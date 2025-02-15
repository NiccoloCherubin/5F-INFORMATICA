<?php
include 'php/db.php';
include 'php/header.php';

// Query per ottenere le gare dal database
$query = "SELECT g.id, g.nome AS gara_nome, g.data, GROUP_CONCAT(CONCAT(p.nome, ' ', p.cognome) SEPARATOR ', ') AS piloti
          FROM campionato_automobilistico.gare g
          LEFT JOIN campionato_automobilistico.partecipare p_g ON g.id = p_g.Gare_id
          LEFT JOIN campionato_automobilistico.piloti p ON p_g.Piloti_id = p.id
          GROUP BY g.id";

$stmt = $pdo->query($query);
$gare = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Elenco delle Gare</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome Gara</th>
            <th>Data</th>
            <th>Piloti Partecipanti</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($gare as $gara) {
            echo "<tr>
                    <td>{$gara['id']}</td>
                    <td>{$gara['gara_nome']}</td>
                    <td>" . date('d-m-Y', strtotime($gara['data'])) . "</td>
                    <td>{$gara['piloti']}</td>                    
                  </tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php include 'php/footer.php'; ?>
