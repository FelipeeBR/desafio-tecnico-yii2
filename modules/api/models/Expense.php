<?php

namespace app\modules\api\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * This is the model class for table "expenses".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property float $amount
 * @property string $description
 * @property string $date
 */
class Expense extends ActiveRecord implements Linkable
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expenses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'amount'], 'required', 'message' => '{attribute} nao pode ficar em branco.'],
            [['user_id', 'category_id'], 'integer'],
            [['amount'], 'number'],
            [['amount'], 'required', 'message' => '{attribute} nao pode ficar em branco.'],
            [['date'], 'required', 'message' => '{attribute} nao pode ficar em branco.'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['description'], 'string', 'max' => 255, 'message' => '{attribute} nao pode ter mais de 255 caracteres.'],
            [['description'], 'required', 'message' => '{attribute} nao pode ficar em branco.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'amount' => 'Amount',
            'description' => 'Description',
            'date' => 'Date',
        ];
    }

    public function getLinks(): array {
        return [
            Link::REL_SELF => Url::to(['/api/expense/view', 'id' => $this->id], true),
            'update' => Url::to(['/api/expense/update', 'id' => $this->id], true),
            'delete' => Url::to(['/api/expense/delete', 'id' => $this->id], true),
        ];
    }
}