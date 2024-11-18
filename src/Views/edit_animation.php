<?php
session_start();

if (!array_key_exists('type_profil',$_SESSION)) {
    header('location: new_animation2.php');
}
if ($_SESSION['type_profil'] == '0') {
    header('location: new_animation2.php');
}

use Controllers\AnimActController;

require_once('../autoloader.php');
$animation_controller = new AnimActController();

//getting animation id
$code_anim = "code"; //$_GET['code_anim'];

//getting all animation's informations
$anim = $animation_controller->getAnimationByCodeAnim($code_anim);

//if array is empty (mean no animation with given id/code exists) //todo réactiver
if (empty($anim)) {
    header('location: new_animation2.php');
}



$code_anim = $anim['CODEANIM'];
$type_anim = $anim['CODETYPEANIM'];
$date_validite_anim = $anim['DATEVALIDITEANIM'];
$titre_anim = $anim['NOMANIM'];
$desc_anim = $anim['DESCRIPTANIM'];
$comment_anim = $anim['COMMENTANIM'];
$duree_anim = $anim['DUREEANIM'];
$tarif = $anim['TARIFANIM'];
$limite_age = $anim['LIMITEAGE'];
$nb_place = $anim['NBREPLACEANIM'];
$difficulte = $anim['DIFFICULTEANIM'];


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Éditer une animation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../ajax_edit_anim.js"></script>

    <!--    <script src="' . SITE_URL . '/Services/globals_functions.js"></script>-->
</head>
<body class="body-middle-div">
<div class="middle-form-div">
    <h1 class="text-center grey-border white-title">Éditer une animation</h1>
    <form method="post" action="../Controllers/add_anim_ajax.php" enctype="multipart/form-data" name="edit-anim-form" id="edit-anim-form" class="add-form">
        <div class="form-overflow-container">


                <input type="hidden" class="form-control" aria-label="Username" aria-describedby="basic-addon1" id="edit-num-anim" name="edit-num-anim" value="<?php echo $code_anim; ?>" required onchange="validate_field(this.id, this.value);"><!--onfocusout="checkActionNumber('<?php echo SITE_URL; ?>');">-->

                <input type="hidden" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $type_anim ?>" id="add-type-anim" name="add-type-anim" required onchange="isValidDatevalidite(this.value)">

<!--            <p class="error-p" id="error-code-anim"></p>-->
<!--            <div class="input-group mb-3">-->
<!--                <div class="input-group-prepend">-->
<!--                    <span class="input-group-text" id="basic-addon1">Code de l'animation</span>-->
<!--                </div>-->
<!--                <input type="hidden" class="form-control" aria-label="Username" aria-describedby="basic-addon1" id="edit-num-anim" name="edit-num-anim" required onchange="validate_field(this.id, this.value);">
            </div>-->
