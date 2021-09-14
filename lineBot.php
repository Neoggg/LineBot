<?php
require 'vendor/autoload.php';
// require_once('LINEBotTiny.php');
require_once('forLine/LineJson.php');
require_once('forLine/LinePost.php');

use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use \LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use \LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;

$HttpRequestBody = file_get_contents('php://input');
$linePost = new LinePost($HttpRequestBody);
// file_put_contents('php://stderr', serialize($linePost));
// file_put_contents('php://stderr', json_encode($linePost->getEventsType()));
// file_put_contents('php://stderr', json_encode($linePost->getReplyToken()));
// file_put_contents('php://stderr', json_encode($linePost->getUserId()));
// file_put_contents('php://stderr', json_encode($linePost->getMessage()));
// exit;

//設定Token 
$channelSecret =  '64f2e4b2431a448b2c872f5c58a201a9';
$channelAccessToken = 'b31d8B9iAriRU9gT2b2LHKapaDFZzWga3SmlmHCMRWUsl5OplYXV/78fKWM/qjkVGX7W/ReVne/1S+9Q9Vc2bBtZsI6td4pb6sqL8MQWCNzLQPI2dh2S5tjEBN4s6+QRkFTXjCqaNTNUZYZ6F0C2cwdB04t89/1O/w1cDnyilFU=';

$httpClient = new CurlHTTPClient($channelAccessToken);
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
// file_put_contents('php://stderr', serialize($httpClient));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

// $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
// $response = $bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);

$QuickReplyMessageBuilder = new QuickReplyMessageBuilder([
	new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
	new QuickReplyButtonBuilder(new  \LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder('Camera')),
	new QuickReplyButtonBuilder(new  \LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder('Camera roll')),
]);
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($linePost->getMessage(), $QuickReplyMessageBuilder);
$response = $bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
$bot->pushMessage($linePost->getReplyToken(), $textMessageBuilder);
$LineJson = new LineJson();
$data = $LineJson->menu();
$richMenuBuilder = new \LINE\LINEBot\RichMenuBuilder($data['size'], $data['selected'], $data['name'], $data['chatBarText'], $data['areas']);
// file_put_contents('php://stderr', serialize($richMenuBuilder));
$response = $bot->createRichMenu($richMenuBuilder);
$status = $response->getHTTPStatus();
if ($status == 200) {
	$content = $response->getJSONDecodedBody();
	$richMenuId = $content['richMenuId'];
	file_put_contents('php://stderr', json_encode($richMenuId));
	$imagePath = __DIR__ . '/ellall.jpg';
	$contentType = 'image/jpeg';
	$imgResponse = $bot->uploadRichMenuImage($richMenuId, $imagePath, $contentType);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/user/all/richmenu/' . $richMenuId);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Authorization: Bearer ' . $channelAccessToken
	]);
	$result = curl_exec($ch);
	file_put_contents('php://stderr', json_encode($result));
	curl_close($ch);
} else {
	error_log('fail'); 
}
exit;
//讀取資訊 
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$dataEven = $client->parseEvents();
foreach ($client->parseEvents() as $event) {
	switch ($event['type']) {
		case 'message': //訊息觸發
			$message = $event['message'];
			if (strtolower($message['text']) == "test") {
				$client->replyMessage(array(
					'replyToken' => $event['replyToken'],
					'messages' => array(
						array(
							'type' => 'text', //訊息類型 (文字)
							'text' => '金罵勒test' //回覆訊息
						),
					),
				));
			} elseif (strtolower($message['text']) == 'meun') {
				$client->replyMessage(array(
					'replyToken' => $event['replyToken'],
						"type" => "text",
						"text" => "Select your favorite food category or send me your location!",
						'quickReply' => array(
							"items" => array(
								array(
									'type' => 'action', //訊息類型 (文字)
									"action" => array(
										"type" => "message",
										"label" => "A.台北",
										"text" => "台北"
									)
								),
								array(
									'type' => 'action', //訊息類型 (文字)
									"action" => array(
										"type" => "message",
										"label" => "b.台南",
										"text" => "台南"
									)
								),
							)
						),
				));
			} else {
				$client->replyMessage(array(
					'replyToken' => $event['replyToken'],
					'messages' => array(
						array(
							'type' => 'text', //訊息類型 (文字)
							'text' => '母湯歐北怕' //回覆訊息
						)
					)
				));
			}
	}
}

//輸出
// error_log(); 
// file_put_contents('php://stderr', json_encode($dataEven));
// file_put_contents('php://stderr', $HttpRequestBody);

/**
 * "events":[{
 * 						"type":"message",
 * 						"message":
 * 						{
 * 							"type":"text",
 * 							"id":"14737459099128",
 * 							"text":"..."
 * 						},
 * 						"timestamp":1631504988589,
 * 						"source":
 * 						{
 * 							"type":"user",
 * 							"userId":"U420aa8a5b3859615a73a08c3f9fa53e2"
 * 						},
 * 						"replyToken":"e38abc6740624b099206b94b25a17967",
 * 						"mode":"active"
 * 					}]
 */
function parser($body)
{
	$data = [];
	$entityBody = file_get_contents('php://input');
	$data = json_decode($entityBody, true);
	// $data['events']['message'];
	// $data['events']['message']['type'];
	// $data['events']['message']['text'];
	// $data['events']['replyToken'];
	// $data['events']['source']['userId'];
	return $data;
}