<?php

namespace Controllers;
use Controllers\InscriptionController;
use Controllers\AnimActController;

final class FunctionController extends BaseController
{

    private InscriptionController $inscription_controller;
    private AnimActController $act_controller;

    public function __construct(){
        date_default_timezone_set("Europe/Stockholm");
        if (session_status() === PHP_SESSION_DISABLED || session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        $this->inscription_controller = new InscriptionController();
        $this->act_controller = new AnimActController();
    }

    public function generateHeaderDiv(bool $is_user_connected = false) : string
    {
        $nom = (array_key_exists("nom", $_SESSION)) ? $_SESSION["nom"] : "Non";
        $prenom = (array_key_exists("prenom", $_SESSION)) ? $_SESSION["prenom"] : "Connecté(e)";
        $is_user_connected = array_key_exists('prenom', $_SESSION);

        $header_div = '
                <div class="header-div">
                    <div class="flex-column-center">
                        <!-- session info div-->
                        <div>
                            <span><b>'.  $nom . ' ' . $prenom . '</b></span>
                        </div>
                
                        <!-- datetime div-->
                        <div>
                            <span id="span-current-datetime">27/09/1920 00:00:00</span>
                            <script>
                                setInterval(function() {
                                    var currentTime = new Date ( );
                                    document.getElementById("span-current-datetime").innerHTML = currentTime.toLocaleString();
                                }, 1000);
                            </script>
                        </div>
                    </div>
                    <h1 class="page-h1">VVA</h1>
            ';


        if ($is_user_connected === true)
        {
            $header_div .= '
                <!-- disconnect button div-->
                <div class="flex-center">
                    <a class="user-logoff-button" onclick="showConfirmDisconnect();" title="Se déconnecter">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="32px" height="32px"><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V256c0 17.7 14.3 32 32 32s32-14.3 32-32V32zM143.5 120.6c13.6-11.3 15.4-31.5 4.1-45.1s-31.5-15.4-45.1-4.1C49.7 115.4 16 181.8 16 256c0 132.5 107.5 240 240 240s240-107.5 240-240c0-74.2-33.8-140.6-86.6-184.6c-13.6-11.3-33.8-9.4-45.1 4.1s-9.4 33.8 4.1 45.1c38.9 32.3 63.5 81 63.5 135.4c0 97.2-78.8 176-176 176s-176-78.8-176-176c0-54.4 24.7-103.1 63.5-135.4z"/></svg>
                    </a>
                </div>
            </div>
            ';
        }

        elseif ($is_user_connected === false){
            $header_div .= '
                <!-- disconnect button div-->
                <div class="flex-center">
                    <a class="user-login-button" onclick="goToLoginForm();" title="Se connecter">
                        <img src="../../Assets/images/fa-fa-user.png">
                    </a>
                </div>
            </div>
            ';
        }

        return $header_div;
    }

    public function generateActButtonsDiv(string $act_id, string $date_act, bool $act_cancelled=false) : string {

        //clean values
        $act_id = $this->sanitize($act_id);
        $date_act = $this->sanitize($date_act);
        $act_cancelled = $this->sanitize($act_cancelled);

        $button = '';

        //si utilisateur pas connecté
        if (!array_key_exists('type_profil', $_SESSION)){ //faire guard clause
            $button = '<button class="btn-card-connect" title="Se connecter" onclick="document.location.href = `../Views/login.php`">Se connecter</button>';
            return $button;
        }

        //si encadrant connecté
        if ($_SESSION['type_profil'] === '1') {
//            $button = '<div style="display: flex; flex-direction: row; column-gap: 10px; justify-content: center; width: 100%;">
//               <button title="Voir les inscrits">Voir les inscrits</button>
//               <button title="Supprimer l\'activité" class="delete-btn" onclick="showConfirmDelete(`'. $act_id .'`, `'. $date_act .'`);">Supprimer</button>
//               </div>';
            $get_method_string = "?act_id='". $act_id ."'&date_act='". $date_act ."'";
            $button = '<div class="card-btn-div">
               <button title="Voir les inscrits" class="show-inscrit-btn" onclick="document.location.href = `../Views/show_inscrits.php'. $get_method_string . '`">Voir les inscrits</button>';

            $date_now = strtotime(date('Y-m-d'));
            # if activity is not cancelled and is now for today (or is not passed)
            if (!$act_cancelled and round(($date_now - strtotime($date_act)) / (60*60*24) ) < -1){
//                $get_method_string = "?act_id='". $act_id ."'&date_act='". $date_act ."'";
                $button .= '<button class="edit-btn" title="éditer l\'animation" onclick="document.location.href = `../Views/edit_activite.php'. $get_method_string . '`">Éditer</button>';
            }
            if ($act_cancelled) {
                $button .= '<button title="Restaurer l\'activité" class="add-btn" onclick="showConfirmRestore(`'. $act_id .'`, `'. $date_act .'`);">Restaurer</button>';
            }
            else {
                $button .= '<button title="Supprimer l\'activité" class="delete-btn" onclick="showConfirmDelete(`'. $act_id .'`, `'. $date_act .'`);">Supprimer</button>';
            }

            $button .= '</div>';
            return $button;
        }

        //si type profil = 0 (vacancier)
        $user_inscrit = $this->inscription_controller->isUserInscritToAct($_SESSION['user'], $act_id, $date_act);

        //si l'utilisateur est inscrit à l'activité
        if ($user_inscrit) {
            $button = '<button class="delete-btn" title="Se Désinscrire" onclick="showConfirmDesinscription(`'. $act_id .'`, `'. $date_act .'`)">Se Désinscrire</button>';
            return $button;
        }

        $nb_places_prises = $this->inscription_controller->getNumberInscritByActCodeAnim($act_id, $date_act);
        $nb_place_totale = $this->act_controller->checkNbrePlaceAnim($act_id);
        $act_pleine = $nb_places_prises < $nb_place_totale;
        //si pas inscrit mais qu'il reste de la place
        if (!$user_inscrit && $nb_places_prises < $nb_place_totale) {
            $button = '<button '. (bool)($nb_places_prises < $nb_place_totale) .' class="add-btn" title="S \'inscrire" onclick="showConfirmInscription(`' . $act_id . '`, `' . $date_act . '`)">S \'inscrire</button>';
            return $button;
        }

        //si pas inscrit et qu'il n'y à plus de place
//        if (!$user_inscrit && $nb_places_prises >= $nb_place_totale) {
        if (!$user_inscrit && $this->inscription_controller->isActFull($act_id, $date_act)) {
            $button = '<button disabled class="act-full-btn" title="L\'activité est pleine" >L\'activité est pleine</button>';
            return $button;
        }

//        if ($_SESSION['type_profil'] === '0') {
//
//
//            if (!$user_inscrit && (int)$this->inscription_controller->getNumberInscritByActCodeAnim($act_id, $date_act) < (int)$this->act_controller->checkNbrePlaceAnim($act_id)) {
//                $button = '<button class="add-btn" title="S \'inscrire" onclick="showConfirmInscription(`'. $act_id .'`, `'. $date_act .'`)">S \'inscrire</button>';
////                    if ((int)$this->inscription_controller->getNumberInscritByActCodeAnim($act_id, $date_act) < (int)$this->act_controller->checkNbrePlaceAnim($act_id)){
////                        $button = '<button class="add-btn" title="S \'inscrire" onclick="showConfirmInscription(`'. $act_id .'`, `'. $date_act .'`)">S \'inscrire</button>';
////                        return $button;
////                    }
////                    else{
////                        $button = '<button disabled class="act-full-btn" title="L\'activité est pleine" >L\'activité est pleine</button>';
////                        return $button;
////                    }
////                    $button = '<button class="add-btn" title="S \'inscrire" onclick="showConfirmInscription(`'. $act_id .'`, `'. $date_act .'`)">S \'inscrire</button>';
//            }
//            elseif (!$user_inscrit && (int)$this->inscription_controller->getNumberInscritByActCodeAnim($act_id, $date_act) >= (int)$this->act_controller->checkNbrePlaceAnim($act_id)) {
//                $button = '<button disabled class="act-full-btn" title="L\'activité est pleine" >L\'activité est pleine</button>';
//            }
//            elseif ($user_inscrit) {
//                $button = '<button class="delete-btn" title="Se Désinscrire" onclick="showConfirmDesinscription(`'. $act_id .'`, `'. $date_act .'`)">Se Désinscrire</button>';
//                return $button;
//            }
//        }
        return $button;
    }

    public function generatePlusCard() : string {
        $plus_card = '
    <div class="add-card">
        <button class="add-btn" onclick="document.location.href = `../Views/add_activite.php`"><img src="../../Assets/images/fa-fa-plus2.png"></button>
    </div>';
        return $plus_card;
    }

    public function generateAnimsControlDiv() : string {

        $anim_list = $this->act_controller->getAllAnimations();

        $div = '
        <div class="anim-control-div flex-row">
            <div style="width: 50%">
                <h1 class="grey-border white-title text-center">Animations disponibles :</h1>
                <div class="input-group mb-3"">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="select-anim">Animations: </label>
                    </div>
                    <select class="form-control" id="select-anim" name="select-anim" onchange="showActivitiesByAnim(this.value);">
                        <option selected value="all">Toutes les animations</option>';

        foreach ($anim_list as $anim) {
            $div .= '<option title="'. $anim["COMMENTANIM"] .'" value="' . $anim["CODEANIM"] . '">' . $anim['NOMANIM'] . ' | ' . $anim['DESCRIPTANIM'] . '</option>';
        }


        $div .= '
                        </select>
                    </div>
                </div>
                <div class="flex-column-center menu-btn-div">';


        //start session if not alrerady started
        if (session_status() === PHP_SESSION_DISABLED || session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }

        // if user is an encadrant
        if (array_key_exists('type_profil', $_SESSION)) {
            if ($_SESSION['type_profil'] == 1) {
                $div .= '<button class="middle-table-div-button" onclick="document.location.href = `../Views/add_animation.php`" style="width: 100%;">Ajouter une animation</button>
                         <button class="middle-table-div-button" onclick="document.location.href = `../Views/edit_animation.php`" style="width: 100%;">Éditer une animation</button>';
            }
        }

//        //check if session started (it mean the user is not an encadrant)
//        if (session_status() === PHP_SESSION_DISABLED || session_status() === PHP_SESSION_NONE)
//        {
//            session_start();
//            $div .= '<button class="middle-table-div-button" onclick="document.location.href = `../Views/add_animation.php`" style="width: 100%;">Ajouter une animation</button>
//                    <button class="middle-table-div-button" style="width: 100%;" onclick="document.location.href = `../Views/test_date.php`">Debug</button>
//
//                </div>
//            </div>';
//            return $div;
//
//        }
//
//        if (array_key_exists('type_profil', $_SESSION)){
//
//        }
//
//        $div .= '
//                    </select>
//                </div>
//            </div>
//            <div class="flex-column-center" style="gap: 20px; flex-wrap: wrap; border: 1px solid black; height: 100%; width: auto; margin-left: 30px;">
//                <button class="middle-table-div-button" onclick="document.location.href = `../Views/add_animation.php`" style="width: 100%;">Ajouter une animation</button>
//                <button class="middle-table-div-button" style="width: 100%;" onclick="document.location.href = `../Views/test_date.php`">Debug</button>
//
//            </div>
//        </div>';

        $div .= '
                </div>
            </div>';
        return $div;
    }

    public function generateInscritUserCard(string $code_anim, string $date_act): string {
        $user_card = '';

        $users_inscits = $this->inscription_controller->getAllUserInscriptionById($code_anim, $date_act);
        foreach ($users_inscits as $user) {
            //get total inscription from this user on every activity
            $total_user_inscription = $this->inscription_controller->getCountInscriptionByUser($user['NOMCOMPTE'], $user['PRENOMCOMPTE']);
            $user_card .= '
                <div class="user-summary-card">
                    <h3 class="card-title text-center grey-border bold insc-card-title">Mr '. $user["NOMCOMPTE"] . ' ' . $user["PRENOMCOMPTE"] .'</h3>
                    <p style="padding-top: 1rem;"><strong>En vacances du <span class="visible-value grey-border">'. $user["DATEDEBSEJOUR"] .'</span> au <span style="font-size: 15pt; color: palegreen" class=" grey-border">'. $user["DATEFINSEJOUR"] . '</span></strong></p>
                    <p><strong>Date d\'inscription:&nbsp<span class="visible-value grey-border">'. $user["DATEINSCRIP"] .'</span></strong></p>
                    <p><strong>Code de l\'inscription:&nbsp<span class="visible-value grey-border">'. $user["NOINSCRIP"] .'</span></strong></p>
                    <p><strong>Inscrit à<span class="visible-value grey-border">&nbsp'. $total_user_inscription .'&nbsp</span>activités au total</strong></p>
                </div>
            ';



        }
        return $user_card;
    }


}