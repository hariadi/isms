<?php

namespace ISMS;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testValid10Digits()
    {
        $msg = new Message('7112345678', 'text');
        $this->assertTrue($msg->isValid());
    }

    public function testValid11Digits()
    {
        $msg = new Message('11123456789', 'text');
        $this->assertTrue($msg->isValid());
    }

    /**
     * @expectedException ISMS\MessageException
     * @expectedExceptionMessage Unknown DDD code (00)
     * @expectedExceptionCode 10
     */
    public function testInvalidDDD()
    {
       $msg = new Message("0012345678", "text");
       $msg->isValid();
    }

    /**
     * @expectedException ISMS\MessageException
     * @expectedExceptionMessage Wrong phone number size
     * @expectedExceptionCode 20
     */
    public function testInvalidNumber()
    {
       $msg = new Message("11123458", "text");
       $msg->isValid();
    }

    /**
     * @expectedException ISMS\MessageException
     * @expectedExceptionMessage Wrong phone number size
     * @expectedExceptionCode 20
     */
    public function testInvalidNumberBig()
    {
       $msg = new Message("21123456789", "text");
       $msg->isValid();
    }

    /**
     * @expectedException ISMS\MessageException
     * @expectedExceptionMessage Message too long
     * @expectedExceptionCode 30
     */
    public function testInvalidBodyBig()
    {
       $msg = new Message("2112345678", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.");
       $msg->isValid();
    }
}