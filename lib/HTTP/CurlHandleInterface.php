<?php

interface Netaxept_CurlHandleInterface
{
    public function setOption($option, $value);

    public function execute();

    public function getInfo();

    public function getError();

    public function close();
}
