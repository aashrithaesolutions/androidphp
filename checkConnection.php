<?php
if(isset($_POST['datasource1']) && isset($_POST['datasource2'])){
    $datasource1=$_POST['datasource1'];
    $datasource2=$_POST['datasource2'];
    $res1=checkConnect($datasource1);
    $res2=checkConnect($datasource2);
    $result=array();
    if($res1==$res2 && $res1==true){
        $result['success']='1';
        $result['message']='Data sources valid';
        echo json_encode($result);
    }else{
        $result['success']='0';
        $result['message']='Data sources Invalid';
        echo json_encode($result);
    }
}
function checkConnect($datasource){
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
   if($pdo){
      return true;
   }else{
      return false;
   }
}
?>
