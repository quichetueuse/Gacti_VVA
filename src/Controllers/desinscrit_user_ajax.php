<?php

use Controllers\InscriptionController;

require_once('../autoloader.php');
if (session_status() === PHP_SESSION_DISABLED || session_status() === PHP_SESSION_NONE)
{
    session_start();
}

//if user session index don't exist
if (!array_key_exists('user', $_SESSION)) {
    return;
}
if (empty($_SESSION['user'])) {
    return;
}
$user_id = $_SESSION['user'];
$act_id = $_GET['act_id'];
$date_act = $_GET['date_act'];
$inscription_controller = new InscriptionController();
// encode result array
$query_success = json_encode($inscription_controller->desincritUserToAct($user_id, $act_id, $date_act));
echo $query_success;