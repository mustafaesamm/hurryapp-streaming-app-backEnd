<?php

require_once('vendor/autoload.php');
require_once('dbConnect.php');
use Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);


if($_SERVER['REQUEST_METHOD'] == 'POST'){
$username=$_POST['username'];
$password=$_POST['password'];

$options = [
'cost' => 12,
];
$stmt='select username,password,id from users where username like :username';
$theResultStmt=$connection->prepare($stmt);
$theResultStmt->execute(['username'=>$username]);
$getInfoUser=$theResultStmt->fetch();

if($getInfoUser && $getInfoUser['username'] == $username ){

if(password_verify($password,$getInfoUser['password'])){



$secret_Key  = '68V0zWFrS72GbpPreidkQFLfj4v9m3Ti+DXc8OB0gcM=';
$date   = strtotime(date('Y-m-d H:i:s'));
$expire_at  =strtotime('+1 day',$date);     // Add 1 Day session
$domainName = "your.domain.name";                                      
$request_data = [
    'st'  => $date,
    'et'  => $expire_at,
    'id' => $getInfoUser['id'],
    'username'=> $username
];

$theJwtCode= JWT::encode(
    $request_data,
    $secret_Key,
    'HS256'
);

$arrayOfSession=['token'=>$theJwtCode];
echo json_encode($arrayOfSession);
}else{
echo json_encode(['message'=>'password incorrect']);
}


}else{
    http_response_code(400);
}

}


?>