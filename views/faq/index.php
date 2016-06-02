<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Faq;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faqs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-index">
    <div class="col-md-12">
        <div class="row">
            <h1 class="pull-left"><?= Html::encode($this->title) ?></h1>
            <p class="pull-right">
                <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="row">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Status',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if (empty($data->answer)) {
                                return '<i style="color:red;">Not Answered</i>';
                            } else {
                                return '<i>Answered</i>';
                            }
                        }
                    ],
                    [
                        'attribute' => 'userId',
                        'label' => 'User Name/ID',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->userId == 0) {
                                return '-';
                            }
                            return Html::a($data->user->name, 'https://www.hangshare.com/user/' . $data->userId, [
                                        'target' => '_blank'
                            ]);
                        },
                            ],
                            [
                                'attribute' => 'categoryId',
                                'label' => 'Category',
                                'format' => 'raw',
                                'filter' => Faq::$CategoryStr,
                                'value' => function ($data) {
                                    if (isset($data::$CategoryStr[$data->categoryId]))
                                        return $data::$CategoryStr[$data->categoryId];
                                    return '-';
                                }
                            ],
                            'question',
                            [
                                'attribute' => 'published',
                                'label' => 'Published',
                                'format' => 'raw',
                                'filter' => ['1' => 'Yas', '0' => 'No'],
                                'value' => function ($data) {
                                    return Html::checkbox('published', $data->published, ['rel' => $data->id, 'class' => 'publishedform']);
                                }
                            ],
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
        </div>
    </div>
</div>
