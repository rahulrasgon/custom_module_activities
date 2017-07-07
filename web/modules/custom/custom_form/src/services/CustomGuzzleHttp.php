<?php
namespace Drupal\custom_form\services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Get a response code from any URL using Guzzle in Drupal 8!
 *
 * Usage:
 * In the head of your document:
 *
 * use Drupal\custom_guzzle_request\Http\CustomGuzzleHttp;
 *
 * In the area you want to return the result, using any URL for $url:
 *
 * $check = new CustomGuzzleHttp();
 * $response = $check->performRequest($url);
 *
 **/

class CustomGuzzleHttp {
  use StringTranslationTrait;
  protected $appid;
  protected $cityName;
  protected $siteUrl;

  public function performRequest($siteUrl) {
    $client = new \GuzzleHttp\Client();
    try {
      $res = $client->get($siteUrl, ['http_errors' => false]);
      return($res->getBody()->getContents());
    } catch (RequestException $e) {
      return($this->t('Error'));
    }

  }

  public function generateUrl($cityName) {
    $this->cityName=$cityName;
    $config_weather = \Drupal::config('weather.settings');
    $this->appid = $config_weather->get('weatherconfig.appid');
    $this->siteUrl='http://api.openweathermap.org/data/2.5/weather?q='.$this->cityName .'&appid='.$this->appid;
    $data=$this->performRequest($this->siteUrl);
    return json_decode($data);
  }
}
