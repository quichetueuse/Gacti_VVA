<?php
use Controllers\AnimActController;
use Controllers\CompteController;
require_once('../autoloader.php');
$act_controller = new AnimActController();
$compte_controller = new CompteController();

$code_anim = $_POST['code_anim'];
$etat_act = $_POST['etat_act'];
//$resp_array = $compte_controller->getNomPrenomByUser($_POST['resp_act']);
//if (!array_key_exists('NOMCOMPTE', $resp_array) || !array_key_exists('PRENOMCOMPTE', $resp_array)) {
//if ($resp_array['NOMCOMPTE'] === false || $resp_array['PRENOMCOMPTE'] === false) {
//    echo json_encode(['success' => false, 'title' => 'Erreur', 'message' => 'Nom ou prénom invalide']);
//    return;
//}
//foreach ($resp_array as $value) {
//    echo $value. '<br>';
//}
//$nom_resp = $resp_array['NOMCOMPTE'];
//$prenom_resp = $resp_array['PRENOMCOMPTE'];
$user_id = $_POST['resp_act'];
$date_act = $_POST['date_act'];
$heure_arrive = $_POST['heure_arrive'];
$heure_depart = $_POST['heure_depart'];
$heure_fin = $_POST['heure_fin'];
$tarif = $_POST['tarif'];

$new_act = array($code_anim, $etat_act, $user_id, $date_act, $heure_arrive, $heure_depart, $heure_fin, $tarif);

//foreach ($new_act as $value) {
//    echo $value. '<br>';
//}
//$query_success = json_encode(['success' => $act_controller->addActivite($new_act)]);
$query_success = json_encode($act_controller->addActivite($new_act));
//echo $act_controller->addActivite($new_act);
echo $query_success;
