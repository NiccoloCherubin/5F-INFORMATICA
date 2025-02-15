<?php
include 'php/db.php';
include 'php/header.php';

$query = "SELECT Piloti.id, Piloti.nome, Piloti.cognome, Piloti.numero, Nazionalita.descrizione AS nazionalita, 
                 Case_Automobilistiche.nome AS casa_nome, Colore_Livree.descrizione AS livrea 
          FROM Piloti 
          JOIN Nazionalita ON Piloti.nazionalita_id = Nazionalita.id
          JOIN Appartenere ON Piloti.id = Appartenere.Piloti_id
          JOIN Case_Automobilistiche ON Appartenere.casa_id = Case_Automobilistiche.id
          JOIN Decidere ON Case_Automobilistiche.id = Decidere.casa_id
          JOIN Colore_Livree ON Decidere.livrea_id = Colore_Livree.id";

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
            <th>Azioni</th> <!-- Aggiunta colonna per i tasti -->
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
