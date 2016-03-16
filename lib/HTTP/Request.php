<?php

class Netaxept_HTTP_Request
{
    protected $url;

    protected $method;

    protected $headers;

    protected $data;

    public function __construct($url)
    {
        $this->url = $url;
        $this->method = 'GET';
        $this->headers = array();
        $this->data = '';
    }

    public function setEnvironment($url)
    {
        $this->$url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setMethod($method)
    {
        return strtoupper($method);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = (String)$value;
    }

    public function getHeader($name)
    {
        if (!array_key_exists($name)) {
            return null;
        }

        return $this->headers[$name];
    }

  //get all headers

  public function getHeaders()
  {
      return $this->headers;
  }

  //Set data

  public function setData($data)
  {
      $this->data = $data;
  }

    public function getData()
    {
        return $this->data;
    }
}
