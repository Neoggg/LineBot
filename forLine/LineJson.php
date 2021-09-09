<?php

class LineJson
{
  public function menu()
  {
    $size = new \LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder(1686,2500);
    $reslut = [
      "size" => $size,
      "selected" => false,
      "name" => "Nice richmenu",
      "chatBarText" => "Tap to open",
    ];
    $bounds = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder(0,0,2500,1686);
    $action = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaActionBuilder("postback","action=buy&itemid=123");
    $reslut['areas'][] = new \LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder($bounds, $action);
    return $reslut;
  }
}