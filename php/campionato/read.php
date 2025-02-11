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
        </tr>
        </thead>
        <tbody>
        <?php foreach ($piloti as $pilota) : ?>
            <tr>
                <td><?php echo $pilota['id']; ?></td>
                <td><?php echo $pilota['nome']; ?></td>
                <td><?php echo $pilota['cognome']; ?></td>
                <td><?php echo $pilota['numero']; ?></td>
                <td><?php echo $pilota['nazionalita']; ?></td>
                <td><?php echo $pilota['casa_nome']; ?></td>
                <td><?php echo $pilota['livrea']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'php/footer.php'; ?>
