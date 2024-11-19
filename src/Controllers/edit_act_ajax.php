<?php
use Controllers\AnimActController;
use Controllers\CompteController;
require_once('../autoloader.php');
$act_controller = new AnimActController();
$compte_controller = new CompteController();

$code_anim = $_POST['code_anim'];
$etat_act = $_POST['etat_act'];
$user_id = $_POST['resp_act'];
$date_act = $_POST['date_act'];
$heure_arrive = $_POST['heure_arrive'];
$heure_depart = $_POST['heure_depart'];
$heure_fin = $_POST['heure_fin'];
$tarif = $_POST['tarif'];

$new_act = array($code_anim, $etat_act, $user_id, $date_act, $heure_arrive, $heure_depart, $heure_fin, $tarif);

//$query_success = json_encode(['success' => true, 'title' => $new_act[0], 'message' => 'You\'ve been trolled!']);
$query_success = json_encode($act_controller->updateActivite($new_act));
echo $query_success;
