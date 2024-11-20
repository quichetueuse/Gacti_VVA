<?php
use Controllers\AnimActController;
require_once('../autoloader.php');

$animation_controller = new AnimActController();
$animation = $animation_controller->getAnimationByCodeAnim($_GET['code_anim']);

$code_anim = $animation['CODEANIM'];
$type_anim = $animation['CODETYPEANIM'];
$date_validite_anim = $animation['DATEVALIDITEANIM'];
$titre_anim = $animation['NOMANIM'];
$desc_anim = $animation['DESCRIPTANIM'];
$comment_anim = $animation['COMMENTANIM'];
$duree_anim = $animation['DUREEANIM'];
$tarif = $animation['TARIFANIM'];
$limite_age = $animation['LIMITEAGE'];
$nb_place = $animation['NBREPLACEANIM'];
$difficulte = $animation['DIFFICULTEANIM'];

$structured_animation = json_encode(
    ['CODEANIM' => $code_anim,
    'CODETYPEANIM' => $type_anim,
    'DATEVALIDITEANIM' => $date_validite_anim,
    'NOMANIM' => $titre_anim,
        'DESCRIPTANIM' => $desc_anim,
        'COMMENTANIM' => $comment_anim,
        'DUREEANIM' => $duree_anim,
        'TARIFANIM' => $tarif,
        'LIMITEAGE' => $limite_age,
        'NBREPLACEANIM' => $nb_place,
        'DIFFICULTEANIM' => $difficulte]);

echo $structured_animation;