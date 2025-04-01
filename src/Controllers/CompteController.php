<?php

namespace Controllers;

use Models\User;
use Controllers\BaseController;

class CompteController extends BaseController
{

    private User $user;

    public function __construct() {
        $this->user = new User();
    }


    /**
     * Méthode récupérant de la table 'compte' tout les utilisateurs
     * @return array - array contenant tout les utilisateurs
     */
    public function getAllUser(): array {
        return $this->user->getAllUser();
    }

    /**
     * Méthode permettant d'obtenir le nom et le prénom d'un utilisateur par son identifiant
     * @param $user_id - Identifiant du compte
     * @return null[] - Retourne un array associatif dont les valeurs sont null si l'utilisateur n'éxiste pas
     */
    public function getNomPrenomByUser($user_id): array {

        $return_result = $this->user->getNomPrenomByUser($user_id);
        if (gettype($return_result) == "boolean") {
            return array('NOMCOMPTE' => null, 'PRENOMCOMPTE' => null);
        }
        return $return_result;
    }

}