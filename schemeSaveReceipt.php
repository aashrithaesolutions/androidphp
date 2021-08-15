<?php
if(isset($_POST['datasource'])){
    $datasource=$_POST['datasource'];
}
if(isset($_POST['Gname'])){
    $Gname=$_POST['Gname'];
}
if(isset($_POST['Mno'])){
    $Mno=$_POST['Mno'];
}
if(isset($_POST['Instno'])){
    $Instno=$_POST['Instno'];
}
if(isset($_POST['Amount'])){
    $Amount=$_POST['Amount'];
}
if(isset($_POST['Mode'])){
    $Mode=$_POST['Mode'];
}
if(isset($_POST['Rate'])){
    $Rate=$_POST['Rate'];
}
if(isset($_POST['Narration'])){
    $Narration=$_POST['Narration'];
}
if(isset($_POST['Staff'])){
    $Staff=$_POST['Staff'];
}
if(isset($_POST['newLastInsNo'])){
    $newLastInsNo=$_POST['newLastInsNo'];
}
$staffcode=getStaffCode($datasource,$Staff);
if($staffcode==-1){
    $response['success'] = "0";
    $response['message'] = "Check staff code again";
    echo json_encode($response);
}else{
    $num=$Amount/$Rate;
    $goldwt = number_format($num, 3);
    date_default_timezone_set("Asia/Calcutta");
    $tim=date("H:i:s", time()); 
    $day=date("d/m/Y");
    $Rno = getRno($datasource);
    $S_ID=getSid($datasource);
    $response = array();
    $details=array(
        'newLastInsNo' => $newLastInsNo,
        'Gname' => $Gname,
        'Mno' => $Mno
    );
    $success = saveReceipt($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details);
    if ($success) {
        $response['success'] = "1";
        $response['message'] = "inserted!";
        $response['Rno'] = $Rno;
        echo json_encode($response);
    } else {
        $response['success'] = "0";
        $response['message'] = "not inserted";
        echo json_encode($response);
    }
}

function saveReceipt($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    
    $stmt = $pdo->prepare(" INSERT INTO STAFFDET(S_ID,ST_ID,RNO,RDATE,GNAME,MNO,INSTNO,AMOUNT,MODE,RRDATE,GRATE,GOLDWT,DELSTATUS,RTIME,GST,SGST,CGST,RCVDA) 
    VALUES ('$S_ID','$staffcode','$Rno','$day','$Gname','$Mno','$Instno','$Amount','$Mode','$day','$Rate','$goldwt','N','$tim',0,0,0,'$Amount') ");
    $stmt->execute();
    $stmt=null;

    $stmt = $pdo->prepare(" INSERT INTO GRECEIPTS(Rno,Rdate,Gname,Mno,Instno,Amount,Mode,rate,goldwt,Delstatus,rectime,dummy1,RGST,RSGST,RCGST,RRAMT,R_DUMMY) 
    VALUES ('$Rno','$day','$Gname','$Mno','$Instno','$Amount','$Mode','$Narration','$goldwt','N','$tim','sent from mobile',0,0,0,'$Amount','$Rate') ");
    $stmt->execute();
    $stmt=null;

    $stmt = $pdo->prepare(" INSERT INTO RECEIPTS(Rno,Rdate,Gname,Mno,Instno,Amount,Mode,MDetails,Delstatus,RGST,RSGST,RCGST,RRAMT,R_DUMMY) 
    VALUES ('$Rno','$day','$Gname','$Mno','$Instno','$Amount','$Mode','$Narration','N',0,0,0,'$Amount','$Rate') ");
    $stmt->execute();
    $stmt=null;

    $stmt = $pdo->prepare(" UPDATE MEMBERS SET LastIno=:newLastInsNo where GName=:Gname and MNo=:Mno ");
    return $stmt->execute($details);
}

function getRno($datasource) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $array = array();
    $stmt = $pdo->prepare("SELECT TOP 1 Rno from Receipts order by Rno desc");
    $stmt->execute();
    $array = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $rno=$array['Rno']+1;
    return $rno;
}

function getSid($datasource) {
  $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
  $array = array();
  $stmt = $pdo->prepare("SELECT TOP 1 S_ID from STAFFDET order by S_ID desc");
  $stmt->execute();
  $array = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt = null;
  $sid=$array['S_ID']+1;
  return $sid;
}
function getStaffCode($datasource,$Staff) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
        $array = array();
        $stmt = $pdo->prepare("SELECT ST_ID from STAFF WHERE ST_CODE='$Staff' ");
        $stmt->execute();
        $array = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        $stid=$array['ST_ID'];
        if($stid==''){
            return -1;
        }else{
            return $stid;
        }
      }
?>