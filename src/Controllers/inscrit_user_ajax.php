<?php

use Controllers\InscriptionController;

require_once('../autoloader.php');
if (session_status() === PHP_SESSION_DISABLED || session_status() === PHP_SESSION_NONE)
{
    session_start();
}
//si la clé 'user' éxiste dans l'array associatif de session
if (!array_key_exists('user', $_SESSION)) {
    return;
}
//si le user de la session est vide
if (empty($_SESSION['user'])) {
    return;
}
$user_id = $_SESSION['user'];
$act_id = $_GET['act_id'];
$date_act = $_GET['date_act'];
$inscription_controller = new InscriptionController();
$query_success = json_encode($inscription_controller->inscritUserToAct($user_id, $act_id, $date_act));
echo $query_success;