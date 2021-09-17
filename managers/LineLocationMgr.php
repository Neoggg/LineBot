<?php

use \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;

class LineLocationMgr
{

  // ES groupby 欄位
  private $aggsField = ['typecode'];
  // searchPath
  private $searchPath = '/user_needs/search-result?';
  // 搜尋類型(八大類型卡片)
  private $searchAggsTypecode = ['電梯大樓', '公寓', '套房', '透天厝', '樓中樓', '別墅', '辦公大樓', '店面'];
  // 組成url所需參數
  private $searchUrlParams = ['city', 'zipcode', 'location'];
  // Line外開Browser
  private $exBrowser = 'openExternalBrowser=1';

  /**
   * 解析lineMessage資訊
   * @param array $messageInfo
   * @return array
   */
  public function parserLineLocationMessage($messageInfo)
  {
    $params = [];
    if (!empty($messageInfo)) {
      // 由zipcode去判斷縣市區域
      preg_match('/^[0-9]{3}/', $messageInfo['address'], $matchZipcode);
      if (!empty($matchZipcode[0]) && ($matchZipcode[0] != 300 || $matchZipcode[0] != 600)) {
        $cityArea = RkyZipcode::getTitleByZipcode($matchZipcode[0]);
        $params['city'] = $cityArea[0];
        $params['area'] = $cityArea[1];
        $params['zipcode'] = $matchZipcode[0];
      }
      $LineLocationConfig = RakuyaConfig::getAppConfig('LineLocationConfig');
      if (!empty($matchZipcode[0]) && ($matchZipcode[0] != 300 || $matchZipcode[0] != 600)) {
        $cityArea = RkyZipcode::getTitleByZipcode($matchZipcode[0]);
        $params['city'] = $cityArea[0];
        $params['area'] = $cityArea[1];
        $params['zipcode'] = $matchZipcode[0];
      }
      // 特殊zipcode轉換
      if ($matchZipcode[0] == 300) {
        $params['city'] = '新竹市';
        foreach ($LineLocationConfig['lineSpecialArea'][300] as $value) {
          if (preg_match('/' . $value . '/', $messageInfo['address'])) {
            $params['area'] = $value;
            $params['zipcode'] = $LineLocationConfig['zipcodeTurn'][300][$value];
            break;
          } else {
            $params['area'] = '';
            $params['zipcode'] = 300;
          }
        }
      } elseif ($matchZipcode[0] == 600) {
        $params['city'] = '嘉義市';
        foreach ($LineLocationConfig['lineSpecialArea'] as $value) {
          if (preg_match('/' . $value . '/', $messageInfo['address'])) {
            $params['area'] = $value;
            $params['zipcode'] = $LineLocationConfig['zipcodeTurn'][600][$value];
            break;
          } else {
            $params['area'] = '';
            $params['zipcode'] = 600;
          }
        }
      }
      //地址除去台灣字樣
      $params['address'] = str_replace($matchZipcode[0] . '台灣', '', $messageInfo['address']);
      $params['location'][] = $messageInfo['latitude'];
      $params['location'][] = $messageInfo['longitude'];
    }
    return $params;
  }

  /**
   * 取得全網搜尋群組 groupBy 資料
   * 
   * @param array $params
   * @return array
   */
  // public function getWholeWebItemAggs($params)
  // {
  //   $result = [];
  //   try {
  //     $WholeWebItemSearchMgr = new RakuyaJsonRpcClient('statistics', '\wholeWebItem\managers\search\WholeWebItemSearchMgr');
  //     $result = $WholeWebItemSearchMgr->searchGroupItemAggs($params, $this->aggsField);
  //   } catch (\Exception $ex) {
  //     RkyLog::setLog($ex->getMessage());
  //     $result = [];
  //   }
  //   return $result;
  // }

  // public function genTypecodeCarouselTemplateMess($aggsData, $params)
  public function genTypecodeCarouselTemplateMess($lineReplyMess)
  {
    $Carousel = '';
    // if (!empty($aggsData) && !empty($params)) {
    //   // 只取目前所需的八大類型
    //   $searchAggsTypecode = $this->searchAggsTypecode;
    //   foreach ($aggsData['aggs']['typecode'] as $aggs) {
    //     if (in_array($aggs['key'], $searchAggsTypecode)) {
    //       $typeAggsData[$aggs['key']] = $aggs['doc_count'];
    //     }
    //   }
    //   // 確保排序
    //   $typeAggs = [];
    //   foreach ($searchAggsTypecode as $value) {
    //     $typeAggs[$value] = $typeAggsData[$value];
    //   }
    //   // params進行url format處理
    //   $urlParams = $this->formatUrlParams($params);
      // 取得卡片回覆內容
      // $lineReplyMess = $this->genTypecodeCarouselReplyMess($typeAggs, $params, $urlParams);
      // 建立CarouselTemplateBuilder
      $CarouselColumn = [];
      foreach ($lineReplyMess as $key => $content) {
        $UriTemplate = [];
        if (!empty($content['searchUrlLowPrice'])) {
          // 低總價searchUrl
          $UriTemplate[] = new UriTemplateActionBuilder($content['searchUrlLowPriceText'], $content['searchUrlLowPrice'] . $this->exBrowser);
        }
        if (!empty($content['searchUrlAll'])) {
          // 全部查詢searchUrl
          $UriTemplate[] = new UriTemplateActionBuilder($content['searchUrlAllText'], $content['searchUrlAll'] . $this->exBrowser);
        }
        // ****之後須更換各類型圖片
        $CarouselColumn[] = new CarouselColumnTemplateBuilder($content['typecode'], $content['text'], 'https://i.imgur.com/VKihAYW.jpg', $UriTemplate, '#FFFFFF');
      }
      $Carousel = new CarouselTemplateBuilder($CarouselColumn,'rectangle','cover');
    // }
    return $Carousel;
  }

