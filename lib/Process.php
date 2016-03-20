<?php

class Netaxept_Process
{

    const RELATIVE_PATH = '/Netaxept/Process.aspx?';

    public function create($params)
    {
        if (is_null(Netaxept_Environment::getEnvironment())) {
            throw new EnvironmentNotSetException("Environment is not set");
        }

        if (!is_array($params)) {
            throw new RequestErrorException("Parameters should be passed as an array");
        }

        $environment = Netaxept_Environment::getEnvironment();
        $request = new Netaxept_HTTP_Request($environment . self::RELATIVE_PATH, $params);
        $transport = new Netaxept_HTTP_Transport();
        $netaxept_request = $transport->create();
        $process = $netaxept_request->send($request);

        if (!is_object($process)) {
          throw new Netaxept_ConnectionExeption("No response from webservice");
        }

        return $process;
    }
}
