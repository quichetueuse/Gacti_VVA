<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <title>Page de connexion</title>-->
<!--</head>-->
<!--<body>-->
<!--    <h1>Page de login</h1>-->
<!--</body>-->
<!--</html>-->
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
    <div class="table-overflow-container">
    <table class="table table-hover table-striped table-bordered">
        <thead class="sticky-header">
        <tr>
            <th>#</th>
            <th>Nom de l'animation</th>
            <th>Durée (minutes)</th>
            <th>Tarif (€)</th>
            <th>Limite d'age</th>
            <th>Difficulté</th>
            <th>Nombre de place</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($anim_list as $anim)
        {
//            echo '<tr onclick="window.location.href = `login_failed.php?is_failed='. $anim['CODEANIM'] . '`;">';
            echo '<tr onclick="window.location.href = `activites.php?code_anim='. $anim['CODEANIM'] . '`;">';
            echo '<th scope="row">'. $i .'</th>';
            echo '<td>' . $anim['NOMANIM'] . '</td>';
            echo '<td>' . $anim['DUREEANIM'] . '</td>';
            echo '<td>' . $anim['TARIFANIM'] . '</td>';
            echo '<td>' . $anim['LIMITEAGE'] . '</td>';
            echo '<td>' . $anim['DIFFICULTEANIM'] . '</td>';
            echo '<td>' . $anim['NBREPLACEANIM'] . '</td>';
            echo '<td>' . $anim['DESCRIPTANIM'] . '</td>';
            echo '</tr>';
            $i++;

        }

        ?>
        </tbody>
    </table>
    </div>
    <div class="flex-row-center middle-table-div-button-container">
        <button class="middle-table-div-button">S'inscrire</button>
        <button class="middle-table-div-button" onclick="history.back()">Click me</button>
    </div>
</div>
</body>
</html>