<?php

namespace ISMS;

class SMS
{
    
    const SEND_SMS              = 'isms_send.php';
    const BALANCE_CHECK_URL     = 'isms_balance.php';
    const SMS_SCHEDULE          = 'isms_scheduler.php';

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function send(Message $message)
    {
        $message->isValid();

        $params = array(
            'dstno' => $message->getPhoneNumber(),
            'msg' => $message->getBody(),
            'un' => $this->config->username,
            'pwd' => $this->config->password,
        );

        $query = http_build_query($params);

        $url = $this->config->api_url . SMS::SEND_SMS . '?' . $query;

        $code = $this->execute($url);

        switch ($code) {
            case 200:
            case 2000:
                return TRUE;
            
            case 403:
                throw new AuthException;

            case 400:
                throw new BadRequestException;

            default:
                throw new \Exception("HTTP ERROR, Code: $code");
        }
    }
   
    protected function execute($link)
    {
        $http = curl_init($link);
        curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE); 
        $http_result = curl_exec($http);
        $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
        curl_close($http);
        
        return $http_result;
    }
}

class AuthException extends \Exception {}
class BadRequestException extends \Exception {}