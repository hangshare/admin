<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserTransactions */

$this->title = 'Create User Transactions';
$this->params['breadcrumbs'][] = ['label' => 'User Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-transactions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
