<?php //root
include_once "../connect.php";
if(isset($_GET["data"])){
    $dataReceive = $_GET["data"];
    if($dataReceive == "root"){
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM kind ");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

        if($stmt->rowCount() > 0){
            $data["record"] = $stmt->fetchAll(); 
            $data["result"] = true;
            $data["message"] = "yes";
        }else{
            $data["record"] = null;
            $data["result"] = false;
            $data["message"] = "fall";
        }
    }
    catch(PDOException $e) {
      //  echo "Error: " . $e->getMessage();
        $data["record"] = null;
        $data["result"] = false;
        $data["message"] = $e->getMessage();
    } 
}else{
        $data["record"] = null;
        $data["result"] = false;
        $data["message"] = "not root";
    
    }
   // echo json_encode($data);
   /*
    
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM member "); // qurey
        $stmt->execute(); // �����ż�
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); //

        if($stmt->rowCount() > 0){ // ���ըӹǹ�� �ҡ���� 0 ���
            $data["record"] = $stmt->fetchAll(); // -> ���˹� ������� 仴֧��������
            $data["result"] = true;
            $data["message"] = "�����";
        }else{
            $data["record"] = null;
            $data["result"] = false;
            $data["message"] = "��������ʻ�ҹ���١";
        }
    }
    catch(PDOException $e) {
      //  echo "Error: " . $e->getMessage();
        $data["record"] = null;
        $data["result"] = false;
        $data["message"] = $e->getMessage();
    } 
    
}else{
        $data["record"] = null;
        $data["result"] = false;
        $data["message"] = "������Ѻ��Ҽ����";
    }
   */
}else{
    $data["record"] = null;
    $data["result"] = false;
    $data["message"] = "no data";

}
echo json_encode($data); // ��� ������� echo
$conn = null;      // INNER JOIN
// $data = [ {"name":} ] �ٻẺ JSON
// varialer is gobla
?>


