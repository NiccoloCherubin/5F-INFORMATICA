<?php
$db = new PDO('mysql:host=localhost;dbname=dbitis', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // da eccezione nel caso di errori
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ // trasforma tuple in oggetti
]);
/*try {
    // var_dump($db);
    echo $db->getAttribute(PDO::ATTR_DRIVER_NAME) . "<br>";
    //echo $db->getAttribute(PDO::ATTR_ERRMODE)."<br>";
    //echo $db->getAttribute(PDO::ATTR_SERVER_INFO)."<br>";

    // READ da DB

    $query = 'select * from studenti';

    $stm = $db->prepare($query); // rende la query vera e propria
    $stm->execute(); // esegue le query

    while ($student = $stm->fetch()) {
        echo 'matricola: ', $student->matricola_studente . "<br>";
        echo 'nome: ', $student->nome . "<br>";
        echo 'cognome: ', $student->cognome . "<br>";
        echo 'data_iscrizione: ', $student->data_iscrizione . "<br>";
        echo 'media: ', $student->media . "<br>";
        echo '<hr>';
    }
    $stm->closeCursor();
} catch (PDOException $e) {
    echo "errore:" . $e->getMessage();
}
/*
try {
    // var_dump($db);
    echo $db->getAttribute(PDO::ATTR_DRIVER_NAME) . "<br>";
    //echo $db->getAttribute(PDO::ATTR_ERRMODE)."<br>";
    //echo $db->getAttribute(PDO::ATTR_SERVER_INFO)."<br>";

    // READ da DB

    $query = 'select media,cognome from student where nome=:name';
    $stm = $db->prepare($query);
    $stm->bindValue(':name', 'Antonella');
    $stm->execute(); // esegue le query


    while ($student = $stm->fetch()) {
        echo 'matricola: ', $student->matricola_studente . "<br>";
        echo 'nome: ', $student->nome . "<br>";
        echo '<hr>';
    }
} catch (PDOException $e) {
    //echo "errore:" . $e->getMessage();
    logError($e);
}
$stm->closeCursor();
*/

// CREATE

/*
try {
$query = "insert into studenti(matricola_studente,nome,cognome,data_iscrizione,media) VALUES (:matricola,:nome,:cognome,now(),:media);";
$stm = $db->prepare($query);
$stm->bindValue(':matricola','00052');
    $stm->bindValue(':nome','Lucy');
    $stm->bindValue(':cognome','Taylor');
    $stm->bindValue(':media',8.3);

    if($stm->execute())
    {
        $stm->closeCursor();
        echo "TUTTO OK";
    }
    else{
        throw PDOException('Studente non inserito correttamente');
    }
}
catch (PDOException $e)
{
    logError($e);
}*/

// UPDATE

/*try {
    $query = "update studenti set media=:media where nome=:name";
    $stm = $db->prepare($query);
    $stm->bindValue(':name','Lucy');
    $stm->bindValue(':media',1.3);

    if($stm->execute())
    {
        $stm->closeCursor();
        echo "TUTTO OK";
    }
    else{
        throw PDOException('Studente non inserito correttamente');
    }

}catch (PDOException $e)
{
    logError($e);
}*/

// DELETE

try {
    $query = "delete from studenti where nome=:name";
    $stm = $db->prepare($query);
    $stm->bindValue(':name','Lucy');
    if($stm->execute())
    {
        $stm->closeCursor();
        echo "TUTTO OK";
    }
    else{
        throw PDOException('Studente non inserito correttamente');
    }

}catch (PDOException $e)
{
    logError($e);
}

function logError(Exception $e) : void
{
    echo "error. riprova dopo"; // per l'utente

    error_log('errore: '.$e->getMessage().'--'.date('Y-M-D- h:i:s')."\n",3,'log/errorLogFIle.log');
}