<?php

namespace Controllers;

use Controllers\BaseController;
use Models\Inscription;
use PDO;

class InscriptionController extends BaseController
{

    private Inscription $inscription;
    private AnimActController $act_controller;

    public function __construct() {
        date_default_timezone_set("Europe/Stockholm");
        if (session_status() === PHP_SESSION_DISABLED || session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }

        $this->inscription = new Inscription();
        $this->act_controller = new AnimActController();
    }


    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la
     * méthode d'inscription d'utilisateur. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param string $user_id - Identifiant de l'utilisateur à inscrire
     * @param string $code_anim - Identifiant de l'activité pour lequel l'utilisateur doit être inscrit
     * @param string $date_act - Date de l'activité pour lequel l'utilisateur doit être inscrit
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function inscritUserToAct(string $user_id, string $code_anim, string $date_act): array {

        //sanitize values
        $cleaned_user_id = $this->sanitize($user_id);
        $cleaned_code_anim = $this->sanitize($code_anim);
        $cleaned_date_act = $this->sanitize($date_act);

        //verify if user is already inscrit
        if ($this->inscription->isUserAlreadyInscrit($cleaned_user_id, $cleaned_code_anim, $cleaned_date_act)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Vous êtes déja inscrit à cette activité!'];
        }

        //verify if activite is in user's holidays
        if ($date_act < $_SESSION['date_debut_sejour'] || $date_act > $_SESSION['date_fin_sejour']) {
            return ['success' => false, 'title' => 'L\'inscription à échouée!', 'message' => 'Votre période de séjour ne concorde pas avec celle de l\'activité. Contacter un administrateur afin qu\'il supprime votre compte'];
        }

        //si nb_place disponible
        $nb_places_prises = $this->getNumberInscritByActCodeAnim($code_anim, $date_act);
        $nb_place_totale = $this->act_controller->checkNbrePlaceAnim($code_anim);
        if ($nb_places_prises >= $nb_place_totale) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'L\'activité est pleine!'];
        }

        // if someone try somehow to register to a cancelled activity
        $is_act_cancelled = $this->act_controller->isActCancelled($code_anim, $date_act);
        if ($is_act_cancelled) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'L\'activité est annulée!'];
        }

        //si l'inscription existe déja dans la table mais ou l'utilisateur s'est désinscrit (DATEANNULE IS NOT NULL)
        if ($this->inscription->isInscriptionAlreadyExist($cleaned_user_id, $cleaned_code_anim, $date_act)) {
            return $this->inscription->inscritUserToAct($cleaned_user_id, $cleaned_code_anim, $cleaned_date_act, true);
        }
        //si aucune inscription éxiste dans la table
        else {
            return $this->inscription->inscritUserToAct($cleaned_user_id, $cleaned_code_anim, $cleaned_date_act, false);
        }
    }

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la
     * méthode de désinscription d'utilisateur. Les valeurs sont néttoyées avant d'être envoyées au modèle
     * @param string $user_id - Identifiant de l'utilisateur à désinscrit
     * @param string $code_anim - Identifiant de l'activité pour lequel l'utilisateur doit être désinscrit
     * @param string $date_act - Date de l'activité pour lequel l'utilisateur doit être désinscrit
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function desincritUserToAct(string $user_id, string $code_anim, string $date_act): array {

        //sanitize values
        $cleaned_user_id = $this->sanitize($user_id);
        $cleaned_code_anim = $this->sanitize($code_anim);
        $cleaned_date_act = $this->sanitize($date_act);

        //verify if user is already désinscrit
        if ($this->inscription->isUserAlreadyInscrit($cleaned_user_id, $cleaned_code_anim, $cleaned_date_act, true)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Vous êtes déja désinscrit à cette activité!'];
        }

        return $this->inscription->desincritUserToAct($cleaned_user_id, $cleaned_code_anim, $cleaned_date_act);
    }

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la
     * méthode pour voir si un utilisateur est inscrit à une certaine activité. Les valeurs sont néttoyées avant
     * d'être envoyées au modèle
     * @param string $user_id - Identifiant de l'utilisateur dont on doit vérifier l'inscription
     * @param string $code_anim - Identifiant de l'activité dont on doit vérifier si l'utilisateur est inscrit
     * @param string $date_act - Date de l'activité dont on doit vérifier si l'utilisateur est inscrit
     * @return bool - Retourne True si l'utilisateur est déja inscrit à l'activité, sinon False
     */
    public function isUserInscritToAct(string $user_id, string $code_anim, string $date_act): bool {
        //sanitize values
        $cleaned_user_id = $this->sanitize($user_id);
        $cleaned_code_anim = $this->sanitize($code_anim);
        $cleaned_date_act = $this->sanitize($date_act);

        return $this->inscription->isUserAlreadyInscrit($cleaned_user_id, $cleaned_code_anim, $cleaned_date_act);
    }

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la
     *  méthode pour voir si un utilisateur est désinscrit à une certaine activité. Les valeurs sont néttoyées avant
     *  d'être envoyées au modèle
     * @param string $user_id - Identifiant de l'utilisateur dont on doit vérifier la désinscription
     * @param string $code_anim - Identifiant de l'activité dont on doit vérifier si l'utilisateur est désinscrit
     * @param string $date_act - Date de l'activité pour dont on doit vérifier si l'utilisateur est désinscrit
     * @return bool - Retourne True si l'utilisateur est déja désinscrit de l'activité, sinon False
     */
    public function isUserDesinscritToAct(string $user_id, string $code_anim, string $date_act): bool {
        //sanitize values
        $cleaned_user_id = $this->sanitize($user_id);
        $cleaned_code_anim = $this->sanitize($code_anim);
        $cleaned_date_act = $this->sanitize($date_act);

        return $this->inscription->isUserAlreadyInscrit($cleaned_user_id, $cleaned_code_anim, $cleaned_date_act, true);
    }


    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la
     *  méthode pour récupérer le nombre d'inscrit à une activité.Les valeurs sont néttoyées avant
     *   d'être envoyées au modèle
     * @param string $code_anim - Identifiant de l'activité
     * @param string $date_act - Date de l'activité
     * @return int - Retourne le nombre d'inscrit à une activité
     */
    public function getNumberInscritByActCodeAnim(string $code_anim, string $date_act): int {
        //sanitize values
        $cleaned_code_anim = $this->sanitize($code_anim);
        $cleaned_date_act = $this->sanitize($date_act);

        return $this->inscription->getNumberInscritByActCodeAnim($cleaned_code_anim, $cleaned_date_act);
    }


    /**
     * Méthode that return information about every user registered to a specific activity
     * @param string $code_anim - act id
     * @param string $date_act - act date
     * @return array - Return all information
     */
    public function getAllUserInscriptionById(string $code_anim, string $date_act): array {
        //clean values
        $cleaned_code_anim = $this->sanitize($code_anim);
        $cleaned_date_act = $this->sanitize($date_act);

        return $this->inscription->getAllUserInscrit($cleaned_code_anim, $cleaned_date_act);
    }

    /**
     * Méthode that return a number corresponding to how many activity the user is registered to
     * @param string $nom - User last name
     * @param string $prenom - User First name
     * @return int - Return number
     */
    public function getCountInscriptionByUser(string $nom, string $prenom): int {
        // clean values
        $cleaned_nom = $this->sanitize($nom);
        $cleaned_prenom = $this->sanitize($prenom);

        return $this->inscription->getCountInscriptionByUser($cleaned_nom, $cleaned_prenom);
    }
}