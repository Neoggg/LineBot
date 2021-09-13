<?php

class LinePost
{
  private $requestBody;
  private $userId;
  private $replyToken;
  private $eventsType;
  private $message;
  private $messageType;
  private $messageContent;

  public function __construct($requestBody)
  {
    $this->requestBody = $requestBody;
    if (!empty($requestBody)) {
      $content = json_decode($requestBody, true);
      foreach ($content as $contentValue) {
        $this->eventsType = $contentValue['type'];
        $this->replyToken = $contentValue['replyToken'];
        $this->userId = $contentValue['source']['userId'];
        $this->message = $contentValue['message'];
        $this->messageType = $contentValue['message']['type'];
        $this->messageContent = $contentValue['message']['text'];
      }
    }
  }

  public function getEventsType()
  {
    return $this->eventsType;
  }

  public function getReplyToken()
  {
    return $this->replyToken;
  }

  public function getUserId()
  {
    return $this->userId;
  }

  public function getMessage()
  {
    return $this->message;
  }
}