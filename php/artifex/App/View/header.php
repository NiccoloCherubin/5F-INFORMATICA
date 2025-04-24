<?php
$appConfig= require dirname(__DIR__, 2) . '/appConfig.php';
$baseUrl = $appConfig['baseURL'].$appConfig['prjName'];
$href=$appConfig['baseURL'].$appConfig['prjName'].$appConfig['css'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastRoute - Corriere Espresso</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<!-- Header -->
<header class="bg-primary text-white text-center py-4">
    <h1>Artifex</h1>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index">Artifex</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Pagina di login per il personale -->
                <li class="nav-item"><a class="nav-link" href="login">Login Personale</a></li>
            </ul>
        </div>
    </div>
</nav>





