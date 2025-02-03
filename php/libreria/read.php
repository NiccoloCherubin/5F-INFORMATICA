<?php include 'php/header.php'; ?>
<?php include "php/db.php"; ?>
<?php
try {
    $query = "SELECT libri.ID, libri.titolo, autori.nome AS autore, generi.nome AS genere, 
                 libri.prezzo, libri.anno_pubblicazione
          FROM libri
          JOIN autori ON libri.autore_ID = autori.ID
          JOIN generi ON libri.genere_ID = generi.ID
          ORDER BY libri.ID ASC";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<link rel='stylesheet' href='css/read.css'>";

    echo "<div class='table-responsive'>
            <table class='table table-striped table-hover table-bordered'>
                <thead class='table-dark'>
                    <tr>
                        <th>ID</th>
                        <th>Titolo</th>
                        <th>Autore</th>
                        <th>Genere</th>
                        <th>Prezzo</th>
                        <th>Anno di Pubblicazione</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>";

    foreach ($result as $row) {
        echo "<tr>
                <td>{$row['ID']}</td>
                <td>{$row['titolo']}</td>
                <td>{$row['autore']}</td>
                <td>{$row['genere']}</td>
                <td>€{$row['prezzo']}</td>
                <td>{$row['anno_pubblicazione']}</td>
                <td>
                    <a href='update.php?id={$row['ID']}' class='btn btn-warning btn-sm'>Modifica</a>
                    <a href='delete.php?id={$row['ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Sei sicuro di voler eliminare questo libro?\")'>Elimina</a>
                </td>
              </tr>";
    }

    echo "</tbody>
          </table>
        </div>";

} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
}
?>

<?php include 'php/footer.php'; ?>