  /**
   * formatUrlParams
   * 
   * @param array $params
   * @return array
   */
  private function formatUrlParams($params)
  {
    $urlParams = [];
    foreach ($this->searchUrlParams as $param) {
      $result = '';
      switch ($param) {
        case 'city':
          $result = RkyZipcode::getCityByZipcode($params['zipcode']);
          break;
        case 'location':
          $result = join(',', $params['location']);
          break;
        default:
          $result = $params[$param];
          break;
      }
      $urlParams[$param] = $result;
    }
    return $urlParams;
  }

  /**
   * 建立各卡片的回應內容與url
   * 
   * @param array $typeAggs
   * @param array $params
   * @param array $urlParams
   * @return array
   */
  private function genTypecodeCarouselReplyMess($typeAggs, $params, $urlParams)
  {
    $message = [];
    $searchReqAll = '';
    $h_global_config = RakuyaConfig::getGlobalConfig('h_global_config');
    $LineLocationConfig = RakuyaConfig::getAppConfig('LineLocationConfig');
    foreach ($urlParams as $param => $value) {
      $searchReqAll = $searchReqAll . $param . '=' . $value . '&';
    }
    foreach ($typeAggs as $type => $count) {
      // 低總價條件 
      if (array_key_exists($params['city'],  $LineLocationConfig['lowPrice'])) {
        if ($type == '公寓' || $type == '套房') {
          $price = $LineLocationConfig['lowPrice'][$params['city']][0];
          $lowPriceRange = '~' . $LineLocationConfig['lowPrice'][$params['city']][0];
        } else {
          $price = $LineLocationConfig['lowPrice'][$params['city']][1];
          $lowPriceRange = '~' . $LineLocationConfig['lowPrice'][$params['city']][1];
        }
      } else {
        if ($type == '公寓' || $type == '套房') {
          $price = $LineLocationConfig['lowPrice'][$params['city']][0];
          $lowPriceRange = '~' . $LineLocationConfig['lowPrice']['else'][0];
        } else {
          $price = $LineLocationConfig['lowPrice'][$params['city']][1];
          $lowPriceRange = '~' . $LineLocationConfig['lowPrice']['else'][1];
        }
      }
      // 若無物件時搜尋全區
      if ($count == 0) {
        $searchUrlLowPrice = '';
        // 此類型全查url
        $searchUrlAll = $h_global_config['member_host'] . $this->searchPath .  str_replace($urlParams['location'], '',  $searchReqAll) . 'typecode=' . $LineLocationConfig['typecodeTurn'][$type] . '&';
        $searchUrlLowPriceText = '';
        $searchUrlAllText = '全部查看';
        $text = '附近500m沒有這類型物件為您查詢全區域的' . $type;
      } else {
        // 此類型500m以內低總價url
        $searchUrlLowPrice = $h_global_config['member_host'] . $this->searchPath .  $searchReqAll . 'typecode=' . $LineLocationConfig['typecodeTurn'][$type] . '&price=' . $lowPriceRange . '&';
        // 此類型500m以內全查url
        $searchUrlAll = $h_global_config['member_host'] . $this->searchPath .  $searchReqAll . 'typecode=' . $LineLocationConfig['typecodeTurn'][$type] . '&';
        $searchUrlLowPriceText = '< ' . $price . '萬 低總價';
        $searchUrlAllText = '全部查看';
        $text = '500m以內共有' . $count . '筆';
      }
      $message[] = [
        'text' => $text,
        'typecode' => $type, 
        'count' => $count,
        'searchUrlLowPrice' => $searchUrlLowPrice,
        'searchUrlLowPriceText' => $searchUrlLowPriceText,
        'searchUrlAll' => $searchUrlAll,
        'searchUrlAllText' => $searchUrlAllText,
      ];
    }
    return $message;
  }

  private function genAutoLoginUrl($url)
  {
    # todo
  }
}