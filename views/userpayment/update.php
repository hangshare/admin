<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserPayment */

$this->title = 'Update User Payment: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
