<?php
include "php/header.php";
include "php/db.php";

// Ottieni tutti i sovrani
$query = "SELECT * FROM sovrani ORDER BY data_inizio ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$sovrani = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <h2 class="mb-4">Lista dei Sovrani</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Data Inizio</th>
            <th>Data Fine</th>
            <th>Immagine</th>
            <th>Sovrano Precedente</th>
            <th>Sovrano Successivo</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Ciclo per aggiornare i sovrani
        for ($i = 0; $i < count($sovrani); $i++) {
            $sovrano = $sovrani[$i];

            // Il sovrano precedente è quello immediatamente precedente nell'array
            $sovrano_precedente = $i > 0 ? $sovrani[$i - 1]['nome'] : 'Nessuno';

            // Il sovrano successivo è quello immediatamente successivo nell'array
            $sovrano_successivo = $i < count($sovrani) - 1 ? $sovrani[$i + 1]['nome'] : 'Nessuno';

            echo "<tr>";
            echo "<td>{$sovrano['nome']}</td>";
            echo "<td>{$sovrano['data_inizio']}</td>";
            echo "<td>{$sovrano['data_fine']}</td>";
            echo "<td><img src='images/{$sovrano['immagine']}.{$sovrano['estensione']}' width='50'></td>";
            echo "<td>{$sovrano_precedente}</td>";
            echo "<td>{$sovrano_successivo}</td>";
            echo "</tr>";


        }
        ?>
        </tbody>
    </table>
</div>

<?php include 'php/footer.php'; ?>