<!---->
<!--            <p class="error-p" id="error-code-type-anim"></p>-->
<!--            <div class="input-group mb-3">-->
<!--                <div class="input-group-prepend">-->
<!--                    <label class="input-group-text" for="add-type-anim">Type de l'animation</label>-->
<!--                </div>-->
<!--                <input type="hidden" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="--><?php //echo $type_anim ?><!--" id="add-type-anim" name="add-type-anim" required onchange="isValidDatevalidite(this.value)">-->
<!--            </div>-->

            <!-- Champ de la date de validité de l'animation -->
            <p class="error-p" id="error-date-validite"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Date de Validité de l'animation</span>
                </div>
                <input type="date" class="form-control" placeholder="Saississez une Date de validité pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $date_validite_anim ?>" id="edit-date-validite-anim" name="edit-date-validite-anim" required onchange="isValidDatevalidite(this.value)">
            </div>

            <!-- Champ du titre de l'animation -->
            <p class="error-p" id="error-titre"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Titre de l'animation</span>
                </div>
                <input type="text" class="form-control" placeholder="Saississez le Titre pour l'animation" aria-label="Username" aria-describedby="basic-addon1" id="edit-titre-anim" name="edit-titre-anim" value="<?php echo $titre_anim; ?>" required onkeyup="validate_field(this.id, this.value);"><!--onfocusout="checkActionNumber('<?php echo SITE_URL; ?>');">-->
            </div>


            <!-- Champ de la description de l'animation -->
            <p class="error-p" id="error-desc"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Description de l'animation</span>
                </div>
                <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea" style="height: auto;" placeholder="Saississez une description pour l'animation" id="edit-desc-anim" name="edit-desc-anim" onkeyup="validate_field(this.id, this.value);"><?php echo $desc_anim; ?></textarea>
                </div>
            </div>


            <!-- Champ du Commentaire de l'animation -->
            <p class="error-p" id="error-comment"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Commentaire de l'animation</span>
                </div>
                <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea" style="height: auto;" placeholder="Saississez un commentaire pour l'animation" id="edit-comment-anim" name="edit-comment-anim" onkeyup="validate_field(this.id, this.value);"><?php echo $comment_anim; ?></textarea>
                </div>
            </div>

            <!-- Champ de la durée de l'animation -->
            <p class="error-p" id="error-duree"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Durée de l'animation</span>
                </div>
                <input type="number" min="1" class="form-control" placeholder="Saississez une Durée pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value='<?php echo $duree_anim; ?>' id="edit-duree-anim" name="edit-duree-anim" required onkeyup="validate_field(this.id, this.value);">
            </div>

            <!-- Champ du tarif de l'animation -->
            <p class="error-p" id="error-tarif"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Tarif de l'animation</span>
                </div>
                <input type="number" min="0" class="form-control" placeholder="Saississez un tarif pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value='<?php echo $tarif; ?>' id="edit-tarif-anim" name="edit-tarif-anim" required onkeyup="validate_field(this.id, this.value);">
            </div>

            <!-- Champ de la limite d'age de l'animation -->
            <p class="error-p" id="error-age"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Limite d'age de l'animation</span>
                </div>
                <input type="number" min="4" max="100" class="form-control" placeholder="Saississez une Limite d'age pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value='<?php echo $limite_age; ?>' id="edit-limiteage-anim" name="edit-limiteage-anim" required onkeyup="validate_field(this.id, this.value);">
            </div>

            <!-- Champ du nombre de place de l'animation -->
            <p class="error-p" id="error-place"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Nombre de place  de l'animation</span>
                </div>
                <input type="number" min="1" max="50" class="form-control" placeholder="Saississez un nombre de place pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value='<?php echo $nb_place; ?>' id="edit-nbplace-anim" name="edit-nbplace-anim" required onkeyup="validate_field(this.id, this.value);">
            </div>

            <!-- Champ de la difficulté de l'animation -->
            <p class="error-p" id="error-diff"></p>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Difficulté de l'animation</span>
                </div>
                <input type="text" class="form-control" placeholder="Saississez une difficulté pour l'animation" aria-label="Username" aria-describedby="basic-addon1" id="edit-difficulte-anim" name="edit-difficulte-anim" value="<?php echo $difficulte; ?>" onkeyup="validate_field(this.id, this.value);"><!--onfocusout="checkActionNumber('<?php echo SITE_URL; ?>');">-->
            </div>
        </div>
        <div class="flex-row-center middle-table-div-button-container">
            <button class="middle-table-div-button" type="reset" form="edit-anim-form" style="width: 33%;">Vider le formulaire</button>
            <button type="button" class="middle-table-div-button" form="edit-anim-form" id="submit-btn" onclick="confirmFormSubmission();" style="width: 33%;">Éditer</button>
            <button class="middle-table-div-button" onclick="window.history.go(-1); return false;" style="width: 33%;">Retour</button>
        </div>
    </form>
</div>
</body>
<script>
    updateFieldsValidity();
</script>
</html>