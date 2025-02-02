<?php include "header.php" ?>
<?php
try {

    $pdo = new PDO("mysql:host=localhost;dbname=libreria", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "insert into informatica(nombre, descripcion) values(:nombre, :descripcion)";

}catch (PDOException $e){

    echo $e->getMessage();
}
?>
<?php include "footer.php" ?>
