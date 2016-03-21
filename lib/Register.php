<?php
class Netaxept_Register extends Operation
{
    const RELATIVE_PATH = '/Netaxept/Register.aspx?';

    public function send($params)
    {
        return $this->create($params, self::RELATIVE_PATH);
    }
}
