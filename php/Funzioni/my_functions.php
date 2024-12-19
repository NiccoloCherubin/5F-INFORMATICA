<?php

declare(strict_types=1);

function average(?int $a, int $b, int|float $c): int|string|float
{
    if ($a == null){
        return "finito";
    }
    return ($a+$b+$c)/3;
}

echo average(10,20,30.99);
echo "<br>";
echo average(null,20,30.99);