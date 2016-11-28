<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmailQueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Queues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="row">
        <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>
        <ul class="list list-inline pull-right">
            <li><?= Html::a('Send Bulk Email', ['create'], ['class' => 'btn btn-danger']) ?></li>
        </ul>
    </div>
    <div class="row">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'emailId',
                'type',
                'opened_num',
                'start_at',
                'end_at',
                'status',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
    </div>
</div>
