<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Country;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="row">
        <h1 style="margin: 0 0 10px 10px;" class="pull-left"><?= Html::encode($this->title) ?></h1>
        <ul class="list-inline pull-right">
            <li><?php echo Html::a('<i class="glyphicon glyphicon-list"></i> Emails list', ['index', 'ex' => 1], ['class' => 'btn']); ?></li>
            <li><?php echo Html::a('<i class="glyphicon glyphicon-export"></i> Excel', ['export'], ['class' => 'btn']); ?></li>
        </ul>
    </div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->id, 'https://www.hangshare.com/user/' . $data->id, [
                                'target' => '_blank'
                    ]);
                },
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a($data->name, 'https://www.hangshare.com/user/' . $data->id, [
                                        'target' => '_blank'
                            ]);
                        },
                            ],
                            'email:email',
                            [
                                'attribute' => 'total_amount',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (isset($data->userStats)) {
                                        return $data->userStats->total_amount;
                                    } else {
                                        return 'Deleted';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'available_amount',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (isset($data->userStats)) {
                                        return $data->userStats->available_amount;
                                    } else {
                                        return 'Deleted';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'cantake_amount',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (isset($data->userStats)) {
                                        return $data->userStats->cantake_amount;
                                    } else {
                                        return 'Deleted';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'post_count',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (isset($data->userStats))
                                        return $data->userStats->post_count;
                                    return 'Deleted';
                                }
                            ],
                            [
                                'attribute' => 'post_total_views',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (isset($data->userStats))
                                        return $data->userStats->post_total_views;
                                    return 'Deleted';
                                }
                            ],
                            [
                                'attribute' => 'profile_views',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if (isset($data->userStats))
                                        return $data->userStats->profile_views;
                                    return 'Deleted';
                                }
                            ],
                            [
                                'attribute' => 'gender',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return $data->gender == 1 ? 'Male' : 'Female';
                                },
                                'filter' => Html::dropDownList('UserSearch[gender]', '', ['1' => 'Male', '2' => 'Female'], ['prompt' => ''])
                            ],
                            [
                                'attribute' => 'plan',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return $data->plan == 1 ? 'GOLD' : 'Normal';
                                },
                                'filter' => Html::dropDownList('UserSearch[plan]', '', ['1' => 'GOLD', '0' => 'Normal', '-1' => 'Not Completed'], ['prompt' => ''])
                            ],
                            [
                                'attribute' => 'country',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->country == 0 || !isset($data->location))
                                        return '<i> غير محدد</i>';

                                    return $data->location->name_ar;
                                },
                                'filter' => Html::dropDownList('UserSearch[country]', '', ArrayHelper::map(Country:: find()->all(), 'id', 'name'), ['prompt' => ''])
                            ],
                            'created_at',
                            [
                                'class' => 'yii\grid\ActionColumn',
                            //'template' => '{view}{de}'
                            ],
                        ],
                    ]);
                    ?>
</div>
