<?php
class Netaxept_Register
{
    const RELATIVE_PATH = '/Netaxept/Register.aspx?';


    /*Creates a register request
    * @param array request parameters
    *
    * return request obj || throws ConnectionException
    */

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

        $register = $netaxept_request->send($request);

        if (!isset($register->TransactionId) || !is_object($register)) {
            throw new Netaxept_ConnectionExeption("No response from webservice");
        }

        return $register;
    }
}
