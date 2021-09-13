<?php

class LinePost
{
  private $requestBody = [];
  private $userId;
  private $replyToken;
  private $eventsType;
  private $message;
  private $messageType;
  private $messageContent;

  public function __construct($requestBody)
  {
    // $this->requestBody = $requestBody;
    if (!empty($requestBody)) {
      $this->requestBody  = json_decode($requestBody, true);
      foreach ($this->requestBody as $content) {
        $this->eventsType = $content['type'];
        $this->replyToken = $content['replyToken'];
        $this->userId = $content['source']['userId'];
        $this->message = $content['message'];
        $this->messageType = $content['message']['type'];
        $this->messageContent = $content['message']['text'];
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