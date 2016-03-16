<?php

class Netaxept_CurlTransport implements Netaxept_TransportInterface
{
  const TIMEOUT = 10;

  protected $curl;

  protected $timeout;

  protected $options;

  public function __construct(Netaxept_CurlFactory $curl)
  {
    $this->curl = $curl;
    $this->timeout = self::TIMEOUT;
    $this->options = array();

  }

  // Set timeout

  public function setTimeout($timeout)
  {
    $this->timeout = (int)$timeout;
  }

  public function getTimeout()
  {
    return $this->timeout;
  }

  public function send(Netaxept_HTTP_Request $request)
  {
    $curl = $this->curl->handle();

    if ($curl === false)
    {
      throw new RuntimeException('Failed to initalize curl handle');
    }

    $url = $request->getUrl();

    $curl->setOption(CURLOPT_URL, $url);

    $method = $request->getMethod();
    if ( $method == 'POST')
    {
      $curl->setOption(CURLOPT_POST, true);
      $curl->setOption(CURLOPT_POSTFIELDS, $request->getData());
    }

    $requestHeaders = array();
    foreach ($request->getHeaders() as $option => $value) {
      $requestHeaders[] = $option . ': ' . $value;
    }


    $curl->setOption(CURLOPT_HTTPHEADER, $requestHeaders);
    $curl->setOption(CURLOPT_RETURNTRANSFER, true);
    $curl->setOption(CURLOPT_TIMEOUT, $this->timeout);
    $curl->setOption(CURLOPT_CONNECTTIMEOUT, $this->timeout);

    $curl->setOption(CURLOPT_SSL_VERIFYPEER, true);
    $curl->setOption(CURLOPT_SSL_VERIFYHOST, 2);


    foreach ($this->options as $key => $value) {
      $curl->setOption($option, $value);
    }
    $payload = $curl->execute();
    $info = $curl->getInfo();
    $error = $curl->getError();

    $curl->close();

    if ($payload === false || $info === false)
    {
      throw new Netaxept_ConnectionExeption("Connection to '{$url}' failed: {$error}");
    }


    $response = simplexml_load_string($payload);

    if (isset($response->Error))
    {
      die('Nets error' . $response->Error->Message);
    }

    return $response;

  }

  public function createRequest($url)
  {
    return new Netaxept_HTTP_Request($url);
  }


}
