<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require_once("../../src/token.php");

session_start();
require_once('../../models/UserModel.php');  
$user_model = new UserModel; 
 
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$response_data = [];
if ($request['action'] == "getUserBy") {
    $users = $user_model->getUserBy($request);
    $response_data['pageSize'] =(string)$request['params']['pagination']['pageSize'];
    $response_data['total'] = $users['total'];
    unset($users['total']); 
    $response_data['data'] = $users;    
    $response_data['require'] = true;
} else if ($request['action'] == "getUserByCode") {

    if (isset($request['user_code'])) {
        $user_code = $request['user_code'];
        $user = $user_model->getUserByCode($user_code);
        if ($user) {
            $response_data['data'] = $user;
            $response_data['require'] = true;
        } else {
            $response_data['data'] = null;
            $response_data['require'] = false;
        }
    } else {
        $response_data['require'] = false;
    }
} else if ($request['action'] == "getUserMaxCode") {

    $code = $request['code'];
    $users = $user_model->getUserMaxCode($code);
    $response_data['data'] = $users;
    $response_data['require'] = true;
} else if ($request['action'] == "getUserByPosition") {

    $code = $request['code'];
    $users = $user_model->getUserByPosition($code);
    $response_data['data'] = $users;
    $response_data['require'] = true;
} else {
    $response_data['response_data'] = "asdas";
    $response_data['require'] = false;
}






echo json_encode($response_data);
