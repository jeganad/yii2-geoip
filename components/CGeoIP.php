<?php

/**
 * +----------------------------------------------------------------------+
 * | PHP version 5                                                        |
 * +----------------------------------------------------------------------+
 * | Copyright (C) 2015 QTmax.com                                         |
 * +----------------------------------------------------------------------+
 * | This library is free software; you can redistribute it and/or        |
 * | modify it under the terms of the GNU Lesser General Public           |
 * | License as published by the Free Software Foundation; either         |
 * | version 2.1 of the License, or (at your option) any later version.   |
 * +----------------------------------------------------------------------+
 * | Authors: Hoang Xuan Phi <phi.qtmax@gmail.com>                        |
 * +----------------------------------------------------------------------+
 *
 * @category Net
 * @package  GeoIP
 * @author Dinis Lage <phi.qtmax@gmail.com>
 * @license http://www.qtmax.com
 * $Id: GeoIP.php 296763 2015-01-20
 */
/**
 * CGeoip class file.
 *
 * @author Hoang Xuan Phi <phi.qtmax@gmail.com>
 * @link http://www.yiiframework.com/
 * @version 0.1
 */
namespace dpodium\yii2\geoip\components;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use dpodium\yii2\geoip\components\GeoIP;

class CGeoIP extends Component {

  public $filename;
  public $mode;
  protected static $flags = GeoIP::STANDARD;
  protected static $geoip;

  public function init() {
    switch($this->mode) {
      case 'MEMORY_CACHE':
        self::$flags = GeoIP::MEMORY_CACHE;
        break;
      default:
        self::$flags = GeoIP::STANDARD;
        break;
    }
    // Run parent
    parent::init();
  }

  public function lookupLocation($ip=null) {
    if((strpos($ip, ":") === false)) {
      $this->filename = dirname(__DIR__) . '/components/GeoIP/GeoLiteCity.dat';
    } else {
      $this->filename = dirname(__DIR__) . '/components/GeoIP/GeoLiteCityv6.dat';
    }
    self::$geoip = GeoIP::getInstance($this->filename, self::$flags);
    $ip = $this->_getIP($ip);
    return self::$geoip->lookupLocation($ip);
  }

  public function lookupCountryCode($ip=null) {
    if((strpos($ip, ":") === false)) {
      $this->filename = dirname(__DIR__) . '/components/GeoIP/GeoIP.dat';
    } else {
      $this->filename = dirname(__DIR__) . '/components/GeoIP/GeoIPv6.dat';
    }
    self::$geoip = GeoIP::getInstance($this->filename, self::$flags);
    $ip = $this->_getIP($ip);
    return self::$geoip->lookupCountryCode($ip);
  }

  public function lookupCountryName($ip=null) {
    if((strpos($ip, ":") === false)) {
      $this->filename = dirname(__DIR__) . '/components/GeoIP/GeoIP.dat';
    } else {
      $this->filename = dirname(__DIR__) . '/components/GeoIP/GeoIPv6.dat';
    }
    self::$geoip = GeoIP::getInstance($this->filename, self::$flags);
    $ip = $this->_getIP($ip);
    return self::$geoip->lookupCountryName($ip);
  }

  public function lookupOrg($ip=null) {
    //$this->filename = dirname(__DIR__) . '/components/GeoIP/GeoLiteCity.dat';
    //self::$geoip = GeoIP::getInstance($this->filename, self::$flags);
    $ip = $this->_getIP($ip);
    return self::$geoip->lookupOrg($ip);
  }

  public function lookupRegion($ip=null) {
    //$this->filename = dirname(__DIR__) . '/components/GeoIP/GeoLiteCity.dat';
    //self::$geoip = GeoIP::getInstance($this->filename, self::$flags);
    $ip = $this->_getIP($ip);
    return self::$geoip->lookupRegion($ip);
  }

  protected function _getIP($ip=null) {
    if ($ip === null) {
      $ip = Yii::$app->getRequest()->getUserIP();
    }
    return $ip;
  }

}
?>
