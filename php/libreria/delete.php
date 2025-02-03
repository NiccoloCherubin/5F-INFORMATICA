<?php include "php/db.php"; ?>

<?php
    $id = $_GET['id'];

    try {
        // Query per eliminare il libro dal database
        $query = "DELETE FROM libri WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Esegui la query
        $stmt->execute();

        // Reindirizza alla pagina di visualizzazione dei libri
        header("Location: read.php");
        exit();

    } catch (PDOException $e) {
        // Se c'è un errore, mostra il messaggio
        echo "Errore: " . $e->getMessage();
    }
?>
