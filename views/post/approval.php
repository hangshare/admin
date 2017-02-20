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
        <?= Html::a('Approve all', ['all'], ['class' => 'btn btn-danger pull-right']) ?>
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
                'contentOptions' => ['style' => 'min-width: 100px;'],
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
                    ]) . ' ' . Html::a('<span class="not-set">(Delete)</span>', ['//user/delete', 'id' => $data->userId], [
                        'data' => [
                            'confirm' => "Are you sure you want to delete profile?",
                            'method' => 'post',
                        ]
                    ]);
                },
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($data) {
                    $lang= '';
                    if($data->lang == 'en'){
                        $lang= 'en/';
                    }
                    return Html::a($data->title, "https://www.hangshare.com/{$lang}{$data->urlTitle}/", [
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
                'template' => '{approve}{delete}{update}',
                'buttons' => [
                    'approve' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-adjust"></span> Approve', ['post/aprovedpost', 'id' => $model->id], [
                            'style' => 'margin-top:15px;',
                            'class' => 'btn btn-primary btn-xs',
                            'data' => [
                                'method' => 'post',
                                'params' => ['id' => $model->id]
                            ]
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['post/delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-xs',
                            'style' => 'margin-top:15px;',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Are you sure?'
                            ]
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span> Update', ['post/update', 'id' => $model->id], [
                            'class' => 'btn btn-warning btn-xs',
                            'style' => 'margin-top:15px;',
                        ]);
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>