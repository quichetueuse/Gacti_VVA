<?php

namespace Controllers;
require_once('../autoloader.php');

use Controllers\CompteController;
use Controllers\BaseController;
use Models\Activite;
use Models\Animation;
use Models\TypeAnimation;


final class AnimActController extends BaseController
{
    private Animation $animation;

    private Activite $activite;

    private TypeAnimation $type_anim;

    private CompteController $compte_controller;

    private EtatActController $etatact_controller;


    public function __construct(){
        date_default_timezone_set("Europe/Stockholm");
        $this->animation = new Animation();
        $this->activite = new Activite();
        $this->type_anim = new TypeAnimation();
        $this->compte_controller = new CompteController();
        $this->etatact_controller = new EtatActController();
    }

    /**
     * Méthode permettant de récupérer toutes les animations
     * @return array - Résultat de la requête SQL (array des animations)
     */
    public function getAllAnimations(): array {
        return $this->animation->getAllAnimations();
    }

    /**
     * Méthode permettant de récupérer toutes les informations d'une animation grâce à son code
     * @return array - Résultat de la requête SQL (array des animations)
     */
    public function getAnimationByCodeAnim(string $code_anim): array {
        //clean value
        $cleaned_code_anim = $this->sanitize($code_anim);

        return $this->animation->getAnimationInformationsByCodeAnim($cleaned_code_anim);
    }


    public function getCountAnimations(): int {
        return $this->animation->getCountAnimations();
    }

    public function getAllActivites(): array {
        return $this->activite->getActivities('all');
    }

    /**
     * Méthode permettant de récupérer toutes les activités en fonction de leur animation ou si elle sont valides ou non
     * @param string $code_anim - Code afin de rechercher les activités d'une animation spécifique
     * @param string $select_mode [optinnal] - Mode de sélection des activités (par défaut toutes les activités
     * sont récupérées)
     * @return array - Résultat de la requête SQL (array des activités)
     */
    public function getAllActivitesByAnim(string $code_anim, string $select_mode=''): array {

        //sanitize values
        $cleaned_code_anim = $this->sanitize($code_anim);
        $cleaned_select_mode = $this->sanitize($select_mode);
        return $this->activite->getActivities($cleaned_code_anim, $cleaned_select_mode);
    }

//    public function getCountActivites(): int {
//        return $this->activite->getCountActivites('all');
//    }
//    public function getCountActivitesByAnim(string $code_anim): int {
//        $code_anim = $this->sanitize($code_anim);
//        return $this->activite->getCountActivites($code_anim);
//    }

    /**
     * Méthode permettant de récupérer tout les types d'animations afin de les mettre dans un
     * sélect (formulaire d'ajout d'animation)
     * @return array - array contenant tout les types d'animations
     */
    public function getAllTypeAnim(): array {
        return $this->type_anim->getAllTypeAnimations();
    }

    /**
     * Méthode permettant de récupérer tout les codes d'animations afin de les mettre dans un
     * sélect (formulaire d'ajout d'activité)
     * @return array - array contenant tout les codes d'animations
     */
    public function getAllCodeAnim(): array {
        return $this->animation->getAllCodeAnim();
    }


//    public function addAnimation() {
//        echo '<script>window.location.href = "../Views/new_animation2.php";</script>';
//    }

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode d'ajout
     * d'animation. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param array $anim_to_add - valeurs sortantes directement du formulaire d'ajout d'animation, non néttoyées
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *   le méssage du popup à afficher
     */
    public function addAnimation(array $anim_to_add) : array {
        //sanitizing every array values
        $cleaned_anim = $this->sanitizeArray($anim_to_add);

        //check return if validation criteria are not met
        if (!$this->checkAnimValuesValidity($anim_to_add)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Valeurs invalides!'];
        }

        //get query result state a.k.a if insert worked
        return $this->animation->addAnimation($cleaned_anim);
    }
//    public function addAnimation(array $anim_to_add) : bool {
//        //sanitizing every array values
//        $cleaned_anim = $this->sanitizeArray($anim_to_add);
//
//        //check return if validation criteria are not met
//        if (!$this->checkAnimValuesValidity($anim_to_add))
//        {
//            return false;
//        }
//
//        //get query result state a.k.a if insert worked
//        $query_success = $this->animation->addAnimation($cleaned_anim);
//        return $query_success;
//    }

//    public function deleteAnimation(array $act): bool {
//        $query_success = $this->activite->deleteActivite($this->sanitizeArray($act));
//        return $query_success;
//    }

