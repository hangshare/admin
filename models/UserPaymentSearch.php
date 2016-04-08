<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserPayment;

/**
 * UserPaymentSearch represents the model behind the search form about `app\models\UserPayment`.
 */
class UserPaymentSearch extends UserPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'start_date', 'end_date'], 'integer'],
            [['price'], 'number'],
            [['payer_email', 'planId', 'transactionId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserPayment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
            'price' => $this->price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $query->andFilterWhere(['like', 'payer_email', $this->payer_email])
            ->andFilterWhere(['like', 'planId', $this->planId])
            ->andFilterWhere(['like', 'transactionId', $this->transactionId]);

        return $dataProvider;
    }
}
