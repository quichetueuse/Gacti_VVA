<?php
use Controllers\AnimActController;
use Controllers\FunctionController;

require_once('../autoloader.php');
$animation_controller = new AnimActController();
$function_controller = new FunctionController();
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../ajax_main_page.js"></script>
    <!--    <script src="' . SITE_URL . '/Services/globals_functions.js"></script>-->
</head>
<body>

<?php
echo $function_controller->generateHeaderDiv();
echo $function_controller->generateAnimsControlDiv();
?>


<div class="act-card-container" id="act-card-container" style="border-top: 5px solid #fff">
</div>

<script>
    showActivitiesByAnim('all');
</script>
</body>
</html>