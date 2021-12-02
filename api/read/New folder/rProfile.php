<?php
include_once "../connect.php";
if(isset($_GET["data"])){ 
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM profile WHERE username='".$_GET["data"]."' ");
        $stmt->execute();
            $data["record"] = $stmt->rowCount() != 0 ? $stmt->fetchAll() : null; 
            $data["result"] = $stmt->rowCount() != 0 ? true : false;
            $data["message"] = $stmt->rowCount() != 0 ? 'พบ' : 'ไม่พบ';
    }
    catch(PDOException $e) {
        $data["record"] = null;
        $data["result"] = false;
        $data["message"] = "ข้อมูลซ้ำ";
    } 
    
}
   

echo json_encode($data); 
$conn = null; 
?>