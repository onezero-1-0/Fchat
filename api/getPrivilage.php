<?php
//passwords
$hashed_SYSTEM_password = "$2y$10\$QBPX5/vmHcfVD9UUjSF/0epeuJ63ReifSXmVKZF3qYI1oBi9btf.y";
$hashed_ADMIN_password = "$2y$10\$f1mZs1V5gJpPwZkABuULk.WNfsSmpMd./2V9mroVzT8sF49MlH0Ra";
$hashed_MOD_password = "$2y$10\$MmrttMmlb6SQtzqhiPJdXeie9cDMRD5ipVFZifQhk7WY5WNm3QN0S";


if($_SERVER["REQUEST_METHOD"] != "POST"){
    echo "please reqest with ?priv=admin,?priv=mod or ?priv=user\n"; //this is a rabit Hall
    header("Location: ../login.php");
}

$adminpass = $_POST['adminpass'];

header('Content-Type: application/json');

if(password_verify($adminpass, $hashed_SYSTEM_password)){
    echo json_encode(["privilege" => 1]);

}elseif(password_verify($adminpass, $hashed_ADMIN_password)){
    echo json_encode(["privilege" => 2]);

}elseif(password_verify($adminpass, $hashed_MOD_password)){
    echo json_encode(["privilege" => 3]);

}else{
    echo json_encode(["privilege" => 4]);
}
