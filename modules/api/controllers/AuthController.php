<?php

namespace app\modules\api\controllers;

use app\modules\api\models\User;
use yii\rest\Controller;
use yii\web\Response;
use Yii;


class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionLogin()
    {
        $body = Yii::$app->request->post();

        if(empty($body['email']) || empty($body['password'])) {
            Yii::$app->response->setStatusCode(422);
            return [
                'success' => false,
                'errors' => [
                    'email' => empty($body['email']) ? ['O campo email é obrigatório.'] : [],
                    'password' => empty($body['password']) ? ['O campo senha é obrigatório.'] : [],
                ],
            ];
        }

        $user = User::findOne(['email' => $body['email'] ?? null]);
        if(!$user || !$user->validatePassword($body['password'] ?? '')) {
            Yii::$app->response->setStatusCode(401);
            return [
                'success' => false,
                'message' => 'Invalid email or password',
            ];
        }

        Yii::$app->response->setStatusCode(200);
        return [
            'success' => true,
            'access_token' => $user->access_token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            '_links' => $user->getLinks(),
        ];
    }
}