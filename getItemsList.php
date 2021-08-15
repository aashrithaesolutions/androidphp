<?php
if(isset($_POST['type'])){
    $ty=$_POST['type'];
}
if(isset($_POST['datasource'])){
    $datasource=$_POST['datasource'];
}
$response = array();
$success = getItemDetails($ty,$datasource);
if (!empty($success)) {
    $response['success'] = "1";
    $response['message'] = "found!";
    $response['details'] = $success;
    echo json_encode($response);
} else {
    $response['success'] = "0";
    $response['message'] = "not found. Please try again!";
    $response['details'] = $success;
    echo json_encode($response);
}
function getItemDetails($ty,$datasource) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $array = array();
    if($ty==1){
        $stmt = $pdo->prepare(" SELECT ITEM_NO,ITEM_CODE,ITEM_NAME from GITEMMASTER_T ");
    }else{
        $stmt = $pdo->prepare(" SELECT ITEM_NO,ITEM_CODE,ITEM_NAME from SITEMMASTER_T ");  
    }
    $stmt->execute();
    $i=0;
    while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $array[$i]=$temp;
        $i++;
      }
    $stmt = null;
    return $array;
}


/*

$result=array();
    require "./connect.php";
    if($ty==1){
        $sql="SELECT ITEM_CODE,ITEM_NAME from GITEMMASTER_T" ;
    }else{
        $sql="SELECT ITEM_CODE,ITEM_NAME from SITEMMASTER_T" ;
    }
    $rs=odbc_exec($conn,$sql);
    $i=0;
    while($row=odbc_fetch_array($rs)){
        $result[$i]=$row;
        $i++;
    }
    odbc_close($conn);
    return $result;

    */
?>