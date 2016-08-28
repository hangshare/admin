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
    </div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'cover',
                'label' => 'Cover',
                'format' => 'raw',
                'value' => function ($data) {
                    $thump = Yii::$app->imageresize->thump($data->cover, 400, 250, 'crop');
                    return Html::img($thump);
                },
            ],
            [
                'attribute' => 'user',
                'label' => 'User Name/ID',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->user->name, "https://www.hangshare.com/user/{$data->userId}/", [
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
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{approve}{delete}',
                'buttons' => [
                    'approve' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-adjust"></span> Approve', ['post/aprovedpost','id'=>$model->id], [
                            'style'=>'margin-top:15px;',
                            'class' => 'btn btn-danger btn-xs',
                            'data'=>[
                                'method' => 'post',
                                'params'=>['id'=>$model->id]
                            ]
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['post/delete'], [
                            'class' => 'btn btn-danger btn-xs',
                            'style'=>'margin-top:15px;',
                            'data'=>[
                                'method' => 'post',
                                'confirm' => 'Are you sure?',
                                'params'=>['id'=>$model->id],
                            ]
                        ]);
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>