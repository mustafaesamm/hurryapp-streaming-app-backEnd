<?php 
require_once('vendor/autoload.php');
require_once 'dbConnect.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// generate join code

$seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789'); 
$rand='';
foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
$rand.='-';
shuffle($seed);
foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];



if($_SERVER['REQUEST_METHOD'] == 'POST'){

$thedearders=getallheaders();
$thedeardersToken=$thedearders['Authorization'];

// JWT DECODE

$key = "68V0zWFrS72GbpPreidkQFLfj4v9m3Ti+DXc8OB0gcM=";
$decoded = JWT::decode($thedeardersToken, new Key($key, 'HS256'));

    $userId=$decoded->id;
    $status='active';
    $joinCode=$rand;
    
    
    $stmt='insert into party(userId,status,joinCode) VALUES(:userId,:status,:joinCode)';
    $stmtResult=$connection->prepare($stmt);
    $stmtResult->execute(['userId'=>$userId,'status'=>$status,'joinCode'=>$joinCode]);

    $stmt='select id from party where joinCode like :joinCode';
    $stmtReady=$connection->prepare($stmt);
    $stmtReady->execute(['joinCode'=>$joinCode]);
    $thePartyId=$stmtReady->fetchColumn();
    echo json_encode(['partyId'=>$thePartyId]);
};