<?php

class AuthCest 
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
        // Cria um usuário para testes
        $I->sendPOST('/api/user', [
            'name' => 'johndoe',
            'email' => 'example@email.com',
            'password' => 'secret123'
        ]);
    }

    public function loginSuccessfully(ApiTester $I)
    {
        $I->wantTo('logar com sucesso');    

        $I->sendPOST('/api/auth/login', [
            'email' => 'example@email.com',
            'password' => 'secret123'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => true,
        ]);
    }

    public function loginWithEmptyEmail(ApiTester $I)
    {
        $I->wantTo('tentar logar com email vazio e receber erro de validação');

        $I->sendPOST('/api/auth/login', [
            'email' => '',
            'password' => 'secret123'
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.email');
    }

    public function loginWithEmptyPassword(ApiTester $I)
    {
        $I->wantTo('tentar logar com senha vazia e receber erro de validação');

        $I->sendPOST('/api/auth/login', [
            'email' => 'example@email.com',
            'password' => ''
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.password');
    }

    public function loginWithInvalidEmail(ApiTester $I)
    {
        $I->wantTo('tentar logar com email inválido e receber erro de validação');

        $I->sendPOST('/api/auth/login', [
            'email' => 'invalid-email',
            'password' => 'secret123'
        ]);

        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.message');
    }
}