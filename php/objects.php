<?php

require_once "Persona.php"; // per importare la calsse
require_once "Volunteer.php"; // per importare la calsse
require_once "studente.php"; // per importare la calsse
require_once "insegnante.php"; // per importare la calsse


$persona1 = new Persona("grappeggia","grapp@iisviola",18);
echo $persona1->getName()."<br>";
echo $persona1->introduce()."<br>";

$s1 = new Student("fuso","fuso@fuso",18,"iis viola");

echo $s1->introduce()."<br>" ;

$ins1 = new insegnante("emiliano","spiller");
$ins2 = new insegnante("emiliano","spiller");
$ins3 = new insegnante("emiliano","spiller");

echo insegnante::getRegister();