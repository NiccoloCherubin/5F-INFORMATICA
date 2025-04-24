<?php
namespace App\Controller;
require_once 'App/Model/utente.php';

use App\Model\Utente;
use PDO;

class ProfileController
{
    /**
     * Mostra il form di modifica email
     */
    public function editEmailForm(PDO $db)
    {
        session_start();
        if (!isset($_SESSION['utente_id'])) {
            header('Location: home/login');
            exit;
        }

        $utente = new Utente($db);
        $utenteFound = $utente->fromID($_SESSION['utente_id']);

        if (!$utenteFound) {
            die('Utente non trovato');
        }

        $content = '';
        require 'App/View/editEmail.php';
    }

    /**
     * Processa la modifica dell'email
     */
    public function updateEmail(PDO $db)
    {
        session_start();
        if (!isset($_SESSION['utente_id'])) {
            header('Location: home/login');
            exit;
        }

        $newEmail = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validazione input
        if (empty($newEmail) || empty($password)) {
            $error = "Tutti i campi sono obbligatori";
            require 'App/View/editEmail.php';
            return;
        }

        // Verifica che la nuova email sia valida
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $error = "Formato email non valido";
            require 'App/View/editEmail.php';
            return;
        }

        // Caricamento dati utente
        $utente = new Utente($db);
        $utenteFound = $utente->fromID($_SESSION['utente_id']);

        if (!$utenteFound) {
            die('Utente non trovato');
        }

        // Verifica password corrente
        if (!password_verify($password, $utente->getPassword())) {
            $error = "Password errata";
            require 'App/View/editEmail.php';
            return;
        }

        // Verifica che la nuova email non sia già in uso
        $stmt = $db->prepare("SELECT COUNT(*) FROM utenti WHERE mail = ? AND id != ?");
        $stmt->execute([$newEmail, $utente->getId()]);
        if ($stmt->fetchColumn() > 0) {
            $error = "Email già in uso da un altro utente";
            require 'App/View/editEmail.php';
            return;
        }

        // Aggiornamento email
        $success = $utente->updateEmail($newEmail);
        if ($success) {
            $message = "Email aggiornata con successo";
            require 'App/View/editEmail.php';
        } else {
            $error = "Errore durante l'aggiornamento dell'email";
            require 'App/View/editEmail.php';
        }
    }

    /**
     * Mostra il form di modifica password
     */
    public function editPasswordForm(PDO $db)
    {
        session_start();
        if (!isset($_SESSION['utente_id'])) {
            header('Location: home/login');
            exit;
        }

        $utente = new Utente($db);
        $utenteFound = $utente->fromID($_SESSION['utente_id']);

        if (!$utenteFound) {
            die('Utente non trovato');
        }

        $content = '';
        require 'App/View/editPassword.php';
    }

    /**
     * Processa la modifica della password
     */
    public function updatePassword(PDO $db)
    {
        session_start();
        if (!isset($_SESSION['utente_id'])) {
            header('Location: home/login');
            exit;
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validazione input
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $error = "Tutti i campi sono obbligatori";
            require 'App/View/editPassword.php';
            return;
        }

        // Verifica che le nuove password corrispondano
        if ($newPassword !== $confirmPassword) {
            $error = "Le nuove password non corrispondono";
            require 'App/View/editPassword.php';
            return;
        }

        // Verifica requisiti di sicurezza della password
        if (strlen($newPassword) < 8) {
            $error = "La password deve contenere almeno 8 caratteri";
            require 'App/View/editPassword.php';
            return;
        }

        // Caricamento dati utente
        $utente = new Utente($db);
        $utenteFound = $utente->fromID($_SESSION['utente_id']);

        if (!$utenteFound) {
            die('Utente non trovato');
        }

        // Verifica password corrente
        if (!password_verify($currentPassword, $utente->getPassword())) {
            $error = "Password attuale errata";
            require 'App/View/editPassword.php';
            return;
        }

        // Aggiornamento password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $success = $utente->updatePassword($hashedPassword);

        if ($success) {
            $message = "Password aggiornata con successo";
            require 'App/View/editPassword.php';
        } else {
            $error = "Errore durante l'aggiornamento della password";
            require 'App/View/editPassword.php';
        }
    }
}