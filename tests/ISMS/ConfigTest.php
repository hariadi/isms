<?php

namespace ISMS;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->config = new Config;
    }

    public function testUsername()
    {
        $username = 'isms';
        $this->config->username = $username;
        $this->assertEquals($username, $this->config->username);
    }

    public function testPassword()
    {
        $password = 'isms';
        $this->config->password = $password;
        $this->assertEquals($password, $this->config->password);
    }

    public function testApiUrl()
    {
        $api_url = 'isms';
        $this->config->api_url = $api_url;
        $this->assertEquals($api_url, $this->config->api_url);
    }
}