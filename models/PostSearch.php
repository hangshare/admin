<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;

/**
 * PostSearch represents the model behind the search form about `app\models\Post`.
 * @property mixed urlTitle
 * @property mixed featured
 */
class PostSearch extends Post
{

    public $user, $views;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'type', 'featured'], 'integer'],
            [['cover', 'title', 'created_at', 'featured', 'user', 'urlTitle'], 'safe'],
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
        $query = Post::find();
        $query->joinWith([
            'user',
            'stats']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    'label' => 'ID',
                    'default' => SORT_DESC
                ],
                'user' => [
                    'asc' => ['user.name' => SORT_ASC],
                    'desc' => ['user.name' => SORT_DESC],
                    'label' => 'User Name',
//                    'default' => SORT_ASC
                ],
                'title' => [
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_DESC],
                    'label' => 'Title',
//                    'default' => SORT_ASC
                ],
                'views' => [
                    'asc' => ['post_stats.views' => SORT_ASC],
                    'desc' => ['post_stats.views' => SORT_DESC],
                    'label' => 'Views',
//                    'default' => SORT_DESC
                ],
                'profit' => [
                    'asc' => ['post_stats.profit' => SORT_ASC],
                    'desc' => ['post_stats.profit' => SORT_DESC],
                    'label' => 'Profit',
//                    'default' => SORT_DESC
                ],
                'urlTitle' => [
                    'asc' => ['urlTitle' => SORT_ASC],
                    'desc' => ['urlTitle' => SORT_DESC],
                    'label' => 'Url Link',
//                    'default' => SORT_DESC
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'label' => 'Post Date',
//                    'default' => SORT_DESC
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'post.id' => $this->id,
            'post.userId' => $this->userId,
            'post.type' => $this->type,
            'post.created_at' => $this->created_at,
            'post.featured' => $this->featured,
            'post.urlTitle' => $this->urlTitle,
            'user.name' => $this->user,
        ]);
        $query->orFilterWhere([
            'user.id' => $this->user
        ]);

        $query->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

}
