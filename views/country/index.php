<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\SysValues;
use app\models\Region;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Countries';
$this->params['breadcrumbs'][] = $this->title;
$defaultPrice = SysValues::findOne(['key' => 'default_view_price']);
$goldPrice = SysValues::findOne(['key' => 'gold_view_price']);
$regions = Region::find()->all();
?>
<div class="country-index">
    <h1>Region / Groups</h1>
    <div class="well">
        <div style="padding: 20px 20px 20px 0;">
            <div class="row">
                <label class="col-md-6">Gold User Factor ex. 3X</label>
                <?php echo Html::textInput('gold_view_price', $goldPrice->value, ['rel' => '', 'class' => 'values_js col-md-6']); ?>
            </div>
            <div class="row">
                <label class="col-md-6">Default View Price</label>
                <?php echo Html::textInput('default_view_price', $defaultPrice->value, ['rel' => '', 'class' => 'values_js col-md-6']); ?>
            </div>
            <hr>
            <div class="row">
                <?php echo Html::a('Add Region', ['/region/create'], ['rel' => '', 'class' => 'country_js btn btn-primary btn-sm pull-right']); ?>
            </div>
            <br>
            <?php
            if (isset($regions) && is_array($regions)) {
                foreach ($regions as $region) :
                    ?>
                    <div class="row">
                        <label class="col-md-6"><?= $region->name ?></label>
                        <?php echo Html::textInput('region[]', $region->price, ['rel' => $region->id, 'class' => 'region_js col-md-6']); ?>
                    </div>
                    <?php
                endforeach;
            }
            ?>
        </div>
    </div>
    <hr>
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => 'Name',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::textInput('name', $data->name, ['rel' => $data->id, 'class' => 'country_js']);
                }
                    ],
                    [
                        'attribute' => 'name_ar',
                        'label' => 'Name Arabic',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::textInput('name_ar', $data->name_ar, ['rel' => $data->id, 'class' => 'country_js']);
                        }
                            ],
                            [
                                'attribute' => 'code',
                                'label' => 'Code',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::textInput('code', $data->code, ['rel' => $data->id, 'class' => 'country_js']);
                                }
                                    ],
                                    [
                                        'attribute' => 'price',
                                        'label' => 'Price',
                                        'format' => 'raw',
                                        'value' => function ($data) {
                                            if ($data->price >= 0) {
                                                $type = '-3';
                                            } else {
                                                $type = $data->price;
                                            }
                                            $html = Html::dropDownList('priceType[]', $type, [
                                                        '-1' => 'Default',
                                                        '-2' => 'Region',
                                                        '-3' => 'Specific',
                                                            ], ['prompt' => '', 'rel' => $data->id, 'class' => 'priceType']);
                                            if ($data->price >= 0) {
                                                $html.=Html::textInput('price', $data->price, ['id' => 'price-' . $data->id, 'rel' => $data->id, 'class' => 'country_js']);
                                            } else {
                                                $html.=Html::hiddenInput('price', $data->price, ['id' => 'price-' . $data->id, 'rel' => $data->id, 'class' => 'country_js']);
                                            }

                                            return $html;
                                        }
                                            ],
                                            [
                                                'attribute' => 'regionId',
                                                'format' => 'raw',
                                                'value' => function ($data) {

                                                    $region = Region::getDb()->cache(function ($db) {
                                                                return Region::find()->all();
                                                            }, 100);

                                                    return Html::dropDownList('regionId', $data->regionId, ArrayHelper::map($region, 'id', 'name'), ['prompt' => 'Not Selected', 'rel' => $data->id, 'class' => 'country_js']);
                                                },
                                                        'filter' => Html::dropDownList('CountrySearch[regionId]', '', ArrayHelper::map(Region::find()->all(), 'id', 'name'), ['prompt' => ''])
                                                    ],
                                                    [
                                                        'attribute' => 'published',
                                                        'label' => 'Published',
                                                        'format' => 'raw',
                                                        'filter' => ['1' => 'Yas', '0' => 'No'],
                                                        'value' => function ($data) {
                                                    return Html::checkbox('published', $data->published, ['rel' => $data->id, 'class' => 'country_js']);
                                                }
                                                    ],
                                                    [
                                                        'class' => 'yii\grid\ActionColumn',
                                                        'template' => '{delete}'
                                                    ],
                                                ],
                                            ]);
                                            ?>
</div>
