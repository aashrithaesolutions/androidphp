<?php
    $datasource='S:/Scheme/Scheme.Mdb';
    $Gname='Z';
    $Mno='4';
    $Instno='1';
    $Amount='1000';
    $Mode='CA';
    $Rate='4100';
    $Narration='';
    $Staff='SO';
    $newLastInsNo='2';

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
    $s1=saveReceipt1($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details);
    $s2=saveReceipt2($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details);
    $s3=saveReceipt3($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details);
    $s4=saveReceipt4($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details);
    if ($s1 && $s2 && $s3 && $s4) {
        $response['success'] = "1";
        $response['message'] = "inserted!";
        $response['Rno'] = $Rno;
        echo json_encode($response);
    } else {
        $response['success'] = "0";
        $response['message'] = "not inserted";
        echo "Q1 :".$s1,"\n";
        echo "Q2 :".$s2,"\n";
        echo "Q3 :".$s3,"\n";
        echo "Q4 :".$s4,"\n";
        echo json_encode($response);
    }
}

function saveReceipt1($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $stmt = $pdo->prepare(" INSERT INTO STAFFDET(S_ID,ST_ID,RNO,RDATE,GNAME,MNO,INSTNO,AMOUNT,MODE,RRDATE,GRATE,GOLDWT,DELSTATUS,RTIME,GST,SGST,CGST,RCVDA) 
    VALUES ('$S_ID','$staffcode','$Rno','$day','$Gname','$Mno','$Instno','$Amount','$Mode','$day','$Rate','$goldwt','N','$tim',0,0,0,'$Amount') ");
    return $stmt->execute();
}

function saveReceipt2($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");  
    $stmt = $pdo->prepare(" INSERT INTO GRECEIPTS(Rno,Rdate,Gname,Mno,Instno,Amount,Mode,rate,goldwt,Delstatus,rectime,dummy1,RGST,RSGST,RCGST,RRAMT,R_DUMMY) 
    VALUES ('$Rno','$day','$Gname','$Mno','$Instno','$Amount','$Mode','$Narration','$goldwt','N','$tim','sent from mobile',0,0,0,'$Amount','$Rate') ");
    return $stmt->execute();
}

function saveReceipt3($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $stmt = $pdo->prepare(" INSERT INTO RECEIPTS(Rno,Rdate,Gname,Mno,Instno,Amount,Mode,MDetails,Delstatus,RGST,RSGST,RCGST,RRAMT,R_DUMMY) 
    VALUES ('$Rno','$day','$Gname','$Mno','$Instno','$Amount','$Mode','$Narration','N',0,0,0,'$Amount','$Rate') ");
    return $stmt->execute();
}

function saveReceipt4($datasource,$Rno,$Gname,$Mno,$Instno,$Amount,$Mode,$Rate,$day,$Narration,$tim,$goldwt,$S_ID,$staffcode,$details) {
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
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