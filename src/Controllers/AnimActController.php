<?php

namespace Controllers;
require_once('../autoloader.php');

use Controllers\CompteController;
use Controllers\BaseController;
use DateTime;
use Models\Activite;
use Models\Animation;
use Models\Inscription;
use Models\TypeAnimation;
use PDO;


final class AnimActController extends BaseController
{
    private Animation $animation;

    private Activite $activite;

    private TypeAnimation $type_anim;

    private CompteController $compte_controller;

    private EtatActController $etatact_controller;

    private Inscription $inscription_model;


    public function __construct(){
        date_default_timezone_set("Europe/Stockholm");
        $this->animation = new Animation();
        $this->activite = new Activite();
        $this->type_anim = new TypeAnimation();
        $this->compte_controller = new CompteController();
        $this->etatact_controller = new EtatActController();
        $this->inscription_model = new Inscription();
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
    public function getAnimationByCodeAnim(string $code_anim, int $mode=4): array {

        return $this->animation->getAnimationInformationsByCodeAnim($code_anim, $mode);
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
        return $this->activite->getActivities($code_anim, $select_mode);
    }

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

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode d'ajout
     * d'animation. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param array $anim_to_add - valeurs sortantes directement du formulaire d'ajout d'animation, non néttoyées
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *   le méssage du popup à afficher
     */
    public function addAnimation(array $anim_to_add) : array {

        // return if validation criteria are not met
        if (!$this->checkAnimValuesValidity($anim_to_add)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Valeurs invalides!'];
        }

        //get query result state a.k.a if insert worked
        return $this->animation->addAnimation($anim_to_add);
    }

    /**
     *  Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode de
     * suppression d'une activité. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param string $act_id - Code de l'animation de l'activité
     * @param string $date_act - Date de l'activité
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function deleteActivite(string $act_id, string $date_act): array {
        $inscriptions = $this->inscription_model->getAllUserInscrit($act_id, $date_act);
        foreach ($inscriptions as $inscription) {
            $user_id = $inscription['USER'];
            $this->inscription_model->desincritUserToAct($user_id, $act_id, $date_act);
        }
        return $this->activite->deleteActivite($act_id, $date_act);
    }

    /**
     * Méthode vérifiant si les valeurs récupérées du formulaire d'ajout d'animation correspondent au format autorisé
     * dans la base de données
     * @param $anim_array - Array contenant toutes les valeurs des champs du formulaire d'ajout d'animation néttoyées
     * que l'on doit vérifier
     * @return bool - Retourne true si les valeurs sont bonnes et false si l'une d'entres elles n'est pas bonne
     */
    public function checkAnimValuesValidity($anim_array) : bool {
        //code anim validity
        if (strlen($anim_array[0]) > 8){
            return false;
        }

        //type anim validity
        if (!in_array($anim_array[1], $this->type_anim->getTypesName())) {
            return false;
        }

        //title anim validity
        if (strlen($anim_array[2]) > 40) {
            return false;
        }

        //date validity anim validity
        if ($anim_array[3] < date('Y-m-d')) {
            return false;
        }

        //validation for duree
        if (!is_numeric($anim_array[4])) {
            return false;
        }
        if (intval($anim_array[4]) < 1) {
            return false;
        }

        //validation for tarif
        if (!is_numeric($anim_array[5])) {
            return false;
        }
        if (intval($anim_array[5]) < 0) {
            return false;
        }

        //validation for limite age
        if (!is_numeric($anim_array[6])) {
            return false;
        }
        if (intval($anim_array[6]) < 4 || intval($anim_array[6]) > 100) {
            return false;
        }

        //validation for nb place
        if (!is_numeric($anim_array[7])) {
            return false;
        }
        if (intval($anim_array[7]) < 1 || intval($anim_array[7]) > 50) {
            return false;
        }

        //validation for desciption
        if (strlen($anim_array[8]) > 250) {
            return false;
        }

        //validation for commentaire
        if (strlen($anim_array[9]) > 250) {
            return false;
        }

        //validation for difficulté
        if (strlen($anim_array[10]) > 40) {
            return false;
        }

        return true;
    }

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode
     * permettant de récupérer le nombre d'inscrit à une animation
     * @param string $code_anim - Code de l'animation dont on souhaite connaitre le nombre d'inscrit
     * @return int - Nombre d'inscrit
     */
    public function checkNbrePlaceAnim(string $code_anim): int {

        return $this->animation->checkNbrePlaceAnim($code_anim);
    }


    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode d'ajout
     * d'activité. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param array $new_act - valeurs sortantes directement du formulaire d'ajout d'activité, non néttoyées
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *   le méssage du popup à afficher
     */
    public function addActivite(array $new_act): array {

        //if values are not valid
        if (!$this->checkActValuesValidity($new_act)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Valeurs invalides!'];
        }

        if ($this->activite->doesActiviteExist($new_act[0], $new_act[3])) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'L\'activité éxiste déja!'];
        }


