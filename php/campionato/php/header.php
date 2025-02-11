<?php
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campionato Automobilistico</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex flex-column min-vh-100">
<!-- Header -->
<header class="bg-primary text-white text-center py-4">
    <h1>Campionato Automobilistico</h1>
    <p>Gestisci Gare, Piloti e Case Automobilistiche</p>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="create.php">Aggiungi</a></li>
                <li class="nav-item"><a class="nav-link" href="read.php">Visualizza Piloti</a></li>
                <li class="nav-item"><a class="nav-link" href="gare.php">Visualizza Gare</a></li>
                <li class="nav-item"><a class="nav-link" href="risultati.php">Visualizza Risultati</a></li>
            </ul>
        </div>
    </div>
</nav>
