<?php
require 'utente.php'; // aggiungo la classe al file


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'] ?? "errore";
    $password   = $_POST['password'] ?? "errore";
    $eta = $_POST['eta'] ?? 0;
    $sesso = $_POST['sesso'] ?? "errore";
    $colori = $_POST['colori'] ?? null;

    $bg = $_POST['bg'] ?? 'white';
    setcookie("bg",$bg); // salvo il background color nei cookie
}
else{
    echo "errore con dati form";
}

echo "<body style='background-color:$bg;'>"; // prende sfondo da cookie

$user1 = new Utente($email, $eta,$password, $sesso,$colori);

$user1->saluta();
echo "<br>";

//spaceship operator
$num1 = 10;
$num2 = 20;
if(($num1 <=> $num2) == -1){
    $max = $num2;
}
elseif (($num1 <=> $num2) == 1)
{
    $max = $num1;
}
else
{
    $max = "i numeri sono uguali";
}
echo $max;

echo "<br>";

$array_Assoc = [
    'fuso' => 'merda',
    'francesca' => 8,
    'armando' => ['culo','spagna','pisello','uccello',69]
    ];

foreach ($array_Assoc as $key=>$value) {

    if(is_array($value)){ // verifica se contenuto è un array
        foreach ($value as $var=>$item) { // stampa contenuto array nell'array
            echo "chiave:$var valore:$item"."<br>";
        }
    }
    else{
        echo "chiave:$key valore:$value"."<br>";
    }
}
$string = "ciao";

$string = str_replace('c','z',$string);
echo $string;

echo "<br>";
// funzione callback => funzione che chiama altra funzione
echo fuzione1(fuzione2(4,5),10);

function fuzione1($num4,$num5) :int
{
    return $num4 + $num5;
}
function fuzione2($num4,$num5) :int
{
    return $num4 * $num5;
}
?>