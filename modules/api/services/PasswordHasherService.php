<?php

namespace app\modules\api\services;

use Yii;

class PasswordHasherService implements PasswordHasherInterface {
    public function hash(string $password): string {
        return Yii::$app->security->generatePasswordHash($password);
    }

    public function validate(string $password, string $hash): bool {
        return Yii::$app->security->validatePassword($password, $hash);
    }
    public function verify(string $password, string $hash): bool {
        return Yii::$app->security->validatePassword($password, $hash);
    }
}