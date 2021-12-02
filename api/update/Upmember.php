<?php
     include_once "../connect.php";  // ???????????? Connect
    if(isset($_GET["role"])){
        $dataRoot = $_GET["role"];
            if($dataRoot == "root"){
                 $dataReceive = json_decode($_GET["data"],true);
                 if(!empty($dataReceive["class_id"])  // ตรวจสอบว่า username เข้าาตัวนี้ใหม datareceive
                 && isset($dataReceive["class_name"])
                 && isset($dataReceive["keeper"])
                 && isset($dataReceive["amount"])
                 && isset($dataReceive["kind_id"]){
            
             try
            {
                $sql = "UPDATE classroom SET 
                class_name = '".$dataReceive["class_name"]."',
                keeper = '".$dataReceive["keeper"]."',
                amount = '".$dataReceive["amount"]."',
                kind_id ='".$dataReceive["kind_id"]."'
                WHERE class_id = '".$dataReceive["class_id"]."'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                // echo $stmt->rowCount() . " records UPDATED successfully";
                $data["record"] = true;
                $data["result"] = true;
                $data["message"] = "แก้ไขข้อมูลสำเร็จ";

                }catch(PDOException $e){
                    $data["record"] = null;
                    $data["result"] = false;
                    $data["message"] = $e->getMessage();
        }
            }else{
                $data["record"] = null;
                $data["result"] = false;
                $data["message"] = "ส่งข้อมูลไม่ครบ";
            } 
         } else{
             $data["record"] = null;
            $data["result"] = false;
            $data["message"] ="ส่งข้อมูลไม่ครบ";
         }
    } else{
        $data["record"] = null;
        $data["result"] = false;
        $data["message"] ="ส่งข้อมูลไม่ครบ";
        
        }
        echo json_encode($data);
    $conn = null; // ยกเลิกการเชื่อมต่อกับ เซิฟเวอร์

?>