<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User {

    public $profile_views, $post_total_views, $post_count, $available_amount;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'gender', 'country', 'type'], 'integer'],
            [['name', 'email', 'image', 'paypal_email', 'password_hash',
            'profile_views', 'post_total_views', 'post_count', 'available_amount',
            'bio', 'dob', 'phone', 'password_reset_token', 'scId', 'created_at', 'gender', 'plan'], 'safe'],
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
        $query = User::find();
        $query->joinWith(['userStats']);
        $pageSize = isset($_GET['ex']) ? 5000 : 20;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id', 'name', 'email', 'created_at', 'paypal_email', 'plan', 'gender',
                'profile_views' => [
                    'asc' => ['user_stats.profile_views' => SORT_ASC],
                    'desc' => ['user_stats.profile_views' => SORT_DESC],
                    'label' => 'Post Date',
                    'default' => SORT_DESC
                ],
                'total_amount' => [
                    'asc' => ['user_stats.available_amount' => SORT_ASC],
                    'desc' => ['user_stats.available_amount' => SORT_DESC],
                    'label' => 'Post Date',
                    'default' => SORT_DESC
                ],
                'available_amount' => [
                    'asc' => ['user_stats.available_amount' => SORT_ASC],
                    'desc' => ['user_stats.available_amount' => SORT_DESC],
                    'label' => 'Post Date',
                    'default' => SORT_DESC
                ],
                'cantake_amount' => [
                    'asc' => ['user_stats.cantake_amount' => SORT_ASC],
                    'desc' => ['user_stats.cantake_amount' => SORT_DESC],
                    'label' => 'Post Date',
                    'default' => SORT_DESC
                ],
                'post_count' => [
                    'asc' => ['user_stats.post_count' => SORT_ASC],
                    'desc' => ['user_stats.post_count' => SORT_DESC],
                    'label' => 'Post Date',
                    'default' => SORT_DESC
                ],
                'post_total_views' => [
                    'asc' => ['user_stats.post_total_views' => SORT_ASC],
                    'desc' => ['user_stats.post_total_views' => SORT_DESC],
                    'label' => 'Post Date',
                    'default' => SORT_DESC
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'country' => $this->country,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'plan' => $this->plan,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'image', $this->image])
                ->andFilterWhere(['like', 'paypal_email', $this->paypal_email])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'bio', $this->bio])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
                ->andFilterWhere(['like', 'scId', $this->scId]);

        return $dataProvider;
    }

}
