<?php
if(isset($_POST['datasource'])){
    $datasource=$_POST['datasource'];
}
if(isset($_POST['searchKey'])){
    $searchKey=$_POST['searchKey'];
}
$response = array();
$success = updateAddress($datasource,$searchKey);
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
function updateAddress($datasource,$searchKey) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $array = array();
    $stmt = $pdo->prepare(" SELECT PA_NO,PA_CODE,PA_NAME,PA_PLACE,PA_TELE1 from ADDRESS_T where PA_NAME LIKE '$searchKey%' OR PA_TELE1 LIKE '$searchKey%' ");
    $stmt->execute();
    $i=0;
    while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $array[$i]=$temp;
        $i++;
      }
    $stmt = null;
    return $array;
}
?>