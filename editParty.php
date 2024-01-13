<?php 
require_once('vendor/autoload.php');
require_once 'dbConnect.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// generate join code

$seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789'); 
$rand='';
foreach (array_rand($seed, 3) as $k) $rand .= $seed[$k];
$rand.='-';
shuffle($seed);
foreach (array_rand($seed, 3) as $k) $rand .= $seed[$k];



if($_SERVER['REQUEST_METHOD'] == 'POST'){
$status=$_POST['status'];
//print_r($jsonData);



//     $userId=$decoded->id;
//     $status='active';
//     $joinCode=$rand;
//     $videoId=$_POST['videoId'];


    $stmt='update party set status=":status" where id ';
    $stmtResult=$connection->prepare($stmt);
    $stmtResult->execute(['userId'=>$userId,'status'=>$status,'joinCode'=>$joinCode,'videoId'=>$videoId]);


    
    $stmt='select id from party where joinCode like :joinCode';
    $stmtReady=$connection->prepare('$stmt');
    $stmtReady->execute(['joinCode'=>$joinCode]);
    $thePartyId=$stmtReady->fetchColumn();
    echo json_encode(['partyId'=>$thePartyId]);
};