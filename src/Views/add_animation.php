<?php
use Controllers\AnimActController;
require_once('../autoloader.php');

session_start();
if (!array_key_exists('type_profil',$_SESSION)) {
    header('location: main_window.php');
}
if ($_SESSION['type_profil'] == '0') {
    header('location: main_window.php');
}

$animation_controller = new AnimActController();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une animation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../ajax_add_anim.js"></script>

</head>
<body class="body-middle-div">
<div class="middle-form-div">
    <h1 class="text-center grey-border white-title">Ajouter une animation</h1>
    <form method="post" action="../Controllers/add_anim_ajax.php" enctype="multipart/form-data" name="add-anim-form" id="add-anim-form" class="add-form">
    <div class="form-overflow-container">

        <!-- Champ du code de l'animation -->
        <p class="error-p" id="error-code-anim"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Code de l'animation</span>
            </div>
            <input type="text" class="form-control" placeholder="Saississez un Code pour l'amination" aria-label="Username" aria-describedby="basic-addon1" id="add-num-anim" name="add-num-anim" required onkeyup="validate_field(this.id, this.value);"><!--onfocusout="checkActionNumber('<?php echo SITE_URL; ?>');">-->
        </div>

        <!-- Champ du type de l'animation -->
        <p class="error-p" id="error-code-type-anim"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="add-type-anim">Type de l'animation</label>
            </div>
            <select class="form-control" id="add-type-anim" name="add-type-anim" required onchange="validate_field(this.id, this.value);">
                <option value="" disabled selected>Selectionnez un type d'animation</option>
                <?php
                foreach ($animation_controller->getAllTypeAnim() as $type_anim)
                {
                    echo '<option value="'. $type_anim["CODETYPEANIM"] .'">'. $type_anim['NOMTYPEANIM'].'</option>';
                } ?>
            </select>
        </div>

        <!-- Champ de la date de validité de l'animation -->
        <p class="error-p" id="error-date-validite"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Date de Validité de l'animation</span>
            </div>
            <input type="date" class="form-control" placeholder="Saississez une Date de validité pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo date('Y-m-d'); ?>" id="add-date-validite-anim" name="add-date-validite-anim" required onchange="isValidDatevalidite(this.value)">
        </div>

        <!-- Champ du titre de l'animation -->
        <p class="error-p" id="error-titre"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Titre de l'animation</span>
            </div>
            <input type="text" class="form-control" placeholder="Saississez le Titre pour l'animation" aria-label="Username" aria-describedby="basic-addon1" id="add-titre-anim" name="add-titre-anim" required onkeyup="validate_field(this.id, this.value);"><!--onfocusout="checkActionNumber('<?php echo SITE_URL; ?>');">-->
        </div>


        <!-- Description input for animation -->
        <p class="error-p" id="error-desc"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Description de l'animation</span>
            </div>
            <div class="input-group">
                <textarea class="form-control" aria-label="With textarea" style="height: auto;" placeholder="Saississez une description pour l'animation" id="add-desc-anim" name="add-desc-anim" onkeyup="validate_field(this.id, this.value);"></textarea>
            </div>
        </div>

        <!-- Champ du Commentaire de l'animation -->
        <p class="error-p" id="error-comment"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Commentaire de l'animation</span>
            </div>
            <div class="input-group">
                <textarea class="form-control" aria-label="With textarea" style="height: auto;" placeholder="Saississez un commentaire pour l'animation" id="add-comment-anim" name="add-comment-anim" onkeyup="validate_field(this.id, this.value);"></textarea>
            </div>
        </div>

        <!-- Champ de la durée de l'animation -->
        <p class="error-p" id="error-duree"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Durée de l'animation</span>
            </div>
            <input type="number" min="1" class="form-control" placeholder="Saississez une Durée pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value='1' id="add-duree-anim" name="add-duree-anim" required onkeyup="validate_field(this.id, this.value);">
        </div>

        <!-- Champ du tarif de l'animation -->
        <p class="error-p" id="error-tarif"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Tarif de l'animation</span>
            </div>
            <input type="number" min="0" class="form-control" placeholder="Saississez un tarif pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value='1' id="add-tarif-anim" name="add-tarif-anim" required onkeyup="validate_field(this.id, this.value);">
        </div>

        <!-- Champ de la limite d'age de l'animation -->
        <p class="error-p" id="error-age"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Limite d'age de l'animation</span>
            </div>
            <input type="number" min="4" max="100" class="form-control" placeholder="Saississez une Limite d'age pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value='4' id="add-limiteage-anim" name="add-limiteage-anim" required onkeyup="validate_field(this.id, this.value);">
        </div>

        <!-- Champ du nombre de place de l'animation -->
        <p class="error-p" id="error-place"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Nombre de place  de l'animation</span>
            </div>
            <input type="number" min="1" max="50" class="form-control" placeholder="Saississez un nombre de place pour l'animation" aria-label="Username" aria-describedby="basic-addon1" value='1' id="add-nbplace-anim" name="add-nbplace-anim" required onkeyup="validate_field(this.id, this.value);">
        </div>

        <!-- Champ de la difficulté de l'animation -->
        <p class="error-p" id="error-diff"></p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Difficulté de l'animation</span>
            </div>
            <input type="text" class="form-control" placeholder="Saississez une difficulté pour l'animation" aria-label="Username" aria-describedby="basic-addon1" id="add-difficulte-anim" name="add-difficulte-anim" onkeyup="validate_field(this.id, this.value);"><!--onfocusout="checkActionNumber('<?php echo SITE_URL; ?>');">-->
        </div>


    </div>
        <div class="flex-row-center middle-table-div-button-container">
            <button class="middle-table-div-button" onclick="clearForm()" form="add-anim-form" style="width: 33%;">Vider le formulaire</button>
            <button type="button" class="middle-table-div-button" form="add-anim-form" id="submit-btn" onclick="confirmFormSubmission();" style="width: 33%;">Ajouter</button>
            <button class="middle-table-div-button" onclick="window.history.go(-1); return false;" style="width: 33%;">Retour</button>
        </div>
    </form>
</div>
</body>
<script>
    updateFieldsValidity();
</script>
</html>