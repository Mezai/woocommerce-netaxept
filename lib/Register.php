<?php
class Netaxept_Register
{
    const RELATIVE_PATH = '/Netaxept/Register.aspx?';

    public function create($params)
    {
        if (is_null(Netaxept_Environment::getEnvironment())) {
            throw new EnvironmentNotSetException("Environment is not set");
        }

        if (!is_array($params)) {
            throw new RequestErrorException("Parameters should be passed as an array");
        }

        $environment = Netaxept_Environment::getEnvironment();
        $request_uri = $environment . self::RELATIVE_PATH;
        $counter = 1;
        $requestParams = '';

        foreach ($params as $key => $value) {
            urlencode($value);
            $requestParams .= ($counter == 1) ? "$key=$value" : "&$key=$value";
            $counter++;
        }

        $request = new Netaxept_HTTP_Request($request_uri . $requestParams);
        $transport = new Netaxept_HTTP_Transport();
        $netaxept_request = $transport->create();
        $transactionId = $netaxept_request->send($request);

        return $transactionId->TransactionId;
    }
}
