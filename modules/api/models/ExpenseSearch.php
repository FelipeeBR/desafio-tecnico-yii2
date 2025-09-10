<?php

namespace app\modules\api\models;

use app\modules\api\models\Expense;
use Yii;
use yii\data\ActiveDataProvider;

class ExpenseSearch extends Expense
{
    public $month;
    public $year;
    public $min_amount;
    public $max_amount;

    public function rules()
    {
        return [
            [['category_id', 'month', 'year'], 'integer'],
            [['min_amount', 'max_amount'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Expense::find()->where(['user_id' => \Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => ['date' => SORT_DESC],
            ],
        ]);

        $this->load($params, '');

        if(!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if($this->category_id) {
            $query->andWhere(['category_id' => $this->category_id]);
        }

        if($this->month && $this->year) {
            $start = sprintf('%04d-%02d-01', $this->year, $this->month);
            $end   = date('Y-m-t', strtotime($start));
            $query->andWhere(['between', 'date', $start, $end]);
        } else if($this->year) {
            $query->andWhere(['between', 'date', "{$this->year}-01-01", "{$this->year}-12-31"]);
        }

        if($this->min_amount !== null) {
            $query->andWhere(['>=', 'amount', $this->min_amount]);
        }
        
        if($this->max_amount !== null) {
            $query->andWhere(['<=', 'amount', $this->max_amount]);
        }
        return $dataProvider;
    }
}

