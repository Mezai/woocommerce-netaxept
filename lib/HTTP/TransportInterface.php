<?php

interface Netaxept_TransportInterface
{
  public function setTimeout($timeout);

  public function getTimeout();

  public function send(Netaxept_HTTP_Request $request);

  public function createRequest($request);
}
