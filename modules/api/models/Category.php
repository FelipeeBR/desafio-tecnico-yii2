<?php

namespace app\modules\api\models;

use yii\db\ActiveRecord;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Category extends ActiveRecord implements Linkable
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
            [['name'], 'unique', 'message' => 'Esta categoria já existe.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getLinks(): array
    {
        return [
            Link::REL_SELF => Url::to(['/api/category/view', 'id' => $this->id], true),
            'update' => Url::to(['/api/category/update', 'id' => $this->id], true),
            'delete' => Url::to(['/api/category/delete', 'id' => $this->id], true),
        ];
    }
}