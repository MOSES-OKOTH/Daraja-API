<?php
header("Content-Type: application/json");

$transactionResponse = file_get_contents('php://input');

if($transactionResponse){
    $logFile = 'log.json';
    $log = fopen($logFile, "a");
    fwrite($log, $transactionResponse);
    fclose($log);
    
    $data = json_encode($logFile);
    
    echo $data;
} else{
    echo "No response to be processed";
}