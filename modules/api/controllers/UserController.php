<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use app\modules\api\models\User;
use app\modules\api\services\PasswordHasherService;
use app\modules\api\services\UserService;

class UserController extends ActiveController
{
    public $modelClass = User::class;
    
    public function init() {
        parent::init();
        
        
        $passwordHasher = new PasswordHasherService();
        User::setPasswordHasher($passwordHasher);
    }

    public function actions() {
        $actions = parent::actions();
        
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate() {
        $data = Yii::$app->request->getBodyParams();
        $result = Yii::$container->get(UserService::class)->createUser($data);

        if ($result['success']) {
            Yii::$app->response->setStatusCode(201);
            return [
                'success' => true,
                'data' => $result['user'],
            ];
        }

        Yii::$app->response->setStatusCode(422);
        return [
            'success' => false,
            'errors' => $result['errors'],
        ];
    }
}