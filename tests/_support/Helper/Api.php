<?php

namespace Helper;

class Api extends \Codeception\Module
{
    public function seeResponseIsJson()
    {
        $response = $this->getModule('REST')->response;
        \PHPUnit\Framework\Assert::assertJson($response);
    }

    public function seeResponseContainsJson($json = [])
    {
        $response = $this->getModule('REST')->response;
        \PHPUnit\Framework\Assert::assertJson($response);
        $responseArray = json_decode($response, true);
        
        $actualJson = array_intersect_key($responseArray, $json);
        \PHPUnit\Framework\Assert::assertEquals($json, $actualJson);
    }
}