<?php
require 'vendor/autoload.php';
require_once 'models/LineJson.php';
require_once 'models/LinePost.php';

use \LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use \LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use \LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;

$jsonMessage = '{"destination":"U52d37d1d9b625754fa7308ed6af263ef","events":[{"type":"message","message":{"type":"text","id":"14743579319820","text":"..."},"timestamp":1631597207787,"source":{"type":"user","userId":"U420aa8a5b3859615a73a08c3f9fa53e2"},"replyToken":"f223ae75bb764c22a14cc18f72fc1929","mode":"active"}]}';
$jsonMap = '{"destination":"U52d37d1d9b625754fa7308ed6af263ef","events":[{"type":"message","message":{"type":"location","id":"14743074306580","latitude":25.028028164750477,"longitude":121.5493593925288,"address":"106台灣台北市大安區敦化南路二段111號"},"timestamp":1631590614516,"source":{"type":"user","userId":"U420aa8a5b3859615a73a08c3f9fa53e2"},"replyToken":"5b7db4bb1a924978918706f76292c7a0","mode":"active"}]}';

$HttpRequestBody = file_get_contents('php://input');
// file_put_contents('php://stderr', json_encode($HttpRequestBody));
$linePost = new LinePost($jsonMap);
$messageInfo = $linePost->getMessage();
//設定Token 
$channelSecret =  '64f2e4b2431a448b2c872f5c58a201a9';
$channelAccessToken = 'b31d8B9iAriRU9gT2b2LHKapaDFZzWga3SmlmHCMRWUsl5OplYXV/78fKWM/qjkVGX7W/ReVne/1S+9Q9Vc2bBtZsI6td4pb6sqL8MQWCNzLQPI2dh2S5tjEBN4s6+QRkFTXjCqaNTNUZYZ6F0C2cwdB04t89/1O/w1cDnyilFU=';

$httpClient = new CurlHTTPClient($channelAccessToken);
$bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);
$lineReplyMess = array ( 0 => array ( 'text' => '500m以內共有60筆', 'typecode' => '公寓', 'count' => 60, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R1&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R1&', 'searchUrlAllText' => '全部查看', ), 1 => array ( 'text' => '500m以內共有132筆', 'typecode' => '電梯大樓', 'count' => 132, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R2&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R2&', 'searchUrlAllText' => '全部查看', ), 2 => array ( 'text' => '500m以內共有24筆', 'typecode' => '華廈', 'count' => 24, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R2&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R2&', 'searchUrlAllText' => '全部查看', ), 3 => array ( 'text' => '500m以內共有73筆', 'typecode' => '店面', 'count' => 73, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=B2&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=B2&', 'searchUrlAllText' => '全部查看', ), 4 => array ( 'text' => '500m以內共有27筆', 'typecode' => '辦公大樓', 'count' => 27, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=B1&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=B1&', 'searchUrlAllText' => '全部查看', ), 5 => array ( 'text' => '500m以內共有6筆', 'typecode' => '套房', 'count' => 6, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R3&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R3&', 'searchUrlAllText' => '全部查看', ), 6 => array ( 'text' => '500m以內共有4筆', 'typecode' => '透天厝', 'count' => 4, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R5&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R5&', 'searchUrlAllText' => '全部查看', ), 7 => array ( 'text' => '500m以內共有4筆', 'typecode' => '樓中樓', 'count' => 4, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R6&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R6&', 'searchUrlAllText' => '全部查看', ), 8 => array ( 'text' => '500m以內共有1筆', 'typecode' => '別墅', 'count' => 1, 'searchUrlLowPrice' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R4&price=~1200', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member-neogg.rakuya.com.tw/user_needs/search-result?city=0&zipcode=106&location=25.02802816475,121.54935939253&typecode=R4&', 'searchUrlAllText' => '全部查看', ), );
$CarouselColumn = [];
foreach ($lineReplyMess as $key => $content) {
	$UriTemplate = [];
	if (!empty($content['searchUrlLowPrice'])) {
		$UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlLowPriceText'], $content['searchUrlLowPrice']);
	}
	if (!empty($content['searchUrlAll'])) {
		// $UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlAllText'], $content['searchUrlAll']);
		// $UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlAllText'], 'https://i.imgur.com/VKihAYW.jpg');
		$UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('https://i.imgur.com/adKT5rY.jpg?openExternalBrowser=1', 'https://i.imgur.com/adKT5rY.jpg?openExternalBrowser=1');
	}
	$CarouselColumn[] = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder($content['typecode'], $content['text'], 'https://i.imgur.com/VKihAYW.jpg', $UriTemplate, '#FFFFFF');
}
$Carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($CarouselColumn,'rectangle','cover');
// $Carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder(
// 	[
// 		new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder('公寓', '60筆', 'https://i.imgur.com/VKihAYW.jpg',
// 			[
// 				new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('url', 'https://open.spotify.com/track/12095GlriCNhVCbJV30vKw?si=c8713d60fa4f4a4e'),
// 				new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('url', 'https://open.spotify.com/track/12095GlriCNhVCbJV30vKw?si=c8713d60fa4f4a4e'),
// 			],
// 			'#FFFFFF',
// 		),
// 		new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder('電梯大樓', '70筆', 'https://i.imgur.com/VKihAYW.jpg',
// 			[
// 				new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('url', 'https://open.spotify.com/track/12095GlriCNhVCbJV30vKw?si=c8713d60fa4f4a4e'),
// 				new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('url', 'https://open.spotify.com/track/12095GlriCNhVCbJV30vKw?si=c8713d60fa4f4a4e'),
// 			],
// 			'#FFFFFF',
// 		)
// 	],
// 	'rectangle','cover'
// );
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('CCC', $Carousel);
$bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
exit;

