<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastRoute - Corriere Espresso</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex flex-column min-vh-100">
<!-- Header -->
<header class="bg-primary text-white text-center py-4">
    <h1>FastRoute - Corriere Espresso</h1>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">FastRoute</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Pagina di login per il personale -->
                <li class="nav-item"><a class="nav-link" href="login.php">Login Personale</a></li>

                <!-- Pagina per la gestione dei plichi:
                     - Registra una spedizione (associa plico al cliente e sede di partenza)
                     - Registra una consegna (aggiorna lo stato del plico) -->
                <li class="nav-item"><a class="nav-link" href="gestione_plichi.php">Gestione Plichi</a></li>

                <!-- Pagina per registrare il ritiro di un plico da parte del destinatario -->
                <li class="nav-item"><a class="nav-link" href="ritiro.php">Registra Ritiro</a></li>

                <!-- Dashboard per visualizzare tutte le spedizioni con dettagli:
                     - Mittente, destinatario, stato attuale, date di consegna/spedizione/ritiro
                     - Ricerca e filtri per monitorare le spedizioni negli ultimi N giorni -->
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard Spedizioni</a></li>

                <!-- Pagina per la gestione del personale (solo per responsabili):
                     - Aggiungere/modificare dipendenti
                     - Cambiare password e ruoli -->
                <li class="nav-item"><a class="nav-link" href="gestione_personale.php">Gestione Personale</a></li>

                <!-- Pagina del profilo personale:
                     - Cambiare password
                     - Selezionare il tema grafico preferito (scelta salvata per sessioni future)
                     - Salvare le credenziali per accesso automatico -->
                <li class="nav-item"><a class="nav-link" href="profilo.php">Profilo</a></li>
            </ul>
        </div>
    </div>
</nav>


