<?php

namespace App\Model;
require_once dirname(__DIR__,2). '/Functions/functions.php';
use Exception;
use PDO;

class Visita
{
    private int $id;
    private string $titolo;
    private float $durata;
    private float $prezzo;
    private int $n_min;
    private int $n_max;
    private int $id_guida;
    private array $luoghi = [];
    private array $eventi = [];
    private array $guida = [];

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Carica una visita dal database dato l'ID
     *
     * @param int $id ID della visita
     * @return Visita|null Ritorna l'istanza di se stesso o null se non trovata
     */
    public function fromID(int $id): ?self
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM visite
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            $this->id = $row['id'];
            $this->titolo = $row['titolo'];
            $this->durata = $row['durata'];
            $this->prezzo = $row['prezzo'];
            $this->n_min = $row['n_min'];
            $this->n_max = $row['n_max'];
            $this->id_guida = $row['id_guida'];

            // Carica informazioni sulla guida
            $this->loadGuida();

            // Carica luoghi e eventi associati
            $this->loadLuoghiEventi();

            return $this;
        }

        return null;
    }

    /**
     * Carica tutte le visite dal database
     *
     * @return array Lista di visite
     */
    public static function getAll(PDO $db): array
    {
        $stmt = $db->query("
            SELECT *
            FROM visite
            ORDER BY titolo
        ");

        $visite = [];
        while ($row = $stmt->fetch()) {
            $visita = new self($db);
            $visita->fromID($row['id']);
            $visite[] = $visita;
        }

        return $visite;

        require 'App/View/Visite.php';
    }

    /**
     * Cerca visite con titolo simile
     *
     * @param string $term Termine di ricerca
     * @return array Lista di visite
     */


    public static function search(PDO $db, string $term): array
    {
        $stmt = $db->prepare("
            SELECT *
            FROM visite
            WHERE titolo LIKE ?
            ORDER BY titolo
        ");
        $stmt->execute(['%' . $term . '%']);

        $visite = [];
        while ($row = $stmt->fetch()) {
            $visita = new self($db);
            $visita->fromID($row['id']);
            $visite[] = $visita;
        }

        return $visite;
    }

    /**
     * Carica le informazioni sui luoghi e gli eventi associati alla visita
     */
    private function loadLuoghiEventi(): void
    {
        $stmt = $this->db->prepare("
            SELECT l.id as luogo_id, l.descrizione as luogo_descrizione,
                   e.id as evento_id, e.descrizione as evento_descrizione
            FROM avere a
            JOIN luoghi l ON a.id_luogo = l.id
            JOIN eventi e ON a.id_evento = e.id
            WHERE a.id_visita = ?
        ");
        $stmt->execute([$this->id]);

        $this->luoghi = [];
        $this->eventi = [];

        while ($row = $stmt->fetch()) {
            $this->luoghi[] = [
                'id' => $row['luogo_id'],
                'descrizione' => $row['luogo_descrizione']
            ];

            $this->eventi[] = [
                'id' => $row['evento_id'],
                'descrizione' => $row['evento_descrizione']
            ];
        }
    }

    /**
     * Carica le informazioni sulla guida associata alla visita
     */
    private function loadGuida(): void
    {
        $stmt = $this->db->prepare("
            SELECT g.*, GROUP_CONCAT(l.descrizione SEPARATOR ', ') as lingue
            FROM guide g
            LEFT JOIN parlare p ON g.id = p.id_guida
            LEFT JOIN lingue l ON p.id_lingua = l.id
            WHERE g.id = ?
            GROUP BY g.id
        ");
        $stmt->execute([$this->id_guida]);
        $row = $stmt->fetch();

        if ($row) {
            $this->guida = [
                'id' => $row['id'],
                'nome' => $row['nome'],
                'cognome' => $row['cognome'],
                'titolo_studio' => $row['titolo_studio'],
                'data_nascita' => $row['data_nascita'],
                'lingue' => $row['lingue']
            ];
        }
    }

    /**
     * Verifica se l'utente ha già prenotato questa visita
     *
     * @param int $utenteId ID dell'utente
     * @return bool true se l'utente ha già prenotato questa visita, false altrimenti
     */
    public function isPrenotataByUtente(int $utenteId): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM prenotare 
            WHERE id_utente = ? AND id_visita = ?
        ");
        $stmt->execute([$utenteId, $this->id]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Prenota una visita per un utente
     *
     * @param int $utenteId ID dell'utente
     * @return bool true se la prenotazione è andata a buon fine, false altrimenti
     */
    public function prenota(int $utenteId): bool
    {
        try {
            // Verifica se l'utente ha già prenotato questa visita
            if ($this->isPrenotataByUtente($utenteId)) {
                return false;
            }

            // Effettua la prenotazione
            $stmt = $this->db->prepare("
                INSERT INTO prenotare (id_utente, id_visita)
                VALUES (?, ?)
            ");
            return $stmt->execute([$utenteId, $this->id]);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cancella la prenotazione di una visita per un utente
     *
     * @param int $utenteId ID dell'utente
     * @return bool true se la cancellazione è andata a buon fine, false altrimenti
     */
    public function cancellaPrenotazione(int $utenteId): bool
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM prenotare 
                WHERE id_utente = ? AND id_visita = ?
            ");
            return $stmt->execute([$utenteId, $this->id]);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Conta il numero di prenotazioni per questa visita
     *
     * @return int Numero di prenotazioni
     */
    public function countPrenotazioni(): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM prenotare 
            WHERE id_visita = ?
        ");
        $stmt->execute([$this->id]);

        return $stmt->fetchColumn();
    }

    /**
     * Verifica se ci sono ancora posti disponibili per questa visita
     *
     * @return bool true se ci sono posti disponibili, false altrimenti
     */
    public function hasPostiDisponibili(): bool
    {
        return $this->countPrenotazioni() < $this->n_max;
    }

    /**
     * Aggiunge un nuovo luogo ed evento alla visita
     *
     * @param int $luogoId ID del luogo
     * @param int $eventoId ID dell'evento
     * @return bool true se l'aggiunta è andata a buon fine, false altrimenti
     */
    public function addLuogoEvento(int $luogoId, int $eventoId): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO avere (id_visita, id_luogo, id_evento)
                VALUES (?, ?, ?)
            ");
            $result = $stmt->execute([$this->id, $luogoId, $eventoId]);

            if ($result) {
                // Ricarica luoghi ed eventi
                $this->loadLuoghiEventi();
            }

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Rimuove un luogo ed evento dalla visita
     *
     * @param int $luogoId ID del luogo
     * @param int $eventoId ID dell'evento
     * @return bool true se la rimozione è andata a buon fine, false altrimenti
     */
    public function removeLuogoEvento(int $luogoId, int $eventoId): bool
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM avere 
                WHERE id_visita = ? AND id_luogo = ? AND id_evento = ?
            ");
            $result = $stmt->execute([$this->id, $luogoId, $eventoId]);

            if ($result) {
                // Ricarica luoghi ed eventi
                $this->loadLuoghiEventi();
            }

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Crea una nuova visita nel database
     *
     * @param string $titolo Titolo della visita
     * @param float $durata Durata della visita in ore
     * @param float $prezzo Prezzo della visita
     * @param int $n_min Numero minimo di partecipanti
     * @param int $n_max Numero massimo di partecipanti
     * @param int $id_guida ID della guida
     * @return bool|int ID della nuova visita se la creazione è andata a buon fine, false altrimenti
     */
    public function create(string $titolo, float $durata, float $prezzo, int $n_min, int $n_max, int $id_guida): bool|int
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO visite (titolo, durata, prezzo, n_min, n_max, id_guida)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([$titolo, $durata, $prezzo, $n_min, $n_max, $id_guida]);

            if ($result) {
                $this->id = $this->db->lastInsertId();
                $this->titolo = $titolo;
                $this->durata = $durata;
                $this->prezzo = $prezzo;
                $this->n_min = $n_min;
                $this->n_max = $n_max;
                $this->id_guida = $id_guida;

                // Carica informazioni sulla guida
                $this->loadGuida();

                return $this->id;
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Aggiorna una visita esistente
     *
     * @param string $titolo Titolo della visita
     * @param float $durata Durata della visita in ore
     * @param float $prezzo Prezzo della visita
     * @param int $n_min Numero minimo di partecipanti
     * @param int $n_max Numero massimo di partecipanti
     * @param int $id_guida ID della guida
     * @return bool true se l'aggiornamento è andato a buon fine, false altrimenti
     */
    public function update(string $titolo, float $durata, float $prezzo, int $n_min, int $n_max, int $id_guida): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE visite
                SET titolo = ?, durata = ?, prezzo = ?, n_min = ?, n_max = ?, id_guida = ?
                WHERE id = ?
            ");
            $result = $stmt->execute([$titolo, $durata, $prezzo, $n_min, $n_max, $id_guida, $this->id]);

            if ($result) {
                $this->titolo = $titolo;
                $this->durata = $durata;
                $this->prezzo = $prezzo;
                $this->n_min = $n_min;
                $this->n_max = $n_max;
                $this->id_guida = $id_guida;

                // Ricarica informazioni sulla guida
                $this->loadGuida();

                return true;
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Elimina una visita dal database
     *
     * @return bool true se l'eliminazione è andata a buon fine, false altrimenti
     */
    public function delete(): bool
    {
        try {
            // Prima elimina tutte le relazioni nella tabella avere
            $stmt = $this->db->prepare("DELETE FROM avere WHERE id_visita = ?");
            $stmt->execute([$this->id]);

            // Poi elimina tutte le prenotazioni
            $stmt = $this->db->prepare("DELETE FROM prenotare WHERE id_visita = ?");
            $stmt->execute([$this->id]);

            // Infine elimina la visita
            $stmt = $this->db->prepare("DELETE FROM visite WHERE id = ?");
            return $stmt->execute([$this->id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getTitolo(): string { return $this->titolo; }
    public function getDurata(): float { return $this->durata; }
    public function getPrezzo(): float { return $this->prezzo; }
    public function getNMin(): int { return $this->n_min; }
    public function getNMax(): int { return $this->n_max; }
    public function getIdGuida(): int { return $this->id_guida; }
    public function getLuoghi(): array { return $this->luoghi; }
    public function getEventi(): array { return $this->eventi; }
    public function getGuida(): array { return $this->guida; }

    /**
     * Ottiene il nome completo della guida
     *
     * @return string Nome completo della guida
     */
    public function getNomeGuida(): string
    {
        if (empty($this->guida)) {
            return '';
        }

        return $this->guida['nome'] . ' ' . $this->guida['cognome'];
    }

    /**
     * Ottiene le lingue parlate dalla guida
     *
     * @return string Lingue parlate dalla guida
     */
    public function getLingueGuida(): string
    {
        if (empty($this->guida) || empty($this->guida['lingue'])) {
            return '';
        }

        return $this->guida['lingue'];
    }

    /**
     * Formatta il prezzo come stringa con due decimali
     *
     * @return string Prezzo formattato
     */
    public function getPrezzoFormattato(): string
    {
        return number_format($this->prezzo, 2, ',', '.') . ' €';
    }

    /**
     * Formatta la durata come stringa (es. "2 ore e 30 minuti")
     *
     * @return string Durata formattata
     */
    public function getDurataFormattata(): string
    {
        $ore = floor($this->durata);
        $minuti = round(($this->durata - $ore) * 60);

        $result = '';
        if ($ore > 0) {
            $result .= $ore . ' ' . ($ore == 1 ? 'ora' : 'ore');
        }

        if ($minuti > 0) {
            if ($result) {
                $result .= ' e ';
            }
            $result .= $minuti . ' ' . ($minuti == 1 ? 'minuto' : 'minuti');
        }

        return $result;
    }
}