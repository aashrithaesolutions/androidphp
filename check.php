
<?php
$datasource='1:/916/Temp.Mdb';


    $type='1';


    $invoiceJsonArray=' [{"TRANS_SLNO":1,"TRANS_ITEMNO":"92","TRANS_RATE":"4380.00","TRANS_QTY":"1","TRANS_GROSSWT":"45.140","TRANS_LESSWT":"0.838","TRANS_NETWT":"44.302","TRANS_WTYPE":"Piece","TRANS_WRATE":"8.860","TRANS_WASTAGE":"8.860","TRANS_TOTWT":"53.162","TRANS_GOLDVAL":"232849.56","TRANS_MCTYPE":"Piece","TRANS_MCRATE":"26500.00","TRANS_MC":"26500.00","TRANS_OCHA":"259780.00","TRANS_TOTAMT":"519129.56","ITEM_CODE":"DN-18","ITEM_NAME":"DIAMOND NECKLACE 18KT","ITEM_GST":"15573.89","ITEM_TV":"534703.44","ITEM_TN":"1","ITEM_TD":"2019-03-05 00:00:00"}] ';


    $invoiceJsonObject=' {"PA_NO":"1","T_TOTQTY":"1.000","T_GROSSWT":"45.140","T_LESSWT":"0.838","T_NETWT":"44.302","T_TOTWAST":"8.860","T_TOTWT":"53.162","T_GOLDVAL":"232849.56","T_TOTMC":"26500.00","T_TOTCH":"259780.00","T_TOTGROSSAMT":"519129.56","T_NETGOLD":"53.162","T_NETVALUE":"519129.56","T_VATAMT":"15573.89","T_TAMTREC":"534703.44","T_ORDERNO":"0","T_CASHADV":"0","T_DISCPER":"0","T_DISCOUNT":"0","T_OGWT":"0","T_OGAMT":"0"} ';


    $size='1';


    $stonesJsonArray='';

    $size2='0';


    $decodejsonobj= json_decode($invoiceJsonObject);
    $T_ID=getTid($datasource);
    $PA_NO = $decodejsonobj->{'PA_NO'};
    $T_TOTQTY = $decodejsonobj->{'T_TOTQTY'};
    $T_GROSSWT = $decodejsonobj->{'T_GROSSWT'};
    $T_LESSWT = $decodejsonobj->{'T_LESSWT'};
    $T_NETWT = $decodejsonobj->{'T_NETWT'};
    $T_TOTWAST = $decodejsonobj->{'T_TOTWAST'};
    $T_TOTWT = $decodejsonobj->{'T_TOTWT'};
    $T_GOLDVAL = $decodejsonobj->{'T_GOLDVAL'};
    $T_TOTMC = $decodejsonobj->{'T_TOTMC'};
    $T_TOTCH = $decodejsonobj->{'T_TOTCH'};
    $T_TOTGROSSAMT = $decodejsonobj->{'T_TOTGROSSAMT'};
    $T_NETGOLD = $decodejsonobj->{'T_NETGOLD'};
    $T_NETVALUE = $decodejsonobj->{'T_NETVALUE'};
    $T_VATAMT = $decodejsonobj->{'T_VATAMT'};
    $T_TAMTREC= $decodejsonobj->{'T_TAMTREC'};
    $T_ORDERNO= $decodejsonobj->{'T_ORDERNO'}; 
    $T_CASHADV= $decodejsonobj->{'T_CASHADV'}; 
    $T_DISCPER= $decodejsonobj->{'T_DISCPER'}; 
    $T_DISCOUNT= $decodejsonobj->{'T_DISCOUNT'}; 
    $T_OGWT= $decodejsonobj->{'T_OGWT'}; 
    $T_OGAMT= $decodejsonobj->{'T_OGAMT'};  
    
    $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
    $date=date(('d/m/Y'));
    if($type==1){
        $stmt = $pdo->prepare(" INSERT INTO TMPESTMASTER_T VALUES ( '$T_ID','$PA_NO','XXXX','$date','$T_TOTQTY','$T_ID',
        '$T_GROSSWT','$T_LESSWT','$T_NETWT','$T_TOTWAST','$T_TOTWT','$T_GOLDVAL','$T_TOTMC','$T_TOTCH','$T_TOTGROSSAMT',
        0,0,'$T_NETGOLD','$T_GOLDVAL','$T_NETVALUE','$T_CASHADV',0,'$T_OGAMT',0,'$T_VATAMT',0,0,'$T_DISCPER','$T_DISCOUNT','$T_TAMTREC',0,0,0,0,
        0,'$date','$T_ORDERNO','$T_OGWT','G','C' ) ");
    }else{
        $stmt = $pdo->prepare(" INSERT INTO TMPESTMASTER_T VALUES ( '$T_ID','$PA_NO','XXXX','$date','$T_TOTQTY','$T_ID',
        '$T_GROSSWT','$T_LESSWT','$T_NETWT','$T_TOTWAST','$T_TOTWT','$T_GOLDVAL','$T_TOTMC','$T_TOTCH','$T_TOTGROSSAMT',
        0,0,'$T_NETGOLD','$T_GOLDVAL','$T_NETVALUE','$T_CASHADV',0,'$T_OGAMT',0,'$T_VATAMT',0,0,'$T_DISCPER','$T_DISCOUNT','$T_TAMTREC',0,0,0,0,
        0,'$date','$T_ORDERNO','$T_OGWT','S','C' ) ");
    }
    
    $stmt->execute();
    $stmt = null;
    
    $decodejsonarray=json_decode($invoiceJsonArray);
        
    for ($x = 0; $x < $size; $x++) {
            
        $TRANS_SLNO= $decodejsonarray[$x]->{"TRANS_SLNO"};
        $TRANS_ITEMNO = $decodejsonarray[$x]->{"TRANS_ITEMNO"};
        $TRANS_RATE= $decodejsonarray[$x]->{"TRANS_RATE"};
        $TRANS_QTY= $decodejsonarray[$x]->{"TRANS_QTY"};
        $TRANS_GROSSWT= $decodejsonarray[$x]->{"TRANS_GROSSWT"};
        $TRANS_LESSWT= $decodejsonarray[$x]->{"TRANS_LESSWT"};
        $TRANS_NETWT= $decodejsonarray[$x]->{"TRANS_NETWT"};
        $TRANS_WTYPE= $decodejsonarray[$x]->{"TRANS_WTYPE"};
        $TRANS_WRATE= $decodejsonarray[$x]->{"TRANS_WRATE"};
        $TRANS_WASTAGE= $decodejsonarray[$x]->{"TRANS_WASTAGE"};
        $TRANS_TOTWT= $decodejsonarray[$x]->{"TRANS_TOTWT"};  
        $TRANS_GOLDVAL= $decodejsonarray[$x]->{"TRANS_GOLDVAL"};
        $TRANS_MCTYPE= $decodejsonarray[$x]->{"TRANS_MCTYPE"};   
        $TRANS_MCRATE= $decodejsonarray[$x]->{"TRANS_MCRATE"};
        $TRANS_MC=   $decodejsonarray[$x]->{"TRANS_MC"};
        $TRANS_OCHA= $decodejsonarray[$x]->{"TRANS_OCHA"};  
        $TRANS_TOTAMT= $decodejsonarray[$x]->{"TRANS_TOTAMT"};
        $tagno=$decodejsonarray[$x]->{"ITEM_TN"};
            
            $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
            $sec=$T_ID.'+'.$TRANS_SLNO;
            $query = " INSERT INTO TMPESTDET_T VALUES ('$T_ID','$sec',
            '$TRANS_SLNO',$tagno,'$TRANS_ITEMNO','$TRANS_RATE','$TRANS_QTY','$TRANS_GROSSWT','$TRANS_LESSWT','$TRANS_NETWT',
            '$TRANS_WTYPE','$TRANS_WRATE','$TRANS_WASTAGE','$TRANS_TOTWT','$TRANS_GOLDVAL','$TRANS_MCTYPE','$TRANS_MCRATE',
            '$TRANS_MC','$TRANS_OCHA','$TRANS_TOTAMT',4,0,0)   ";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $stmt=null;
            
    }
    $decodejsonarray2=json_decode($stonesJsonArray);
    for ($x = 0; $x < $size2; $x++) {
        //ST_SSLNO,ST_SLNO,ST_BEEDS,ST_QTY,ST_CARRAT,ST_WEIGHT,ST_LESS,ST_RATE,ST_VALUE,ST_STONENO
        $ST_SSLNO=$decodejsonarray2[$x]->{"ST_SSLNO"};
        $ST_SLNO=$decodejsonarray2[$x]->{"ST_SLNO"};
        $ST_BEEDS=$decodejsonarray2[$x]->{"ST_BEEDS"};
        $ST_QTY=$decodejsonarray2[$x]->{"ST_QTY"};
        $ST_CARRAT=$decodejsonarray2[$x]->{"ST_CARRAT"};
        $ST_WEIGHT=$decodejsonarray2[$x]->{"ST_WEIGHT"};
        $ST_LESS=$decodejsonarray2[$x]->{"ST_LESS"};
        $ST_RATE=$decodejsonarray2[$x]->{"ST_RATE"};
        $ST_VALUE=$decodejsonarray2[$x]->{"ST_VALUE"};
        $ST_STONENO=$decodejsonarray2[$x]->{"ST_STONENO"};

        $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
            $query = " INSERT INTO TMPESTSTONES_T VALUES ( '$T_ID','S','$ST_SSLNO','$ST_SLNO','$ST_BEEDS','$ST_QTY','$ST_CARRAT','$ST_WEIGHT','$ST_LESS','G','$ST_RATE','$ST_VALUE','$ST_STONENO' )  ";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $stmt=null;
    }
        
    $response = array();
    $response['success'] = "1";
    $response['message'] = "found!";
    $response['details'] = $T_ID.'';
    echo json_encode($response);
    
    function getTid($datasource){
        $pdo=new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$datasource; Uid=; Pwd=;");
        $array = array();
        $stmt = $pdo->prepare("SELECT TOP 1 T_ID from TMPESTMASTER_T order by T_ID desc ");
        $stmt->execute();
        $array = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        $tid=$array['T_ID']+1;
        return $tid;
    }


?>