<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmailQueue;

/**
 * EmailQueueSearch represents the model behind the search form about `app\models\EmailQueue`.
 */
class EmailQueueSearch extends EmailQueue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'emailId', 'type', 'opened_num', 'start_at', 'end_at', 'status'], 'integer'],
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
        $query = EmailQueue::find();

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
            'emailId' => $this->emailId,
            'type' => $this->type,
            'opened_num' => $this->opened_num,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
