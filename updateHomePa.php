<?php
if(isset($_POST['datasource'])){
    $datasource=$_POST['datasource'];
}
if(isset($_POST['pa_code'])){
    $searchKey=$_POST['pa_code'];
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
    $stmt = $pdo->prepare(" SELECT PA_NO from ADDRESS_T where PA_CODE LIKE '$searchKey' ");
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