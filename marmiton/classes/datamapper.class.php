<?php

class DataMapper
{
  public static $db;
  public static function init($db)
  {
    self::$db = $db;
  }

  function __destruct() {}
}
