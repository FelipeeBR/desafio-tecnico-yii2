<?php

namespace app\modules\api\models;

use app\modules\api\services\PasswordHasherInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 */

class User extends ActiveRecord implements Linkable
{
    private static $passwordHasher;

    public static function setPasswordHasher(PasswordHasherInterface $passwordHasher): void
    {
        self::$passwordHasher = $passwordHasher;
    }

    public static function tableName()
    {
        return 'users';
    }

    public function rules(): array
    {
        return [
            [['name', 'email', 'password'], 'required', 'message' => '{attribute} não pode ficar em branco.'],
            [['name', 'email', 'password'], 'string', 'max' => 45],
            [['auth_key', 'access_token'], 'string', 'max' => 255],
            [['email'], 'unique', 'message' => 'Este email já está cadastrado.'],
            ['email', 'email', 'message' => 'Email inválido.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password'], $fields['auth_key']);
        return $fields;
    }

    public function extraFields() {
        return ['access_token'];
    }

    public function beforeSave($insert): bool
    {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->generateAuthKey();
                $this->generateAccessToken();
                if($this->isAttributeChanged('password')) {
                    $this->setPassword($this->password);
                }
            } else {
                if($this->isAttributeChanged('password')) {
                    $this->setPassword($this->password);
                }
            }
            return true;
        }
        return false;
    }

    public function setPassword(string $password): void
    {
        if(self::$passwordHasher) {
            $this->password = self::$passwordHasher->hash($password);
        } else {
            $this->password = Yii::$app->security->generatePasswordHash($password);
        }
    }

    public function validatePassword(string $password): bool
    {
        if(self::$passwordHasher) {
            return self::$passwordHasher->verify($password, $this->password);
        } else {
            return Yii::$app->security->validatePassword($password, $this->password);
        }
    }

    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken(): void
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    public function getLinks(): array {
        return [
            Link::REL_SELF => Url::to(['/api/user/view', 'id' => $this->id], true),
            'update' => Url::to(['/api/user/update', 'id' => $this->id], true),
            'delete' => Url::to(['/api/user/delete', 'id' => $this->id], true),
        ];
    }
}