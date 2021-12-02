<?php
    include_once "../connect.php";
    if(isset($_GET["no"])){
        
        try {
            $sql = "DELETE FROM classroom WHERE class_id='".$_GET["no"]."' ";
            $conn->exec($sql);
            $data["record"] = true;
            $data["result"] = true;
            $data["message"] = "Success";
        }catch(PDOException $e){
            $data["record"] = null;
            $data["result"] = false;
            $data["message"] = $e->getMessage();
        }           
}else{
    $data["record"] = null;
    $data["result"] = false;
    $data["message"] = "Word not correct!";
}
echo json_encode($data);
$conn = null;
?>