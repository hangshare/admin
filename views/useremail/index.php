<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserEmailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Emails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-email-index col-md-12">
    <div class="row">
        <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>
    </div>
    <br>
    <div class="row">
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
                        if (!isset($data->user)) {
                            return '-';
                        }
                        return Html::a($data->user->name, 'http://www.hangshare.com/user/' . $data->userId, [
                                    'target' => '_blank'
                        ]);
                    },
                        ],
                        [
                            'attribute' => 'emailId',
                            'label' => 'Email Template',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return $data->template->subject;
                            },
                        ],
                        [
                            'attribute' => 'opened_at',
                            'label' => 'Opened on',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->opened_at == 0)
                                    return '<i>Not Opened</i>';
                                return date('Y-m-d h:i:s', $data->opened_at);
                            },
                        ],
                        'created_at',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
    </div>
</div>
