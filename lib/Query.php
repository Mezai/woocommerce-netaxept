<?php

class Netaxept_Query extends Operation
{
    const RELATIVE_PATH = '/Netaxept/Query.aspx?';

    public function send($params)
    {
        return $this->create($params, self::RELATIVE_PATH);
    }
}
