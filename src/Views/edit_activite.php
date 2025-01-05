<?php

require_once('../autoloader.php');

use Controllers\AnimActController;
use Controllers\CompteController;
use Controllers\EtatActController;


$activite_controller = new AnimActController();
$compte_controller = new CompteController();
$etatact_controller = new EtatActController();

session_start();

//if user is not connected
if (!array_key_exists('type_profil',$_SESSION)) {
    header('location: new_animation2.php');
}

//if user is not an encadrant
if ($_SESSION['type_profil'] == '0') {
    header('location: new_animation2.php');
}


$act_id = $_GET['act_id'];
$date_act = $_GET['date_act'];

$activite = $activite_controller->getActiviteById($act_id, $date_act, PDO::FETCH_ASSOC);

//if array is empty (mean no activite with given id/code exists)
if (empty($activite)) {
    header('location: new_animation2.php');
}

$date_now = strtotime(date('Y-m-d'));

// if activity is for today or is passed
if ( round(($date_now - strtotime($activite['DATEACT'])) / (60*60*24) ) >= -1 ) {
    header('location: new_animation2.php');
}

$code_act = $activite['CODEANIM'];
$date_act = $activite['DATEACT'];
$etat_act = $activite['CODEETATACT'];

$heure_arrive = $activite['HRRDVACT'];
$heure_depart = $activite['HRDEBUTACT'];
$heure_fin = $activite['HRFINACT'];

//$heure_arrive = date('H:i', strtotime($activite['HRRDVACT']));
//$heure_depart = date('H:i', strtotime($activite['HRDEBUTACT']));
//$heure_fin = date('H:i', strtotime($activite['HRFINACT']));


//$heure_arrive = DateTime::createFromFormat('H:i', $activite['HRRDVACT']);
//$heure_depart = DateTime::createFromFormat('H:i', $activite['HRDEBUTACT']);
//$heure_fin = DateTime::createFromFormat('H:i', $activite['HRFINACT']);

$tarif = $activite['PRIXACT'];
$resp = $activite['USER'];


//echo '<h1>'. $act_id. ' | '. $date_act .'</h1>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Éditer une activité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../ajax_edit_act.js"></script>

</head>
<body class="body-middle-div">
<div class="middle-form-div">
    <h1 class="text-center grey-border white-title">Éditer une activité</h1>
    <form method="post" action="../Controllers/edit_anim_ajax.php" enctype="multipart/form-data" name="edit-act-form" id="edit-act-form" class="add-form">
        <div class="form-overflow-container">

            <input type="hidden" class="form-control" id="edit-code-anim" name="edit-code-anim" required value="<?php echo $code_act; ?>">


            <!-- Champ du code de l'état de l'activité -->
            <p class="error-p" id="error-code-etat-act"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="edit-code-etat-act">État de l'activité</label>
                </div>
                <select class="form-control" id="edit-code-etat-act" name="edit-code-etat-act" required onchange="validateFields(this.id);">
                    <option value="" disabled selected>Selectionnez un état pour l'activité</option>
                    <?php
                    foreach ($etatact_controller->getAllEtat() as $etat)
                    {
                        if ($etat['CODEETATACT'] === 'CA')
                        {
                            continue;
                        }
                        if ($etat["CODEETATACT"] === $etat_act) {
                            echo '<option selected="selected" value="'. $etat["CODEETATACT"] .'">'. $etat['NOMETATACT'].'</option>';
                        }
                        else {
                            echo '<option value="'. $etat["CODEETATACT"] .'">'. $etat['NOMETATACT'].'</option>';
                        }
                    } ?>
                </select>
            </div>

            <!-- Champ du responsable de  l'activité -->
            <p class="error-p" id="error-resp-act"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="edit-resp-act">Responsable de l'activité</label>
                </div>
                <select class="form-control" id="edit-resp-act" name="edit-resp-act" required onchange="validateFields(this.id);">
                    <option value="" disabled selected>Selectionnez un Responsable pour l'activité</option>
                    <?php
                    foreach ($compte_controller->getAllUser() as $user)
                    {
                        if ($user['TYPEPROFIL'] == 0){ //todo vérifier si ça marche (car activité encardré par vacancier :/)
                            continue;
                        }

                        if ($user['USER'] == $resp)
                            echo '<option selected="selected" value="'. $user["USER"] .'">'. $user["PRENOMCOMPTE"].' | '. $user["NOMCOMPTE"] .'</option>';
                        else
                            echo '<option value="'. $user["USER"] .'">'. $user["PRENOMCOMPTE"].' | '. $user["NOMCOMPTE"] .'</option>';
                    } ?>
                </select>
            </div>

            <!-- Champ de la date de l'activité -->
            <input type="hidden" class="form-control" placeholder="Saississez une date pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $date_act; ?>" id="edit-date-act" name="edit-date-act" required>

            <!-- Champ de l'heure d'arrivé -->
            <p class="error-p" id="error-time-arrive"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Heure d'arrivé</span>
                </div>
                <input type="time" class="form-control" placeholder="Saississez une heure d'arrivé pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $heure_arrive; ?>" id="edit-time-arrive" name="edit-time-arrive" required onkeyup="validateFields('hour');">
            </div>

            <!-- Champ de l'heure de départ -->
            <p class="error-p" id="error-time-depart"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Heure de départ</span>
                </div>
                <input type="time" class="form-control" placeholder="Saississez une heure de départ pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $heure_depart; ?>" id="edit-time-depart" name="edit-time-depart" required onkeyup="validateFields('hour');">
            </div>

            <!-- Champ de l'heure de fin -->
            <p class="error-p" id="error-time-fin"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Heure de fin</span>
                </div>
                <input type="time" class="form-control" placeholder="Saississez une heure de de fin pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $heure_fin; ?>" id="edit-time-fin" name="edit-time-fin" required onkeyup="validateFields('hour');">
            </div>


            <!-- Champ du tarif de l'animation -->
            <p class="error-p" id="error-tarif"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Tarif de l'activité</span>
                </div>
                <input type="number" min="0" class="form-control" placeholder="Saississez un tarif pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value='<?php echo $tarif; ?>' id="edit-tarif-act" name="edit-tarif-act" required onkeyup="validateFields(this.id);">
            </div>

        </div>
        <div class="flex-row-center middle-table-div-button-container">
            <button class="middle-table-div-button" type="reset" form="edit-act-form" style="width: 33%;">Vider le formulaire</button>
            <button type="button" class="middle-table-div-button" form="edit-act-form" id="submit-btn" onclick="confirmFormSubmission();" style="width: 33%">Mettre à jour</button>
            <button class="middle-table-div-button" onclick="window.history.go(-1); return false;" style="width: 33%">Retour</button>
        </div>
    </form>
</div>
<script>
    updateFieldsValidity();
</script>
</body>
</html>
