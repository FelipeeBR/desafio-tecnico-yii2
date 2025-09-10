<?php

namespace app\modules\api\services;

use app\modules\api\models\User;
use yii\web\IdentityInterface;

class UserIdentityService implements IdentityInterface
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public static function findIdentity($id) {
        $user = User::findOne($id);
        return $user ? new self($user) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $user = User::findOne(['access_token' => $token]);
        return $user ? new self($user) : null;
    }

    public static function findByUsername($username) {
        $user = User::findOne(['name' => $username]);
        return $user ? new self($user) : null;
    }

    public function getId() {
        return $this->user->id;
    }

    public function getAuthKey() {
        return $this->user->auth_key;
    }

    public function validateAuthKey($auth_key) {
        return $this->user->auth_key === $auth_key;
    }

    public function validatePassword($password) {
        return $this->user->validatePassword($password);
    }

    public function getUser(): User {
        return $this->user;
    }
}