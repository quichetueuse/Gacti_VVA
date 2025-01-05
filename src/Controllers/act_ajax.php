<?php
use Controllers\AnimActController;
use Controllers\FunctionController;
use Controllers\InscriptionController;
require_once('../autoloader.php');

session_start();
$function_controller = new FunctionController();
$activites_controller = new AnimActController();
$inscription_controller = new InscriptionController();
$code_anim = $_GET['code_anim'];

// si session pas connectée
if (!array_key_exists('type_profil', $_SESSION)) {
    $acts_list = $activites_controller->getAllActivitesByAnim($code_anim, 'valid');
}

// si encadrant
elseif ($_SESSION['type_profil'] == 1) {
    $acts_list = $activites_controller->getAllActivitesByAnim($code_anim);
}

// si vacancier
else {
    $acts_list = $activites_controller->getAllActivitesByAnim($code_anim, 'valid');
}

//$acts_list = $activites_controller->getAllActivitesByAnim($code_anim);
//echo '<script>console.log('. echo $acts_list[0]['DUREEACT'] . ')</script>';
//$button = '';
//
//if (array_key_exists('type_profil', $_SESSION)) {
//
//    if ($_SESSION['type_profil'] === '0') {
//        $button = '<button title="S \'inscrire">S \'inscire</button>';
//    }
//    if ($_SESSION['type_profil'] === '1') {
//        $button = '<div style="display: flex; flex-direction: row; column-gap: 10px; justify-content: center; width: 100%;">
//                   <button title="Voir les inscrits" style="width: 100%">Voir les inscrits</button>
//                   <button title="Supprimer l\'activité" class="delete-btn" onclick="showConfirmDelete('. $ .');">Supprimer</button>
//                   </div>';
//    }
//}
//// ajouter valeur
//else
//{
//    $button = '<button title="Se connecter" onclick="document.location.href = `../Views/login.php`">Se connecter</button>';
//}
foreach ($acts_list as $act){
    $nb_inscrit = $inscription_controller->getNumberInscritByActCodeAnim($act["CODEANIM"], $act['DATEACT']);

    // get card class
    $card_class = 'card';
    if ($act["DATEANNULEACT"] != null) {
        $card_class = 'canceled-card';
    }




    //affichage des activités valides dont la date n'est pas passée
    if (array_key_exists('type_profil', $_SESSION)) { //todo faire en sorte qu'une activité dont la date est passé soit traité comme une activité supprimée (rose)
        if ($_SESSION['type_profil'] == 0 && $act['DATEACT'] < date("Y-m-d H:i:s")) {
            continue;
        }
    }
    elseif ($act['DATEACT'] < date("Y-m-d H:i:s")) {
        continue;
    }






//    $card_color = $act["DATEANNULEACT"] != null ? 'style="background-color: #f5dbff;"' : ''; //#e0abf5

    $card_title = $act['DATEACT'] < date("Y-m-d H:i:s") ? ('<span style="color:red;">(Date dépassée)<br>&nbsp</span>' . $act["NOMANIM"]) : $act["NOMANIM"];
    echo '
    <div class="'. $card_class .'">
        <h3 class="card-title text-center grey-border bold">'. $card_title .'</h3>
        <p><strong>Description: </strong>'. $act["DESCRIPTANIM"] .'</p>
        <p><strong>Commentaire: </strong>'. $act["COMMENTANIM"] .'</p>
        
        <hr style="border-width:1px; background-color:black;">
        <p><strong>Date de l\'activité: </strong>'. $act["DATEACT"] .'</p>
        <p><strong>Horraire d\'arrivé: </strong>'. $act["HRRDVACT"] .'</p>
        <p><strong>Durée (minutes): </strong>' . $act["DUREEANIM"] . '</p>
        
        <p><strong>Nombre de place: </strong>'. $nb_inscrit .'/'.$act["NBREPLACEANIM"] .' ('. ((int)$act["NBREPLACEANIM"] - $nb_inscrit) .' restantes)</p>
        <p><strong>Tarif: </strong>' . $act["PRIXACT"] . '€</p>
        <p><strong>Limite d\'age: </strong>'. $act["LIMITEAGE"] .'</p>
        <p><strong>Difficulté: </strong>'. $act["DIFFICULTEANIM"] .'</p>
        <p><strong>Responsable de l\'activité: </strong>'. $act['PRENOMRESP'] . " " . $act['NOMRESP'] .'</p>
        
        '. $function_controller->generateActButtonsDiv($act["CODEANIM"], $act['DATEACT'], $act["DATEANNULEACT"] === null ? false : true) .'
    </div>';
}//background-color: navajowhite;
//        <h3 class="card-title text-center grey-border bold">'. $act["HRRDVACT"] .'</h3>

//        <p><strong>Horraire de départ: </strong>'. $act["HRDEBUTACT"] .'</p>
//        <p><strong>Horraire de fin: </strong>'. $act["HRFINACT"] .'</p>

// affiche ou non le bouton d'ajout d'une activité en fonction du tyoe de profil connecté (affiché uniquement si profil personnel)
if (array_key_exists('type_profil', $_SESSION)) {
    if ($_SESSION['type_profil'] === '1') {
        echo $function_controller->generatePlusCard();
    }
}
//echo '
//    <div class="add-card">
//        <button class="add-btn"><img src="../../Assets/images/fa-fa-plus2.png"></button>
//    </div>';