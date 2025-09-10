<?php

use yii\helpers;

class ExpenseCest
{
    public function _before(ApiTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');

        $I->sendPOST('/api/user', [
            'name' => 'johndoe',
            'email' => 'example@email.com',
            'password' => 'secret123'
        ]);

        $I->login('example@email.com', 'secret123');
    }

    public function createExpenseSuccessfully(ApiTester $I) {
        $I->wantTo('criar uma despesa');
        
        $userId = $I->getUserData('userId');

        $I->sendPOST('/api/expense', [
            'user_id'=> $userId,
            'category_id'=> 1,
            'description'=> 'Teste',
            'amount'=> 100.00,
            'date'=> '2025-10-01',
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => true,
        ]);
    }

    public function getExpensesSuccessfully(ApiTester $I) {
        $I->wantTo('listar despesas');
        
        $I->sendGET('/api/expense');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.*');
    }

    public function createExpensesWithInvalidDate(ApiTester $I) {
        $I->wantTo('criar uma despesa com data inválida e receber erro de validação');

        $userId = $I->getUserData('userId');
        
        $I->sendPOST('/api/expense', [
            'user_id'=> $userId,
            'category_id'=> 1,
            'description'=> 'Teste',
            'amount'=> 100.00,
            'date'=> 'invalid-date',
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.date');
    }

    public function createExpensesWithInvalidAmount(ApiTester $I) {
        $I->wantTo('criar uma despesa com valor inválido e receber erro de validação');

        $userId = $I->getUserData('userId');
        
        $I->sendPOST('/api/expense', [
            'user_id'=> $userId,
            'category_id'=> 1,
            'description'=> 'Teste',
            'amount'=> 'invalid-amount',
            'date'=> '2025-10-01',
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.amount');
    }

    public function createExpensesWithInvalidDescription(ApiTester $I) {
        $I->wantTo('criar uma despesa com descrição inválida e receber erro de validação');

        $userId = $I->getUserData('userId');
        
        $I->sendPOST('/api/expense', [
            'user_id'=> $userId,
            'category_id'=> 1,
            'description'=> '',
            'amount'=> 100.00,
            'date'=> '2025-10-01',
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.description');
    }

    public function createExpensesWithInvalidCategoryId(ApiTester $I) {
        $I->wantTo('criar uma despesa com categoria inválida e receber erro de validação');

        $userId = $I->getUserData('userId');
        
        $I->sendPOST('/api/expense', [
            'user_id'=> $userId,
            'category_id'=> 0,
            'description'=> 'Teste',
            'amount'=> 100.00,
            'date'=> '2025-10-01',
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.errors.category_id');
    }

    public function updateExpenseSuccessfully(ApiTester $I) 
    {
        $I->wantTo('atualizar uma despesa');

        $userId = $I->getUserData('userId');
        
        $I->sendPOST('/api/expense', [
            'user_id' => $userId,
            'category_id' => 1,
            'description' => 'Teste de update',
            'amount' => 50.00,
            'date' => '2024-01-01',
        ]);
        
        $I->seeResponseCodeIs(201);
        $expenseId = $I->grabDataFromResponseByJsonPath('$.expense.id')[0];
        
        $I->sendPut("/api/expense/{$expenseId}", [
            'category_id' => 2,
            'description' => 'atualizado', 
            'amount' => 75.00, 
            'date' => '2024-01-15', 
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => true,
        ]);
    }

    public function deleteExpenseSuccessfully(ApiTester $I) 
    {
        $I->wantTo('deletar uma despesa');

        $userId = $I->getUserData('userId');
        
        $I->sendPOST('/api/expense', [
            'user_id' => $userId,
            'category_id' => 1,
            'description' => 'Teste de delete',
            'amount' => 50.00,
            'date' => '2024-01-01',
        ]);
        
        $I->seeResponseCodeIs(201);
        $expenseId = $I->grabDataFromResponseByJsonPath('$.expense.id')[0];
        
        $I->sendDelete("/api/expense/{$expenseId}");

        $I->seeResponseCodeIs(204);
    }
}