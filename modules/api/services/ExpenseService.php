<?php

namespace app\modules\api\services;

use app\modules\api\models\Expense;

class ExpenseService
{
    public function createExpense(array $data): array
    {
        $expense = new Expense();
        $expense->load($data, '');

        if($expense->validate()) {
            if($expense->save()) {
                return [
                    'success' => true,
                    'expense' => $expense,
                ];
            }
            return [
                'success' => false,
                'errors' => ['general' => ['Nao foi possivel salvar a despesa']],
            ];
        }

        return [
            'success' => false,
            'errors' => $expense->errors,
        ];
    }

    public function updateExpense($id, array $data): array
    {
        $userId = \Yii::$app->user->id;
        $expense = Expense::find()
            ->where(['id' => $id, 'user_id' => $userId])
            ->one();

        if(!$expense) {
            return [
                'success' => false,
                'errors' => ['general' => ['Ocorreu um erro ao alterar os dados da despesa']],
            ];
        }

        $expense->load($data, '');

        if($expense->validate()) {
            if($expense->save()) {
                return [
                    'success' => true,
                    'expense' => $expense,
                ];
            }
            return [
                'success' => false,
                'errors' => ['general' => ['Nao foi possivel alterar os dados da despesa']],
            ];
        }

        return [
            'success' => false,
            'errors' => $expense->errors,
        ];
    }

    public function deleteExpense($id): array
    {
        $userId = \Yii::$app->user->id;
        $expense = Expense::find()
            ->where(['id' => $id, 'user_id' => $userId])
            ->one();

        if(!$expense) {
            return [
                'success' => false,
                'errors' => ['general' => ['Ocorreu um erro ao excluir a despesa']],
            ];
        }

        if($expense->delete()) {
            return [
                'success' => true,
            ];
        }
        return [
            'success' => false,
            'errors' => ['general' => ['Nao foi possivel excluir a despesa']],
        ];
    }
}