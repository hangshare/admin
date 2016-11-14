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
                        $username = empty($data->user->username) ? $data->userId : $data->user->username;
                        return Html::a($data->user->name, "https://www.hangshare.com/user/{$username}/", [
                            'target' => '_blank'
                        ]);
                    },
                ],
                [
                    'attribute' => 'emailId',
                    'label' => 'Email Template',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (!isset($data->template))
                            return '<i>Not Set</i>';
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
