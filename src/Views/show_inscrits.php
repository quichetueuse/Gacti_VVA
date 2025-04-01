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