<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../config/Database.php");
include_once("../../models/User.php");

$database = new Database();
$db = $database->connect();

$user = new User($db);

$result = $user->read();
$num = $result->rowCount();

if ($num > 0) {
    $userAry = array();
    $userAry = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($userAry);
} else {
    echo json_encode (array ("message" => "no users found."));
}