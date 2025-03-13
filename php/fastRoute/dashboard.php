<?php
// Includiamo la classe Database
include_once 'php/Database.php';

session_start(); // Aggiungiamo la gestione della sessione per il login

// Verifica se l'utente è autenticato come personale
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Se non è autenticato, redirige alla pagina di login
    exit();
}

// Recuperiamo i dati delle spedizioni dal database
$query = "
    SELECT 
        p.id AS plico_id, 
        c.nome AS mittente_nome, 
        c.cognome AS mittente_cognome, 
        d.nome AS destinatario_nome,  
        d.cognome AS destinatario_cognome, 
        s.descrizione AS stato_plico, 
        p.data_ritiro, 
        i.data AS data_spedizione, 
        rr.data AS data_consegna
    FROM Plichi p
    JOIN Spedire sp ON sp.Plichi_id = p.id
    JOIN Clienti c ON c.id = sp.Clienti_id
    JOIN Ritirare r ON r.Plichi_id = p.id
    JOIN Destinatari d ON d.id = r.Destinatari_id
    JOIN Stati s ON s.id = p.Stati_id
    LEFT JOIN Inviare i ON i.Plichi_id = p.id  -- Data di spedizione
    LEFT JOIN Ricevere rr ON rr.Plichi_id = p.id  -- Data di consegna
    ORDER BY p.id DESC
";



$spedizioni = Database::select($query); // Eseguiamo la query per ottenere tutte le spedizioni

?>
<?php include 'php/header.php'; ?>



<!-- Dashboard Content -->
<div class="container my-5">
    <h2>Tabella delle Spedizioni</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID Plico</th>
            <th>Mittente</th>
            <th>Destinatario</th>
            <th>Stato</th>
            <th>Data Spedizione</th>
            <th>Data Consegna</th>
            <th>Data Ritiro</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($spedizioni as $spedizione): ?>
            <tr>
                <td><?= htmlspecialchars($spedizione->plico_id) ?></td>
                <td><?= htmlspecialchars($spedizione->mittente_nome) . ' ' . htmlspecialchars($spedizione->mittente_cognome) ?></td>
                <td><?= htmlspecialchars($spedizione->destinatario_nome) . ' ' . htmlspecialchars($spedizione->destinatario_cognome) ?></td>
                <td><?= htmlspecialchars($spedizione->stato_plico) ?></td>
                <td><?= htmlspecialchars($spedizione->data_spedizione) ?></td>
                <td><?= htmlspecialchars($spedizione->data_consegna) ?></td>
                <td><?= htmlspecialchars($spedizione->data_ritiro) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'php/footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
