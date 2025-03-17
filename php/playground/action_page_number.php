<?php
$numeri = $_POST["numero"];
if(isset($numeri) && isset($_POST["rip"]))
    for ($i = 0; $i < $_POST['rip']; $i++) {
        echo $numeri[$i] . "<br>";
}