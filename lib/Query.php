<?php

class Netaxept_Query
{
  const RELATIVE_PATH = '/Netaxept/Query.aspx?';



  public function create($params)
  {
      if (!is_array($params))
      {
        throw new RequestErrorException('Provided params is not of type array');
      }

      $request_uri = self::RELATIVE_PATH;

      $requestParams = '';

      foreach ($params as $key => $value) {
        $requestParams = $key . '=' . $value;
      }

  }
}
