<?php

// Classe che gestisce una lista di utenti
class UserList {
    private $users = [];

    // Aggiunge un nuovo utente alla lista
    public function addUser($username, $email) {
        $this->users[] = [
            'username' => $username,
            'email' => $email,
            'is_active' => true
        ];
    }

    // Usa un generatore per restituire gli utenti uno alla volta
    public function getUsers() {
        foreach ($this->users as $user) {
            yield $user;
        }
    }

    // Restituisce i dati di un utente specifico
    public function getUserData($username) {
        foreach ($this->users as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        return null; // Utente non trovato
    }

    // Simula l'attivazione di un utente
    public function activateUser($username) {
        foreach ($this->users as &$user) {
            if ($user['username'] === $username) {
                $user['is_active'] = true;
                return "Utente $username attivato.";
            }
        }
        return "Utente non trovato.";
    }
}

// Crea un'istanza della lista utenti
$userList = new UserList();

// Aggiungi alcuni utenti alla lista
$userList->addUser("utente1", "utente1@example.com");
$userList->addUser("utente2", "utente2@example.com");
$userList->addUser("utente3", "utente3@example.com");

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utenti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f9;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
        pre {
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<h1>Gestione Utenti</h1>

<h2>Elenco Utenti</h2>
<table>
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Stato</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($userList->getUsers() as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['is_active'] ? 'Attivo' : 'Inattivo' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2>Dati dell'utente (utente2)</h2>
<?php
$userData = $userList->getUserData("utente2");
if ($userData) {
    echo "<h3>Informazioni dell'utente in formato JSON</h3>";
    echo "<pre>" . json_encode($userData, JSON_PRETTY_PRINT) . "</pre>";
} else {
    echo "<p>Utente non trovato.</p>";
}
?>

<h2>Attivazione Utente</h2>
<?php
echo "<p>" . $userList->activateUser("utente3") . "</p>";
?>

<h2>Elenco Utenti Dopo Attivazione</h2>
<table>
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Stato</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($userList->getUsers() as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['is_active'] ? 'Attivo' : 'Inattivo' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<button class="button" onclick="window.location.reload();">Ricarica la pagina</button>

</body>
</html>
