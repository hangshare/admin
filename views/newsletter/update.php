<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmailQueue */

$this->title = 'Update Email Queue: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Email Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="email-queue-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
