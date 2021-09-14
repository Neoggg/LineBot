<?php

class LinePost
{
  private $requestBody = [];
  private $userId;
  private $replyToken;
  private $eventsType;
  private $message;

  public function __construct($requestBody)
  {
    $this->requestBody  = json_decode($requestBody, true);
    if (!empty($requestBody)) {
      foreach ($this->requestBody['events'] as $content) {
        $this->eventsType = $content['type'];
        $this->replyToken = $content['replyToken'];
        $this->userId = $content['source']['userId'];
        $this->message = isset($content['message']) ? $content['message'] : '';
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