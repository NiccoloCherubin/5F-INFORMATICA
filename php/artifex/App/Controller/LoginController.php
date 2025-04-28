<?php
namespace App\Controller;
require_once 'App/Model/utente.php';

use App\Model\Utente;
use PDO;

class LoginController
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function loginAction()
    {
        $error = null;
        $content = '';
        require 'App/View/loginForm.php';
    }

    public function processLogin(PDO $db)
    {
        $user = new Utente($db);

        $mail = $_POST['mail'] ?? '';
        $password = $_POST['password'] ?? '';

        $userFound = $user->fromMail($mail);

        if ($userFound && password_verify($password, $user->getPassword())) {
            // Login OK
            session_start();
            $_SESSION['utente_id'] = $user->getId();
            header('Location: profilo');
            exit;
        } else {
            // Login fallito
            $error = "Email o password errati.";
            require 'App/View/loginForm.php';
        }
    }

    public function profilo(PDO $db)
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
        require 'App/View/profilo.php';
    }
}