    /**
     *  Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode de
     * suppression d'une activité. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param string $act_id - Code de l'animation de l'activité
     * @param string $date_act - Date de l'activité
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function deleteActivite(string $act_id, string $date_act): array {
        return $this->activite->deleteActivite($this->sanitize($act_id), $this->sanitize($date_act));
    }

    /**
     * Méthode vérifiant si les valeurs récupérées du formulaire d'ajout d'animation correspondent au format autorisé
     * dans la base de données
     * @param $anim_array - Array contenant toutes les valeurs des champs du formulaire d'ajout d'animation néttoyées
     * que l'on doit vérifier
     * @return bool - Retourne true si les valeurs sont bonnes et false si l'une d'entres elles n'est pas bonne
     */
    public function checkAnimValuesValidity($anim_array) : bool {
        //validité code anim
        if (strlen($anim_array[0]) > 8){
//            echo 'blocage code anim';
            return false;
        }

        //validité type anim
        if (!in_array($anim_array[1], $this->type_anim->getTypesName())) {
//            echo 'blocage type anim';
            return false;
        }

        //validité titre anim
        if (strlen($anim_array[2]) > 40) {
//            echo 'blocage titre anim';
            return false;
        }

        //validité date validité anim
        if ($anim_array[3] < date('Y-m-d')) {
//            echo 'blocage date validité anim <br> ' . date('Y-m-d');
            return false;
        }

        //validation for duree
        if (!is_numeric($anim_array[4])) {
//            echo 'blocage durée anim1';
            return false;
        }
        if (intval($anim_array[4]) < 1) {
//            echo 'blocage durée anim2';
            return false;
        }

        //validation for tarif
        if (!is_numeric($anim_array[5])) {
//            echo 'blocage tarif1';
            return false;
        }
        if (intval($anim_array[5]) < 0) {
//            echo 'blocage tarif2';
            return false;
        }

        //validation for limite age
        if (!is_numeric($anim_array[6])) {
//            echo 'blocage limite age1';
            return false;
        }
        if (intval($anim_array[6]) < 4 || intval($anim_array[6]) > 100) {
//            echo 'blocage limite age 2';
            return false;
        }

        //validation for nb place
        if (!is_numeric($anim_array[7])) {
//            echo 'blocage nb place1';
            return false;
        }
        if (intval($anim_array[7]) < 1 || intval($anim_array[7]) > 50) {
//            echo 'blocage nb place2';
            return false;
        }

        //validation for desciption
        if (strlen($anim_array[8]) > 250) {
//            echo 'blocage desc anim';
            return false;
        }

        //validation for commentaire
        if (strlen($anim_array[9]) > 250) {
//            echo 'blocage comment anim';
            return false;
        }

        //validation for difficulté
        if (strlen($anim_array[10]) > 40) {
//            echo 'blocage diff anim';
            return false;
        }

//        return false;
        return true;
    }

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode
     * permettant de récupérer le nombre d'inscrit à une animation
     * @param string $code_anim - Code de l'animation dont on souhaite connaitre le nombre d'inscrit
     * @return int - Nombre d'inscrit
     */
    public function checkNbrePlaceAnim(string $code_anim): int {
        //sanitize values
        $cleaned_code_anim = $this->sanitize($code_anim);

        return $this->animation->checkNbrePlaceAnim($cleaned_code_anim);
    }


    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode d'ajout
     * d'activité. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param array $new_act - valeurs sortantes directement du formulaire d'ajout d'activité, non néttoyées
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *   le méssage du popup à afficher
     */
    public function addActivite(array $new_act): array {
//        return ['success'=> false, 'title' => $this->compte_controller->getNomPrenomByUser($new_act[2]), 'message' => ''];

        //clean array values
        $cleaned_act = $this->sanitizeArray($new_act);

        //if values are not valid
        if (!$this->checkActValuesValidity($new_act)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Valeurs invalides!'];
        }

        if ($this->activite->doesActiviteExist($cleaned_act[0], $cleaned_act[3])) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'L\'activité éxiste déja!'];
        }


        $resp_array = $this->compte_controller->getNomPrenomByUser($cleaned_act[2]);
        $new_act_array = array($cleaned_act[0], $cleaned_act[1], $resp_array['NOMCOMPTE'], $resp_array['PRENOMCOMPTE'], $cleaned_act[3], $cleaned_act[4], $cleaned_act[5], $cleaned_act[6], $cleaned_act[7]);

