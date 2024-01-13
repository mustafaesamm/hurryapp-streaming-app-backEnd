<?php
date_default_timezone_set('Asia/Riyadh');
use Firebase\JWT\JWT;
use \Firebase\JWT\Key;
require_once('vendor/autoload.php');
require_once('dbConnect.php');






if($_SERVER['REQUEST_METHOD'] == 'POST'){
$username=$_POST['username'];
$password=$_POST['password'];

$options = [
'cost' => 12,
];
$hashPassword=password_hash($password, PASSWORD_BCRYPT, $options);

$stmt='select username,id from users where username like :username';
$theResultStmt=$connection->prepare($stmt);
$theResultStmt->execute(['username'=>$username]);
$getInfoUser=$theResultStmt->fetch();

if($getInfoUser && $getInfoUser['username'] == $username){

    $array_repsonse=['message'=>'this username is taken'];
    echo json_encode($array_repsonse);
    http_response_code(400);

}else{

$stmt='insert into users(password,username) VALUES(:password,:username)';
$theResult=$connection->prepare($stmt);
$theResult->execute(['password'=>$hashPassword,'username'=>$username]);


$stmtFetchId='select id from users where  username like :username';
$theStmtReady=$connection->prepare($stmtFetchId);
$theStmtReady->execute(['username'=>$username]);
$theNewId=$theStmtReady->fetchColumn();

// jwt parameters

$secret_Key  = '68V0zWFrS72GbpPreidkQFLfj4v9m3Ti+DXc8OB0gcM=';
$date   = strtotime(date('Y-m-d H:i:s'));
$expire_at  =strtotime('+1 day',$date);      // Add 1 Day session
$domainName = "your.domain.name";                                      
$request_data = [
    'st'  => $date,
    'et'  => $expire_at,
    'id' => $theNewId,
];

$theJwtCode= JWT::encode(
    $request_data,
    $secret_Key,
    'HS256'
);

$arrayOfSession=['token'=>$theJwtCode];
echo json_encode($arrayOfSession);
}



}


?>