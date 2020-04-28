<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../config/Database.php");
include_once("../../models/User.php");

$database = new Database();
$db = $database->connect();

$user = new User($db);

// get the requested id from the url
$user->id = isset($_GET['id']) ? $_GET['id'] : die();

$user->readOne();

echo json_encode($user);