        $resp_array = $this->compte_controller->getNomPrenomByUser($new_act[2]);
        $new_act_array = array($new_act[0], $new_act[1], $resp_array['NOMCOMPTE'], $resp_array['PRENOMCOMPTE'], $new_act[3], $new_act[4], $new_act[5], $new_act[6], $new_act[7]);

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

        // if anim code exist
        if (!$this->animation->getAnimationByCodeAnim($act_array[0])){
            return false;
        }

        // if etat activité don't exist
        if (!in_array($act_array[1], $this->etatact_controller->getAllEtat(false))){
            return false;
        }

        //if user (encadrant) is not found
        if ($this->compte_controller->getNomPrenomByUser($act_array[2])['NOMCOMPTE'] === null){
            return false;
        }

        //if hours are hours
        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $act_array[4])) {
            return false;
        }

        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $act_array[5])) {
            return false;
        }

        if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $act_array[6])) {
            return false;
        }

        // if end hour is lower than done hour or start hour
        if (strtotime($act_array[6]) < strtotime($act_array[5]) || strtotime($act_array[6]) < strtotime($act_array[4])) {
            return false;
        }

        // if start hour is bigger than end hour or if start hour is bigger than done hour
        if (strtotime($act_array[5]) > strtotime($act_array[6]) || strtotime($act_array[5]) < strtotime($act_array[4])) {
            return false;
        }

        // if done hour is bigger than end hour or start hour
        if (strtotime($act_array[4]) > strtotime($act_array[6]) || strtotime($act_array[4]) > strtotime($act_array[5])) {
            return false;
        }

        // if 24 hours minimum have passed
        if ($act_array[3] < date("Y-m-d", strtotime('tomorrow'))) {
            return false;
        }

        //if price is a number
        if (!is_numeric($act_array[7])) {
            return false;
        }

        //if price is between 0 and 10 000
        if ($act_array[7] < 0 || $act_array[7] > 10000){
            return false;
        }

        return true;
    }

    /**
     *  Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode de
     * restauration d'une activité. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param string $act_id - Code de l'animation de l'activité
     * @param string $date_act - Date de l'activité
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function restoreActivite(string $act_id, string $date_act): array {
        return $this->activite->restoreActivite($act_id, $date_act);
    }


    /**
     *  Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode de
     * mise à jour d'une animation. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param array $anim - Array contenant les nouvelles valeurs de l'animation
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *    le méssage du popup à afficher
     */
    public function updateAnimation(array $anim): array {

        //return if no changes were made to values
        $old_anim = $this->animation->getAnimationInformationsByCodeAnim($anim[0], PDO::FETCH_NUM);
        if ($this->areArraysDifferent($anim, $old_anim)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Aucuns changements ont été effectués sur l\'animation!'];
        }

        // return if validation criteria are not met
        if (!$this->checkAnimValueForUpdate($anim, $old_anim[3])) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Valeurs invalides!'];
        }

        return $this->animation->updateAnimation($anim);
    }


    /**
     * Méthode that compare 2 array of same size
     * @param array $array_1 - Array 1 to compare
     * @param array $array_2 - Array 2 to compare
     * @return bool - Return true if no differences are found between the 2 arrays and return false if differences are
     * found
     */
    private function areArraysDifferent(array $array_1, array $array_2): bool {
        // return false if arrays are not the same size
        if (sizeof($array_1) != sizeof($array_2)) {
            return true;
        }

        return $array_1 == $array_2;
    }

    /**
     *  Méthode testant à partir de conditions précises la validités de chaques valeur avant de mettre à jour
     * l'animation
     * @param array $anim_array - Array contenant les nouvelles valeurs de l'animation
     * @param string $old_validity_date - ancienne date de validité de l'animation afin de la comparer avec la nouvelle
     * (pour éviter que la nouvelle soit en dessous de l'ancienne)
     * @return boolean - retourne true si les valeurs sont valides, sinon false
     */
    private function checkAnimValueForUpdate($anim_array, $old_validity_date): bool {
        //check code anim validity
        if (strlen($anim_array[0]) > 8){
            return false;
        }

        // check type anim validity
        if (!in_array($anim_array[1], $this->type_anim->getTypesName())) {
            return false;
        }

        //check title anim validity
        if (strlen($anim_array[2]) > 40) {
            return false;
        }

        //check validity date validity
        if ($anim_array[3] < $old_validity_date) {
            return false;
        }

        //duree validity
        if (!is_numeric($anim_array[4])) {
            return false;
        }
        if (intval($anim_array[4]) < 1) {
            return false;
        }

        //limite age validity
        if (!is_numeric($anim_array[5])) {
            return false;
        }
        if (intval($anim_array[5]) < 4 || intval($anim_array[5]) > 100) {
            return false;
        }

        //tarif validity
        if (!is_numeric($anim_array[6])) {
            return false;
        }
        if (intval($anim_array[6]) < 0) {
            return false;
        }

        //nb place validity
        if (!is_numeric($anim_array[7])) {
            return false;
        }
        if (intval($anim_array[7]) < 1 || intval($anim_array[7]) > 50) {
            return false;
        }

        //description validity
        if (strlen($anim_array[8]) > 250) {
            return false;
        }

        //commentaire validity
        if (strlen($anim_array[9]) > 250) {
            return false;
        }

        //difficulte validity
        if (strlen($anim_array[10]) > 40) {
            return false;
        }

        return true;
    }

    /**
     * Méthode permettant de récupérer toutes les informations d'une activité grâce à ses identifiants
     * @return array - Résultat de la requête SQL (array des activité)
     */
    public function getActiviteById(string $code_anim, string $date_act, int $mode=4): array {
        return $this->activite->getActiviteInformationById($code_anim, $date_act, $mode);
    }

    /**
     * Méthode permettant de faire le lien entre l'exterieur (la vue) et l'intérieur (le modele) pour la méthode d'ajout
     * d'activité. Les valeurs sont néttoyées avant d'être envoyées au modele
     * @param array $new_act - valeurs sortantes directement du formulaire d'ajout d'activité, non néttoyées
     * @return array - Format de valeur en json contenant le statut de success de la requête, le titre et
     *   le méssage du popup à afficher
     */
    public function updateActivite(array $new_act): array {

        //return if no changes where made to values
        $old_act = $this->activite->getActiviteInformationById($new_act[0], $new_act[3], PDO::FETCH_NUM);
        if ($this->areArraysDifferent($new_act, $old_act)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Aucuns changements ont été effectués sur l\'activité!'];
        }
        //if values are not valid
        if (!$this->checkActValuesValidityForUpdate($new_act)) {
            return ['success' => false, 'title' => 'Erreur', 'message' => 'Valeurs invalides!'];
        }

        $resp_array = $this->compte_controller->getNomPrenomByUser($new_act[2]);
        $new_act_array = array($new_act[0], $new_act[1], $resp_array['NOMCOMPTE'], $resp_array['PRENOMCOMPTE'], $new_act[3], $new_act[4], $new_act[5], $new_act[6], $new_act[7]);

        return $this->activite->updateActivite($new_act_array);
    }


    /**
     *  Méthode testant à partir de conditions précises la validités de chaques valeur avant de mettre à jour
     * l'activité
     * @param array $act_array - Array contenant les nouvelles valeurs de l'activité
     * @return boolean - retourne true si les valeurs sont valides, sinon false
     */
    public function checkActValuesValidityForUpdate(array $act_array): bool {

        // if anim code exist
        if (!$this->animation->getAnimationByCodeAnim($act_array[0])){
            return false;
        }

        // if etat activité don't exist
        if (!in_array($act_array[1], $this->etatact_controller->getAllEtat(false))){
            return false;
        }

        //if user (encadrant) is not found
        if ($this->compte_controller->getNomPrenomByUser($act_array[2])['NOMCOMPTE'] === null){
            return false;
        }

        //if hours are hours
        if (!preg_match("/^((?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$)/", $act_array[4])) {
            return false;
        }

        if (!preg_match("/^((?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$)/", $act_array[5])) {
            return false;
        }

        if (!preg_match("/^((?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$)/", $act_array[6])) {
            return false;
        }

        // if end hour is lower than done hour or start hour
        if (strtotime($act_array[6]) < strtotime($act_array[5]) || strtotime($act_array[6]) < strtotime($act_array[4])) {
            return false;
        }

        // if start hour is bigger than end hour or if start hour is bigger than done hour
        if (strtotime($act_array[5]) > strtotime($act_array[6]) || strtotime($act_array[5]) < strtotime($act_array[4])) {
            return false;
        }

        // if done hour is bigger than end hour or start hour
        if (strtotime($act_array[4]) > strtotime($act_array[6]) || strtotime($act_array[4]) > strtotime($act_array[5])) {
            return false;
        }

        //if price is a number
        if (!is_numeric($act_array[7])) {
            return false;
        }

        //if price is between 0 and 10 000
        if ($act_array[7] < 0 || $act_array[7] > 10000){
            return false;
        }

        return true;
    }

    /**
     * Method linked to model method that check if an activity is cancelled or not
     * @param string $code_anim - act id
     * @param string $date_act - act date
     * @return bool - Return True if the activity is cancelled, else false
     */
    public function isActCancelled(string $code_anim, string $date_act): bool {
        return $this->activite->isActCancelled($code_anim, $date_act);
    }

}