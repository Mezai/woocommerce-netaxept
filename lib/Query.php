<?php

class Netaxept_Query
{
    const RELATIVE_PATH = '/Netaxept/Query.aspx?';

    public function create($params)
    {
        if (!is_array($params)) {
            throw new RequestErrorException("Parameters should be passed as an array");
        }
        $environment = Netaxept_Environment::getEnvironment();
        $request_uri = $environment . self::RELATIVE_PATH;
        $request = new Netaxept_HTTP_Request($request_uri, $params);
        $transport = new Netaxept_HTTP_Transport();
        $netaxept_request = $transport->create();
        $query = $netaxept_request->send($request);

        if (!is_object($query)) {
          throw new Netaxept_ConnectionExeption("No response from webservice");
        }

        return $query;
    }
}
