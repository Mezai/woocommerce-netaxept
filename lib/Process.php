<?php

class Netaxept_Process
{

  const RELATIVE_PATH = '/Netaxept/Process.aspx?';



  public function create($params)
  {
    if (is_null(Netaxept_Environment::getEnvironment()))
    {
      throw new EnvironmentNotSetException("Environment is not set");
    }

    if (!is_array($params))
    {
      throw new RequestErrorException("Parameters should be passed as an array");
    }

    $environment = Netaxept_Environment::getEnvironment();

    $request_uri = $environment . self::RELATIVE_PATH;

    $requestParams = '';

    foreach ($params as $key => $value) {
      $requestParams .= $key . '=' . $value . '&';
    }

    $request = new Netaxept_HTTP_Request($request_uri . $requestParams);
    $transport = new Netaxept_HTTP_Transport();
    $netaxept_request = $transport->create();
    $process = $netaxept_request->send($request);

    return $process->ResponseCode;
  }

}
