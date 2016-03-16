<?php

class Netaxept_Environment
{
  const TEST = 'https://test.epayment.nets.eu';

  const LIVE = 'https://epayment.nets.eu';

  private static $environment;

  public static function setEnvironment($environment = self::TEST)
  {
    self::$environment = $environment;
  }

  public static function getEnvironment()
  {
    return self::$environment;
  }
}
