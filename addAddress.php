<?php
$response=array();
if(isset($_POST['name'])){
    $name=$_POST['name'];
}
if(isset($_POST['datasource1'])){
    $datasource1=$_POST['datasource1'];
}
if(isset($_POST['datasource2'])){
    $datasource2=$_POST['datasource2'];
}
$namelength=strlen($name);
if($namelength<=3){
    $code=strtoupper($name);
}else{
    $code=substr($name,0,3);
    $code=strtoupper($code);
}
$i=1;
$success=0;
$old=$code;
find($code,$datasource1);
function find($code,$datasource1){
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource1; Uid=; Pwd=;");
    $array = array();
    $temp=$code.'[0-9]'.'%';
    $stmt = $pdo->prepare("SELECT PA_CODE from ADDRESS_T where PA_CODE LIKE '$temp' ");
    $stmt->execute();
    $i=0;
    $t='';
    while ($temp = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $array[$i]=$temp;
        $t=$temp['PA_CODE'];
        $i++;
      }
    if($t==''){
        $response['success'] = "1";
        $response['message'] = "available";
        $response['code'] = $code.++$i;
        echo json_encode($response);
    }else{
        $len=strlen($code);
        $sub=substr($t,$len);
        $sub++;
        $t=$code.$sub;
        $response['success'] = "1";
        $response['message'] = "available";
        $response['code'] = $t;
        echo json_encode($response);
    }
    $stmt = null;
}
/*
do{
    $code=$code.$i;
    $okay=findcode($code,$datasource1);
    if($okay==true){
        $success=1;
        $response['success'] = "1";
        $response['message'] = "available";
        $response['code'] = $code;
        echo json_encode($response);
    }else{
        $code=$old;
        $i++;
    }
}while($success==0);
*/
/*
function findcode($code,$datasource1){
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource1; Uid=; Pwd=;");
    $array = array();
    $temp=substr($code,0,-1);
    $stmt = $pdo->prepare("SELECT PA_CODE from (SELECT PA_CODE from ADDRESS_T where PA_CODE LIKE '$temp%') where PA_CODE='$code' ");
    $stmt->execute();
    $array = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $newpacode=$array['PA_CODE'];
    if($newpacode){
        return false;
    }else{
        return true;
    }
}
*/
?>