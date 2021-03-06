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
    <div class="row" style="  position: absolute;    left: 37px;">
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
                        $username = empty($data->username) ? $data->id : $data->username;
                        return Html::a($data->id, "https://www.hangshare.com/user/{$username}/", [
                            'target' => '_blank'
                        ]);
                    },
                ],
                [
                    'attribute' => 'image',
                    'label' => 'Image',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (empty($data->image))
                            return 'NO image';
                        $thump = Yii::$app->imageresize->thump($data->image, 80, 80, 'crop');
                        $thump_full = str_replace('/80x80-crop', '', $thump);
                        return Html::a(Html::img($thump, ['width' => 80, 'alt' => 'image']), $thump_full, ['target' => '_blank']);
                    },
                ],
                'scId',
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($data) {
                        $username = empty($data->username) ? $data->id : $data->username;
                        return Html::a($data->name, "https://www.hangshare.com/user/{$username}/", [
                            'target' => '_blank'
                        ]);
                    },
                ],
                'email:email',
                [
                    'attribute' => 'total_amount',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'max-width:5px;'],
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
                    'contentOptions' => ['style' => 'max-width: 5px;'],
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
                    'contentOptions' => ['style' => 'max-width: 50px;'],
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
                    'contentOptions' => ['style' => 'max-width: 20px;'],
                    'value' => function ($data) {
                        if (isset($data->userStats))
                            return $data->userStats->post_count;
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
                    'attribute' => 'deleted',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return $data->deleted == 1 ? 'Banded' : 'Active';
                    },
                    'filter' => Html::dropDownList('UserSearch[deleted]', '', ['1' => 'Banded', '0' => 'Active'], ['prompt' => ''])
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
                    'contentOptions' => ['style' => 'max-width: 50px;'],
                    'value' => function ($data) {
                        if ($data->country == 0 || !isset($data->location))
                            return '<i> غير محدد</i>';

                        return $data->location->name;
                    },
                    'filter' => Html::dropDownList('UserSearch[country]', '', ArrayHelper::map(Country:: find()->all(), 'id', 'name'), ['style' => 'width:130px;', 'prompt' => ''])
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
</div>
