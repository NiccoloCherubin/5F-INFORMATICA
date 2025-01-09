<?php
require_once 'Dispositivo.php';
require_once 'Smartphone.php';

$s1 = new Smartphone("Snapdragon 888", "Samsung");
$s2 = new Smartphone("Snapdragon 888", "Samsung");

echo $s1->accendi()."<br>";

// non è possibile creare un oggetto di tipo dispositivo

echo "Confronto '==' tra s1 e s2: " . ($s1 == $s2 ? 'true' : 'false') . "<br>";
echo "Confronto '===' tra s1 e s2: " . ($s1 === $s2 ? 'true' : 'false') . "<br>";

$s1 = $s2;
echo "Confronto '==' tra s1 e s2 dopo assegnazione: " . ($s1 == $s2 ? 'true' : 'false') . "<br>";
echo "Confronto '===' tra s1 e s2 dopo assegnazione: " . ($s1 === $s2 ? 'true' : 'false') . "<br>";

$s3 = clone $s1;
echo "Confronto '==' tra s1 e s3 dopo clonazione: " . ($s1 == $s3 ? 'true' : 'false') . "<br>";
echo "Confronto '===' tra s1 e s3 dopo clonazione: " . ($s1 === $s3 ? 'true' : 'false') . "<br>";

echo "La classe Smartphone esiste? " . (class_exists('Smartphone') ? 'true' : 'false') . "<br>";

echo "Classe dell'oggetto s1: " . get_class($s1) . "<br>";

echo "s1 è un'istanza di Smartphone? " . (is_a($s1, 'Smartphone') ? 'true' : 'false') . "<br>";

echo "s1 ha la proprietà 'cpu'? " . (property_exists($s1, 'cpu') ? 'true' : 'false') . "<br>";

echo "s1 ha il metodo 'accendi'? " . (method_exists($s1, 'accendi') ? 'true' : 'false') . "<br>";

echo "Classe di s1 usando ::class: " . $s1::class . "<br>";