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
                'attribute' => 'user',
                'label' => 'User Name/ID',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->user->name, 'http://www.hangshare.com/user/' . $data->userId, [
                        'target' => '_blank'
                    ]);
                },
            ],

            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->title, 'http://www.hangshare.com/explore/' . $data->id . '?title=' . urlencode($data->title), [
                        'target' => '_blank'
                    ]);
                },
            ],
            'urlTitle',
            [
                'attribute' => 'featured',
                'label' => 'Featured',
                'format' => 'raw',
                'filter' => ['1' => 'Yas', '0' => 'No'],
                'value' => function ($data) {
                    return Html::checkbox('featured', $data->featured, ['rel' => $data->id, 'class' => 'featuredform']);
                }
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