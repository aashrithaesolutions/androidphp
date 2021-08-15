<?php
if(isset($_POST['tagcode'])){
    $code=$_POST['tagcode'];
}
if(isset($_POST['type'])){
    $ty=$_POST['type'];
}
if(isset($_POST['datasource'])){
    $datasource=$_POST['datasource'];
}
$response = array();
$success = getItemRate($code,$ty,$datasource);
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
function getItemRate($code,$ty,$datasource) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $array = array();
    if($ty==1){
        $stmt = $pdo->prepare(" SELECT top 1 IIF(gi.ITEM_PURITY=22,R_G22BR,IIF(gi.ITEM_PURITY=21,R_G21BR,IIF(gi.ITEM_PURITY=20,R_G20BR,IIF(gi.ITEM_PURITY=18,R_G18BR,'0')))) as RATE from GITEMMASTER_T gi,RATE_T where gi.ITEM_CODE='$code' order by R_DATE desc ");
    }else{
        $stmt = $pdo->prepare(" SELECT top 1 R_SBR as RATE from SITEMMASTER_T gi,RATE_T where gi.ITEM_CODE='$code' order by R_DATE desc ");
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
?>