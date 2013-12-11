<?php

namespace ISMS;

class SMS
{
    const VERSION = '0.1.0';
    const HOST                  = 'https://isms.com.my/';
    const SEND                  = 'isms_send.php?';
    const BALANCE_CHECK_URL     = 'isms_balance.php?';
    const SMS_SCHEDULE          = 'isms_scheduler.php?';

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


        $url = $this->config->api_url . SMS::SEND;

        $code = $this->execute($url, $params);

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
   
    protected function execute($link, $params = array())
    {
        // Use SSL: http://www.php.net/manual/en/function.curl-setopt-array.php#89850
        $ch = curl_init();
        $options = array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_URL            => $link,
            CURLOPT_HEADER         => false,
            CURLOPT_ENCODING       => "",
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false,
        );
        curl_setopt_array( $ch, $options );
        $result = curl_exec( $ch );
        curl_close( $ch );

        return $result;
    }
}

class AuthException extends \Exception {}
class BadRequestException extends \Exception {}