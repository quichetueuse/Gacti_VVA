<?php
namespace Controllers;
require_once('../autoloader.php');
use Models\User;

final class LoginController extends BaseController
{

    private User $user;
    public function __construct(){
        $this->user = new User();
        $user_email = $this->sanitize($_POST['input-email']);
        $user_password = sha1($this->sanitize($_POST['input-password']));
        $record = $this->user->verify_credentials($user_email, $user_password);
        if (!$record)
        {
            $this->redirectToFailed();
            exit();
        }
        session_start();
        $_SESSION['nom'] = $record['NOMCOMPTE'];
        $_SESSION['prenom'] = $record['PRENOMCOMPTE'];
        $_SESSION['type_profil'] = $record['TYPEPROFIL'];
        $_SESSION['user'] = $record['USER'];
        $_SESSION['date_debut_sejour'] = $record['DATEDEBSEJOUR'];
        $_SESSION['date_fin_sejour'] = $record['DATEFINSEJOUR'];

        $this->redirect();
    }

    #[\Override]
    protected function redirect() {
        header('location: ../Views/new_animation2.php', true, 302);
        exit();
    }

    protected function redirectToFailed() {
        header('location: ../Views/login.php?error=true', true, 302);
        exit();
    }
}

new LoginController();