//        if (!$this->activite->doesActiviteExist($new_act[0], $new_act[4])) {
//            return false;
//        }


        return $this->activite->addActivite($new_act_array);
    }

    /**
     * Méthode vérifiant si les valeurs récupérées du formulaire d'ajout d'activité correspondent au format autorisé
     * dans la base de données
     * @param $anim_array - Array contenant toutes les valeurs des champs du formulaire d'ajout d'activité néttoyées
     * que l'on doit vérifier
     * @return bool - Retourne true si les valeurs sont bonnes et false si l'une d'entres elles n'est pas bonne
     */
    public function checkActValuesValidity(array $act_array): bool {

        //si le code n'appartient à aucune animation
        if (!$this->animation->getAnimationByCodeAnim($act_array[0])){
            return false;
        }

        //si l'état de l'activité n'éxiste pas
        if (in_array($act_array[1], $this->etatact_controller->getAllEtat(false))){ //todo vérifier si pas erreurquelque part (normalement !in_array)
            return false;
        }

//        if (strlen($act_array[0]) > 8){
//            return false;
//        }
//
//        if (strlen($act_array[1]) > 2){
//            return false;
//        }

//        if (strlen($act_array[2]) > 40){
//            return false;
//        }

        //si aucun utilisateur n'est trouvé
        if (gettype($this->compte_controller->getNomPrenomByUser($act_array[2])) === 'boolean'){
            return false;
        }

//        if (in_array($act_array[2], $this->compte_controller->getNomPrenomByUser($act_array[2]))){
//            return false;
//        }

        //si les heures sont bien des heures
        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $act_array[4])) {
            return false;
        }

        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $act_array[5])) {
            return false;
        }

        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $act_array[6])) {
            return false;
        }

        //si l'heure de fin est inférieure à celle d'arrivée ou de départ
        if (strtotime($act_array[6]) < strtotime($act_array[5]) || strtotime($act_array[6]) < strtotime($act_array[4])) {
            return false;
        }

        //si l'heure de départ est supérieur à celle de fin ou si l'heure de départ est inférieur à celle d'arrivée
        if (strtotime($act_array[5]) > strtotime($act_array[6]) || strtotime($act_array[5]) < strtotime($act_array[4])) {
            return false;
        }

        //si l'heure d'arrivée est supérieure à celle de fin ou de départ
        if (strtotime($act_array[4]) > strtotime($act_array[6]) || strtotime($act_array[4]) > strtotime($act_array[5])) {
            return false;
        }

        //si la date de l'activité est minimum 24h après
        if ($act_array[3] < date("Y-m-d", strtotime('tomorrow'))) {
            return false;
        }

        //si le prix est un nombre
        if (!is_numeric($act_array[7])) {
            return false;
        }

        //si il est compris entre 0 et 10000
        if ($act_array[7] < 0 || $act_array[7] > 10000){
            return false;
        }

        return true;
    }

//    public function restoreActivite(string $act_id, string $date_act): bool {
//
//        //cleaned_value
//        $cleaned_act_id = $this->sanitize($act_id);
//        $cleaned_date_act = $this->sanitize($date_act);
//
//        return $this->activite->restoreActivite($cleaned_act_id, $cleaned_date_act);
//    }

    /**
     *  Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode de
     * restauration d'une activité. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param string $act_id - Code de l'animation de l'activité
     * @param string $date_act - Date de l'activité
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function restoreActivite(string $act_id, string $date_act): array {

        //cleaned_value
        $cleaned_act_id = $this->sanitize($act_id);
        $cleaned_date_act = $this->sanitize($date_act);

        return $this->activite->restoreActivite($cleaned_act_id, $cleaned_date_act);
    }

}