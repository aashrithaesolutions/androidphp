<?php
if(isset($_POST['groupId'])){
    $groupId=$_POST['groupId'];
}
if(isset($_POST['datasource'])){
    $datasource=$_POST['datasource'];
}
$details = array(
    'groupId' => $groupId
);
$response = array();
$success = getSchemeDetail($details,$datasource);
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
function getSchemeDetail($details,$datasource) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $array = array();
    $stmt = $pdo->prepare(" SELECT DISTINCT TOP 1 m.MName,m.Phone,m.LastIno,m.InsAmt,r.R_G22BR,r.R_date from RATE_T r,Members m where  
    m.Gmnname=:groupId order by r.R_date desc ");
    $stmt->execute($details);
    $i=0;
    while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $array[$i]=$temp;
        $i++;
      }
    $stmt = null;
    return $array;
}

?>