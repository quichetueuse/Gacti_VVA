
<?php

use trash\ActiviteController;

require_once('../autoloader.php');
$activite_controller = new ActiviteController();
$act_list = $activite_controller->getAllActivites();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des activites</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <!--    <script src="' . SITE_URL . '/Services/globals_functions.js"></script>-->
</head>
<body class="body-middle-div">
<div class="middle-table-div">
    <h1>Activités disponibles (<?php echo $activite_controller->getCountActivites(); ?>) :</h1>
    <div class="table-overflow-container">
    <table class="table table-hover table-striped table-bordered">
        <thead class="sticky-header">
        <tr>
            <th>#</th>
            <th>Date de l'activité</th>
            <th>Statut de l'activité</th>
            <th>Heure d'arrivé</th>
            <th>Prix (€)</th>
            <th>Début de l'activté</th>
            <th>Fin de l'activité</th>
            <th>Encadrant</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($act_list as $act)
        {
            echo '<tr>';
            echo '<th scope="row">'. $i .'</th>';
            echo '<td>' . $act['DATEACT'] . '</td>';
            echo '<td>' . $act['CODEETATACT'] . '</td>';
            echo '<td>' . $act['HRRDVACT'] . '</td>';
            echo '<td>' . $act['PRIXACT'] . '</td>';
            echo '<td>' . $act['HRDEBUTACT'] . '</td>';
            echo '<td>' . $act['HRFINACT'] . '</td>';
            echo '<td>' . $act['PRENOMRESP'] . ' ' . $act['NOMRESP'] . '</td>';
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