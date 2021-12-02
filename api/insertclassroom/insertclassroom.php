<?php
    include_once "../connect.php";  // เรียกใช้ไฟล์ Connect
    if(isset($_GET["data"])){ // ตรวจสอบค่า isst ว่ามีค่าเข้ามาใหม
        $dataReceive = json_decode($_GET["data"],true);  // 
     if(isset($dataReceive["class_id"])  // ตรวจสอบว่า username เข้าาตัวนี้ใหม datareceive
     && isset($dataReceive["class_name"])
     && isset($dataReceive["keeper"])
     && isset($dataReceive["amount"])
     && isset($dataReceive["kind_id"]))
     && isset($dataReceive["build_id"]))
     && isset($dataReceive["code"]))
     {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO classroom (class_id, class_name, keeper, amount, kind_id,build_id,code)
                VALUES (
                '".$dataReceive["class_id"]."', 
                '".$dataReceive["class_name"]."', 
                '".$dataReceive["keeper"]."', 
                '".$dataReceive["amount"]."', 
                '".$dataReceive["kind_id"]."', 
                '".$dataReceive["build_id"]."', 
                '".$dataReceive["code"]."', 
                
                )";
                $conn->exec($sql);
                $data["record"] = $dataReceive;
                $data["result"] = true;
                $data["message"] = "สำเร็จ";
    }
    catch(PDOException $e) {
     echo "Error: " . $e->getMessage(); // ข้อความ นี้ ปริ้น error
     $data["record"] = null;
     $data["result"] = false;
     $data["message"] = "ผิดพลาด";
    }
}else{
    $data["record"] = null;
    $data["result"] = false;
    $data["message"] = "ข้อมูลไม่ครบบ";
}
}else{
    $data["record"] = null;
    $data["result"] = false;
    $data["message"] = "ยังไม่รับค่าา";
}

    echo json_encode($data); // echo เหมือน prinf เข้ารหัสแล้วถอดออกมา
    $conn = null;
?>