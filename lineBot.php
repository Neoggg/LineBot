<?php
//設定Token 
$ChannelSecret = '64f2e4b2431a448b2c872f5c58a201a9'; 
$ChannelAccessToken = 'b31d8B9iAriRU9gT2b2LHKapaDFZzWga3SmlmHCMRWUsl5OplYXV/78fKWM/qjkVGX7W/ReVne/1S+9Q9Vc2bBtZsI6td4pb6sqL8MQWCNzLQPI2dh2S5tjEBN4s6+QRkFTXjCqaNTNUZYZ6F0C2cwdB04t89/1O/w1cDnyilFU='; 
 
//讀取資訊 
$HttpRequestBody = file_get_contents('php://input'); 
$HeaderSignature = $_SERVER['HTTP_X_LINE_SIGNATURE']; 
 
//驗證來源是否是LINE官方伺服器 
$Hash = hash_hmac('sha256', $HttpRequestBody, $ChannelSecret, true); 
$HashSignature = base64_encode($Hash); 
if($HashSignature != $HeaderSignature) 
{ 
    die('hash error!'); 
} 
 
//輸出 
file_put_contents('log.txt', $HttpRequestBody); 