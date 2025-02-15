<?php
include 'php/db.php';
include 'php/header.php';

$query = "SELECT p.id, p.nome, p.cognome, n.descrizione AS nazionalita, p.numero, ca.nome AS casa_nome, cl.descrizione AS livrea 
          FROM campionato_automobilistico.piloti p
          JOIN campionato_automobilistico.nazionalita n ON p.nazionalita_id = n.id
          JOIN campionato_automobilistico.case_automobilistiche ca ON p.casa_id = ca.id 
          JOIN campionato_automobilistico.colore_livree cl ON ca.livrea_id = cl.id";

$stmt = $pdo->query($query);
$piloti = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Elenco dei Piloti</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Numero</th>
            <th>Nazionalità</th>
            <th>Casa Automobilistica</th>
            <th>Livrea</th>
            <th>Azioni</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($piloti as $pilota) {
            echo "<tr>
                    <td>{$pilota['id']}</td>
                    <td>{$pilota['nome']}</td>
                    <td>{$pilota['cognome']}</td>
                    <td>{$pilota['numero']}</td>
                    <td>{$pilota['nazionalita']}</td>
                    <td>{$pilota['casa_nome']}</td>
                    <td>{$pilota['livrea']}</td>
                    <td>
                        <a href='update.php?id={$pilota['id']}' class='btn btn-warning btn-sm'>Modifica</a>
                        <a href='delete.php?id={$pilota['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Sei sicuro di voler eliminare questo pilota?\")'>Elimina</a>
                    </td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php include 'php/footer.php'; ?>
