<?php
 include_once "../connect.php";
if(isset($_GET["data"])){
    $dataRe = ($_GET["data"]);
    if($dataRe == "root"){
        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn ->prepare(
        "SELECT * FROM member  WHERE username LIKE '%".$_GET["search"]."%' 
        OR sname LIKE '%".$_GET["search"]."%' 
        OR lname LIKE '%".$_GET["search"]."%' 
        OR phone LIKE '%".$_GET["search"]."%' 
        OR role  LIKE '%".$_GET["search"]."%' 
        ORDER BY role ASC"); 
               $stmt->execute();
               $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
            if($stmt->rowCount()>0){
                $data["record"]=$stmt->fetchAll();
                $data["result"]=true;
                $data["message"]="ok";
            }else{
                $data["record"]=null;
                $data["result"]=false;
                $data["message"]="not ok";
            }
        }
        catch(PDOException $e) {
                $data["record"]=null;
                $data["result"]=false;
                $data["message"]= $e->getMessage();
        }
    }else{
        $data["record"]=null;
        $data["result"]=false;
        $data["message"]="you not allow";
    }
}else{
    $data["record"]=null;
    $data["result"]=false;
    $data["message"]="No Data";
}
echo json_encode($data);
$conn = null;
?>