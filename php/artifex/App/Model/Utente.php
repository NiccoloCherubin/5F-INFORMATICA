<?php

namespace App\Model;
use PDO;

class Utente
{
    private int $id;
    private string $nome;
    private string $telefono;
    private string $mail;
    private string $nazionalita;
    private string $lingua;
    private string $password;

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function fromMail(string $mail): ?self
    {
        $stmt = $this->db->prepare("
            SELECT u.*, n.descrizione AS nazionalita, l.descrizione AS lingua
            FROM utenti u
            JOIN nazionalita n ON u.id_nazionalita = n.id
            JOIN lingue l ON u.id_lingua = l.id
            WHERE u.mail = ?
        ");
        $stmt->execute([$mail]);
        $row = $stmt->fetch();

        if ($row) {
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->telefono = $row['telefono'];
            $this->mail = $row['mail'];
            $this->nazionalita = $row['nazionalita'];
            $this->lingua = $row['lingua'];
            $this->password = $row['password'];
            return $this;
        }
        return null;
    }

    public function fromID(int $id): ?self
    {
        $stmt = $this->db->prepare("
            SELECT u.*, n.descrizione AS nazionalita, l.descrizione AS lingua
            FROM utenti u
            JOIN nazionalita n ON u.id_nazionalita = n.id
            JOIN lingue l ON u.id_lingua = l.id
            WHERE u.id = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->telefono = $row['telefono'];
            $this->mail = $row['mail'];
            $this->nazionalita = $row['nazionalita'];
            $this->lingua = $row['lingua'];
            $this->password = $row['password'];
            return $this;
        }
        return null;
    }

    /**
     * Aggiorna l'email dell'utente
     *
     * @param string $newEmail La nuova email
     * @return bool True se l'aggiornamento è avvenuto con successo, False altrimenti
     */
    public function updateEmail(string $newEmail): bool
    {
        $stmt = $this->db->prepare("UPDATE utenti SET mail = ? WHERE id = ?");
        $result = $stmt->execute([$newEmail, $this->id]);

        if ($result) {
            $this->mail = $newEmail;
        }

        return $result;
    }

    /**
     * Aggiorna la password dell'utente
     *
     * @param string $hashedPassword La nuova password già hashata
     * @return bool True se l'aggiornamento è avvenuto con successo, False altrimenti
     */
    public function updatePassword(string $hashedPassword): bool
    {
        $stmt = $this->db->prepare("UPDATE utenti SET password = ? WHERE id = ?");
        $result = $stmt->execute([$hashedPassword, $this->id]);

        if ($result) {
            $this->password = $hashedPassword;
        }

        return $result;
    }

    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getTelefono(): string { return $this->telefono; }
    public function getMail(): string { return $this->mail; }
    public function getNazionalita(): string { return $this->nazionalita; }
    public function getLingua(): string { return $this->lingua; }
    public function getPassword(): string { return $this->password; }
}