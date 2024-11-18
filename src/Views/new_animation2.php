<?php
use Controllers\AnimActController;
use Controllers\FunctionController;

require_once('../autoloader.php');
//$animation_controller = new AnimationController();
//$anim_list = $animation_controller->getAllAnimations();
$animation_controller = new AnimActController();
$anim_list = $animation_controller->getAllAnimations();

$function_controller = new FunctionController();

//todo lorque vacancier / pas connecté: ne pas afficher carte activité supprimé
//session_start();
//$nom = (array_key_exists("nom", $_SESSION)) ? $_SESSION["nom"] : "Non";
//$prenom = (array_key_exists("prenom", $_SESSION)) ? $_SESSION["prenom"] : "Connecté(e)";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des animations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../ajax_main_page.js"></script>
    <!--    <script src="' . SITE_URL . '/Services/globals_functions.js"></script>-->
</head>
<body>

<?php
echo $function_controller->generateHeaderDiv();
echo $function_controller->generateAnimsControlDiv();
?>


<div class="act-card-container" id="act-card-container">
<!--    <div class="card">-->
<!--        <h3 class="card-title text-center grey-border bold">Nom de l'animation</h3>-->
<!--        <p><strong>Durée (minutes): </strong>tgirrfrf</p>-->
<!--        <p><strong>Tarif (€): </strong>tgirrfrf</p>-->
<!--        <p><strong>Limite d'age: </strong>tgirrfrf</p>-->
<!--        <p><strong>Difficulté: </strong>tgirrfrf</p>-->
<!--        <p><strong>Nombre de place: </strong>tgirrfrf</p>-->
<!--        <p><strong>Description: </strong>tgirrfrf</p>-->
<!--    </div>-->
</div>
<script>
    showActivitiesByAnim('all');
</script>
</body>
</html>


<!--<div class="anim-control-div flex-row">-->
<!--    <div style="width: 50%">-->
<!--        <h1 class="grey-border white-title text-center">Animations disponibles :</h1>  (--><?php //echo $animation_controller->getCountAnimations(); ?><!--)-->
<!--        <div class="input-group mb-3"">-->
<!--        <div class="input-group-prepend">-->
<!--            <label class="input-group-text" for="select-anim">Animations: </label>-->
<!--        </div>-->
<!--        <select class="form-control" id="select-anim" name="select-anim" onchange="filterActivitiesByAnim();">-->
<!--                       <option value="" disabled selected>Selectionnez un type d'animation</option>-->
<!--            <option selected value="all">Toutes les animations</option>-->
<!--            --><?php
//            foreach ($anim_list as $anim)
//            {
////                         if ($user['username'] == $resp_suivi)
////                             echo '<option selected="selected" value="'. $user["username"] .'">'. $user['username']. ' | ' . $user['email'] . ' | ' . $user['trigramm'] .'</option>';
////                         else
//                echo '<option value="'. $anim["CODEANIM"] .'">'. $anim['NOMANIM'] . ' | ' . $anim['DESCRIPTANIM'] . '</option>';
//            } ?>
<!--        </select>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="flex-column-center" style="gap: 20px; flex-wrap: wrap; border: 1px solid black; height: 100%; width: auto; margin-left: 30px;">-->
<!--    <button class="middle-table-div-button" onclick="document.location.href = '../Views/add_animation.php'" style="width: 100%;">Ajouter une animation</button>-->
<!--    <button class="middle-table-div-button" style="width: 100%;" onclick="document.location.href = '../Views/test_date.php'">rfrfrf</button>-->
<!---->
<!--</div>-->
<!--    <h1 class="grey-border white-title">Activités disponibles pour l'animation (--><?php ////echo $animation_controller->getCountActivitesByAnim('<script>document.getElementById(`select-anim`).value;</script>'); ?><!--) :</h1>-->
<!--</div>-->