<?php
$names = [
    "bob",
    "lucy",
    "mary",
    "Anthony",
];

$names[] = "kamala"; // aggiunto un nome

for($i = 0; $i < count($names); $i++)
    {
        echo $names[$i]."<br>";
    }

var_dump($names); //utile per debug

foreach ($names as $name)
{
    echo $name."<br>";
}

unset($names[2]);

var_dump($names); //utile per debug

echo "<br>";

foreach ($names as $name)
{
    echo $name."<br>";
}


for($i = 0; $i < count($names); $i++)
{
    if(isset($names[$i]))
    {
        echo $names[$i]."<br>";
    }
}

echo "<br>";
echo "con array values"."<br>";
echo "<br>";


$newarray = array_values($names);

for($i = 0; $i < count($names); $i++)
{
    echo $newarray[$i]."<br>";
}

var_dump($newarray); //utile per debug


//array associativi
$students = [
    'Alice' => '5',
    'Bob' => '8',
    'Marley' => '7',

];
foreach ($students as $case=>$value)
{
    echo $case." ".$value." "."<br>";
}


// date and time
/*c'è il modo legacy(quello vecchio) che usa time_stamp. Questo prima di php 5.0
approccio nuovo usa le classi.
*/
$now = new DateTime();
$data = new DateTime('+1 year +8 month');
$data2 = new DateTime('+1 year +8 month +80day');
echo $data->format("y/m/d;h:i:s")."<br>";
$interval = $data->diff($data2);

echo "Differenza: " . $interval->format("%y years, %m months, %d days")."<br>";

$intervalTime = new DateInterval('P3Y4D');
echo $intervalTime->format('%Y anni, %D giorni')."<br>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

/*FILES*/

echo "FILE"."<br>";

echo getcwd()."<br>";

echo is_file(getcwd().DIRECTORY_SEPARATOR."PROVA.TXT") ? 'file trovato'."<br>" : 'file non trovato'."<br>";

echo is_dir(getcwd().DIRECTORY_SEPARATOR."cartella") ? 'cartella trovata'."<br>" : 'cartella non trovata'."<br>";

// Definisce il percorso della cartella
$directory = getcwd() . DIRECTORY_SEPARATOR . "cartella"; // Percorso completo della cartella

// Verifica se la cartella esiste
if (is_dir($directory)) {
    // Ottieni gli elementi della cartella
    $items = scandir($directory);

    // Verifica che scandir() non abbia restituito false
    if ($items !== false) {
        // Inizia la lista HTML
        echo "<ul>";

        // Itera sugli elementi della cartella
        foreach ($items as $item) {
            // Ignora i valori "." e ".."
            if ($item != "." && $item != "..") {
                // Stampa l'elemento della cartella come un elemento di lista
                echo "<li>" . $item . "</li>";
            }
        }

        // Chiude la lista HTML
        echo "</ul>";
    } else {
        // Se scandir non ha funzionato, mostra un messaggio di errore
        echo "Errore nell'aprire la cartella.";
    }
} else {
    // Se la cartella non esiste, mostra un messaggio di errore
    echo "La cartella 'cartella' non esiste.";
}





