<?php
namespace App\Model;
require dirname(__DIR__,2). '/Functions/functions.php';
use Exception;
use PDO;

class Tablet
{
    private PDO $db;
    public  function __construct($db) {
        $this->db=$db;
    }
  //metodi che corrispondono al CRUD
    public function showAll():array{
        $listOfTablet=[];
        $query= 'SELECT * FROM Tablet';
        try{
            $stm= $this->db->prepare($query);
            $stm->execute();
            while($product= $stm->fetch()) {
                $listOfTablet[]=$product;
            }
            $stm->closeCursor();

        } catch (Exception $e) {

        }
        return $listOfTablet;
    }

    public function createOne(array $tablet):bool {
        $tabletAttributes= require dirname(__DIR__, 2) . '/App/Attributes/tabletAttributes.php';
        $query =  'INSERT INTO Tablet (Brand, Model, ScreenSize, StorageGB, RAMGB, OS, Price, ReleaseDate) VALUES(:brand, :model, :screenSize, :storageGB, :RAMGB, :OS,:price, :releaseDate)' ;
        try {
            $stmt = $this->db->prepare($query);
            foreach ($tabletAttributes as $tabletAttribute=>$attribute) {
                $stmt->bindValue(':'.$tabletAttribute, $tablet[$tabletAttribute]);
            }
//            $stmt->bindValue(':brand', $tablet['brand']);
//            $stmt->bindValue(':model', $tablet['model']);
//            $stmt->bindValue(':screenSize', $tablet['screensize']);
//            $stmt->bindValue(':storageGB', $tablet['storageGB']);
//            $stmt->bindValue(':RAMGB', $tablet['RAMGB']);
//            $stmt->bindValue(':OS', $tablet['OS']);
//            $stmt->bindValue(':price', $tablet['price']);
//            $stmt->bindValue(':releaseDate', $tablet['releaseDate']);
            if (!$stmt->execute()) {
                throw new Exception("execute error");
            }
            if ($stmt->rowCount() == 0) {
                throw new Exception("row counter error");
            }
            $stmt->closeCursor();
        }
        catch(Exception $e) {
            $stmt->closeCursor();
            logError($e);
            return false;
        }
        return true;
    }

}