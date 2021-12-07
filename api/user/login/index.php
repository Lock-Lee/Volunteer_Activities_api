<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");



require_once('../../../models/UserModel.php');  
$user_model = new UserModel; 

 
// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);
$user_username = '';
$user_password = '';
$data = [];
if(isset($obj["user_username"]) && isset($obj["user_password"])){
    $user_username = $obj["user_username"];
    $user_password = $obj["user_password"];
    $data = $user_model->getUserLogin($user_username,$user_password);
   

} 
if($data['data']['user_code'] == null){
    $data =false;
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);

