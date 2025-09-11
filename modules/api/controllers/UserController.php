<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use app\modules\api\models\User;
use app\modules\api\services\PasswordHasherService;
use app\modules\api\services\UserService;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    
    public function init() {
        parent::init();
        
        
        $passwordHasher = new PasswordHasherService();
        User::setPasswordHasher($passwordHasher);
    }

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['create'],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];

        return $behaviors;
    }

    public function actions() {
        $actions = parent::actions();
        
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate() {
        $data = Yii::$app->request->getBodyParams();
        $result = Yii::$container->get(UserService::class)->createUser($data);

        if($result['success']) {
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

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        return $dataProvider->getModels();
    }
}