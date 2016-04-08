<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserEmail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Emails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-email-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></p>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'userId',
            'emailId:email',
            'opened_at',
            'key',
            'created_at',
        ],
    ]) ?>

</div>
