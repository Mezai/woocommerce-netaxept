<?php

abstract class Operation
{

    protected function create($params, $path)
    {
        if (!is_array($params)) {
            throw new RequestErrorException("Parameters should be passed as an array");
        }
        $request = new Netaxept_HTTP_Request(Netaxept_Environment::getEnvironment() . $path, $params);

        $transport = new Netaxept_HTTP_Transport();

        $netaxept_request = $transport->create();

        $operation = $netaxept_request->send($request);

        if (!is_object($operation)) {
            throw new Netaxept_ConnectionExeption("No response from webservice");
        }
        return $operation;
    }

    abstract protected function send($params);
}
