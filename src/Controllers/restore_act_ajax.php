<?php
use Controllers\AnimActController;
require_once('../autoloader.php');

$act_id = $_GET['act_id'];
$date_act = $_GET['date_act'];
$animation_controller = new AnimActController();
// encode result array
$query_success = json_encode($animation_controller->restoreActivite($act_id, $date_act));
echo $query_success;