<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow_Methods: PUT");
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
$user->id = $data->id;

if ($user->update()) {
    echo json_encode(
        array("message" => "user updated")
    );
} else {
    echo json_encode(
        array("message" => "Could not update user.")
    );
}