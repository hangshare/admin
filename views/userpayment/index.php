<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-payment-index">
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
            [
                'attribute' => 'userId',
                'label' => 'User Name',
                'format' => 'raw',
                'value' => function ($data) {
                    if (!isset($data->users)) {
                        return 'Deleted';
                    }
                    $username = empty($data->users->username) ? $data->userId : $data->users->username;
                    return Html::a($data->users->name, "https://www.hangshare.com/user/{$username}/", [
                                'target' => '_blank'
                    ]);
                }
                    ],
                    'price',
                    'payer_email:email',
                    [
                        'attribute' => 'start_date',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return date('Y-m-d h:i:s', $data->start_date);
                        }
                    ],
                    [
                        'attribute' => 'end_date',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return date('Y-m-d h:i:s', $data->end_date);
                        }
                    ],
                    'transactionId',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'
                    ],
                ],
            ]);
            ?>

</div>
