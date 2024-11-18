<?php

use trash\AnimationController;

require_once('../autoloader.php');
$animation_controller = new AnimationController();
$anim_list = $animation_controller->getAllAnimations();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des animations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <!--    <script src="' . SITE_URL . '/Services/globals_functions.js"></script>-->
</head>
<body class="body-middle-div">
<div class="middle-table-div">
    <h1 class="text-center grey-border white-title">Animations disponibles (<?php echo $animation_controller->getCountAnimations(); ?>) :</h1>
    <div class="table-overflow-container" style="padding: 10px;">

        <!-- Champ de choix de l'animation -->
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="select-anim">Animations: </label>
            </div>
            <select class="form-control" id="select-anim" name="select-anim">
                <option value="" disabled selected>Selectionnez un type d'animation</option>
                <?php
                foreach ($anim_list as $anim)
                {
//                         if ($user['username'] == $resp_suivi)
//                             echo '<option selected="selected" value="'. $user["username"] .'">'. $user['username']. ' | ' . $user['email'] . ' | ' . $user['trigramm'] .'</option>';
//                         else
                    echo '<option value="'. $anim["CODEANIM"] .'">'. $anim['NOMANIM'] . ' | ' . $anim['DESCRIPTANIM'] . '</option>';
                } ?>
            </select>
        </div>
        <p>
            Description: <br>
            Prix: <br>
            Nombre de place: <br>

        </p>
    </div>
    <div class="flex-row-center middle-table-div-button-container">
        <button class="middle-table-div-button">S'inscrire</button>
        <button class="middle-table-div-button" onclick="history.back()">Click me</button>
    </div>
</div>
<div class="header">
    <h1 class="grey-border white-title text-center">Animations disponibles (<?php echo $animation_controller->getCountAnimations(); ?>) :</h1>
</div>
</body>
</html>