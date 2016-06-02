<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPostView */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Views';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'userId',
                'label' => 'User Name/ID',
                'format' => 'raw',
                'value' => function ($data) {
                    if (!isset($data->user))
                        return '<i>Guest</i>';
                    return Html::a($data->user->name, 'https://www.hangshare.com/user/' . $data->userId, [
                                'target' => '_blank'
                    ]);
                },
                    ],
                    [
                        'attribute' => 'postId',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if (!isset($data->post))
                                return '<i>Deleted Post</i>';
                            return Html::a($data->post->title, 'https://www.hangshare.com/explore/' . $data->post->id . '?title=' . urlencode($data->post->title), [
                                        'target' => '_blank'
                            ]);
                        },
                            ],
                            'ip',
                            'created_at',
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}'
                            ],
                        ],
                    ]);
                    ?>

</div>
