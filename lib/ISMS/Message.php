<?php

namespace ISMS;

class Message
{
    private $DDD = array(
        11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 24, 27, 28,
        31, 32, 33, 34, 35, 37, 38, 41, 42, 43, 44, 45, 46, 47,
        48, 49, 51, 53, 54, 55, 61, 62, 63, 64, 65, 66, 67, 68,
        69, 71, 73, 74, 75, 77, 79, 81, 82, 83, 84, 85, 86, 87,
        88, 89, 91, 92, 93, 94, 95, 96, 97, 98, 99);

    private $NINE_DIGITS_DDD = array(11);

    private $phone_number;
    private $body;

    public function __construct($phone_number, $body)
    {
        $this->phone_number = $phone_number;
        $this->body         = $body;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function isValid()
    {
        $this->checkNumber();
        $this->checkBody();
        return TRUE;
    }

    private function checkNumber()
    {
        $ddd    = substr($this->phone_number, 0, 2);
        $number = substr($this->phone_number, 2);

        if (!in_array($ddd, $this->DDD)) {
            throw new MessageException("Unknown DDD code ({$ddd})", 10);
        }

        if (in_array($ddd, $this->NINE_DIGITS_DDD)) {
            if (!in_array(strlen($number), array(8, 9))) {
                throw new MessageException("Wrong phone number size", 20);
            }
        }
        else {
            if (strlen($number) != 8) {
                throw new MessageException("Wrong phone number size", 20);
            }
        }
        return TRUE;
    }

    private function checkBody()
    {
        if (strlen($this->body) > 140) {
            throw new MessageException("Message too long", 30);
        }
        return TRUE;
    }
}

class MessageException extends \Exception {}