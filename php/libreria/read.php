<?php include 'php/header.php'; ?>

<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=libreria", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT libri.ID, libri.titolo, autori.nome AS autore, generi.nome AS genere, 
                 libri.prezzo, libri.anno_pubblicazione
          FROM libri
          JOIN autori ON libri.autore_ID = autori.ID
          JOIN generi ON libri.genere_ID = generi.ID";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Recupero i risultati correttamente
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
                    </tr>
                </thead>
                <tbody>";

    // Loop through the results and display rows
    foreach ($result as $row) {
        echo "<tr>
                <td>{$row['ID']}</td>
                <td>{$row['titolo']}</td>
                <td>{$row['autore']}</td>
                <td>{$row['genere']}</td>
                <td>€{$row['prezzo']}</td>
                <td>{$row['anno_pubblicazione']}</td>
              </tr>";
    }

    echo "</tbody>
          </table>
        </div>";;

} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
}
?>

<?php include 'php/footer.php'; ?>
