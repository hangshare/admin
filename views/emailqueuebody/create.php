<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailQueueBody */

$this->title = 'Create Email Queue Body';
$this->params['breadcrumbs'][] = ['label' => 'Email Queue Bodies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-queue-body-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
