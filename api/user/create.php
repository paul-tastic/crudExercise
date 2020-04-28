<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow_Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, Access-Control-Allow_Methods, X-Requested-With");

include_once("../../config/Database.php");
include_once("../../models/User.php");

$database = new Database();
$db = $database->connect();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->username = $data->username;
$user->password = $data->password;
$user->first_name = $data->first_name;
$user->last_name = $data->last_name;

if ($user->create()) {
    echo json_encode(
        array("message" => "user successfully created")
    );
} else {
    echo json_encode(
        array("message" => "Could not create user.")
    );
}