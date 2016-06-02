<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'User Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-transactions-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'image',
                'format' => 'raw',
                'value' => function ($data) {
                    if (empty($data->image))
                        return '-';
                    return Html::a(Html::img($data->image,['width'=>200]),$data->image,['target'=>'_blank']);
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
                    'amount',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data->status ? 'Received' : 'Processing';
                        },
                        'filter' => Html::dropDownList('UserTransactionsSearch[status]', '', ['0' => 'Processing', '1' => 'Received'], ['prompt' => ''])
                    ],
                    'created_at',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'
                    ],
                ],
            ]);
            ?>

</div>
