<?php
// Verifica che il modulo sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupero dei dati dal modulo
    $name = $_POST['name'];
    $password = $_POST['password'];
    $comment = $_POST['comment'];
    $gender = $_POST['gender'];
    $interests = $_POST['interests'];
    $city = $_POST['city'];
    $languages = $_POST['languages'];

    // Stampa dei dati
    echo "<h1>Dati Registrati:</h1>";
    echo "<p><strong>Nome:</strong> " . htmlspecialchars($name) . "</p>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($password) . "</p>";
    echo "<p><strong>Commento:</strong> " . nl2br(htmlspecialchars($comment)) . "</p>";
    echo "<p><strong>Sesso:</strong> " . htmlspecialchars($gender) . "</p>";
    // Interessi (checkbox)
    echo "<p><strong>Interessi:</strong> ";
    echo implode(", ", array_map('htmlspecialchars', $interests));
    echo "</p>";

    echo "<p><strong>Città:</strong> " . htmlspecialchars($city) . "</p>";

    // Lingue conosciute (listbox)
    echo "<p><strong>Lingue conosciute:</strong> ";
    echo implode(", ", array_map('htmlspecialchars', $languages));

    echo "</p>";
} else {
    echo "<p>Il modulo non è stato inviato correttamente.</p>";
}
