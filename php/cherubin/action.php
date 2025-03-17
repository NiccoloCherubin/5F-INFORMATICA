<?php
echo "Niccolò Cherubin 5F fila B"."<br>";

require_once "Azienda.php";

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $nome = $_POST['nome'] ?? null;
    $citta = $_POST['citta'] ?? null;
    $indirizzo = $_POST['indirizzo'] ?? null;
    $telefono = $_POST['telefono'] ?? null;
    $estere = $_POST['estere'] ?? null;
    $NFrancia = $_POST['NFrancia'] ?? null;
    $NSpagna = $_POST['NSpagna'] ?? null;
    $NGermania= $_POST['NGermania'] ?? null;
    $NInghilterra = $_POST['NInghilterra'] ?? null;
    $NUsa = $_POST['NUsa'] ?? null;
}

$az = new Azienda($nome,$citta,$indirizzo,$telefono); // creo oggetto di tipo azienda
$estereReal = []; // contiene estere vere
$cont = 0; // supporto

//verifico se ha inserito almeno una nazione estera
if(is_null($estere) || count($estere) === 0)
{
    echo "Selezionare almeno una nazione estera";
    echo "<a href='index.php'> torna al form";
    exit(-1); // termino il programma nel caso non ci siano nazioni estere

}

//verifico che l'utente abbia inserito massimo 4 nazioni
if(!is_null($estere) && count($estere) > 4)
{
    echo "Selezionare massimo 4 aziende estere";
    echo "<a href='index.php'> torna al form";
    exit(-1); // termino il programma nel caso abbia sbagliato
}

// echo "Sedi selezionate".implode(",",$estere)."<br>"; // stampa delle aziende selezione con la checkbox

$string = "Nome azienda ".$az->getNome().", citta ".$az->getCitta()." indirizzo ".$az->getIndirizzo().", telefono ".$az->getTelefono()." estere ";

echo $string;

echo $estere[0]."<br>";

//controllo se hanno messo le sedi estere e se hanno messo il numero di sedi estere

//controllo francia
if(!is_null($NFrancia) && $NFrancia !== 0 && !FindStringInArray("Francia",$estere,count($estere)))
{
    echo "no sedi in francia"."<br>";
}
else{
    $az->setNFrancia($NFrancia);
    $estereReal[$cont] = "Francia";
    $cont++;
    $string .= " Francia con ".$az->getNFrancia()." sedi";
}
//controllo spagna
if(!is_null($NSpagna) && $NSpagna !== 0 && !FindStringInArray("Spagna",$estere,count($estere)))
{
    echo "no sedi in Spagna"."<br>";
}
else{
    $az->setNSpagna($NSpagna);
    $estereReal[$cont] = "Spagna";
    $cont++;
    $string .= " Spagna con ".$az->getNSpagna()." sedi";
}
//controllo germania
if(!is_null($NGermania) && $NGermania !== 0 && !FindStringInArray("Germania",$estere,count($estere)))
{
    echo "no sedi in Germania"."<br>";
}
else{
    $az->setNGermania($NGermania);
    $estereReal[$cont] = "Germania";
    $cont++;
    $string .= " Germania con ".$az->getNGermania()." sedi";
}
//controllo inghilterra
if(!is_null($NInghilterra) && $NInghilterra !== 0 && !FindStringInArray("Inghilterra",$estere,count($estere)))
{

    echo "no sedi in Inghilterra"."<br>";
}
else{
    $az->setNInghilterra($NInghilterra);
    $estereReal[$cont] = "Inghilterra";
    $cont++;
    $string .= " Inghilterra con ".$az->getNInghilterra()." sedi";
}
//controllo USA
if(!is_null($NUsa) && $NUsa !== 0 && !FindStringInArray("Usa",$estere,count($estere)))
{
    echo "no sedi in Usa"."<br>";
}
else{
    $az->setNUsa($NUsa);
    $estereReal[$cont] = "Usa";
    $cont++;
    $string .= " $NUsa con ".$az->getNUsa()." sedi";
}

$az->setEstere($estereReal);

echo $string; // stampa della stringa finale


//funzione che ricerca una stringa all'interno di un array
function FindStringInArray($string,$array,$lenght) :bool
{
    for($i = 0; $i < $lenght; $i++)
    {
        if($array[$i] === $string)
        {
            return true; //trovata la stringa nell'array
        }
    }
    return false;
}
?>