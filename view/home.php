<?php

require "header.php";
require "footer.php";

// READ da DB
    $db = new PDO('mysql:host=localhost;dbname=dbitis', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // da eccezione nel caso di errori
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ // trasforma tuple in oggetti
]);
    try{

    $query = 'select * from studenti';
    $stm = $db->prepare($query);
    $stm->execute(); // esegue le query

        ob_start(); // apre buffer in memoria e tutte le cose vanno nel buffer

    while ($student = $stm->fetch()) {
        echo 'matricola: ', $student->matricola_studente . "<br>";
        echo 'nome: ', $student->nome . "<br>";
        echo '<hr>';
    }

    $content = ob_get_contents();
    ob_end_clean();
} catch (PDOException $e) {
    //echo "errore:" . $e->getMessage();
    logError($e);
}
$stm->closeCursor();

function logError(Exception $e) : void
{
    echo "error. riprova dopo"; // per l'utente

    error_log('errore: '.$e->getMessage().'--'.date('Y-M-D- h:i:s')."\n",3,'log/errorLogFIle.log');
}
?>
<div>
    <p> <?=$content?></p>
</div>
