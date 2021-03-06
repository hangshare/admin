<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div class="row">
        <h1 style="margin: 0 0 10px 10px;" class="pull-left"><?= Html::encode($this->title) ?></h1>
        <ul class="list-inline pull-right">
            <li><?php echo Html::a('<i class="glyphicon glyphicon-export"></i> Excel', ['export'], ['class' => 'btn']); ?></li>
        </ul>
    </div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'score',
                'label' => 'Score',
                'format' => 'raw',
                'contentOptions'=>['style'=>'min-width: 100px;'],
                'value' => function ($data) {
                    return $this->render('//score/form', ['model' => $data]);
                },
            ],
            [
                'attribute' => 'cover',
                'label' => 'Cover',
                'format' => 'raw',
                'value' => function ($data) {
                    $thump = Yii::$app->imageresize->thump($data->cover, 400, 250, 'crop');
                    $thump_full = str_replace('/400x250-crop', '', $thump);
                    return Html::a(Html::img($thump, ['width' => 150, 'alt' => 'image']), $thump_full, ['target' => '_blank']);
                },
            ],
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
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->title, "https://www.hangshare.com/{$data->urlTitle}/", [
                        'target' => '_blank'
                    ]);
                },
            ],
            [
                'attribute' => 'views',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->stats->views;
                }
            ],
            [
                'attribute' => 'profit',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->stats->profit;
                }
            ],
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',

            ],
        ],
    ]);
    ?>
</div>