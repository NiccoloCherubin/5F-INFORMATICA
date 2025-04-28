<?php
namespace App\Controller;

require_once dirname(__DIR__) . '/Model/Visita.php';
require_once dirname(__DIR__) . '/Model/Utente.php';

use App\Model\Visita;
use App\Model\Utente;
use PDO;

class VisiteController
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Mostra l'elenco delle visite
     */
    public function index()
    {
        $searchTerm = $_GET['search'] ?? null;

        if ($searchTerm) {
            $visite = Visita::search($this->db, $searchTerm);
        } else {
            $visite = Visita::getAll($this->db);
        }

        // Passa i dati alla vista
        extract(['visite' => $visite, 'searchTerm' => $searchTerm]);

        // Carica la vista
        require_once 'App/view/visite.php';
    }

    /**
     * Mostra i dettagli di una visita specifica
     */
    public function show()
    {
        $visita = new Visita($this->db);
        $visita = $visita->fromID($_GET['id']);

        if (!$visita) {
            // Visita non trovata, reindirizza all'elenco
            header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'home/visite');
            exit;
        }

        $postiDisponibili = $visita->hasPostiDisponibili();
        $numeroPrenotazioni = $visita->countPrenotazioni();

        // Controlla se l'utente corrente ha già prenotato questa visita
        $prenotataUtente = false;
        if (isset($_SESSION['user_id'])) {
            $prenotataUtente = $visita->isPrenotataByUtente($_SESSION['user_id']);
        }

        // Passa i dati alla vista
        extract([
            'visita' => $visita,
            'postiDisponibili' => $postiDisponibili,
            'numeroPrenotazioni' => $numeroPrenotazioni,
            'prenotataUtente' => $prenotataUtente
        ]);

        // Carica la vista
        require_once 'App/view/visita.php';
    }

    /**
     * Prenota una visita per l'utente corrente
     */
    public function prenota($id)
    {
        if (!isset($_SESSION['user_id'])) {
            // Reindirizza l'utente alla pagina di login
            header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'home/login');
            exit;
        }

        $visita = new Visita($this->db);
        $visita = $visita->fromID($id);

        if (!$visita) {
            // Visita non trovata, reindirizza all'elenco
            header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'home/visite');
            exit;
        }

        // Verifica se ci sono posti disponibili
        if (!$visita->hasPostiDisponibili()) {
            $_SESSION['error'] = 'Non ci sono più posti disponibili per questa visita';
            header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'visite/dettaglio/' . $id);
            exit;
        }

        // Verifica se l'utente ha già prenotato questa visita
        if ($visita->isPrenotataByUtente($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Hai già prenotato questa visita';
            header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'visite/dettaglio/' . $id);
            exit;
        }

        $result = $visita->prenota($_SESSION['user_id']);

        if ($result) {
            $_SESSION['success'] = 'Prenotazione effettuata con successo';
        } else {
            $_SESSION['error'] = 'Errore durante la prenotazione';
        }

        header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'visite/dettaglio/' . $id);
        exit;
    }

    /**
     * Cancella la prenotazione di una visita per l'utente corrente
     */
    public function cancellaPrenotazione($id)
    {
        if (!isset($_SESSION['user_id'])) {
            // Reindirizza l'utente alla pagina di login
            header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'home/login');
            exit;
        }

        $visita = new Visita($this->db);
        $visita = $visita->fromID($id);

        if (!$visita) {
            // Visita non trovata, reindirizza all'elenco
            header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'home/visite');
            exit;
        }

        $result = $visita->cancellaPrenotazione($_SESSION['user_id']);

        if ($result) {
            $_SESSION['success'] = 'Prenotazione cancellata con successo';
        } else {
            $_SESSION['error'] = 'Errore durante la cancellazione della prenotazione';
        }

        header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'visite/dettaglio/' . $id);
        exit;
    }

    /**
     * Mostra le visite prenotate dall'utente corrente
     */
    public function miePrenotazioni()
    {
        if (!isset($_SESSION['user_id'])) {
            // Reindirizza l'utente alla pagina di login
            header('Location: ' . $GLOBALS['appConfig']['baseUrl'] . 'home/login');
            exit;
        }

        $stmt = $this->db->prepare("
            SELECT v.*
            FROM visite v
            JOIN prenotare p ON v.id = p.id_visita
            WHERE p.id_utente = ?
            ORDER BY v.titolo
        ");
        $stmt->execute([$_SESSION['user_id']]);

        $visite = [];
        while ($row = $stmt->fetch()) {
            $visita = new Visita($this->db);
            $visita->fromID($row['id']);
            $visite[] = $visita;
        }

        // Passa i dati alla vista
        extract(['visite' => $visite]);

        // Carica la vista
        require_once 'views/visite/mie-prenotazioni.php';
    }
}