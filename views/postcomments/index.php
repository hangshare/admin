<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostCommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-comments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user',
                'label' => 'User Name/ID',
                'format' => 'raw',
                'value' => function ($data) {
                    $username = empty($data->user->username) ? $data->userId : $data->user->username;
                    return Html::a($data->user->name, "https://www.hangshare.com/user/{$username}/", [
                        'target' => '_blank'
                    ]);
                },
            ],
            [
                'attribute' => 'post',
                'label' => 'Post Title',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->post->title, "https://www.hangshare.com/{$data->post->urlTitle}/", [
                        'target' => '_blank'
                    ]);
                },
            ],
            'comment',
            'created_at',
            // 'parentId',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
