<?php

class UserCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function createUserSuccessfully(ApiTester $I)
    {
        $I->wantTo('criar um usuário válido');

        $random = uniqid();
        $email = "user{$random}@example.com";

        $I->sendPOST('/api/user', [
            'name' => 'johndoe',
            'email' => $email,
            'password' => 'secret123'
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => true,
        ]);
    }

    public function createUserWithEmptyEmail(ApiTester $I)
    {
        $I->wantTo('tentar criar um usuário com email vazio e receber erro de validação');

        $I->sendPOST('/api/user', [
            'name' => 'johndoe',
            'email' => '',
            'password' => 'secret123',
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.email');
    }

    public function createUserWithInvalidEmail(ApiTester $I)
    {
        $I->wantTo('tentar criar um usuário com email inválido e receber erro de validação');

        $I->sendPOST('/api/user', [
            'name' => 'johndoe',
            'email' => 'invalid-email',
            'password' => 'secret123',
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.email');
    }

    public function createUserWithEmptyPassword(ApiTester $I)
    {
        $I->wantTo('tentar criar um usuário com senha vazia e receber erro de validação');

        $I->sendPOST('/api/user', [
            'name' => 'johndoe',
            'email' => 'OqK3d@example.com',
            'password' => '',
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.password');
    }

    public function createUserWithEmptyName(ApiTester $I)
    {
        $I->wantTo('tentar criar um usuário com nome vazio e receber erro de validação');

        $I->sendPOST('/api/user', [
            'name' => '',
            'email' => 'OqK3d@example.com',
            'password' => 'secret123',
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.name');
    }
}