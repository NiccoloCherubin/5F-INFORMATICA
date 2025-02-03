<?php
// Verifica se l'ID è presente e valido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID non valido.");
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=libreria", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "delete from libri where id = '$id'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //reindirizza alla pagina di visualizzazione
    header("Location: read.php");
    exit();

}
catch (PDOException $e) {
    echo $e->getMessage();
}
?>

