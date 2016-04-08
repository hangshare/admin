<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PostView;

/**
 * SearchPostView represents the model behind the search form about `app\models\PostView`.
 */
class SearchPostView extends PostView {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'userId', 'postId'], 'integer'],
            [['ip', 'ip_info', 'hash', 'user_agent', 'created_at'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = PostView::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
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
            'postId' => $this->postId,
            'price' => $this->price,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
                ->andFilterWhere(['like', 'ip_info', $this->ip_info])
                ->andFilterWhere(['like', 'hash', $this->hash])
                ->andFilterWhere(['like', 'user_agent', $this->user_agent]);

        return $dataProvider;
    }

}
