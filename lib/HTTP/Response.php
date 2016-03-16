<?php

class Netaxept_HTTP_Response
{
  //http resp int
  protected $status;

  protected $request;

  protected $headers;

  protected $data;

  public function __construct(Netaxept_HTTP_Request $request, array $headers, $status, $data)
  {
    $this->request = $request;
    $this->headers = array();
    $this->status = $status;
    $this->data = $data;
    foreach ($headers as $key => $value) {
        $this->headers[$key] = $value;
    }
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function getHeaders()
  {
    return $this->headers;
  }

  public function getRequest()
  {
    return $this->request;
  }

  public function getHeader($name)
  {
    if (!array_key_exists($name, $this->headers))
    {
      return null;
    }

    return $this->headers[$name];
  }

  public function getData()
  {
    return $this->data;
  }
}
