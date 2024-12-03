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
