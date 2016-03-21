<?php

class Netaxept_Environment
{

  public static $mode;

  public static function setEnvironment($mode = TEST)
  {
    self::$mode = $mode;
  }

  public static function getEnvironment()
  {
    return self::$mode;
  }
}
