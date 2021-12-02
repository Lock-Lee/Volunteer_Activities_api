<?php
     include_once "../connect.php"; 
     
    if(isset( $_GET["data"])){
        $dataReceive = json_decode($_GET["data"],true);
             try
            {
                $sql = "UPDATE profile SET 
                study = '".$dataReceive["study"]."',
                sex = '".$dataReceive["sex"]."',
                facebook ='".$dataReceive["facebook"]."'
                WHERE username = '".$dataReceive["username"]."'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
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
  
        echo json_encode($data);
    $conn = null; 

?>