<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmailQueueBody */

$this->title = 'Update Email Queue Body: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Email Queue Bodies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="email-queue-body-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
