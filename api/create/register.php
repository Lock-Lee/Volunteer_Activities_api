<?php
    include_once "../connect.php";  // เรียกใช้ไฟล์ Connect
    if(isset($_GET["data"])){ // ตรวจสอบค่า isst ว่ามีค่าเข้ามาใหม
        $dataReceive = json_decode($_GET["data"],true);  // 
     if(isset($dataReceive["username"])  // ตรวจสอบว่า username เข้าาตัวนี้ใหม datareceive
     && isset($dataReceive["fname"])
     && isset($dataReceive["lname"])
     && isset($dataReceive["password"])
     && isset($dataReceive["phone"])){
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO member (username, fname, lname, password, phone, role)
                VALUES ('".$dataReceive["username"]."', 
                '".$dataReceive["fname"]."', 
                '".$dataReceive["lname"]."', 
                '".$dataReceive["password"]."', 
                '".$dataReceive["phone"]."', 
                'user')";
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