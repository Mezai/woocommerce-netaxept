<?php

class Netaxept_CurlHandle implements Netaxept_CurlHandleInterface
{
    private $handle = null;

    public function __construct()
    {
        if (!extension_loaded('curl')) {
            throw new RuntimeException('Curl extension is required');
        }

        $this->handle = curl_init();
    }

    public function setOption($option, $value)
    {
        return curl_setopt($this->handle, $option, $value);
    }

    public function execute()
    {
        return curl_exec($this->handle);
    }

    public function getInfo()
    {
        return curl_getinfo($this->handle);
    }

    public function getError()
    {
        return curl_error($this->handle);
    }

    public function close()
    {
        return curl_close($this->handle);
    }
}
