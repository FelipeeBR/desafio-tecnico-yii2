<?php

namespace app\modules\api\services;

use app\modules\api\models\User;

class UserService
{
    public function createUser(array $data): array
    {
        $user = new User();
        $user->load($data, '');

        if($user->validate()) {
            if($user->save()) {
                return [
                    'success' => true,
                    'user' => $user,
                ];
            }
            return [
                'success' => false,
                'errors' => ['general' => ['Não foi possível salvar o usuário']],
            ];
        }

        return [
            'success' => false,
            'errors' => $user->errors,
        ];
    }
}