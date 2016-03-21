<?php

class Netaxept_Process extends Operation
{
    const RELATIVE_PATH = '/Netaxept/Process.aspx?';

    public function send($params)
    {
      return $this->create($params, self::RELATIVE_PATH);
    }
}
