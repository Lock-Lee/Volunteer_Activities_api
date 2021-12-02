<?php
include_once "../connect.php";
if(isset($_GET["data"])){ 
    $dataReceive = json_decode($_GET["data"],true);
    if(isset($dataReceive["username"])&& isset($dataReceive["password"])){
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM member WHERE username= '".$dataReceive["username"]."' AND password = '".$dataReceive["password"]."'");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        if($stmt->rowCount() > 0){
            $data["record"] = $stmt->fetchAll(); 
            $data["result"] = true;
            $data["message"] = "ok";
        }else{
            $data["record"] = null;
            $data["result"] = false;
            $data["message"] = "Not ok";
        }
    }
    catch(PDOException $e) {
        $data["record"] = null;
        $data["result"] = false;
        $data["message"] = $e->getMessage();
    } 
    
}else{
        $data["record"] = null;
        $data["result"] = false;
        $data["message"] = "not enter user password";
    }
   
}else{
    $data["record"] = null;
    $data["result"] = false;
    $data["message"] = "No data";

}
echo json_encode($data); 
$conn = null; 
?>