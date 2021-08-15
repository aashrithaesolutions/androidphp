<?php
if(isset($_POST['orderno'])){
    $orderno=$_POST['orderno'];
}
if(isset($_POST['datasource'])){
    $datasource=$_POST['datasource'];
}
$response = array();
$success = getCash($orderno,$datasource);
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
function getCash($orderno,$datasource) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $array = array();
    $stmt = $pdo->prepare(" SELECT ORDM_CASH from ORDGMAST_T where ORDM_NO=$orderno ");
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