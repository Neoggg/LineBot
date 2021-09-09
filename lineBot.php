<?php

/**
 * LineBot test
 * https://neogg.herokuapp.com/lineBot.php
 */

date_default_timezone_set("Asia/Taipei"); //設定時區為台北時區

require_once('LINEBotTiny.php');

//設定Token 
$ChannelSecret =  '64f2e4b2431a448b2c872f5c58a201a9'; 
$ChannelAccessToken = 'b31d8B9iAriRU9gT2b2LHKapaDFZzWga3SmlmHCMRWUsl5OplYXV/78fKWM/qjkVGX7W/ReVne/1S+9Q9Vc2bBtZsI6td4pb6sqL8MQWCNzLQPI2dh2S5tjEBN4s6+QRkFTXjCqaNTNUZYZ6F0C2cwdB04t89/1O/w1cDnyilFU='; 
 
//讀取資訊 
$HttpRequestBody = file_get_contents('php://input'); 
$client = new LINEBotTiny('b31d8B9iAriRU9gT2b2LHKapaDFZzWga3SmlmHCMRWUsl5OplYXV/78fKWM/qjkVGX7W/ReVne/1S+9Q9Vc2bBtZsI6td4pb6sqL8MQWCNzLQPI2dh2S5tjEBN4s6+QRkFTXjCqaNTNUZYZ6F0C2cwdB04t89/1O/w1cDnyilFU=', '64f2e4b2431a448b2c872f5c58a201a9');
foreach ($client->parseEvents() as $event) {
    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text', //訊息類型 (文字)
                'text' => 'Hello, world!' //回覆訊息
            )
        )
    ));
}

//輸出 
file_put_contents('log.txt', $HttpRequestBody); 