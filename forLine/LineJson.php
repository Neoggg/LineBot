<?php

class LineJson
{
  public function menu()
  {
    $size = new \LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder(843,2500);
    $reslut = [
      "size" => $size,
      "selected" => true,
      "name" => "Nice richmenu",
      "chatBarText" => "neogg A meun 拉",
    ];
    $boundArr = [
      [0,0,833,843],
      [833,0,833,843],
      [1666,0,833,843],
    ];
    $actionArr = [
      ["postback", "test"],
      ["postback", "test2"],
      ["postback", "test3"],
    ];
    foreach ($boundArr as $key => $value) {
      $bounds = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder($value[0], $value[1], $value[2], $value[3]);
      $action = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder($actionArr[$key][0],$actionArr[$key][1]);
      $reslut['areas'][] = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder($bounds, $action);
    }
    // $bounds = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder(0,0,2500,1686);
    // $action = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaActionBuilder("postback","action=buy&itemid=123");
    // $reslut['areas'][] = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder($bounds, $action);
    return $reslut;
  }
}