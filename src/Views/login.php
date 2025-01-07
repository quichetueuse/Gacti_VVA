<?php

//check for error message
if (!array_key_exists('error', $_GET))
{
    $error_msg = '';
}
else {
    $error_msg = "Mot de passe ou nom d'utilisateur incorrect";
}

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Page de connexion</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../style.css">
        <script src="../../login.js"></script>
    <!--    <link rel="stylesheet" href="' . SITE_URL . '/accueil.css">-->
    <!--    <script src="' . SITE_URL . '/Services/globals_functions.js"></script>-->
    </head>
    <body class="body-middle-div">
<!--    <form method="post" action="--><?php //echo SITE_URL.'/';?><!--Login/login_connecdatation.php">-->
    <form method="post" action="../Controllers/LoginController.php">
        <div class="login-div">
            <h1 class="h3 mb-3 fw-normal white-bold grey-border login-title">Connectez-vous</h1>
            <div class="form-floating" style="margin-right: 15px; margin-left: 15px;">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="input-email">
                <label for="floatingInput">Adresse Email</label>
            </div>
            <div class="form-floating" style="margin-right: 15px; margin-left: 15px;">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="input-password">
                <label for="floatingPassword">Mot de passe</label>
            </div>
            <div class="form-check text-start my-3" style="margin-left: 15px;">
                <input class="form-check-input" type="checkbox" value="show-password" id="flexCheckDefault" onchange="view_password_v2('floatingPassword');">
                <label class="form-check-label" for="flexCheckDefault">
                    Afficher le mot de passe
                </label>
            </div>
            <p class="error-p"><?php echo $error_msg; ?></p>
            <div style="margin-left: 15px; margin-right: 15px;">
                <button class="btn btn-primary w-100 py-2" style="margin-bottom: 10px;" type="submit">Connexion</button>
                <button class="btn btn-primary w-100 py-2" style="margin-bottom: 10px;" onclick="document.location.href = 'new_animation2.php'" type="button">Continuer sans s'inscrire</button>
            </div>
        </div>
    </form>
    </body>
</html>