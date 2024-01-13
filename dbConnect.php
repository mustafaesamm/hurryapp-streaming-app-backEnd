<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type:application/json');
date_default_timezone_set('Asia/Riyadh');

$serverName='localhost';
$dbName='streamingapp';
$userName='root';
$passWord='';



$connection=new PDO('mysql:server='.$serverName.';dbname='.$dbName.'',$userName,$passWord);
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
