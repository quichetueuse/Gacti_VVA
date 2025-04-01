<?php
require_once('../autoloader.php');
use Controllers\FunctionController;
use Controllers\InscriptionController;

session_start();

//if user is not connected
if (!array_key_exists('type_profil',$_SESSION)) {
    header('location: main_window.php');
}

//if user is not an encadrant
if ($_SESSION['type_profil'] == '0') {
    header('location: main_window.php');
}

$function_controller = new FunctionController();
$inscription_controller = new InscriptionController();

$code_act = $_GET['act_id'];
$date_act = $_GET['date_act'];

//echo '<h1>' . $code_act . ' | '. $date_act .'</h1>';



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des inscrits </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php echo $function_controller->generateHeaderDiv(); ?>
<!--<div style="height: 15rem; width: 20rem; background-color: grey; border: 1px solid black; border-radius: 10px;">-->
<!--    haha-->
<!--</div>-->
    <div class="return-control-div">
        <button class="middle-table-div-button" onclick="window.history.go(-1); return false;">Retour</button>
    </div>
    <div class="user-summary-card-container">
<!--        <div class="user-summary-card">-->
<!--            <h3 class="card-title text-center grey-border bold" style="border-bottom: 1px solid white; padding-bottom: 1rem;">Mr Nom Prénom</h3>-->
<!--            <p style="padding-top: 1rem;"><strong>En vacances du YYYY:MM:DD au YYYY:MM:DD</strong></p>-->
<!--            <p><strong>Date d'inscription:</strong> YYYY:MM:DD </p>-->
<!--            <p><strong>Code de l'inscription:</strong> int </p>-->
<!--            <p><strong>Inscrit à <span style="font-size: 15pt; color: palegreen" class=" grey-border">&nbsp5&nbsp</span> activités au total</strong></p>-->
<!--        </div>-->
        <?php echo $function_controller->generateInscritUserCard($code_act, $date_act); ?>
    </div>
</body>
<script>
    function showConfirmDisconnect(){
        Swal.fire({
            title: "Voulez-vous vraiment vous déconnecter ?",
            text: "Il faudra se reconnecter",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Annuler",
            confirmButtonText: "Oui, je me déconnecte!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = '../Controllers/disconnect.php'
            }
        });
    }
</script>
</html>