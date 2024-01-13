<?php
date_default_timezone_set('Asia/Riyadh');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require_once('vendor/autoload.php');
require_once('dbConnect.php');
// get request headers

$thedearders=getallheaders();
$thedeardersToken=$thedearders['Authorization'];

// JWT DECODE
$key = "68V0zWFrS72GbpPreidkQFLfj4v9m3Ti+DXc8OB0gcM=";
$decoded = JWT::decode($thedeardersToken, new Key($key, 'HS256'));

if(date('Y-m-d H:i:s',$decoded->et) >= date('Y-m-d H:i:s')){
print_r( json_encode(['username'=>$decoded->username,'id'=>$decoded->id,'timeExpiration'=>date('Y-m-d H:i:s',$decoded->et)]));
}else{
    http_response_code(400);
}