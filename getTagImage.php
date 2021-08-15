<?php
if(isset($_POST['location'])){
    $location=$_POST['location'];
}
if (file_exists($location)) {
    $img = file_get_contents($location); 
    $data = base64_encode($img); 
    $response=array();
    $response['success']="1";
    $response['imageEncoded']=$data;
    echo json_encode( $response); 
}else {
    $response['success']="0";
    echo json_encode( $response); 
}
