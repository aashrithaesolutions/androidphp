<?php
if(isset($_POST['datasource'])){
    $datasource=$_POST['datasource'];
}
$response = array();
$success = getRegPass($datasource);
if (!empty($success)) {
    $response['success'] = "1";
    $response['message'] = "found!";
    $response['details'] = $success;
    echo json_encode($response);
} else {
    $response['success'] = "0";
    $response['message'] = "Not found. Please try again!";
    $response['details'] = $success;
    echo json_encode($response);
}
function getRegPass($datasource) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $array = array();
    $stmt = $pdo->prepare("SELECT USER_BIOMETRICDEVICE4 from UPASSWORD_T where USERNAME='ADMIN'");
    $stmt->execute();
    $array = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    return $array;
}
?>