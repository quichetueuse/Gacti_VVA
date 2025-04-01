<?php
session_start();
if (!array_key_exists('type_profil',$_SESSION)) {
    header('location: main_window.php');
}
if ($_SESSION['type_profil'] == '0') {
    header('location: main_window.php');
}

use Controllers\AnimActController;
use Controllers\CompteController;
use Controllers\EtatActController;

require_once('../autoloader.php');
$animation_controller = new AnimActController();
$compte_controller = new CompteController();
$etatact_controller = new EtatActController();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une activité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <!--    <script type="module" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../ajax_add_act.js"></script>

    <!--    <script src="' . SITE_URL . '/Services/globals_functions.js"></script>-->
</head>
<body class="body-middle-div">
<div class="middle-form-div">
    <h1 class="text-center grey-border white-title">Ajouter une activité</h1>
    <form method="post" action="../Controllers/add_anim_ajax.php" enctype="multipart/form-data" name="add-act-form" id="add-act-form" class="add-form">
        <div class="form-overflow-container">

            <!-- Champ du code de l'animation -->
            <p class="error-p" id="error-code-anim"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="add-code-anim">Animation</label>
                </div>
                <select class="form-control" id="add-code-anim" name="add-code-anim" required onchange="validateFields(this.id);">
                    <option value="" disabled selected>Selectionnez une d'animation</option>
                    <?php
                    foreach ($animation_controller->getAllCodeAnim() as $code_anim)
                    {
//                         if ($user['username'] == $resp_suivi)
//                             echo '<option selected="selected" value="'. $user["username"] .'">'. $user['username']. ' | ' . $user['email'] . ' | ' . $user['trigramm'] .'</option>';
//                         else
                        echo '<option value="'. $code_anim["CODEANIM"] .'">'. $code_anim['NOMANIM'].'</option>';
                    } ?>
                </select>
            </div>


            <!-- Champ du code de l'état de l'activité -->
            <p class="error-p" id="error-code-etat-act"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="add-code-etat-act">État de l'activité</label>
                </div>
                <select class="form-control" id="add-code-etat-act" name="add-code-etat-act" required onchange="validateFields(this.id);">
                    <option value="" disabled selected>Selectionnez un état pour l'activité</option>
                    <?php
                    foreach ($etatact_controller->getAllEtat() as $etat)
                    {
                        if ($etat["CODEETATACT"] === 'CA') {
                            continue;
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
                    <label class="input-group-text" for="add-resp-act">Responsable de l'activité</label>
                </div>
                <select class="form-control" id="add-resp-act" name="add-resp-act" required onchange="validateFields(this.id);">
                    <option value="" disabled selected>Selectionnez un Responsable pour l'activité</option>
                    <?php
                    foreach ($compte_controller->getAllUser() as $user)
                    {
                         if ($user['TYPEPROFIL'] == 0){
                             continue;
                         }
                         else
                            echo '<option value="'. $user["USER"] .'">'. $user["PRENOMCOMPTE"].' | '. $user["NOMCOMPTE"] .'</option>';
                    } ?>
                </select>
            </div>

            <!-- Champ de la date de l'activité -->
            <p class="error-p" id="error-date-act"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Date de l'activité</span>
                </div>
                <input type="date" class="form-control" placeholder="Saississez une date pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo date("Y-m-d", strtotime('tomorrow')); ?>" id="add-date-act" name="add-date-act" required onchange="isValidDateActivite(this.value)">
            </div>

            <!-- Champ de l'heure d'arrivé -->
            <p class="error-p" id="error-time-arrive"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Heure d'arrivé</span>
                </div>
                <input type="time" class="form-control" placeholder="Saississez une heure d'arrivé pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo date('H:i'); ?>" id="add-time-arrive" name="add-time-arrive" required onkeyup="validateFields('hour');">
            </div>

            <!-- Champ de l'heure de départ -->
            <p class="error-p" id="error-time-depart"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Heure de départ</span>
                </div>
                <input type="time" class="form-control" placeholder="Saississez une heure de départ pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo date('H:i'); ?>" id="add-time-depart" name="add-time-depart" required onkeyup="validateFields('hour');">
            </div>

            <!-- Champ de l'heure de fin -->
            <p class="error-p" id="error-time-fin"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Heure de fin</span>
                </div>
                <input type="time" class="form-control" placeholder="Saississez une heure de de fin pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo date('H:i'); ?>" id="add-time-fin" name="add-time-fin" required onkeyup="validateFields('hour');">
            </div>


            <!-- Champ du tarif de l'animation -->
            <p class="error-p" id="error-tarif"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Tarif de l'activité</span>
                </div>
                <input type="number" min="0" class="form-control" placeholder="Saississez un tarif pour l'activité" aria-label="Username" aria-describedby="basic-addon1" value='1' id="add-tarif-act" name="add-tarif-act" required onkeyup="validateFields(this.id);">
            </div>

        </div>
        <div class="flex-row-center middle-table-div-button-container">
            <button class="middle-table-div-button" type="reset" form="add-act-form" style="width: 33%;">Vider le formulaire</button>
            <button type="button" class="middle-table-div-button" form="add-act-form" id="submit-btn" onclick="confirmFormSubmission();" style="width: 33%">Ajouter</button>
            <button class="middle-table-div-button" onclick="window.history.go(-1); return false;" style="width: 33%">Retour</button>
        </div>
    </form>
</div>
<script>
    updateFieldsValidity();
</script>
</body>
</html>