<?php


class Netaxept_HTTP_Transport
{
    public static function create()
    {
        return new Netaxept_CurlTransport(new Netaxept_CurlFactory);
    }
}
