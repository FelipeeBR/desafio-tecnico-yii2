<?php

namespace Helper;

class Api extends \Codeception\Module
{
    private $userData = [];

    /**
     * Armazena dados do usuário para uso entre testes
     */
    public function setUserData($key, $value)
    {
        $this->userData[$key] = $value;
    }

    /**
     * Recupera dados do usuário armazenados
     */
    public function getUserData($key)
    {
        return $this->userData[$key] ?? null;
    }

    /**
     * Limpa dados do usuário
     */
    public function clearUserData()
    {
        $this->userData = [];
    }

    /**
     * Login e autenticação automática
     */
    public function login($email = 'example@email.com', $password = 'secret123')
    {
        $this->getModule('REST')->haveHttpHeader('Content-Type', 'application/json');
        $this->getModule('REST')->haveHttpHeader('Accept', 'application/json');

        $this->getModule('REST')->sendPOST('/api/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $this->getModule('REST')->seeResponseCodeIs(200);
        
        $token = $this->getModule('REST')->grabDataFromResponseByJsonPath('$.access_token')[0];
        $userId = $this->getModule('REST')->grabDataFromResponseByJsonPath('$.user.id')[0];

        $this->getModule('REST')->amBearerAuthenticated($token);
        $this->setUserData('userId', $userId);
        $this->setUserData('token', $token);

        return [
            'token' => $token,
            'userId' => $userId
        ];
    }

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