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

foreach ($acts_list as $act){
    $nb_inscrit = $inscription_controller->getNumberInscritByActCodeAnim($act["CODEANIM"], $act['DATEACT']);

    // get card class
    $card_class = 'card';
    if ($act["DATEANNULEACT"] != null) {
        $card_class = 'canceled-card';
    }

    //affichage des activités valides dont la date n'est pas passée
    if (array_key_exists('type_profil', $_SESSION)) {
        if ($_SESSION['type_profil'] == 0 && $act['DATEACT'] < date("Y-m-d H:i:s")) {
            continue;
        }
    }
    elseif ($act['DATEACT'] < date("Y-m-d H:i:s")) {
        continue;
    }


    // Convert date_act to date and get current date
    $date_act = strtotime($act['DATEACT']);
    $date_now = strtotime(date('Y-m-d'));

    // calculate how many days is between the 2 dates
    $date_diff = round(($date_now - $date_act) / (60 * 60 * 24));

    $card_date_string = $act['DATEACT'] . ' (';
    if ($date_diff < 0){
        $card_date_string .= 'Dans ' . abs($date_diff) . ' jour(s))';
    }
    else {
        $card_date_string .= 'Dépassé depuis ' . abs($date_diff) . ' jour(s))';
    }

    $card_title = $act['DATEACT'] < date("Y-m-d H:i:s") ? ('<span style="color:red;">(Date dépassée)<br>&nbsp</span>' . $act["NOMANIM"]) : $act["NOMANIM"];
    echo '
    <div class="'. $card_class .'">
        <h3 class="card-title text-center grey-border bold">'. $card_title .'</h3>
        <p><strong>Description: </strong>'. $act["DESCRIPTANIM"] .'</p>
        <p><strong>Commentaire: </strong>'. $act["COMMENTANIM"] .'</p>
        
        <hr style="border-width:1px; background-color:black;">
        <p><strong>Date de l\'activité: </strong>'. $card_date_string .'</p>
        <p><strong>Horraire d\'arrivé: </strong>'. $act["HRRDVACT"] .'</p>
        <p><strong>Durée (minutes): </strong>' . $act["DUREEANIM"] . '</p>
        
        <p><strong>Nombre de place: </strong>'. $nb_inscrit .'/'.$act["NBREPLACEANIM"] .' ('. ((int)$act["NBREPLACEANIM"] - $nb_inscrit) .' restantes)</p>
        <p><strong>Tarif: </strong>' . $act["PRIXACT"] . '€</p>
        <p><strong>Limite d\'age: </strong>'. $act["LIMITEAGE"] .'</p>
        <p><strong>Difficulté: </strong>'. $act["DIFFICULTEANIM"] .'</p>
        <p><strong>Responsable de l\'activité: </strong>'. $act['PRENOMRESP'] . " " . $act['NOMRESP'] .'</p>
        
        '. $function_controller->generateActButtonsDiv($act["CODEANIM"], $act['DATEACT'], $act["DATEANNULEACT"] === null ? false : true) .'
    </div>';
}

// show create activity button only if connected user is encadrant
if (array_key_exists('type_profil', $_SESSION)) {
    if ($_SESSION['type_profil'] === '1') {
        echo $function_controller->generatePlusCard();
    }
}