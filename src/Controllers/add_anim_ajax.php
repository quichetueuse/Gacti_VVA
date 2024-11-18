<?php
use Controllers\AnimActController;
require_once('../autoloader.php');

$animation_controller = new AnimActController();

$code_anim = $_POST['code_anim'];
$type_anim = $_POST['type_anim'];
$date_validite_anim = $_POST['date_validite_anim'];
$titre_anim = $_POST['titre_anim'];
$desc_anim = $_POST['desc_anim'];
$comment_anim = $_POST['comment_anim'];
$duree_anim = $_POST['duree_anim'];
$tarif = $_POST['tarif_anim'];
$limite_age = $_POST['limite_age'];
$nb_place = $_POST['nb_place'];
$difficulte = $_POST['difficulte'];

$new_anim = array($code_anim, $type_anim, $titre_anim, $date_validite_anim, $duree_anim, $tarif, $limite_age, $nb_place, $desc_anim, $comment_anim, $difficulte);

//$query_success = json_encode(['success' => $animation_controller->addAnimation($new_anim)]);
$query_success = json_encode($animation_controller->addAnimation($new_anim));
echo $query_success;