$ButtonTemplate = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(
	'公寓',
	'60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆',
	'https://i.imgur.com/VKihAYW.jpg',
	[
		new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('url', 'https://open.spotify.com/track/12095GlriCNhVCbJV30vKw?si=c8713d60fa4f4a4e'),
		new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('url', 'https://open.spotify.com/track/12095GlriCNhVCbJV30vKw?si=c8713d60fa4f4a4e'),
	],
	'rectangle',
	'cover',
	'#FFFFFF'
);
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('alert', $ButtonTemplate);
$bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
// exit;

$QuickReplyMessageBuilder = new QuickReplyMessageBuilder([
	new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
	new QuickReplyButtonBuilder(new  \LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder('Camera')),
	new QuickReplyButtonBuilder(new  \LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder('Camera roll')),
]);
$messageInfo = $linePost->getMessage();
file_put_contents('php://stderr', json_encode($messageInfo));
if ($messageInfo['type'] == 'text') {
	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($messageInfo['text'], $QuickReplyMessageBuilder);
	$bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
}
if ($messageInfo['type'] == 'location') {
	$pushMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($HttpRequestBody . PHP_EOL . $messageInfo['latitude'] . ' ' . $messageInfo['longitude'] . PHP_EOL . $messageInfo['address'], $QuickReplyMessageBuilder);
	$bot->pushMessage($linePost->getUserId(), $pushMessageBuilder);
}
$LineJson = new LineJson();
$data = $LineJson->menu();
$richMenuBuilder = new \LINE\LINEBot\RichMenuBuilder($data['size'], $data['selected'], $data['name'], $data['chatBarText'], $data['areas']);
$response = $bot->createRichMenu($richMenuBuilder);
$status = $response->getHTTPStatus();
if ($status == 200) {
	$content = $response->getJSONDecodedBody();
	$richMenuId = $content['richMenuId'];
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
	curl_close($ch);
} else {
	error_log('fail'); 
}
exit;

$jsonMap = '{"destination":"U52d37d1d9b625754fa7308ed6af263ef","events":[{"type":"message","message":{"type":"location","id":"14743074306580","latitude":25.028028164750477,"longitude":121.5493593925288,"address":"106台灣台北市大安區敦化南路二段111號"},"timestamp":1631590614516,"source":{"type":"user","userId":"U420aa8a5b3859615a73a08c3f9fa53e2"},"replyToken":"5b7db4bb1a924978918706f76292c7a0","mode":"active"}]}';
