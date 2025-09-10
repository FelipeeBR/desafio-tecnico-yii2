<?php

namespace app\modules\api\controllers;

use app\modules\api\services\ExpenseService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class ExpenseController extends ActiveController
{
    public $modelClass = 'app\modules\api\models\Expense';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];

        return $behaviors;
    }

    public function actions() {
        $actions = parent::actions();
        
        unset($actions['index'], $actions['create'], $actions['update'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionIndex() {
        $userId = Yii::$app->user->id;

        return new ActiveDataProvider([
            'query' => $this->modelClass::find()->where(['user_id' => $userId]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    public function actionCreate() {
        $data = Yii::$app->request->getBodyParams();
        $data['user_id'] = Yii::$app->user->id;
        $result = Yii::$container->get(ExpenseService::class)->createExpense($data);
        
        if($result['success']) {
            Yii::$app->response->setStatusCode(201);
            return [
                'success' => true,
                'expense' => $result['expense'],
                '_links' => $result['expense']->getLinks(),
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return [
            'success' => false,
            'errors' => $result['errors'],
        ];
    }

    public function actionUpdate($id) {
        $data = Yii::$app->request->getBodyParams();
        $data['user_id'] = Yii::$app->user->id;
        $result = Yii::$container->get(ExpenseService::class)->updateExpense($id, $data);
        
        if($result['success']) {
            Yii::$app->response->setStatusCode(200);
            return [
                'success' => true,
                'expense' => $result['expense'],
                '_links' => $result['expense']->getLinks(),
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return [
            'success' => false,
            'errors' => $result['errors'],
        ];
    }

    public function actionDelete($id) {
        $result = Yii::$container->get(ExpenseService::class)->deleteExpense($id);
        
        if($result['success']) {
            Yii::$app->response->setStatusCode(204);
            return [
                'success' => true,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return [
            'success' => false,
            'errors' => $result['errors'],
        ];
    }

    public function actionView($id) {
        $userId = Yii::$app->user->id;
        $expense = $this->modelClass::find()->where(['id' => $id, 'user_id' => $userId])->one();
        if($expense) {
            Yii::$app->response->setStatusCode(200);
            return [
                'success' => true,
                'expense' => $expense,
                '_links' => $expense->getLinks(),
            ];
        }
        Yii::$app->response->setStatusCode(404);
        return [
            'success' => false,
            'errors' => ['general' => ['Despesa nao encontrada']],
        ];
    }
}