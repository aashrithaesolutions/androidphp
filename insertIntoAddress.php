<?php
if(isset($_POST['name'])){
    $name=$_POST['name'];
}
if(isset($_POST['code'])){
    $code=$_POST['code'];
}
if(isset($_POST['place'])){
    $place=$_POST['place'];
}
if(isset($_POST['phone'])){
    $phone=$_POST['phone'];
}
if(isset($_POST['addr1'])){
    $addr1=$_POST['addr1'];
}
if(isset($_POST['addr2'])){
    $addr2=$_POST['addr2'];
}
if(isset($_POST['gst'])){
    $gst=$_POST['gst'];
}
if(isset($_POST['adpan'])){
    $adpan=$_POST['adpan'];
}
if(isset($_POST['datasource1'])){
    $datasource1=$_POST['datasource1'];
}
if(isset($_POST['datasource2'])){
    $datasource2=$_POST['datasource2'];
}
$newpa = getNewPA($datasource1);
$response = array();

$success = updateIntoAddress($newpa,$code,$name,$place,$phone,$addr1,$addr2,$gst,$adpan,$datasource1,$datasource2);
if ($success) {
    $response['success'] = "1";
    $response['message'] = "inserted!";
    $response['details'] = $success;
    echo json_encode($response);
} else {
    $response['success'] = "0";
    $response['message'] = "not inserted";
    $response['details'] = $success;
    echo json_encode($response);
}
function updateIntoAddress($newpa,$code,$name,$place,$phone,$addr1,$addr2,$gst,$adpan,$datasource1,$datasource2){
    updateIntoAddress2($newpa,$code,$name,$place,$phone,$addr1,$addr2,$gst,$adpan,$datasource2);
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource1; Uid=; Pwd=;");
    //$query = " UPDATE ADDRESS_T SET PA_NAME='$name',PA_PLACE='$place',PA_TELE1='$phone',PA_ADDR1='$addr1',PA_ADDR2='$addr2',PA_TELE2='$gst',PA_TIN='$adpan',A_TYPE='P' where PA_CODE='$code'";
    $query=" INSERT INTO ADDRESS_T(PA_NO,PA_CODE,PA_NAME,PA_PLACE,PA_TELE1,PA_ADDR1,PA_ADDR2,PA_TELE2,PA_TIN,A_TYPE)
     VALUES ('$newpa','$code','$name','$place','$phone','$addr1','$addr2','$gst','$adpan','P') ";
    $stmt = $pdo->prepare($query);
    return $stmt->execute();
}
function updateIntoAddress2($newpa,$code,$name,$place,$phone,$addr1,$addr2,$gst,$adpan,$datasource2){
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource2; Uid=; Pwd=;");
    //$query = " UPDATE ADDRESS_T SET PA_NAME='$name',PA_PLACE='$place',PA_TELE1='$phone',PA_ADDR1='$addr1',PA_ADDR2='$addr2',PA_TELE2='$gst',PA_TIN='$adpan',A_TYPE='P' where PA_CODE='$code'";
    $query=" INSERT INTO ADDRESS_T(PA_NO,PA_CODE,PA_NAME,PA_PLACE,PA_TELE1,PA_ADDR1,PA_ADDR2,PA_TELE2,PA_TIN,A_TYPE)
     VALUES ('$newpa','$code','$name','$place','$phone','$addr1','$addr2','$gst','$adpan','P' ) ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $stmt=null;
}
function getNewPA($datasource1) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource1; Uid=; Pwd=;");
    $array = array();
    $stmt = $pdo->prepare("SELECT TOP 1 PA_NO from ADDRESS_T order by PA_NO desc ");
    $stmt->execute();
    $array = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $newpa=$array['PA_NO']+1;
    return $newpa;
}

/*

updateIntoAddress2($code,$name,$place,$phone,$addr1,$addr2,$gst,$adpan);
    $result=array();
    require "./connect.php";
    $sql=" UPDATE ADDRESS_T SET PA_NAME='$name',PA_PLACE='$place',PA_TELE1='$phone',PA_ADDR1='$addr1',PA_ADDR2='$addr2',PA_TELE2='$gst',PA_TIN='$adpan' where PA_CODE='$code' " ;
    $rs=odbc_exec($conn,$sql);
    $result=$rs[0];
    odbc_close($conn);
    return $result;


*/
?>