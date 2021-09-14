<?php
require 'vendor/autoload.php';
require_once 'forLine/LineJson.php';
require_once 'forLine/LinePost.php';

use \LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use \LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use \LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;

$jsonMap = '{"destination":"U52d37d1d9b625754fa7308ed6af263ef","events":[{"type":"message","message":{"type":"location","id":"14743074306580","latitude":25.028028164750477,"longitude":121.5493593925288,"address":"106台灣台北市大安區敦化南路二段111號"},"timestamp":1631590614516,"source":{"type":"user","userId":"U420aa8a5b3859615a73a08c3f9fa53e2"},"replyToken":"5b7db4bb1a924978918706f76292c7a0","mode":"active"}]}';
$HttpRequestBody = file_get_contents('php://input');
// file_put_contents('php://stderr', json_encode($HttpRequestBody));
$linePost = new LinePost($HttpRequestBody);
file_put_contents('php://stderr', json_encode($linePost->getMessage()));
//設定Token 
$channelSecret =  '64f2e4b2431a448b2c872f5c58a201a9';
$channelAccessToken = 'b31d8B9iAriRU9gT2b2LHKapaDFZzWga3SmlmHCMRWUsl5OplYXV/78fKWM/qjkVGX7W/ReVne/1S+9Q9Vc2bBtZsI6td4pb6sqL8MQWCNzLQPI2dh2S5tjEBN4s6+QRkFTXjCqaNTNUZYZ6F0C2cwdB04t89/1O/w1cDnyilFU=';

$httpClient = new CurlHTTPClient($channelAccessToken);
$bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$QuickReplyMessageBuilder = new QuickReplyMessageBuilder([
	new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
	new QuickReplyButtonBuilder(new  \LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder('Camera')),
	new QuickReplyButtonBuilder(new  \LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder('Camera roll')),
]);
// $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('tset', $QuickReplyMessageBuilder);
$pushMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('U420aa8a5b3859615a73a08c3f9fa53e2',  json_encode($linePost->getMessage()));
// $bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
$bot->pushMessage($linePost->getUserId(), $pushMessageBuilder);
$LineJson = new LineJson();
$data = $LineJson->menu();
$richMenuBuilder = new \LINE\LINEBot\RichMenuBuilder($data['size'], $data['selected'], $data['name'], $data['chatBarText'], $data['areas']);
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

$jsonMap = '{"destination":"U52d37d1d9b625754fa7308ed6af263ef","events":[{"type":"message","message":{"type":"location","id":"14743074306580","latitude":25.028028164750477,"longitude":121.5493593925288,"address":"106台灣台北市大安區敦化南路二段111號"},"timestamp":1631590614516,"source":{"type":"user","userId":"U420aa8a5b3859615a73a08c3f9fa53e2"},"replyToken":"5b7db4bb1a924978918706f76292c7a0","mode":"active"}]}';

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