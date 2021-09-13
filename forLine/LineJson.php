<?php

class LineJson
{
  public function menu()
  {
    $size = new \LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder(1686,2500);
    $result = [
      "size" => $size,
      "selected" => true,
      "name" => "Nice richmenu",
      "chatBarText" => "neogg A meun 拉",
    ];
    $boundArr = [
      [0,0,833,843],
      [833,0,833,843],
      [1666,0,833,843],
      // [0,843,833,843],
      // [833,843,833,843],
      // [1666,843,833,843],
    ];
    $actionArr = [
      ["postback", "test"],
      ["message", "挖金罵勒共威"],
      ["uri",'url', 'https://open.spotify.com/track/1gtr662OovFOCdYjivs21N?si=51f8cf24a3e8479f'],
    ];
    foreach ($boundArr as $key => $value) {     
      $bounds = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder($value[0],$value[1],$value[2],$value[3]);
      switch ($actionArr[$key][0]) {
        case 'postback':
          $action = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder($actionArr[$key][0],$actionArr[$key][1]);
          break;
        case 'uri':
          $action = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($actionArr[$key][1],$actionArr[$key][2]);
          break;
        case 'message':
          $action = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder($actionArr[$key][0],$actionArr[$key][1]);
          break;
        case 'location':
          $action = new  \LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder('location', 'Location');
          break;
        case 'camera':
          $action = new  \LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder($actionArr[$key][1]);
          break;
      }
      $result['areas'][] = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder($bounds, $action);
    }
    return $result;
  }
}